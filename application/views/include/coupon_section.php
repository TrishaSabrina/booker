<div class="col-md-12 mb-4">
    
    <?php if ($appointment->group_booking != 0): ?>
        <div class="d-flex justify-content-between align-items-center mt-2 mb-2">
            <div>
                <p class="mb-0">
                    <?php echo trans('total-persons') ?>
                </p>
            </div>

            <div>
                <p class="text-dark font-weight-bold mb-0">
                    <?php echo $appointment->total_person + 1 ?>
                </p>
            </div>
        </div>
    <?php endif; ?>


    <div class="d-flex justify-content-between align-items-center mt-2 mb-2">
        <div>
            <p class="mb-0"><?php echo trans('price') ?></p>
        </div>
        <div>
            <p class="text-dark font-weight-bold mb-0">
                <?php if ($appointment->price == 0): ?>
                    <?php echo trans('free') ?>
                <?php else: ?>
                    
                    <?php if ($appointment->group_booking != 0): ?>
                        <span><?php echo $appointment->total_person + 1 ?> <?php echo trans('persons'); ?> x <?php if($company->curr_locate == 0){echo get_currency_by_country($company->country)->currency_symbol;} ?> <?php echo number_format($appointment->price, $company->num_format) ?> <?php if($company->curr_locate == 1){echo get_currency_by_country($company->country)->currency_symbol;} ?> = </span>
                    <?php endif ?>

                    <?php $apprice = get_price($appointment->price, $appointment->group_booking, $appointment->total_person); ?>
                    <?php if($company->curr_locate == 0){echo get_currency_by_country($company->country)->currency_symbol;} ?> <?php echo number_format($apprice, $company->num_format) ?> <?php if($company->curr_locate == 1){echo get_currency_by_country($company->country)->currency_symbol;} ?>
                <?php endif ?>
            </p>
        </div>
    </div>

    <?php $check_coupon = check_coupon($appointment->id, $appointment->service_id, $appointment->business_id); ?>
    <?php $service_status = check_coupon_status($appointment->service_id, $appointment->business_id); ?>

        <?php if ($check_coupon != FALSE): ?>
            <?php if (!empty($check_coupon)): ?>
                <?php 
                    $price = get_price($appointment->price, $appointment->group_booking, $appointment->total_person);
                    $discount = $check_coupon->discount;
                    $totalCost = $price - ($price * ($discount / 100));
                    $discount_amount = $price - $totalCost;
                 ?>
            <?php else: ?>
                <?php 
                    $price = get_price($appointment->price, $appointment->group_booking, $appointment->total_person);
                    $discount = 0;
                    $discount_amount = 0;
                    $totalCost = $price;
                 ?>
            <?php endif ?>
        <?php else: ?>
            <?php $totalCost = get_price($appointment->price, $appointment->group_booking, $appointment->total_person); $discount = 0; $discount_amount = 0;?>
        <?php endif ?>

        <div class="d-flex justify-content-between align-items-center mt-2 mb-2">
            <div>
                <p class="mb-0"><?php echo trans('discount') ?> <span class="percent"><?php if($discount != 0){echo html_escape($discount.'%');} ?></span></p>
            </div>
            <div>
                <p class="text-dark font-weight-bold mb-0">
                    <?php if($company->curr_locate == 0){echo get_currency_by_country($company->country)->currency_symbol;} ?> <span class="coupon_amount"><?php if($discount_amount != 0){echo number_format($discount_amount, $company->num_format);}else{echo number_format(0, $company->num_format);} ?></span> <?php if($company->curr_locate == 1){echo get_currency_by_country($company->country)->currency_symbol;} ?>
                </p>
            </div>
        </div>

        <?php if ($service_status == TRUE): ?>
            <?php if ($discount == 0): ?>
                <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                    <div>
                        <p class="mb-0"><?php echo trans('add-coupon') ?></p>
                    </div>
                    <div>
                        <div class="input-group input-group-sm">
                            <input type="text" name="coupon_code" class="form-control form-control-sm coupon_code" placeholder="Code here" aria-label="Apply Code here" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <input type="hidden" name="appointment_id" class="appointment_id" value="<?php echo html_escape($appointment->id) ?>">
                                <button class="btn btn-primary apply_coupon" type="button"><?php echo trans('apply') ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        <?php endif ?>

        <div class="d-flexs apply_msg text-right">
            <span class="badge badge-success-soft mb-2 mt-2 d-hide apply_msg_success"></span>
            <span class="badge badge-danger-soft mb-2 mt-2 d-hide apply_msg_error"></span>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3 pt-2 mb-2 btm-1">
            <div>
                <p class="mb-0"><?php echo trans('total-cost') ?></p>
            </div>
            <div>
                <p class="text-dark font-weight-bold mb-0">
                    <?php if($company->curr_locate == 0){echo get_currency_by_country($company->country)->currency_symbol;} ?> <span class="final_amount"><?php echo number_format($totalCost, $company->num_format) ?></span> <?php if($company->curr_locate == 1){echo get_currency_by_country($company->country)->currency_symbol;} ?>
                </p>
            </div>
        </div>
    
</div>