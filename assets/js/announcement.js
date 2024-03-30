  const app = Vue.createApp({
    data() {
      return {
        searchTerm: '',
        dataTable: null,
        loading: true,
        errors: {},
        error_transaction: [],
        formData: {
          Titlename: '',
          Description: '',
          sendannouncement: "",
        },
      };
    },
    methods: {
      loadDatatable() {
        if ($.fn.DataTable.isDataTable('#dataTable')) { // Destroy existing DataTable if it exists
          $('#dataTable').DataTable().destroy();
        }

        this.dataTable = $('#dataTable').DataTable({
          "processing": true,
          "serverSide": true,

          ajax: {
            url: base_url + 'announcement/search', // Replace with your server-side script
            dataSrc: '',
            type: "POST",
            data: function(d) {
              d.searchTerm = $("#search-input").val(); // Add the search term
            }
          },
          columns: [{
              data: null,
              render: function(data, type, row, meta) {
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
              title: 'User ID'
            },
            {
              data: 'Title',
              title: 'Title',
              render: function(data, type, row) {
                if (row.RecordDeleted === 'Record deleted') {
                  return '<span><del>' + data + '</del></span>';
                } else {
                  return '<input type="text" value="' + data + '" class="form-control TitleRow" />';
                }
              }
            },
            {
              data: 'Description',
              title: 'Description',
              render: function(data, type, row) {
                if (row.RecordDeleted === 'Record deleted') {
                  return '<span><del>' + data + '</del></span>';
                } else {
                  return '<input type="text" value="' + data + '" class="form-control DescriptionRow" />';
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
              render: function(data, type, row) {
                if (row.RecordDeleted === 'Record deleted') {
                  return '<button class="btn btn-sm btn-danger" disabled><i class="fa fa-trash"></i> Record deleted</button>';
                } else {
                  return '<button class="update-button btn btn-sm btn-warning d-none" data-user-id="' + row.EntryID + '"><i class="fa fa-edit"></i></button> <button class="delete-button btn btn-sm btn-danger" data-user-id="' + row.EntryID + '"><i class="fa fa-trash"></i></button>';
                }
              },
              title: 'Action'
            },
          ],
          columnDefs: [{
            targets: -1, // Target the last column (Action column)
            width: "10%", // Set the width to 10%
          },
          {
            targets: [1], // Target the UserID column
            visible: false, // Hide the UserID column
            width: "-10%", // Set the width to 10%
        },
          ]
        });

        // Watch for changes in searchTerm and update DataTable search
        this.$watch('searchTerm', (newValue) => {
          this.dataTable.search(newValue).draw();
        });
      },

      openRegistrationModal() {
        // Open the Bootstrap modal for registration
        $("#Titlename").prop('disabled', false);
        $("#Description").prop('disabled', false);
        $("#submit_form_btn").prop('disabled', false);
        $("#error_content").html('');
        $(".messagebox").hide("slow");

        $('#registrationModal').modal('show');
      },

      submitRegistrationForm() {
        this.errors = {};

        // Validation logic
        if (!this.formData.Titlename) {
          this.errors.Titlename = 'Title Name is required.';
        }

       

        // If there are no errors, submit the form (you can replace this with your actual form submission logic)
        if (Object.keys(this.errors).length === 0) {
          this.error_transaction = [];
          $(".messagebox").hide("slow");
          $('#loading').show();

          $("#submit_form_btn").prop('disabled', true);
          $("#Titlename").prop('disabled', true);
          $("#Description").prop('disabled', true);



          const address = base_url + "announcement/save";
          let params = new URLSearchParams();
          params.append("Titlename", this.formData.Titlename);
          params.append("Description", this.formData.Description);
          params.append("SendAnnouncement", this.formData.sendannouncement);

          axios.post(address, params,)
            .then(response => {
              if (response.data.message == "success") {
                $('#loading').hide();
                this.formData.Titlename = "";
                this.formData.Description = "";
                alert('Form submitted successfully!');
                $('#registrationModal').modal('hide');
                $("#Titlename").prop('disabled', false);
                $("#Description").prop('disabled', false);
                $("#submit_form_btn").prop('disabled', false);

                this.loadDatatable();
              } else {
                $('#loading').hide();
                $("#Titlename").prop('disabled', false);
                $("#Description").prop('disabled', false);
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
      },

      updateRow(userID, TitleRow, DescriptionRow) {
        const address = base_url + "announcement/update";
        let params = new URLSearchParams();

        params.append("TitleName", TitleRow);
        params.append("Description", DescriptionRow);
        params.append("userID", userID);

        return new Promise((resolve, reject) => {
          axios.post(address, params)
            .then(response => {
              if (response.data.message == "success") {
                //alert('Form submitted successfully!');
                resolve("success");
              } else {
                alert('Form not updated!');
                console.log(response);
                reject("error");
              }
            })
            .catch(error => {
              alert("Something went wrong. Contact the administrator for the problem.");
              console.log(error);
              reject("error");
            });
        });
      },
      deleteRow(userID)
      {
        $("#delete_loading_div").show();
        const address = base_url + "announcement/delete";

        let params = new URLSearchParams();       
        params.append("userID", userID);

        //return new Promise((resolve, reject) => {
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
        //});
      },
      tempdel(userID)
      {
        console.log(userID);
      }
    },
    mounted() {
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

      // Attach click event listener to the update buttons
      $('#dataTable').on('click', '.update-button', (event) => {
        // Get the clicked row data
        var rowData = this.dataTable.row($(event.target).closest('tr')).data();
        var $row = $(event.target).closest('tr');

        // Extract values from the row data
        var userID = rowData.EntryID;
        var TitleRow = $row.find('input.TitleRow').val();
        var DescriptionRow = $row.find('input.DescriptionRow').val();


        var email = $row.find('input[type="email"]').val();

       // console.log(userID)
        this.updateRow(userID, TitleRow, DescriptionRow)
          .then(res => {
            // Hide the update button after processing
            if (res == "success") {
              $(event.target).addClass('d-none');
            }
          })
          .catch(error => {
            // Handle error if needed
          });
      });

      // Event listener for input change
      $('#dataTable').on('change', 'input[type="text"], input[type="email"]', (event) => {
        const $row = $(event.target).closest('tr'); // Get the closest row to the changed input
        const $updateButton = $row.find('.update-button'); // Find the update button within the row

        // Show the update button if it's hidden
        if ($updateButton.hasClass('d-none')) {
          $updateButton.removeClass('d-none');
        }
      });

      $('.update-button').addClass('d-none');



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