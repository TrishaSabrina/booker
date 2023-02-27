<?php if (isset($page) && $page == 'Appointment'): ?>
<script src="<?php echo base_url() ?>assets/admin/js/jquery-ui.min.js"></script>
<script>
    $(document).ready(function () {

        var $datePicker = $("#datepickers");
        var base_url = $('#base_url').val();
        var business_id = <?php echo html_escape($this->business->uid) ?>;
        var arrayFromPHP = <?php echo json_encode($not_available) ?>;
        var disabledDays = <?php echo $this->business->holidays; ?>

        $.datepicker.regional ['en'] = {
            clearText: 'Clear', 
            clearStatus: '',
            closeText: 'Close',
            closeStatus: 'Close without modifying',
            prevStatus: 'See previous month',
            nextStatus: 'See next month',
            currentText: 'Current',
            currentStatus: 'See current month',
            monthNames: ['<?php echo trans('january') ?>', '<?php echo trans('february') ?>', '<?php echo trans('march') ?>', '<?php echo trans('april') ?>', '<?php echo trans('may') ?>', '<?php echo trans('june') ?>',
            '<?php echo trans('july') ?>', '<?php echo trans('august') ?>', '<?php echo trans('september') ?>', '<?php echo trans('october') ?>', '<?php echo trans('november') ?>', '<?php echo trans('december') ?>'],
            monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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

        $datePicker.datepicker({
            daysOfWeekDisabled: [0],
            changeMonth: false,
            changeYear: false,
            showOtherMonths: true,
            selectOtherMonths: true,
            showButtonPanel: true,
            minDate: 0,
            todayBtn: false,
            dateFormat: 'yy-mm-dd',
            onSelect: function(){
                var date = $(this).val();
                $('.booking_date').val(date);

                var url = base_url+'company/get_time/'+date+'/'+business_id;
                var post_data = {
                    'csrf_test_name' : csrf_token
                };

                $('#load_data').html('<span class="spinner-border spinner-border-sm"></span>');

                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    data: post_data,
                    success: function(data) {
                        if (data.status == 0) {
                            $('.step2_btn').prop('disabled', true);
                        }
                        $('#load_data').html(data.result);
                    }
                })

            },

            beforeShowDay: function(date) {
                var show = true;
          
                $.each(arrayFromPHP, function (i, elem) {
                    if(date.getDay() == elem-1) show = false
                });

                // holidays
                var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
                for (i = 0; i < disabledDays.length; i++) {
                    if($.inArray(y + '-' + (m+1) + '-' + d,disabledDays) != -1) {
                        show = false
                    }
                }
                
                return [show];
            }


        });
    });
</script>
<?php endif ?>



<?php if (isset($page_title) && $page_title == 'Holidays'): ?>
<script src="<?php echo base_url() ?>assets/admin/js/jquery-ui.min.js"></script>
<script>
    $(document).ready(function () {

        var $datePicker = $("#holiday_picker");
        var base_url = $('#base_url').val();
        var business_id = <?php echo html_escape($this->business->uid) ?>;
        var disabledDays = <?php echo $this->business->holidays; ?>
        
       

        $.datepicker.regional ['en'] = {
            clearText: 'Clear', 
            clearStatus: '',
            closeText: 'Close',
            closeStatus: 'Close without modifying',
            prevStatus: 'See previous month',
            nextStatus: 'See next month',
            currentText: 'Current',
            currentStatus: 'See current month',
            monthNames: ['<?php echo trans('january') ?>', '<?php echo trans('february') ?>', '<?php echo trans('march') ?>', '<?php echo trans('april') ?>', '<?php echo trans('may') ?>', '<?php echo trans('june') ?>',
            '<?php echo trans('july') ?>', '<?php echo trans('august') ?>', '<?php echo trans('september') ?>', '<?php echo trans('october') ?>', '<?php echo trans('november') ?>', '<?php echo trans('december') ?>'],
            monthNamesShort: ['<?php echo trans('january') ?>', '<?php echo trans('february') ?>', '<?php echo trans('march') ?>', '<?php echo trans('april') ?>', '<?php echo trans('may') ?>', '<?php echo trans('june') ?>',
            '<?php echo trans('july') ?>', '<?php echo trans('august') ?>', '<?php echo trans('september') ?>', '<?php echo trans('october') ?>', '<?php echo trans('november') ?>', '<?php echo trans('december') ?>'],
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

        $datePicker.datepicker({
            daysOfWeekDisabled: [0],
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            showButtonPanel: true,
            todayBtn: false,
            dateFormat: 'yy-m-d',

            onSelect: function(){
                var date = $(this).val();
                $('.booking_time').val('');

                var url = base_url+'admin/settings/add_holidays/'+date;
                var post_data = {
                    'csrf_test_name' : csrf_token
                };

                $('#load_data').html('<span class="spinner-border spinner-border-sm"></span>');

                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    data: post_data,
                    success: function(data) {
                        if (data.status == 1) {
                            window.location.href = base_url+'admin/settings/holidays?msg=success';
                        }
                    }
                })

            },


            beforeShowDay: function(date) {
                var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
                for (i = 0; i < disabledDays.length; i++) {
                    if($.inArray(y + '-' + (m+1) + '-' + d,disabledDays) != -1) {
                        //return [false];
                        return [true, 'ui-state-actived', ''];
                    }
                }
                return [true];
            }

        });
    });
</script>
<?php endif ?>