<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <?php $this->load->view('admin/include/breadcrumb'); ?>

  <!-- Start content -->
  <div class="content">
  	<div class="container">

      <div class="row">

        <div class="col-md-4">

            <?php if (isset($page_title) && $page_title != "Edit"): ?>
            <div class="card input_area">
                <div class="card-header">
                    <h3 class="card-title"><?php echo trans('set-default-language') ?> </h3>
                </div>

                <div class="card-body">
                    <form id="cat-form" method="post" class="validate-form" action="<?php echo base_url('admin/settings/set_language')?>" role="form">
                        <?php $settings = get_settings(); ?>

                        <div class="form-group mb-4">
                            <div class="custom-control custom-switch prefrence-items ml-10">
                              <input type="checkbox" name="enable_multilingual" class="custom-control-input" value="1" id="switch-88" <?php if($settings->enable_multilingual == 1){echo "checked";} ?>>
                              <label class="custom-control-label" for="switch-88"><?php echo trans('multilingual-system') ?></label>
                              <p class="text-muted"><small><?php echo trans('enable-multilingual') ?>.</small></p>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                          <select class=" nice_select wide" name="language">
                            <?php foreach ($languages as $lng): ?>
                              <option value="<?php echo html_escape($lng->id); ?>" <?php echo ($settings->lang == $lng->id) ? 'selected' : ''; ?>><?php echo ucfirst($lng->name); ?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                        <!-- csrf token -->
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                        <button type="submit" class="btn btn-primary pull-left mt-4"> <?php echo trans('update') ?></button>
                    </form>
                </div>
            </div>
            <?php endif; ?>


            <div class="card input_area">
                <div class="card-header">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <h3 class="card-title"><?php echo trans('edit-language') ?> <a href="<?php echo base_url('admin/language') ?>" class="pull-right btn btn-secondary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a></h3>
                  <?php else: ?>
                    <h3 class="card-title"> <?php echo trans('add-new-language') ?> </h3>
                  <?php endif; ?>
                </div>

                <div class="card-body">
                    <form id="cat-form" method="post" class="validate-form" action="<?php echo base_url('admin/language/add')?>" role="form" novalidate>
                       
                        <div class="form-group">
                            <label><?php echo trans('name') ?></label>
                            <input type="text" placeholder="Example: English, Duch" class="form-control" required name="name" value="<?php if(isset($language[0]['name'])){echo html_escape($language[0]['name']);} ?>">
                        </div>

                        <div class="form-group mb-20">
                            <label><?php echo trans('short-form') ?></label>
                            <input type="text" placeholder="Example: en, du" class="form-control" required name="short_name" value="<?php if(isset($language[0]['short_name'])){echo html_escape($language[0]['short_name']);} ?>">
                        </div>

                        <div class="form-group clearfix mt-4">
                          <div class="icheck-primary radio radio-inline d-inline mr-4 mt-2">
                            <input type="radio" id="radioPrimary1" value="ltr" name="text_direction" <?php if(isset($language[0]['text_direction']) && $language[0]['text_direction'] == 'ltr'){echo "checked";} ?> <?php if (isset($page_title) && $page_title != "Edit"){echo "checked";} ?>>
                            <label for="radioPrimary1"> LTR (Left to Right)
                            </label>
                          </div>

                          <div class="icheck-primary radio radio-inline d-inline">
                            <input type="radio" id="radioPrimary2" value="rtl" name="text_direction" <?php if(isset($language[0]['text_direction']) && $language[0]['text_direction'] == 'rtl'){echo "checked";} ?>>
                            <label for="radioPrimary2"> RTL (Right to Left)
                            </label>
                          </div>
                        </div>

                     

                        <input type="hidden" name="id" value="<?php if(isset($language[0]['id'])){echo html_escape($language[0]['id']);} ?>">
                        <input type="hidden" name="lang_name" value="<?php if(isset($language[0]['name'])){echo html_escape($language[0]['name']);} ?>">

                        <!-- csrf token -->
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

                        <?php if (isset($page_title) && $page_title == "Edit"): ?>
                          <button type="submit" class="btn btn-primary pull-left m-t-10"> <?php echo trans('save-changes') ?></button>
                        <?php else: ?>
                          <button type="submit" class="btn btn-primary pull-left m-t-10"> <?php echo trans('save') ?></button>
                        <?php endif; ?>
                        
                    </form>

                </div>
            </div>
        </div>


        <?php if (isset($page_title) && $page_title != "Edit"): ?>

            <div class="col-md-8 list_area">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> <?php echo trans('manage-language') ?> </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 table-responsive scroll">
                                <table class="table table-hover <?php if(count($languages) > 5){echo "datatable";} ?>">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo trans('name') ?></th>
                                            <th><?php echo trans('short-form') ?></th>
                                            <th><?php echo trans('direction') ?></th>
                                            <th><?php echo trans('status') ?></th>
                                            <th><?php echo trans('action') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php $i=1; foreach ($languages as $lang): ?>
                                        <tr id="row_<?php echo html_escape($lang->id); ?>">
                                            
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo ucfirst(html_escape($lang->name)); ?></td>
                                            <td>
                                                <span class="badge badge-secondary-soft fs-15"><?php echo html_escape($lang->short_name); ?></span>
                                            </td>
                                            <td>
                                                <?php if ($lang->text_direction == 'rtl'): ?>
                                                  <span class="badge badge-secondary-soft"><?php echo strtoupper($lang->text_direction); ?></span>
                                                <?php else: ?>
                                                  <span class="badge badge-secondary-soft"><?php echo strtoupper($lang->text_direction); ?></span>
                                                <?php endif ?>
                                            </td>
                                            
                                            <td>
                                              <?php if ($lang->status == 1): ?>
                                                <span class="badge badge-success"><i class="fas fa-check-circle"></i> <?php echo trans('active') ?></span>
                                              <?php else: ?>
                                                <span class="badge badge-danger"><?php echo trans('inactive') ?></span>
                                              <?php endif ?>
                                            </td>

                                    

                                            <td class="actions">

                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-tool" data-toggle="dropdown" aria-expanded="false">
                                                      <i class="fas fa-ellipsis-h"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" role="menu" >
                                                      <a href="<?php echo base_url('admin/language/values/admin/'.html_escape($lang->slug)) ?>" class="dropdown-item"> <?php echo trans('translate-language') ?></a> 

                                                      <span class="dropdown-divider"></span>

                                                      <a href="<?php echo base_url('admin/language/edit/'.html_escape($lang->id));?>" class="dropdown-item"><?php echo trans('edit') ?></a>

                                                      <a data-val="Category" data-id="<?php echo html_escape($lang->id); ?>" href="<?php echo base_url('admin/language/delete/'.html_escape($lang->id));?>" class="dropdown-item delete_item"><?php echo trans('delete') ?></a>

                                                      <?php if ($lang->status == 1): ?>
                                                        <a href="<?php echo base_url('admin/language/deactive/'.html_escape($lang->id));?>" class="dropdown-item"><?php echo trans('deactivate') ?></a>
                                                      <?php else: ?>
                                                        <a href="<?php echo base_url('admin/language/active/'.html_escape($lang->id));?>" class="dropdown-item"><?php echo trans('activate') ?></a>
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
                    </div>
                </div>
            </div>

        <?php endif; ?>

      </div>

    </div>
  </div>
</div>
