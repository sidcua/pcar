$(document).ready(function(){
    initregion();
})
function url(){
    return "../php/assign.php";
}
function listassign(region){
    $.ajax({
        url: url(),
        method: "post",
        data: {region: region, action: "listassign"},
        beforeSend: function(){
            $("#tblassign").empty();
            $("#fountainG").show();
        },
        success: function(data){
            data = $.parseJSON(data);
            $("#fountainG").hide();
            $("#tblassign").html(data);
        }
    })
}
function initregion(){
    $.ajax({
        url: url(),
        method: "post",
        data: {action: "initregion"},
        beforeSend: function(){
            $("#slctregion").hide();  
        },
        success: function(data){
            data = $.parseJSON(data);
            if(data.level){
                $("#slctregion").html(data.options);
            }
        },
        complete: function(){
            $("#slctregion").show();
            listassign($("#slctregion").val());
        }
    })
}
function print(){
    var region = $("#slctregion").val();
    window.open("../home/printable/?print=assign&region=" + region);
}