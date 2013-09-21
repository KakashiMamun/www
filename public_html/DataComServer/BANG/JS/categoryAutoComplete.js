/**
 * Created with JetBrains PhpStorm.
 * User: root
 * Date: 9/21/13
 * Time: 9:04 PM
 * To change this template use File | Settings | File Templates.
 */
$(function() {
    function split( val ) {
        return val.split( /,\s*/ );
    }
    function extractLast( term ) {
        return split( term ).pop();
    }
    $( ".autocomplete_Multiple" )
// don't navigate away from the field on tab when selecting an item
        .bind( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
                $( this ).data( "ui-autocomplete" ).menu.active ) {
                event.preventDefault();
            }
        })
        .autocomplete({
            source:
                function( request, response ) {

                    var url = "http://Urboshi.com/UrboshiAction.php";

                    $.ajax({
                        url: url,
                        contentType: "application/json",
                        dataType: 'jsonp',
                        type: "GET",
                        data: {term: extractLast( request.term )},
                        success: function(data) {
                            var suggestions = [];

                            //process response
                            $.each(data, function(i, val){
                                suggestions.push(val.name);

                            });
                            //pass array to callback
                            response(suggestions);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
//                                alert(JSON.stringify(ajaxOptions));

                        }
                    });

                    $.getJSON("http://Urboshi.com/UrboshiAction.php",
                        {term: extractLast( request.term )},
                        function(data){

                            var suggestions = [];

                            //process response
                            $.each(data, function(i, val){
                                suggestions.push(val.name);
                            });
//
                            alert(JSON.stringify(data));
//                            alert(JSON.stringify(suggestions));
                            //pass array to callback
                            response(suggestions);
                        });


                },
            search: function() {
// custom minLength
                var term = extractLast( this.value );
                if ( term.length < 1 ) {
                    return false;
                }
            },
            focus: function() {
// prevent value inserted on focus
                return false;
            },
            select: function( event, ui ) {
                var terms = split( this.value );


// remove the current input
                terms.pop();
// add the selected item
                terms.push( ui.item.value );
// add placeholder to get the comma-and-space at the end
                terms.push( "" );
                this.value = terms.join( ", " );
                return false;
            }
        });
});