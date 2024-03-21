var accountURL = 'http://localhost:5001/account';
var InventoryURL = 'http://localhost:5002/inventory';
var PrescriptionURL = 'http://localhost:5004/prescription';

const app = Vue.createApp({
    data() {
        return {
            patientID : '',
            email : '',
            name : '',
            allergies : [],
            prescriptions : [],
            role: 0
        }
    },

    methods:{
        displayPatient(){
            // get patient ID from get url
            var urlParams = new URLSearchParams(window.location.search);
            var patientID = urlParams.get('patientID');
            if(patientID != null && patientID > 3){
                this.patientID = patientID;
                axios.get(accountURL + '/' + patientID).then((response) => {
                    var patient = response.data.data;
                    this.patientID = patient.id;
                    this.email = patient.email;
                    this.name = patient.name;
                    // check if patient.allergies == null
                    if(patient.allergies != null){
                        this.getAllergies(patient.allergies);
                    } 
                    this.role = patient.role;
                    this.getPrescription(patientID);
                });

            } else {
                window.location.href = '../views/Patients.php';
            }
        },
        getAllergies(allergies){
            for (allergy in allergies){
                var MedicineID = allergies[allergy]
                axios.get(InventoryURL + '/' + MedicineID).then((response) => {
                    var medicine  = response.data.data;
                    this.allergies.push({id: medicine.inventoryID, name: medicine.medicine, alternative: medicine.alternative});
                });
            }

        },

        getPrescription(ID){
            axios.get(PrescriptionURL + '/patient/' + ID).then((response) => {
                var prescription = response.data.data;
                for (i in prescription){
                    this.prescriptions.push(prescription[i]);
                }
            });
        }
    
    },

    created(){
        this.displayPatient();
    }
}); 

app.mount('#profile');