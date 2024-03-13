### Invoice microservice 

*Details*
service port 5007
db Port 3307

table name: invoice

    invoice_id INT PRIMARY KEY AUTO_INCREMENT,
    patient_id INT NOT NULL,
    date DATETIME NOT NULL,
    medicine VARCHAR(255),
    total_price FLOAT NOT NULL,
    payment_status INT NOT NULL,

*instructions*
in Invoice folder, run the following command "docker compose up"

```/invoice/<int:patient_id>```
1. method: GET
    retrieve the invoice(s) of patient with payment_status = 0 (not yet paid)


2. creating invoice after tabulating total price -- ** to be implemented

