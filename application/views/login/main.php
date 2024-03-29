<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view("login/head") ?>
    <body class="bg-primary"  >
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content" style="background-image: linear-gradient(24deg, #0000ff70 0%, rgb(55 231 102) 100%);">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <!-- Basic login form-->
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header justify-content-center">
                                        <hr>
                                        <div class="text-center">
                                            <img src="<?php echo base_url().'assets/imgs/login-logo.png'?>" title='Login Logo' width="90" height="90" />
                                            <img src="<?php echo base_url().'assets/imgs/login-logo-2.png'?>" title='Login Logo' width="90" height="90" />
                                        </div>
                                        <div class="text-center">
                                            <h3 class="font-weight-light my-4">
                                                <?php echo CNF_APPNAMELANDINGPAGE ?>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="form-group  " id="loading" style="display:none;">
                                        <div class="col-md-12">
                                          <center>
                                          <strong>
                                            <img src="<?php echo base_url() ?>assets/imgs/loading.gif" alt="CMULOGO" style="width:158px;height:154px;">
                                            </strong>
                                            </center>
                                         </div> 
                                    </div> 

                                    <div class="alert alert-danger messagebox" style="display: none;" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        <span class="sr-only">Error:</span>
                                        <a style="color:black;"id="message_error" disabled >
                                            <b>You have following error(s):</b> 
                                            <ul id="error_content">
                                             
                                            </ul>
                                        </a>


                                    </div> 

                                    <div class="card-body" id="app">
                                        <?php $this->load->view('login/home') ?>
                                    </div>
                                    <div class="card-footer text-center">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <?php $this->load->view("login/footer") ?>
        </div>
        <?php $this->load->view("login/footer_script") ?>
    </body>
</html>
