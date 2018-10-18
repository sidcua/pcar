<?php  
	session_start();
	include '../../../php/connect.php';
	$action = $_POST['action'];

	function fetchdata(){
		$accid = $_SESSION['accID'];
		$output = '';
		$region = $_SESSION['region'];
		if($_SESSION['level'] == 0){
			$sql = mysql_query("SELECT * FROM account ORDER BY name ASC");
		}
		else if($_SESSION['level'] == 1){
			$sql = mysql_query("SELECT * FROM account INNER JOIN region ON account.regionID = region.regionID WHERE levelID = 2 AND acciD != '$accid' ORDER BY name ASC");
		}
		else if($_SESSION['level'] == 2){
			$sql = mysql_query("SELECT * FROM account WHERE regionID = '$region' AND accID != '$accid' AND levelID = 3 OR levelID = 4 ORDER BY name ASC");
		}
		if(mysql_num_rows($sql) == 0){
			$output .= 
			"<tr>
				<td colspan='5'><p class='h1-responsive text-center'>No accounts found</p></td>
			</tr>";
		}
		else{
			while($fetch = mysql_fetch_assoc($sql)){
				$accID = $fetch['accID'];
				$email = $fetch['email'];
				$name = $fetch['name'];
				$position = $fetch['position'];
				$regionid = $fetch['regionID'];
				$levelid = $fetch['levelID'];
                $status = $fetch['status'];
				$output .= '<tr data-id='.$accID.'>
					<td class="email">'.$email.'</td>
					<td width="20%" class="name">'.$name.'</td>
					<td class="position">'.$position.'</td>';
				if($_SESSION['level'] == 1 || $_SESSION['level'] == 2){
					if($regionid != 0){
						$query = mysql_query("SELECT region_code FROM region WHERE regionID = '$regionid'");
						$get = mysql_fetch_assoc($query);
						$output .= '<td class="region">'.$get['region_code'].'</td><td class="regionID" hidden>'.$regionid.'</td>';
					}
					else{
						$output .= '<td class="region">'.$get['region_code'].'</td>';
					}
				}
				else{
					if($regionid != 0){
						$query = mysql_query("SELECT region_code FROM region WHERE regionID = '$regionid'");
						$get = mysql_fetch_assoc($query);
						$output .= '<td class="regionID" hidden>'.$regionid.'</td><td class="region" hidden>'.$get['region_code'].'</td>';
					}
					else{
						$output .= '<td class="regionID" hidden>0</td><td class="region" hidden>'.$get['region_code'].'</td>';
					}
				}
				$output .= '<td class="level" hidden>'.$levelid.'</td>';
				$output .= '<td>';
				if($_SESSION['level'] == 2){
					$output .= '<a><span data-toggle="modal" data-target="#modalassignprogram" class="badge badge-default assignprogram"><i class="fa fa-edit fa-2x" aria-hidden="true"></i></a> ';
				}
				$output .= '<a><span data-toggle="modal" data-target="#modaleditaccount" class="badge badge-warning editaccount"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></i></span></a> ';
                if($status == 1){
                    $output .= '<a><span data-toggle="modal" data-target="#modallockaccount" class="badge badge-danger" style="width: 28.69px;"><i class="fa fa-lock fa-2x" aria-hidden="true"></i></span></a> ';
                }
                else{
                    $output .= '<a><span data-toggle="modal" data-target="#modalunlockaccount" class="badge badge-success"><i class="fa fa-unlock fa-2x" aria-hidden="true"></i></i></i></span></a> ';
                }
                if($_SESSION['level'] < 2){
                    $output .= '<a><span data-toggle="modal" data-target="#modaldeleteaccount" class="badge badge-danger"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></i></i></span></a>';
                }               
                $output .= '</td>';
			}
		}
		return $output;
	}

	if($action == "accountlist"){
		echo json_encode(fetchdata());
	}
	if($action == "addaccount"){
		$name = htmlentities(mysql_escape_string($_POST['name']));
		$email = mysql_escape_string($_POST['email']);
		$position = htmlentities(mysql_escape_string($_POST['position']));
		$slctregion = mysql_escape_string($_POST['region']);
		$slctaccounttype = mysql_escape_string($_POST['accounttype']);
		$sql = mysql_query("SELECT * FROM account WHERE email = '$email'");
		if(mysql_num_rows($sql) > 0){
			$obj['email'] = true;
		}
		else{
			$obj['email'] = false;
		}
		$sql = mysql_query("SELECT * FROM account WHERE name = '$name'");
		if(mysql_num_rows($sql) != 0){
			$obj['name'] = true;
		}
		else{
			$obj['name'] = false;
		}
		if($obj['email'] == false && $obj['name'] == false){
			$password = sha1(md5($email));
			if($_SESSION['level'] == 0){
				if($slctaccounttype == 1){
					mysql_query("INSERT INTO account (email, password, name, position, regionID, levelID, status) VALUES ('$email', '$password', '$name', '$position', 0, '$slctaccounttype', 1)");
				}
				else {
					mysql_query("INSERT INTO account (email, password, name, position, regionID, levelID, status) VALUES ('$email', '$password', '$name', '$position', $slctregion, '$slctaccounttype', 1)");
				}
			}
			else if($_SESSION['level'] == 1){
				mysql_query("INSERT INTO account (email, password, name, position, regionID, levelID, status) VALUES ('$email', '$password', '$name', '$position', $slctregion, 2, 1)");
			}
			else if($_SESSION['level'] == 2){
				$region = $_SESSION['region'];
				mysql_query("INSERT INTO account (email, password, name, position, regionID, levelID, status) VALUES ('$email', '$password', '$name', '$position', $region, 3, 1)");
			}
		}
		echo json_encode($obj);
	}
	if($action == "deleteaccount"){
		$accid = mysql_escape_string($_POST['accid']);
		mysql_query("DELETE FROM account WHERE accID = '$accid'");
	}
	if($action == "editaccount"){
		$accid = mysql_escape_string($_POST['accid']);
		$name = htmlentities(mysql_escape_string($_POST['name']));
		$email = mysql_escape_string($_POST['email']);
		$position = htmlentities(mysql_escape_string($_POST['position']));
		$slctregion = mysql_escape_string($_POST['region']);
		$slctaccounttype = mysql_escape_string($_POST['accounttype']);
		$sql = mysql_query("SELECT * FROM account WHERE email = '$email' AND accID !='$accid'");
		if(mysql_num_rows($sql) > 0){
			$obj['email'] = true;
		}
		else{
			$obj['email'] = false;
		}
		$sql = mysql_query("SELECT * FROM account WHERE name = '$name' AND accID !='$accid'");
		if(mysql_num_rows($sql) > 0){
			$obj['name'] = true;
		}
		else{
			$obj['name'] = false;
		}
		if($obj['email'] == false && $obj['name'] == false){
			if($_SESSION['level'] == 0){
				if($slctaccounttype == 1){
					mysql_query("UPDATE account SET email = '$email', name = '$name', position = '$position', regionID = 0, levelID = '$slctaccounttype' WHERE accID = '$accid'");
				}
				else if($slctaccounttype == 2){
					mysql_query("UPDATE account SET email = '$email', name = '$name', position = '$position', regionID = '$slctregion', levelID = '$slctaccounttype' WHERE accID = '$accid'");
				}
				else if($slctaccounttype == 3){
					mysql_query("UPDATE account SET email = '$email', name = '$name', position = '$position', regionID = '$slctregion', levelID = '$slctaccounttype' WHERE accID = '$accid'");
				}
			}
			else if($_SESSION['level'] == 1){
				if($slctaccounttype == 1){
					mysql_query("UPDATE account SET email = '$email', name = '$name', position = '$position', regionID = 0, levelID = '$slctaccounttype' WHERE accID = '$accid'");
				}
				else if($slctaccounttype == 2){
					mysql_query("UPDATE account SET email = '$email', name = '$name', position = '$position', regionID = '$slctregion', levelID = '$slctaccounttype' WHERE accID = '$accid'");
				}
				else if($slctaccounttype == 3){
					mysql_query("UPDATE account SET email = '$email', name = '$name', position = '$position', regionID = '$slctregion', levelID = '$slctaccounttype' WHERE accID = '$accid'");
				}
			}
			else if($_SESSION['level'] == 2){
				$region = $_SESSION['region'];
                mysql_query("UPDATE account SET email = '$email', name = '$name', position = '$position' WHERE accID = '$accid'");
			}
		}
		echo json_encode($obj);
	}
	if($action == "loadprogram"){
		$obj['availableprogram'] = "";
		$obj['assignedprogram'] = "";
		$accid = mysql_escape_string($_POST['accid']);
		$level = mysql_escape_string($_POST['level']);
		$reportid = mysql_escape_string($_POST['reportid']);
		if($level > 1){
			$sql = mysql_query("SELECT assign.programID, title FROM assign INNER JOIN program ON assign.programID = program.programID WHERE assign.accID = '$accid' AND program.level = '$level' - 1 AND reportID = '$reportid'");
			while($fetch = mysql_fetch_assoc($sql)){
				$programid = $fetch['programID'];
                $title = $fetch['title'];
				$sql2 = mysql_query("SELECT programID, title FROM program WHERE programID != ALL (SELECT programID FROM assign WHERE accID = '$accid') AND under = '$programid' AND state = 1 AND reportID = '$reportid'");
                if(mysql_num_rows($sql2) != 0){
                    $obj['availableprogram'] .= '<div><i class="fa fa-circle" aria-hidden="true"></i> '.$title.'</div>';
                    while($fetch2 = mysql_fetch_assoc($sql2)){
                        $obj['availableprogram'] .= 
                        '<li id="list'.$fetch2['programID'].'" class="list-group-item d-flex justify-content-between align-items-center">'.$fetch2['title'].'<a><i onclick="assign('.$fetch2['programID'].')" class="fa fa-check text-success" aria-hidden="true"></i></a></li>';
                    }
                    $obj['availableprogram'] .= '<div><hr></div>';
                }
			}
		}
		else{
			$sql = mysql_query("SELECT programID, title FROM program WHERE programID != ALL (SELECT programID FROM assign WHERE accID = '$accid') AND state = 1 AND level = '$level' AND reportID = '$reportid'");
			while($fetch = mysql_fetch_assoc($sql)){
				$programid = $fetch['programID'];
				$title = $fetch['title'];
				$obj['availableprogram'] .=
				'<li id="list'.$programid.'" class="list-group-item d-flex justify-content-between align-items-center">'.$title.'<a><i onclick="assign('.$programid.')" class="fa fa-check text-success" aria-hidden="true"></i></a></li>';
			}
		}
        if($level > 1){
            $sql = mysql_query("SELECT assign.programID, title FROM assign INNER JOIN program ON assign.programID = program.programID WHERE assign.accID = '$accid' AND program.level = '$level' - 1 AND reportID = '$reportid'");
			while($fetch = mysql_fetch_assoc($sql)){
				$programid = $fetch['programID'];
                $title = $fetch['title'];
				$sql2 = mysql_query("SELECT programID, title FROM program WHERE programID = ANY (SELECT programID FROM assign WHERE accID = '$accid') AND under = '$programid' AND state = 1 AND reportID = '$reportid'");
                if(mysql_num_rows($sql2) != 0){
                    $obj['assignedprogram'] .= '<div><i class="fa fa-circle red-text" aria-hidden="true"></i> '.$title.'</div>';
                    while($fetch2 = mysql_fetch_assoc($sql2)){
                        $obj['assignedprogram'] .= 
                        '<li id="list'.$fetch2['programID'].'" class="list-group-item d-flex justify-content-between align-items-center">'.$fetch2['title'].'<a><i onclick="unassign('.$fetch2['programID'].')" class="fa fa-close text-danger" aria-hidden="true"></i></a></li>';
                    }
                    $obj['assignedprogram'] .= '<div><hr></div>';
                }
			}
        }
        else{
            $sql = mysql_query("SELECT assign.programID, title FROM assign INNER JOIN program ON assign.programID = program.programID WHERE assign.accID = '$accid' AND level = '$level' AND reportID = '$reportid'");
            while($fetch = mysql_fetch_assoc($sql)){
                $programid = $fetch['programID'];
                $title = $fetch['title'];
                $obj['assignedprogram'] .=
                '<li id="list'.$programid.'" class="list-group-item d-flex justify-content-between align-items-center">'.$title.'<a><i onclick="unassign('.$programid.')" class="fa fa-close text-danger" aria-hidden="true"></i></a></li>';
            }
        }
		echo json_encode($obj);
	}
	if($action == "assign"){
		$programid = mysql_escape_string($_POST['programid']);
		$accid = mysql_escape_string($_POST['accid']);
		mysql_query("INSERT INTO assign (programID, accID) VALUES ('$programid', '$accid')");
	}
	if($action == "unassign"){
		$programid = mysql_escape_string($_POST['programid']);
		$accid = mysql_escape_string($_POST['accid']);
		mysql_query("DELETE FROM assign WHERE accID = '$accid' AND programID = '$programid'");
	}
	if($action == "loadtab"){
		$sql = mysql_query("SELECT DISTINCT(level) FROM program WHERE state = 1");
		$output = "";
		$flag = 1;
		while($fetch = mysql_fetch_assoc($sql)){
			$level = $fetch['level'];
			$output .=
			'<li class="nav-item">
				<a onclick="loadprogram('.$level.')" class="nav-link';
			if($flag == 1){
				$output .= ' active">';
				$flag = 0;
			}
			else{
				$output .= '">';
			}
			$output .= 
			'Level '.$level.'</a>
			</li> ';
		}
		echo json_encode($output);
	}
	if($action == "changepassword"){
		$old = mysql_escape_string($_POST['old']);
		$new = mysql_escape_string($_POST['new']);
		$accid = $_SESSION['accID'];
		$s_a = 0;
		$sql = mysql_query("SELECT password FROM account WHERE accID = '$accid'");
		if(mysql_num_rows($sql) == 0){
			$sql = mysql_query("SELECT password FROM super_account WHERE accID = '$accid'");
			$s_a = 1;
		}
		$fetch = mysql_fetch_assoc($sql);
		$old = sha1(md5($old));
		if($old != $fetch['password']){
			echo json_encode(false);
		}
		else{
			$new = sha1(md5($new));
			if($s_a == 1){
				mysql_query("UPDATE super_account SET password = '$new' WHERE accID = '$accid'");
			}
			mysql_query("UPDATE account SET password = '$new' WHERE accID = '$accid'");
			echo json_encode(true);
		}
	}
	if($action == "searchaccount"){
		$search = mysql_escape_string($_POST['search']);
		$region = $_SESSION['region'];
		if($_SESSION['level'] == 0){
			$sql = mysql_query("SELECT * FROM account INNER JOIN region ON account.regionID = region.regionID WHERE (levelID = 1 OR levelID = 2) AND (name LIKE '%$search%' OR email LIKE '%$search%' OR position LIKE '%$search%') ORDER BY name ASC");
		}
		else if($_SESSION['level'] == 1){
			$sql = mysql_query("SELECT * FROM account INNER JOIN region ON account.regionID = region.regionID WHERE (levelID = 2 AND acciD != '$accid') AND (name LIKE '%$search%' OR email LIKE '%$search%' OR position LIKE '%$search%') ORDER BY name ASC");
		}
		else if($_SESSION['level'] == 2){
			$sql = mysql_query("SELECT * FROM account WHERE (regionID = '$region' AND accID != '$accid' AND levelID = 3 OR levelID = 4) AND (name LIKE '%$search%' OR email LIKE '%$search%' OR position LIKE '%$search%') ORDER BY name ASC");
		}
		if(mysql_num_rows($sql) == 0){
			if($_SESSION['level'] <= 2){
				$output .= 
				"<tr>
					<td colspan='5'><p class='h1-responsive text-center'>No accounts found</p></td>
				</tr>";
			}
			else{
				$output .=
				"<tr>
					<td colspan='4'><p class='h1-responsive text-center'>No accounts found</p></td>
				</tr>";
			}
		}
		else{
			while($fetch = mysql_fetch_assoc($sql)){
				$accID = $fetch['accID'];
				$email = $fetch['email'];
				$name = $fetch['name'];
                $status = $fetch['status'];
				$position = $fetch['position'];
                $regionid = $fetch['regionID'];
				$output .= '<tr data-id='.$accID.'>
					<td class="email">'.$email.'</td>
					<td width="30%" class="name">'.$name.'</td>
					<td class="position">'.$position.'</td>';
				if($_SESSION['level'] == 1 || $_SESSION['level'] == 2){
					if($regionid != 0){
						$query = mysql_query("SELECT region_code FROM region WHERE regionID = '$regionid'");
						$get = mysql_fetch_assoc($query);
						$output .= '<td class="region">'.$get['region_code'].'</td>';
					}
					else{
						$output .= '<td class="region">'.$get['region_code'].'</td>';
					}
				}
				else{
					if($regionid != 0){
						$query = mysql_query("SELECT region_code FROM region WHERE regionID = '$regionid'");
						$get = mysql_fetch_assoc($query);
						$output .= '<td class="region" hidden>'.$get['region_code'].'</td>';
					}
					else{
						$output .= '<td class="region" hidden>'.$get['region_code'].'</td>';
					}
				}
				$output .= '<td class="level" hidden>'.$levelid.'</td>';
				$output .= '<td>';
				if($_SESSION['level'] == 2){
					$output .= '<a><span data-toggle="modal" data-target="#modalassignprogram" class="badge badge-default assignprogram"><i class="fa fa-edit fa-2x" aria-hidden="true"></i></a> ';
				}
				$output .= '<a><span data-toggle="modal" data-target="#modaleditaccount" class="badge badge-warning editaccount"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></i></span></a> ';
                if($status == 1){
                    $output .= '<a><span data-toggle="modal" data-target="#modallockaccount" class="badge badge-danger"><i class="fa fa-chain fa-2x" aria-hidden="true"></i></span></a> ';
                }
                else{
                    $output .= '<a><span data-toggle="modal" data-target="#modalunlockaccount" class="badge badge-success"><i class="fa fa-unlock fa-2x" aria-hidden="true"></i></i></i></span></a> ';
                }
                if($_SESSION['level'] < 2){
                    $output .= '<a><span data-toggle="modal" data-target="#modaldeleteaccount" class="badge badge-danger"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></i></i></span></a>';
                } 
                $output .= '</td>';
			}
		}	
		echo json_encode($output);
	}
	if($action == "initregion"){
		if($_SESSION['level'] > 1){
			$obj['level'] = false;
		}
		else{
			$sql = mysql_query("SELECT regionID, region_code FROM region ORDER BY region_digit ASC");
			$output = '';
			while($fetch = mysql_fetch_assoc($sql)){
				$regionid = $fetch['regionID'];
				$code = $fetch['region_code'];
				$output .= 
				'<option value="'.$regionid.'">'.$code.'</option>';
			}
			$obj['options'] = $output;
			$obj['level'] = true;
		}
		echo json_encode($obj);
	}
	if($action == "initaccounttype"){
        $sql = mysql_query("SELECT levelID, levelname FROM level WHERE levelID != 0 ORDER BY levelID ASC");
        $output = '';
        while($fetch = mysql_fetch_assoc($sql)){
            $levelid = $fetch['levelID'];
            $name = $fetch['levelname'];
            $output .= '<option value="'.$levelid.'">'.$name.'</option>';
        }
        $obj['options'] = $output;
		if($_SESSION['level'] == 0){
			$obj['level'] = true;
		}
		else{
			$obj['level'] = false;
		}
		echo json_encode($obj);
	}
    if($action == "lockaccount"){
        $accid = mysql_escape_string($_POST['accid']);
        mysql_query("UPDATE account SET status = 0 WHERE accID = '$accid'");
    }
    if($action == "unlockaccount"){
        $accid = mysql_escape_string($_POST['accid']);
        mysql_query("UPDATE account SET status = 1 WHERE accID = '$accid'");
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
