<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/vue@3.4.15/dist/vue.global.js"></script>
        <script src="https://unpkg.com/axios@1.6.5/dist/axios.min.js"></script>
        <script src="https://unpkg.com/lodash@4.17.21/lodash.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/scripts.js"></script>

        <script type="text/javascript">
    var base_url = "<?php echo base_url() ?>";
</script>

<script type="text/javascript">
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
</script>