<?php
    require_once('../includes/backIncludes.php');

                                                              
    $users=User::SearchByEmail($_GET['term'], 'Administrator');
    $count=0;
    foreach($users as $userInfo)
    {
        $administratorId=$userInfo['user_id'];
        $administratorInfo=Administrator::GetInfo($administratorId);
        if($administratorInfo['owner_id']!=$currentUserId)
            continue;
        $userCompleteInfo=User::GetCompleteInfo($administratorId);
        $sites=Site::GetByAdministrator($administratorId);
        $siteHtml='';
        $br='';
        foreach($sites as $aSite)
        {
            $siteHtml.=$br.$aSite['name'];
            $br='<br>';
        }
        $data[$count]['id']=$administratorId;
        $data[$count]['value']='<span>'.$userCompleteInfo['f_name'].' '.$userCompleteInfo['l_name'].'</span><span>'.$userInfo['email'].'</span><span style="width:15em">'.$siteHtml.'</span>';
        ++$count;
    }
    echo ICodeTools::ArrayToJSON($data);
?>