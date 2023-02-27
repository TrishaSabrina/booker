

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
                    <a href="<?php echo base_url('admin/faq') ?>" class="pull-right btn btn-secondary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a>
                  <?php else: ?>
                    <?php $required = 'required'; ?>
                    <a href="#" class="text-right btn btn-secondary btn-sm cancel_btn"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a>
                  <?php endif; ?>
                </div>
              </div>

              <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/faq/add')?>" role="form" novalidate>
                <div class="card-body">
                    <div class="form-group">
                        <label><?php echo trans('title') ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" value="<?php echo html_escape($faq[0]['title']); ?>" <?php echo html_escape($required); ?>>
                    </div>
                    <div class="form-group">
                        <label><?php echo trans('details') ?></label>
                        <textarea id="ckEditor" class="form-control" name="details" rows="6"><?php echo html_escape($faq[0]['details']); ?></textarea>
                    </div>
                </div>

                <div class="card-footer">
                  <input type="hidden" name="id" value="<?php echo html_escape($faq['0']['id']); ?>">
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
                  <h3 class="card-title pt-2"><?php echo trans('edit') ?> <a href="<?php echo base_url('admin/pages') ?>" class="pull-right btn btn-secondary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a></h3>
                <?php else: ?>
                  <h3 class="card-title pt-2"><?php echo trans('faqs') ?></h3>
                <?php endif; ?>

                <div class="card-tools pull-right">
                   <a href="#" class="pull-right btn btn-secondary btn-sm add_btn"><i class="fa fa-plus"></i> <?php echo trans('create-new') ?></a>
                  </div>
              </div>

              <div class="card-body table-responsive p-0">
                  <table class="table table-hover text-nowrap <?php if(count($faqs) > 10){echo "datatable";} ?>">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th><?php echo trans('title') ?></th>
                              <th><?php echo trans('action') ?></th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $i=1; foreach ($faqs as $row): ?>
                          <tr id="row_<?php echo ($row->id); ?>">
                              
                              <td><?= $i; ?></td>
                              <td>
                                <p class="mb-1"><?php echo html_escape($row->title); ?></p>
                                <p class="mb-0 small"><?php echo character_limiter($row->details, 70); ?></p>
                            </td>

                              <td class="actions">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-tool" data-toggle="dropdown" aria-expanded="false">
                                      <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu" >
                                      <a href="<?php echo base_url('admin/faq/edit/'.html_escape($row->id));?>" class="dropdown-item"><?php echo trans('edit') ?></a>
                                      <a data-val="Category" data-id="<?php echo html_escape($row->id); ?>" href="<?php echo base_url('admin/faq/delete/'.html_escape($row->id));?>" class="dropdown-item delete_item"><?php echo trans('delete') ?></a>
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
