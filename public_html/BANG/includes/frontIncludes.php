<?php
    include_once('noCacheHeader.php');
    require_once('adminConnection.php');
    require_once('directories.php'); 
    require_once('configFile.php');
    require_once('library.php');
    require_once('commonFunctions.php');
    //global $currentUserId, $currentUserLoginInfo, $currentUserDetails, $STATUSES;    
    $classDir=$ROOT.'classes/';
    require_once($classDir.'ICodeConfig.class.php');
    require_once($classDir.'SystemController.class.php');

    SystemController::StartUp();
?>