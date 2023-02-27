
<?php include APPPATH.'views/include/banner2.php'; ?>

<?php if(empty($categories) && empty($services)): ?>
    <section class="bg-light">
        <div class="bg-light">
            <?php include APPPATH.'views/include/not_found_msg.php'; ?>
        </div>
    </section>
<?php endif; ?>

<!-- services -->
<?php if(!empty($categories)): ?>
<section class="bg-light pt-0">
    <div class="container p-0">
        <?php $c=1; foreach ($categories as $category): ?>
            <div class="d-flex justify-content-between align-items-center mb-0 mt-<?php if($c != 1){echo "8";} ?>">
                <h5 class="mb-0"><?php echo html_escape($category->name) ?></h5>
                <a href="<?php echo base_url('services/'.$slug) ?>" class="btn btn-light-dark btn-sm"> See More <?php echo trans('see-more') ?> <i class="lni lni-arrow-right"></i></a>
            </div> 

            <!-- Blog -->
            <div class="row">
                <?php $i=1; foreach ($category->services as $service): ?>
                    <?php include APPPATH.'views/include/service_items_2.php'; ?>
                <?php $i++; endforeach; ?>
            </div>
            <!-- End Blog -->
        <?php $c++; endforeach; ?>
    </div>
</section>
<?php endif; ?>




<!-- services -->
<?php if(!empty($services)): ?>
<section class="bg-light pt-0">
    <div class="container p-0">

        <div class="text-left mb-1 d-flex justify-content-between align-items-center">
            <h5 class="mb-1"><?php echo trans('services') ?></h5>
            <a href="<?php echo base_url('services/'.$slug) ?>" class="btn btn-light-dark btn-sm"> See More <?php echo trans('see-more') ?> <i class="lni lni-arrow-right"></i></a>
        </div> 

        <!-- Blog -->
        <div class="row">

            <?php $i=1; foreach ($services as $service): ?>
                <?php include APPPATH.'views/include/service_items_2.php'; ?>
            <?php $i++; endforeach; ?>

        </div>
        <!-- End Blog -->

    </div>
</section>
<?php endif; ?>


