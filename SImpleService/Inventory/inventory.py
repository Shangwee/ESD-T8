from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS

from os import environ


app = Flask(__name__)
CORS(app)
app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False


db = SQLAlchemy(app)

class Inventory(db.Model):
    __tablename__ = 'inventory'


    inventoryID = db.Column(db.Integer, primary_key=True)
    medicine = db.Column(db.String(64), nullable=False)
    price = db.Column(db.Float(precision=2), nullable=False)
    quantity = db.Column(db.Integer)


    def __init__(self, inventoryID, medicine, price, quantity):
        self.inventoryID = inventoryID
        self.medicine = medicine
        self.price = price
        self.quantity = quantity


    def json(self):
        return {"inventoryID": self.inventoryID, "medicine": self.medicine, "price": self.price, "quantity": self.quantity}


@app.route("/inventory")
def get_all():
    inventorylist = db.session.scalars(db.select(Inventory)).all()
    if len(inventorylist):
        return jsonify(
            {
                "code": 200,
                "data": {
                    "inventories": [inventory.json() for inventory in inventorylist]
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "There are no inventories.",
            "sql": inventorylist
        }
    ), 404


@app.route("/inventory/<int:inventoryID>")
def find_by_inventoryID(inventoryID):
    inventory = db.session.scalars(
    	db.select(Inventory).filter_by(inventoryID = int(inventoryID)).
    	limit(1)
        ).first()

    if inventory:
        return jsonify(
            {
                "code": 200,
                "data": inventory.json()
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "Inventory not found."
        }
    ), 404



@app.route("/inventory/<int:inventoryID>", methods=['POST'])
def create_inventory(inventoryID):
    if (db.session.scalars(
      db.select(Inventory).filter_by(inventoryID = int(inventoryID)).
      limit(1)
      ).first()
      ):
        return jsonify(
            {
                "code": 400,
                "data": {
                    "inventoryID": inventoryID
                },
                "message": "Inventory already exists."
            }
        ), 400
    
    data = request.get_json()
    inventory = inventory(inventoryID, **data)

    try:
        db.session.add(inventory)
        db.session.commit()
    except:
        return jsonify(
            {
                "code": 500,
                "data": {
                    "inventoryID": inventoryID
                },
                "message": "An error occurred creating the inventory."
            }
        ), 500

    return jsonify(
        {
            "code": 201,
            "data": inventory.json()
        }
    ), 201


@app.route("/inventory/<int:inventoryID>", methods=['PUT'])
def update_inventory(inventoryID):
    try:
        inventory = db.session.scalars(db.select(Inventory).filter_by(inventoryID=int(inventoryID)).limit(1)).first()
        if not inventory:
            return jsonify(
                {
                    "code": 404,
                    "data": {
                        "inventoryID": inventoryID
                    },
                    "message": "inventory not found."
                }
            ), 404

        # update the inventory
        data = request.get_json()
        inventory.medicine = data['medicine']
        inventory.price = data['price']
        inventory.quantity = data['quantity']
        db.session.commit()
        return jsonify(
            {
                "code": 200,
                "data": inventory.json()
            }
        )
    except Exception as e:
        return jsonify(
            {
                "code": 500,
                "data": {
                    "inventoryID": inventoryID
                },
                "message": "An error occurred while updating the inventory. " + str(e)
            }
        ), 500

        

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
