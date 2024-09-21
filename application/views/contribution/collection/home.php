                    

<!-- Example DataTable for Dashboard Demo-->
<div class="card mb-4">
    <div class="card-header"><?php echo $pageSubtitle ?></div>
   
    <div class="card-body">

        <div class="datatable">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Billing</th>
                        <th>Description</th>
                        <th>Total Collection</th>
                        <th>Need to be Collected</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>


                </tbody>
            </table>
        </div>
    </div>
</div>



<?php $this->load->view("contribution/collection/showdetails") ?>
<?php $this->load->view("contribution/collection/syncform") ?>


