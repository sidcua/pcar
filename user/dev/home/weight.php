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
		<title>Accounts</title>
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
					    <h1 class="h1-responsive">Weight Percentage</h1>
					    <hr class="my-2">
					    <p><i>List of level 1 programs and its corresponding weight percentage</i>
					</div>
				</div>
			</div>
			<div class="divspace"></div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="table-wrapper-2">
                        <input type="hidden" id="programidholder" value="" />
						<table class="table table-striped">
						    <thead class="mdb-color darken-3">
						        <tr class="white-text">
						            <th>Programs/Project</th>
                                    <th>Percentage</th>
						            <th style="width: 200px;">Action</th>
						        </tr>
						    </thead>
						    <tbody id="tblweight">
						        
						    </tbody>
						</table>
						
					</div>
					<div id="weightloader" class="cssload-container">
						<div class="cssload-speeding-wheel"></div>
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
	<script type="text/javascript" src="../../../js/mdb/popper.min.js"></script>
	<script type="text/javascript" src="../../../js/mdb/mdb.js"></script>
	<script type="text/javascript" src="../../../js/mdb/bootstrap.js"></script>
	<script type="text/javascript" src="../js/weight.js"></script>
	<script type="text/javascript" src="../../../js/global.js"></script>
</html>
<div class="modal fade" id="modaleditweight" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-warning" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <p class="heading lead">Edit Weight</p>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">
            	<p class="error" id="errormsgeditweight"></p>
                <div class="md-form">
				    <i class="fa fa-archive prefix"></i>
				    <input type="text" id="edittxtweight" class="form-control">
				    <label for="edittxtweight">Milestone</label>
				</div>
            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-warning" onclick="editweight()">Save</button>
                <button type="button" class="btn btn-outline-warning waves-effect" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>