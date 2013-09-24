/**
 * Created with JetBrains PhpStorm.
 * User: root
 * Date: 9/11/13
 * Time: 8:14 PM
 * To change this template use File | Settings | File Templates.
 */
tinyMCE.init({
    theme : "modern",
    mode: "textareas",
    selector: "textarea.editme",
    elements : "elm1",
    theme_advanced_toolbar_location : "top",
    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,separator,"
        + "justifyleft,justifycenter,justifyright,justifyfull,formatselect,"
        + "bullist,numlist,outdent,indent",
    theme_advanced_buttons2 : "link,unlink,anchor,image,separator,"
        +"undo,redo,cleanup,code,separator,sub,sup,charmap",
    theme_advanced_buttons3 : "",
    height:"350px",
    width:"800px"
});