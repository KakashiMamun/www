<?php
function ICodeMail($emailaddress, $fromaddress, $emailsubject, $body,$fromName, $attachments=false)
{
  $eol="\r\n";
  $mime_boundary=md5(time());

  # Common Headers
  $headers = "From: $fromName<".$fromaddress.'>'.$eol;
  $headers .= "Reply-To: $fromName<".$fromaddress.'>'.$eol;
  $headers .= "Return-Path: $fromName<".$fromaddress.'>'.$eol;    // these two to set reply address
  $headers .= "Message-ID: <".time()." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol;
  $headers .= "X-Mailer: PHP v".phpversion().$eol;          // These two to help avoid spam-filters

  # Boundry for marking the split & Multitype Headers
  $headers .= 'MIME-Version: 1.0'.$eol;
  $headers .= "Content-Type: multipart/mixed; boundary=\"".$mime_boundary."\"".$eol;

  $msg = "";
 
  if ($attachments !== false)
  {

    for($i=0; $i < count($attachments); $i++)
    {
      if (is_file($attachments[$i]["file"]))
      {  
        # File for Attachment
        $file_name = substr($attachments[$i]["file"], (strrpos($attachments[$i]["file"], "/")+1));
       
        $handle=fopen($attachments[$i]["file"], 'rb');
        $f_contents=fread($handle, filesize($attachments[$i]["file"]));
        $f_contents=chunk_split(base64_encode($f_contents));    //Encode The Data For Transition using base64_encode();
        fclose($handle);
       
        # Attachment

        $msg .= "--".$mime_boundary.$eol;
        $msg .= "Content-Type: ".$attachments[$i]["content_type"]."; name=\"".$file_name."\"".$eol;
        $msg .= "Content-Transfer-Encoding: base64".$eol;
        $msg .= "Content-Disposition: attachment; filename=\"".$file_name."\"".$eol.$eol; // !! This line needs TWO end of lines !! IMPORTANT !!
        $msg .= $f_contents.$eol.$eol;

       
      }
    }
  }
  /*
  # Setup for text OR html  
  $msg .= "--".$mime_boundary.$eol;
  //$msg .= "Content-Type: multipart/alternative boundary=\"".$mime_boundary."alt"."\"".$eol.$eol;
 
  # Text Version
  //$msg .= "--".$mime_boundary."alt".$eol;
  $msg .= "Content-Type: text/plain; charset=iso-8859-1".$eol;
  $msg .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
  $msg .= $body.$eol.$eol;

  */
  # HTML Version            
  $msg .= "--".$mime_boundary.$eol;
  $msg .= "Content-Type: text/html; charset=iso-8859-1".$eol;
  $msg .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
  $msg .= "<html><body>".$body."</body></html>".$eol.$eol;


  //$msg .= "--".$mime_boundary."alt"."--".$eol.$eol;  // finish with two eol's for better security. see Injection.
  
  # Finished
  $msg .= "--".$mime_boundary."--".$eol.$eol;
  //echo "<pre>$msg</pre>";
  # SEND THE EMAIL
  //ini_set(sendmail_from,$fromaddress);  // the INI lines are to force the From Address to be used !
  $error=mail($emailaddress, $emailsubject, $msg, $headers);
  //ini_restore(sendmail_from);
  /*
  echo"<pre>";
  echo $msg;
  echo"</pre>";
  
    */
  return $error;

}

 
# To Email Address
/*
$emailaddress="themuktadirs@yahoo.com";

# From Email Address
$fromaddress = "hotepare2004@yahoo.com";

# Message Subject
$emailsubject="This is a test mail with some attachments";

# Use relative paths to the attachments
$attachments = Array(
  Array("file"=>"border.jpg", "content_type"=>"image/jpeg"),
  Array("file"=>"custom.css", "content_type"=>"text/plain")
);

# Message Body
$body="This is a message with <b>".count($attachments)."</b> attachments and maybe some <i>HTML</i>!";

send_mail($emailaddress, $fromaddress, $emailsubject, $body, $attachments);
*/
?>