<?php
require_once('../includes/frontIncludes.php');
$_POST['payer_email']= 'testing@nai.com';
$_POST['txn_id']= 'hijibiji'.$_GET['cartId'] ;
$_POST['cartId']= $_GET['cartId'];

ICodeCart::AcceptPayment($_POST,'paypal');

?>