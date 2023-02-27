<style type="text/css">
    .ui-datepicker-prev:after, .ui-datepicker-next:after {
      font-family: "Font Awesome 5 Free";
      font-weight: 500;
      content: "\f008";
      position: absolute;
      display: block;
      width: 10px;
      height: 10px;
      border-left: 2px solid #fff;
      border-bottom: 2px solid #fff;
      color: #fff;
      top: 524px !important;
    }


  .ui-datepicker-title {
    text-align: center;
    padding-top: 6px;
    font-size: 15px;
  }
</style>
<div class="content-wrapper pt-3">
  <div class="content container mb-4">
    <div class="container">
      <div class="row box-dash-areas">
        
        <!-- /.col -->
        <div class="col">
          <div class="info-box p-2 pl-3">
            <span class="info-box-icon info-box-icon-md bg-primary-soft"><i class="far fa-calendar-alt"></i></span>
            <div class="info-box-content">
              <span class="info-box-number"><?php echo get_count_appointment_by_status('all') ?></span>
              <span class="info-box-text"><?php echo trans('appointments') ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col">
          <div class="info-box p-2 pl-3">
            <span class="info-box-icon info-box-icon-md bg-warning-soft"><i class="far fa-clock"></i></span>
            <div class="info-box-content">
              <span class="info-box-number"><?php echo get_count_appointment_by_status('0') ?></span>
              <span class="info-box-text"><?php echo trans('pending') ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <!-- /.col -->
        <div class="col">
          <div class="info-box p-2 pl-3">
            <span class="info-box-icon info-box-icon-md bg-success-soft"><i class="far fa-calendar-check"></i></span>
            <div class="info-box-content">
              <span class="info-box-number"><?php echo get_count_appointment_by_status('1') ?></span>
              <span class="info-box-text"><?php echo trans('approved') ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>


        <!-- /.col -->
        <div class="col">
          <div class="info-box p-2 pl-3">
            <span class="info-box-icon info-box-icon-md bg-info-soft"><i class="fas fa-check-circle"></i></span>
            <div class="info-box-content">
              <span class="info-box-number"><?php echo get_count_appointment_by_status('3') ?></span>
              <span class="info-box-text"><?php echo trans('completed') ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- /.col -->
        <div class="col">
          <div class="info-box p-2 pl-3">
            <span class="info-box-icon info-box-icon-md bg-danger-soft"><i class="far fa-calendar-times"></i></span>
            <div class="info-box-content">
              <span class="info-box-number"><?php echo get_count_appointment_by_status('2') ?></span>
              <span class="info-box-text"><?php echo trans('rejected') ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->


      </div>
    </div>
  </div>



  <!-- Main content -->
  <div class="content">
    <div class="container">

      <div class="row">
        <div class="col-md-10">
            <div class="card add_area <?php if(isset($page_title) && $page_title == "Edit"){echo "d-block";}else{echo "hide";} ?>">
              <div class="card-header with-border">
                <?php if (isset($page_title) && $page_title == "Edit"): ?>
                  <h3 class="card-title pt-2"><?php echo trans('edit') ?></h3>
                <?php else: ?>
                  <h3 class="card-title pt-2"><?php echo trans('new-appointment') ?> </h3>
                <?php endif; ?>

                <div class="card-tools pull-right">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <a href="<?php echo base_url('admin/appointment') ?>" class="pull-right btn btn-secondary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a>
                  <?php else: ?>
                    <a href="#" class="text-right btn btn-secondary cancel_btn btn-sm"><?php echo trans('appointments') ?></a>
                  <?php endif; ?>
                </div>
              </div>


              <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/appointment/add')?>" role="form" novalidate>

                <div class="card-body">
                    
                    <div class="row">


                      <div class="col-sm-7 mt-4">

                        <?php if ($this->business->enable_location == 1): ?>
                            <div class="row">
                              <div class="col-md-12 mb-2 text-left">
                                  <h5 class="mb-2 h5"><?php echo trans('locations') ?> </h5>
                              </div>

                              <div class="col-md-6" data-aos="fade-up" data-aos-duration="100">
                                  <div class="form-group">
                                    <label class="control-label" for="example-input-normal"><?php echo trans('location') ?> <span class="text-danger">*</span></label>
                                    <select class="form-control custom-select location" name="location_id">
                                        <option value=""><?php echo trans('select') ?></option>
                                        <?php foreach ($locations as $location): ?>
                                            <option <?php if (isset($appointment[0]['location_id']) && $appointment[0]['location_id'] == $location->id){echo "selected";} ?> value="<?php echo html_escape($location->id); ?>">
                                              <?php echo html_escape($location->name); ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>

                                    <p class="text-danger fs-14 mt-1 mb-0 d-hide" id="location_error"> <?php echo trans('location-required') ?></p>
                                  </div>
                              </div>

                              <div class="col-md-6 sub_area <?php if (isset($page_title) && $page_title != "Edit"){echo "d-hide";} ?>">
                                  <div class="form-group">
                                    <label class="control-label" for="example-input-normal"><?php echo trans('branches') ?> </label>
                                    <select class="form-control custom-select sub_location" name="sub_location_id" <?php if (isset($page_title) && $page_title != "Edit"){echo "disabled";} ?>>
                                        
                                        <?php if (isset($page_title) && $page_title == 'Edit'): ?>
                                          <option selected value="<?php echo html_escape($appointment[0]['sub_location_id']) ?>"><?php echo get_by_id($appointment[0]['sub_location_id'], 'locations')->name ?></option>
                                        <?php endif; ?>

                                    </select>
                                  </div>
                              </div>
                            </div>
                        <?php endif; ?>


                          <div class="form-group">
                            <label><?php echo trans('services') ?> <span class="text-danger">*</span></label>
                            <select class="form-control select2s service_staffs" name="service_id" required>
                                <option value=""><?php echo trans('services') ?></option>
                                <?php foreach ($services as $service): ?>
                                  <option value="<?php echo html_escape($service->id) ?>" <?php if (isset($appointment[0]['service_id']) && $appointment[0]['service_id'] == $service->id){echo "selected";} ?>><?php echo html_escape($service->name) ?></option>
                                <?php endforeach ?>                 
                            </select>
                          </div>

                          <div class="form-group staff_area" style="display: <?php if (isset($page_title) && $page_title != "Edit"){echo "none";} ?>;">
                            <label><?php echo trans('staffs') ?> <span class="text-danger"><?php if($this->business->enable_staff == 1){echo "*";} ?></span></label>
                            <select class="form-control select2s staffs" name="staff_id" <?php if($this->business->enable_staff == 1){echo "required";} ?>>
                                <option value=""><?php echo trans('staffs') ?></option>
                                <?php foreach ($staffs as $staff): ?>
                                  <option value="<?php echo html_escape($staff->id) ?>" <?php if (isset($appointment[0]['staff_id']) && $appointment[0]['staff_id'] == $staff->id){echo "selected";} ?>><?php echo html_escape($staff->name) ?></option>
                                <?php endforeach ?>                 
                            </select>
                          </div>
                        
                          <div class="form-group">
                            <label><?php echo trans('customers') ?> <span class="text-danger">*</span></label>
                            <select class="form-control select2s" name="customer_id" required>
                                <option value=""><?php echo trans('customers') ?></option>
                                <?php foreach ($customers as $customer): ?>
                                  <option value="<?php echo html_escape($customer->id) ?>" <?php if (isset($appointment[0]['customer_id']) && $appointment[0]['customer_id'] == $customer->id){echo "selected";} ?>><?php echo html_escape($customer->name) ?></option>
                                <?php endforeach ?>                 
                            </select>
                          </div>
                        
                          <div class="form-group">
                            <label><?php echo trans('status') ?> <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required> 
                              <option value="0" <?php if (isset($appointment[0]['status']) && $appointment[0]['status'] == 0){echo "selected";} ?>> <?php echo trans('pending') ?></option>
                              <option value="1" <?php if (isset($appointment[0]['status']) && $appointment[0]['status'] == 1){echo "selected";} ?>> <?php echo trans('approved') ?></option>
                              <option value="2" <?php if (isset($appointment[0]['status']) && $appointment[0]['status'] == 2){echo "selected";} ?>> <?php echo trans('rejected') ?></option>
                            </select>
                          </div>

                          <div class="form-group d-<?php if (isset($page_title) && $page_title == "Edit"){echo "show";}else{echo "hide";} ?> appointment_datepicker">
                            <label><?php echo trans('date') ?> <span class="text-danger">*</span></label>
                            <div id="load_work_cal">
                                <div id="datepickers"></div>
                            </div>
                            <input type="hidden" class="booking_date" name="date" value="<?php if (isset($appointment[0]['date'])){echo html_escape($appointment[0]['date']);} ?>">
                          </div>


                          <?php if (isset($page_title) && $page_title != "Edit"): ?>
                            <div class="form-group mt-2">
                              <div class="icheck-success d-inline">
                                <input type="checkbox" id="checkboxPrimary2" name="notify_customer" value="1">
                                <label for="checkboxPrimary2"> <span class="small"><?php echo trans('notify-customers') ?></span>
                                </label>
                              </div>
                            </div>
                          <?php endif; ?>
                      </div>

                    
                      <div class="col-sm-5 pl-3">
                        

                        <div class="p-0 text-center">

                            <input type="hidden" class="booking_time" name="time" value="<?php if(isset($appointment[0]['time'])){echo html_escape($appointment[0]['time']);} ?>">

                            <div id="load_data"></div>
                        </div>
                      </div>
                    </div>

                </div>

                <div class="card-footer">
                    <input type="hidden" name="id" value="<?php if(isset($appointment[0]['id'])){echo html_escape($appointment[0]['id']);} ?>">
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
      </div>


      <?php if (isset($page_title) && $page_title != 'Edit'): ?>
        <div class="list_area">
          
          <div class="row">
            <div class="col-lg-12">
              <div class="card list_area">
                <div class="card-header">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <h3 class="card-title pt-2">Edit <a href="<?php echo base_url('admin/pages') ?>" class="pull-right btn btn-secondary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a></h3>
                  <?php else: ?>
                    <h3 class="card-title pt-2"><?php echo trans('appointments') ?></h3>
                  <?php endif; ?>

                  <div class="card-tools pull-right d-flex justify-content-between">
                    <div>
                      <form method="get" class="sort_form" action="<?php echo base_url('admin/appointment') ?>">
                        <select name="range" class="nice_select small xs customs mr-2 sort">
                          <option value="0"> <?php echo trans('all') ?></option>
                          <option value="<?php echo date('Y-m-d') ?>" <?php if (isset($_GET['range']) && $_GET['range'] == date('Y-m-d')){echo "selected";} ?>> <?php echo trans('today') ?></option>
                          <option value="<?php echo date('Y-m-d', strtotime('+1 days')) ?>" <?php if (isset($_GET['range']) && $_GET['range'] == date('Y-m-d', strtotime('+1 days'))){echo "selected";} ?>> <?php echo trans('tomorrow') ?></option>
                          <option value="<?php echo date('Y-m-d', strtotime('+7 days')) ?>" <?php if (isset($_GET['range']) && $_GET['range'] == date('Y-m-d', strtotime('+7 days'))){echo "selected";} ?>> <?php echo trans('next-7-days') ?></option>
                          <option value="<?php echo date('Y-m-d', strtotime('+15 days')) ?>"<?php if (isset($_GET['range']) && $_GET['range'] == date('Y-m-d', strtotime('+15 days'))){echo "selected";} ?>> <?php echo trans('next-15-days') ?></option>
                        </select>
                      </form>
                    </div>

                     <div>
                      <a href="#" class="pull-right btn btn-outline-primary btn-sm add_btn mr-1"><i class="fa fa-plus"></i> <span class="d-none d-md-inline"><?php echo trans('new-appointment') ?></span></a>
                      <a href="#" class="filter-action pull-right btn btn-outline-primary btn-sm"><i class="fas fa-filter"></i></a>
                    </div>

                  </div>
                </div>

                <div class="filter_popup showFilter">
                  <p class="leads mb-3"><?php echo trans('filters') ?></p>
                  <form method="get" class="sort_forms" action="<?php echo base_url('admin/appointment') ?>">

                    <div class="row">
                      <div class="col-md-12 mb-3">     
                        <div class="form-group mb-0">
                          <label class="mb-0"><?php echo trans('services') ?></label>
                          <select class="nice_select small wide" name="service" aria-invalid="false">
                              <option value=""><?php echo trans('all') ?></option>
                              <?php foreach ($services as $service): ?>
                                <option value="<?php echo html_escape($service->id) ?>" <?php if (isset($_GET['service']) && $_GET['service'] == $service->id){echo "selected";} ?>><?php echo html_escape($service->name) ?></option>
                              <?php endforeach ?>                 
                          </select>
                        </div>
                      </div>
                    
                      <div class="col-md-12 mb-3">   
                        <div class="form-group mb-0">
                          <label class="mb-0"><?php echo trans('customers') ?></label>
                          <select class="nice_select small wide mt-2" name="customer" aria-invalid="false">
                              <option value=""><?php echo trans('all') ?></option>
                              <?php foreach ($customers as $customer): ?>
                                <option value="<?php echo html_escape($customer->customer_id) ?>" <?php if (isset($_GET['customer']) && $_GET['customer'] == $customer->customer_id){echo "selected";} ?>><?php echo html_escape($customer->name) ?></option>
                              <?php endforeach ?>   
                              
                              <?php foreach ($customers_app as $customer): ?>
                                <option value="<?php echo html_escape($customer->customer_id) ?>" <?php if (isset($_GET['customer']) && $_GET['customer'] == $customer->customer_id){echo "selected";} ?>><?php echo html_escape($customer->name) ?></option>
                              <?php endforeach ?>                 
                          </select>
                        </div>
                      </div>

                      <div class="col-md-12 mb-3">   
                        <div class="form-group mb-0">
                          <label class="mb-0"><?php echo trans('staffs') ?></label>
                          <select class="nice_select small wide mt-2" name="staff" aria-invalid="false">
                              <option value=""><?php echo trans('all') ?></option>
                              <?php foreach ($staffs as $staff): ?>
                                <option value="<?php echo html_escape($staff->id) ?>" <?php if (isset($_GET['staff']) && $_GET['staff'] == $staff->id){echo "selected";} ?>><?php echo html_escape($staff->name) ?></option>
                              <?php endforeach ?>                 
                          </select>
                        </div>
                      </div>

                      <div class="col-md-12 mb-1">   
                        <div class="form-group mb-0">
                          <label><?php echo trans('status') ?></label>
                          <select class="nice_select small wide mb-2" name="status" aria-invalid="false">
                              <option value=""><?php echo trans('all') ?></option>
                              <option value="0" <?php if (isset($_GET['status']) && $_GET['status'] == 0){echo "selected";} ?>> <?php echo trans('pending') ?></option>
                              <option value="1" <?php if (isset($_GET['status']) && $_GET['status'] == 1){echo "selected";} ?>> <?php echo trans('approved') ?></option>
                              <option value="2" <?php if (isset($_GET['status']) && $_GET['status'] == 2){echo "selected";} ?>> <?php echo trans('rejected') ?></option>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-12">   
                        <div class="form-group mb-0 mt-2">
                          <input type="text" name="search" class="form-control form-control-sm" placeholder="<?php echo trans('search') ?>">
                          <a href="<?php echo base_url('admin/appointment') ?>" class="btn btn-default btn-xs pull-right mt-1"><i class="fas fa-redo-alt"></i> <?php echo trans('reset') ?></a>
                        </div>
                      </div>
                      
                      <div class="col-md-12">   
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary btn-block btn-sm"><?php echo trans('submit') ?></button>
                        </div>
                      </div>
                    </div>

                  </form>
                </div>
                  

                <div class="card-body table-responsive p-0 minh-300">
                 
                  <?php if (empty($appointments)): ?>
                    <?php $this->load->view('admin/include/not-found') ?>
                  <?php else: ?>
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo trans('date') ?></th>
                                <th><?php echo trans('service') ?></th>
                                <th><?php echo trans('customer') ?></th>
                                <th><?php echo trans('staff') ?></th>
                                <th><?php echo trans('payment') ?></th>
                                <th><?php echo trans('status') ?></th>
                                <th><?php echo trans('action') ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $a=1; foreach ($appointments as $appointment): ?>
                                <tr class="default" id="row_<?php echo html_escape($appointment->id) ?>">
                                    <th><?php echo html_escape($a) ?></th>
                                    <td class="pl-3">
                                        <p class="mb-1"><?php echo my_date_show($appointment->date) ?></p>
                                        
                                        <?php if ($appointment->duration_type != 'day'): ?>
                                        <p class="small mb-0"><?php echo format_time($appointment->time, $this->business->time_format) ?></p>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td>
                                        <?php if (check_apo_rating($appointment->id) != 0): ?>
                                              <?php $rating = check_apo_rating($appointment->id); ?>
                                              <?php for($i = 1; $i <= 5; $i++):?>
                                                <?php 
                                                if($i > $rating->rating){
                                                  $star = 'far fa-star';
                                                }else{
                                                  $star = 'fas fa-star';
                                                }
                                                ?>
                                                <i class="<?php echo $star;?> text-warning fs-12"></i> 
                                              <?php endfor;?>
                                        <?php endif; ?>
                                        <p class="mb-0 font-weight-bold"><?php echo html_escape($appointment->service_name) ?> </p>
                                        <p class="mb-0 mt-0"><span class="small"><?php echo html_escape($appointment->duration).' '.trans($appointment->duration_type); ?> </span></p>
                                    </td>
                                    

                                    <td>
                                      <div class="d-flex">
                                        <div class="mr-3">
                                          <a data-tooltip="<?php echo trans('view-details') ?>" href="<?php echo base_url('admin/customers/details/'.md5($appointment->customer_id));?>" class="text-dark">
                                          <img class="img-circle mr-2" width="40px" height="40px" src="<?php echo base_url($appointment->customer_thumb) ?>"> <?php echo html_escape($appointment->customer_name) ?> 
                                          <span class="badge badge-info"><?php if($appointment->customer_role == 'guest') {echo html_escape($appointment->customer_role);}?></span></a>
                                        </div>
                                      </div>
                                    </td>

                                    <td>
                                      <?php if (!empty($appointment->staff_name)): ?>
                                        <img class="img-circle mr-2" width="40px" height="40px" src="<?php echo base_url($appointment->staff_thumb) ?>"> <?php echo html_escape($appointment->staff_name) ?>
                                      <?php else: ?>
                                        <p class="fs-12 pt-2"><i class="fas fa-user-slash"></i> <?php echo trans('not-assigned') ?></p>
                                      <?php endif ?>
                                    </td>
                                   
                                    <td>

                                      <p class="fs-14 mb-0">
                                          <?php 
                                              $check_coupon = check_coupon($appointment->id, $appointment->service_id, $appointment->business_id);
                                              if ($check_coupon != FALSE):
                                                  if (!empty($check_coupon)):
                                                      $price =  get_price($appointment->price, $appointment->group_booking, $appointment->total_person);
                                                      $discount = $check_coupon->discount;
                                                      $amount = $price - ($price * ($discount / 100));
                                                      $discount_amount = $price - $amount;
                                                  else:
                                                      $price =  get_price($appointment->price, $appointment->group_booking, $appointment->total_person);
                                                      $discount = 0;
                                                      $discount_amount = 0;
                                                      $amount = $price;
                                                  endif;
                                              else:
                                                  $discount = 0;
                                                  $amount =  get_price($appointment->price, $appointment->group_booking, $appointment->total_person);
                                              endif;
                                          ?>

                                          <p class="mb-0">
                                            <?php if ($appointment->price == 0): ?>
                                                <?php echo trans('free') ?>
                                            <?php else: ?>
                                                <?php if($this->business->curr_locate == 0){echo $this->business->currency_symbol;} ?>
                                                <?php echo number_format($amount, $this->business->num_format) ?>
                                                <?php if($this->business->curr_locate == 1){echo $this->business->currency_symbol;} ?> 
                                                
                                                <?php if ($discount != 0): ?>
                                                  <span class="small">(<?php echo html_escape($discount) ?>% <?php echo trans('off') ?>)</span>
                                                <?php endif ?>
                                            <?php endif ?>
                                          </p>
                                          
                                          <?php $check_payment = check_appointment_payment($appointment->id) ?>
                                   
                                          <?php if ($check_payment == true): ?>
                                            <span class="text-success font-weight-bold fs-12"><i class="fas fa-check-circle"></i> <?php echo trans('paid') ?></span>
                                          <?php else: ?>
                                            <?php if ($appointment->price != 0): ?>
                                              <span class="text-warning font-weight-bold fs-12"><i class="far fa-clock"></i> <?php echo trans('pending') ?></span>
                                            <?php endif; ?>
                                          <?php endif; ?>
                                      </p>
                                      
                                    </td>

                                    <td>
                                        <select data-id="<?php echo html_escape($appointment->id) ?>" name="" class="nice_select small custom active_status <?php if ($appointment->status == 0){echo "br-warning";}elseif($appointment->status == 1){echo "br-success";}elseif($appointment->status == 2){echo "br-danger";}else{echo "br-primary";} ?>">
                                          <option value="0" <?php if ($appointment->status == 0){echo "selected";} ?>> <?php echo trans('pending') ?></option>
                                          <option value="1" <?php if ($appointment->status == 1){echo "selected";} ?>> <?php echo trans('approved') ?></option>
                                          <option value="2" <?php if ($appointment->status == 2){echo "selected";} ?>> <?php echo trans('rejected') ?></option>
                                          <option value="3" <?php if ($appointment->status == 3){echo "selected";} ?>> <?php echo trans('completed') ?></option>
                                        </select>
                                    </td>
                                    
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-tool" data-toggle="dropdown" aria-expanded="false">
                                              <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" role="menu">

                                              <?php if (!empty(settings()->google_client_id) && !empty(settings()->google_client_secret)): ?>
                                                  <?php if (check_user_feature_access($appointment->user_id, 'google-calendar-sync') == TRUE): ?>
                                                      <?php if ($appointment->sync_calendar_user != 1): ?>
                                                          <a target="_blank" href="<?php echo base_url('admin/appointment/sync/'.md5($appointment->id)) ?>" class="dropdown-item"><i class="far fa-calendar-check mr-1"></i> <?php echo trans('sync-google-calendar') ?></a>
                                                      <?php endif ?>
                                                  <?php endif ?>
                                              <?php endif ?>


                                              <?php if (check_apo_rating($appointment->id) != 0): ?>
                                                <a data-toggle="modal" href="#ratingModal_<?php echo $a ?>" class="dropdown-item"><i class="far fa-star mr-1"></i> <?php echo trans('review') ?></a>
                                              <?php endif; ?>

                                              <?php if ($check_payment == false): ?>
                                                <a href="#paymentModal_<?= $a; ?>" data-toggle="modal" class="dropdown-item"><i class="lni lni-coin mr-1"></i> <?php echo trans('record-payment') ?></a>
                                              

                                                <?php if ($appointment->customer_phone != '' && user()->twillo_account_sid != ''): ?>
                                                  <a data-id="<?php echo html_escape($appointment->id); ?>" href="<?php echo base_url('admin/appointment/notify_customer/'.$appointment->id) ?>" class="dropdown-item notify_customer"><i class="far fa-paper-plane mr-1"></i> <?php echo trans('send-sms-reminder') ?></a>
                                                <?php endif; ?>
                                              <?php endif; ?>
                                              
                                              <a href="<?php echo base_url('admin/appointment/edit/'.html_escape($appointment->id));?>" class="dropdown-item"><i class="lni lni-pencil mr-1"></i> <?php echo trans('edit') ?></a>

                                              <a data-val="Category" data-id="<?php echo html_escape($appointment->id); ?>" href="<?php echo base_url('admin/appointment/delete/'.html_escape($appointment->id));?>" class="dropdown-item delete_item"><i class="lni lni-trash-can mr-1"></i> <?php echo trans('delete') ?></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="arrow"></span></td>
                                </tr>

                                <tr class="toggle-row">
                                  <td colspan="10" class="p-0">
                                    <div class="sub-table-wrap">
                                      <div class="full-sub-table">
                                        <dl class="info-wrapper">
                                        
                                          <dd><?php echo trans('customer') ?> <?php echo trans('email') ?>: <?php echo html_escape($appointment->customer_email) ?></dd>
                                          <dd><?php echo trans('customer') ?> <?php echo trans('phone') ?>: <?php echo html_escape($appointment->customer_phone) ?></dd>
                                          <?php if (!empty($appointment->note)): ?>
                                            <dd><?php echo trans('notes') ?>: <?php echo $appointment->note; ?></dd>
                                          <?php endif ?>
                                        </dl>

                                        <dl class="info-wrapper">
                                          <dt><?php echo trans('locations') ?></dt>
                                          <dd>
                                            <?php if ($appointment->location_id != 0): ?>
                                              <p class="mb-1">
                                                  <?php echo get_by_id($appointment->location_id, 'locations')->name ?>
                                                  <?php if ($appointment->sub_location_id != 0): ?>
                                                    <span> - <?php echo get_by_id($appointment->sub_location_id, 'locations')->name ?></span>
                                                  <?php endif ?>
                                              </p>
                                            <?php else: ?>
                                              <p><?php echo trans('not-found') ?></p>
                                            <?php endif ?>
                                          </dd>
                                        </dl>

                                        <?php if (!empty($appointment->note)): ?>
                                          <dl class="info-wrapper">
                                            <dt><?php echo trans('notes') ?></dt><dd><?php echo $appointment->note; ?></dd>
                                          </dl>
                                        <?php endif ?>

                                        <dl class="info-wrapper">
                                          <?php if ($appointment->group_booking != 0): ?>
                                            <dt><?php echo trans('group-booking') ?>: <?php echo $appointment->total_person + 1 ?> <?php echo trans('persons') ?></dt>
                                          <?php else: ?>
                                            <dt><?php echo trans('group-booking') ?>: <?php echo trans('no') ?></dt>
                                          <?php endif; ?>

                                          <?php if (!empty($appointment->zoom_link)): ?>
                                             <dt><?php echo trans('zoom') ?>: <?php echo trans('yes') ?></dt>
                                          <?php else: ?>
                                             <dt><?php echo trans('zoom') ?>: <?php echo trans('no') ?></dt>
                                          <?php endif ?>

                                          <?php if (!empty($appointment->google_meet)): ?>
                                             <dt><?php echo trans('google-meet') ?>: <?php echo trans('yes') ?></dt>
                                          <?php else: ?>
                                             <dt><?php echo trans('google-meet') ?>: <?php echo trans('no') ?></dt>
                                          <?php endif ?>

                                        </dl>
                                      </div>
                                    </div>
                                  </td>
                                </tr>

                            <?php $a++; endforeach ?>
                        </tbody>
                    </table>
                  <?php endif ?>
                </div>

              </div>

              <div class="mt-4">
                <?php echo $this->pagination->create_links(); ?>
              </div>
              
            </div>
          </div>
        </div>
      <?php endif ?>

    </div>
  </div>
</div>





<!-- Modal -->

<?php $j=1; foreach ($appointments as $appointment): ?>

<div class="modal fade d-hide" id="ratingModal_<?= $j; ?>" aria-hidden="true">
  <div class="modal-dialog">
  
    <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('customer/add_rating')?>" role="form" novalidate>
      <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">
            <?php echo trans('customer-feedback') ?>
        </h4>
          <div class="mclose" data-dismiss="modal"><i class="lnib lni-close"></i></div>
        </div>

        <div class="modal-body">
            
          <?php $rating = check_apo_rating($appointment->id); ?>
          <?php for ($i=0; $i < $rating->rating; $i++) { ?>
              <i class="fas fa-star text-warning"></i>
          <?php } ?>
          <p class="mt-2 lead"><?php echo $rating->feedback ?></p>
       
        </div>

        <?php if (check_apo_rating($appointment->id) == 0): ?>
        <div class="modal-footer justify-content-between">
          <input type="hidden" name="appointment_id" value="<?php echo $appointment->id ?>">
          <!-- csrf token -->
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
          <button type="submit" class="btn btn-primary"><?php echo trans('save') ?></button>
        </div>
        <?php endif; ?>

      </div>
    </form>

    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<?php $j++; endforeach; ?>


<?php $i=1; foreach ($appointments as $appointment): ?>

<div class="modal fade d-hide" id="paymentModal_<?= $i; ?>" aria-hidden="true">
  <div class="modal-dialog">
  
    <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/payment/record_payment/'.$appointment->id)?>" role="form" novalidate>
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><?php echo trans('record-payment') ?> - <?php echo html_escape($appointment->service_name); ?></h4>
          <div class="mclose" data-dismiss="modal"><i class="lnib lni-close"></i></div>
        </div>

        <?php 
          $check_coupon = check_coupon($appointment->id, $appointment->service_id, $appointment->business_id);
          if ($check_coupon != FALSE):
              if (!empty($check_coupon)):
                  $price =  get_price($appointment->price, $appointment->group_booking, $appointment->total_person);
                  $discount = $check_coupon->discount;
                  $amount = $price - ($price * ($discount / 100));
                  $discount_amount = $price - $totalCost;
              else:
                  $price =  get_price($appointment->price, $appointment->group_booking, $appointment->total_person);
                  $discount = 0;
                  $discount_amount = 0;
                  $amount = $price;
              endif;
          else:
              $amount =  get_price($appointment->price, $appointment->group_booking, $appointment->total_person);
          endif;
         ?>
        <div class="modal-body">
          <div class="form-group">
            <label><?php echo trans('price') ?> <span class="text-danger">*</span></label>
            <input type="text" class="form-control" required name="price" value="<?php echo number_format($amount, $this->business->num_format) ?>" disabled>
          </div>
        </div>

        <div class="modal-footer justify-content-between">
          <!-- csrf token -->
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
          <button type="submit" class="btn btn-primary"><?php echo trans('save') ?></button>
        </div>
      </div>
    </form>

    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<?php $i++; endforeach; ?>
<!-- End Modal -->
