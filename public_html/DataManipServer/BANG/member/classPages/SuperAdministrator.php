<?php
    $needClass='SuperAdministrator';
    User::RestrictAccess($needClass);  //this is needed for security puposes
    $error='';                       
    require_once('header.php');
    //require_once('leftControl.php');
    $requestedPage=ICodeTools::GetRawValue('page');
    if($requestedPage!='')
    {
        Permission::ProcessPage($needClass,$requestedPage);
    }
    else
    {
           
        Permission::ProcessPage($needClass,'notificationLog');
    }
    require_once('footer.php');
?>
  