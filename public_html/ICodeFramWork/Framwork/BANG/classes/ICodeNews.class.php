<?php
class ICodeNews
{
   public static function Get()
   {
       global $BLOG_URL;
       $feedArr=News::GetFeeds();    
       $prayers=array();
       // remove invalid items and outdated items
       $count=0;
       foreach($feedArr as $aFeed)
       {
           $feedUrl=$aFeed['url'];
           $items=ICodeRSS::GetObjectArray($feedUrl);
           $nameSpaces=ICodeRSS::GetDefaultNameSpaces();
           foreach($items as $aP)
           {
               //var_dump($aP);     
               $description=(string)trim($aP->description);
               $title=(string)$aP->title;
               $pubDate= (string)$aP->pubDate;
               $dc=$aP->children($nameSpaces['dc']);
               if($dc)
                   $author=(string)$dc->creator;
               else if($aP->author)
                   $author=(string)$aP->author;

                                      
               $prayers[$count]['title'] = $title;
               $prayers[$count]['pubDate'] = $pubDate;      
               $prayers[$count]['description'] = $description;
               $prayers[$count]['link'] = (string)$aP->link;
               $prayers[$count]['author'] =$author ;
               $count++;
           }
       }
       //print_r($prayers);
       return $prayers;

   }
   public static function GetFeeds()
   {
       return ICodeDB::GetResultsSet("select * from feed  order by title asc");
   }
   public static function Add()
   {
       $url=str_replace('http://','',$_POST['url']);
       $url='http://'.$url;
       $insert="insert into feed (title,url) values('{$_POST['title']}','{$url}')";
       if(ICodeDB::FreshInsert($insert))
           return "Added";
       return "DB error on ADD";
   }
   public static function Remove($feedId)
   {              
       $delete="delete from feed where feed_id=$feedId";
       if(ICodeDB::Delete($delete))
           return "Deleted";  
       return "DB error on DELETE";
       
   }

}
/*

   public static function()
   {
   }
*/
?>