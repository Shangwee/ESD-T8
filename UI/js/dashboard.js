var accountURL = 'http://localhost:5001/account';
var InventoryURL = 'http://localhost:5002/inventory';
var PrescriptionURL = 'http://localhost:5004/prescription';

const app = Vue.createApp({
    data() {
        return {
            doctorID : '',
            name : '',
            prescriptions : [],
            role: 0
        }
    },

    methods:{
        displayPrescription(){
            // get account from session storage
            let account = JSON.parse(sessionStorage.getItem('account'));
            this.doctorID = account.id;
            this.name = account.name;
            this.getPrescription(this.doctorID);
            
        },

        getPrescription(ID){
            axios.get(PrescriptionURL + '/doctor/' + ID).then((response) => {
                var prescription = response.data.data;
                for (i in prescription){
                    this.prescriptions.push(prescription[i]);
                }
            });
        }
    
    },

    created(){
        this.displayPrescription();
    }
}); 

app.mount('#index');