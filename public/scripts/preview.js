$(document).ready(function(){
    $("#preview").html(XBBCODE.process({
            text: $("#preview-input").val(),
            removeMisalignedTags: false,
            addInLineBreaks: false
        }).html.replace(/\n/g, "<br />")+"<br />");
    $("#preview-input").on("load change keyup keydown", function(){
        $("#preview").html(XBBCODE.process({
                text: $("#preview-input").val(),
                removeMisalignedTags: false,
                addInLineBreaks: false
            }).html.replace(/\n/g, "<br />")+"<br />");
    });
});