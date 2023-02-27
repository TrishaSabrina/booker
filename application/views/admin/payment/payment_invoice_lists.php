<div class="content-wrapper">

  <!-- Main content -->
  <section class="content container pt-4 mb-4">

    <div class="card list_area">
      <div class="card-header with-border pl-2">
        <h3 class="card-title"><?php echo trans('payments') ?></h3>
      </div>
    
     
      <div class="col-md-10">
        <div class="card-body table-responsive p-0">
          <table class="table table-hover <?php if(count($payments) > 10){echo "datatable";} ?> cushover" id="dg_table">
              <thead>
                  <tr>
                      <th>#</th>
                      <th><?php echo trans('plan') ?></th>
                      <th><?php echo trans('billing-cycle') ?></th>
                      <th><?php echo trans('price') ?></th>
                      <th><?php echo trans('date') ?></th>
                      <th><?php echo trans('status') ?></th>
                      <th><?php echo trans('action') ?></th>
                  </tr>
              </thead>
              <tbody>
                <?php $i=1; foreach ($payments as $payment): ?>

                  <?php if ($payment->amount != '0.00'): ?>
                    <tr id="row_<?php echo html_escape($payment->id); ?>">
                        
                        <td><?php echo $i; ?></td>
                        <td><?php echo html_escape($payment->package_name); ?></td>
                        <td><?php echo html_escape($payment->billing_type); ?></td>
                        <td><?php if(settings()->curr_locate == 0){echo settings()->currency_symbol;} ?><?php echo number_format($payment->amount, settings()->num_format); ?> <?php if(settings()->curr_locate == 1){echo settings()->currency_symbol;} ?></td>
                        <td><?php echo my_date_show($payment->created_at); ?> </td>
                        <td>
                          <?php if ($payment->status == 'verified'): ?>
                            <p class="mb-1"><span class="badge badge-success"><i class="fas fa-check-circle"></i> <?php echo trans('paid') ?></span></p>
                          <?php elseif ($payment->status == 'pending'): ?>
                            <p class="mb-1"><span class="badge-custom badge-warning-soft"><i class="far fa-clock"></i> <?php echo trans('pending') ?></span></p>
                          <?php else: ?>
                              <p class="mb-1"><span class="badge-custom badge-danger-soft"><i class="far fa-clock"></i> <?php echo trans('expired') ?></span></p>
                          <?php endif; ?>
                        </td>
                        <td class="actions">
                          <a target="_blank" href="<?php echo base_url('admin/payment/receipt/'.$payment->puid) ?>" class="pull-right badge badge-primary-soft"><i class="fa fa-eye"></i> <?php echo trans('view-invoice') ?></a>
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
