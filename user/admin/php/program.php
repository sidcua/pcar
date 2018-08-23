<?php  
	session_start();
	include '../../../php/connect.php';
	$action = $_POST['action'];
    function checkprogram_assign($programid){
        $region = $_SESSION['region'];
        $sql = mysql_query("SELECT assignID FROM assign INNER JOIN account ON assign.accID = account.accID WHERE programID = '$programid' AND regionID = '$region'");
        if(mysql_num_rows($sql) != 0){
            return true;
        }
        else{
            return false;
        }
    }
    if($action == "programlist"){
        $reportid = mysql_escape_string($_POST['reportid']);
        $output .= "";
	   // level 1
        $sql = mysql_query("SELECT * FROM program WHERE level = 1 AND state = 1 AND reportID = '$reportid' ORDER BY level ASC");
        while($fetch = mysql_fetch_assoc($sql)){
            $programid = $fetch['programID'];
            $title = $fetch['title'];
            $under = $fetch['under'];
            $level = $fetch['level'];
            $status = $fetch['status'];
            $state = $fetch['state'];
            if($status == 1){
                $status = "Active";
            }
            else{
                $status = "Inactive";
            }
            if($state == 1){
                $state = "Active";
            }
            else{
                $state = "Inactive";
            }
            $output .= '<tr ';
            if($_SESSION['level'] == 2){
                if(checkprogram_assign($programid) == false){
                    $output .= 'class="red lighten-4" ';
                }
            }
            $output .= 'data-id="'.$programid.'">
            <td class="under" hidden>'.$under.'</td>
            <td class="level" hidden>'.$level.'</td>
            <td width="70%" class="title">'.$title.'</td>
            <td class="status">'.$status.'</td>
            <td class="state">'.$state.'</td>'; 
            if($_SESSION['level'] < 2){
                $output .= 
                '<td><a><span data-toggle="modal" data-target="#modaleditprogram" class="badge badge-warning editprogram"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></span></a> <a><span data-toggle="modal" data-target="#modaldeleteprogram" class="badge badge-danger"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></i></i></span></a></td>';
            }
            $output .= '</tr>';
            // level 2
            $sql2 = mysql_query("SELECT * FROM program WHERE under = '$programid' AND state = 1 AND reportID = '$reportid'");
            if(mysql_num_rows($sql2) != 0){
                while($fetch2 = mysql_fetch_assoc($sql2)){
                    $programid = $fetch2['programID'];
                    $title = $fetch2['title'];
                    $under = $fetch2['under'];
                    $level = $fetch2['level'];
                    $status = $fetch2['status'];
                    $state = $fetch2['state'];
                    if($status == 1){
                        $status = "Active";
                    }
                    else{
                        $status = "Inactive";
                    }
                    if($state == 1){
                        $state = "Active";
                    }
                    else{
                        $state = "Inactive";
                    }
                    $output .= '<tr ';
                    if($_SESSION['level'] == 2){
                        if(checkprogram_assign($programid) == false){
                            $output .= 'class="red lighten-4" ';
                        }
                    }
                    $output .= 'data-id="'.$programid.'">
                    <td class="under" hidden>'.$under.'</td>
                    <td class="level" hidden>'.$level.'</td>
                    <td width="70%" class="title" style="padding-left: 20px;">'.$title.'</td>
                    <td class="status">'.$status.'</td>
                    <td class="state">'.$state.'</td>'; 
                    if($_SESSION['level'] < 2){
                        $output .= 
                        '<td><a><span data-toggle="modal" data-target="#modaleditprogram" class="badge badge-warning editprogram"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></span></a> <a><span data-toggle="modal" data-target="#modaldeleteprogram" class="badge badge-danger"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></i></i></span></a></td>';
                    }
                    $output .= '</tr>';
                    // level 3
                    $sql3 = mysql_query("SELECT * FROM program WHERE under = '$programid' AND state = 1 AND reportID = '$reportid'");
                    if(mysql_num_rows($sql3) != 0){
                        while($fetch3 = mysql_fetch_assoc($sql3)){
                            $programid = $fetch3['programID'];
                            $title = $fetch3['title'];
                            $under = $fetch3['under'];
                            $level = $fetch3['level'];
                            $status = $fetch3['status'];
                            $state = $fetch3['state'];
                            if($status == 1){
                                $status = "Active";
                            }
                            else{
                                $status = "Inactive";
                            }
                            if($state == 1){
                                $state = "Active";
                            }
                            else{
                                $state = "Inactive";
                            }
                            $output .= '<tr ';
                            if($_SESSION['level'] == 2){
                                if(checkprogram_assign($programid) == false){
                                    $output .= 'class="red lighten-4" ';
                                }
                            }
                            $output .= 'data-id="'.$programid.'">
                            <td class="under" hidden>'.$under.'</td>
                            <td class="level" hidden>'.$level.'</td>
                            <td width="70%" class="title" style="padding-left: 40px;">'.$title.'</td>
                            <td class="status">'.$status.'</td>
                            <td class="state">'.$state.'</td>'; 
                            if($_SESSION['level'] < 2){
                                $output .= 
                                '<td><a><span data-toggle="modal" data-target="#modaleditprogram" class="badge badge-warning editprogram"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></span></a> <a><span data-toggle="modal" data-target="#modaldeleteprogram" class="badge badge-danger"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></i></i></span></a></td>';
                            }
                            $output .= '</tr>';
                                // level 4
                            $sql4 = mysql_query("SELECT * FROM program WHERE under = '$programid' AND state = 1 AND reportID = '$reportid'");
                            if(mysql_num_rows($sql4) != 0){
                                while($fetch4 = mysql_fetch_assoc($sql4)){
                                    $programid = $fetch4['programID'];
                                    $title = $fetch4['title'];
                                    $under = $fetch4['under'];
                                    $level = $fetch4['level'];
                                    $status = $fetch4['status'];
                                    $state = $fetch4['state'];
                                    if($status == 1){
                                        $status = "Active";
                                    }
                                    else{
                                        $status = "Inactive";
                                    }
                                    if($state == 1){
                                        $state = "Active";
                                    }
                                    else{
                                        $state = "Inactive";
                                    }
                                    $output .= '<tr ';
                                    if($_SESSION['level'] == 2){
                                        if(checkprogram_assign($programid) == false){
                                            $output .= 'class="red lighten-4" ';
                                        }
                                    }
                                    $output .= 'data-id="'.$programid.'">
                                    <td class="under" hidden>'.$under.'</td>
                                    <td class="level" hidden>'.$level.'</td>
                                    <td width="70%" class="title" style="padding-left: 60px;">'.$title.'</
                                    <td></td>
                                    <td class="status">'.$status.'</td>
                                    <td class="state">'.$state.'</td>'; 
                                    if($_SESSION['level'] < 2){
                                        $output .= 
                                        '<td><a><span data-toggle="modal" data-target="#modaleditprogram" class="badge badge-warning editprogram"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></span></a> <a><span data-toggle="modal" data-target="#modaldeleteprogram" class="badge badge-danger"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></i></i></span></a></td>';
                                    }
                                    $output .= '</tr>';
                                    //level 5
                                    $sql5 = mysql_query("SELECT * FROM program WHERE under = '$programid' AND state = 1 AND reportID = '$reportid'");
                                    if(mysql_num_rows($sql5) != 0){
                                        while($fetch5 = mysql_fetch_assoc($sql5)){
                                            $programid = $fetch5['programID'];
                                            $title = $fetch5['title'];
                                            $under = $fetch5['under'];
                                            $level = $fetch5['level'];
                                            $status = $fetch5['status'];
                                            $state = $fetch5['state'];
                                            if($status == 1){
                                                $status = "Active";
                                            }
                                            else{
                                                $status = "Inactive";
                                            }
                                            if($state == 1){
                                                $state = "Active";
                                            }
                                            else{
                                                $state = "Inactive";
                                            }
                                            $output .= '<tr ';
                                            if($_SESSION['level'] == 2){
                                                if(checkprogram_assign($programid) == false){
                                                    $output .= 'class="red lighten-4" ';
                                                }
                                            }
                                            $output .= 'data-id="'.$programid.'">
                                            <td class="under" hidden>'.$under.'</td>
                                            <td class="level" hidden>'.$level.'</td>
                                            <td width="70%" class="title" style="padding-left: 80px;">'.$title.'</td>
                                            <td class="status">'.$status.'</td>
                                            <td class="state">'.$state.'</td>'; 
                                            if($_SESSION['level'] < 2){
                                                $output .= 
                                                '<td><a><span data-toggle="modal" data-target="#modaleditprogram" class="badge badge-warning editprogram"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></span></a> <a><span data-toggle="modal" data-target="#modaldeleteprogram" class="badge badge-danger"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></i></i></span></a></td>';
                                            }
                                            $output .= '</tr>';
                                            //level 6
                                            $sql6 = mysql_query("SELECT * FROM program WHERE under = '$programid' AND state = 1 AND reportID = '$reportid'");
                                            if(mysql_num_rows($sql6) != 0){
                                                while($fetch6 = mysql_fetch_assoc($sql6)){
                                                    $programid = $fetch6['programID'];
                                                    $title = $fetch6['title'];
                                                    $under = $fetch6['under'];
                                                    $level = $fetch6['level'];
                                                    $status = $fetch6['status'];
                                                    $state = $fetch6['state'];
                                                    if($status == 1){
                                                        $status = "Active";
                                                    }
                                                    else{
                                                        $status = "Inactive";
                                                    }
                                                    if($state == 1){
                                                        $state = "Active";
                                                    }
                                                    else{
                                                        $state = "Inactive";
                                                    }
                                                    $output .= '<tr ';
                                                    if($_SESSION['level'] == 2){
                                                        if(checkprogram_assign($programid) == false){
                                                            $output .= 'class="red lighten-4" ';
                                                        }
                                                    }
                                                    $output .= 'data-id="'.$programid.'">
                                                    <td class="under" hidden>'.$under.'</td>
                                                    <td class="level" hidden>'.$level.'</td>
                                                    <td width="70%" class="title" style="padding-left: 100px;">'.$title.'</td>
                                                    <td class="status">'.$status.'</td>
                                                    <td class="state">'.$state.'</td>'; 
                                                    if($_SESSION['level'] < 2){
                                                        $output .= 
                                                        '<td><a><span data-toggle="modal" data-target="#modaleditprogram" class="badge badge-warning editprogram"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></span></a> <a><span data-toggle="modal" data-target="#modaldeleteprogram" class="badge badge-danger"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></i></i></span></a></td>';
                                                    }
                                                    $output .= '</tr>';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }	
                }
            }
        }
    echo json_encode($output);
    }
	if($action == "addprogram"){
		$title = htmlentities(mysql_escape_string($_POST['title']));
		$level = mysql_escape_string($_POST['level']);
		$under = mysql_escape_string($_POST['under']);
		$status = mysql_escape_string($_POST['status']);
		$state = mysql_escape_string($_POST['state']);
		if($status == "Active"){
			$status = 1;
		}
		else{
			$status = 0;
		}
		if($state == "Active"){
			$state = 1;
		}
		else{
			$state = 0;
		}
		if($under == ""){
			$under = 0;
		}
		mysql_query("INSERT INTO program (title, level, under, status, state, percentage) VALUES ('$title', '$level', '$under', '$status', '$state', '0')");
	}
	if($action == "selectprogram"){
		$level = mysql_escape_string($_POST['level']) - 1;
		$output = "";
		$sql = mysql_query("SELECT programID, title FROM program WHERE level = '$level'");
		if(mysql_num_rows($sql) != 0){
			while($fetch = mysql_fetch_assoc($sql)){
				$programid = $fetch['programID'];
				$title = $fetch['title'];
				$output .= 
				'<option value="'.$programid.'">'.$title.'</option>';
			}
		}
		echo json_encode($output);
	}
	if($action == "deleteprogram"){
		$programid = mysql_escape_string($_POST['programid']);
		mysql_query("DELETE FROM program WHERE programID = '$programid'");
	}
	if($action == "editprogram"){
		$programid = mysql_escape_string($_POST['programid']);
		$title = htmlentities(mysql_escape_string($_POST['title']));
		$under = mysql_escape_string($_POST['under']);
		$status = mysql_escape_string($_POST['status']);
		$level = mysql_escape_string($_POST['level']);
		$state = mysql_escape_string($_POST['state']);
		if($status == "Active"){
			$status = 1;
		}
		else{
			$status = 0;
		}
		if($state == "Active"){
			$state = 1;
		}
		else{
			$state = 0;
		}
		if($under == ""){
			$under = 0;
		}
		$sql = mysql_query("SELECT programID FROM account WHERE title = '$title' AND programID != '$programid' ");
		if(mysql_num_rows($sql) > 0){
			echo json_encode(true);
		}
		else{
			mysql_query("UPDATE program SET title = '$title', under = '$under', status = '$status', level = '$level', state = '$state' WHERE programID = '$programid'");
			echo json_encode(false);
		}
	}
	if($action == "editselectprogram"){
		$level = mysql_escape_string($_POST['level']) - 1;
		$output = "";
		$sql = mysql_query("SELECT programID, title FROM program WHERE level = '$level'");
		if(mysql_num_rows($sql) != 0){
			while($fetch = mysql_fetch_assoc($sql)){
				$programid = $fetch['programID'];
				$title = $fetch['title'];
				$output .= 
				'<option value="'.$programid.'">'.$title.'</option>';
			}
		}
		echo json_encode($output);
	}
	if($action == "searchprogram"){
		$output = '';
		$search = mysql_escape_string($_POST['search']);
		$sql = mysql_query("SELECT * FROM program WHERE title LIKE '%$search%' ORDER BY level ASC");
		if(mysql_num_rows($sql) == 0){
			$output .= 
			"<tr>
				<td colspan='6'><p class='h1-responsive text-center'>No Programs/Projects found</p></td>
			</tr>";
		}
		else{
			while($fetch = mysql_fetch_assoc($sql)){
				$programid = $fetch['programID'];
				$title = $fetch['title'];
				$under = $fetch['under'];
				$level = $fetch['level'];
				$status = $fetch['status'];
				$state = $fetch['state'];
				if($status == 1){
					$status = "Active";
				}
				else{
					$status = "Inactive";
				}
				if($state == 1){
					$state = "Active";
				}
				else{
					$state = "Inactive";
				}
				if($under != 0){
					$sql2 = mysql_query("SELECT title FROM program WHERE programID = '$under'");
					$fetch2 = mysql_fetch_assoc($sql2);
					$under = $fetch2['title'];
				}
				else{
					$under = "";
				}
				$check = mysql_query("SELECT assignID FROM assign INNER JOIN account ON assign.accID = account.accID WHERE programID = '$programid' AND regionID = '$region'");
				$output .= '<tr ';
				if($_SESSION['level'] == 2){
                    if(checkprogram_assign($programid) == false){
                        $output .= 'class="red lighten-4" ';
                    }
                }
				$output .= 'data-id='.$programid.'>
					<td width="70%" class="title">'.$title.'</td>
					<td class="under" hidden>'.$underid .'</td>
					<td class="under" hidden>'.$under.'</td>
					<td class="level" hidden>'.$level.'</td>
					<td class="status">'.$status.'</td>
					<td class="state">'.$state.'</td>';
				if($_SESSION['level'] < 2){
					$output .= 
					'<td><a><span data-toggle="modal" data-target="#modaleditprogram" class="badge badge-warning editprogram"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></span></a> <a><span data-toggle="modal" data-target="#modaldeleteprogram" class="badge badge-danger"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></i></i></span></a></td>';
				}
			}
		}
		echo json_encode($output);
	}
?>