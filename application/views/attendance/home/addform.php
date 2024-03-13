  <!-- Bootstrap Modal for Registration -->
  <div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="registrationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registrationModalLabel">Activity Form</h5>
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
              <input class="custom-control-input" id="customCheckSolid1" class="createannoucement" type="checkbox" value="createannoucement" v-model="formData.createannoucement" >
              <label class="custom-control-label" for="customCheckSolid1">Create an Announcement</label>
          </div>
          <div>
            <label for="Name">Name of Activity</label>
            <input type="text" id="Name" name="Name" class="form-control" v-model="formData.Name" required>
            <span v-if="errors.Name" class="error">{{ errors.Name }}</span>
          </div>
          
          <div>
            <label for="Description">Description</label>
            <input type="text" id="Description" class="form-control" name="Description"  v-model="formData.Description" required>
            <span v-if="errors.Description" class="error">{{ errors.Description }}</span>
          </div>

          <div>
            <label for="Fines">Fines to be imposed</label>
            <input type="number" id="Description" class="form-control" name="Fines"  v-model="formData.Fines" required>
            <span v-if="errors.Fines" class="error">{{ errors.Fines }}</span>
          </div>

          <div>
            <label for="Fines">Scheduled Date</label>
            <input type="date" id="datescheduled" class="form-control" name="datescheduled"  v-model="formData.datescheduled" required>
            <span v-if="errors.datescheduled" class="error">{{ errors.datescheduled }}</span>
          </div>

         

        
          <button type="submit" class="btn btn-primary mt-3 submit_form_btn" id="submit_form_btn">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
  <!-- End of Bootstrap Modal for Registration -->