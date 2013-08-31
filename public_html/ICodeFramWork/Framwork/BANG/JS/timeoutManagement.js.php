<?php
    require_once('../includes/backIncludes.php');
    if($currentUserId>0)
    {
        $timeOutMints=$currentUserLoginInfo['forget_minutes'];
        echo "
        var timeOutPeriod=$timeOutMints;";

?>
        var timeOutId=0;
        idleTime = 0;

        $(document).ready(function()
        {
            //TimeoutLogin();
            //alert(GetDirUrl(1));
            //alert(timeOutPeriod);

            timeOutId=setInterval("TimeoutLogin()",60000);       
            //Zero the idle timer on mouse movement.
            $(this).mousemove(function (e)
            {
                idleTime = 0;
            });
            $(this).keypress(function (e)
            {
                idleTime = 0;
            });
            //AutoLogout();

        });
                
        function TimeoutLogin()
        {        
            idleTime = idleTime + 1;
            if (idleTime >= timeOutPeriod)
            { // timeOutPeriod minutes
                AutoLogout();
            }
        }
        function GetTimeout()
        {
        }

        function AutoLogout()
        {
            var baseUrl=GetDirUrl(1);
            //alert('');
            Redirect(baseUrl+'logout.php');
        }
<?php
    }
?>