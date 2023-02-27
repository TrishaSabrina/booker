<?php include"topbar.php"; ?>


<section class="bg-lights p-4 cus-account">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-10 col-xl-8">
                <h4 class="mb-0"><?php echo trans('booking-confirmation') ?></h4>
                <p class="w-100 w-lg-80 mx-auto mb-0"><?php echo trans('confirm-the-booking') ?></p>
            </div>
        </div>
    </div>

    <div class="container mt-7">
        <div class="row justify-content-center">
            <div class="col-lg-8 card shadow-light br-10">

                <div class="booking_confirm">
                    <div class="row" data-aos="fade-up" data-aos-duration="150">
                       
                        <div class="col-md-6">
                            <p class="mb-0"><?php echo trans('booking-number') ?> </p>
                            <h4># <?php echo html_escape($appointment->number) ?></h4>
                        </div>

                        <div class="col-md-6 text-right">
                            <?php if (!empty(settings()->google_client_id) && !empty(settings()->google_client_secret)): ?>
                                <?php if (check_user_feature_access($appointment->user_id, 'google-calendar-sync') == TRUE): ?>
                                    <?php if ($appointment->sync_calendar != 1): ?>
                                        <a target="_blank" href="<?php echo base_url('googlecalendar/login') ?>" class="btn btn-danger btn-sm mt-1 mr-2"><i class="fas fa-calendar-check"></i> Sync Google Calendar</a>
                                    <?php endif ?>
                                <?php endif ?>
                            <?php endif ?>

                            <a href="<?php echo base_url('customer/appointments') ?>" class="btn btn-outline-secondary btn-sm mt-1"><i class="lnib lni-arrow-left"></i> <?php echo trans('back') ?></a>
                            <button type="button" class="btn btn-outline-secondary btn-sm mt-3 hide"><i class="fas fa-print"></i> Print</button>
                        </div>
                    </div>
                
                    <div class="row mt-2" data-aos="fade-up" data-aos-duration="250">
                        <div class="col-md-12 mb-2 text-left">
                            <h5 class="mb-2 h5 info-title"><?php echo trans('booking-info') ?></h5>
                        </div>
                        
                        <div class="col-md-6 mb-2 text-left">
                            <p class="small mb-0"><i class="far fa-calendar-alt"></i> <?php echo trans('date') ?></p>
                            <p class="text-dark font-weight-normal"> <?php echo my_date_show($appointment->date) ?></p>
                        </div>

                        <div class="col-md-6 mb-2 text-left">
                            <p class="small mb-0"><i class="far fa-clock"></i> <?php echo trans('time') ?></p>
                            <p class="text-dark font-weight-normal"> <?php echo html_escape($appointment->time) ?></p>
                        </div>

                        <div class="col-md-6 mb-2 text-left">
                            <p class="small mb-0"><?php echo trans('service') ?></p>
                            <p class="text-dark font-weight-normal"><?php echo html_escape($appointment->service_name) ?></p>
                        </div>

                        <div class="col-md-6 mb-2 text-left">
                            <p class="small mb-0"><?php echo trans('staff') ?></p>
                            <p class="text-dark font-weight-normal"><?php echo html_escape($appointment->staff_name) ?></p>
                        </div>

                        <?php if ($appointment->group_booking != 0): ?>
                            <div class="col-md-6 mb-2 text-left">
                                <p class="small mb-0"><?php echo trans('group-booking') ?></p>
                                <p class="text-dark font-weight-normal"><?php echo trans('yes') ?></p>
                            </div>

                            <div class="col-md-6 mb-2 text-left">
                                <?php if (!empty($appointment->staff_name)): ?>
                                    <p class="small mb-0"><?php echo trans('additional-persons') ?></p>
                                    <p class="text-dark font-weight-normal"><?php echo html_escape($appointment->total_person) ?></p>
                                <?php endif ?>
                            </div>
                        <?php endif ?>

                        <div class="col-md-12 mb-2 text-left">
                            <h5 class="mb-2 h5 info-title"><?php echo trans('payment-info') ?></h5>
                        </div>

                        <?php include APPPATH.'views/include/coupon_section.php'; ?>

                    </div>

                    <div class="row mt-2">
                        <div class="col-md-12 mt-4 payments_area">
                            <?php if (settings()->enable_wallet == 1): ?>
                                <?php $this->load->view('include/payment_section_admin.php');?>
                            <?php else: ?>
                                <?php $this->load->view('include/payment_section.php');?>
                            <?php endif ?>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>