from flask import Flask, request, jsonify
from flask_cors import CORS
import os, sys
from invokes import invoke_http
import json

app = Flask(__name__)
CORS(app)

account_URL = "http://localhost:5001/account"
inventory_URL = "http://localhost:5002/inventory"
patient_record_URL = "http://localhost:5003/record"
prescription_URL = "http://localhost:5004/prescription"

@app.route("/create_prescription", methods=['POST'])
def create_prescription():
      if request.is_json:
            try:
                  prescription = request.get_json()
                  print("\nReceived a prescription in JSON:", prescription)

                  # do the actual work
                  # 1. Send prescription info {patient id, doctor id, {medicine:quanity, instruction:instruction}} 
                  result = processCreatePrescription(prescription)
                  return jsonify(result), result["code"]

            except Exception as e:
                  # Unexpected error in code
                  exc_type, exc_obj, exc_tb = sys.exc_info()
                  fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
                  ex_str = str(e) + " at " + str(exc_type) + ": " + fname + ": line " + str(exc_tb.tb_lineno)
                  print(ex_str)

                  return jsonify({
                  "code": 500,
                  "message": "create_prescription.py internal error: " + ex_str
                  }), 500
            
       # if reached here, not a JSON request.
      return jsonify({
            "code": 400,
            "message": "Invalid JSON input: " + str(request.get_data())
      }), 400

def processCreatePrescription(prescription):
      # 2. check allergies
      # invoke the account microservice
      print('\n-----Invoking account microservice-----')
      patientID = prescription["patientID"]
      patient_result = invoke_http(account_URL + "/" + str(patientID), method='GET')
      print('patient_result:', patient_result)
      allergies = patient_result["data"]["allergies"]
      prescriptionList = getIDinPrescription(prescription)

      checkdata = {
            "prescriptionList": prescriptionList,
            "allergies": allergies
      }
      # convert to json
      checkdata = json.dumps(checkdata)
      print('\n-----Invoking prescription microservice-----')
      check_result = invoke_http(prescription_URL + "/checkallergy", method='POST', json=checkdata)
      print('check_result:', check_result)
      allergy_code = check_result["code"]
      alt_dictionary = {}
      if allergy_code == 400:
            allergic_medicine = check_result["data"]["allergic_medicine"]
            return {
                  "code": 400,
                  "data": {
                        "allergic_medicine": allergic_medicine,
                  },
                  "message": "Allergic medicine found"
            }

      # 3. Record new prescription
      # invoke the prescription microservice
      print('\n-----Invoking prescription microservice-----')
      prescription_result = invoke_http(prescription_URL, method='POST', json=prescription)
      print('prescription_result:', prescription_result)

      code = prescription_result["code"]
      if code not in range(200,300):
            return {
                  code: 500,
                  "data": {"prescription_result": prescription_result},
                  "message": "Error creating prescription"
            }
      
      # 4. send prescription ID to AMQP broker

      # 5. Return preacription result
      return {
            "code": 201,
            "data": {
                  "prescription_result": prescription_result
            }
      }

def getIDinPrescription(preacription):
      # invoke the prescription microservice
      prescriptionList = []
      for medicine in preacription["medicine"]:
            prescriptionList.append(medicine["medicineID"])
      return prescriptionList

def getalternative(medicineID):
      # invoke the inventory microservice
      inventory_result = invoke_http(inventory_URL + "/" + str(medicineID), method='GET')
      alternative = inventory_result["data"]["alternative"]
      return alternative


# Execute this program if it is run as a main script (not by 'import')
if __name__ == "__main__":
    print("This is flask " + os.path.basename(__file__) +
          " for creating prescription...")
    app.run(host="0.0.0.0", port=6003, debug=True)
    # Notes for the parameters:
    # - debug=True will reload the program automatically if a change is detected;
    #   -- it in fact starts two instances of the same flask program,
    #       and uses one of the instances to monitor the program changes;
    # - host="0.0.0.0" allows the flask program to accept requests sent from any IP/host (in addition to localhost),
    #   -- i.e., it gives permissions to hosts with any IP to access the flask program,
    #   -- as long as the hosts can already reach the machine running the flask program along the network;
    #   -- it doesn't mean to use http://0.0.0.0 to access the flask program.
