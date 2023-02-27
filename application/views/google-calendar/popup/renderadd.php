
<div class="form-group">
  <label for="inputAddress">Summary</label>
  <input type="text" name="summary" class="form-control summary input-gcevent-summary">
</div>

<div class="form-row">
<div class="form-group col-md-8">
  <label for="inputAddress2">Start Date </label>
  <input type="date" name="startDate" class="form-control start-date input-gcevent-startdate" value="<?php print $datetime; ?>">
</div>

<div class="form-group col-md-4">
  <label for="inputAddress2">Start Time</label>
  <input type="time" name="startTime" class="form-control start-time input-gcevent-starttime" value="<?php print date("H:i"); ?>">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-8">
  <label for="inputAddress2">End Date</label>
  <input type="date" name="endDate" class="form-control end-date input-gcevent-enddate" value="<?php print $datetime; ?>">
</div>
<div class="form-group col-md-4">
  <label for="inputAddress2">End Time</label>
  <input type="time" name="endTime" class="form-control end-time input-gcevent-endtime" value="<?php print date('H:i'); ?>">
</div>
</div>

<div class="form-group">
  <label for="inputAddress">Description</label>
  <textarea name="description" class="form-control input-gcevent-description" rows="3"></textarea>
</div>
<button type="button" name="save_gc_event" id="save-gc-event" class="btn btn-primary">Save</button>