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
	var reportid = document.getElementById("slctreport");
	$.ajax({
		url: url(),
		method: "post",
		data: {reportid: reportid.value, region: region.value, year: year.value, mode: mode.value, action: "changemode"},
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
			initreport();
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
			changemode();
		}
	})
}
function print(){
    var region = $("#slctregion").val();
	var year = $("#slctyear").val();
	var report = $("#slctreport").val();
	if(report == 1){
		report = "pcar_report.php";
	}
	else if(report == 2){
		report = "ipcr_report.php";
	}
	else if(report == 3){
		report = "dbm_report.php";
	}
    window.open("../home/printable/" + report + "?year=" + year + "&region=" + region);
}