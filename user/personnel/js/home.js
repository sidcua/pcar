$(document).ready(function(){
    initregion();
})
function url(){
    return "../php/home.php";
}
function quarterlygraph(data){
    var ctxL = document.getElementById("targetaccomplish_quarter").getContext('2d');
    var myLineChart = new Chart(ctxL, {
        type: 'line',
        data: {
            labels: ["0", "1st Quarter", "2nd Quarter", "3rd Quarter", "4th Quarter"],
            datasets: [
                {
                    label: "Targets",
                    backgroundColor : "rgba(220, 44, 44, 0.3)",
                    borderWidth : 2,
                    borderColor : "rgba(215, 40, 40, 0.9)",
                    pointBackgroundColor : "rgba(255, 0, 0, 1)",
                    pointBorderColor : "#fff",
                    pointBorderWidth : 1,
                    pointRadius : 4,
                    pointHoverBackgroundColor : "#fff",
                    pointHoverBorderColor : "rgba(220,220,220,1)",
                    data: [0, data[1][1], data[1][2], data[1][3], data[1][4]]
                },
                {
                    label: "Accomplishment",
                    backgroundColor : "rgba(0, 255, 47, 0.5)",
                    borderWidth : 2,
                    borderColor : "rgba(0, 255, 47, 1)",
                    pointBackgroundColor : "rgba(0, 255, 0, 1)",
                    pointBorderColor : "#fff",
                    pointBorderWidth : 1,
                    pointRadius : 4,
                    pointHoverBackgroundColor : "#fff",
                    pointHoverBorderColor : "rgba(220,220,220,1)",
                    data: [0, data[2][1], data[2][2], data[2][3], data[2][4]]
                }
            ]
        },
        options: {
            responsive: true
        }    
    });
}
function quarterlygraph_office(data){
    var ctxL = document.getElementById("targetaccomplish_quarter_office").getContext('2d');
    var myLineChart = new Chart(ctxL, {
        type: 'line',
        data: {
            labels: ["0", "1st Quarter", "2nd Quarter", "3rd Quarter", "4th Quarter"],
            datasets: [
                {
                    label: "Targets",
                    backgroundColor : "rgba(220, 44, 44, 0.3)",
                    borderWidth : 2,
                    borderColor : "rgba(215, 40, 40, 0.9)",
                    pointBackgroundColor : "rgba(255, 0, 0, 1)",
                    pointBorderColor : "#fff",
                    pointBorderWidth : 1,
                    pointRadius : 4,
                    pointHoverBackgroundColor : "#fff",
                    pointHoverBorderColor : "rgba(220,220,220,1)",
                    data: [0, data[1][1], data[1][2], data[1][3], data[1][4]]
                },
                {
                    label: "Accomplishment",
                    backgroundColor : "rgba(0, 255, 47, 0.5)",
                    borderWidth : 2,
                    borderColor : "rgba(0, 255, 47, 1)",
                    pointBackgroundColor : "rgba(0, 255, 0, 1)",
                    pointBorderColor : "#fff",
                    pointBorderWidth : 1,
                    pointRadius : 4,
                    pointHoverBackgroundColor : "#fff",
                    pointHoverBorderColor : "rgba(220,220,220,1)",
                    data: [0, data[2][1], data[2][2], data[2][3], data[2][4]]
                }
            ]
        },
        options: {
            responsive: true
        }    
    });
}
function initquarterlygraph(year, region, report){
    $.ajax({
        url: url(),
        method: "post",
        data: {report: report, year: year, region: region, action: "quarterlygraph"},
        beforeSend: function(){
            $("#targetaccomplish_quarter").empty();
            $("#loading_targetaccomplish_quarter").show();
        },
        success: function(data){
            data = $.parseJSON(data);
            if(data.success){
                $("#loading_targetaccomplish_quarter").hide();
                quarterlygraph(data);
            }
            else{
                $("#personalpraph_quarter").hide();
            }
        }
    })
}
function initquarterlygraph_office(year, region, report){
    $.ajax({
        url: url(),
        method: "post",
        data: {report: report, year: year, region: region, action: "quarterlygraph_office"},
        beforeSend: function(){
            $("#targetaccomplish_quarter_office").empty();
            $("#loading_targetaccomplish_quarter_office").show();
        },
        success: function(data){
            data = $.parseJSON(data);
            $("#loading_targetaccomplish_quarter_office").hide();
            quarterlygraph_office(data);
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
            initreport();
        },
        complete: function(){
            $("#slctyear").show();
        }
    })
}
function loadgraphs(year, region, report){
    initquarterlygraph(year, region, report);
    initquarterlygraph_office(year, region, report);
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
            initreport();
        },
        complete: function(){
            $("#slctregion").show();
            inityear();
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
            loadgraphs($("#slctyear").val(), $("#slctregion").val(), $("#slctreport").val());
        }
    })
}
function foryear(year){
    var region = $("#slctregion").val();
    var report = $("#slctreport").val();
    loadgraphs(year, region, report);
}
function forregion(region){
    var year = $("#slctyear").val();
    var report = $("#slctreport").val();
    loadgraphs(year, region, report);
}
function forreport(){
    var year = $("#slctyear").val();
    var region = $("#slctregion").val();
    var report = $("#slctreport").val();
    if(report == 1){
        $(".display-graph").html("PCAR");
    }
    else if(report == 2){
        $(".display-graph").html("IPCR");
    }
    else if(report == 3){
        $(".display-graph").html("DBM");
    }
    loadgraphs(year, region, report);
}