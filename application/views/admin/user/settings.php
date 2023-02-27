<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <?php $this->load->view('admin/include/breadcrumb'); ?>

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
        
            <?php $this->load->view('admin/user/include/settings_menu.php'); ?>

            <div class="col-lg-9 pl-3">
                <div class="card">
                    <form method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/settings/update_company') ?>" role="form" class="form-horizontal pl-20">
                        <div class="card-body">
                             
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="mih-100">
                                            <?php if (!empty($company->logo)):?>
                                                <img class="m-auto" width="100px" src="<?php echo base_url($company->logo); ?>">
                                            <?php else: ?>
                                               <p class="m-auto text-muted"><?php echo trans('upload-company-logo') ?></p>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="photo1" id="customFile">
                                                <label class="custom-file-label" for="customFile"><?php echo trans('upload-logo') ?></label>
                                                <p class="text-muted mt-1 fs-12 small"><i class="fas fa-info-circle"></i> <?php echo trans('for-better-view-use') ?> 300 x 150px</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="mih-100">
                                            <?php if (!empty($company->image)):?>
                                                <img class="m-auto" width="100px" src="<?php echo base_url($company->thumb); ?>">
                                            <?php else: ?>
                                                <img class="m-auto" width="100px" src="<?php echo base_url('assets/front/img/vericla-cover.jpg'); ?>">
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-file">
                                            <input type="file" name="photo" class="custom-file-input" id="customFiles">
                                            <label class="custom-file-label" for="customFiles"><?php echo trans('banner-image') ?></label>
                                            </div>
                                            <p class="text-muted mt-1 fs-12 small"><i class="fas fa-info-circle"></i> <?php echo trans('for-better-view-use') ?> 1600 x 1000px</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo trans('company-name') ?></label>
                                        <input type="text" name="name" value="<?php echo html_escape($company->name); ?>" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo trans('company-title') ?></label>
                                        <input type="text" name="title" value="<?php echo html_escape($company->title); ?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo trans('email') ?></label>
                                        <input type="text" name="email" value="<?php echo html_escape($company->email); ?>" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo trans('phone') ?></label>
                                        <input type="text" name="phone" value="<?php echo html_escape($company->phone); ?>" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label><?php echo trans('address') ?></label>
                                <textarea class="form-control" name="address" rows="2"><?php echo html_escape($company->address); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label><?php echo trans('details') ?></label>
                                <textarea id="summernote" class="form-control" name="details" rows="4"><?php echo html_escape($company->details); ?></textarea>
                            </div>
                        </div>


                        <div class="col-12 mt-4"><p class="font-weight-bold mb-0"><?php echo trans('seo-settings') ?> </p></div>
                        <div class="card-body p-4 mt-1 m-0">
                            <div class="form-group">
                              <label><?php echo trans('keywords') ?></label>
                                <input type="text" data-role="tagsinput" name="keywords" value="<?php echo html_escape($company->keywords); ?>" class="form-control" >
                            </div>

                            <div class="form-group">
                                <label><?php echo trans('description') ?></label>
                                <textarea class="form-control" name="description" rows="4"><?php echo html_escape($company->description); ?></textarea>
                            </div>
                        </div>

                        <div class="col-12 mt-4"><p class="font-weight-bold mb-0"><?php echo trans('social-settings') ?></p></div>
                        <div class="card-body row mt-1 m-0">
                            <div class="form-group col-md-6">
                              <label><?php echo trans('facebook') ?></label>
                                <input type="text" name="facebook" value="<?php echo html_escape($company->facebook); ?>" class="form-control" >
                            </div>
                            <div class="form-group col-md-6">
                              <label><?php echo trans('twitter') ?></label>
                                <input type="text" name="twitter" value="<?php echo html_escape($company->twitter); ?>" class="form-control" >
                            </div>
                            <div class="form-group col-md-6">
                              <label><?php echo trans('instagram') ?></label>
                                <input type="text" name="instagram" value="<?php echo html_escape($company->instagram); ?>" class="form-control" >
                            </div>
                            <div class="form-group col-md-6">
                              <label><?php echo trans('whatsapp') ?></label>
                                <input type="text" name="whatsapp" value="<?php echo html_escape($company->whatsapp); ?>" class="form-control" >
                            </div>
                        </div>

                        <div class="d-hide">
                            <div class="form-group mb-4">
                                <label><?php echo trans('currency') ?></label>
                                <select class="form-control" name="country">
                                    <option value=""><?php echo trans('select') ?></option>
                                    <?php foreach ($currencies as $currency): ?>
                                        <?php if (!empty($currency->currency_name)): ?>
                                          <option value="<?php echo html_escape($currency->id); ?>" 
                                            <?php echo ($this->business->country == $currency->id) ? 'selected' : ''; ?>>
                                            <?php echo html_escape($currency->name.'  -  '.$currency->currency_code.' ('.$currency->currency_symbol.')'); ?>
                                          </option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label><?php echo trans('currency-position') ?></label>
                                <select class="form-control" name="curr_locate">
                                    <option value=""><?php echo trans('select') ?></option>
                                    <option value="0" <?php if($company->curr_locate == 0){echo "selected";} ?>>$ <?php echo number_format('100', $company->num_format) ?> </option>
                                    <option value="1" <?php if($company->curr_locate == 1){echo "selected";} ?>><?php echo number_format('100', $company->num_format) ?> $</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label><?php echo trans('number-format') ?></label>
                                <select class="form-control" name="num_format">
                                    <option value=""><?php echo trans('select') ?></option>
                                    <option value="0" <?php if($company->num_format == 0){echo "selected";} ?>>100 </option>
                                    <option value="2" <?php if($company->num_format == 2){echo "selected";} ?>>100.00</option>
                                </select>
                            </div>

                            <div class="form-group mb-4">
                                <label><?php echo trans('date-format') ?></label>
                                <select class="form-control" name="date_format">
                                    <option value=""><?php echo trans('select') ?></option>
                                    <option <?php echo ($this->business->date_format == 'd-m-Y') ? 'selected' : ''; ?> value="d-m-Y"><?php echo date('d-m-Y') ?> (d-m-Y)</option>
                                    <option <?php echo ($this->business->date_format == 'Y-m-d') ? 'selected' : ''; ?> value="Y-m-d"><?php echo date('Y-m-d') ?> (Y-m-d)</option>
                                    <option <?php echo ($this->business->date_format == 'd/m/Y') ? 'selected' : ''; ?> value="d/m/Y"><?php echo date('d/m/Y') ?> (d/m/Y)</option>
                                    <option <?php echo ($this->business->date_format == 'Y/m/d') ? 'selected' : ''; ?> value="Y/m/d"><?php echo date('Y/m/d') ?> (Y/m/d)</option>
                                    <option <?php echo ($this->business->date_format == 'd.m.Y') ? 'selected' : ''; ?> value="d.m.Y"><?php echo date('d.m.Y') ?> (d.m.Y)</option>
                                    <option <?php echo ($this->business->date_format == 'Y.m.d') ? 'selected' : ''; ?> value="Y.m.d"><?php echo date('Y.m.d') ?> (Y.m.d)</option>
                                    <option <?php echo ($this->business->date_format == 'd M Y') ? 'selected' : ''; ?> value="d M Y"><?php echo date('d M Y') ?> (d M Y)</option>
                                </select>
                            </div>

                            <div class="form-group mb-4">
                                <label><?php echo trans('time-format') ?></label>
                                <select class="form-control" name="time_format">
                                    <option value=""><?php echo trans('select') ?></option>
                                    <option <?php echo ($this->business->time_format == 'hh') ? 'selected' : ''; ?> value="hh"> 12 <?php echo trans('hours') ?></option>
                                    <option <?php echo ($this->business->time_format == 'HH') ? 'selected' : ''; ?> value="HH">24 <?php echo trans('hours') ?></option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label>Interval Settings</label>
                                        <select class="form-control interval_settings" name="interval_settings">
                                            <option value=""><?php echo trans('select') ?></option>
                                            <option <?php echo ($this->business->interval_settings == '1') ? 'selected' : ''; ?> value="1"> Apply service duration to grnerate booking time slots</option>
                                            <option <?php echo ($this->business->interval_settings == '2') ? 'selected' : ''; ?> value="2"> Apply fixed duration to grnerate booking time slots</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 interval_area">
                                    <div class="form-group mb-4">
                                      <label><?php echo trans('time-interval') ?> </label>
                                      <div class="input-group">
                                          <input type="number" class="form-control cus-ra-right interval_input" name="time_interval" value="<?php if(isset($this->business->time_interval)){echo html_escape($this->business->time_interval);} ?>" <?php if($this->business->interval_settings == 1){echo "disabled";} ?>>
                                            
                                          <div>
                                            <select class="form-control cus-ra-left interval_input" name="interval_type" <?php if($this->business->interval_settings == 1){echo "disabled";} ?>>
                                                <option value="minute" <?php if($this->business->interval_type == 'minute'){echo "selected";} ?>><?php echo trans('minute') ?></option>
                                                <option value="hour" <?php if($this->business->interval_type == 'hour'){echo "selected";} ?>><?php echo trans('hour') ?></option>
                                                <!-- <option value="day" <?php if($this->business->interval_type == 'day'){echo "selected";} ?>><?php echo trans('day') ?></option> -->
                                            </select>
                                          </div>
                                      </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                              <div class="icheck-success d-inline">
                                <input type="checkbox" id="checkboxPrimary4" name="enable_group" class="group_booking" value="1" <?php if($company->enable_group == 1){echo "checked";}; ?>>
                                <label for="checkboxPrimary4"> <span class="smalls">Enable Group Booking </span>
                                    <p><small>Enable to allow group booking for your customers</small></p>
                                </label>
                              </div>
                            </div>

                            <div class="person_area d-hide">
                                <div class="form-group mb-4">
                                  <label class="control-label" for="example-input-normal">Maximum allowed additional persons</label>
                                  <select class="form-control custom-select" name="allow_persons">
                                      <?php for ($i=1; $i <= 20; $i++) { ?>
                                        <option value="<?php echo $i ?>"><?php echo $i ?> <?php if($i == 1){echo trans('person');}else{echo trans('persons');} ?></option>
                                      <?php } ?>
                                  </select>
                                </div>
                            </div>

                            <div class="form-group">
                              <div class="icheck-success d-inline">
                                <input type="checkbox" id="checkboxPrimary3" name="enable_rating" value="1" <?php if($company->enable_rating == 1){echo "checked";}; ?>>
                                <label for="checkboxPrimary3"> <span class="smalls"><?php echo trans('enable-ratings') ?> </span>
                                    <p><small><?php echo trans('enable-ratings-title') ?></small></p>
                                </label>
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="icheck-success d-inline">
                                <input type="checkbox" id="checkboxPrimary1" name="enable_staff" value="1" <?php if($company->enable_staff == 1){echo "checked";}; ?>>
                                <label for="checkboxPrimary1"> <span class="smalls"><?php echo trans('enable-staff') ?> </span>
                                    <p><small><?php echo trans('enable-staff-title') ?></small></p>
                                </label>
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="icheck-success d-inline">
                                <input type="checkbox" id="checkboxPrimary2" name="enable_gallery" value="1" <?php if($company->enable_gallery == 1){echo "checked";}; ?>>
                                <label for="checkboxPrimary2"> <span class="smalls"><?php echo trans('enable-gallery') ?> </span>
                                    <p><small><?php echo trans('enable-gallery-title') ?></small></p>
                                </label>
                              </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <input type="hidden" name="id" value="<?php echo html_escape($company->id); ?>">
                            <!-- csrf token -->
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                            <button type="submit" class="btn btn-primary mt-2"><?php echo trans('save-changes') ?></button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
