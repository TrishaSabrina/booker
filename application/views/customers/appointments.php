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
                                <form class="sort_form" method="get" action="<?php echo base_url('customer/appointments') ?>">
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
                                    <th scope="col"><?php echo trans('date') ?></th>
                                    <th scope="col"><?php echo trans('company-name') ?></th>
                                    <th scope="col"><?php echo trans('staff') ?></th>
                                    <th scope="col"><?php echo trans('status') ?></th>
                                    <th scope="col"><?php echo trans('payment') ?></th>
                                    <th scope="col"><?php echo trans('action') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $a=1; foreach ($appointments as $appointment): ?>
                                    <tr id="row_<?php echo html_escape($appointment->id) ?>">
                                        <th class="pl-5" scope="row"><?php echo html_escape($a) ?></th>
                                        <td width="15%">
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
                                            <?php if ($appointment->group_booking != 0): ?>
                                            <span class="badge badge-secondary-soft br-2 mb-1"><?php echo trans('group-booking') ?> - <i class="fas fa-users"></i> <?php echo $appointment->total_person + 1 ?> </span>
                                            <?php endif ?>

                                            <span class="badge badge-secondary-soft br-2"><i class="fas fa-calendar-alt"></i> <?php echo my_date_show($appointment->date) ?></span><br>

                                            <?php if ($appointment->duration_type != 'day'): ?>
                                            <span class="mt-1 badge badge-secondary-soft br-2"><i class="fas fa-clock"></i> <?php echo format_time($appointment->time, $company->time_format) ?></span>
                                            <?php endif; ?>


                                            <?php if ($appointment->location_id != 0): ?>
                                                <p class="mb-0">
                                                    <?php echo get_by_id($appointment->location_id, 'locations')->name ?>
                                                
                                            <?php endif ?>
                                            <?php if ($appointment->sub_location_id != 0): ?>
                                                <?php echo get_by_id($appointment->sub_location_id, 'locations')->name ?> (<?php echo get_by_id($appointment->sub_location_id, 'locations')->address ?>)</p>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <span class="mb-1 small badge badge-primary-soft badge-sm"> <?php echo html_escape($appointment->business_name) ?></span>
                                        </td>
                                        <td><?php echo html_escape($appointment->staff_name) ?></td>

                                        <td>
                                            <?php if ($appointment->status == 0): ?>
                                                <span><i class="far fa-circle text-warning fs-14"></i> <?php echo trans('pending') ?></span>
                                            <?php elseif ($appointment->status == 1): ?>
                                                <span><i class="far fa-circle text-success fs-14"></i> <?php echo trans('approved') ?></span>
                                            <?php elseif ($appointment->status == 2): ?>
                                                <span><i class="far fa-circle text-danger fs-14"></i> <?php echo trans('rejected') ?></span>
                                            <?php elseif ($appointment->status == 3): ?>
                                                <span><i class="far fa-circle text-primary fs-14"></i> <?php echo trans('completed') ?></span>
                                            <?php endif ?>
                                        </td>

                                        <td>
                                            <?php $check_payment = check_appointment_payment($appointment->id) ?>
                                            <?php if ($check_payment == true): ?>
                                                <span class="badge badgesm badge-success-soft"><i class="fas fa-check-circle"></i> <?php echo trans('paid') ?></span>
                                            <?php else: ?>
                                                <?php if ($appointment->price != 0): ?>
                                                    <span class="badge badgesm badge-danger-soft"><i class="far fa-clock"></i> <?php echo trans('pending') ?></span>
                                                <?php endif ?>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <td width="10%">
                                            <?php if ($check_payment == true): ?>
                                                <?php $cpayment = appointment_payment_details($appointment->id) ?>
                                                <a target="_blank" href="<?php echo base_url('customer/customer_receipt/'.$cpayment->puid) ?>" class="pull-right badge badge-primary-soft"><i class="fa fa-eye"></i> <?php echo trans('view-invoice') ?></a>
                                            <?php endif; ?>

                                            <?php if (empty($appointment->pay_info) && $check_payment != true): ?>
                                                <?php if ($appointment->price != 0): ?>
                                                    <a data-toggle="tooltip" data-title="<?php echo trans('complete-your-payment') ?>" data-placement="left" class="btn btn-light-primary btn-sm" data-id="<?php echo html_escape($appointment->id) ?>" href="<?php echo base_url('customer/payment/'.md5($appointment->id)) ?>"><i class="fas fa-credit-card"></i></a>
                                                <?php endif ?>
                                            <?php endif ?>
                                            <?php if ($appointment->pay_info == 1 && $check_payment != true): ?>
                                                <?php if ($appointment->price != 0): ?>
                                                    <a data-toggle="tooltip" data-title="<?php echo trans('complete-your-payment') ?>" data-placement="left" class="btn btn-light-primary btn-sm" data-id="<?php echo html_escape($appointment->id) ?>" href="<?php echo base_url('customer/payment/'.md5($appointment->id)) ?>"><i class="fas fa-credit-card"></i></a>
                                                <?php endif ?>
                                            <?php endif ?>

                                            <?php if ($check_payment != true): ?>
                                                <a data-toggle="tooltip" data-title="<?php echo trans('cancel-appointment') ?>" data-placement="top" class="btn btn-light-danger btn-sm cancel_item" data-id="<?php echo html_escape($appointment->id) ?>" href="<?php echo base_url('customer/cancel/'.md5($appointment->id)) ?>"><i class="fas fa-times-circle fs-12"></i></a>
                                            <?php endif ?>

                                            <?php if (!empty($appointment->zoom_link)): ?>
                                                <a target="_blank" data-toggle="tooltip" data-title="<?php echo trans('zoom-meeting-link') ?>" data-placement="top" class="btn btn-primary btn-sm" data-id="<?php echo html_escape($appointment->id) ?>" href="<?php echo html_escape($appointment->zoom_link) ?>"><i class="fas fa-video fs-12"></i></a>
                                            <?php endif ?>

                                            <?php if (!empty($appointment->google_meet)): ?>
                                                <a target="_blank" data-toggle="tooltip" data-title="<?php echo trans('google-meet-link') ?>" data-placement="top" class="btn btn-success btn-sm" data-id="<?php echo html_escape($appointment->id) ?>" href="<?php echo html_escape($appointment->google_meet) ?>"><i class="fas fa-video fs-12"></i></a>
                                            <?php endif ?>

                                            <?php if ($appointment->status == 3): ?>
                                                <?php $check = check_apo_rating($appointment->id); ?>
                                                <?php if (check_apo_rating($appointment->id) == 0): ?>
                                                    <a href="#ratingModal_<?php echo $a ?>" data-toggle="modal" class="btn btn-outline-warning btn-sm"> <i class="far fa-star fs-14"></i></a>
                                                <?php else: ?>
                                                    <a href="#ratingModal_<?php echo $a ?>" data-toggle="modal" class="btn btn-warning btn-sm"> <i class="fas fa-star fs-14"></i></a>
                                                <?php endif ?>
                                            <?php endif ?>

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
<?php $b=1; foreach ($appointments as $appointment): ?>
<div class="modal fade d-hide" id="ratingModal_<?= $b; ?>" aria-hidden="true">
  <div class="modal-dialog">
  
    <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('customer/add_rating')?>" role="form" novalidate>
      <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">
            <?php if (check_apo_rating($appointment->id) == 0): ?>
                <?php echo trans('rate-this-service') ?>
            <?php else: ?>
                <?php echo trans('your-feedback') ?>
            <?php endif; ?>
        </h4>
          <div class="mclose" data-dismiss="modal"><i class="lnib lni-close"></i></div>
        </div>

        <div class="modal-body">
            <?php if (check_apo_rating($appointment->id) == 0): ?>
                <?php 
                $id1 = $b+rand(); $id2 = $b+rand(); $id3 = $b+rand(); $id4 = $b+rand(); $id5 = $b+rand();
            ?>
                <div class="form-group mt-2">
                    <fieldset class="rating one mb-4">
                        <input type="radio" id="star<?= $id1 ?>" name="rating" value="5" /><label for="star<?= $id1 ?>"><span><i class="fas fa-star"></i></span></label>
                        <input type="radio" id="star<?= $id2 ?>" name="rating" value="4" /><label for="star<?= $id2 ?>"><span><i class="fas fa-star"></i></span></label>
                        <input type="radio" id="star<?= $id3 ?>" name="rating" value="3" /><label for="star<?= $id3 ?>"><span><i class="fas fa-star"></i></span></label>
                        <input type="radio" id="star<?= $id4 ?>" name="rating" value="2" /><label for="star<?= $id4 ?>"><span><i class="fas fa-star"></i></span></label>
                        <input type="radio" id="star<?= $id5 ?>" name="rating" value="1" /><label for="star<?= $id5 ?>"><span><i class="fas fa-star"></i></span></label>
                    </fieldset>
                </div>

                <div class="form-group mt-2">
                    <textarea class="form-control" name="feedback" rows="2" placeholder="<?php echo trans('write-feedback') ?>"></textarea>
                </div>
            <?php else: ?>
                <?php $rating = check_apo_rating($appointment->id); ?>
                <?php for($i = 1; $i <= 5; $i++):?>
                <?php 
                if($i > $rating->rating){
                  $star = 'far fa-star';
                }else{
                  $star = 'fas fa-star';
                }
                ?>
                <i class="<?php echo $star;?> text-warning fs-13"></i> 
              <?php endfor;?>

                <p class="mt-2 lead"><?php echo $rating->feedback ?></p>
            <?php endif; ?>
        </div>

        <?php if (check_apo_rating($appointment->id) == 0): ?>
        <div class="modal-footer justify-content-between">
          <input type="hidden" name="appointment_id" value="<?php echo $appointment->id ?>">
          <!-- csrf token -->
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
          <button type="submit" class="btn btn-primary btn-sm"><?php echo trans('submit') ?></button>
        </div>
        <?php endif; ?>

      </div>
    </form>

    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<?php $b++; endforeach; ?>
<!-- End Modal -->
