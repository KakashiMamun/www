
$(document).ready(function()
{
             
    $( "#dialog:ui-dialog" ).dialog( "destroy" );         
    $( "#reinstateDialog" ).dialog({
       autoOpen: false,
       height: 500,
       width: 590,
       modal: true
    });

});

function log( message ) {
    ShowError(message);
}
          
function Suspend(userId)
{
    //first add him to database
    //if succcessful add him to the probable list of recipients
    //
    //alert('aa');
    var callUrl='../ajax/suspend.php';
    var formData='userId='+userId;
    $.ajax({
        type: "POST",
        url: callUrl,    
        data: formData,
        async: false,
        success: function( response )
        {
            //alert(response);

            response=$.trim(response);
            if(response == 'Suspended')
            {
                ReloadWindow();
            }
            else
                ShowError(response);
        }


    });
}       
function Reinstate(userId)
{
    //first add him to database
    //if succcessful add him to the probable list of recipients
    //
    //alert('aa');
    var callUrl='../ajax/reinstate.php';
    var formData='userId='+userId;
    $.ajax({
        type: "POST",
        url: callUrl,    
        data: formData,
        async: false,
        success: function( response )
        {
            //alert(response);

            response=$.trim(response);
            if(response == 'Reinstated')
            {
                ReloadWindow();
            }
            else
                ShowError(response);
        }


    });
}

function ReinstateForm(userId)
{
    //first add him to database
    //if succcessful add him to the probable list of recipients
    //
    //alert('aa');
    var callUrl='../ajax/reinstateForm.php';
    var formData='userId='+userId;
    $.ajax({
        type: "POST",
        url: callUrl,    
        data: formData,
        async: false,
        success: function( response )
        {
            //alert(response);

            response=$.trim(response);
            $( "#reinstateDialog" ).html(response);
            $( "#reinstateDialog" ).dialog('open');

        }


    });
}           
function SuspendOther(id,type)
{
    //first add him to database
    //if succcessful add him to the probable list of recipients
    //
    //alert('aa');
    var callUrl='../ajax/suspendOther.php';
    var formData='id='+id+'&type='+type;
    $.ajax({
        type: "POST",
        url: callUrl,    
        data: formData,
        async: false,
        success: function( response )
        {
            //alert(response);

            response=$.trim(response);
            if(response == 'Suspended')
            {
                ReloadWindow();
            }
            else
                ShowError(response);
        }


    });
}       
function ReinstateOther(id,type)
{
    //first add him to database
    //if succcessful add him to the probable list of recipients
    //
    //alert('aa');
    var callUrl='../ajax/reinstateOther.php';
    var formData='id='+id+'&type='+type;
    $.ajax({
        type: "POST",
        url: callUrl,    
        data: formData,
        async: false,
        success: function( response )
        {
            //alert(response);

            response=$.trim(response);
            if(response == 'Reinstated')
            {
                ReloadWindow();
            }
            else
                ShowError(response);
        }


    });
}



