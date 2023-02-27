<section class="pt-6">
    <div class="container">

        <div class="text-center mx-md-auto mb-5 mb-md-7 mb-lg-9">
            <h2 class="mb-1 custom-font"><?php echo trans('pricing-title') ?></h2>
            <p><?php echo trans('pricing-desc') ?></p>

            <div class="btn-group btn-group-toggle mt-4" data-toggle="buttons">
              <label class="btn btn-outline-primary custom-btngp active">
                <input type="radio" name="price_type" value="monthly" class="switch_price" checked> <?php echo trans('monthly') ?>
              </label>
              <label class="btn btn-outline-primary custom-btngp">
                <input type="radio" name="price_type" value="yearly" class="switch_price"> <?php echo trans('yearly') ?>
              </label>

              <?php if (settings()->enable_lifetime == 1): ?>
              <label class="btn btn-outline-primary custom-btngp">
                <input type="radio" name="price_type" value="lifetime" class="switch_price"> <?php echo trans('lifetime') ?>
              </label>
              <?php endif ?>
            </div>

        </div>

        <!-- Blog -->
        <div class="row">
            <?php $i=1; foreach ($packages as $package): ?>
              <div class="col-md-<?php echo(12/count($packages)) ?>" data-aos="fade-up" data-aos-delay="<?= $i*100;?>">
                <div class="pricing-table purple shadow-hover <?php if ($package->is_special == 1){echo "bg-primary-soft";} ?>">

                  <span class="package_titles badge badge-primary<?php if ($package->is_special != 1){echo "-soft";} ?> badge-pill"><?php echo html_escape($package->name); ?></span>

                    <!-- Price -->
                    <div class="price-tag m-0 mt-2 text-left">
                      <div class="lifetime_price d-hide">
                          <span class="symbol h4 font-weight-bold <?php if(settings()->curr_locate == 0){echo "d-show";}else{echo "d-hide";} ?>"><?php echo settings()->currency_symbol ?></span>
                          <span class="amount"><?php echo number_format($package->lifetime_price, settings()->num_format); ?></span>
                          <span class="symbol h4 font-weight-bold <?php if(settings()->curr_locate == 1){echo "d-show";}else{echo "d-hide";} ?>"><?php echo settings()->currency_symbol ?></span>
                          <span class="text-small text-muted">/ <?php echo strtolower(trans('lifetime')) ?></span>
                      </div>

                      <div class="yearly_price d-hide">
                          <span class="symbol h4 font-weight-bold <?php if(settings()->curr_locate == 0){echo "d-show";}else{echo "d-hide";} ?>"><?php echo settings()->currency_symbol ?></span>
                          <span class="amount"><?php echo number_format($package->price, settings()->num_format); ?></span>
                          <span class="symbol h4 font-weight-bold <?php if(settings()->curr_locate == 1){echo "d-show";}else{echo "d-hide";} ?>"><?php echo settings()->currency_symbol ?></span>
                          <span class="text-small text-muted">/ <?php echo trans('year') ?></span>
                      </div>

                      <div class="monthly_price">
                          <span class="symbol h4 font-weight-bold <?php if(settings()->curr_locate == 0){echo "d-show";}else{echo "d-hide";} ?>"><?php echo settings()->currency_symbol ?></span>
                          <span class="amount"><?php echo number_format($package->monthly_price, settings()->num_format); ?></span>
                          <span class="symbol h4 font-weight-bold <?php if(settings()->curr_locate == 1){echo "d-show";}else{echo "d-hide";} ?>"><?php echo settings()->currency_symbol ?></span>
                          <span class="text-small text-muted">/ <?php echo trans('month') ?></span>
                      </div>
                    </div>
                    
                    <!-- Features -->
                      <div class="pricing-features text-center">
                          <?php if (empty($package->features)): ?>
                            <?php echo trans('features-not-selected-') ?>
                          <?php else: ?>
                            <?php foreach ($features as $all_feature): ?>
                              <?php foreach ($package->features as $feature): ?>
                                  <?php if ($feature->feature_id == $all_feature->id): ?>
                                      <?php $spani = 1; $icon = 'lnib lni-checkmark'; break; ?>
                                  <?php else: ?>
                                      <?php $spani = 5; $icon = 'lni lni-close fs-12'; ?>
                                  <?php endif ?>
                              <?php endforeach ?>

                              <?php $package_slug = $package->slug; $limit = get_feature_limit($all_feature->id)->$package_slug; ?>

                              <div class="feature">
                                  <span class="list-style<?= $spani; ?> mr-2"><i class="<?php echo html_escape($icon); ?>"></i></span> 
                                 
                                  <span class="pt-2">
                                    <b class="text-dark">
                                      <?php if ($all_feature->is_limit != 0): ?>
                                        <?php if(isset($limit) && $limit > 0){echo html_escape($limit);}else{ echo '<i class="fa fa-infinity"></i>';}; ?>
                                      <?php endif ?>
                                    </b> 
                                    <?php echo trans($all_feature->slug) ?></span>
                                </div>
                            <?php endforeach ?>
                          <?php endif ?>
                      </div>
                    <!-- Button -->
                    <input type="hidden" name="billing_type" value="monthly" class="billing_type">
                    <a class="btn btn-light-primary btn-block package_btn" href="<?php echo base_url('register?plan='.$package->slug) ?>"><?php echo trans('select-plan') ?></a>
                </div>
              </div>
            <?php $i++; endforeach ?>
        </div>
        <!-- End Blog -->

    </div>
</section>
