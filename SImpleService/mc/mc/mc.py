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
    # total_price = db.Column(db.Float(precision=2), nullable=False)
    # payment_status = db.Column(db.Integer, nullable=False)

    def __init__(self, patientname, numberofdays, patientid):
        self.patientid = patientid
        self.patientname = patientname
        self.numberofdays = numberofdays

    def json(self):
        return {"mcid": self.mcid,"patientid":self.patientid, "patientname": self.patientname, "numberofdays": self.numberofdays}


@app.route("/mc/create_mc", methods=['POST'])
def create_mc():
    # data = request.get_json() 
    # medicine * quantity -- use a loop 
    # if receive nothing for payment status, pass as 0  
    patientid = request.json.get('patient_id', None)
    patientname = request.json.get('patient_name', None)
    numberofdays = request.json.get('numberofdays', None)
    # payment_status = request.json.get('payment_status', None) 
    if patientid == None or patientname == None or numberofdays == None:
          return jsonify(
        {
            "code": 400,
            "message": "missing data, please check again "
        }
        ), 201
    mc_new = mc(patientid=patientid, patientname = patientname, numberofdays=numberofdays)
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
                "error": str(e)
            }
        ), 500
    
@app.route("/mc")
def get_all():
    mclist = db.session.scalars(db.select(mc)).all()
    if len(mclist):
        return jsonify(
            {
                "code": 200,
                "data": {
                    "invoices": [mc.json() for mc in mclist]
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "There are no invoices.",
        }
    ), 404

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)