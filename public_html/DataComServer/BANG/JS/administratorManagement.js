var administratorList;
$(document).ready(function()
{
    administratorList='';
    $('input#email').autocomplete({
        minLength: 2,
        source: '../ajax/autoCompleteAdministrator.php',
        appendTo: '#lookUpForm',
        focus: function(event, ui)
        { 
            event.preventDefault();
        },
        select: function( event, ui )
        {
            if(ui.item)
            {
                 $('#email').val(' ');
                 AddToUserList(ui.item.id);
                 event.preventDefault();
                 return false;
            }
           log( ui.item ?
          "Selected: " + ui.item.value + " aka " + ui.item.id :
          "Nothing selected, input was " + this.value );

        }
    })
    .data( "autocomplete" )._renderItem = function( ul, item )
    {
      return $( "<li></li>" )
        .data( "item.autocomplete", item )
        .append( "<a>" + item.value+"</a>" )
        .appendTo( ul );
    };


});

function log( message ) {
    ShowError(message);
}

function AddAdministrator()
{
    //first add him to database
    //if succcessful add him to the probable list of administrators
    //
    //alert('aa');
    var callUrl='../ajax/addAdministrator.php';
    var formData=$('#addAdministrator').serialize();
    $.ajax({
        type: "POST",
        url: callUrl,
        data: formData,
        async: false,
        success: function( response )
        {
            //alert(response);
            response=$.trim(response);

            if(IsNumber(response))
            {
                AddToUserList(response);
            }
            else
                ShowError(response);
        }


    });
}

function AddToUserList(userId)
{
    //alert('adding to userlis');
    if(InList(userId,administratorList))
        return;
    administratorList= AddToList(userId,administratorList);
    $('#administratorIdList').val(administratorList);
    //alert($('#administratorIdList').val());
    //create html
    callUrl='../ajax/getAdministratorRow.php';
    formData="administratorId="+userId;
    $.ajax({
        type: "POST",
        url: callUrl,
        data: formData,
        success: function(response)
        {
            //alert(response);
            $('#administratorListTbl').append(response);
            //alert($('#administratorListTbl').html());

        }
    });
}                 
function RemoveFromUserList(userId)
{
    //return;
    //alert(administratorList);
    administratorList=RemoveFromList(userId,administratorList);
    //alert(administratorList);
    $('#item'+userId).remove();
}

function ValidateAdministratorList()
{
    //siteCheckbox
    var numberOfWG=CountChecked('siteId') + CountChecked('workgroupId');
    //alert(numberOfWG);
                       
    if($('#administratorIdList').val()=='')
    {    
        return ShowError('You must choose at least one administrator to proceed');
    }
    if(numberOfWG<1)
    {
        return ShowError('You must choose at least one site to proceed');
    }
    return true;
}