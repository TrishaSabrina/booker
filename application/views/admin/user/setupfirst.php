<?php
$activeTab = 'working-hour';
$queryParms = $_SERVER['QUERY_STRING'];
if ($queryParms) {
  $queries = explode("=", $queryParms);
  if ($queries[0] == 'activetab') {
    $activeTab = $queries['1'];
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="<?php echo text_dir(); ?>">

<head>
  <?php $settings = get_settings(); ?>
  <?php $user = get_logged_user($this->session->userdata('id')); ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="Codericks">
  <link rel="icon" href="<?php echo base_url($settings->favicon) ?>">

  <title>
    <?php echo html_escape($settings->site_name); ?>

    <?php if (is_user()) : ?>
      &bull; <?php if (isset($this->business->name)) {
                echo html_escape($this->business->name);
              } ?>
    <?php endif; ?>

    <?php if (isset($page_title)) {
      echo ' &bull; ' . trans(str_slug($page_title));
    } else {
      echo "Dashboard";
    } ?>
  </title>


  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/line-icons/lineicons.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Google Font: DM Sans -->
  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,400i,700&amp;display=swap" rel="stylesheet">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- sweet alert -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/sweet-alert.css">
  <!-- Light/Dark Mode Bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/bootstrap-dark.min.css" id="css_theme_style">
  <!-- tags inputs -->
  <link href="<?php echo base_url() ?>assets/admin/css/bootstrap-tagsinput.css" rel="stylesheet" />
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/select2/css/select2.min.css">
  <!-- nice-select -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/nice-select.css">
  <!-- date & time picker -->
  <link href="<?php echo base_url() ?>assets/admin/css/bootstrap-datepicker.min.css" rel="stylesheet">
  <link href="<?php echo base_url() ?>assets/admin/css/timepicker.min.css" rel="stylesheet">
  <!-- css animation -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/front/css/aos.css">
  <!-- fullcalendar -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/fullcalendar-main.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/summernote/summernote-bs4.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/bootstrap-colorpicker.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/admin_default.css?var=<?= settings()->version ?>&time=<?= time(); ?>">

  <?php if (isset($page_title) && $page_title == 'Holidays') : ?>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/holiday.css">
  <?php endif; ?>


  <?php if (settings()->layout == 1) : ?>
    <link href="<?php echo base_url() ?>assets/admin/css/admin_light.css" rel="stylesheet">
  <?php endif ?>

  <?php if (text_dir() == 'rtl') : ?>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/bootstrap-rtl.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/custom-rtl.css">
  <?php endif ?>

  <script type="text/javascript">
    var csrf_token = '<?= $this->security->get_csrf_hash(); ?>';
    var token_name = '<?= $this->security->get_csrf_token_name(); ?>'
  </script>

  <?php if (settings()->enable_captcha == 1 && settings()->captcha_site_key != '') : ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>
  <?php endif; ?>

</head>

<body class="hold-transition sidebar-mini" data-theme-style="light">

  <div class="wrapper <?php if (settings()->site_info == 3) {
                        echo "d-none";
                      } ?>">
    <div class="content-wrapper">

      <!-- Content Header (Page header) -->

      <!-- Main content -->
      <section class="content">
        <div class="container">
          <div class="col-lg-12 pt-5">
            <div>
              <h3>Hi</h3>
              <h1>Welcome to Harcomia Booking Service</h1> <br>
              <h6 class="text-gray">Please take few second for fill out this form, is mandatory</h6>
            </div>
          </div>
          <div class="col-lg-12 pt-4">
            <div class="card">
              <div class="">
                <div class="row">
                  <div class="col-md-3">
                    <div class="card-body">
                      <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link <?php echo $activeTab == 'working-hour' ? 'active' : ''; ?>" id="working-hour-tab" data-toggle="tab" href="#working-hour" role="tab" aria-controls="working-hour" aria-selected="true">
                            <i class="lni lni-cog mr-1"></i> Working Hour
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link <?php echo $activeTab == 'staff' ? 'active' : ''; ?>" id="staff-tab" data-toggle="tab" href="#staff" role="tab" aria-controls="staff" aria-selected="true">
                            <i class="lni lni-cog mr-1"></i> <?php echo trans('staff') ?>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link <?php echo $activeTab == 'location' ? 'active' : ''; ?>" id="location-tab" data-toggle="tab" href="#location" role="tab" aria-controls="location" aria-selected="true">
                            <i class="lni lni-cog mr-1"></i> <?php echo trans('location') ?>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link <?php echo $activeTab == 'services' ? 'active' : ''; ?>" id="services-tab" data-toggle="tab" href="#services" role="tab" aria-controls="services" aria-selected="true">
                            <i class="lni lni-cog mr-1"></i> <?php echo trans('services') ?>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>

                  <!-- col-md-4 -->
                  <div class="col-md-9">
                    <div class="tab-content custom card-body" id="myTabContent">
                      <!-- apprance tab -->
                      <div class="tab-pane fade show <?php echo $activeTab == 'working-hour' ? 'active' : ''; ?>" id="working-hour" role="tabpanel" aria-labelledby="working-hour-tab">
                        <?php $days = get_days(); ?>
                        <form method="post" class="validate-form" action="<?php echo base_url('admin/settings/set') ?>" role="form" enctype="multipart/form-data">
                          <input type="hidden" name="setupfirst" value="setupfirst" />
                          <div class="card-body">

                            <div class="row main_item">
                              <?php $i = 1;
                              foreach ($days as $day) : ?>

                                <?php $checks = 0;
                                $check = ''; ?>
                                <?php foreach ($my_days as $asnday) : ?>
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
                                      <input type="checkbox" value="<?= $i; ?>" name="day_<?= $i - 1; ?>" class="custom-control-input day_option" id="switch-<?= $i; ?>" <?php if (!empty($check)) {
                                                                                                                                                                            echo html_escape($check);
                                                                                                                                                                          } ?>>
                                      <label class="custom-control-label" for="switch-<?= $i; ?>"><?php echo trans(strtolower($day)) ?></label>
                                    </div>
                                  </div>

                                  <div class="hour-item mb-2 mt-4 col-md-12 hideable_<?= $i; ?> <?php if (!empty($check)) {
                                                                                                  echo 'd-show';
                                                                                                } else {
                                                                                                  echo "d-hide";
                                                                                                } ?>">
                                    <div class="row">
                                      <div class="col-sm-5 pr-3 mb-2">
                                        <div class="input-group">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                                          </div>
                                          <?php if ($this->business->time_format == 'HH') {
                                            $mstart = $my_days[$i - 1]['start'];
                                          } else {
                                            $mstart = date("h:i a", strtotime($my_days[$i - 1]['start']));
                                          } ?>
                                          <input type="text" class="form-control hourpicker" name="start_hour_<?= $i - 1; ?>" value="<?php echo html_escape($mstart); ?>" placeholder="<?php echo trans('opening-hour') ?>" autocomplete="off">
                                        </div>
                                      </div>

                                      <div class="col-sm-5 mb-2">
                                        <div class="input-group">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                                          </div>
                                          <?php if ($this->business->time_format == 'HH') {
                                            $mend = $my_days[$i - 1]['end'];
                                          } else {
                                            $mend = date("h:i a", strtotime($my_days[$i - 1]['end']));
                                          } ?>

                                          <input type="text" class="form-control hourpicker" name="end_hour_<?= $i - 1; ?>" value="<?php echo html_escape($mend); ?>" placeholder="<?php echo trans('end-hour') ?>" autocomplete="off">
                                        </div>
                                      </div>
                                    </div>
                                  </div>


                                  <?php //if($i == ''): 
                                  ?>
                                  <div class="form-group col-sm-12 mt-3 hideable_<?= $i; ?> <?php if ($check == 'checked') {
                                                                                              echo 'd-show';
                                                                                            } else {
                                                                                              echo "d-hide";
                                                                                            } ?>">
                                    <a href="#" data-id="<?= $i - 1; ?>" class="add_time_row"><i class="fa fa-plus-circle"></i> <?php echo trans('add-breaks') ?></a>
                                  </div>

                                  <div class="col-md-8 mr-auto pl-0">
                                    <?php foreach (get_time_by_days($i, $this->business->uid) as $time) : ?>
                                      <div class="hour-item mb-2 col-md-12 hideable_<?= $i; ?>" id="row_<?= $time->id ?>">
                                        <div class="row">
                                          <div class="col-sm-5 pr-3 mb-2">
                                            <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                              </div>

                                              <?php if ($this->business->time_format == 'HH') {
                                                $bstart = $time->start;
                                              } else {
                                                $bstart = date("h:i a", strtotime($time->start));
                                              } ?>

                                              <input type="text" class="form-control form-control-sm timepicker" name="start_time_<?= $i - 1; ?>[]" value="<?php echo html_escape($bstart); ?>" placeholder="Start Time" autocomplete="off">
                                            </div>
                                          </div>

                                          <div class="col-sm-5 mb-2">
                                            <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                              </div>

                                              <?php if ($this->business->time_format == 'HH') {
                                                $bend = $time->end;
                                              } else {
                                                $bend = date("h:i a", strtotime($time->end));
                                              } ?>

                                              <input type="text" class="form-control form-control-sm timepicker" name="end_time_<?= $i - 1; ?>[]" value="<?php echo html_escape($bend); ?>" placeholder="End Time" autocomplete="off">
                                            </div>
                                          </div>

                                          <div class="col-sm-2 mb-2"><a data-id="<?= $time->id ?>" href="<?php echo base_url('admin/appointment/delete_time/' . $time->id) ?>" class="del_time_row delete_item text-danger"><i class="lnib lni-close"></i></a></div>
                                        </div>
                                      </div>
                                    <?php endforeach ?>

                                    <div class="houritem_<?= $i - 1; ?> col-md-12"></div>
                                  </div>
                                  <?php //endif; 
                                  ?>


                                  <div class="day_highliter"></div>
                                  <div class="day_divider"></div>
                                </div>

                              <?php $i++;
                              endforeach ?>

                            </div>

                          </div>

                          <div class="card-footer">
                            <!-- csrf token -->
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                            <button type="submit" class="btn btn-primary pull-left"><?php echo trans('save-changes') ?></button>
                          </div>

                        </form>
                      </div>
                      <div class="tab-pane fade show <?php echo $activeTab == 'staff' ? 'active' : ''; ?>" id="staff" role="tabpanel" aria-labelledby="staff-tab">
                        <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/staff/add') ?>" role="form" novalidate>
                          <input type="hidden" name="setupfirstStaff" value="setupfirstStaff" />
                          <div class="form-group">
                            <?php if (isset($page_title) && $page_title == "Edit") : ?>
                              <img width="100px" class="img-thumbnail" src="<?php echo base_url($staff[0]['thumb']) ?>"> <br><br>
                            <?php endif ?>

                            <div class="custom-file w-50 mt-1">
                              <input type="file" class="custom-file-input" name="photo" id="customFileUp">
                              <label class="custom-file-label" for="customFileUp"><?php echo trans('upload-image') ?></label>
                              <p class="text-muted mt-1 fs-12 small"><i class="fas fa-info-circle"></i> <?php echo trans('for-better-view-use') ?> 200 x 200px</p>
                            </div>
                          </div>

                          <div class="form-group">
                            <label><?php echo trans('name') ?> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" required name="name" value="<?php if (isset($staff[0]['name'])) {
                                                                                                  echo html_escape($staff[0]['name']);
                                                                                                } ?>">
                          </div>


                          <div class="form-group">
                            <label><?php echo trans('email') ?> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" required name="email" placeholder="<?php echo trans('enter-email-for-username') ?>" value="<?php if (isset($staff[0]['email'])) {
                                                                                                                                                                  echo html_escape($staff[0]['email']);
                                                                                                                                                                } ?>">
                          </div>


                          <div class="form-group">
                            <label class="control-label" for="example-input-normal"><?php echo trans('location') ?> <span class="text-danger"><?php if ($this->business->enable_location == 1) {
                                                                                                                                                echo "*";
                                                                                                                                              } ?></span></label>
                            <?php if (isset($staff_locations)) {
                              $staff_location = $staff_locations[0]->location_id;
                            } else {
                              $staff_location = 0;
                            } ?>
                            <select class="form-control custom-select location" name="location_id" <?php if ($this->business->enable_location == 1) {
                                                                                                      echo "required";
                                                                                                    } ?>>
                              <option value=""><?php echo trans('select') ?></option>
                              <?php foreach ($locations as $location) : ?>
                                <option value="<?php echo html_escape($location->id); ?>" <?php if ($location->id == $staff_location) {
                                                                                            echo "selected";
                                                                                          } ?>>
                                  <?php echo html_escape($location->name); ?>
                                </option>
                              <?php endforeach ?>
                            </select>
                          </div>


                          <?php if (isset($page_title) && $page_title != "Edit") : ?>
                            <div class="sub_area d-hide">
                              <div class="select2-blue">
                                <div class="form-group">
                                  <label class="control-label" for="example-input-normal"><?php echo trans('branches') ?> </label>
                                  <select class="select2 sub_location" name="sub_location_id[]" multiple="multiple" style="width: 100%;">

                                  </select>
                                </div>
                              </div>
                            </div>
                          <?php else : ?>
                            <div class="sub_area <?php if (empty($staff_sub_locations)) {
                                                    echo "d-hide";
                                                  } ?>">
                              <div class="select2-blue">
                                <div class="form-group">
                                  <label class="control-label" for="example-input-normal"><?php echo trans('branches') ?> </label>
                                  <select class="select2 sub_location" name="sub_location_id[]" multiple="multiple" style="width: 100%;">
                                    <?php foreach ($staff_sub_locations as $staff_sub) : ?>
                                      <?php foreach ($staff_locations as $staff_loc) : ?>
                                        <?php if ($staff_loc->sub_location_id == $staff_sub->id) : ?>
                                          <?php $selected = 'selected';
                                          break; ?>
                                        <?php else : ?>
                                          <?php $selected = ''; ?>
                                        <?php endif ?>
                                      <?php endforeach ?>
                                      <option <?php echo $selected ?> value="<?php echo $staff_sub->id ?>"><?php echo $staff_sub->name ?></option>
                                    <?php endforeach ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                          <?php endif; ?>


                          <div class="form-group">
                            <label><?php echo trans('password') ?></label>
                            <input type="password" class="form-control" name="password" placeholder="<?php echo trans('set-or-reset-password') ?>" value="">
                          </div>

                          <div class="form-group">
                            <label><?php echo trans('phone') ?></label>
                            <input type="text" class="form-control" name="phone" value="<?php if (isset($staff[0]['phone'])) {
                                                                                          echo html_escape($staff[0]['phone']);
                                                                                        } ?>" placeholder="<?php echo trans('enter-phone-number-with-dial-code') ?> (Ex. +16100000000)">
                          </div>

                          <div class="form-group clearfix">
                            <label><?php echo trans('dtatus') ?></label><br>

                            <div class="icheck-primary radio radio-inline d-inline mr-4 mt-2">
                              <input type="radio" id="radioPrimary1" value="1" required name="status" <?php if (isset($staff[0]['status']) && $staff[0]['status'] == 1) {
                                                                                                        echo "checked";
                                                                                                      } ?> <?php if (isset($page_title) && $page_title != "Edit") {
                                                                                                              echo "checked";
                                                                                                            } ?>>
                              <label for="radioPrimary1"> <?php echo trans('active') ?>
                              </label>
                            </div>

                            <div class="icheck-primary radio radio-inline d-inline">
                              <input type="radio" id="radioPrimary2" value="2" required name="status" <?php if (isset($staff[0]['status']) && $staff[0]['status'] == 2) {
                                                                                                        echo "checked";
                                                                                                      } ?>>
                              <label for="radioPrimary2"> <?php echo trans('hidden') ?>
                              </label>
                            </div>
                          </div>

                          <div class="card-footer">
                            <input type="hidden" name="id" value="<?php if (isset($staff[0]['id'])) {
                                                                    echo html_escape($staff[0]['id']);
                                                                  } ?>">
                            <!-- csrf token -->
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                            <?php if (isset($page_title) && $page_title == "Edit") : ?>
                              <button type="submit" class="btn btn-primary pull-left"><?php echo trans('save-changes') ?></button>
                            <?php else : ?>
                              <button type="submit" class="btn btn-primary pull-left"> <?php echo trans('save') ?></button>
                            <?php endif; ?>
                          </div>
                        </form>
                      </div>
                      <div class="tab-pane fade show <?php echo $activeTab == 'location' ? 'active' : ''; ?>" id="location" role="tabpanel" aria-labelledby="location-tab">
                        <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/location/add') ?>" role="form" novalidate>
                            <input type="hidden" name="setupfirstLocation" value="setupfirstLocation" />
                            <div class="card-body">
                            <div class="form-group">
                              <label><?php echo trans('name') ?> <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" required name="name" value="<?php if (isset($location[0]['name'])) {
                                                                                                    echo html_escape($location[0]['name']);
                                                                                                  } ?>">
                            </div>

                            <div class="form-group">
                              <label><?php echo trans('phone') ?></label>
                              <input type="text" class="form-control" name="phone" value="<?php if (isset($location[0]['phone'])) {
                                                                                            echo html_escape($location[0]['phone']);
                                                                                          } ?>">
                            </div>

                            <div class="form-group">
                              <label><?php echo trans('address') ?></label>
                              <textarea id="summernote" class="form-control" name="address"><?php if (isset($location[0]['address'])) {
                                                                                              echo html_escape($location[0]['address']);
                                                                                            } ?></textarea>
                            </div>

                            <div class="form-group clearfix">
                              <label><?php echo trans('dtatus') ?></label><br>
                              <div class="icheck-primary radio radio-inline d-inline mr-4 mt-2">
                                <input type="radio" id="locationradioPrimary1" value="1" required name="status" <?php if (isset($location[0]['status']) && $location[0]['status'] == 1) {
                                                                                                          echo "checked";
                                                                                                        } ?> <?php if (isset($page_title) && $page_title != "Edit") {
                                                                                                                echo "checked";
                                                                                                              } ?>>
                                <label for="locationradioPrimary1"> <?php echo trans('active') ?>
                                </label>
                              </div>

                              <div class="icheck-primary radio radio-inline d-inline">
                                <input type="radio" id="locationradioPrimary2" value="2" required name="status" <?php if (isset($location[0]['status']) && $location[0]['status'] == 2) { echo "checked";} ?>>
                                <label for="locationradioPrimary2"> <?php echo trans('hidden') ?></label>
                              </div>
                            </div>

                          </div>

                          <div class="card-footer">
                            <input type="hidden" name="id" value="<?php if (isset($location[0]['id'])) {
                                                                    echo html_escape($location[0]['id']);
                                                                  } ?>">
                            <!-- csrf token -->
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                            <?php if (isset($page_title) && $page_title == "Edit") : ?>
                              <button type="submit" class="btn btn-primary pull-left"><?php echo trans('save-changes') ?></button>
                            <?php else : ?>
                              <button type="submit" class="btn btn-primary pull-left"> <?php echo trans('save') ?></button>
                            <?php endif; ?>
                          </div>

                        </form>
                      </div>
                      <div class="tab-pane fade show <?php echo $activeTab == 'services' ? 'active' : ''; ?>" id="services" role="tabpanel" aria-labelledby="services-tab">
                        <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/services/add') ?>" role="form" novalidate>
                          <input type="hidden" name="setupfirstService" value="setupfirstService" />
                          <div class="card-body">

                            <div class="form-group">
                              <label><?php echo trans('service-name') ?> <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" required name="name" value="<?php if (isset($service[0]['name'])) {
                                                                                                    echo html_escape($service[0]['name']);
                                                                                                  } ?>">
                            </div>

                            <div class="form-group">
                              <label><?php echo trans('service-image') ?> <span class="text-danger">*</span></label>
                              <?php if (isset($page_title) && $page_title == "Edit") : ?>
                                <p><img width="150px" src="<?php echo base_url($service[0]['image']) ?>">
                                <p>
                                <?php endif ?>
                                <div class="custom-file">
                                  <input type="file" class="custom-file-input" name="photo" id="customFileUp">
                                  <label class="custom-file-label" for="customFileUp"><?php echo trans('upload-image') ?></label>
                                </div>
                            </div>


                            <div class="form-group">
                              <label><?php echo trans('assign-staffs') ?> </label>
                              <div class="select2-blue">
                                <select name="staffs[]" class="select2 w-100" multiple="multiple" data-placeholder="<?php echo trans('select-staffs') ?>" data-dropdown-css-class="select2-blue" style="width: 100%;">
                                  <?php $selected = ''; ?>
                                  <?php foreach ($staffs as $staff) : ?>

                                    <?php if (isset($page_title) && $page_title == 'Edit') : ?>
                                      <?php $assign_staffs = json_decode($service[0]['staffs']); ?>
                                      <?php foreach ($assign_staffs as $asn_staff) : ?>
                                        <?php if ($asn_staff == $staff->id) : ?>
                                          <?php $selected = 'selected';
                                          break; ?>
                                        <?php else : ?>
                                          <?php $selected = ''; ?>
                                        <?php endif ?>
                                      <?php endforeach ?>
                                    <?php endif ?>

                                    <option <?php echo html_escape($selected); ?> value="<?php echo html_escape($staff->id) ?>"><?php echo html_escape($staff->name) ?></option>
                                  <?php endforeach ?>
                                </select>
                              </div>
                            </div>

                            <div class="row mt-4 mb-2">

                              <div class="col-md-6 <?php if ($this->business->enable_category == 0) {
                                                      echo "hide";
                                                    } ?>">
                                <div class="form-group">
                                  <label class="control-label" for="example-input-normal"><?php echo trans('category') ?> <span class="text-danger">*</span></label>
                                  <select class="form-control" name="category_id" <?php if ($this->business->enable_category == 1) {
                                                                                    echo "required";
                                                                                  } ?>>
                                    <option value=""><?php echo trans('select') ?></option>
                                    <?php foreach ($categories as $category) : ?>
                                      <option value="<?php echo html_escape($category->id); ?>" <?php echo (isset($service[0]['category_id']) && $service[0]['category_id'] == $category->id) ? 'selected' : ''; ?>>
                                        <?php echo html_escape($category->name); ?>
                                      </option>
                                    <?php endforeach ?>
                                  </select>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-group">
                                  <label><?php echo trans('price') ?> <span class="text-danger">*</span></label>
                                  <div class="input-group">
                                    <input type="text" class="form-control" name="price" value="<?php if (isset($service[0]['price'])) {
                                                                                                  echo html_escape($service[0]['price']);
                                                                                                } ?>" required>
                                    <div class="input-group-append">
                                      <span class="input-group-text"><?php echo html_escape($this->business->currency_symbol) ?></span>
                                    </div>
                                  </div>
                                  <p class="text-muted small pt-2"><i class="fas fa-info-circle"></i> <?php echo trans('set-0-for-free') ?></p>
                                </div>
                              </div>

                              <div class="col-md-6 d-hide">
                                <div class="form-group">
                                  <label><?php echo trans('capacity') ?> <span class="text-danger">*</span></label>
                                  <div class="input-group">
                                    <!-- <input type="number" class="form-control" name="capacity" value="<?php //if(isset($service[0]['capacity'])){echo html_escape($service[0]['capacity']);} 
                                                                                                          ?>" required> -->
                                    <input type="number" class="form-control" name="capacity" value="-1">
                                    <div class="input-group-append">
                                      <span class="input-group-text"><?php echo trans('person') ?></span>
                                    </div>
                                  </div>
                                  <p class="text-muted small pt-2"><i class="fas fa-info-circle"></i> <?php echo trans('set-1-for-unlimited') ?></p>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-group">
                                  <label><?php echo trans('duration') ?> <span class="text-danger">*</span></label>
                                  <div class="input-group">
                                    <input type="number" class="form-control cus-ra-right" name="duration" value="<?php if (isset($service[0]['duration'])) {
                                                                                                                    echo html_escape($service[0]['duration']);
                                                                                                                  } ?>" required>

                                    <div>
                                      <select class="form-control cus-ra-left" name="duration_type">
                                        <option value="minute" <?php if ($service[0]['duration_type'] == 'minute') {
                                                                  echo "selected";
                                                                } ?> <?php if (isset($page_title) && $page_title != "Edit") {
                                                                        echo "selected";
                                                                      } ?>><?php echo trans('minute') ?></option>
                                        <option value="hour" <?php if ($service[0]['duration_type'] == 'hour') {
                                                                echo "selected";
                                                              } ?>><?php echo trans('hour') ?></option>
                                        <!-- <option value="day" <?php //if($service[0]['duration_type'] == 'day'){echo "selected";} 
                                                                  ?>><?php //echo trans('day') 
                                                                      ?></option> -->
                                      </select>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-6 hide">
                                <div class="form-group">
                                  <label><?php echo trans('order') ?></label>
                                  <input type="number" placeholder="Ex: 1 2 3" class="form-control" name="orders" value="<?php if (isset($service[0]['orders'])) {
                                                                                                                            echo html_escape($service[0]['orders']);
                                                                                                                          } ?>">
                                </div>
                              </div>

                            </div>


                            <!-- virtual meeting -->
                            <?php if (check_feature_access('zoom-meeting') == TRUE) : ?>
                              <div class="form-group">
                                <div class="icheck-success d-inline">
                                  <input type="checkbox" id="checkboxPrimary2" name="allow_zoom" class="allow_zoom" value="1" <?php if (!empty($service[0]['zoom_link'])) {
                                                                                                                                echo 'checked';
                                                                                                                              } ?>>
                                  <label for="checkboxPrimary2"> <?php echo trans('allow-zoom-meeting') ?></span>
                                  </label>
                                </div>
                              </div>

                              <div class="form-group link_area d-<?php if (!empty($service[0]['zoom_link'])) {
                                                                    echo 'show';
                                                                  } else {
                                                                    echo 'hide';
                                                                  } ?>">
                                <label><?php echo trans('zoom-invitation-link') ?></label>
                                <input type="text" placeholder="" class="form-control" name="zoom_link" value="<?php if (isset($service[0]['zoom_link'])) {
                                                                                                                  echo html_escape($service[0]['zoom_link']);
                                                                                                                } ?>">
                              </div>


                              <div class="form-group">
                                <div class="icheck-success d-inline">
                                  <input type="checkbox" id="checkboxPrimary3" name="allow_gmeet" class="allow_gmeet" value="1" <?php if (!empty($service[0]['google_meet'])) {
                                                                                                                                  echo 'checked';
                                                                                                                                } ?>>
                                  <label for="checkboxPrimary3"> <?php echo trans('allow-google-meet') ?></span>
                                  </label>
                                </div>
                              </div>

                              <div class="form-group toggle_area d-<?php if (!empty($service[0]['google_meet'])) {
                                                                      echo 'show';
                                                                    } else {
                                                                      echo 'hide';
                                                                    } ?>">
                                <label><?php echo trans('google-meet-link') ?></label>
                                <input type="text" placeholder="" class="form-control" name="google_meet" value="<?php if (isset($service[0]['google_meet'])) {
                                                                                                                    echo html_escape($service[0]['google_meet']);
                                                                                                                  } ?>">
                              </div>
                            <?php endif; ?>


                            <div class="form-group">
                              <label><?php echo trans('details') ?></label>
                              <textarea id="summernote" class="form-control" name="details"><?php if (isset($service[0]['details'])) {
                                                                                              echo html_escape($service[0]['details']);
                                                                                            } ?></textarea>
                            </div>



                            <div class="form-group clearfix">
                              <label><?php echo trans('status') ?></label><br>

                              <div class="icheck-primary radio radio-inline d-inline mr-4 mt-2">
                                <input type="radio" id="radioPrimary3" value="1" name="status" <?php if (isset($service[0]['status']) && $service[0]['status'] == 1) {
                                                                                                  echo "checked";
                                                                                                } ?> <?php if (isset($page_title) && $page_title != "Edit") {
                                                                                                        echo "checked";
                                                                                                      } ?>>
                                <label for="radioPrimary3"> <?php echo trans('show') ?>
                                </label>
                              </div>

                              <div class="icheck-primary radio radio-inline d-inline">
                                <input type="radio" id="radioPrimary4" value="2" name="status" <?php if (isset($service[0]['status']) && $service[0]['status'] == 2) {
                                                                                                  echo "checked";
                                                                                                } ?>>
                                <label for="radioPrimary4"> <?php echo trans('hide') ?>
                                </label>
                              </div>
                            </div>

                          </div>

                          <div class="card-footer">
                            <input type="hidden" name="id" value="<?php if (isset($service[0]['id'])) {
                                                                    echo html_escape($service[0]['id']);
                                                                  } ?>">
                            <!-- csrf token -->
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                            <?php if (isset($page_title) && $page_title == "Edit") : ?>
                              <button type="submit" class="btn btn-primary pull-left"> <?php echo trans('save-changes') ?></button>
                            <?php else : ?>
                              <button type="submit" class="btn btn-primary pull-left"> <?php echo trans('save') ?></button>
                            <?php endif; ?>
                          </div>

                        </form>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- Footer -->

    <?php include APPPATH . 'views/include/js_msg_list.php'; ?>

    <?php $success = $this->session->flashdata('msg'); ?>
    <?php $error = $this->session->flashdata('error'); ?>
    <input type="hidden" id="success" value="<?php if (isset($success)) {
                                                echo html_escape($success);
                                              } ?>">
    <input type="hidden" id="error" value="<?php if (isset($error)) {
                                              echo html_escape($error);
                                            } ?>">
    <input type="hidden" id="lc" value="<?php echo strlen(settings()->ind_code); ?>">
    <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
    <?php echo $this->session->unset_userdata('msg');
    $this->session->unset_userdata('error'); ?>

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
        <?php echo trans('version') ?> <?php echo html_escape(settings()->version) ?>
      </div>
      <!-- Default to the left -->
      <strong><?php echo trans('copyright') ?> &copy; <?php echo date('Y') ?> <?php echo trans('all-rights-reserved') ?>.
    </footer>
  </div>
  <!-- ./wrapper -->


  <!-- jQuery -->
  <script src="<?php echo base_url() ?>assets/admin/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url() ?>assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables -->
  <script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
  <script src="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>


  <!-- Admin App -->
  <script src="<?php echo base_url() ?>assets/admin/js/admin.js?var=<?= settings()->version ?>&time=<?= time(); ?>"></script>

  <script src="<?php echo base_url() ?>assets/admin/js/validation.js"></script>

  <script src="<?php echo base_url() ?>assets/admin/js/sweet-alert.min.js"></script>
  <script src="<?php echo base_url() ?>assets/admin/js/bootstrap-tagsinput.min.js"></script>

  <!-- select2 js -->
  <script src="<?php echo base_url() ?>assets/admin/plugins/select2/js/select2.full.min.js"></script>
  <!-- nice select js -->
  <script src="<?php echo base_url() ?>assets/admin/js/nice-select.min.js"></script>
  <script src="<?php echo base_url() ?>assets/admin/js/tata.js"></script>

  <!-- date & time picker -->
  <script src="<?php echo base_url() ?>assets/admin/js/bootstrap-datepicker.min.js"></script>
  <script src="<?php echo base_url() ?>assets/admin/js/timepicker.min.js"></script>
  <!-- animation js -->
  <script src="<?php echo base_url() ?>assets/front/js/aos.js"></script>

  <!-- bs-custom-file-input -->
  <script src="<?php echo base_url() ?>assets/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <!-- Summernote -->
  <script src="<?php echo base_url() ?>assets/admin/plugins/summernote/summernote-bs4.min.js"></script>

  <script src="<?php echo base_url() ?>assets/admin/js/jquery-ui.min.js"></script>
  <script src="<?php echo base_url() ?>assets/admin/js/bootstrap-colorpicker.min.js"></script>


  <!-- stripe js -->
  <?php include 'stripe-js.php'; ?>


  <!-- chart js -->
  <?php if (isset($page) && $page == 'Dashboard') : ?>
    <?php $this->load->view('admin/include/charts'); ?>
  <?php elseif (isset($page) && $page == 'Reports') : ?>
    <?php $this->load->view('admin/include/user-charts'); ?>
  <?php endif ?>

  <!-- calendar js -->
  <?php if (isset($page_title) && $page_title == 'Calendars') : ?>
    <?php include 'calendar-js.php'; ?>
  <?php endif ?>

  <script type="text/javascript">
    $(document).ready(function() {

      //Colorpicker
      $('.colorpicker').colorpicker();

      $('.default').click(function() {
        $('.default').not($(this)).removeClass('active');
        $(this).toggleClass('active').next().find('.sub-table-wrap').slideToggle();
        $(".toggle-row").not($(this).next()).find('.sub-table-wrap').slideUp('fast');
      });

      //$('[data-toggle="tooltip"]').tooltip();  

      $(".datepicker").datepicker({
        dateFormat: 'yy-mm-dd'
      });

      $.datepicker.regional['en'] = {
        clearText: 'Clear',
        clearStatus: '',
        closeText: 'Close',
        closeStatus: 'Close without modifying',
        prevStatus: 'See previous month',
        nextStatus: 'See next month',
        currentText: 'Current',
        currentStatus: 'See current month',
        monthNames: ['<?php echo trans('january') ?>', '<?php echo trans('february') ?>', '<?php echo trans('march') ?>', '<?php echo trans('april') ?>', '<?php echo trans('may') ?>', '<?php echo trans('june') ?>',
          '<?php echo trans('july') ?>', '<?php echo trans('august') ?>', '<?php echo trans('september') ?>', '<?php echo trans('october') ?>', '<?php echo trans('november') ?>', '<?php echo trans('december') ?>'
        ],
        monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
          'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ],
        monthStatus: 'See another month',
        yearStatus: 'See another year',
        weekHeader: 'Sm',
        weekStatus: '',
        dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        dayNamesMin: ['<?php echo trans('su') ?>', '<?php echo trans('mo') ?>', '<?php echo trans('tu') ?>', '<?php echo trans('we') ?>', '<?php echo trans('th') ?>', '<?php echo trans('fr') ?>', '<?php echo trans('sa') ?>'],
        dayStatus: 'Use DD as the first day of the week',
        dateStatus: 'Choose the DD, MM of',
        firstDay: 0,
        initStatus: 'Choose date',
        isRTL: false
      };

      $.datepicker.setDefaults($.datepicker.regional['en']);

    });
  </script>


  <script type="text/javascript">
    <?php if (isset($this->business->time_format) && $this->business->time_format == 'HH') : ?>
      $(document).on("focusin", ".timepicker", function() {
        $('input.timepicker').timepicker({
          timeFormat: 'HH:mm',
          interval: 30
        });
      });

      $(document).on("focusin", ".hourpicker", function() {
        $('input.hourpicker').timepicker({
          timeFormat: 'HH:mm',
          interval: 60
        });
      });
    <?php else : ?>
      $(document).on("focusin", ".timepicker", function() {
        $('input.timepicker').timepicker({
          timeFormat: 'hh:mm p',
          interval: 30
        });
      });

      $(document).on("focusin", ".hourpicker", function() {
        $('input.hourpicker').timepicker({
          timeFormat: 'hh:mm p',
          interval: 60
        });
      });
    <?php endif ?>
  </script>


  <div id="load_work">
    <?php $this->load->view('admin/include/datepicker-js.php'); ?>
  </div>


  <?php if (isset($page) && $page == 'Appointment') : ?>
    <script type="text/javascript">
      <?php if (!empty($this->session->userdata('staff_id'))) : ?>
          (function($) {
            $(document).ready(function() {
              var base_url = $('#base_url').val();
              var staffId = <?php echo $this->session->userdata('staff_id') ?>;
              if (staffId != '') {
                $(".appointment_datepicker").show();

                var url = base_url + 'admin/appointment/sess_staff/' + staffId;
                $.post(url, {
                  data: 'value',
                  'csrf_test_name': csrf_token
                }, function(json) {
                  if (json.st == 1) {
                    $("#load_work_cal").html('<div id="datepickers"></div>');
                    $("#load_work").html(json.loaded);
                  } else {
                    $("#load_work").html(json.loaded);
                  }
                }, 'json');
              }
            });
          })(jQuery);
      <?php endif; ?>
    </script>
  <?php endif ?>

</body>

</html>