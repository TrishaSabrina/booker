<section>
    <div class="container <?php if (empty($galleries)){echo "h-100vh";} ?> mb-4 p-0">
        <div class="row justify-content-center">
            <div class="text-center">
                <h3 class="mb-5"><?php echo trans('gallerys') ?></h3>
            </div>
            <div class="col-lg-12 br-10">
                <?php if (empty($galleries)): ?>
                    <div class="text-center">
                        <p class="text-muted m-auto pt-4"><?php echo trans('no-data-found') ?></p>
                    </div>
                <?php else: ?>
                <div class="aoxio-gallery row">
                    <?php foreach ($galleries as $image): ?>
                        <div class="col-sm-4 lift-xs mb-5">
                            <a href="<?php echo base_url($image->image); ?>" data-lightbox="example-set" data-title="<?php echo html_escape($image->title); ?>">
                                <div class="gallerybg" style="background-image: url(<?php echo base_url($image->image); ?>);"></div>
                            </a>
                        </div>
                    <?php endforeach ?>
                </div>
                <?php endif ?>

            </div>

        </div>
    </div>
</section>


