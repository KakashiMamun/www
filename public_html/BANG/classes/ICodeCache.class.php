<?php
class ICodeCache
{                         
    public static $cacheStarted=false;
    public static function GetInfo($cacheName)
    {
        //TIMESTAMPDIFF(unit,datetime_expr1,datetime_expr2) Returns datetime_expr2 – datetime_expr1, w
        return ICodeDB::GetResultRow("select *, TIMESTAMPDIFF(SECOND, expiry_date,NOW()) as is_expired  from cache where cache_name='$cacheName'");
    }
    public static function StartCache($cacheName, $cacheDuration,$userId=0) //returns
    {
        $cacheInfo=ICodeCache::GetInfo($cacheName);
        if(empty($cacheInfo) || $cacheInfo['is_expired']>1)  //NOW()-expiry_date
        {
            //start caching
            ob_start();
            ICodeCache::$cacheStarted=true;

        }
        else
        {
            echo $cacheInfo['data'];
            return false;
        }

    }
    public static function EndCache($cacheDuration)
    {         
        $data=ob_get_clean()//?
        ICodeCache::$cacheStarted=false;
    }
}
?>