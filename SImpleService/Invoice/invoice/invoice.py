from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from sqlalchemy.sql import func
from flask_cors import CORS

from os import environ

app = Flask(__name__)
CORS(app)
app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)

class Invoice(db.Model):
    __tablename__ = 'invoice'

    invoice_id = db.Column(db.Integer, autoincrement=True, primary_key=True, nullable=True)
    patient_id = db.Column(db.Integer, nullable=False)
    medicine = db.Column(db.JSON, nullable=False)
    total_price = db.Column(db.Float(precision=2), nullable=False)
    payment_status = db.Column(db.Integer, nullable=False)

    def __init__(self, patient_id, medicine, total_price, payment_status):
        self.patient_id = patient_id
        self.medicine = medicine
        self.total_price = total_price
        self.payment_status = payment_status

    def json(self):
        return {"invoice_id": self.invoice_id, "patient_id": self.patient_id, "medicine": self.medicine, "total_price": self.total_price, "payment_status": self.payment_status}

@app.route("/invoice")
def get_all():
    invoicelist = db.session.scalars(db.select(Invoice)).all()
    if len(invoicelist):
        return jsonify(
            {
                "code": 200,
                "data": {
                    "invoices": [invoice.json() for invoice in invoicelist]
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "There are no invoices.",
        }
    ), 404

@app.route("/invoice/<int:patient_id>")
def get_unpaid_invoice_by_patientID(patient_id):
    invoice_by_patient = db.session.scalars(
        db.select(Invoice).filter_by(patient_id = int(patient_id), payment_status = 0)
    ).all()
    if len(invoice_by_patient):
        return jsonify(
            {
                "code": 200,
                "data": [invoice.json() for invoice in invoice_by_patient]
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "Invoice not found.",
        }
    ), 404


@app.route("/invoice/", methods=['POST'])
def create_invoice():
    totalprice =0 
    # data = request.get_json() 
    # medicine * quantity -- use a loop 
    # if receive nothing for payment status, pass as 0  
    patient_id = request.json.get('patient_id', None)
    medicine = request.json.get('medicine', None)
    
    total_price = request.json.get('total_price', None)
    # payment_status = request.json.get('payment_status', None) 
    if patient_id == None or medicine == None or total_price == None:
          return jsonify(
        {
            "code": 400,
            "message": "missing data, please check again "
        }
        ), 201
    newInvoice = Invoice(patient_id=patient_id, medicine = medicine, total_price=total_price, payment_status=0)
    try:
        db.session.add(newInvoice)
        db.session.commit()
    except: 
          return jsonify(
            {
                "code": 500,
                "message": "An error occurred creating the invoice."
            }
        ), 500
    


## tabulation method TBC

@app.route("/invoice/getTotalPrice", methods=['POST'])
def get_total_price():
    totalprice=0
    data = request.json
    newdic = {}
    if data:
        for medicine in data['InventorytoInvoice']:
            if('price' in  medicine and 'quantity' in medicine):
                 totalprice += medicine['price'] * medicine['quantity']
        invoice_details = {
            "patientID" : data["InventorytoInvoice"][0]["patientID"],
            "medicineItems" : data["InventorytoInvoice"][1:],
            "medicinetotalprice":totalprice,
            "paymentstatus" : 0
        }
        # del data['InventorytoInvoice']
        return jsonify(
            {
               "code":212,
               **invoice_details
                 
            }
        )
        
    else:
           return jsonify(
                    {
                        "code": 404,
                        "message": "No prescription result passed"
                    }
                ), 404


@app.route('/invoice/<int:invoice_id>', methods=['PUT'])
def update_invoice_payment_status(invoice_id):
    data = request.get_json()
    invoice = db.session.scalars(
        db.select(Invoice).filter_by(invoice_id = int(invoice_id))
    ).first()
    if invoice:
        try:
            invoice.payment_status = data['payment_status']
            db.session.commit()
        except:
            return jsonify(
                {
                    "code": 500,
                    "data": data,
                    "message": "An error occurred updating the invoice payment status"
                }
            ), 500
        return jsonify(
            {
                "code": 200,
                "data": invoice.json()
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "Invoice not found."
        }
    ), 404


# {
#     "prescriptionID": self.prescriptionID,
#     "patientID": self.patientID,
#     "doctorID": self.doctorID,
#     "medicine": self.medicine,
#     "process": self.process,
#     "date": self.datetime
# } prescription returns this 
    
# need to retrieve medicine price * quantity 
#   (4, 1, '[{"medcineID": 2, "medicineName": "CoughMedicine 2", "quantity": 5, "instruction": "Twice daily"}, {"medcineID": 4,"medicineName": "FluMedicine 1", "quantity": 2, "instruction": "As needed"}]', '2024-03-12 10:00:00'),
 

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)