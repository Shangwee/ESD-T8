var accountURL = 'http://localhost:5001/account';

const signout = Vue.createApp({
    data() {
        return {
            email: '',
            password: '',
        }
    },

    methods:{
        signout(){
            // check if the user is logged in
            let account = JSON.parse(sessionStorage.getItem('account'));
            if (account == null) {
                window.location.href = './sign-in.php';
            } else {
                sessionStorage.removeItem('account');
                window.location.href = './sign-in.php';
            }
        },

    },

    created(){
        this.signout();
    }
}); 

signout.mount('#signout');