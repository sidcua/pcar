<?php 
	session_start();
	include '../../../php/checksession.php';
	include '../../../php/checkaccount.php';
	if($_SESSION['level'] != 3){
		header("location: ../../../");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
		<title>Home</title>
		<link rel="icon" href="../../../img/custom/CHED LOGO WITH WHITE BACKGROUND.png" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="../../../css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="../../../css/mdb.css" />
		<link rel="stylesheet" type="text/css" href="../../../css/font-awesome.css" />
		<link rel="stylesheet" type="text/css" href="../../../css/style.css" />
	</head>
	<body class="grey lighten-4">
		<div>
			<?php include '../view/header.php'; ?>
		</div>
		<div class="divspace"></div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<div class="jumbotron grey lighten-5">
					    <h1 class="h1-responsive">Home</h1>
					    <hr class="my-2">
					    <p><i>Statistical Graph</i></p>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="d-flex flex-row-reverse">
						<div class="form-group d-flex flex-row">
                            <?php
                                if($_SESSION['level'] < 2){
                                    echo '<label for="slctregion" style="margin-right: 10px; margin-top: 10px;">Region</label>
                                    <select onchange="forregion(this.value)" class="form-control" id="slctregion">
                                    </select>';   
                                }
                                else{
                                    echo '<label for="slctregion" style="margin-right: 10px; margin-top: 10px;" hidden>Region</label>
                                    <select onchange="forregion(this.value)" class="form-control" id="slctregion" hidden>
                                    <option value="'.$_SESSION['region'].'"><option>
                                    </select>';
                                }
                            ?>
							<label for="slctyear" style="margin-right: 10px; margin-top: 10px; margin-left: 50px;">Year</label>
							<select onchange="foryear(this.value)" class="form-control" id="slctyear" style="width: 100px;">
							</select>
						</div>
					</div>
				</div>
			</div>
            <div class="row">
                <div class="col-sm-12" id="personalpraph_quarter">
                    <label for="targetaccomplish_quarter" class="h1-responsive"><i class="fa fa-user" aria-hidden="true"></i> Quarterly Graph - Personal</label>
                    <canvas id="targetaccomplish_quarter"></canvas>
                    <div id="loading_targetaccomplish_quarter" class="text-center" style="margin-top: 50px;">
                        <img src="../../../css/loading/loading.gif">
                    </div>
                    <div class="row" style="margin-top: 50px; margin-bottom: 50px;">
                        <div class="col-sm-12">
                            <hr>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
			<div class="divspace"></div>
			<div class="row">
				<div class="col-sm-12">
					<label for="targetaccomplish_quarter_office" class="h1-responsive"><i class="fa fa-building" aria-hidden="true"></i> Quarterly Graph - Office</label>
					<canvas id="targetaccomplish_quarter_office"></canvas>
					<div id="loading_targetaccomplish_quarter_office" class="text-center" style="margin-top: 50px;">
						<img src="../../../css/loading/loading.gif">
					</div>
				</div>
			</div>
		</div>
		<div class="divspace"></div>
		<div>
			<?php include '../view/footer.php'; ?>
		</div>
	</body>
	<script type="text/javascript" src="../../../js/mdb/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="../../../js/mdb/mdb.js"></script>
	<script type="text/javascript" src="../../../js/mdb/bootstrap.js"></script>
	<script type="text/javascript" src="../../../js/mdb/popper.min.js"></script>
	<script type="text/javascript" src="../js/home.js"></script>
	<script type="text/javascript" src="../../../js/global.js"></script>
</html>