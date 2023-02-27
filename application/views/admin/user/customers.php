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
                  <h3 class="card-title"><?php echo trans('edit') ?></h3>
                <?php else: ?>
                  <h3 class="card-title"><?php echo trans('create-new') ?> </h3>
                <?php endif; ?>

                <div class="card-tools pull-right">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <a href="<?php echo base_url('admin/customers') ?>" class="pull-right btn btn-secondary btn-sm"><i class="fa fa-angle-left"></i> Back</a>
                  <?php else: ?>
                    <a href="#" class="text-right btn btn-secondary cancel_btn btn-sm"><?php echo trans('customers') ?></a>
                  <?php endif; ?>
                </div>
              </div>


              <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/customers/add')?>" role="form" novalidate>
                <div class="card-body">

                    <div class="form-group">
                      <label><?php echo trans('name') ?> <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" required name="name" value="<?php if(isset($customer[0]['name'])){echo html_escape($customer[0]['name']);} ?>">
                    </div>

                    
                    <div class="form-group">
                      <label><?php echo trans('email') ?> <span class="text-danger">*</span></label>
                      <input type="email" class="form-control" name="email" placeholder="<?php echo trans('enter-email-for-username') ?>" value="<?php if(isset($customer[0]['email'])){echo html_escape($customer[0]['email']);} ?>" required>
                    </div>

                    <div class="form-group">
                      <label><?php echo trans('password') ?></label>
                      <input type="password" class="form-control" name="password" placeholder="<?php echo trans('set-or-reset-password') ?>" value="">
                    </div>

                    <div class="form-group">
                      <label><?php echo trans('phone') ?></label>
                      <input type="text" class="form-control" name="phone" value="<?php if(isset($customer[0]['phone'])){echo html_escape($customer[0]['phone']);} ?>" placeholder="<?php echo trans('enter-phone-number-with-dial-code') ?> (Ex. +16100000000)">
                    </div>

                    <div class="form-group clearfix">
                      <label><?php echo trans('status') ?></label><br>

                      <div class="icheck-primary radio radio-inline d-inline mr-4 mt-2">
                        <input type="radio" id="radioPrimary1" value="1" name="status" <?php if(isset($customer[0]['status']) && $customer[0]['status'] == 1){echo "checked";} ?>>
                        <label for="radioPrimary1"> <?php echo trans('active') ?>
                        </label>
                      </div>

                      <div class="icheck-primary radio radio-inline d-inline">
                        <input type="radio" id="radioPrimary2" value="2" name="status" <?php if(isset($customer[0]['status']) && $customer[0]['status'] == 2){echo "checked";} ?>>
                        <label for="radioPrimary2"> <?php echo trans('disabled') ?>
                        </label>
                      </div>
                    </div>

                </div>

                <div class="card-footer">
                    <input type="hidden" name="id" value="<?php if(isset($customer[0]['id'])){echo html_escape($customer[0]['id']);} ?>">
                    <!-- csrf token -->
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

                    <?php if (isset($page_title) && $page_title == "Edit"): ?>
                      <button type="submit" class="btn btn-primary pull-left"><?php echo trans('save-changes') ?></button>
                    <?php else: ?>
                      <button type="submit" class="btn btn-primary pull-left"> <?php echo trans('save') ?></button>
                    <?php endif; ?>
                </div>

              </form>

            </div>


            <?php if (isset($page_title) && $page_title != "Edit"): ?>
              <div class="card list_area">
                <div class="card-header with-border">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <h3 class="card-title pt-2"><?php echo trans('edit') ?> <a href="<?php echo base_url('admin/customers') ?>" class="pull-right btn btn-sm btn-primary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a></h3>
                  <?php else: ?>
                    <h3 class="card-title pt-2"><?php echo trans('customers') ?> </h3>
                  <?php endif; ?>

                  <div class="card-tools pull-right">
                   <a href="#" class="pull-right btn btn-sm btn-secondary add_btn"><i class="fa fa-plus"></i> <?php echo trans('create-new') ?></a>
                  </div>
                </div>

                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-nowrap <?php if(count($customers) > 10){echo "datatable";} ?>">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo trans('avatars') ?></th>
                                <th><?php echo trans('name') ?></th>
                                <th><?php echo trans('summary') ?></th>
                                <th><?php echo trans('action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $i=1; foreach ($customers as $row): ?>
                            <tr id="row_<?php echo html_escape($row->customer_id); ?>">
                                
                                <td><?= $i; ?></td>
                                <td class="text-right"><img class="img-circle" width="50px" src="<?php echo base_url($row->thumb) ?>"></td>
                                <td>
                                  <p class="mb-0"><?php echo html_escape($row->name); ?></p>
                                  <p class="mb-0"><?php echo html_escape($row->email); ?></p>
                                </td>
                                <td>
                                  <a href="<?php echo base_url('admin/customers/details/'.md5($row->customer_id));?>" class="badge badge-primary-soft"><i class="far fa-eye"></i> <?php echo trans('view-details') ?></a>
                                </td>
                                <td class="actions">
                                  <div class="btn-group">
                                      <button type="button" class="btn btn-tool" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i>
                                      </button>
                                      <div class="dropdown-menu dropdown-menu-right" role="menu" >
                                        <a href="<?php echo base_url('admin/customers/edit/'.html_escape($row->customer_id));?>" class="dropdown-item"><?php echo trans('edit') ?></a>

                                        <a data-val="Category" data-id="<?php echo html_escape($row->customer_id); ?>" href="<?php echo base_url('admin/customers/delete/'.html_escape($row->customer_id));?>" class="dropdown-item delete_item"><?php echo trans('delete') ?></a>
                                      </div>
                                  </div>

                                </td>
                            </tr>
                            
                          <?php $i++; endforeach; ?>


                          <?php if (!empty($customers_app)): ?>
                            <?php $a=count($customers); foreach ($customers_app as $row): ?>
                              <tr id="row_<?php echo html_escape($row->customer_id); ?>">
                                  
                                  <td><?= $i; ?></td>
                                  <td class="text-right"><img class="img-circle" width="50px" src="<?php echo base_url($row->thumb) ?>"></td>
                                  <td>
                                    <p class="mb-0"><?php echo html_escape($row->name); ?></p>
                                    <p class="mb-0"><?php echo html_escape($row->email); ?></p>
                                  </td>
                                  <td>
                                    <a href="<?php echo base_url('admin/customers/details/'.md5($row->customer_id));?>" class="badge badge-primary-soft"><i class="far fa-eye"></i> <?php echo trans('view-details') ?></a>
                                  </td>
                                  <td class="actions">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-tool" data-toggle="dropdown" aria-expanded="false">
                                          <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" role="menu" >
                                          <a href="<?php echo base_url('admin/customers/edit/'.html_escape($row->customer_id));?>" class="dropdown-item"><?php echo trans('edit') ?></a>

                                          <a data-val="Category" data-id="<?php echo html_escape($row->customer_id); ?>" href="<?php echo base_url('admin/customers/delete/'.html_escape($row->customer_id));?>" class="dropdown-item delete_item"><?php echo trans('delete') ?></a>
                                        </div>
                                    </div>

                                  </td>
                              </tr>
                              
                            <?php $a++; endforeach; ?>
                          <?php endif; ?>

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
