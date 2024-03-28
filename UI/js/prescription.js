var accountURL = 'http://localhost:5001/account';
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
            allergicTo: [],
            patientName: '',
            ispatient: '',
            error : '',
        }
    },

    methods:{
        checkloginDoctor(){
            // check if the user is logged in
            let account = JSON.parse(sessionStorage.getItem('account'));
            if (account == null && account.role != 0) {
                window.location.href = '../index.php';
            } else {
                this.doctorID = account.id;
            }
        },

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

        removePrescription(medicineID){
            for (let i = 0; i < this.prescriptions.length; i++) {
                if (this.prescriptions[i].medicineID === medicineID) {
                    this.prescriptions.splice(i, 1);
                    return;
                }
            }
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

        getallergicTo(){
            this.allergicTo = [];
            this.error = '';
            if (this.patientID != '') {
                let id = this.patientID.toString();
                axios.get(accountURL + "/" +id ).then((response) => {
                this.patientName = response.data.data.name;
                let allergicList = response.data.data.allergies;
                // get inventory 
                if (allergicList != null){
                    for (medicine in this.inventory) {
                        let inventoryID = this.inventory[medicine].inventoryID;
                        for (allergic of allergicList) {
                            if (inventoryID == parseInt(allergic)){
                                let medName = this.inventory[medicine].medicine;
                                this.allergicTo.push(medName);
                            }
                        }
                    }
                }
                })
                .catch((error) => {
                    console.log(error.response.data.message);
                    this.error = error.response.data.message;

                });
            } else {
                this.allergicTo = [];
                this.patientName = '';
            }
        },

        savePrescription(){
            if(this.patientID <= 3 || this.doctorID >= 4 || this.prescriptions.length < 1 || this.patientID == '' || this.doctorID == ''){
                alert("Please fill all the fields properly.");
            } else {
                let params = {
                    patientID: this.patientID,
                    doctorID: this.doctorID,
                    medicine: this.prescriptions
                }
                axios.post(createPresscriptionURL, params).then((response) => {
                    console.log(response);
                    this.prescriptions = [];
                    this.patientID = '';
                    this.doctorID = '';
                    this.allergicTo = [];
                    alert("Prescription created successfully");
                })
                .catch((error) => {
                    let message = error.response.data.message;
                    alert(message);
                })
            }     
        }
    },
    created(){
        this.checkloginDoctor();
        this.displayAvailableInventoy();
    }
}); 

const vm = app.mount('#prescription');