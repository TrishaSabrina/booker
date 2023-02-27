<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <?php $this->load->view('admin/include/breadcrumb'); ?>

  <!-- Main content -->
  <div class="content">
    <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="card add_area <?php if(isset($page_title) && $page_title == "Edit"){echo "d-block";}else{echo "d-hide";} ?>">
              <div class="card-header with-border">
                <?php if (isset($page_title) && $page_title == "Edit"): ?>
                  <h3 class="card-title pt-2"><?php echo trans('edit') ?></h3>
                <?php else: ?>
                  <h3 class="card-title pt-2"><?php echo trans('new-coupon') ?></h3>
                <?php endif; ?>

                <div class="card-tools pull-right">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <a href="<?php echo base_url('admin/coupons/plan') ?>" class="pull-right btn btn-secondary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a>
                  <?php else: ?>
                    <a href="#" class="text-right btn btn-secondary cancel_btn btn-sm"><?php echo trans('coupons') ?></a>
                  <?php endif; ?>
                </div>
              </div>


                <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/coupons/add_coupon')?>" role="form" novalidate>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="example-input-normal"><?php echo trans('plan') ?> <span class="text-danger">*</span></label>
                                    <select class="form-control" name="plan" required>
                                        <option value=""><?php echo trans('select') ?></option>
                                        <?php foreach ($plans as $plan): ?>
                                            <option value="<?php echo html_escape($plan->id); ?>" 
                                              <?php if(isset($coupon[0]['plan']) && $coupon[0]['plan'] == $plan->id){echo "selected";} ?>>
                                              <?php echo html_escape($plan->name); ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="example-input-normal"><?php echo trans('billing-cycle') ?> <span class="text-danger">*</span></label>
                                    <select class="form-control" name="plan_type" required>
                                        <option value=""><?php echo trans('select') ?></option>
                                        <option value="monthly" <?php if(isset($coupon[0]['plan_type']) && $coupon[0]['plan_type'] == 'monthly'){echo "selected";} ?>><?php echo trans('monthly') ?></option>
                                        <option value="yearly" <?php if(isset($coupon[0]['plan_type']) && $coupon[0]['plan_type'] == 'yearly'){echo "selected";} ?>><?php echo trans('yearly') ?></option>
                                        <?php if (settings()->enable_lifetime == 1): ?>
                                        <option value="lifetime" <?php if(isset($coupon[0]['plan_type']) && $coupon[0]['plan_type'] == 'lifetime'){echo "selected";} ?>><?php echo trans('lifetime') ?></option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 d-hide">
                                <div class="form-group">
                                    <label class="control-label" for="example-input-normal"><?php echo trans('discount').' '.trans('type') ?> <span class="text-danger">*</span></label>
                                    <select class="form-control" name="discount_type">
                                        <option value=""><?php echo trans('select') ?></option>
                                        <option value="discount" selected><?php echo trans('discount') ?></option>
                                        <option value="redemable"><?php echo trans('redemable') ?>Redemable</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <label class="mb-0"><?php echo trans('name') ?><span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" value="<?php if(isset($coupon[0]['name'])){echo html_escape($coupon[0]['name']);} ?>" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <label class="mb-0"><?php echo trans('code') ?> <span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="code" value="<?php if(isset($coupon[0]['code'])){echo html_escape($coupon[0]['code']);} ?>" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="col-sm-12 d-hide">
                                <label><?php echo trans('days') ?> <span class="text-danger">*</span></label>
                                <div class="form-group mb-1">
                                    <input type="number" class="form-control" name="days" value="" autocomplete="off">
                                </div>
                                <p class="small"><?php echo trans('how-many-days-will-be-active-this-coupon') ?></p>
                            </div>

                            <div class="col-sm-12">
                                <label><?php echo trans('discount') ?> <span class="text-danger">*</span></label>
                                <div class="form-group input-group mb-1">
                                    <input type="number" class="form-control" name="discount" value="<?php if(isset($coupon[0]['discount'])){echo html_escape($coupon[0]['discount']);} ?>" autocomplete="off">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <p class="small"><?php echo trans('discount-must-be-between') ?></p>
                            </div>

                            <div class="col-sm-12">
                                <label><?php echo trans('quantity') ?> <span class="text-danger">*</span></label>
                                <div class="form-group mb-1">
                                    <input type="number" class="form-control" name="quantity" value="<?php if(isset($coupon[0]['quantity'])) {echo html_escape($coupon[0]['quantity']);} ?>" autocomplete="off" required>
                                </div>
                                <p class="small">How many time the code can be used</p>
                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <input type="hidden" name="id" value="<?php if(isset($coupon[0]['id'])){echo html_escape($coupon[0]['id']);} ?>">
                        <!-- csrf token -->
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

                        <?php if (isset($page_title) && $page_title == "Edit"): ?>
                          <button type="submit" class="btn btn-primary pull-left"> <?php echo trans('save-changes') ?></button>
                        <?php else: ?>
                          <button type="submit" class="btn btn-primary pull-left"> <?php echo trans('save') ?></button>
                        <?php endif; ?>
                    </div>

                </form>

            </div>
          </div>

          <div class="col-lg-12">

            <?php if (settings()->enable_coupon == 0): ?>
             
                <h5><?php echo trans('coupons') ?></h5>
                <div class="card-body text-center mt-3">
                    <p class="text-danger mb-0 py-4"><i class="fas fa-ban"></i><br> <?php echo trans('disabled') ?></p>
                    <p class="badge badge-secondary-soft fs-14"><?php echo trans('enable-coupon-from') ?> <strong><?php echo trans('settings') ?> <i class="fas fa-long-arrow-alt-right"></i> <?php echo trans('website-settings') ?> <i class="fas fa-long-arrow-alt-right"></i> <?php echo trans('preferences') ?><strong></p>
                </div>
            <?php else: ?>

                <?php if (isset($page_title) && $page_title != "Edit"): ?>
                  <div class="card list_area">
                    <div class="card-header with-border">
                      <?php if (isset($page_title) && $page_title == "Edit"): ?>
                        <h3 class="card-title pt-2"><?php echo trans('edit') ?> <a href="<?php echo base_url('admin/coupons/plan') ?>" class="pull-right btn btn-sm btn-primary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a></h3>
                      <?php else: ?>
                        <h3 class="card-title pt-2"><?php echo trans('coupons') ?> </h3>
                      <?php endif; ?>

                      <div class="card-tools pull-right">
                       <a href="#" class="pull-right btn btn-sm btn-secondary add_btn"><i class="fa fa-plus"></i> <?php echo trans('new-coupon') ?></a>
                      </div>
                    </div>

                    <div class="card-body table-responsive p-0">

                        <table class="table table-hover text-nowrap <?php if(count($coupons) > 8){echo "datatable";} ?>">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo trans('plans') ?></th>
                                    <th><?php echo trans('coupons') ?></th>
                                    <th><?php echo trans('status') ?></th>
                                    <th><?php echo trans('action') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php $i=1; foreach ($coupons as $row): ?>
                                <tr id="row_<?php echo html_escape($row->uid); ?>">
                                    <td><?= $i; ?></td>
                                    <td>
                                      <p class="mb-0 fs-14 font-weight-bold"><?php echo html_escape($row->plan_name); ?></p>
                                      <p class="mb-0 fs-12"><?php echo html_escape($row->plan_type); ?></p>
                                    </td>
                                    <td>

                                      <p class="mb-0"><?php echo trans('name') ?>: <?php echo html_escape($row->name); ?></p>
                                      <p class="mb-0"><?php echo trans('code') ?>: <?php echo html_escape($row->code); ?></p>
                                      <p class="mb-0"><?php echo ucfirst($row->discount_type); ?> (<?php echo $row->discount; ?>%)</p>
                                      <p class="mb-0"><?php echo trans('quantity') ?>: <?php echo html_escape($row->quantity); ?></p>

                                      <?php if ($row->discount_type == 'redemable'): ?>
                                        <p class="mb-0"><?php echo count_by_uid($row->uid); ?> <?php echo trans('codes') ?></p>
                                        <p class="mb-0"><?php echo $row->days; ?> <?php echo trans('days') ?></p>
                                      <?php else: ?>
                                      <?php endif ?>
                                    </td>
                                    <td>
                                      <?php if ($row->status == 1): ?>
                                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> <?php echo trans('active') ?></span>
                                      <?php else: ?>
                                        <span class="badge badge-warning-soft"><i class="fas fa-eye-slash"></i> <?php echo trans('disabled') ?></span>
                                      <?php endif ?>
                                    </td>
                                    <td class="actions">
                                        <div class="btn-group">
                                          <button type="button" class="btn btn-tool" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-h"></i>
                                          </button>
                                          <div class="dropdown-menu dropdown-menu-right" role="menu" >
                                            
                                            <?php if ($row->status == 1): ?>
                                                <a href="<?php echo base_url('admin/coupons/plan_status_action/2/'.html_escape($row->id));?>" class="dropdown-item">  <?php echo trans('deactivate') ?></a>
                                            <?php else: ?>
                                                <a href="<?php echo base_url('admin/coupons/plan_status_action/1/'.html_escape($row->id));?>" class="dropdown-item">  <?php echo trans('activate') ?></a>
                                            <?php endif ?>

                                            <a href="<?php echo base_url('admin/coupons/edit_plan_coupon/'.html_escape($row->id));?>" class="dropdown-item"><?php echo trans('edit') ?></a>

                                            <a data-val="Category" data-id="<?php echo html_escape($row->uid); ?>" href="<?php echo base_url('admin/coupons/delete_plan_coupons/'.html_escape($row->id));?>" class="dropdown-item delete_item"><?php echo trans('delete') ?></a>
                                          </div>
                                      </div>

                                    </td>
                                </tr>
                                
                              <?php $i++; endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>

                  </div>
                <?php endif; ?>
            <?php endif; ?>
            
          </div>
        </div>
    </div>
  </div>
</div>
