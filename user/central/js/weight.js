$(document).ready(function(){
    holdprogramid();
    transferaccinfo();
    fetchdata();
    reseteditmodal();
})
function url(){
    return "../php/weight.php";
}
function fetchdata(){
    $.ajax({
        url: url(),
        method: "post",
        data: {action: "fetchdata"},
        beforeSend: function(){
            $("#tblweight").empty();
            $("#weightloader").show();
        },
        success: function(data){
            data = $.parseJSON(data);
            $("#weightloader").hide();
            $("#tblweight").html(data);
        }
    })
}
function editweight(){
    var programid = $("#programidholder").val();
    var weight = document.getElementById("edittxtweight");
    if(!weight.value.trim()){
        $("#errormsgeditweight").text("Input Weight");
    }
    else if(weight.value > 100){
        $("#errormsgeditweight").text("100 is the limit");
    }
    else{
        $.ajax({
            url: url(),
            method: "post",
            data: {programid: programid, weight: weight.value, action: "editweight"},
            beforeSend: function(){
                  
            },
            success: function(data){
                data = $.parseJSON(data);
                if(!data){
                    $("#errormsgeditweight").text("100 is the limit");
                }
                else{
                    fetchdata();
                    $("#modaleditweight").modal('hide');
                }
            }
        })
    }
}
function holdprogramid(){
	$('body').on('click', '#tblweight>tr', function(){
		$("#programidholder").val($(this).attr('data-id'));
	});
}
function transferaccinfo(){
	$('body').on('click', '.editweight', function(){
		var weight = $(this).closest('tr').find('.weight').text();
		$("#edittxtweight").val(weight);
        $("[for='edittxtweight']").addClass("active");
	});
}
function reseteditmodal(){
    $("#modaleditweight").on('hidden.bs.modal', function(){
        $("#errormsgeditweight").text("");
    })
}