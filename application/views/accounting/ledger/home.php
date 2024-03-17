                    

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
    <div class="card-header">Payor Ledger</div>
    <div class="card-body">
        <div class="row">
            
            <div class="col-sm-12 col-md-12">
                <div class="text-right">
                    <div class="btn-group ">
                        
                     <a class="btn btn-success  btn-sm" id="refresh_ledger" data-info="" style="margin-right : 5px;">
                        <i class="fa fa-sync" style="margin-right : 5px;"></i> Refresh </a>

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
                        <th>Transaction Code</th>
                        <th>Reference ID</th>
                        
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance</th>
                        <th>Remarks</th>

                        <th>Transaction Date</th>
                        <th style="display: none;">EntryID</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in loadRemainingBalanceArray" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ item.TransactionCode }}</td>
                        <td>{{ item.ReferenceID }}</td>
                        <td>{{ item.Debit }}</td>
                        <td>{{ item.Credit }}</td>
                        <td>{{ item.BalanceFee }}</td>
                        <td>{{ item.Remarks }}</td>
                        <td>{{ item.DateTransacted }}</td>

                        <td style="display: none;">{{ item.EntryID }}</td>
                    </tr>
                    <!-- Additional row for total computation -->
                    <tr >
                        <td colspan="3">Total Amount</td>
                        <td>{{ totalDebit }}</td>
                        <td>{{ totalCredit }}</td>
                        <td>{{ totalBalance  }}</td>
                        <td></td>
                        <td></td>
                        <td style="display: none;"></td>
                    </tr>
                    <tr>
                        <td colspan="8"><hr></td>
                    </tr>
                    <tr >
                        <td colspan="6"><hr></td>
                        <td>Overall Balance</td>
                        <td>{{ totalBalance  }}</td>
                        
                    </tr>
                </tbody>
            </table>
            
        </div>
    </div>
</div>


<?php $this->load->view("accounting/ledger/showmemberinfo"); ?>

