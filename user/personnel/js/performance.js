$(document).ready(function(){
    initregion();
})
function url(){
	return "../php/performance.php";
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
			change();
		}
	})
}
function change(){
    var year = $("#slctyear").val();
    var region = $("#slctregion").val();
	$.ajax({
		url: url(),
		method: "post",
		data: {region: region, year: year, action: "change"},
		beforeSend: function(){
			$("#tblperformance").empty();
			$("#fountainG").show();
		},
		success: function(data){
			data = $.parseJSON(data);
			$("#fountainG").hide();
			$("#tblperformance").html(data);
		}
	})
}
function initregion(){
    $.ajax({
        url: url(),
        method: "post",
        data: {action: "initregion"},
        beforeSend: function(){
        },
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
    mode = $("#slctmode").val();
    region = $("#slctregion").val();
    year = $("#slctyear").val();
    window.open("../home/printable?print=performance&year=" + year + "&region=" + region);
}