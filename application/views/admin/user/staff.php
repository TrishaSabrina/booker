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
                    <a href="<?php echo base_url('admin/staff') ?>" class="pull-right btn btn-secondary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a>
                  <?php else: ?>
                    <a href="#" class="text-right btn btn-secondary cancel_btn btn-sm"><?php echo trans('staff') ?></a>
                  <?php endif; ?>
                </div>
              </div>

              <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/staff/add')?>" role="form" novalidate>

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                  <li class="nav-item mr-2">
                    <a class="wh nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true"><?php echo trans('staff') ?> <?php echo trans('details') ?></a>
                  </li>
                  <li class="nav-item">
                    <a class="wh nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false"><?php echo trans('working-hours') ?></a>
                  </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="card-body">

                        <div class="form-group">
                            <?php if (isset($page_title) && $page_title == "Edit"): ?>
                                <img width="100px" class="img-thumbnail" src="<?php echo base_url($staff[0]['thumb']) ?>"> <br><br>
                            <?php endif ?>

                            <div class="custom-file w-50 mt-1">
                              <input type="file" class="custom-file-input" name="photo" id="customFileUp">
                              <label class="custom-file-label" for="customFileUp"><?php echo trans('upload-image') ?></label>
                              <p class="text-muted mt-1 fs-12 small"><i class="fas fa-info-circle"></i> <?php echo trans('for-better-view-use') ?> 200 x 200px</p>
                            </div>
                        </div>
                      
                        <div class="form-group">
                          <label><?php echo trans('name') ?> <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" required name="name" value="<?php if(isset($staff[0]['name'])){echo html_escape($staff[0]['name']);} ?>">
                        </div>

                        
                        <div class="form-group">
                          <label><?php echo trans('email') ?> <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" required name="email" placeholder="<?php echo trans('enter-email-for-username') ?>" value="<?php if(isset($staff[0]['email'])){echo html_escape($staff[0]['email']);} ?>" >
                        </div>


                        <div class="form-group">
                          <label class="control-label" for="example-input-normal"><?php echo trans('location') ?> <span class="text-danger"><?php if ($this->business->enable_location == 1){echo "*";}?></span></label>
                          <?php if(isset($staff_locations)){$staff_location = $staff_locations[0]->location_id;}else{$staff_location = 0;} ?>
                          <select class="form-control custom-select location" name="location_id" <?php if ($this->business->enable_location == 1){echo "required";}?>>
                              <option value=""><?php echo trans('select') ?></option>
                              <?php foreach ($locations as $location): ?>
                                  <option value="<?php echo html_escape($location->id); ?>" <?php if($location->id == $staff_location){echo "selected";} ?>>
                                    <?php echo html_escape($location->name); ?>
                                  </option>
                              <?php endforeach ?>
                          </select>
                        </div>

                        
                        <?php if (isset($page_title) && $page_title != "Edit"): ?>
                          <div class="sub_area d-hide">
                              <div class="select2-blue">
                                <div class="form-group">
                                  <label class="control-label" for="example-input-normal"><?php echo trans('branches') ?> </label>
                                  <select class="select2 sub_location" name="sub_location_id[]" multiple="multiple" style="width: 100%;">
                                      
                                  </select>
                                </div>
                              </div>
                          </div>
                        <?php else: ?>
                          <div class="sub_area <?php if (empty($staff_sub_locations)){echo "d-hide";}?>">
                              <div class="select2-blue">
                                <div class="form-group">
                                  <label class="control-label" for="example-input-normal"><?php echo trans('branches') ?> </label>
                                  <select class="select2 sub_location" name="sub_location_id[]" multiple="multiple" style="width: 100%;">
                                      <?php foreach ($staff_sub_locations as $staff_sub): ?>
                                          <?php foreach ($staff_locations as $staff_loc): ?>
                                            <?php if ($staff_loc->sub_location_id == $staff_sub->id): ?>
                                              <?php $selected = 'selected'; break; ?>
                                            <?php else: ?>
                                              <?php $selected = ''; ?>
                                            <?php endif ?>
                                          <?php endforeach ?>
                                          <option <?php echo $selected ?> value="<?php echo $staff_sub->id ?>"><?php echo $staff_sub->name ?></option>
                                      <?php endforeach ?>
                                  </select>
                                </div>
                              </div>
                          </div>
                        <?php endif; ?>

                   
                        <div class="form-group">
                          <label><?php echo trans('password') ?></label>
                          <input type="password" class="form-control" name="password" placeholder="<?php echo trans('set-or-reset-password') ?>" value="">
                        </div>

                        <div class="form-group">
                          <label><?php echo trans('phone') ?></label>
                          <input type="text" class="form-control" name="phone" value="<?php if(isset($staff[0]['phone'])){echo html_escape($staff[0]['phone']);} ?>" placeholder="<?php echo trans('enter-phone-number-with-dial-code') ?> (Ex. +16100000000)">
                        </div>

                        <div class="form-group clearfix">
                          <label><?php echo trans('dtatus') ?></label><br>

                          <div class="icheck-primary radio radio-inline d-inline mr-4 mt-2">
                            <input type="radio" id="radioPrimary1" value="1" required name="status" <?php if(isset($staff[0]['status']) && $staff[0]['status'] == 1){echo "checked";} ?> <?php if (isset($page_title) && $page_title != "Edit"){echo "checked";} ?>>
                            <label for="radioPrimary1"> <?php echo trans('active') ?>
                            </label>
                          </div>

                          <div class="icheck-primary radio radio-inline d-inline">
                            <input type="radio" id="radioPrimary2" value="2" required name="status" <?php if(isset($staff[0]['status']) && $staff[0]['status'] == 2){echo "checked";} ?>>
                            <label for="radioPrimary2"> <?php echo trans('hidden') ?>
                            </label>
                          </div>
                        </div>

                    </div>
                  </div>




                  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="card-body">
                      <?php $days = get_days();?>
                        <div class="row main_item">
                          <?php $i=1; foreach ($days as $day): ?>
                            
                            <?php $checks=0; $check='';?>
                            <?php foreach ($my_days as $asnday): ?>
                              <?php if ($asnday['day'] == $i) {
                                $check = 'checked';
                                $checks = $asnday['day'];
                                break;
                              } else {
                                $check = '';
                                $checks = 0;
                              }
                              ?>
                            <?php endforeach ?>

                            <div class="item-rows w-100 mb-20">
                              
                              <div class="form-group col-md-12 mb-2">
                                  <div class="custom-control custom-switch pt-10">
                                      <input type="checkbox" value="<?= $i; ?>" name="day_<?= $i-1; ?>" class="custom-control-input day_option" id="switch-<?= $i;?>" <?php if(!empty($check)){echo html_escape($check);} ?>>
                                      <label class="custom-control-label" for="switch-<?= $i;?>"><?php echo trans(strtolower($day)) ?></label>
                                  </div>
                              </div>

                              <div class="hour-item mb-2 mt-4 col-md-12 hideable_<?= $i; ?> <?php if(!empty($check)){echo 'd-show';}else{echo "d-hide";} ?>">
                                  <div class="row">
                                      <div class="col-sm-5 pr-3 mb-2">
                                            <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                              </div>
                                              <?php if($this->business->time_format == 'HH'){$mstart = $my_days[$i-1]['start'];}else{$mstart = date("h:i a", strtotime($my_days[$i-1]['start']));} ?>
                                              <input type="text" class="form-control hourpicker" name="start_hour_<?= $i-1; ?>" value="<?php echo html_escape($mstart); ?>" placeholder="<?php echo trans('opening-hour') ?>" autocomplete="off">
                                            </div>
                                      </div>

                                      <div class="col-sm-5 mb-2">
                                          <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                              </div>
                                              <?php if($this->business->time_format == 'HH'){$mend = $my_days[$i-1]['end'];}else{$mend = date("h:i a", strtotime($my_days[$i-1]['end']));} ?>

                                              <input type="text" class="form-control hourpicker" name="end_hour_<?= $i-1; ?>" value="<?php echo html_escape($mend); ?>" placeholder="<?php echo trans('end-hour') ?>" autocomplete="off">
                                          </div>
                                      </div>
                                  </div>
                              </div>


                              

                              <div class="day_highliter"></div>
                              <div class="day_divider"></div>
                            </div>
                         
                          <?php $i++; endforeach ?>

                        </div>
                    </div>
                  </div>
                </div>



                <div class="card-footer">
                    <input type="hidden" name="id" value="<?php if(isset($staff[0]['id'])){echo html_escape($staff[0]['id']);} ?>">
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
                    <h3 class="card-title pt-2">Edit Staff <a href="<?php echo base_url('admin/staff') ?>" class="pull-right btn btn-sm btn-primary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a></h3>
                  <?php else: ?>
                    <h3 class="card-title pt-2"><?php echo trans('staff') ?> </h3>
                  <?php endif; ?>

                  <div class="card-tools pull-right">
                   <a href="#" class="pull-right btn btn-sm btn-secondary add_btn"><i class="fa fa-plus"></i> <?php echo trans('create-new') ?></a>
                  </div>
                </div>

                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-nowrap <?php if(count($staffs) > 10){echo "datatable";} ?>">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-right"><?php echo trans('') ?></th>
                                <th><?php echo trans('name') ?></th>
                                <?php if ($this->business->enable_location == 1): ?>
                                  <th><?php echo trans('location') ?></th>
                                <?php endif ?>
                                <th><?php echo trans('status') ?></th>
                                <th><?php echo trans('action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $i=1; foreach ($staffs as $row): ?>
                            <tr id="row_<?php echo html_escape($row->id); ?>">
                                
                                <td><?= $i; ?></td>
                                <td class="text-right"><img class="img-circle" width="50px" height="50px" src="<?php echo base_url($row->thumb) ?>"></td>
                                <td>
                                  <p class="mb-0"><?php echo html_escape($row->name); ?></p>
                                  <p class="mb-0"><?php echo html_escape($row->email); ?></p>
                                  <p class="mb-0"><?php echo html_escape($row->phone); ?></p>
                                </td>

                                <?php if ($this->business->enable_location == 1): ?>
                                  <td>
                                    <?php $location = get_staff_location($row->id); ?>
                                    <span class="badge badge-secondary"><i class="fas fa-map-marker-alt"></i> <?php echo get_by_id($location->location_id, 'locations')->name; ?></span>
                                  </td>
                                <?php endif; ?>

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
                                        <a href="<?php echo base_url('admin/staff/edit/'.html_escape($row->id));?>" class="dropdown-item"><?php echo trans('edit') ?></a>
                                        <a data-val="Category" data-id="<?php echo html_escape($row->id); ?>" href="<?php echo base_url('admin/staff/delete/'.html_escape($row->id));?>" class="dropdown-item delete_item"><?php echo trans('delete') ?></a>
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
