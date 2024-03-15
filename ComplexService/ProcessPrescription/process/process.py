from flask import Flask, request, jsonify
from flask_cors import CORS

import os, sys

from invokes import invoke_http

app = Flask(__name__)
CORS(app)

prescription_URL = "http://host.docker.internal:5004/prescription/"
inventory_URL = "http://host.docker.internal:5002/inventory/"
invoice_URL = "http://host.docker.internal:5007/invoice"


@app.route("/process", methods=["POST"])
def process_prescription():
    if request.is_json:
        try:
            prescription = request.get_json()
            print("\nReceived a prescription in JSON:", prescription)

            # do the actual work
            # 1. Send prescription id
            result = processPrescription(prescription["id"])
            return jsonify(result), result["code"]
        
        except Exception as e:
            # Unexpected error in code
            exc_type, exc_obj, exc_tb = sys.exc_info()
            fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
            ex_str = str(e) + " at " + str(exc_type) + ": " + fname + ": line " + str(exc_tb.tb_lineno)
            print(ex_str)

            return jsonify({
                "code": 500,
                "message": "process.py internal error: " + ex_str
            }), 500
    # if reached here, not a JSON request.
    return jsonify({
        "code": 400,
        "message": "Invalid JSON input: " + str(request.get_data())
    }), 400

def processPrescription(id):

    # 2. Get prescription info
    # Invoke the prescription microservice
    print('\n-----Invoking prescription microservice-----')
    prescription_result = invoke_http(prescription_URL + str(id))
    print('prescription_result:', prescription_result)
    
    
    # Invoke the Inventory microservice
    
    medicine = prescription_result["data"]["medicine"]
    for m in medicine:
        medicine_id = m["medicineID"]
        prescription_quantity = m["quantity"]
        print('\n-----Invoking inventory microservice-----')

        get_inventory_result = invoke_http(inventory_URL + str(medicine_id))
        print('Retrieved inventory info:', get_inventory_result)

        inventory_quantity = get_inventory_result["data"]["quantity"]

        quantity = {
            "medicine": get_inventory_result["data"]["medicine"],
            "price": get_inventory_result["data"]["price"],
            "quantity": inventory_quantity - prescription_quantity,
            "alternative": get_inventory_result["data"]["alternative"],
        }
        
        # 3. Update medicine quantity in inventory
        update_inventory_result = invoke_http(inventory_URL + str(medicine_id), method="PUT", json=quantity)
        print('Updated inventory quantity:', update_inventory_result)

    # 4. Update prescription "process" column
    update_prescription_process = invoke_http(prescription_URL + "" + str(id), method="PUT", json={"process": True})
    print('Successfully processed prescription:', update_prescription_process)


    # 5. Get medicine price
    # Invoke the Inventory microservice
    print('\n-----Invoking inventory microservice-----')
    inventory_result = invoke_http(inventory_URL, method='POST', json=prescription_result)
    print('inventory_result:', inventory_result)

    # 6. Create invoice
    # Invoke the Invoice microservice
    print('\n-----Invoking inventory microservice-----')
    inventory_result = invoke_http(invoice_URL, method='POST', json=inventory_result)
    print('inventory_result:', inventory_result)

    return {
        "code": 201,
        "data": {
            "update_prescription_process": update_prescription_process,
        }
    }

    # return "processsing prescription..... " + str(id) 


# Execute this program if it is run as a main script (not by 'import')
if __name__ == "__main__":
    # print("This is flask " + os.path.basename(__file__) + " for placing an order...")
    app.run(host="0.0.0.0", port=5100, debug=True)
    # Notes for the parameters: 
    # - debug=True will reload the program automatically if a change is detected;
    #   -- it in fact starts two instances of the same flask program, and uses one of the instances to monitor the program changes;
    # - host="0.0.0.0" allows the flask program to accept requests sent from any IP/host (in addition to localhost),
    #   -- i.e., it gives permissions to hosts with any IP to access the flask program,
    #   -- as long as the hosts can already reach the machine running the flask program along the network;
    #   -- it doesn't mean to use http://0.0.0.0 to access the flask program.
