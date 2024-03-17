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
                    Name: '',
                    Description: '',
                    Fines: '',
                    datescheduled:'',
                    createannoucement: [],
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
                        url: base_url+'attendance/search', // Replace with your server-side script
                        dataSrc: '',
                        type: "POST",
                        data: function (d) {
                            d.searchTerm = $("#search-input").val(); // Add the search term
                        }
                    },
                    columns: [    
                        {
                            data: null,
                            render: function (data, type, row, meta) {
                                if (meta) {
                                    return meta.row + 1; // Row number starts from 1
                                } else {
                                    return ''; // or handle the case when meta is undefined
                                }
                            },
                            title: '#'
                        },              
                       
                        { data: 'EntryID', title: 'EntryID' },
                        { data: 'Name', title: 'Name' },
                        { data: 'Description', title: 'Description' },
                        { data: 'Fines', title: 'Fines Imposed' },
                        { data: 'DateScheduleofActivity', title: 'Schedule of Activity' },
                        {
                          data: null,
                          render: (data, type, row) => {
                            
                            return '<a class="check-attendance-button btn btn-sm btn-info" title="Check Attendance" href="'+ base_url+'attendance/view_attendance/' + row.EntryID + '" target="_blank"><i class="fa fa-check"></i></a><button class="update-button btn btn-sm btn-warning" data-user-id="' + row.EntryID + '"><i class="fa fa-edit"></i></button> <button class="delete-button btn btn-sm btn-danger" data-user-id="' + row.EntryID + '"><i class="fa fa-trash"></i></button> ';
                          },
                          title: 'Action',
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
                $("#Name").prop('disabled', false);
                $("#Description").prop('disabled', false);
                $("#Fines").prop('disabled', false);


                $('#registrationModal').modal('show');
            },
            submitRegistrationForm() {
                this.errors = {};

                // Validation logic
                if (!this.formData.Name) {
                  this.errors.Name = 'Name is required.';
                }

               

                if(typeof this.Fines === 'number' ) {
                  this.errors.Fines = 'Fines must be numeric.';
                }
                

                // Add additional validation logic for other fields as needed

                

               

              

                // If there are no errors, submit the form (you can replace this with your actual form submission logic)
                if (Object.keys(this.errors).length === 0) {
                    this.error_transaction = [];
                    $(".messagebox").hide("slow");
                    $('#loading').show();

                    $("#submit_form_btn").prop('disabled', true);
                    $("#Name").prop('disabled', true);
                    $("#Description").prop('disabled', true);
                    $("#Fines").prop('disabled', true);

                    const address = base_url+"attendance/save";
                    let params = new URLSearchParams();
                    params.append("createannoucement", this.formData.createannoucement);
                    params.append("Name", this.formData.Name);
                    params.append("Description", this.formData.Description);
                    params.append("Fines", this.formData.Fines);
                     params.append("datescheduled", this.formData.datescheduled);

                    axios.post(address, params,)
                    .then(response => {
                        if(response.data.message=="success")
                        {
                            $('#loading').show();
                            alert('Form submitted successfully!');
                            $('#registrationModal').modal('hide');
                            $("#Name").prop('disabled', false);
                            $("#Description").prop('disabled', false);
                            $("#Fines").prop('disabled', false);
                            $("#submit_form_btn").prop('disabled', false);

                            //console.log(response);
                        }
                        else
                        {
                            $("#Name").prop('disabled', false);
                            $("#Description").prop('disabled', false);
                            $("#Fines").prop('disabled', false);
                            $("#submit_form_btn").prop('disabled', false);
                            
                            $("#error_content").html(response.data.message_details);
                            $(".messagebox").fadeIn("slow");
                            $('#registrationModal').animate({ scrollTop: 0 }, 'slow');
                            //console.log(response);
                        }
                    })
                    .catch(error => {
                        $('#loading').fadeOut("slow");
                         this.error_transaction.push("Something went wrong. Contact the administrator for the problem.");
                        $(".messagebox").fadeIn("slow");
                        alert("Something went wrong. Contact the administrator for the problem.");
                        $('html,body').animate({ scrollTop: 0 }, 'slow');
                        //console.log(error);
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