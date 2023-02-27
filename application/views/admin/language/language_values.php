<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <?php $this->load->view('admin/include/breadcrumb'); ?>

  <!-- Start content -->
  <div class="content">
    <div class="container">

      <div class="row">
        <div class="col-md-12 d-block">
          <div class="card">
              <div class="card-header"><h3 class="card-title">Language Values</h3></div>
              <div class="card-body">
                  <form method="post" class="validate-form" action="<?php echo base_url('admin/language/add_value')?>" role="form" novalidate>
                      
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label><?php echo trans('label') ?></label>
                            <input type="text" class="form-control" placeholder="Example: Home / Register User" name="label" autocomplete="off" required>
                          </div><br>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                            <label><?php echo trans('keyword') ?></label>
                            <input type="text" class="form-control" placeholder="Example: home / register_user" name="keyword" autocomplete="off" required>
                          </div>
                        </div>

                        <div class="col-md-4 hides">
                          <div class="form-group">
                              <label class="col-sm-2 control-label p-0" for="example-input-normal"><?php echo trans('type') ?></label>
                              <select class="form-control" name="type" required>
                                  <option value="">Select</option>
                                  <option value="front">Frontend</option>
                                  <option value="admin">Admin</option>
                                  <option selected value="user">User</option>
                              </select>
                          </div>
                        </div>

                      </div>

                      <input type="hidden" name="lang" value="<?php echo html_escape($value) ?>">
                      <!-- csrf token -->
                      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

                 
                        <div class="col-sm-12 p-0">
                            <button type="submit" class="btn btn-secondary btn-lg btn-block pull-right"> <?php echo trans('save') ?></button>
                        </div>
                

                  </form>
              </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="card input_area">
            <div class="card-header">
          
              <div class="d-flex justify-content-between">
              <div class="ml-10 dropdown">
                <button type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown">
                  <?php if ($type == 'front'): ?>
                    <?php echo trans('edit-frontend-values') ?>
                  <?php elseif ($type == 'admin'): ?>
                    <?php echo trans('edit-admin-values') ?>
                  <?php elseif ($type == 'user'): ?>
                    <?php echo trans('edit-user-values') ?>
                  <?php endif ?>           
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="<?php echo base_url('admin/language/values/front/'.$value) ?>"><?php echo trans('edit-frontend-values') ?></a>
                  <a class="dropdown-item" href="<?php echo base_url('admin/language/values/admin/'.$value) ?>"><?php echo trans('edit-admin-values') ?></a>
                  <a class="dropdown-item" href="<?php echo base_url('admin/language/values/user/'.$value) ?>"><?php echo trans('edit-user-values') ?></a>
                </div>
              </div>

              <div class="dropdown">
                <button type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown">
                  <i class="fa fa-language"></i> <?php echo ucfirst($value); ?>              
                </button>
                <div class="dropdown-menu">
                  <?php $lang_list = get_language(); ?>
                  <?php foreach ($lang_list as $lg): ?>
                    <a class="dropdown-item" href="<?php echo base_url('admin/language/values/'.$type.'/'.$lg->slug) ?>"><?php echo ucfirst($lg->name) ?></a>
                  <?php endforeach ?>
                </div>
              </div>
              </div>

            </div>




            <div class="card-body">

            <form method="post" class="validate-form" action="<?php echo base_url('admin/language/update_values/'.$type)?>" role="form" novalidate>

              <div class="row">
                <div class="col-sm-6">
                    <button type="submit" class="mb-10 btn btn-success pull-<?php echo($settings->dir == 'rtl') ? 'right' : 'left'; ?> m-t-20"><i class="fas fa-check-circle"></i> <?php echo trans('update-values') ?></button>
                </div>
                <div class="col-sm-6">
                    <!-- <div class="input-group mb-1">
                      <input type="text" class="form-control" placeholder="<?php echo trans('search-value') ?>">
                      <div class="input-group-append">
                        <button class="btn btn-success" type="submit"><?php echo trans('search') ?></button>
                      </div>
                    </div> -->
                </div>
              </div>

              <table class="table table-bordered table-striped dataTable">
                <thead>
                  <tr role="row">
                    <th>#</th>
                    <th><?php echo trans('type') ?></th>
                    <th><?php echo trans('info') ?></th>
                    <th><?php echo trans('insert-your-translate-value-here') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i=1; foreach ($language as $lang): ?>
                    <tr class="tr-phrase">
                      <td><?php echo $i; ?></td>
                      <td><span class="badge badge-secondary"><?php echo ucfirst($lang->type); ?></span></td>
                      <td>
                        <p class="mb-0"><b><?php echo trans('label') ?></b>: <?php echo html_escape($lang->label) ?></p>
                        <p class="mb-0"><b><?php echo trans('keyword') ?></b>: <?php echo html_escape($lang->keyword) ?></p>
                      </td>
                      <td width="50%">
                        <textarea name="value<?php echo html_escape($lang->id) ?>" class="form-control"><?php echo html_escape($lang->$value) ?></textarea>
                        <!-- <input type="text" name="value<?php echo html_escape($lang->id) ?>" class="form-control" value="<?php echo html_escape($lang->$value) ?>"> -->
                      </td>
                    </tr>
                  <?php $i++; endforeach ?>

                </tbody>
              </table>

              <input type="hidden" name="lang_type" value="<?php echo html_escape($value) ?>">
              <!-- csrf token -->
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

              <div class="row">
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-success btn-sm pull-<?php echo($settings->dir == 'rtl') ? 'right' : 'left'; ?> m-t-20"><i class="fas fa-check-circle"></i> <?php echo trans('update-values') ?></button>
                </div>
                <div class="col-sm-6">
                    
                </div>
              </div>

            </form>

            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
