
    </div>
    <?php if(($_GET['page'] === 'articleCompose') || $_GET['page'] === 'editArticle'):?>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <style>
            .ui-autocomplete { max-height: 200px; overflow-y: scroll; overflow-x: hidden;}
        </style>
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <script language="javascript" type="text/javascript" src="../tinymce/js/tinymce/tinymce.min.js"></script>
        <script language="javascript" type="text/javascript" src="../JS/timeMCEConfig.js"></script>
        <script language="javascript" type="text/javascript" src="../JS/categoryAutoComplete.js"></script>
    <?php endif ?>
    <!--wrapper ends-->               
    <div id='footerArea'>
         <div  class='sitecomPadder'>
         <div class='footer'>
              <img src='../images/magicFooter.png'>
              <span class='footerLeft'>
              <!--<a href=''>Download the desktop tool</a> -->
              </span><span class='footerRight'>
                  <span id='currentUserInfo'>
                        <img src='../images/avatar.png'> <span> Logged in as <?php echo $currentUserDetails['f_name'],' ',$currentUserDetails['l_name'];?> (<?php echo $currentUserLoginInfo['class']; ?>)</span> | <a href='../logout.php'>Logout</a>
                  </span>

              </span>
         </div>
         </div>
    </div>
</body>
</html>