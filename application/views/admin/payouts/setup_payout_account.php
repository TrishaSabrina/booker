<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <?php $this->load->view('admin/include/breadcrumb'); ?>

  <!-- Main content -->
  <div class="content">
    <div class="container">
        <div class="row">
          <div class="col-lg-8">

            <div class="card">
              <div class="card-header with-border mb-3">
                <h3 class="card-title"><?php echo trans('setup-payout-accounts') ?></h3>
              </div>

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                  <?php if(settings()->paypal_payout == 1): ?>
                    <li class="nav-item mr-2">
                      <a class="linkd nav-link pr-4 pl-4" id="pills-paypal-tab" data-toggle="pill" href="#pills-paypal" role="tab" aria-controls="pills-paypal" aria-selected="true"><?php echo trans('paypal') ?></a>
                    </li>
                  <?php endif; ?>

                  <?php if(settings()->iban_payout == 1): ?>
                  <li class="nav-item mr-2">
                    <a class="linkd nav-link pr-4 pl-4" id="pills-iban-tab" data-toggle="pill" href="#pills-iban" role="tab" aria-controls="pills-iban" aria-selected="false"><?php echo trans('iban') ?></a>
                  </li>
                  <?php endif; ?>

                  <?php if(settings()->swift_payout == 1): ?>
                  <li class="nav-item mr-2">
                    <a class="linkd nav-link pr-4 pl-4" id="pills-swift-tab" data-toggle="pill" href="#pills-swift" role="tab" aria-controls="pills-swift" aria-selected="false"><?php echo strtoupper(trans('swift')) ?></a>
                  </li>
                  <?php endif; ?>
                </ul>

                <!-- paypal -->
                <div class="tab-content" id="pills-tabContent">

                  <div class="card-body linkd_hide">
                    <span class=""><?php echo trans('select').' '.trans('payout-method') ?></span>
                  </div>

                  <div class="tab-pane fade show" id="pills-paypal" role="tabpanel" aria-labelledby="pills-paypal-tab">
                    <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/payouts/update_account/1')?>" role="form" novalidate>
                      <div class="card-body">
                          <div class="form-group">
                            <label><?php echo trans('paypal') ?> <?php echo trans('email') ?> <span class="text-danger">*</span></label>
                            <input type="text" required class="form-control" name="payout_paypal_email" value="<?php if(isset($user)){echo html_escape($user->payout_paypal_email);} ?>">
                          </div>
                      </div>
                      <input type="hidden" name="id" value="<?php if(isset($user)){echo html_escape($user->id);}else{echo 0;} ?>">
                      <!-- csrf token -->
                      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                      <button type="submit" class="btn btn-primary pull-left mt-3"><?php echo trans('save-changes') ?></button>
                    </form>
                  </div>

                      

                  <!-- IBAN -->
                  <div class="tab-pane fade" id="pills-iban" role="tabpanel" aria-labelledby="pills-iban-tab">
                    <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/payouts/update_account/2')?>" role="form" novalidate>
                      <div class="card-body">
                          <div class="form-group">
                            <label> <?php echo trans('full-name') ?> <span class="text-danger">*</span></label>
                            <input type="text" required class="form-control" name="iban_full_name" value="<?php if(isset($user)){echo html_escape($user->iban_full_name);} ?>">
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group">
                                <label> <?php echo trans('country') ?> <span class="text-danger">*</span></label>
                                <select class="form-control" required name="iban_country_id">
                                    <option value=""><?php echo trans('select') ?></option>
                                    <?php foreach ($countries as $country): ?>
                                        <?php if (!empty($country->name)): ?>
                                          <option value="<?php echo html_escape($country->id); ?>" 
                                            <?php echo (isset($user) && $user->iban_country_id == $country->id) ? 'selected' : ''; ?>>
                                            <?php echo html_escape($country->name); ?>
                                          </option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group">
                                <label> <?php echo trans('bank-name') ?> <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" name="iban_bank_name" value="<?php if(isset($user)){echo html_escape($user->iban_bank_name);} ?>">
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label> <?php echo trans('iban-number') ?> <span class="text-danger">*</span></label>
                            <input type="text" required class="form-control" name="iban_number" value="<?php if(isset($user)){echo html_escape($user->iban_number);} ?>">
                          </div>

                      </div>

                      <input type="hidden" name="id" value="<?php if(isset($user)){echo html_escape($user->id);}else{echo 0;} ?>">
                      <!-- csrf token -->
                      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                      <button type="submit" class="btn btn-primary pull-left mt-3"><?php echo trans('save-changes') ?></button>
                    </form>
                  </div>

                  <!-- swift -->
                  <div class="tab-pane fade" id="pills-swift" role="tabpanel" aria-labelledby="pills-swift-tab">
                    <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/payouts/update_account/3')?>" role="form" novalidate>
                      <div class="card-body">
                          <div class="form-group">
                            <label> <?php echo trans('full-name') ?> <span class="text-danger">*</span></label>
                            <input type="text" required class="form-control" name="swift_full_name" value="<?php if(isset($user)){echo html_escape($user->swift_full_name);} ?>">
                          </div>

                          <div class="row">
                            <div class="col-4">
                              <div class="form-group">
                                <label> <?php echo trans('state') ?> <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" name="swift_state" value="<?php if(isset($user)){echo html_escape($user->swift_state);} ?>">
                              </div>
                            </div>

                            <div class="col-4">
                              <div class="form-group">
                                <label> <?php echo trans('city') ?> <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" name="swift_city" value="<?php if(isset($user)){echo html_escape($user->swift_city);} ?>">
                              </div>
                            </div>

                            <div class="col-4">
                              <div class="form-group">
                                <label> <?php echo trans('post-code') ?> <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" name="swift_postcode" value="<?php if(isset($user)){echo html_escape($user->swift_postcode);} ?>">
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label> <?php echo trans('address') ?> <span class="text-danger">*</span></label>
                            <input type="text" required class="form-control" name="swift_address" value="<?php if(isset($user)){echo html_escape($user->swift_address);} ?>">
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group">
                                <label> <?php echo trans('bank-account-holders-name') ?> <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" name="swift_bank_account_holder_name" value="<?php if(isset($user)){echo html_escape($user->swift_bank_account_holder_name);} ?>">
                              </div>
                            </div>

                            <div class="col-6">
                              <div class="form-group">
                                <label> <?php echo trans('bank-name') ?> <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" name="swift_bank_name" value="<?php if(isset($user)){echo html_escape($user->swift_bank_name);} ?>">
                              </div>
                            </div>

                            <div class="col-6">
                              <div class="form-group">
                                <label> <?php echo trans('bank-branch-country') ?><span class="text-danger">*</span></label>
                                <select class="form-control" required name="swift_bank_branch_country_id">
                                    <option value=""><?php echo trans('select') ?></option>
                                    <?php foreach ($countries as $country): ?>
                                        <?php if (!empty($country->name)): ?>
                                          <option value="<?php echo html_escape($country->id); ?>" 
                                            <?php echo (isset($user) && $user->swift_bank_branch_country_id == $country->id) ? 'selected' : ''; ?>>
                                            <?php echo html_escape($country->name); ?>
                                          </option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </select>
                              </div>
                            </div>

                            <div class="col-6">
                              <div class="form-group">
                                <label> <?php echo trans('bank-branch-city') ?> <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" name="swift_bank_branch_city" value="<?php if(isset($user)){echo html_escape($user->swift_bank_branch_city);} ?>">
                              </div>
                            </div>

                            <div class="col-6">
                              <div class="form-group">
                                <label> <?php echo trans('bank-account-number') ?> <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" name="swift_iban" value="<?php if(isset($user)){echo html_escape($user->swift_iban);} ?>">
                              </div>
                            </div>

                            <div class="col-6">
                              <div class="form-group">
                                <label> <?php echo trans('swift-code') ?> <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" name="swift_code" value="<?php if(isset($user)){echo html_escape($user->swift_code);} ?>">
                              </div>
                            </div>

                          </div>

                      </div>

                      <input type="hidden" name="id" value="<?php if(isset($user)){echo html_escape($user->id);}else{echo 0;} ?>">
                      <!-- csrf token -->
                      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                      <button type="submit" class="btn btn-primary pull-left mt-3"><?php echo trans('save-changes') ?></button>
                    </form>
                  </div>


                </div>

              

            </div>

          </div>
      </div>
    </div>
  </div>
</div>
