                    

<!-- Example DataTable for Dashboard Demo-->
<div class="card mb-4">
    <div class="card-header">

        <div class="row">
            <div class="col-sm-6 col-md-6">
                Payor Information
            </div>
            <div class="col-sm-6 col-md-6">



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



            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-10 col-md-10">
            <small>Member ID: {{ memberID }}</small> <br> 
            <small>Member Name: {{ memberFullname }}</small>
        </div>


        <div class="col-sm-2 col-md-2">

        </div>

    </div>

</div>


</div>




<div class="card mb-4">
    <div class="card-header">Payor Assessment/Billing </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-4 col-md-4">
                <button @click="addrecord" class="btnmarg btn  btn-sm btn-primary " data-menu="add" style="margin-right : 5px;"><i class="fa fa-table" style="margin-right : 5px;"></i> Add Fee</button>

                <button @click="confirmDelete" class="btn  btn-sm btn-danger " data-menu="rem" style="margin-right : 5px;"><i class="fa fa-times" style="margin-right : 5px;"></i> Remove Fee</button>
            </div>
            <div class="col-sm-8 col-md-8">
                <div class="text-right">
                    <div class="btn-group ">
                        
                        <a class="btn btn-sm btn-info" target="_blank" href="<?php echo base_url() ?>accounting/ledger" style="margin-right : 5px;"> <i class="fa fa-table" style="margin-right : 5px;"></i> Ledger</a>
                        
                        
                        <button class="btn btn-sm btn-primary " data-menu="recalcfee" style="margin-right : 5px;"><i style="margin-right : 5px;" class="fa fa-money-bill"></i> Re-Assess Fee</button>
                        <button class="btn btn-sm btn-primary " title="Recompute Balances" data-menu="recalc" style="margin-right : 5px;"><i class="fa fa-calculator" style="margin-right : 5px;"></i> Recompute </button>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="datatable">

            <table class="table table-bordered table-hover ">
                <thead>
                    <tr id="messagebox_table" style="display:none;">
                        <th colspan="7" >
                            <div class="alert alert-danger "  role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Error:</span>
                                <a style="color:black;"id="message_error" disabled >
                                    <b>You have following error(s):</b> 
                                    <ul id="error_content">
                                     
                                    </ul>
                                </a>


                            </div> 
                        </th>
                    </tr>
                    <tr id="loading_table" style="display:none;">
                        <th colspan="7" >
                            <center>
                                <strong>
                                    <img src="<?php echo base_url() ?>assets/imgs/loading.gif" alt="CMULOGO" style="width:158px;height:154px;">
                                </strong>
                            </center>
                        </th>
                    </tr>
                    <tr>
                        <th><input type="checkbox" @change="selectAll($event)"></th> <!-- Master checkbox -->
                        <th>#</th>
                      
                        
                        <th>Billing</th>
               
                        <th>Payment </th>
                        <th>Payment Discount</th>
                        <th>Balance</th>
                        <th>Remarks</th>

                       
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in loadRemainingBalanceArray" :key="index">
                        <td><input type="checkbox"class="selectedItems" v-model="selectedItems[index]"></td> <!-- Individual checkbox -->
                        <td>{{ index + 1 }}</td>
                       
                         <!-- Make Credit editable -->
                         <td><input type="number" step="0.01" v-model="item.Credit" @keyup.enter="updateRow(item.EntryID,item.Credit)" /></td> 
                        
                       

                        <td>{{ item.ActualPayment }}</td>
                        <td>{{ item.PaymentDiscount }}</td>
                        <td>{{ item.BalanceFee }}</td>
                        <td><input type="text" v-model="item.Remarks" @keyup.enter="updateRow(item.EntryID,item.Credit,item.Remarks)" ></td>

                        
                    </tr>
                    <!-- Additional row for total computation -->
                    <tr >
                        <td colspan="2">Total Amount</td>
                        <td>{{ totalCredit }}</td>
                       
                        <td>{{ totalActualPayment  }}</td>
                        <td>{{ totalPaymentDiscount  }}</td>
                        <td>{{ totalBalanceFee  }}</td>
                        <td></td>
                        
                    </tr>
                    
                </tbody>
            </table>
            
        </div>
    </div>
</div>




