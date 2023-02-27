<!-- Footer -->
<?php if (isset($menu) && $menu == TRUE): ?>
<footer class="pt-4 border-top border-light">

    <div class="container">
        <div class="row pb-2">
            <div class="col-sm-5 col-lg-5 mb-5 mb-lg-0">
                <img width="150px" src="<?php echo base_url(settings()->logo) ?>" class="w-md-30 mb-2" alt="logo">
                <p class=""><?php echo html_escape(settings()->footer_about) ?></p>
                <ul class="list-unstyled social-icon2 mb-0">
                    <?php if (!empty($settings->facebook)) : ?>
                        <li><a target="_blank" href="<?= prep_url($settings->facebook) ?>"><i class="lni lni-facebook-original"></i></a></li>
                    <?php endif ?>

                    <?php if (!empty($settings->twitter)) : ?>
                        <li><a target="_blank" href="<?= prep_url($settings->twitter) ?>"><i class="lni lni-twitter"></i></a></li>
                    <?php endif ?>

                    <?php if (!empty($settings->linkedin)) : ?>
                        <li><a target="_blank" href="<?= prep_url($settings->linkedin) ?>"><i class="lni lni-linkedin-original"></i></a></li>
                    <?php endif ?>

                    <?php if (!empty($settings->instagram)) : ?>
                        <li><a target="_blank" href="<?= prep_url($settings->instagram) ?>"><i class="lni lni-instagram-original"></i></a></li>
                    <?php endif ?>
                </ul>
            </div>

            <div class="col-sm-1 col-lg-1 mb-5 mb-sm-0"></div>

            <div class="col-sm-3 col-lg-3 mb-5 mb-lg-0">
                <h3 class="h6"><?php echo trans('services') ?></h3>
                <ul class="footer-list-style-two">
                    <li><a href="<?php echo base_url('pricing') ?>"><?php echo trans('pricing') ?></a></li>
                    
                    <?php if (settings()->enable_blog == 1): ?>
                        <li><a href="<?php echo base_url('blogs') ?>"><?php echo trans('blogs') ?></a></li>
                    <?php endif; ?>

                    <?php if (settings()->enable_faq == 1): ?>
                    <li><a href="<?php echo base_url('faqs') ?>"><?php echo trans('faqs') ?></a></li>
                    <?php endif; ?>

                    <li><a href="<?php echo base_url('contact') ?>"><?php echo trans('contact') ?></a></li>
                </ul>
            </div>

            <div class="col-sm-3 col-lg-3 mb-5 mb-sm-0">
                <?php if (!empty(get_pages(0))): ?>
                <h3 class="h6"><?php echo trans('pages') ?></h3>
                <ul class="footer-list-style-two">
                    <?php foreach (get_pages(0) as $page): ?>
                        <li><a href="<?php echo base_url('page/'.$page->slug) ?>"><?php echo html_escape($page->title) ?></a></li>
                    <?php endforeach ?>
                </ul>
                <?php endif ?>
            </div>

        </div>
    </div>

    <div class="text-center border-top">
        <div class="container">
            <div class="row py-2">
                <div class="col-md-12">
                    <p class="mb-0"><?php echo html_escape(settings()->copyright) ?></p>
                </div>
            </div>
        </div>
    </div>

</footer>

<?php endif; ?>

<?php if (isset($page) && $page == 'Company'): ?>
    <div class="text-center border-top <?php if(isset($is_embed)){echo 'd-hide';} ?>">
        <div class="container">
            <div class="row py-2">
                <div class="col-md-12">
                    <p class="mb-0"><?php echo trans('powrered-by') ?> <a target="_blank" href="<?php echo base_url() ?>"><img width="80px" src="<?php echo base_url(settings()->logo) ?>"></a> </p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- End Footer -->

</div>

    <?php include'js_msg_list.php'; ?>

    <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
    <?php $success = $this->session->flashdata('msg'); ?>
    <?php $error = $this->session->flashdata('error'); ?>

    <input type="hidden" id="success" value="<?php if(isset($success)){echo html_escape($success);} ?>">
    <input type="hidden" id="error" value="<?php if(isset($error)){echo html_escape($error);} ?>">  
    <input type="hidden" id="cp" value="<?php echo strlen(settings()->purchase_code);?>">
    <a href="javascript:void(0)" class="scroll-to-top"><i class="fa fa-angle-up"></i></a>
    <input type="hidden" class="accept_cookies" value="<?php echo trans('accept_cookies') ?>">
    <input type="hidden" class="accept" value="<?php echo trans('accept') ?>">
    <input type="hidden" id="country_code" value="<?php echo strtolower(settings()->code); ?>">
    <input type="hidden" id="lan_type" value="<?php echo text_dir(); ?>">
    <?php echo $this->session->unset_userdata('msg'); $this->session->unset_userdata('error'); ?>
    <!-- Global JS -->
    <script src="<?php echo base_url() ?>assets/front/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>assets/front/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?php echo base_url() ?>assets/front/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/front/libs/owl-carousel/dist/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url() ?>assets/front/libs/svg-injector/dist/svg-injector.min.js"></script>
    <script src="<?php echo base_url() ?>assets/front/libs/jarallax/dist/jarallax.min.js"></script>
    <script src="<?php echo base_url() ?>assets/front/libs/svg-injector/dist/svg-injector.min.js"></script>
    <script src="<?php echo base_url() ?>assets/front/libs/owl-carousel/dist/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url() ?>assets/front/libs/easy-responsive-tabs/js/easyResponsiveTabs.js"></script>
   
    <!-- Custom JS -->
    <script src="<?php echo base_url() ?>assets/front/js/template.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/front/js/custom.js?var=<?= settings()->version ?>&time=<?=time();?>"></script>
    <script src="<?php echo base_url()?>assets/admin/js/sweet-alert.min.js"></script>
    <script src="<?php echo base_url() ?>assets/admin/js/validation.js"></script>
    <script src="<?php echo base_url()?>assets/admin/js/tata.js"></script>
    
    <!-- animation js -->
    <?php if(settings()->enable_animation == 1): ?>
        <script src="<?php echo base_url() ?>assets/front/js/aos.js"></script>
    <?php endif; ?>
    <!-- nice select js -->
    <script src="<?php echo base_url()?>assets/admin/js/nice-select.min.js"></script>
    <script src="<?php echo base_url() ?>assets/front/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url() ?>assets/front/js/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/front/js/daterangepicker.js"></script>
    <!-- select2 js -->
    <script src="<?php echo base_url()?>assets/admin/plugins/select2/js/select2.full.min.js"></script>
    <!-- date & time picker -->
    <script src="<?php echo base_url() ?>assets/admin/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url()?>assets/admin/js/timepicker.min.js"></script>
    <script src="<?php echo base_url() ?>assets/front/js/lightbox.js"></script>
    <script src="<?php echo base_url() ?>assets/front/js/intlInputPhone.js"></script>


    <script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    
    
    <!-- stripe js -->
    <?php $this->load->view('admin/include/stripe-js.php');?>


    <div id="load_work">
        <?php $this->load->view('include/custom-js.php');?>
    </div>

    <?php if( empty($is_embed) || $is_embed==false ): ?>
        <!-- gdpr compliance code -->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/front/js/jquery.cookieMessage.min.js"></script>
        <script type="text/javascript">
            var cookieMsg = $('.accept_cookies').val();
            var accept = $('.accept').val();
            $.cookieMessage({
                'mainMessage': '<p class="mb-2">'+cookieMsg+' <a class="learn-more" href="<?php echo base_url('page/terms-of-service') ?>"><?php echo trans('learn-more') ?></a>'+'</p>',
                'acceptButton': accept,
                'fontSize': '16px',
                'backgroundColor': '#222',
            });

            <?php if (isset($page_title) && $page_title == 'Gallery'): ?>
            $(document).ready(function() {
                $(window).on('load', function() { 
                    $('.preloader').fadeOut('3000');
                });
            });
            <?php endif; ?>
        </script>
    <?php endif; ?>
    <!-- gdpr compliance code -->


    
    <?php if (isset($page_title) && $page_title == 'Appointments'): ?>
        <script type="text/javascript">
          <?php if ($company->time_format == 'HH'): ?>
            $(document).on("focusin",".timepicker", function () {
              $('input.timepicker').timepicker({ timeFormat: 'HH:mm', interval: 30 });
            });
          <?php else: ?>
            $(document).on("focusin",".timepicker", function () {
              $('input.timepicker').timepicker({ timeFormat: 'hh:mm p', interval: 30 });
            });
          <?php endif ?>
        </script>
    

        <script type="text/javascript">

             // daterangepicker
            $(function() {
               
              $('input[name="daterange"]').daterangepicker({
                opens: 'left',
                locale: {
                  format: 
                    'YYYY/MM/DD',
                    "applyLabel": "<?php echo trans('apply') ?>",
                    "cancelLabel": "<?php echo trans('cancel') ?>",
                    "fromLabel": "<?php echo trans('from') ?>",
                    "toLabel": "<?php echo trans('to') ?>",
                    "customRangeLabel": "<?php echo trans('custom') ?>",
                    "daysOfWeek": [
                        "<?php echo trans('su') ?>",
                        "<?php echo trans('mo') ?>",
                        "<?php echo trans('tu') ?>",
                        "<?php echo trans('we') ?>",
                        "<?php echo trans('th') ?>",
                        "<?php echo trans('fr') ?>",
                        "<?php echo trans('sa') ?>"
                    ],
                    "monthNames": [
                        "<?php echo trans('january') ?>",
                        "<?php echo trans('february') ?>",
                        "<?php echo trans('march') ?>",
                        "<?php echo trans('april') ?>",
                        "<?php echo trans('may') ?>",
                        "<?php echo trans('june') ?>",
                        "<?php echo trans('july') ?>",
                        "<?php echo trans('august') ?>",
                        "<?php echo trans('september') ?>",
                        "<?php echo trans('october') ?>",
                        "<?php echo trans('november') ?>",
                        "<?php echo trans('december') ?>"
                    ]
                }
                
              }, function(start, end, label) {
                // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
              });
            });
        </script>
    <?php endif ?>

</body>


</html>