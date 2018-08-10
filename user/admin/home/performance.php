<?php 
	session_start();
	include '../../../php/checksession.php';
    include '../../../php/checkaccount.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
		<title>Reports</title>
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
					    <h1 class="h1-responsive">Performance</h1>
					    <hr class="my-2">
					    <p><i>Performance in Remarks, Rating, and Adjective Rating on each Program</i></p>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="offset-1 col-sm-5">
					<div class="d-flex">
                        <?php
                            if($_SESSION['level'] < 2){
                                echo '<div class="form-group d-flex flex-row"><label for="slctregion" style="margin-right: 15px; margin-top: 10px;">Region</label>
                                <select onchange="change();" class="form-control" id="slctregion" style="margin-right: 10px;">
                                </select></div>';
                            }
                            else{
                                echo '<div class="form-group d-flex flex-row"><label for="slctregion" style="margin-right: 15px; margin-top: 10px;" hidden>Region</label>
                                <select class="form-control" id="slctregion" style="margin-right: 10px;" hidden>
                                <option value="'.$_SESSION['region'].'"></option>
                                </select></div>';
                            }
                        ?>
					    <div class="form-group d-flex flex-row">
					        <label for="slctyear" style="margin-right: 15px; margin-top: 10px;">Year</label>
                            <select onchange="change();" class="form-control" id="slctyear">
                            </select>
					    </div>
					</div>
				</div>
				<div class="col-sm-6 d-flex flex-row-reverse">
                    <div class="form-group">
                        <button type="button" onclick="print(<?php echo $_SESSION['accID']; ?>)" class="btn btn-outline-primary waves-effect"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                    </div>
                </div>
			</div>
			<div class="row">
				<div id="fountainG" style="margin-top: 100px; margin-bottom: 20px;">
					<div id="fountainG_1" class="fountainG"></div>
					<div id="fountainG_2" class="fountainG"></div>
					<div id="fountainG_3" class="fountainG"></div>
					<div id="fountainG_4" class="fountainG"></div>
					<div id="fountainG_5" class="fountainG"></div>
					<div id="fountainG_6" class="fountainG"></div>
					<div id="fountainG_7" class="fountainG"></div>
					<div id="fountainG_8" class="fountainG"></div>
				</div>
				<table id="tblperformance" class="table table-striped">
					
				</table>
			</div>
		</div>
		<div>
			<?php include '../view/footer.php'; ?>
		</div>
	</body>
	<script type="text/javascript" src="../../../js/mdb/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="../../../js/mdb/mdb.js"></script>
	<script type="text/javascript" src="../../../js/mdb/bootstrap.js"></script>
	<script type="text/javascript" src="../../../js/mdb/popper.min.js"></script>
	<script type="text/javascript" src="../js/performance.js"></script>
	<script type="text/javascript" src="../../../js/global.js"></script>
</html>