<?php
    require_once('../includes/frontIncludes.php');
    //$requestXml=$_POST['request'];
/*
        $_POST['xml']=
                          "
<request>
    <operation>
        read
    </operation>      
    <authKey>NDMtYjE2OGM4NWIwOTllMWQ2YjQ5OWIzZjQxYjFkOGQ3ODYtMA==
    </authKey>       
    <read>
        <notificationId>7
        </notificationId>
    </read>
</request>
";
*/

    SitecomsAPI::ProcessRequest();

?>