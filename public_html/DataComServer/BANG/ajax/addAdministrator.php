<?php
    require_once('../includes/backIncludes.php');
    $formError='';
    $form='administrator';
    if(isset($_POST['formSubmitted']))
    {
        //$currentUserDetails;                 
        $_POST['email2']=$_POST['email'];
        $_POST['companyName']='change';
        //print_r($address);
        $_POST['address1']='change';
        $_POST['address2']='';
        $_POST['address3']='';
        $_POST['city']='change';
        $_POST['stateId']=$currentUserDetails['state_id'];
        $_POST['postcode']=$currentUserDetails['postcode'];
        $_POST['country_code']=$currentUserDetails['country_code'];
        $_POST['title']='change';
        $_POST['jobTitle']='change';
        $_POST['phone']='change';          
        $_POST['class']='Administrator';
        $_REQUEST['class']=$_POST['class'];
        $_POST['status']='needPassword';
        $_POST['password']='test';
        $_POST['password2']='test';    
        $_POST['mobile']='00000000';
                                
        if(!isset($_POST['customTitle']))
            $_POST['customTitle']='change';
        if(!isset($_POST['sameInvoiceAddress']))
            $_POST['sameInvoiceAddress']='change';
                                  
        $_POST['ownerId']=$currentUserId;
        $administratorId=User::Add();
        if(is_numeric($administratorId) && $administratorId>0)
        {
            //$form='payment';
            $formError=$administratorId;
        }
        else
        {
            $formError=$administratorId;
        }
        echo $formError;
        exit();
    }
    echo"form not submitted";
?>