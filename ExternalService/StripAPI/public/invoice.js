var createCheckout = 'http://localhost:4242/create-checkout-session';
var createPayment_URL = 'http://localhost:6002/createpayment';

const app = Vue.createApp({
    data() {
        return {
            invoices: [],
            total_price: 0
        }
    },

    methods:{
        getInvoice(){
            var testing =
                [
                    {"invoice_id": 3, "medicine": [{"medicineID": 1, "medicineName": "CoughMedicine 2", "price": 20.0, "quantity": 5}, { "medicineID": 1, "medicineName": "CoughMedicine 2",  "price": 20.0, "quantity": 5}, { "medicineID": 1, "medicineName": "CoughMedicine 2",  "price": 20.0, "quantity": 5}], "patient_id": 2, "payment_status": 0, "total_price": 10.0},
                    {"invoice_id": 4, "medicine": [{"medicineID": 2, "medicineName": "CoughMedicine 3", "price": 20.0, "quantity": 5}], "patient_id": 2, "payment_status": 0, "total_price": 10.0},
                ]

            this.invoices = testing;
            console.log(testing)
        },

        createCheckout() {
            var invoice_id = document.getElementById('invoice_id').value;
            var total_price = document.getElementById('total_price').value;
            total_price = total_price * 100; // Convert to smallest currency unit
        
            let params = {
                invoice_id: invoice_id,
                total_price: total_price
            };
            axios.post(createCheckout, params)
                .then(response => {
                    // Redirect to Stripe checkout page
                    if (response.data.url) {
                        window.location.href = response.data.url;
                    } else {
                        alert('Failed to get a valid response from the server.');
                    }
                })
                .catch((error) => {
                    console.error("Error during checkout session creation:", error);
                    alert("Failed to initiate checkout process.");
                });
        },

        test(event) {
            /* send to createpayment complex microservice*/
            const invoice = JSON.parse(event.target.dataset.invoice);

            fetch(createPayment_URL,
                {
                    method: "POST",
                    headers: {
                        "Content-type": "application/json"
                    },
                    body: JSON.stringify(invoice)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                console.log("sent over to createpayment complex successfully")
            })
            .catch(error => {
                console.log("There is some problem sending to complex. " + error)
            })
        },

    },

    created(){
        this.getInvoice();
    }

}); 

const vm = app.mount('#invoice');