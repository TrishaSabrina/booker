
<section class="section">
    <div class="container">

        <?php if (empty($features)): ?>
            <div class="text-center">
                <h3 class="pt-300"><span>No data found!</span></h3>
            </div>
        <?php else: ?>

        <div class="section-heading section-heading--center">
            <h2 class="__title">Explore our features</h2>
        </div>

        <div class="spacer py-6"></div>
        <?php $i=1; foreach ($features as $feature): ?>
            <div class="row <?php if($i % 2 == 0){echo "flex-lg-row-reverse";} ?> align-items-md-center">
                <div class="col-12 col-lg-6">
                    <div class="section-heading">
                        <h3 class="__title"><?php echo html_escape($feature->name); ?></h3>
                    </div>

                    <div class="spacer py-2"></div>

                    <div>
                        <p>
                            <?= ($feature->details); ?>
                        </p>

                        <p class="mt-9">
                            <a class="custom-btn custom-btn--medium custom-btn--style-2" href="#">Read More</a>
                        </p>
                    </div>
                </div>

                <div class="spacer py-4 d-lg-none"></div>

                <div class="col-12 col-lg-6  text-center text-lg-<?php if($i % 2 == 0){echo "left";}else{echo "right";} ?>">
                    <img class="img-fluid" width="520" height="507" src="<?php echo base_url($feature->image) ?>" alt="demo" />
                </div>
            </div>
        <?php $i++; endforeach; ?>

        <?php endif ?>
        
    </div>
</section>