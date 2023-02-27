<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <?php $this->load->view('admin/include/breadcrumb'); ?>
  <!-- Main content -->
    <div class="content">
        <div class="container">
          <div class="row pb-5">
            <div class="col-lg-5 col-sm-12 col-xs-12">
                
                <div class="card-body mt-2">
                  <p class="text-left"><?php echo trans('apply-your-coupon-code-here') ?></p>
                  <div class="input-group mt-1">
                      <input type="text" name="coupon_code" class="form-control coupon_code" placeholder="Coupon code" aria-label="Apply Code here" aria-describedby="basic-addon2">
                      <div class="input-group-append">
                          <input type="hidden" name="appointment_id" class="appointment_id" value="">
                          <button class="btn btn-primary apply_coupon" type="button"><?php echo trans('apply') ?></button>
                      </div>
                  </div>

                  <div class="d-flexs apply_msg text-right mt-2">
                      <span class="badge badge-success-soft mb-2 mt-2 d-hide apply_msg_success"></span>
                      <span class="badge badge-danger-soft mb-2 mt-2 d-hide apply_msg_error"></span>
                  </div>
                </div>

              </div>
           
            </div>
        </div>
    </div>
</div>