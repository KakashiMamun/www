$(document).ready(function()
{                                
  $('#sameInvoiceAddress').change(function()
  {
      if($('#sameInvoiceAddress:checked').val()=='yes')
      {
          CopyAddressToInvoice();
          //alert('same invoice');
      }
      //else
          //alert('not the same');
  });
});


function CopyAddressToInvoice()
{
    $('[name="companyNameInv"]').val($('[name="companyName"]').val());
    $('[name="address1Inv"]').val($('[name="address1"]').val());
    $('[name="address2Inv"]').val($('[name="address2"]').val());
    $('[name="address3Inv"]').val($('[name="address3"]').val());
    $('[name="stateIdInv"]').val($('[name="stateId"]').val());
    $('[name="cityInv"]').val($('[name="city"]').val());
    $('[name="postcodeInv"]').val($('[name="postcode"]').val());
}