var createCheckout = 'http://localhost:4242/create-checkout-session';

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
                    {"invoice_id": 3, "medicine": [{"medicineID": 1, "medicineName": "CoughMedicine 2", "price": 20.0, "quantity": 5}], "patient_id": 2, "payment_status": 0, "total_price": 10.0},
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

    },

    created(){
        this.getInvoice();
    }
}); 

const vm = app.mount('#invoice');



