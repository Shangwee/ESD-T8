### Questions

Inventory Simple Microservice:
- line 104 onwards: update_inventory
    i think need to do some checks before updating inventory, for e.g.
        if prescribe < inventory: can just deduct
        if prescribe > inventory: deduct the remaining inventory to 0
            the remaining amount will also affect the invoice portion

Prescription Simple Microservice:
- for sql, should medicine data-type be VARCHAR(255)[] instead? since there can be more than 1 med prescribed
    - or store as a dictonary (JSON format) which contains the other prescription information if you wanna include in

Others:
- probably can standardise naming convention throughout (e.g. patientID vs patient_id)


loop through prescription and get price from prescription, return a json object of {[medicine id, quantity, price]} - do it at simple inventory 
Test data
{
    "InventorytoInvoice": [
        {
            "medicineID": 2,
            "price": 20.0,
            "quantity": 5
        },
        {
            "medicineID": 4,
            "price": 20.0,
            "quantity": 2
        }
    ],
    "code": 250
}
 