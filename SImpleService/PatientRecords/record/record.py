import datetime
from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from sqlalchemy.sql import func
from os import environ

app = Flask(__name__)

app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
# app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/recorddb'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)

class Record(db.Model):
    __tablename__ = 'record'

    id = db.Column(db.Integer, primary_key=True, autoincrement=True, nullable=True)
    patient_id = db.Column(db.String(64), nullable=False)
    record_date = db.Column(db.DateTime(timezone=True), default=func.now())

    def __init__(self, patient_id):
        self.patient_id = patient_id

    def json(self):
        return {"id": self.id, "patient_id": self.patient_id, "record_date": self.record_date}

@app.route("/record")
def get_all():
    record_list = db.session.scalars(db.select(Record)).all()

    if len(record_list):
        return jsonify(
            {
                "code": 200,
                "data": {
                    "records": [record.json() for record in record_list]
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "There are no records."
        }
    ), 404


@app.route("/record/<int:id>")
def get_record_by_id(id):
    record = db.session.scalars(
    	db.select(Record).filter_by(id=int(id)).
    	limit(1)
    ).first()

    if record:
        return jsonify(
            {
                "code": 200,
                "data": record.json()
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "Record not found."
        }
    ), 404


@app.route("/record", methods=['POST'])
def create_record():
    data = request.get_json()
    record = Record(**data)

    try:
        db.session.add(record)
        db.session.commit()
    except:
        return jsonify(
            {
                "code": 500,
                "data": data,
                "message": "An error occurred creating the book."
            }
        ), 500

    return jsonify(
        {
            "code": 201,
            "data": record.json()
        }
    ), 201


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
