<!-- Modal for updating data -->
<div class="modal fade" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Cash Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="datatable">
                   <table class="table"> 
                        <tr id="showerrorcashierpayment" style="display: none;">
                            <td colspan="2">
                                <div class="col-sm-12 col-md-12">
                                    <div class="alert alert-danger msg"><i class="fa fa-exclamation-circle"></i> {{ showerrorcashierpayment }} </div>
                                </div>
                            </td>  
                        </tr>
                       <tr>
                           <td width="30%">Total Cash Received</td>
                           <td><input @keyup.enter="confirmpayNow()"  class="form-control" v-model="TotalCashReceived" type="number" @input="computeTotalChange()"/></td>
                       </tr>
                       <tr>
                           <td width="30%">Amount to be Paid</td>
                           <td><input class="form-control" v-model="TotalCashToBePaid" disabled /></td>
                       </tr>
                       
                       <tr>
                           <td width="30%">Change</td>
                           <td><input class="form-control" v-model="TotalCashChanged" disabled /></td>
                       </tr>
                   </table>
               </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" @click="confirmpayNow()" >Confirm</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
