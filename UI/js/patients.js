var accountURL = 'http://localhost:5001/account';
var InventoryURL = 'http://localhost:5002/inventory';

const app = Vue.createApp({
    data() {
        return {
            patients: []
        }
    },

    methods:{
        displayPatients(){
            axios.get(accountURL).then((response) => {
                accounts = response.data.data.accounts;
                accounts.forEach(account => {
                    if(account.role == 1){
                        this.patients.push(account);
                    }
                });
            });
        },
        displayProfile(id){
            // set session storage
            sessionStorage.setItem('patientID', id);
            window.location.href = '../views/PatientProfile.php';
        }
    },

    created(){
        this.displayPatients();
    }
}); 

app.mount('#patients');