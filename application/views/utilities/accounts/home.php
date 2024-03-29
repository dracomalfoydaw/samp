                    

<!-- Example DataTable for Dashboard Demo-->
<div class="card mb-4">
    <div class="card-header"><?php echo $pageSubtitleTable ?></div>
    <div class="card-body">
        <button class="btn btn-primary mb-3" @click="openRegistrationModal">Register</button>
    </div>
    <div class="card-body">

        <div class="alert alert-danger messagebox_table_error"  style="display: none;"  role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            <a style="color:black;"id="message_error_table" disabled >
              <b>You have following error(s):</b> 
              <ul id="error_content_table">
                 
              </ul>
            </a>


        </div> 

       

        <div class="datatable" style="width: 100%; overflow-x: auto;">
            <table class="table table-bordered table-hover display nowrap" id="dataTable" width="100%" cellspacing="0">
               <thead>
                   
                </thead>

                <tbody>


                </tbody>
            </table>
        </div>
    </div>
</div>



<?php $this->load->view("utilities/accounts/addform") ?>
<?php $this->load->view("utilities/accounts/modaldeleteprompt") ?>