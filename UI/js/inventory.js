var InventoryURL = 'http://localhost:5002/inventory';

const app = Vue.createApp({
    data() {
        return {
            inventory : [],
        }
    },

    methods:{
        displayAvailableInventoy(){
            axios.get(InventoryURL).then((response) => {
                this.inventory = response.data.data.inventories;
            });
        },
        checkloginDoctor(){
            // check if the user is logged in
            let account = JSON.parse(sessionStorage.getItem('account'));
            if (account == null && account.role != 0) {
                window.location.href = '../index.php';
            } else {
                this.doctorID = account.id;
            }
        },
    },

    created(){
        this.displayAvailableInventoy();
        this.checkloginDoctor();
    }
}); 

app.mount('#Inventory');