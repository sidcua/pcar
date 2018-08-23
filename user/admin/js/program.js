$(document).ready(function(){
	fetchdata();
	showmodaladdprogram();
	resetmodaladdprogram();
	resetmodaleditprogram();
	holdprogramid();
	transferprograminfo();
})
function url(){
	return "../php/program.php";
}
function fetchdata(){
	var program = $("#programholder").val();
	$.ajax({
		url: url(),
		method: "post",
		data: {reportid: program, action: "programlist"},
		beforeSend: function(){
			$("#program").html("");
			$(".cssload-container").show();

		},
		success: function(data){
			data = $.parseJSON(data);
			$(".cssload-container").hide();
			$("#program").html(data);
		}
	})
}
function selectprogram(){
	$("#slctprogram").html("");
	var level = document.getElementById("txtlevel");
	if(level.value == "" || level.value == 1){
        $("#status").hide();
        $("#slctstatus").val("Inactive");
	}
	else{
		$.ajax({
			url: url(),
			method: "post",
			data: {level: level.value, action: "selectprogram"},
            beforeSend: function(){
                $("#slctstatus").val("Active");
                $("#status").show()
            },
			success: function(data){
				data = $.parseJSON(data);
				$("#slctprogram").html(data);
			}
		})
	}
}
function editselectprogram(level, under, bool){
	if(level == "" || level == 1){
		$("#editslctprogram").html("");
        $("#editstatus").hide();
        $("#editslctstatus").val("Inactive");
	}
	else{
		$.ajax({
			url: url(),
			method: "post",
			data: {level: level, action: "editselectprogram"},
            beforeSend: function(){
                $("#editslctstatus").val("Active");
                $("#editstatus").show();
            },
			success: function(data){
				data = $.parseJSON(data);
				$("#editslctprogram").html(data);
				if(bool == true){
					selection(under);
				}
			}
		})
	}
}
function selection(under){
	$("#editslctprogram").val(under);
}
function transferprograminfo(){
	$('body').on('click', '.editprogram', function(){
		var title = $(this).closest('tr').find('.title').text();
		var level = $(this).closest('tr').find('.level').text();
		var status = $(this).closest('tr').find('.status').text();
		var under = $(this).closest('tr').find('.under').text();
		var state = $(this).closest('tr').find('.state').text();
		editselectprogram(level, under, true);
		$("#edittxttitle").val(title);
		$("#edittxtlevel").val(level);
		$("#editslctstatus").val(status);
		$("#editslctstate").val(state);
	});
}
function holdprogramid(){
	$('body').on('click', '#program>tr', function(){
		$("#programidholder").val($(this).attr('data-id'));
	});
}
function showmodaladdprogram(){
	$("#modaladdprogram").on('show.bs.modal', function(){
		selectprogram();
	});
}
function resetmodaladdprogram(){
	$("#modaladdprogram").on('hidden.bs.modal', function(){
		$("#txttitle").val("");
		$("#txtlevel").val("");
		$("#slctprogram").html("");
		$("#txttitle").removeClass("active");
		$("#txtlevel").removeClass("active");
		$("[for=txtlevel]").removeClass("active");
		$("[for=txttitle]").removeClass("active");
		$("#errormsgaddprogram").html("");
	});
}
function resetmodaleditprogram(){
	$("#modaleditprogram").on('show.bs.modal', function(){
		$("#edittxttitle").addClass("active");
		$("#edittxtlevel").addClass("active");
		$("[for=edittxtlevel]").addClass("active");
		$("[for=edittxttitle]").addClass("active");
		$("#errormsgeditprogram").html("");
	});
}
function addprogram(){
	var title = document.getElementById("txttitle");
	var level = document.getElementById("txtlevel");
	var under = document.getElementById("slctprogram");
	var status = document.getElementById("slctstatus");
	var state = document.getElementById("slctstate");
	if(!title.value.trim() && !level.value.trim() && !status.value.trim()){
		$("#errormsgaddprogram").html("<strong>Please enter the details</strong");
	}
	else if(!title.value.trim()){
		$("#errormsgaddprogram").html("<strong>Please enter the title</strong");
	}
    else if(level.value > 5){
        $("#errormsgaddprogram").html("<strong>Maximum level is 5</strong");
    }
	else if(!level.value.trim()){
		$("#errormsgaddprogram").html("<strong>Please enter the level</strong");
	}
	else{
		$.ajax({
			url: url(),
			method: "post",
			data: {title: title.value, level: level.value, under: under.value, status: status.value, state: state.value, action: "addprogram"},
			beforeSend: function(){
			},
			success: function(data){
				$("#modaladdprogram").modal('hide');
				fetchdata();
			}
		})
	}
}
function deleteprogram(){
	var programid = document.getElementById("programidholder");
	$.ajax({
		url: url(),
		method: "post",
		data: {programid: programid.value, action: "deleteprogram"},
		beforeSend: function(){
			$("#modaldeleteprogram").modal('hide');
		},	
		success: function(){
			fetchdata();			
		}
	})
}
function editprogram(){
	var programid = document.getElementById("programidholder");
	var title = document.getElementById("edittxttitle");
	var level = document.getElementById("edittxtlevel");
	var under = document.getElementById("editslctprogram");
	var status = document.getElementById("editslctstatus");
	var state = document.getElementById("editslctstate");
	if(!title.value.trim() && !level.value.trim() && !status.value.trim()){
		$("#errormsgeditprogram").html("<strong>Please enter the details</strong");
	}
	else if(!title.value.trim()){
		$("#errormsgeditprogram").html("<strong>Please enter the title</strong");
	}
    else if(level.value > 5){
        $("#errormsgeditprogram").html("<strong>Maximum level is 5</strong");
    }
	else if(!level.value.trim()){
		$("#errormsgeditprogram").html("<strong>Please enter the level</strong");
	}
	else{
		$.ajax({
			url: url(),
			method: "post",
			data: {programid: programid.value, title: title.value, level:level.value, under: under.value, status: status.value, state: state.value, action: "editprogram"},
			beforeSend: function(){
				$("#modaleditprogram").modal('hide');
			},
			success: function(data){
				if(!data){
					$("#errormsgeditprogram").html("<strong>Program already existed</strong");
				}
				else{
					fetchdata();
				}
			}
		});
	}
}
function searchprogram(event){
	var search = document.getElementById("txtsearchprogram");
	if(event.keyCode == 13){
        if(search.value.trim() == ""){
            fetchdata();
        }
        else{
            $.ajax({
                url: url(),
                method: "post",
                data: {search: search.value.trim(), action: "searchprogram"},
                beforeSend: function(){
                    $("#program").empty();
                    $(".cssload-container").show();
                },
                success: function(data){
                    data = $.parseJSON(data);
                    $(".cssload-container").hide();
                    $("#program").html(data);
                }
            })
        }
    }
}