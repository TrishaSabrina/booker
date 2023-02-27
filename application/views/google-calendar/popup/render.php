
  <?php
  foreach ($eventData as $key => $element) {
    echo '<div class="card-hover marg-bot22" style="border:1px dashed #cecccc; background: #f8f8f8;padding: 6px;" id="google-cal1">
      <a target="_blank" href="# ">'.$element['summary']. ' - '.$element['description'].'</a>
      <br>
      <span>'.date('l, F d', strtotime($element['start_date'])).'</span>
    </div>';
  }
  ?>
