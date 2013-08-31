<?php
   class ICodeFormValidation
   {                                               
       public static function DecodeBase64($var)
       {                        
               if(is_array($var))
               {
                   foreach($var as $key=>$val)
                   {
                       $var[$key]=ICodeFormValidation::DecodeBase64($val);
                   }
                   return $var;
               }
               return base64_decode($var);
       }
       public static function EncodeBase64($var)
       {                        
               if(is_array($var))
               {
                   foreach($var as $key=>$val)
                   {
                       $var[$key]=ICodeFormValidation::EncodeBase64($val);
                   }
                   return $var;
               }
               return base64_encode($var);
       }
       public static function TrimDeep($var)
       {                        
               if(is_array($var))
               {
                   foreach($var as $key=>$val)
                   {
                       $var[$key]=ICodeFormValidation::TrimDeep($val);
                   }
                   return $var;
               }
               return trim($var);
       }
       
         
       public static function TrimAll($test)          //not using it in the TrimDeep because it's special
       {
           return trim(ereg_replace( ' +', ' ', $test));
       }

       public static function AddSafeSlashesDeep($array)
       {
           //THIS WILL CHECK MAGIC_QUOTES_GPC
           if(!get_magic_quotes_gpc())
           {
               if(is_array($array))
               {
                 foreach($array as $key=>$val)
                 {
                     $array[$key]=ICodeFormValidation::AddSafeSlashesDeep($val);
                 }
                 return $array;
               }
               else
                   return AddSlashes($array);
           }       
           return $array;
       }
       public static function ProcessFormData($array)
       {
           $array=ICodeFormValidation::TrimDeep($array);
           $array=ICodeFormValidation::AddSafeSlashesDeep($array);
           return $array;
       }
       public static function StripSlashesDeep($array)
       {
                                   
               if(is_array($array))
               {
                 foreach($array as $key=>$val)
                 {
                     $array[$key]=ICodeFormValidation::StripSlashesDeep($val);
                 }
                 return $array;
               }
               else
                   return StripSlashes($array);
       }

       public static function SizeCheck($str,$min,$max)
       {
           $len=strlen($str);
           if($len<$min || $len>$max)  return false;
           return true;

       }
       //regular expressions           
       public static function IsEmail($email)
       {                                      
           $pattern = '/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])' .'(([a-z0-9-])*([a-z0-9]))+' . '(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i';
           if(preg_match ($pattern, $email))
               return true;
           return false;
       }
       public static function IsPassword($password)
       {
           if(SizeCheck($password,4,16))
               return false;
           if(preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,30}\$/",$password))
               return true;
           return false;
       }
       public static function UsernameCheck($username)
       {
           if(preg_match("/^[a-zA-Z0-9_]+\$/",$username))
               return true;
           return false;
       }
       public static function IsAlphaNumeric($str)
       {       
           if(preg_match("/^[a-zA-Z0-9]+\$/",$username))
               return true;
           return false;
       }
       public static function ValidateNonEmpty($array)
       {
            foreach($array as $value)
            {
                if(!isset($_POST[$value]) || is_null($_POST[$value]) || $_POST[$value]=="" )
                    return $value. " cannot be empty.";
            }
            return 1;
       }


    }

?>