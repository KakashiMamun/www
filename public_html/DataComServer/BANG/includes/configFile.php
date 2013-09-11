<?php
$WEBSITE_NAME='www.global-giving.net';
$WEBMASTER_EMAIL = 'robi@optimus8.com';
$CONTACT_EMAIL = 'support@vouchersolution.com';
$DATE_FORMAT = "date_format(date,'%d-%m-%Y %H:%i:%s') as date"; //every sql that fetches date will have this format

$CAPTCHA_PUBLIC="6LfJ-cISAAAAAAoQ5-AdE3w9PvKDo5a7bBLu_YGz";
$CAPTCHA_PRIVATE="6LfJ-cISAAAAAO7nxZocWPssZweObSnoZAFwTlZM";
$MAX_DISTANCE = '10';
$KM = false; // true for calculation in km, false for miles
$MEMBER_PER_PAGE = 10;
$ADMIN_PER_PAGE = 10;
$MANAGER_PER_PAGE = 10;
$REQUEST_PER_PAGE = 10;
$VOUCHAR_PER_PAGE=10;
$CARTS_PER_PAGE=10;
$TRANSACTION_PER_PAGE=10;
$QUANTITY_PER_PAGE = 10;

$VOUCHER_LIMIT=500;
$VOUCHER_EXP_DAYS=14;

$SYSTEM_EMAIL_ADDRESS = "support@vouchersolution.com";
$MERCHANT_INQUIRY_ADDRESS = "support@vouchersolution.com";

//payment notification email
$PAYMENT_NOTIFICATION_EMAIL='support@vouchersolution.com';
//paypal conf
$PAYPAL_INVOICE_PREFIX='icode';
$PAYPAL_BUSINESS_ACCOUNT='support@vouchersolution.com';
$PAYPAL_CURRENCY_CODE='USD';
$PAYPAL_RETURN_URL=$BASE_URL."member/verifyPayment.php?";
$PAYPAL_CANCEL_URL=$BASE_URL;

$FORGET_HOURS=48;
?>