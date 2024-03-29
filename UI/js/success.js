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
            id: '',
            name: ''
        }
    },

    methods:{
        displayPatient(){
            // get account from session storage
            let account = JSON.parse(sessionStorage.getItem('account'));
            this.id = account.id;
            this.name = account.name;
            console.log("id is: ", this.id)
            console.log("name is: ", this.name)
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
                    clearQueryVariable(status)
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
        this.displayPatient();
        this.checkPaymentStatus();
    }

}); 

const vm = app.mount('#success');