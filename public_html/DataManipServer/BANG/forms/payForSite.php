<?php
    $formError='';

    $form='';
    if(isset($_GET['siteId']))
    {
        $siteId=(int)$_GET['siteId'];

        if($siteId>0)
        {
        
            //get billing address
            $siteInfo=Site::GetInfo($siteId);
            $ownerInfo=SuperAdministrator::GetInfo($currentUserId);
            $_POST['currencyCode']= $CONFIGURATIONS['CURRENCY_CODE'];
            $_POST['amount'] = $CONFIGURATIONS['ANNUAL_PRICE_PER_SITE'];     
            $_POST['customerId']=$currentUserId;
            $_POST['productId']=$siteId;
            $_POST['name']=$ownerInfo['inv_companyName'];
            $_POST['address']=$ownerInfo['inv_address'];
            $_POST['cityId']=$ownerInfo['inv_state_id'];
            $_POST['stateId']=$ownerInfo['inv_city_id'];
            $_POST['postcode']=$ownerInfo['inv_postcode'];
            $_POST['countryCode']='UK';
            $cartId=ICodeCart::Add();
            if(is_numeric($cartId) && $cartId>0)
            {
                $form='payment';
                $paymentMethods='';
                $paypalButton=ICodePaypal::GetButton(null,$cartId);
                $paymentMethods.=$paypalButton;
            }
            else
                $formError=$cartId;
        }
        else
        {
            $formError='Invalid site';
        }
    }
    else
    {  
       $formError='No site chosen for payment';
    }
                                                  
    /** printing starts **/
    echo"<div id='status' class='formError'>
              <img src='../images/magicStatus.png'><span>$formError</span>    
              <span id='jsError'>
              </span>
       </div>";       
?>            
         <!--content area starts-->
         <div id='contentArea' class='sitecomPadder'>
              <!--content starts-->
              <div id='content'>     
                  <div class='subHead'>
                       <span class='subHeadLeft'>
                             <div>Please choose a payment method for <?php echo $siteInfo['name']; ?></div>
                       </span><span class='subHeadRight'>
                       </span>
                  </div>    
                      <?php
                          if($form=='payment')
                          {
                      ?>
                              <div class='paymentMethods'>
                                   <?php
                                       echo $paymentMethods;
                                   ?>
                              </div>
                      <?php
                          }
                      ?> 
              </div>           
              <!--content ends-->
         </div>
         <!--contentArea ends-->