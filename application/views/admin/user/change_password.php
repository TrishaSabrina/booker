<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <?php $this->load->view('admin/include/breadcrumb'); ?>

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
            
            <?php if (user()->role == 'user'): ?>
              <?php $this->load->view('admin/user/include/settings_menu.php'); ?>
            <?php endif ?>

            <div class="col-lg-12 pl-3">
                <form method="post" id="cahage_pass_form" action="<?php echo base_url('admin/settings/change') ?>">
                    <div class="card">
                        <div class="card-body">
                          <div class="row p-35">
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label><?php echo trans('old-password') ?></label>
                                <input type="password" class="form-control" name="old_pass" />
                              </div>
                            </div>

                            <div class="col-sm-12">
                              <div class="form-group">
                                <label><?php echo trans('new-password') ?></label>
                                <input type="password" class="form-control" name="new_pass" />
                              </div>
                            </div>

                            <div class="col-sm-12">
                              <div class="form-group">
                                <label><?php echo trans('confirm-new-password') ?></label>
                                <input type="password" class="form-control" name="confirm_pass" />
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="card-footer">
                            <input type="hidden" name="id" value="<?php echo html_escape(user()->id); ?>">
                            <!-- csrf token -->
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                            <button type="submit" class="btn btn-primary"> <?php echo trans('save-changes') ?></button>
                        </div>
                    </div>
                </form>

            </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
