

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
                  <h3 class="card-title pt-2"><?php echo trans('edit') ?></h3>
                <?php else: ?>
                  <h3 class="card-title pt-2"><?php echo trans('create-new') ?> </h3>
                <?php endif; ?>

                <div class="card-tools pull-right">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <a href="<?php echo base_url('admin/blog_category') ?>" class="pull-right btn btn-sm btn-secondary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a>
                  <?php else: ?>
                    <a href="#" class="text-right btn btn-sm btn-secondary cancel_btn"> <?php echo trans('categories') ?></a>
                  <?php endif; ?>
                </div>
              </div>

              
                <form id="cat-form" method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/blog_category/add')?>" role="form" novalidate>

                  <div class="card-body">
                    <div class="form-group">
                      <label><?php echo trans('name') ?> <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" required name="name" value="<?php echo html_escape($category[0]['name']); ?>" >
                    </div>
                  </div>

                  <div class="card-footer">
                    <input type="hidden" name="id" value="<?php echo html_escape($category['0']['id']); ?>">
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
                <div class="card-header">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <h3 class="card-title pt-2">Edit Category <a href="<?php echo base_url('admin/blog_category') ?>" class="pull-right btn btn-sm btn-primary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a></h3>
                  <?php else: ?>
                    <h3 class="card-title pt-2"><?php echo trans('categories') ?></h3>
                  <?php endif; ?>

                  <div class="card-tools pull-right">
                   <a href="<?php echo base_url('admin/blog') ?>" class="pull-right btn btn-sm btn-primary"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a>
                   <a href="#" class="pull-right btn btn-sm btn-secondary add_btn"><i class="fa fa-plus"></i> <?php echo trans('create-new') ?></a>
                  </div>
                </div>

                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo trans('name') ?></th>
                                <th><?php echo trans('status') ?></th>
                                <th><?php echo trans('action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $i=1; foreach ($categories as $cat): ?>
                            <tr id="row_<?php echo html_escape($cat->id); ?>">
                                
                                <td><?= $i; ?></td>
                                <td><?php echo html_escape($cat->name); ?></td>
                                <td>
                                  <?php if ($cat->status == 1): ?>
                                    <span class="label label-info"><?php echo trans('active') ?></span>
                                  <?php else: ?>
                                    <span class="label label-danger"><?php echo trans('inactive') ?></span>
                                  <?php endif ?>
                                </td>



                                <td class="actions">

                                  <div class="btn-group">
                                    <button type="button" class="btn btn-tool" data-toggle="dropdown" aria-expanded="false">
                                      <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu" >
                                      <a href="<?php echo base_url('admin/blog_category/edit/'.html_escape($cat->id));?>" class="dropdown-item"><?php echo trans('edit') ?></a>
                                      <a data-val="Category" data-id="<?php echo html_escape($cat->id); ?>" href="<?php echo base_url('admin/blog_category/delete/'.html_escape($cat->id));?>" class="dropdown-item delete_item"><?php echo trans('delete') ?></a>
                                      <?php if ($cat->status == 1): ?>
                                        <a href="<?php echo base_url('admin/blog_category/deactive/'.html_escape($cat->id));?>" class="dropdown-item" data-toggle="tooltip" data-placement="top" title="Deactivate"><?php echo trans('deactivate') ?></a>
                                      <?php else: ?>
                                        <a href="<?php echo base_url('admin/blog_category/active/'.html_escape($cat->id));?>" class="dropdown-item" data-toggle="tooltip" data-placement="top" title="Activate"><?php echo trans('activate') ?></a>
                                      <?php endif ?>
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
