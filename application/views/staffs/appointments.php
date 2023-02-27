<?php include"topbar.php"; ?>

<section class="pt-0 cus-account">
    <div class="container cw-14">
        <div class="row mb-100">
            <div class="col-md-3">
                <?php include'side_menu.php'; ?>
            </div>

            <div class="col-md-9">
                <div class="card shadow-sm br-10 over-hiddens mb-4">
                    <div class="card-header bg-white px-5 py-2 mt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="card-title font-weight-normal"><?php echo trans('appointments') ?> <span class="count"><?php echo count($appointments) ?></span> </h5>
                            </div>
                            
                            
                            <div class="col-md-6">
                                <form class="sort_form" method="get" action="<?php echo base_url('staff/appointments') ?>">
                                    <div class="input-group mt--8">
                                        <input type="text" class="form-control daterange" name="daterange" aria-describedby="button-addon2" autocomplete="off" placeholder="Select date">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary sort_btn" type="button" id="button-addon2"><i class="fas fa-search"></i> </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                    </div>

                    <div class="card-body bg-white p-0 table-responsive">
                        <table class="table table-hover <?php if(count($appointments) > 10){echo "datatable";} ?>">
                            <thead class="thead-light">
                                <tr class="bt-0">
                                    <th class="pl-5" scope="col">#</th>
                                    <th scope="col"><?php echo trans('service') ?></th>
                                    <th scope="col"><?php echo trans('locations') ?></th>
                                    <th scope="col"><?php echo trans('customer') ?></th>
                                    <th scope="col"><?php echo trans('date') ?></th>
                                    <th scope="col"><?php echo trans('status') ?></th>
                                    <th scope="col"><?php echo trans('payment') ?></th>
                                    <th scope="col"><?php echo trans('action') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $a=1; foreach ($appointments as $appointment): ?>
                                    <tr id="row_<?php echo html_escape($appointment->id) ?>">
                                        <th class="pl-5" scope="row"><?php echo html_escape($a) ?></th>
                                        <td>
                                            <p class="mb-0 font-weight-bold"><?php echo html_escape($appointment->service_name) ?></p>

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

                                            <?php if ($discount != 0): ?>
                                              <span class="small badge badge-sm">
                                                  <?php echo html_escape($discount) ?>% <?php echo trans('off') ?>
                                              </span>
                                            <?php endif ?>

                                            <span class="small badge badge-sm mb-0">
                                                <?php if ($appointment->price == 0): ?>
                                                    <?php echo trans('free') ?>
                                                <?php else: ?>
                                                    <?php if($company->curr_locate == 0){echo get_currency_by_country($company->country)->currency_symbol;} ?><?php echo number_format($amount, $company->num_format) ?> <?php if($company->curr_locate == 1){echo get_currency_by_country($company->country)->currency_symbol;} ?>
                                                <?php endif ?>
                                            </span>
                                            <p class="mt-1"><span class="small badge badge-sm mb-0"><?php echo html_escape($appointment->duration).' '.trans($appointment->duration_type) ?> </span></p>
                                        </td>
                                        <td>
                                            <?php if ($appointment->location_id != 0): ?>
                                                <p class="mb-1">
                                                    <?php echo get_by_id($appointment->location_id, 'locations')->name ?>
                                                </p>
                                            <?php endif ?>
                                            <?php if ($appointment->sub_location_id != 0): ?>
                                                <p class="mb-0"><?php echo get_by_id($appointment->sub_location_id, 'locations')->name ?> (<?php echo get_by_id($appointment->sub_location_id, 'locations')->address ?>)</p>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($appointment->note)): ?>
                                                <p data-toggle="tooltip" title="<?php echo $appointment->note; ?>" data-placement="top" class="mb-1" title="<?php echo $appointment->note; ?>"><span class="badge badgesm badge-warning-soft"><i class="far fa-file-alt"></i> Note </span></p>
                                            <?php endif ?>

                                            <?php echo html_escape($appointment->customer_name) ?>
                                            <?php if ($appointment->group_booking != 0): ?>
                                            <p class="mb-1"><span class="badge badge-primary-soft badge-sm mb-0"><?php echo trans('group-booking') ?> - <i class="fas fa-users"></i> <?php echo $appointment->total_person + 1 ?> </span></p>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary-soft br-2"><i class="far fa-calendar-alt"></i> <?php echo my_date_show($appointment->date) ?></span><br>

                                            <?php if ($appointment->duration_type != 'day'): ?>
                                            <span class="mt-1 badge badge-secondary-soft br-2"><i class="far fa-clock"></i> <?php echo format_time($appointment->time, $company->time_format) ?></span>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <?php if ($appointment->status == 0): ?>
                                                <span><i class="far fa-circle text-warning fs-13"></i> <?php echo trans('pending') ?></span>
                                            <?php elseif ($appointment->status == 1): ?>
                                                <span><i class="far fa-circle text-success fs-13"></i> <?php echo trans('approved') ?></span>
                                            <?php elseif ($appointment->status == 2): ?>
                                                <span><i class="far fa-circle text-danger fs-13"></i> <?php echo trans('rejected') ?></span>
                                            <?php elseif ($appointment->status == 3): ?>
                                                <span><i class="far fa-circle text-primary fs-14"></i> <?php echo trans('completed') ?></span>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <?php $check_payment = check_appointment_payment($appointment->id) ?>
                                            <?php if ($check_payment == true): ?>
                                                <span class="badge badgesm badge-success-soft"><i class="fas fa-check-circle"></i> <?php echo trans('verified') ?></span>
                                            <?php else: ?>
                                                <?php if ($appointment->price != 0): ?>
                                                    <span class="badge badgesm badge-danger-soft"><i class="far fa-clock"></i> <?php echo trans('pending') ?></span>
                                                <?php endif ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty(settings()->google_client_id) && !empty(settings()->google_client_secret)): ?>
                                                <?php if (check_user_feature_access($appointment->user_id, 'google-calendar-sync') == TRUE): ?>
                                                    <?php if ($appointment->sync_calendar_staff != 1): ?>
                                                        <a data-toggle="tooltip" data-title="<?php echo trans('sync-google-calendar') ?>" target="_blank" href="<?php echo base_url('staff/sync/'.md5($appointment->id)) ?>" class="btn btn-light-danger btn-sm"><i class="fas fa-calendar-check"></i></a>
                                                    <?php endif ?>
                                                <?php endif ?>
                                            <?php endif ?>

                                            <a class="btn btn-light-primary btn-sm" href="#editModal_<?= $appointment->id; ?>" data-toggle="modal"><i class="lni lni-pencil"></i></a>
                                        </td>
                                    </tr>
                                <?php $a++; endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</seciton>



<!-- Modal -->
<?php $i=1; foreach ($appointments as $appointment): ?>
    <div class="modal fade d-hide" id="editModal_<?= $appointment->id; ?>" aria-hidden="true">
        <div class="modal-dialog">
        
            <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('staff/update_appointment/'.$appointment->id)?>" role="form" novalidate>
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><?php echo trans('edit-appointment') ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group d-hide">
                            <label><?php echo trans('services') ?> <span class="text-danger">*</span></label>
                            <select class="form-control select2s" name="service_id">
                                <option value=""><?php echo trans('services') ?></option>
                                <?php foreach ($services as $service): ?>
                                <option value="<?php echo html_escape($service->id) ?>" <?php if ($appointment->service_id == $service->id){echo "selected";} ?>><?php echo html_escape($service->name) ?></option>
                                <?php endforeach ?>                 
                            </select>
                        </div>
                        
                        <div class="form-group d-hide">
                            <label><?php echo trans('customers') ?> <span class="text-danger">*</span></label>
                            <select class="form-control select2s" name="customer_id">
                                <option value=""><?php echo trans('customers') ?></option>
                                <?php foreach ($customers as $customer): ?>
                                <option value="<?php echo html_escape($customer->id) ?>" <?php if ($appointment->customer_id == $customer->id){echo "selected";} ?>><?php echo html_escape($customer->name) ?></option>
                                <?php endforeach ?>                 
                            </select>
                        </div>
                        
                        <div class="form-group d-show">
                            <label><?php echo trans('status') ?> <span class="text-danger">*</span></label>
                            <select name="status" class="select2s form-control">
                                <option value="0" <?php if($appointment->status == 0){echo "selected";} ?>> <?php echo trans('pending') ?></option>
                                <option value="1" <?php if($appointment->status == 1){echo "selected";} ?>> <?php echo trans('approved') ?></option>
                                <option value="2" <?php if($appointment->status == 2){echo "selected";} ?>> <?php echo trans('rejected') ?></option>
                                <option value="3" <?php if($appointment->status == 3){echo "selected";} ?>> <?php echo trans('completed') ?></option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label><?php echo trans('date') ?> <span class="text-danger">*</span></label>
                            <div class="input-group">
                            <input type="text" name="date" class="form-control datepicker" required placeholder="Booking date" autocomplete="off" value="<?php echo html_escape($appointment->date); ?>">
                            <span class="input-group-append">
                                <button type="button" class="btn btn-secondary"><i class="fas fa-calendar-alt"></i></button>
                            </span>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <?php list ($start_time, $end_time) = explode('-', trim($appointment->time)); ?>
                            <div class="col-sm-6">
                                <label><?php echo trans('start-time') ?> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                    <input type="text" class="form-control timepicker" name="start_time" value="<?php if (isset($start_time)){echo html_escape($start_time);} ?>" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label><?php echo trans('end-time') ?> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                    <input type="text" class="form-control timepicker" name="end_time" value="<?php if (isset($end_time)){echo html_escape($end_time);} ?>" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer justify-content-between">
                        <!-- csrf token -->
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                        <button type="submit" class="btn btn-primary btn-block"><?php echo trans('save-changes') ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $i++; endforeach; ?>
<!-- End Modal -->