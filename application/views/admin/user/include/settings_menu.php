<div class="col-lg-3">
	<div class="card">
		<div class="card-body">
			<ul class="nav nav-pills flex-column" id="myTab" role="tablist">
				<?php if (check_my_payment_status() == TRUE): ?>
				<li class="nav-item">
					<a class="nav-link <?php if(isset($page_title) && $page_title == "System Settings"){echo "active";} ?>" href="<?php echo base_url('admin/settings/company') ?>"><i class="lni lni-home mr-1"></i> <?php echo trans('company-settings') ?></a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?php if(isset($page_title) && $page_title == "General Settings"){echo "active";} ?>" href="<?php echo base_url('admin/settings/general') ?>"><i class="lni lni-cog mr-1"></i> <?php echo trans('general-settings') ?></a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?php if(isset($page_title) && $page_title == "Working Hours"){echo "active";} ?>" href="<?php echo base_url('admin/settings/working_hours') ?>"><i class="far fa-clock mr-1"></i> <?php echo trans('working-hours') ?></a>
				</li>

				<li class="nav-item">
					<a class="nav-link <?php if(isset($page_title) && $page_title == "SMS Settings"){echo "active";} ?>" href="<?php echo base_url('admin/settings/sms') ?>"><i class="far fa-comment-dots mr-1"></i> <?php echo trans('twillo-sms-settings') ?></a>
				</li>

				<?php if(get_user_info() == TRUE){$uval = 'd-show';}else{$uval = 'd-hide';} ?>
				<?php if (check_feature_access('get-online-payments') == TRUE): ?>
					<?php if (settings()->enable_wallet == 0): ?>
						<li class="nav-item <?= $uval; ?>">
							<a class="nav-link <?php if(isset($page_title) && $page_title == "Payment Settings"){echo "active";} ?>" href="<?php echo base_url('admin/payment/user') ?>"><i class="lni lni-coin mr-1"></i> <?php echo trans('payment-settings') ?></a>
						</li>
					<?php endif; ?>
				<?php endif; ?>

				<li class="nav-item">
					<a class="nav-link <?php if(isset($page_title) && $page_title == "Embedded Settings"){echo "active";} ?>" href="<?php echo base_url('admin/settings/embedded_code') ?>"><i class="fas fa-laptop-code ml-1 mr-1"></i> <?php echo trans('embedded-code') ?></a>
				</li>

				<li class="nav-item">
					<a class="nav-link <?php if(isset($page_title) && $page_title == "QR Settings"){echo "active";} ?>" href="<?php echo base_url('admin/settings/qr_code') ?>"><i class="fas fa-qrcode ml-1 mr-1"></i> <?php echo trans('qr-code') ?></a>
				</li>
				<?php endif; ?>

				<li class="nav-item">
					<a class="nav-link <?php if(isset($page_title) && $page_title == "Profile"){echo "active";} ?>" href="<?php echo base_url('admin/settings/profile') ?>"><i class="lnib lni-user mr-1"></i> <?php echo trans('manage-profile') ?></a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?php if(isset($page_title) && $page_title == "Change Password"){echo "active";} ?>" href="<?php echo base_url('admin/settings/change_password') ?>"><i class="lnib lni-lock mr-1"></i> <?php echo trans('change-password') ?></a>
				</li>
			</ul>
		</div>
	</div>

	<?php if(isset($page_title) && $page_title == "Working Hours"): ?>
		<form method="post" class="validate-form" action="<?php echo base_url('admin/settings/update_time_format')?>" role="form" enctype="multipart/form-data">

		    <div class="card mt-4">
		      <div class="card-body">
		        <div class="row">
		            
		            <div class="form-group col-md-12">
		                <label><?php echo trans('time-format') ?></label>
		                <select class="form-control" name="time_format">
		                    <option value=""><?php echo trans('select') ?></option>
		                    <option <?php echo ($this->business->time_format == 'hh') ? 'selected' : ''; ?> value="hh"> 12 <?php echo trans('hours') ?></option>
		                    <option <?php echo ($this->business->time_format == 'HH') ? 'selected' : ''; ?> value="HH"> 24 <?php echo trans('hours') ?></option>
		                </select>
		            </div>

		            <div class="col-md-12">
		              <!-- csrf token -->
		                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
		                
		                <div><button type="submit" class="btn btn-secondary"><?php echo trans('update') ?></button></div>
		            </div>

		        </div>
		      </div>
		    </div>
		</form>
	<?php endif ?>

</div>