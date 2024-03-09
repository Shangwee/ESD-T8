# ESD-T8

### port numbers
DB starts (3300)
- account 3301
- inventory 3302
- patients record 3303
- prescription 3304

Simple service (5000)
- account 5001
- inventory 5002
- patients record 5003
- prescription 5004

Complex service (6000)
- CreateMC 6001
- CreatePayment 6002
- CreatePresciption 6003

### Note

Make sure to include the following in all the microservice:
- ```from flask_cors import CORS``` and ```CORS(app)``` 

