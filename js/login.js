function url(){
	return "php/login.php";
}
function login(){
	var email = document.getElementById("txtemail");
	var password = document.getElementById("txtpassword");
	if(!email.value.trim() && !password.value.trim()){
		$("#errormsglogin").html("<strong>Please enter your account details");
		$('#modallogin').modal('show');
		$(".close-btn").focus();
	}
	else if(!email.value.trim()){
		$("#errormsglogin").html("<strong>Please enter your email");
		$('#modallogin').modal('show');
		$(".close-btn").focus();
	}
	else if(!password.value.trim()){
		$("#errormsglogin").html("<strong>Please enter your password");
		$('#modallogin').modal('show');
		$(".close-btn").focus();
	}
	else{
		$.ajax({
			url: url(),
			method: "post",
			data: {email: email.value, password: password.value, action: "login"},
			success: function(data){
				data = $.parseJSON(data);
				if(data.status == 1){
					window.location = data.directory;
				}
                else if(data.status == 0){
                    window.location = "notice.php";
                }
				else{
					$("#errormsglogin").html("<strong>Invalid email and password</strong>");
					$('#modallogin').modal('show');
					$(".close-btn").focus();
				}
			}
		});
	}
}
$('#modallogin').on('hidden.bs.modal', function (e) {
	$("#errormsglogin").html("");
	$("#txtemail").focus();
})