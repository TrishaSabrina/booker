<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <?php $this->load->view('admin/include/breadcrumb'); ?>

  <!-- Main content -->
  <div class="content">
    <div class="container">
        <div class="row">
          <div class="col-md-3 pt-2">
              <div class="card-body box-profile pt-4 mt-5 p-0">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="<?php echo base_url($customer->thumb) ?>" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center mb-1"><?php echo $customer->name ?></h3>
                <p class="text-muted text-center mb-1"><?php echo $customer->phone ?></p>
                <p class="text-muted text-center strong"><?php echo trans('joined') ?>: <?php echo get_time_ago($customer->created_at) ?></p>

                <ul class="list-group list-group-unbordered pt-3">
                  <li class="list-group-item pl-3 pr-3 text-dark">
                    <span class="font-weight-bold fs-12"><?php echo trans('total-appointments') ?></span> <a class="float-right badge badge-secondary-soft"><?php echo count_customer_info($customer->id, 1); ?></a>
                  </li>
                  <li class="list-group-item pl-3 pr-3 text-dark">
                    <span class="font-weight-bold fs-12"><?php echo trans('total-services') ?></span> <a class="float-right badge badge-secondary-soft"><?php echo count_customer_info($customer->id, 2); ?></a>
                  </li>
                  <li class="list-group-item pl-3 pr-3 text-dark">
                    <span class="font-weight-bold fs-12"><?php echo trans('last-appointment') ?></span> <a class="float-right badge badge-secondary-soft"><?php if (!empty($appointments)){echo my_date_show($appointments[0]->created_at);} ?></a>
                  </li>
                </ul>
              </div>
          </div>

          <div class="col-md-9">
              <?php if (!empty($appointments)): ?>
                <div class="card pl-3">
                  <div class="card-header">
                    <h5 class="card-title mb-0"><?php echo trans('appointments') ?> </h5>

                    <div class="card-tools pull-right"><a class="pull-right btn btn-secondary btn-sm" href="<?php echo base_url('admin/customers') ?>"><i class="fas fa-angle-left"></i> Back</a></div>
                  </div>
                  
                  <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-valign-middle <?php if(count($appointments) > 10){echo "datatable";} ?>">
                      <thead>
                      <tr>
                        <th><?php echo trans('service') ?></th>
                        <th><?php echo trans('date') ?></th>
                        <th><?php echo trans('time') ?></th>
                        <th><?php echo trans('payment') ?></th>
                        <th><?php echo trans('created') ?></th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($appointments as $appointment): ?>
                          <tr>
                            
                            <td>
                                <p class="mb-0 font-weight-bold"><?php echo html_escape($appointment->service_name) ?></p>
                            </td>


                            <td>
                                <p class="mb-0 fs-13"> <?php echo my_date_show($appointment->date) ?></p>
                            </td>

                            <td>
                                <p class="mb-0 fs-13"> <?php echo html_escape($appointment->time) ?></p>
                            </td>

                            <td>

                              <span class="fs-14"><?php if($this->business->curr_locate == 0){echo $this->business->currency_symbol;} ?>
                                <?php echo number_format($appointment->price, $this->business->num_format) ?>
                                <?php if($this->business->curr_locate == 1){echo $this->business->currency_symbol;} ?></span>

                            <?php $check_payment = check_appointment_payment($appointment->id) ?>
                                <?php if ($check_payment == true): ?>
                                  <p class="mb-1 text-success fs-12 font-weight-bold"><i class="fas fa-check-circle"></i> <?php echo trans('paid') ?></p>
                                <?php else: ?>
                                  <?php if ($appointment->price != 0): ?>
                                    <p class="mb-1 text-warning fs-12 font-weight-bold"><i class="far fa-clock"></i> <?php echo trans('pending') ?></p>
                                  <?php endif; ?>
                                <?php endif; ?>
                            </td>

                            <td>
                                <span class="small"><i class="far fa-clock"></i> <?php echo html_escape(get_time_ago($appointment->created_at)) ?></span>
                            </td>
                            
                          </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              <?php else: ?>
                <div class="card mt-5">
                  <div class="card-body mt-2 text-center p-5 pt-4">
                      <p><?php echo trans('no-data-found') ?></p>
                  </div>
                </div>
              <?php endif ?>
          </div>

        </div>
    </div>
  </div>
</div>