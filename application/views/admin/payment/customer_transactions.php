<div class="content-wrapper">
  <!-- Main content -->
  <section class="content container">
    <div class="card list_area">
      <div class="card-header with-border pl-2">
        <h3 class="card-title p-0"><?php echo trans('transactions') ?> </h3>
      </div>
    
      <div class="col-md-12"> 
        <div class="card-body table-responsive p-0">
            <table class="table table-hover <?php if(count($payments) > 10){echo "datatable";} ?> cushover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo trans('date') ?></th>
                        <th><?php echo trans('service') ?></th>
                        <th><?php echo trans('customer') ?></th>
                        <th><?php echo trans('price') ?></th>
                        <th><?php echo trans('status') ?></th>
                        <th><?php echo trans('payment-type') ?></th>
                        <th><?php echo trans('action') ?></th>
                    </tr>
                </thead>
                <tbody>
                  <?php $i=1; foreach ($payments as $payment): ?>

                    <?php if ($payment->amount != '0.00'): ?>
                      <tr id="row_<?php echo html_escape($payment->id); ?>">
                          
                          <td><?php echo $i; ?></td>
                          
                          <td><?php echo my_date_show($payment->created_at); ?> </td>

                          <td><?php echo get_by_id($payment->service_id, 'services')->name; ?> </td>

                          <?php $customer = get_by_id($payment->customer_id, 'customers') ?>
                          <?php if ($customer->thumb == ''): ?>
                              <?php $avatar = 'assets/images/avatar.png'; ?> 
                          <?php else: ?>
                              <?php $avatar = $customer->thumb; ?>
                          <?php endif ?>
                          <td>
                            <img width="40px" class="img-circle mr-2" src="<?php echo base_url($avatar) ?>"> 
                            <?php echo ucfirst($customer->name); ?>
                          </td>

                          <td>
                            <?php if($this->business->curr_locate == 0){echo $this->business->currency_symbol;} ?>
                            <?php echo number_format($payment->amount, $this->business->num_format); ?>
                            <?php if($this->business->curr_locate == 1){echo $this->business->currency_symbol;} ?>
                          </td>

                          <td>
                            <?php if ($payment->status == 'verified'): ?>
                              <span class="badge badge-success-soft brd-20"><i class="fas fa-check-circle"></i> <?php echo trans('paid') ?></span>
                            <?php else: ?>
                              <span class="badge badge-danger-soft brd-20"><?php echo ucfirst($payment->status); ?></span>
                            <?php endif ?>
                          </td>

                          <td>
                            <?php if (settings()->enable_wallet == 1): ?>
                              <span class="badge badge-danger-soft brd-20"><i class="fas fa-credit-card"></i> <?php echo trans('wallet') ?></span>
                            <?php else: ?>
                              <?php if (!empty($payment->payment_method)): ?>
                                <span class="badge badge-secondary-soft brd-20"><i class="fas fa-hand-holding-usd"></i> <?php echo ucfirst($payment->payment_method); ?></span>
                              <?php endif ?>
                            <?php endif ?>

                            
                          </td>
                          
                          <td class="actions">
                              <a target="_blank" href="<?php echo base_url('admin/payment/customer_receipt/'.$payment->puid) ?>" class="pull-right badge badge-primary-soft"><i class="fa fa-eye"></i> <?php echo trans('view-invoice') ?></a>
                          </td>
                      </tr>
                    <?php endif ?>
                    
                  <?php $i++; endforeach; ?>
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </section>
</div>
