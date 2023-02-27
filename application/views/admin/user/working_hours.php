<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <?php $this->load->view('admin/include/breadcrumb'); ?>

  <!-- Main content -->
  <section class="content">
    <div class="container">
      <div class="row">

        <?php $this->load->view('admin/user/include/settings_menu.php'); ?>

        <div class="col-lg-9 pl-3">

          <div class="card">
            
            <?php $days = get_days();?>
            <form method="post" class="validate-form" action="<?php echo base_url('admin/settings/set')?>" role="form" enctype="multipart/form-data">

              <div class="card-body">
                  
                <div class="row main_item">
                  <?php $i=1; foreach ($days as $day): ?>
                    
                    <?php $checks=0; $check='';?>
                    <?php foreach ($my_days as $asnday): ?>
                      <?php if ($asnday['day'] == $i) {
                        $check = 'checked';
                        $checks = $asnday['day'];
                        break;
                      } else {
                        $check = '';
                        $checks = 0;
                      }
                      ?>
                    <?php endforeach ?>

                    <div class="item-rows w-100 mb-20">
                      
                      <div class="form-group col-md-12 mb-2">
                          <div class="custom-control custom-switch pt-10">
                              <input type="checkbox" value="<?= $i; ?>" name="day_<?= $i-1; ?>" class="custom-control-input day_option" id="switch-<?= $i;?>" <?php if(!empty($check)){echo html_escape($check);} ?>>
                              <label class="custom-control-label" for="switch-<?= $i;?>"><?php echo trans(strtolower($day)) ?></label>
                          </div>
                      </div>

                      <div class="hour-item mb-2 mt-4 col-md-12 hideable_<?= $i; ?> <?php if(!empty($check)){echo 'd-show';}else{echo "d-hide";} ?>">
                          <div class="row">
                              <div class="col-sm-5 pr-3 mb-2">
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                      </div>
                                      <?php if($this->business->time_format == 'HH'){$mstart = $my_days[$i-1]['start'];}else{$mstart = date("h:i a", strtotime($my_days[$i-1]['start']));} ?>
                                      <input type="text" class="form-control hourpicker" name="start_hour_<?= $i-1; ?>" value="<?php echo html_escape($mstart); ?>" placeholder="<?php echo trans('opening-hour') ?>" autocomplete="off">
                                    </div>
                              </div>

                              <div class="col-sm-5 mb-2">
                                  <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                      </div>
                                      <?php if($this->business->time_format == 'HH'){$mend = $my_days[$i-1]['end'];}else{$mend = date("h:i a", strtotime($my_days[$i-1]['end']));} ?>

                                      <input type="text" class="form-control hourpicker" name="end_hour_<?= $i-1; ?>" value="<?php echo html_escape($mend); ?>" placeholder="<?php echo trans('end-hour') ?>" autocomplete="off">
                                  </div>
                              </div>
                          </div>
                      </div>


                      <?php //if($i == ''): ?>
                      <div class="form-group col-sm-12 mt-3 hideable_<?= $i; ?> <?php if($check == 'checked'){echo 'd-show';}else{echo "d-hide";} ?>">
                        <a href="#" data-id="<?= $i-1; ?>" class="add_time_row"><i class="fa fa-plus-circle"></i> <?php echo trans('add-breaks') ?></a>
                      </div>

                      <div class="col-md-8 mr-auto pl-0">
                        <?php foreach (get_time_by_days($i, $this->business->uid) as $time): ?>
                          <div class="hour-item mb-2 col-md-12 hideable_<?= $i; ?>" id="row_<?= $time->id ?>">
                              <div class="row">
                                  <div class="col-sm-5 pr-3 mb-2">
                                        <div class="input-group">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                                          </div>

                                          <?php if($this->business->time_format == 'HH'){$bstart = $time->start;}else{$bstart = date("h:i a", strtotime($time->start));} ?>

                                          <input type="text" class="form-control form-control-sm timepicker" name="start_time_<?= $i-1; ?>[]" value="<?php echo html_escape($bstart); ?>" placeholder="Start Time" autocomplete="off">
                                        </div>
                                  </div>

                                  <div class="col-sm-5 mb-2">
                                      <div class="input-group">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                                          </div>

                                          <?php if($this->business->time_format == 'HH'){$bend = $time->end;}else{$bend = date("h:i a", strtotime($time->end));} ?>

                                          <input type="text" class="form-control form-control-sm timepicker" name="end_time_<?= $i-1; ?>[]" value="<?php echo html_escape($bend); ?>" placeholder="End Time" autocomplete="off">
                                      </div>
                                  </div>

                                  <div class="col-sm-2 mb-2"><a data-id="<?= $time->id ?>" href="<?php echo base_url('admin/appointment/delete_time/'.$time->id) ?>" class="del_time_row delete_item text-danger"><i class="lnib lni-close"></i></a></div>
                              </div>
                          </div>
                        <?php endforeach ?>

                        <div class="houritem_<?= $i-1; ?> col-md-12"></div>
                      </div>
                      <?php //endif; ?>
                      

                      <div class="day_highliter"></div>
                      <div class="day_divider"></div>
                    </div>
                 
                  <?php $i++; endforeach ?>

                </div>

              </div>

              <div class="card-footer">
                <!-- csrf token -->
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                  
                  <button type="submit" class="btn btn-primary pull-left"><?php echo trans('save-changes') ?></button>
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</div>
