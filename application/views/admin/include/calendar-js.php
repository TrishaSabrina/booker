<script src="<?php echo base_url() ?>assets/admin/js/fullcalendar-main.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/locales-all.js'></script>

<script>

    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        initialDate: '<?php echo date('Y-m-d') ?>',
        locale: '<?php echo strtolower(lang_short_form()) ?>',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        eventClick: function(info) {
          swal("<?php echo trans('appointments') ?>", info.event.title);
        },
        events: [
          <?php foreach ($appointments as $appointment): ?>
            <?php $time = explode("-", $appointment->time, 3); ?>
            {
              title: '<?php echo html_escape($appointment->service_name.' - '.' ('.$appointment->time.') at '.my_date_show($appointment->date).', '.trans('staff').': '.$appointment->staff_name.' - '.trans('customer').': '.$appointment->customer_name) ?>',
              
              start:  '<?php echo html_escape($appointment->date).'T'.$time[0]?>'
            },
          <?php endforeach; ?>
        ],
        eventColor: '#3CB371'

      });

      calendar.render();
    });

</script>