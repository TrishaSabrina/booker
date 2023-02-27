<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Payment Invoice</title>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/admin_default.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/custom-invoice.css">
</head>

<body>

  <div class="main-box">
    
    <div class="invoice-box print_area <?php if(isset($page_title) && $page_title != 'Export'){echo "br1 shadow";} ?>">

        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="3">
                    <table>
                        <tr>
                            <?php if (!empty($this->business->logo)): ?>
                                <td class="title">
                                    <img src="<?php echo base_url($this->business->logo) ?>" class="w-40">
                                </td>
                            <?php endif ?>
                            
                            <td>
                                <?php echo trans('invoice') ?> - <?php echo html_escape(sprintf('%02d', $user->id)) ?><br>
                                <?php echo trans('order-no') ?>: <?php echo html_escape($user->puid) ?> <br> 
                                <?php echo trans('date') ?>: <?php echo my_date_show($user->created_at) ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <?php $price = $user->amount;  ?>
            
            <tr class="information">
                <td colspan="3">
                    <table>
                        <tr>
                            <td>
                                <?php echo html_escape($this->business->name) ?><br>
                                <?php echo html_escape($this->business->email) ?>
                            </td>
                            
                            <td>
                                <strong><?php echo get_by_id($user->customer_id, 'customers')->name ?></strong><br>
                                  <p class="mb-0"><?php echo get_by_id($user->customer_id, 'customers')->email ?></p>
                                <?php if (!empty(get_by_id($user->customer_id, 'customers')->phone)): ?>
                                  <p class="mb-1"><?php echo get_by_id($user->customer_id, 'customers')->phone ?></p>
                                <?php endif ?>
                                
                                <?php if ($user->status == 'pending'): ?>
                                  <span class="float-right badge badge-danger-soft"> <?php echo trans('payment') ?> - <?php echo trans('pending') ?></span>
                                <?php elseif ($user->status == 'verified'): ?>
                                  <span class="float-right badge badge-success-soft"> <?php echo trans('payment') ?> - <?php echo trans('paid') ?></span>
                                <?php endif ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        

            <tr class="heading">
                <td>
                    <?php echo trans('service') ?>
                </td>
                
                <td>
                    <?php echo trans('price') ?>
                </td>

                <td class="text-right">
                    <?php echo trans('total') ?>
                </td>
            </tr>
            
            <?php $service = get_by_id($user->service_id, 'services'); ?>
            <?php 
              $appointment = get_by_id($user->appointment_id, 'appointments');

              $price = $service->price;
              

              $check_coupon = check_coupon($appointment->id, $appointment->service_id, $appointment->business_id);
              if ($check_coupon != FALSE):
                  if (!empty($check_coupon)):
                      $price =  get_price($price, $appointment->group_booking, $appointment->total_person);
                      $discount = $check_coupon->discount;
                      $amount = $price - ($price * ($discount / 100));
                      $discount_amount = abs($amount - $price);
                  else:
                      $price =  get_price($price, $appointment->group_booking, $appointment->total_person);
                      $discount = 0;
                      $discount_amount = 0;
                      $amount = $price;
                  endif;
              else:
                  $discount = 0;
                  $amount =  get_price($price, $appointment->group_booking, $appointment->total_person);
              endif;
            ?>


            <tr class="item">
              <td>
                <?php echo html_escape($service->name) ?> <br> <span class="fs-12"><?php echo html_escape($service->duration).' '.trans($service->duration_type); ?></span>
                
              </td>

              <td>

                <?php if ($appointment->group_booking != 0): ?>
                    <?php echo $appointment->total_person + 1 ?> x
                <?php endif; ?>

                <?php if($this->business->curr_locate == 0){echo $this->business->currency_symbol;} ?><?php echo number_format($service->price, $this->business->num_format) ?> <?php if($this->business->curr_locate == 1){echo $this->business->currency_symbol;} ?>
                    
              </td>

              <td class="text-right"><?php if($this->business->curr_locate == 0){echo $this->business->currency_symbol;} ?><?php echo number_format($price, $this->business->num_format) ?> <?php if($this->business->curr_locate == 1){echo $this->business->currency_symbol;} ?></td>
            </tr>
            
            
            <?php if ($discount > 0): ?>
            <tr class="item">
                <td></td>
                <td class="text-right"><strong><?php echo html_escape($discount) ?>% <?php echo trans('off') ?></strong></td>
                <td class="text-right"><span><strong><?php if($this->business->curr_locate == 0){echo $this->business->currency_symbol;} ?><?php echo number_format($discount_amount, $this->business->num_format) ?> <?php if($this->business->curr_locate == 1){echo $this->business->currency_symbol;} ?></strong></span></td>
            </tr>
            <?php endif ?>

            <tr class="item">
                <td></td>
                <td class="text-right"><strong><?php echo trans('sub-total') ?></strong></td>
                <td class="text-right"><span><strong><?php if($this->business->curr_locate == 0){echo $this->business->currency_symbol;} ?><?php echo html_escape(number_format($amount,$this->business->num_format)) ?> <?php if($this->business->curr_locate == 1){echo $this->business->currency_symbol;} ?></strong></span></td>
            </tr>

            <tr class="total">
                <td></td>
                <td class="text-right"><strong><?php echo trans('total') ?></strong></td>
                <td class="text-right"><span><strong><?php if($this->business->curr_locate == 0){echo $this->business->currency_symbol;} ?><?php echo html_escape(number_format($amount,$this->business->num_format)) ?> <?php if($this->business->curr_locate == 1){echo $this->business->currency_symbol;} ?></strong></span></td>
            </tr>

            <tr>
              <td></td>
            </tr>
            <tr>
              <td></td>
            </tr>
            <tr>
              <td></td>
            </tr>
            <tr>
              <td></td>
            </tr>

        </table>

        <div class="pwf">
          <?php echo trans('powered-by') ?> - <?php echo html_escape(settings()->site_name) ?>
        </div>
    </div>
  </div>



</body>
</html>
