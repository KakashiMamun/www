<?php
///**
// * Created by JetBrains PhpStorm.
// * User: root
// * Date: 9/11/13
// * Time: 6:08 PM
// * To change this template use File | Settings | File Templates.
// */
// $allowedTags='<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
// $allowedTags.='<li><ol><ul><span><div><br><ins><del>';
//// Should use some proper HTML filtering here.
//  if(isset($_POST['elm1']) && $_POST['elm1']!='') {
//      $sHeader = '<h1>Ah, content is king.</h1>';
//      $sContent = strip_tags(stripslashes($_POST['elm1']),$allowedTags);
//
//      print_r($_POST['elm1']);
//
//  } else {
//      $sHeader = '<h1>Nothing submitted yet</h1>';
//      $sContent = '<p>Start typing...</p>';
//      $sContent.= '<p><img width="107" height="108" border="0" src="/mediawiki/images/badge.png"';
//      $sContent.= 'alt="TinyMCE button"/>This rover has crossed over</p>';
//  }
//?>
<!--<html>-->
<!--<head>-->
<!--    <title>My test editor - with tinyMCE and PHP</title>-->
<!--    <script language="javascript" type="text/javascript" src="tinymce/js/tinymce/tinymce.min.js"></script>-->
<!--    <script language="javascript" type="text/javascript" src="JS/timeMCEConfig.js"></script>-->
<!--</head>-->
<!--<body>-->
<?php //echo $sHeader;?>
<!--<h2>Sample using TinyMCE and PHP</h2>-->
<!--<form method="post" action="">-->
<!--    <textarea id="elm1" name="elm1" rows="15" cols="80">--><?php //echo $sContent;?><!--</textarea>-->
<!--    <br />-->
<!--    <input type="submit" name="save" value="Submit" />-->
<!--    <input type="reset" name="reset" value="Reset" />-->
<!--</form>-->
<!--</body>-->
<!--</html>-->


<?php

require_once('UrboshiNextID.class.php');



for($i=1;$i<100;$i++){

echo UrboshiNextID::getNextArticleID();
echo '<br>';
echo UrboshiNextID::getNextCategoryID();
echo '<br>';
echo '<br>';
}