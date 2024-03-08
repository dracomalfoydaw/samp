                    

<!-- Example DataTable for Dashboard Demo-->
<div class="card mb-4">
    <div class="card-header">Personnel Management</div>
    <div class="card-body">
        <button class="btn btn-primary mb-3" @click="openRegistrationModal">Register</button>
    </div>
    <div class="card-body">

        <div class="datatable">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Identification #</th>
                        <th>LastName</th>
                        <th>FirstName</th>
                        <th>MiddleName</th>
                        <th>NameExtension</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>


                </tbody>
            </table>
        </div>
    </div>
</div>



<?php $this->load->view("members/profile/addform") ?>