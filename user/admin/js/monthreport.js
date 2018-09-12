$(document).ready(function(){
    inityear();
})
function url(){
    return "../php/monthreport.php";
}
function fetchdata(mode, year, report){
    if(mode == "month"){
        value = $("#slctmonth").val();
    }
    else{
        value = $("#slctquarter").val();
    }
    $.ajax({
        url: url(),
        method: "post",
        data: {report: report, value: value, year: year, action: mode},
        beforeSend: function(){
            $("#tblmonthreport").empty();
            $("#monthreportloader").show()
        },
        success: function(data){
            data = $.parseJSON(data);
            $("#tblmonthreport").html(data);
        },
        complete: function(){
            $("#monthreportloader").hide();
            $("#tblmonthreport").show();
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
            $("#slctyear").show();
        },
        complete: function(){
            initreport();
        }
    })
}
function mode(mode){
    if(mode == "month"){
        $("#form").html('<label for="slctmonth" style="margin-right: 10px; margin-top: 10px;">Month</label><select onchange="change()" class="form-control" id="slctmonth"><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>');
    }
    else{
        $("#form").html('<label for="slctquarter" style="margin-right: 10px; margin-top: 10px;">Quarter</label><select onchange="change()" class="form-control" id="slctquarter"><option value="1">Quarter 1</option><option value="2">Quarter 2</option><option value="3">Quarter 3</option><option value="4">Quarter 4</option></select>');
    }
    fetchdata(mode, $("#slctyear").val(), $("#slctreport").val());
}
function change(){
    var mode = $("#slctmode").val();
    var year = $("#slctyear").val();
    var report = $("#slctreport").val();
    fetchdata(mode, year, report);
}
function year(year){
    fetchdata($("#slctmode").val(), year);
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
            mode("quarter");
        }
    })
}
function print(){
    var year = $("#slctyear").val();
    var report = $("#slctreport").val();
    var quarter = $("#slctquarter").val();
    window.open("../home/printable/monthreport_report.php?year=" + year + "&report=" + report + "&quarter=" + quarter);
}