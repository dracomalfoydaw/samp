<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script>
    var image_var = '<?php echo SiteHelpers::avatar_class_members("img-account-profile rounded-circle mb-2", $data['Avatar']);?>';
    var ini_username = "<?php echo $data['AccountID']; ?>";
    var ini_emailaddress = "<?php echo $data['EmailAddress']; ?>";
    var ini_firstname = "<?php echo $data['FirstName']; ?>";
    var ini_lastname = "<?php echo $data['LastName']; ?>";
    var ini_middlename = "<?php echo $data['MiddleName']; ?>";
    var ini_nameextension = "<?php echo $data['NameExtension']; ?>";
    var ini_ProfileStatus = "<?php echo $data['RecordActive']; ?>";

    var ini_HomePurok = "<?php echo $data['HomePurok']; ?>";
    var ini_HomeBaranggay = "<?php echo $data['HomeBaranggay']; ?>";
    var ini_HomeMuncity = "<?php echo $data['HomeMuncity']; ?>";
    var ini_HomeProvince = "<?php echo $data['HomeProvince']; ?>";
    var ini_zipcode = "<?php echo $data['zipcode']; ?>";
    var ini_Country = "<?php echo $data['Country']; ?>";

    var ini_Sex = "<?php echo $data['Sex']; ?>";
    var ini_DateofBirth = "<?php echo $data['DateofBirth']; ?>";
    var ini_PlaceofBirth = "<?php echo $data['PlaceofBirth']; ?>";
    var ini_Bloodtype = "<?php echo $data['Bloodtype']; ?>";

    var ini_ContactNumber = "<?php echo $data['ContactNumber']; ?>";
    var ini_FaxNumber = "<?php echo $data['FaxNumber']; ?>";
    var ini_HomeNumber = "<?php echo $data['HomeNumber']; ?>";
    var ini_OfficeNumber = "<?php echo $data['OfficeNumber']; ?>";

    var ini_Occupation = "<?php echo $data['Occupation']; ?>";
    var ini_Education = "<?php echo $data['Education']; ?>";
    var ini_Employment = "<?php echo $data['Employment']; ?>";
    var ini_EmploymentAddress = "<?php echo $data['EmploymentAddress']; ?>";

    var ini_familykin = "<?php echo $data['familykin']; ?>";
    var ini_familyrelation = "<?php echo $data['familyrelation']; ?>";
    var ini_familyaddress = "<?php echo $data['familyaddress']; ?>";
    var ini_familynokids = "<?php echo $data['familynokids']; ?>";
    var ini_familykidsname = "<?php echo $data['familykidsname']; ?>";


    var ini_recordStat = "<?php echo $data['recordStat']; ?>";
    var ini_LodgeNo = "<?php echo $data['LodgeNo']; ?>";
    var ini_LodgeName = "<?php echo $data['LodgeName']; ?>";
    var ini_MasonDistrict = "<?php echo $data['MasonDistrict']; ?>";
    var ini_initiated = "<?php echo $data['initiated']; ?>";
    var ini_passed = "<?php echo $data['passed']; ?>";
    var ini_raised = "<?php echo $data['raised']; ?>";
    var ini_memberstatus = "<?php echo $data['memberstatus']; ?>";
</script>

<script >

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

            axios.post(base_url + 'profile/membership/uploadImage', formData, {
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
     
        formdata.append('session_log', this.session_log);
        formdata.append('FirstName', this.form.firstname);
        formdata.append('LastName', this.form.lastname);
        formdata.append('MiddleName', this.form.middlename|| '');
        formdata.append('nameExtension', this.form.nameExtension|| '');
       
        formdata.append('email', this.form.email);

        axios.post(base_url + 'profile/membership/update', formdata)
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
            this.errorsForms = {};
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

                    var address = base_url + 'profile/membership/updateinfo';
                    axios.post(address, formdata,)
                    .then(response_server => {
                      const response = response_server.data;
                      //console.log(response);
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


app.component('account-mason-card', {
    data() {
        return {
            newForm: {
                recordStat:ini_recordStat,
                LodgeNo:ini_LodgeNo,
                LodgeName:ini_LodgeName,
                MasonDistrict:ini_MasonDistrict,
                initiated:ini_initiated,
                passed:ini_passed,
                raised:ini_raised,
                memberstatus:ini_memberstatus,
            },
            errorsForms : {},   
            isSubmit: false,
            username: ini_username,
            session_log: session_log,
        };
    },
    methods: {
        confirmSubmit(){
           
            try {   
            if (Object.keys(this.errorsForms).length === 0) {
                this.isSubmit = true;
                var formdata = new FormData();
               
                formdata.append('session_log', this.session_log);
                formdata.append('recordStat', this.newForm.recordStat);
                formdata.append('LodgeNo', this.newForm.LodgeNo);
                formdata.append('LodgeName', this.newForm.LodgeName);
                formdata.append('MasonDistrict', this.newForm.MasonDistrict);
                formdata.append('initiated', this.newForm.initiated);
                formdata.append('passed', this.newForm.passed);
                formdata.append('raised', this.newForm.raised);
                formdata.append('memberstatus', this.newForm.memberstatus);

                var address = base_url + 'profile/membership/updatemasoninfo';
                axios.post(address, formdata,)
                .then(response_server => {
                  const response = response_server.data;
                  //console.log(response);
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
                          <div class="col-md-6">
                            <span class="form-control">
                              <label><input :disabled="isSubmit" type="radio" name="recordStat" class="recordStat auto" value="petitioner" v-model="newForm.recordStat" > Petitioner</label> &nbsp;
                              <label><input :disabled="isSubmit" type="radio" name="recordStat" class="recordStat" value="cabletow" v-model="newForm.recordStat"> Cabletow</label>
                            </span>
                          </div>
                          <div class="col-md-6">
                           </div>
                      </div>
                    </div>
                    <div class="mb-3">
                      <div class ="row">
                        <div class="col-md-3">
                          <label for="LodgeNo" class="form-label">Lodge Number</label>
                          <input :disabled="isSubmit" type="text" class="form-control" id="LodgeNo" name="LodgeNo" v-model="newForm.LodgeNo" required>
                          <span v-if="errorsForms.LodgeNo" style="color: red;">{{ errorsForms.LodgeNo }}</span>
                        </div>
                        <div class="col-md-3">
                          <label for="LodgeName" class="form-label">Lodge Name</label>
                          <input :disabled="isSubmit" type="text" class="form-control" id="LodgeName" name="LodgeName" v-model="newForm.LodgeName" >
                          <span v-if="errorsForms.LodgeName" style="color: red;">{{ errorsForms.LodgeName }}</span>
                        </div>
                        <div class="col-md-6">
                          <label for="MasonDistrict" class="form-label">Mason District</label>
                          <input :disabled="isSubmit" type="text" class="form-control" id="MasonDistrict" name="MasonDistrict" v-model="newForm.MasonDistrict" required>
                          <span v-if="errorsForms.MasonDistrict" style="color: red;">{{ errorsForms.MasonDistrict }}</span>
                        </div>
                        
                      </div>
                    </div>
                   <div class="mb-3">
                      <div class ="row">
                        <div class="col-md-3">                      
                          <label for="initiated" class="form-label">Date Initiated</label>
                          <input :disabled="isSubmit" type="date" class="form-control" id="initiated" name="initiated" v-model="newForm.initiated" required>
                          <span v-if="errorsForms.initiated" style="color: red;">{{ errorsForms.initiated }}</span>
                        </div>

                        <div class="col-md-3">                      
                          <label for="passed" class="form-label">Date Passed</label>
                          <input :disabled="isSubmit" type="date" class="form-control" id="passed" name="passed" v-model="newForm.passed" required>
                          <span v-if="errorsForms.passed" style="color: red;">{{ errorsForms.passed }}</span>
                        </div>


                        <div class="col-md-3">                      
                          <label for="raised" class="form-label">Date Raised</label>
                          <input :disabled="isSubmit" type="date" class="form-control" id="raised" name="raised" v-model="newForm.raised" required>
                          <span v-if="errorsForms.raised" style="color: red;">{{ errorsForms.raised }}</span>
                        </div>


                        <div class="col-md-3">                      
                          <label for="memberstatus" class="form-label">Status</label>
                          <select :disabled="isSubmit" id="memberstatus" v-model="newForm.memberstatus" class="form-control select2">
                            <option value="" disabled>Select Status</option>
                            <option value="Active" >Active</option>
                            <option value="Foreigner" >Foreigner</option>
                            <option value="SNPD" >SNPD</option>
                            <option value="Demitted" >Demitted</option>
                            <option value="LML" >LML</option>
                            <option value="Died" >Died</option>
                            <option value="Other" >Other</option>
                          </select>
                          <span v-if="errorsForms.memberstatus" style="color: red;">{{ errorsForms.memberstatus }}</span>
                        </div>
                      </div>
                    </div>
                     <button type="submit" class="btn btn-primary" :disabled="isSubmit">Submit</button>
            </div>
        
    </div>

   
           
         </form>  
  `
});


app.component('account-remarks-card', {
    template: `
    
    <div class="row ">
      <div class="col-md-5">
        <button class="tips btn btn-sm  btn-info" @click="newRecord"> <i class="fa fa-plus"></i> Add New</button>
        <button class="tips btn btn-sm  btn-danger" v-if="selectedRows.length" @click="deleteRecord"> <i class="fa fa-trash"></i> Delete</button>
      </div>
      <div class="col-md-3">  

      </div>
      <div class="col-md-4">
        <input type="text" class="form-control" v-model="searchQuery" @keyup.enter="onSearch" placeholder="Search...">
      </div>
    </div>
    <div class="datatable">
      <div class="row ">
        <div class="col-md-5">
         
        </div>
        <div class="col-md-3">            
            <div class="form-group has-feedback justify-content-center align-items-center" id="loading" style="display: none;">
                <div class="justify-content-center align-items-center">
                  <img src="`+base_url+`assets/imgs/loading.gif" alt="Loading" style="width:150px;height:150px;">
                </div>
            </div>
        </div>
        <div class="col-md-4">
        
        </div>
      </div>
      <div class="datatable" style="width: 100%; overflow-x: auto;">
      <table class="table table-responsive table-bordered table-hover" id="remarks_table" width="100%" cellspacing="0"></table>
      </div>
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
            <button class="btn btn-primary" @click="prevPage" :disabled="isDisabledPrevPage || currentPage === 1">Previous</button>
            <span>Page {{ currentPage }} of many</span>
            <button class="btn btn-primary" :disabled="isDisabledNextPage" @click="nextPage">Next</button>
          </div>
        </div>
      </div>
      <!-- Delete Modal -->
      <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            
              <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" @click="closeModal" aria-label="Close" :disabled="isDeleting">X</button>
              </div>
              <div class="modal-body">
                Are you sure you want to delete this record?
                <div v-if="isDeleting">
                  <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%;"></div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeModal" :disabled="isDeleting">Cancel</button>
                <button type="submit" class="btn btn-danger"  @click="confirmDelete"  :disabled="isDeleting">Delete</button>
              </div>
            
          </div>
        </div>
      </div>

      <!-- New Form Modal -->
      <div class="modal fade" id="newFormModal" tabindex="-1" aria-labelledby="newFormModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-l">
          <div class="modal-content">
            <form @submit.prevent="confirmSubmit">
              <div class="modal-header">
                <h5 class="modal-title" id="newFormModalLabel">New Record</h5>
                <button type="button" class="btn-close" @click="closenewFormModal" :disabled="isSubmit" aria-label="Close">X</button>
              </div>
             
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
              
              <div class="modal-body">
                <div v-if="isSubmit">
                  <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%;"></div>
                  </div>
                </div>
                <div v-if="isSubmit">
                </div>                

                
                <h3>Remarks</h3>
                <hr>
                <div class="mb-3">

                  <div class ="row">
                    <div class="col-md-12">
                      <label for="TransactionDate" class="form-label">Transaction Date</label>
                      <input :disabled="isSubmit" type="date" class="form-control" id="TransactionDate" name="TransactionDate" v-model="newForm.TransactionDate" >
                      <span v-if="errors.TransactionDate" style="color: red;">{{ errors.TransactionDate }}</span>
                    </div>
                    <div class="col-md-12">
                      <label for="Remarks" class="form-label">Remarks</label>
                      <input :disabled="isSubmit" type="text" class="form-control" id="Remarks" name="Remarks" v-model="newForm.Remarks" required>
                      <span v-if="errors.Remarks" style="color: red;">{{ errors.Remarks }}</span>
                    </div>
                  </div>
                </div>

                

                

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closenewFormModal" :disabled="isSubmit">Cancel</button>
                <button type="submit" class="btn btn-primary" :disabled="isSubmit">Submit</button>
              </div>
            </form>           
          </div>
        </div>
      </div>
    </div>
  `,
  data() {
    return {
      table: null,
      isDisabledNextPage: null,
      isDisabledPrevPage: null,
      currentPage: 1,
      searchQuery: '',
      rowsPerPage: 5, // Default rows per page
      sortColumn: '',
      sortOrder: 'asc', // Default sort order
      rowOptions: [
        { value: '5', text: '5' },
        { value: '10', text: '10' },
        { value: '25', text: '25' },
        { value: '50', text: '50' },
        { value: '100', text: '100' }
      ],
      sortOptions: [
        { value: '', text: 'Sort by' },
      ],      
      selectedRows: [],
      session_log: session_log,
      rowNumber: null,
      /**delete form**/  
      entryIdToDelete: null,
      isDeleting: false,
      deleteModal: null,
      /**New form**/      
      errors : {},      
      isSubmit: false,
      isAutomatic: false,
      newForm: {},
      newFormModal : null,
    };
  },
  watch: {
      'newForm.studNumRad'(newVal) {
          this.isAutomatic = newVal === 'auto-num';
      }
  },
  methods: {
    async fetchData(page, query = '', sortColumn = '', sortOrder = 'asc') {
      this.isDisabledNextPage = true;
      this.isDisabledPrevPage = true;
      this.showLoading(true);
      this.table.clear();
      this.table.draw();
      try {
        const response = await axios.get(base_url + 'profile/membership/remarks/table/', {
          params: {
            start: (page - 1) * this.rowsPerPage,
            limit: this.rowsPerPage,
            search: query,
            sortColumn: sortColumn,
            sortOrder: sortOrder,
            session_log: this.session_log,
          }
        });
        if(response.data.session_log && response.data.success) {
          this.isDisabledNextPage  = false;
          this.isDisabledPrevPage  = false;
          table_data =  response.data.data; 
          if(response.data.data.length <=0)
          {
            this.isDisabledNextPage = true;
          } 
        }
        else
        {
          alert('Session TimeOut. Reloading the Page');
          //location.reload(true);
        }
        this.table.clear();
        this.table.rows.add(table_data);
        this.table.draw();
        this.$nextTick(() => {
          this.addEventListeners();
        });
      } catch (error) {
        console.error('Error fetching data:', error);
      } finally {
        this.showLoading(false);
      }
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
    },
    

    /**New form**/    
    newRecord() {
      this.newFormModal = new bootstrap.Modal(document.getElementById('newFormModal'), {
        backdrop: 'static', // Prevent closing when clicking outside
        keyboard: false, // Prevent closing with ESC key
      });
      this.newFormModal.show();
    },

    confirmSubmit() {
      try {   
          $(".messagebox").fadeOut("slow");
          $(".messagebox_error").fadeOut("slow");
          const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
          this.errors = {};
          if (!this.newForm.Remarks) {
            this.errors.Remarks = 'Remarks is required.';
          }
          
          
          if (Object.keys(this.errors).length === 0) {
            this.isSubmit = true;
            var formdata = new FormData();
            formdata.append('Remarks', this.newForm.Remarks );
            formdata.append('session_log', this.session_log);
            formdata.append('DateTransaction', this.newForm.TransactionDate);
            formdata.append('ProfileID', ini_username);

            var address = base_url + 'profile/membership/remarks/add';
            axios.post(address, formdata,)
            .then(response_server => {
              const response = response_server.data;
              console.log(response);
              if (response.session_log && response.success) {
                this.newForm= {};

                this.currentPage = 1;
                this.selectedRows = [];
                this.fetchData(this.currentPage, this.searchQuery, this.sortColumn, this.sortOrder);
                this.newFormModal.hide();
                $(".messagebox").fadeOut("slow");
              }
              else if(response.session_log && response.success == false)
              {
                $("#error_content").html(response.message_details);
                $(".messagebox").fadeIn("slow");
              }
              else
              {
                alert('Session TimeOut. Reloading the Page');
                //location.reload(true);
              }
              this.isSubmit = false;
            })
            .catch(error => {
              $(".messagebox_error").fadeIn("slow");
              this.isSubmit = false;
            });
          }
      } catch (error) {
        this.newFormModal.hide();
        console.error('Error of fetching data:', error);
        alert('An error occurred while fetching the record.');
      }
    },
    closenewFormModal() {
      this.newFormModal.hide();
    },
    
    /**delete row**/
    deleteRow(entryId,rowNumber) {
      this.entryIdToDelete = entryId;
      this.rowNumber = rowNumber;
      this.deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'), {
        backdrop: 'static', // Prevent closing when clicking outside
        //keyboard: false // Prevent closing with ESC key
      });
      this.deleteModal.show();
    },

    async confirmDelete() {
      this.isDeleting = true;
      try {     
          var formdata = new FormData();
          var selectedRowsJSON = JSON.stringify(this.selectedRows);
          formdata.append('session_log', this.session_log);
          formdata.append('data', selectedRowsJSON);
          const response = await axios.post(base_url + 'profile/membership/remarks/delete', formdata);
          if (response.data.session_log && response.data.success) {
            //this.currentPage = 1;
            this.selectedRows = [];
            this.fetchData(this.currentPage, this.searchQuery, this.sortColumn, this.sortOrder);
            this.closeModal();           
          }
          else
          {
            alert('Session TimeOut. Reloading the Page');
            //location.reload(true);
          }
      } catch (error) {
        console.error('Error deleting data:', error);
        alert('An error occurred while deleting the record.');
        this.isDeleting = false;
      }
    },
    closeModal() {
      this.isDeleting = false;
      if (this.deleteModal) {
        this.deleteModal.hide();
      }
    },
    deleteRecord() {
      //alert('Selected IDs: ' + this.selectedRows.join(', '));

      this.deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'), {
        backdrop: 'static', // Prevent closing when clicking outside
        keyboard: false // Prevent closing with ESC key
      });
      this.deleteModal.show();
    },

 

            
    
    addEventListeners() {
      const self = this;
      $('#remarks_table').off('click', '.update-button').on('click', '.update-button', function() {
        const entryId = $(this).data('entry-id');
        const rowNumber = $(this).data('row-number');
        self.updateRow(entryId,rowNumber);
      });

      $('#remarks_table').on('click', '.avatar-img', function() {
        const imgSrc = $(this).data('img');
        alert('You clicked on the image: ' + imgSrc);
      });
      
    },
    
    handleCheckboxClick(event, row) {
      if (event.target.checked) {
        if (!this.selectedRows.includes(row.TransID)) {
          this.selectedRows.push(row.TransID);
        }
      } else {
        const index = this.selectedRows.indexOf(row.TransID);
        if (index > -1) {
          this.selectedRows.splice(index, 1);
        }
      }
    },
    
    handleSelectAll(event) {
      const isChecked = event.target.checked;
      this.selectedRows = [];
      $('input.row-checkbox').prop('checked', isChecked);
      if (isChecked) {
        this.table.rows().every((index) => {
          const row = this.table.row(index).data();
          this.selectedRows.push(row.TransID);
        });
      }
    }
    
  },
  mounted() {
    const default_avatar = base_url+`assets/assets/img/logo.png`; // Path to default image
    this.newForm.ProfileID = '';
    this.newForm.studNumRad = 'auto-num';
    this.newForm.defaultuseraccount = false;
    this.isAutomatic = true,
    this.table = $('#remarks_table').DataTable({
      columns: [
        {
          data: null,
          render: function (data, type, row, meta) {
            if (row.RecordStatus === 'Record Deleted') {
              return "";
            } else {              
              return `<input type="checkbox" class="row-checkbox" data-entry-id="${row.TransID}" >`;
            }
          },
          width:'5%',
          title: '<input type="checkbox" id="select-all" >',
          orderable: false
        },
        
        
        {
          data: 'DateTransaction',
          title: 'Date',
          orderable: false ,// Disable default sorting,
          render: function(data, type, row) {
            if (row.RecordStatus === 'Record Deleted') {
              return '<span><del>' + data + '</del></span>';
            } else {
              return data;
            }
          }
        },
        {
          data: 'Remarks',
          title: 'Remarks',
          orderable: false ,// Disable default sorting,
          render: function(data, type, row) {
            if (row.RecordStatus === 'Record Deleted') {
              return '<span><del>' + data + '</del></span>';
            } else {
              return data;
            }
          }
        },
        
        
        {
          data: null,
          render: (data, type, row, meta) => {
            if (row.RecordStatus === 'Record Deleted') {
              return `<button class="btn btn-sm btn-danger" disabled><i class="fa fa-trash"></i> Record deleted</button>`;
            } else {
              if (row.RecordActive === 'Active') {
                return `<button class="btn btn-sm btn-success" disabled> Active</button>`;
              }
              else
              {
                return `<button class="btn btn-sm btn-danger" disabled>Inactive</button>`;
              }
            }
          },
          title: 'Status',
          width:'5%',
          orderable: false // Disable default sorting
        },

        
        
      ],
      paging: false,
      searching: false,
      info: false
    });
    this.fetchData(this.currentPage);

    $('#remarks_table tbody').on('click', 'input.row-checkbox', (event) => {
      const row = this.table.row($(event.target).closest('tr')).data();
      this.handleCheckboxClick(event, row);
    });

    $('#select-all').on('click', (event) => {
      this.handleSelectAll(event);
    });


    
  }
});

app.component('account-officers-card', {
    template: `
    
    <div class="row ">
      <div class="col-md-5">
        <button class="tips btn btn-sm  btn-info" @click="newRecord"> <i class="fa fa-plus"></i> Add New</button>
        <button class="tips btn btn-sm  btn-danger" v-if="selectedRows.length" @click="deleteRecord"> <i class="fa fa-trash"></i> Delete</button>
      </div>
      <div class="col-md-3">  

      </div>
      <div class="col-md-4">
        <input type="text" class="form-control" v-model="searchQuery" @keyup.enter="onSearch" placeholder="Search...">
      </div>
    </div>
    <div class="datatable">
      <div class="row ">
        <div class="col-md-5">
         
        </div>
        <div class="col-md-3">            
            <div class="form-group has-feedback justify-content-center align-items-center" id="loading_div" style="display: none;">
                <div class="justify-content-center align-items-center">
                  <img src="`+base_url+`assets/imgs/loading.gif" alt="Loading" style="width:150px;height:150px;">
                </div>
            </div>
        </div>
        <div class="col-md-4">
        
        </div>
      </div>
      <div class="datatable" style="width: 100%; overflow-x: auto;">
      <table class="table table-responsive table-bordered table-hover" id="officers_table" width="100%" cellspacing="0"></table>
      </div>
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
            <button class="btn btn-primary" @click="prevPage" :disabled="isDisabledPrevPage || currentPage === 1">Previous</button>
            <span>Page {{ currentPage }} of many</span>
            <button class="btn btn-primary" :disabled="isDisabledNextPage" @click="nextPage">Next</button>
          </div>
        </div>
      </div>
      <!-- Delete Modal -->
      <div class="modal fade" id="deleteofficerModal" tabindex="-1" aria-labelledby="deleteOfficerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content"> 
            
              <div class="modal-header">
                <h5 class="modal-title" id="deleteOfficerModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" @click="closeModal" aria-label="Close" :disabled="isDeleting">X</button>
              </div>
              <div class="modal-body">
                Are you sure you want to delete this record?
                <div v-if="isDeleting">
                  <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%;"></div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeModal" :disabled="isDeleting">Cancel</button>
                <button type="submit" class="btn btn-danger"  @click="confirmDelete"  :disabled="isDeleting">Delete</button>
              </div>
            
          </div>
        </div>
      </div>

      <!-- New Form Modal -->
      <div class="modal fade" id="newFormofficerModal" tabindex="-1" aria-labelledby="newFormModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-l">
          <div class="modal-content">
            <form @submit.prevent="confirmSubmit">
              <div class="modal-header">
                <h5 class="modal-title" id="newFormModalLabel">New Record</h5>
                <button type="button" class="btn-close" @click="closenewFormModal" :disabled="isSubmit" aria-label="Close">X</button>
              </div>
             
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
              
              <div class="modal-body">
                <div v-if="isSubmit">
                  <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%;"></div>
                  </div>
                </div>
                <div v-if="isSubmit">
                </div>                

                
                <h3>Remarks</h3>
                <hr>
                <div class="mb-3">

                  <div class ="row">
                    <div class="col-md-12">
                      <label for="TransactionDate" class="form-label">Year Appointed</label>
                      <input :disabled="isSubmit" type="text" class="form-control" id="TransactionDate" name="TransactionDate" v-model="newForm.TransactionDate" >
                      <span v-if="errors.TransactionDate" style="color: red;">{{ errors.TransactionDate }}</span>
                    </div>
                    <div class="col-md-12">
                      <label for="LodgeNo" class="form-label">Lodge Number</label>
                      <input :disabled="isSubmit" type="text" class="form-control" id="LodgeNo" name="LodgeNo" v-model="newForm.LodgeNo" required>
                      <span v-if="errors.LodgeNo" style="color: red;">{{ errors.LodgeNo }}</span>
                    </div>
                    <div class="col-md-12">
                      <label for="LodgeName" class="form-label">LodgeName</label>
                      <input :disabled="isSubmit" type="text" class="form-control" id="LodgeName" name="LodgeName" v-model="newForm.LodgeName" required>
                      <span v-if="errors.LodgeName" style="color: red;">{{ errors.LodgeName }}</span>
                    </div>
                    <div class="col-md-12">
                      <label for="Type" class="form-label">Type</label>
                      <input :disabled="isSubmit" type="text" class="form-control" id="Type" name="Type" v-model="newForm.Type" required>
                      <span v-if="errors.Type" style="color: red;">{{ errors.Type }}</span>
                    </div>
                    <div class="col-md-12">
                      <label for="Position" class="form-label">Position</label>
                      <input :disabled="isSubmit" type="text" class="form-control" id="Position" name="Position" v-model="newForm.Position" required>
                      <span v-if="errors.Position" style="color: red;">{{ errors.Position }}</span>
                    </div>
                    <div class="col-md-12">
                      <label for="Remarks" class="form-label">Remarks</label>
                      <input :disabled="isSubmit" type="text" class="form-control" id="Remarks" name="Remarks" v-model="newForm.Remarks" required>
                      <span v-if="errors.Remarks" style="color: red;">{{ errors.Remarks }}</span>
                    </div>
                  </div>
                </div>

                

                

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closenewFormModal" :disabled="isSubmit">Cancel</button>
                <button type="submit" class="btn btn-primary" :disabled="isSubmit">Submit</button>
              </div>
            </form>           
          </div>
        </div>
      </div>
    </div>
  `,
  data() {
    return {
      table: null,
      isDisabledNextPage: null,
      isDisabledPrevPage: null,
      currentPage: 1,
      searchQuery: '',
      rowsPerPage: 5, // Default rows per page
      sortColumn: '',
      sortOrder: 'asc', // Default sort order
      rowOptions: [
        { value: '5', text: '5' },
        { value: '10', text: '10' },
        { value: '25', text: '25' },
        { value: '50', text: '50' },
        { value: '100', text: '100' }
      ],
      sortOptions: [
        { value: '', text: 'Sort by' },
      ],      
      selectedRows: [],
      session_log: session_log,
      rowNumber: null,
      /**delete form**/  
      entryIdToDelete: null,
      isDeleting: false,
      deleteModal: null,
      /**New form**/      
      errors : {},      
      isSubmit: false,
      isAutomatic: false,
      newForm: {},
      newFormModal : null,
    };
  },
  watch: {
      'newForm.studNumRad'(newVal) {
          this.isAutomatic = newVal === 'auto-num';
      }
  },
  methods: {
    async fetchData(page, query = '', sortColumn = '', sortOrder = 'asc') {
      this.isDisabledNextPage = true;
      this.isDisabledPrevPage = true;
      this.showLoading(true);
      this.table.clear();
      this.table.draw();
      try {
        const response = await axios.get(base_url + 'profile/membership/officerrecord/table/', {
          params: {
            start: (page - 1) * this.rowsPerPage,
            limit: this.rowsPerPage,
            search: query,
            sortColumn: sortColumn,
            sortOrder: sortOrder,
            session_log: this.session_log,
          }
        });
        if(response.data.session_log && response.data.success) {
          this.isDisabledNextPage  = false;
          this.isDisabledPrevPage  = false;
          table_data =  response.data.data; 
          if(response.data.data.length <=0)
          {
            this.isDisabledNextPage = true;
          } 
        }
        else
        {
          alert('Session TimeOut. Reloading the Page');
          location.reload(true);
        }
        this.table.clear();
        this.table.rows.add(table_data);
        this.table.draw();
        this.$nextTick(() => {
          this.addEventListeners();
        });
      } catch (error) {
        console.error('Error fetching data:', error);
      } finally {
        this.showLoading(false);
      }
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
      const loadingElement = document.getElementById('loading_div');
      if (loadingElement) {
        loadingElement.style.display = show ? 'block' : 'none';
      }
    },
    

    /**New form**/    
    newRecord() {
      this.newFormModal = new bootstrap.Modal(document.getElementById('newFormofficerModal'), {
        backdrop: 'static', // Prevent closing when clicking outside
        keyboard: false, // Prevent closing with ESC key
      });
      this.newFormModal.show();
    },

    confirmSubmit() {
      try {   
          $(".messagebox").fadeOut("slow");
          $(".messagebox_error").fadeOut("slow");
          const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
          this.errors = {};
          if (!this.newForm.Remarks) {
            this.errors.Remarks = 'Remarks is required.';
          }
          
          
          if (Object.keys(this.errors).length === 0) {
            this.isSubmit = true;
            var formdata = new FormData();
            formdata.append('Remarks', this.newForm.Remarks );
            formdata.append('session_log', this.session_log);
            formdata.append('DateTransaction', this.newForm.TransactionDate);
            formdata.append('LodgeNo', this.newForm.LodgeNo);
            formdata.append('LodgeName', this.newForm.LodgeName);
            formdata.append('Type', this.newForm.Type);
            formdata.append('Position', this.newForm.Position);
            formdata.append('ProfileID', ini_username);

            var address = base_url + 'profile/membership/officerrecord/add';
            axios.post(address, formdata,)
            .then(response_server => {
              const response = response_server.data;

              if (response.session_log && response.success) {
                this.newForm= {};

                this.currentPage = 1;
                this.selectedRows = [];
                this.fetchData(this.currentPage, this.searchQuery, this.sortColumn, this.sortOrder);
                this.newFormModal.hide();
                $(".messagebox").fadeOut("slow");
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
        this.newFormModal.hide();
        console.error('Error of fetching data:', error);
        alert('An error occurred while fetching the record.');
      }
    },
    closenewFormModal() {
      this.newFormModal.hide();
    },
    
    /**delete row**/
    deleteRow(entryId,rowNumber) {
      this.entryIdToDelete = entryId;
      this.rowNumber = rowNumber;
      this.deleteModal = new bootstrap.Modal(document.getElementById('deleteOfficerModal'), {
        backdrop: 'static', // Prevent closing when clicking outside
        //keyboard: false // Prevent closing with ESC key
      });
      this.deleteModal.show();
    },

    async confirmDelete() {
      this.isDeleting = true;
      try {     
          var formdata = new FormData();
          var selectedRowsJSON = JSON.stringify(this.selectedRows);
          formdata.append('session_log', this.session_log);
          formdata.append('data', selectedRowsJSON);
          const response = await axios.post(base_url + 'profile/membership/officerrecord/delete', formdata);
          if (response.data.session_log && response.data.success) {
            //this.currentPage = 1;
            this.selectedRows = [];
            this.fetchData(this.currentPage, this.searchQuery, this.sortColumn, this.sortOrder);
            this.closeModal();           
          }
          else
          {
            alert('Session TimeOut. Reloading the Page');
            //location.reload(true);
          }
      } catch (error) {
        console.error('Error deleting data:', error);
        alert('An error occurred while deleting the record.');
        this.isDeleting = false;
      }
    },
    closeModal() {
      this.isDeleting = false;
      if (this.deleteModal) {
        this.deleteModal.hide();
      }
    },
    deleteRecord() {
      //alert('Selected IDs: ' + this.selectedRows.join(', '));

      this.deleteModal = new bootstrap.Modal(document.getElementById('deleteofficerModal'), {
        backdrop: 'static', // Prevent closing when clicking outside
        keyboard: false // Prevent closing with ESC key
      });
      this.deleteModal.show();
    },

 

            
    
    addEventListeners() {
      const self = this;
      $('#officers_table').off('click', '.update-button').on('click', '.update-button', function() {
        const entryId = $(this).data('entry-id');
        const rowNumber = $(this).data('row-number');
        self.updateRow(entryId,rowNumber);
      });

      $('#officers_table').on('click', '.avatar-img', function() {
        const imgSrc = $(this).data('img');
        alert('You clicked on the image: ' + imgSrc);
      });
      
    },
    
    handleCheckboxClick(event, row) {
      if (event.target.checked) {
        if (!this.selectedRows.includes(row.TransID)) {
          this.selectedRows.push(row.TransID);
        }
      } else {
        const index = this.selectedRows.indexOf(row.TransID);
        if (index > -1) {
          this.selectedRows.splice(index, 1);
        }
      }
    },
    
    handleSelectAll(event) {
      const isChecked = event.target.checked;
      this.selectedRows = [];
      $('input.officer-row-checkbox').prop('checked', isChecked);
      if (isChecked) {
        this.table.rows().every((index) => {
          const row = this.table.row(index).data();
          this.selectedRows.push(row.TransID);
        });
      }
    }
    
  },
  mounted() {
    const default_avatar = base_url+`assets/assets/img/logo.png`; // Path to default image
    this.newForm.ProfileID = '';
    this.newForm.studNumRad = 'auto-num';
    this.newForm.defaultuseraccount = false;
    this.isAutomatic = true,
    this.table = $('#officers_table').DataTable({
      columns: [
        {
          data: null,
          render: function (data, type, row, meta) {
            if (row.RecordStatus === 'Record Deleted') {
              return "";
            } else {              
              return `<input type="checkbox" class="officer-row-checkbox" data-entry-id="${row.TransID}" >`;
            }
          },
          width:'5%',
          title: '<input type="checkbox" id="officer-select-all" >',
          orderable: false
        },
        
        
        {
          data: 'DateTransaction',
          title: 'Date',
          orderable: false ,// Disable default sorting,
          render: function(data, type, row) {
            if (row.RecordStatus === 'Record Deleted') {
              return '<span><del>' + data + '</del></span>';
            } else {
              return data;
            }
          }
        },
        
        
        {
          data: 'LodgeNo',
          title: 'Lodge Number',
          orderable: false ,// Disable default sorting,
          render: function(data, type, row) {
            if (row.RecordStatus === 'Record Deleted') {
              return '<span><del>' + data + '</del></span>';
            } else {
              return data;
            }
          }
        },

        

        {
          data: 'LodgeName',
          title: 'Lodge Name',
          orderable: false ,// Disable default sorting,
          render: function(data, type, row) {
            if (row.RecordStatus === 'Record Deleted') {
              return '<span><del>' + data + '</del></span>';
            } else {
              return data;
            }
          }
        },

        {
          data: 'Type',
          title: 'Type',
          orderable: false ,// Disable default sorting,
          render: function(data, type, row) {
            if (row.RecordStatus === 'Record Deleted') {
              return '<span><del>' + data + '</del></span>';
            } else {
              return data;
            }
          }
        },

        {
          data: 'Position',
          title: 'Position',
          orderable: false ,// Disable default sorting,
          render: function(data, type, row) {
            if (row.RecordStatus === 'Record Deleted') {
              return '<span><del>' + data + '</del></span>';
            } else {
              return data;
            }
          }
        },

        {
          data: 'Remarks',
          title: 'Remarks',
          orderable: false ,// Disable default sorting,
          render: function(data, type, row) {
            if (row.RecordStatus === 'Record Deleted') {
              return '<span><del>' + data + '</del></span>';
            } else {
              return data;
            }
          }
        },
        
        {
          data: null,
          render: (data, type, row, meta) => {
            if (row.RecordStatus === 'Record Deleted') {
              return `<button class="btn btn-sm btn-danger" disabled><i class="fa fa-trash"></i> Record deleted</button>`;
            } else {
              if (row.RecordActive === 'Active') {
                return `<button class="btn btn-sm btn-success" disabled> Active</button>`;
              }
              else
              {
                return `<button class="btn btn-sm btn-danger" disabled>Inactive</button>`;
              }
            }
          },
          title: 'Status',
          width:'5%',
          orderable: false // Disable default sorting
        },

        
        
      ],
      paging: false,
      searching: false,
      info: false
    });
    this.fetchData(this.currentPage);

    $('#officers_table tbody').on('click', 'input.officer-row-checkbox', (event) => {
      const row = this.table.row($(event.target).closest('tr')).data();
      this.handleCheckboxClick(event, row);
    });

    $('#officer-select-all').on('click', (event) => {
      this.handleSelectAll(event);
    });


    
  }
});



    app.mount('#app');    

</script>




