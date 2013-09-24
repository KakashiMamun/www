/***************************/
//@Author: Adrian "yEnS" Mato Gondelle & Ivan Guardado Castro
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!                  
/***************************/
   
   
  

$(document).ready(function(){
    //global vars
    var form = $("#regForm");
    var businessName = $("#businessName");
    var businessNameInfo = $("#businessNameInfo");
    var email = $("#email");
    var emailInfo = $("#emailInfo");
    var pass1 = $("#password");
    var pass1Info = $("#passwordInfo");
    var pass2 = $("#password2");
    var pass2Info = $("#password2Info");
   
   var userId = $("#userId");
   var userIdInfo = $("#userIdInfo");
   var referer = $("#referer");
   var refererInfo = $("#refererInfo");
   var fname = $("#firstName");
   var fnameInfo = $("#firstNameInfo");
   var lname = $("#lastName");
   var lnameInfo = $("#lastNameInfo");
   var address1 = $("#address1");
   var address1Info = $("#address1Info");
   var address2  = $("#address2");
   var address2Info  = $("#address2Info");
   var city  = $("#city");
   var cityInfo  = $("#cityInfo");
   var postalCode = $("#postalCode");
   var postalCodeInfo = $("#postalCodeInfo");
   var phoneNumber = $("#phoneNumber");
   var phoneNumberInfo = $("#phoneNumberInfo");
   var countryCode = $("#countryCode");
   var countryCodeInfo = $("#countryCodeInfo");
   var ldescription = $("#longDescription");
   var ldescriptionInfo = $("#longDescriptionInfo");
   var sdescription = $("#shortDescription");
   var sdescriptionInfo = $("#shortDescriptionInfo");
   var website = $("#website");
   var websiteInfo = $("#websiteInfo");
   var category = $("#category");
   var categoryInfo = $("#categoryInfo");
   
   //On Submitting
    form.submit(function(){
        if(validateBusinessName() && validateEmail() && validatePass1() && validatePass2() && 
      validateUserId() &&  validateFName() && validateLName() && 
      validateAddress1() && validateAddress2() && validateCity() && validatePostalCode() 
      && validatePhoneNumber() && validateCountryCode() && validateLDescription() 
      && validateSDescription()  && validateCategory() )
            return true
        else
            return false;
    });
   

   function validateSDescription(){
         
        //if it's NOT valid
        if( sdescription.val().length < 10 || sdescription.val().length >200 ){
            sdescription.addClass("error");
            sdescriptionInfo.text("We want names with min 10 and max 200 letters!");
            sdescriptionInfo.addClass("error");
            return false;
        }
        //if it's valid
        else{
            sdescription.removeClass("error");
            sdescriptionInfo.text("");
            sdescriptionInfo.removeClass("error");
            return true;
        }
    }
   function validateLDescription(){
        //if it's NOT valid
        if(ldescription.val().length < 20){
            ldescription.addClass("error");
            ldescriptionInfo.text("Please Give Some Detail Info");
            ldescriptionInfo.addClass("error");
            return false;
        }
        //if it's valid
        else{
            ldescription.removeClass("error");
            ldescriptionInfo.text("");
            ldescriptionInfo.removeClass("error");
            return true;
        }
    }
   
   function validateCountryCode(){
        //if it's valid
        if(countryCode.val() != 0){
         countryCode.removeClass("error");
            countryCodeInfo.text("");
            countryCodeInfo.removeClass("error");
            return true;
            
        }
        //if it's NOT valid
        else{
            countryCode.addClass("error");
            countryCodeInfo.text("Please Select a Country");
            countryCodeInfo.addClass("error");
            return false;
        }
    }
   function validateCategory(){
        //if it's valid
        if(category.val() != 0){
         category.removeClass("error");
            categoryInfo.text("");
            categoryInfo.removeClass("error");
            return true;
            
        }
        //if it's NOT valid
        else{
            category.addClass("error");
            categoryInfo.text("No category selected");
            categoryInfo.addClass("error");
            return false;
        }
    }
   function validatePhoneNumber(){
        //if it's NOT valid
        if(phoneNumber.val().length == 0){
            phoneNumber.addClass("error");
            phoneNumberInfo.text("Invalid Phone Number Given");
            phoneNumberInfo.addClass("error");
            return false;
        }
        //if it's valid
        else{
            phoneNumber.removeClass("error");
            phoneNumberInfo.text("");
            phoneNumberInfo.removeClass("error");
            return true;
        }
    }
   function validatePostalCode(){
        //if it's NOT valid
        if(postalCode.val().length == 0 ){
            postalCode.addClass("error");
            postalCodeInfo.text("Please Enter Valid Postal code");
            postalCodeInfo.addClass("error");
            return false;
        }
        //if it's valid
        else{
            postalCode.removeClass("error");
            postalCodeInfo.text("");
            postalCodeInfo.removeClass("error");
            return true;
        }
    }
   
   function validateCity(){
        //if it's NOT valid
        if(city.val().length == 0 ){
            city.addClass("error");
            cityInfo.text("Invalid city Name");
            cityInfo.addClass("error");
            return false;
        }
        //if it's valid
        else{
            city.removeClass("error");
            cityInfo.text("");
            cityInfo.removeClass("error");
            return true;
        }
    }
   function validateAddress2(){
        //if it's NOT valid
        if(address2.val().length > 140 ){
            address2.addClass("error");
            address2Info.text("Address Length is too much");
            address2Info.addClass("error");
            return false;
        }
        //if it's valid
        else{
            address2.removeClass("error");
            address2Info.text("");
            address2Info.removeClass("error");
            return true;
        }
    }   
   function validateAddress1(){
        //if it's NOT valid
      if(address1.val().length == 0 )
      {
         address1.addClass("error");
            address1Info.text("Invalid address given");
            address1Info.addClass("error");
            return false;
      }
        else if(address1.val().length > 45){
            address1.addClass("error");
            address1Info.text("Address Length is too much .Please use address2 filed for Large address");
            address1Info.addClass("error");
            return false;
        }
        //if it's valid
        else{
            address1.removeClass("error");
            address1Info.text("");
            address1Info.removeClass("error");
            return true;
        }
    }
   function validateLName(){
        //if it's NOT valid
        if(lname.val().length == 0 ){
            lname.addClass("error");
            lnameInfo.text("Invalid Last Name");
            lnameInfo.addClass("error");
            return false;
        }
        //if it's valid
        else{
            lname.removeClass("error");
            lnameInfo.text("");
            lnameInfo.removeClass("error");
            return true;
        }
    }
   function validateFName(){
        //if it's NOT valid
        if(fname.val().length ==0  ){
            fname.addClass("error");
            fnameInfo.text("Invalid First Name");
            fnameInfo.addClass("error");
            return false;
        }
        //if it's valid
        else{
            fname.removeClass("error");
            fnameInfo.text("");
            fnameInfo.removeClass("error");
            return true;
        }
    }
    
   function IsUserExists()
   {
     
     return  $.get("validateUserId.php",{userId : userId.val()} ,function(data) {
         if(data == 1) {
            userId.addClass("error");
            userIdInfo.text("ID \""+userId.val()+"\"already Taken");
            userId.val('');
            userIdInfo.addClass("error");         
            return false;
         }
         else 
         {
            userIdInfo.text("");
            return true;;
         }
      });
     
   
   }
    function validateUserId(){
        //if it's NOT valid
        if(userId.val().length == 0){
         
            userId.addClass("error");
            userIdInfo.text("Invalid Id");
            userIdInfo.addClass("error");         
            return false;
        }
        //if it's valid
        else{
         IsUserExists();
            userId.removeClass("error");
            userIdInfo.text("");
            userIdInfo.removeClass("error");
            return true; 
      }
    }
    function IsEmailExists()
   {

     return  $.get("validateEmail.php",{email : email.val()} ,function(data) {
         if(data == 1) {
            email.addClass("error");
            emailInfo.text("Email \""+email.val()+"\"already used in another account");
            email.val('');
            emailInfo.addClass("error");
            return false;
         }
         else
         {
            emailInfo.text("");
            return true;;
         }
      });


   }
   function validateEmail(){
        //testing regular expression
        var a = $("#email").val();
        var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
        //if it's valid email
        if(filter.test(a)){
            IsEmailExists()
            email.removeClass("error");
            emailInfo.text("");
            emailInfo.removeClass("error");
            return true;
        }
        //if it's NOT valid
        else{

            email.addClass("error");
            emailInfo.text("Type a valid e-mail please");
            emailInfo.addClass("error");
            return false;
        }
    }
    function validateBusinessName(){
        //if it's NOT valid
        if(businessName.val().length == 0){
            businessName.addClass("error");
            businessNameInfo.text("Enter a Valid Name");
            businessNameInfo.addClass("error");
            return false;
        }
        //if it's valid
        else{
            businessName.removeClass("error");
            businessNameInfo.text("");
            businessNameInfo.removeClass("error");
            return true;
        }
    }
    function validatePass1(){
        var a = $("#password");
        var b = $("#password2");

        //it's NOT valid
        if(pass1.val().length <5){
            pass1.addClass("error");
            pass1Info.text("At least 5 characters: letters, numbers and '_'");
            pass1Info.addClass("error");
            return false;
        }
        //it's valid
        else{           
            pass1.removeClass("error");
            pass1Info.text("");
            pass1Info.removeClass("error");
            validatePass2();
            return true;
        }
    }
    function validatePass2(){
        var a = $("#password");
        var b = $("#password2");
        //are NOT valid
        if( pass1.val() != pass2.val() ){
            pass2.addClass("error");
            pass2Info.text("Passwords doesn't match!");
            pass2Info.addClass("error");
            return false;
        }
        //are valid
        else{
            pass2.removeClass("error");
            pass2Info.text("");
            pass2Info.removeClass("error");
            return true;
        }
    }
    
    //On blur
    businessName.blur(validateBusinessName);
    email.blur(validateEmail);
    pass1.blur(validatePass1);
    pass2.blur(validatePass2);
   userId.blur(validateUserId);
   
   fname.blur(validateFName);
   lname.blur(validateLName);
   address1.blur(validateAddress1);
   address2.blur(validateAddress2);
   city.blur(validateCity);
   postalCode.blur(validatePostalCode);
   phoneNumber.blur(validatePhoneNumber);
   countryCode.blur(validateCountryCode);
   ldescription.blur(validateLDescription);
   sdescription.blur(validateSDescription);
   
   category.blur(validateCategory);
   
   
    //On key press
    businessName.keyup(validateBusinessName);
    pass1.keyup(validatePass1);
    pass2.keyup(validatePass2);
    
   
   fname.keyup(validateFName);
   lname.keyup(validateLName);
   address1.keyup(validateAddress1);
   address2.keyup(validateAddress2);
   city.keyup(validateCity);
   postalCode.keyup(validatePostalCode);
   phoneNumber.keyup(validatePhoneNumber);
   countryCode.keyup(validateCountryCode);
   ldescription.keyup(validateLDescription);
   sdescription.keyup(validateSDescription);
  
    
 
});