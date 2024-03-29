<!-- Modal for confirmation -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div  id='loading_div_delete' style="display: none;"  >
                   <center><img src="<?php echo base_url()?>assets/imgs/loading.gif"></center>
                       
                </div>
            <div class="modal-body">
                Are you sure you want to delete these transactions? <br>
                Take note: All transaction that been paid will converted as non ledger. Be careful.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" @click="deleteTransactions">Confirm</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>