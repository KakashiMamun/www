<?php
    require_once('../includes/frontIncludes.php');
    //$requestXml=$_POST['request'];
/*
        $_POST['xml']=
                          "
<request>
    <operation>
        getSuperUsers
    </operation>       
    <authKey>NDctYjE2OGM4NWIwOTllMWQ2YjQ5OWIzZjQxYjFkOGQ3ODYtMA==
    </authKey>
    <getSuperUsers>          
        <start>
        </start>
        <limit>
        </limit>        
    </getSuperUsers>
</request>
";
*/
    SitecomsAPI::ProcessRequest();

?>