var InventoryURL = 'http://localhost:5002/inventory';
var createPresscriptionURL = 'http://localhost:6003/create_prescription';

const app = Vue.createApp({
    data() {
        return {
            inventory : [],
            prescriptions: [],
            editlist : [],
            patientID: '',
            doctorID: '',

        }
    },

    methods:{
        addPrescription(medicineID, medicineName){
            // check if the medicine is already in the prescription
            for (let i = 0; i < this.prescriptions.length; i++) {
                if (this.prescriptions[i].medicineID === medicineID) {
                    this.prescriptions[i].quantity += 1;
                    return;
                }
            }
            this.prescriptions.push({
                medicineID: medicineID,
                medicineName: medicineName,
                quantity: 1,
                instruction: 'No instruction provided'
            });
        },

        removePrescription(index){
            this.prescriptions.splice(index, 1);
        },

        displayAvailableInventoy(){
            axios.get(InventoryURL).then((response) => {
                this.inventory = response.data.data.inventories;
            });
        },

        editMedicine(item) {
            // push item id into editlist
            console.log("item loaded", item);
            this.editlist.push(item.medicineID);
            console.log("item loaded", this.editlist);
            console.log("betore editing");
        },
        
        saveMedicine(item){
            console.log("save medicine", item);
            this.editlist.splice(this.editlist.indexOf(item.medicineID), 1);
            console.log("after editing");
        },

        savePrescription(){
            if(this.patientID <= 3 || this.doctorID >= 4 || this.prescriptions.length < 1){
                alert("Please fill all the fields");
            } else {
                let params = {
                    patientID: this.patientID,
                    doctorID: this.doctorID,
                    medicine: this.prescriptions
                }
                axios.post(createPresscriptionURL, params).then((response) => {
                    console.log(response);
                    alert("Prescription created successfully");
                });
            }     
        }
    },
    created(){
        this.displayAvailableInventoy();
    }
}); 

const vm = app.mount('#prescription');