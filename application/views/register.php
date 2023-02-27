<div class="d-flex align-items-center position-relative min-vh-100 mb-6">

    <?php if (isset($page_title) && $page_title == 'Register'): ?>
    <!-- Register form -->
    <div class="container <?php if(settings()->site_info == 3){echo "d-hide";} ?>">
        <div class="row justify-content-center justify-content-lg-starts">
            <div class="col-md-8 col-lg-7 col-xl-7 offset-lg-1 offset-xl-2 my-1" data-aos="fade-left"
                data-aos-duration="200">

                <?php if (settings()->enable_registration == 0): ?>
                    <div class="mb-6 text-center">
                        <img class="mb-4" width="30%" src="<?php echo base_url('assets/front/img/not-found.png') ?>">
                        <h3 class="text-muted"><?php echo trans('registration-system-is-disabled-') ?> !</h3>
                        <a class="btn btn-light-primary btn-sm mt-2" href="<?php echo base_url('contact') ?>"> <?php echo trans('contact') ?>
                            </a>
                        <a class="btn btn-light-primary btn-sm mt-2" href="<?php echo base_url() ?>"><i
                                class="icon-home"></i> <?php echo trans('home') ?> </a>
                    </div>
                <?php else: ?>
                <div class="mb-6 text-center">
                    <h3 class="mb-0 custom-font"><?php echo trans('register-your-company') ?></h3>
                    <p class="mb-0"><?php echo trans('basic-information-you-can-add-more-later') ?></p>
                </div>

                <div class="mb-4 mt-4">
                    <div class="success text-success"></div>
                    <div class="success_extend text-success"></div>
                    <div class="error text-danger"></div>
                    <div class="warning text-warning"></div>
                </div>

                <form id="register_form" class="authorization__form authorization__form--shadow leave_con" method="post"
                    action="<?php echo base_url('auth/register_user'); ?>">

                    <div class="row">
                        
                        <div class="col-12">

                            <div class="form-group mb-2">
                                <label class="mb-1"><?php echo trans('company-slug-restrict') ?> <span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <?php $parse = parse_url(base_url()) ?>
                                    <div class="input-group-prepend">
                                      <div class="input-group-text"><?php echo $parse['host']; ?>/</div>
                                    </div>
                                    <input type="text" id="user-name" name="company_slug" class="form-control form-control-sm slug_input" autocomplete="off" required>
                                </div>
                            </div>
                            
                            <div class="loader"></div>
                            
                            <p class="text-danger fs-14 mt-0 mb-0" id="name_illegal" style="display: none;"><i class="icon-close"></i> <?php echo trans('illegal-characters-title') ?></p>
                            <p class="text-danger fs-14 mt-0 mb-0" id="name_exist" style="display: none;"><i class="icon-close"></i> <?php echo trans('name-is-already-taken') ?>.</p>
                            <p class="text-success fs-14 mt-0 mb-0" id="name_available" style="display: none;"><i class="icon-check"></i> <?php echo trans('name-is-available') ?>.</p>
                        </div>

                        <div class="col-12 mt-2">
                            <div class="form-group">
                                <label class="mb-1"><?php echo trans('company-name') ?> <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control form-control-sm name_input" name="company_name" placeholder="<?php echo trans('name-of-your-company') ?>">
                            </div>

                            <p class="text-danger fs-14 mt-0 mb-2" id="name_illegal_2" style="display: none;"><i class="icon-close"></i> <?php echo trans('illegal-characters-title') ?></p>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label class="mb-1"><?php echo trans('categories') ?> <span class="text-danger">*</span></label>
                                <select name="category" class="nice_select wide small" required>
                                    <option value=""> <?php echo trans('select') ?></option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo html_escape($category->id)?>"> <?php echo html_escape($category->name)?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 hide">
                            <div class="form-group">
                                <label class="mb-1">Company Details</label>
                                <textarea class="form-control form-control-sm" name="details" id="details_input" placeholder="Company about us"></textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="mb-1"><?php echo trans('email') ?> <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-sm" name="email" placeholder="" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1"><?php echo trans('phone') ?> <span class="text-danger">*</span></label>
                                        <div class="input-phone"></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="form-group">
                                <label class="mb-1"><?php echo trans('password') ?> <span class="text-danger">*</span></label>
                                <input type="password" class="form-control form-control-sm" name="password" required>
                            </div>
                        </div>

                    </div>


                    <div class="row mt-2">
                        <div class="col-md-12">
                            <?php if (settings()->enable_captcha == 1 && settings()->captcha_site_key != ''): ?>
                            <div class="g-recaptcha pull-left"
                                data-sitekey="<?php echo html_escape(settings()->captcha_site_key); ?>"></div>
                            <?php endif ?>
                        </div>
                    </div>


                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="agree" class="custom-control-input agree_btn"
                                    id="terms-condition" required>
                                <label class="custom-control-label" for="terms-condition">
                                    <?php echo trans('i-have-read-and-understood-the') ?> <a
                                        href="<?php echo base_url('page/terms-of-service') ?>"><?php echo trans('terms-and-conditions') ?></a>
                                    <?php echo trans('and') ?> <a href="<?php echo base_url('page/privacy-policy') ?>"> <?php echo trans('privacy-policy') ?> </a><?php echo trans('of-this-site') ?>.</label>
                            </div>
                        </div>

                        <div class="col-md-12 center">
                            <input type="hidden" name="plan"
                                value="<?php if(isset($_GET['plan'])){echo html_escape($_GET['plan']);}else{echo "basic";} ?>">
                            <input type="hidden" name="billing"
                                value="<?php if(isset($_GET['billing'])){echo html_escape($_GET['billing']);}else{echo "monthly";} ?>">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>"
                                value="<?php echo $this->security->get_csrf_hash();?>">
                            <button type="submit"
                                class="btn btn-primary btn-block mt-4 mb-0 register_button" disabled="disabled"><?php echo trans('register') ?></button>
                        </div>
                    </div>


                    <div class="text-center text-small mt-4">
                        <span><?php echo trans('already-have-an-account') ?> <a href="<?php echo base_url('login') ?>"><?php echo trans('sign-in') ?></a></span>
                    </div>

                </form>
                
                <?php endif ?>

            </div>
        </div>
    </div>
    <!-- End register form -->

    <!-- Left content -->
    <div class="jarallaxs overlays overlay-primarys overlay-70s col-lg-5 col-xl-5 d-none d-lg-flex align-items-center h-100vh px-0 mr-0" data-aos="fade-right"
                data-aos-duration="400">
        <div class="w-lg-85 p-5 text-center">

            <div class="browser">
                <div class="browser-navigation-bar">
                    <i></i><i></i><i></i>
                    <!-- Place your URL into <input> below -->
                    <input id="slug_add" value="<?php echo base_url() ?>" disabled />
                </div>

                <div class="browser-container">
                    <!-- Place your content of any type here -->
                    <div class="page-toper">
                        <img width="15%" src="<?php echo base_url(settings()->logo) ?>">
                        <h5 class="mb-0" id="name_add"></h5>
                    </div>
                    
                    <div class="page-footer">
                        <button class="btn btn-secondary btn-sm btn-pill pl-2 pr-2 fs-12" disabled> <?php echo trans('book-now') ?></button>
                        <h5 class="mb-1 hide"><?php echo trans('about') ?></h5>
                        <p id="details_add"></p>
                    </div>

                    <div class="brow_service">
                        <div class="row">
                            <div class="col-md-4 text-left">
                                <p class="servicet"><?php echo trans('service') ?></p>
                                <article class="skeleton">
                                    <div class="image"></div>
                                    <p class="line"></p>
                                    <p class="line2"></p>
                                </article>
                            </div>
                            <div class="col-md-4 text-left">
                                <p class="servicet"><?php echo trans('service') ?></p>
                                <article class="skeleton">
                                    <div class="image"></div>
                                    <p class="line"></p>
                                    <p class="line2"></p>
                                </article>
                            </div>
                            <div class="col-md-4 text-left">
                                <p class="servicet"><?php echo trans('service') ?></p>
                                <article class="skeleton">
                                    <div class="image"></div>
                                    <p class="line"></p>
                                    <p class="line2"></p>
                                </article>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="position-relative hide">
                <a href="<?php echo base_url() ?>">
                    <h1 class="text-white display-4 font-weight-normal" data-aos="fade-up" data-aos-duration="300">
                        <?php echo html_escape(settings()->site_name); get_pres_values();?></h1>
                </a>
                <p class="lead text-white-90 mb-0 w-85 w-xl-70 mx-auto" data-aos="fade-up" data-aos-duration="400">
                    <?php echo html_escape(settings()->description) ?>
                </p>
            </div>

            <div class="position-absolute right-0 bottom-0 left-0 text-center text-white p-5 hide">
                <div class="row">
                    <div class="col-6">
                        <p class="mb-0 mt-1"><span class="text-white-85">
                                <?php echo html_escape(settings()->copyright) ?></span></p>
                    </div>
                    <div class="col-6">
                        <ul class="list-inline-item mb-0">
                            <li class="list-inline-item"><a href="<?php echo base_url('page/privacy-policy') ?>"
                                    class="text-white-85 hover-white"><?php echo trans('privacy') ?></a></li>
                            <li class="list-inline-item"><a href="<?php echo base_url('page/terms-of-service') ?>"
                                    class="text-white-85 hover-white"><?php echo trans('terms') ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Left content -->
    <?php endif ?>



    <?php if (isset($page_title) && $page_title == 'Email Verification'): ?>
    <!-- email verify -->
    <div class="container">
        <div class="row justify-content-center justify-content-lg-start">
            <div class="col-md-8 col-lg-7 col-xl-5 offset-lg-2 offset-xl-3 my-5" data-aos="fade-down" data-aos-duration="400">
                    <?php $verify_type = $_GET['type']; ?>
         
                    <div class="mb-3 text-center">
                        <img class="mb-4" width="30%" src="<?php echo base_url('assets/front/img/message.png') ?>">
                        <p><?php echo trans('we-have-send-a-verification-code-in-your') ?> <?php if($verify_type == 'sms'){echo trans('phone');}else{echo trans('email');} ?>.</p>
                    </div>

                    <form id="verify_from" method="post" action="<?php echo base_url('auth/verify_account'); ?>">

                        <div class="row justify-content-center">
                            <div class="col-6 mb-2">
                                <div class="form-group">
                                    <input type="text" class="form-control text-center" name="code" placeholder="<?php echo trans('enter-code-here') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-6">
                                <input type="hidden" name="type" value="<?php echo html_escape($verify_type) ?>">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                <button type="submit" class="btn btn-success btn-block mb-0 verify_btn"><i class="fas fa-check-circle"></i> <?php echo trans('verify-code') ?></button>
                            </div>
                        </div>


                        <div class="loader mb-2 mt-4 text-primary text-center hide"><?php echo trans('sending') ?> <i class="fa fa-spinner fa-spin"></i></div>

                        <div class="text-center text-small mt-2">
                            <?php if ($verify_type == 'sms'): ?>
                                <span>Don't received any code? <a class="resend_mail" href="<?php echo base_url('auth/resend_sms') ?>"><?php echo trans('resend') ?></a></span>
                            <?php else: ?>
                                <span>Don't received any code? <a class="resend_mail" href="<?php echo base_url('auth/resend') ?>"><?php echo trans('resend') ?></a></span>
                            <?php endif ?>

                            <p><a class="btn btn-light-secondary btn-sm mt-2" href="<?php echo base_url() ?>"><i
                                class="fas fa-long-arrow-alt-left"></i> <?php echo trans('back') ?> </a></p>
                        </div>

                    </form>

            </div>
        </div>
    </div>
    <!-- End email verify -->
    <?php endif ?>
</div>