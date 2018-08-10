<?php 
	session_start();
	include 'php/checksession2.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
		<title>OPCARS</title>
		<link rel="icon" href="img/custom/CHED LOGO WITH WHITE BACKGROUND.png" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="css/mdb.css" />
		<link rel="stylesheet" type="text/css" href="css/font-awesome.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		
	</head>
	<body class="login">
		<div class="container">
			<div class="row" style="margin-top: 0px;"></div>
			<div class="row">
				<div class="col-sm-12">
					<center>
						<img src="img/custom/chedlogo2.png" class="img-fluid" style="max-width: 500px; max-height: 500px;">
					</center>
<!--
                    <center>
                        <svg width="700" height="350">
                            <defs>
                                <clipPath id="circleView">
                                    <circle cx="350" cy="175" r="125" fill="#FFFFFF" />            
                                </clipPath>
                            </defs>
                        <image width="700" height="350" xlink:href="img/custom/chedlogo2.png" clip-path="url(#circleView)" />

                         </svg>
                    </center>
-->
				</div>
			</div>
			<div class="row" style="margin-top: -30px;">
				<div class="col-sm-3"></div>
		        <div class="col-sm-6">
		        	<div class="card indigo text-center z-depth-2">
			            <div class="card-body">
			                <p class="white-text mb-0">OPCARS</p>
			            </div>
			        </div>
		        </div>
		        <div class="col-sm-3"></div>
			</div>
			<div class="row" style="margin-top: 10px;">
				<div class="col-sm-2"></div>
				<div class="col-sm-8">	
			        <div class="row">
			        	<div class="col-sm-2"></div>
			        	<div class="col-sm-8">
			        		<p class="error" id="errormsglogin"></p>
			        		<div class="md-form">
						        <i class="fa fa-envelope prefix"></i>
						        <input type="text" id="txtemail" class="form-control white-text" onkeydown="if(event.keyCode == 13) login();" autofocus>
						        <label for="txtemail" class="white-text">Your email</label>
						    </div>

						    <div class="md-form">
						        <i class="fa fa-lock prefix"></i>
						        <input type="password" id="txtpassword" class="form-control white-text" onkeydown="if(event.keyCode == 13) login();">
						        <label for="txtpassword" class="white-text">Your password</label>
						    </div>
			        	</div>
			        	<div class="col-sm-2"></div>
			        </div>
				    <div class="text-center">
				        <button class="btn btn-indigo" onclick="login()">Login</button>
						<p class="white-text">Forgot <a href="#!" class="blue-text">Password?</a></p>
				    </div>
				</div>
				<div class="col-sm-2"></div>
			</div>
		</div>
	</body>
	<script type="text/javascript" src="js/mdb/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="js/login.js"></script>
	<script type="text/javascript" src="js/mdb/mdb.js"></script>
	<script type="text/javascript" src="js/mdb/bootstrap.js"></script>
	<script type="text/javascript" src="js/mdb/popper.min.js"></script>
</html>