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

Account will be doctor if role = 0
Account will be patient if role = 1 

*instructions*
- in accounts root folder, run docker compose up