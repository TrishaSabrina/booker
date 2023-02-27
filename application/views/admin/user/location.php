<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <?php $this->load->view('admin/include/breadcrumb'); ?>

  <!-- Main content -->
  <div class="content">
    <div class="container">
        <div class="row">

          <div class="col-12">
              <div class="card-bodys p-0">
                  <div class="icheck-success d-inline mt-2">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" value="1" name="enable_location" class="enable_location custom-control-input" id="switch-2" <?php if($this->business->enable_location == 1){echo "checked";} ?>>
                        <label class="custom-control-label font-weight-bold" for="switch-2"> 
                        <?php if ($this->business->enable_location == 1): ?>
                          <?php echo trans('disable-locations') ?>
                        <?php else: ?>
                          <?php echo trans('enable-locations') ?>
                        <?php endif ?></label>

                        <?php if ($this->business->enable_location == 0): ?>
                          <p class="small"><?php echo trans('location-title-2') ?></p>
                        <?php else: ?>
                          <p class="small"><?php echo trans('disable-location-title') ?></p>
                        <?php endif ?></label>
                    </div>
                  </div>
              </div>
          </div>


          <?php if (isset($page_title) && $page_title != "Edit Sub"): ?>
          <div class="col-lg-12 col-xs-12">

            <div class="card add_area <?php if(isset($page_title) && $page_title == "Edit"){echo "d-block";}else{echo "hide";} ?>">
              <div class="card-header with-border">
                <?php if (isset($page_title) && $page_title == "Edit"): ?>
                  <h3 class="card-title"><?php echo trans('edit') ?></h3>
                <?php else: ?>
                  <h3 class="card-title"><?php echo trans('create-new') ?> </h3>
                <?php endif; ?>

                <div class="card-tools pull-right">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <a href="<?php echo base_url('admin/location') ?>" class="pull-right btn btn-secondary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a>
                  <?php else: ?>
                    <a href="#" class="text-right btn btn-secondary cancel_btn btn-sm"><?php echo trans('locations') ?></a>
                  <?php endif; ?>
                </div>
              </div>


              <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/location/add')?>" role="form" novalidate>
                <div class="card-body">

                  
                    <div class="form-group">
                      <label><?php echo trans('name') ?> <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" required name="name" value="<?php if(isset($location[0]['name'])){echo html_escape($location[0]['name']);} ?>">
                    </div>

                    <div class="form-group">
                      <label><?php echo trans('phone') ?></label>
                      <input type="text" class="form-control" name="phone" value="<?php if(isset($location[0]['phone'])){echo html_escape($location[0]['phone']);} ?>" >
                    </div>

                    <div class="form-group">
                      <label><?php echo trans('address') ?></label>
                      <textarea id="summernote" class="form-control" name="address"><?php if(isset($location[0]['address'])){echo html_escape($location[0]['address']);} ?></textarea>
                    </div>

                    <div class="form-group clearfix">
                      <label><?php echo trans('dtatus') ?></label><br>

                      <div class="icheck-primary radio radio-inline d-inline mr-4 mt-2">
                        <input type="radio" id="radioPrimary1" value="1" required name="status" <?php if(isset($location[0]['status']) && $location[0]['status'] == 1){echo "checked";} ?> <?php if (isset($page_title) && $page_title != "Edit"){echo "checked";} ?>>
                        <label for="radioPrimary1"> <?php echo trans('active') ?>
                        </label>
                      </div>

                      <div class="icheck-primary radio radio-inline d-inline">
                        <input type="radio" id="radioPrimary2" value="2" required name="status" <?php if(isset($location[0]['status']) && $location[0]['status'] == 2){echo "checked";} ?>>
                        <label for="radioPrimary2"> <?php echo trans('hidden') ?>
                        </label>
                      </div>
                    </div>

                </div>

                <div class="card-footer">
                    <input type="hidden" name="id" value="<?php if(isset($location[0]['id'])){echo html_escape($location[0]['id']);} ?>">
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
                    <h3 class="card-title pt-2">Edit location <a href="<?php echo base_url('admin/location') ?>" class="pull-right btn btn-sm btn-primary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a></h3>
                  <?php else: ?>
                    <h3 class="card-title pt-2"><?php echo trans('locations') ?> </h3>
                  <?php endif; ?>

                  <div class="card-tools pull-right">
                   <a href="#" class="pull-right btn btn-sm btn-secondary add_btn"><i class="fa fa-plus"></i> <?php echo trans('create-new') ?></a>
                  </div>
                </div>

                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-nowrap <?php if(count($locations) > 10){echo "datatable";} ?>">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo trans('name') ?></th>
                                <th><?php echo trans('address') ?></th>
                                <th><?php echo trans('status') ?></th>
                                <th><?php echo trans('action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $i=1; foreach ($locations as $row): ?>
                            <tr id="row_<?php echo html_escape($row->id); ?>">
                                
                                <td><?= $i; ?></td>
                                <td>
                                  <p class="mb-0"><?php echo html_escape($row->name); ?></p>
                                </td>
                                <td>
                                  <p class="mb-0"><?php echo html_escape($row->phone); ?></p>
                                  <p class="mb-0 small"><?php echo $row->address; ?></p>
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
                                        <a href="<?php echo base_url('admin/location/edit/'.html_escape($row->id));?>" class="dropdown-item"><?php echo trans('edit') ?></a>
                                        <a data-val="Category" data-id="<?php echo html_escape($row->id); ?>" href="<?php echo base_url('admin/location/delete/'.html_escape($row->id));?>" class="dropdown-item delete_item"><?php echo trans('delete') ?></a>
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
          <?php endif; ?>


          <?php if (isset($page_title) && $page_title != "Edit"): ?>
          <div class="col-lg-12 col-xs-12 ml-auto">

            <div class="card add_area2 <?php if(isset($page_title) && $page_title == "Edit Sub"){echo "d-block";}else{echo "hide";} ?>">
              <div class="card-header with-border">
                <?php if (isset($page_title) && $page_title == "Edit"): ?>
                  <h3 class="card-title"><?php echo trans('edit') ?></h3>
                <?php else: ?>
                  <h3 class="card-title"><?php echo trans('create-new') ?> </h3>
                <?php endif; ?>

                <div class="card-tools pull-right">
                  <?php if (isset($page_title) && $page_title == "Edit Sub"): ?>
                    <a href="<?php echo base_url('admin/location') ?>" class="pull-right btn btn-secondary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a>
                  <?php else: ?>
                    <a href="#" class="text-right btn btn-secondary cancel_btn2 btn-sm"><?php echo trans('sub-locations') ?></a>
                  <?php endif; ?>
                </div>
              </div>


              <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/location/add_sub')?>" role="form" novalidate>
                <div class="card-body">

                    <div class="form-group">
                      <label class="control-label" for="example-input-normal"><?php echo trans('locations') ?> <span class="text-danger">*</span></label>
                      <select class="form-control" name="parent_id" required>
                          <option value=""><?php echo trans('select') ?></option>
                          <?php foreach ($locations as $location): ?>
                              <option value="<?php echo html_escape($location->id); ?>" 
                                <?php echo (isset($sub_location[0]['parent_id']) && $sub_location[0]['parent_id'] == $location->id) ? 'selected' : ''; ?>>
                                <?php echo html_escape($location->name); ?>
                              </option>
                          <?php endforeach ?>
                      </select>
                    </div>
                  
                    <div class="form-group">
                      <label><?php echo trans('name') ?> <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" required name="name" value="<?php if(isset($sub_location[0]['name'])){echo html_escape($sub_location[0]['name']);} ?>">
                    </div>

                    <div class="form-group">
                      <label><?php echo trans('phone') ?></label>
                      <input type="text" class="form-control" name="phone" value="<?php if(isset($sub_location[0]['phone'])){echo html_escape($sub_location[0]['phone']);} ?>" >
                    </div>

                    <div class="form-group">
                      <label><?php echo trans('address') ?></label>
                      <textarea id="summernote" class="form-control" name="address"><?php if(isset($sub_location[0]['address'])){echo html_escape($sub_location[0]['address']);} ?></textarea>
                    </div>

                    <div class="form-group clearfix">
                      <label><?php echo trans('dtatus') ?></label><br>

                      <div class="icheck-primary radio radio-inline d-inline mr-4 mt-2">
                        <input type="radio" id="radioPrimary11" value="1" required name="status" <?php if(isset($sub_location[0]['status']) && $sub_location[0]['status'] == 1){echo "checked";} ?> <?php if (isset($page_title) && $page_title != "Edit"){echo "checked";} ?>>
                        <label for="radioPrimary11"> <?php echo trans('active') ?>
                        </label>
                      </div>

                      <div class="icheck-primary radio radio-inline d-inline">
                        <input type="radio" id="radioPrimary22" value="2" required name="status" <?php if(isset($sub_location[0]['status']) && $sub_location[0]['status'] == 2){echo "checked";} ?>>
                        <label for="radioPrimary22"> <?php echo trans('hidden') ?>
                        </label>
                      </div>
                    </div>

                </div>

                <div class="card-footer">
                    <input type="hidden" name="id" value="<?php if(isset($sub_location[0]['id'])){echo html_escape($sub_location[0]['id']);} ?>">
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


            <?php if (isset($page_title) && $page_title != "Edit Sub"): ?>
              <div class="card list_area2">
                <div class="card-header with-border">
                  <?php if (isset($page_title) && $page_title == "Edit Sub"): ?>
                    <h3 class="card-title pt-2">Edit <a href="<?php echo base_url('admin/location') ?>" class="pull-right btn btn-sm btn-primary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a></h3>
                  <?php else: ?>
                    <h3 class="card-title pt-2"><?php echo trans('sub-locations') ?> </h3>
                  <?php endif; ?>

                  <div class="card-tools pull-right">
                    <?php if (count($locations) > 0): ?>
                      <a href="#" class="pull-right btn btn-sm btn-secondary add_btn2"><i class="fa fa-plus"></i> <?php echo trans('create-new') ?></a>
                    <?php endif ?>
                  </div>
                </div>

                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-nowrap <?php if(count($sub_locations) > 10){echo "datatable";} ?>">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo trans('location') ?></th>
                                <th><?php echo trans('name') ?></th>
                                <th><?php echo trans('address') ?></th>
                                <th><?php echo trans('status') ?></th>
                                <th><?php echo trans('action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $i=1; foreach ($sub_locations as $row): ?>
                            <tr id="row_<?php echo html_escape($row->id); ?>">
                                
                                <td><?= $i; ?></td>
                                <td>
                                  <p class="mb-0"><?php echo get_by_id($row->parent_id, 'locations')->name; ?></p>
                                </td>
                                <td>
                                  <p class="mb-0"><?php echo html_escape($row->name); ?></p>
                                </td>
                                <td>
                                  <p class="mb-0 small"><?php echo html_escape($row->phone); ?></p>
                                  <p class="mb-0 small"><?php echo $row->address; ?></p>
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
                                        <a href="<?php echo base_url('admin/location/edit_sub/'.html_escape($row->id));?>" class="dropdown-item"><?php echo trans('edit') ?></a>
                                        <a data-val="Category" data-id="<?php echo html_escape($row->id); ?>" href="<?php echo base_url('admin/location/delete/'.html_escape($row->id));?>" class="dropdown-item delete_item"><?php echo trans('delete') ?></a>
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
          <?php endif; ?>
      </div>
    </div>
  </div>
</div>
