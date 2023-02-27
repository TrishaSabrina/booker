<div class="col-md-6 mt-4">
    <a href="<?php echo base_url('service/'.$service->id.'/'.$slug) ?>">
        <div class="service-card border-1 lift-sm mb-2 shadow-light">
            <div class="service_img" style="background-image: url(<?php echo base_url($service->image) ?>);">
                        </div>
                <div class="service-card-body text-left flex-grow-1">
                    
                    <div class="<?php if($company->enable_rating == 1){echo "d-show";}else{echo"d-hide";} ?>">
                        <?php $rating = get_ratings_info($service->id);?>
                        <?php if (empty($ratings)): ?>
                          <?php $average = 0 ?>
                        <?php else: ?>
                          <?php $average = number_format($rating->total_point/$rating->total_user, 1) ?>
                        <?php endif ?>

                        <?php $rating = get_ratings_info($service->id);?>
                            <?php if (isset($rating->total_point) && $rating->total_point != 0): ?>
                                <?php $average = number_format($rating->total_point/$rating->total_user, 1) ?>
                            <?php endif ?>

                            <?php if (!empty($rating->total_point)): ?>
                              <?php for($u = 1; $u <= 5; $u++):?>
                                <?php 
                                  if ( round($average - .25) >= $u) {
                                        $star = "fas fa-star";
                                    } elseif (round($average + .25) >= $u) {
                                        $star = "fas fa-star-half-alt";
                                    } else {
                                        $star = "far fa-star";
                                    }
                                ?>
                                <i class="<?php echo $star;?> text-warning fs-14"></i> 
                            <?php endfor;?>
                        <?php endif ?>
                    </div>

                    
                    <p class="fs-16 text-dark mb-1 mt-1 font-weight-bold"><?php echo html_escape($service->name) ?></p>
                    <p class="fs-14 mb-1 text-dark">
                        <span class="mr-2">
                           <i class="far fa-clock text-muted"></i>  <?php echo html_escape($service->duration).' '.trans($service->duration_type); ?>
                        </span>
                        <span>
                            <?php if ($service->price == 0): ?>
                                <?php echo trans('free') ?>
                            <?php else: ?>
                                <?php if($company->curr_locate == 0){echo get_currency_by_country($company->country)->currency_symbol;} ?>
                                <?php echo number_format($service->price, $company->num_format) ?>
                                <?php if($company->curr_locate == 1){echo get_currency_by_country($company->country)->currency_symbol;} ?>
                            <?php endif ?>
                        </span>
                    </p>
                    <span class="text-muted mb-10 font-weight-normal fs-14"><?php echo strip_tags(character_limiter($service->details, 50)) ?></span>

                    <div class="d-flex align-items-center mt-4">
                        <?php $staffs = json_decode($service->staffs);?>
                        <?php if (!empty($staffs)): ?>
                        <div class="staffs-list align-items-left pl-<?php if(count($staffs) != 1){echo "3";} ?>">
                            <?php foreach ($staffs as $staff): ?>
                            <img class="staff-avatar <?php if(count($staffs) < 2){echo "ml-0";} ?>"
                                src="<?php echo base_url(get_by_id($staff, 'staffs')->thumb) ?>"
                                data-toggle="tooltip" data-placement="top"
                                title="<?php echo get_by_id($staff, 'staffs')->name; ?>">
                            <?php endforeach ?>
                        </div>
                        <?php endif ?>
                    </div>

                </div>
        </div>
    </a>
</div>

