<?php  
	session_start();
	include '../../../php/connect.php';
	$action = $_POST['action'];
	if($action == "quarterlygraph"){
		$accid = $_SESSION['accID'];
		$year = mysql_escape_string($_POST['year']);
		$region = mysql_escape_string($_POST['region']);
		$report = mysql_escape_string($_POST['report']);
		$position = $_SESSION['position'];
		if($_SESSION['level'] == 3){
			for ($i = 1; $i <= 4 ; $i++) { 
				$sql = mysql_query("SELECT SUM(target) AS target FROM targetaccomplish INNER JOIN assign ON targetaccomplish.assignID = assign.assignID INNER JOIN program ON assign.programID = program.programID WHERE month = '$i' AND accID = '$accid' AND year = '$year' AND reportID = '$report'");
				$fetch = mysql_fetch_assoc($sql);
				$target = $fetch['target'];
				if($target == ""){
					$target = 0;
				}
				$obj[1][$i] = $target;
			}
			for ($i = 1; $i <= 4 ; $i++) { 
				$sql = mysql_query("SELECT SUM(accomplish) AS accomplish FROM targetaccomplish INNER JOIN assign ON targetaccomplish.assignID = assign.assignID INNER JOIN program ON assign.programID = program.programID WHERE month = '$i' AND accID = '$accid' AND year = '$year' AND reportID = '$report'");
				$fetch = mysql_fetch_assoc($sql);
				$accomplish = $fetch['accomplish'];
				if($accomplish == ""){
					$accomplish = 0;
				}
				$obj[2][$i] = $accomplish;
			}
			$obj['success'] = true;
		}
		else{
			$obj['success'] = false;
		}
		echo json_encode($obj);
	}
	if($action == "quarterlygraph_office"){
		$year = mysql_escape_string($_POST['year']);
		$region = mysql_escape_string($_POST['region']);
		$report = mysql_escape_string($_POST['report']);
        if($region != 0){
            $sub = " AND regionID = ".$region;
        }
		for ($i = 1; $i <= 4 ; $i++) { 
			$sql = mysql_query("SELECT SUM(target) AS target FROM targetaccomplish INNER JOIN assign ON targetaccomplish.assignID = assign.assignID INNER JOIN account ON assign.accID = account.accID INNER JOIN program ON assign.programID = program.programID WHERE month = '$i' AND year = '$year' AND reportID = '$report'".$sub);
			$fetch = mysql_fetch_assoc($sql);
			$target = $fetch['target'];
			if($target == ""){
				$target = 0;
			}
			$obj[1][$i] = $target;
		}
		for ($i = 1; $i <= 4 ; $i++) { 
			$sql = mysql_query("SELECT SUM(accomplish) AS accomplish FROM targetaccomplish INNER JOIN assign ON targetaccomplish.assignID = assign.assignID INNER JOIN account ON assign.accID = account.accID INNER JOIN program ON assign.programID = program.programID WHERE month = '$i' AND year = '$year' AND reportID = '$report'".$sub);
			$fetch = mysql_fetch_assoc($sql);
			$accomplish = $fetch['accomplish'];
			if($accomplish == ""){
				$accomplish = 0;
			}
			$obj[2][$i] = $accomplish;
		}
		echo json_encode($obj);
	}
	if($action == "inityear"){
		$latest = date('Y');
		for ($i = $latest; $i >= 2014 ; $i--) { 
			$output .= '<option value="'.$i.'">'.$i.'</option>';
		}
		echo json_encode($output);
	}
    if($action == "initregion"){
        $sql = mysql_query("SELECT regionID, region_code FROM region ORDER BY region_digit ASC");
        $obj['options'] .= '<option value="0">All</td>';
        while($fetch = mysql_fetch_assoc($sql)){
            $regionid = $fetch['regionID'];
            $region = $fetch['region_code'];
            $obj['options'] .= '<option value="'.$regionid.'">'.$region.'</option>';
        }
        if($_SESSION['region'] < 2){
            $obj['level'] = true;
        }
        else{
            $obj['level'] = false;
        }
        echo json_encode($obj);
	}
	if($action == "initreport"){
		$sql = mysql_query("SELECT * FROM report WHERE status = 1");
		while($fetch = mysql_fetch_assoc($sql)){
			$reportid = $fetch['reportID'];
			$report = $fetch['report'];
			$output .= '<option value="'.$reportid.'">'.$report.'</option>';
		}
		echo json_encode($output);
	}
?>