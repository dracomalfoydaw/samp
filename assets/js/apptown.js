

  const app = Vue.createApp({
    data() {
      return {
        searchTerm: '',
        dataTable: null,
        loading: true,
        errors: {},
        options: {
      'Superadmin': 'Superadmin',
      'Admin': 'Admin',
      'User': 'User',
      'Cashier': 'Cashier',
      'Encoder': 'Encoder',
      'Accounting': 'Accounting'
    },
        error_transaction: [],
        formData: {
          group: '',
          firstName: '',
          middleName: '',
          lastName: '',
          nameExtension: '',
          username: '',
          email: '',
          idnumber: '',
          password: '',
          confirmPassword: '',
          defaultuseraccount: [],
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
            url: base_url + 'account/search', // Replace with your server-side script
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
              data: 'UserID',
              title: 'User ID'
            },
            {
              data: 'UserName',
              title: 'User Name',
              render: function(data, type, row) {
                if (row.RecordDeleted === 'Record deleted') {
                  return '<span><del>' + data + '</del></span>';
                } else {
                  return '<input type="text" value="' + data + '" class="form-control UserNameRow" required  />';
                }
              }
            },
            {
          data: 'GroupID',
          title: 'GroupName',
          render: (data, type, row) => {
            // Create select element
            var select = '<select class="form-control GroupDataRow">';
            
            // Populate options from Vue.js data
            for (var value in this.options) {
              var selected = data == value ? 'selected' : '';
              select += '<option value="' + value + '" ' + selected + '>' + this.options[value] + '</option>';
            }

            // Close select element
            select += '</select>';
            
            return select;
          }
        },
          {
            data: 'LastName',
            title: 'Last Name',
            render: function(data, type, row) {
              if (row.RecordDeleted === 'Record deleted') {
                return '<span><del>' + data + '</del></span>';
              } else {
                return '<input type="text" value="' + data + '" class="form-control LastNameRow" required  />';
              }
            }
          },
          {
            data: 'FirstName',
            title: 'First Name',
            render: function(data, type, row) {
              if (row.RecordDeleted === 'Record deleted') {
                return '<span><del>' + data + '</del></span>';
              } else {
                return '<input type="text" value="' + data + '" class="form-control FirstNameRow" required  />';
              }
            }
          },
          {
            data: 'MiddleName',
            title: 'Middle Name',
            render: function(data, type, row) {
              if (row.RecordDeleted === 'Record deleted') {
                return '<span><del>' + data + '</del></span>';
              } else {
                return '<input type="text" value="' + data + '" class="form-control MiddleNameRow" />';
              }
            }
          },

          {
            data: 'email',
            title: 'Email address',
            render: function(data, type, row) {
              if (row.RecordDeleted === 'Record deleted') {
                return '<span><del>' + data + '</del></span>';
              } else {
                return '<input type="email" value="' + data + '" class="form-control" />';
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
            data: 'AccountLock',
            title: 'Account Status',
            render: function(data, type, row) {
               if (row.RecordDeleted === 'Record deleted') {
                return '<span><del>' + data + '</del></span>';
               } else {
                if (row.AccountLock === 'Account Lock') {
                  return '<span class="btn btn-sm  btn-danger accountstatus">' + data + '</span>';
                }
                else
                {
                  return '';
                }
               }
            }
          },
          {
            data: null,
            render: function(data, type, row) {
              if (row.RecordDeleted === 'Record deleted') {
                return '<button class="btn btn-sm btn-danger" disabled><i class="fa fa-trash"></i> Record deleted</button>';
              } else {
                return '<button class="update-button btn btn-sm btn-warning d-none" data-user-id="' + row.UserID + '"><i class="fa fa-edit"></i></button> <button data-user-id="' + row.UserID + '" class="reset-button btn btn-sm btn-warning" ><i class="fa fa-unlock"></i></button> <button data-user-id="' + row.UserID + '" class="change-pass-button btn btn-sm btn-warning" ><i class="fa fa-sync-alt "></i></button> <button class="delete-button btn btn-sm btn-danger" data-user-id="' + row.UserID + '"><i class="fa fa-trash"></i></button>';
              }
            },
            title: 'Action'
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
isPasswordValid() {
  // Regular expression to match special characters
  const specialCharactersRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;

  // Check if password contains special characters and has a length of at least 8 characters
  return specialCharactersRegex.test(this.formData.password) && this.formData.password.length >= 8;
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

  if (!this.formData.username) {
    this.errors.username = 'Username is required.';
  }
  if (!this.formData.password) {
    this.errors.password = 'Password  is required.';
  }
  else
  {
    if(this.formData.password !== this.formData.confirmPassword)
    {
      this.errors.password = 'Passwords do not match';
    }
    else
    {
      if (!this.isPasswordValid()) {
        // Password is not valid, display error
        this.errors.password = 'Password must contain special characters and be at least 8 characters long.';
        return; // Stop form submission
      }
    }
  }

        // Add additional validation logic for other fields as needed

  if (!this.formData.email) {
    this.errors.email = 'Email is required.';
  } else if (!this.isValidEmail(this.formData.email)) {
    this.errors.email = 'Invalid email format.';
  }


  if (!this.formData.group) {
    this.errors.group = 'Group Access is Required';
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
    $("#username").prop('disabled', true);
    $("#email").prop('disabled', true);
    $("#idnumber").prop('disabled', true);
    $("#group").prop('disabled', true);
    $(".passwordinput").prop('disabled', true);


    const address = base_url + "account/save";
    let params = new URLSearchParams();
    params.append("group", this.formData.group);
    params.append("firstName", this.formData.firstName);
    params.append("middleName", this.formData.middleName);
    params.append("lastName", this.formData.lastName);
    params.append("username", this.formData.username);
    params.append("email", this.formData.email);
    params.append("idnumber", this.formData.idnumber);
    params.append("password", this.formData.password);
    params.append("confirmPassword", this.formData.confirmPassword);

    axios.post(address, params,)
    .then(response => {
      if (response.data.message == "success") {
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
        $("#group").prop('disabled', false);
        $(".passwordinput").prop('disabled', false);

        this.loadDatatable();
      } else {
        $("#firstName").prop('disabled', false);
        $("#middleName").prop('disabled', false);
        $("#lastName").prop('disabled', false);
        $("#nameExtension").prop('disabled', false);
        $("#username").prop('disabled', false);
        $("#email").prop('disabled', false);
        $("#idnumber").prop('disabled', false);
        $("#submit_form_btn").prop('disabled', false);
        $("#group").prop('disabled', false);
        $(".passwordinput").prop('disabled', false);

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

updateRow(userID, lastName, firstName, middleName, nameExtension, email,groupID) {
  const address = base_url + "account/update";
  let params = new URLSearchParams();

  params.append("firstName", firstName);
  params.append("middleName", middleName);
  params.append("lastName", lastName);
  params.append("nameextension", nameExtension);
  params.append("email", email);
  params.append("userID", userID);
  params.append("groupID", groupID);

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
  const address = base_url + "account/delete";

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
updateRow(userID) {
  const address = base_url + "account/unlock";
  let params = new URLSearchParams();       
  params.append("userID", userID);

  return new Promise((resolve, reject) => {
    axios.post(address, params)
    .then(response => {
      if (response.data.message == "success") {
         resolve("success");
      } else {
         resolve("error");
      }
    })
    .catch(error => {
      resolve("error");
    });
  });
},

generatePassword(userID, randomPass) {
  const address = base_url + "account/resetpass";
  let params = new URLSearchParams();   
 
  params.append("userID", userID);
  params.append("password", randomPass); // Corrected typo here

  return new Promise((resolve, reject) => {
    axios.post(address, params)
    .then(response => {
      if (response.data.message == "success") {
         resolve("success");
      } else {
         resolve("error");
      }
    })
    .catch(error => {
      reject(error); // Reject with error
    });
  });
},
generateRandomPassword(length) {
  const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  let password = "";
  for (let i = 0; i < length; i++) {
    const randomIndex = Math.floor(Math.random() * charset.length);
    password += charset[randomIndex];
  }
  return password;
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
$('#dataTable').on('click', '.reset-button', async (event) => {
  var rowData = this.dataTable.row($(event.target).closest('tr')).data();
  var userID = rowData.UserID;

  var $button = $(this); // Reference to the clicked button
  $button.prop('disabled', true); // Disable the button


  try {
    const status = await this.updateRow(userID);

    // Check if the status is success
    if (status === "success") {
      // Remove .accountstatus only from the same row
      $(event.target).closest('tr').find('.accountstatus').remove();
      //$button.prop('disabled', false); // Enable the button
      $button.remove(); // Remove the button from the DOM
    }

  } catch (error) {
    console.error(error); // Log any errors
    $button.prop('disabled', false); // Enable the button
  }
});


$('#dataTable').on('click', '.change-pass-button', async (event) => {
  var rowData = this.dataTable.row($(event.target).closest('tr')).data();
  var userID = rowData.UserID;

  var $button = $(this); // Reference to the clicked button
  $button.prop('disabled', true); // Disable the button


  try {
    const randomPass = this.generateRandomPassword(10); // Assuming you have this function
    const status = await this.generatePassword(userID,randomPass);

    // Check if the status is success
    console.log(status);
    if (status === "success") {
      // Remove .accountstatus only from the same row
      $(event.target).closest('tr').find('.accountstatus').remove();
      $button.prop('disabled', false); // Enable the button
      alert("Password generated successfully. New password: " + randomPass);
    }

  } catch (error) {
    console.error(error); // Log any errors
    $button.prop('disabled', false); // Enable the button
  }
});





      // Attach click event listener to the update buttons
  $('#dataTable').on('click', '.update-button', (event) => {
        // Get the clicked row data
    var rowData = this.dataTable.row($(event.target).closest('tr')).data();
    var $row = $(event.target).closest('tr');

        // Extract values from the row data
    var userID = rowData.UserID;
    var lastName = $row.find('input.LastNameRow').val();
    var firstName = $row.find('input.FirstNameRow').val();
    var middleName = $row.find('input.MiddleNameRow').val();
    var nameExtension = $row.find('input.NameExtensionRow').val();

    var groupID = $row.find('select.GroupDataRow').val();

    var email = $row.find('input[type="email"]').val();

   
    this.updateRow(userID, lastName, firstName, middleName, nameExtension, email,groupID)
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
  $('#dataTable').on('change', 'input[type="text"], input[type="email"], select.GroupDataRow', (event) => {
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

