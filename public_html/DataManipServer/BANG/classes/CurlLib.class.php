<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 9/24/13
 * Time: 8:18 AM
 * To change this template use File | Settings | File Templates.
 */

class CurlLib {

        public static function curlPost($url,$fields)
        {

            $fields_string = '';
            //url-ify the data for the POST
            foreach($fields as $key=>$value)
            {
                $fields_string .= $key.'='. urlencode($value) . '&';
            }
            $fields_string = trim($fields_string, "&");
//            var_dump($fields_string);



            //open connection
            $ch = curl_init();

            //set the url, number of POST vars, POST data
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_POST, true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

            //execute post
            $result = curl_exec($ch);

            //close connection
            curl_close($ch);
            return $result;
        }

        public static function curlGet($url,$fields)
        {

            $fields_string = '';
            //url-ify the data for the GET
            foreach($fields as $key=>$value)
            {
                $fields_string .= $key.'='. urlencode($value) . '&';
            }
            $fields_string = trim($fields_string, "&");
            //var_dump($fields_string);


            //open connection
            $ch = curl_init();

            //set the url, number of GET vars, GET data
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURL, true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch,CURLOPT_CUSTOMREQUEST, 'GET');

            //execute post
            $result = curl_exec($ch);

            var_dump($result);

            //close connection
            curl_close($ch);
            return $result;
        }
}