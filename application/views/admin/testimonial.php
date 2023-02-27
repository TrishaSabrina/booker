

<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <?php $this->load->view('admin/include/breadcrumb'); ?>

  <!-- Main content -->
  <div class="content">
    <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="card add_area <?php if(isset($page_title) && $page_title == "Edit"){echo "d-block";}else{echo "hide";} ?>">
              <div class="card-header">
                <?php if (isset($page_title) && $page_title == "Edit"): ?>
                  <h3 class="card-title pt-2"><?php echo trans('edit') ?></h3>
                <?php else: ?>
                  <h3 class="card-title pt-2"><?php echo trans('create-new') ?> </h3>
                <?php endif; ?>

                <div class="card-tools pull-right">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <?php $required = ''; ?>
                    <a href="<?php echo base_url('admin/testimonial') ?>" class="pull-right btn btn-secondary btn-sm mt-15"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a>
                  <?php else: ?>
                    <?php $required = 'required'; ?>
                    <a href="#" class="text-right btn btn-secondary btn-sm cancel_btn"> <?php echo trans('testimonials') ?></a>
                  <?php endif; ?>
                </div>
              </div>

              <form id="cat-form" method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/testimonial/add')?>" role="form" novalidate>
                <div class="card-body">
                    
                    <div class="form-group">
                        <?php if (isset($page_title) && $page_title == "Edit"): ?>
                            <img src="<?php echo base_url($testimonial[0]['thumb']) ?>"> <br><br>
                        <?php endif ?>

                        <div class="custom-file w-50 mt-2">
                          <input type="file" class="custom-file-input" name="photo" id="customFileUp">
                          <label class="custom-file-label" for="customFileUp"><?php echo trans('upload-image') ?></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo trans('customer') ?> <?php echo trans('name') ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" value="<?php echo html_escape($testimonial[0]['name']); ?>" <?php echo html_escape($required); ?>>
                    </div>

                    <div class="form-group">
                        <label><?php echo trans('designation') ?></label>
                        <input type="text" class="form-control" name="designation" value="<?php echo html_escape($testimonial[0]['designation']); ?>">
                    </div>

                    <div class="form-group">
                        <label><?php echo trans('feedback') ?></label>
                        <textarea class="form-control" name="feedback"><?php echo html_escape($testimonial[0]['feedback']); ?></textarea>
                    </div>
                </div>

                <div class="card-footer">
                  <input type="hidden" name="id" value="<?php echo html_escape($testimonial['0']['id']); ?>">
                  <!-- csrf token -->
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <button type="submit" class="btn btn-primary pull-left"> <?php echo trans('save-changes') ?></button>
                  <?php else: ?>
                    <button type="submit" class="btn btn-primary pull-left"> <?php echo trans('save') ?></button>
                  <?php endif; ?>
                </div>

              </form>
            </div>

            <?php if (isset($page_title) && $page_title != "Edit"): ?>
              <div class="card list_area">
                <div class="card-header">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <h3 class="card-title pt-2"><?php echo trans('edit') ?> <a href="<?php echo base_url('admin/testimonial') ?>" class="pull-right btn btn-secondary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a></h3>
                  <?php else: ?>
                    <h3 class="card-title pt-2"><?php echo trans('testimonials') ?> </h3>
                  <?php endif; ?>

                  <div class="card-tools pull-right">
                   <a href="#" class="pull-right btn btn-secondary btn-sm add_btn"><i class="fa fa-plus"></i> <?php echo trans('create-new') ?></a>
                  </div>
                </div>

                 <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap <?php if(count($testimonials) > 10){echo "datatable";} ?>">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo trans('info') ?></th>
                                <th><?php echo trans('feedback') ?></th>
                                <th><?php echo trans('action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $i=1; foreach ($testimonials as $row): ?>
                            <tr id="row_<?php echo ($row->id); ?>">
                                
                                <td><?= $i; ?></td>
                                <td>
                                  <img class="img-circle mr-2" width="40px" src="<?php echo base_url($row->thumb) ?>">
                                  <?php echo html_escape($row->name); ?>
                                </td>

                                <td><span class="small"><?php echo character_limiter($row->feedback, 100); ?></span></td>

                                <td class="actions">
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-tool" data-toggle="dropdown" aria-expanded="false">
                                      <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu" >
                                      <a href="<?php echo base_url('admin/testimonial/edit/'.html_escape($row->id));?>" class="dropdown-item"><?php echo trans('edit') ?></a>
                         
                                      <a data-val="testimonial" data-id="<?php echo html_escape($row->id); ?>" href="<?php echo base_url('admin/testimonial/delete/'.html_escape($row->id));?>" class="dropdown-item delete_item"><?php echo trans('delete') ?></a>
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
