  <!-- Bootstrap Modal for Registration -->
  <div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="registrationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registrationModalLabel">Announcement Form</h5>
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
              <input class="custom-control-input" id="customCheckSolid1" class="sendannouncement" type="checkbox" value="sendannouncement" v-model="formData.sendannouncement" >
              <label class="custom-control-label" for="customCheckSolid1">Send Announcement Through email;</label>
          </div>
          
          <div>
            <label for="username">Title Name:</label>
            <input type="text" id="Titlename" name="Titlename" class="form-control" v-model="formData.Titlename" required>
            <span v-if="errors.Titlename" class="error">{{ errors.Titlename }}</span>
          </div>
          
          <div>
            <label for="firstName">Description:</label>
            <input type="text" id="Description" class="form-control" name="Description"  v-model="formData.Description" required>
            <span v-if="errors.Description" class="error">{{ errors.Description }}</span>
          </div>

          

        
          <button type="submit" class="btn btn-primary mt-3 submit_form_btn" id="submit_form_btn">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
  <!-- End of Bootstrap Modal for Registration -->