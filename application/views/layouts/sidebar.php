	<div class="sidenav-menu">
                        <div class="nav accordion" id="accordionSidenav">
                            <!-- Sidenav Menu Heading (Account)-->
                            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                            <div class="sidenav-menu-heading d-sm-none">Account</div>
                            <?php $this->load->view('layouts/notification_alert_sm') ?>
                            <?php $this->load->view('layouts/messenger_alert_sm') ?>
                            
                            <!-- Sidenav Menu Heading (Core)-->
                            <div class="sidenav-menu-heading">Core</div>
                            <!-- Sidenav Accordion (Dashboard)-->

                            <a class="nav-link" href="<?php echo base_url() ?>">
                                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                                Dashboard
                            </a>
                           


                            <div class="sidenav-menu-heading">Module </div>
                            <a class="nav-link" href="<?php echo base_url() ?>announcement">
                                <div class="nav-link-icon"><i data-feather="mail"></i></div>
                                List of Announcement 
                            </a>
                            <a class="nav-link" href="<?php echo base_url() ?>attendance">
                                <div class="nav-link-icon"><i data-feather="check-square"></i></div>
                                List of Attendance/Activities
                            </a>
                            <?php if($this->session->userdata('gid')==4 or $this->session->userdata('gid')==1  or $this->session->userdata('gid')==2 ): ?>
                            <div class="sidenav-menu-heading">Cashier</div>

                            <a class="nav-link" href="<?php echo base_url() ?>cashiering">
                                <div class="nav-link-icon"><i data-feather="dollar-sign"></i></div>
                                Cashiering Module
                            </a>
                            <?php endif; ?>

                            <div class="sidenav-menu-heading">Accounting</div>


                            <a class="nav-link" href="<?php echo base_url() ?>accounting/assessment">

                                <div class="nav-link-icon"><i data-feather="book-open"></i></div>
                                Balances
                            </a>

                            <?php if($this->session->userdata('gid')!=3 ): ?>
                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseContribution" aria-expanded="false" aria-controls="collapseContribution">
                                <div class="nav-link-icon"><i data-feather="users"></i></div>
                                Contribution
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseContribution" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                   
                                    <a class="nav-link" href="<?php echo base_url() ?>contribution">Contribution Profile</a>
                                   
                                    <a class="nav-link" href="<?php echo base_url() ?>contribution/collection">Contribution Collection</a>
                                </nav>
                            </div>

                            <?php else: ?>
                            <a class="nav-link" href="<?php echo base_url() ?>contribution">

                                <div class="nav-link-icon"><i data-feather="users"></i></div>
                                Contribution
                            </a>
                            <?php endif; ?>
                          



                            <?php if($this->session->userdata('gid')==4 or $this->session->userdata('gid')==1  or $this->session->userdata('gid')==2 ): ?>
                            <div class="sidenav-menu-heading">Members</div>

                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseMembers" aria-expanded="false" aria-controls="collapseMembers">
                                <div class="nav-link-icon"><i data-feather="users"></i></div>
                                Members Information
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseMembers" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                    <a class="nav-link" href="<?php echo base_url() ?>members">Profile</a>
                                </nav>
                            </div>
                            <?php endif; ?>
                            <?php if($this->session->userdata('gid')==1  or $this->session->userdata('gid')==2 ): ?>
                            <div class="sidenav-menu-heading">Utilities</div>
                            <!-- Sidenav Accordion (Utilities)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="false" aria-controls="collapseUtilities">
                                <div class="nav-link-icon"><i data-feather="tool"></i></div>
                                Utilities
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseUtilities" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo base_url() ?>account/">Users Account</a>
                                    <!-- <a class="nav-link" href="background.html">User Group</a>
                                    <a class="nav-link" href="borders.html">Access Rights</a> -->
                                </nav>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>