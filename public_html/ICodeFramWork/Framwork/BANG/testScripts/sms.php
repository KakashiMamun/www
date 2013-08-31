<?php                
require_once('../includes/frontIncludes.php');
//ExtractVars();
$from='8801671026444';
$toArr[]='8801723869962';
$msg='eAliens';                    
//SMS::Send($from, $toArr,$msg);
echo "credits required:". SMS::CreditsNeeded($from,$toArr);
?>
<form action='' method='post' enctype='multipart/form-data'>
<input type='file' name='icon'>
<input type='submit'>
<input type='hidden' name='submitted'>
</form>
sample:
TestMode=0
MessageReceived=eAliens
MessageCount=1
From=8801671026444
CreditsAvailable=890
MessageLength=7
NumberContacts=1
CreditsRequired=1.2
CreditsRemaining=888.8