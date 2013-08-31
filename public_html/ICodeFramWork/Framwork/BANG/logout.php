<?php                                                  
    require_once('includes/frontIncludes.php');
    User::Logout();
    Header('Location: index.php');
?>