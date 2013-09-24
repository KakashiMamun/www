<?php
class ICodeFile
{
    public static function Add($fileInfo,$basePath,$resSize=0,$cdnId=0,$hasThumb='no',$permission=0644,$resExtensions=null)
    {  
        if(is_uploaded_file($fileInfo['tmp_name']))
        {
            if($resSize>0)
            {
                if($fileInfo['size']>$resSize)
                {
                   unlink($fileInfo['tmp_name']);
                   return -1;  //file limit exceeded
                }
            }
           
            $fileQuery="insert into icode_file(file_id,cdn_id,path,file_name,has_thumb,type,added_on) values(null,$cdnId,'','{$fileInfo['name']}','$hasThumb','{$fileInfo['type']}',now())";
            $fileId=ICodeDB::FreshInsertAndGetId($fileQuery,'icode_file');
            
            if($fileId>0)
            {
                //if not error
                $ext=ICodeTools::GetFileExtension($fileInfo['name']);
                $directory=ICodeFile::CreatePath($fileId);
                $absDirOfFile=$basePath.$directory;
                $saveAs=$absDirOfFile.$fileId;
                //die($absDirOfFile);
                if(!ICodeFile::CreateDir($absDirOfFile,$basePath))
                    return "Path couldn't be created.";
                
                //echo $saveDirectory;
                
                if(UploadFile($fileInfo,$saveAs,$permission,$resSize,$resExtensions)!==0)
                {
                    return "Uploading error.";
                }
                                         
                $saveAs=$basePath.$directory.$fileId.'.'.$ext;
                $saveAs=addslashes($saveAs);
                
                $updateDirectoryQuery="update icode_file set path='$saveAs' where file_id=$fileId";
                $updateStatus=ICodeDB::Update($updateDirectoryQuery);
                
                if($updateStatus==false)
                    return "Path update failed due to DB error.";
            }
            
            return $fileId;
        }
        else
            return 0;
    }
    
    public static function Remove($fileId)
    {
        $query="delete from icode_file where file_id=$fileId";
        $deleteStatus=ICodeDB::Delete($query);
        return $deleteStatus;
    }
                              
    /** ICode, Muktadir, Start, Revision **/
    public static function GetInfo($fileId)
    {
        global $CONFIGURATIONS;
        $query="select * from icode_file where file_id=$fileId";

        $afile=ICodeDB::GetResultRow($query);
        $path=$afile['path'];
        $afile['url']=str_replace($CONFIGURATIONS['ROOT'],$CONFIGURATIONS['BASE_URL'],$path);
        return $afile;
    }
    public static function GetByIds($fileIds)
    {
        $attachments=array();    
        if(!is_array($fileIds))
            return $attachments;
        $count=0;
        foreach($fileIds as $aFileId)
        {
            $fileInfo=ICodeFile::GetInfo($aFileId);            
            $attachments[$count]['file']=$fileInfo['path'];  
            $attachments[$count]['url']=$fileInfo['url'];
            $attachments[$count]['fileName']=$fileInfo['file_name'];
            $attachments[$count]['content_type']=$fileInfo['type'];

        }
        return $attachments;
    }     
    /** ICode, Muktadir, Start, Revision **/
    
    public static function Get($start=0,$limit=0,$from='',$to='',$params='')
    {
        $taken=false;
        $fromQuery='';
        $toQuery='';
        $limitQuery='';
        
        if($start!=0)
        {
            if($start!=0)
                $limitQuery=" limit $start,$limit";
        }

        if(strlen($from)!=0)
        {
            $fromQuery=" where added_on>='$from'";
            $taken=true;
        }
        
        if(strlen($to)!=0)
        {
            if($taken)
                $toQuery=" and added_on<='$to'";
            else
                $toQuery=" where added_on<='$to'"; 
        }
        
        $query="select * from icode_file".$fromQuery.$toQuery.$limitQuery;
    }

    public static function CreatePath($fileId)
    {
        $MAX_FILE_PER_DIR=300; //this will be fetched from configuration later
        $DIRECTORY_DEPTH=3;    //this will be fetched from configuration later
 
        $modResult=array();
                             
        $fileId=(int)($fileId/$MAX_FILE_PER_DIR);
        for($i=$DIRECTORY_DEPTH-1;$i>0;$i--)
        {
             $modResult=$fileId%$MAX_FILE_PER_DIR;
             $pathArr[$i]=$modResult;
             $fileId=(int)($fileId/$MAX_FILE_PER_DIR); 
        }
        //print_r($pathArr);
        ksort($pathArr);  
        //print_r($pathArr);
        $directory=implode('/',$pathArr);
       // echo "<br>$directory";
        $directory=$fileId."/".$directory.'/';
        
        return $directory;
    }
    
    public static function CreateDir($directory,$baseDir)
    {                                                                  
        if(substr($directory,strlen($directory)-1)=='/')
            $directory=substr($directory,0,strlen($directory)-1);
        if(substr($baseDir,strlen($baseDir)-1)=='/')
            $baseDir=substr($baseDir,0,strlen($baseDir)-1);
        //echo "<br>$directory\n base: $baseDir";
        if($directory==$baseDir || is_dir($directory))
            return true;
        else
        {
            $parent=substr($directory,0,strrpos($directory,'/'));
             
            if(!ICodeFile::CreateDir($parent,$baseDir))
                return false;
            
            else if(!mkdir($directory))
                return false;
            return true;
        }
       
   }

    public static function Download($fileId)
    {
        
    }
}
?>