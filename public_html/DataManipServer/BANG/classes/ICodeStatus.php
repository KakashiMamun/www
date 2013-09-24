<?php
class ICodeStatus
{
   //we define all the status messages here:
   public static function LoadStatuses()
   {
       global $STATUSES,$ACRONYMS;
       //we won't save or load from DB. We just populate it here
       $STATUSES['TRUE']= true ;
       $STATUSES['FALSE']= false ;
       $STATUSES['DB_ERROR']= -1 ;

       //related to usership                   
       $STATUSES['NOT_LOGGED_IN']= 10 ;
       $STATUSES['INVALID_LOGIN']= 11 ;
       $STATUSES['SUSPENDED']= 12 ;       
       $STATUSES['NOT_ADMIN']= 100 ;
       $STATUSES['RESTRICTED']= 101 ;
   }


}
?>