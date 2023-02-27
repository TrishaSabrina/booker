<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <?php $this->load->view('admin/include/breadcrumb'); ?>

  <!-- Main content -->
  <div class="content pt-4">
      <div class="container">
      
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header with-border">
                <h3 class="card-title"><?php echo trans('payout-settings') ?></h3>
              </div>


              <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/payouts/update_settings')?>" role="form" novalidate>
                <div class="card-body">
                   
                    <div class="form-group">
                      <div class="custom-control custom-switch prefrence-item ml-10 mt-25">
                          <input type="checkbox" name="enable_wallet" class="custom-control-input" value="1" id="switch-wa" <?php if($settings->enable_wallet == 1){echo "checked";} ?>>
                          <label class="custom-control-label" for="switch-wa"><?php echo trans('enable-payouts') ?></label>
                          <p class="text-muted mb-2"><small><?php echo trans('enable-payout-title') ?></small></p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label><?php echo trans('minimum-payout-amount') ?></label>
                      <div class="input-group">
                        <div class="input-group-append">
                          <span class="input-group-text"><?php echo settings()->currency_symbol ?></span>
                        </div>
                        <input type="number" class="form-control" name="min_payout_amount" value="<?php echo html_escape($settings->min_payout_amount); ?>">
                      </div>
                    </div>
                  
                    <div class="form-group mb-3">
                      <label><?php echo trans('commission-rate') ?></label>
                      <div class="input-group">
                        <input type="number" class="form-control" name="commission_rate" value="<?php echo html_escape($settings->commission_rate); ?>">
                        <div class="input-group-append">
                          <span class="input-group-text">%</span>
                        </div>
                      </div>
                      <p class="small mt-1"><?php echo ucfirst(trans('must-be-between-1-99')) ?></p>
                    </div>

                    <p class="mb-0 pt-4 mt-3"><?php echo trans('enabledisable-payout-methods') ?></p class="mb-0 mt-3">

                    <div class="row mt-0">
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="custom-control custom-switch prefrence-item ml-10 mt-25">
                              <input type="checkbox" name="paypal_payout" class="custom-control-input" value="1" id="switch-pp" <?php if($settings->paypal_payout == 1){echo "checked";} ?>>
                              <label class="custom-control-label" for="switch-pp"><?php echo trans('enable') ?> <?php echo trans('paypal') ?></label>
                              <p class="text-muted mb-2"></p>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="custom-control custom-switch prefrence-item ml-10 mt-25">
                              <input type="checkbox" name="iban_payout" class="custom-control-input" value="1" id="switch-iban" <?php if($settings->iban_payout == 1){echo "checked";} ?>>
                              <label class="custom-control-label" for="switch-iban"><?php echo trans('enable') ?> <?php echo trans('iban') ?></label>
                              <p class="text-muted mb-2"></p>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="custom-control custom-switch prefrence-item ml-10 mt-25">
                              <input type="checkbox" name="swift_payout" class="custom-control-input" value="1" id="switch-swift" <?php if($settings->swift_payout == 1){echo "checked";} ?>>
                              <label class="custom-control-label" for="switch-swift"><?php echo trans('enable') ?> <?php echo trans('swift') ?></label>
                              <p class="text-muted mb-2"></p>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="card-footer">
                    <!-- csrf token -->
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                    <button type="submit" class="btn btn-primary pull-left"> <?php echo trans('save-changes') ?></button>
                </div>

              </form>

            </div>
          </div>
        </div>

      </div>
    </div>



</div>
