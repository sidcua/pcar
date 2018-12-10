<?php 
	session_start();
    include 'php/checksession.php';
    include 'php/checkaccount2.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
		<title>Notice</title>
        <link rel="icon" href="img/custom/CHED LOGO WITH WHITE BACKGROUND.png" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="css/mdb.css" />
		<link rel="stylesheet" type="text/css" href="css/font-awesome.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
    <header>
            <nav class="navbar navbar-expand-lg navbar-dark primary-color">
                <img src="img/custom/chedlogo2.png" style="height: 40px; margin-left: -20px;">
                <a class="navbar-brand" href="." style="margin-left: -10px;"><strong>CHED PCAR - <?php if($_SESSION['level'] == 0){echo "Developer";} else if($_SESSION['level'] == 1){echo "Central Office";} else if($_SESSION['level'] == 2){echo "Regional Office";} else if($_SESSION['level'] == 3){echo "Personnel";}?></strong></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent"> 
                    <ul class="navbar-nav nav-flex-icons ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i>
                            <?php
                                echo $_SESSION['name'];
                            ?>
                            </a>    
                            <div class="dropdown-menu dropdown-menu-right dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="php/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
	<body class="grey lighten-4">
		<div class="container">
			<div class="jumbotron grey lighten-5" style="margin-top: 100px; margin-bottom: 200px;">
                <h1 class="h1-responsive">Dear <?php echo $_SESSION['name']; ?></h1>
                <p class="lead">Your account has been lockded by the Adminstrator.</p>
                <hr class="my-2">
                <p>Please contact your <?php if($_SESSION['level'] == 1){echo "Developer";} else if($_SESSION['level'] == 2){echo "Central";} else if($_SESSION['level'] == 3){echo "Regional";} ?> administrator for more information and concerns.
                </p>
                <a href="php/logout.php" class="btn btn-primary btn-lg" role="button">Logout</a>
            </div>
		</div>
	</body>
    <footer class="page-footer font-small primary-color pt-4">

    <!--Footer Links-->
        <div class="container-fluid" style="height: 100px;">
            <div class="row">

                <!--First column-->
                <div class="col-md-6">
                    <h5 class="title"></h5>
                    <p></p>
                </div>
                <!--/.First column-->

                <!--Second column-->
                <div class="col-md-6">
                    
                </div>
                <!--/.Second column-->
            </div>
        </div>
        <!--/.Footer Links-->

        <!--Copyright-->
        <div class="footer-copyright">
            <div class="footer-copyright text-center py-3">© 2018 Copyright:
                <a href="."> pcar.chedro9.com</a>
            </div>
        </div>
        <!--/.Copyright-->
        </footer>
	<script type="text/javascript" src="js/mdb/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="js/mdb/mdb.js"></script>
	<script type="text/javascript" src="js/mdb/bootstrap.js"></script>
	<script type="text/javascript" src="js/mdb/popper.min.js"></script>
</html>
