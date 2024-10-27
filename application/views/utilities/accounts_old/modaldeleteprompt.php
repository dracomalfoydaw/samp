<div class="modal" tabindex="-1" role="dialog" id="deleteConfirmationModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id='delete_loading_div' style="display: none;"  >
           <center><img src="<?php echo base_url()?>assets/imgs/loading.gif"></center>
        </div>
        <p>Are you sure you want to delete this record?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="cancelDeleteButton">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
      </div>
    </div>
  </div>
</div>
