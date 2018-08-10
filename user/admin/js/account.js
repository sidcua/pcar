$(document).ready(function(){
	fetchdata();
	clearmodaladdaccount();
	holdaccid();
	transferaccinfo();
	resetmodaleditaccount();
	resetmodaladdaccount();
	loadmodalassign();
	resetmodalchangepassword();
	loadmodaladdaccount();
});
function url(){
	return "../php/account.php";
}
function fetchdata(){
	$.ajax({
		url: url(),
		method: "post",
		data: {action: "accountlist"},
		beforeSend: function(){
			$("#accounts").html("");
			$(".cssload-container").show();
		},
		success: function(data){
			data = $.parseJSON(data);
			$(".cssload-container").hide();
			$("#accounts").html(data);
		}
	})
}
function resetmodaladdaccount(){
	$('#modaladdaccount').on('hidden.bs.modal', function(){
	  	$("#txtemail").val("");
	  	$("#txtname").val("");
	  	$("#txtposition").val("");
	  	$("#txtemail").removeClass("active");
	  	$("#txtposition").removeClass("active");
	  	$("#txtname").removeClass("active");
	  	$("[for=txtname]").removeClass("active");
	  	$("[for=txtposition]").removeClass("active");
	  	$("[for=txtemail]").removeClass("active");
	  	$("#errormsgaddaccount").html("");
	});
}
function loadmodaladdaccount(){
	$("#modaladdaccount").on('show.bs.modal', function(){
		initaccounttype();
		initregion();
	});
}
function resetmodaleditaccount(){
	$("#modaleditaccount").on('show.bs.modal', function(){
		$("#edittxtemail").addClass("active");
		$("[for=edittxtemail]").addClass("active");
		$("#edittxtname").addClass("active");
		$("[for=edittxtname]").addClass("active");
		$("#edittxtposition").addClass("active");
		$("[for=edittxtposition]").addClass("active");
		$("#errormsgeditaccount").html("");
	});
}
function holdaccid(){
	$('body').on('click', '#accounts>tr', function(){
		$("#accidholder").val($(this).attr('data-id'));
	});
}
function transferaccinfo(){
	$('body').on('click', '.editaccount', function(){
		var email = $(this).closest('tr').find('.email').text();
		var name = $(this).closest('tr').find('.name').text();
		var position = $(this).closest('tr').find('.position').text();
		var regionid = $(this).closest('tr').find('.regionID').text();
		var level = $(this).closest('tr').find('.level').text();
		$("#edittxtemail").val(email);
		$("#edittxtname").val(name);
		$("#edittxtposition").val(position);
		initeditregion(regionid);
		initeditaccounttype(level);
	});
}
function clearmodaladdaccount(){
	var email = document.getElementById("txtemail");
	var name = document.getElementById("txtname");
	var position = document.getElementById("txtposition");
}
function addaccount(){
	var email = document.getElementById("txtemail");
	var name = document.getElementById("txtname");
	var position = document.getElementById("txtposition");
	var region = document.getElementById("slctregion");
	var accounttype = document.getElementById("slctaccounttype");
	if(!email.value.trim() && !name.value.trim() && !position.value.trim()){
		$("#errormsgaddaccount").html("<strong>Please enter the account details</strong>");
	}
	else if(!email.value.trim()){
		$("#errormsgaddaccount").html("<strong>Please enter email</strong>");
	}
	else if(!name.value.trim()){
		$("#errormsgaddaccount").html("<strong>Please enter name</strong>");
	}
	else if(!position.value.trim()){
		$("#errormsgaddaccount").html("<strong>Please enter position</strong>");
	}
	else{
		$.ajax({
			url: url(),
			method: "post",
			data: {email: email.value, name: name.value, position: position.value, region: region.value, accounttype: accounttype.value, action: "addaccount"},
			beforeSend: function(){
				
			},
			success: function(data){
				data = $.parseJSON(data);
				if(data.email){
					$("#errormsgaddaccount").html("<strong>Email is already existed");
				}
				else if(data.name){
					$("#errormsgaddaccount").html("<strong>Name is already existed");
				}
				else{
					$("#modaladdaccount").modal('hide');
					fetchdata();
				}
			}
		});
	}
}
function deleteaccount(){
	var accid = document.getElementById("accidholder");
	$.ajax({
		url: url(),
		method: "post",
		data: {accid: accid.value, action: "deleteaccount"},
		beforeSend: function(){
			$("#modaldeleteaccount").modal('hide');
		},
		success: function(data){
			fetchdata();
		}
	});
}	
function editaccount(){
	var accid = document.getElementById("accidholder");
	var email = document.getElementById("edittxtemail");
	var name = document.getElementById("edittxtname");
	var position = document.getElementById("edittxtposition");
	var region = document.getElementById("editslctregion");
	var accounttype = document.getElementById("editslctaccounttype");
	if(!email.value.trim() && !name.value.trim() && !position.value.trim()){
		$("#errormsgeditaccount").html("<strong>Please enter the account details</strong>");
	}
	else if(!email.value.trim()){
		$("#errormsgeditaccount").html("<strong>Please enter email</strong>");
	}
	else if(!name.value.trim()){
		$("#errormsgeditaccount").html("<strong>Please enter name</strong>");
	}
	else if(!position.value.trim()){
		$("#errormsgeditaccount").html("<strong>Please enter position</strong>");
	}
	else{
		$.ajax({
			url: url(),
			method: "post",
			data: {accid: accid.value, email: email.value, name: name.value, position: position.value, region: region.value, accounttype: accounttype.value, action: "editaccount"},
			beforeSend: function(){
				$("#modaleditaccount").modal('hide');
			},
			success: function(data){
				data = $.parseJSON(data);
				if(data.email){
					$("#errormsgeditaccount").html("<strong>Email is already existed");
				}
				else if(data.name){
					$("#errormsgeditaccount").html("<strong>Nmae is already existed");
				}
				else{
					fetchdata();
				}
			}
		})
	}
}
function loadprogram(level){
	var accid = document.getElementById("accidholder");
	$.ajax({
		url: url(),
		method: "post",
		data: {accid: accid.value, level: level, action: "loadprogram"},
		beforeSend: function(){
			$("#listavailableprogram").html("");
			$("#listassignedprogram").html("");
			$("#programloader").show();
			$("#assignedloader").show();
			$("#tablevel>li>.active").removeClass("active");
			$("[onclick='loadprogram(" + level + ")']").addClass("active");
		},
		success: function(data){
			data = $.parseJSON(data);
			$("#programloader").hide();
			$("#assignedloader").hide();
			$("#listavailableprogram").html(data.availableprogram);
			$("#listassignedprogram").html(data.assignedprogram);
		}
	})
}	
function loadmodalassign(){
	$('body').on('click', '.assignprogram', function(){
		var name = $(this).closest('tr').find('.name').text();
		$("#assignheader").html('<b>Name: ' + name + '</b>');
	});
	$("#modalassignprogram").on('show.bs.modal', function(){
		loadtab();
		loadprogram(1);
	});
}
function assign(programid){
	var accid = document.getElementById("accidholder");
	$.ajax({
		url: url(),
		method: "post",
		data: {programid: programid, accid: accid.value, action: "assign"},
		beforeSend: function(){
			var listassigned = $("#listassignedprogram").html();
			var title = $("#list" + programid).text();
			listassigned += '<li id="list' + programid + '" class="list-group-item d-flex justify-content-between align-items-center">' + title +'<a><i onclick="unassign(' + programid + ')" class="fa fa-close text-danger" aria-hidden="true"></i></a></li>';
			$("#listavailableprogram>#list" + programid).remove();
			$("#listassignedprogram").html(listassigned);
		}
	})
}
function unassign(programid){
	var accid = document.getElementById("accidholder");
	$.ajax({
		url: url(),
		method: "post",
		data: {programid: programid, accid: accid.value, action: "unassign"},
		beforeSend: function(){
			var listavailable = $("#listavailableprogram").html();
			var title = $("#list" + programid).text();
			listavailable += '<li id="list' + programid + '" class="list-group-item d-flex justify-content-between align-items-center">' + title + '<a><i onclick="assign(' + programid +')" class="fa fa-check text-success" aria-hidden="true"></i></a></li>';
			$("#listassignedprogram>#list" + programid).remove();
			$("#listavailableprogram").html(listavailable);
		}
	})
}
function loadtab(){
	$.ajax({
		url: url(),
		method: "post",
		data: {action: "loadtab"},
		beforeSend: function(){
			$("#tabloader").show();
		},
		success: function(data){
			data = $.parseJSON(data);
			$("#tabloader").hide();
			$("#tablevel").html(data);
		}
	})
}
function searchaccount(event){
	var search = document.getElementById("txtsearchaccount");
	if(event.keyCode == 13){
        if(search.value.trim() == ""){
            fetchdata();
        }
        else{
            $.ajax({
                url: url(),
                method: "post",
                data: {search: search.value.trim(), action: "searchaccount"},
                beforeSend: function(){
                    $("#accounts").empty();
                    $(".cssload-container").show();
                },
                success: function(data){
                    data = $.parseJSON(data);
                    $(".cssload-container").hide();
                    $("#accounts").html(data);
                }
            })
        }
    }
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
			else{
				$("#region").hide();
			}
		}
	})
}
function initaccounttype(){
	$.ajax({
		url: url(),
		method: "post",
		data: {action: "initaccounttype"},
		success: function(data){
			data = $.parseJSON(data);
			if(data.level){
				$("#slctaccounttype").html(data.options);
				$("#region").hide();
			}
			else{
				$("#accounttype").hide();
			}
		}
	})
}
function initeditregion(region){
	$.ajax({
		url: url(),
		method: "post",
		data: {action: "initregion"},
		success: function(data){
			data = $.parseJSON(data);
			if(data.level){
				$("#editslctregion").html(data.options);
				$("#editslctregion").val(region);
			}
			else{
				$("#editregion").hide();
			}
		}
	})
}
function initeditaccounttype(level){
	$.ajax({
		url: url(),
		method: "post",
		data: {action: "initaccounttype"},
		success: function(data){
			data = $.parseJSON(data);
			if(data.level){
				$("#editslctaccounttype").html(data.options);
				$("#editslctaccounttype").val(level);
			}
			else{
				$("#editaccounttype").hide();
                $("#editslctaccounttype").html(data.options);
				$("#editslctaccounttype").val(level);
			}
		}
	})
}
function accounttype(){
	var slctaccounttype = document.getElementById("slctaccounttype");
	if(slctaccounttype.value == 1){
		$("#region").hide();
	}
	else{
		$("#region").show();
	}
}
function lockaccount(){
    var accid = document.getElementById("accidholder");
    $.ajax({
        url: url(),
		method: "post",
		data: {accid: accid.value, action: "lockaccount"},
        beforeSend: function(){
            $("#modallockaccount").modal('hide');  
        },
		success: function(){
			fetchdata();
		}
    })
}
function unlockaccount(){
    var accid = document.getElementById("accidholder");
    $.ajax({
        url: url(),
        method: "post",
        data: {accid: accid.value, action: "unlockaccount"},
        beforeSend: function(){
            $("#modalunlockaccount").modal('hide');
        },
        success: function(){
            fetchdata();
        }
    })
}