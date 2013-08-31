<?php

   abstract Class ICodePaypal
   {
       public static function GetButton($array=null,$cartId=0)
       {
            //EchoPre($array) ;
            global $CONFIGURATIONS;

            if((int)$CONFIGURATIONS['PAYPAL_SANDBOX']==1)
                $sandbox ='.sandbox';
            else
                $sandbox='';
            $form="<form action='https://www$sandbox.paypal.com/cgi-bin/webscr' method='post'>
                         <input type='hidden' name='cmd' value='_xclick'>";
            if($cartId!=0)
            {
                //make array from cart
                $cartInfo=ICodeCart::GetInfo($cartId);
                $array['currency_code']=$cartInfo['currency_code'];        
                $array['invoice']=$CONFIGURATIONS['PAYPAL_INVOICE_PREFIX'].'-'.$cartId;
                $array['amount']=$cartInfo['amount'];
                $array['business']=$CONFIGURATIONS['PAYPAL_BUSINESS_ACCOUNT'];
                $array['item_name']="Invoice no #".$cartId;
                $array['shopping_url']=$CONFIGURATIONS['BASE_URL'];
                $array['no_note']=1;
                $array['return']=$CONFIGURATIONS['BASE_URL'].'member/';
                $array['cancel_return']=$CONFIGURATIONS['BASE_URL'];
                $array['image']=$CONFIGURATIONS['IMAGE_URL'].'paypal.gif';    
                $array['notify_url']=$CONFIGURATIONS['BASE_URL'].'IPN.php';
                $array['tax']=0;
                $array['tax_rate']=0;
            }
            if(is_null($array))
                return "No data given for the paypal button";
            foreach($array as $key=>$val)
            {
                if($key=='image') continue;
                $form.="<input type='hidden' name='$key' value='$val'>";
            }
            if( !array_key_exists('shipping',$array) && !array_key_exists('shipping2',$array) && !array_key_exists('no_shipping',$array))
                $form.="<input type='hidden' name='no_shipping' value='1'>";
            
             $form.="    <input type='image' src='{$array['image']}' border='0' name='submit' alt='PayPal - The safer, easier way to pay online!'>
                         <img alt='' border='0' src='https://www$sandbox.paypal.com/en_US/i/scr/pixel.gif' width='1' height='1'>
                         </form>";

            return $form;
       }
       public static function GetPaypalFeed($cartId){             
            global $PAYPAL_BUSINESS_ACCOUNT,$PAYPAL_RETURN_URL,$PAYPAL_CANCEL_URL,$PAYPAL_CURRENCY_CODE,$IMAGE_URL,$BASE_URL,$PAYPAL_INVOICE_PREFIX;
            $cartInfo = ICodeCart::GetInfo($cartId);

            if(!isset($PAYPAL_BUSINESS_ACCOUNT)|| $PAYPAL_BUSINESS_ACCOUNT=='')
                 ICodeError::LogAndStop("paypal business account not found");
            if(!isset($PAYPAL_INVOICE_PREFIX) || $PAYPAL_INVOICE_PREFIX=='')
                 ICodeError::LogAndStop("paypal prefix not found");       
            $invoiceId=$PAYPAL_INVOICE_PREFIX."-".$cartId;


            $paypalFeed = array('invoice'=>$invoiceId,
                                'currency_code'=>$cartInfo['currency_code'],         //$cartInfo['currency_code'],
                                'amount'=>$cartInfo['amount'],
                                'business'=>$PAYPAL_BUSINESS_ACCOUNT,
                                'item_name'=>"Invoice #$cartId: Voucher of amount ".$cartInfo['amount'],
                                'shopping_url'=>$BASE_URL,
                                'no_note'=>1,
                                'return'=>$PAYPAL_RETURN_URL."cartId=$cartId",
                                'cancel_ return'=>$PAYPAL_CANCEL_URL,
                                'image'=>$IMAGE_URL.'paypal.gif'
                                );
            return $paypalFeed;  
                                
       }
       public static function IPN() //the IPN notifier calls it   invoice id prefix-323
       {
             //ICodeError::LogAndStop(serialize($_POST));
             global $CONFIGURATIONS;

             $PAYMENT_NOTIFICATION_EMAIL=$CONFIGURATIONS['PAYMENT_NOTIFICATION_EMAIL'];
             $PAYPAL_BUSINESS_ACCOUNT=$CONFIGURATIONS['PAYPAL_BUSINESS_ACCOUNT'];
             $PAYPAL_INVOICE_PREFIX=$CONFIGURATIONS['PAYPAL_INVOICE_PREFIX'];
             // The majority of the following code is a direct copy of the example code specified on the Paypal site.

             // Paypal POSTs HTML FORM variables to this page
             // we must post all the variables back to paypal exactly unchanged and add an extra parameter cmd with value _notify-validate

             // initialise a variable with the requried cmd parameter
             if((int)$CONFIGURATIONS['LOG_TRANSACTIONS']==1)
                 $logError=true;
             else
                 $logError=false;

             if(!isset($PAYPAL_BUSINESS_ACCOUNT)|| $PAYPAL_BUSINESS_ACCOUNT=='')
                 ICodeError::LogAndStop("paypal business account not found");
             if(!isset($PAYPAL_INVOICE_PREFIX) || $PAYPAL_INVOICE_PREFIX=='')
                 ICodeError::LogAndStop("paypal prefix not found");

             $req = 'cmd=_notify-validate';

             // go through each of the POSTed vars and add them to the variable
             foreach ($_POST as $key => $value) {
             $value = urlencode(stripslashes($value));
             $req .= "&$key=$value";
             }
             $header = '';
             // post back to PayPal system to validate
             $header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
             $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
             $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

             // In a live application send it back to www.paypal.com
             // but during development you will want to uswe the paypal sandbox

             // comment out one of the following lines
                            
            if((int)$CONFIGURATIONS['PAYPAL_SANDBOX']==1)
                 $fp = fsockopen ('www.sandbox.paypal.com', 80, $errno, $errstr, 30);
             else
                 $fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);

             // or use port 443 for an SSL connection
             //$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);


             if (!$fp) {
             // HTTP ERROR
                ICodeError::LogAndStop('Could not connect to paypal');
             }
             else
             {     
               if($logError)
                  ICodeError::Log(print_r($_POST,true));
               fputs ($fp, $header . $req);
               while (!feof($fp))
               {
                     $res = fgets ($fp, 1024);
                     if (strcmp ($res, "VERIFIED") == 0)
                     {

                       if($logError)
                          ICodeError::Log('Verified Paypal Transaction:');
                       // assign posted variables to local variables
                       // the actual variables POSTed will vary depending on your application.
                       // there are a huge number of possible variables that can be used. See the paypal documentation.

                       // the ones shown here are what is needed for a simple purchase
                       // a "custom" variable is available for you to pass whatever you want in it. 
                       // if you have many complex variables to pass it is possible to use session variables to pass them.

                       $invoiceId = $_POST['invoice'];
                       $invoiceArr=explode("-",$invoiceId);
                       if($invoiceArr[0]!=$PAYPAL_INVOICE_PREFIX) 
                           ICodeError::LogAndStop("paypal prefix $PAYPAL_INVOICE_PREFIX didn't match with {$invoiceArr[0]}");
                           
                       $cartId=$invoiceArr[1];
                       $payment_status = $_POST['payment_status'];
                       $payment_amount = floatval($_POST['mc_gross']);         //full amount of payment. payment_gross in US
                       $payment_currency = $_POST['mc_currency'];
                       $txn_id = $_POST['txn_id'];                   //unique transaction id
                       $receiver_email = $_POST['receiver_email'];
                       $payer_email = $_POST['payer_email'];

                       // use the above params to look up what the price of "item_name" should be.
                       $cartInfo=ICodeCart::GetInfo($cartId);
                       
                       if($cartInfo['status']=='payment_recieved')
                           ICodeError::LogAndStop("Payment already received for cart # $cartId before");
                       
                       if($logError)
                           ICodeError::Log(print_r($cartInfo,true));

                       //$amount_they_should_have_paid = lookup_price($item_name); // you need to create this code to find out what the price for the item they bought really is so that you can check it against what they have paid. This is an anti hacker check.

                       // the next part is also very important from a security point of view
                       // you must check at the least the following...

                       if (($payment_status == 'Completed') &&   //payment_status = Completed
                          ($receiver_email == $PAYPAL_BUSINESS_ACCOUNT) &&   // receiver_email is same as your account email
                          ($payment_amount == floatval($cartInfo['amount'] )) &&  //check they payed what they should have
                          ($payment_currency == $cartInfo['currency_code']) &&  // and its the correct currency
                          (strcmp($txn_id,$cartInfo['transaction_id'])!=0))
                       {  //txn_id isn't same as previous to stop duplicate payments. You will need to write a function to do this check.

                          //        uncomment this section during development to receive an email to indicate whats happened
                             
                             if($logError)
                             {
                                 ICodeError::Log("all conditions ok. calling Cart::AcceptPayment(\$_POST,'paypal')");
                             }
                             $_POST['cartId']=$cartId;
                             if(ICodeCart::AcceptPayment($_POST,'paypal'))
                             {

                                 $mail_Subject = "completed status received from paypal for invoice $invoiceId";
                                 $mail_Body = "completed:  \n\nThe Invoice ID number is: $invoiceId";                                                      
                             }
                             else
                             {  
                                 $mail_Subject = "Error: completed status received from paypal for invoice $invoiceId";
                                 $mail_Body = "completed:  \n\nThe Invoice ID number is: $invoiceId but the invoice was not updated. Please update it manually";

                             }
                             ICodeTools::ICodeMail($PAYMENT_NOTIFICATION_EMAIL, $CONFIGURATIONS['SYSTEM_EMAIL_ADDRESS'], $mail_Subject, $mail_Body,$CONFIGURATIONS['WEBMASTER_EMAIL']);
                       }
                       else
                       {
                           //             
                           
                           if($logError)
                              ICodeError::Log('Potential fraud attack');
                           if(!($payment_status == 'Completed'))
                              ICodeError::Log('Payment status not completed');
                           if(!($receiver_email == $PAYPAL_BUSINESS_ACCOUNT))       
                              ICodeError::Log("receiver email is not business account:$PAYPAL_BUSINESS_ACCOUNT");
                           if(!($payment_amount == floatval($cartInfo['amount'])))
                              ICodeError::Log('amount doesn\'t match');
                           if(!(strcmp($txn_id,$cartInfo['transaction_id'])==0))
                              ICodeError::Log('transaction id same');
                           if(!($payment_currency == $cartInfo['currency_code']))
                              ICodeError::Log('currency codes doesn\'t match');
                           //
                           // we will send an email to say that something went wrong
                           $mail_Subject = "PayPal IPN status not completed or security check fail";
                           $mail_Body = "Something wrong. \n\nThe Invoice ID number is: $invoiceId \n\nThe transaction ID number is: $txn_id \n\n Payment status = $payment_status \n\n Payment amount = $payment_amount".print_r($_POST,true);;

                           ICodeTools::ICodeMail($PAYMENT_NOTIFICATION_EMAIL, $CONFIGURATIONS['SYSTEM_EMAIL_ADDRESS'], $mail_Subject, $mail_Body,$CONFIGURATIONS['WEBMASTER_EMAIL']);

                       }
                     }
                     else if (strcmp ($res, "INVALID") == 0)
                     {
                           //
                           // Paypal didnt like what we sent. If you start getting these after system was working ok in the past, check if Paypal has altered its IPN format
                           //   
                         
                           if($logError)
                              ICodeError::LogAndStop('INVALID for cartId'.$cartId);
                           $mail_Subject = "PayPal - Invalid IPN ";

                           $invoiceId = $_POST['invoice'];
                           $txn_id = $_POST['txn_id'];                   //unique transaction id
                           $mail_Body = "We have had an INVALID response.  \n\nThe Invoice ID number is: $invoiceId \n\nThe transaction ID number is: $txn_id ";

                           ICodeTools::ICodeMail($PAYMENT_NOTIFICATION_EMAIL, $CONFIGURATIONS['SYSTEM_EMAIL_ADDRESS'], $mail_Subject, $mail_Body,$CONFIGURATIONS['WEBMASTER_EMAIL']);

                     }
                     else
                     {  
                           ICodeError::Log('StrangeData from paypal server: '.$res);
                     }
                } //end of while
             fclose ($fp);
             }

       }

   }

?>