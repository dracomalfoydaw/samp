  <!-- Bootstrap Modal for Registration -->
  <div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="registrationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registrationModalLabel">Registration Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Registration Form -->
          <form @submit.prevent="submitRegistrationForm">

          <div class="form-group  " id="loading" style="display:none;">
            <div class="col-md-12">
              <center>
              <strong>
                <img src="<?php echo base_url() ?>assets/imgs/loading.gif" alt="CMULOGO" style="width:158px;height:154px;">
                </strong>
                </center>
             </div> 
          </div> 
          <div class="alert alert-danger messagebox" style="display: none;" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            <a style="color:black;"id="message_error" disabled >
              <b>You have following error(s):</b> 
              <ul id="error_content">
                 
              </ul>
            </a>


          </div> 
          <div class="custom-control custom-checkbox custom-control-solid">
              <input class="custom-control-input" id="customCheckSolid1" class="defaultsystemuser" type="checkbox" value="defaultsystemuser" v-model="formData.defaultuseraccount" >
              <label class="custom-control-label" for="customCheckSolid1">Create Dafault System User</label>
          </div>
          <div>
            <label for="username">ID Number:</label>
            <input type="text" id="idnumber" name="idnumber" class="form-control" v-model="formData.idnumber" required>
            <span v-if="errors.idnumber" class="error">{{ errors.idnumber }}</span>
          </div>
          
          <div>
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" class="form-control" name="firstName"  v-model="formData.firstName" required>
            <span v-if="errors.firstName" class="error">{{ errors.firstName }}</span>
          </div>

          <div>
            <label for="middleName">Middle Name:</label>
            <input type="text" id="middleName" name="middleName" class="form-control" v-model="formData.middleName" >
            <span v-if="errors.middleName" class="error">{{ errors.middleName }}</span>
          </div>

          <div>
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" class="form-control" v-model="formData.lastName" required>
            <span v-if="errors.lastName" class="error">{{ errors.lastName }}</span>
          </div>

          <div>
            <label for="nameExtension">Name Extension:</label>
            <input type="text" id="nameExtension" name="nameExtension" class="form-control" v-model="formData.nameExtension">
          </div>

          

          <div>
            <label for="email">Email:</label>
            <input type="email" id="email" id="name" class="form-control" v-model="formData.email" required>
            <span v-if="errors.email" class="error">{{ errors.email }}</span>
          </div>

        
          <button type="submit" class="btn btn-primary mt-3 submit_form_btn" id="submit_form_btn">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
  <!-- End of Bootstrap Modal for Registration -->