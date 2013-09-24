var recipientList;
$(document).ready(function()
{
    recipientList='';
    $('input#email').autocomplete({
        minLength: 3,
        source: '../ajax/autoCompleteRecipient.php',
        appendTo: '#lookUpForm',
        focus: function(event, ui)
        { 
            event.preventDefault();
        },
        select: function( event, ui )
        {                    
            event.preventDefault();
            if(ui.item)
            {
                 $('#email').val(' ');
                 AddToUserList(ui.item.id);
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

function AddRecipient()
{
    //first add him to database
    //if succcessful add him to the probable list of recipients
    //
    //alert('aa');
    var callUrl='../ajax/addRecipient.php';
    var formData=$('#addRecipient').serialize();
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
    if(InList(userId,recipientList))
        return;
    recipientList= AddToList(userId,recipientList);
    $('#recipientIdList').val(recipientList);     
    //alert($('#recipientIdList').val());
    //create html
    callUrl='../ajax/getRecipientRow.php';
    formData="recipientId="+userId;
    $.ajax({
        type: "POST",
        url: callUrl,
        data: formData,
        success: function(response)
        {
            //alert(response);
            $('#recipientListTbl').append(response);
            //alert($('#recipientListTbl').html());

        }
    });
}
                           
function RemoveFromUserList(userId)
{
    //return;
    //alert(recipientList);
    recipientList=RemoveFromList(userId,recipientList);
    //alert(recipientList);
    $('#item'+userId).remove();
}

function ValidateRecipientList()
{
    //workgroupCheckbox
    var numberOfWG=CountChecked('workgroupId');
    //alert(numberOfWG);
                       
    if($('#recipientIdList').val()=='')
    {    
        return ShowError('You must choose at least one recipient to proceed');
    }
    if(numberOfWG<1)
    {
        return ShowError('You must choose at least one work group to proceed');
    }
    return true;
}