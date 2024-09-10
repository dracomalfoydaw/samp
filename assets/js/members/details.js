 const { createApp, onMounted } = Vue;

    //const app = Vue.createApp({});
    const app = createApp({});
    
app.component('image-uploader', {
    template: `
        <div>
            <div class="card">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    `+ image_var + `
                    <hr>
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
                            <button type="button" :disabled="isUploading" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" :disabled="isUploading" class="btn btn-primary" @click="uploadImage">Upload</button>
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
            ini_username: ini_username,
            isUploading: false,
        };
    },
    methods: {
        onFileChange(event) {
            const file = event.target.files[0];
            if (file.size > 5 * 1024 * 1024) {
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
            if (file.size > 5 * 1024 * 1024) {
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
            formData.append('ini_username', this.ini_username);
            formData.append('session_log', session_log);

            axios.post(base_url + 'members/uploadImage', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                onUploadProgress: (progressEvent) => {
                    this.progress = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                }
            })
            .then(response => {
                console.log(response);
                if (response.data.success) {
                    alert('Image uploaded successfully!');
                    this.clearModal();
                    $('img.img-account-profile').attr('src', base_url + "uploads/users/" + response.data.file_name);
                    $('#uploadModal').modal('hide');
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
        ProfileStatus: ini_ProfileStatus,  // Correctly initialize ProfileStatus
      },
      session_log: session_log,
      errors: {},
      isLoading: false,
      isActive: false,
      message: '',
      messageType: ''
    };
  },
  methods: {
    validateForm() {
      this.errors = {};
      this.message = '';

      // Debugging: Log the ProfileStatus value

      if (!this.form.ProfileStatus) {
        this.errors.ProfileStatus = 'Profile Status is required.';
      }
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
    submitForm() {
      this.isLoading = true;
        $(".messagebox").fadeOut("slow");
        $(".messagebox_error").fadeOut("slow");
      try {
        var formdata = new FormData();
        formdata.append('ProfileStatus', this.form.ProfileStatus);
        formdata.append('session_log', this.session_log);
        formdata.append('FirstName', this.form.firstname);
        formdata.append('LastName', this.form.lastname);
        formdata.append('MiddleName', this.form.middlename|| '');
        formdata.append('nameExtension', this.form.nameExtension|| '');
        formdata.append('ProfileID', this.form.username);
        formdata.append('email', this.form.email);

        axios.post(base_url + 'members/update', formdata)
          .then(response_server => {
            const response = response_server.data;
            if (response.session_log && response.success) {
               $(".messagebox").fadeOut("slow");
               this.setMessage('Form submitted successfully!', 'success');
            }
            else
            {
              $("#error_content").html(response.message_details);
                $(".messagebox").fadeIn("slow");
            }
            this.isLoading = false;
        })
        .catch(error => {
            $(".messagebox_error").fadeIn("slow");
            this.isLoading = false;
          });
      } catch (error) {
        this.setMessage('There was an error submitting the form.', 'error');
        console.error('There was an error!', error);
        this.isLoading = false;
      }
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
    }
  },
  template: `

    <div class="card mb-4">
      <div class="card-header">Personal Information Details</div>
      <div class="card-body">
        <div v-if="message" :class="['message', messageType === 'success' ? 'success' : 'error']">
          {{ message }}
        </div>
        <br>
        <div class="modal-body messagebox_error" style="display: none;">
            <div class="alert alert-danger "  role="alert">
              <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
              <span class="sr-only">Error:</span>
              <a style="color:black;"id="message_error" disabled >
                <b>You have following error(s):</b> 
                <p>Something went wrong. Contact the administrator for the problem.</p>
              </a>
            </div> 
        </div> 
        <div class="modal-body messagebox" style="display: none;">
            <div class="alert alert-danger "  role="alert">
              <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
              <span class="sr-only">Error:</span>
              <a style="color:black;"id="message_error" disabled >
                <b>You have following error(s):</b> 
                <ul id="error_content">
                   
                </ul>
              </a>
            </div> 
        </div> 
        <div v-if="isLoading" class="progress mb-3">
          <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"></div>
        </div>
        <form @submit.prevent="validateForm" v-if="!isLoading">
          <div class="form-group">
            <label class="small mb-1" for="ProfileStatus">Profile Status:</label>
            <div class="col-md-12">
              <span class="form-control">
                <label><input :disabled="isLoading" type="radio" name="ProfileStatus" value="Active" v-model="form.ProfileStatus"> Active</label> &nbsp;
                <label><input :disabled="isLoading" type="radio" name="ProfileStatus" value="Inactive" v-model="form.ProfileStatus"> Inactive</label>
              </span>
            </div>
            <div v-if="errors.ProfileStatus" class="error">{{ errors.ProfileStatus }}</div>
          </div>

          <div class="form-group">
            <label class="small mb-1" for="username">AccountID:</label>
            <input type="text" id="username" disabled v-model="form.username" class="form-control">
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
      </div>
    </div>
  `
});




app.component('account-address-card', {
    data() {
        return {
            newForm: {
                homeaddress:ini_HomePurok,
                Province:ini_HomeBaranggay,
                Municipality:ini_HomeMuncity,
                Barangay:ini_HomeProvince,
                zipcode:ini_zipcode,
                Country:ini_Country,

                sex:ini_Sex,
                dateofbirth:ini_DateofBirth,
                placeofbirth:ini_PlaceofBirth,
                bloodtype:ini_Bloodtype,

                contactno:ini_ContactNumber,
                faxno:ini_FaxNumber,
                homeno:ini_HomeNumber,
                officeno:ini_OfficeNumber,

                Occupation:ini_Occupation,
                Education:ini_Education,
                Employment:ini_Employment,
                EmploymentAddress:ini_EmploymentAddress,

                familykin:ini_familykin,
                familyrelation:ini_familyrelation,
                familyaddress:ini_familyaddress,
                familynokids:ini_familynokids,
                familykidsname:ini_familykidsname,
            },
            errorsForms : {},   
            isSubmit: false,
            username: ini_username,
            session_log: session_log,
        };
    },
    methods: {
        confirmSubmit(){
            if (!this.newForm.homeaddress) {
                this.errorsForms.homeaddress = 'Home Address is required.';
            }
            if (!this.newForm.Province) {
                this.errorsForms.Province = 'Province Name is required.';
            }
            if (!this.newForm.Municipality) {
                this.errorsForms.Municipality = 'Municipality Name is required.';
            }
            if (!this.newForm.Barangay) {
                this.errorsForms.Barangay = 'Barangay Name is required.';
            }
            if (!this.newForm.zipcode) {
                this.errorsForms.zipcode = 'ZipCode is required.';
            }
            try {   
            if (Object.keys(this.errorsForms).length === 0) {
                this.isSubmit = true;
                var formdata = new FormData();
                formdata.append('ProfileID', this.username);
                formdata.append('session_log', this.session_log);
                formdata.append('homeaddress', this.newForm.homeaddress);
                formdata.append('Province', this.newForm.Province);
                formdata.append('Municipality', this.newForm.Municipality);
                formdata.append('Barangay', this.newForm.Barangay);
                formdata.append('ZipCode', this.newForm.zipcode);

                formdata.append('sex', this.newForm.sex);
                formdata.append('dateofbirth', this.newForm.dateofbirth);
                formdata.append('placeofbirth', this.newForm.placeofbirth);
                formdata.append('bloodtype', this.newForm.bloodtype);

                formdata.append('Country', this.newForm.Country);

                formdata.append('contactno', this.newForm.contactno);
                formdata.append('faxno', this.newForm.faxno);
                formdata.append('homeno', this.newForm.homeno);
                formdata.append('officeno', this.newForm.officeno);

                formdata.append('Occupation', this.newForm.Occupation);
                formdata.append('Education', this.newForm.Education);
                formdata.append('Employment', this.newForm.Employment);
                formdata.append('EmploymentAddress', this.newForm.EmploymentAddress);

                formdata.append('familykin', this.newForm.familykin);
                formdata.append('familyrelation', this.newForm.familyrelation);
                formdata.append('familyaddress', this.newForm.familyaddress);
                formdata.append('familynokids', this.newForm.familynokids);
                formdata.append('familykidsname', this.newForm.familykidsname);

                var address = base_url + 'members/updateinfo';
                axios.post(address, formdata,)
                .then(response_server => {
                  const response = response_server.data;
                  console.log(response);
                  if (response.session_log && response.success) {
                    alert("success");
                  }
                  else if(response.session_log && response.success == false)
                  {
                    $("#error_content").html(response.message_details);
                    $(".messagebox").fadeIn("slow");
                  }
                  else
                  {
                    alert('Session TimeOut. Reloading the Page');
                    location.reload(true);
                  }
                  this.isSubmit = false;
                })
                .catch(error => {
                  $(".messagebox_error").fadeIn("slow");
                  this.isSubmit = false;
                });
              }
          } catch (error) {
            console.error('Error of fetching data:', error);
            alert('An error occurred while fetching the record.');
          }
        },
    },
     template: `
    <form @submit.prevent="confirmSubmit">
    <div class="card mt-4">                        
            <div class="card-header"></div>
            <div class="card-body">
                
                    <div class="mb-3">
                      <div class ="row">
                        <div class="col-md-3">
                          <label for="sex" class="form-label">Sex</label>
                          <select class="form-control required" id="sex" name="sex" v-model="newForm.sex">
                              <option value="M">Male</option>
                              <option value="F">Female</option>
                          </select>
                          <span v-if="errorsForms.sex" style="color: red;">{{ errorsForms.sex }}</span>
                        </div>
                        <div class="col-md-3">
                          <label for="dateofbirth" class="form-label">Date of Birth</label>
                          <input :disabled="isSubmit" type="date" class="form-control" id="dateofbirth" name="dateofbirth" v-model="newForm.dateofbirth" >
                          <span v-if="errorsForms.dateofbirth" style="color: red;">{{ errorsForms.dateofbirth }}</span>
                        </div>
                        <div class="col-md-3">
                          <label for="placeofbirth" class="form-label">Place of Birth</label>
                          <input :disabled="isSubmit" type="text" class="form-control" id="placeofbirth" name="placeofbirth" v-model="newForm.placeofbirth" required>
                          <span v-if="errorsForms.placeofbirth" style="color: red;">{{ errorsForms.placeofbirth }}</span>
                        </div>
                        <div class="col-md-3">
                          <label for="bloodtype" class="form-label">Blood Type</label>
                          <input :disabled="isSubmit" type="text" class="form-control" id="bloodtype" name="bloodtype" v-model="newForm.bloodtype" >
                          <span v-if="errorsForms.bloodtype" style="color: red;">{{ errorsForms.bloodtype }}</span>
                        </div>
                      </div>
                    </div>
                   <div class="mb-3">
                      <div class ="row">
                        <div class="col-md-3">                      
                          <label for="Occupation" class="form-label">Occupation</label>
                          <input :disabled="isSubmit" type="text" class="form-control" id="Occupation" name="Occupation" v-model="newForm.Occupation" required>
                          <span v-if="errorsForms.Occupation" style="color: red;">{{ errorsForms.Occupation }}</span>
                        </div>

                        <div class="col-md-3">                      
                          <label for="Education" class="form-label">Education</label>
                          <input :disabled="isSubmit" type="text" class="form-control" id="Education" name="Education" v-model="newForm.Education" required>
                          <span v-if="errorsForms.Education" style="color: red;">{{ errorsForms.Education }}</span>
                        </div>


                        <div class="col-md-3">                      
                          <label for="Employment" class="form-label">Employment</label>
                          <input :disabled="isSubmit" type="text" class="form-control" id="Employment" name="Employment" v-model="newForm.Employment" required>
                          <span v-if="errorsForms.Employment" style="color: red;">{{ errorsForms.Employment }}</span>
                        </div>


                        <div class="col-md-3">                      
                          <label for="EmploymentAddress" class="form-label">Address</label>
                          <input :disabled="isSubmit" type="text" class="form-control" id="EmploymentAddress" name="EmploymentAddress" v-model="newForm.EmploymentAddress" required>
                          <span v-if="errorsForms.EmploymentAddress" style="color: red;">{{ errorsForms.EmploymentAddress }}</span>
                        </div>
                      </div>
                    </div>
                
            </div>
        
    </div>

    <div class="card mt-4">
                        
                            <div class="card-header">Home Address</div>
                            <div class="card-body">
                                
                                    <div class="mb-3">
                                      <div class ="row">
                                        <div class="col-md-6">
                                          <label for="homeaddress" class=" control-label text-left"> Home Address</label>
                                          <input :disabled="isSubmit" type="text" class="form-control" id="homeaddress" name="homeaddress" v-model="newForm.homeaddress" >
                                          <span v-if="errorsForms.homeaddress" style="color: red;">{{ errorsForms.homeaddress }}</span>
                                        </div>
                                        <div class="col-md-6">
                                          <label for="Country" class=" control-label text-left"> Country</label>
                                          <input :disabled="isSubmit" type="text" class="form-control" id="Country" name="Country" v-model="newForm.Country" >
                                          <span v-if="errorsForms.Country" style="color: red;">{{ errorsForms.Country }}</span>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="mb-3">
                                      <div class ="row">
                                        <div class="col-md-3">
                                          <label for="Province" class=" control-label text-left"> Province </label>
                                          <input :disabled="isSubmit" type="text" class="form-control" id="Province" name="Province" v-model="newForm.Province" >
                                          <span v-if="errorsForms.Province" style="color: red;">{{ errorsForms.Province }}</span>
                                        </div>
                                        <div class="col-md-3">
                                          <label for="Municipality" class=" control-label text-left"> Municipality/City </label>
                                          <input :disabled="isSubmit" type="text" class="form-control" id="Municipality" name="Province" v-model="newForm.Municipality" >                 
                                          <span v-if="errorsForms.Municipality" style="color: red;">{{ errorsForms.Municipality }}</span>
                                        </div>
                                        <div class="col-md-3">
                                          <label for="Barangay" class=" control-label  text-left"> Barangay </label>
                                          <input :disabled="isSubmit" type="text" class="form-control" id="Barangay" name="Barangay" v-model="newForm.Barangay" >                    
                                          <span v-if="errorsForms.Barangay" style="color: red;">{{ errorsForms.Barangay }}</span>
                                        </div>
                                        <div class="col-md-3">
                                          <label for="zipcode" class="form-label">ZipCode</label>
                                          <input :disabled="isSubmit" type="text" class="form-control" id="zipcode" name="zipcode" v-model="newForm.zipcode" >
                                          <span v-if="errorsForms.zipcode" style="color: red;">{{ errorsForms.zipcode }}</span>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="mb-3">
                                      <div class ="row">
                                        <div class="col-md-3">                      
                                          <label for="contactno" class="form-label">Contact No</label>
                                          <input :disabled="isSubmit" type="text" class="form-control" id="contactno" name="contactno" v-model="newForm.contactno" required>
                                          <span v-if="errorsForms.contactno" style="color: red;">{{ errorsForms.contactno }}</span>
                                        </div>

                                        <div class="col-md-3">                      
                                          <label for="faxno" class="form-label">Fax No</label>
                                          <input :disabled="isSubmit" type="text" class="form-control" id="faxno" name="faxno" v-model="newForm.faxno" required>
                                          <span v-if="errorsForms.faxno" style="color: red;">{{ errorsForms.faxno }}</span>
                                        </div>


                                        <div class="col-md-3">                      
                                          <label for="homeno" class="form-label">Home Number</label>
                                          <input :disabled="isSubmit" type="text" class="form-control" id="homeno" name="homeno" v-model="newForm.homeno" required>
                                          <span v-if="errorsForms.homeno" style="color: red;">{{ errorsForms.homeno }}</span>
                                        </div>


                                        <div class="col-md-3">                      
                                          <label for="officeno" class="form-label">Office Number</label>
                                          <input :disabled="isSubmit" type="text" class="form-control" id="officeno" name="officeno" v-model="newForm.officeno" required>
                                          <span v-if="errorsForms.officeno" style="color: red;">{{ errorsForms.officeno }}</span>
                                        </div>
                                      </div>
                                    </div>
                                   
                               
                            </div>
                        
                    </div>
            <div class="card mt-4">                        
                    <div class="card-header">Family Information</div>
                    <div class="card-body">
                        
                            <div class="mb-3">
                              <div class ="row">
                                <div class="col-md-3">                      
                                  <label for="familykin" class="form-label">Kin</label>
                                  <input :disabled="isSubmit" type="text" class="form-control" id="familykin" name="familykin" v-model="newForm.familykin" required>
                                  <span v-if="errorsForms.familykin" style="color: red;">{{ errorsForms.familykin }}</span>
                                </div>
                                <div class="col-md-3">                      
                                  <label for="familyrelation" class="form-label">Relation</label>
                                  <input :disabled="isSubmit" type="text" class="form-control" id="familyrelation" name="familyrelation" v-model="newForm.familyrelation" required>
                                  <span v-if="errorsForms.familyrelation" style="color: red;">{{ errorsForms.familyrelation }}</span>
                                </div>
                                <div class="col-md-6">                      
                                  <label for="familyaddress" class="form-label">Address</label>
                                  <input :disabled="isSubmit" type="text" class="form-control" id="familyaddress" name="familyaddress" v-model="newForm.familyaddress" required>
                                  <span v-if="errorsForms.familyaddress" style="color: red;">{{ errorsForms.familyaddress }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="mb-3">
                              <div class ="row">
                                <div class="col-md-3">                      
                                  <label for="familynokids" class="form-label">Number of Kids</label>
                                  <input :disabled="isSubmit" type="number" class="form-control" id="familynokids" name="familynokids" v-model="newForm.familynokids" required>
                                  <span v-if="errorsForms.familynokids" style="color: red;">{{ errorsForms.familynokids }}</span>
                                </div>
                                <div class="col-md-9">                      
                                  <label for="familykidsname" class="form-label">Name of Kids</label>
                                  <input :disabled="isSubmit" type="text" class="form-control" id="familykidsname" name="familykidsname" v-model="newForm.familykidsname" required>
                                  <span v-if="errorsForms.familykidsname" style="color: red;">{{ errorsForms.familykidsname }}</span>
                                </div>
                              </div>
                            </div>
                            <button type="submit" class="btn btn-primary" :disabled="isSubmit">Submit</button>
                        
                    </div>
                
            </div>
         </form>  
  `
});




    app.mount('#app');