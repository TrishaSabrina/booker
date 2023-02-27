<script type="text/javascript">

    <?php if (isset($flutterwave_type) && $flutterwave_type == 'admin'): ?>                                          
        document.addEventListener("DOMContentLoaded", (event) => {
            // Add an event listener for when the user clicks the submit button to pay
            document.getElementById("flutterwave_payment").addEventListener("click", (e) => {
            e.preventDefault();
            const PBFKey = '<?php echo settings()->flutterwave_public_key ?>'; // paste in the public key from your dashboard here
            const txRef = ''+Math.floor((Math.random() * 1000000000) + 1); //Generate a random id for the transaction reference
            const email = '<?php echo user()->email ?>';
            const phone = '<?php echo user()->phone ?>';
            const amount = '<?php echo html_escape($price) ?>';
         

            // getpaidSetup is Rave's inline script function. it holds the payment data to pass to Rave.
            getpaidSetup({
                PBFPubKey: PBFKey,
                customer_email: email,
                amount: amount,
                customer_phone: phone,
                currency: "<?php echo settings()->currency_code ?>",  // Select the currency. leaving it empty defaults to NGN
                txref: txRef, // Pass your UNIQUE TRANSACTION REFERENCE HERE.
            
                onclose: function() {},
                callback: function(response) {
                    flw_ref = response.tx.flwRef;
                    // collect flwRef returned and pass to a server page to complete status check. //if(response.tx.chargeResponse =='00' || response.tx.chargeResponse == '0') {} else {}

                    console.log("This is the response returned after a charge", response);
                    
                    window.location.href='<?php echo base_url('admin/subscription/payment_success/'.$billing_type.'/'.html_escape($package->id).'/'.html_escape($payment_id).'/flutterwave') ?>';

                    
                }
              });
            });
        });
    <?php else: ?>

        <?php 
          if (settings()->enable_wallet == 1) {
                $public_key = settings()->flutterwave_public_key;
            }else{
                $public_key = $user->flutterwave_public_key;
          }
        ?>
        document.addEventListener("DOMContentLoaded", (event) => {
            // Add an event listener for when the user clicks the submit button to pay
            document.getElementById("flutterwave_payment").addEventListener("click", (e) => {
            e.preventDefault();
            const PBFKey = '<?php echo $public_key ?>'; // paste in the public key from your dashboard here
            const txRef = ''+Math.floor((Math.random() * 1000000000) + 1); //Generate a random id for the transaction reference
            const email = '<?php echo $email ?>';
            const phone = '<?php echo $phone ?>';
            const amount = '<?php echo html_escape($price) ?>';
         

            // getpaidSetup is Rave's inline script function. it holds the payment data to pass to Rave.
            getpaidSetup({
                PBFPubKey: PBFKey,
                customer_email: email,
                amount: amount,
                customer_phone: phone,
                currency: "<?php echo $currency_code ?>",  // Select the currency. leaving it empty defaults to NGN
                txref: txRef, // Pass your UNIQUE TRANSACTION REFERENCE HERE.
            
                onclose: function() {},
                callback: function(response) {
                    flw_ref = response.tx.flwRef;
                    // collect flwRef returned and pass to a server page to complete status check. //if(response.tx.chargeResponse =='00' || response.tx.chargeResponse == '0') {} else {}

                    console.log("This is the response returned after a charge", response);
                    
                    window.location.href='<?php echo base_url('admin/payment/payment_success/'.html_escape($appointment->id).'/flutterwave') ?>';

                    
                }
              });
            });
        });
    <?php endif; ?>

</script>