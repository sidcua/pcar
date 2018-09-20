<?php 
	session_start();
	include '../../../php/checksession.php';
    include '../../../php/checkaccount.php';
    include '../../../php/checklevel.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
		<title>Percentage</title>
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
					    <h1 class="h1-responsive">Percentage Accomplishment</h1>
					    <hr class="my-2">
					    <p><i>Total targets, total accomplishments and percentage rating of all level 1 programs</i></p>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-10 d-flex justify-content-start">
					<div class="form-group d-flex flex-row" style="margin-right: 20px;" hidden>
						<label for="slctregion" style="margin-right: 10px; margin-top: 10px;" hidden>Region</label>
						<select class="form-control" id="slctregion" hidden>
						<option value="<?php echo $_SESSION['region']; ?>"></option>
						</select>
					</div>
					<div class="form-group d-flex flex-row">
						<label for="slctyear" style="margin-right: 10px; margin-top: 10px;">Year</label>
						<select onchange="fetchdata()" class="form-control" id="slctyear">
						</select>
					</div>
					<div class="form-group d-flex flex-row">
						<label for="slctreport" style="margin-right: 10px; margin-top: 10px; margin-left: 20px;">Report</label>
						<select onchange="fetchdata()" class="form-control" id="slctreport">
						</select>
					</div>
				</div>
				<div class="col-sm-2 d-flex justify-content-end"></div>
			</div>
			<div class="row">
				<table class="table table-striped">
					<thead class="mdb-color darken-3 table-striped">
						<tr class="white-text text-center">
							<th style="width: 300px;">Services Programs/Projects</th>
							<th>Total Targets</th>
							<th>Total Accopplishments</th>
                            <th></th>
							<th>Percentage</th>
                            <th>Equivalent</th>
						</tr>
					</thead>
					<tbody id="tblpercentage">
						
					</tbody>
				</table>
				<div id="percentageloader" class="cssload-container" style="margin-top: 20px;">
					<div class="cssload-speeding-wheel"></div>
				</div>
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
	<script type="text/javascript" src="../js/percentage.js"></script>
	<script type="text/javascript" src="../../../js/global.js"></script>
</html>