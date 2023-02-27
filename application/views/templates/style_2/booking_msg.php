<section class="pt-5">
    <div class="container h-100vh mb-5 p-3">
        <div class="row pt-5">
            
            <div class="col-md-6 text-center br-10 pt-5 pb-5 m-auto shadow">
       
                <h3 class="text-success pt-5"><i class="fas fa-check-circle"></i> <?php echo trans('success') ?></h3>
                <p class="text-success mb-0"><?php echo trans('appointment-booked-successfully') ?></p>
                
                <?php if ($is_embed == true): ?>
                    <p>Manage your bookings to click this <a target="_blank" href="<?php echo base_url($slug) ?>">link</a></p>
                <?php endif ?>
            </div>

        </div>
    </div>
</section>


