<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <?php $this->load->view('admin/include/breadcrumb'); ?>

  <!-- Main content -->
  <div class="content">
    <div class="container">
        <div class="row">
          <div class="col-lg-12">

            <div class="card add_area <?php if(isset($page_title) && $page_title == "Edit"){echo "d-block";}else{echo "hide";} ?>">
              <div class="card-header with-border">
                <?php if (isset($page_title) && $page_title == "Edit"): ?>
                  <h3 class="card-title"><?php echo trans('edit') ?></h3>
                <?php else: ?>
                  <h3 class="card-title"><?php echo trans('create-new') ?> </h3>
                <?php endif; ?>

                <div class="card-tools pull-right">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <a href="<?php echo base_url('admin/site_features') ?>" class="pull-right btn btn-secondary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a>
                  <?php else: ?>
                    <a href="#" class="text-right btn btn-secondary cancel_btn btn-sm"><?php echo trans('features') ?></a>
                  <?php endif; ?>
                </div>
              </div>


              <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/site_features/add')?>" role="form" novalidate>
                <div class="card-body">
                  
                    <div class="form-group">
                      <label> <?php echo trans('title') ?> <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" required name="name" value="<?php echo html_escape($service[0]['name']); ?>" >
                    </div>

                    <div class="form-group">
                      <label> <?php echo trans('details') ?> <span class="text-danger">*</span></label>
                      <textarea class="form-control" required name="details" rows="6"><?php echo html_escape($service[0]['details']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label> <?php echo trans('image') ?> <span class="text-danger">*</span></label>
                        <?php if (isset($page_title) && $page_title == "Edit"): ?>
                            <p><img src="<?php echo base_url($service[0]['thumb']) ?>"> </p>
                        <?php endif ?>
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" name="photo" id="customFileUp">
                          <label class="custom-file-label" for="customFileUp"><?php echo trans('upload-image') ?></label>
                        </div>
                    </div>

                    <div class="form-group">
                      <label><?php echo trans('order') ?></label>
                      <input type="number" placeholder="<?php echo trans('example') ?>: 1 2 3" class="form-control" name="orders" value="<?php echo html_escape($service[0]['orders']); ?>" >
                    </div>

                </div>

                <div class="card-footer">
                    <input type="hidden" name="id" value="<?php echo html_escape($service['0']['id']); ?>">
                    <!-- csrf token -->
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

                    <?php if (isset($page_title) && $page_title == "Edit"): ?>
                      <button type="submit" class="btn btn-primary pull-left"><?php echo trans('save-changes') ?></button>
                    <?php else: ?>
                      <button type="submit" class="btn btn-primary pull-left"> <?php echo trans('save') ?></button>
                    <?php endif; ?>
                </div>

              </form>

            </div>


            <?php if (isset($page_title) && $page_title != "Edit"): ?>
              <div class="card list_area">
                <div class="card-header with-border">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <h3 class="card-title pt-2">Edit Service <a href="<?php echo base_url('admin/site_features') ?>" class="pull-right btn btn-sm btn-primary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a></h3>
                  <?php else: ?>
                    <h3 class="card-title pt-2"><?php echo trans('features') ?> </h3>
                  <?php endif; ?>

                  <div class="card-tools pull-right">
                   <a href="#" class="pull-right btn btn-sm btn-secondary add_btn"><i class="fa fa-plus"></i> <?php echo trans('create-new') ?></a>
                  </div>
                </div>

                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo trans('thumb') ?></th>
                                <th><?php echo trans('details') ?></th>
                                <th><?php echo trans('orders') ?></th>
                                <th><?php echo trans('action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $i=1; foreach ($services as $service): ?>
                            <tr id="row_<?php echo html_escape($service->id); ?>">
                                
                                <td><?= $i; ?></td>
                                <td><img width="100px" src="<?php echo base_url($service->thumb) ?>"></td>
                                <td><?php echo html_escape($service->name); ?>
                                  <p class="small"><?php echo character_limiter($service->details, 60); ?></p>
                                </td>

                                <td><span class="badge badge-secondary"><?php echo html_escape($service->orders); ?></span></td>
                                
                                <td class="actions">
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-tool" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i>
                                      </button>
                                      <div class="dropdown-menu dropdown-menu-right" role="menu" >
                                        <a href="<?php echo base_url('admin/site_features/edit/'.html_escape($service->id));?>" class="dropdown-item"><?php echo trans('edit') ?></a>
                                        <a data-val="Category" data-id="<?php echo html_escape($service->id); ?>" href="<?php echo base_url('admin/site_features/delete/'.html_escape($service->id));?>" class="dropdown-item delete_item"><?php echo trans('delete') ?></a>
                                      </div>
                                  </div>

                                </td>
                            </tr>
                            
                          <?php $i++; endforeach; ?>
                        </tbody>
                    </table>
                  
                </div>

              </div>
            <?php endif; ?>

          </div>
      </div>
    </div>
  </div>
</div>
