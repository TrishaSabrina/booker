<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <?php $this->load->view('admin/include/breadcrumb'); ?>

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
        
            <?php $this->load->view('admin/user/include/settings_menu.php'); ?>

            <div class="col-lg-9 pl-3">
                <div class="card">
                    <?php if (isset($page_title) && $page_title == 'Embedded Settings'): ?>
                        <div class="card-body">
                            <p class="lead"><span class="badge badge-secondary-soft"><i class="far fa-clone"></i> <?php echo trans('embed-code-copy') ?></span></p>
                            <textarea class="form-control mb-4" rows="6">
                                <iframe src="<?php echo base_url($this->business->slug) ?>" width="100%" height="400">
                                  <p>Your browser does not support iframes.</p>
                                </iframe>
                            </textarea>
                            
                            <p class="mb-3 lead"><span class="badge badge-success-soft badge-pill fs-16"><i class="fas fa-eye"></i> <?php echo trans('preview') ?></span></p>
                            <div class="col-8">
                                <iframe src="<?php echo base_url($this->business->slug) ?>" width="100%" height="400">
                                  <p>Your browser does not support iframes.</p>
                                </iframe>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="card-body">
                            <p class="lead"><span class="badge badge-secondary-soft"><i class="fas fa-share-alt"></i> <?php echo trans('share-qr-code') ?></span></p>
                            <img class="img-thumbnail opacity-40" src="<?php echo base_url($company->qr_code) ?>">

                            <p class="mt-3"><a href="<?php echo base_url('admin/settings/download_qrcode') ?>" class="btn btn-primary btn-sm"><i class="lni lni-cloud-download"></i> <?php echo trans('download') ?></a></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
