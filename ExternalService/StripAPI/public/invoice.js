var createCheckout = 'http://localhost:4242/create-checkout-session';
var createPayment_URL = 'http://localhost:6002/createpayment';
var invoice_url = 'http://localhost:5007/invoice/2';


function clearQueryVariable(variable) {
    var baseUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
    var newUrl = baseUrl;
    var query = window.location.search.substring(1);
    var vars = query.split('&');

    if (vars.length > 0 && vars[0] !== "") {
        newUrl += '?';
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split('=');
            if (decodeURIComponent(pair[0]) !== variable) { // Keep other parameters, remove only the specified one
                newUrl += (newUrl.slice(-1) !== '?' ? '&' : '') + vars[i];
            }
        }
        if (newUrl.slice(-1) === '?') { // Remove '?' if no parameters left
            newUrl = baseUrl;
        }
    }

    // Update the URL without reloading the page
    history.pushState({path: newUrl}, '', newUrl);
}


const app = Vue.createApp({
    data() {
        return {
            invoices: [],
            total_price: 0,
            chosen_invoice: '',
            display: false
        }
    },

    methods:{
        getInvoice(){
            // var testing =
            //     [
            //         {"invoice_id": 3, "medicine": [{"medicineID": 1, "medicineName": "CoughMedicine 2", "price": 20.0, "quantity": 5}, { "medicineID": 1, "medicineName": "CoughMedicine 2",  "price": 20.0, "quantity": 5}, { "medicineID": 1, "medicineName": "CoughMedicine 2",  "price": 20.0, "quantity": 5}], "patient_id": 3, "payment_status": 0, "total_price": 10.0},
            //         {"invoice_id": 4, "medicine": [{"medicineID": 2, "medicineName": "CoughMedicine 3", "price": 20.0, "quantity": 5}], "patient_id": 2, "payment_status": 0, "total_price": 10.0},
            //     ]

            // this.invoices = testing;
            // console.log(testing)


            // will need to change to Get Patient ID from UI later on
            axios.get(invoice_url)
                .then(response => {
                    console.log("successful retrieval")
                    console.log(response.data)
                    invoices = response.data.data
                    this.invoices = invoices
                    console.log(typeof(invoices))
                    console.log(invoice)
                    console.log(this.invoices)
                    this.display = true
                })
                .catch(error => {
                    console.log("failed to retrieve invoice from DB")
                    console.log(error)
                })


        },

        createCheckout() {
            // var invoice_id = document.getElementById('invoice_id').value;
            // var total_price = document.getElementById('total_price').value;
            // total_price = total_price * 100; // Convert to smallest currency unit
        
            const invoice = JSON.parse(event.target.dataset.invoice);
            this.chosen_invoice = invoice

            const invoice_id = invoice.invoice_id
            const medicine = invoice.medicine
            const patient_id = invoice.patient_id
            const total_price = invoice.total_price * 100

            dup_invoice = invoice

            console.log(invoice_id)
            console.log(total_price)
            console.log(medicine)
            console.log(patient_id)

            let params = {
                invoice_id: invoice_id,
                patient_id : patient_id,
                medicine : medicine,
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
                if(data.url) {
                    window.location.href = data.url;
                } else {
                    console.log("Failed to get checkout URL")
                }

                /* Check if stripe sends back payment status code "done" */
                if (document.getElementById("status").value == "success") {
                    document.getElementById("status").value = null

                    params = {
                        status : "done"
                    }

                    
                }
            })
            .catch(error => {
                console.log("There is some problem sending to complex. " + error)
            })
        },

        checkPaymentStatus() {
            const status = this.getQueryVariable('status');
            console.log("testing", status)

            const process_status = JSON.parse(status)

            if (process_status) {
                // invoke to complex microservice
                axios.post(createPayment_URL, process_status)
                .then(response => {
                    console.log(response.data)
                })
                .catch(error => {
                    console.log(error)
                })

            }
        },

        getQueryVariable(variable) {
            var query = window.location.search.substring(1);
            var vars = query.split('&');
            for (var i = 0; i < vars.length; i++) {
                var pair = vars[i].split('=');
                if (decodeURIComponent(pair[0]) == variable) {
                    return decodeURIComponent(pair[1].replace(/\+/g, ' '));
                }
            }
            return null;
        },

    },

    created(){
        this.getInvoice();
        this.checkPaymentStatus();
    }

}); 

const vm = app.mount('#invoice');