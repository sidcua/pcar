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
		<title>Programs</title>
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
					    <h1 class="h1-responsive">Programs</h1>
					    <hr class="my-2">
					    <p><i>List of programs/projects</i>
					</div>
				</div>
			</div>
			<div class="divspace"></div>
		</div>

		<input type="hidden" id="programidholder" value="">
		<input id="programholder" type="hidden" value="<?php echo $_GET['program']; ?>">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<div class="md-form d-flex justify-content-start">
						<?php  
							if($_SESSION['level'] <= 1){
								echo '<button type="button" data-toggle="modal" data-target="#modaladdprogram" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Add Program</button>';
							}
							if($_SESSION['level'] == 2){
								echo '<i class="fa red-text fa-stop fa-2x" aria-hidden="true" style="margin-left: 20px;"></i>
									<p class="h4-responsive" style="margin-left: 5px;">Unassigned Program</p>';
							}  
						?>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="md-form form-sm float-right">
						<i class="fa fa-search prefix" aria-hidden="true"></i>
						<input onkeypress="searchprogram(event)" type="text" id="txtsearchprogram" class="form-control" style="width: 350px;">
						<label for="txtsearchprogram">Search</label>
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
                                <th>Program/Project</th>
                                <th>Status for Input</th>
                                <th>State</th>
                                <?php  
                                    if($_SESSION['level'] < 2){
                                        echo '<th>Action</th>'; 
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody id="program">

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
	<script type="text/javascript" src="../../../js/mdb/mdb.js"></script>
	<script type="text/javascript" src="../../../js/mdb/bootstrap.js"></script>
	<script type="text/javascript" src="../../../js/mdb/popper.min.js"></script>
	<script type="text/javascript" src="../js/program.js"></script>
	<script type="text/javascript" src="../../../js/global.js"></script>
</html>

<div class="modal fade" id="modaladdprogram" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <p class="heading lead">Add Program</p>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">
            	<p class="error" id="errormsgaddprogram"></p>
                <div class="md-form">
				    <i class="fa fa-book prefix"></i>
				    <input type="text" id="txttitle" class="form-control">
				    <label for="txttitle">Title</label>
				</div>
				<div class="md-form">
				    <i class="fa fa-reorder prefix"></i>
				    <input onchange="selectprogram()" type="number" id="txtlevel" min="1" class="form-control">
				    <label for="txtlevel">Level</label>
				</div>
				<div class="form-group">
					<i class="fa fa-level-down" aria-hidden="true"></i>
					<label for="slctprogram">Under Program</label>
					<select class="form-control" id="slctprogram">
					</select>
				</div>
				<!-- <div class="form-group p-3" id="report">
				</div> -->
				<div class="form-group" id="status">
					<i class="fa fa-info" aria-hidden="true"></i>
					<label for="slctstatus">Status for Input</label>
					<select class="form-control" id="slctstatus">
						<option value="Active">Active</option>
						<option value="Inactive">Inactive</option>
					</select>
				</div>
				<div class="form-group">
					<i class="fa fa-info" aria-hidden="true"></i>
					<label for="slctstate">State</label>
					<select class="form-control" id="slctstate">
						<option value="Active">Active</option>
						<option value="Inactive">Inactive</option>
					</select>
				</div>
            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary" onclick="addprogram()">Save</button>
                <button type="button" class="btn btn-outline-primary waves-effect" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<div class="modal fade" id="modaldeleteprogram" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <button onclick="deleteprogram()" type="button" class="btn btn-outline-danger">Yes</button>
                <button type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">No</button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<div class="modal fade" id="modaleditprogram" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-warning modal-lg" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <p class="heading lead">Edit Program</p>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">
            	<p class="error" id="errormsgeditprogram"></p>
                <div class="md-form">
				    <i class="fa fa-book prefix"></i>
				    <input type="text" id="edittxttitle" class="form-control">
				    <label for="edittxttitle">Title</label>
				</div>
				<div class="md-form">
				    <i class="fa fa-reorder prefix"></i>
				    <input onchange="editselectprogram(this.value, 0, false)" type="number" id="edittxtlevel" min="1" class="form-control">
				    <label for="edittxtlevel">Level</label>
				</div>
				<div class="form-group">
					<i class="fa fa-level-down" aria-hidden="true"></i>
					<label for="editslctprogram">Under Program</label>
					<select class="form-control" id="editslctprogram">
					</select>
				</div>
				<div class="form-group" id="editstatus">
					<i class="fa fa-info" aria-hidden="true"></i>
					<label for="editslctstatus">Status for Input</label>
					<select class="form-control" id="editslctstatus">
						<option value="Active">Active</option>
						<option value="Inactive">Inactive</option>
					</select>
				</div>
				<div class="form-group">
					<i class="fa fa-info" aria-hidden="true"></i>
					<label for="editslctstate">State</label>
					<select class="form-control" id="editslctstate">
						<option value="Active">Active</option>
						<option value="Inactive">Inactive</option>
					</select>
				</div>
            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-warning" onclick="editprogram()">Update</button>
                <button type="button" class="btn btn-outline-warning waves-effect" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
