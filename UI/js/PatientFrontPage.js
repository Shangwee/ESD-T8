
const app = Vue.createApp({
    data() {
        return {
            name : '',
            role: 1,
            id: ''
        }
    },

    methods:{
        displayPatient(){
            // get account from session storage
            let account = JSON.parse(sessionStorage.getItem('account'));
            this.id = account.id;
            this.name = account.name;
            
            
        },

       
    
    },

    created(){
        this.displayPatient();
    }
}); 

app.mount('#frontpage');