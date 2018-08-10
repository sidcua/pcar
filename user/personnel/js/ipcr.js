$(document).ready(function(){
    initregion();
})
function url(){
    return "../php/ipcr.php";
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
            fetchdata();
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
function fetchdata(){
    var region = $("#slctregion").val();
    var year = $("#slctyear").val();
    $.ajax({
        url: url(),
        method: "post",
        data: {region: region, year: year, action: "fetchdata"},
        beforeSend: function(){
            $("#tblipcr").empty();
            $("#fountainG").show();
        },
        success: function(data){
            data = $.parseJSON(data);
            $("#fountainG").hide();
            $("#tblipcr").html(data);
        }
    })
}
function print(){
    var region = $("#slctregion").val();
    var year = $("#slctyear").val();
    window.open("../home/printable/?print=ipcr&region=" + region + "&year=" + year);
}