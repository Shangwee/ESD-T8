### Patient Records microservice 

*Details*

record: port 5003
db: port 3303

table name: record
- id INT
- patient_id INT
- record_date DATETIME

/record (GET)
/record/id (GET)
/record (POST)

*instructions*
- in PatientRecords root folder, run docker compose up