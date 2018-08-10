<?php
    session_start();
    include '../../../../php/checksession.php';
    include '../../../../php/checkaccount.php';
    include '../../php/print.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
		<title>
		    <?php
                if($print == "report"){
                    echo "Targets and Accomplishments";
                }
                else if($print == "performance"){
                    echo "Performance";
                }
                else if($print == "target"){
                    echo "Targets";
                }
                else if($print == "accomplish"){
                    echo "Accomplishments";
                }
                else if($print == "assign"){
                    echo "Assigned Personnel";
                }
                else if($print == "percent"){
                    echo "Percentage";
                }
                else if($print == "monthlyreport"){
                    echo "Monthly Report";
                }
                else if($print == "opcr"){
                    echo "OPCR";
                }
                else if($print == "ipcr"){
                    echo "IPCR";
                }
            ?>
		</title>
        <link rel="icon" href="../../../../img/custom/CHED LOGO WITH WHITE BACKGROUND.png" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="../../../../css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="../../../../css/mdb.css" />
		<link rel="stylesheet" type="text/css" href="../../../../css/font-awesome.css" />
		<link rel="stylesheet" type="text/css" href="../../../../css/style.css" />
	</head>
	<body class="grey lighten-4">
	    <div>
	        <p class="h3-responsive text-center">
	            <?php
                    if($print == "report"){
                        echo "Targets and Performance";
                    }
                    else if($print == "performance"){
                        echo "Performance";
                    }
                ?>
	        </p>
	    </div>
        <?php
            if($print == "opcr" || $print == 'ipcr'){
                echo 
                '<div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="text-center h1-responsive">OFFICE PERFORMANCE COMMITMENT REVIEW (OPCR) FORM</p>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="h6-responsive">I, <span class="h6"><u>JUANITO R. DEMETRIO, DPA, CESO III</u></span>, of CHED Regional Office 9 commits to deliver and agrees to be rated in the attainment of the targets in accordance with the indicated measures for the period <span class="h6"><u>JANUARY to DECEMBER, '.$year.'</u></span></p><br><br>
                            <div class="offset-7 text-center">
                                <p><span class="h6"><u>JUANITO R. DEMETRIO, DPA, CESO III</u></span><br>DIRECTOR IV</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-bordered">
                            <thead class="mdb-color darken-3 white-text text-center">
                                <tr><th>Reviewed by:</th>
                                <th>Date</th>
                                <th>Approved by:</th>
                                <th>Date</th><tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td><br><u>ATTY. JULIO D. VITRIOLO</u><br>EXECUTIVE DIRECTOR</td>
                                    <td></td>
                                    <td><br><u>DR. PATRICIA B. LICUANAN</u><br>CHAIRPERSON</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>';
            }
        ?>
		<div class="container-fluid">
			<div class="row">
				<table id="tblprint" class="table table-bordered">
				<?php echo $output;  ?>
				</table>
			</div>
        </div>
        <div class="container-fluid">
            <?php
                if($print == "opcr" || $print == 'ipcr'){
                    echo $output2;
                }
            ?>
        </div>
        <?php
            if($print == "opcr" || $print == "ipcr"){
                echo 
                '<div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered">
                                <thead class="mdb-color darken-3 white-text text-center">
                                    <tr>
                                        <th></th>
                                        <th>Date</th>
                                        <th></th>
                                        <th>Date</th>
                                        <th>Final Rating by:</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><br><br></td>
                                        <td><br><br></td>
                                        <td><br><br></td>
                                        <td><br><br></td>
                                        <td><br><br></td>
                                        <td><br><br></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered">
                                <thead class="mdb-color darken-3 white-text text-center">
                                    <tr><th>Legend</th></tr>
                                </thead>
                                <tbody>
                                    <tr><td><p><b>1 - Effectiveness/Quality</b>: The extent to which actual performance compares with targeted performance (can be measured by quantity) . The degree to which objectives are achieved and the extent to which targeted problems are solved. In management, effectiveness relates to getting the right things done.</p></td></tr>
                                    <tr><td><p><b>2 - Efficiency</b>: The extent to which time or resources is used for the intended task or purpose. Measures whether targets are accomplished with a minimum amount or quantity of waste, expense,  or unnecessary effort.</p></td></tr>
                                    <tr><td><p><b>3 - Timeliness</b>: Measures whether the deliverable was done on time based on the requirements of the law and/or clients/stakeholders. Time-related performance indicators evaluate such things as project completion deadlines, time management skills, and other time-sensitive expectations.</p></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered">
                                <thead class="mdb-color darken-3 white-text text-center">
                                    <tr><th colspan="3">Rating Scale</th></tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">5</td>
                                        <td class="text-center">Outstanding</td>
                                        <td><p>Performance represents an extraordinary level of achievement and commitment in terms of quality and time, technical skills and knowledge, ingenuity, creativity, and initiative. Employees at this performance level should have demonstrated exceptional job mastery in all major areas of responsibility. Employee achievement and contributions to the organization are of marked excellence.</p></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">4</td>
                                        <td class="text-center">Very Satisfactory</td>
                                        <td><p>Performance succeeded expectations. All goals, objectives, and targets were achieved above the established standards.</p></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">3</td>
                                        <td class="text-center">Satisfactory</td>
                                        <td><p>Performance met expectations in terms of quality of work, efficiency, and timeliness. The most critical annual goals were met.</p></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <td class="text-center">Unsatisfactory</td>
                                        <td><p>Performance failed to meet expectations, and/or one or more  of the most critical goals were not met.</p></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td class="text-center">Poor</td>
                                        <td><p>Performance was consistently below expectations, and/or reasonable progress toward critical goals was not made. Significant improvement is needed in one or more important areas.</p></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>';
            }
        ?>
	</body>
	<script type="text/javascript" src="../../../../js/mdb/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="../../../../js/mdb/mdb.js"></script>
	<script type="text/javascript" src="../../../../js/mdb/bootstrap.js"></script>
	<script type="text/javascript" src="../../../../js/mdb/popper.min.js"></script>
</html>
<script>
    $(document).ready(function(){
        window.print();
    })
</script>
