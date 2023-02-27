<div class="col-md-3 mt-4">
    <div class="staff-card border-1 lift-sm mb-2 text-center shadow-light">
        <div class="staff_img mt-4">
            <img src="<?php echo base_url($staff->image) ?>">
            <span><i class="fas fa-circle text-<?php if($staff->status == 1){echo "success";}else{echo "muted";} ?>"></i></span>
        </div>
        <div class="staff-card-body text-center py-4 flex-grow-1">
            <p class="fs-16 text-dark mb-1 mt-1 font-weight-bold"><?php echo html_escape($staff->name) ?></p>
            <p class="fs-14 text-muted mb-0 font-weight-normal"><?php echo html_escape($staff->email) ?></p>
            <?php if ($company->enable_location == 1): ?>
                <?php $location = get_staff_location($staff->id); ?>
                <span class="fs-14"><i class="fas fa-map-marker-alt fs-12"></i> <?php echo get_by_id($location->location_id, 'locations')->name; ?></span>
            <?php endif; ?>
        </div>
    </div>
</div>

