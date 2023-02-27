<?php if (empty($company->image)):?>
    <?php $bg_image = base_url('assets/front/img/vericla-cover.jpg'); ?>
<?php else: ?>
    <?php $bg_image = base_url($company->image);?>
<?php endif; ?>

<section class="bg-light pt-0">
    <section class="container bannerimg overlay overlay-black overlay-50 mt-0 position-relative"
        style="background-image: url(<?php echo html_escape($bg_image) ?>);">
        
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-md-11 text-left m-auto">
                    <div class="company-banner">

                        <h1 class="display-6 mb-0 text-light"><?php echo html_escape($company->name) ?></h1>
                        <p class="mb-1 text-light fs-18"><?php echo html_escape($company->title) ?></p>
                        

                        <form class="d-flex py-1 px-3 bg-white rounded mt-3 w-lg-50 blur-md" method="get" action="<?php echo base_url('company/services/'.$slug) ?>">
                            <span class="svg-icon svg-icon-1 svg-icon-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black"></path>
                                </svg>
                            </span>
                            <input type="text" name="search" class="form-control fcustom blur-md border-0 fw-bold ps-2 w-xxl-350px" placeholder="Search">
                        </form>

                        <div class="company-buttons">
                            <?php if (!empty($my_days)): ?>
                                <a data-toggle="modal" href="#scheduleModal" class="btn btn-dark btn-sm mt-4 mr-1"><i class="far fa-clock"></i> <?php echo trans('business-days') ?></a>
                            <?php endif ?>

                            <a data-toggle="modal" href="#infoModal" class="btn btn-dark btn-sm mt-4 mr-1"><i class="icon icon-info fs-12"></i> <?php echo trans('info') ?></a>

                            <?php if(!empty($services) || !empty($categories)): ?>
                                <a href="<?php echo base_url('booking/'.$company->slug) ?>" class="btn btn-primary btn-sm mt-4"><i class="icon icon-calendar"></i> <?php echo trans('book-now') ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

    </section>


    <section class="p-0 mt--25 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-11 col-xs-12 text-left m-auto">
                    <div class="company-nav">
                        <nav class="navbar navbar-expand-lg navbar-expand-sm navbar-expand-xs navbar-light bg-white shadow rounded-full py-2 blur">
                          <div class="container-fluid">
                            <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarText">
                                <?php if (!empty($company->logo)):?>
                                <a class="navbar-brand" href="<?php echo base_url($slug) ?>">
                                  <img src="<?php echo base_url($company->logo) ?>" alt="" width="80" height="24" class="d-inline-block align-text-top">
                                  
                                </a>
                                <?php endif; ?>
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0 smr-5">
                                    <li class="nav-item"><a href="<?php echo base_url($slug) ?>" class="nav-link hdarks <?php if (isset($page_title) && $page_title == 'Company Home'){echo 'active';} ?> text-xs-white <?php if(isset($page_title) && $page_title == "Home"){echo "active";} ?>"><?php echo trans('home') ?></a></li>
                                    
                                    <li class="nav-item"><a href="<?php echo base_url('services/'.$slug) ?>" class="nav-link hdark text-<?php if (isset($page_title) && $page_title == 'Company Home'){echo 'muted';} ?> text-xs-white <?php if(isset($page_title) && $page_title == "Services"){echo "active";} ?>"><?php echo trans('services') ?></a></li>

                                    <li class="nav-item"><a href="<?php echo base_url('staff/'.$slug) ?>" class="nav-link hdark text-<?php if (isset($page_title) && $page_title == 'Company Home'){echo 'muted';} ?> text-xs-white <?php if(isset($page_title) && $page_title == "Staff"){echo "active";} ?>"><?php echo trans('staff') ?></a></li>
                         
                                    <?php if (check_user_feature_access($company->user_id, 'gallery') == TRUE): ?>
                                        <?php if ($company->enable_gallery == TRUE): ?>
                                            <li class="nav-item"><a href="<?php echo base_url('gallery/'.$slug) ?>" class="nav-link hdark text-<?php if (isset($page_title) && $page_title == 'Company Home'){echo 'muted';} ?> text-xs-white <?php if(isset($page_title) && $page_title == "Gallery"){echo "active";} ?>"><?php echo trans('gallery') ?></a></li>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if (!empty(get_pages($company->uid))): ?>
                                        <li class="nav-item dropdown">
                                            <a href="javascript:void(0);" data-toggle="dropdown" class="nav-link dropdown-toggle <?php if (isset($page_title) && $page_title == 'Company Home'){echo 'text-muted';} ?>"><?php echo trans('pages') ?></a>

                                            <ul class="dropdown-menu shadow mt-1">
                                                <?php foreach (get_pages($company->uid) as $page): ?>
                                                    <li><a class="dropdown-item" href="<?php echo base_url('company/page/'.$slug.'/'.$page->slug) ?>"><?php echo html_escape($page->title) ?></a></li>
                                                <?php endforeach ?>
                                            </ul>
                                        </li>
                                    <?php endif ?>
                                </ul>
                                
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0 tr-sm">
                                    <li class="nav-item mr-0">
                                        <?php if(is_user()): ?>
                                            <a class="btn btn-sm btn-pill btn-light-secondary ml-auto" href="<?php echo base_url('auth/logout') ?>"><i class="icon-logout"></i> <?php echo trans('logout') ?> </a>

                                             <a class="btn btn-sm btn-pill btn-primary ml-auto" href="<?php echo base_url('admin/dashboard/user') ?>"><i class="icon-speedometer"></i> <?php echo trans('dashboard') ?></a>
                                        <?php elseif(is_customer()): ?>
                                            <a class="btn btn-sm btn-pill btn-light-secondary ml-auto" href="<?php echo base_url('auth/logout') ?>"><i class="lni lni-exit"></i> <?php echo trans('logout') ?> </a>

                                            <a class="btn btn-sm btn-pill btn-primary ml-auto" href="<?php echo base_url('customer/appointments') ?>"><i class="icon-speedometer"></i> <?php echo trans('dashboard') ?></a>
                                        <?php elseif(is_staff()): ?>
                                            <a class="btn btn-sm btn-pill btn-light-secondary ml-auto" href="<?php echo base_url('auth/logout') ?>"><i class="lni lni-exit"></i> <?php echo trans('logout') ?> </a>

                                            <a class="btn btn-sm btn-pill btn-primary ml-auto" href="<?php echo base_url('staff/appointments') ?>"><i class="icon-speedometer"></i> <?php echo trans('dashboard') ?></a>
                                        <?php else: ?>
                                            <a class="btn btn-sm btn-pill btn-light-secondary ml-auto" href="<?php echo base_url('login') ?>"><?php echo trans('sign-in') ?></a>
                                            <a class="btn btn-sm btn-pill btn-primary ml-auto" href="<?php echo base_url('register') ?>"><?php echo trans('get-started') ?></a>
                                        <?php endif ?>
                                    </li>
                                </ul>
                            </div>
                          </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>




<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-normal" id="exampleModalLabel"><?php echo trans('about') ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="lni lni-close fs-14"></i></span>
        </button>
      </div>
      <div class="modal-body p-0">
        <ul class="list-group p-0 m-0">
            <li class="list-group-item">
                <div class="d-flex align-items-center justify-content-between">
                    <?php if (!empty($company->details)): ?>
                        <p class="mb-0"><?php echo $company->details ?></p> 
                    <?php endif ?>
                </div>
            </li>

            <?php if(!empty($company->email)): ?>
            <li class="list-group-item">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="list-style4 mr-3">
                        Email
                    </span> 
                    <a href="mailto:<?php echo html_escape($company->email) ?>"><?php echo html_escape($company->email) ?></a>
                </div>
            </li>
            <?php endif; ?>
            
            <?php if(!empty($company->phone)): ?>
            <li class="list-group-item">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="list-style4 mr-3">
                        Phone
                    </span> <?php echo html_escape($company->phone) ?>
                </div>
            </li>
            <?php endif; ?>

            <?php if(!empty($company->address)): ?>
            <li class="list-group-item">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="list-style4 mr-3">
                        Location
                    </span> <?php echo html_escape($company->address) ?>
                </div>
            </li>
            <?php endif; ?>
        </ul>
      </div>

      <div class="modal-footer justify-content-center align-items-center">
        <ul class="list-unstyled social-icon3 mt-2">
            <?php if (!empty($company->facebook)) : ?>
                <li><a href="<?= prep_url($company->facebook) ?>"><i class="lni lni-facebook-original"></i></a></li>
            <?php endif ?>

            <?php if (!empty($company->twitter)) : ?>
                <li><a href="<?= prep_url($company->twitter) ?>"><i class="lni lni-twitter"></i></a></li>
            <?php endif ?>

            <?php if (!empty($company->instagram)) : ?>
                <li><a href="<?= prep_url($company->instagram) ?>"><i class="lni lni-instagram-original"></i></a></li>
            <?php endif ?>

            <?php if (!empty($company->whatsapp)) : ?>
                <li><a href="https://wa.me/<?= $company->whatsapp ?>"><i class="lni lni-whatsapp"></i></a></li>
            <?php endif ?>
        </ul>
      </div>

    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-normal" id="exampleModalLabel"><?php echo trans('working-hours') ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="lni lni-close fs-14"></i></span>
        </button>
      </div>
      <div class="modal-body p-0">

        <ul class="list-group p-0">
            <?php $days = get_days(); ?>
            <?php if (empty($my_days)): ?>
                <li class="py-1">
                    <div class="d-flex">
                        <span class="list-style9 mr-3">
                            <i class="fas fa-times"></i>
                        </span> <?php echo trans('schedule-is-not-setted') ?>
                    </div>
                </li>
            <?php else: ?>
                
                <?php $i=1; foreach ($days as $day): ?>

                    <?php foreach ($my_days as $asnday): ?>
                        <?php if ($asnday['day'] == $i) {
                            $check = 'check';
                            break;
                        } else {
                            $check = 'times not';
                        }
                        ?>
                    <?php endforeach ?>
                

                    <?php if($company->time_format == 'HH'){$mstart = $my_days[$i-1]['start'];}else{$mstart = date("h:i a", strtotime($my_days[$i-1]['start']));} ?>
                    <?php if($company->time_format == 'HH'){$mend = $my_days[$i-1]['end'];}else{$mend = date("h:i a", strtotime($my_days[$i-1]['end']));} ?>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <span class="text-dark fs-18"><?php echo trans(strtolower($day)) ?></span><br>
                            <?php if ($check == 'check'): ?>
                                <?php if (!empty($my_days[$i-1]['start'])): ?>
                                    <i class="far fa-clock"></i> <?= $mstart.'-'.$mend ?>
                                <?php endif ?>
                            <?php endif ?>
                        </span> 

                        <?php if ($check == 'check'): ?>
                            <span class="badge badge-success-soft badge-smalls"><i class="fas fa-check-circle fs-12"></i> <?php echo trans('open') ?> </span>
                        <?php else: ?>
                            <span class="badge badge-danger-soft badge-smalls"><i class="fas fa-times-circle fs-12"></i> <?php echo trans('close') ?> </span>
                        <?php endif ?>
                    </li>

                    
                <?php  $i++; endforeach ?>

            <?php endif ?>
        </ul>
      </div>
    </div>
  </div>
</div>