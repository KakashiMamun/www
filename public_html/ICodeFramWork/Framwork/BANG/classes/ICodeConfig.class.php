<?php
class ICodeConfig
{
      public static function Load()
      {
          global $CONFIGURATIONS,$ROOT,$BASE_URL;
          $CONFIGURATIONS = array(); 
          $CONFIGURATIONS['ROOT']=$ROOT;               
          $CONFIGURATIONS['BASE_URL']=$BASE_URL;    
          $CONFIGURATIONS['PER_PAGE']=10;
          //populate directories
          $CONFIGURATIONS['INCLUDE_DIR']=$CONFIGURATIONS['ROOT'].'includes/';
          $CONFIGURATIONS['IMAGE_DIR']=$CONFIGURATIONS['ROOT'].'images/';
          $CONFIGURATIONS['LOGO_DIR']=$CONFIGURATIONS['IMAGE_DIR'].'logo/';
          $CONFIGURATIONS['MEMBER_DIR']=$CONFIGURATIONS['ROOT'].'member/';
          $CONFIGURATIONS['CLASS_DIR']=$CONFIGURATIONS['ROOT'].'classes/';
          $CONFIGURATIONS['FORMS_DIR']=$CONFIGURATIONS['ROOT'].'forms/';

          $CONFIGURATIONS['IMAGE_URL']=$CONFIGURATIONS['BASE_URL'].'images/';
          $CONFIGURATIONS['LOGO_URL']=$CONFIGURATIONS['IMAGE_URL'].'logo/';      
          $CONFIGURATIONS['MEMBER_URL']=$CONFIGURATIONS['BASE_URL'].'member/';
          $CONFIGURATIONS['CSS_URL']=$CONFIGURATIONS['BASE_URL'].'CSS/';
          $CONFIGURATIONS['JS_URL']=$CONFIGURATIONS['BASE_URL'].'JS/';

          /* load from database */

          $Configurations = ICodeDB::GetResultsSet("SELECT * FROM icode_configuration");
          if(count($Configurations) > 0)
          {
              foreach($Configurations as $configRow)
              {
                  $CONFIGURATIONS[$configRow['name']] = $configRow['value'];
              }
          }
          //EchoPre("Configurations Loaded");
          //print_r($CONFIGURATIONS);

      }

      public static function Get($type='')
      {
          $where='';
          if($type!='')
              $where=" where type='$type' ";
          $Configurations = ICodeDB::GetResultsSet("SELECT * FROM icode_configuration $where order by name");
          return $Configurations;
      }

      public static function Read($name)
      {
          $configuration = ICodeDB::GetResultRow("SELECT value FROM icode_configuration WHERE name='{$name}'");
          if(empty($configuration))
          {
            return '';
          }
          return $configuration['value'];
      }

      public static function Write($name,$value,$type,$isTimeStamp=false)
      {
          global $CONFIGURATIONS;
          if($isTimeStamp)                                                                                                                    
              $status = ICodeDB::Replace("REPLACE INTO icode_configuration (name,value,type) VALUES ('{$name}',now(),'$type')");
          else
              $status = ICodeDB::Replace("REPLACE INTO icode_configuration (name,value,type) VALUES ('{$name}','{$value}','$type')");
          if($status)
              $CONFIGURATIONS[$name]=$value;  //adding to currnt session
          return $status;
      }

      public static function Update($name,$value)
      {         
          global $CONFIGURATIONS;
          $update="update icode_configuration set value='$value' where name='$name'";
          $status=ICodeDB::Update($update);
          if($status)
              $CONFIGURATIONS[$name]=$value;  //adding to currnt session
          return $status;
      }
}
?>