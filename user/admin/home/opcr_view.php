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
		<title>OPCR</title>
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
					    <h1 class="h1-responsive">OPCR</h1>
					    <hr class="my-2">
					    <!-- <p><i>OPCR summary</i></p> -->
					</div>
				</div>
			</div>
		</div>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-sm-5">
                    <div class="card">
                        <h5 class="card-header"></h5>
                        <div class="card-body">
                            <input id="regionid" type="hidden" value="<?php echo $_SESSION['region'];?>">
                            <div class="form-group d-flex flex-row">
                                <label for="slctyear" style="margin: 10px 15px 0px 0px;">Year</label>
                                <select class="form-control" id="slctyear">
                                    <?php
                                        $latest = date('Y');
                                        for ($i = $latest; $i >= 2014 ; $i--) { 
                                            $output .= '<option value="'.$i.'">'.$i.'</option>';
                                        }
                                        echo $output;
                                    ?>
                                </select>
                            </div>
                            <div class="form-group d-flex justify-content-end">
                                <button onclick="print()" class="btn btn-outline-primary waves-effect"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="divspace"><br><br></div>
		<div>
			<?php include '../view/footer.php'; ?>
		</div>
	</body>
	<script type="text/javascript" src="../../../js/mdb/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="../../../js/mdb/mdb.js"></script>
	<script type="text/javascript" src="../../../js/mdb/bootstrap.js"></script>
	<script type="text/javascript" src="../../../js/mdb/popper.min.js"></script>
	<script type="text/javascript" src="../js/opcr.js"></script>
	<script type="text/javascript" src="../../../js/global.js"></script>
</html>
<script>
    function print(){
        var year = $("#slctyear").val();
        var region = $("#regionid").val();
        window.open("../home/printable/opcr_report.php?year=" + year + "&region=" + region);
    }
</script>