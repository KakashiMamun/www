<?php
class ICodeRSS
{
   public static function GetObjectArray($feedUrl)
   {
       $xml = simplexml_load_file($feedUrl);
       //var_dump($xml);
       $items = $xml->channel->item;
      //var_dump($items);
       return $items;
   }              
   public static function CreateRSSFeed($data)
   {
   }
   public static function GetDefaultNameSpaces()
   {                                         
       $nameSpaces = array
       (
           "content"  => "http://purl.org/rss/1.0/modules/content/" ,
           "wfw"  => "http://wellformedweb.org/CommentAPI/" ,
           "dc"  => "http://purl.org/dc/elements/1.1/"
       );
       return $nameSpaces;
   }
}
/*

   public static function()
   {
   }
   
   public static function Get()
   {
       global $BLOG_URL;
       $feedUrl= $BLOG_URL."feed/?post_type=prayer";
       $items=ICodeRSS::GetObjectArray($feedUrl);
       $nameSpaces=ICodeRSS::GetDefaultNameSpaces();
       $prayers=array();
       // remove invalid items and outdated items
       $count=0;
       foreach($items as $aP)
       {
           //var_dump($aP);     
           $description=(string)trim($aP->description);
           $descArr=explode('/%divider%/',$description);
           $prayerDate=trim($descArr[0]);
           $prayerContent=trim($descArr[1]);
           if(stripos($prayerDate,'invalid')===0)
               continue;
           if(stripos($prayerContent,'invalid')===0)
               continue;

           $title=(string)$aP->title;
           $pubDate= (string)$aP->pubDate;
           $dc=$aP->children($nameSpaces['dc']);
           $author=(string)$dc->creator;

                                  
           $prayers[$count]['title'] = $title;
           $prayers[$count]['pubDate'] = $pubDate;      
           $prayers[$count]['prayerContent'] = $prayerContent;
           $prayers[$count]['prayerDate'] = $prayerDate;
           $prayers[$count]['author'] =$author ;
           $count++;
       }        
       //print_r($prayers);
       return $prayers;

   }
*/
?>