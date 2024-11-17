<!-- User Dropdown-->
                <li class="nav-item dropdown no-caret mr-3 mr-lg-0 dropdown-user">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo SiteHelpers::avatar_class();?></a>
                    <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                        <h6 class="dropdown-header d-flex align-items-center">
                            <?php echo SiteHelpers::avatar_class("dropdown-user-img");?> 
                            <div class="dropdown-user-details">
                                <div class="dropdown-user-details-name"><?php echo $this->session->userdata('fid') ?></div>
                                <div class="dropdown-user-details-email"><?php echo $this->session->userdata('email') ?></div>
                            </div>
                        </h6>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo base_url() ?>profile">
                            <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                            Account Settings
                        </a>
                        <?php if($this->session->userdata('ProfileID') !=''): ?>
                        <a class="dropdown-item" href="<?php echo base_url() ?>profile/membership">
                            <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                            My Membership Profile
                        </a>
                        <?php endif; ?>
                        <a class="dropdown-item" href="<?php echo base_url() ?>profile/logout">
                            <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                            Logout
                        </a>
                    </div>
                </li>