                    


<div class="card mb-4">
    <div class="card-header">Payor Assessment/Billing </div>
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
                        <th id='loading_div' style="display: none;"  colspan="8">
                   <center><img src="<?php echo base_url()?>assets/imgs/loading.gif"></center>
                        </th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Code</th>
                        <th>Account Name</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Total</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in loadRemainingBalanceArray" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ item.ChartCode }}</td>
                        <td>{{ item.ChartName }}</td>
                        <td>{{ item.Description }}</td>
                        <td>
                            {{ item.Credit }}
                        </td>
                        <td>{{ computeTotal(index) }}</td>
                        <td>
                             {{ item.Remarks }}
                        </td>
                    </tr>
                    <!-- Additional row for total computation -->
                    <tr >
                        
                    </tr>
                    <tr >
                        <td colspan="4">Total Amount</td>
                        <td>{{ totalAmount }}</td>
                        <td>{{ totalAmount  }}</td>
                        <td colspan="2"></td>
                        <td style="display: none;"></td>
                    </tr>
                </tbody>
            </table>

        </div>
       
    </div>
</div>


    

