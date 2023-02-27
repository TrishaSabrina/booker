
<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <?php $this->load->view('admin/include/breadcrumb'); ?>

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          
          <?php $this->load->view('admin/user/include/settings_menu.php'); ?>
          
          <div class="col-lg-9 pl-3">

              <?php if (settings()->type == 'demo'): ?>
                  <div class="card p-2 mr-1 bg-danger-soft">
                    <span><i class="fas fa-info-circle"></i> Payment gateways are only available with extended License</span>
                  </div>
              <?php endif ?>


              <form method="post" action="<?php echo base_url('admin/payment/user_update') ?>" role="form" class="form-horizontal pr-20">
              
                <div class="card">
                  <div class="card-body">
                      <div class="d-flex justify-content-between mb-2">
                        <div>
                          <img width="100px" src="<?php echo base_url() ?>assets/images/payments/paypal.svg">
                        </div>

                        <div>
                          <div class="form-group">
                              <div class="custom-control custom-switch">
                                  <input type="checkbox" value="1" name="paypal_payment" class="custom-control-input" id="switch-1" <?php if(user()->paypal_payment == 1){echo "checked";} ?>>
                                  <label class="custom-control-label font-weight-bold" for="switch-1">  </label>
                              </div>
                          </div>
                        </div>
                      </div>
                      
                      <div class="form-group">
                          <label><?php echo trans('paypal-mode') ?> </label>
                          <select class="form-control" name="paypal_mode">
                                <option value=""><?php echo trans('select') ?></option>
                                <option value="sandbox" <?php echo (user()->paypal_mode == 'sandbox') ? 'selected' : ''; ?>><?php echo trans('sandbox') ?></option>
                                <option value="live" <?php echo (user()->paypal_mode == 'live') ? 'selected' : ''; ?>><?php echo trans('live') ?></option>
                          </select>
                      </div>

                      <div class="form-group">
                          <label><?php echo trans('paypal-account') ?></label>
                          <input type="text" name="paypal_email" value="<?php echo html_escape(user()->paypal_email); ?>" class="form-control" >
                      </div>
                  </div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                          <div>
                            <img width="70px" src="<?php echo base_url() ?>assets/images/payments/stripe.svg">
                          </div>

                          <div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" value="1" name="stripe_payment" class="custom-control-input" id="switch-2" <?php if(user()->stripe_payment == 1){echo "checked";} ?>>
                                    <label class="custom-control-label font-weight-bold" for="switch-2"> </label>
                                </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                            <label><?php echo trans('publish-key') ?></label>
                            <input type="text" name="publish_key" value="<?php echo html_escape(user()->publish_key); ?>" class="form-control">
                        </div>

                        <div class="form-group">
                          <label><?php echo trans('secret-key') ?> </label>
                          <input type="text" name="secret_key" value="<?php echo html_escape(user()->secret_key); ?>" class="form-control">
                      </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">

                          <div class="d-flex justify-content-between mb-2">
                            <div>
                              <img width="120px" src="<?php echo base_url() ?>assets/images/payments/razorpay.svg">
                            </div>

                            <div>
                              <div class="form-group">
                                  <div class="custom-control custom-switch">
                                      <input type="checkbox" value="1" name="razorpay_payment" class="custom-control-input" id="switch-3" <?php if(user()->razorpay_payment == 1){echo "checked";} ?>>
                                      <label class="custom-control-label font-weight-bold" for="switch-3"> </label>
                                  </div>
                              </div>
                            </div>
                          </div>

                          

                          <div class="form-group">
                              <label><?php echo trans('kay-id') ?></label>
                              <input type="text" name="razorpay_key_id" value="<?php echo html_escape(user()->razorpay_key_id); ?>" class="form-control">
                          </div>

                          <div class="form-group">
                            <label><?php echo trans('key-secret') ?> </label>
                            <input type="text" name="razorpay_key_secret" value="<?php echo html_escape(user()->razorpay_key_secret); ?>" class="form-control">
                        </div>
                    </div>
                </div>


                 <div class="card">
                    <div class="card-body">
                       
                        <div class="d-flex justify-content-between mb-2">
                          <div>
                            <img width="120px" src="<?php echo base_url() ?>assets/images/payments/paystack.svg">
                          </div>

                          <div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" value="1" name="paystack_payment" class="custom-control-input" id="switch-4" <?php if(user()->paystack_payment == 1){echo "checked";} ?>>
                                    <label class="custom-control-label font-weight-bold" for="switch-4"> </label>
                                </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                            <label><?php echo trans('publish-key') ?></label>
                            <input type="text" name="paystack_public_key" value="<?php echo html_escape(user()->paystack_public_key); ?>" class="form-control">
                        </div>

                        <div class="form-group">
                          <label><?php echo trans('secret-key') ?> </label>
                          <input type="text" name="paystack_secret_key" value="<?php echo html_escape(user()->paystack_secret_key); ?>" class="form-control">
                      </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                          <div>
                            <img width="140px" src="<?php echo base_url() ?>assets/images/payments/flutterwave.svg">
                          </div>

                          <div>
                            <div class="form-group">
                              <div class="custom-control custom-switch">
                                  <input type="checkbox" value="1" name="flutterwave_payment" class="custom-control-input" id="switch-fw" <?php if(user()->flutterwave_payment == 1){echo "checked";} ?>>
                                  <label class="custom-control-label font-weight-bold" for="switch-fw"> </label>
                              </div>
                            </div>
                          </div>
                        </div>


                        <div class="form-group">
                            <label><?php echo trans('publish-key') ?></label>
                            <input type="text" name="flutterwave_public_key" value="<?php echo html_escape(user()->flutterwave_public_key); ?>" class="form-control">
                        </div>

                        <div class="form-group">
                          <label><?php echo trans('secret-key') ?> </label>
                          <input type="text" name="flutterwave_secret_key" value="<?php echo html_escape(user()->flutterwave_secret_key); ?>" class="form-control">
                      </div>
                    </div>
                </div>



                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                          <div>
                            <img width="140px" src="<?php echo base_url() ?>assets/images/payments/mercado_pago.svg">
                          </div>

                          <div>
                            <div class="form-group">
                              <div class="custom-control custom-switch">
                                  <input type="checkbox" value="1" name="mercado_payment" class="custom-control-input" id="switch-mp" <?php if(user()->mercado_payment == 1){echo "checked";} ?>>
                                  <label class="custom-control-label font-weight-bold" for="switch-mp"> </label>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="example-input-normal"><?php echo trans('publish-key') ?></label>
                            <div class="">
                              <input type="text" name="mercado_api_key" value="<?php echo html_escape(user()->mercado_api_key); ?>" class="form-control" >
                            </div>
                        </div>
                      
                          <div class="form-group">
                            <label class="control-label" for="example-input-normal"><?php echo trans('access-token') ?> </label>
                            <div class="">
                              <input type="text" name="mercado_token" value="<?php echo html_escape(user()->mercado_token); ?>" class="form-control" >
                            </div>
                        </div>
                      
                        <div class="form-group">
                            <label class="control-label">Default Currency</label>
                            <select name="mercado_currency" class="form-control">
                                <option <?php if(user()->mercado_currency == 'ARS'){echo "selected";} ?> value="ARS">ARS&nbsp;(Argentina Peso)</option>
                                <option <?php if(user()->mercado_currency == 'BRL'){echo "selected";} ?> value="BRL">BRL&nbsp;(Brazil Real)</option>
                                <option <?php if(user()->mercado_currency == 'CLP'){echo "selected";} ?> value="CLP">CLP&nbsp;(Chile Peso)</option>
                                <option <?php if(user()->mercado_currency == 'COP'){echo "selected";} ?> value="COP">COP&nbsp;(Colombia Peso)</option>
                                <option <?php if(user()->mercado_currency == 'MXN'){echo "selected";} ?> value="MXN">MXN&nbsp;(Mexico Peso)</option>
                                <option <?php if(user()->mercado_currency == 'PEN'){echo "selected";} ?> value="PEN">PEN&nbsp;(Peru Nuevo Sol)</option>
                                <option <?php if(user()->mercado_currency == 'UYU'){echo "selected";} ?> value="UYU">UYU&nbsp;(Uruguayan Peso)</option>
                            </select>
                        </div>

                    </div>
                </div>


                <div class="card-footers mb-4">
                  <!-- csrf token -->
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                  <button type="submit" class="btn btn-primary btn-lgs"> <?php echo trans('save-changes') ?></button>
                </div>
                
       
              </form>
          </div>
          

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
