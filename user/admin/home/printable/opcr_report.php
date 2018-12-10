<?php
    session_start();
    include '../../../../php/checksession.php';
    include '../../../../php/checkaccount.php';
    include '../../../../php/connect.php';
    $year = mysql_escape_string($_GET['year']);
    $region = mysql_escape_string($_GET['region']);
    
?>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
		<title>OPCR</title>
        <link rel="icon" href="../../../../img/custom/CHED LOGO WITH WHITE BACKGROUND.png" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="../../../../css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="../../../../css/mdb.css" />
		<link rel="stylesheet" type="text/css" href="../../../../css/font-awesome.css" />
		<link rel="stylesheet" type="text/css" href="../../../../css/style.css" />
	</head>
    <style>
        
    </style>
	<body class="grey lighten-4">
	    <div class="container-fluid">
            <div class="divspace"></div>
            <div class="row">
                <div class="col-sm-12 text-center d-flex justify-content-center">
                    <div class="float-middle" style="margin-top: -25px; margin-left: -50px; margin-right: 20px;">
                        <img src="../../../../img/custom/CHED LOGO WITH WHITE BACKGROUND.png" style="width: 100px; height: 100px;">
                    </div>
                    <div>
                        <p style="line-height: 5px">Republic of the Philippines</p>
                        <p style="line-height: 5px">Office of the Presiden</p>
                        <p style="line-height: 5px">COMMISSION ON HIGHER EDUCATION</p>
                        <p style="line-height: 5px">Region IX, Zamboanga Peninsula</p>
                    </div>
                </div>
            </div>
            <div class="divspace"></div>
            <div class="row">
                <div class="col-sm-10 offset-1">
                    <div class="card p-3 grey lighten-4">
                        <blockquote class="blockquote mb-0 card-body">
                            <p>Office: <b><?php echo $_SESSION['region_code']; ?></b></p>
                            <!-- <footer class="blockquote-footer">
                                <small class="text-muted"><?php echo $_SESSION['position']; ?>
                                <cite title="Source Title"></cite>
                                </small>
                            </footer> -->
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="divspace"></div>
            <div class="row">
                <table class="table table-bordered">
                    <thead class="mdb-color darken-3 table-bordered">
                        <tr class="text-center white-text">
                            <th rowspan="2" style="width: 17%;">Services Programs</th>
                            <th colspan="5">Success Indicators</th>
                            <th rowspan="2" style="width: 10px;">Timelines</th>
                            <th rowspan="2" style="width: 10px;">Weight</th>
                            <th rowspan="2" style="width: 10px;">Person/Unit Responsible</th>
                            <th colspan="5">Actual Accomplishments</th>
                            <th rowspan="2" style="width: 10px;">Rating</th>
                            <th rowspan="2" style="width: 10px;">Remarks</th>
                            <th colspan="8">Quarterly Rating</th>
                        </tr>
                        <tr class="text-center white-text">
                            <th>Q1</th>
                            <th>Q2</th>
                            <th>Q3</th>
                            <th>Q4</th>
                            <th>Total</th>
                            <th>Q1</th>
                            <th>Q2</th>
                            <th>Q3</th>
                            <th>Q4</th>
                            <th>Total</th>
                            <th colspan="2">Q1</th>
                            <th colspan="2">Q2</th>
                            <th colspan="2">Q3</th>
                            <th colspan="2">Q4</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
	</body>
	<script type="text/javascript" src="../../../../js/mdb/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="../../../../js/mdb/mdb.js"></script>
	<script type="text/javascript" src="../../../../js/mdb/bootstrap.js"></script>
	<script type="text/javascript" src="../../../../js/mdb/popper.min.js"></script>
</html>
<script>
    // $(document).ready(function(){
    //     print();
    // })
</script>