<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <?php $this->load->view('admin/include/breadcrumb'); ?>

  <!-- Main content -->
  <div class="content">
    <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="card add_area <?php if(isset($page_title) && $page_title == "Edit"){echo "d-block";}else{echo "hide";} ?>">
              <div class="card-header with-border">
                <?php if (isset($page_title) && $page_title == "Edit"): ?>
                  <h3 class="card-title pt-2"><?php echo trans('edit') ?></h3>
                <?php else: ?>
                  <h3 class="card-title pt-2"><?php echo trans('new-coupon') ?></h3>
                <?php endif; ?>

                <div class="card-tools pull-right">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <a href="<?php echo base_url('admin/coupons') ?>" class="pull-right btn btn-secondary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a>
                  <?php else: ?>
                    <a href="#" class="text-right btn btn-secondary cancel_btn btn-sm"><?php echo trans('coupons') ?></a>
                  <?php endif; ?>
                </div>
              </div>


              <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/coupons/add')?>" role="form" novalidate>
                <div class="card-body">

                    <div class="form-group">
                        <label><?php echo trans('services') ?> <span class="text-danger">*</span></label>
                        <select class="form-control select2s" name="service_id" required>
                            <option value=""><?php echo trans('services') ?></option>
                            <?php foreach ($services as $service): ?>
                            <option value="<?php echo html_escape($service->id) ?>" <?php if (isset($coupon[0]['service_id']) && $coupon[0]['service_id'] == $service->id){echo "selected";} ?>><?php echo html_escape($service->name) ?></option>
                            <?php endforeach ?>                 
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label><?php echo trans('code') ?> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" required name="code" value="<?php if(isset($coupon[0]['code'])){echo html_escape($coupon[0]['code']);} ?>">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label><?php echo trans('discount') ?> <span class="text-danger">*</span></label>
                            <div class="form-group input-group">
                                <input type="number" class="form-control" name="discount" value="<?php if(isset($coupon[0]['discount'])){echo html_escape($coupon[0]['discount']);} ?>" autocomplete="off" required>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label><?php echo trans('start-date') ?> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                <input type="text" name="start_date" class="form-control datepicker" required placeholder="Start date" autocomplete="off" value="<?php if (isset($coupon[0]['start_date'])){echo html_escape($coupon[0]['start_date']);} ?>">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-default"><i class="fas fa-calendar-alt"></i></button>
                                </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label><?php echo trans('end-date') ?> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                <input type="text" name="end_date" class="form-control datepicker" required placeholder="End date" autocomplete="off" value="<?php if (isset($coupon[0]['end_date'])){echo html_escape($coupon[0]['end_date']);} ?>">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-default"><i class="fas fa-calendar-alt"></i></button>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group mt-1">
                                <label><?php echo trans('limit') ?></label>
                                <input type="text" class="form-control" required name="usages_limit" value="<?php if(isset($coupon[0]['usages_limit'])){echo html_escape($coupon[0]['usages_limit']);} ?>">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group mt-5">
                                <div class="icheck-success d-inline">
                                    <input type="checkbox" id="checkboxPrimary2" name="once_per_customer" value="1" <?php if(isset($coupon[0]['once_per_customer']) && $coupon[0]['once_per_customer'] == 1){echo "checked";} ?>>
                                    <label for="checkboxPrimary2"> <span class="small"><?php echo trans('once-per-customer') ?></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group clearfix">
                      <label><?php echo trans('status') ?></label><br>
                      <div class="icheck-primary radio radio-inline d-inline mr-4 mt-2">
                        <input type="radio" id="radioPrimary1" value="1" name="status" <?php if(isset($coupon[0]['status']) && $coupon[0]['status'] == 1){echo "checked";} ?>>
                        <label for="radioPrimary1"> <?php echo trans('show') ?>
                        </label>
                      </div>

                      <div class="icheck-primary radio radio-inline d-inline">
                        <input type="radio" id="radioPrimary2" value="2" name="status" <?php if(isset($coupon[0]['status']) && $coupon[0]['status'] == 2){echo "checked";} ?>>
                        <label for="radioPrimary2"> <?php echo trans('hide') ?>
                        </label>
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
            <?php if (isset($page_title) && $page_title != "Edit"): ?>
              <div class="card list_area">
                <div class="card-header with-border">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <h3 class="card-title pt-2"><?php echo trans('edit') ?> <a href="<?php echo base_url('admin/coupons') ?>" class="pull-right btn btn-sm btn-primary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a></h3>
                  <?php else: ?>
                    <h3 class="card-title pt-2"><?php echo trans('coupons') ?> </h3>
                  <?php endif; ?>

                  <div class="card-tools pull-right">
                   <a href="#" class="pull-right btn btn-sm btn-secondary add_btn"><i class="fa fa-plus"></i> <?php echo trans('new-coupon') ?></a>
                  </div>
                </div>

                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo trans('code') ?></th>
                                <th><?php echo trans('discount') ?></th>
                                <th><?php echo trans('limit') ?></th>
                                <th><?php echo trans('used') ?></th>
                                <th><?php echo trans('info') ?></th>
                                <th><?php echo trans('service') ?></th>
                                <th><?php echo trans('status') ?></th>
                                <th><?php echo trans('action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $i=1; foreach ($coupons as $row): ?>
                            <tr id="row_<?php echo html_escape($row->id); ?>">
                                
                                <td><?= $i; ?></td>
                                <td>
                                  <p class="mb-0"><?php echo html_escape($row->code); ?></p>
                                </td>
                                <td>
                                  <p class="mb-0"><?php echo html_escape($row->discount); ?>%</p>
                                </td>
                                <td>
                                  <p class="mb-0"><?php echo html_escape($row->usages_limit); ?></p>
                                </td>
                                <td>
                                  <p class="mb-0"><?php echo html_escape($row->used); ?></p>
                                </td>
                                <td>
                                    <?php if(!empty($row->start_date) && !empty($row->end_date)): ?>
                                        <p class="mb-0"><span class="badge-custom badge-secondary-soft"><i class="far fa-calendar-alt"></i> <?php echo my_date_show($row->start_date).' - '.my_date_show($row->end_date)?></span></p>
                                    <?php endif;?>
                                    <p class="mb-0 mt-1"><span class="badge-custom badge-secondary-soft"><?php echo trans('once-per-customer') ?>: <?php if($row->once_per_customer == 1){echo trans('yes');}else{echo trans('no');} ?></span></p>
                                </td>
                                <td>
                                  <p class="mb-0"><?php echo get_by_id($row->service_id, 'services')->name; ?></p>
                                </td>
                                <td>
                                    <?php if ($row->status == 1): ?>
                                    <span class="badge badge-success"><i class="fas fa-check-circle"></i> <?php echo trans('active') ?></span>
                                    <?php else: ?>
                                    <span class="badge badge-secondary"><i class="fas fa-eye-slash"></i> <?php echo trans('hidden') ?></span>
                                    <?php endif ?>
                                </td> 
                                <td class="actions">
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-tool" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i>
                                      </button>
                                      <div class="dropdown-menu dropdown-menu-right" role="menu" >
                                        <a href="<?php echo base_url('admin/coupons/edit/'.html_escape($row->id));?>" class="dropdown-item"><?php echo trans('edit') ?></a>
                                        <a data-val="Category" data-id="<?php echo html_escape($row->id); ?>" href="<?php echo base_url('admin/coupons/delete/'.html_escape($row->id));?>" class="dropdown-item delete_item"><?php echo trans('delete') ?></a>
                                      </div>
                                  </div>

                                </td>
                            </tr>
                            
                          <?php $i++; endforeach; ?>
                        </tbody>
                    </table>
                  
                </div>

              </div>
            <?php endif; ?>
          </div>
      </div>
    </div>
  </div>
</div>
