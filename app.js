new Vue({
    el: '#app',
    data: {
        currentPage: 'home',
        login: {
            username: '',
            password: ''
        },
        loginMessage: '',
        contact: {
            name: '',
            email: '',
            message: ''
        },
        contactMessage: '',
        signup: {
            username: '',
            email: '',
            password: '',
            confirmPassword: ''
        },
        signupMessage: ''
    },
    methods: {
        submitLogin() {
            // For demonstration, just check if username and password are non-empty
            if (this.login.username && this.login.password) {
                this.loginMessage = 'Login successful for user: ' + this.login.username;
            } else {
                this.loginMessage = 'Please enter username and password.';
            }
        },
        submitContact() {
            if (this.contact.name && this.contact.email && this.contact.message) {
                this.contactMessage = 'Thank you, ' + this.contact.name + '. Your message has been sent.';
                // Clear form
                this.contact.name = '';
                this.contact.email = '';
                this.contact.message = '';
            } else {
                this.contactMessage = 'Please fill in all contact form fields.';
            }
        },
        submitSignup() {
            if (!this.signup.username || !this.signup.email || !this.signup.password || !this.signup.confirmPassword) {
                this.signupMessage = 'Please fill in all sign up fields.';
                return;
            }
            if (this.signup.password !== this.signup.confirmPassword) {
                this.signupMessage = 'Passwords do not match.';
                return;
            }
            this.signupMessage = 'Sign up successful for user: ' + this.signup.username;
            // Clear form
            this.signup.username = '';
            this.signup.email = '';
            this.signup.password = '';
            this.signup.confirmPassword = '';
        }
    }
});
