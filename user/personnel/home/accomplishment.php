<?php 
	session_start();
	include '../../../php/checksession.php';
    include '../../../php/checkaccount.php';
    include '../../../php/checklevel2.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
		<title>Accomplishment</title>
		<link rel="icon" href="../../../img/custom/CHED LOGO WITH WHITE BACKGROUND.png" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" 	href="../../../css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="../../../css/mdb.css" />
		<link rel="stylesheet" type="text/css" href="../../../css/font-awesome.css" />
		<link rel="stylesheet" type="text/css" href="../../../css/style.css" />
	</head>
	<body class="grey lighten-4">
		<div>
			<?php include '../view/header.php'; ?>
		</div>
		<div class="container-fluid">
			<?php include '../view/accomplish_guide.php'; ?>
		</div>
		<div class="divspace"></div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<div class="jumbotron grey lighten-5">
					    <h1 class="h1-responsive">Accomplishment
							<?php
								if($_GET['program'] == 1){
									echo '(PCAR)';
								}
								else if($_GET['program'] == 2){
									echo '(IPCR)';
								}
								else if($_GET['program'] == 3){
									echo '(DBM)';
								}
							?>
						</h1>
					    <hr class="my-2">
					    <p><i>Accomplishment Record</i></p>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<div class="d-flex justify-content-between">
						<div class="form-group d-flex flex-row">
							<label for="slctyear" style="margin-right: 10px; margin-top: 10px;">Year</label>
							<select onchange="fetchdata(this.value)" class="form-control" id="slctyear">
							</select>
						</div>
						<div class="form-gruop">
					        <button onclick="print(<?php echo $_SESSION['accID']; ?>)" class="btn btn-outline-primary waves-effect"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
					    </div>
					</div>
				</div>
			</div>
            <div class="row" id="txtnotice">
            </div>
			<input type="hidden" id="programholder" value="<?php echo $_GET['program']; ?>">
			<div class="row">
				<table class="table table-bordered">
					<thead class="mdb-color darken-3">
						<tr class="text-center white-text">
							<th class="font-weight-bold align-middle" style="width: 300px;" rowspan="2">Services Programs/Projects</th>
							<th class="font-weight-bold" colspan="5">Targets</th>
							<th class="font-weight-bold" colspan="5">Accomplishment</th>
							<th class="font-weight-bold align-middle" rowspan="2" style="width: 300px;">Remark</th>
							<th class="font-weight-bold align-middle" rowspan="2" style="width: 150px;">Action</th>
						</tr>
						<tr class="text-center white-text">
							<th class="font-weight-bold">1st Quarter</th>
							<th class="font-weight-bold">2nd Quarter</th>
							<th class="font-weight-bold">3rd Quarter</th>
							<th class="font-weight-bold">4th Quarter</th>
							<th class="font-weight-bold align-middle">Total</th>
							<th class="font-weight-bold">1st Quarter</th>
							<th class="font-weight-bold">2nd Quarter</th>
							<th class="font-weight-bold">3rd Quarter</th>
							<th class="font-weight-bold">4th Quarter</th>
							<th class="font-weight-bold align-middle">Total</th>
						</tr>
					</thead>
					<tbody id="tblaccomplish">
						
					</tbody>
				</table>
				<div id="accomplishloader" class="cssload-container" style="margin-top: 20px;">
					<div class="cssload-speeding-wheel"></div>
				</div>
			</div>
		</div>
		<div class="divspace" style="margin-bottom: 100px;"></div>
		<div>
			<?php include '../view/footer.php'; ?>
		</div>
	</body>
	<script type="text/javascript" src="../../../js/mdb/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="../../../js/mdb/mdb.js"></script>
	<script type="text/javascript" src="../../../js/mdb/bootstrap.js"></script>
	<script type="text/javascript" src="../../../js/mdb/popper.min.js"></script>
	<script type="text/javascript" src="../js/accomplish.js"></script>
	<script type="text/javascript" src="../../../js/global.js"></script>
</html>