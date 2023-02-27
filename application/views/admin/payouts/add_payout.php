<div class="content-wrapper">


  <!-- Main content -->
  <div class="content pt-4 mb-4">
      <div class="container">
        
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header with-border">
                <h3 class="card-title"><?php echo trans('add-payout') ?></h3>

                <div class="card-tools pull-right">
                    <a href="<?php echo base_url('admin/payouts/requests') ?>" class="pull-right btn btn-sm btn-secondary"> <?php echo trans('payouts') ?></a>
                  </div>
              </div>


              <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/payouts/add')?>" role="form" novalidate>
                <div class="card-body">

                    <div class="form-group mt-4">
                      <label> <?php echo trans('users') ?> <span class="text-danger">*</span></label>
                      <select class="form-control select2" required name="user_id">
                          <option value=""><?php echo trans('select') ?></option>
                          <?php foreach ($users as $user): ?>
                            <option value="<?php echo html_escape($user->user_id) ?>"><?php echo html_escape($user->user_name.' ('.settings()->currency_symbol.''.(number_format($user->balance/100, 2)).')') ?></option>
                          <?php endforeach ?>
                      </select>
                    </div>

                   
                    <div class="form-group">
                      <label><?php echo trans('amount') ?> (<?php echo settings()->currency_code?>) <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <div class="input-group-append">
                          <span class="input-group-text"><?php echo settings()->currency_symbol ?></span>
                        </div>
                        <input type="number" class="form-control" name="amount" value="" required aria-invalid="false">
                      </div>
                    </div>


                    <div class="form-group mt-4">
                      <label> <?php echo trans('withdrawal-method') ?> <span class="text-danger">*</span></label>
                      <select class="form-control" required name="payout_method">
                          <?php if(settings()->paypal_payout == 1): ?>
                            <option value="paypal"><?php echo trans('paypal') ?></option>
                          <?php endif; ?>
                          <?php if(settings()->iban_payout == 1): ?>
                            <option value="iban"><?php echo trans('iban') ?></option>
                          <?php endif; ?>
                          <?php if(settings()->swift_payout == 1): ?>
                            <option value="swift"><?php echo trans('swift') ?></option>
                          <?php endif; ?>
                      </select>
                    </div>
                </div>

                <div class="card-footer">
                    <!-- csrf token -->
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                    <button type="submit" class="btn btn-primary pull-left"> <?php echo trans('submit') ?></button>
                </div>

              </form>

            </div>
          </div>
        </div>

      </div>
    </div>



</div>
