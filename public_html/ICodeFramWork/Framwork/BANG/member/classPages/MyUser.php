<?php
    $needClass='myUser';
    User::RestrictAccess($needClass);  //this is needed for security purposes
    $error='';                       
    require_once('header.php');
    //require_once('leftControl.php');

    $requestedPage=ICodeTools::GetRawValue('page');

    if($requestedPage!='')
    {
        echo $requestedPage;
        Permission::ProcessPage($needClass,$requestedPage);
    }
    else
    {

    }
    require_once('footer.php');
?>
  