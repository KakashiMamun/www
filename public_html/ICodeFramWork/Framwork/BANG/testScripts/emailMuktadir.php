<?php
    require_once('../includes/frontIncludes.php');

    $toEmail='ceo@icodebd.com';
    $file[0]['file']=$ROOT.'testScripts/buffer.php';
    $file[0]['content_type']='application/pdf';
    //ICodeMail($emailaddress, $fromaddress, $emailsubject, $body,$fromName, $attachments=false)               
    ICodeTools::ICodeMail($toEmail,'system@sitecoms.com','no html no attach','hi','ICodeMail');
    ICodeTools::ICodeMail($toEmail,'system@sitecoms.com','no html with attach','hi','ICodeMail',$file);
    ICodeTools::ICodeMail($toEmail,'','no name no ema with attachil','no name','',$file);
    ICodeTools::ICodeMail($toEmail,'','no name no ema without','nai','');     
    ICodeTools::ICodeMail($toEmail,'system@sitecoms.com','rich','<a href="http://hello.com">hi</a>','ICodeMail',$file);
    /*
    mail($toEmail,'with from','raw','From: muktadir<system@sitecoms.com>');
    mail($toEmail,'with from and new line','raw','From: muktadir<system@sitecoms.com>\n\n');
    mail($toEmail,'have no from','<a href="">test</a>');
    */

?>  sending emails?