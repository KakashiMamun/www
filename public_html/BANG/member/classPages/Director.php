<?php
    $needClass='Director';
    $error='';
    User::RestrictAccess($needClass);  //this is needed for security puposes
    require_once( '../header.php');
    //require_once('leftControl.php');
    $requestedPage=ICodeTools::GetRawValue('page');
    if($requestedPage!='')
    {
        Permission::ProcessPage($needClass,$requestedPage);
    }
    else
    {

    }
    require_once('../footer.php');
?>
  