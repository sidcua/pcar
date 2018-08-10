$(document).ready(function(){
    inityear();
    holdmilestoneid();
    resetaddmodal();
    transmilestoneinfo();
})
function url(){
    return '../php/milestone.php';
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
            $("#slctaddyear").html(data);
            $("#slctedityear").html(data);
            listmilestone($("#slctyear").val());
        },
        complete: function(){
            $("#slctyear").show();
        }
    })
}
function listmilestone(year){
    $.ajax({
        url: url(),
        method: "post",
        data: {year: year, action: "listmilestone"},
        beforeSend: function(){
            $("#tblmilestone").empty();
            $("#milestoneloader").show();
        },
        success: function(data){
            data = $.parseJSON(data);
            $("#milestoneloader").hide();
            $("#tblmilestone").html(data);
        }
    })
}   
function resetaddmodal(){
    $("#modaladdmilestone").on('hidden.bs.modal', function(){
        $("#txtaddmilestone").val("");
        $("[for='txtaddmilestone']").removeClass("active");
    })
}
function holdmilestoneid(){
	$('body').on('click', '#tblmilestone>tr', function(){
		$("#milestoneidholder").val($(this).attr('data-id'));
	});
}
function addmilestone(){
    var milestone = document.getElementById("txtaddmilestone");
    var year = document.getElementById("slctaddyear");
    if(!milestone.value.trim()){
        $("#errormsgaddmilestone").text("Input milestone");
    }
    else{
        $.ajax({
            url: url(),
            method: "post",
            data: {milestone: milestone.value, year: year.value, action: "addmilestone"},
            beforeSend: function(){
                $("#tblmilestone").empty();
                $("#milestoneloader").show();
                $("#modaladdmilestone").modal('hide');
            },
            success: function(){
                listmilestone($("#slctyear").val());
            }
        })
    }
}
function deletemilestone(){
    var milestoneid = $("#milestoneidholder").val();
    $.ajax({
        url: url(),
        method: "post",
        data: {milestoneid: milestoneid, action: "deletemilestone"},
        beforeSend: function(){
            $("#modaldeletemilestone").modal('hide');
            $("#tblmilestone").empty();
            $("#milestoneloader").show();
        },
        success: function(){
            listmilestone($("#slctyear").val());
        }
    })
}
function transmilestoneinfo(){
	$('body').on('click', '.editmilestone', function(){
		var milestone = $(this).closest('tr').find('.milestone').text();
		$("#txteditmilestone").val(milestone);
        $("[for='txteditmilestone']").addClass("active");
	});
}
function editmilestone(){
    var milestoneid = $("#milestoneidholder").val();
    var milestone = document.getElementById("txteditmilestone");
    var year = $("#slctedityear").val();
    if(!milestone.value.trim()){
        $("#errormsgeditmilestone").text("Input milestone");
    }
    else{
        $.ajax({
            url: url(),
            method: "post",
            data: {milestoneid: milestoneid, milestone: milestone.value, year: year, action: "editmilestone"},
            beforeSend: function(){
                $("#modaleditmilestone").modal('hide');
                $("#tblmilestone").empty();
                $("#milestoneloader").show();
            },
            success: function(){
                listmilestone($("#slctyear").val());
            }
        })
    }
}