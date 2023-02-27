<!DOCTYPE html>
<html lang="en" dir="<?php echo text_dir(); ?>">

<head>

    <!-- Title  -->
    <?php $settings = get_settings(); ?>
    <title><?php echo html_escape($settings->site_name) ?> &bull; <?php if(isset($page_title)){echo trans(strtolower($page_title)).' &bull; ';} ?>  <?php echo html_escape($settings->site_title) ?></title>
    <!-- Metas -->
    <meta charset="utf-8">
    <?php if (isset($page) && $page == 'Company'): ?>
    <meta name="author" content="<?php echo html_escape($company->name) ?>">
    <meta name="description" content="<?php echo html_escape($company->description) ?>">
    <meta name="keywords" content="<?php echo html_escape($company->keywords) ?>">
    <?php else: ?>
    <meta name="author" content="<?php echo html_escape($settings->site_name) ?>">
    <meta name="description" content="<?php echo html_escape($settings->description) ?>">
    <meta name="keywords" content="<?php echo html_escape($settings->keywords) ?>">
    <?php endif ?>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#286efb" />
    <meta name="msapplication-navbutton-color" content="#286efb" />
    <meta name="apple-mobile-web-app-status-bar-style" content="#286efb" />

    <!-- Favicons-->
    <link rel="icon" href="<?php echo base_url($settings->favicon) ?>">
    <link rel="apple-touch-icon" href="<?php echo base_url($settings->favicon) ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url($settings->favicon) ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url($settings->favicon) ?>">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo base_url() ?>assets/img/favicon.ico">
    
    <!-- Google Fonts -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700&amp;display=swap" rel="stylesheet"> -->
    
    <!-- CSS Libs  -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/front/libs/font-awesome/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/front/libs/jarallax/dist/jarallax.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/front/libs/owl-carousel/dist/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/front/libs/owl-carousel/dist/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/front/css/simple-line-icons.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/sweet-alert.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/line-icons/lineicons.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/front/css/daterangepicker.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/front/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/front/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/front/css/lightbox.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <!-- Template CSS -->
    <link href="<?php echo base_url() ?>assets/front/css/template.min.css?var=<?= settings()->version ?>&time=<?=time();?>" rel="stylesheet">


    
    <?php if(settings()->enable_animation == 1): ?>
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/front/css/aos.css">
    <?php endif; ?>

    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/select2/css/select2.min.css">
     <!-- nice-select -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/nice-select.css">
    <!-- date & time picker -->
    <link href="<?php echo base_url() ?>assets/admin/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/admin/css/timepicker.min.css" rel="stylesheet">

    

    <?php if (isset($page_title) && $page_title == 'Register'): ?>
        <link href="<?php echo base_url() ?>assets/front/css/intelInput.css" rel="stylesheet">
    <?php else: ?>
        <link href="<?php echo base_url() ?>assets/front/css/intlInputPhone.css" rel="stylesheet">
    <?php endif ?>

    <?php if (text_dir() == 'rtl'): ?>
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/custom-rtl.css">
        <link rel="stylesheet" href="<?php echo base_url()?>assets/admin/css/bootstrap-rtl.min.css" crossorigin="anonymous">
    <?php endif ?>

    <!-- overwrite css -->
    <link href="<?php echo base_url() ?>assets/front/css/style-over.php?color=<?php echo settings()->site_color; ?>" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/front/libs/owl-carousel/dist/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/front/libs/owl-carousel/dist/css/owl.theme.default.min.css">

    <?php if (isset($company) && $company->template_style == 2): ?>
        <link href="<?php echo base_url() ?>assets/front/css/style2.css" rel="stylesheet">
    <?php endif ?>

    <!-- csrf token -->
    <script type="text/javascript">
       var csrf_token = '<?= $this->security->get_csrf_hash(); ?>';
       var token_name = '<?= $this->security->get_csrf_token_name();?>';
    </script>
    
    
    <?php if (!empty($settings->google_analytics)): ?>
        <?php echo base64_decode($settings->google_analytics) ?>
    <?php endif ?>

    <?php if (settings()->enable_captcha == 1 && settings()->captcha_site_key != ''): ?>
        <script src='https://www.google.com/recaptcha/api.js'></script>
    <?php endif; ?>

</head>

<body<?php if(isset($is_embed) && $is_embed == true){echo ' class="is-embed-no-bg"';} ?>>
    <!-- main wrapper -->
    <div class="main-wrapper">

        <!-- header -->
        <?php if (isset($menu) && $menu == TRUE): ?>
            <header id="navbar">
                <div class="container">
                    <nav class="navbar navbar-expand-lg navbar-light bg-whites py-3">
                        <a class="navbar-brand" href="<?php echo base_url() ?>">
                            <img width="120px" src="<?php echo base_url(settings()->logo) ?>" alt="logo">
                        </a>

                        <button type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler">
                            <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
                        </button>

                        <!-- Menu -->
                        <div id="navbarContent" class="collapse navbar-collapse mt-2">

                            <ul class="navbar-nav align-items-lg-center ml-auto">

                                <li class="nav-item xs-mb-10"><a href="<?php echo base_url() ?>" class="nav-link  <?php if(isset($page_title) && $page_title == "Home"){echo "active";} ?>"><?php echo trans('home') ?></a></li>
                                
                                <li class="nav-item xs-mb-10"><a href="<?php echo base_url('pricing') ?>" class="nav-link <?php if(isset($page_title) && $page_title == "Pricing"){echo "active";} ?>"><?php echo trans('pricing') ?></a></li>

                                <?php if (settings()->enable_users == 1): ?>
                                <li class="nav-item xs-mb-10"><a href="<?php echo base_url('companies') ?>" class="nav-link <?php if(isset($page_title) && $page_title == "Companies"){echo "active";} ?>"><?php echo trans('companies') ?></a></li>
                                <?php endif ?>


                                <?php if (settings()->enable_blog == 1): ?>
                                <li class="nav-item xs-mb-10"><a href="<?php echo base_url('blogs') ?>" class="nav-link <?php if(isset($page_title) && $page_title == "Blogs"){echo "active";} ?>"><?php echo trans('blogs') ?></a></li>
                                <?php endif ?>


                                <?php if (settings()->enable_faq == 1): ?>
                                <li class="nav-item xs-mb-10"><a href="<?php echo base_url('faqs') ?>" class="nav-link <?php if(isset($page_title) && $page_title == "Faqs"){echo "active";} ?>"><?php echo trans('faqs') ?></a></li>
                                <?php endif ?>

                                <li class="nav-item xs-mb-10"><a href="<?php echo base_url('contact') ?>" class="nav-link <?php if(isset($page_title) && $page_title == "Contact"){echo "active";} ?>"><?php echo trans('contact') ?></a></li>

                                <?php if (!empty(get_pages(0))): ?>
                                    <li class="nav-item dropdown">
                                        <a href="javascript:void(0);" data-toggle="dropdown" class="nav-link dropdown-toggle"><?php echo trans('pages') ?></a>

                                        <ul class="dropdown-menu shadow mt-1">
                                            <?php foreach (get_pages(0) as $page): ?>
                                                <li><a class="dropdown-item" href="<?php echo base_url('page/'.$page->slug) ?>"><?php echo html_escape($page->title) ?></a></li>
                                            <?php endforeach ?>
                                        </ul>
                                    </li>
                                <?php endif ?>

                                <?php if (settings()->enable_multilingual == 1): ?>
                                    <li class="nav-item dropdown">
                                        <a href="javascript:void(0);" data-toggle="dropdown" class="nav-link dropdown-toggle"><?php echo lang_short_form(); ?></a>

                                        <ul class="dropdown-menu shadow mt-1">
                                            <?php foreach (get_language() as $lang): ?>
                                                <li><a class="dropdown-item" href="<?php echo base_url('home/switch_lang/'.$lang->slug) ?>"><?php echo html_escape($lang->name) ?></a></li>
                                            <?php endforeach ?>
                                        </ul>
                                    </li>
                                <?php endif ?>

                            </ul>

                            <ul class="navbar-nav align-items-lg-center ml-lg-auto mt-0">
                                <li class="nav-item mr-0">
                                    <?php if (is_admin()): ?>
                                        <a class="btn btn-sm btn-light-secondary ml-auto" href="<?php echo base_url('auth/logout') ?>"><i class="lni lni-exit"></i> <?php echo trans('logout') ?> </a>

                                        <a class="btn btn-sm btn-primary ml-auto" href="<?php echo base_url('admin/dashboard') ?>"><i class="icon-speedometer"></i> <?php echo trans('dashboard') ?></a>
                                    <?php elseif(is_customer()): ?>

                                        <a class="btn btn-sm btn-light-secondary ml-auto" href="<?php echo base_url('auth/logout') ?>"><i class="lni lni-exit"></i> <?php echo trans('logout') ?> </a>

                                         <a class="btn btn-sm btn-primary ml-auto" href="<?php echo base_url('customer/appointments') ?>"><i class="icon-speedometer"></i> <?php echo trans('dashboard') ?></a>
                                    <?php elseif(is_staff()): ?>

                                        <a class="btn btn-sm btn-light-secondary ml-auto" href="<?php echo base_url('auth/logout') ?>"><i class="lni lni-exit"></i> <?php echo trans('logout') ?> </a>

                                         <a class="btn btn-sm btn-primary ml-auto" href="<?php echo base_url('staff/appointments') ?>"><i class="icon-speedometer"></i> <?php echo trans('dashboard') ?></a>
                                    <?php elseif(is_user()): ?>

                                        <a class="btn btn-sm btn-light-secondary ml-auto" href="<?php echo base_url('auth/logout') ?>"><i class="lni lni-exit"></i> <?php echo trans('logout') ?> </a>

                                        <?php $diff = date_difference(user()->created_at); ?>
                                        <?php if (user()->email_verified == 0 && settings()->enable_email_verify == 1 && $diff < 2): ?>
                                            <a class="btn btn-sm btn-warning ml-auto" href="<?php echo base_url('auth/verify?type=mail') ?>"><i class="fas fa-check-circle"></i> <?php echo trans('verify-account') ?></a>
                                        <?php else: ?>
                                            <a class="btn btn-sm btn-primary ml-auto" href="<?php echo base_url('admin/dashboard/user') ?>"><i class="icon-speedometer"></i> <?php echo trans('dashboard') ?></a>
                                        <?php endif ?>
                                    <?php else: ?>
                                        <a class="btn btn-sm btn-light ml-auto" href="<?php echo base_url('login') ?>"><?php echo trans('sign-in') ?></a>
                                        <a class="btn btn-sm btn-primary ml-auto" href="<?php echo base_url('register') ?>"><?php echo trans('get-started') ?></a>
                                    <?php endif ?>
                                </li>
                            </ul>

                        </div>
                        <!-- End Menu -->

                    </nav>
                </div>
            </header>
        <?php endif ?>

        <?php if (isset($page) && $page == 'Company'): ?>
            <header class="<?php if(isset($is_embed) && $is_embed == true){echo 'd-hide';} ?> <?php if (isset($page_title) && $page_title == 'Company Home'){echo 'position-absolute';} ?> left-0 top-0 w-100">
                <div class="container">
                    <nav class="navbar navbar-expand-lg navbar-light py-3 <?php if (isset($company->template_style) && $company->template_style == 2){echo "hide";}?>">
                        <a class="navbar-brand mr-lg-5" href="<?php echo base_url($slug) ?>">
                            <?php if (!empty($company->logo)):?>
                                <img width="120px" src="<?php echo base_url($company->logo) ?>" alt="logo">
                            <?php else: ?>
                                <span class="text-white company-name"><?php echo html_escape($company->name) ?></span>
                            <?php endif; ?>
                        </a>

                        <button type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler">
                            <span class="navbar-toggler-icon text-<?php if (isset($page_title) && $page_title == 'Company Home'){echo 'white';} ?> text-xs-black"><i class="fas fa-bars"></i></span>
                        </button>

                        <!-- Menu -->
                        <div id="navbarContent" class="collapse navbar-collapse company mt-2">

                            <ul class="navbar-nav align-items-lg-center ml-auto">
                                <li class="nav-item"><a href="<?php echo base_url($slug) ?>" class="nav-link text-<?php if (isset($page_title) && $page_title == 'Company Home'){echo 'white';} ?> text-xs-white <?php if(isset($page_title) && $page_title == "Home"){echo "active";} ?>"><?php echo trans('home') ?></a></li>
                                
                                <li class="nav-item"><a href="<?php echo base_url('services/'.$slug) ?>" class="nav-link text-<?php if (isset($page_title) && $page_title == 'Company Home'){echo 'white';} ?> text-xs-white <?php if(isset($page_title) && $page_title == "Services"){echo "active";} ?>"><?php echo trans('services') ?></a></li>
                     
                                <?php if (check_user_feature_access($company->user_id, 'gallery') == TRUE): ?>
                                    <?php if ($company->enable_gallery == TRUE): ?>
                                        <li class="nav-item"><a href="<?php echo base_url('gallery/'.$slug) ?>" class="nav-link text-<?php if (isset($page_title) && $page_title == 'Company Home'){echo 'white';} ?> text-xs-white <?php if(isset($page_title) && $page_title == "Gallery"){echo "active";} ?>"><?php echo trans('gallery') ?></a></li>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if (!empty(get_pages($company->uid))): ?>
                                    <li class="nav-item dropdown">
                                        <a href="javascript:void(0);" data-toggle="dropdown" class="nav-link dropdown-toggle <?php if (isset($page_title) && $page_title == 'Company Home'){echo 'text-white';} ?>"><?php echo trans('pages') ?></a>

                                        <ul class="dropdown-menu shadow mt-1">
                                            <?php foreach (get_pages($company->uid) as $page): ?>
                                                <li><a class="dropdown-item" href="<?php echo base_url('company/page/'.$slug.'/'.$page->slug) ?>"><?php echo html_escape($page->title) ?></a></li>
                                            <?php endforeach ?>
                                        </ul>
                                    </li>
                                <?php endif ?>
                            </ul>

                            <ul class="navbar-nav align-items-lg-center ml-lg-auto">
                                <li class="nav-item mr-0">
                                    <?php if(is_user()): ?>
                                        <a class="btn btn-sm btn-light-secondary ml-auto text-<?php if (isset($page_title) && $page_title == 'Company Home'){echo 'white';} ?> text-xs-white" href="<?php echo base_url('auth/logout') ?>"><i class="icon-logout"></i> <?php echo trans('logout') ?> </a>

                                         <a class="btn btn-sm btn-primary ml-auto" href="<?php echo base_url('admin/dashboard/user') ?>"><i class="icon-speedometer"></i> <?php echo trans('dashboard') ?></a>
                                    <?php elseif(is_customer()): ?>

                                        <a class="btn btn-sm btn-light-secondary ml-auto" href="<?php echo base_url('auth/logout') ?>"><i class="lni lni-exit"></i> <?php echo trans('logout') ?> </a>

                                         <a class="btn btn-sm btn-primary ml-auto" href="<?php echo base_url('customer/appointments') ?>"><i class="icon-speedometer"></i> <?php echo trans('dashboard') ?></a>
                                    <?php elseif(is_staff()): ?>

                                        <a class="btn btn-sm btn-light-secondary ml-auto" href="<?php echo base_url('auth/logout') ?>"><i class="lni lni-exit"></i> <?php echo trans('logout') ?> </a>

                                         <a class="btn btn-sm btn-primary ml-auto" href="<?php echo base_url('staff/appointments') ?>"><i class="icon-speedometer"></i> <?php echo trans('dashboard') ?></a>
                                    <?php else: ?>
                                        <a class="btn btn-sm btn-light-secondary ml-auto text-<?php if (isset($page_title) && $page_title == 'Company Home'){echo 'white';} ?> text-xs-white" href="<?php echo base_url('login') ?>"><?php echo trans('sign-in') ?></a>
                                        <a class="btn btn-sm btn-primary ml-auto" href="<?php echo base_url('register') ?>"><?php echo trans('get-started') ?></a>
                                    <?php endif ?>
                                </li>
                            </ul>

                        </div>
                        <!-- End Menu -->

                    </nav>
                </div>
            </header>
        <?php endif ?>

