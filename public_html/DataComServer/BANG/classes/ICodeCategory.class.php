<?php

abstract class ICodeCategory
{                         
    public static function Add()
    {
        
        global $CAT_ICON_DIR;
        $return=array();
        $return['icon']='';
        $return['id']=0;
        $insert="insert into category (name, parent)
                        values
                        ('".$_POST['name']."','".$_POST['parent']."')";
        if(($id=ICodeDB::FreshInsertAndGetId($insert,'category'))!=0)
        {
            //upload video  \
            $return['id']=$id;
            $error=UploadFile($_FILES['icon'],$CAT_ICON_DIR.$id);
            if($error!==0)
            {
                $return['icon']=" <br>icon ".$error;
            }
            return $return;
        }
        else
            return $return;
    }               
    public static function Update()
    {
        
        global $CAT_ICON_DIR;
        $id=$_POST['catId'];
        $return=array();
        $return['icon']='';  
        $return['id']=0;
        $update="update category
                        set name='".$_POST['name']."',
                        parent='".$_POST['parent']."'
                        where cat_id=$id";
        if(ICodeDB::Update($update)==true)
        {                     
            $return['id']=$id;
            $error=UploadFile($_FILES['icon'],$CAT_ICON_DIR.$id);
            if($error!==0)
            {
                $return['icon']=" <br>icon ".$error;
            }
            return $return;
        }
        else
            return $return;
    }
    public static function Edit()
    {
    }     
    public static function Remove($id)
    {
        $catInfo=Category::GetInfo($id);
        $parent=$catInfo['parent'];
        $q="update category set parent=$parent where parent=$id";
        return ICodeDB::Delete("delete from category where cat_id=$id limit 1");
    }
    public static function Get($parent=0)
    {          
        return ICodeDB::GetResultsSet("select * from category where parent=$parent order by name");

    }
    public static function GetInfo($id)
    {                 
        return ICodeDB::GetResultRow("select * from category where cat_id=$id");
    }     
    public static function GetImage($id)
    {
        global $CAT_ICON_DIR,$CAT_ICON_URL;
        if(($ext=SearchImgFileExt($CAT_ICON_DIR.$id))===false)
            return $CAT_ICON_URL."noImg.png";
        return $CAT_ICON_URL.$id.".$ext";
    }  
    public static function GetName($id)
    {                                  
        $row=ICodeDB::GetResultRow("select name from category where cat_id=$id");
        if(empty($row))
            return "";
        return $row['name'];
    }
    /*
    public static function ()
    {
    }
    public static function ()
    {
    }
    */
}