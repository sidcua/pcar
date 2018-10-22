$(document).ready(function(){
	removebordererror();
	inityear();
});
function url(){
	return "../php/target.php";
}
function fetchdata(year){
	var program = $("#programholder").val();
	$.ajax({
		url: url(),
		method: "post",
		data: {reportid: program, year: year, action: "listassignedprogram"},
		beforeSend: function(){
			$("#tbltargets").html("");
			$("#targetloader").show();
            checknotice(year);
		},
		success: function(data){
			data = $.parseJSON(data);
			$("#targetloader").hide();
			$("#tbltargets").html(data);
		}
	})
}
function removebordererror(){
	$("body").on('click', '.red-border', function(e){
		$(e.target).removeClass("red-border");
	})
}
function editvalues(td){
	$("#actionassign" + td).html('<a><span onclick="savevalues(' + td + ')" class="badge badge-success mr-2"><i class="fa fa-save fa-4x" aria-hidden="true"></i></a> <a><span onclick="canceledit(' + td + ')" class="badge badge-danger ml-2"><i class="fa fa-close fa-4x" aria-hidden="true"></i></a>');
	$("#assign" + td + ">td").attr("contenteditable", true);
	$("[for=title]").attr("contenteditable", false);
	$("[for=action]").attr("contenteditable", false);
    if(!Number.isInteger(parseInt($("#assign" + td).closest('tr').find('.q1-' + td).text())) && $("#assign" + td).closest('tr').find('.q1-' + td).text() != ""){
		$("#assign" + td + ">.q1-" + td).empty();
	}
	if(!Number.isInteger(parseInt($("#assign" + td).closest('tr').find('.q2-' + td).text())) && $("#assign" + td).closest('tr').find('.q2-' + td).text() != ""){
		$("#assign" + td + ">.q2-" + td).empty();
	}
	if(!Number.isInteger(parseInt($("#assign" + td).closest('tr').find('.q3-' + td).text())) && $("#assign" + td).closest('tr').find('.q3-' + td).text() != ""){
		$("#assign" + td + ">.q3-" + td).empty();
	}
	if(!Number.isInteger(parseInt($("#assign" + td).closest('tr').find('.q4-' + td).text())) && $("#assign" + td).closest('tr').find('.q4-' + td).text() != ""){
		$("#assign" + td + ">.q4-" + td).empty();
	}
}
function canceledit(td){
	$("#actionassign" + td).html('<a><span onclick="editvalues(' + td + ')" class="badge badge-default"><i class="fa fa-pencil fa-4x" aria-hidden="true"></i></a>');
	$("#assign" + td + ">td").attr("contenteditable", false);
	if(!Number.isInteger(parseInt($("#assign" + td).closest('tr').find('.q1-' + td).text())) && $("#assign" + td).closest('tr').find('.q1-' + td).text() != ""){
		$("#assign" + td + ">.q1-" + td).empty();
	}
	if(!Number.isInteger(parseInt($("#assign" + td).closest('tr').find('.q2-' + td).text())) && $("#assign" + td).closest('tr').find('.q2-' + td).text() != ""){
		$("#assign" + td + ">.q2-" + td).empty();
	}
	if(!Number.isInteger(parseInt($("#assign" + td).closest('tr').find('.q3-' + td).text())) && $("#assign" + td).closest('tr').find('.q3-' + td).text() != ""){
		$("#assign" + td + ">.q3-" + td).empty();
	}
	if(!Number.isInteger(parseInt($("#assign" + td).closest('tr').find('.q4-' + td).text())) && $("#assign" + td).closest('tr').find('.q4-' + td).text() != ""){
		$("#assign" + td + ">.q4-" + td).empty();
	}
	$("#assign" + td + ">.q1-" + td).removeClass("red-border");
	$("#assign" + td + ">.q2-" + td).removeClass("red-border");
	$("#assign" + td + ">.q3-" + td).removeClass("red-border");
	$("#assign" + td + ">.q4-" + td).removeClass("red-border");
}
function savevalues(td){
	var assignid = td;
	var program = $("#programholder").val();
	var error = 0; 
	if(!Number.isInteger(parseInt($("#assign" + td).closest('tr').find('.q1-' + td).text())) && $("#assign" + td).closest('tr').find('.q1-' + td).text() != ""){
		$("#assign" + td + ">.q1-" + td).addClass("red-border");
		error = 1;
	}
	if(!Number.isInteger(parseInt($("#assign" + td).closest('tr').find('.q2-' + td).text())) && $("#assign" + td).closest('tr').find('.q2-' + td).text() != ""){
		$("#assign" + td + ">.q2-" + td).addClass("red-border");
		error = 1;
	}
	if(!Number.isInteger(parseInt($("#assign" + td).closest('tr').find('.q3-' + td).text())) && $("#assign" + td).closest('tr').find('.q3-' + td).text() != ""){
		$("#assign" + td + ">.q3-" + td).addClass("red-border");
		error = 1;
	}
	if(!Number.isInteger(parseInt($("#assign" + td).closest('tr').find('.q4-' + td).text())) && $("#assign" + td).closest('tr').find('.q4-' + td).text() != ""){
		$("#assign" + td + ">.q4-" + td).addClass("red-border");
		error = 1;
	}
	if(error != 0){
		return "";
	}
	else{
		var data = [ 0,
			$("#assign" + td).closest('tr').find('.q1-' + td).text(), 
			$("#assign" + td).closest('tr').find('.q2-' + td).text(),
			$("#assign" + td).closest('tr').find('.q3-' + td).text(),
			$("#assign" + td).closest('tr').find('.q4-' + td).text(),
		];
		// var remark = $("#assign" + td).closest('tr').find('.remark-' + td).text();
		var year = document.getElementById("slctyear");
		$.ajax({
			url: url(),
			method: "post",
			data: {reportid: program, data: JSON.stringify(data), assignid: assignid, year: year.value, action: "savevalues"},
			beforeSend: function(){

			},
			success: function(data){
				fetchdata($("#slctyear").val());
			}
		})
	}
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
			alert(data)
			data = $.parseJSON(data);
			$("#slctyear").html(data)
			fetchdata($("#slctyear").val());
		},
        complete: function(){
            $("#slctyear").show();
        }
	})
}
function print(accid){
    var year = $("#slctyear").val();
    window.open("../home/printable/?print=target&year=" + year + "&accid=" + accid);
}
function checknotice(year){
    $.ajax({
        url: url(),
        method: "post",
        data: {year: year, action: "checknotice"},
        beforeSend: function(){
            $("#txtnotice").empty();
        },
        success: function(data){
            data = $.parseJSON(data);
            if(data){
                $("#txtnotice").html('<div class="col-sm-12"><div class="card red text-center z-depth-2"><div class="card-body"><p class="white-text mb-0"><b>NOTICE:</b> Inputting of data was locked by the Central</p></div></div><br></div>');
            }
        }
    })
}