var accountURL = 'http://localhost:5001/account';

const protectIndex = Vue.createApp({

    methods:{
        checklogin(){
            // check if the user is logged in
            let account = JSON.parse(sessionStorage.getItem('account'));
            if (account == null) {
                window.location.href = './views/sign-in.php';
            }
        },
    },

    created(){
        this.checklogin();
    }
}); 

protectIndex.mount('#protect');