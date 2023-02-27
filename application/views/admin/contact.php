

<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <?php $this->load->view('admin/include/breadcrumb'); ?>

  <!-- Main content -->
  <div class="content">
    <div class="container">
        <div class="row">
          <div class="col-lg-12">

            <div class="card list_area">
              <div class="card-header">
                  <h3 class="card-title pt-2"><?php echo trans('contacts') ?></h3>
              </div>

              <div class="card-body table-responsive p-0">
                  <table class="table table-hover <?php if(count($contacts) > 10){echo "datatable";} ?>">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th><?php echo trans('name') ?></th>
                              <th><?php echo trans('email') ?></th>
                              <th><?php echo trans('message') ?></th>
                              <th><?php echo trans('date') ?></th>
                              <th><?php echo trans('action') ?></th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $i=1; foreach ($contacts as $contact): ?>
                          <tr id="row_<?php echo html_escape($contact->id); ?>">
                              
                              <td><?= $i; ?></td>
                              <td><?php echo html_escape($contact->name); ?></td>
                              <td><?php echo html_escape($contact->email); ?></td>
                              <td><?php echo html_escape($contact->message); ?></td>
                              <td><span class="badge badge-secondary-soft"><i class="fas fa-calendar-alt"></i> <?php echo my_date_show_time($contact->created_at); ?> </span></td>
                              
                              <td class="actions">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-tool" data-toggle="dropdown" aria-expanded="false">
                                      <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu" >
                                      <a data-val="Category" data-id="<?php echo html_escape($contact->id); ?>" href="<?php echo base_url('admin/contact/delete/'.html_escape($contact->id));?>" class="dropdown-item delete_item"><?php echo trans('delete') ?></a>
                                    </div>
                                </div>
                              </td>
                          </tr>
                          
                        <?php $i++; endforeach; ?>
                      </tbody>
                  </table>
              </div>
            </div>

          </div>
        </div>
    </div>
  </div>
</div>

