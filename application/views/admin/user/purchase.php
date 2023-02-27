
<?php $settings = get_settings(); ?>
<?php
    $paypal_url = ($settings->paypal_mode == 'sandbox')?'https://www.sandbox.paypal.com/cgi-bin/webscr':'https://www.paypal.com/cgi-bin/webscr';
    $paypal_id= html_escape($settings->paypal_email);
?>

<div class="content-wrapper">
    <div class="content">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-8 m-auto">

                    <?php if ($billing_type == 'monthly'): ?>
                        <?php 
                            $price = $package->monthly_price;
                            $frequency = trans('per-month');
                            $billing_type = 'monthly';
                        ?>
                    <?php elseif ($billing_type == 'lifetime'): ?>
                        <?php 
                            $price = $package->lifetime_price; 
                            $frequency = trans('lifetime');
                            $billing_type = 'lifetime';
                        ?>
                    <?php else: ?>
                        <?php 
                            $price = $package->price; 
                            $frequency = trans('per-year');
                            $billing_type = 'yearly';
                        ?>
                    <?php endif ?>

                    <?php if (isset($coupon)): ?>
                        <?php $price = $price - ($price * ($coupon->discount/100));  ?>
                    <?php endif ?>

                    <?php $price = str_replace(',','', get_tax($price, settings()->tax_value)); ?>
                    
                    <ul class="nav nav-pills mb-3 mt-5 justify-content-center" id="pills-tab" role="tablist">
                        <?php if (settings()->paypal_payment == 1): ?>
                            <li class="nav-item mb-2">
                                <a class="linkd nav-link" id="paypal-tab" data-toggle="pill" href="#paypal" role="tab" aria-controls="paypal" aria-selected="true"><img width="60px" src="<?php echo base_url() ?>assets/images/payments/paypal.svg"/> </a></a>
                            </li>
                        <?php endif; ?>

                        <?php if (settings()->stripe_payment == 1): ?>
                        <li class="nav-item mb-2">
                            <a class="linkd nav-link" id="stripe-tab" data-toggle="pill" href="#stripe" role="tab" aria-controls="stripe" aria-selected="false"><img width="50px" src="<?php echo base_url() ?>assets/images/payments/stripe.svg"/></a>
                        </li>
                        <?php endif; ?>

                        <?php if (settings()->razorpay_payment == 1): ?>
                        <li class="nav-item mb-2">
                            <a class="linkd nav-link" id="razorpay-tab" data-toggle="pill" href="#razorpay" role="tab" aria-controls="razorpay" aria-selected="false"><img width="70px" src="<?php echo base_url() ?>assets/images/payments/razorpay.svg"/></a>
                        </li>
                        <?php endif; ?>

                        <?php if (settings()->paystack_payment == 1): ?>
                        <li class="nav-item mb-2">
                            <a class="linkd nav-link" id="paystack-tab" data-toggle="pill" href="#paystack" role="tab" aria-controls="paystack" aria-selected="false"><img width="70px" src="<?php echo base_url() ?>assets/images/payments/paystack.svg"/></a>
                        </li>
                        <?php endif; ?>

                        <?php if (settings()->flutterwave_payment == 1): ?>
                        <li class="nav-item mb-2">
                            <a class="linkd nav-link" id="flutterwave-tab" data-toggle="pill" href="#flutterwave" role="tab" aria-controls="flutterwave" aria-selected="false"><img width="70px" src="<?php echo base_url() ?>assets/images/payments/flutterwave.svg"/></a>
                        </li>
                        <?php endif; ?>

                        <?php if (settings()->mercado_payment == 1): ?>
                        <li class="nav-item mb-2">
                            <a class="linkd nav-link" data-toggle="pill" href="#mercado"><img width="70px" src="<?php echo base_url() ?>assets/images/payments/mercado_pago.svg"/></a>
                        </li>
                        <?php endif ?>

                        <?php if (settings()->enable_offline_payment == 1): ?>
                        <li class="nav-item">
                            <a class="linkd nav-link" id="offline-tab" data-toggle="pill" href="#offline" role="tab" aria-controls="offline" aria-selected="false"><?php echo trans('offline-payment') ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>

                    <div class="card mt-4">

                        <?php if (settings()->enable_coupon == 1): ?>
                        <div class="coupon_area d-hide">
                            <a href="#" class="btn btn-secondary-soft toggle_btn mb-2"><?php echo trans('have-any-coupon-code') ?></a>

                            <div class="card-body mb-2 toggle_area d-hide">
                              <div class="input-group mt-1">
                                  <input type="text" name="coupon_code" class="form-control coupon_code" placeholder="Coupon code" aria-label="Apply Code here" aria-describedby="basic-addon2">
                                  <div class="input-group-append">
                                      <input type="hidden" name="plan_id" class="plan_id" value="<?php echo $package->id ?>">
                                      <input type="hidden" name="billing_type" class="billing_type" value="<?php echo $billing_type ?>">
                                      <button class="btn btn-primary apply_coupon" type="button"><?php echo trans('apply') ?></button>
                                  </div>
                              </div>

                              <div class="d-flexs apply_msg text-right mt-2">
                                  <span class="badge badge-success-soft mb-2 mt-2 d-hide apply_msg_success"></span>
                                  <span class="badge badge-danger-soft mb-2 mt-2 d-hide apply_msg_error"></span>
                              </div>
                            </div>
                        </div>
                        <?php endif ?>

                        <div class="card-body">
                            <div class="tab-content" id="pills-tabContent">
                                
                                <span class="linkd_hide"><?php echo trans('select-payment-method') ?></span>

                                <div class="tab-pane fade show" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">

                                    <p class="mb-0 text-center"><?php echo trans('plan') ?>: <?php echo html_escape($package->name);?> </p>
                                    <p class="mb-0"><strong><?php if(settings()->curr_locate == 0){echo settings()->currency_symbol;} ?><?php echo html_escape($price) ?> <?php if(settings()->curr_locate == 1){echo settings()->currency_symbol;} ?></strong> <small><?php echo html_escape($frequency) ?></small></p>

                                    <?php if (isset($coupon)): ?>
                                        <p class="small mb-0"><?php echo trans('discount') ?>: (<?php echo $coupon->discount ?>%)</p>
                                    <?php endif ?>

                                    <?php if (settings()->tax_value != '' && settings()->tax_value != 0): ?>
                                        <p class="small"><?php echo settings()->tax_name ?> (<?php echo settings()->tax_value ?>%)</p>
                                    <?php endif ?>


                                    <!-- PRICE ITEM -->
                                    <form action="<?php echo html_escape($paypal_url); ?>" method="post" name="frmPayPal1">
                                    
                                        <input type="hidden" name="business" value="<?php echo html_escape($paypal_id); ?>" readonly>
                                        <input type="hidden" name="cmd" value="_xclick">
                                        <input type="hidden" name="item_name" value="<?php echo html_escape($package->name);?>">
                                        <input type="hidden" name="item_number" value="1">
                                        <input type="hidden" name="amount" value="<?php echo html_escape($price) ?>" readonly>
                                        <input type="hidden" name="no_shipping" value="1">
                                        <input type="hidden" name="currency_code" value="<?php echo html_escape($settings->currency_code);?>">
                                        <input type="hidden" name="cancel_return" value="<?php echo base_url('admin/subscription/payment_cancel/'.$billing_type.'/'.html_escape($package->id).'/'.html_escape($payment_id)) ?>">
                                        <input type="hidden" name="return" value="<?php echo base_url('admin/subscription/payment_success/'.$billing_type.'/'.html_escape($package->id).'/'.html_escape($payment_id)) ?>">  
                                        
                                        <div class="mt-4">
                                            <button class="btn btn-primary paypal-btn btn-block" href="#"><?php echo trans('pay-now') ?></button>
                                        </div>
                                        
                                    </form>
                                    <!-- /PRICE ITEM -->
                                </div>

                                <div class="tab-pane fade" id="stripe" role="tabpanel" aria-labelledby="stripe-tab">
                                    <div class="credit-card-box">
                                        <div class="d-flex justify-content-between">
                                            <div class="pt-1"><h5><?php echo trans('card-details') ?></h5> </div>
                                            <div>
                                                <i class="text-primary fab fa-cc-visa fa-2x"></i> 
                                                <i class="text-primary fab fa-cc-mastercard fa-2x"></i> 
                                                <i class="text-primary fab fa-cc-discover fa-2x"></i> 
                                                <i class="text-primary fab fa-cc-amex fa-2x"></i>
                                            </div>
                                        </div><hr>
                                       
                                        <div class="box-body p-0">
                            
                                            <form role="form" action="<?php echo base_url('admin/subscription/stripe_payment') ?>" method="post" class="require-validation stripe_form" data-cc-on-file="false" data-stripe-publishable-key="<?php echo html_escape($settings->publish_key); ?>" id="payment-form">
                                                
                                                <div class='row'>
                                                    <div class='col-xs-12 col-md-6 form-group required text-left'>
                                                    </div>
                                                    <div class='col-xs-12 col-md-6 form-group required text-left'>
                                                    </div>
                                                </div>

                                                <div class='row'>
                                                    <div class='col-xs-12 col-md-12 form-group required text-left'>
                                                        <label class='control-label'><?php echo trans('card-number') ?></label> 
                                                        <input autocomplete='off' class='textfield textfield--grey card-number'
                                                            type='text' value="" size='6'>
                                                    </div>
                                                    <div class='col-xs-12 col-md-12 form-group required text-left'>
                                                        <label class='control-label'><?php echo trans('cardholders-name') ?></label> 
                                                        <input class='textfield textfield--grey' type='text' value="" size='6'>
                                                    </div>
                                                </div>
                                    

                                                <div class='form-row row'>
                                                    <div class='col-xs-12 col-md-4 form-group expiration required text-left'>
                                                        <label class='control-label'><?php echo trans('month') ?></label> <input
                                                            class='textfield textfield--grey card-expiry-month' placeholder='MM' size='2'
                                                            type='text' value="">
                                                    </div>
                                                    <div class='col-xs-12 col-md-4 form-group expiration required text-left'>
                                                        <label class='control-label'><?php echo trans('year') ?></label> <input
                                                            class='textfield textfield--grey card-expiry-year' placeholder='YYYY' size='4'
                                                            type='text' value="">
                                                    </div>
                                                    <div class='col-xs-12 col-md-4 form-group cvc required text-left'>
                                                        <label class='control-label'>CVC</label> <input autocomplete='off'
                                                            class='textfield textfield--grey card-cvc' placeholder='ex. 311' size='4'
                                                            type='text' value="">
                                                    </div>
                                                </div>

                                                <!-- csrf token -->
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

                                                <input type="hidden" name="billing_type" value="<?php echo html_escape($billing_type); ?>" readonly>
                                                <input type="hidden" name="package_id" value="<?php echo html_escape($package->id); ?>" readonly>
                                                <input type="hidden" name="payment_id" value="<?php echo html_escape($payment_id); ?>" readonly>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p class="mb-0 text-center"><?php echo trans('plan') ?>: <?php echo html_escape($package->name);?> </p>
                                                        <p class="mb-0"><strong><?php if(settings()->curr_locate == 0){echo settings()->currency_symbol;} ?><?php echo html_escape($price) ?> <?php if(settings()->curr_locate == 1){echo settings()->currency_symbol;} ?></strong> <small><?php echo html_escape($frequency) ?></small></p>

                                                        <?php if (isset($coupon)): ?>
                                                            <p class="small mb-0"><?php echo trans('discount') ?>: (<?php echo $coupon->discount ?>%)</p>
                                                        <?php endif ?>

                                                        <?php if (settings()->tax_value != '' && settings()->tax_value != 0): ?>
                                                            <p class="small"><?php echo settings()->tax_name ?> (<?php echo settings()->tax_value ?>%)</p>
                                                        <?php endif ?>
                                                        
                                                        <div class="text-center text-success">
                                                            <div class="payment_loader hide"><i class="fa fa-spinner fa-spin"></i> <?php echo trans('loading') ?>....</div><br>
                                                        </div>
                                                        <button class="btn btn-primary payment_btn btn-block" type="submit"><?php echo trans('pay-now') ?></button>
                                                    </div>
                                                </div>
                                                        
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="razorpay" role="tabpanel" aria-labelledby="razorpay-tab">
                                   <div class="box-body p-0">
                                       <div class="row">
                                            <?php
                                                $productinfo = $package->name;
                                                $txnid = time();
                                                $price = $price;

                                                $surl = base_url('admin/subscription/payment_success/'.$billing_type.'/'.html_escape($package->id).'/'.html_escape($payment_id));

                                                $furl = base_url('admin/subscription/payment_cancel/'.$billing_type.'/'.html_escape($package->id).'/'.html_escape($payment_id));

                                                $key_id = settings()->razorpay_key_id;
                                                $currency_code = settings()->currency_code;            
                                                $total = ($price * 100); 
                                                $amount = $price;
                                                $merchant_order_id = $package->id;
                                                $card_holder_name = user()->name;
                                                $email = user()->email;
                                                $phone = user()->phone;
                                                $name = settings()->site_name;
                                                $return_url = base_url().'razorpay/payment';
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

                                               <input type="hidden" name="billing_type" value="<?php echo html_escape($billing_type); ?>" readonly>
                                              <!-- csrf token -->
                                              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                            </form>

                                            
                                            <div class="col-12">
                                                <p class="mb-0 text-center"><?php echo trans('plan') ?>: <?php echo html_escape($package->name);?> </p>
                                                <p class="mb-0 text-center"><strong><?php if(settings()->curr_locate == 0){echo settings()->currency_symbol;} ?><?php echo html_escape($price) ?> <?php if(settings()->curr_locate == 1){echo settings()->currency_symbol;} ?></strong> <small><?php echo html_escape($frequency) ?></small></p>

                                                <?php if (isset($coupon)): ?>
                                                    <p class="small mb-0"><?php echo trans('discount') ?>: (<?php echo $coupon->discount ?>%)</p>
                                                <?php endif ?>

                                                <?php if (settings()->tax_value != '' && settings()->tax_value != 0): ?>
                                                    <p class="small text-center"><?php echo settings()->tax_name ?> (<?php echo settings()->tax_value ?>%)</p>
                                                <?php endif ?>

                                                <div class="mt-4">
                                                    <input id="submit-pay" type="submit" onclick="razorpaySubmit(this);" value="Pay Now" class="btn btn-primary btn-sm btn-block" />
                                                </div>
                                            </div>
                                            <?php include APPPATH.'views/admin/include/razorpay-js.php'; ?>
                                       </div>
                                   </div>
                                   
                                </div>

                                <div class="tab-pane fade" id="paystack" role="tabpanel" aria-labelledby="paystack-tab">
                                   <div class="box-body p-0">
                                       <div class="row">
                                            
                                            <div class="col-12">
                                                <p class="mb-0 text-center"><?php echo trans('plan') ?>: <?php echo html_escape($package->name);?> </p>
                                                <p class="mb-0 text-center"><strong><?php if(settings()->curr_locate == 0){echo settings()->currency_symbol;} ?><?php echo html_escape($price) ?> <?php if(settings()->curr_locate == 1){echo settings()->currency_symbol;} ?></strong> <small><?php echo html_escape($frequency) ?></small></p>

                                                <?php if (isset($coupon)): ?>
                                                    <p class="small mb-0"><?php echo trans('discount') ?>: (<?php echo $coupon->discount ?>%)</p>
                                                <?php endif ?>

                                                <?php if (settings()->tax_value != '' && settings()->tax_value != 0): ?>
                                                    <p class="small text-center"><?php echo settings()->tax_name ?> (<?php echo settings()->tax_value ?>%)</p>
                                                <?php endif ?>

                                                <div class="mt-4">
                                                    <script src="https://js.paystack.co/v1/inline.js"></script>
                                                    <button type="button" onclick="payWithPaystack()" class="btn btn-primary btn-md btn-block"> <?php echo trans('pay-now') ?> </button>
                                                </div>
                                            </div>
                                            <?php include APPPATH.'views/admin/include/paystack-js.php'; ?>
                                       </div>
                                   </div>
                                   
                                </div>


                                <?php if (settings()->mercado_payment == 1): ?>
                                    <div class="tab-pane text-center" id="mercado">
                                       <div class="row">
                                            <div class="box col-md-12">
                                                <div class="box-body text-center">
                                                    <div class="payment_content text-center">
                                                        <p class="mb-0 text-center"><?php echo trans('plan') ?>: <?php echo html_escape($package->name);?> </p>
                                                        <p class="mb-0 text-center"><strong><?php if(settings()->curr_locate == 0){echo settings()->currency_symbol;} ?><?php echo html_escape($price) ?> <?php if(settings()->curr_locate == 1){echo settings()->currency_symbol;} ?></strong> <small><?php echo html_escape($frequency) ?></small></p>

                                                        <?php if (isset($coupon)): ?>
                                                            <p class="small mb-0"><?php echo trans('discount') ?>: (<?php echo $coupon->discount ?>%)</p>
                                                        <?php endif ?>

                                                        <?php if (settings()->tax_value != '' && settings()->tax_value != 0): ?>
                                                            <p class="small text-center"><?php echo settings()->tax_name ?> (<?php echo settings()->tax_value ?>%)</p>
                                                        <?php endif ?><br>
                                                    
                                                        <a href="<?= prep_url($init); ?>" class="btn btn-primary btn-block btn-md"><?php echo trans('pay-now') ?></a>
                                                
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>




                                <div class="tab-pane fade" id="flutterwave" role="tabpanel" aria-labelledby="flutterwave-tab">
                                   <div class="box-body p-0">
                                       <div class="row">
                                            
                                            <div class="col-12">
                                                <p class="mb-0 text-center"><?php echo trans('plan') ?>: <?php echo html_escape($package->name);?> </p>
                                                <p class="mb-0 text-center"><strong><?php if(settings()->curr_locate == 0){echo settings()->currency_symbol;} ?><?php echo html_escape($price) ?> <?php if(settings()->curr_locate == 1){echo settings()->currency_symbol;} ?></strong> <small><?php echo html_escape($frequency) ?></small></p>

                                                <?php if (isset($coupon)): ?>
                                                    <p class="small mb-0"><?php echo trans('discount') ?>: (<?php echo $coupon->discount ?>%)</p>
                                                <?php endif ?>

                                                <?php if (settings()->tax_value != '' && settings()->tax_value != 0): ?>
                                                    <p class="small text-center"><?php echo settings()->tax_name ?> (<?php echo settings()->tax_value ?>%)</p>
                                                <?php endif ?>

                                                <div class="mt-4">
                                                    <script type="text/javascript" src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>

                                                    <button type="button" id="flutterwave_payment" class="btn btn-primary btn-md btn-block"> <?php echo trans('pay-now') ?> </button>

                                                    <?php $flutterwave_type = 'admin'; ?>
                                                    <?php include APPPATH.'views/admin/include/flutterwave-js.php'; ?>
                                                </div>
                                            </div>
                                       </div>
                                   </div>
                                </div>







                                
                                <div class="tab-pane fade" id="offline" role="tabpanel" aria-labelledby="offline-tab">
                                   
                                        <div class="box-body p-2">

                                            <div class="row">
                                                <div class="col-md-12 mb-4">
                                                    <p class="text-center"><?php echo trans('offline-payment-instructions') ?></p>
                                                    <div class="bg-light p-4"><p><?php echo $settings->offline_details ?></p></div>
                                                </div>

                                                <div class="col-md-12">
                                                    <p class="mb-0 text-center"><?php echo trans('plan') ?>: <?php echo html_escape($package->name);?> </p>
                                                    <p class="mb-0"><strong><?php if(settings()->curr_locate == 0){echo settings()->currency_symbol;} ?><?php echo html_escape($price) ?> <?php if(settings()->curr_locate == 1){echo settings()->currency_symbol;} ?></strong> <small><?php echo html_escape($frequency) ?></small></p>

                                                    <?php if (isset($coupon)): ?>
                                                        <p class="small mb-0"><?php echo trans('discount') ?>: (<?php echo $coupon->discount ?>%)</p>
                                                    <?php endif ?>

                                                    <?php if (settings()->tax_value != '' && settings()->tax_value != 0): ?>
                                                        <p class="small"><?php echo settings()->tax_name ?> (<?php echo settings()->tax_value ?>%)</p>
                                                    <?php endif ?>
                                                    
                                                    <div class="text-center text-success">
                                                        <div class="payment_loader hide"><i class="fa fa-spinner fa-spin"></i> <?php echo trans('loading') ?>....</div><br>
                                                    </div>
                                                </div>
                                            </div>
                            
                                            <form enctype="multipart/form-data" action="<?php echo base_url('admin/subscription/offline_payment') ?>" method="post" class="form-horizontal">
                                                
                                                <div class="form-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="file" aria-invalid="false" required>
                                                        <label class="custom-file-label" for="customFile"><?php echo trans('upload-payment-proof') ?></label>
                                                    </div>
                                                </div>
                                    
                                                <!-- csrf token -->
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

                                                <input type="hidden" name="billing_type" value="<?php echo html_escape($billing_type); ?>" readonly>
                                                <input type="hidden" name="package_id" value="<?php echo html_escape($package->id); ?>" readonly>
                                                <input type="hidden" name="payment_id" value="<?php echo html_escape($payment_id); ?>" readonly>
                                                
                                                <button class="btn btn-primary btn-block" type="submit"><?php echo trans('submit') ?></button>
                                            </form>
                                        </div>
                               
                                </div>

                            </div>
                        </div>
                    </div>
               
                </div>
            </div>
        </div>
    </div>
</div>