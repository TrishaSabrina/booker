<div class="content-wrapper">
  <!-- Main content -->
  <section class="content container pt-4 mb-4">
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
                        <th class="text-right"><?php echo trans('user') ?></th>
                        <th></th>
                        <th><?php echo trans('plan') ?></th>
                        <th><?php echo trans('billing-cycle') ?></th>
                        <th><?php echo trans('price') ?></th>
                        <th><?php echo trans('status') ?></th>
                        <th><?php echo trans('payment') ?></th>
                        <th><?php echo trans('date') ?></th>
                        <th><?php echo trans('action') ?></th>
                    </tr>
                </thead>
                <tbody>
                  <?php $i=1; foreach ($payments as $payment): ?>

                    <?php if ($payment->amount != '0.00'): ?>
                      <tr id="row_<?php echo html_escape($payment->id); ?>">
                          
                          <td><?php echo $i; ?></td>
                          
                          <?php if ($payment->thumb == ''): ?>
                              <?php $avatar = 'assets/images/avatar.png'; ?> 
                          <?php else: ?>
                              <?php $avatar = $payment->thumb; ?>
                          <?php endif ?>
                          <td class="text-right"><img width="40px" class="img-circle" src="<?php echo base_url($avatar) ?>"></td>
                          <td>
                            <?php echo ucfirst($payment->user_name); ?><br>
                            <?php echo ucfirst($payment->email); ?>
                          </td>
                          <td><span class="badge badge-primary brd-20"><?php echo html_escape($payment->package_name); ?></span></td>
                          <td><?php echo ucfirst($payment->billing_type); ?></td>
                          <td>
                            <?php if(settings()->curr_locate == 0){echo settings()->currency_symbol;} ?>
                            <?php echo number_format($payment->amount, settings()->num_format); ?>
                            <?php if(settings()->curr_locate == 1){echo settings()->currency_symbol;} ?>
                          </td>
                          <td>
                            <?php if ($payment->status == 'verified'): ?>
                              <span class="badge badge-success-soft brd-20"><i class="fas fa-check-circle"></i> <?php echo trans('paid') ?></span>
                            <?php else: ?>
                              <span class="badge badge-danger-soft brd-20"><?php echo ucfirst($payment->status); ?></span>
                            <?php endif ?>
                          </td>

                          <td>
                            <?php if (!empty($payment->payment_method)): ?>
                              <span class="badge badge-secondary-soft brd-20"> <?php echo ucfirst($payment->payment_method); ?></span>
                            <?php endif ?>
                          </td>

                          <td><?php echo my_date_show($payment->created_at); ?> </td>
                          
                          <td class="actions">
                            <div class="btn-group">
                                <button type="button" class="btn btn-tool" data-toggle="dropdown" aria-expanded="false">
                                  <i class="fas fa-ellipsis-h"></i>
                                </button>

                                <div class="dropdown-menu dropdown-menu-right" role="menu" >
                                  <?php if (!empty($payment->proof)): ?>

                                    <?php if (!empty($payment->status == 'pending')): ?>
                                      <a href="<?php echo base_url('admin/payment/approve_offline/'.$payment->id) ?>" class="dropdown-item"><i class="far fa-check-circle"></i> <?php echo trans('approve-payment') ?></a>
                                    <?php endif ?>

                                    <a target="_blank" href="<?php echo base_url('uploads/files/'.$payment->proof) ?>" class="dropdown-item"><i class="far fa-eye"></i> <?php echo trans('view-proof') ?></a>
                                  <?php endif ?>

                                  <a target="_blank" href="<?php echo base_url('admin/payment/receipt/'.$payment->puid) ?>" class="dropdown-item"><i class="far fa-eye"></i> <?php echo trans('view-invoice') ?></a>
                                </div>
                            </div>
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
