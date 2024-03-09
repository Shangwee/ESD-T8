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

class Prescription(db.Model):
    __tablename__ = 'prescription'

    prescriptionID = db.Column(db.Integer, autoincrement=True, primary_key=True, nullable=True)
    patientID = db.Column(db.Integer, nullable=False)
    doctorID = db.Column(db.Integer, nullable=False)
    medicine = db.Column(db.String(64), nullable=False)
    quantity = db.Column(db.Integer, nullable=False)
    instructions = db.Column(db.Text, nullable=True)
    datetime = db.Column(db.DateTime(timezone=True), default=func.now())

    def __init__(self, patientID, doctorID, medicine, quantity, instructions):
        self.patientID = patientID
        self.doctorID = doctorID
        self.medicine = medicine
        self.quantity = quantity
        self.instructions = instructions

    def json(self):
        return {"prescriptionID": self.prescriptionID, "patientID": self.patientID, "doctorID": self.doctorID, "medicine": self.medicine, "quantity": self.quantity,"instructions": self.instructions ,"date": self.datetime}
    
@app.route("/prescription")
def get_all():
    prescriptionlist = db.session.scalars(db.select(Prescription)).all()
    if len(prescriptionlist):
        return jsonify(
            {
                "code": 200,
                "data": {
                    "prescriptions": [prescription.json() for prescription in prescriptionlist]
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "There are no prescriptions.",
        }
    ), 404

@app.route("/prescription/", methods=['POST'])
def create_prescription():
    data = request.get_json()
    prescription = Prescription(**data)

    try:
        db.session.add(prescription)
        db.session.commit()
    except:
        return jsonify(
            {
                "code": 500,
                "data": data,
                "message": "An error occurred creating the prescription."
            }
        ), 500

    return jsonify(
        {
            "code": 201,
            "data": prescription.json()
        }
    ), 201

@app.route("/prescription/patient/<int:patient_id>")
def get_by_patientID(patient_id):
    prescription_list_by_paitent = db.session.scalars(
        db.select(Prescription).filter_by(patientID = int(patient_id))
    ).all()
    if len(prescription_list_by_paitent):
        return jsonify(
            {
                "code": 200,
                "data": [prescription.json() for prescription in prescription_list_by_paitent]
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "Prescription not found.",
        }
    ), 404

@app.route('/prescription/<int:prescriptionID>', methods=['PUT'])
def update_prescription(prescriptionID):
    data = request.get_json()
    prescription = db.session.scalars(
        db.select(Prescription).filter_by(prescriptionID = int(prescriptionID))
    ).first()
    if prescription:
        try:
            for key, value in data.items():
                setattr(prescription, key, value)
            db.session.commit()
        except:
            return jsonify(
                {
                    "code": 500,
                    "data": data,
                    "message": "An error occurred updating the prescription."
                }
            ), 500
        return jsonify(
            {
                "code": 200,
                "data": prescription.json()
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "Prescription not found."
        }
    ), 404

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)