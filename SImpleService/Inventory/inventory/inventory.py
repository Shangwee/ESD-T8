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


    inventoryID = db.Column(db.Integer,autoincrement=True, primary_key=True, nullable=True)
    medicine = db.Column(db.String(64), nullable=False)
    price = db.Column(db.Float(precision=2), nullable=False)
    quantity = db.Column(db.Integer)
    alternative = db.Column(db.JSON, nullable=True)


    def __init__(self, medicine, price, quantity, alternative):
        self.medicine = medicine
        self.price = price
        self.quantity = quantity
        self.alternative = alternative


    def json(self):
        return {"inventoryID": self.inventoryID, "medicine": self.medicine, "price": self.price, "quantity": self.quantity, "alternative": self.alternative}


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



@app.route("/inventory/", methods=['POST'])
def create_inventory():    
    data = request.get_json()
    inventory = Inventory( **data)

    try:
        db.session.add(inventory)
        db.session.commit()
    except:
        return jsonify(
            {
                "code": 500,
                "data": data,
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
        inventory.alternative = data['alternative']
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

@app.route("/inventory", methods=['POST'])
def find_medicine_price():
        newarr = []
        data = request.json
        medicines = data.get('medicine')

        for medicine in medicines:
            medicineID = medicine['medicineID']
            quantity = medicine["quantity"]
            inventory = db.session.scalars(db.select(Inventory).filter_by(inventoryID = int(medicineID)).limit(1)).first()
            if inventory:
                price = inventory.price
                newdic = {"medicineID": medicineID, "quantity":quantity, "price":price}
            else:
                 return jsonify(
                    {
                        "code": 404,
                        "message": "Inventory not found."
                    }
                ), 404
            newarr.append(newdic)


        return jsonify(
           {
               "code":250,
                "InventorytoInvoice": newarr
           }
        )


# [{"medicineID": 2, "medicineName": "CoughMedicine 2", "quantity": 5, "instruction": "Twice daily"}, {"medicineID": 4,"medicineName": "FluMedicine 1", "quantity": 2, "instruction": "As needed"}]
# {[medicine id, quantity, price]}
            
    

        

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
