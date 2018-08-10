$(document).ready(function(){
    resetmodalchangepassword();
})
function resetmodalchangepassword(){
    $("#modalchangepassword").on('hidden.bs.modal', function(){
        $('#changepasswordmodalbody').removeClass("text-center");
        $('#changepasswordmodalbody').html('<p class="error" id="errormsgchangepassword"></p><div class="md-form"><i class="fa fa-lock prefix" aria-hidden="true"></i><input type="password" id="txtoldpassword" class="form-control"><label for="txtoldpassword">Old Password</label></div><div class="md-form"><i class="fa fa-lock prefix" aria-hidden="true"></i><input type="password" id="txtnewpassword" class="form-control"><label for="txtnewpassword">New Password</label></div><div class="md-form"><i class="fa fa-lock prefix" aria-hidden="true"></i><input type="password" id="txtconfirmpassword" class="form-control"><label for="txtconfirmpassword">Confirm password</label></div>');
        $('#changepasswordmodalfooter').html('<button type="button" class="btn btn-indigo" onclick="changepassword()">Change</button><button type="button" class="btn btn-outline-indigo waves-effect" data-dismiss="modal">Cancel</button>');
    })
}
function changepassword(){
    var old = document.getElementById("txtoldpassword");
    var newp = document.getElementById("txtnewpassword");
    var confirm = document.getElementById("txtconfirmpassword");
    if(!old.value.trim()){
        $("#errormsgchangepassword").html('<strong>Old password required</strong>');
    }
    else if(!newp.value.trim()){
        $("#errormsgchangepassword").html('<strong>New password required</strong>');
    }
    else if(!confirm.value.trim()){
        $("#errormsgchangepassword").html('<strong>Confirm your new password</strong>');
    }
    else if(newp.value != confirm.value){
        $("#errormsgchangepassword").html('<strong>New password do not match</strong>');
    }
    else{
        $.ajax({
            url: "../php/account.php",
            method: "post",
            data: {old: old.value.trim(), new: newp.value.trim(), action: "changepassword"},
            beforeSend: function(){

            },
            success: function(data){
                data = $.parseJSON(data);
                if(!data){
                    $("#errormsgchangepassword").html('<strong>Old password do not match</strong>');
                }
                else{
                    $("#changepasswordmodalbody").addClass("text-center")
                    $('#changepasswordmodalbody').html('<span><i class="fa green-text fa-check fa-4x animated fadeIn"></i></span><p class="h1-responsive green-text">Password changed successfully</p>')
                    $('#changepasswordmodalfooter').empty();
                    setTimeout(function(){
                        $("#modalchangepassword").modal('hide');
                    }, 3000)
                }
            }
        })
    }
}
$("#modallock").on('show.bs.modal', function(){
    inityear_lock();
})
function inityear_lock(){
    $.ajax({
        url: "../php/settings.php",
        method: "post",
        data: {action: "inityear_lock"},
        beforeSend: function(){
            $("#toggle").hide();
            $("#loaderlock").show();
        },
        success: function(data){
            data = $.parseJSON(data);
            $("#slctyear_lock").html(data);
        },
        complete: function(){
            initswitch($("#slctyear_lock").val());
        }
    })
}
function initswitch(year){
    var target = document.getElementById("chcktarget");
    var accomplish = document.getElementById("chckaccomplish");
    $.ajax({
        url: "../php/settings.php",
        method: "post",
        data: {year: year, action: "initswitch"},
        success: function(data){
            data = $.parseJSON(data);
            if(data.target == 1){
                target.checked = true;
            }
            else{
                target.checked = false;
            }
            if(data.accomplish == 1){
                accomplish.checked = true;
            }
            else{
                accomplish.checked = false;
            }
        },
        complete: function(){
            $("#loaderlock").hide();
            $("#toggle").show();
        }
    })
}
function targettoggle(){
    var target = document.getElementById("chcktarget");
    var year = $("#slctyear_lock").val();
    var value;
    if(target.checked){
        value = 1;
    }
    else{
        value = 0;
    }
    $.ajax({
        url: "../php/settings.php",
        method: "post",
        data: {year: year, value: value, action: "targettoggle"}
    })
}
function accomplishtoggle(){
    var accomplish = document.getElementById("chckaccomplish");
    var year = $("#slctyear_lock").val();
    var value;
    if(accomplish.checked){
        value = 1;
    }
    else{
        value = 0;
    }
    $.ajax({
        url: "../php/settings.php",
        method: "post",
        data: {year: year, value: value, action: "accomplishtoggle"}
    })
}
function selectyear_lock(year){
    var target = document.getElementById("chcktarget");
    var accomplish = document.getElementById("chckaccomplish");
     $.ajax({
        url: "../php/settings.php",
        method: "post",
        data: {year: year, action: "initswitch"},
        beforeSend: function(){
            $("#toggle").hide();
            $("#loaderlock").show();
        },
        success: function(data){
            data = $.parseJSON(data);
            if(data.target == 1){
                target.checked = true;
            }
            else{
                target.checked = false;
            }
            if(data.accomplish == 1){
                accomplish.checked = true;
            }
            else{
                accomplish.checked = false;
            }
        },
        complete: function(){
            $("#loaderlock").hide();
            $("#toggle").show();
        }
    })
}