<div class="content-wrapper">
  <section class="content">
    <div class="container mb-20">
        <div class="row">
          <div class="text-center m-auto col-md-6">
              <div class="pay_status">
                <h3><i class="icon-question text-success fa-2x"></i></h3>
                <p><strong class="mb-50"> <?php echo trans('sure-upgrade') ?></strong></p><br>
                <a class="btn btn-success" href="<?php echo base_url('admin/subscription/upgrade/'.$slug.'/1/'.$billing_type) ?>"><i class="ficon flaticon-check"></i> <?php echo trans('yes-continue') ?> </a>
              </div>
          </div>
        </div>
    </div>
  </section>
</div>