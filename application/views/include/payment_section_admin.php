<?php
    $paypal_url = (settings()->paypal_mode == 'sandbox')?'https://www.sandbox.paypal.com/cgi-bin/webscr':'https://www.paypal.com/cgi-bin/webscr';
    $paypal_id = html_escape(settings()->paypal_email);

    $check_coupon = check_coupon($appointment->id, $appointment->service_id, $appointment->business_id);
    if ($check_coupon != FALSE):
        if (!empty($check_coupon)):
            $price = get_price($appointment->price, $appointment->group_booking, $appointment->total_person);
            $discount = $check_coupon->discount;
            $totalCost = $price - ($price * ($discount / 100));
            $discount_amount = $price - $totalCost;
        else:
            $price = get_price($appointment->price, $appointment->group_booking, $appointment->total_person);
            $discount = 0;
            $discount_amount = 0;
            $totalCost = $price;
        endif;
    else:
        $totalCost = get_price($appointment->price, $appointment->group_booking, $appointment->total_person);
    endif;
?>


<ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
    <?php if (settings()->paypal_payment == 1): ?>
        <li class="nav-item ml-1 mt-1">
            <a class="nav-link active" id="pills-paypal-tab" data-toggle="pill" href="#pills-paypal" role="tab"
                aria-controls="pills-paypal" aria-selected="true"> <?php echo trans('paypal') ?></a>
        </li>
    <?php endif ?>

    <?php if (settings()->stripe_payment == 1): ?>
        <li class="nav-item ml-1 mt-1">
            <a class="nav-link" id="pills-stripe-tab" data-toggle="pill" href="#pills-stripe" role="tab"
                aria-controls="pills-stripe" aria-selected="false"><?php echo trans('stripe') ?></a>
        </li>
    <?php endif ?>

    <?php if (settings()->razorpay_payment == 1): ?>
        <li class="nav-item ml-1 mt-1">
            <a class="nav-link" id="pills-razorpay-tab" data-toggle="pill" href="#pills-razorpay" role="tab"
                aria-controls="pills-razorpay" aria-selected="false"><?php echo trans('razorpay') ?></a>
        </li>
    <?php endif ?>

    <?php if (settings()->paystack_payment == 1): ?>
        <li class="nav-item ml-1 mt-1">
            <a class="nav-link" id="pills-paystack-tab" data-toggle="pill" href="#pills-paystack" role="tab"
                aria-controls="pills-paystack" aria-selected="false"><?php echo trans('paystack') ?></a>
        </li>
    <?php endif ?>

    <?php if ($user->flutterwave_payment == 1): ?>
        <li class="nav-item ml-1 mt-1">
            <a class="nav-link" id="pills-flutterwave-tab" data-toggle="pill" href="#pills-flutterwave" role="tab"
                aria-controls="pills-flutterwave" aria-selected="false"><?php echo trans('flutterwave') ?></a>
        </li>
    <?php endif ?>

    <?php if ($user->mercado_payment == 1): ?>
        <li class="nav-item ml-1 mt-1">
            <a class="nav-link" id="pills-mercado-tab" data-toggle="pill" href="#pills-mercado" role="tab"
                aria-controls="pills-mercado" aria-selected="false">MercadoPago</a>
        </li>
    <?php endif ?>
</ul>


<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-paypal" role="tabpanel" aria-labelledby="pills-paypal-tab">
        <?php if (settings()->paypal_payment == 1): ?>
            <div class="payment_area container <?php if (settings()->paypal_payment == 1){echo "d-show";}else{echo "d-hide";} ?>" id="paypal">
                <div class="row">
                    <div class="box col-md-12 m-auto text-center">

                        <div class="box-body text-center">

                            <div class="box-header mb-4 hide">
                                <badge class="mb-0 badge badge-pill badge-primary-soft">
                                    Total booking price:
                                    <?php if($company->curr_locate == 0){echo get_currency_by_country($company->country)->currency_symbol;} ?><?php echo number_format($totalCost, $company->num_format) ?> <?php if($company->curr_locate == 1){echo get_currency_by_country($company->country)->currency_symbol;} ?>
                                </badge><br>
                            </div>

                            <!-- PRICE ITEM -->
                            <form action="<?php echo html_escape($paypal_url); ?>" method="post" name="frmPayPal1">
                                <input type="hidden" name="business" value="<?php echo html_escape($paypal_id); ?>"
                                    readonly>
                                <input type="hidden" name="cmd" value="_xclick">
                                <input type="hidden" name="item_name" value="<?php echo html_escape($appointment->service_name) ?>">
                                <input type="hidden" name="item_number" value="<?php echo html_escape($appointment->number) ?>">
                                <input type="hidden" name="amount" class="paypal_price" value="<?php echo html_escape($totalCost) ?>">
                                <input type="hidden" name="no_shipping" value="1">
                                <input type="hidden" name="currency_code"
                                    value="<?php echo html_escape(get_currency_by_country($company->country)->currency_code);?>">
                                <input type="hidden" name="cancel_return"
                                    value="<?php echo base_url('customer/payment_msg/failed/'.html_escape($appointment->id)) ?>">
                                <input type="hidden" name="return"
                                    value="<?php echo base_url('admin/payment/payment_success/'.html_escape($appointment->id).'/paypal') ?>">

                                <div class="mt-30 mt-8">
                                    <button class="btn btn-primary paypal-btn btn-block" href="#"><i class="fas fa-check-circle"></i> <?php echo trans('pay-now') ?></button>
                                </div>
                            </form>
                            <!-- PRICE ITEM -->

                        </div>

                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>

    <div class="tab-pane fade" id="pills-stripe" role="tabpanel" aria-labelledby="pills-stripe-tab">
        <?php if (settings()->stripe_payment == 1): ?>
            <div class="payment_area container" id="stripe">
                <div class="row justify-content-center">
                    <div class="box col-md-12 m-auto text-center">

                        <div class="box-header mb-6 hide">
                            <badge class="mb-0 badge badge-pill badge-primary-soft">
                                Total booking price:
                                <?php echo get_currency_by_country($company->country)->currency_symbol; ?><?php echo html_escape($price) ?>
                            </badge><br>
                        </div>

                        <div class="credit-card-box">
                            <div class="d-flex justify-content-between info-title mb-4">
                                <div class="pt-1"><h5 class="mb-0"><?php echo trans('card-details') ?></h5> </div>
                                <div>
                                    <i class="text-primary fab fa-cc-visa fa-2x"></i> 
                                    <i class="text-primary fab fa-cc-mastercard fa-2x"></i> 
                                    <i class="text-primary fab fa-cc-discover fa-2x"></i> 
                                    <i class="text-primary fab fa-cc-amex fa-2x"></i>
                                </div>
                            </div>
                           
                            <div class="box-body p-0">
                                <form role="form" action="<?php echo base_url('admin/payment/stripe_appointment_payment') ?>"
                                    method="post" class="require-validation" data-cc-on-file="false"
                                    data-stripe-publishable-key="<?php echo html_escape(settings()->publish_key); ?>"
                                    id="payment-form">

                                    <div class='row'>
                                        <div class='col-xs-12 col-md-6 form-group required text-left'>
                                        </div>
                                        <div class='col-xs-12 col-md-6 form-group required text-left'>
                                        </div>
                                    </div>

                                    <div class='row'>
                                        <div class='col-xs-12 col-md-12 form-group required text-left'>
                                            <input autocomplete='off' class='textfield textfield--grey card-number'
                                                type='text' placeholder="<?php echo trans('card-number') ?>" value="" size='12'>
                                        </div>
                                        <div class='col-xs-12 col-md-12 form-group required text-left'>
                                            <input class='textfield textfield--grey' type='text' value=""
                                                placeholder="<?php echo trans('cardholders-name') ?>" size='12'>
                                        </div>
                                    </div>


                                    <div class='form-row row'>
                                        <div class='col-xs-12 col-md-4 form-group expiration required text-left'>
                                            <input class='textfield textfield--grey card-expiry-month'
                                                placeholder='MM' size='2' type='text' value="">
                                        </div>
                                        <div class='col-xs-12 col-md-4 form-group expiration required text-left'>
                                            <input class='textfield textfield--grey card-expiry-year'
                                                placeholder='YYYY' size='4' type='text' value="">
                                        </div>
                                        <div class='col-xs-12 col-md-4 form-group cvc required text-left'>
                                            <input autocomplete='off' class='textfield textfield--grey card-cvc'
                                                placeholder='CVC' size='4' type='text' value="">
                                        </div>
                                    </div>

                                    <div class="text-center text-success">
                                        <div class="payment_loader hide"><i class="fa fa-spinner fa-spin"></i> <?php echo trans('loading') ?>....
                                        </div><br>
                                    </div>

                                    <!-- csrf token -->
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>"
                                        value="<?php echo $this->security->get_csrf_hash();?>">

                                    <input type="hidden" name="appointment_id" value="<?php echo html_escape($appointment->id); ?>">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="badge badge-pill badge-warning-soft mb-4"><i class="icon-lock"></i>
                                                <?php echo trans('secure-and-encrypted') ?></div>
                                        </div>
                                        <div class="spacer py-4"></div>
                                        <div class="col-md-12 mb-30">
                                            <button class="btn btn-primary paypal-btn btn-block" type="submit"><i class="fas fa-check-circle"></i> <?php echo trans('pay-now') ?></button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>

    <div class="tab-pane fade" id="pills-razorpay" role="tabpanel" aria-labelledby="pills-razorpay-tab">
        <?php if (settings()->razorpay_payment == 1): ?>
            <div class="payment_area container <?php if (settings()->razorpay_payment == 1){echo "d-show";}else{echo "d-hide";} ?>" id="razorpay">
                <div class="row">
                    <div class="box col-md-12 m-auto text-center">
                        <div class="box-body text-center">

                           <?php
                                $productinfo = $company->name.'-'.$appointment->service_name;
                                $txnid = time();
                                $price = $totalCost;
                                $surl = '';
                                $furl = '';
                                $key_id = settings()->razorpay_key_id;
                                $currency_code =  get_currency_by_country($company->country)->currency_code;           
                                $total = ($price * 100); 
                                $amount = $price;
                                $merchant_order_id = $appointment->number;
                                $card_holder_name = $appointment->customer_name;
                                $email = $appointment->customer_email;
                                $phone = $appointment->customer_phone;
                                $name = settings()->site_name;
                                $return_url = base_url().'razorpay/user_payment';
                            ?>

                            <form name="razorpay-form" id="razorpay-form" action="<?php echo $return_url; ?>" method="POST">
                              <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" />
                              <input type="hidden" name="merchant_order_id" id="merchant_order_id" value="<?php echo $merchant_order_id; ?>"/>
                              <input type="hidden" name="merchant_trans_id" id="merchant_trans_id" value="<?php echo $txnid; ?>"/>
                              <input type="hidden" name="merchant_product_info_id" id="merchant_product_info_id" value="<?php echo $productinfo; ?>"/>
                              <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $surl; ?>"/>
                              <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $furl; ?>"/>
                              <input type="hidden" name="card_holder_name_id" id="card_holder_name_id" value="<?php echo $card_holder_name; ?>"/>
                              <input type="hidden" name="merchant_total" id="merchant_total" value="<?php echo $total; ?>"/>
                              <input type="hidden" name="merchant_amount" id="merchant_amount" value="<?php echo $amount; ?>"/>

                               <input type="hidden" name="appointment_id" value="<?php echo html_escape($appointment->id); ?>">
                               <input type="hidden" name="currency_code" value="<?php echo get_currency_by_country($company->country)->currency_code; ?>">
                              <!-- csrf token -->
                              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                            </form>

           
                            <div class="mt-4">
                                <button id="submit-pay" type="submit" onclick="razorpaySubmit(this);" class="btn btn-primary btn-block"> <i class="fas fa-check-circle"></i> <?php echo trans('pay-now') ?></button>
                            </div>
                          
                            <?php include APPPATH.'views/admin/include/razorpay-user-js.php'; ?>

                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>

     <div class="tab-pane fade" id="pills-paystack" role="tabpanel" aria-labelledby="pills-paystack-tab">
        <?php if (settings()->paystack_payment == 1): ?>
            <div class="payment_area container <?php if (settings()->paystack_payment == 1){echo "d-show";}else{echo "d-hide";} ?>" id="paystack">
                <div class="row">
                    <div class="box col-md-12 m-auto text-center">
                        <div class="box-body text-center">

                            <?php 
                                $paystack_type = 'user';
                                $email = $appointment->customer_email;
                                $price = $totalCost;
                             ?>
                            <div class="mt-4">
                                <script src="https://js.paystack.co/v1/inline.js"></script>
                                <button type="button" onclick="payWithPaystack()" class="btn btn-primary btn-block"><i class="fas fa-check-circle"></i> <?php echo trans('pay-now') ?> </button>
                            </div>
                          
                            <?php include APPPATH.'views/admin/include/paystack-js.php'; ?>

                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>


    <div class="tab-pane fade" id="pills-flutterwave" role="tabpanel" aria-labelledby="pills-flutterwave-tab">
        <?php if ($user->flutterwave_payment == 1): ?>
            <div class="payment_area container <?php if ($user->flutterwave_payment == 1){echo "d-show";}else{echo "d-hide";} ?>" id="flutterwave">
                <div class="row">
                    <div class="box col-md-12 m-auto text-center">
                        <div class="box-body text-center">

                            <?php 
                                $flutterwave_type = 'user';
                                $currency_code =  get_currency_by_country($company->country)->currency_code; 
                                $email = $appointment->customer_email;
                                $phone = $appointment->customer_phone;
                                $price = $totalCost;
                             ?>
                            <div class="mt-4">
                                <script type="text/javascript" src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
                                <button type="button" id="flutterwave_payment" class="btn btn-primary btn-block"><i class="fas fa-check-circle"></i> <?php echo trans('pay-now') ?> </button>
                            </div>
                          
                            <?php include APPPATH.'views/admin/include/flutterwave-js.php'; ?>

                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>

    <div class="tab-pane fade" id="pills-mercado" role="tabpanel" aria-labelledby="pills-mercado-tab">
        <?php if ($user->mercado_payment == 1): ?>
            <div class="payment_area container <?php if ($user->mercado_payment == 1){echo "d-show";}else{echo "d-hide";} ?>" id="mercado">
                <div class="row">
                    <div class="box col-md-12 m-auto text-center">
                        <div class="box-body text-center">
                            <div class="mt-4">
                                <a href="<?= prep_url($init); ?>" class="btn btn-primary btn-block"><i class="fas fa-check-circle"></i> <?php echo trans('pay-now') ?> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>

    
</div>