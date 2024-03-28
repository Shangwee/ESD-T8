# ESD-T8

### port numbers
DB starts (3300)
- account 3301
- inventory 3302
- prescription 3304
- invoice 3307
- mc 3308

Simple service (5000)
- account 5001
- inventory 5002
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
- to enable logging in terminal place ```PYTHONUNBUFFERED: 1``` under enviroment in the compose file


### How to run services
For UI
- start wamp
- Make sure to disable mysql on wamp
    - Wamp setting > untick "Allow MySQL"

Simple microservice
- navigate to SImpleSerive directory in terminal 
- run ```docker compose up```

Complex microservice
- navigate to ComplexSerive directory in terminal 
- run ```docker compose up```

AMQP
- navigate to AMQP directory in terminal 
- run ```docker compose up```

To run ExternalService (StripAPI)
- navigate to ```\ExternalService\StripAPI``` directory in terminal 
- run ```python server.py```

To rebuild any of the above services
- run ```docker compose build```


To access the starting page
input this into ```http://localhost/ESD-T8/UI/views/sign-in.php``` to start using the application

