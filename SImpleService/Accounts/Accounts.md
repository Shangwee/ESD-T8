### Accounts microservice 

*Details*

account: port 5001
db: port 3301

table name: account
- id INT
- name VARCHAR(255)
- email VARCHAR(50)
- password VARCHAR(255)
- role INT

/account (GET)
/account/id (GET)
/login (POST)

*instructions*
- in accounts root folder, run docker compose up