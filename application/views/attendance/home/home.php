                    

<!-- Example DataTable for Dashboard Demo-->
<div class="card mb-4">
    <div class="card-header"><?php echo $pageSubtitleTable ?></div>
    <div class="card-body">
        <button class="btn btn-primary mb-3" @click="openRegistrationModal">Create New</button>
    </div>
    <div class="card-body">

        <div class="datatable">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                   
                </thead>

                <tbody>


                </tbody>
            </table>
        </div>
    </div>
</div>



<?php $this->load->view("attendance/home/addform") ?>