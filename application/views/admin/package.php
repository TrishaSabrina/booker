<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <?php include"include/breadcrumb.php"; ?>

    <!-- Main content -->
    <div class="content">
      
        <?php if (isset($page_title) && $page_title == "Package"): ?>
            <div class="container">
              <div class="row pb-5">
                <?php $i=1; foreach ($packages as $package): ?>
                  <div class="col-lg-4 col-sm-12 col-xs-12 text-center">

                      <?php if ($package->status == 1): ?>
                        <div class="custom-control custom-switch mb-2 mt-4">
                            <input type="checkbox" name="enable_faq" class="custom-control-input plan_status" data-id="<?php echo html_escape($package->id) ?>" value="2" id="switch-<?= $package->id ?>" <?php if(settings()->enable_faq == 1){echo "checked";} ?>>
                            <label class="custom-control-label" for="switch-<?= $package->id ?>"><?php echo trans('hide') ?></label>
                            <p class="text-muted"><small><?php echo trans('disable-to-hide-this-plan') ?></small></p>
                        </div>
                      <?php else: ?>
                        <div class="custom-control custom-switch mb-2 mt-4">
                            <input type="checkbox" name="enable_faq" class="custom-control-input plan_status" data-id="<?php echo html_escape($package->id) ?>" value="1" id="switch-<?= $package->id ?>">
                            <label class="custom-control-label" for="switch-<?= $package->id ?>"><?php echo trans('active') ?></label>
                            <p class="text-muted"><small><?php echo trans('enable-to-active-this-plan') ?></small></p>
                        </div>
                      <?php endif ?>

                     <div class="pricing-table purple text-center shadow-sm">

                        <?php if ($package->status == 1): ?>
                          <span class="badge badge-secondary font-weight-bold"><i class="lni lni-user"></i> <?php echo get_total_user_by_package($package->id) ?></span>

                          <label class="badge badge-success brd-20"><i class="lnib lni-checkmark"></i> <?php echo trans('active') ?></label>
                        <?php else: ?>
                          <span class="badge badge-secondary font-weight-bold"><i class="fas fa-users"></i> <?php echo get_total_user_by_package($package->id) ?></span>

                          <label class="badge badge-warning brd-20"><i class="fas fa-eye-slash"></i> <?php echo trans('hidden') ?></label>
                        <?php endif ?>

                        <h3 class="mb-2 mt-3"><?php echo html_escape($package->name); ?></h3>
                        
                        
                        <!-- Price -->
                        <div class="price-tag mt-0">
                           <span class="symbols <?php if(settings()->curr_locate == 0){echo "d-inline-block";}else{echo "d-hide";} ?>"><?php echo settings()->currency_symbol ?></span>
                           <span class="amount-sm"><?php echo number_format($package->monthly_price, settings()->num_format); ?></span>
                           <span class="symbol <?php if(settings()->curr_locate == 1){echo "d-inline-block";}else{echo "d-hide";} ?>"><?php echo settings()->currency_symbol ?></span>

                           <span class="after">/<?php echo trans('month') ?></span>
                           
                           -
                           
                           <span class="symbols <?php if(settings()->curr_locate == 0){echo "d-inline-block";}else{echo "d-hide";} ?>"><?php echo settings()->currency_symbol ?></span>
                           <span class="amount-sm"><?php echo number_format($package->price, settings()->num_format); ?></span>
                           <span class="symbol <?php if(settings()->curr_locate == 1){echo "d-inline-block";}else{echo "d-hide";} ?>"><?php echo settings()->currency_symbol ?></span>

                           <span class="after">/<?php echo trans('year') ?></span>

                           <?php if (settings()->enable_lifetime == 1): ?>
                           -
                           <span class="symbols <?php if(settings()->curr_locate == 0){echo "d-inline-block";}else{echo "d-hide";} ?>"><?php echo settings()->currency_symbol ?></span>
                           <span class="amount-sm"><?php echo number_format($package->lifetime_price, settings()->num_format); ?></span>
                           <span class="symbol <?php if(settings()->curr_locate == 1){echo "d-inline-block";}else{echo "d-hide";} ?>"><?php echo settings()->currency_symbol ?></span>

                           <span class="after">/<?php echo trans('lifetime') ?></span>
                           <?php endif; ?>

                        </div>

                          <?php $package_slug = $package->slug; ?>
                        
                          <!-- Features -->
                          <div class="pricing-features">
                              <?php if (empty($package->features)): ?>
                                Features not selected !
                              <?php else: ?>
                                <?php foreach ($features as $all_feature): ?>

                                  <?php foreach ($package->features as $feature): ?>
                                      <?php if ($feature->feature_id == $all_feature->id): ?>
                                          <?php $icon = 'lnib lni-checkmark text-success'; break; ?>
                                      <?php else: ?>
                                          <?php $icon = 'lnib lni-close text-danger'; ?>
                                      <?php endif ?>
                                  <?php endforeach ?>

                                  <?php $limit = get_feature_limit($all_feature->id)->$package_slug; ?>

                                  <div class="features flex-between">
                                    <div class="feature-item-left">
                                      <?php if(isset($limit) && $limit > 0){echo html_escape($limit);}else{ echo "<b><i class='lnib lni-infinite'></i></b>";}; ?> 
                                      <span><?php echo trans($all_feature->slug) ?></span>
                                    </div>
                                    <span class="limits"><i class="<?php echo html_escape($icon); ?>"></i></span> 
                                  </div>
                                <?php endforeach ?>
                              <?php endif ?>
                          </div>
                        <!-- Button -->
                        <a class="btn btn-secondary btn-block mt-4" href="<?php echo base_url('admin/package/edit/'.$package->id) ?>"><i class="lni lni-pencil"></i> <?php echo trans('edit-plan') ?></a>
                     </div>
                  </div>
                <?php endforeach ?>
              </div>
            </div>
        <?php endif; ?>

        <?php if (isset($page_title) && $page_title == "Edit"): ?>
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-12">
                <div class="card">

                    <div class="card-header">
                      <h3 class="card-title"><?php echo trans('update-plan') ?> - <?php echo html_escape($package[0]['name']) ?></h3>
                      <div class="card-tools">
                        <a href="<?php echo base_url('admin/package') ?>" class="btn btn-tool btn-default"><i class="fas fa-chevron-left"></i> <?php echo trans('back') ?></a>
                      </div>
                    </div>  

                    <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/package/add')?>" role="form" novalidate>
                   
                      <div class="card-body">

                        <div class="row">
                          <div class="col-md-4">
                            <h3 class="mb-0"><?php echo trans('plan') ?></h3>
                            <p class="text-muted"><?php echo trans('manage-your-plan') ?></p>
                          </div>

                          <div class="col-md-8">
                              <div class="form-group">
                                <label><?php echo trans('plan-name') ?> <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required name="name" value="<?php echo html_escape($package[0]['name']); ?>" >
                              </div>

                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <label><?php echo trans('monthly-price') ?> <span class="text-danger">*</span></label>
                                    <input type="price" class="form-control" required name="monthly_price" value="<?php echo html_escape($package[0]['monthly_price']); ?>" >
                                    <p><i class="fa fa-question-circle text-primary"></i> <?php echo trans('set-0-price-for-free-package') ?></p>
                                  </div>
                                </div>

                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <label><?php echo trans('yearly-price') ?> <span class="text-danger">*</span></label>
                                    <input type="price" class="form-control" required name="price" value="<?php echo html_escape($package[0]['price']); ?>" >
                                    <p><i class="fa fa-question-circle text-primary"></i> <?php echo trans('set-0-price-for-free-package') ?></p>
                                  </div>
                                </div>

                                
                                <div class="col-sm-4">
                                  <div class="form-group <?php if (settings()->enable_lifetime != 1){echo 'd-hide';} ?>">
                                    <label><?php echo trans('lifetime-price') ?> <span class="text-danger">*</span></label>
                                    <input type="price" class="form-control" required name="lifetime_price" value="<?php echo html_escape($package[0]['lifetime_price']); ?>">
                                    <p><i class="fa fa-question-circle text-primary"></i> <?php echo trans('set-0-price-for-free-package') ?></p>
                                  </div>
                                </div>
                      

                              </div>
                              
                          </div>
                        </div>

                          
                        <div class="row mt-50">
                          <div class="col-md-4">
                            <h3 class="mb-0"><?php echo trans('plan-settings') ?></h3>
                            <p class="text-muted"><?php echo trans('choose-which-features') ?></p>
                          </div>


                          <div class="col-md-8 p-20 plan-item">
                            
                              <?php $checked = ''; ?>
                              <?php $slug = $package[0]['slug'];?>
                              <?php $p=50; foreach ($features as $feature): ?>
                                <?php foreach ($assign_features as $asg_feature): ?>
                                  <?php if ($asg_feature->feature_id == $feature->id): ?>
                                      <?php $checked = 'checked'; break; ?>
                                  <?php else: ?>
                                      <?php $checked = ''; ?>
                                  <?php endif ?>
                                <?php endforeach ?>

                                <div class="custom-control custom-switch">
                                    <div class="row">
                                       <div class="col-sm-6"> 
                                          <input type="checkbox" name="features[]" value="<?php echo html_escape($feature->id); ?>" class="custom-control-input" id="switch-<?php echo html_escape($p);?>" <?php echo html_escape($checked); ?>>
                                          <label class="custom-control-label" for="switch-<?php echo html_escape($p);?>"><?php echo html_escape($feature->name) ?></label>
                                          <p class="text-muted mb-2"><small><?php echo trans('enable-access-to') ?> <?php echo html_escape($feature->name) ?> <?php echo trans('feature-in-this-plan') ?></small></p>
                                       </div>

                                       <div class="col-sm-4 mr-auto"> 
                                          <?php if ($feature->is_limit == 1): ?>
                                            <div class="form-group">
                                              <input type="number" class="form-control custom" name="limits[]" value="<?php if(isset($feature->$slug)){echo html_escape($feature->$slug);}else{echo "0";} ?>" placeholder="Set limit for <?php echo html_escape($feature->name) ?>">
                                              <input type="hidden" name="ids[]" value="<?php echo html_escape($feature->id) ?>">
                                              <small><?php echo trans('set-limit-1-for-unlimited') ?></small>
                                            </div>
                                          <?php endif ?>
                                       </div>
                                    </div>
                                </div>
                                
                              <?php $p++; endforeach ?>
                          </div>
                        </div>

                      </div>

                      <div class="card-footer text-right">
                        <input type="hidden" name="id" value="<?php echo html_escape($package['0']['id']); ?>">
                        <!-- csrf token -->
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

                        
                        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> <?php echo trans('save-changes') ?> </button>
                      </div>

                    </form>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>

    </div>
    <!-- /.content -->
</div>
