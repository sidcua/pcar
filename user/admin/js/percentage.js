$(document).ready(function(){
    inityear();
})
function url(){
    return "../php/percentage.php";
}
function fetchdata(){
    var region = $("#slctregion").val();
    var report = $("#slctreport").val();
    var year = $("#slctyear").val();
    $.ajax({
        url: url(),
        method: "post",
        data: {report: report, year: year, region: region, action: "fetchdata"},
        beforeSend: function(){
            $("#tblpercentage").empty();
            $("#percentageloader").show();
        },
        success: function(data){
            data = $.parseJSON(data);
            $("#percentageloader").hide();
            $("#tblpercentage").html(data);
        }
    })
}
function inityear(){
    $.ajax({
        url: url(),
        method: "post",
        data: {action: "inityear"},
        beforeSend: function(){
            $("#slctyear").hide();
        },
        success: function(data){
            data = $.parseJSON(data);
            $("#slctyear").html(data);
            initregion();
        },
        complete: function(){
            $("#slctyear").show();
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
                $("#slctregion").show();
            }
        },
        complete: function(){
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
            fetchdata();
        }
    })
}
function print(){
    region = $("#slctregion").val();
    year = $("#slctyear").val();
    window.open("../home/printable/?print=percent&year=" + year + "&region=" + region);
}