<?php

class Article
{
    /* member type is the class name of that member */                                              
    public static $insertFields=array('title','content','ownerId');
    public static $updateFields=array('articleId','title','content','ownerId');
    public static $tableName='article';
    public static $idName='article_id';
    public static $formIdName='articleId';
    public static $className='Article';
    
    public static function Add()
    {                              
        if(($status=Article::Validate())!==1)
            return $status;
        //process password
        $insertSql="insert into article (title,content,owner_id)
                         values('".$_POST['title']."','".$_POST['content']."','".$_POST['ownerId']."')";
        if(($articleId=ICodeDB::FreshInsertAndGetId($insertSql,Article::$tableName))>0)
        {
            //User::PassToSubClass('Add',$articleId,);
            return $articleId;
        }                
        return 'Article could not be created due to DB error';
    }      
    public static function Update()
    {      
        if(($status=Article::Validate())!==1)
            return $status;
        //process password
                                   
//        $updateOptions=array();
//        if(isset($_POST['sample']))
//            $updateOptions[]="sample = '{$_POST['sample']}'";
//
//        $updateSql="update article set ".implode(' , ',$updateOptions)." where article_id=".$_POST['articleId'];
//        $and='';


        $updateSql="update article set
                           title='".$_POST['title']."',
                           content='".$_POST['content']."'
                           where article_id=".$_POST['articleId'];

        return ICodeDB::Update($updateSql);
    }
    public static function Validate()
    {
        //check non empty, not isset, etc
        $update=false;
        if(isset($_POST[Article::$formIdName]) && (int)$_POST[Article::$formIdName]>0) //means update
            $update=true;
        if($update)
        {
            $mustFields=Article::$updateFields;
        }
        else
            $mustFields=Article::$insertFields;

        if(($status=ICodeFormValidation::ValidateNonEmpty($mustFields))!==1)
            return $status;

        //now custom validation
        if($update)
        {
            if((int)$_POST[Article::$formIdName]<=0)
                return "Invalid ".Article::$formIdName;
            $uniqueCond='and article_id!='.$_POST['articleId'];
            if((int)$_POST['articleId']==0 ) //&& $_POST['articleClass']!='Admin')
                return 'Invalid article id';
            if(ICodeDB::IsKeyUsed(Article::$tableName,'title',$_POST['title'],$uniqueCond))
                return "Email already used for another account.";
        }
        else
        {   
            if(ICodeDB::IsKeyUsed(Article::$tableName,'title',$_POST['title']))
                return "title already used for another account.";
//            if($_POST['password']!=$_POST['password2'])
//                return "Passwords don't match";
        }
        return 1;
    }
    public static function Remove($id)
    {
        if(ICodeDB::Delete("delete from article where article_id='$id' limit 1"))
           return true;
    }
    public static function Get($start=0,$limit=0, $from='',$to='') //pending email verification and phone verifications won't show up
    {
        $upto='';
        $where='';
        $and='';
        $condition='';
        if($from!='')
        {
            $condition.=$and." date>='$from'";
            $and=' and ';
        }
        if($to!='')
        {
            $condition.=$and." date<='$to'";
            $and=' and ';
        }
        $where.=$condition;
        if($where!='')
            $where=' where '. $where;

        if($limit>0)
            $upto=" limit $start,$limit";
        return (ICodeDB::GetResultsSet("select * from article $where  order by article_id $upto"));

    }    


    
    public static function GetTotal()
    {

        $row=ICodeDB::GetResultRow("select count(*) as count from article");
        return $row['count'];
    }                                         
    public static function GetDetailInfo($id)
    {
        return ICodeDB::GetResultRow("select * from article_detail where article_id='$id'");
    }             
    public static function GetInfo($id)
    {
        return ICodeDB::GetResultRow("select * from article where article_id='$id'");
    }
    public static function GetInfoByTitle($title)
    {
        //echo "<br>select * from article where email='$email'<br>";
        return ICodeDB::GetResultRow("select * from article where title='$title'");
    }
    
    public static function ChangeStatus($id,$title)
    {
        if(ICodeDB::Update("update article set title='$title' where article_id='$id'"))
          return "Status updated";
        return "Status not updated due to DB failure";
    }             
    public static function GetImage($id)
    {
        global $Article_IMG_DIR,$Article_IMG_URL;
        if(($ext=SearchImgFileExt($Article_IMG_DIR.$id))===false)
            return $Article_IMG_URL."noImg.png";
        return $Article_IMG_URL.$id.".$ext";
    }  
    public static function GetImagePath($id)
    {
        global $Article_IMG_DIR,$Article_IMG_URL;
        if(($ext=SearchImgFileExt($Article_IMG_DIR.$id))===false)
            return false;
        return $Article_IMG_DIR.$id.".$ext";
    }  

}
?>