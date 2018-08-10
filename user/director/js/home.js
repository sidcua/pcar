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
            labels: ["1st Quarter", "2nd Quarter", "3rd Quarter", "4th Quarter"],
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
                    data: [data[1][1], data[1][4], data[1][7], data[1][10]]
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
                    data: [data[2][1], data[2][4], data[2][7], data[2][10]]
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
            labels: ["1st Quarter", "2nd Quarter", "3rd Quarter", "4th Quarter"],
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
                    data: [data[1][1], data[1][4], data[1][7], data[1][10]]
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
                    data: [data[2][1], data[2][4], data[2][7], data[2][10]]
                }
            ]
        },
        options: {
            responsive: true
        }    
    });
}
function initquarterlygraph(year, region){
    $.ajax({
        url: url(),
        method: "post",
        data: {year: year, region: region, action: "quarterlygraph"},
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
function initquarterlygraph_office(year, region){
    $.ajax({
        url: url(),
        method: "post",
        data: {year: year, region: region, action: "quarterlygraph_office"},
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
        },
        complete: function(){
            $("#slctyear").show();
            loadgraphs($("#slctyear").val(), $("#slctregion").val());
        }
    })
}
function loadgraphs(year, region){
    initquarterlygraph(year, region);
    initquarterlygraph_office(year, region);
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
            inityear();
        }
    })
}
function foryear(year){
    var region = $("#slctregion").val();
    loadgraphs(year, region);
}
function forregion(region){
    var year = $("#slctyear").val();
    loadgraphs(year, region);
}