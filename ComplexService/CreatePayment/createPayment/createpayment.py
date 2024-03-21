from flask import Flask, request, jsonify, redirect
from flask_cors import CORS
import os, sys
from invokes import invoke_http
import json

app = Flask(__name__)
CORS(app)

prescription_URL = "http://host.docker.internal:5004/prescription/"
inventory_URL = "http://host.docker.internal:5002/inventory/"
invoice_URL = "http://host.docker.internal:5007/invoice"
MC_URL  = "http://host.docker.internal:5008/MC"
createCheckout_URL = "http://host.docker.internal:4242//create-checkout-session"
account_URL = "http://host.docker.internal:5001/account"

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
            result = processPostPayment(invoice_details)
            return jsonify(result), result["code"]
        
            ######################################################################################
        
            # invoice = json.dumps(invoice_details)
            # stripe_payment_result = invoke_http(createCheckout_URL, method='POST', json=invoice)
            # checkout_url = stripe_payment_result['url']

            # return {'url' : checkout_url}

            ########################################################################################



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


def processPostPayment(invoice_details):

    print("postpost: ", invoice_details)

    print('\n-----Invoking invoice microservice to update payment status-----')
    invoice_id = invoice_details['invoice_id']

    status = {"payment_status" : 1}
    invoice_update_status = invoke_http(invoice_URL + '/' + str(invoice_id), method='PUT', json=status)
    print('invoice_update_status:', invoice_update_status)

    code = invoice_update_status['code']
    if code not in range(200, 300):
        return {
            code: 500,
            "message": "Error updating invoice payment status"
        }

    
    #4. create MC 
    MC = invoke_http(MC_URL, method='POST', json=invoice_details)

    #convert to JSON object
    invoice = json.dumps(invoice_details)
    print(invoice + "this is working")

    patient_ID = invoice["patient_id"]
    patient_result = invoke_http(account_URL + "/" + str(patient_ID), method='GET')
    name = patient_result['name']
    invoice['name'] = name

    #4. create MC 
    MC = invoke_http(MC_URL, method='POST', json=invoice)
    cd = MC['code']
    if cd not in range(200, 300):
        return {
            code: 500,
            "message": "Error updating invoice payment status"
        }


    return {
        "code": 201,
        "data": {
            "message": "payment status updated & MC created",
        }
    }

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
