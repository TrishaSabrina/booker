<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
      <div class="container">
          <div class="row">
              <div class="col-md-8">
                <div class="card mt-4">
                  <div class="card-header border-0">
                    <h3 class="card-title"><?php echo trans('license-info') ?></h3>
                  </div>
                 
                    <div class="card-body">
                        <?php if (get_user_info() == false): ?> 
                          <p class="text-md mb-4 mt-2"><?php echo trans('license-type') ?>: <span class="text-info font-weight-bold"><i class="fas fa-check-circle"></i> <?php echo trans('regular') ?> </span></p>
                        <?php else: ?>
                          <p class="text-md mt-0 mt-3"><?php echo trans('license-type') ?>: <span class="text-primary font-weight-bold"><i class="fas fa-check-circle"></i> <?php echo trans('extended') ?></span></p>
                        <?php endif ?>
                        
                        <?php if (get_user_info() == false): ?>
                          <p class="badge badge-secondary-soft text-md font-weight-normal"><i class="fas fa-info-circle"></i> <?php echo trans('license-upgrade-info') ?>: <a href="mailto:codericks.envato@gmail.com?subject=Support - Upgrade License"><?php echo trans('click-to-send-mail') ?></a> </p>
                        <?php endif ?>
                    </div>
                    
                </div>
              </div>
          </div>
      </div>
    </div>
</div>