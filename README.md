# ESD-T8

### port numbers
DB starts (3300)
- account 3301
- inventory 3302
- patients record 3303 (not using)
- prescription 3304
- dispenser ----
- invoice 3307
- mc 3308

Simple service (5000)
- account 5001
- inventory 5002
- patients record 5003 (not using)
- prescription 5004
- dispenser 5005
- invoice 5007
- mc 5008

Complex service (6000)
- ProcessPrescription 6001
- CreatePayment 6002
- CreatePresciption 6003

External API Stripe
- 4242


### Note

Make sure to include the following in all the microservice:
- ```from flask_cors import CORS``` and ```CORS(app)``` 
- In complex microservices do take note to use ```host.docker.internal``` instead of ```localhost``` so that complex can talk to other simple microservices
