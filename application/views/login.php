<div class="d-flex align-items-center position-relative min-vh-100">

    <!-- Left content -->
    <div class="jarallax overlay overlay-primary overlay-50 col-lg-5 col-xl-4 d-none d-lg-flex align-items-center h-100vh px-0" data-jarallax data-speed="0.9" style="background-image: url(<?php echo base_url() ?>assets/front/img/vericla-cover.jpg);">

        <div class="w-100 p-5 text-center">

            <div class="position-relative">
                <h1 class="text-white display-4 custom-font" data-aos="fade-up" data-aos-duration="300"><?php echo html_escape(settings()->site_name) ?></h1>
                <p class="lead text-white-90 mb-0 w-85 w-xl-70 mx-auto" data-aos="fade-up" data-aos-duration="400"><?php echo html_escape(settings()->description) ?>
                </p>
            </div>

            <div class="position-absolute right-0 bottom-0 left-0 text-center text-white p-5">
                <div class="row">
                    <div class="col-6">
                        <p class="mb-0 mt-1"><span class="text-white-85"> <?php echo html_escape(settings()->copyright) ?></span></p>
                    </div>
                    <div class="col-6">
                        <ul class="list-inline-item mb-0">
                            <li class="list-inline-item"><a href="<?php echo base_url('page/privacy-policy') ?>" class="text-white-85 hover-white"><?php echo trans('privacy') ?></a></li>
                            <li class="list-inline-item"><a href="<?php echo base_url('page/terms-of-service') ?>" class="text-white-85 hover-white"><?php echo trans('terms') ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End Left content -->

    <!-- Login form -->
    <div class="container">
        <div class="row justify-content-center justify-content-lg-start">
            
            <div id="login-area" class="col-md-8 col-lg-7 col-xl-5 offset-lg-2 offset-xl-3 my-5" data-aos="fade-left" data-aos-duration="400">

                <?php if (isset($_GET['msg']) && $_GET['msg'] == 'success'): ?>
                    <div class="alert alert-success alert-dismissible mb-4 log_alert">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <?php echo trans('logout-successfully-') ?>
                    </div>
                <?php endif ?>

                <div class="mb-6 text-center">
                    <?php get_last_logins(); ?>
                    <h4 class="font-weight-bold mb-0"><a href="<?php echo base_url() ?>"><img width="30%" src="<?php echo base_url(settings()->logo) ?>"></a></h4>
                    <p class="mb-0"><?php echo trans('sign-in-to-your') ?> <span class="font-weight-bold text-dark"><?php echo html_escape(settings()->site_name) ?> </span> <?php echo trans('account') ?></p>
                </div>

                <div class="mb-4 mt-4">
                    <div class="success text-success"></div>
                    <div class="error text-danger"></div>
                    <div class="warning text-warning"></div>
                </div>

                <?php if (settings()->type == 'demo'): ?>
                <div class="alert alert-default mb-4">
                    <div class="rows badge badge-pill badge-primary-soft">
                        <div class="col-6 mb-2">
                            admin
                        </div>
                        <div class="col-6">
                            1234
                        </div>
                    </div>
                    <div class="rows badge badge-pill badge-primary-soft">
                        <div class="col-6 mb-2">
                            user
                        </div>
                        <div class="col-6">
                            1234
                        </div>
                    </div>
                    <div class="rows badge badge-pill badge-primary-soft">
                        <div class="col-6 mb-2">
                            staff
                        </div>
                        <div class="col-6">
                            1234
                        </div>
                    </div>
                    <div class="rows badge badge-pill badge-primary-soft">
                        <div class="col-6 mb-2">
                            customer
                        </div>
                        <div class="col-6">
                            1234
                        </div>
                    </div>
                </div>
                <?php endif ?>

                <form id="login-form" method="post" action="<?php echo base_url('auth/log'); ?>">

                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="form-group">
                                <label><?php echo trans('username') ?></label>
                                <input type="text" class="form-control" name="user_name" placeholder="<?php echo trans('enter-email-or-username') ?>" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-12 mb-2">
                            <div class="form-group">
                                <label><?php echo trans('password') ?></label>
                                <input type="password" class="form-control" name="password" placeholder="<?php echo trans('enter-password') ?>" autocomplete="off">
                            </div>

                            <div class="text-left text-sm-left">
                                <a href="#" class="m-link-muted small forgot_pass"><?php echo trans('forgot-password') ?></a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        
                        <div class="col-md-12 center">
                            <!-- csrf token -->
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                            <button type="submit" class="btn btn-primary btn-block mt-4 mb-0 signin_btn"><?php echo trans('sign-in') ?> </button>
                        </div>
                    </div>

                    <div class="text-center text-small mt-4">
                        <span><?php echo trans('an-account-yet') ?> <a href="<?php echo base_url('register') ?>"><?php echo trans('register') ?></a></span>
                    </div>

                </form>
            </div>

            <div id="forgot-area" class="col-md-8 col-lg-7 col-xl-5 offset-lg-2 offset-xl-3 my-5 d-hide" data-aos="fade-left" data-aos-duration="400">
                
                <div class="mb-6 text-center">
                    <h2 class="font-weight-bold mb-0"><a href="<?php echo base_url() ?>"><img width="30%" src="<?php echo base_url(settings()->logo) ?>"></a></h2>
                    <p class="font-weight-normal mb-0"><?php echo trans('recover-password') ?></p>
                </div>

                <!-- Form -->
                <form id="lost-form" method="post" action="<?php echo base_url('auth/forgot_password'); ?>">

                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="form-group">
                                <select class="nice_select wide" name="role" id="exampleFormControlSelect1" required>
                                    <option value=""><?php echo trans('select-your-role') ?></option>
                                    <option value="users"><?php echo trans('adminuser') ?></option>
                                    <option value="staffs"><?php echo trans('staff') ?></option>
                                    <option value="customers"><?php echo trans('customer') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 mb-2">
                            <div class="form-group">
                                <input type="text" class="form-control" name="email" required placeholder="<?php echo trans('enter-your-email') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 text-left text-sm-left">
                            <a href="#" class="small back_login"><i class="fas fa-long-arrow-left"></i> <?php echo trans('back') ?></a>
                        </div>
                        <div class="col-md-12 center">
                            <!-- csrf token -->
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                            <button type="submit" class="btn btn-primary btn-block mt-4 mb-0"><?php echo trans('submit') ?></button>
                        </div>
                    </div>

                </form>
                <!-- End Form -->

            </div>

        </div>
    </div>
    <!-- End Register form -->

</div>