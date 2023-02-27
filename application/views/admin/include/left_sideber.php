<aside class="main-sidebar sidebar-dark-primary elevation-4 d-block d-sm-none">
    <!-- Brand Logo -->
    <div class="d-flex justify-content-between align-content-center border-bottom border-secondary pr-2">
      <a target="_blank" href="<?php echo base_url() ?>" class="brand-link border-0">
        <img src="<?php echo base_url(settings()->favicon) ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-bold"><?php echo html_escape(settings()->site_name) ?></span>
        <?php if(get_user_info() == TRUE){$uval = 'd-show';}else{$uval = 'd-hide';} ?>
      </a>
      <div class="d-flex">
        <?php if(is_user()): ?>
          <a target="_blank" href="<?php echo base_url($this->business->slug) ?>" class="btn btn-outline-secondary btn-sm text-white my-auto"><i class="lni lni-eye"></i> <?php echo trans('view-page') ?></a>
        <?php else: ?>
          <a target="_blank" href="<?php echo base_url() ?>" class="btn btn-outline-secondary btn-sm text-white my-auto"><i class="lni lni-eye"></i> <?php echo trans('view-site') ?></a>
          <?php endif; ?>
      </div>
    </div>
    

    <!-- Sidebar -->
    <div class="sidebar">
     
      <!-- Sidebar Menu -->
      <nav class="mt-4">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <?php if (is_admin()): ?>
              <li class="nav-item d-flex align-items-center">
                <a href="<?php echo base_url('admin/dashboard') ?>" class="nav-link d-flex <?php if(isset($page_title) && $page_title == "Dashboard"){echo "active";} ?>">
                  <i class="nav-icon fa fa-home"></i> <span class="pl-1 align-items-center"><?php echo trans('dashboard') ?></span>
                </a>
              </li>
              
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                  <i class="nav-icon fas fa-credit-card"></i>  
                  <span class="pl-1">
                    <?php echo trans('payouts') ?>
                  </span>
                </a>
                <div class="dropdown-menu">
                  <a class="dropdown-item <?php if(isset($page_title) && $page_title == "Add Payout"){echo "active";} ?>" href="<?php echo base_url('admin/payouts/add') ?>">
                    <i class="lni lni-circle-plus"></i> <span><?php echo trans('add-payout') ?></span>
                  </a>
                  
                  <a class="dropdown-item <?php if(isset($page_title) && $page_title == "Payout Settings"){echo "active";} ?>" href="<?php echo base_url('admin/payouts/settings') ?>"><i class="lni lni-coin nav-icon"></i> <span><?php echo trans('payout-settings') ?></span></a>
                  
                  <a class="dropdown-item <?php if(isset($page_title) && $page_title == "Payout Requests"){echo "active";} ?>" href="<?php echo base_url('admin/payouts/requests') ?>"><i class="fas fa-file-invoice-dollar nav-icon"></i> <span><?php echo trans('payout-requests') ?></span></a>
                  
                  <a class="dropdown-item <?php if(isset($page_title) && $page_title == "Payout Completed"){echo "active";} ?>" href="<?php echo base_url('admin/payouts/completed') ?>"><i class="far fa-check-circle nav-icon"></i> <span><?php echo trans('completed') ?></span></a>
                </div>
              </li>
              
              <li class="nav-item">
                <a class="nav-link d-flex align-items-center  <?php if(isset($page_title) && $page_title == "Language"){echo "active";} ?>" href="<?php echo base_url('admin/language') ?>">
                  <i class="nav-icon fas fa-globe"></i> <span class="pl-1"><?php echo trans('language') ?></span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link d-flex align-items-center  <?php if(isset($page_title) && $page_title == "Package"){echo "active";} ?>" href="<?php echo base_url('admin/package') ?>">
                  <i class="nav-icon lni lni-layers"></i> <span class="pl-1"><?php echo trans('plans') ?></span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link d-flex align-items-center  <?php if(isset($page_title) && $page_title == "Category"){echo "active";} ?>" href="<?php echo base_url('admin/category') ?>">
                  <i class="nav-icon lni lni-folder"></i> <span class="pl-1"><?php echo trans('categories') ?></span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link d-flex align-items-center  <?php if(isset($page_title) && $page_title == "Blogs"){echo "active";} ?>" href="<?php echo base_url('admin/blog') ?>">
                  <i class="nav-icon lni lni-image"></i> <span class="pl-1"><?php echo trans('blogs') ?></span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link d-flex align-items-center  <?php if(isset($page_title) && $page_title == "Users"){echo "active";} ?>" href="<?php echo base_url('admin/users') ?>">
                  <i class="nav-icon lni lni-users"></i> <span class="pl-1"><?php echo trans('users') ?></span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link d-flex align-items-center  <?php if(isset($page_title) && $page_title == "Testimonials"){echo "active";} ?>" href="<?php echo base_url('admin/testimonial') ?>">
                  <i class="nav-icon far fa-comment-dots"></i> <span class="pl-1"><?php echo trans('testimonials') ?> </span> 
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link d-flex align-items-center  <?php if(isset($page_title) && $page_title == "Features"){echo "active";} ?>" href="<?php echo base_url('admin/site_features') ?>">
                  <i class="nav-icon lni lni-star"></i> <span class="pl-1"><?php echo trans('features') ?></span>
                </a>
              </li>
            <?php endif; ?>

            <?php if (is_user()): ?>

              <li class="nav-item">
                <a href="<?php echo base_url('admin/dashboard/user') ?>" class="nav-link <?php if(isset($page_title) && $page_title == "User Dashboard"){echo "active";} ?>">
                  <i class="nav-icon fa fa-home"></i> <span class="pl-1"><?php echo trans('dashboard') ?></span>
                </a>
              </li>

              <li class="nav-item">
                  <a class="nav-link <?php if(isset($page_title) && $page_title == "Transactions"){echo "active";} ?>" href="<?php echo base_url('/admin/payment/customer_transactions') ?>">
                  <i class="lni lni-coin"></i> <span class="pl-1"><?php echo trans('transactions') ?></span>
                  </a>
                </li>

              <?php if (check_my_payment_status() == TRUE): ?>

                <?php if (settings()->enable_wallet == 1): ?>
                <li class="nav-item has-treeview <?php if(isset($page) && $page == "Payouts"){echo "menu-open";} ?> <?= $uval; ?>">
                  <a href="#" class="nav-link <?php if(isset($page) && $page == "Payouts"){echo "active";} ?>">
                    <i class="nav-icon far fa-credit-card"></i>
                    <span>
                      <?php echo trans('payouts') ?>
                      <i class="right lni lni-chevron-left"></i>
                    </span>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a class="nav-link <?php if(isset($page_title) && $page_title == "Set Payout Account"){echo "active";} ?>" href="<?php echo base_url('admin/payouts/setup_account') ?>"><i class="fas fa-plus-circle nav-icon"></i> <span><?php echo trans('set-payout-account') ?></span></a>
                    </li>
                    
                    <li class="nav-item">
                      <a class="nav-link <?php if(isset($page_title) && $page_title == "Payouts"){echo "active";} ?>" href="<?php echo base_url('admin/payouts/user ') ?>"><i class="fas fa-credit-card nav-icon"></i> <span><?php echo trans('payouts') ?></span></a>
                    </li>
                  </ul>
                </li>
                <?php endif; ?>

                <?php if (check_feature_access('appointments') == TRUE): ?>
                <li class="nav-item">
                  <a class="nav-link <?php if(isset($page_title) && $page_title == "Appointments"){echo "active";} ?>" href="<?php echo base_url('admin/appointment') ?>">
                    <i class="nav-icon far fa-clock"></i> <span class="pl-1"><?php echo trans('appointments') ?></span>
                  </a>
                </li>
                <?php endif; ?>

                <li class="nav-item">
                  <a class="nav-link <?php if(isset($page_title) && $page_title == "Calendars"){echo "active";} ?>" href="<?php echo base_url('admin/appointment/calendars') ?>">
                    <i class="nav-icon far fa-calendar-alt"></i> <span class="pl-1"><?php echo trans('calendars') ?></span>
                  </a>
                </li>

                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="nav-icon lni lni-network"></i>
                    <span class="pl-1">
                      <?php echo trans('staff') ?>
                    </span>
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo base_url('admin/staff') ?>">
                      <i class="nav-icon lni lni-map"></i> <span><?php echo trans('staff') ?></span>
                    </a>
                    <a class="dropdown-item" href="<?php echo base_url('admin/services') ?>">
                      <i class="nav-icon lni lni-layers"></i> <span><?php echo trans('services') ?></span>
                    </a>
                    <a class="dropdown-item" href="<?php echo base_url('admin/location') ?>">
                      <i class="nav-icon lni lni-map"></i> <span><?php echo trans('locations') ?></span>
                    </a>
                  </div>
                </li>

                <li class="nav-item">
                  <a class="nav-link <?php if(isset($page_title) && $page_title == "Customers" || isset($page) && $page == "Customers"){echo "active";} ?>" href="<?php echo base_url('admin/customers') ?>">
                    <i class="nav-icon lni lni-users"></i> <span class="pl-1"><?php echo trans('customers') ?></span>
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link <?php if(isset($page_title) && $page_title == "Service"){echo "active";} ?>" href="<?php echo base_url('admin/services') ?>">
                    <i class="nav-icon lni lni-layers"></i> <span class="pl-1"><?php echo trans('services') ?></span>
                  </a>
                </li>
                
                <li class="nav-item">
                  <a class="nav-link <?php if(isset($page_title) && $page_title == "Reports"){echo "active";} ?>" href="<?php echo base_url('admin/reports') ?>">
                  <i class="nav-icon far fa-chart-bar"></i> <span class="pl-1"><?php echo trans('reports') ?> </span>
                  </a>
                </li>
              <?php endif; ?>

            <?php endif; ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>