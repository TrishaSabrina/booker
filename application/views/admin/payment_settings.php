
<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <?php include"include/breadcrumb.php"; ?>

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">


          <?php if (settings()->type == 'demo'): ?>
            <div class="col-lg-4">
            </div>
            <div class="col-lg-8">
              <div class="card p-2 mr-2 bg-danger-soft">
                <span><i class="fas fa-info-circle"></i> Payment gateways are only available with Extended License</span>
              </div>
            </div>
          <?php endif ?>
          
          <!-- .col-md-12 -->
          <div class="col-lg-12">
            <div class="card p-2">

              <form method="post" action="<?php echo base_url('admin/payment/update') ?>" role="form" class="form-horizontal pr-20">
                <div class="row mb-4">
                  <div class="col-md-6">
                      <div class="card-body">
                        <h6 class="mb-2"><?php echo trans('currency') ?></h6>
                        <select class="form-control single_select" id="country" name="country">
                            <option value=""><?php echo trans('select') ?></option>
                            <?php foreach ($currencies as $currency): ?>
                                <?php if (!empty($currency->currency_name)): ?>
                                  <option value="<?php echo html_escape($currency->id); ?>" 
                                    <?php echo (settings()->country == $currency->id) ? 'selected' : ''; ?>>
                                    <?php echo html_escape($currency->name.'  -  '.$currency->currency_code.' ('.$currency->currency_symbol.')'); ?>
                                  </option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>
                      </div>
                  </div>

                  <div class="col-md-6">
                    <?php if (get_user_info() == TRUE): ?>
                      <div class="card-body">
                          <div class="d-flex justify-content-between mb-2">
                            <div>
                              <h6 class="mb-0 pt-2"><?php echo trans('payment') ?></h6>
                              <p class="text-muted mb-2"><small><?php echo trans('payment-title') ?>.</small></p>
                            </div>
                            <div class="custom-control custom-switch pt-2">
                                <input type="checkbox" name="enable_payment" class="custom-control-input" value="1" id="switch-ep" <?php if(settings()->enable_payment == 1){echo "checked";} ?>>
                                <label class="custom-control-label fs-22" for="switch-ep"></label>
                            </div>
                          </div>
                      </div>
                    <?php else: ?>
                        <input type="hidden" name="enable_payment" value="0">
                    <?php endif ?>
                  </div>
                </div>


                <div class="row mb-4">
                  <div class="col-md-6 mb-4">
                      <div class="card-body">
                          
                          <div class="d-flex justify-content-between mb-2">
                            <div>
                              <img width="100px" src="<?php echo base_url() ?>assets/images/payments/paypal.svg">
                            </div>

                            <div>
                              <div class="form-group">
                                  <div class="custom-control custom-switch">
                                      <input type="checkbox" value="1" name="paypal_payment" class="custom-control-input" id="switch-1" <?php if(settings()->paypal_payment == 1){echo "checked";} ?>>
                                      <label class="custom-control-label font-weight-bold" for="switch-1"> </label>
                                  </div>
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                              <label><?php echo trans('paypal-mode') ?> </label>
                              <select class="form-control" name="paypal_mode">
                                  <option value=""><?php echo trans('select') ?></option>
                                  <option value="sandbox" <?php echo (settings()->paypal_mode == 'sandbox') ? 'selected' : ''; ?>>Sandbox</option>
                                  <option value="live" <?php echo (settings()->paypal_mode == 'live') ? 'selected' : ''; ?>>Live</option>
                              </select>
                          </div>

                          <div class="form-group">
                              <label> <?php echo trans('paypal-account') ?></label>
                              <input type="text" name="paypal_email" value="<?php echo html_escape(settings()->paypal_email); ?>" class="form-control" >
                          </div>
                      </div>
                  </div>

                  <div class="col-md-6 mb-4">
                      <div class="card-body">

                          <div class="d-flex justify-content-between mb-2">
                            <div>
                              <img width="80px" src="<?php echo base_url() ?>assets/images/payments/stripe.svg">
                            </div>

                            <div>
                              <div class="form-group">
                                  <div class="custom-control custom-switch">
                                      <input type="checkbox" value="1" name="stripe_payment" class="custom-control-input" id="switch-2" <?php if(settings()->stripe_payment == 1){echo "checked";} ?>>
                                      <label class="custom-control-label font-weight-bold" for="switch-2"> </label>
                                  </div>
                              </div>
                            </div>
                          </div>


                          <div class="form-group">
                              <label><?php echo trans('publish-key') ?></label>
                              <input type="text" name="publish_key" value="<?php echo html_escape(settings()->publish_key); ?>" class="form-control">
                          </div>

                          <div class="form-group">
                            <label><?php echo trans('secret-key') ?> </label>
                            <input type="text" name="secret_key" value="<?php echo html_escape(settings()->secret_key); ?>" class="form-control">
                        </div>
                      </div>
                  </div>
                
                  <div class="col-md-6 mb-4">
                      <div class="card-body">
                          <div class="d-flex justify-content-between mb-2">
                            <div>
                              <img width="100px" src="<?php echo base_url() ?>assets/images/payments/paystack.svg">
                            </div>

                            <div>
                              <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" value="1" name="paystack_payment" class="custom-control-input" id="switch-5" <?php if(settings()->paystack_payment == 1){echo "checked";} ?>>
                                    <label class="custom-control-label font-weight-bold" for="switch-5"> </label>
                                </div>
                              </div>
                            </div>
                          </div>


                          <div class="form-group">
                              <label><?php echo trans('publish-key') ?></label>
                              <input type="text" name="paystack_public_key" value="<?php echo html_escape(settings()->paystack_public_key); ?>" class="form-control">
                          </div>

                          <div class="form-group">
                            <label><?php echo trans('secret-key') ?> </label>
                            <input type="text" name="paystack_secret_key" value="<?php echo html_escape(settings()->paystack_secret_key); ?>" class="form-control">
                        </div>
                      </div>
                  </div>
                
                  <div class="col-md-6 mb-4">
                      <div class="card-body">
                          <div class="d-flex justify-content-between mb-2">
                            <div>
                              <img width="100px" src="<?php echo base_url() ?>assets/images/payments/razorpay.svg">
                            </div>

                            <div>
                              <div class="form-group">
                                  <div class="custom-control custom-switch">
                                      <input type="checkbox" value="1" name="razorpay_payment" class="custom-control-input" id="switch-3" <?php if(settings()->razorpay_payment == 1){echo "checked";} ?>>
                                      <label class="custom-control-label font-weight-bold" for="switch-3"> </label>
                                  </div>
                              </div>
                            </div>
                          </div>


                          <div class="form-group">
                              <label><?php echo trans('kay-id') ?></label>
                              <input type="text" name="razorpay_key_id" value="<?php echo html_escape(settings()->razorpay_key_id); ?>" class="form-control">
                          </div>

                          <div class="form-group">
                            <label><?php echo trans('key-secret') ?> </label>
                            <input type="text" name="razorpay_key_secret" value="<?php echo html_escape(settings()->razorpay_key_secret); ?>" class="form-control">
                        </div>
                      </div>
                  </div>

                  <div class="col-md-6 mb-4">
                      <div class="card-body">
                          <div class="d-flex justify-content-between mb-2">
                            <div>
                              <img width="120px" src="<?php echo base_url() ?>assets/images/payments/flutterwave.svg">
                            </div>

                            <div>
                              <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" value="1" name="flutterwave_payment" class="custom-control-input" id="switch-fw" <?php if(settings()->flutterwave_payment == 1){echo "checked";} ?>>
                                    <label class="custom-control-label font-weight-bold" for="switch-fw"> </label>
                                </div>
                              </div>
                            </div>
                          </div>


                          <div class="form-group">
                              <label><?php echo trans('publish-key') ?></label>
                              <input type="text" name="flutterwave_public_key" value="<?php echo html_escape(settings()->flutterwave_public_key); ?>" class="form-control">
                          </div>

                          <div class="form-group">
                            <label><?php echo trans('secret-key') ?> </label>
                            <input type="text" name="flutterwave_secret_key" value="<?php echo html_escape(settings()->flutterwave_secret_key); ?>" class="form-control">
                        </div>
                      </div>
                  </div>



                  <div class="col-md-6 mb-4">
                      <div class="card-body">
                          <div class="d-flex justify-content-between mb-2">
                            <div>
                              <img width="120px" src="<?php echo base_url() ?>assets/images/payments/mercado_pago.svg">
                            </div>

                            <div>
                              <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" value="1" name="mercado_payment" class="custom-control-input" id="switch-mp" <?php if(settings()->mercado_payment == 1){echo "checked";} ?>>
                                    <label class="custom-control-label font-weight-bold" for="switch-mp"> </label>
                                </div>
                              </div>
                            </div>
                          </div>


                          <div class="d-flex justify-content-between">
                            <div class="form-group w-100 mr-2">
                                <label class="control-label" for="example-input-normal"><?php echo trans('publish-key') ?></label>
                                <div class="">
                                  <input type="text" name="mercado_api_key" value="<?php echo html_escape(settings()->mercado_api_key); ?>" class="form-control" >
                                </div>
                            </div>
                        
                            <div class="form-group w-100">
                              <label class="control-label" for="example-input-normal"><?php echo trans('access-token') ?> </label>
                              <div class="">
                                <input type="text" name="mercado_token" value="<?php echo html_escape(settings()->mercado_token); ?>" class="form-control" >
                              </div>
                            </div>
                          </div>
                      
                        <div class="form-group">
                            <label class="control-label"> <?php echo trans('currency') ?></label>
                            <select name="mercado_currency" class="form-control">
                                <option <?php if(settings()->mercado_currency == 'ARS'){echo "selected";} ?> value="ARS">ARS&nbsp;(Argentina Peso)</option>
                                <option <?php if(settings()->mercado_currency == 'BRL'){echo "selected";} ?> value="BRL">BRL&nbsp;(Brazil Real)</option>
                                <option <?php if(settings()->mercado_currency == 'CLP'){echo "selected";} ?> value="CLP">CLP&nbsp;(Chile Peso)</option>
                                <option <?php if(settings()->mercado_currency == 'COP'){echo "selected";} ?> value="COP">COP&nbsp;(Colombia Peso)</option>
                                <option <?php if(settings()->mercado_currency == 'MXN'){echo "selected";} ?> value="MXN">MXN&nbsp;(Mexico Peso)</option>
                                <option <?php if(settings()->mercado_currency == 'PEN'){echo "selected";} ?> value="PEN">PEN&nbsp;(Peru Nuevo Sol)</option>
                                <option <?php if(settings()->mercado_currency == 'UYU'){echo "selected";} ?> value="UYU">UYU&nbsp;(Uruguayan Peso)</option>
                            </select>
                        </div>
                 

                      </div>
                  </div>

                
                  <div class="col-md-12 mb-4">
                      <div class="card-body">
                          <div class="form-group">
                              <div class="custom-control custom-switch">
                                  <input type="checkbox" value="1" name="enable_offline_payment" class="custom-control-input" id="switch-4" <?php if(settings()->enable_offline_payment == 1){echo "checked";} ?>>
                                  <label class="custom-control-label font-weight-bold" for="switch-4">  <?php echo trans('offline-payment') ?></label>
                              </div>
                          </div>

                          <div class="form-group">
                              <label><?php echo trans('offline-payment-instructions') ?></label>
                              <p class="small"><?php echo trans('offline-payment-suggestions') ?>.</p>
                              <textarea id="summernote" name="offline_details" placeholder="Provide your offline payment instructions here"><?php echo settings()->offline_details; ?></textarea>
                              
                          </div>
                      </div>
                  </div>


                  <div class="col-md-6">
                    <div class="card-footers mt-4">
                        <!-- csrf token -->
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                        <button type="submit" class="btn btn-primary btn-lgs"> <?php echo trans('save-changes') ?></button>
                      </div>
                  </div>
                </div>


              </form>
        
            </div>
          </div>
          <!-- /.col-md-6 -->

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
