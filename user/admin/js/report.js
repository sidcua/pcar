$(document).ready(function(){
	initregion();
});
function url(){
	return "../php/report.php";
}
function changemode(){
	var year = document.getElementById("slctyear");
	var mode = document.getElementById("slctmode");
    var region = document.getElementById("slctregion");
	$.ajax({
		url: url(),
		method: "post",
		data: {region: region.value, year: year.value, mode: mode.value, action: "changemode"},
		beforeSend: function(){
			$("#tblreport").empty();
			$("#fountainG").show();
		},
		success: function(data){
			data = $.parseJSON(data);
			$("#fountainG").hide();
			$("#tblreport").html(data);
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
			changemode();
		}
	})
}
function initregion(){
    $.ajax({
        url: url(),
        method: "post",
        data: {action: "initregion"},
        success: function(data){
            data = $.parseJSON(data);
            if(data.level){
                $("#slctregion").html(data.options);
            }
        },
        complete: function(){
            inityear();
        }
    })
}
function print(){
    var region = $("#slctregion").val();
    var year = $("#slctyear").val();
    var mode = $("#slctmode").val();
    window.open("../home/printable/?print=report&mode=" + mode + "&year=" + year + "&region=" + region);
}