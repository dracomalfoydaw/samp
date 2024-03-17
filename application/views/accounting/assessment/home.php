                    

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
                <button class="btnmarg btn  btn-sm btn-primary " data-menu="add" style="margin-right : 5px;"><i class="fa fa-table" style="margin-right : 5px;"></i> Add Fee</button>

                <button class="btn  btn-sm btn-danger " data-menu="rem" style="margin-right : 5px;"><i class="fa fa-times" style="margin-right : 5px;"></i> Remove Fee</button>
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
                    <tr>
                        <th></th>
                        <th>Code</th>
                        <th>Account Name</th>
                        
                        <th>Assestment</th>
                        <th>Net Assestment </th>
                        <th>Payment </th>
                        <th>Payment Discount</th>
                        <th>Balance</th>
                        <th>Remarks</th>

                        <th >EntryID</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in loadRemainingBalanceArray" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ item.ChartCode }}</td>
                        <td>{{ item.ChartName }}</td>
                        <td>{{ item.Credit }}</td>
                        <td>{{ item.Credit }}</td>

                        <td>{{ item.ActualPayment }}</td>
                        <td>{{ item.PaymentDiscount }}</td>
                        <td>{{ item.BalanceFee }}</td>
                        <td>{{ item.Remarks }}</td>

                        <td >{{ item.EntryID }}</td>
                    </tr>
                    <!-- Additional row for total computation -->
                    <tr >
                        <td colspan="3">Total Amount</td>
                        <td>{{ totalCredit }}</td>
                        <td>{{ totalCredit }}</td>
                        <td>{{ totalActualPayment  }}</td>
                        <td>{{ totalPaymentDiscount  }}</td>
                        <td>{{ totalBalanceFee  }}</td>
                        <td></td>
                        <td ></td>
                    </tr>
                    <tr>
                        <td colspan="8"><hr></td>
                    </tr>
                    <tr >
                        <td colspan="6"><hr></td>
                        <td>Overall Balance</td>
                        <td></td>
                        
                    </tr>
                </tbody>
            </table>
            
        </div>
    </div>
</div>


<?php $this->load->view("accounting/assessment/showmemberinfo"); ?>

