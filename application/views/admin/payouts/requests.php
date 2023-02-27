<div class="content-wrapper">


  <!-- Main content -->
  <div class="content pt-4 mb-4">
      <div class="container">
        
        <div class="row mt-5">
          <div class="col-md-12">

            <div class="card add_area <?php if(isset($_GET['error']) && $_GET['error'] == "Invalid"){echo "d-block";}else{echo "hide";} ?>">
              <div class="card-header with-border">
                <h3 class="card-title"><?php echo trans('send-payout-request') ?></h3>

                <div class="card-tools pull-right">
                    <a href="#" class="text-right btn btn-secondary cancel_btn btn-sm"><?php echo trans('payouts') ?></a>
                </div>
              </div>


              <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/payouts/send_request')?>" role="form" novalidate>
                <div class="card-body">
                   
                    <div class="form-group">
                      <label><?php echo trans('amount') ?> </label>
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

            <div class="card list_area">
              <div class="card-header with-border">
                  <h3 class="card-title pt-2"><?php echo trans(str_slug($page_title)) ?> </h3>

                  <div class="card-tools">
                      <div class="filter-bars pull-right">
                        <a class="filter-action btn btn-outline-primary text-primary"> <i class="fas fa-filter"></i></a>
                      </div>
                    </div>
              </div>

              <div class="filter_popup showFilter">
                    <p class="leads mb-3"><?php echo trans('filters') ?></p>
                    <?php if($status == 1){$stat_url = 'completed';}else{$stat_url = 'requests';} ?>
                    <form action="<?php echo base_url('admin/payouts/'.$stat_url) ?>" class="sort_form" method="get">
                      <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?php echo trans('transaction-id') ?></label>
                                <input type="text" name="transaction_id" class="form-control form-control-sm">
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                          <button type="submit" class="btn btn-primary btn-sm btn-block"><?php echo trans('submit') ?></button>
                        </div>

                      </div>
                    </form>
                </div>

              <div class="card-body table-responsive p-0">
                  <?php if (!empty($payouts)): ?>
                  <table class="table table-hover text-nowrap">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th><?php echo trans('user') ?></th>
                              <th><?php echo trans('withdrawal-method') ?></th>
                              <th><?php echo trans('amount') ?> </th>
                              <th><?php echo trans('transaction-id') ?></th>
                              <th><?php echo trans('status') ?></th>
                              <th><?php echo trans('request-sent') ?></th>
                              <th><?php echo trans('action') ?></th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $i=1; foreach ($payouts as $row): ?>
                          <tr id="row_<?php echo html_escape($row->id); ?>">
                              <td><?= $i; ?></td>
                              
                              <td class="pl-2">
                                <div class="d-flex align-items-center">
                                  <div>
                                    <?php if ($row->thumb == ''): ?>
                                        <?php $avatar = 'assets/images/no-photo-sm.png'; ?> 
                                    <?php else: ?>
                                        <?php $avatar = $row->thumb; ?>
                                    <?php endif ?>
                                    <img width="50px" class="img-circle mr-3" src="<?php echo base_url($avatar) ?>"> 
                                  </div>
                                  
                                  <div class="d-flexs flex-columns">
                                      <div>
                                          <p class="leads font-weight-bold mb-0"><?php echo ucfirst($row->user_name); ?></p>
                                      </div>
                                  </div>
                                </div>
                              </td>

                              <td>
                                <span class="badge badge-primary"><?php echo ucfirst($row->payout_method); ?></span>
                                <a data-toggle="modal" href="#payoutModal_<?php echo html_escape($i) ?>" >
                                  <span class="badge badge-secondary"><i class="far fa-eye"></i> <?php echo trans('view-details') ?></span>
                                </a>
                              </td>
                              <td>
                                <?php 
                                  $user_balance = $row->balance/100;
                                  $withdraw_amount = $row->amount/100;
                                ?>

                                <h6 class="mb-0"><?php echo trans('amount-withdraw') ?>: <?php echo settings()->currency_symbol ?><?php echo html_escape($withdraw_amount); ?></h6>
                                <p class="mb-0 text-success"><?php echo settings()->currency_symbol.''.(number_format($user_balance, 2)) ?></p>
                              </td>
                              <td>
                                <p class="mb-0"><?php echo html_escape($row->transaction_id); ?></p>
                              </td>
                              <td>
                                <?php if ($row->status == 1): ?>
                                  <span class="badge badge-success"><i class="fas fa-check-circle"></i> <?php echo trans('completed') ?></span>
                                <?php else: ?>
                                  <span class="badge badge-warning"><i class="fas fa-clock"></i> <?php echo trans('pending') ?></span>
                                <?php endif ?>
                              </td>
                              <td>
                                <p class="mb-0 fs-14"><?php echo get_time_ago($row->created_at) ?></p>
                              </td>
                              <td class="actions">
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-tool" data-toggle="dropdown" aria-expanded="false">
                                      <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu" >
                                      <?php if ($status == 0): ?>
                                        <a href="<?php echo base_url('admin/payouts/complete/'.md5($row->id));?>" class="dropdown-item <?php if($user_balance < $withdraw_amount){echo "hide";} ?>"><i class="far fa-check-circle"></i> <?php echo trans('completed') ?></a>
                                      <?php endif ?>
                                      <a data-val="Category" data-id="<?php echo html_escape($row->id); ?>" href="<?php echo base_url('admin/payouts/delete/'.html_escape($row->id));?>" class="dropdown-item delete_item"><i class="lni lni-trash-can"></i> <?php echo trans('delete') ?></a>
                                    </div>
                                </div>
                              </td>

                          </tr>
                          
                        <?php $i++; endforeach; ?>
                      </tbody>
                  </table>
                  <?php else: ?>
                    <?php $this->load->view('admin/include/not-found'); ?>
                  <?php endif; ?>
              </div>

              <div class="mt-4">
                  <?php echo $this->pagination->create_links(); ?>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>

</div>



<?php $b=1; foreach ($payouts as $payout): ?>
<?php $user = get_user_by_id($payout->user_id, 'users_payout_accounts'); ?>

<div class="modal fade" id="payoutModal_<?php echo html_escape($b) ?>">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header justify-content-between">
        <h6 class="modal-title text-muted"><?php echo trans('payout-method') ?> (<?php echo ucfirst($payout->payout_method) ?>)</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="fs-14"><i class="lnib lni-close"></i></span>
        </button>
      </div>

      <div class="modal-body p-0">

        <?php if ($payout->payout_method == 'paypal'): ?>
        <ul class="list-group">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo trans('paypal') ?> <?php echo trans('email') ?>
            <span class="badge badge-primary-soft badge-pill fs-14 font-weight-normal"><?php echo html_escape($user->payout_paypal_email) ?></span>
          </li>
        </ul>
        <?php endif ?>

        <?php if ($payout->payout_method == 'iban'): ?>
        <ul class="list-group">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo trans('full-name') ?>
            <span class="badge badge-primary-soft badge-pill fs-14 font-weight-normal"><?php echo html_escape($user->iban_full_name) ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo trans('country') ?>
            <span class="badge badge-primary-soft badge-pill fs-14 font-weight-normal"><?php echo get_by_id($user->iban_country_id, 'country')->name ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo trans('bank-name') ?>
            <span class="badge badge-primary-soft badge-pill fs-14 font-weight-normal"><?php echo html_escape($user->iban_bank_name) ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo trans('iban-number') ?>
            <span class="badge badge-primary-soft badge-pill fs-14 font-weight-normal"><?php echo html_escape($user->iban_number) ?></span>
          </li>
        </ul>
        <?php endif ?>

        <?php if ($payout->payout_method == 'swift'): ?>
        <ul class="list-group">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo trans('full-name') ?>
            <span class="badge badge-primary-soft badge-pill fs-14 font-weight-normal"><?php echo html_escape($user->swift_full_name) ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo trans('state') ?>
            <span class="badge badge-primary-soft badge-pill fs-14 font-weight-normal"><?php echo html_escape($user->swift_state) ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo trans('city') ?>
            <span class="badge badge-primary-soft badge-pill fs-14 font-weight-normal"><?php echo html_escape($user->swift_city) ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo trans('post-code') ?>
            <span class="badge badge-primary-soft badge-pill fs-14 font-weight-normal"><?php echo html_escape($user->swift_postcode) ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo trans('address') ?>
            <span class="badge badge-primary-soft badge-pill fs-14 font-weight-normal"><?php echo html_escape($user->swift_address) ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo trans('bank-account-holders-name') ?>
            <span class="badge badge-primary-soft badge-pill fs-14 font-weight-normal"><?php echo html_escape($user->swift_bank_account_holder_name) ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo trans('bank-name') ?>
            <span class="badge badge-primary-soft badge-pill fs-14 font-weight-normal"><?php echo html_escape($user->swift_bank_name) ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo trans('bank-branch-country') ?>
            <span class="badge badge-primary-soft badge-pill fs-14 font-weight-normal"><?php echo get_by_id($user->swift_bank_branch_country_id, 'country')->name ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo trans('bank-branch-city') ?>
            <span class="badge badge-primary-soft badge-pill fs-14 font-weight-normal"><?php echo html_escape($user->swift_bank_branch_city) ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo trans('bank-account-number') ?>
            <span class="badge badge-primary-soft badge-pill fs-14 font-weight-normal"><?php echo html_escape($user->swift_iban) ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo trans('swift-code') ?>
            <span class="badge badge-primary-soft badge-pill fs-14 font-weight-normal"><?php echo html_escape($user->swift_code) ?></span>
          </li>
        </ul>
        <?php endif ?>

      </div>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<?php $b++; endforeach; ?>
