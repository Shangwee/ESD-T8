### Inventory microservice 

*Details*
service port 5002
db Port 3302

table name: inventory

inventoryID (INT) (Primary key) auto increment
medicine (VARCHAR)
price (Float)
quantity (Int)

*instructions*
1. do to the inventory folder
2. run the following command "docker-compose -f ./docker-compose.yaml up "

```/inventory```
1.method: GET
    details: retrieve all the inventory
2. method: POST
    details: Create new inventory

```/inventory/<int:inventoryID>```
1. method: GET
    get specific inventory

```/inventory/<int:inventoryID>```
1. method: PUT
    update specific inventory
