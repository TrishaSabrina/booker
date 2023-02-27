<div class="content-wrapper">
 
    <div class="content pt-4 mb-4">
      <div class="container">
        <div class="row box-dash-areas">
          
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-primary-soft" data-aos="fade-up" data-aos-delay="150">
              <span class="info-box-icon bg-primary"><i class="fas fa-calendar-alt"></i></span>
              <div class="info-box-content">
                <span class="info-box-number"><?php echo get_count_by_user('appointments') ?></span>
                <span class="info-box-text"><?php echo trans('appointments') ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-danger-soft" data-aos="fade-up" data-aos-delay="200">
              <span class="info-box-icon bg-danger"><i class="fas fa-users"></i></span>
              <div class="info-box-content">
                <span class="info-box-number"><?php echo get_count_by_user('staffs') ?></span>
                <span class="info-box-text"><?php echo trans('staff') ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-success-soft" data-aos="fade-up" data-aos-delay="250">
              <span class="info-box-icon bg-success"><i class="fas fa-stream"></i></span>
              <div class="info-box-content">
                <span class="info-box-number"><?php echo get_count_by_user('services') ?></span>
                <span class="info-box-text"><?php echo trans('services') ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-info-soft" data-aos="fade-up" data-aos-delay="300">
              <span class="info-box-icon bg-info"><i class="fas fa-user-friends"></i></span>
              <div class="info-box-content">
                <span class="info-box-number"><?php echo get_count_by_user('customers') ?></span>
                <span class="info-box-text"><?php echo trans('customers') ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="card" data-aos="fade-up">
              <div class="card-header">
                <h5 class="mb-0"><?php echo trans('last-12-months-income') ?></h5>
              </div>
              
              <div class="card-body">
                <div id="userIncomeChart"></div>
              </div>
            </div>

            <?php if (!empty($appointments)): ?>
              <div class="card" data-aos="fade-up">
                <div class="card-header">
                  <h5 class="mb-0"><?php echo trans('latest-appointments') ?></h5>
                </div>
                
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover table-valign-middle">
                    <thead>
                    <tr>
                      <th><?php echo trans('customer') ?></th>
                      <th><?php echo trans('service') ?></th>
                      <th><?php echo trans('time-date') ?></th>
                      <th><?php echo trans('created') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($appointments as $appointment): ?>
                        <tr>
                          <td>
                            <div class="d-flex">
                              <div class="mr-3">
                                <img class="img-circle mt-1" width="30px" src="<?php echo base_url($appointment->customer_thumb) ?>">
                              </div>
                              <div>
                                <p class="mb-0 font-weight-bold"><?php echo html_escape($appointment->customer_name) ?></p>
                                <p class="mb-0"><?php echo html_escape($appointment->customer_email) ?></p>
                              </div>
                            </div>
                          </td>

                          <td>
                              <p class="mb-0 font-weight-bold"><?php echo html_escape($appointment->service_name) ?></p>
                          </td>


                          <td>
                              <p class="mb-1"><?php echo my_date_show($appointment->date) ?></p>
                              <p class="mb-0"><span class="small"><?php echo format_time($appointment->time, $this->business->time_format) ?></span></p>
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


              <div class="text-center mb-4">
                <a href="<?php echo base_url('admin/appointment') ?>" class="btn btn-secondary btn-xs"><?php echo trans('see-all') ?> <i class="lnib lni-arrow-right"></i></a>
              </div>
            <?php endif ?>
          </div>
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>