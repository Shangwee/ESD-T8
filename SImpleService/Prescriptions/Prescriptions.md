### Prescriptions microservice 

*Details*
service port 5004
db Port 3304

table name: prescription 

prescriptionID INT AUTO_INCREMENT PRIMARY KEY,
patientID INT NOT NULL,
doctorID INT NOT NULl,
medicine VARCHAR(255) ,
quantity INT NOT NULL,
instructions TEXT,
datetime DATETIME

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

```/prescription/CheckAllergy/<<int:patient_id>>``` *to be implemented*
1. retrieve allergy based on patient id from accounts
2. check if prescribe medicine is on the list
3. if no, return all good
4. if yes, system retrieve inventory to find similar drugs and return UI about the change.

