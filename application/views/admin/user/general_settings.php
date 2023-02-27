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
                    <form method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/settings/general_settings') ?>" role="form" class="form-horizontal pl-20">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-body">
                                    
                                    <div class="form-group mb-4">
                                        <label><?php echo trans('time-zone') ?></label>
                                        <select class="cus_lh select2" name="time_zone" style="width: 100%;">
                                            <option value=""><?php echo trans('select') ?></option>
                                            <?php foreach ($time_zones as $time): ?>
                                                <option value="<?php echo html_escape($time->id); ?>" 
                                                    <?php echo ($this->business->time_zone == $time->id) ? 'selected' : ''; ?>>
                                                    <?php echo html_escape($time->name); ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>

                                    <div class="form-group mb-4 <?php if(settings()->enable_wallet == 1){echo "hide";} ?>">
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
                                            <option value="0" <?php if($company->curr_locate == 0){echo "selected";} ?>>$ <?php echo number_format('500', $company->num_format) ?> </option>
                                            <option value="1" <?php if($company->curr_locate == 1){echo "selected";} ?>><?php echo number_format('500', $company->num_format) ?> $</option>
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

                                    
                                    <div class="form-group mb-4">
                                        <label><?php echo trans('interval-settings') ?></label>
                                        <select class="form-control interval_settings" name="interval_settings">
                                            <option value=""><?php echo trans('select') ?></option>
                                            <option <?php echo ($this->business->interval_settings == '1') ? 'selected' : ''; ?> value="1"> <?php echo trans('generate-booking-time-slots') ?></option>
                                            <option <?php echo ($this->business->interval_settings == '2') ? 'selected' : ''; ?> value="2"> <?php echo trans('fixed-booking-time-slots') ?></option>
                                        </select>
                                    </div>
                                 

                                    <div class="interval_area <?php if($this->business->interval_settings == 2){echo "d-show";}else{echo "d-hide";} ?>">
                                        <div class="form-group mb-4">
                                          <label><?php echo trans('time-interval') ?> </label>
                                          <div class="input-group">
                                              <input type="number" class="form-control cus-ra-right interval_input" name="time_interval" value="<?php if(isset($this->business->time_interval)){echo html_escape($this->business->time_interval);} ?>">
                                                
                                              <div>
                                                <select class="form-control cus-ra-left interval_input" name="interval_type">
                                                    <option value="minute" <?php if($this->business->interval_type == 'minute'){echo "selected";} ?>><?php echo trans('minute') ?></option>
                                                    <option value="hour" <?php if($this->business->interval_type == 'hour'){echo "selected";} ?>><?php echo trans('hour') ?></option>
                                                    <!-- <option value="day" <?php if($this->business->interval_type == 'day'){echo "selected";} ?>><?php echo trans('day') ?></option> -->
                                                </select>
                                              </div>
                                          </div>
                                        </div>
                                    </div>

                                    
                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="card-body mb-3">
                                    <div class="row">
                                      <div class="col-6">
                                        <label class="add-pointer">
                                        <div class="icheck-primary text-center radio mt-2 pb-3">
                                          <input type="radio" id="radioPrimaryl" value="1" name="template_style" <?php if($company->template_style == 1){echo "checked";} ?>>
                                          <label for="radioPrimaryl"> <?php echo trans('home') ?> 1
                                          </label>
                                        </div>
                                        <img width="90%" class="img-thumbnail shadow" src="<?php echo base_url('assets/admin/images/home1.png') ?>">
                                        </label>
                                      </div>

                                      <div class="col-6">
                                        <label class="add-pointer">
                                        <div class="icheck-primary text-center radio mt-2 pb-3">
                                          <input type="radio" id="radioPrimaryd" value="2" name="template_style" <?php if($company->template_style == 2){echo "checked";} ?>>
                                          <label for="radioPrimaryd"> <?php echo trans('home') ?> 2
                                          </label>
                                        </div>
                                        <img width="90%" class="img-thumbnail shadow" src="<?php echo base_url('assets/admin/images/home2.png') ?>">
                                        </label>
                                      </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    
                                    <?php if (settings()->site_info == 2): ?>
                                     
                                    <div class="form-group mb-1">
                                      <div class="icheck-success d-inline">
                                        <input type="checkbox" id="checkboxPrimary5" name="enable_payment" value="1" <?php if($company->enable_payment == 1){echo "checked";}; ?>>
                                        <label for="checkboxPrimary5"> <span class="smalls"><?php echo trans('enable-online-payment') ?> </span>
                                            <p><small><?php echo trans('enable-online-title') ?></small></p>
                                        </label>
                                      </div>
                                    </div>

                                    <div class="form-group mb-1">
                                      <div class="icheck-success d-inline">
                                        <input type="checkbox" id="checkboxPrimary6" name="enable_onsite" value="1" <?php if($company->enable_onsite == 1){echo "checked";}; ?>>
                                        <label for="checkboxPrimary6"> <span class="smalls"><?php echo trans('enable-offline-payment') ?> </span>
                                            <p><small><?php echo trans('enable-offline-title') ?></small></p>
                                        </label>
                                      </div>
                                    </div>

                                    <?php else: ?>

                                        <input type="hidden" name="enable_payment" value="0">
                                        <input type="hidden" name="enable_onsite" value="1">

                                    <?php endif ?>


                                    <div class="form-group mb-1">
                                      <div class="icheck-success d-inline">
                                        <input type="checkbox" id="checkboxPrimary3" name="enable_rating" value="1" <?php if($company->enable_rating == 1){echo "checked";}; ?>>
                                        <label for="checkboxPrimary3"> <span class="smalls"><?php echo trans('enable-ratings') ?> </span>
                                            <p><small><?php echo trans('enable-ratings-title') ?></small></p>
                                        </label>
                                      </div>
                                    </div>

                                    <div class="form-group mb-1">
                                      <div class="icheck-success d-inline">
                                        <input type="checkbox" id="checkboxPrimary1" name="enable_staff" value="1" <?php if($company->enable_staff == 1){echo "checked";}; ?>>
                                        <label for="checkboxPrimary1"> <span class="smalls"><?php echo trans('enable-staff') ?> </span>
                                            <p><small><?php echo trans('enable-staff-title') ?></small></p>
                                        </label>
                                      </div>
                                    </div>

                                    <div class="form-group mb-1">
                                      <div class="icheck-success d-inline">
                                        <input type="checkbox" id="checkboxPrimary2" name="enable_gallery" value="1" <?php if($company->enable_gallery == 1){echo "checked";}; ?>>
                                        <label for="checkboxPrimary2"> <span class="smalls"><?php echo trans('enable-gallery') ?> </span>
                                            <p><small><?php echo trans('enable-gallery-title') ?></small></p>
                                        </label>
                                      </div>
                                    </div>

                                    <div class="form-group mb-1">
                                      <div class="icheck-success d-inline">
                                        <input type="checkbox" id="checkboxPrimary7" name="enable_guest" value="1" <?php if($company->enable_guest == 1){echo "checked";}; ?>>
                                        <label for="checkboxPrimary7"> <span class="smalls"><?php echo trans('enable-guest-booking') ?> </span>
                                            <p><small><?php echo trans('enable-guest-booking-title') ?> </small></p>
                                        </label>
                                      </div>
                                    </div>

                                    <div class="form-group mb-1">
                                      <div class="icheck-success d-inline">
                                        <input type="checkbox" id="checkboxPrimary4" name="enable_group" class="group_booking" value="1" <?php if($company->enable_group == 1){echo "checked";}; ?>>
                                        <label for="checkboxPrimary4"> <span class="smalls"><?php echo trans('enable-group-booking') ?> </span>
                                            <p><small><?php echo trans('enable-group-title') ?></small></p>
                                        </label>
                                      </div>
                                    </div>

                                    <div class="pl-4 person_area d-<?php if($company->enable_group == 1){echo "show";}else{echo "hide";} ?>">
                                        <div class="form-group mb-3">
                                          <label class="control-label" for="example-input-normal"><?php echo trans('max-allowed-persons') ?></label>
                                          <select class="form-control custom-select" name="total_person">
                                              <?php for ($i=1; $i <= 20; $i++) { ?>
                                                <option value="<?php echo $i ?>" <?php if($company->total_person == $i){echo "selected";} ?>><?php echo $i ?> <?php if($i == 1){echo trans('person');}else{echo trans('persons');} ?></option>
                                              <?php } ?>
                                          </select>
                                        </div>
                                    </div>

                                    
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
