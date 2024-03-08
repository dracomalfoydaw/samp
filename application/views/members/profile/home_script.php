<script type="text/javascript">
    var base_url = "<?php echo base_url() ?>";
</script>
<script type="text/javascript">
    const app = Vue.createApp({
        data()
        {
            return {
                searchTerm: '',
                dataTable: null,
                loading: true,
                errors: {},
                error_transaction:[],
                formData: {
                    firstName: '',
                    middleName: '',
                    lastName: '',
                    nameExtension: '',
                    username: '',
                    email: '',
                    idnumber: '',
                    defaultuseraccount: [],
                },
            };
        },
        methods:{
            loadDatatable:function()
            {
                this.dataTable = $('#dataTable').DataTable({
                    "processing": true,
                    "serverSide": true,

                    ajax: {
                        url: base_url+'members/search', // Replace with your server-side script
                        dataSrc: '',
                        type: "POST",
                        data: function (d) {
                            d.searchTerm = $("#search-input").val(); // Add the search term
                        }
                    },
                    columns: [                  
                       
                        { data: 'UserID', title: 'User ID' },
                        { data: 'LastName', title: 'Last Name' },
                        { data: 'FirstName', title: 'First Name' },
                        { data: 'MiddleName', title: 'Middle Name' },
                        { data: 'NameExtension', title: 'Name Extension' },
                        {
                          data: null,
                          render: (data, type, row) => {
                            
                            return '<button class="update-button btn btn-sm btn-warning" data-user-id="' + row.UserID + '"><i class="fa fa-edit"></i></button> <button class="delete-button btn btn-sm btn-danger" data-user-id="' + row.UserID + '"><i class="fa fa-trash"></i></button>';
                          },
                        },
                    ]
                });

                // Watch for changes in searchTerm and update DataTable search
                this.$watch('searchTerm', (newValue) => {
                    this.dataTable.search(newValue).draw();
                });
               /* $('#search-input').on('input', () => {
                        this.dataTable.search($('#search-input').val()).draw();
                    });*/
            },

            openRegistrationModal() {
                // Open the Bootstrap modal for registration
                $("#firstName").prop('disabled', false);
                $("#middleName").prop('disabled', false);
                $("#lastName").prop('disabled', false);
                $("#nameExtension").prop('disabled', false);
                $("#username").prop('disabled', false);
                $("#email").prop('disabled', false);
                $("#idnumber").prop('disabled', false);
                 $("#submit_form_btn").prop('disabled', false);

                $('#registrationModal').modal('show');
            },
            submitRegistrationForm() {
                this.errors = {};

                // Validation logic
                if (!this.formData.firstName) {
                  this.errors.firstName = 'First Name is required.';
                }

               

                if (!this.formData.lastName) {
                  this.errors.lastName = 'Last Name is required.';
                }
                if (!this.formData.idnumber) {
                  this.errors.idnumber = 'ID Number is required.';
                }

                // Add additional validation logic for other fields as needed

                

                if (!this.formData.email) {
                  this.errors.email = 'Email is required.';
                } else if (!this.isValidEmail(this.formData.email)) {
                  this.errors.email = 'Invalid email format.';
                }

              

                // If there are no errors, submit the form (you can replace this with your actual form submission logic)
                if (Object.keys(this.errors).length === 0) {
                    this.error_transaction = [];
                    $(".messagebox").hide("slow");
                    $('#loading').show();

                    $("#submit_form_btn").prop('disabled', true);
                    $("#firstName").prop('disabled', true);
                    $("#middleName").prop('disabled', true);
                    $("#lastName").prop('disabled', true);
                    $("#nameExtension").prop('disabled', true);
                    $("#username").prop('disabled', true);
                    $("#email").prop('disabled', true);
                    $("#idnumber").prop('disabled', true);

                    const address = base_url+"members/save";
                    let params = new URLSearchParams();
                    params.append("defaultuseraccount", this.formData.defaultuseraccount);
                    params.append("firstName", this.formData.firstName);
                    params.append("middleName", this.formData.middleName);
                    params.append("lastName", this.formData.lastName);
                    params.append("nameextension", this.formData.nameExtension);
                    params.append("username", this.formData.username);
                    params.append("email", this.formData.email);
                    params.append("idnumber", this.formData.idnumber);

                    axios.post(address, params,)
                    .then(response => {
                        if(response.data.message=="success")
                        {
                            $('#loading').show();
                            alert('Form submitted successfully!');
                            $('#registrationModal').modal('hide');
                            $("#firstName").prop('disabled', false);
                            $("#middleName").prop('disabled', false);
                            $("#lastName").prop('disabled', false);
                            $("#nameExtension").prop('disabled', false);
                            $("#username").prop('disabled', false);
                            $("#email").prop('disabled', false);
                            $("#idnumber").prop('disabled', false);
                            $("#submit_form_btn").prop('disabled', false);

                            console.log(response);
                        }
                        else
                        {
                            $("#firstName").prop('disabled', false);
                            $("#middleName").prop('disabled', false);
                            $("#lastName").prop('disabled', false);
                            $("#nameExtension").prop('disabled', false);
                            $("#username").prop('disabled', false);
                            $("#email").prop('disabled', false);
                            $("#idnumber").prop('disabled', false);
                            $("#submit_form_btn").prop('disabled', false);
                            
                            $("#error_content").html(response.data.message_details);
                            $(".messagebox").fadeIn("slow");
                            $('#registrationModal').animate({ scrollTop: 0 }, 'slow');
                            console.log(response);
                        }
                    })
                    .catch(error => {
                        $('#loading').fadeOut("slow");
                         this.error_transaction.push("Something went wrong. Contact the administrator for the problem.");
                        $(".messagebox").fadeIn("slow");
                        alert("Something went wrong. Contact the administrator for the problem.");
                        $('html,body').animate({ scrollTop: 0 }, 'slow');
                        console.log(error);
                    });



                    
                }
                
            },
            isValidEmail(email) {
                // Simple email validation using regular expression
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

        },
        mounted(){
            this.loadDatatable();
            $('#dataTable').on('click', '.delete-button', function () {
                var userId = $(this).data('user-id');
                console.log('delete'+userId);
                
                // Implement your delete logic here using the userId
                // For example, you can make an AJAX call to the server to delete the user
                // $.ajax({
                //     url: 'members/delete/' + userId,
                //     type: 'DELETE',
                //     success: function (response) {
                //         // Handle success
                //     },
                //     error: function (error) {
                //         // Handle error
                //     }
                // });
            });
            $('#dataTable').on('click', '.update-button', function () {
                var userId = $(this).data('user-id');
                console.log('update'+userId);
                
                // Implement your delete logic here using the userId
                // For example, you can make an AJAX call to the server to delete the user
                // $.ajax({
                //     url: 'members/delete/' + userId,
                //     type: 'DELETE',
                //     success: function (response) {
                //         // Handle success
                //     },
                //     error: function (error) {
                //         // Handle error
                //     }
                // });
            });
        }
    });

    app.mount('#app');
</script>