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
                    <form method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/settings/update_profile') ?>" role="form" class="form-horizontal pl-20">
                        <div class="card-body">
                             
                            <div class="row mb-4">
                                <div class="col-md-6 mr-auto">
                                    <div class="form-group">
                                        <div class="mih-100">
                                            <img width="100px" src="<?php echo base_url(user()->thumb); ?>">
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="photo" id="customFile">
                                            <label class="custom-file-label" for="customFile"><?php echo trans('upload-logo') ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><?php echo trans('name') ?></label>
                                        <input type="text" name="name" value="<?php echo html_escape(user()->name); ?>" class="form-control" >
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><?php echo trans('email') ?></label>
                                        <input type="text" name="email" value="<?php echo html_escape(user()->email); ?>" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><?php echo trans('phone') ?></label>
                                        <input type="text" name="phone" value="<?php echo html_escape(user()->phone); ?>" class="form-control">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <input type="hidden" name="id" value="<?php echo html_escape(user()->id); ?>">
                            <!-- csrf token -->
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                            <button type="submit" class="btn btn-primary mt-2"> <?php echo trans('save-changes') ?></button>
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
