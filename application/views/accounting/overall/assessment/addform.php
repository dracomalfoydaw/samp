<!-- Bootstrap Modal for Registration -->
<div class="modal fade" id="addrecord" tabindex="-1" role="dialog" aria-labelledby="registrationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registrationModalLabel">Add Fee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div  id='loading_addfee_div' style="display: none;"  >
                   <center><img src="<?php echo base_url()?>assets/imgs/loading.gif"></center>
                       
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
                <div class="row">
                    <div class="col-md-6">
                        <select class="form-control" v-model="selectedType" @change="search">
                          
                            <option v-for="option in options" :value="option.value">{{ option.label }}</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control" title="Search Value" v-model="search_value" @input="search" />
                    </div>
                </div>
                <hr>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                           
                            <th>#</th>
                            <th>Name</th>
                            <th>Details</th>
                            <th>DatePosted</th>
                            <th>Payment</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in loadListofPayment" :key="index">
                          
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.Name }}</td>
                            <td>{{ item.Description }}</td>
                            <td>{{ item.DateCreated }}</td>                            
                            <td>{{ item.TotalPayment }}</td>
                            <td><button class="check-attendance-button btn btn-sm btn-success" @click="selectItem(item.EntryID,item.Name )">select</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End of Bootstrap Modal for Registration -->