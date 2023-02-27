<?php 


    mysqli_query($connection, "UPDATE settings SET version = '1.5' WHERE id = 1;");

    mysqli_query($connection, "ALTER TABLE `business` ADD `enable_guest` VARCHAR(155) NULL DEFAULT '0' AFTER `enable_group`;");

    mysqli_query($connection, "ALTER TABLE `settings` ADD `enable_coupon` INT NULL DEFAULT '0' AFTER `enable_lifetime`;");

    mysqli_query($connection, "ALTER TABLE `services` ADD `google_meet` TEXT NULL DEFAULT NULL AFTER `zoom_link`;");

    mysqli_query($connection, "UPDATE `features` SET `name` = 'Virtual Meeting(Zoom, Google Meet)' WHERE `features`.`id` = 7;");

    mysqli_query($connection, "UPDATE `lang_values` SET `english` = 'Virtual Meeting(Zoom, Google Meet)' WHERE `lang_values`.`keyword` = 'zoom-meeting';");

    mysqli_query($connection, "ALTER TABLE `settings` ADD `paystack_payment` VARCHAR(155) NULL DEFAULT '0' AFTER `secret_key`, ADD `paystack_secret_key` VARCHAR(255) NULL DEFAULT NULL AFTER `paystack_payment`, ADD `paystack_public_key` VARCHAR(255) NULL DEFAULT NULL AFTER `paystack_secret_key`;");

    mysqli_query($connection, "ALTER TABLE `users` ADD `paystack_payment` VARCHAR(155) NULL DEFAULT '0' AFTER `secret_key`, ADD `paystack_secret_key` VARCHAR(255) NULL DEFAULT NULL AFTER `paystack_payment`, ADD `paystack_public_key` VARCHAR(255) NULL DEFAULT NULL AFTER `paystack_secret_key`;");


    mysqli_query($connection, "
        INSERT INTO `lang_values` (`type`, `label`, `keyword`, `english`) VALUES
        ('user', 'Apply your coupon code here', 'apply-your-coupon-code-here', 'Apply your coupon code here'),
        ('user', 'Coupons limit', 'coupons-limit', 'Coupons limit'),
        ('user', 'How many days will be active this coupon', 'how-many-days-will-be-active-this-coupon', 'How many days will be active this coupon'),
        ('user', 'Discount must be between 1% - 99%', 'discount-must-be-between', 'Discount must be between 1% - 99%'),
        ('user', 'Export as CSV', 'export-as-csv', 'Export as CSV'),
        ('user', 'Codes', 'codes', 'Codes'),
        ('user', 'See all codes', 'see-all-codes', 'See all codes'),
        ('user', 'Your name string contains illegal characters.', 'illegal-characters-title', 'Your name string contains illegal characters.'),
        ('user', 'Please Complete these steps', 'please-complete-these-steps', 'Please Complete these steps'),
        ('user', 'Set Business Hours', 'set-business-hours', 'Set Business Hours'),
        ('user', 'Add Staff', 'add-staff', 'Add Staff'),
        ('user', 'Add Customer', 'add-customer', 'Add Customer'),
        ('user', 'Add Service', 'add-service', 'Add Service'),
        ('user', 'Enter phone number with dial code', 'enter-phone-number-with-dial-code', 'Enter phone number with dial code'),
        ('user', 'Cities', 'cities', 'Cities'),
        ('user', 'Location is required', 'location-required', 'Location is required'),
        ('admin', 'Paystack', 'paystack', 'Paystack'),
        ('admin', 'Setup Your Paystack Account to Accept Payments', 'paystack-title', 'Setup Your Paystack Account to Accept Payments'),
        ('user', 'Recently booked an appointment at', 'recently-booked-an-appointment', 'Recently booked an appointment at'),
        ('user', 'New appointment is booked', 'new-appointment-is-booked', 'Booked new appointment'),
        ('user', 'Quantity', 'quantity', 'Quantity'),
        ('user', 'Coupon code already applied', 'coupon-code-already-applied', 'Coupon code already applied'),
        ('user', 'Have any coupon code?', 'have-any-coupon-code', 'Have any coupon code?'),
        ('user', 'Enable to active coupon code feature', 'enable-coupon-title', 'Enable to active coupon code feature'),
        ('user', 'Allow Google Meet', 'allow-google-meet', 'Allow Google Meet'),
        ('user', 'Google meet link', 'google-meet-link', 'Google meet invitation link'),
        ('user', 'Google Meet', 'google-meet', 'Google Meet'),
        ('user', 'Virtual Meeting', 'virtual-meeting', 'Virtual Meeting'),
        ('user', 'Zoom', 'zoom', 'Zoom'),
        ('user', 'Enable Coupon from', 'enable-coupon-from', 'Enable Coupon from');
    ");

    mysqli_query($connection, "CREATE TABLE `plan_coupons_apply` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `user_id` int(11) NOT NULL,
      `coupon_id` int(11) NOT NULL,
      `created_at` date NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

    mysqli_query($connection, "CREATE TABLE `plan_coupons` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `uid` varchar(255) NOT NULL,
      `name` varchar(255) DEFAULT NULL,
      `user_id` varchar(155) DEFAULT '0',
      `plan` varchar(255) NOT NULL,
      `plan_type` varchar(255) DEFAULT NULL,
      `code` varchar(255) NOT NULL,
      `days` varchar(155) DEFAULT NULL,
      `discount` int(11) NOT NULL,
      `discount_type` varchar(155) DEFAULT NULL,
      `start_date` date DEFAULT NULL,
      `end_date` date DEFAULT NULL,
      `quantity` int(11) DEFAULT '0',
      `used` int(11) NOT NULL,
      `status` int(11) NOT NULL,
      `apply_date` varchar(255) DEFAULT NULL,
      `created_at` datetime NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");



    //version 1.6
	
	mysqli_query($connection, "UPDATE settings SET version = '1.6' WHERE id = 1;");

    mysqli_query($connection, "ALTER TABLE `appointments` ADD `sync_calendar_staff` VARCHAR(155) NULL DEFAULT '0' AFTER `sync_calendar`, ADD `sync_calendar_user` VARCHAR(155) NULL DEFAULT '0' AFTER `sync_calendar_staff`;");

    mysqli_query($connection, "ALTER TABLE `business` ADD `holidays` LONGTEXT NULL DEFAULT NULL AFTER `enable_onsite`;");

    mysqli_query($connection, "ALTER TABLE `working_days` ADD `staff_id` VARCHAR(155) NULL DEFAULT '0' AFTER `user_id`;");

    mysqli_query($connection, "ALTER TABLE `settings` ADD `enable_wallet` VARCHAR(155) NULL DEFAULT '0' AFTER `enable_sms`, ADD `min_payout_amount` VARCHAR(155) NULL DEFAULT '0' AFTER `enable_wallet`, ADD `commission_rate` VARCHAR(155) NULL DEFAULT '0' AFTER `min_payout_amount`;");

    mysqli_query($connection, "ALTER TABLE `settings` ADD `paypal_payout` VARCHAR(155) NULL DEFAULT '1' AFTER `commission_rate`, ADD `iban_payout` VARCHAR(155) NULL DEFAULT '1' AFTER `paypal_payout`, ADD `swift_payout` VARCHAR(155) NULL DEFAULT '1' AFTER `iban_payout`;");


    mysqli_query($connection, "ALTER TABLE `payment_user` ADD `type` VARCHAR(155) NOT NULL DEFAULT 'user' AFTER `payment_method`;");

    mysqli_query($connection, "ALTER TABLE `users` ADD `balance` BIGINT NULL DEFAULT '0' AFTER `slug`, ADD `total_sales` BIGINT NULL DEFAULT '0' AFTER `balance`;");

    mysqli_query($connection, "ALTER TABLE `payment_user` ADD `total_amount` DECIMAL(10,2) NULL DEFAULT '0' AFTER `amount`, ADD `commission_amount` DECIMAL(10,2) NULL DEFAULT '0' AFTER `total_amount`, ADD `commission_rate` INT NULL DEFAULT '0' AFTER `commission_amount`;");



    mysqli_query($connection, "ALTER TABLE `appointments` CHANGE `business_id` `business_id` VARCHAR(255) NULL DEFAULT '0';");
    mysqli_query($connection, "ALTER TABLE `customers` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';");
    mysqli_query($connection, "ALTER TABLE `coupons` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';");
    mysqli_query($connection, "ALTER TABLE `coupons_apply` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';");
    mysqli_query($connection, "ALTER TABLE `gallery` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';");
    mysqli_query($connection, "ALTER TABLE `locations` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';");
    mysqli_query($connection, "ALTER TABLE `ratings` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';");
    mysqli_query($connection, "ALTER TABLE `services` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';");
    mysqli_query($connection, "ALTER TABLE `service_category` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';");
    mysqli_query($connection, "ALTER TABLE `staffs` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';");
    mysqli_query($connection, "ALTER TABLE `staff_locations` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';");
    mysqli_query($connection, "ALTER TABLE `working_days` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';");
    mysqli_query($connection, "ALTER TABLE `working_time` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';");

    mysqli_query($connection, "
            INSERT INTO `lang_values` (`type`, `label`, `keyword`, `english`) VALUES
            ('user', 'Holidays', 'holidays', 'Holidays'),
            ('user', 'Interval Settings', 'interval-settings', 'Interval Settings'),
            ('user', 'Enable Appointment Reminder', 'enable-appointment-reminder', 'Enable Appointment Reminder'),
            ('user', 'Send reminder email', 'send-reminder-email', 'Send reminder email'),
            ('user', 'Same day', 'same-day', 'Same day'),
            ('user', 'Before', 'before', 'Before'),
            ('user', 'Login', 'login', 'Login'),
            ('user', 'Trial', 'trial', 'Trial'),
            ('user', 'Plan Coupons', 'plan-coupons', 'Plan Coupons'),
            ('user', 'System Settings', 'system-settings', 'System Settings'),
            ('user', 'Guest Booking', 'guest-booking', 'Guest Booking'),
            ('user', 'Enable Guest Booking', 'enable-guest-booking', 'Enable Guest Booking'),
            ('user', 'Enable to allow guest booking', 'enable-guest-booking-title', 'Enable to allow guest booking'),
            ('user', 'Wallet Settings', 'wallet-settings', 'Wallet Settings'),
            ('user', 'Commission Rate', 'commission-rate', 'Commission Rate'),
            ('user', 'Minimum Payout Amount', 'minimum-payout-amount', 'Minimum Payout Amount'),
            ('user', 'Enable Payouts', 'enable-payouts', 'Enable Payouts'),
            ('user', 'Enable to active payouts module and receive users appointment payment to admin account.', 'enable-payout-title', 'Enable to active payouts module and receive users appointment payment to admin account.'),
            ('user', 'Payouts', 'payouts', 'Payouts'),
            ('user', 'Setup Payout Accounts', 'setup-payout-accounts', 'Setup Payout Accounts'),
            ('user', 'Set Payout Account', 'set-payout-account', 'Set Payout Account'),
            ('user', 'Full Name', 'full-name', 'Full Name'),
            ('user', 'IBAN', 'iban', 'IBAN'),
            ('user', 'Bank Name', 'bank-name', 'Bank Name'),
            ('user', 'International Bank Account Number(IBAN) ', 'iban-number', 'International Bank Account Number(IBAN) '),
            ('user', 'State', 'state', 'State'),
            ('user', 'City', 'city', 'City'),
            ('user', 'Postcode', 'post-code', 'Postcode'),
            ('user', 'Bank Account Holder\'s Name', 'bank-account-holders-name', 'Bank Account Holder\'s Name'),
            ('user', 'Bank Branch Country', 'bank-branch-country', 'Bank Branch Country'),
            ('user', 'Bank Branch City', 'bank-branch-city', 'Bank Branch City'),
            ('user', 'Bank Account Number', 'bank-account-number', 'Bank Account Number'),
            ('user', 'Swift Code', 'swift-code', 'Swift Code'),
            ('user', 'Swift', 'swift', 'Swift'),
            ('user', 'Invalid withdrawal amount!', 'invalid-withdrawal-amount', 'Invalid withdrawal amount!'),
            ('user', 'Payout request sent successfully !', 'payout-request-sent-successfully', 'Payout request sent successfully !'),
            ('user', 'Minimum Payout Amounts', 'minimum-payout-amounts', 'Minimum Payout Amounts'),
            ('user', 'Empty Paypal email', 'empty-paypal-email', 'Empty Paypal email'),
            ('user', 'Empty IBAN info', 'empty-iban-info', 'Empty IBAN info'),
            ('user', 'Empty Swift info', 'empty-swift-info', 'Empty Swift info'),
            ('user', 'Transaction ID', 'transaction-id', 'Transaction ID'),
            ('user', 'Withdrawal Method', 'withdrawal-method', 'Withdrawal Method'),
            ('user', 'Amount', 'amount', 'Amount'),
            ('user', 'Send Payout Request', 'send-payout-request', 'Send Payout Request'),
            ('user', 'Total Earnings', 'total-earnings', 'Total Earnings'),
            ('user', 'Total Withdraw', 'total-withdraw', 'Total Withdraw'),
            ('user', 'Balance', 'balance', 'Balance'),
            ('user', 'after commission of', 'after-commission-of', 'after commission of'),
            ('user', 'Payout Settings', 'payout-settings', 'Payout Settings'),
            ('user', 'Payout Requests', 'payout-requests', 'Payout Requests'),
            ('user', 'Payout Completed', 'payout-completed', 'Payout Completed'),
            ('user', 'Request Sent', 'request-sent', 'Request Sent'),
            ('user', 'Enable / Disable Payout Methods', 'enabledisable-payout-methods', 'Enable / Disable Payout Methods'),
            ('user', 'must be between 1% - 99%', 'must-be-between-1-99', 'must be between 1% - 99%'),
            ('user', 'Payout History', 'payout-history', 'Payout History'),
            ('user', 'Payout Method', 'payout-method', 'Payout Method'),
            ('user', 'Add Payout', 'add-payout', 'Add Payout'),
            ('user', 'Wallet', 'wallet', 'Wallet'),
            ('user', 'User Dashboard', 'user-dashboard', 'User Dashboard'),
            ('user', 'has been', 'has-been', 'has been'),
            ('user', 'Appointment Reminder', 'appointment-reminder', 'Appointment Reminder'),
            ('user', 'Tomorrow you have an appointment', 'tomorrow-you-have-an-appointment', 'Tomorrow you have an appointment'),
            ('user', 'Dear', 'dear', 'Dear'),
            ('user', 'thank you for your booking at our', 'thank-you-for-your-booking-at-our', 'thank you for your booking at our'),
            ('user', 'at', 'at', 'at'),
            ('user', 'is', 'is', 'is'),
            ('user', 'Confirmed', 'confirmed', 'Confirmed'),
            ('user', 'Rate this service', 'rate-this-service', 'Rate this service'),
            ('user', 'Your feedback', 'your-feedback', 'Your feedback');
        ");
		
		mysqli_query($connection, "CREATE TABLE `payouts` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `user_id` int(11) NOT NULL,
		  `payout_method` varchar(255) NOT NULL,
		  `amount` bigint(20) NOT NULL,
		  `transaction_id` varchar(255) DEFAULT NULL,
		  `message` text,
		  `currency` varchar(255) DEFAULT NULL,
		  `status` int(11) NOT NULL,
		  `created_at` datetime NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");



		mysqli_query($connection, "CREATE TABLE `users_payout_accounts` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `user_id` int(11) DEFAULT NULL,
		  `payout_paypal_email` varchar(255) DEFAULT NULL,
		  `payout_bank_info` mediumtext,
		  `iban_full_name` varchar(255) DEFAULT NULL,
		  `iban_country_id` varchar(20) DEFAULT NULL,
		  `iban_bank_name` varchar(255) DEFAULT NULL,
		  `iban_number` varchar(500) DEFAULT NULL,
		  `swift_full_name` varchar(255) DEFAULT NULL,
		  `swift_address` varchar(500) DEFAULT NULL,
		  `swift_state` varchar(255) DEFAULT NULL,
		  `swift_city` varchar(255) DEFAULT NULL,
		  `swift_postcode` varchar(100) DEFAULT NULL,
		  `swift_country_id` varchar(20) DEFAULT NULL,
		  `swift_bank_account_holder_name` varchar(255) DEFAULT NULL,
		  `swift_iban` varchar(255) DEFAULT NULL,
		  `swift_code` varchar(255) DEFAULT NULL,
		  `swift_bank_name` varchar(255) DEFAULT NULL,
		  `swift_bank_branch_city` varchar(255) DEFAULT NULL,
		  `swift_bank_branch_country_id` varchar(20) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");






		// version 1.7

		mysqli_query($connection, "UPDATE settings SET version = '1.7' WHERE id = 1;");

        mysqli_query($connection, "ALTER TABLE `settings` ADD `enable_animation` INT NULL DEFAULT '1' AFTER `enable_faq`;");
        mysqli_query($connection, "UPDATE `lang_values` SET `english` = 'Public key' WHERE `lang_values`.`keyword` = 'publish-key';");

        mysqli_query($connection, "ALTER TABLE `settings` ADD `flutterwave_payment` INT NULL DEFAULT '0' AFTER `razorpay_key_secret`, ADD `flutterwave_public_key` VARCHAR(255) NULL AFTER `flutterwave_payment`, ADD `flutterwave_secret_key` VARCHAR(255) NULL AFTER `flutterwave_public_key`;");

        mysqli_query($connection, "ALTER TABLE `users` ADD `flutterwave_payment` INT NULL DEFAULT '0' AFTER `razorpay_key_secret`, ADD `flutterwave_public_key` VARCHAR(255) NULL AFTER `flutterwave_payment`, ADD `flutterwave_secret_key` VARCHAR(255) NULL AFTER `flutterwave_public_key`;");

        mysqli_query($connection, "UPDATE `lang_values` SET `english` = ' Click here to copy below code and add to your website' WHERE `lang_values`.`keyword` = 'embed-code-copy';");

        mysqli_query($connection, "ALTER TABLE `pages` ADD `business_id` VARCHAR(255) NOT NULL DEFAULT '0' AFTER `id`;");


        

        mysqli_query($connection, "
            INSERT INTO `lang_values` (`type`, `label`, `keyword`, `english`) VALUES
            ('admin', 'Dear', 'dear', 'Dear'),
            ('admin', 'thank you for your booking at our', 'thank-you-for-your-booking-at-our', 'thank you for your booking at our'),
            ('admin', 'at', 'at', 'at'),
            ('admin', 'is', 'is', 'is'),
            ('admin', 'Confirmed', 'confirmed', 'Confirmed'),
            ('admin', 'Rate this service', 'rate-this-service', 'Rate this service'),
            ('admin', 'Your feedback', 'your-feedback', 'Your feedback'),
            ('admin', 'Your account has been created successfully, now you can login to your account using below access', 'new-user-account-login', 'Your account has been created successfully, now you can login to your account using below access'),
            ('admin', 'Site Animation', 'site-animation', 'Site Animation'),
            ('admin', 'Enable to activate website animation', 'site-animation-title', 'Enable to activate website animation'),
            ('admin', 'Enable', 'enable', 'Enable'),
            ('admin', 'Amount Withdraw', 'amount-withdraw', 'Amount Withdraw'),
            ('admin', 'Flutterwave', 'flutterwave', 'Flutterwave'),
            ('admin', 'Copy', 'copy', 'Copy'),
            ('admin', 'Copied', 'copied', 'Copied');
        ");








		// version 1.8

		mysqli_query($connection, "UPDATE settings SET version = '1.8' WHERE id = 1;");

        mysqli_query($connection, "ALTER TABLE `settings` ADD `sender_mail` VARCHAR(255) NULL DEFAULT NULL AFTER `is_smtp`;");

        mysqli_query($connection, "ALTER TABLE `settings` ADD `mercado_payment` INT NULL DEFAULT '0' AFTER `razorpay_key_secret`, ADD `mercado_currency` VARCHAR(155) NULL AFTER `mercado_payment`, ADD `mercado_api_key` VARCHAR(255) NULL AFTER `mercado_currency`, ADD `mercado_token` VARCHAR(255) NULL AFTER `mercado_api_key`;");

        mysqli_query($connection, "ALTER TABLE `users` ADD `mercado_payment` INT NULL DEFAULT '0' AFTER `razorpay_key_secret`, ADD `mercado_currency` VARCHAR(155) NULL AFTER `mercado_payment`, ADD `mercado_api_key` VARCHAR(255) NULL AFTER `mercado_currency`, ADD `mercado_token` VARCHAR(255) NULL AFTER `mercado_api_key`;");


        mysqli_query($connection, "UPDATE `lang_values` SET `english` = 'must be between 1% - 100%' WHERE `lang_values`.`keword` = 'must-be-between-1-99';");
        

        mysqli_query($connection, "
            INSERT INTO `lang_values` (`type`, `label`, `keyword`, `english`) VALUES
            ('admin', 'Sender Email', 'sender-email', 'Sender Email'),
            ('admin', 'Access Token', 'access-token', 'Access Token'),
            ('admin', 'Password Recovery', 'password-recovery', 'Password Recovery'),
            ('admin', 'Hello', 'hello', 'Hello'),
            ('admin', 'We have reset your password, Please use this', 'we-reset-pass', 'We have reset your password, Please use below'),
            ('admin', 'code to login your account', 'code-to-login-your-account', 'code to login your account');
        ");

        mysqli_query($connection, "CREATE TABLE `booking_val` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `business_id` varchar(155) COLLATE utf8_unicode_ci DEFAULT '0',
		  `staff_id` varchar(155) COLLATE utf8_unicode_ci DEFAULT '0',
		  `service_id` varchar(155) COLLATE utf8_unicode_ci DEFAULT '0',
		  `location_id` varchar(155) COLLATE utf8_unicode_ci DEFAULT '0',
		  `sub_location_id` varchar(155) COLLATE utf8_unicode_ci DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");










    mysqli_query($connection, "UPDATE settings SET version = '1.9' WHERE id = 1;");

?>





















<?php 

    UPDATE settings SET version = '1.5' WHERE id = 1;

    ALTER TABLE `business` ADD `enable_guest` VARCHAR(155) NULL DEFAULT '0' AFTER `enable_group`;

    ALTER TABLE `settings` ADD `enable_coupon` INT NULL DEFAULT '0' AFTER `enable_lifetime`;

    ALTER TABLE `services` ADD `google_meet` TEXT NULL DEFAULT NULL AFTER `zoom_link`;

    UPDATE `features` SET `name` = 'Virtual Meeting(Zoom, Google Meet)' WHERE `features`.`id` = 7;

    UPDATE `lang_values` SET `english` = 'Virtual Meeting(Zoom, Google Meet)' WHERE `lang_values`.`keyword` = 'zoom-meeting';

    ALTER TABLE `settings` ADD `paystack_payment` VARCHAR(155) NULL DEFAULT '0' AFTER `secret_key`, ADD `paystack_secret_key` VARCHAR(255) NULL DEFAULT NULL AFTER `paystack_payment`, ADD `paystack_public_key` VARCHAR(255) NULL DEFAULT NULL AFTER `paystack_secret_key`;

    ALTER TABLE `users` ADD `paystack_payment` VARCHAR(155) NULL DEFAULT '0' AFTER `secret_key`, ADD `paystack_secret_key` VARCHAR(255) NULL DEFAULT NULL AFTER `paystack_payment`, ADD `paystack_public_key` VARCHAR(255) NULL DEFAULT NULL AFTER `paystack_secret_key`;


    
        INSERT INTO `lang_values` (`type`, `label`, `keyword`, `english`) VALUES
        ('user', 'Apply your coupon code here', 'apply-your-coupon-code-here', 'Apply your coupon code here'),
        ('user', 'Coupons limit', 'coupons-limit', 'Coupons limit'),
        ('user', 'How many days will be active this coupon', 'how-many-days-will-be-active-this-coupon', 'How many days will be active this coupon'),
        ('user', 'Discount must be between 1% - 99%', 'discount-must-be-between', 'Discount must be between 1% - 99%'),
        ('user', 'Export as CSV', 'export-as-csv', 'Export as CSV'),
        ('user', 'Codes', 'codes', 'Codes'),
        ('user', 'See all codes', 'see-all-codes', 'See all codes'),
        ('user', 'Your name string contains illegal characters.', 'illegal-characters-title', 'Your name string contains illegal characters.'),
        ('user', 'Please Complete these steps', 'please-complete-these-steps', 'Please Complete these steps'),
        ('user', 'Set Business Hours', 'set-business-hours', 'Set Business Hours'),
        ('user', 'Add Staff', 'add-staff', 'Add Staff'),
        ('user', 'Add Customer', 'add-customer', 'Add Customer'),
        ('user', 'Add Service', 'add-service', 'Add Service'),
        ('user', 'Enter phone number with dial code', 'enter-phone-number-with-dial-code', 'Enter phone number with dial code'),
        ('user', 'Cities', 'cities', 'Cities'),
        ('user', 'Location is required', 'location-required', 'Location is required'),
        ('admin', 'Paystack', 'paystack', 'Paystack'),
        ('admin', 'Setup Your Paystack Account to Accept Payments', 'paystack-title', 'Setup Your Paystack Account to Accept Payments'),
        ('user', 'Recently booked an appointment at', 'recently-booked-an-appointment', 'Recently booked an appointment at'),
        ('user', 'New appointment is booked', 'new-appointment-is-booked', 'Booked new appointment'),
        ('user', 'Quantity', 'quantity', 'Quantity'),
        ('user', 'Coupon code already applied', 'coupon-code-already-applied', 'Coupon code already applied'),
        ('user', 'Have any coupon code?', 'have-any-coupon-code', 'Have any coupon code?'),
        ('user', 'Enable to active coupon code feature', 'enable-coupon-title', 'Enable to active coupon code feature'),
        ('user', 'Allow Google Meet', 'allow-google-meet', 'Allow Google Meet'),
        ('user', 'Google meet link', 'google-meet-link', 'Google meet invitation link'),
        ('user', 'Google Meet', 'google-meet', 'Google Meet'),
        ('user', 'Virtual Meeting', 'virtual-meeting', 'Virtual Meeting'),
        ('user', 'Zoom', 'zoom', 'Zoom'),
        ('user', 'Enable Coupon from', 'enable-coupon-from', 'Enable Coupon from');
    

    CREATE TABLE `plan_coupons_apply` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `user_id` int(11) NOT NULL,
      `coupon_id` int(11) NOT NULL,
      `created_at` date NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    CREATE TABLE `plan_coupons` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `uid` varchar(255) NOT NULL,
      `name` varchar(255) DEFAULT NULL,
      `user_id` varchar(155) DEFAULT '0',
      `plan` varchar(255) NOT NULL,
      `plan_type` varchar(255) DEFAULT NULL,
      `code` varchar(255) NOT NULL,
      `days` varchar(155) DEFAULT NULL,
      `discount` int(11) NOT NULL,
      `discount_type` varchar(155) DEFAULT NULL,
      `start_date` date DEFAULT NULL,
      `end_date` date DEFAULT NULL,
      `quantity` int(11) DEFAULT '0',
      `used` int(11) NOT NULL,
      `status` int(11) NOT NULL,
      `apply_date` varchar(255) DEFAULT NULL,
      `created_at` datetime NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;








	
	UPDATE settings SET version = '1.6' WHERE id = 1;

    ALTER TABLE `appointments` ADD `sync_calendar_staff` VARCHAR(155) NULL DEFAULT '0' AFTER `sync_calendar`, ADD `sync_calendar_user` VARCHAR(155) NULL DEFAULT '0' AFTER `sync_calendar_staff`;

    ALTER TABLE `business` ADD `holidays` LONGTEXT NULL DEFAULT NULL AFTER `enable_onsite`;

    ALTER TABLE `working_days` ADD `staff_id` VARCHAR(155) NULL DEFAULT '0' AFTER `user_id`;

    ALTER TABLE `settings` ADD `enable_wallet` VARCHAR(155) NULL DEFAULT '0' AFTER `enable_sms`, ADD `min_payout_amount` VARCHAR(155) NULL DEFAULT '0' AFTER `enable_wallet`, ADD `commission_rate` VARCHAR(155) NULL DEFAULT '0' AFTER `min_payout_amount`;

    ALTER TABLE `settings` ADD `paypal_payout` VARCHAR(155) NULL DEFAULT '1' AFTER `commission_rate`, ADD `iban_payout` VARCHAR(155) NULL DEFAULT '1' AFTER `paypal_payout`, ADD `swift_payout` VARCHAR(155) NULL DEFAULT '1' AFTER `iban_payout`;


    ALTER TABLE `payment_user` ADD `type` VARCHAR(155) NOT NULL DEFAULT 'user' AFTER `payment_method`;

    ALTER TABLE `users` ADD `balance` BIGINT NULL DEFAULT '0' AFTER `slug`, ADD `total_sales` BIGINT NULL DEFAULT '0' AFTER `balance`;

    ALTER TABLE `payment_user` ADD `total_amount` DECIMAL(10,2) NULL DEFAULT '0' AFTER `amount`, ADD `commission_amount` DECIMAL(10,2) NULL DEFAULT '0' AFTER `total_amount`, ADD `commission_rate` INT NULL DEFAULT '0' AFTER `commission_amount`;



    ALTER TABLE `appointments` CHANGE `business_id` `business_id` VARCHAR(255) NULL DEFAULT '0';
    ALTER TABLE `customers` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';
    ALTER TABLE `coupons` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';
    ALTER TABLE `coupons_apply` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';
    ALTER TABLE `gallery` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';
    ALTER TABLE `locations` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';
    ALTER TABLE `ratings` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';
    ALTER TABLE `services` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';
    ALTER TABLE `service_category` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';
    ALTER TABLE `staffs` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';
    ALTER TABLE `staff_locations` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';
    ALTER TABLE `working_days` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';
    ALTER TABLE `working_time` CHANGE `business_id` `business_id` VARCHAR(25) NULL DEFAULT '0';


        INSERT INTO `lang_values` (`type`, `label`, `keyword`, `english`) VALUES
        ('user', 'Holidays', 'holidays', 'Holidays'),
        ('user', 'Interval Settings', 'interval-settings', 'Interval Settings'),
        ('user', 'Enable Appointment Reminder', 'enable-appointment-reminder', 'Enable Appointment Reminder'),
        ('user', 'Send reminder email', 'send-reminder-email', 'Send reminder email'),
        ('user', 'Same day', 'same-day', 'Same day'),
        ('user', 'Before', 'before', 'Before'),
        ('user', 'Login', 'login', 'Login'),
        ('user', 'Trial', 'trial', 'Trial'),
        ('user', 'Plan Coupons', 'plan-coupons', 'Plan Coupons'),
        ('user', 'System Settings', 'system-settings', 'System Settings'),
        ('user', 'Guest Booking', 'guest-booking', 'Guest Booking'),
        ('user', 'Enable Guest Booking', 'enable-guest-booking', 'Enable Guest Booking'),
        ('user', 'Enable to allow guest booking', 'enable-guest-booking-title', 'Enable to allow guest booking'),
        ('user', 'Wallet Settings', 'wallet-settings', 'Wallet Settings'),
        ('user', 'Commission Rate', 'commission-rate', 'Commission Rate'),
        ('user', 'Minimum Payout Amount', 'minimum-payout-amount', 'Minimum Payout Amount'),
        ('user', 'Enable Payouts', 'enable-payouts', 'Enable Payouts'),
        ('user', 'Enable to active payouts module and receive users appointment payment to admin account.', 'enable-payout-title', 'Enable to active payouts module and receive users appointment payment to admin account.'),
        ('user', 'Payouts', 'payouts', 'Payouts'),
        ('user', 'Setup Payout Accounts', 'setup-payout-accounts', 'Setup Payout Accounts'),
        ('user', 'Set Payout Account', 'set-payout-account', 'Set Payout Account'),
        ('user', 'Full Name', 'full-name', 'Full Name'),
        ('user', 'IBAN', 'iban', 'IBAN'),
        ('user', 'Bank Name', 'bank-name', 'Bank Name'),
        ('user', 'International Bank Account Number(IBAN) ', 'iban-number', 'International Bank Account Number(IBAN) '),
        ('user', 'State', 'state', 'State'),
        ('user', 'City', 'city', 'City'),
        ('user', 'Postcode', 'post-code', 'Postcode'),
        ('user', 'Bank Account Holder\'s Name', 'bank-account-holders-name', 'Bank Account Holder\'s Name'),
        ('user', 'Bank Branch Country', 'bank-branch-country', 'Bank Branch Country'),
        ('user', 'Bank Branch City', 'bank-branch-city', 'Bank Branch City'),
        ('user', 'Bank Account Number', 'bank-account-number', 'Bank Account Number'),
        ('user', 'Swift Code', 'swift-code', 'Swift Code'),
        ('user', 'Swift', 'swift', 'Swift'),
        ('user', 'Invalid withdrawal amount!', 'invalid-withdrawal-amount', 'Invalid withdrawal amount!'),
        ('user', 'Payout request sent successfully !', 'payout-request-sent-successfully', 'Payout request sent successfully !'),
        ('user', 'Minimum Payout Amounts', 'minimum-payout-amounts', 'Minimum Payout Amounts'),
        ('user', 'Empty Paypal email', 'empty-paypal-email', 'Empty Paypal email'),
        ('user', 'Empty IBAN info', 'empty-iban-info', 'Empty IBAN info'),
        ('user', 'Empty Swift info', 'empty-swift-info', 'Empty Swift info'),
        ('user', 'Transaction ID', 'transaction-id', 'Transaction ID'),
        ('user', 'Withdrawal Method', 'withdrawal-method', 'Withdrawal Method'),
        ('user', 'Amount', 'amount', 'Amount'),
        ('user', 'Send Payout Request', 'send-payout-request', 'Send Payout Request'),
        ('user', 'Total Earnings', 'total-earnings', 'Total Earnings'),
        ('user', 'Total Withdraw', 'total-withdraw', 'Total Withdraw'),
        ('user', 'Balance', 'balance', 'Balance'),
        ('user', 'after commission of', 'after-commission-of', 'after commission of'),
        ('user', 'Payout Settings', 'payout-settings', 'Payout Settings'),
        ('user', 'Payout Requests', 'payout-requests', 'Payout Requests'),
        ('user', 'Payout Completed', 'payout-completed', 'Payout Completed'),
        ('user', 'Request Sent', 'request-sent', 'Request Sent'),
        ('user', 'Enable / Disable Payout Methods', 'enabledisable-payout-methods', 'Enable / Disable Payout Methods'),
        ('user', 'must be between 1% - 99%', 'must-be-between-1-99', 'must be between 1% - 99%'),
        ('user', 'Payout History', 'payout-history', 'Payout History'),
        ('user', 'Payout Method', 'payout-method', 'Payout Method'),
        ('user', 'Add Payout', 'add-payout', 'Add Payout'),
        ('user', 'Wallet', 'wallet', 'Wallet'),
        ('user', 'User Dashboard', 'user-dashboard', 'User Dashboard'),
        ('user', 'has been', 'has-been', 'has been'),
        ('user', 'Appointment Reminder', 'appointment-reminder', 'Appointment Reminder'),
        ('user', 'Tomorrow you have an appointment', 'tomorrow-you-have-an-appointment', 'Tomorrow you have an appointment'),
        ('user', 'Dear', 'dear', 'Dear'),
        ('user', 'thank you for your booking at our', 'thank-you-for-your-booking-at-our', 'thank you for your booking at our'),
        ('user', 'at', 'at', 'at'),
        ('user', 'is', 'is', 'is'),
        ('user', 'Confirmed', 'confirmed', 'Confirmed'),
        ('user', 'Rate this service', 'rate-this-service', 'Rate this service'),
        ('user', 'Your feedback', 'your-feedback', 'Your feedback');
        
		
		CREATE TABLE `payouts` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `user_id` int(11) NOT NULL,
		  `payout_method` varchar(255) NOT NULL,
		  `amount` bigint(20) NOT NULL,
		  `transaction_id` varchar(255) DEFAULT NULL,
		  `message` text,
		  `currency` varchar(255) DEFAULT NULL,
		  `status` int(11) NOT NULL,
		  `created_at` datetime NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;



		CREATE TABLE `users_payout_accounts` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `user_id` int(11) DEFAULT NULL,
		  `payout_paypal_email` varchar(255) DEFAULT NULL,
		  `payout_bank_info` mediumtext,
		  `iban_full_name` varchar(255) DEFAULT NULL,
		  `iban_country_id` varchar(20) DEFAULT NULL,
		  `iban_bank_name` varchar(255) DEFAULT NULL,
		  `iban_number` varchar(500) DEFAULT NULL,
		  `swift_full_name` varchar(255) DEFAULT NULL,
		  `swift_address` varchar(500) DEFAULT NULL,
		  `swift_state` varchar(255) DEFAULT NULL,
		  `swift_city` varchar(255) DEFAULT NULL,
		  `swift_postcode` varchar(100) DEFAULT NULL,
		  `swift_country_id` varchar(20) DEFAULT NULL,
		  `swift_bank_account_holder_name` varchar(255) DEFAULT NULL,
		  `swift_iban` varchar(255) DEFAULT NULL,
		  `swift_code` varchar(255) DEFAULT NULL,
		  `swift_bank_name` varchar(255) DEFAULT NULL,
		  `swift_bank_branch_city` varchar(255) DEFAULT NULL,
		  `swift_bank_branch_country_id` varchar(20) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;











		UPDATE settings SET version = '1.7' WHERE id = 1;

        ALTER TABLE `settings` ADD `enable_animation` INT NULL DEFAULT '1' AFTER `enable_faq`;
        UPDATE `lang_values` SET `english` = 'Public key' WHERE `lang_values`.`keyword` = 'publish-key';

        ALTER TABLE `settings` ADD `flutterwave_payment` INT NULL DEFAULT '0' AFTER `razorpay_key_secret`, ADD `flutterwave_public_key` VARCHAR(255) NULL AFTER `flutterwave_payment`, ADD `flutterwave_secret_key` VARCHAR(255) NULL AFTER `flutterwave_public_key`;

        ALTER TABLE `users` ADD `flutterwave_payment` INT NULL DEFAULT '0' AFTER `razorpay_key_secret`, ADD `flutterwave_public_key` VARCHAR(255) NULL AFTER `flutterwave_payment`, ADD `flutterwave_secret_key` VARCHAR(255) NULL AFTER `flutterwave_public_key`;

        UPDATE `lang_values` SET `english` = ' Click here to copy below code and add to your website' WHERE `lang_values`.`keyword` = 'embed-code-copy';

        ALTER TABLE `pages` ADD `business_id` VARCHAR(255) NOT NULL DEFAULT '0' AFTER `id`;

        

        
        INSERT INTO `lang_values` (`type`, `label`, `keyword`, `english`) VALUES
        ('admin', 'Dear', 'dear', 'Dear'),
        ('admin', 'thank you for your booking at our', 'thank-you-for-your-booking-at-our', 'thank you for your booking at our'),
        ('admin', 'at', 'at', 'at'),
        ('admin', 'is', 'is', 'is'),
        ('admin', 'Confirmed', 'confirmed', 'Confirmed'),
        ('admin', 'Rate this service', 'rate-this-service', 'Rate this service'),
        ('admin', 'Your feedback', 'your-feedback', 'Your feedback'),
        ('admin', 'Your account has been created successfully, now you can login to your account using below access', 'new-user-account-login', 'Your account has been created successfully, now you can login to your account using below access'),
        ('admin', 'Site Animation', 'site-animation', 'Site Animation'),
        ('admin', 'Enable to activate website animation', 'site-animation-title', 'Enable to activate website animation'),
        ('admin', 'Enable', 'enable', 'Enable'),
        ('admin', 'Amount Withdraw', 'amount-withdraw', 'Amount Withdraw'),
        ('admin', 'Flutterwave', 'flutterwave', 'Flutterwave'),
        ('admin', 'Copy', 'copy', 'Copy'),
        ('admin', 'Copied', 'copied', 'Copied');
        











		UPDATE settings SET version = '1.8' WHERE id = 1;

        ALTER TABLE `settings` ADD `sender_mail` VARCHAR(255) NULL DEFAULT NULL AFTER `is_smtp`;

        ALTER TABLE `settings` ADD `mercado_payment` INT NULL DEFAULT '0' AFTER `razorpay_key_secret`, ADD `mercado_currency` VARCHAR(155) NULL AFTER `mercado_payment`, ADD `mercado_api_key` VARCHAR(255) NULL AFTER `mercado_currency`, ADD `mercado_token` VARCHAR(255) NULL AFTER `mercado_api_key`;

        ALTER TABLE `users` ADD `mercado_payment` INT NULL DEFAULT '0' AFTER `razorpay_key_secret`, ADD `mercado_currency` VARCHAR(155) NULL AFTER `mercado_payment`, ADD `mercado_api_key` VARCHAR(255) NULL AFTER `mercado_currency`, ADD `mercado_token` VARCHAR(255) NULL AFTER `mercado_api_key`;


        UPDATE `lang_values` SET `english` = 'must be between 1% - 100%' WHERE `lang_values`.`keyword` = 'must-be-between-1-99';
        

        
        INSERT INTO `lang_values` (`type`, `label`, `keyword`, `english`) VALUES
        ('admin', 'Sender Email', 'sender-email', 'Sender Email'),
        ('admin', 'Access Token', 'access-token', 'Access Token'),
        ('admin', 'Password Recovery', 'password-recovery', 'Password Recovery'),
        ('admin', 'Hello', 'hello', 'Hello'),
        ('admin', 'We have reset your password, Please use this', 'we-reset-pass', 'We have reset your password, Please use below'),
        ('admin', 'code to login your account', 'code-to-login-your-account', 'code to login your account');
        

        CREATE TABLE `booking_val` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `business_id` varchar(155) COLLATE utf8_unicode_ci DEFAULT '0',
		  `staff_id` varchar(155) COLLATE utf8_unicode_ci DEFAULT '0',
		  `service_id` varchar(155) COLLATE utf8_unicode_ci DEFAULT '0',
		  `location_id` varchar(155) COLLATE utf8_unicode_ci DEFAULT '0',
		  `sub_location_id` varchar(155) COLLATE utf8_unicode_ci DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;









    UPDATE settings SET version = '1.9' WHERE id = 1;

?>