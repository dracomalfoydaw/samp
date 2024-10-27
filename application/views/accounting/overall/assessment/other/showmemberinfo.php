<!-- Modal for updating data -->
<div class="modal fade" id="showmemberinfo" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Search Payor Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- DataTable container -->
                <div  id='loading_div' style="display: none;"  >
                   <center><img src="<?php echo base_url()?>assets/imgs/loading.gif"></center>
                       
                </div>
                <div class="table-responsive">
                    
                    <table id="showmemberinfoDataTable"  class="table table-striped " width="   100%">
                        <!-- DataTable content will be dynamically generated here -->
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
