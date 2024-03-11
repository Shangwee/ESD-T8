const app = Vue.createApp({
    data() {
        return {
            inventory : [],
            prescriptions: [],
            patientID: '',
            doctorID: '',
            medicine: '',
            quantity: 1,
            instruction: ''

        }
    },
    methods:{
        addPrescription(){
            this.prescriptions.push({
                medicine: this.medicine,
                quantity: this.quantity,
                instruction: this.instruction
            });
            this.patientID = '';
            this.doctorID = '';
            this.medicine = '';
            this.quantity = 1;
            this.instruction = '';
        },
        removePrescription(index){
            this.prescriptions.splice(index, 1);
        },

        displayAvailableInventoy(){
            let InventoryURL = 'http://localhost:5002/inventory';
            axios.get(InventoryURL).then((response) => {
                this.inventory = response.data.data.inventories;
            });
        }
    }
}); 

const vm = app.mount('#prescription');