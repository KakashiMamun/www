<?php

abstract class Country
{       
   public static function Add($code,$name)
   {
       return ICodeDB::FreshInsertAndGetId("insert into country (country_code,name) values('$code','$name')");
   }
   public static function Edit($code,$name)
   {
       return ICodeDB::Update("update country set name='$name' where country_code='$code'");
   }
   public static function Remove($catId)
   {
       return ICodeDB::DeleteRecord("delete from country where country_code='$code' limit 1");
   }            
   public static function GetCountries()
   {
       return ICodeDB::GetResultsSet("select * from country  order by name asc");
   }        
   public static function GetNameByCode($code)
   {
       $row=ICodeDB::GetResultRow("select name from country  where country_code='$code'");
       return $row['name'];
   }
   public static function GetStates(){
       return ICodeDB::GetResultsSet("select name from state");
   }
   public static function GetStateName($stateId){
       $row=ICodeDB::GetResultRow("select name from tb_states  where state_id=$stateId");
       return $row['name'];
   }
   public static function GetCountriesOptions($countryCode=0,$checkedCode=""){
       $countryInfo = "";
       $countryOptionHtml = "";
       if($countryCode!=0){
            $countryInfo=Country::GetCountryByCode($countryCode);
       }
       else{
            $countryInfo=Country::GetCountries();
       }
       foreach($countryInfo as $aCountry)
       {
           $checked= "";
           if($checkedCode!="" && $checkedCode==$aCountry['country_code'])
               $checked = "checked=checked";
           $countryOptionHtml .=  "<option $checked value={$aCountry['country_code']}>{$aCountry['name']}</option>";
       }
       return $countryOptionHtml;
   }
   public static function GetStateOptions($stateId=0)
   {
       $statesInfo = "";
       $stateOptionHtml = "<option  value='0'>NA</option>";;
       $statesInfo=ICodeDB::GetResultsSet("select * from state");
       
       //EchoPre($statesInfo);
       foreach($statesInfo as $aState)
       {
           $selected= "";
           if($stateId==$aState['state_id'])
               $selected = "selected=selected";
           $stateOptionHtml .=  "<option $selected value={$aState['state_id']}>{$aState['name']}</option>";
       }
       return $stateOptionHtml;
   }
  
/*
   public static function ()
   {
   }
*/
}

?>