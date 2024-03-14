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
  "prescriptions": [
    {
      "prescriptionID": 1,
      "patientID": 123,
      "doctorID": 456,
      "medicine": [
        {"medicineID": 2, "medicineName": "CoughMedicine 2", "quantity": 5, "instruction": "Twice daily"},
        {"medicineID": 4, "medicineName": "FluMedicine 1", "quantity": 2, "instruction": "As needed"}
      ],
      "process": false,
      "datetime": "2024-03-14T12:00:00Z"
    },
    {
      "prescriptionID": 2,
      "patientID": 789,
      "doctorID": 101,
      "medicine": [
        {"medicineID": 2, "medicineName": "Painkiller X", "quantity": 3, "instruction": "Every 6 hours"},
        {"medicineID": 4, "medicineName": "Antibiotic Y", "quantity": 1, "instruction": "Once daily"}
      ],
      "process": true,
      "datetime": "2024-03-14T15:30:00Z"
    }
  ]
}
 