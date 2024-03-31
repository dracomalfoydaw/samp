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
                    createannoucement:'',
                    sendannouncement:'',
                    desccontribution: '',
                    amountofcontribution: '0.00',
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
                        {
                          data: 'EntryID',
                          title: '#'
                        },
                        { 
                            data: 'Name', title: 'Name' ,
                            render: function(data, type, row) {
                                if (row.RecordDeleted === 'Record deleted') {
                                  return '<span><del>' + data + '</del></span>';
                                } else {
                                  return data ;
                                }
                             }


                        },
                        { 
                            data: 'BalanceFee', title: 'BalanceFee',
                            render: function(data, type, row) {
                                if (row.RecordDeleted === 'Record deleted') {
                                  return '<span><del>' + data + '</del></span>';
                                } else {
                                  return data ;
                                }
                             }

                        },
                        { 
                            data: 'Description', title: 'Description' ,
                            render: function(data, type, row) {
                                if (row.RecordDeleted === 'Record deleted') {
                                  return '<span><del>' + data + '</del></span>';
                                } else {
                                  return data ;
                                }
                             }
                        },
                         {
                data: 'DateCreated',
                title: 'Date Created'
              },
              {
                data: 'DateUpdated',
                title: 'Date Updated'
              },
                        {
                          data: null,
                          render: (data, type, row) => {
                            if (row.RecordDeleted === 'Record deleted') {
                  return '<button class="btn btn-sm btn-danger" disabled><i class="fa fa-trash"></i> Record deleted</button>';
                } else {
                           /* return '<button class="update-button btn btn-sm btn-warning" data-user-id="' + row.EntryID + '"><i class="fa fa-edit"></i></button> <button class="delete-button btn btn-sm btn-danger" data-user-id="' + row.EntryID + '"><i class="fa fa-trash"></i></button>';*/
                             return ' <button class="delete-button btn btn-sm btn-danger" data-user-id="' + row.EntryID + '"><i class="fa fa-trash"></i></button>';
                          }
                          },title: 'Action'
                        },
                    ],
                     columnDefs: [{
            targets: [1], // Target the UserID column
            visible: false // Hide the UserID column
        },{
            targets: -1, // Target the last column (Action column)
            width: "15%", // Set the width to 10%
          }]
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
                    params.append("createannoucement", this.formData.createannoucement);
                    params.append("sendannouncement", this.formData.sendannouncement);
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
                            this.reloaddata();
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
            reloaddata()
            {
                if ($.fn.DataTable.isDataTable('#dataTable')) { // Destroy existing DataTable if it exists
                    $('#dataTable').DataTable().destroy();
                }

                
                this.formData.createannoucement ='';
                this.formData.desccontribution= '';
                this.formData.amountofcontribution= '0.00';
                this.formData.applyrecord =  [];
                this.loadDatatable();
            },
            deleteRow(userID)
            {
                $("#delete_loading_div").show();
                const address = base_url + "contribution/delete";

                let params = new URLSearchParams();       
                params.append("userID", userID);

                  return new Promise((resolve, reject) => {
                    axios.post(address, params)
                    .then(response => {
                      if (response.data.message == "success") {
                        $("#delete_loading_div").hide();
                        $('#deleteConfirmationModal').modal('hide');
                      } else {
                        alert('Form not updated!');
                        console.log(response);
                        $('#deleteConfirmationModal').modal('hide');
                      }
                    })
                    .catch(error => {
                      alert("Something went wrong. Contact the administrator for the problem.");
                      $('#deleteConfirmationModal').modal('hide');
                      console.log(error);
                    });
                });
            },

        },
        mounted(){
            this.loadDatatable();
            $('#dataTable').on('click', '.delete-button', function() {
                var $row = $(this).closest('tr');
                $("#delete_loading_div").hide();
                    // Show confirmation modal
                $('#deleteConfirmationModal').modal('show');

                    // Save the row and delete button information to use after confirmation
                $('#deleteConfirmationModal').data('row', $row);
                $('#deleteConfirmationModal').data('deleteButton', $(this));
            });
                // Handle cancel button in the confirmation modal
            $('#cancelDeleteButton').on('click', function() {
                    // Hide confirmation modal
                $('#deleteConfirmationModal').modal('hide');
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

            // Store a reference to the Vue component
            const app = this;

                  // Handle delete confirmation
            $('#confirmDeleteButton').on('click', function() {
                var $row = $('#deleteConfirmationModal').data('row');
                var $deleteButton = $('#deleteConfirmationModal').data('deleteButton');

                      // Log data-user-id attribute of the delete button
                var userId = $deleteButton.data('user-id');



                      // Convert input elements to plain text
                $row.find('input').each(function() {
                  $(this).replaceWith('<span>' + $(this).val() + '</span>');
                });

                      // Apply strike-through
                $row.find('td').addClass('strike-through');

                      // Change delete button to disabled button with caption "Record deleted"
                $deleteButton.replaceWith('<button class="btn btn-sm btn-danger" disabled><i class="fa fa-trash"></i> Record deleted</button>');

                      // Call deleteRow method of the Vue component
                app.deleteRow(userId);
            });
        }
    });

    app.mount('#app');