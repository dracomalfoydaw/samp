<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layouts/head') ?>
    <body class="nav-fixed">
        <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
            <!-- Navbar Brand-->
            <!-- * * Tip * * You can use text or an image for your navbar brand.-->
            <!-- * * * * * * When using an image, we recommend the SVG format.-->
            <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
            <a class="navbar-brand" href="index.html"><?php echo CNF_APPNAME_CODE; ?></a>
            <!-- Sidenav Toggle Button-->
            <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle"><i data-feather="menu"></i></button>
            <!-- Navbar Search Input-->
            <!-- * * Note: * * Visible only on and above the md breakpoint-->
            
            <!-- Navbar Items-->
            <ul class="navbar-nav align-items-center ml-auto">
                <!-- Documentation Dropdown-->
                
                <!-- Navbar Search Dropdown-->
                <!-- * * Note: * * Visible only below the md breakpoint-->
                <?php $this->load->view('layouts/notification_content') ?>
                <?php $this->load->view('layouts/messenger_content') ?>
                <?php $this->load->view('layouts/profile') ?>
                
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sidenav shadow-right sidenav-light">
                    <?php $this->load->view("layouts/sidebar") ?>
                    <!-- Sidenav Footer-->
                    <div class="sidenav-footer">
                        <div class="sidenav-footer-content">
                            <div class="sidenav-footer-subtitle">Logged in as:</div>
                            <div class="sidenav-footer-title">Valerie Luna</div>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                        <div class="container">
                            <div class="page-header-content pt-4">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-4">
                                        <h1 class="page-header-title">
                                            <div class="page-header-icon"><i data-feather="activity"></i></div>
                                            <?php echo $pageTitle ?>
                                        </h1>
                                        <div class="page-header-subtitle"><?php echo $pageSubtitle ?></div>
                                    </div>
                                    <div class="col-auto mt-8">
                                        <div class="text-center">
                                            <img src="<?php echo base_url().'assets/imgs/login-logo.png'?>" width="90" height="90" />
                                            <img src="<?php echo base_url().'assets/imgs/login-logo-2.png'?>" width="90" height="90" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                    <!-- Main page content-->
                    <div class="container mt-n10" id="app">

                        <?php echo $content; ?>
                        
                       
                        
                        
                    </div>
                    
                </main>
                 <?php $this->load->view('layouts/footer_div') ?>
            </div>
        </div>

        <?php $this->load->view('layouts/footer') ?>
        <?php echo $home_script ?>
        
    </body>
</html>
