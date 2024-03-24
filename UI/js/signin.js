var accountURL = 'http://localhost:5001/account';

const app = Vue.createApp({
    data() {
        return {
            email: '',
            password: '',
            wrong: false,
            error: '',
        }
    },

    methods:{
        checklogin(){
            // check if the user is logged in
            let account = JSON.parse(sessionStorage.getItem('account'));
            if (account != null) {
                window.location.href = '../index.php';
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
                // check if it is patient or doctor
                if (account.role == 0) {
                    window.location.href = '../index.php';
                } else {
                    window.location.href = '../views/PatientFrontPage.php';
                }
                
            })
            .catch((error) => {
                this.wrong = true;
                this.error = error.response.data.message;
            })
        },

    },

    created(){
        this.checklogin();
    }
}); 

app.mount('#login');