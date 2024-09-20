                    

<!-- Example DataTable for Dashboard Demo-->
<div class="card mb-4">
    <div class="card-header">
    
        <div class="row">
            <div class="col-sm-6 col-md-6">
                Payor Information
            </div>
            <div class="col-sm-6 col-md-6">
                
                <div class=" row" >
                    
                    <div class="col-md-6">
                      <input type='text' class='form-control Student' placeholder=''  v-model="OrNumber" name='student_id' disabled  /> <br />
                      <i> <small></small></i>
                    </div> 
                    <div class="col-md-6">
                      <input type='text' class='form-control Student' placeholder='' value="Date: <?php echo date("m-d-Y h:m:s"); ?>" name='student_id' disabled  /> <br />
                      <i> <small></small></i>
                    </div> 
                </div>
                
            </div>
        </div>
    </div>
    <div class="card-body">
        
        <div class="row">
            <div class="col-sm-10 col-md-10">
                <div class="row" id='nousermessegediv' style="display: none;"  >
                    <div class="col-sm-12 col-md-12">
                        <div class="alert alert-danger msg"><i class="fa fa-exclamation-circle"></i> No Record Found </div>
                    </div>
                </div>
                
                <div class="row"id='searchusermessegediv' style="display: none;" >
                    <div class="col-sm-12 col-md-12">
                        <div class="alert alert-warning msg"><i class="fa fa-check-circle"></i> checking ......</div>
                    </div>
                </div>
             </div>
             

             <div class="col-sm-2 col-md-2">
                    
             </div>

        </div>
        <div class="row">
            <div class="col-sm-10 col-md-10">
                    <div class="input-group">

                        <input tabindex="1" type="text" id="txtname"v-model="searchTerm" @keyup.enter="searchProfile()" name="txtname" autocomplete="off" class="form-control bold font-blue-madison" value="" placeholder="Search by IDNo, Name">
                        <span class="input-group-btn">
                         <button class="btn btn-primary" @click="searchProfile()"type="button" data-menu="search"><i class="feather text-white-50" data-feather="search"></i></button>
                     </span>
                 </div>
             </div>
             

             <div class="col-sm-2 col-md-2">
                    <div class="input-group">

                        
                        <span class="input-group-btn">
                            <button title = "Payment Received" disabled id="payNowButton" @click="payNow()" class="btn btn-secondary" style="margin-right:  5px;" ><i class="fa fa-cash-register "></i></button >
                         <button class="btn btn-danger" @click="cashierSetup()" title="Settings"><i class="fas fa-cog "></i> </button>
                     </span>
                 </div>
             </div>

        </div>
        <div class="row">
            <div class="col-sm-10 col-md-10">
                <small>Member ID: {{ memberID }}</small>  
             </div>
             

             <div class="col-sm-2 col-md-2">
                    
             </div>

        </div>

    </div>


</div>
<div class="card mb-4">
    <div class="card-header">Payor Information</div>
    <div class="card-body">
        <div class="datatable">
            <!-- <button @click="addRow">Add Row</button> -->
             <!-- Button to open the modal -->
           <!--  <button type="button" class="btn btn-primary" @click="openModal">
                Add Row
            </button> -->
            <br>
            <table class="table table-bordered table-hover ">
                <thead>
                    <tr>
                        <th></th>
                        <th>Code</th>
                        <th>Account Name</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Discount</th>
                        <th>Total</th>
                        <th>Remarks</th>
                        <!-- <th>Option</th> -->
                        <th style="display: none;">EntryID</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in loadRemainingBalanceArray" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ item.ChartCode }}</td>
                        <td>{{ item.ChartName }}</td>
                        <td>{{ item.Description }}</td>
                        <td>
                            <!-- Make Debit editable -->
                            <input v-model="item.Credit" @input="updateTotal(index)" />
                        </td>
                        <td>
                            <!-- Add an input field for Discount -->
                            <input v-model="item.Discount" value="0.00" @input="updateTotal(index)" />
                        </td>
                        <td>{{ computeTotal(index) }}</td>
                        <td>
                            <input v-model="item.Remarks" />

                        </td>
                        <!-- <td><button @click="removeRow(index)">Remove</button></td> -->
                        <td style="display: none;">{{ item.EntryID }}</td>
                    </tr>
                    <!-- Additional row for total computation -->
                    <tr >
                        
                    </tr>
                    <tr >
                        <td colspan="4">Total Amount</td>
                        <td>{{ totalAmount }}</td>
                        <td>{{ totalDiscount }}</td>
                        <td>{{ totalAmount - totalDiscount }}</td>
                        <td colspan="2"></td>
                        <td style="display: none;"></td>
                    </tr>
                </tbody>
            </table>

        </div>
        <!-- Bootstrap Modal -->
        <div class="modal fade" id="paymentTypeModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Select Payment Type</h5>
                        <button type="button" class="btn-close" @click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="paymentType" class="form-label">Payment Type</label>
                                <select v-model="selectedPaymentType" id="paymentType" class="form-select">
                                    <option value="">Select a payment type</option>
                                    <option value="CSC Payment">CSC Payment</option>
                                    <option value="TTF">Talent Fee</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeModal">Cancel</button>
                        <button type="button" class="btn btn-primary" @click="addRowWithPaymentType">Add Payment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    


<?php $this->load->view("cashiering/showmemberinfo"); ?>
<?php $this->load->view("cashiering/paymentmodal"); ?>
<?php $this->load->view("cashiering/cashiersettingmodal"); ?>