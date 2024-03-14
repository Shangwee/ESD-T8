### Prescriptions microservice 

*Details*
service port 5004
db Port 3304

table name: prescription 

prescriptionID INT AUTO_INCREMENT PRIMARY KEY,
patientID INT NOT NULL,
doctorID INT NOT NULl,
medicine JSON
process BOOLEAN

In medicine 
each medcine include
- medicineID
- medicineName
- quantity
- instruction


*instructions*
1. do to the prescripton folder
2. run the following command "docker-compose -f ./docker-compose.yaml up "

```/prescription```
1. method: GET
    details: retrieve all the prescription
2. method: POST
    details: Create new prescription

```/prescription/patient/<int:patient_id>```
1. method: GET
    get prescrition of specific patients

```/prescription/<int:prescriptionID>```
2. method: PUT
    update prescription details

```/prescription/checkallergy/``` *to be implemented*
1. retrieve allergy based on patient id from accounts
2. check if prescribe medicine is on the list
3. if no, return all good
4. if yes return the list of allergy

*version*
v1.0
created the new prescription microservice

v1.1
changed the sql table with include a json for medicine data field

v1.2
added a new column 'process', this check if the prescription is being process yet, it will be stored as a boolean

v1.3
added a new route for ```/prescription/checkallergy```   