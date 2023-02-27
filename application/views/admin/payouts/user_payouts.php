<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <?php $this->load->view('admin/include/breadcrumb'); ?>

  <?php 
    $balance = number_format(user()->balance/100, 2);
    $total_withdraw = total_earnings(user()->id) - $balance;
  ?>

  <!-- Main content -->
  <div class="content pt-4">
      <div class="container">
        <div class="row box-payout-areas">
          
          <div class="col-md-4 col-sm-6 col-12 mb-1">
            <div class="info-box-pay border border-primary">
              <div class="info-box-content-pay">
                <span class="info-box-number-pay text-primary"><?php echo settings()->currency_symbol ?><?php echo total_earnings(user()->id); ?></span>
                <span class="info-box-text font-weight-bold text-muted"><?php echo trans('total-earnings') ?> <span class="small">(<?php echo trans('after-commission-of') ?> <?php echo settings()->commission_rate ?>%)</span></span>
                <span class="small mt-1"></span>
              </div>
              <!-- /.info-box-content-pay -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <div class="col-md-4 col-sm-6 col-12 mb-1">
            <div class="info-box-pay border border-warning">
              <div class="info-box-content-pay">
                <span class="info-box-number-pay text-warning"><?php echo settings()->currency_symbol ?> <?php echo $total_withdraw;  ?></span>
                <span class="info-box-text font-weight-bold text-muted"> <?php echo trans('total-withdraw') ?></span>
                <span class="small mt-1"></span>
              </div>
              <!-- /.info-box-content-pay -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <div class="col-md-4 col-sm-6 col-12 mb-1">
            <div class="info-box-pay border border-success">
              <div class="info-box-content-pay">
                <span class="info-box-number-pay text-success"><?php echo settings()->currency_symbol ?><?php echo html_escape($balance) ?></span>
                <span class="info-box-text font-weight-bold text-muted"> <?php echo trans('balance') ?> </span>
              </div>
              <!-- /.info-box-content-pay -->
            </div>

            <span class="small mt-1"><i class="fas fa-info-circle text-muted"></i> <?php echo trans('minimum-payout-amounts') ?> <?php echo settings()->currency_symbol.'<b>'.settings()->min_payout_amount.'</b>' ?></span>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          
        </div>

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
                      <label><?php echo trans('amount') ?> (<?php echo settings()->currency_code?>)</label>
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

            <div class="card list_area <?php if(isset($_GET['error']) && $_GET['error'] == "Invalid"){echo "hide";} ?>">
              <div class="card-header with-border">
                  <h3 class="card-title pt-2"><?php echo trans('payouts') ?> </h3>
                  <div class="card-tools pull-right">
                    <?php if ($balance >= settings()->min_payout_amount): ?>
                      <a href="#" class="pull-right btn btn-sm btn-success add_btn"> <?php echo trans('send-payout-request') ?></a>
                    <?php endif ?>
                  </div>
              </div>

              <div class="card-body table-responsive p-0">
                  <?php if (!empty($payouts)): ?>
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo trans('amount') ?> </th>
                                <th><?php echo trans('payout-method') ?></th>
                                <th><?php echo trans('transaction-id') ?></th>
                                <th><?php echo trans('status') ?></th>
                                <th><?php echo trans('date') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $i=1; foreach ($payouts as $row): ?>
                            <tr id="row_<?php echo html_escape($row->id); ?>">
                                <td><?= $i; ?></td>
                                <td>
                                  <p class="mb-0"><?php echo settings()->currency_symbol ?><?php echo number_format($row->amount/100, 0); ?></p>
                                </td>
                                <td>
                                  <span class="badge badge-secondary"><?php echo ucfirst($row->payout_method); ?></span>
                                </td>
                                <td>
                                  <p class="mb-0"><?php echo html_escape($row->transaction_id); ?></p>
                                </td>
                                <td>
                                  <?php if ($row->status == 1): ?>
                                    <span class="badge badge-success"><i class="fas fa-check-circle"></i> <?php echo trans('completed') ?></span>
                                  <?php else: ?>
                                    <span class="badge badge-warning-soft"><i class="fas fa-clock"></i> <?php echo trans('pending') ?></span>
                                  <?php endif ?>
                                </td>

                                <td>
                                  <p class="mb-0 fs-14"><?php echo my_date_show_time($row->created_at) ?></p>
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
