$(document).ready(function(){
    inityear();
})
function url(){
    return "../php/percentage.php";
}
function fetchdata(year, region){
    $.ajax({
        url: url(),
        method: "post",
        data: {year: year, region: region, action: "fetchdata"},
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
            fetchdata($("#slctyear").val(), $("#slctregion").val());
        }
    })
}
function region(region){
    fetchdata($("#slctyear").val(), region);
}
function year(year){
    fetchdata(year, $("#slctregion").val());
}
function print(){
    region = $("#slctregion").val();
    year = $("#slctyear").val();
    window.open("../home/printable/?print=percent&year=" + year + "&region=" + region);
}