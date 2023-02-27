    <section class="border-bottom border-light py-8 py-lg-10">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-12 col-lg-6 order-md-1 pr-lg-5 pr-xl-0 mb-8 mb-lg-0">
                    <p class="badge badge-pill badge-primary-soft font-weight-bold fs-12 mb-2" data-aos="zoom-in"><?php echo trans('one-platform-for-any-business') ?></p>
                    <h1 data-aos="fade-left" data-aos-delay="250" class="display-4 font-weight-bold custom-fonts">
                        <?php echo trans('smart-booking-tool-to-grow-your-online-business') ?></h1>
                    <p data-aos="fade-left" data-aos-delay="250" class="text-muted fs-15 mt-3 mb-3 <?php if(text_dir() == 'rtl'){echo "pl-15";}else{echo "pr-15";} ?>"><?php echo html_escape(settings()->description) ?></p>
                    
                    <?php if (settings()->trial_days != 0): ?>
                        <a href="<?php echo base_url('register?trial=start') ?>" class="btn btn-primary mt-3 btn-pill fs-14" data-aos="fade-left" data-aos-delay="350"><?php echo trans('start') ?> <?php echo settings()->trial_days; ?> <?php echo trans('days-trial') ?></a>
                    <?php endif ?>
                </div>

                <div class="col-md-12 col-lg-6 order-md-2">
                    <div class="banner-img" data-aos="zoom-in">
                        <img src="<?php echo base_url(settings()->hero_img) ?>" class="text-right" alt="Hero Image">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php if (settings()->enable_feature == 1): ?>
        <section>
            <div class="container">

                <div class="text-center mx-auto mb-8" data-aos="fade-up">
                    <h3 class="h3 custom-fonts"><?php echo trans('the-best-solution-to-start') ?></h3>
                </div>

                <!-- Feature box -->
                <div class="row">

                    <div class="col-sm-6 col-lg-3 mb-5" data-aos="zoom-in-up" data-aos-delay="150">
                        <div class="rtlcard card shadow-hover p-4 p-xl-6 text-center h-100">
                            <div class="rtlcbody card-body p-0">
                                <div class="mb-4"><img width="50px" src="<?php echo base_url('assets/images/web.svg') ?>"></div>
                                <h3 class="h6"><?php echo trans('booking-website') ?></h3>
                                <p class="mb-0 mb-0"><?php echo trans('booking-website-title') ?> <?php echo html_escape(settings()->site_name) ?> </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3 mb-5 mb-lg-0" data-aos="zoom-in-up" data-aos-delay="250">
                        <div class="rtlcard card shadow-hover-1 transition-hover p-4 p-xl-6 text-center h-100 bg-secondary-soft">
                            <div class="rtlcbody card-body p-0">
                                <div class="mb-4"><img width="50px" src="<?php echo base_url('assets/images/calendar.svg') ?>"></div>
                                <h3 class="h6"><?php echo trans('accept-online-bookings') ?></h3>
                                <p class="mb-0"><?php echo trans('accept-online-bookings-title') ?>.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-lg-3 mb-5 mb-lg-0" data-aos="zoom-in-up" data-aos-delay="350">
                        <div class="rtlcard card shadow-hover-1 transition-hover p-4 p-xl-6 text-center  h-100">
                            <div class="rtlcbody card-body p-0">
                                <div class="mb-4"><img width="50px" src="<?php echo base_url('assets/images/profile.svg') ?>"></div>
                                <h3 class="h6"><?php echo trans('staff-client-portal') ?></h3>
                                <p class="mb-0 mb-0"><?php echo trans('staff-client-portal-title') ?>. </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3 mb-5 mb-sm-0" data-aos="zoom-in-up" data-aos-delay="450">
                        <div class="rtlcard card shadow-hover-1 transition-hover p-4 p-xl-6 text-center h-100 bg-secondary-soft">
                            <div class="rtlcbody card-body p-0">
                                <div class="mb-4"><img width="55px" src="<?php echo base_url('assets/images/valid.svg') ?>"></div>
                                <h3 class="h6"><?php echo trans('accept-payments') ?></h3>
                                <p class="mb-0"><?php echo trans('accept-payments-title') ?>. </p>
                            </div>
                        </div>
                    </div>
                    

                </div>
                <!-- End Feature box -->

            </div>
        </section>
    <?php endif; ?>

    <!-- Workflow -->
    <?php if (settings()->enable_workflow == 1): ?>
    <section>
        <div class="container">

            <div class="w-md-80 w-lg-50 text-center mx-auto mb-8 mb-lg-10" data-aos="fade-up">
                <h3 class="custom-fonts mb-1"><?php echo trans('workflow') ?></h3>
                <p><?php echo trans('workflow-title') ?></p>
            </div>

            <div class="row">
            
                <div class="col-md-4 mb-7 mb-md-0" data-aos="zoom-in-up" data-aos-delay="150">
                    <div class="text-center">
                        <div class="mb-5 workflow-img"><img class="display-5" src="<?php echo base_url() ?>assets/front/img/website.png" alt="..."></div>
                        <p class="mb-0 mx-auto w-95 w-lg-85"><?php echo trans('customize-your-appointment-schedule-and-booking-page') ?>.</p>
                    </div>
                </div>

                <div class="col-md-4 mb-7 mb-md-0" data-aos="zoom-in-up" data-aos-delay="250">
                    <div class="text-center">
                        <div class="mb-5 workflow-img"><img class="display-5" src="<?php echo base_url() ?>assets/front/img/link.png" alt="..."></div>
                        <p class="mb-0 mx-auto w-95 w-lg-85"><?php echo trans('share-your-personal-booking-page') ?>.</p>
                    </div>
                </div>

                <div class="col-md-4" data-aos="zoom-in-up" data-aos-delay="350">
                    <div class="text-center">
                        <div class="mb-5 workflow-img"><img class="display-5" src="<?php echo base_url() ?>assets/front/img/schedule.png" alt="..."></div>
                        <p class="mb-0 mx-auto w-95 w-lg-85"><?php echo trans('your-customers-prospects-book-an-available-time-with-you') ?></p>
                    </div>
                </div>

            </div>

        </div>
    </section>
    <?php endif; ?>
    <!-- End Workflow -->




    <!-- features -->
    <?php if (!empty($features)): ?>
        <section class="pt-6 pt-md-5 pt-xl-0 mt-8">

            <div class="container mt-5">
                <?php $i=1; foreach ($features as $feature): ?>
                    <div class="row align-items-center justify-content-center mt-6 mb-6" data-aos="fade-<?php if ($i % 2 == 0){echo 'left';}else{echo 'right';} ?>">
                        <?php if ($i % 2 == 0): ?>
                            <div class="col-10 col-sm-9 col-md-6 col-lg-7 text-center pr-md-5 pr-lg-10 mb-5 mb-md-0">
                                <img src="<?php echo base_url($feature->image) ?>" class="screen-one w-90" alt="Feature Image">
                            </div>

                            <div class="col-md-6 col-lg-5">
                                <h4 class="h3 mb-4 custom-fonts"><?php echo html_escape($feature->name); ?></h4>
                                <p class="leads mb-6"><?php echo html_escape($feature->details); ?></p>
                            </div>
                        <?php else: ?>
                            <div class="col-md-6 col-lg-5 order-2 order-md-1">
                                <h4 class="h3 mb-4 custom-fonts"><?php echo html_escape($feature->name); ?></h4>
                                <p class="leads mb-6"><?php echo html_escape($feature->details); ?></p>
                            </div>

                            <div class="col-10 col-sm-9 col-md-6 col-lg-7 text-center mb-5 mb-md-0 pl-md-5 pl-lg-10 order-1 order-md-2">
                                <img src="<?php echo base_url($feature->image) ?>" class="screen-one w-90" alt="Feature Image">
                            </div>
                        <?php endif ?>
                    </div>
                <?php $i++; endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
    <!-- features -->



    <!-- Blog -->
    <?php if (settings()->enable_blog == 1 && !empty($posts)): ?>
        <section class="bg-lights pt-6">
            <div class="container">
                <div class="text-center mb-5 mt-5 mb-lg-7 mt-0 mt-lg-5 mt-xl-0" data-aos="zoom-in-up">
                    <h3 class="h2 mb-3 mt-6 custom-fonts"><?php echo trans('learn-more-empower-yourself') ?></h3>
                </div>

                <div class="row">
                    <?php $b=1; foreach ($posts as $post): ?>
                        <?php include'include/blog_post_item.php'; ?>
                    <?php $b++; endforeach ?>
                </div>
            </div>
        </section>
    <?php endif ?>
    <!-- End Blog -->


    <!-- Testimonials -->
    <?php if (!empty($testimonials)): ?>
        <section class="pt-10 mt-8 bg-light">
            <div class="container-fluid mt-5">

                <div class="w-md-80 w-lg-50 text-center mx-auto mb-8 mb-lg-8">
                    <h2 class="custom-fonts mb-1"><?php echo trans('testimonials') ?></h2>
                    <p><?php echo trans('testimonial-title') ?> <b><?php echo settings()->site_name ?></b></p>
                </div>

                <div class="testimonial owl-carousel owl-theme">
                    <?php foreach ($testimonials as $testimonial): ?>
                       <div class="item text-left owl-item-cus">
                            <p class="text-dark"> <?php echo html_escape($testimonial->feedback) ?> </p>
                            <div class="d-flex align-items-center justify-content-centers">
                                <div class="md-avatar">
                                    <img class="img-fluid rounded-circle" src="<?php echo base_url($testimonial->thumb) ?>" alt="Image">
                                </div>
                                <div class="ml-3 text-left">
                                    <h4 class="h6 mb-0"><?php echo html_escape($testimonial->name) ?></h4>
                                    <small class="text-muted"><?php echo html_escape($testimonial->designation) ?></small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>

            </div>
        </section>
    <?php endif ?>
    <!-- Testimonials -->

    <section class="get_started bg-white">
        <div class="container">
            <div class="row justify-content-center">
            <div class="text-center  pb-5 pt-5">
                <h3 class="h1 mb-2 mt-0 text-primary font-weight-bold custom-fonts" data-aos="fade-up" data-aos-delay="100"><?php echo trans('start-using') ?> <?php echo html_escape(settings()->site_name) ?> <?php echo trans('account') ?></h3>
                <p class="text-dark" data-aos="fade-up" data-aos-delay="200"><?php echo trans('sign-up-for-our-14-day-trial-with-all-features') ?>.</p>
                <a href="<?php echo base_url('register?trial=start') ?>" class="badge badge-primary badge-pill py-3" data-aos="fade-up" data-aos-delay="300"><?php echo trans('get-started') ?> <i class="fas fa-long-arrow-alt-right"></i></a>
            </div>
            </div>
        </div>
    </section>