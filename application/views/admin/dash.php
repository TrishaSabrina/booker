<div class="content-wrapper">
 
    <div class="content pt-4 mb-4">
      <div class="container">
        <div class="row box-dash-areas">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-primary-soft" data-aos="fade-up" data-aos-delay="100">
              <span class="info-box-icon bg-primary"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-number"><?php echo get_count('users') - 1; ?></span>
                <span class="info-box-text"><?php echo trans('users') ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-success-soft" data-aos="fade-up" data-aos-delay="150">
              <span class="info-box-icon bg-success"><i class="fas fa-stream"></i></span>

              <div class="info-box-content">
                <span class="info-box-number"><?php echo get_count('services') ?></span>
                <span class="info-box-text"><?php echo trans('services') ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-danger-soft" data-aos="fade-up" data-aos-delay="200">
              <span class="info-box-icon bg-danger"><i class="fas fa-calendar-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-number"><?php echo get_count('appointments') ?></span>
                <span class="info-box-text"><?php echo trans('appointments') ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-info-soft" data-aos="fade-up" data-aos-delay="250">
              <span class="info-box-icon bg-info"><i class="fas fa-user-friends"></i></span>

              <div class="info-box-content">
                <span class="info-box-number"><?php echo get_count('customers') ?></span>
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
          <div class="col-lg-7">
            <div class="card" data-aos="fade-up">
              <div class="card-header">
                <h5 class="mb-0"><?php echo trans('last-12-months-income') ?></h5>
              </div>

              <div class="card-body">
                <div id="adminIncomeChart"></div>
              </div>
            </div>

            <div class="card mb-2" data-aos="fade-up">
              <div class="card-header">
                <h5 class="mb-0"><?php echo trans('latest-users') ?></h5>
              </div>
    
              <div class="card-body table-responsive p-0">
                <table class="table table-hover table-valign-middle">
                  <thead>
                  <tr>
                    <th><?php echo trans('user') ?></th>
                    <th><?php echo trans('plan') ?></th>
                    <th><?php echo trans('joining-date') ?></th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($users as $user): ?>
                      <tr>
                        <td>
                          <img src="<?php echo base_url($user->thumb); ?>" alt="user" class="img-circle img-size-32 mr-2">
                          <?php echo html_escape($user->name) ?>
                        </td>
                        <td><span class="badge badge-primary-soft"><?php echo html_escape($user->package); ?></span></td>
                        <td>
                            <span class="small text-muted"><i class="fas fa-clock"></i> <?php echo get_time_ago($user->created_at) ?></span>
                        </td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>
            <?php if (count($users) > 5): ?>
              <div class="text-center mb-2">
                <a href="<?php echo base_url('admin/users') ?>" class="badge bg-secondary"><?php echo trans('see-all') ?></a>
              </div>
            <?php endif ?>
          </div>

          <!-- /.col-md-6 -->
          <div class="col-lg-5">
            <div class="card" data-aos="fade-up">
              <div class="card-header">
                <h5 class="m-0"><?php echo trans('packages-by-user') ?></h5>
              </div>
              <div class="card-body">
                <div id="packagePie"></div>
              </div>
            </div>


            <div class="card" data-aos="fade-up">
              <div class="card-header">
                <h5 class="mb-0"><?php echo trans('net-income') ?></h5>
              </div>
              
              <div class="card-body p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th><?php echo trans('fiscal-year') ?> <i class="fa fa-info-circle" data-toggle="tooltip" data-title="<?php echo trans('fiscal-year-title') ?>"></i></th>
                      <?php foreach ($net_income as $netincome): ?>
                        <th><?php echo show_year($netincome->created_at) ?></th>
                      <?php endforeach ?>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><?php echo trans('income') ?></td>
                      <?php foreach ($net_income as $netincome): ?>
                        <td><span class="badge badge-success-soft"><?php echo settings()->currency_symbol ?> <?php echo html_escape(number_format($netincome->total,2)) ?></span></td>
                      <?php endforeach ?>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container -->
    </div>
    <!-- /.content -->
  </div>