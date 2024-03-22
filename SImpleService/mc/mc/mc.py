from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from sqlalchemy.sql import func
from flask_cors import CORS
from datetime import datetime, timedelta

from os import environ

app = Flask(__name__)
CORS(app)
app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)

# `mcid` INT AUTO_INCREMENT PRIMARY KEY,
#   `patientname` VARCHAR(255) NOT NULL,
#   `patientid` INT NOT NULL,
#   `numberofdays` int(11),
#   `sickness` JSON
class mc(db.Model):
    __tablename__ = 'mc'

    mcid = db.Column(db.Integer, autoincrement=True, primary_key=True, nullable=True)
    patientid = db.Column(db.Integer, nullable=False)
    patientname = db.Column(db.String(64), nullable=False)
    numberofdays = db.Column(db.Integer, nullable=False)
    assigned = db.Column(db.Integer(), nullable=False)
    date = db.Column(db.Date)
    newdate = db.Column(db.Date)

    # total_price = db.Column(db.Float(precision=2), nullable=False)
    # payment_status = db.Column(db.Integer, nullable=False)

    def __init__(self, patientname, numberofdays, patientid, assigned, date, newdate):
        self.patientid = patientid
        self.patientname = patientname
        self.numberofdays = numberofdays
        self.assigned = assigned
        self.date = date
        self.newdate = newdate


    def json(self):
        return {"mcid": self.mcid,"patientid":self.patientid, "patientname": self.patientname, "numberofdays": self.numberofdays, "assigned": self.assigned, "date":self.date, "newdate":self.newdate}


@app.route("/mc/create_mc", methods=['POST'])
def create_mc():
    # data = request.get_json() 
    # medicine * quantity -- use a loop 
    # if receive nothing for payment status, pass as 0 
    # abc = {"invoice_id": 3, "medicine": [{"medicineID": 1, "medicineName": "CoughMedicine 2", "price": 20.0, "quantity": 5}, { "medicineID": 1, "medicineName": "CoughMedicine 2",  "price": 20.0, "quantity": 5}, { "medicineID": 1, "medicineName": "CoughMedicine 2",  "price": 20.0, "quantity": 5}], "patient_id": 2, "payment_status": 0, "total_price": 10000000}
    listofillness = {"Cough":1, "Flu":1, "Fever":2}
    patientid = request.json.get('patient_id', None)
    patientname = request.json.get('name', None)
    # numberofdays = request.json.get('numberofdays', None)
    medicine = request.json.get('medicine', None)
    numberofdays = 0
    for med in medicine:
        medicinename = med['medicineName']
        for illness, value in listofillness.items():
            if illness.lower() in medicinename.lower():
                noofdays = listofillness[illness]
                print(noofdays)
            if noofdays>numberofdays:
                numberofdays = noofdays
    # payment_status = request.json.get('payment_status', None) 
    if patientid == None or patientname == None or numberofdays == None:
          return jsonify(
        {
            "code": 400,
            "message": "missing data, please check again "
        }
        ), 201
    if numberofdays != 0:
        today = datetime.utcnow().date()
        newdate = today+timedelta(days=numberofdays)
        mc_new = mc(patientid=patientid, patientname = patientname, numberofdays=numberofdays, assigned = 0,date=today,newdate=newdate)
    else:
          return jsonify(
            {
                "code": 201,
                "mc": "",
            }
        ), 201
    try:
        db.session.add(mc_new)
        db.session.commit()
        return jsonify({
            "code": 200,
            "message": "MC successfully created.",
            "mc": mc_new.json()  # Optional: return the created MC details
        }), 200
    except Exception as e: 
          return jsonify(
            {
                "code": 500,
                "message": "An error occurred creating the mc.",
                "error": str(e),
                "mc": mc_new.json()
            }
        ), 500

#this is a testing function
@app.route("/mc")
def get_all():
    mclist = db.session.scalars(db.select(mc)).all()
    if len(mclist):
        return jsonify(
            {
                "code": 200,
                "data": {
                    "mc": [mc.json() for mc in mclist]
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "There are no mc.",
        }
    ), 404

#retrieve one single mc from one patient record based on status
@app.route("/mc/retrievalofsinglerecord/<int:patient_id>")
def get_mc_record(patient_id):
    mc_record = db.select(mc).where(mc.patientid == patient_id, mc.assigned == 0)
    mclist = db.session.scalars(mc_record).all()
    if len(mclist):
        for record in mclist:
            record.assigned = 1
        db.session.commit()
        return jsonify(
            {
                "code": 200,
                "data": {
                    "mc": [mc.json() for mc in mclist]
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "There is no mc.",
        }
    ), 404

@app.route("/mc/retrieveonpatientid/<int:patient_id>")
def getMCrecs(patient_id):
    mc_record = db.select(mc).where(mc.patientid == patient_id)
    mclist = db.session.scalars(mc_record).all()
    if len(mclist):
        for record in mclist:
            record.assigned = 1
        db.session.commit()
        return jsonify(
            {
                "code": 200,
                "data": {
                    "mc": [mc.json() for mc in mclist]
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "There is no mc.",
        }
    ), 404


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)