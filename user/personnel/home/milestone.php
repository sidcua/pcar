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
		<title>Milestone</title>
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
					    <h1 class="h1-responsive">Milestone</h1>
					    <hr class="my-2">
					    <p><i>List and adding of milestone</i>
					</div>
				</div>
			</div>
			<div class="divspace"></div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="d-flex justify-content-between">
						<div class="md-form">
							<button type="button" data-toggle="modal" data-target="#modaladdmilestone" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Add Milestone</button>
						</div>
						<div class="md-form d-flex flex-row">
                            <label for="slctyear" style="margin-right: 10px;">Year</label>
                            <select onchange="listmilestone(this.value)" class="form-control" id="slctyear" style="margin-left: 50px;">
                            </select>
						</div>
					</div>
				</div>
			</div>

			<input type="hidden" id="accidholder" value="">

			<div class="row">
				<div class="col-sm-12">
					<div class="table-wrapper-2">
                        <input type="hidden" id="milestoneidholder" value="" />
						<table class="table table-striped">
						    <thead class="mdb-color darken-3">
						        <tr class="white-text">
						            <th>Milestone</th>
						            <th style="width: 200px;">Action</th>
						        </tr>
						    </thead>
						    <tbody id="tblmilestone">
						        
						    </tbody>
						</table>
						
					</div>
					<div id="milestoneloader" class="cssload-container">
						<div class="cssload-speeding-wheel"></div>
					</div>
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
	<script type="text/javascript" src="../js/milestone.js"></script>
	<script type="text/javascript" src="../../../js/global.js"></script>
</html>
<div class="modal fade" id="modaladdmilestone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-info" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <p class="heading lead">Add Milestone</p>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">
            	<p class="error" id="errormsgaddmilestone"></p>
                <div class="md-form">
				    <i class="fa fa-archive prefix"></i>
				    <input type="text" id="txtaddmilestone" class="form-control">
				    <label for="txtaddmilestone">Milestone</label>
				</div> 
                <div class="md-form d-flex flex-row">
				    <label for="slctaddyear" style="margin-right: 10px;">Year</label>
                    <select class="form-control" id="slctaddyear" style="margin-left: 50px;">
                    </select>
				</div> 
            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary" onclick="addmilestone()">Add</button>
                <button type="button" class="btn btn-outline-primary waves-effect" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>

<div class="modal fade" id="modaldeletemilestone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
        <!--Content-->
        <div class="modal-content text-center">
            <!--Header-->
            <div class="modal-header d-flex justify-content-center">
                <p class="heading">Are you sure?</p>
            </div>

            <!--Body-->
            <div class="modal-body">

                <i class="fa fa-times fa-4x animated rotateIn"></i>

            </div>

            <!--Footer-->
            <div class="modal-footer flex-center">
                <button onclick="deletemilestone()" type="button" class="btn btn-outline-danger">Yes</button>
                <button type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">No</button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<div class="modal fade" id="modaleditmilestone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-warning" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <p class="heading lead">Edit Milestone</p>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">
            	<p class="error" id="errormsgeditmilestone"></p>
                <div class="md-form">
				    <i class="fa fa-archive prefix"></i>
				    <input type="text" id="txteditmilestone" class="form-control">
				    <label for="txteditmilestone">Milestone</label>
				</div> 
                <div class="md-form d-flex flex-row">
				    <label for="slctedityear" style="margin-right: 10px;">Year</label>
                    <select class="form-control" id="slctedityear" style="margin-left: 50px;">
                    </select>
				</div> 
            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-warning" onclick="editmilestone()">Add</button>
                <button type="button" class="btn btn-outline-warning waves-effect" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>