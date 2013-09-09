/**
 * Created with JetBrains PhpStorm.
 * User: root
 * Date: 9/9/13
 * Time: 3:53 PM
 * To change this template use File | Settings | File Templates.
 */

(function() {
    var obj = $('.ajaxLink');

    obj.bind('click', function(event) {
        event.preventDefault();
        var link = $(this).attr('href');
        var slugs = link.split('/');
        var urlSlug = (slugs[slugs.length-1]);

        alert($(this).pathname);
//            function logArrayElements(element, index, array) {
//                alert("array[" + index + "] = " + element);
//            }
//            slugs.forEach(logArrayElements);

        $.ajax({
            url: "http://testhost.com/Urboshi/testAjaxCall.php",
            type: "POST",//type of posting the data
            data: {slug: urlSlug},
            dataType: "json",
            error: function(data, ajaxOptions,error){
                //what to do in error
                alert(JSON.stringify(data));
            },
            success: function (data) {
                alert('ok');
                alert(data);
                //what to do in success
            },
            complete:function() {
//                alert("complete");
            },
            timeout : 15000//timeout of the ajax call
        });

    });
})();