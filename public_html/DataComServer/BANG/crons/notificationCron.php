<?php                
require_once('../includes/frontIncludes.php');
$attachmentBase=$ROOT.'notificationFiles/';

$PER_CRON=$CONFIGURATIONS['NOTIFICATION_MAIL_PER_CRON'];
$q="select notification_target_id,receiver_id from notification_receiver where is_sent='no' order by notification_target_id asc limit 0,$PER_CRON";
ICodeTools::DebugMessage($q);
$notificationReceivers=ICodeDB::GetResultsSet($q);
$notificationInfo=array();
$notificationTargetInfo=array();
$currentDate=date("Y-m-d H:i:s",time()); //important for consistent reporting ;)
foreach($notificationReceivers as $aNR)
{
    if(empty($notificationTargetInfo) || $notificationTargetInfo['notification_target_id']!=$aNR['notification_target_id'])
    {
        $notificationTargetInfo=NotificationTarget::GetInfo($aNR['notification_target_id']);      
        if(empty($notificationTargetInfo))
            continue;   
        $fromName='URGENT Notification from SITEcoms';
        $fromDetails='from details';
    }
    if(empty($notificationInfo) || $notificationInfo['notification_id']!=$notificationTargetInfo['notification_id'])
    {
        $notificationInfo=Notification::GetInfo($notificationTargetInfo['notification_id']);
        if(empty($notificationInfo))
            continue;
    }
    $receiverInfo=User::GetCompleteInfo($aNR['receiver_id']);

                                                    
    //Now we have a valid notification and receiver

    //1. send email
    $fileIds=array();
    if($notificationInfo['fileIds']!='' || $notificationInfo['fileIds'] != "''")
        $fileIds=unserialize($notificationInfo['fileIds']);

    $attachments=array();
    $count=0;
    if(is_array($fileIds))
    {
        foreach($fileIds as $aFileId)
        {
            $fileInfo=ICodeFile::GetInfo($aFileId);        
            $attachments[$count]['file']=$fileInfo['path'];                
            $attachments[$count]['fileName']=$fileInfo['file_name'];
            $attachments[$count]['content_type']=$fileInfo['type'];

        }
    }
    print_r($attachments);
    //echo $receiverInfo['email'], $CONFIGURATIONS['SYSTEM_EMAIL_ADDRESS'], $notificationInfo['head'], $notificationInfo['body'],$fromName;
    //exit();
    $body= $notificationInfo['body']. ICodeTools::GetIsReadLink("class=NotificationTarget&notificationTargetId={$aNR['notification_target_id']}&receiverId={$aNR['receiver_id']}");
    echo $body;
    if(ICodeTools::ICodeMail($receiverInfo['email'], $CONFIGURATIONS['SYSTEM_EMAIL_ADDRESS'], $notificationInfo['head'], $body, $fromName, $attachments))
    {
        //2. send SMS
        $credits=0;
        if(in_array($notificationInfo['method'], array('SMS','both')))
        {
            
            $from='SITECOMS';
            if($notificationInfo['reply_to']!='')
                $from=$notificationInfo['reply_to'];
            if($receiverInfo['mobile']!='')
            {
                echo"sending sms to {$receiverInfo['mobile']}";
                $toArr[]=$receiverInfo['mobile'];
                $credits = SMS::Send($from, $toArr, $notificationInfo['head']);
            }
        }
        //3. Update database if success
        $update="Update notification_receiver set is_sent='yes',date_sent='$currentDate', sms_credit='$credits' where notification_target_id={$aNR['notification_target_id']} and receiver_id={$aNR['receiver_id']}";
        if(!ICodeDB::Update($update))
            ICodeTools::DebugMessage('Failed query: '.$update);
            
    }
    else
        ICodeTools::DebugMessage('Cron Mail Failed');
}
?>