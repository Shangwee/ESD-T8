from flask import Flask, request, jsonify
from flask_cors import CORS
import os, sys
from invokes import invoke_http
import json

app = Flask(__name__)
CORS(app)

prescription_URL = "http://host.docker.internal:5004/prescription/"
inventory_URL = "http://host.docker.internal:5002/inventory/"
invoice_URL = "http://host.docker.internal:5007/invoice"
MC_URL  = "http://host.docker.internal:500/MC"
createCheckout_URL = "http://host.docker.internal:4242//create-checkout-session"

@app.route("/test")
def test():
    return "hello world"


@app.route("/createpayment", methods=["POST"])
def create_payment():
    if request.is_json:
        try:
            invoice_details = request.get_json()
            print("\nReceived a invoice payment amount in JSON:", invoice_details)

            # do the actual work
            # 1. Invoice object (details) will be sent here from UI
            result = processCreatePayment(invoice_details)
            return jsonify(result), result["code"]
        
        except Exception as e:
            # print("hello")
            # Unexpected error in code
            exc_type, exc_obj, exc_tb = sys.exc_info()
            fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
            ex_str = str(e) + " at " + str(exc_type) + ": " + fname + ": line " + str(exc_tb.tb_lineno)
            print(ex_str)

            return jsonify({
                "code": 500,
                "message": "createpayment internal error: " + ex_str
            }), 500
    # if reached here, not a JSON request.
    return jsonify({
        "code": 400,
        "message": "Invalid JSON input: " + str(request.get_data())
    }), 400


def processCreatePayment(invoice_details):

    # 2. Disect info and send to Stripe API

    print('\n-----Sending info to Stripe API to handle payment-----')
    
    #convert to JSON object
    invoice = json.dumps(invoice_details)
    print(invoice + "this is working")
    abc = {"invoice_id": 3, "medicine": [{"medicineID": 1, "medicineName": "CoughMedicine 2", "price": 20.0, "quantity": 5}, { "medicineID": 1, "medicineName": "CoughMedicine 2",  "price": 20.0, "quantity": 5}, { "medicineID": 1, "medicineName": "CoughMedicine 2",  "price": 20.0, "quantity": 5}], "patient_id": 2, "payment_status": 0, "total_price": 10000000}
    stripe_payment_result = invoke_http(createCheckout_URL, method='POST', json=abc)
    print('stripe_payment_result:', stripe_payment_result)
    # 3. In payment successful - update invoice_payment_status
    UpdateInvoiceResult = invoke_http(invoice_URL, method='PUT', json="TBC")
    
    #4. create MC 
    MC = invoke_http(MC_URL, method='POST', json=stripe_payment_result)




    # return {
    #     "code": 201,
    #     "data": {
    #         "update_prescription_process": update_prescription_process,
    #     }
    # }

    # return "processsing prescription..... " + str(id) 


# Execute this program if it is run as a main script (not by 'import')
if __name__ == "__main__":
    # print("This is flask " + os.path.basename(__file__) + " for placing an order...")
    app.run(host="0.0.0.0", port=6002, debug=True)
    # Notes for the parameters: 
    # - debug=True will reload the program automatically if a change is detected;
    #   -- it in fact starts two instances of the same flask program, and uses one of the instances to monitor the program changes;
    # - host="0.0.0.0" allows the flask program to accept requests sent from any IP/host (in addition to localhost),
    #   -- i.e., it gives permissions to hosts with any IP to access the flask program,
    #   -- as long as the hosts can already reach the machine running the flask program along the network;
    #   -- it doesn't mean to use http://0.0.0.0 to access the flask program.
