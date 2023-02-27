<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <?php $this->load->view('admin/include/breadcrumb'); ?>

  <!-- Main content -->
  <div class="content">
    <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <?php if (isset($page_title) && $page_title != "Edit"): ?>
              <div class="card list_area">
                <div class="card-header with-border">
                  <h3 class="card-title pt-2"><?php echo trans('codes') ?> (<?php echo count_by_uid($uid); ?>) </h3>
                  <div class="card-tools pull-right">
                   <a href="<?php echo base_url('admin/coupons/plan') ?>" class="pull-right btn btn-sm btn-secondary"><?php echo trans('back') ?></a>
                  </div>
                </div>

                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-nowrap datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo trans('plans') ?></th>
                                <th><?php echo trans('code') ?></th>
                                <th><?php echo trans('used') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $i=1; foreach ($coupons as $row): ?>
                            <tr id="row_<?php echo html_escape($row->id); ?>">
                                <td><?= $i; ?></td>
                                <td>
                                  <p class="mb-0 fs-14 font-weight-bold"><?php echo html_escape($row->name); ?></p>
                                  <p class="mb-0 fs-12"><?php echo html_escape($row->plan_type); ?></p>
                                </td>
                                <td>
                                  <p class="mb-0 badge badge-primary-soft fs-14"><?php echo html_escape($row->code); ?></p>
                                </td>
                                <td>
                                  <?php if ($row->used != 0): ?>
                                      <span class="badge badge-success"><i class="fas fa-check-circle"></i> <?php echo trans('yes') ?></span>
                                  <?php else: ?>
                                    <span class="badge badge-secondary"> <?php echo trans('no') ?></span>
                                  <?php endif ?>
                                </td>
                                <td class="actions d-hide">
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-tool" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i>
                                      </button>
                                      <div class="dropdown-menu dropdown-menu-right" role="menu" >
                                        <a href="<?php echo base_url('admin/coupons/edit/'.html_escape($row->id));?>" class="dropdown-item"><?php echo trans('edit') ?></a>
                                        <a data-val="Category" data-id="<?php echo html_escape($row->id); ?>" href="<?php echo base_url('admin/coupons/delete/'.html_escape($row->id));?>" class="dropdown-item delete_item"><?php echo trans('delete') ?></a>
                                      </div>
                                  </div>

                                </td>
                            </tr>
                            
                          <?php $i++; endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>

              </div>
            <?php endif; ?>
          </div>
      </div>
    </div>
  </div>
</div>
