<!-- Modal for updating data -->
<div class="modal fade" id="cashierSetup_modal" tabindex="-1" role="dialog" aria-labelledby="settingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="settingModalLabel">Enter Official Receipt No.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-header">Please verify your OR No.to your official receipt</div>
                <hr>
                <div class="card-body">
                    
                    <div class="row" id='oruseddiv' style="display: none;" >
                        <div class="col-sm-12 col-md-12">
                            <div class="alert alert-danger msg"><i class="fa fa-exclamation-circle"></i> OR Number already used. </div>
                        </div>
                    </div>
                    <div class="row"id='ornotuseddiv' style="display: none;" >
                        <div class="col-sm-12 col-md-12">
                            <div class="alert alert-success msg"><i class="fa fa-check-circle"></i> OR Number is not used</div>
                        </div>
                    </div>
                    <div class="row"id='checkingornotuseddiv' style="display: none;" >
                        <div class="col-sm-12 col-md-12">
                            <div class="alert alert-warning msg"><i class="fa fa-check-circle"></i> checking ......</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10 col-md-10">
                                <div class="input-group">

                                    <input  type="text"  v-model="searchTermOrNumber" class="form-control " @keyup.enter="verifyOR()" placeholder="Enter O.R. Number ">
                                    
                             </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                                <div class="input-group">

                                    
                                    <span class="input-group-btn">
                                     <button @click="verifyOR()"class="btn btn-primary" type="button" data-menu="search"><i class="feather text-white-50" data-feather="check"></i></button> Verify Number
                                 </span>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" @click="confirmOR()">Confirm</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
