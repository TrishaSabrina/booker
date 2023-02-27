<div class="navbar-expand-lg navbar-expand-lg-collapse-block navbar-light">
    <div id="sidebarNavcustom" class="collapse navbar-collapse navbar-vertical sub">
        <!-- Card -->
        <div class="card mb-5 shadow-sm">
            <div class="card-body pr-0 pl-0">
         
                <div class="d-none d-lg-block text-center mb-5">
                    <div class="avatar avatar-circle mb-3">
                        <img class="avatar-img" src="<?php echo base_url($customer->thumb) ?>" alt="Image Description">
                    </div>

                    <h4 class="card-title mb-0"><?php echo html_escape($customer->name) ?></h4>
                    <p class="card-text"><?php echo html_escape($customer->email) ?></p>
                </div>

                <ul class="nav nav-sub nav-sm nav-tabs custo mb-4">

                    <li class="nav-item customer">
                        <a class="nav-link <?php if(isset($page_title) && $page_title == 'Appointments'){echo 'active';} ?>" href="<?php echo base_url('customer/appointments') ?>">
                            <i class="far fa-calendar-alt nav-icon"></i> <span class="d-none d-lg-inline-block"><?php echo trans('appointments') ?></span>
                        </a>
                    </li>

                    <li class="nav-item customer">
                        <a class="nav-link <?php if(isset($page_title) && $page_title == 'Account'){echo 'active';} ?>" href="<?php echo base_url('customer/account') ?>">
                            <i class="far fa-user nav-icon"></i> <span class="d-none d-lg-inline-block"><?php echo trans('personal-info') ?></span>
                        </a>
                    </li>

                    <li class="nav-item customer">
                        <a class="nav-link <?php if(isset($page_title) && $page_title == 'Change Password'){echo 'active';} ?>" href="<?php echo base_url('customer/change_password') ?>">
                            <i class="lnib lni-lock-alt nav-icon"></i> <span class="d-none d-lg-inline-block"><?php echo trans('change-password') ?></span>
                        </a>
                    </li>

                    <li class="nav-item customer">
                        <a class="nav-link" href="<?php echo base_url('auth/logout') ?>">
                            <i class="lnib lni-exit nav-icon"></i> <span class="d-none d-lg-inline-block"><?php echo trans('logout') ?></span>
                        </a>
                    </li>

                </ul>

                <div class="d-lg-none">
                    <div class="dropdown-divider"></div>

                    <!-- List -->
                    <ul class="nav nav-sub nav-sm nav-tabs nav-list-y-2">
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="#">
                        <i class="fas fa-sign-out-alt nav-icon"></i><?php echo trans('logout') ?>
                        </a>
                    </li>
                    </ul>
                    <!-- End List -->
                </div>
                <!-- End Nav -->
            </div>
        </div>
        <!-- End Card -->
    </div>
</div>