<?php  
	session_start();
	include '../../../php/connect.php';
	$action = $_POST['action'];
	if($action == "quarterlygraph"){
		$accid = $_SESSION['accID'];
		$year = mysql_escape_string($_POST['year']);
        $region = mysql_escape_string($_POST['region']);
		$position = $_SESSION['position'];
		$limit = 3;
		if($_SESSION['level'] == 3){
			for ($i = 1; $i <= 12 ; $i = $i + 3) { 
				$sql = mysql_query("SELECT SUM(target) AS target FROM targetaccomplish INNER JOIN assign ON targetaccomplish.assignID = assign.assignID WHERE month >= '$i' AND month <= '$limit' AND accID = '$accid' AND year = '$year'");
				$fetch = mysql_fetch_assoc($sql);
				$target = $fetch['target'];
				if($target == ""){
					$target = 0;
				}
				$obj[1][$i] = $target;
				$limit = $limit + 3;
			}
			$limit = 3;
			for ($i = 1; $i <= 12 ; $i = $i + 3) { 
				$sql = mysql_query("SELECT SUM(accomplish) AS accomplish FROM targetaccomplish INNER JOIN assign ON targetaccomplish.assignID = assign.assignID WHERE month >= '$i' AND month <= '$limit' AND accID = '$accid' AND year = '$year'");
				$fetch = mysql_fetch_assoc($sql);
				$accomplish = $fetch['accomplish'];
				if($accomplish == ""){
					$accomplish = 0;
				}
				$obj[2][$i] = $accomplish;
				$limit = $limit + 3;
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
        if($region != 0){
            $sub = " AND regionID = ".$region;
        }
		$limit = 3;
		for ($i = 1; $i <= 12 ; $i = $i + 3) { 
			$sql = mysql_query("SELECT SUM(target) AS target FROM targetaccomplish INNER JOIN assign ON targetaccomplish.assignID = assign.assignID INNER JOIN account ON assign.accID = account.accID WHERE month >= '$i' AND month <= '$limit' AND year = '$year'".$sub);
			$fetch = mysql_fetch_assoc($sql);
			$target = $fetch['target'];
			if($target == ""){
				$target = 0;
			}
			$obj[1][$i] = $target;
			$limit = $limit + 3;
		}
		$limit = 3;
		for ($i = 1; $i <= 12 ; $i = $i + 3) { 
			$sql = mysql_query("SELECT SUM(accomplish) AS accomplish FROM targetaccomplish INNER JOIN assign ON targetaccomplish.assignID = assign.assignID INNER JOIN account ON assign.accID = account.accID WHERE month >= '$i' AND month <= '$limit' AND year = '$year'".$sub);
			$fetch = mysql_fetch_assoc($sql);
			$accomplish = $fetch['accomplish'];
			if($accomplish == ""){
				$accomplish = 0;
			}
			$obj[2][$i] = $accomplish;
			$limit = $limit + 3;
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
            $obj['options'] .= '<option value="'.$regionid.'">'.$region.'</td>';
        }
        if($_SESSION['region'] < 2){
            $obj['level'] = true;
        }
        else{
            $obj['level'] = false;
        }
        echo json_encode($obj);
    }
?>