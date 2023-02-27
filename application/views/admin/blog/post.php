
<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <?php $this->load->view('admin/include/breadcrumb'); ?>

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-md-12">

            <!-- add area -->
            <div class="card card card-default add_area <?php if(isset($page_title) && $page_title == "Edit"){echo "d-block";}else{echo "hide";} ?>">
              <div class="card-header">
                <?php if (isset($page_title) && $page_title == "Edit"): ?>
                  <h3 class="card-title pt-2"><?php echo trans('edit') ?></h3>
                <?php else: ?>
                  <h3 class="card-title pt-2"><?php echo trans('create-new') ?> </h3>
                <?php endif; ?>

                <div class="card-tools">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <a href="<?php echo base_url('admin/blog') ?>" class="pull-right btn btn-secondary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a>
                  <?php else: ?>
                    <a href="#" class="text-right btn btn-secondary btn-sm cancel_btn"> <?php echo trans('posts') ?></a>
                  <?php endif; ?>
                </div>
              </div>

              <form id="cat-form" method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/blog/add')?>" role="form" novalidate>
                
                <div class="card-body">

                    <div class="form-group">
                        <label class="control-label" for="example-input-normal"><?php echo trans('category') ?> <span class="text-danger">*</span></label>
                        <select class="form-control" name="category" required>
                            <option value=""><?php echo trans('select') ?></option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo html_escape($category->id); ?>" 
                                  <?php echo ($blog[0]['category_id'] == $category->id) ? 'selected' : ''; ?>>
                                  <?php echo html_escape($category->name); ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <a href="<?php echo base_url('admin/blog_category') ?>" class="text-right btn btn-secondary btn-xs mt-2"><i class="fa fa-plus"></i> <?php echo trans('add-new-category') ?></a>
                    </div>
                  
                    <div class="form-group">
                      <label><?php echo trans('title') ?> <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" required name="title" value="<?php echo html_escape($blog[0]['title']); ?>" >
                    </div>
                 
                    <?php if (isset($page_title) && $page_title != "Edit"): ?>
                    <div class="form-group">
                        <label><?php echo trans('slug') ?></label>
                        <input type="text" class="form-control" name="slug">
                    </div>
                    <?php endif; ?>
                  
                    <div class="form-group">
                        <label><?php echo trans('tags') ?></label>
                        <?php if (isset($page_title) && $page_title == "Edit"): ?>
                          <input type="text" data-role="tagsinput" name="tags[]" value="<?php echo html_escape($tags) ?>" />
                        <?php else: ?>
                          <input type="text" data-role="tagsinput" name="tags[]" placeholder="<?php echo trans('enter-your-tags') ?>" />
                        <?php endif ?>
                    </div>
       
                    <div class="form-group">
                        <label><?php echo trans('description') ?></label>
                        <textarea id="summernote" class="form-control" name="details"><?php echo html_escape($blog[0]['details']); ?></textarea>
                    </div>
                  
                    <div class="form-group">
                        <?php if (isset($page_title) && $page_title == "Edit"): ?>
                            <img src="<?php echo base_url($blog[0]['thumb']) ?>"> <br><br>
                        <?php endif ?>

                        <div class="custom-file w-50 mt-2">
                          <input type="file" class="custom-file-input" name="photo" id="customFileUp">
                          <label class="custom-file-label" for="customFileUp"><?php echo trans('upload-image') ?></label>
                        </div>
                    </div>
                  
                    <div class="form-group clearfix">
                      <label><?php echo trans('status') ?></label><br>

                      <div class="icheck-primary radio radio-inline d-inline mr-4 mt-2">
                        <input type="radio" id="radioPrimary1" value="1" name="status" <?php if($blog[0]['status'] == 1){echo "checked";} ?>>
                        <label for="radioPrimary1"> <?php echo trans('show') ?>
                        </label>
                      </div>

                      <div class="icheck-primary radio radio-inline d-inline">
                        <input type="radio" id="radioPrimary2" value="2" name="status" <?php if($blog[0]['status'] == 2){echo "checked";} ?>>
                        <label for="radioPrimary2"> <?php echo trans('hidden') ?>
                        </label>
                      </div>
                    </div>
                </div>

                <div class="card-footer">
                  <input type="hidden" name="id" value="<?php echo html_escape($blog['0']['id']); ?>">
                  <!-- csrf token -->
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <button type="submit" class="btn btn-primary pull-left">Save Changes</button>
                  <?php else: ?>
                    <button type="submit" class="btn btn-primary pull-left"> Save Post</button>
                  <?php endif; ?>
                </div>


              </form>

            </div>

            <!-- view area -->
            <?php if (isset($page_title) && $page_title != "Edit"): ?>
              <div class="card list_area">
                <div class="card-header">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <h3 class="card-title pt-2"><?php echo trans('edit') ?> <a href="<?php echo base_url('admin/blog') ?>" class="btn btn-primary btn-sm"><i class="fa fa-angle-left"></i> Back</a></h3>
                  <?php else: ?>
                    <h3 class="card-title pt-2"><?php echo trans('posts') ?></h3>
                  <?php endif; ?>

                  <div class="card-tools">
                   <a href="#" class="btn btn-secondary btn-sm add_btn"><i class="fa fa-plus"></i> <?php echo trans('create-new') ?></a>
                  </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap <?php if(count($posts) > 10){echo "datatable";} ?>">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo trans('thumb') ?></th>
                                <th><?php echo trans('title') ?></th>
                                <th><?php echo trans('status') ?></th>
                                <th><?php echo trans('action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $i=1; foreach ($posts as $post): ?>
                            <tr id="row_<?php echo html_escape($post->id); ?>">
                                
                                <td><?= $i; ?></td>
                                <td><img class="w-100px" src="<?php echo base_url($post->thumb) ?>"></td>
                                <td><?php echo html_escape($post->title); ?>
                                </td>
                                <td>
                                  <?php if ($post->status == 1): ?>
                                    <span class="badge badge-success"> <i class="lnib lni-checkmark"></i> <?php echo trans('active') ?></span>
                                  <?php else: ?>
                                    <span class="badge badge-secondary"><i class="fas fa-eye-slash"></i> <?php echo trans('hidden') ?></span>
                                  <?php endif ?>
                                </td>

                                <td class="actions">

                                  <div class="btn-group">
                                    <button type="button" class="btn btn-tool" data-toggle="dropdown" aria-expanded="false">
                                      <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu" >
                                      <a href="<?php echo base_url('admin/blog/edit/'.html_escape($post->id));?>" class="dropdown-item"><?php echo trans('edit') ?></a>
                                      <a data-val="Category" data-id="<?php echo html_escape($post->id); ?>" href="<?php echo base_url('admin/blog/delete/'.html_escape($post->id));?>" class="dropdown-item delete_item"><?php echo trans('delete') ?></a>
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
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      <!-- </div>/.container -->
    </div>
    <!-- /.content -->
</div>

