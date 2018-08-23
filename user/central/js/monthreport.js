$(document).ready(function(){
    inityear();
})
function url(){
    return "../php/monthreport.php";
}
function fetchdata(mode, year){
    if(mode == "month"){
        value = $("#slctmonth").val();
    }
    else{
        value = $("#slctquarter").val();
    }
    $.ajax({
        url: url(),
        method: "post",
        data: {value: value, year: year, action: mode},
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
            mode($("#slctmode").val());
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
    fetchdata(mode, $("#slctyear").val());
}
function change(){
    fetchdata($("#slctmode").val(), $("#slctyear").val());
}
function year(year){
    fetchdata($("#slctmode").val(), year);
}
function print(){
    var mode = $("#slctmode").val();
    var year = $("#slctyear").val();
    if(mode == "month"){
        var month = $("#slctmonth").val();
        window.open("../home/printable/?print=monthlyreport&mode=" + mode + "&year=" + year + "&month=" + month);
    }
    else{
        var quarter = $("#slctquarter").val();
        window.open("../home/printable/?print=monthlyreport&mode=" + mode + "&year=" + year + "&quarter=" + quarter);
    }
}