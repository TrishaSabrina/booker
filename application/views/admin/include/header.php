<!DOCTYPE html>
<html lang="en" dir="<?php echo text_dir(); ?>">
<head>
  <?php $settings = get_settings(); ?>
  <?php $user = get_logged_user($this->session->userdata('id')); ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="Codericks">
  <link rel="icon" href="<?php echo base_url($settings->favicon) ?>">
  
  <title>
    <?php echo html_escape($settings->site_name); ?>  

    <?php if(is_user()): ?>
      &bull; <?php if(isset($this->business->name)){echo html_escape($this->business->name);} ?>
    <?php endif; ?>

    <?php if(isset($page_title)){echo ' &bull; '.trans(str_slug($page_title));}else{echo "Dashboard";} ?>
 </title>


  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/line-icons/lineicons.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Google Font: DM Sans -->
  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,400i,700&amp;display=swap" rel="stylesheet">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- sweet alert -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/sweet-alert.css">
  <!-- Light/Dark Mode Bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/bootstrap-dark.min.css" id="css_theme_style" >
  <!-- tags inputs -->
  <link href="<?php echo base_url() ?>assets/admin/css/bootstrap-tagsinput.css" rel="stylesheet" />
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/select2/css/select2.min.css">
  <!-- nice-select -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/nice-select.css">
  <!-- date & time picker -->
  <link href="<?php echo base_url() ?>assets/admin/css/bootstrap-datepicker.min.css" rel="stylesheet">
  <link href="<?php echo base_url() ?>assets/admin/css/timepicker.min.css" rel="stylesheet">
  <!-- css animation -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/front/css/aos.css">
  <!-- fullcalendar -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/fullcalendar-main.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/summernote/summernote-bs4.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/bootstrap-colorpicker.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/admin_default.css?var=<?= settings()->version ?>&time=<?=time();?>">

  <?php if (isset($page_title) && $page_title == 'Holidays'): ?>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/holiday.css">
  <?php endif; ?>


  <?php if (settings()->layout == 1): ?>
    <link href="<?php echo base_url() ?>assets/admin/css/admin_light.css" rel="stylesheet">
  <?php endif ?>

  <?php if (text_dir() == 'rtl'): ?>
    <link rel="stylesheet" href="<?php echo base_url()?>assets/admin/css/bootstrap-rtl.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/custom-rtl.css">
  <?php endif ?>

  <script type="text/javascript">
   var csrf_token = '<?= $this->security->get_csrf_hash(); ?>';
   var token_name = '<?= $this->security->get_csrf_token_name();?>'
 </script>

  <?php if (settings()->enable_captcha == 1 && settings()->captcha_site_key != ''): ?>
      <script src='https://www.google.com/recaptcha/api.js'></script>
  <?php endif; ?>
 
  </head>

  <body class="hold-transition sidebar-mini" data-theme-style="light">
  
  <div class="wrapper <?php if(settings()->site_info == 3){echo "d-none";} ?>">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark bg-dark border-0">
      <div class="container">
        <a target="_blank" href="<?php echo base_url() ?>" class="brand-link d-none d-sm-block">
          <img src="<?php echo base_url(settings()->favicon) ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
          <span class="text-white font-weight-bold"><?php echo html_escape(settings()->site_name) ?></span>
          <?php if(get_user_info() == TRUE){$uval = 'd-show';}else{$uval = 'd-hide';} ?>
        </a>
          
        <!-- Left navbar links -->
        <ul class="navbar-nav pl-3">
          <?php if(is_user()): ?>
            <li class="nav-item d-none d-sm-block">
              <a target="_blank" href="<?php echo base_url($this->business->slug) ?>" class="btn btn-outline-secondary btn-sm text-white"><i class="lni lni-eye"></i> <?php echo trans('view-page') ?></a>
            </li>
          <?php else: ?>
            <li class="nav-item d-none d-sm-block">
              <a target="_blank" href="<?php echo base_url() ?>" class="btn btn-outline-secondary btn-sm text-white"><i class="lni lni-eye"></i> <?php echo trans('view-site') ?></a>
            </li>
          <?php endif; ?>
          <li class="nav-item d-none d-block d-sm-none">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
        </ul>

        
        <!-- Right navbar links -->
        <ul class="rtlnav navbar-nav collapse navbar-collapse justify-content-end <?php if(text_dir() == 'ltr'){echo "ml-auto";} ?>" id="main_navbar">

          <li class="nav-item dropdown"> 
            <a class="nav-link"  data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false"> 
              <img id="header-lang-img" src="<?= base_url() . 'assets/images/countries/us.svg' ?>" alt="Header Language" height="16"> 
            </a>
            <div class="dropdown-menu dropdown-menu-right countries">
              <div class="p-1 px-4">
                <a class="dropdown-icon-item text-decoration-none" href="javascript:;">
                  <img src="<?= base_url() . 'assets/images/countries/us.svg' ?>" alt="user-image" class="me-1" height="12">
                  <span class="align-middle ml-2">English</span>
                </a>
              </div>
              <div class="p-1 px-4">
                <a class="dropdown-icon-item text-decoration-none" href="javascript:;">
                  <img src="<?= base_url() . 'assets/images/countries/es.svg' ?>" alt="user-image" class="me-1" height="12">
                  <span class="align-middle ml-2">Spanish</span>
                </a>
              </div>
              <div class="p-1 px-4">
                <a class="dropdown-icon-item text-decoration-none" href="javascript:;">
                  <img src="<?= base_url() . 'assets/images/countries/de.svg' ?>" alt="user-image" class="me-1" height="12">
                  <span class="align-middle ml-2">Germany</span>
                </a>
              </div>
              <div class="p-1 px-4">
                <a class="dropdown-icon-item text-decoration-none" href="javascript:;">
                  <img src="<?= base_url() . 'assets/images/countries/it.svg' ?>" alt="user-image" class="me-1" height="12">
                  <span class="align-middle ml-2">Italian</span>
                </a>
              </div>
              <div class="p-1 px-4">
                <a class="dropdown-icon-item text-decoration-none" href="javascript:;">
                  <img src="<?= base_url() . 'assets/images/countries/ru.svg' ?>" alt="user-image" class="me-1" height="12">
                  <span class="align-middle ml-2">Russian</span>
                </a>
              </div>
            </div>
          </li>

          <li class="nav-item dropdown"> 
            <a class="nav-link" href="javascript:;"> 
              <button type="button" id="switch_theme_style" class="btn btn-link text-decoration-none p-0" data-toggle="tooltip">
                <span style="color: white" data-theme-style="light" class=""><i class="far fa-fw fa-lg fa-moon mr-1"></i> </span>
                <span style="color: white" data-theme-style="dark" class="d-none"><i class="far fa-fw fa-lg fa-sun mr-1"></i> </span>
              </button>
            </a>
            <?php //include_once(base_url() . "application/views/theme_style_js.php") ?>
    
          </li>
          
          <li class="nav-item dropdown"> 
            <a class="nav-link" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false"> 
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid icon-lg"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg> 
            </a>
            <div class="dropdown-menu dropdown-menu-right p-3">
              <div class="d-flex grid-row">
                <div class="col-4 p-2 py-3">
                  <a class="dropdown-icon-item text-decoration-none" href="javascript:;">
                    <div class="text-center">
                      <img src="https://www.harcomia.com/assets/images/brands/github.png" />
                      <p class="mb-0">GitHub</p>
                    </div>
                  </a>
                </div>
                <div class="col-4 p-2 py-3">
                  <a class="dropdown-icon-item text-decoration-none" href="javascript:;">
                    <div class="text-center">
                      <img src="https://www.harcomia.com/assets/images/brands/bitbucket.png" />
                      <p class="mb-0">Bitbucket</p>
                    </div>
                  </a>
                </div>
                <div class="col-4 p-2 py-3">
                  <a class="dropdown-icon-item text-decoration-none" href="javascript:;">
                    <div class="text-center">
                      <img src="https://www.harcomia.com/assets/images/brands/dribbble.png" />
                      <p class="mb-0">Dribbble</p>
                    </div>
                  </a>
                </div>
              </div>
              <div class="d-flex grid-row">
                <div class="col-4 p-2 py-3">
                  <a class="dropdown-icon-item text-decoration-none" href="javascript:;">
                    <div class="text-center">
                      <img src="https://www.harcomia.com/assets/images/brands/dropbox.png" />
                      <p class="mb-0">Dropbox</p>
                    </div>
                  </a>
                </div>
                <div class="col-4 p-2 py-3">
                  <a class="dropdown-icon-item text-decoration-none" href="javascript:;">
                    <div class="text-center">
                      <img src="https://www.harcomia.com/assets/images/brands/mail_chimp.png" />
                      <p class="mb-0">Mail Chimp</p>
                    </div>
                  </a>
                </div>
                <div class="col-4 p-2 py-3">
                  <a class="dropdown-icon-item text-decoration-none" href="javascript:;">
                    <div class="text-center">
                      <img src="https://www.harcomia.com/assets/images/brands/slack.png" />
                      <p class="mb-0">Slack</p>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </li>
          
          <li class="nav-item dropdown"> 
            <a class="nav-link"  data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false"> 
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell icon-lg"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
              <span class="badge bg-danger rounded-pill" style="position: absolute; top: 0px; right: 5px; padding: 2px 5px;">5</span> 
            </a>
            <div class="dropdown-menu dropdown-menu-right notifications">
              <div class="d-flex justify-content-between p-2 px-4">
                <h6> Notifications </h6>
                <small><u>Unread(3)</u></small>
              </div>
              <div class="notify-contents">
                <div class="d-flex p-2 px-3">
                  <img src="https://www.harcomia.com/assets/images/users/avatar-3.jpg" class="rounded-circle mr-1" loading="lazy" width="32" height="32"/>
                  <div class="ml-3">
                    <h6 class="mb-1">James Lemire</h6>
                    <p class="mb-1">It will seem like simplified English.</p>
                    <span><i class="far fa-clock"></i> 1 hours ago</span>
                  </div>
                </div>
                <div class="d-flex p-2 px-3">
                  <img src="https://www.harcomia.com/assets/images/users/avatar-3.jpg" class="rounded-circle mr-1" loading="lazy" width="32" height="32"/>
                  <div class="ml-3">
                    <h6 class="mb-1">James Lemire</h6>
                    <p class="mb-1">It will seem like simplified English.</p>
                    <span><i class="far fa-clock"></i> 1 hours ago</span>
                  </div>
                </div>
                <div class="d-flex p-2 px-3">
                  <img src="https://www.harcomia.com/assets/images/users/avatar-3.jpg" class="rounded-circle mr-1" loading="lazy" width="32" height="32"/>
                  <div class="ml-3">
                    <h6 class="mb-1">James Lemire</h6>
                    <p class="mb-1">It will seem like simplified English.</p>
                    <span><i class="far fa-clock"></i> 1 hours ago</span>
                  </div>
                </div>
                <div class="d-flex p-2 px-3">
                  <img src="https://www.harcomia.com/assets/images/users/avatar-3.jpg" class="rounded-circle mr-1" loading="lazy" width="32" height="32"/>
                  <div class="ml-3">
                    <h6 class="mb-1">James Lemire</h6>
                    <p class="mb-1">It will seem like simplified English.</p>
                    <span><i class="far fa-clock"></i> 1 hours ago</span>
                  </div>
                </div>
              </div>
              <div class="p-2 px-4 text-center border-top">
                <a class="text-decoration-none text-center view-more">
                  <i class="fas fa-arrow-alt-circle-right mr-2"></i>
                  <span>View More..</span>
                </a>
              </div>
            </div>
        </li>
                      
          <!-- Messages Dropdown Menu -->
          <li class="nav-item dropdown pr-4">
            <div class="nav-link user-log d-sm-flex align-items-center" data-toggle="dropdown" href="#">
              <img class="rounded-circle mr-2" src="https://www.harcomia.com/dash-v2/assets/images/users/avatar-1.jpg" width="32" height="32" /> 
              <span class="d-none d-sm-flex align-content-center">
                <?php echo ucfirst(user()->name) ?>
                <i class="right lni lni-chevron-down text-white d-none d-sm-block pl-1 pt-1"></i></span>
            </div>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right mr-4">
              
              <?php if (user()->role == 'admin'): ?>
                <a href="<?php echo base_url('admin/settings/profile') ?>" class="dropdown-item px-4">
                  <i class="lni lni-user mr-2"></i> <?php echo trans('manage-profile') ?>
                </a>
                <a href="<?php echo base_url('admin/settings/change_password') ?>" class="dropdown-item px-4">
                  <i class="lni lni-lock-alt mr-2"></i> <?php echo trans('change-password') ?>
                </a>
      
                <a href="<?php echo base_url('admin/subscription') ?>" class="dropdown-item px-4">
                  <i class="lni lni-coin mr-2"></i> <?php echo trans('subscription') ?>
                </a>
      
                <a href="<?php echo base_url('admin/settings') ?>" class="dropdown-item px-4">
                  <i class="lni lni-cog mr-2"></i> <?php echo trans('settings') ?>
                  <!-- <i class="right lni lni-chevron-down ml-3"></i> -->
                </a>
      
                <a href="<?php echo base_url('admin/coupons/plan') ?>" class="dropdown-item px-4">
                  <i class="lni lni-offer mr-2"></i> <?php echo trans('coupons') ?>
                </a>
                <a href="<?php echo base_url('admin/payment/transactions') ?>" class="dropdown-item px-4">
                  <i class="lni lni-coin mr-2"></i> <?php echo trans('transactions') ?>
                </a>
      
                <a href="<?php echo base_url('admin/gallery') ?>" class="dropdown-item px-4">
                  <i class="lni lni-image mr-2"></i> <?php echo trans('gallery') ?>
                </a>
      
                <a href="<?php echo base_url('admin/pages') ?>" class="dropdown-item px-4">
                  <i class="lni lni-layout mr-2"></i></i> <?php echo trans('pages') ?>
                </a>

                <a href="<?php echo base_url('admin/faq') ?>" class="dropdown-item px-4">
                  <i class="lni lni-question-circle mr-2"></i></i> <?php echo trans('faqs') ?>
                </a>

                <a href="<?php echo base_url('admin/contact') ?>" class="dropdown-item px-4">
                  <i class="lni lni-popup mr-2"></i></i> <?php echo trans('contacts') ?>
                </a>

                <a href="<?php echo base_url('admin/dashboard/app_info') ?>" class="dropdown-item px-4">
                  <i class="far fa-question-circle mr-2"></i></i> <?php echo trans('info') ?>
                </a>
      
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url('auth/logout') ?>" class="dropdown-item px-4">
                  <i class="lni lni-exit mr-2"></i> <?php echo trans('logout') ?>
                </a>
              <?php endif ?>

              <?php if (user()->role == 'user'): ?>
                <a href="<?php echo base_url('admin/settings/profile') ?>" class="dropdown-item px-4">
                  <i class="lni lni-user mr-2"></i> <?php echo trans('manage-profile') ?>
                </a>
                <a href="<?php echo base_url('admin/settings/change_password') ?>" class="dropdown-item px-4">
                  <i class="lni lni-lock-alt mr-2"></i> <?php echo trans('change-password') ?>
                </a>
      
                <a href="<?php echo base_url('admin/subscription') ?>" class="dropdown-item px-4">
                  <i class="lni lni-coin mr-2"></i> <?php echo trans('subscription') ?>
                </a>
      
                <a href="<?php echo base_url('admin/settings') ?>" class="dropdown-item px-4">
                  <i class="lni lni-cog mr-2"></i> <?php echo trans('settings') ?>
                  <!-- <i class="right lni lni-chevron-down ml-3"></i> -->
                </a>
      
                <a href="<?php echo base_url('admin/coupons/plan') ?>" class="dropdown-item px-4">
                  <i class="lni lni-offer mr-2"></i> <?php echo trans('coupons') ?>
                </a>
      
                <a href="<?php echo base_url('admin/gallery') ?>" class="dropdown-item px-4">
                  <i class="lni lni-image mr-2"></i> <?php echo trans('gallery') ?>
                </a>
      
                <a href="<?php echo base_url('admin/pages') ?>" class="dropdown-item px-4">
                  <i class="lni lni-layout mr-2"></i></i> <?php echo trans('pages') ?>
                </a>

                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url('auth/logout') ?>" class="dropdown-item px-4">
                  <i class="lni lni-exit mr-2"></i> <?php echo trans('logout') ?>
                </a>
              <?php endif ?>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!-- /.navbar -->

    <nav class="navbar navbar-expand-lg navbar-light topnav-menu pb-3">
      <div class="container">
        <div class="collapse navbar-collapse" id="topnav_menu_content">
          <ul class="navbar-nav flex-wrap">
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
                  <a class="nav-link <?php if(isset($page_title) && $page_title == "Reports"){echo "active";} ?>" href="<?php echo base_url('admin/reports') ?>">
                  <i class="nav-icon far fa-chart-bar"></i> <span class="pl-1"><?php echo trans('reports') ?> </span>
                  </a>
                </li>
              <?php endif; ?>

            <?php endif; ?>

          </ul>
        </div>
      </div>
    </nav>
      
         
  <script>

    window.onload = function() {
      init();
    }

    function init() {
      let css = document.querySelector(`#css_theme_style`);
      document.querySelector(`body`).setAttribute('data-theme-style', localStorage.theme_style);
      
      if (document.querySelector(`body`).getAttribute('data-theme-style') === "light") {
        document.querySelector(`#switch_theme_style [data-theme-style="dark"]`).classList.add('d-none');
        document.querySelector(`#switch_theme_style [data-theme-style="light"]`).classList.remove('d-none');
      } else {
        document.querySelector(`#switch_theme_style [data-theme-style="light"]`).classList.add('d-none');
        document.querySelector(`#switch_theme_style [data-theme-style="dark"]`).classList.remove('d-none');
      }

      document.querySelector(`body`).setAttribute('data-theme-style', localStorage.theme_style);

      switch(localStorage.theme_style) {
          case 'dark':
              document.body.classList.add('c_darkmode');
              document.querySelector('.topnav-menu').classList.add('bg-dark');
              document.querySelector('.topnav-menu').classList.add('navbar-dark');
              document.querySelector('.topnav-menu').classList.remove('bg-light');
              document.querySelector('.topnav-menu').classList.remove('navbar-light');
              document.querySelector('.main-footer').classList.add('bg-dark');
              document.querySelector('.main-footer').classList.remove('bg-light');
              break;

          case 'light':
              document.body.classList.remove('c_darkmode');
              document.querySelector('.topnav-menu').classList.remove('bg-dark');
              document.querySelector('.topnav-menu').classList.remove('navbar-dark');
              document.querySelector('.topnav-menu').classList.add('bg-light');
              document.querySelector('.topnav-menu').classList.add('navbar-light');
              document.querySelector('.main-footer').classList.remove('bg-dark');
              document.querySelector('.main-footer').classList.add('bg-light');
              break;
      }
    }

    document.querySelector("#switch_theme_style").addEventListener("click", event => {
      let theme_style = document.querySelector('body[data-theme-style]').getAttribute('data-theme-style');
      let new_theme_style = theme_style == 'light' ? 'dark' : 'light';

      localStorage.theme_style = new_theme_style;

      init();

      event.preventDefault();
    })
    </script>


