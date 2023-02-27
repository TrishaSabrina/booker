<?php if ($interval == 'day'): ?>
	<p class="pick-date fs-16 pt-2 mb-3 mt-xs-20">Pick Appointment Date<?php echo trans('pick-date') ?></p>

	<?php 
		if (!empty($this->session->userdata('staff_id'))) {
        	$sess_staff_id = $this->session->userdata('staff_id');
        }else{
            $sess_staff_id = session_get($company->uid, 'staff_id');
        }

        if (!empty($this->session->userdata('location_id'))) {
        	$sess_location_id = $this->session->userdata('location_id');
        }else{
            $sess_location_id = session_get($company->uid, 'location_id');
        }
	?>

	<?php 
		// check booking location time
		if (!empty($this->session->userdata('location_id'))) {
			$check_location = check_location_time($date, $date, $sess_location_id);
		}else{
			$check_location = '';
		}

		// check booking time slots duplication
		$check = check_time($date, $date, $service_id, $sess_staff_id);

		// check staff time slots duplication
		$staff_time_slot = '';
 	?>

	<div class="time_wrap" style="height: <?php echo "auto"; ?>;">
		<div class="time_group pt-1">
			<div class="btn-group w-100">
			    <label class="btn btn-light-success btn-sm time_btn <?php echo $staff_time_slot; ?>  <?php if($check == TRUE){echo 'disabled';} ?>  <?php if($check_location == TRUE){echo 'disabled';} ?>">
			      <input type="radio" class="time_inp" value="<?php echo $date ?>" name="time" autocomplete="off"><i class="far fa-calendar-alt"></i> <?php echo $date?> 
			    </label>
			</div>
		</div>
	</div>
<?php else: ?>

	<?php if (empty($times)): ?>
		<div class="align-item-center pt-1">
			<h4 class="mb-0"><i class="lni lni-cross-circle text-danger"></i></h4>
			<p class="time-empty-info pt-0 mt-xs-20"><?php echo trans('schedule-not-available') ?></p>
		</div>
	<?php else: ?>

		<?php 

			if($is_embed == false){
				$sess_staff_id = $this->session->userdata('staff_id');
				$sess_location_id = $this->session->userdata('location_id');
			}else{
				$sess_staff_id = session_get($company->uid, 'staff_id');
				$sess_location_id = session_get($company->uid, 'location_id');
			}

			// if (!empty($this->session->userdata('staff_id'))) {
   //          	$sess_staff_id = $this->session->userdata('staff_id');
	  //       }else{
	  //           $sess_staff_id = session_get($company->uid, 'staff_id');
	  //       }

	  //       if (!empty($this->session->userdata('location_id'))) {
   //          	$sess_location_id = $this->session->userdata('location_id');
	  //       }else{
	  //           $sess_location_id = session_get($company->uid, 'location_id');
	  //       }
		?>

		<p class="pick-date fs-16 pt-2 mb-3 mt-xs-20"><?php echo trans('pick-time-for') ?>  <span><?php echo my_date_show($date) ?></span></p>
		<div class="time_wrap" style="height: <?php if(count($times) > 20){echo "369px";}else{ echo "auto"; } ?>;">
			<?php foreach ($times as $time): ?>
				<?php 
					$time_val = date("H:i", strtotime($time['start_time'])).'-'.date("H:i", strtotime($time['end_time'])); 
					$start_time = date("H:i", strtotime($time['start_time']));
					$end_time = date("H:i", strtotime($time['end_time']));

					// check booking location time

					// ofdld location code
					// if (!empty($this->session->userdata('location_id'))) {
					// 	$check_location = check_location_time($date, $date, $sess_location_id);
					// }else{
					// 	$check_location = '';
					// }

					if (!empty($this->session->userdata('location_id')) || !empty($sess_location_id)) {
						$location_id = $sess_location_id;
					}else{
						$location_id = '0';
					}

					// check booking time slots duplication :: added new parameter location_id
					$check = check_time($time_val, $date, $service_id, $sess_staff_id, $location_id);

					// check staff time slots duplication
					if (!empty($this->session->userdata('staff_id')) || !empty($sess_staff_id)) {

						$check_staff = check_staff_time($time_val, $date, $sess_staff_id);
						foreach ($check_staff as $staff_slot) {
							$slot_tims =  $staff_slot->time;
					        $staff_times = explode("-", $slot_tims);
					        $slot_start_time = $staff_times[0]; // time 1
					        $slot_end_time = $staff_times[1]; // time 2
					     	
					     	if ($start_time >= $slot_start_time && $start_time < $slot_end_time) {
						       $staff_time_slot = 'disabled'; break;
						    }else{
						    	$staff_time_slot = '';
						        if ($end_time > $slot_start_time && $end_time <= $slot_end_time) {
							       $staff_time_slot = 'disabled'; break;
							    }else{
						       		$staff_time_slot = '';
						       	}
						    }
						}
					}else{
						$staff_time_slot = '';
					}


					// check break time slots duplications
					$breaks = check_break($company->uid, $day_id);
					if (!empty($breaks)) {
						foreach ($breaks as $break) {
						    if ($start_time >= $break->start && $start_time < $break->end) {
						       $break_slot = 'disabled'; break;
						    }else{
						    	$break_slot = '';
						        if ($end_time > $break->start && $end_time <= $break->end) {
							       $break_slot = 'disabled'; break;
							    }else{
						       		$break_slot = '';
						       	}
						    }
						}
					}else{
						$break_slot = '';
					}


					if($company->time_format == 'HH'){
						$time_view = date("H:i", strtotime($time['start_time'])).'-'.date("H:i", strtotime($time['end_time'])); 
					}else{
						$time_view = date("h:i a", strtotime($time['start_time'])).'-'.date("h:i a", strtotime($time['end_time'])); 
					}
				?>

				<div class="time_group pt-1"> 
					<div class="btn-group w-100">
					    <label class="btn btn-light-success btn-sm time_btn <?php echo $staff_time_slot; ?> <?php echo $break_slot; ?> <?php if($check == TRUE){echo 'disabled';} ?>">
					      <input type="radio" class="time_inp" value="<?php echo $time_val ?>" name="time" autocomplete="off"><i class="far fa-clock"></i> <?php echo $time_view?> 
					    </label>
					</div>
				</div>
				<?php //endif ?>

			<?php endforeach ?>
		</div>
	<?php endif ?>

<?php endif ?>