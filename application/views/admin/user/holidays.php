<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <?php $this->load->view('admin/include/breadcrumb'); ?>

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
        
            <div class="col-md-12">
                <div class="cards">
                    <form method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/settings/update_sms') ?>" role="form" class="form-horizontal pl-20">
                        <div class="card-bodys">
                            <div class="row">
                                <div class="col-md-7 mr-auto">
                                    <h5><i class="far fa-calendar-alt"></i> <?php echo trans('holidays') ?></h5>
                                    <div id="holiday_picker"></div>
                                </div>
                                <div class="col-md-5">
                                    <div class="hol-list mt-4 pt-2 pl-4">
                                        <?php  $holidays_list = json_decode($this->business->holidays, true); ?>
                                        <?php if (!empty($holidays_list)): ?>
                                        <?php foreach ($holidays_list as $list): ?>
                                            <span class="badge badge-secondary fs-13 mb-1"><i class="fas fa-calendar-alt"></i> <?php echo my_date_show($list) ?></span>
                                        <?php endforeach ?>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
