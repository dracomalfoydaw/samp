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

          <div>
            <label for="group">Group:</label>
            <select id="group" class="form-control" v-model="formData.group" required>
              <option v-for="(value, key) in options" :value="key">{{ value }}</option>
            </select>
            <span v-if="errors.group" class="error" style="color:red;">{{ errors.group }}</span>
          </div>

          <div>
            <label for="username">Profile Number : </label>
            <input type="text" id="idnumber" name="idnumber" class="form-control" v-model="formData.idnumber" required>
            <span v-if="errors.idnumber" class="error" style="color:red;">{{ errors.idnumber }}</span>
          </div>
          
          <div>
            <label for="username">Username : </label>
            <input type="text" id="username" name="username" class="form-control" v-model="formData.username" required>
            <span v-if="errors.username" class="error" style="color:red;">{{ errors.username }}</span>
          </div>
          
          <div>
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" class="form-control" name="firstName"  v-model="formData.firstName" required>
            <span v-if="errors.firstName" class="error" style="color:red;">{{ errors.firstName }}</span>
          </div>

          

          <div>
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" class="form-control" v-model="formData.lastName" required>
            <span v-if="errors.lastName" class="error" style="color:red;">{{ errors.lastName }}</span>
          </div>

         

          

          <div>
            <label for="email">Email:</label>
            <input type="email" id="email" id="name" class="form-control" v-model="formData.email" required>
            <span v-if="errors.email" class="error" style="color:red;">{{ errors.email }}</span>
          </div>

           <div>
            <label for="password">Password:</label>
            <input type="password" id="password" class="form-control passwordinput" v-model="formData.password" required>
            <span v-if="errors.password" class="error" style="color:red;">{{ errors.password }}</span>
          </div>

          <div>
            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" class="form-control passwordinput" v-model="formData.confirmPassword" required>
            <span v-if="errors.confirmPassword" class="error" style="color:red;">{{ errors.confirmPassword }}</span>
          </div>

        
          <button type="submit" class="btn btn-primary mt-3 submit_form_btn" id="submit_form_btn">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
  <!-- End of Bootstrap Modal for Registration -->