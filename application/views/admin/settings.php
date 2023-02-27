<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <?php include"include/breadcrumb.php"; ?>

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
            <div class="card">

              <div class="">
                <div class="row">
                  <div class="col-md-3">
                    <div class="card-body">
                      <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><i class="lni lni-cog mr-1"></i> <?php echo trans('website-settings') ?></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="appearance-tab" data-toggle="tab" href="#appearance" role="tab" aria-controls="appearance" aria-selected="false"><i class="fas fa-paint-brush mr-1"></i> <?php echo trans('appearance') ?> </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="prefrences-tab" data-toggle="tab" href="#prefrences" role="tab" aria-controls="prefrences" aria-selected="false"><i class="lnib lni-invention mr-1"></i> <?php echo trans('prefrences') ?></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="charts-tab" data-toggle="tab" href="#charts" role="tab" aria-controls="charts" aria-selected="false"><i class="lnib lni-stats-up mr-1"></i> <?php echo trans('charts') ?></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="calendar-tab" data-toggle="tab" href="#calendar" role="tab" aria-controls="calendar" aria-selected="false"><i class="far fa-calendar-alt mr-1"></i> <?php echo trans('calendar-settings') ?> </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="sms-tab" data-toggle="tab" href="#sms" role="tab" aria-controls="sms" aria-selected="false"><i class="far fa-comment-dots mr-1"></i> Twilio <?php echo trans('sms-settings') ?></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="mail-tab" data-toggle="tab" href="#mail" role="tab" aria-controls="mail" aria-selected="false"><i class="fas fa-at mr-1"></i> <?php echo trans('email-settings') ?></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="tax-tab" data-toggle="tab" href="#tax" role="tab" aria-controls="tax" aria-selected="false"><i class="fas fa-percent mr-1"></i> <?php echo trans('subscription-tax') ?></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="captcha-tab" data-toggle="tab" href="#captcha" role="tab" aria-controls="captcha" aria-selected="false"><i class="lnib lni-lock-alt mr-1"></i> reCaptcha V2 <?php echo trans('settings') ?></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="script-tab" data-toggle="tab" href="#script" role="tab" aria-controls="script" aria-selected="false"><i class="fas fa-code mr-1"></i> <?php echo trans('header-script-codes') ?> </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="social-tab" data-toggle="tab" href="#social" role="tab" aria-controls="social" aria-selected="false"><i class="lni lni-cogs mr-1"></i> <?php echo trans('social-settings') ?></a>
                        </li>
                      </ul>
                    </div>
                  </div>

                  <!-- col-md-4 -->
                  <div class="col-md-9">
                    <form method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/settings/update') ?>" role="form" class="form-horizontal pl-20">
                      <div class="tab-content custom card-body" id="myTabContent">
                        
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                  
                            <div class="row mb-4">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                      <div class="col-sm-12">
                                        <div class="mih-100">
                                          <img class="m-auto" width="50px" src="<?php echo base_url($settings->favicon); ?>">
                                        </div>

                                        <div class="form-group">
                                          <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="photo1"  id="customFile">
                                            <label class="custom-file-label" for="customFile"><?php echo trans('upload-favicon') ?></label>
                                          </div>
                                        </div>

                                      </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                      <div class="col-sm-12">
                                        <div class="mih-100">
                                          <img class="m-auto" width="150px" src="<?php echo base_url($settings->logo); ?>">
                                        </div>

                                        <div class="form-group mb-0">
                                            <div class="custom-file">
                                              <input type="file" class="custom-file-input" name="photo2" id="customFile">
                                              <label class="custom-file-label" for="customFile"><?php echo trans('upload-logo') ?></label>
                                            </div>
                                        </div>
                                        <p class="text-muted mt-1 fs-12 small"><?php echo trans('logo-suggestions') ?></p>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                          <div class="mih-100">
                                          <img class="m-auto" width="100px" src="<?php echo base_url($settings->hero_img); ?>">
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-file">
                                              <input type="file" class="custom-file-input" name="photo3" id="customFile">
                                              <label class="custom-file-label" for="customFile"><?php echo trans('upload-hero-image') ?></label>
                                            </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                              <label><?php echo trans('application-name') ?></label>
                              <input type="text" name="site_name" value="<?php echo html_escape($settings->site_name); ?>" class="form-control" >
                            </div>

                            <div class="form-group">
                              <label><?php echo trans('application-title') ?></label>
                              <input type="text" name="site_title" value="<?php echo html_escape($settings->site_title); ?>" class="form-control">
                            </div>

                            <div class="form-group">
                              <label><?php echo trans('admin-email') ?></label>
                              <input type="text" name="admin_email" class="form-control" value="<?php echo html_escape(user()->email); ?>">
                              <!-- <p class="small text-muted"><i class="fa fa-info-circle"></i> <?php //echo trans('settings-email-info') ?></p> -->
                            </div>

                            <div class="form-group">
                              <label><?php echo trans('keywords') ?></label>
                                <input type="text" data-role="tagsinput" name="keywords" value="<?php echo html_escape($settings->keywords); ?>" class="form-control" >
                            </div>

                            <div class="form-group">
                                <label><?php echo trans('description') ?></label>
                                <textarea class="form-control" name="description" rows="4"><?php echo html_escape($settings->description); ?></textarea>
                            </div>

                            <div class="form-group">
                              <label><?php echo trans('footer-about') ?></label>
                              <textarea class="form-control" name="footer_about"><?php echo html_escape($settings->footer_about); ?></textarea>
                            </div>

                            <div class="form-group">
                              <label><?php echo trans('copyright') ?></label>
                              <input type="text" name="copyright" class="form-control" value="<?php echo html_escape($settings->copyright); ?>">
                            </div>

                            <div class="row">

                              <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo trans('currency') ?></label>
                                    <select class="form-control single_select" name="country">
                                        <option value=""><?php echo trans('select') ?></option>
                                        <?php foreach ($currencies as $currency): ?>
                                            <?php if (!empty($currency->currency_name)): ?>
                                              <option value="<?php echo html_escape($currency->id); ?>" 
                                                <?php echo (settings()->country == $currency->id) ? 'selected' : ''; ?>>
                                                <?php echo html_escape($currency->name.'  -  '.$currency->currency_code.' ('.$currency->currency_symbol.')'); ?>
                                              </option>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo trans('currency-position') ?></label>
                                    <select class="form-control" name="curr_locate">
                                        <option value=""><?php echo trans('select') ?></option>
                                        <option value="0" <?php if(settings()->curr_locate == 0){echo "selected";} ?>>$ 100 </option>
                                        <option value="1" <?php if(settings()->curr_locate == 1){echo "selected";} ?>>100 $</option>
                                    </select>
                                </div>
                              </div>
                              
                              <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo trans('number-format') ?></label>
                                    <select class="form-control" name="num_format">
                                        <option value=""><?php echo trans('select') ?></option>
                                        <option value="0" <?php if(settings()->num_format == 0){echo "selected";} ?>>100 </option>
                                        <option value="2" <?php if(settings()->num_format == 2){echo "selected";} ?>>100.00</option>
                                    </select>
                                </div>
                              </div>
                             
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label><?php echo trans('set-trial-days') ?></label>
                                  <input type="number" name="trial_days" class="form-control" value="<?php echo html_escape($settings->trial_days); ?>">
                                  <p class="small text-muted"><i class="fa fa-info-circle"></i> <?php echo trans('set-0-to-disable-the-trial-option') ?></p>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo trans('time-zone') ?></label>
                                    <select class="cus_lh select2" name="time_zone" style="width: 100%;">
                                        <option value=""><?php echo trans('select') ?></option>
                                        <?php foreach ($time_zones as $time): ?>
                                            <option value="<?php echo html_escape($time->id); ?>" 
                                                <?php echo (settings()->time_zone == $time->id) ? 'selected' : ''; ?>>
                                                <?php echo html_escape($time->name); ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                              </div>

                            </div>

                        </div>


                        <!-- apprance tab -->
                        <div class="tab-pane fade" id="appearance" role="tabpanel" aria-labelledby="appearance-tab">
                            
                            <div class="d-hides">
                              <p class="mb-2 font-weight-bold"><?php echo trans('frontend-color') ?></p>
                              <input type="text" name="site_color" value="<?php echo $settings->site_color; ?>" class="form-control w-50 colorpicker d-block mb-3" autocomplete="off" style="border: 2px solid #<?php echo $settings->site_color; ?>;">
                            </div>

                            <p class="mb-2 mt-3 pt-3 font-weight-bold"></p>

                            <div class="row">
                              <div class="col-6">
                                <label class="add-pointer">
                                <div class="icheck-primary text-center radio mt-2 pb-3">
                                  <input type="radio" id="radioPrimaryl" value="1" name="layout" <?php if($settings->layout == '1'){echo "checked";} ?>>
                                  <label for="radioPrimaryl"> <?php echo trans('light') ?>
                                  </label>
                                </div>
                                <img width="90%" class="img-thumbnail shadow" src="<?php echo base_url('assets/admin/images/light.png') ?>">
                                </label>
                              </div>

                              <div class="col-6">
                                <label class="add-pointer">
                                <div class="icheck-primary text-center radio mt-2 pb-3">
                                  <input type="radio" id="radioPrimaryd" value="0" name="layout" <?php if($settings->layout == '0'){echo "checked";} ?>>
                                  <label for="radioPrimaryd"> <?php echo trans('dark') ?>
                                  </label>
                                </div>
                                <img width="90%" class="img-thumbnail shadow" src="<?php echo base_url('assets/admin/images/dark.png') ?>">
                                </label>
                              </div>
                            </div>
                        </div>

                        <!-- prefrences tab -->
                        <div class="tab-pane fade" id="prefrences" role="tabpanel" aria-labelledby="prefrences-tab">
                            <div class="form-group">
                                <div class="col-sm-12 mt-15">

                                  <div class="custom-control custom-switch prefrence-item ml-10">
                                      <input type="checkbox" name="enable_multilingual" class="custom-control-input" value="1" id="switch-88" <?php if($settings->enable_multilingual == 1){echo "checked";} ?>>
                                      <label class="custom-control-label" for="switch-88"><?php echo trans('multilingual-system') ?></label>
                                      <p class="text-muted"><small><?php echo trans('enable-multilingual') ?>.</small></p>
                                  </div>

                                  <div class="custom-control custom-switch prefrence-item ml-10">
                                      <input type="checkbox" name="enable_frontend" class="custom-control-input" value="1" id="switch-11" <?php if($settings->enable_frontend == 1){echo "checked";} ?>>
                                      <label class="custom-control-label" for="switch-11"><?php echo trans('enable-frontend') ?></label>
                                      <p class="text-muted"><small><?php echo trans('enable-to-show-frontend-site') ?>.</small></p>
                                  </div>
                                  
                                  <div class="custom-control custom-switch prefrence-item ml-10">
                                      <input type="checkbox" name="enable_registration" class="custom-control-input" value="1" id="switch-2" <?php if($settings->enable_registration == 1){echo "checked";} ?>>
                                      <label class="custom-control-label" for="switch-2"><?php echo trans('registration-system') ?></label>
                                      <p class="text-muted mb-2"><small><?php echo trans('registration-title') ?>.</small></p>
                                  </div>

                                  <div class="custom-control custom-switch prefrence-item ml-10 mt-25">
                                      <input type="checkbox" name="enable_captcha" class="custom-control-input" value="1" id="switch-1" <?php if($settings->enable_captcha == 1){echo "checked";} ?>>
                                      <label class="custom-control-label" for="switch-1">reCaptcha</label>
                                      <p class="text-muted mb-2"><small><?php echo trans('recaptcha-title') ?></small></p>
                                  </div>

                                  <div class="custom-control custom-switch prefrence-item ml-10 mt-25">
                                      <input type="checkbox" name="enable_lifetime" class="custom-control-input" value="1" id="switch-12" <?php if($settings->enable_lifetime == 1){echo "checked";} ?>>
                                      <label class="custom-control-label" for="switch-12"><?php echo trans('enable-lifetime') ?></label>
                                      <p class="text-muted mb-2"><small><?php echo trans('enable-lifetime-title') ?>.</small></p>
                                  </div>

                                  <div class="custom-control custom-switch prefrence-item ml-10 mt-25">
                                      <input type="checkbox" name="enable_coupon" class="custom-control-input" value="1" id="switch-13" <?php if($settings->enable_coupon == 1){echo "checked";} ?>>
                                      <label class="custom-control-label" for="switch-13"><?php echo trans('coupons') ?></label>
                                      <p class="text-muted mb-2"><small><?php echo trans('enable-coupon-title') ?>.</small></p>
                                  </div>

                                  <?php if (get_user_info() == TRUE): ?>
                                  <div class="custom-control custom-switch prefrence-item ml-10 mt-25">
                                      <input type="checkbox" name="enable_payment" class="custom-control-input" value="1" id="switch-9" <?php if($settings->enable_payment == 1){echo "checked";} ?>>
                                      <label class="custom-control-label" for="switch-9"><?php echo trans('payment') ?></label>
                                      <p class="text-muted mb-2"><small><?php echo trans('payment-title') ?>.</small></p>
                                  </div>
                                  <?php else: ?>
                                      <input type="hidden" name="enable_payment" value="0">
                                  <?php endif ?>

                                  <div class="custom-control custom-switch prefrence-item ml-10 mt-25">
                                      <input type="checkbox" name="enable_sms" class="custom-control-input" value="1" id="switch-10" <?php if($settings->enable_sms == 1){echo "checked";} ?>>
                                      <label class="custom-control-label" for="switch-10"><?php echo trans('sms-verification') ?></label>
                                      <p class="text-muted mb-0"><small><?php echo trans('sms-title1') ?></small></p>

                                      <p class="text-danger mb-2"><small><?php echo trans('sms-title2') ?>.</small></p>
                                  </div>


                                  <div class="custom-control custom-switch prefrence-item ml-10 mt-25">
                                      <input type="checkbox" name="enable_email_verify" class="custom-control-input" value="1" id="switch-3" <?php if($settings->enable_email_verify == 1){echo "checked";} ?>>
                                      <label class="custom-control-label" for="switch-3"><?php echo trans('email-verification') ?></label>
                                      <p class="text-muted mb-2"><small><?php echo trans('email-verify-title') ?>.</small></p>
                                  </div>

                                  <div class="custom-control custom-switch prefrence-item ml-10 mt-25">
                                      <input type="checkbox" name="enable_users" class="custom-control-input" value="1" id="switch-4" <?php if($settings->enable_users == 1){echo "checked";} ?>>
                                      <label class="custom-control-label" for="switch-4"><?php echo trans('company-list') ?></label>
                                      <p class="text-muted mb-2"><small><?php echo trans('company-list-title') ?></small></p>
                                  </div>

                                  <div class="custom-control custom-switch prefrence-item ml-10 mt-25">
                                      <input type="checkbox" name="enable_blog" class="custom-control-input" value="1" id="switch-5" <?php if($settings->enable_blog == 1){echo "checked";} ?>>
                                      <label class="custom-control-label" for="switch-5"><?php echo trans('blogs') ?></label>
                                      <p class="text-muted mb-2"><small><?php echo trans('blogs-title') ?></small></p>
                                  </div>

                                  <div class="custom-control custom-switch prefrence-item ml-10 mt-25">
                                      <input type="checkbox" name="enable_faq" class="custom-control-input" value="1" id="switch-6" <?php if($settings->enable_faq == 1){echo "checked";} ?>>
                                      <label class="custom-control-label" for="switch-6"><?php echo trans('faqs') ?></label>
                                      <p class="text-muted mb-2"><small><?php echo trans('faq-title') ?></small></p>
                                  </div>

                                  <div class="custom-control custom-switch prefrence-item ml-10 mt-25">
                                      <input type="checkbox" name="enable_feature" class="custom-control-input" value="1" id="switch-8" <?php if($settings->enable_feature == 1){echo "checked";} ?>>
                                      <label class="custom-control-label" for="switch-8"><?php echo trans('features-intro') ?></label>
                                      <p class="text-muted mb-2"><small><?php echo trans('features-intro-title') ?></small></p>
                                  </div>

                                  <div class="custom-control custom-switch prefrence-item ml-10 mt-25">
                                      <input type="checkbox" name="enable_workflow" class="custom-control-input" value="1" id="switch-7" <?php if($settings->enable_workflow == 1){echo "checked";} ?>>
                                      <label class="custom-control-label" for="switch-7"><?php echo trans('workflow') ?></label>
                                      <p class="text-muted mb-2"><small><?php echo trans('workflow-title') ?></small></p>
                                  </div>

                                  <div class="custom-control custom-switch prefrence-item ml-10 mt-25">
                                      <input type="checkbox" name="enable_animation" class="custom-control-input" value="1" id="switch-an" <?php if($settings->enable_animation == 1){echo "checked";} ?>>
                                      <label class="custom-control-label" for="switch-an"><?php echo trans('site-animation') ?></label>
                                      <p class="text-muted mb-2"><small><?php echo trans('site-animation-title') ?></small></p>
                                  </div>

                                </div>
                            </div>
                        </div>


                        <!-- charts tab -->
                        <div class="tab-pane fade" id="charts" role="tabpanel" aria-labelledby="charts-tab">
                            <p class="mb-3"><?php echo trans('select-income-chart-style') ?></p>

                            <div class="icheck-primary radio mt-2 pb-3">
                              <input type="radio" id="radioPrimary1" value="column" name="chart_style" <?php if($settings->chart_style == 'column'){echo "checked";} ?>>
                              <label for="radioPrimary1"><i class="fas fa-chart-bar fa-2x ml-2"></i> <?php echo trans('bar-chart') ?>
                              </label>
                            </div>

                            <div class="icheck-primary radio pb-3">
                              <input type="radio" id="radioPrimary2" value="line" name="chart_style" <?php if($settings->chart_style == 'line'){echo "checked";} ?>>
                              <label for="radioPrimary2"><i class="fas fa-chart-line fa-2x ml-2"></i> <?php echo trans('line-chart') ?>
                              </label>
                            </div>

                            <div class="icheck-primary radio pb-3">
                              <input type="radio" id="radioPrimary3" value="area" name="chart_style" <?php if($settings->chart_style == 'area'){echo "checked";} ?>>
                              <label for="radioPrimary3"><i class="fas fa-chart-area fa-2x ml-2"></i> <?php echo trans('area-line-chart') ?>
                              </label>
                            </div>

                            <div class="icheck-primary radio pb-3">
                              <input type="radio" id="radioPrimary4" value="areaspline" name="chart_style" <?php if($settings->chart_style == 'areaspline'){echo "checked";} ?>>
                              <label for="radioPrimary4"><i class="fas fa-chart-area fa-2x ml-2"></i> <?php echo trans('area-shape-chart') ?>
                              </label>
                            </div>
                        </div>


                        <!-- calendar tab -->
                        <div class="tab-pane fade" id="calendar" role="tabpanel" aria-labelledby="calendar-tab">
                            <p>
                              <span class="badge badge-primary-soft fs-15 mr-4"><?php echo trans('google-calendar') ?></span>
                              <a target="_blank" class="pull-right" href="<?php echo base_url('assets/admin/files/google_calendar.pdf') ?>"><span class="btn btn-outline-danger btn-sm"><i class="fas fa-info-circle"></i> <?php echo trans('google-calendar-integration') ?></span></a>
                            </p>

                            <div class="form-group">
                              <label><?php echo trans('client-id') ?></label>
                                <input type="text" name="google_client_id" value="<?php echo html_escape($settings->google_client_id); ?>" class="form-control" >
                            </div>

                            <div class="form-group">
                              <label><?php echo trans('client-secret') ?></label>
                                <input type="text" name="google_client_secret" value="<?php echo html_escape($settings->google_client_secret); ?>" class="form-control" >
                            </div>

                            <div class="form-group bg-light-primary">
                              <p class="mb-1 mt-4"><?php echo trans('google-callback-url') ?></p>
                              <code class="badge badge-secondary-soft fs-14"><?php echo base_url('gc/auth/oauth') ?></code>
                            </div>
                        </div>

                        <!-- sms tab -->
                        <div class="tab-pane fade" id="sms" role="tabpanel" aria-labelledby="sms-tab">
                            <div class="form-group">
                              <label><?php echo trans('account-sid') ?></label>
                                <input type="text" name="twillo_account_sid" value="<?php echo html_escape($settings->twillo_account_sid); ?>" class="form-control" >
                            </div>

                            <div class="form-group">
                              <label><?php echo trans('auth-token') ?></label>
                                <input type="text" name="twillo_auth_token" value="<?php echo html_escape($settings->twillo_auth_token); ?>" class="form-control" >
                            </div>

                            <div class="form-group">
                              <label><?php echo trans('sender-number-tw') ?></label>
                                <input type="text" name="twillo_number" value="<?php echo html_escape($settings->twillo_number); ?>" class="form-control" >
                            </div>
                        </div>

                        <!-- tax tab -->
                        <div class="tab-pane fade" id="tax" role="tabpanel" aria-labelledby="tax-tab">
                          <div class="col-5">
                            <div class="form-group">
                              <label><?php echo trans('tax-name') ?></label>
                                <input type="text" name="tax_name" value="<?php echo html_escape($settings->tax_name); ?>" class="form-control" >
                            </div>
                            
                              <div class="form-group">
                                <label><?php echo trans('tax-amount') ?></label>
                                <div class="input-group">
                                  <input type="number" class="form-control" name="tax_value" value="<?php echo html_escape($settings->tax_value); ?>">
                                  <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                  </div>
                                </div>
                              </div>
                          </div>
                        </div>


                        <!-- mail tab -->
                        <div class="tab-pane fade" id="mail" role="tabpanel" aria-labelledby="mail-tab">
                            
                          <div class="col-sm-12 mt-15">

                              <div class="callout callout-default smtp_area <?php if(settings()->mail_protocol == 'mail'){echo "d-hide";} ?>">
                                  <h5><?php echo trans('gmail-smtp') ?></h5>
                                  <p>Gmail Host:&nbsp;&nbsp;smtp.gmail.com <br>
                                   Port:&nbsp;&nbsp;SSL 465 & TLS 587</p>

                                  <p class="text-dark mb-2"><b><i class="fa fa-info-circle"></i> <?php echo trans('mail-info-title') ?></b></p>
                                  <p><i class="fas fa-times-circle text-danger"></i> <?php echo trans('two-factor-authentication-off') ?><br>
                                  <i class="fas fa-check-circle text-success"></i> <?php echo trans('less-secure-app-on') ?></p>
                              </div>

                              <div class="form-group">
                                  <label class="control-label"><?php echo trans('mail-type') ?></label>
                                  <select name="mail_protocol" class="form-control custom-select mail_protocol">
                                      <option value="smtp" <?php echo ($settings->mail_protocol == "smtp") ? "selected" : ""; ?>>SMTP</option>
                                      <option value="mail" <?php echo ($settings->mail_protocol == "mail") ? "selected" : ""; ?>>Codeigniter Mail</option>
                                  </select>
                              </div>

                              <div class="form-group">
                                  <label class="control-label"><?php echo trans('mail-title') ?></label>
                                  <input type="text" class="form-control" name="mail_title" value="<?php echo html_escape($settings->mail_title); ?>">
                              </div>

                              <div class="form-group">
                                  <label class="control-label"><?php echo trans('sender-email') ?></label>
                                  <input type="text" class="form-control" name="sender_mail" value="<?php if(empty($settings->sender_mail)){ echo html_escape($settings->admin_email);} else{echo html_escape($settings->sender_mail);} ?>">
                              </div>

                              <div class="smtp_area <?php if(settings()->mail_protocol == 'mail'){echo "d-hide";} ?>">
                                <div class="form-group">
                                    <label class="control-label"><?php echo trans('mail-host') ?></label>
                                    <input type="text" class="form-control" name="mail_host" value="<?php echo html_escape($settings->mail_host); ?>">
                                </div>

                                <div class="form-group">
                                    <label class="control-label"><?php echo trans('mail-port') ?></label>
                                    <input type="text" class="form-control" name="mail_port" value="<?php echo html_escape($settings->mail_port); ?>">
                                </div>

                                <div class="form-group">
                                    <label class="control-label"><?php echo trans('mail-username') ?></label>
                                    <input type="text" class="form-control" name="mail_username" value="<?php echo html_escape($settings->mail_username); ?>" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label class="control-label"><?php echo trans('mail-password') ?></label>
                                    <input type="password" class="form-control" name="mail_password" value="<?php echo base64_decode($settings->mail_password); ?>" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label class="control-label"><?php echo trans('mail-encryption') ?></label>
                                    <select name="mail_encryption" class="form-control custom-select">
                                        <option value="ssl" <?php echo ($settings->mail_encryption == "ssl") ? "selected" : ""; ?>>SSL</option>
                                        <option value="tls" <?php echo ($settings->mail_encryption == "tls") ? "selected" : ""; ?>>TLS</option>
                                    </select>
                                    <p class="small"><i class="fa fa-info-circle"></i> <?php echo trans('mail-port-help') ?> </p>
                                </div>
                              </div>

                          
                              <div class="form-group">
                                <a target="_blank" href="<?php echo base_url('auth/test_mail') ?>" class="btn btn-secondary mb-50 pull-right"><i class="fa fa-paper-plane"></i> <?php echo trans('send-test-mail') ?></a>
                              </div>
                          </div>

                        </div>

                        <!-- script tab -->
                        <div class="tab-pane fade" id="script" role="tabpanel" aria-labelledby="script-tab">
                            <div class="form-group">
                              <label><?php echo trans('header-script-codes-title') ?></label>
                              <textarea class="form-control" name="google_analytics" rows="16"><?php echo base64_decode($settings->google_analytics) ?></textarea>
                            </div>
                        </div>


                        <!-- social tab -->
                        <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                            <div class="form-group">
                              <label><?php echo trans('facebook') ?></label>
                                <input type="text" name="facebook" value="<?php echo html_escape($settings->facebook); ?>" class="form-control" >
                            </div>
                            <div class="form-group">
                              <label><?php echo trans('twitter') ?></label>
                                <input type="text" name="twitter" value="<?php echo html_escape($settings->twitter); ?>" class="form-control" >
                            </div>
                            <div class="form-group">
                              <label><?php echo trans('instagram') ?></label>
                                <input type="text" name="instagram" value="<?php echo html_escape($settings->instagram); ?>" class="form-control" >
                            </div>
                            <div class="form-group">
                              <label><?php echo trans('linkedin') ?></label>
                                <input type="text" name="linkedin" value="<?php echo html_escape($settings->linkedin); ?>" class="form-control" >
                            </div>
                        </div>

                        <!-- captcha tab -->
                        <div class="tab-pane fade" id="captcha" role="tabpanel" aria-labelledby="captcha-tab">
                            <div class="form-group mb-4">
                              <label><?php echo trans('recaptcha') ?></label>
                              <?php if (settings()->captcha_site_key != ''): ?>
                                  <div class="g-recaptcha pull-left m-10" data-sitekey="<?php echo html_escape(settings()->captcha_site_key); ?>"></div>
                              <?php endif ?>
                            </div>

                            <div class="form-group">
                              <label><?php echo trans('captcha-site-key') ?></label>
                                <input type="text" name="captcha_site_key" value="<?php echo html_escape($settings->captcha_site_key); ?>" class="form-control" >
                            </div>

                            <div class="form-group">
                              <label><?php echo trans('captcha-secret-key') ?></label>
                                <input type="text" name="captcha_secret_key" value="<?php echo html_escape($settings->captcha_secret_key); ?>" class="form-control" >
                            </div>
                        </div>
                      </div>

                      <!-- csrf token -->
                      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

                      <button type="submit" class="btn btn-primary btn-lg btn-block mt-3"> <?php echo trans('save-changes') ?></button>
                        
                    </form>
                  </div>
                </div>
                
              </div>
            </div>

          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
