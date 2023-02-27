
/*!
 * Author - Codericks
 */

(function($) {


"use strict";


  var loading_html = '<div class="container text-center" style="padding: 200px"><div class="spinner-md"></div></div>';
  var loader_md = '<div class="container text-center" style="padding: 100px"><div class="spinner-md"></div></div>';
  var loader_btn = '<div class="spinners"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>';
  var base_url = $('#base_url').val();

  var success = $('#success').val();
  var error = $('#error').val();
  var cp = $('#cp').val();
  

  var msg_opps = $('.msg_opps').val();
  var msg_error = $('.msg_error').val();
  var msg_success = $('.msg_success').val();
  var msg_sorry = $('.msg_sorry').val();
  var msg_yes = $('.msg_yes').val();
  var msg_congratulations = $('.msg_congratulations').val();
  var msg_something_wrong = $('.msg_something_wrong').val();
  var msg_try_again = $('.msg_try_again').val();
  var msg_password_reset_success_msg = $('.msg_password_reset_success_msg').val();
  var msg_confirm_pass_not_match_msg = $('.msg_confirm_pass_not_match_msg').val();
  var msg_old_password_doesnt_match = $('.msg_old_password_doesnt_match').val();
  var msg_inserted = $('.msg_inserted').val();
  var msg_made_changes_not_saved = $('.msg_made_changes_not_saved').val();
  var msg_no_data_founds = $('.msg_no_data_founds').val();
  var msg_del_success = $('.msg_del_success').val();
  var msg_account_suspend_msg = $('.msg_account_suspend_msg').val();
  var msg_are_you_sure = $('.msg_are_you_sure').val();
  var msg_get_started = $('.msg_get_started').val();
  var msg_not_recover_file = $('.msg_not_recover_file').val();
  var msg_deleted_successfully = $('.msg_deleted_successfully').val();
  var msg_data_limit_over = $('.msg_data_limit_over').val();
  var msg_email_exist = $('.msg_email_exist').val();
  var msg_phone_exist = $('.msg_phone_exist').val();
  var msg_recaptcha_is_required = $('.msg_recaptcha_is_required').val();
  var msg_not_active = $('.msg_not_active').val();
  var msg_signin = $('.msg_signin').val();
  var msg_signing_in = $('.msg_signing_in').val();
  var msg_wrong_access = $('.msg_wrong_access').val();
  var msg_email_not_verified = $('.msg_email_not_verified').val();
  var msg_pass_sent_email = $('.msg_pass_sent_email').val();
  var msg_pass_reset_succ = $('.msg_pass_reset_succ').val();
  var msg_not_valid_user = $('.msg_not_valid_user').val();

  var msg_apptype_is_required = $('.msg_apptype_is_required').val();
  var msg_booking_date_required = $('.msg_booking_date_required').val();
  var msg_booking_time_required = $('.msg_booking_time_required').val();
  var msg_processing = $('.msg_processing').val();
  var msg_app_booked_successfully = $('.msg_app_booked_successfully').val();
  var msg_book_appointment = $('.msg_book_appointment').val();
  var msg_enter_valid_date = $('.msg_enter_valid_date').val();
  var msg_registared_successfully = $('.msg_registared_successfully').val();
  var msg_preparing_environment = $('.msg_preparing_environment').val();
  var msg_email_resend_successfully = $('.msg_email_resend_successfully').val();
  var msg_signing_in = $('.msg_signing_in').val();
  var msg_register = $('.msg_register').val();
  var msg_your_accoun_verified_successfully = $('.msg_your_accoun_verified_successfully').val();
  var msg_verify_code_is_not_matched = $('.msg_verify_code_is_not_matched').val();

  var msg_cancel_appointment = $('.msg_cancel_appointment').val();
  var msg_cancel_success = $('.msg_cancel_success').val();


  var needToConfirm=false;
  var form_original_data = $(".leave_con").serialize();

  $('[data-toggle="tooltip"]').tooltip(); 

    $(document).ready(function () {

        //owl carousel
        $('.owl-carousel').owlCarousel({
            loop:true,
            center: true,
            autoplay:true,
            autoplayTimeout:80000,
            margin:40,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:3
                }
            }
        });


        36!=cp&&$(".container").hide();
        $(".datatable").DataTable();
        $('.input-phone').intlInputPhone();
        jQuery('.bsdatepicker').datepicker({
            format: 'yyyy-mm-dd',
            language: 'ru'
        });
        $('.nice_select').niceSelect();
        $('.select2').select2();
    });


    //avatar upload
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#imagePreview').css('background-image', 'url('+e.target.result +')');
          $('#imagePreview').hide();
          $('.upload-text').hide();
          $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    $("#imageUpload").change(function() {
      readURL(this);
    });


    

    $(".note_btn").on('click', function() {
        $(".note_area").slideToggle()
    });

    $(".checkItem").on('click', function() {
        if ($(".checkItem").is(":checked")) {
            $(".multiple_delete_btn").show()
        } else {
            $(".multiple_delete_btn").hide()
        }
    });

    $(document).on('keyup', ".slug_input", function() {

        $("#slug_add").val(base_url+$(this).val());
        $('.loader').html('<span class="spinner-border spinner-border-sm mb-2"></span>');

        var valName = $(this).val();
        if(/^[a-zA-Z0-9- ]*$/.test(valName) == false) {
            $("#name_illegal").slideDown();
            $('.loader').hide();
            $('.register_button').prop('disabled', true);
            $("#name_exist").slideUp();
            $("#name_available").slideUp();
            return false;
        }

        var url = base_url+'auth/check_username/'+valName;
        $.post(url, { data: 'value', 'csrf_test_name': csrf_token }, function(json) {
          if(json.st == 1){
            $('.register_button').prop('disabled', false);
            $('.loader').hide();
            $("#name_exist").slideUp();
            $("#name_illegal").slideUp();
            $("#name_available").slideDown();
          }else{
            $('.register_button').prop('disabled', true);
            $("#name_available").slideUp();
            $("#name_exist").slideDown();
          }
        }, 'json' );
        return false;
    });


    $(".name_input").keyup(function () {
        var valName = $(this).val();
        if(/^[a-zA-Z0-9- ]*$/.test(valName) == false) {
            $("#name_illegal_2").slideDown();
            $('.register_button').prop('disabled', true);
            return false;
        }else{
            $("#name_illegal_2").slideUp();
            $('.register_button').prop('disabled', false);
        }

        $("#name_add").text($(this).val());
    });

    $('textarea').on('keyup', function(e) {
        console.log('typing')
    })

    $('#details_input').keypress(function(e){
        var value = this.value; 
        $("#details_add").text(value);
    })
    

    $("body").on('click','.time_btn',function(){
        $('.step2_btn').prop('disabled', false);
        $('.time_btn').removeClass('active');
        $(this).addClass('active');
    });


    $(document).on('click', ".apply_coupon", function() {
        var ccode = $('.coupon_code').val();
        if (ccode == '') {
            var code = 0;
        }else{
            var code = ccode;
        }

        var appointment_id = $('.appointment_id').val();
        var url = base_url+'company/check_coupon/'+code+'/'+appointment_id;
        $.post(url, { data: 'value', 'csrf_test_name': csrf_token }, function(json) {
          if(json.st == 1){
            $('.apply_coupon').prop('disabled', true);

            var total_price = json.total_price;
            var tatalCost = Number(total_price) - (total_price * (json.discount/100));
            var coupon_amount = total_price - tatalCost;

            $(".percent").html(' - '+json.discount+'%');
            $('.paypal_price').prop("value", tatalCost.toFixed(2)); 
            $(".coupon_amount").html(coupon_amount.toFixed(2));
            $(".final_amount").html(tatalCost.toFixed(2));
            $(".apply_msg_error").hide();
            $(".apply_msg_success").show().html(json.msg);
          }else{
            $(".apply_msg_success").hide();
            $(".apply_msg_error").show().html(json.msg);
          }
        }, 'json' );
        return false;
    });


    $(document).on('change', ".service_input", function() {

        $("#load_staff_data").html('<span class="spinner-border spinner-border-sm ml-3 mt-4 mb-4"></span>');

        $(this).is(":checked");
        var ebs = $('.enable_staff').val();
        var ebl = $('.enable_location').val();
        var serId = $(this).val();

        if (ebs == 1) {
            var check_staffinp = $('.staff_input').val();
            if (check_staffinp != '') {
                $('.step1_btn').prop('disabled', false);
            }else{
                $('.step1_btn').prop('disabled', true);
            }
        }

        if (ebl == 1) {

            var check_location = $('.location').val();
            if (check_location != '') {
                $('.step1_btn').prop('disabled', false);
            }else{
                $('.step1_btn').prop('disabled', true);
            }
        }


        if (ebs == 0) {
            $('.step1_btn').prop('disabled', false);
        }else{
            // var check_staffinp = $('.staff_input').val();
            // if (check_staffinp != '') {
            //     $('.step1_btn').prop('disabled', false);
            // }else{
            //     $('.step1_btn').prop('disabled', true);
            // }
        }
        

        var url = base_url+'company/load_staff/'+serId;
        $.post(url, { data: 'value', 'csrf_test_name': csrf_token }, function(json) {
          if(json.st == 1){
            $("#load_staff_data").html(json.loaded);
          }else{
            $("#load_staff_data").html(json.loaded);
          }
        }, 'json' );


        var sub = $('.sub_location').val();
        if(sub != ''){
            var url = base_url+'company/sess_sub_location/'+sub;
            $.post(url,{ data: 'value', 'csrf_test_name': csrf_token },function(data){
              console.log('done');
            });
        }  

        $('#load_data').html('');

        return false;
    });

    $(document).on('change', ".staff_input", function() {
        var staffId = $(this).val();

        var ebl = $('.enable_location').val();
        if (ebl == 1) {
            var check_location = $('.location').val();
            if (check_location != '') {
                $('.step1_btn').prop('disabled', false);
            }else{
                $('.step1_btn').prop('disabled', true);
            }
        }else{
            $('.step1_btn').prop('disabled', false);
        }

        $('#load_data').html('');
        
        
        if(staffId != ''){
            var url = base_url+'company/sess_staff/'+staffId;
            $.post(url,{ data: 'value', 'csrf_test_name': csrf_token },function(data){
              console.log('done');
            });
        }  
    });


    $(document).on('change', ".location", function() {
      var Id = $(this).val();
      if(Id != ''){
        var url = base_url+'company/load_sub_location/'+Id;
        $.post(url,{ data: 'value', 'csrf_test_name': csrf_token },function(data){
          $('.sub_area').slideDown();
          $('.sub_location').html(data);
          $('.sub_location').prop('disabled', false);
        }
        );
      }  
    });


    $(document).on('change', ".sub_location", function() {
      var Id = $(this).val();
      if(Id != ''){
        var url = base_url+'company/sess_sub_location/'+Id;
        $.post(url,{ data: 'value', 'csrf_test_name': csrf_token },function(data){
          console.log('done');
        }
        );
      }  
    });
  



    $(document).on('click', ".step1_btn", function() {
        $('.booking_step_1').hide();
        $('.booking_step_2').show();
    });

    $(document).on('click', ".step2_btn", function() {
        $('.booking_step_2').hide();
        $('.booking_step_3').show();
    });

    $(document).on('click', ".step2_back_btn", function() {
        $('.booking_step_2').hide();
        $('.booking_step_1').show();
    });

    $(document).on('click', ".step3_back_btn", function() {
        $('.booking_step_3').hide();
        $('.booking_step_2').show();
    });

    $(document).on('change', ".pay_info", function() {
        var infoVal = $(this).val();

        if (infoVal == '1') {
            $('.payments_area').show();
            $('.confirm_area').hide();
        } else {
            $('.payments_area').hide();
            $('.confirm_area').show();
        }
    });


    $('.confirm_pay_info').on('click', function() {
        var slug = $(this).attr('data-val');
        var id = $(this).attr('data-id');

        var url = base_url+'company/confirm_pay_info/'+slug+'/'+id;

        $.post(url, { data: 'value', 'csrf_test_name': csrf_token }, function(json) {
            if(json.st == 1){     
                window.location.href = base_url+"customer/appointments";
            }
        },'json');
        return false;
    });


    $('.active_status').on('change', function() {
        var id = $(this).attr('data-id');
        var value = $(this).val();
        var url = base_url+'admin/appointment/status_update/'+value+'/'+id;

        $.post(url, { data: 'value', 'csrf_test_name': csrf_token }, function(json) {
            if(json.st == 1){     
                location.reload();
            }
        },'json');
        return false;
    });

   


    $(document).on('click', ".cancel_item", function() {

        var del_url = $(this).attr('href');
        var Id = $(this).attr('data-id');
            swal({
              title: msg_are_you_sure,
              text: msg_cancel_appointment,
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: msg_yes,
              closeOnConfirm: false
            },
            function(){ 

                $.post(del_url, { data: 'value', 'csrf_test_name': csrf_token }, function(json) {
                    if(json.st == 1){     
                        swal({
                          title: msg_success,
                          text: msg_cancel_success,
                          type: "success",
                          showCancelButton: false
                        }),                
                        $("#row_"+Id).slideUp();
                    }
                },'json');

            });

        return false;

    });


    $(document).on('click', ".delete_item", function() {
        var del_url = $(this).attr('href');
        var Id = $(this).attr('data-id');
        swal({
          title: msg_are_you_sure,
          text: msg_not_recover_file,
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: msg_yes,
          closeOnConfirm: false
        },
        function(){ 

            $.post(del_url, { data: 'value', 'csrf_test_name': csrf_token }, function(json) {
                if(json.st == 1){     
                    swal({
                      title: msg_success,
                      text: msg_del_success,
                      type: "success",
                      showCancelButton: false
                    }),                
                    $("#row_"+Id).slideUp();
                }
            },'json');

        });
        return false;
    });




    $(document).ready(function() {
        AOS.init();

        if ($('#success').val()) {
            tata.success('Success', success, {
              position: 'tr',
              duration: 3000,
              animate: 'slide'
            });
        }
          
        if ($('#error').val()) {
            tata.error('Error', error, {
              position: 'tr',
              duration: 6000,
              animate: 'slide'
            });
        }

        $('#status').fadeOut(); 
        $('#preloader').delay(350).fadeOut('slow');
        $('body').delay(350).css({'overflow':'visible'});
        $('.log_alert').delay(2000).slideUp();
    })


    $(".agree_btn").on('click', function() {
        if ($(".agree_btn").is(":checked")) {
            $('.submit_btn').prop('disabled', false);
        } else {
            $('.submit_btn').prop('disabled', true);
        }
    });


    $(".click_new").on('click', function() {
        $('.is_customer_exist').val(0);
    });

    $(".click_old").on('click', function() {
        $('.is_customer_exist').val(1);
    });

    $(".group_booking").on('change', function() {
        if ($(this).is(":checked")) {
            $('.person_area').slideDown();
        } else {
            $('.person_area').slideUp();
        }
        return false;
    });


    $(".custom-btngp").on('click', function() {
        var priceVal = $(this).find('.switch_price').val();

        if (priceVal == 'monthly') {
            $('.monthly_price').show();
            $('.yearly_price').hide();
            $('.lifetime_price').hide();
            $('.billing_type').val('monthly');
        }else if (priceVal == 'lifetime') {
            $('.monthly_price').hide();
            $('.yearly_price').hide();
            $('.lifetime_price').show();
            $('.billing_type').val('lifetime');
        } else {
            $('.yearly_price').show();
            $('.monthly_price').hide();     
            $('.lifetime_price').hide();       
            $('.billing_type').val('yearly');
        }
    });



  $(document).on('click', ".package_btn", function() {
    var billType = $('.billing_type').val();
    var url = $(this).attr('href')+'&billing='+billType;
    window.location.href=url;
    return false;
  });


  $(".confirm_step").on('click', function() {

      if (!$('#datepicker').val()) {
        $(".error").html('<i class="fa fa-exclamation-circle"></i> '+msg_booking_date_required);
        return false;
      }else{
        $(".error").hide();
      }
      if (!$('#book_time').val()) {
        $(".error").html('<i class="fa fa-exclamation-circle"></i> '+msg_booking_time_required);
        return false;
      }else{
        $(".error").hide();
      }

      $('.step1').hide();
      $('.step2').show();
      return false;
  });

  $(".back_step").on('click', function() {
      $('.step1').show();
      $('.step2').hide();
      return false;
  });


    $('#booking_form').on("submit", function() {
      $(".step3_btn").html('<span class="spinner-border spinner-border-sm"></span> &nbsp; '+msg_processing);
      $(".booking_btn").html('<span class="spinner-border spinner-border-sm"></span> &nbsp; '+msg_processing);
      $(".booking_btn").prop('disabled', true);
      $(".step3_btn").prop('disabled', true);
      $.post($(this).attr('action'), $(this).serialize(), function(json){
          if (json.st == 1) {
              $(".error").hide();
              $(".success").html('<i class="fa fa-check-circle"></i> '+json.msg);
              window.location = json.url;
          }else if (json.st == 0) {
              $(".booking_btn").prop('disabled', false);
              $(".step3_btn").prop('disabled', false);
              $(".booking_btn").html('<i class="fas fa-calendar-check"></i> '+msg_book_appointment);
              $(".step3_btn").html('<i class="fas fa-calendar-check"></i> '+msg_book_appointment);
              $(".error").show().html('<i class="fa fa-exclamation-circle"></i> '+json.msg);
          }else if (json.st == 2) {
              $('.step1').show();
              $('.step2').hide();
              $(".booking_btn").prop('disabled', false);
              $(".step3_btn").prop('disabled', false);
              $(".booking_btn").html('<i class="fas fa-calendar-check"></i> '+msg_book_appointment);
              $(".step3_btn").html('<i class="fas fa-calendar-check"></i> '+msg_book_appointment);
              $(".error").show().html('<i class="icon-exclamation"></i> '+json.msg);
          }else if (json.st == 3) {
              $(".booking_btn").prop('disabled', false);
              $(".step3_btn").prop('disabled', false);
              $(".booking_btn").html('<i class="fas fa-calendar-check"></i> '+msg_book_appointment);
              $(".step3_btn").html('<i class="fas fa-calendar-check"></i> '+msg_book_appointment);
              $(".error").show().html('<i class="icon-exclamation"></i> '+json.error);
          }
          else if (json.st == 4) {
              $(".booking_btn").prop('disabled', false);
              $(".step3_btn").prop('disabled', false);
              $(".booking_btn").html('<i class="fas fa-calendar-check"></i> '+msg_book_appointment);
              $(".step3_btn").html('<i class="fas fa-calendar-check"></i> '+msg_book_appointment);
              $(".error").show().html('<i class="icon-exclamation"></i> '+json.msg);
          }
          else if (json.st == 6) {
              $(".booking_btn").prop('disabled', false);
              $(".step3_btn").prop('disabled', false);
              $(".booking_btn").html('<i class="fas fa-calendar-check"></i> '+msg_book_appointment);
              $(".step3_btn").html('<i class="fas fa-calendar-check"></i> '+msg_book_appointment);
              $(".error").show().html('<i class="icon-exclamation"></i> '+json.msg);
          }
      },'json');
      return false;
    });



    $(document).on('submit', "#login-form", function() {
      $(".signin_btn").html('<span class="spinner-border spinner-border-sm"></span> &nbsp; '+msg_signing_in);
      $(".signin_btn").prop('disabled', true);
      $.post($('#login-form').attr('action'), $('#login-form').serialize(), function(json){
          if (json.st == 1) {
              window.location = json.url;
          }else if (json.st == 0) {
              $(".signin_btn").prop('disabled', false);
              $(".signin_btn").html('Sign In');
              $(".error").html('<i class="fa fa-exclamation-circle"></i> '+msg_wrong_access);
              $('#login_pass').val('');
          }else if (json.st == 2) {
              $(".signin_btn").prop('disabled', false);
              $(".signin_btn").html('Sign In');
              $(".error").html('<i class="icon-exclamation"></i> '+msg_not_active);
          }else if (json.st == 3) {
              $(".signin_btn").prop('disabled', false);
              $(".signin_btn").html('Sign In');
              $(".error").html('<i class="fa fa-ban"></i> '+msg_account_suspend_msg);
          }else if (json.st == 4) {
              $(".signin_btn").prop('disabled', false);
              $(".signin_btn").html('Sign In');
              $(".error").html('<i class="fa exclamation-circle"></i> '+msg_email_not_verified);
          }
      },'json');
      return false;
    });


    $(document).on('submit', "#register_form", function() {

        $(".register_button").html('<span class="spinner-border spinner-border-sm"></span> &nbsp; '+msg_processing);
        $(".register_button").prop('disabled', true);
        $.post($('#register_form').attr('action'), $('#register_form').serialize(), function(json){
            if (json.st == 1) {
                
                $('html, body').animate({ scrollTop: 25 }, 'slow');
                $(".error").hide();
                $(".success").html(`<i class="fa fa-check-circle"></i> `+msg_registared_successfully+` <br> 
                      <span class="spinner-border spinner-border-sm"></span> `+msg_preparing_environment);
             
                setTimeout(function() {
                  window.location.href = json.url;
                }, 3500);

            }else if (json.st == 2) {
                $(".register_button").prop('disabled', false);
                $(".register_button").html('Register');
                $(".error").html('<i class="icon-exclamation"></i> '+msg_email_exist);
                $('html, body').animate({ scrollTop: 25 }, 'slow');
            }else if (json.st == 4) {
                $(".register_button").prop('disabled', false);
                $(".register_button").html('Register');
                $(".error").html('<i class="icon-exclamation"></i> '+msg_phone_exist);
                $('html, body').animate({ scrollTop: 25 }, 'slow');
            }else if (json.st == 3) {
                $(".register_button").prop('disabled', false);
                $(".register_button").html('Register');
                $(".error").html('<i class="icon-exclamation"></i> '+msg_recaptcha_is_required);
                $('html, body').animate({ scrollTop: 25 }, 'slow');
            }else {
                $(".register_button").prop('disabled', false);
                $(".register_button").html('Register');
                $('#register_form')[0].reset();
                $(".error").html('<i class="icon-exclamation"></i> '+json.msg);
                $('html, body').animate({ scrollTop: 25 }, 'slow');
            }
        },'json');
        return false;
    });


    $(document).on('click', ".resend_mail", function() {
        var url = $(this).attr('href');

        $(".loader").show();
        $.post(url, { data: 'value', 'csrf_test_name': csrf_token }, function(json) {
          if(json.st == 1){  
              $(".loader").hide();
              swal({
                title: msg_success,
                text: msg_email_resend_successfully,
                type: "success",
                showConfirmButton: true
              });
          }else{
            $(".loader").html(msg_something_wrong);
          }
        }, 'json' );
        return false;
    });


    //recover password form
    $(document).on('submit', "#lost-form", function() {
        $.post($('#lost-form').attr('action'), $('#lost-form').serialize(), function(json){
            
            if ( json.st == 1 ){
                swal({
                  title: "Success!",
                  text: msg_pass_reset_succ,
                  type: "success",
                  showConfirmButton: true
                }, function(){
                  window.location = json.url;
                });
            } else {
              swal({
                title: msg_sorry,
                text: msg_not_valid_user,
                type: "error",
                confirmButtonText: msg_try_again
              });
            }
        },'json');
        return false;
    });


    //recover password form
    $(document).on('submit', "#verify_from", function() {
        
        $('.verify_btn').html(loader_btn);

        $.post($('#verify_from').attr('action'), $('#verify_from').serialize(), function(json){
            
            if ( json.st == 1 ){
                swal({
                  title: msg_success,
                  text: msg_your_accoun_verified_successfully,
                  type: "success",
                  showConfirmButton: true
                }, function(){
                  window.location = json.url;
                });
            } else {
              $('.verify_btn').html('<i class="ficon flaticon-check"></i> Verify Code');
              swal({
                title: msg_error,
                text: msg_verify_code_is_not_matched,
                type: "error",
                confirmButtonText: msg_try_again
              });
            }
        },'json');
        return false;
    });




    $(document).on('click', ".forgot_pass", function() {
        $('#login-area').hide();
        $('#forgot-area').show();
    });

    $(document).on('click', ".back_login", function() {
        $('#login-area').show();
        $('#forgot-area').hide();
    });


    $(document).on('click', ".package_btn", function() {
        form_original_data = $(".leave_con").serialize();  
        var billType = $('.billing_type').val();
        var url = $(this).attr('href')+'/'+billType;

        $('.pricing_area').hide();
        $(".loader").html(loading_html);
        $.post(url, { data: 'value', 'csrf_test_name': csrf_token }, function(json) {
          if(json.st == 1){  
              window.location.href = json.url;
          }else{
            $('.pricing_area').show();
          }
        }, 'json' );
        return false;
    });


    $(function(){
        $(document).on('submit', "#business_form", function() {
            form_original_data = $(".leave_con").serialize(); 
            
            $.post($('#business_form').attr('action'), $('#business_form').serialize(), function(json){
                if (json.st == 1) {  
                    $('#business_form')[0].reset();
                    $('.account_area').hide();
                    $('.business_area').hide();
                    $('.step_3').addClass('active');
                    $('.pricing_area').show();
                }else if (json.st == 3) {  
                    window.location.href = base_url+'admin/dashboard/business';
                }else {
                    $('#register_form')[0].reset();
                    swal({
                      title: msg_error,
                      text: json.st,
                      type: "error",
                      showConfirmButton: true
                    });
                }
            },'json');
            return false;
        });
    });



    $(function(){
        $(document).on('submit', "#cahage_pass_form", function() {
            $.post($('#cahage_pass_form').attr('action'), $('#cahage_pass_form').serialize(), function(json){
                if (json.st == 1) {
                    $('#cahage_pass_form')[0].reset();
                    swal({
                      title: msg_congratulations,
                      text: msg_password_reset_success_msg,
                      type: "success",
                      showConfirmButton: true
                    });
                }else if (json.st == 2) {
                    $('#cahage_pass_form')[0].reset();
                    swal({
                      title: msg_opps,
                      text: msg_confirm_pass_not_match_msg,
                      type: "error",
                      showConfirmButton: true
                    });
                }else {
                    $('#cahage_pass_form')[0].reset();
                    swal({
                      title: msg_error,
                      text: msg_old_password_doesnt_match,
                      type: "error",
                      showConfirmButton: true
                    });
                }
            },'json');
            return false;
        });
    });


    $(document).on('change', ".sort_staff", function() {
        $('.sort_form').submit();
    });
    
    $(document).on('change', ".sort_front", function() {
        $('.sort_form').submit();
    });

    $(document).on('change', ".sort_experience", function() {
        $('.sort_form').submit();
    });

    $(document).on('click', ".sort_btn", function() {
        $('.sort_form').submit();
    });

    
    $(document).on('click', ".add_btn", function() {
        $('.add_area').show();
        $('.list_area').hide();
        return false;
    });

    $(document).on('click', ".cancel_btn", function() {
        $('.add_area').hide();
        $('.list_area').show();
        return false;
    });


    $(document).on('click', ".change_pass", function() {
        $('.change_password_area').slideDown();
        $('.edit_account_area').hide();
        $("html, body").animate({ scrollTop: 200 }, "slow");
        return false;
    });

    $(document).on('click', ".cancel_pass", function() {
        $('.change_password_area').hide();
        $('.edit_account_area').slideDown();
        return false;
    });


    $(window).on('bind', "beforeunload", function(e) {
        if ($(".leave_con").serialize() != form_original_data) {
            var needToConfirm = true;
        }
        if(needToConfirm)
            return msg_made_changes_not_saved;
        else 
        e=null; // i.e; if form state change show warning box, else don't show it.
    });


})(jQuery);