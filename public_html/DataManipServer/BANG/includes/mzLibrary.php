<?php
    function UploadFileGroup($fileArray,$productImagePath)//productImagePath = PATH/id
    {
        $return = '';
        $fileCount = GetCountFileGroup($productImagePath."-");
        foreach($fileArray['icon']['name'] as $i=>$name)
        {
            $fileCount++;
            $fileInfo = array();
            $fileInfo['name'] = $name;
            $fileInfo['type'] = $fileArray['icon']['type'][$i];
            $fileInfo['tmp_name'] = $fileArray['icon']['tmp_name'][$i];
            $fileInfo['error'] = $fileArray['icon']['error'][$i];
            $fileInfo['size'] = $fileArray['icon']['size'][$i];
            
            $error=UploadFile($fileInfo,$productImagePath."-".$fileCount);
            if($error!==0)
            {
                $return .= " <br>icon ".$error;
            }
        }
        return $return;
    }
    function DeleteFileFromGroup($deletedImage)//deletedImage=PATH/id-no
    {
       $position = strrpos($deletedImage,'-');
       $deletedimageNo = (int)substr($deletedImage,$position+1);
       $path =  substr($deletedImage,0,$position+1);

       $fileCount = GetCountFileGroup($path);

       $existingFiles = array();
       $existingFiles = glob("$path*");
       $filesToRename = array();
       $fileToRemove = '';
       if(count($existingFiles))
       {
           foreach($existingFiles as $exFile)
           {
                 $pos = strrpos($exFile,'-');
                 $iNo = (int)substr($exFile,$pos+1);
                 if($iNo>$deletedimageNo)
                 {
                     $filesToRename[] = $exFile;
                 }
                 if($iNo==$deletedimageNo)
                 {
                     $fileToRemove = $exFile;
                 }
           }
       }

       sort($filesToRename);
       $fileDeleteStatus = DeleteFile($fileToRemove);
       foreach($filesToRename as $oldFile)
       {
           $ext = FileExtension($oldFile);
           if($ext!="")
           {
             $tmp = $oldFile;
             str_replace("$ext","",$tmp);
             $pos = strrpos($tmp,'-');
             $imageNo = (int)substr($tmp,$pos+1);
             $path =  substr($tmp,0,$pos+1);

             $newName = $path .($imageNo - 1).".$ext";
             rename($oldFile,$newName);
           }
       }
       return $fileDeleteStatus;
    }
    function GetCountFileGroup($imagePath)
    {
        $fileCount = 0;
        if (glob("$imagePath*") != false)
        {
            $fileCount = count(glob("$imagePath*"));
        }
        return $fileCount;
    }

    function GetHtmlMultipleFile($fileName = 'icon')
    {
             $html = "";
             $html .= "<script type='text/javascript'>
                     
                     var fileCount = 0;
                     function AddDynamicHtmlChild()
                     {
                         fileCount++;
                         
                         var child = '<div id=\"".$fileName."'+fileCount+'\"> <input type=file name=\"".$fileName."[]\"> <a href=\"javascript:void(0);\" onclick=\"RemoveDynamicHtmlChild('+fileCount+');\">Remove</a></div>';
                         $(\"#multipleFileInputDiv\").append(child); 
                     }
                     function RemoveDynamicHtmlChild(counter)
                     {
                         fileCount--;
                         $(\"#".$fileName."\"+counter).remove();
                     }
                     </script>";
             $html .= "<div id='multipleFileInputDiv'><a href='javascript:void(0);' onclick='AddDynamicHtmlChild();'>Add icon</a> </div>";
             return $html;
    }
?>