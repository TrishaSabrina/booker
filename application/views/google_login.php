
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6 m-auto mt-300">
                <div class="content-container minh-400">
                    <div class="row"><?php echo validation_errors('<div class="col-12 col-md-12 col-lg-12"><div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div></div>'); ?></div>

                    <a href="<?php print $loginUrl; ?>" id="contact-send-a" class="py-2 mt-300"><img src="<?php echo base_url('assets/images/btn_google_signin_dark_normal_web@2x.png') ?>"></a>
                </div>
            </div>
        </div>
    </div>
</section>