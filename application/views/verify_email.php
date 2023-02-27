
<section class="section p-0 mt-100">
    <div class="container">
        
        <div class="spacer py-6"></div>

        <div class="row">
            <?php if (empty($code)): ?>
                <div class="col-md-12 text-center">
                    <h2 class="text-warning mb-0"><i class="icon-info"></i></h2>
                    <h3 class="mt-0 text-warning">Verify Account</h3>
                    <p class="mt-2">We have sent a link to your registered email address, please click this link to verify your account</p>
                </div>
            <?php else: ?>
                <?php if ($code == 'invalid'): ?>
                    <div class="col-md-12 text-center">
                        <h1 class="text-danger mb-5"><i class="icon-close"></i></h1>
                        <h3 class="mt-5 text-danger">Error</h3>
                        <p class="mt-2">Email verification failed!</p>

                        <a class="custom-btn custom-btn--medium custom-btn--style-2" href="<?php echo base_url() ?>">Back Home</a>
                    </div>
                <?php else: ?>
                    <div class="col-md-12 text-center">
                        <h1 class="text-success"><i class="icon-check"></i></h1>
                        <h3 class="mb-0">Congratulation's</h3>
                        <p class="mt-2">Your account successfully verified</p>

                        <a class="custom-btn custom-btn--medium custom-btn--style-2" href="<?php echo base_url('admin/dashboard/user') ?>">Continue</a>
                    </div>
                <?php endif ?>
            <?php endif ?>
        </div>

    </div>
</section>

