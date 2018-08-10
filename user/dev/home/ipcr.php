<?php 
	session_start();
	include '../php/checksession.php';
    include '../php/checkaccount.php';
    include '../php/checklevel2.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
		<title>IPCR</title>
		<link rel="icon" href="../img/custom/CHED LOGO WITH WHITE BACKGROUND.png" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="../css/mdb.css" />
		<link rel="stylesheet" type="text/css" href="../css/font-awesome.css" />
		<link rel="stylesheet" type="text/css" href="../css/style.css" />
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
					    <h1 class="h1-responsive">IPCR</h1>
					    <hr class="my-2">
					    <p><i>IPCR summary</i></p>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="offset-1 col-sm-5">
					<div class="d-flex flex-row">
                        <?php
                            if($_SESSION['level'] < 2){
                                echo '<div class="form-group d-flex flex-row"><label for="slctregion" style="margin: 10px 15px 0px 0px;">Region</label>
                                <select onchange="fetchdata()" class="form-control" id="slctregion" style="width: 100px;">
                                </select>
                                <div style="margin: 0px 20px 0px 20px;"></div></div>';
                            }
                            else{
                                echo '<div class="form-group d-flex flex-row"><label for="slctregion" style="margin: 10px 15px 0px 0px;" hidden>Region</label>
                                <select class="form-control" id="slctregion" style="width: 100px;" hidden>
                                <option value="'.$_SESSION['region'].'"></option>
                                </select>
                                <div style="margin: 0px 20px 0px 20px;"></div></div>';
                            }
                        ?>
                        <div class="form-group d-flex flex-row">
                            <label for="slctyear" style="margin: 10px 15px 0px 0px;">Year</label>
                            <select onchange="fetchdata();" class="form-control" id="slctyear">
                            </select>
                        </div>
						
                    </div>
				</div>
				<div class="col-sm-6 d-flex flex-row-reverse">
                    <div class="form-group">
                        <button onclick="print()" class="btn btn-outline-primary waves-effect"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                    </div>
                </div>
			</div>
			<div class="row">
				<table class="table table-striped" id="tblipcr">
                </table>
                <div id="fountainG" style="margin-top: 50px; margin-bottom: 20px;">
                    <div id="fountainG_1" class="fountainG"></div>
                    <div id="fountainG_2" class="fountainG"></div>
                    <div id="fountainG_3" class="fountainG"></div>
                    <div id="fountainG_4" class="fountainG"></div>
                    <div id="fountainG_5" class="fountainG"></div>
                    <div id="fountainG_6" class="fountainG"></div>
                    <div id="fountainG_7" class="fountainG"></div>
                    <div id="fountainG_8" class="fountainG"></div>
                </div>
			</div>
		</div>
		<div>
			<?php include '../view/footer.php'; ?>
		</div>
	</body>
	<script type="text/javascript" src="../js/mdb/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="../js/mdb/mdb.js"></script>
	<script type="text/javascript" src="../js/mdb/bootstrap.js"></script>
	<script type="text/javascript" src="../js/mdb/popper.min.js"></script>
	<script type="text/javascript" src="../js/ipcr.js"></script>
	<script type="text/javascript" src="../js/global.js"></script>
</html>