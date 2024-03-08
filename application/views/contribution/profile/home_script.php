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

                    desccontribution: '',
                    amountofcontribution: '',
                    amountofcontribution: '',
                    applyrecord: [],
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
                        url: base_url+'contribution/search', // Replace with your server-side script
                        dataSrc: '',
                        type: "POST",
                        data: function (d) {
                            d.searchTerm = $("#search-input").val(); // Add the search term
                        }
                    },
                    columns: [                  
                       
                        { data: 'Name', title: 'Name' },
                        { data: 'BalanceFee', title: 'BalanceFee' },
                        { data: 'Description', title: 'Description' },
                        {
                          data: null,
                          render: (data, type, row) => {
                            
                            return '<button class="update-button btn btn-sm btn-warning" data-user-id="' + row.EntryID + '"><i class="fa fa-edit"></i></button> <button class="delete-button btn btn-sm btn-danger" data-user-id="' + row.EntryID + '"><i class="fa fa-trash"></i></button>';
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
                $("#contributionname").prop('disabled', false);
                $("#amountofcontribution").prop('disabled', false);
                $("#desccontribution").prop('disabled', false);
               // $("#submit_form_btn").prop('disabled', false);

                $('#registrationModal').modal('show');
            },
            submitRegistrationForm() {
                this.errors = {};

                // Validation logic
                if (!this.formData.contributionname) {
                  this.errors.contributionname = 'Contribution Name is required.';
                }

               

                if (!this.formData.amountofcontribution) {
                  this.errors.amountofcontribution = 'Amount of Contribution is required.';
                }
                else
                {
                    const value = this.formData.amountofcontribution;
                    // Regular expression to check for a valid number with two decimal places
                    const regex = /^\d+(\.\d{1,2})?$/;

                    if (!regex.test(value)) {
                        this.errors.amountofcontribution = 'Please enter a valid number with up to two decimal places.';
                    }
                }
           

                // Add additional validation logic for other fields as needed

              

                // If there are no errors, submit the form (you can replace this with your actual form submission logic)
                if (Object.keys(this.errors).length === 0) {
                    this.error_transaction = [];
                    $(".messagebox").hide("slow");
                    $('#loading').show();

                    $("#contributionname").prop('disabled', true);
                    $("#amountofcontribution").prop('disabled', true);
                    $("#desccontribution").prop('disabled', true);
                    $("#submit_form_btn").prop('disabled', true);

                    const address = base_url+"contribution/save";
                    let params = new URLSearchParams();
                    params.append("applyrecord", this.formData.applyrecord);
                    params.append("contributionname", this.formData.contributionname);
                    params.append("amountofcontribution", this.formData.amountofcontribution);
                    params.append("desccontribution", this.formData.desccontribution); 

                    axios.post(address, params,)
                    .then(response => {
                        $('#loading').fadeOut("slow");
                        if(response.data.message=="success")
                        {
                            alert('Form submitted successfully!');
                            $('#registrationModal').modal('hide');
                            $("#contributionname").prop('disabled', false);
                            $("#amountofcontribution").prop('disabled', false);
                            $("#desccontribution").prop('disabled', false);
                            $("#submit_form_btn").prop('disabled', false);

                            console.log(response);
                        }
                        else
                        {
                            $("#contributionname").prop('disabled', false);
                            $("#amountofcontribution").prop('disabled', false);
                            $("#desccontribution").prop('disabled', false);
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
            /*validateAmount() {
                const value = this.formData.amountofcontribution;

                  // Regular expression to check for a valid number with two decimal places
                const regex = /^\d+(\.\d{1,2})?$/;

                if (!regex.test(value)) {
                    this.errors.amountofcontribution = 'Please enter a valid number with up to two decimal places.';
                } else {
                    this.errors.amountofcontribution = null;
                }
            }*/

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