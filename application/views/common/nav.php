<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <div class="" style="float:left">
              <img id="image-logo-denr" src="<?php echo base_url(); ?>assets/images/logo-denr.png" alt="logo-denr" style="width:50px;height:50px;"></img> - Online Services |</h4><a target="_blank" href="<?= base_url()?>uploads/steps_crs_new.pdf" class="btn" style="text-decoration: revert;color: green;"><i class="fa fa-book" aria-hidden="true"></i> View Manual</a>
          </div>
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
            <?php if ($this->session->userdata('client_id') == '26'): ?>
              <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="https://iis.emb.gov.ph/support/User/verify_user_acc/?user_code=<?php echo $this->session->userdata('user_code');?>" target="_blank">
                  <span class="mr-2 d-none d-lg-inline small" style="color:green">SUPPORT</span>
                  <i class="fa fa-phone" aria-hidden="true"></i>
                </a>
                <!-- Dropdown - User Information -->
              </li>
            <?php endif; ?>

            <?php if(!empty($lgu_patrolled_id)): ?>
              <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="<?php echo base_url()?>swm">
                  <span class="mr-2 d-none d-lg-inline small" style="color:green">SWM</span>
                  <i class='far fa-building' aria-hidden="true"></i>
                </a>
              </li>
            <?php endif; ?>

            <?php if($this->session->userdata('client_id') == 188) { ?>
               <li class="nav-item dropdown no-arrow">
                 <a class="nav-link dropdown-toggle" href="<?=base_url('payment/main')?>">
                   <span class="mr-2 d-none d-lg-inline small" style="color:green">Order of Payment Request</span>
                   <i class="fas fa-money-bill-wave"></i>
                 </a>
               </li>
            <?php } ?>

            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" target="_blank" href="http://hwms.emb.gov.ph/profile/company">
                <span class="mr-2 d-none d-lg-inline small" style="color:green">Hazardous Waste Manifest System</span>
                <i class='far fa-building' aria-hidden="true"></i>
              </a>
              <!-- Dropdown - User Information -->
            </li>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="https://client.emb.gov.ph/smr/login/verify_user_registration/?user_code=<?php echo $this->session->userdata('user_code');?>">
                <span class="mr-2 d-none d-lg-inline small" style="color:green">SMR</span>
                <i class="fa fa-paper-plane" aria-hidden="true"></i>
              </a>
            <?php //if ($this->session->userdata('client_id') == 1957): ?>
              <!-- <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="https://iis.emb.gov.ph/smr/login/verify_user_registration/?user_code=<?php echo $this->session->userdata('user_code');?>" target="_blank">
                  <span class="mr-2 d-none d-lg-inline small" style="color:green">SMR</span>
                  <i class="fa fa-paper-plane" aria-hidden="true"></i>
                </a>
              </li> -->

            <?php //endif; ?>


            <li class="nav-item dropdown no-arrow">
            <!-- <?php if ($this->session->userdata('username') == 'sampleclient1'): ?>
              <a class="nav-link dropdown-toggle" href="<?php echo base_url()?>Establishment_/add_establishment_steps/1">
                <span class="mr-2 d-none d-lg-inline small" style="color:green;font-weight: 800;">Add Establishment</span>
                <i class='far fa-building' aria-hidden="true"></i>
              </a>
                <?php else: ?>
                  <a class="nav-link dropdown-toggle" href="<?php echo base_url()?>Establishment">
                    <span class="mr-2 d-none d-lg-inline small" style="color:green;font-weight: 800;">Add Establishment</span>
                    <i class='far fa-building' aria-hidden="true"></i>
                  </a>
              <?php endif; ?> -->

              <a class="nav-link dropdown-toggle" href="<?php echo base_url()?>Establishment_/add_establishment_steps/1">
                <span class="mr-2 d-none d-lg-inline small" style="color:green;font-weight: 800;">Add Establishment</span>
                <i class='far fa-building' aria-hidden="true"></i>
              </a>

              <!-- Dropdown - User Information -->
            </li>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="<?php echo base_url()?>dashboard">
                <span class="mr-2 d-none d-lg-inline small" style="color:green;">Dashboard</span>
                <i class="fa fa-home" aria-hidden="true"></i>
              </a>
              <!-- Dropdown - User Information -->
            </li>
            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <!-- <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
            </li> -->

            <!-- Nav Item - Messages -->
            <!-- <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li> -->

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $this->session->userdata('username') ?></span>
                <img class="img-profile rounded-circle" src="<?php echo base_url(); ?>/uploads/user_image.png">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?php echo base_url(); ?>User/user_profile">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <!-- <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a> -->
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo base_url(); ?>Login/logout_user">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
