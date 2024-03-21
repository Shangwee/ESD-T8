var accountURL = 'http://localhost:5001/account';

const app = Vue.createApp({
    data() {
        return {
            email: '',
            password: '',
        }
    },

    methods:{
        checklogin(){
            // check if the user is logged in
            let account = JSON.parse(sessionStorage.getItem('account'));
            if (account != null) {
                window.location.href = '../Prescription.php';
            }
        },

        login(){
            let params = {
                email: this.email,
                password: this.password
            }
            loginURL = accountURL + '/login';
            axios.post(loginURL, params).then((response) => {
                account = response.data.data;
                // add it into the session storage
                sessionStorage.setItem('account', JSON.stringify(account));
                // redirect to the dashboard
                window.location.href = '../index.php';
            })
            .catch((error) => {
                console.log(error);
            })
        },

    },

    created(){
        this.checklogin();
    }
}); 

app.mount('#login');