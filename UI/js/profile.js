var accountURL = 'http://localhost:5001/account';
var InventoryURL = 'http://localhost:5002/inventory';

const app = Vue.createApp({
    data() {
        return {
            patientID : '',
        }
    },

    methods:{
        displayPatient(){
            // get from session storage
            var patientID = sessionStorage.getItem('patientID');
            if(patientID != null){
                this.patientID = patientID;
                axios.get(accountURL + '/patient/' + patientID).then((response) => {
                    this.patient = response.data.data.patient;
                    console.log(this.patient);
                });
            } else {
                window.location.href = '../views/Patients.php';
            }
        },
    },

    created(){
        this.displayPatient();
    }
}); 

app.mount('#profile');