<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <?php $this->load->view('admin/include/breadcrumb'); ?>

  <!-- Main content -->
  <div class="content">
    <div class="container">
      <div class="row">
          <div class="col-md-6">
            <div class="card" data-aos="fade-up" data-aos-delay="100">
              <div class="card-header">
                <h5 class="mb-0"><?php echo trans('net-income') ?></h5>
              </div>
              
              <div class="card-body">
                <div id="netIncomeChart"></div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card" data-aos="fade-up" data-aos-delay="250">
              <div class="card-header">
                <h5 class="m-0"><?php echo trans('most-booked-customers') ?></h5>
              </div>
              <div class="card-body">
                <div id="customersPie"></div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card" data-aos="fade-up" data-aos-delay="500">
              <div class="card-header">
                <h5 class="m-0"><?php echo trans('most-serviced-staffs') ?></h5>
              </div>
              <div class="card-body">
                <div id="staffPie"></div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card" data-aos="fade-up" data-aos-delay="600">
              <div class="card-header">
                <h5 class="m-0"><?php echo trans('most-booked-services') ?></h5>
              </div>
              <div class="card-body">
                <div id="serviceChart"></div>
              </div>
            </div>
          </div>

      </div>
    </div>
  </div>
</div>