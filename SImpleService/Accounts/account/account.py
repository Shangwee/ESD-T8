from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from os import environ

app = Flask(__name__)

app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
# app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/account'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)

class Account(db.Model):
    __tablename__ = 'account'

    id = db.Column(db.String(64), primary_key=True)
    name = db.Column(db.String(64), nullable=False)
    email = db.Column(db.String(64), nullable=False)
    password = db.Column(db.String(64), nullable=False)
    role = db.Column(db.Integer)

    def __init__(self, id, name, email, password, role):
        self.id = id
        self.name = name
        self.email = email
        self.password = password
        self.role = role

    def json(self):
        return {"id": self.id, "name": self.name, "email": self.email, "password": self.password, "role": self.role}

@app.route("/account")
def get_all():
    account_list = db.session.scalars(db.select(Account)).all()

    if len(account_list):
        return jsonify(
            {
                "code": 200,
                "data": {
                    "accounts": [account.json() for account in account_list]
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "There are no accounts."
        }
    ), 404


@app.route("/account/<int:id>")
def get_account_by_id(id):
    account = db.session.scalars(
    	db.select(Account).filter_by(id=int(id)).
    	limit(1)
    ).first()

    if account:
        return jsonify(
            {
                "code": 200,
                "data": account.json()
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "Account not found."
        }
    ), 404


@app.route("/login", methods=['POST'])
def login():

    data = request.get_json()
    email = data["email"]
    password = data["password"]

    account = db.session.scalars(
    	db.select(Account).filter_by(email=email, password=password)
    ).first()

    

    if account:
        return jsonify(
            {
                "code": 200,
                "data": account.json()
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "Incorrect email or password."
        }
    ), 404

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
