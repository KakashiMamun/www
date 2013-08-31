<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title><?php echo $CONFIGURATIONS['WEBSITE_NAME'];?></title>                           
    <link rel='stylesheet' type='text/css' href='CSS/icode.css' media='all' />
    <link rel='stylesheet' type='text/css' href='CSS/layout.css' media='all' />
    <link rel='stylesheet' type='text/css' href='CSS/sitecom.css' media='all' />
    <link rel='stylesheet' type='text/css' href='CSS/menu.css' media='all' />
    <link rel='stylesheet' type='text/css' href='CSS/cupertino/jquery-ui-1.8.16.custom.css' media='all' />
    <link rel='stylesheet' type='text/css' href='CSS/cupertino/jquery.ui.autocomplete.css' media='all' />
    <link rel='stylesheet' type='text/css' href='CSS/cupertino/jquery.ui.all.css' media='all' />
    <script type="text/javascript" src='JS/jquery-1.6.2.min.js'></script>
    <script type="text/javascript" src='JS/jquery-ui-1.8.16.custom.min.js'></script>
    <script type="text/javascript" src='JS/ui/jquery.ui.core.min.js'></script>
    <script type="text/javascript" src='JS/ui/jquery.ui.widget.min.js'></script>
    <script type="text/javascript" src='JS/ui/jquery.ui.position.min.js'></script>
    <script type="text/javascript" src='JS/ui/jquery.ui.autocomplete.min.js'></script>
    <script type="text/javascript" src='JS/icodeTools.js'></script>
    <script type="text/javascript" src='JS/icodeString.js'></script>
    <script type="text/javascript" src='JS/icodeNumber.js'></script>
    <script type="text/javascript" src='JS/menuManagement.js'></script>
    <script type="text/javascript" src='JS/footer.js'></script>
    <script type="text/javascript" src='JS/User.class.js'></script>
<?php                           
    if(ICodeTools::IfCurrentPage('addRecipient'))
    {
?>
    <script type="text/javascript" src='JS/recipientManagement.js'></script>             
<?php
    }            
    else if(ICodeTools::IfCurrentPage('addAdministrator'))
    {
?>
    <script type="text/javascript" src='JS/administratorManagement.js'></script>
<?php
    }
    else if(ICodeTools::CurrentScriptName()=='register.php')
    {
?>
    <script type="text/javascript" src='JS/registerSuperAdministrator.js'></script>
<?php
    }
?>
</head>
<body>