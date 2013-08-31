<?php                
require_once('../includes/frontIncludes.php');
$testBase=$ROOT.'notificationFiles/';
ExtractVars();
if(isset($_POST['submitted']))
{
    ICodeFile::Add($_FILES['icon'],$testBase);
}
?>
<form action='' method='post' enctype='multipart/form-data'>
<input type='file' name='icon'>
<input type='submit'>
<input type='hidden' name='submitted'>
</form>