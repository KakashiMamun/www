<?php
require_once('../includes/guestIncludes.php');
Business::ChangeSubscription($_GET['businessId'],$_GET['subscriptionId']);
?>