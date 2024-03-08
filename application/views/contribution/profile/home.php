                    

<!-- Example DataTable for Dashboard Demo-->
<div class="card mb-4">
    <div class="card-header"><?php echo $pageSubtitle ?></div>
    <div class="card-body">
        <button class="btn btn-primary mb-3" @click="openRegistrationModal">Add New Record</button>
    </div>
    <div class="card-body">

        <div class="datatable">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Billing</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>


                </tbody>
            </table>
        </div>
    </div>
</div>



<?php $this->load->view("contribution/profile/addform") ?>