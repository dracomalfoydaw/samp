const app = Vue.createApp({
                data()
                {
                        return {
                                email: '',
                                password: '',
                                rememberPassword: false,
                                errors: {}
                        };
                },
                methods:{
                        login() {
                                this.errors = {};
                                if (!this.email) {
                                    this.errors.email = 'Email is required.';
                                }
                                if (!this.password) {
                                    this.errors.password = 'Password is required.';
                                }
                                // Here you can add additional validation logic, e.g., checking email/password against a database
                                if (Object.keys(this.errors).length === 0) {
                                        this.error_transaction = [];
                                        $(".messagebox").hide("slow");
                                        $('#loading').show();
                                        $("#inputEmailAddress").prop('disabled', true);
                                        $("#inputPassword").prop('disabled', true);
                                        $("#loginbutton").prop('disabled', true);
                                        // Perform login operation
                                        const address = base_url+"login/check_credentials";
                                        let params = new URLSearchParams();
                                        params.append("email", this.email);
                                        params.append("password", this.password);
                                        axios.post(address, params,)
                                        .then(response => {
                                                $('#loading').fadeOut("slow");
                                                if(response.data.message=="success")
                                                {
                                                        
                                                        window.location.href=base_url+'home';
                                                }
                                                else
                                                {
                                                        $("#inputEmailAddress").prop('disabled', false);
                                                        $("#inputPassword").prop('disabled', false);
                                                        $("#loginbutton").prop('disabled', false);
                                                        $("#error_content").html(response.data.message_details);
                                                        $(".messagebox").fadeIn("slow");
                                                        $('#registrationModal').animate({ scrollTop: 0 }, 'slow');
                                                      
                                                }
                                        })
                                        .catch(error => {
                                                $("#inputEmailAddress").prop('disabled', false);
                                                $("#inputPassword").prop('disabled', false);
                                                $("#loginbutton").prop('disabled', false);

                                                $('#loading').fadeOut("slow");
                                                this.error_transaction.push("Something went wrong. Contact the administrator for the problem.");
                                                $(".messagebox").fadeIn("slow");
                                                alert("Something went wrong. Contact the administrator for the problem.");
                                                $('html,body').animate({ scrollTop: 0 }, 'slow');
                                              
                                        });


                                }
                        }
                }
        });

        app.mount('#app');