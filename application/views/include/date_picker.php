<script>
    // $(document).ready(function () {
    //     var $datePicker = $("div#datepickers");

    //     var base_url = $('#base_url').val();
    //     var business_id = <?php echo html_escape($service->business_id) ?>;
    //     var service_id = <?php echo html_escape($service->id) ?>;
    //     var arrayFromPHP = ["6"];

    //     $datePicker.datepicker({
    //         changeMonth: false,
    //         changeYear: false,
    //         showOtherMonths: true,
    //         selectOtherMonths: true,
    //         showButtonPanel: true,
    //         minDate: 0,
    //         todayBtn: false,
    //         dateFormat: 'yy-mm-dd',
    //         beforeShowDay: function(date) {
    //             var show = true;
    //             //foreach
    //             $.each(arrayFromPHP, function (i, elem) {
    //                 if(date.getDay() == elem-1) show = false
    //             });
                
    //             return [show];
    //         },

    //         onSelect: function(){
    //             var date = $(this).val();
    //             $('.booking_date').val(date);

    //             var url = base_url+'company/get_time/'+date+'/'+business_id;
    //             var post_data = {
    //                 'csrf_test_name' : csrf_token
    //             };

    //             $('#load_data').html('<span class="spinner-border spinner-border-sm"></span>');

    //             $.ajax({
    //                 type: "POST",
    //                 url: url,
    //                 dataType: 'json',
    //                 data: post_data,
    //                 success: function(data) {
    //                     if (data.status == 0) {
    //                         $('.step2_btn').prop('disabled', true);
    //                     }
    //                     $('#load_data').html(data.result);
    //                 }
    //             })

    //         }

            

    //     });
    // });

</script>