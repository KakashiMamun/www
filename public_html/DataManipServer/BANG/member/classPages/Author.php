<?php
    $needClass='Author';
    User::RestrictAccess($needClass);  //this is needed for security puposes
    $error='';
    require_once('header.php');
    //require_once('leftControl.php');
    $requestedPage=ICodeTools::GetRawValue('page');
    if($requestedPage!='')
    {
        Permission::ProcessPage($needClass,$requestedPage);
    }
    require_once('footer.php');
?>
  