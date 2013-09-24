<?php

class City
{       
   public static function Add($name,$stateId)
   {
       $cityId=City::GetIdByName($name);
       if($cityId>0)
           return $cityId;
       return ICodeDB::FreshInsertAndGetId("insert into city (name,state_id) values('$name',$stateId)",'city');
   }
   public static function Edit($code,$name)
   {
       return ICodeDB::Update("update city set name='$name' where city_id='$code'");
   }
   public static function Remove($cityId)
   {
       return ICodeDB::DeleteRecord("delete from city where city_id='$cityId' limit 1");
   }
   public static function Search($name)
   {
       return ICodeDB::GetResultsSet("select * from city where name like %$name%");
   }        
   public static function GetCityName($cityId)
   {
      // echo "select name from city  where city_id=$cityId";
       $row=ICodeDB::GetResultRow("select name from city  where city_id=$cityId");
       return $row['name'];
   }
   public static function GetIdByName($name)
   {
       $row=ICodeDB::GetResultRow("select city_id from city  where name='$name'");
       if(empty($row))
           return 0;
       return $row['city_id'];
   }
   public static function GetInfo($cityId)
   {                
       return ICodeDB::GetResultRow("select * from city  where city_id=$cityId");
   }
   public static function GetCityOptions($stateId=0,$name='',$cityId=0)
   {
       $cityInfo = "";
       $cityOptionHtml = "";
       $where='';
       $and='';
       if($stateId != 0)
       {
           $where=" where state_id=$stateId ";
           $and='';
       }
       if($where!='')
           $citySql="select * from city $where";
       
       if($name!='')
       {                    
           $cityByNameSql="select * from city where name like %$name%";
           if($citySql!='')
               $citySql="($citySql) union ($cityByNameSql)";
           else
               $citySql=$cityByNameSql;
       }
       //echo $citySql;
       $cityInfo = ICodeDB::GetResultsSet($citySql);
       foreach($cityInfo as $aCity)
       {
           $selected= "";
           if($cityId!=0 && $cityId==$aCity['city_id'])
               $selected = "selected=selected";
           $cityOptionHtml .=  "<option $selected value={$aCity['city_id']}>{$aCity['name']}</option>";
       }
       return $cityOptionHtml;
   }
}
?>