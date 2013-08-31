
$(document).ready(function()
{
    $( "#dialog:ui-dialog" ).dialog( "destroy" );         
    $( "#siteDialog" ).dialog({
       autoOpen: false,
       height: 300,
       width: 590,
       modal: true
    });
    $( "#recipientDialog" ).dialog({
       autoOpen: false,
       height: 400,
       width: 700,
       modal: true
    });


});
                             
function ShowSiteEditForm(siteId)
{
    //first add him to database
    //if succcessful add him to the probable list of administrators
    //
    //alert('aa');
    var callUrl='../ajax/siteEditForm.php';
    formData='siteId='+siteId;
    $.ajax({
        type: "POST",
        url: callUrl,
        data: formData,
        async: false,
        success: function( response )
        {
            //alert(response);
            $('#siteDialog').html(response);
            $( "#siteDialog" ).dialog('open');
        }


    });
}                       
function ShowSiteRecipientList(siteId)
{
    //first add him to database
    //if succcessful add him to the probable list of administrators
    //
    //alert('aa');
    var callUrl='../ajax/siteRecipientList.php';
    formData='siteId='+siteId;
    $.ajax({
        type: "POST",
        url: callUrl,
        data: formData,
        async: false,
        success: function( response )
        {
            //alert(response);
            $('#recipientDialog').html(response);
            $( "#recipientDialog" ).dialog('open');
        }


    });
}
function ShowSiteAdministratorList(siteId)
{
    //first add him to database
    //if succcessful add him to the probable list of administrators
    //
    //alert('aa');
    var callUrl='../ajax/siteAdministratorList.php';
    formData='siteId='+siteId;
    $.ajax({
        type: "POST",
        url: callUrl,
        data: formData,
        async: false,
        success: function( response )
        {
            //alert(response);
            $('#recipientDialog').html(response);
            $( "#recipientDialog" ).dialog('open');
        }


    });
}

