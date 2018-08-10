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
					    <h1 class="h1-responsive">Accounts</h1>
					    <hr class="my-2">
					    <p><i>List of accounts and assignation of prgorams</i>
					</div>
				</div>
			</div>
			<div class="divspace"></div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<div class="md-form">
						<button type="button" data-toggle="modal" data-target="#modaladdaccount" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Add Account</button>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="md-form form-sm float-right">
						<i class="fa fa-search prefix" aria-hidden="true"></i>
						<input onkeypress="searchaccount(event)" type="text" id="txtsearchaccount" class="form-control" style="width: 350px;">
						<label for="txtsearchaccount">Search</label>
					</div>
				</div>
			</div>

			<input type="hidden" id="accidholder" value="">

			<div class="row">
				<div class="col-sm-12">
					<div class="table-wrapper-2">
						<table class="table table-striped">
						    <thead class="mdb-color darken-3">
						        <tr class="white-text">
						            <th>Email</th>
						            <th>Name</th>
						            <th>Position</th>
						            <?php  
						            	if($_SESSION['level'] == 1 || $_SESSION['level'] == 2){
						            		echo 
						            		'<th>Region</th>';
						            	}
						            ?>
						            <th>Action</th>
						        </tr>
						    </thead>
						    <tbody id="accounts">
						        
						    </tbody>
						</table>
						
					</div>
					<div class="cssload-container">
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
	<script type="text/javascript" src="../js/account.js"></script>
	<script type="text/javascript" src="../../../js/global.js"></script>
</html>
<div class="modal fade" id="modaladdaccount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-info" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <p class="heading lead">Add Account</p>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">
            	<p class="error" id="errormsgaddaccount"></p>
                <div class="md-form">
				    <i class="fa fa-envelope prefix"></i>
				    <input type="text" id="txtemail" class="form-control">
				    <label for="txtemail">Email</label>
				</div>
				<div class="md-form">
				    <i class="fa fa-user prefix"></i>
				    <input type="text" id="txtname" class="form-control">
				    <label for="txtname">Name</label>
				</div>
				<div class="md-form">
				    <i class="fa fa-suitcase prefix"></i>
				    <input type="text" id="txtposition" class="form-control">
				    <label for="txtposition">Position</label>
				</div>
				<div class="form-group" id="accounttype">
					<i class="fa fa-user" aria-hidden="true"></i>
					<label for="slctaccounttype">Account Type</label>
					<select onchange="accounttype()" class="form-control" id="slctaccounttype">
						<option></option>
					</select> 
				</div>
				<div class="form-group" id="region">
					<i class="fa fa-map" aria-hidden="true"></i>
					<label for="slctregion">Region</label>
					<select class="form-control" id="slctregion">
						<option></option>
					</select>
				</div>
            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary" onclick="addaccount()">Save</button>
                <button type="button" class="btn btn-outline-primary waves-effect" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>

<div class="modal fade" id="modaldeleteaccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <button onclick="deleteaccount()" type="button" class="btn btn-outline-danger">Yes</button>
                <button type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">No</button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<div class="modal fade" id="modallockaccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
        <!--Content-->
        <div class="modal-content text-center">
            <!--Header-->
            <div class="modal-header d-flex justify-content-center">
                <p class="heading">Are you sure?</p>
            </div>

            <!--Body-->
            <div class="modal-body">

                <i class="fa fa-lock fa-4x animated rotateIn"></i>

            </div>

            <!--Footer-->
            <div class="modal-footer flex-center">
                <button onclick="lockaccount()" type="button" class="btn btn-outline-danger">Yes</button>
                <button type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">No</button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<div class="modal fade" id="modalunlockaccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-notify modal-success" role="document">
        <!--Content-->
        <div class="modal-content text-center">
            <!--Header-->
            <div class="modal-header d-flex justify-content-center">
                <p class="heading">Are you sure?</p>
            </div>

            <!--Body-->
            <div class="modal-body">

                <i class="fa fa-unlock fa-4x animated rotateIn"></i>

            </div>

            <!--Footer-->
            <div class="modal-footer flex-center">
                <button onclick="unlockaccount()" type="button" class="btn btn-outline-success">Yes</button>
                <button type="button" class="btn  btn-success waves-effect" data-dismiss="modal">No</button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<div class="modal fade" id="modaleditaccount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-warning" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <p class="heading lead">Edit Account</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">
            	<p class="error" id="errormsgeditaccount"></p>
                <div class="md-form">
				    <i class="fa fa-envelope prefix"></i>
				    <input type="text" id="edittxtemail" class="form-control">
				    <label for="edittxtemail">Email</label>
				</div>
				<div class="md-form">
				    <i class="fa fa-user prefix"></i>
				    <input type="text" id="edittxtname" class="form-control">
				    <label for="edittxtname">Name</label>
				</div>
				<div class="md-form">
				    <i class="fa fa-suitcase prefix"></i>
				    <input type="text" id="edittxtposition" class="form-control">	
				    <label for="edittxtposition">Position</label>
				</div>
				<div class="form-group" id="editregion">
					<i class="fa fa-map" aria-hidden="true"></i>
					<label for="editslctregion">Region</label>
					<select class="form-control" id="editslctregion">
						<option></option>
					</select>
				</div>
				<div class="form-group" id="editaccounttype">
					<i class="fa fa-user" aria-hidden="true"></i>
					<label for="editslctaccounttype">Account Type</label>
					<select class="form-control" id="editslctaccounttype">
						<option></option>
					</select> 
				</div>
            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <button onclick="editaccount()" type="button" class="btn btn-warning">Update</button>
                <button type="button" class="btn btn-outline-warning waves-effect" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<div class="modal fade" id="modalassignprogram" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-fluid modal-info" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <p id="assignheader" class="heading lead"></p>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">
            	<div class="container-fluid">
            		<div class="row">
        				<div class="col-sm-12 d-flex justify-content-center" style="margin-bottom: 0px;">
        					<ul id="tablevel" class="nav nav-pills">
							</ul>
							<div id="tabloader" class="cssload-container">
								<div class="cssload-speeding-wheel"></div>
							</div>
        				</div>
            		</div>
            		<hr>
            		<div class="row">
            			<div class="col-sm-6">
            				<label><b>Programs/Projects</b></label>
            				<div class="modalbody-height">
            					<ul class="list-group" id="listavailableprogram">
								</ul>
								<div id="programloader" class="cssload-container" style="margin-top: 15px;">
									<div class="cssload-speeding-wheel"></div>
								</div>
            				</div>
            			</div>
            			<div class="col-sm-6">
            				<label><b>Assigned Program</b></label>
            				<div class="modalbody-height">
            					<ul class="list-group" id="listassignedprogram">
								</ul>
								<div id="assignedloader" class="cssload-container" style="margin-top: 15px;">
									<div class="cssload-speeding-wheel"></div>
								</div>
            				</div>
            			</div>
            		</div>
            	</div>
            </div>
            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-default waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>