<?php
    require_once('../includes/backIncludes.php');
    $administratorId=$_POST['administratorId'];

    $userCompleteInfo=User::GetCompleteInfo($administratorId);
    $administratorInfo=Administrator::GetInfo($administratorId);
    $sites=Site::GetByAdministrator($administratorId);
    $siteHtml='';
    $br='';
    foreach($sites as $aSite)
    {
        $siteHtml.=$br.$aSite['name'];
        $br='<br>';
    }
    $htmlRow="
              <tr  id='item{$administratorId}'>
                 <td>{$userCompleteInfo['f_name']}
                 </td>
                 <td>{$userCompleteInfo['l_name']}
                 </td>
                 <td>{$userCompleteInfo['email']}
                 </td>
                 <td><a href='javascript:void(0)' onclick='RemoveFromUserList(\"$administratorId\")'>Delete</a>
                 </td>
              </tr>";
    echo $htmlRow;
?>