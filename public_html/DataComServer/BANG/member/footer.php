
    </div>
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