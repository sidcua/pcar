$(document).ready(function(){
    initregion();
})
function url(){
    return "../php/assign.php";
}
function listassign(){
    var region = $("#slctregion").val();
    var report = $("#slctreport").val();
    $.ajax({
        url: url(),
        method: "post",
        data: {report: report, region: region, action: "listassign"},
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
            initreport();
        }
    })
}
function initreport(){
    $.ajax({
        url: url(),
        method: "post",
        data: {action: "initreport"},
        success: function(data){
            data = $.parseJSON(data);
            $("#slctreport").html(data);
        },
        complete: function(){
            listassign();
        }
    })
}
function print(){
    var region = $("#slctregion").val();
    window.open("../home/printable/?print=assign&region=" + region);
}