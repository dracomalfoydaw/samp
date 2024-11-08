    const { createApp, onMounted } = Vue;

    //const app = Vue.createApp({});
    const app = createApp({});
    app.component('image-uploader', {
    template: `
        <div>
            <!-- Profile picture card-->
            <div class="card">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                     `+ image_var + `
                    <!-- Profile picture help block-->
                    <hr>
                    <!-- Profile picture upload button-->
                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#uploadModal">Upload new image</button>
                </div>
            </div>

            <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadModalLabel">Upload Image</h5>
                            <button type="button" :disabled="isUploading" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="drop-zone" @dragover.prevent="onDragOver" @dragleave.prevent="onDragLeave" @drop.prevent="onDrop" :class="{ 'dragover': isDragging }">
                                Drag and drop an image here or click to select <br> <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                                <input type="file" @change="onFileChange" ref="fileInput" hidden>
                            </div>
                            <button class="btn btn-secondary mt-3" :disabled="isUploading" @click="selectFile">Select Image</button>
                            <img v-if="imageUrl" :src="imageUrl" alt="Uploaded Image" class="img-fluid mt-3">
                            <div class="progress mt-3" v-if="progress > 0">
                                <div class="progress-bar" role="progressbar" :style="{ width: progress + '%' }" aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100">{{ progress }}%</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" :disabled="isUploading" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" :disabled="isUploading" @click="uploadImage">Upload</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `,
    data() {
        return {
            selectedFile: null,
            imageUrl: '',
            progress: 0,
            isDragging: false,
            isUploading: false
        };
    },

    methods: {
        onFileChange(event) {
            const file = event.target.files[0];
            if (file.size > 5 * 1024 * 1024) { // 5MB limit
                alert('File size exceeds 5MB');
                this.selectedFile = null;
                this.imageUrl = '';
                return;
            }
            this.selectedFile = file;
            this.imageUrl = URL.createObjectURL(this.selectedFile);
        },
        selectFile() {
            this.$refs.fileInput.click();
        },
        onDragOver() {
            this.isDragging = true;
        },
        onDragLeave() {
            this.isDragging = false;
        },
        onDrop(event) {
            const file = event.dataTransfer.files[0];
            if (file.size > 5 * 1024 * 1024) { // 5MB limit
                alert('File size exceeds 5MB');
                this.selectedFile = null;
                this.imageUrl = '';
                return;
            }
            this.selectedFile = file;
            this.imageUrl = URL.createObjectURL(this.selectedFile);
            this.isDragging = false;
        },
        uploadImage() {
            if (!this.selectedFile) {
                alert('Please select a file first.');
                return;
            }

            this.isUploading = true;

            const formData = new FormData();
            formData.append('file', this.selectedFile);
            formData.append('session_log', session_log);

            axios.post(base_url + 'profile/uploadImage', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                onUploadProgress: (progressEvent) => {
                    this.progress = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                }
            })
            .then(response => {
                if (response.data.success) {
                    alert('Image uploaded successfully!');
                    this.clearModal();
                    $('img.img-account-profile').attr('src', base_url + "uploads/users/" + response.data.file_name);
                    $('#uploadModal').modal('hide'); // Close the modal
                } else {
                    alert('Image upload failed: ' + response.data.error);
                }
                this.isUploading = false;
                this.progress = 0;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred during the upload.');
                this.isUploading = false;
                this.progress = 0;
            });
        },
        clearModal() {
            this.selectedFile = null;
            this.imageUrl = '';
            this.progress = 0;
        },
        closeModal() {
            if (!this.isUploading) {
                $('#uploadModal').modal('hide');
            }
        },
        resetModal() {
            this.clearModal();
            this.isUploading = false;
        }
    }
});



    app.component('account-details-card', {
      data() {
        return {
          form: {
            username: ini_username,
            firstname: ini_firstname,
            lastname: ini_lastname,
            middlename: ini_middlename,
            nameExtension: ini_nameextension,
            email: ini_emailaddress,
            session_log: session_log,
          },
          originalEmail: '',
          originalUsername: '',
          errors: {},
          showConfirmationCode: false,
          confirmationCode: '',
          isLoading: false,
          message: '',
          messageType: ''
        }
      },
      methods: {
        validateForm() {
          this.errors = {};
          this.message = '';
          this.showConfirmationCode = false;

          if (!this.form.username) {
            this.errors.username = 'Username is required.';
          }

          if (!this.form.firstname) {
            this.errors.firstname = 'First name is required.';
          }

          if (!this.form.lastname) {
            this.errors.lastname = 'Last name is required.';
          }

          const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
          if (!this.form.email) {
            this.errors.email = 'Email is required.';
          } else if (!emailPattern.test(this.form.email)) {
            this.errors.email = 'Invalid email address.';
          }

          if (Object.keys(this.errors).length === 0) {
            this.submitForm();
          }
        },
        backToForm() {
          this.showConfirmationCode = false;
        },
        submitForm() {
          this.isLoading = true;
          axios.post(base_url+'profile/save_info', this.form)
            .then(response => {
              this.isLoading = false;
              resultInfo = response.data;
              if (resultInfo.success) {
                this.setMessage('Form submitted successfully!', 'success');
              } else {
                if(resultInfo.error_code=="email_confirmation_code")
                {
                    this.showConfirmationCode = true;
                }
                else
                {
                    this.setMessage(response.data.message || 'Failed to submit form.', 'error');
                }
                
              }
            })
            .catch(error => {
              this.isLoading = false;
              this.setMessage('There was an error submitting the form.', 'error');
              console.error('There was an error!', error);
            });
        },
        submitConfirmationCode() {
          this.isLoading = true;
          axios.post(base_url+'profile/verify_confirmation_code', { email: this.form.email, code: this.confirmationCode, session_log: session_log })
            .then(response => {
            this.confirmationCode = "";
              this.isLoading = false;
              result = response.data;
              if (result.success) {
                //this.submitForm();
                this.showConfirmationCode = false;
                this.setMessage('Form submitted successfully!', 'success');
                email_status = "";

              } else {
                this.setMessage(result.message, 'error');
              }
            })
            .catch(error => {
              this.isLoading = false;
              this.setMessage('There was an error verifying the confirmation code.', 'error');
              this.messageType = 'error';
              console.error('There was an error!', error);
            });
        },
        setMessage(message, type) {
            this.message = message;
            this.messageType = type;
          
            if (this.messageTimer) {
                clearTimeout(this.messageTimer);
            }
              
            this.messageTimer = setTimeout(() => {
                this.message = '';
                this.messageType = '';
            }, 5000);
        },
        resendConfirmationCode() {
            this.isLoading = true;
          axios.post(base_url+'profile/resendConfirmationCode', { session_log: session_log })
            .then(response => {
            this.confirmationCode = "";
              this.isLoading = false;
              result = response.data;
              if (result.success) {
                //this.submitForm();
                this.showConfirmationCode = true;
                this.setMessage('Email Verification Code sent!', 'success');
                email_status = "";

              } else {
                this.setMessage(result.message, 'error');
              }
            })
            .catch(error => {
              this.isLoading = false;
              this.setMessage('There was an error verifying the confirmation code.', 'error');
              this.messageType = 'error';
              console.error('There was an error!', error);
            });
        }
      },
      mounted() {
        this.originalEmail = this.form.email; // Initialize the original email when component mounts
        this.originalUsername = this.form.username; // Initialize the original username when component mounts
        if(email_status=="reconfirm")
        {
            this.showConfirmationCodeonLoad=false;
            this.showConfirmationCode=true    ;
        }
        else
        {
            this.showConfirmationCodeonLoad=true;
        }
      },
      template: `
        <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
          <div v-if="message" :class="['message', messageType === 'success' ? 'success' : 'error']">
            {{ message }}
          </div>
          <div v-if="isLoading" class="progress mb-3">
            <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"></div>
          </div>
          <form @submit.prevent="validateForm" v-if="!showConfirmationCode && !isLoading">
            <div class="form-group">
              <label class="small mb-1" for="username">Username:</label>
              <input type="text" id="username" v-model="form.username" class="form-control" :disabled="isLoading">
              <div v-if="errors.username" class="error">{{ errors.username }}</div>
            </div>

            <div class="form-group">
              <label class="small mb-1" for="firstname">First Name:</label>
              <input type="text" id="firstname" v-model="form.firstname" class="form-control" :disabled="isLoading">
              <div v-if="errors.firstname" class="error">{{ errors.firstname }}</div>
            </div>
            <div class="form-group">
              <label for="middlename">Middle Name:</label>
              <input type="text" id="middlename" v-model="form.middlename" class="form-control" :disabled="isLoading">
            </div>

            <div class="form-group">
              <label class="small mb-1" for="lastname">Last Name:</label>
              <input type="text" id="lastname" v-model="form.lastname" class="form-control" :disabled="isLoading">
              <div v-if="errors.lastname" class="error">{{ errors.lastname }}</div>
            </div>

            

            <div class="form-group">
              <label class="small mb-1" for="nameExtension">Name Extension:</label>
              <input type="text" id="nameExtension" v-model="form.nameExtension" class="form-control" :disabled="isLoading">
            </div>

            <div class="form-group">
              <label class="small mb-1" for="email">Email:</label>
              <input type="email" id="email" v-model="form.email" class="form-control" :disabled="isLoading">
              <div v-if="errors.email" class="error">{{ errors.email }}</div>
            </div>

            <button type="submit" class="btn btn-primary" :disabled="isLoading">Submit</button>
          </form>

          <div v-if="showConfirmationCode" class="confirmation-code">
            <label for="confirmationCode">Enter Confirmation Code:</label>
            <input type="text" id="confirmationCode" v-model="confirmationCode" class="form-control" :disabled="isLoading">
            <button  v-if="showConfirmationCodeonLoad" class="btn btn-secondary mt-3" @click="backToForm" :disabled="isLoading">Back to Form</button>
            <button class="btn btn-primary mt-3" @click="submitConfirmationCode" :disabled="isLoading">Submit Confirmation Code</button>
            <button class="btn btn-secondary mt-3" @click="resendConfirmationCode" :disabled="isLoading">Resend Confirmation Code</button>
          </div>
         
        </div>
        </div>
      `
    });
    app.component('account-security-password-card', {
        data() {
            return {
                currentPassword: '',
                newPassword: '',
                confirmPassword: '',
                formErrors: {
                    currentPassword: '',
                    newPassword: '',
                    confirmPassword: '',
                    server: ''
                },
                successMessage: '',
                formValid: true,
                twoFactorEnabled: false,
                isLoading: false, // Add a loading state
                messageTimeout: null // Timeout for hiding messages
            };
        },
        methods: {
            validateForm() {
                this.formValid = true;
                // Reset error messages
                this.formErrors = {
                    currentPassword: '',
                    newPassword: '',
                    confirmPassword: '',
                    server: ''
                };
                this.successMessage = ''; // Reset success message

                // Validate current password
                if (!this.currentPassword) {
                    this.formErrors.currentPassword = 'Current password is required.';
                    this.formValid = false;
                }

                // Validate new password
                const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?])[A-Za-z\d!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{8,}$/;

                if (!this.newPassword) {
                    this.formErrors.newPassword = 'New password is required.';
                    this.formValid = false;
                } else if (!passwordPattern.test(this.newPassword)) {
                    this.formErrors.newPassword = 'Password must be at least 8 characters long, and include at least one uppercase letter, one lowercase letter, one number, and one special character.';
                    this.formValid = false;
                }

                // Validate confirm password
                if (!this.confirmPassword) {
                    this.formErrors.confirmPassword = 'Confirm password is required.';
                    this.formValid = false;
                } else if (this.newPassword !== this.confirmPassword) {
                    this.formErrors.confirmPassword = 'Passwords do not match.';
                    this.formValid = false;
                }

                return this.formValid;
            },
            submitForm() {
                if (this.validateForm()) {
                    this.isLoading = true; // Show the progress bar
                    // Make an API request to update the password
                    var formdata = new FormData();
                    formdata.append('session_log', session_log);
                    formdata.append('currentPassword',  this.currentPassword);
                    formdata.append('newPassword', this.newPassword);
                    var address = base_url + 'profile/update_password';
                    axios.post(address, formdata,)
                    .then(response => {
                        this.isLoading = false; // Hide the progress bar
                        console.log(response);
                        if (response.data.status === 'success') {
                            this.successMessage = 'Password updated successfully!';
                            // Clear the form
                            this.currentPassword = '';
                            this.newPassword = '';
                            this.confirmPassword = '';
                            this.hideMessageAfterDelay(); // Hide the message after a delay
                        } else {
                            this.formErrors.server = response.data.message;
                            this.hideMessageAfterDelay(); // Hide the message after a delay
                        }
                    })
                    .catch(error => {
                        this.isLoading = false; // Hide the progress bar
                        this.formErrors.server = 'An error occurred while updating the password.';
                        this.hideMessageAfterDelay(); // Hide the message after a delay
                    });
                }
            },
            toggleTwoFactorAuth(status) {

                var formdata = new FormData();
                formdata.append('session_log', session_log);
                formdata.append('twoFactorEnabled', status);
                var address = base_url + 'profile/toggle_two_factor';
                axios.post(address, formdata,)
                .then(response => {
                    this.isLoading = false; // Hide the progress bar
                    result = response.data;
                        if (result.status === 'success') {
                            this.successMessage = result.message;
                            this.twoFactorEnabled = status;
                            this.hideMessageAfterDelay(); // Hide the message after a delay
                        } else {
                            this.formErrors.server = result.message;
                            this.hideMessageAfterDelay(); // Hide the message after a delay
                        }
                })
                .catch(error => {
                    alert('An error occurred while updating Two-Factor Authentication status.');
                });
            },
            hideMessageAfterDelay() {
                clearTimeout(this.messageTimeout);
                this.messageTimeout = setTimeout(() => {
                    this.successMessage = '';
                    this.formErrors.server = '';
                }, 3000); // Hide message after 3 seconds
            }
        },
        mounted() {
             this.twoFactorEnabled =  authenticationStatus;
        },
        template: `
            <div class="col-lg-8">
                <!-- Change password card-->
                <div class="card mb-4">
                    <div class="card-header">Change Password</div>
                    <div class="card-body">
                        <form @submit.prevent="submitForm">                        
                            <div class="text-success mt-2">{{ successMessage }}</div>
                            <div class="text-danger mt-2">{{ formErrors.server }}</div>
                            <!-- Form Group (current password)-->
                            <div class="form-group">
                                <label class="small mb-1" for="currentPassword">Current Password</label>
                                <input v-model="currentPassword" :disabled="isLoading" class="form-control" id="currentPassword" type="password" placeholder="Enter current password" />
                                <div class="text-danger">{{ formErrors.currentPassword }}</div>
                            </div>
                            <!-- Form Group (new password)-->
                            <div class="form-group">
                                <label class="small mb-1" for="newPassword">New Password</label>
                                <input v-model="newPassword" :disabled="isLoading" class="form-control" id="newPassword" type="password" placeholder="Enter new password" />
                                <div class="text-danger">{{ formErrors.newPassword }}</div>
                            </div>
                            <!-- Form Group (confirm password)-->
                            <div class="form-group">
                                <label class="small mb-1" for="confirmPassword">Confirm Password</label>
                                <input v-model="confirmPassword" :disabled="isLoading" class="form-control" id="confirmPassword" type="password" placeholder="Confirm new password" />
                                <div class="text-danger">{{ formErrors.confirmPassword }}</div>
                            </div>
                            <button class="btn btn-primary" type="submit" :disabled="isLoading">Save</button>
                        </form>
                    </div>
                    <div v-if="isLoading" class="progress mt-2">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Two factor authentication card-->
                <div class="card mb-4">
                    <div class="card-header">Two-Factor Authentication</div>
                    <div class="card-body">
                        <p>Add another level of security to your account by enabling two-factor authentication. We will send you an email message to verify your login attempts on unrecognized devices and browsers.</p>
                        <form>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" id="twoFactorOn" type="radio" name="radioUsage" @click="toggleTwoFactorAuth(true)" :checked="twoFactorEnabled" />
                                    <label class="custom-control-label" for="twoFactorOn">On</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" id="twoFactorOff" type="radio" name="radioUsage" @click="toggleTwoFactorAuth(false)" :checked="!twoFactorEnabled" />
                                    <label class="custom-control-label" for="twoFactorOff">Off</label>
                                </div>
                            </div>
                        </form>
                        <div v-if="isLoading" class="progress mt-2">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            `,
    });

app.component('account-logs-card', {
  template: `
    <div class="datatable">
      <div class="row ">
        <div class="col-md-5">
         
        </div>
        <div class="col-md-3">            
            <div class="form-group has-feedback justify-content-center align-items-center" id="loading" style="display: none;">
                <div class="justify-content-center align-items-center">
                  <img src="./assets/imgs/loading.gif" alt="Loading" style="width:150px;height:150px;">
                </div>
            </div>
        </div>
        <div class="col-md-4">
         
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3">
          <input type="text" class="form-control" v-model="searchQuery" @keyup.enter="onSearch" placeholder="Search...">
        </div>
      </div>
      <table class="table table-bordered table-hover" id="example" width="100%" cellspacing="0"></table>

      <div class="row">
        <div class="col-md-6 d-flex align-items-center">
          <div class="row-per-page">
            <select class="form-control form-control-inline" id="rowsPerPage" v-model="rowsPerPage" @change="updateRowsPerPage">
              <option v-for="option in rowOptions" :key="option.value" :value="option.value">{{ option.text }}</option>
            </select>
          </div>
          <div class="sort-options ml-2">
            <select id="sortColumn" class="form-control form-control-inline" v-model="sortColumn" @change="updateSort">
              <option v-for="option in sortOptions" :key="option.value" :value="option.value">{{ option.text }}</option>
            </select>
            <select id="sortOrder" class="form-control form-control-inline ml-2" v-model="sortOrder" @change="updateSort">
              <option value="asc">Ascending</option>
              <option value="desc">Descending</option>
            </select>
          </div>
        </div>

        <div class="col-md-6">
          <div class="pagination-controls">
            <button class="btn btn-primary" @click="prevPage" :disabled="currentPage === 1">Previous</button>
            <span>Page {{ currentPage }} of many</span>
            <button class="btn btn-primary" @click="nextPage">Next</button>
          </div>
        </div>
      </div>
    </div>
  `,
  data() {
    return {
      table: null,
      currentPage: 1,
      searchQuery: '',
      rowsPerPage: 10, // Default rows per page
      sortColumn: '',
      sortOrder: 'desc', // Default sort order
      rowOptions: [
        { value: '10', text: '10' },
        { value: '25', text: '25' },
        { value: '50', text: '50' },
        { value: '100', text: '100' }
      ],
      sortOptions: [
        { value: '', text: 'Sort by' },
        { value: 'note', text: 'Details' },
        { value: 'logdate', text: 'Date Transacted' }
      ]
    };
  },
  methods: {
    fetchData(page, query = '', sortColumn = '', sortOrder = 'asc') {
      $.ajax({
        url: base_url + 'profile/logs',
        method: 'GET',
        data: {
          start: (page - 1) * this.rowsPerPage,
          limit: this.rowsPerPage,
          search: query,
          sortColumn: sortColumn,
          sortOrder: sortOrder,
          session_log: session_log,
        },
        beforeSend: () => {
          this.showLoading(true);
        },
        success: (data) => {
                if(data.session_log && data.success) {
                    this.table.clear();
                    this.table.rows.add(data.data); // Use data.data to add only the array of records
                    this.table.draw();
                } else {
                    alert('Session TimeOut. Reloading the Page');
                    location.reload(true);
                }
        },
        complete: () => {
          this.showLoading(false);
        },
      });
    },
    nextPage() {
      this.currentPage++;
      this.fetchData(this.currentPage, this.searchQuery, this.sortColumn, this.sortOrder);
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
        this.fetchData(this.currentPage, this.searchQuery, this.sortColumn, this.sortOrder);
      }
    },
    onSearch() {
      this.currentPage = 1;
      this.fetchData(this.currentPage, this.searchQuery, this.sortColumn, this.sortOrder);
    },
    updateRowsPerPage() {
      this.currentPage = 1;
      this.fetchData(this.currentPage, this.searchQuery, this.sortColumn, this.sortOrder);
    },
    updateSort() {
      this.currentPage = 1;
      this.fetchData(this.currentPage, this.searchQuery, this.sortColumn, this.sortOrder);
    },
    showLoading(show) {
      const loadingElement = document.getElementById('loading');
      if (loadingElement) {
        loadingElement.style.display = show ? 'block' : 'none';
      }
    }
  },
  mounted() {
    this.table = $('#example').DataTable({
      columns: [
        {
          data: null,
          render: function(data, type, row, meta) {
            return meta ? meta.row + 1 : ''; // Row number starts from 1
          },
          title: '#',
          orderable: false // Disable default sorting
        },
        {
          data: 'Details',
          title: 'Details',
          orderable: false // Disable default sorting
        },
        {
          data: 'LogDate',
          title: 'Date Transacted',
          orderable: false // Disable default sorting
        },
      ],
      paging: false,
      searching: false,
      info: false,
    });
    this.fetchData(this.currentPage);
  },
});






    app.mount('#app');