<?php
   //forum related functions
   //******************UI related functions *************************

   //maxLength=maximum number of characters to show. insert a break after each charsPerLine characters
   //$isHtml is an option field. if the text contains html tags, must ignore them from character count ;)
   function FormatText($text, $maxLength, $charsPerLine, $isHtml=0)
   {
   }
   //sql injection check with patterns
    function IsAtomic($string){
             //yet to create
             if(strpos($string," ")===false)
                 return false;
             else
                 return true;
    }
    
   
    function PrintError($string)
    {
        echo '<p class="error">' . $string . '</p>';
    }


   //special funtions
   /**assign format example: trim($_POST['%'])  . here % is the place. if $globalArray=='$_POST' this function will
    print all the things in $_POST array this way: $id=trim($_POST['id']);
    other format is actually a complete statement format: %=trim($_POST['%']); this field is optional
    **/
   function ExtractVars($gobalArray=0,$place=0,$assignFormat=0,$otherFormat=0)  //DEFAULT IS $id=trim($_POST['id'])
   {
       echo"<pre>";    
       print_r($_GET);  
       print_r($_POST);
       print_r($_COOKIE);  
       print_r($_FILES);
       echo"</pre>";     
                           
                  foreach($_GET as $key=>$value)
                  {
                      echo"<br>\$$key=\$_GET['$key'];";
                  }
                  foreach($_POST as $key=>$value)
                  {
                      echo"<br>\$$key=\$_POST['$key'];";
                  }
                  echo"<br>";               
                  foreach($_GET as $key=>$value)
                  {
                      echo"\$_GET['$key'],";
                  }                      
                  echo"<br>";  
                  foreach($_POST as $key=>$value)
                  {
                      echo"\$_POST['$key'],";
                  }                 
                  echo"<br>";  
                  
                  foreach($_GET as $key=>$value)
                  {
                      echo"'\".\$_GET['$key'].\"',";
                  }          
                  echo"<br>";  
                  foreach($_POST as $key=>$value)
                  {
                      echo"'\".\$_POST['$key'].\"',";
                  }        
                  echo"<br>";             
                  
                  foreach($_GET as $key=>$value)
                  {
                      echo"\$$key,";
                  }          
                  echo"<br>";  
                  foreach($_POST as $key=>$value)
                  {
                      echo"\$$key,";
                  }        
                  echo"<br>";
                                                  
                  foreach($_GET as $key=>$value)
                  {
                      echo"'\$$key',";
                  }          
                  echo"<br>";  
                  foreach($_POST as $key=>$value)
                  {
                      echo"'\$$key',";
                  }        
                  echo"<br>";
                  foreach($_GET as $key=>$value)
                  {
                      echo"'$key',";
                  }          
                  echo"<br>";  
                  foreach($_POST as $key=>$value)
                  {
                      echo"'$key',";
                  }        
                  echo"<br>";
                  
                  foreach($_GET as $key=>$value)
                  {
                      echo"\$_SESSION['$key']='';";
                  echo"<br>";
                  }          
                  echo"<br>";  
                  foreach($_POST as $key=>$value)
                  {
                      echo"\$_SESSION['$key']='';";
                  echo"<br>";
                  }


   }
   
   function EchoPre($mixed)
   {               
       echo"<pre>";
       print_r($mixed);
       echo"</pre>";
   }
   //image functions
   function GetImgType($type)
   {

          $ext="";        
          if($type=="image/gif")
              $ext=".gif";
          else if($type=="image/png")
              $ext=".png";              
          else if($type=="image/pjpeg" || $type=="image/jpeg")
              $ext=".jpg";
          return $ext;

   }
   //files
      
   //gets the extension of the file
   function FileExtension($str)   //returns jpg,JPG gif,etc
   {
       $i = strrpos($str,".");
       if (!$i) { return ""; }

       $l = strlen($str) - $i;
       $ext = substr($str,$i+1,$l);
       return strtolower($ext);
   }
   function DeleteFile($filename)
   {
       if(file_exists($filename))
       {
          @chmod($filename,0777);
          $success=unlink($filename);
          return $success;
       }
       return true;
   }
   
          
   function RemoveDirectory($directory)
   {
       // $directory = "6"; 
       chmod($directory,0777);
       if( !$dirhandle = @opendir($directory) )
            return;
       while( false !== ($filename = readdir($dirhandle)) )
       {
              if( $filename != "." && $filename != ".." )
                {
                   $filename = $directory. "/". $filename;
                   chmod($filename,0777);
                   if(!@unlink($filename))
                       RemoveDirectory($filename);

                }

       }

       closedir($dirhandle);
       return rmdir($directory);
   }
    
   function GetDirectory($directory,$removeDirName=false) //relative dirnames won't be removed
   {
       // $directory = "6";
       $array=array();
       $saveName='';
       if( !$dirhandle = @opendir($directory) )
            return;
       while( false !== ($filename = readdir($dirhandle)) )
       {
              if( $filename != "." && $filename != ".." )
                {
                
                   $saveName=$filename;
                   $filename = $directory. "/". $filename;
                   if(!$removeDirName)
                       $saveName=$filename;
                       
                   if(is_dir($filename))
                   {
                       $array=array_merge($array,GetDirectory($filename));
                   }
                   else
                   {
                       $array[]=$saveName;
                   }
                }

       }

       closedir($dirhandle);
       return $array;
   }
                                              
   function SearchImgFileExt($file)//returns with ext, otherwise false
   {                           
       if(file_exists($file.".jpg"))
           return "jpg";
       if(file_exists($file.".gif"))
           return "gif";
       if(file_exists($file.".png"))
           return "png";
       return false;
   }
    //remember not to give extension in $saveAs
   function UploadFile($fileInfo,$saveAs,$permission=0644,$resSIze=0,$resExtensions=null)//$resTypes=array of extensions it can have  //returns 0 on success
   {

       if(is_uploaded_file($fileInfo['tmp_name']))
       {
           if($resSIze!=0)
           {
               if($fileInfo['size']>$resSIze)
               {
                   unlink($fileInfo['tmp_name']);
                   return "file size limit exceeded";
               }
           }    
           $ext=FileExtension($fileInfo['name']);  
           DeleteFile($saveAs.".jpg");
           DeleteFile($saveAs.".png");    
           DeleteFile($saveAs.".gif");
           DeleteFile($saveAs.".$ext");
           $saveAs=$saveAs.".".$ext;
           if(!is_null($resExtensions))
           {
               //check the extensions allowed
               if(!in_array($ext,$resExtensions))
               {
                   unlink($fileInfo['tmp_name']);
                   return "file type not allowed";
               }
           }
           if(move_uploaded_file($fileInfo['tmp_name'],$saveAs))
           {
               chmod($saveAs,$permission);
               if(file_exists($saveAs))
                   return 0;
               return "Urgent: Server could not move file to $saveAs.";
           }
           unlink($fileInfo['tmp_name']);
       }
       else
           return "File was not uploaded";
       
       return "file couldn't be uploaded due to error code:".$fileInfo['tmp_name']['error'];
   }

   function DownloadFile($fileArr)
   {

       $file=$fileArr['path'];
       $fileName=$fileArr['name'];
       //echo $fileName;
       //exit();
       if (file_exists($file))
       {
         /*
          header("Content-type: application/force-download");
          header("Content-Transfer-Encoding: Binary");
          header("Content-length: ".filesize($file));
          header("Content-disposition: attachment; filename=\"".$fileName."\"");    
          header("Pragma: no-cache");
          */        
          ob_clean();
          header("Pragma: public");
          header("Expires: 0");     
          header("Cache-Control: private",false);
          header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
          header("Content-Description: File Transfer");    
          header("Content-type: application/octet-stream");
          header("Content-length: ".filesize($file));
          header("Content-Disposition: attachment; filename=\"".$fileName."\";");
          header("Content-Transfer-Encoding: binary");
          ob_flush();
          readfile($file);
       }
       else
       {
           echo "No file selected";
       }
   }
                
    //trailing slash for directories**all thumbs should be in jpg
  function CreateThumb( $pathToImage, $pathToThumb, $restrictionW=100,$restrictionH=100, $fixHeight=0,$stretch=0 ) //if fixheight==0 then restriction is for width, otherwise height
  {
         $fname=$pathToImage;
         // parse path for the extension
         $ext=strtolower(FileExtension($fname));
         //echo "Creating thumbnail for {$fname} <br />";
         if($ext == 'jpg' || $ext == 'jpeg' )
         {
           $img = ImageCreateFromJPEG( $pathToImage );
         }

         else if($ext == 'gif' )
         {
           $img = ImageCreateFromGif( $pathToImage );
         }

         else if($ext == 'png')
         {
           $img = ImageCreateFromPNG( $pathToImage );
         }
         else return "invalid image extenstion for thumb src";

         $width = imagesx( $img );
         $height = imagesy( $img );

         // calculate thumbnail size
         if($width<$restrictionW && $height<$restrictionH && $stretch==0)
         {       
           $new_width = $width;
           $new_height = $height;
         }
         else
         {
             if($fixHeight==0)
             {
               $new_width = $restrictionW;
               $new_height = floor( $height * ( $restrictionW/ $width ) );
               if($new_height>$restrictionH)
               {
                   $new_height=$restrictionH;
                   $new_width = floor( $width * ( $restrictionH/$height) );
               }
             }
             else
             {     
               $new_height = $restrictionH;
               $new_width = floor( $width * ( $restrictionH/$height) );  
               if($new_width>$restrictionW)
               {
                   $new_width=$restrictionW;
                   $new_height = floor( $height * ( $restrictionW/$width) );
               }

             }
         }
         $tmp_img = imagecreatetruecolor( $new_width, $new_height );
         //if($ext == 'gif' ||$ext == 'png')
         //{

               imagealphablending($tmp_img, false);   
               $trnprt_indx = imagecolorallocate($tmp_img,255,255,255);
               // Completely fill the background of the new image with allocated color.
               imagefill($tmp_img, 0, 0, $trnprt_indx);
        
               // Set the background color for new image to transparent
               imagecolortransparent($tmp_img, $trnprt_indx);
         //}

         $trnprt_indx = imagecolorallocate($img,255,255,255);
         imagecolortransparent($img, $trnprt_indx);
         ImageCopyResampled( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

        //save              
        DeleteFile($pathToThumb);
        if($ext == 'jpg' || $ext == 'jpeg' )
        {                                                            
          ImageJPEG($tmp_img, $pathToThumb,100);
        }

        else if($ext == 'gif' )
        {
          ImageGif($tmp_img, $pathToThumb);
        }

        else if($ext == 'png' || $ext == 'jpeg' )
        {
          ImagePNG($tmp_img, $pathToThumb);
        }
        ImageDestroy($tmp_img);  
        ImageDestroy($img);     
        if(file_exits($pathToThumb))
            return 0;
        return "Server Error: Couldn't save thumb: $pathToThumb";
  }
  function CreateThumbsFromDir( $pathToImages, $pathToThumbs, $restrictionW,$restrictionH, $fixHeight=0,$stretch=0 ) //if fixheight==0 then restriction is for width, otherwise height
  {
    // open the directory
    $dir = opendir( $pathToImages );

    // loop through it, looking for any/all JPG files:
    while (false !== ($fname = readdir( $dir )))
    {
      // parse path for the extension
         $ext=strtolower(FileExtension($fname));
         echo "Creating thumbnail for {$fname} <br />";
         if($ext == 'jpg' || $ext == 'jpeg' )
         {
           $img = ImageCreateFromJPEG( "{$pathToImages}{$fname}" );
         }

         else if($ext == 'gif' )
         {
           $img = ImageCreateFromGif( "{$pathToImages}{$fname}" );
         }

         else if($ext == 'png')
         {
           $img = ImageCreateFromPNG( "{$pathToImages}{$fname}" );
         }
         else continue;

         $width = imagesx( $img );
         $height = imagesy( $img );

         // calculate thumbnail size
         if($width<$restrictionW && $height<$restrictionH && $stretch==0)
         {       
           $new_width = $width;
           $new_height = $height;
         }
         else
         {
             if($fixHeight==0)
             {
               $new_width = $restrictionW;
               $new_height = floor( $height * ( $restrictionW/ $width ) );
               if($new_height>$restrictionH)
               {
                   $new_height=$restrictionH;
                   $new_width = floor( $width * ( $restrictionH/$height) );
               }
             }
             else
             {     
               $new_height = $restrictionH;
               $new_width = floor( $width * ( $restrictionH/$height) );  
               if($new_width>$restrictionW)
               {
                   $new_width=$restrictionW;
                   $new_height = floor( $height * ( $restrictionW/$width) );
               }

             }
         }
         echo "new height $new_height,old height $height, new width $new_width,old width $width";
         // create a new temporary image with white background
         $tmp_img = imagecreatetruecolor( $new_width, $new_height );
         //$whiteBack=ImageColorAllocate($tmp_img,255,255,255);
         //set white to transparent in case of gif /png
         //if($ext == 'gif' ||$ext == 'png')
         //{

               imagealphablending($tmp_img, false);   
               $trnprt_indx = imagecolorallocate($tmp_img,255,255,255);
               // Completely fill the background of the new image with allocated color.
               imagefill($tmp_img, 0, 0, $trnprt_indx);
        
               // Set the background color for new image to transparent
               imagecolortransparent($tmp_img, $trnprt_indx);
         //}


         //echo "transparent index:$trnprt_indx and color: ",$trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue'];

         //setting white as img's transparent color
         // copy and resize old image into new image    
         $trnprt_indx = imagecolorallocate($img,255,255,255);
         imagecolortransparent($img, $trnprt_indx);
         ImageCopyResampled( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

        //save
        if($ext == 'jpg' || $ext == 'jpeg' )
        {                                                            
          ImageJPEG($tmp_img, "{$pathToThumbs}{$fname}",100);
        }

        else if($ext == 'gif' )
        {
          ImageGif($tmp_img, "{$pathToThumbs}{$fname}");
        }

        else if($ext == 'png' || $ext == 'jpeg' )
        {
          ImagePNG($tmp_img, "{$pathToThumbs}{$fname}");
        }
        ImageDestroy($tmp_img);
    }
    // close the directory
    closedir( $dir );
  }
  function MakeTransparent($pathToImages, $destinationPath,$transparentColorR,$transparentColorG,$transparentColorB,$resWidth=0,$resHeight=0) //saves in Gif format
  {
  
    // open the directory
    $dir = opendir( $pathToImages );

    // loop through it, looking for any/all JPG files:
    while (false !== ($fname = readdir( $dir )))
    {
      // parse path for the extension
         $ext=strtolower(FileExtension($fname));
         echo "Making transparent {$fname} <br />";
         if($ext == 'jpg' || $ext == 'jpeg' )
         {
           $img = ImageCreateFromJPEG( "{$pathToImages}{$fname}" );
         }

         else if($ext == 'gif' )
         {
           $img = ImageCreateFromGif( "{$pathToImages}{$fname}" );
         }

         else if($ext == 'png')
         {
           $img = ImageCreateFromPNG( "{$pathToImages}{$fname}" );
         }
         else continue;

         $width = imagesx( $img );
         $height = imagesy( $img ); 
         //echo "new height $newHeight,old height $height, new width $newWidth,old width $width";
         $newWidth=$resWidth;
         $newHeight=$resHeight;
         if($resWidth==0)
             $newWidth=$width;
         if($resHeight==0)
             $newHeight=$height;
             
         //echo "new height $newHeight,old height $height, new width $newWidth,old width $width";
         $newImg=ImageCreateTrueColor($newWidth,$newHeight);
         imagealphablending($newImg, false);
         //imagesavealpha($img,true);
         $transparentColorIndex=ImageColorAllocate($img,$transparentColorR,$transparentColorG,$transparentColorB);
         ImageFill($newImg,0,0,$transparentColorIndex);
         ImageColorTransparent($newImg,$transparentColorIndex);
         ImageCopyResized($newImg,$img,0,0,0,0,$newWidth,$newHeight,$width,$height);
         ImageGif($newImg,"{$destinationPath}{$fname}");
         ImageDestroy($img);
      }
  }

function GetHaversineDistance($lat1, $long1, $lat2, $long2)
   {
       global $KM;
       //$earth = 6371; //km change accordingly
       $earth = 3960; //miles

       if($KM)
           $earth = 6371;

       //Point 1 cords
       $lat1 = deg2rad($lat1);
       $long1= deg2rad($long1);

       //Point 2 cords
       $lat2 = deg2rad($lat2);
       $long2= deg2rad($long2);

       //Haversine Formula
       $dlong=$long2-$long1;
       $dlat=$lat2-$lat1;

       $sinlat=sin($dlat/2);
       $sinlong=sin($dlong/2);

       $a=($sinlat*$sinlat)+cos($lat1)*cos($lat2)*($sinlong*$sinlong);

       $c=2*asin(min(1,sqrt($a)));

       $d=round($earth*$c);

       return $d;
   }
?>