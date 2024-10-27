                    





<div class="card mb-4">
    <div class="card-header">Payor Ledger</div>
    <div class="card-body">
        <div class="row">
            
            <div class="col-sm-12 col-md-12">
                <div class="text-right">
                    <div class="btn-group ">
                        
                   
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
                       
                    </tr>
                </thead>
                <tbody>
                   <tr v-for="(record, index) in records" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ record.TransactionCode }}</td>
                        <td>{{ record.ReferenceID }}</td>
                        <td>{{ record.Debit }}</td>
                        <td>{{ record.Credit }}</td>
                        <td>{{ record.BalanceFee }}</td>
                        <td>{{ record.Remarks }}</td>
                        <td>{{ record.DateTransacted }}</td>
                    </tr>
                </tbody>
            </table>
            <div ref="scrollAnchor"></div>
        </div>
    </div>
</div>




