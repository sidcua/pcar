<?php  
	session_start();
	include '../../../php/connect.php';
	$action = $_POST['action'];
	function arrangeprogram($year, $reportid){
		$accid = $_SESSION['accID'];
		$output = "";
        $sql = mysql_query("SELECT target FROM locked WHERE year = '$year'");
        if(mysql_num_rows($sql) == 0){
            $input = true;
        }
        else{
            $fetch = mysql_fetch_assoc($sql);
            if($fetch['target'] == 1){
                $input = false;
            }
            else{
                $input = true;
            }
        }
        //level 1
        $sql = mysql_query("SELECT assignID, program.programID AS programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE accID = '$accid' AND level = 1 AND reportID = '$reportid' ORDER BY title ASC");
        if(mysql_num_rows($sql) != 0){
            while($fetch = mysql_fetch_assoc($sql)){
                $programid = $fetch['programID'];
				$assignid = $fetch['assignID'];
				$title = $fetch['title'];
                $status = $fetch['status'];
				$output .= 
				'<tr id="assign'.$assignid.'">
					<td for="title">'.$title.'</td>';
				if($status == 0){
					$output .= 
					'<td colspan="13" class="grey lighten-2"></td>';
				}
				else{
					for ($i = 1; $i <= 12 ; $i++) { 
						switch($i){
							case 1:
								$output .= '<td class="text-center q1-'.$assignid.'">';
								break;
							case 2:
								$output .= '<td class="text-center q2-'.$assignid.'">';
								break;
							case 3:
								$output .= '<td class="text-center q3-'.$assignid.'">';
								break;
							case 4:
								$output .= '<td class="text-center q4-'.$assignid.'">';
								break;
						}
                        $sql_target = mysql_query("SELECT target FROM targetaccomplish WHERE assignID = '$assignid' AND month = '$i' AND year = '$year'");
						if(mysql_num_rows($sql_target) != 0){
							$fetch = mysql_fetch_assoc($sql_target);
							if($fetch['target'] != 0){
								$output .= $fetch['target'];
							}
							else{
								$output .= "-";
							}
						}
						$output .= '</td>';
                    }
                    $sql_remark = mysql_query("SELECT remark FROM targetaccomplish WHERE assignID = '$assignid' AND year = '$year'");
                    $fetch_remark = mysql_fetch_assoc($sql_remark);
                    $output .= '<td class="remark-'.$assignid.'">'.$fetch_remark['remark'].'</td>';
                    if($input == true){
                        $output .= '<td for="action" id="actionassign'.$assignid.'"><a><span onclick="editvalues('.$assignid.')" class="badge badge-default"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></a></td>';
                    }
                    else{
                        $output .= '<td></td>';
                    }
                }
                $output .= '</tr>';
                //level 2
                $sql2 = mysql_query("SELECT assignID, program.programID AS programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE accID = '$accid' AND under = '$programid' AND reportID = '$reportid' ORDER BY title ASC");
                if(mysql_num_rows($sql2) != 0){
                    while($fetch2 = mysql_fetch_assoc($sql2)){
                        $programid = $fetch2['programID'];
                        $assignid = $fetch2['assignID'];
                        $title = $fetch2['title'];
                        $status = $fetch2['status'];
                        $output .= 
                        '<tr id="assign'.$assignid.'">
                            <td for="title" style="padding-left: 20px;">'.$title.'</td>';
                        if($status == 0){
                            $output .= 
                            '<td colspan="13" class="grey lighten-2"></td>';
                        }
                        else{
                            for ($i = 1; $i <= 12 ; $i++) { 
                                switch($i){
                                    case 1:
                                        $output .= '<td class="text-center q1-'.$assignid.'">';
                                        break;
                                    case 2:
                                        $output .= '<td class="text-center q2-'.$assignid.'">';
                                        break;
                                    case 3:
                                        $output .= '<td class="text-center q3-'.$assignid.'">';
                                        break;
                                    case 4:
                                        $output .= '<td class="text-center q4-'.$assignid.'">';
                                        break;
                                }
                                $sql_target = mysql_query("SELECT target, remark FROM targetaccomplish WHERE assignID = '$assignid' AND month = '$i' AND year = '$year'");
                                if(mysql_num_rows($sql_target) != 0){
                                    $fetch = mysql_fetch_assoc($sql_target);
                                    if($fetch['target'] != 0){
                                        $output .= $fetch['target'];
                                    }
                                    else{
                                        $output .= "-";
                                    }
                                }
                                $output .= '</td>';
                            }
                            $sql_remark = mysql_query("SELECT remark FROM targetaccomplish WHERE assignID = '$assignid' AND year = '$year'");
                            $fetch_remark = mysql_fetch_assoc($sql_remark);
                            $output .= '<td class="remark-'.$assignid.'">'.$fetch_remark['remark'].'</td>';
                            if($input == true && $status == 1){
                                $output .= '<td for="action" id="actionassign'.$assignid.'"><a><span onclick="editvalues('.$assignid.')" class="badge badge-default"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></a></td>';
                            }
                            else{
                                $output .= '<td></td>';
                            }
                        }
                        $output .= '</tr>';
                        //level 3
                        $sql3 = mysql_query("SELECT assignID, program.programID AS programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE accID = '$accid' AND under = '$programid' AND reportID = '$reportid' ORDER BY title ASC");
                        if(mysql_num_rows($sql3) != 0){
                            while($fetch3 = mysql_fetch_assoc($sql3)){
                                $programid = $fetch3['programID'];
                                $assignid = $fetch3['assignID'];
                                $title = $fetch3['title'];
                                $status = $fetch3['status'];
                                $output .= 
                                '<tr id="assign'.$assignid.'">
                                    <td for="title" style="padding-left: 40px;">'.$title.'</td>';
                                if($status == 0){
                                    $output .= 
                                    '<td colspan="13" class="grey lighten-2"></td>';
                                }
                                else{
                                    for ($i = 1; $i <= 12 ; $i++) { 
                                        switch($i){
                                            case 1:
                                                $output .= '<td class="text-center q1-'.$assignid.'">';
                                                break;
                                            case 2:
                                                $output .= '<td class="text-center q2-'.$assignid.'">';
                                                break;
                                            case 3:
                                                $output .= '<td class="text-center q3-'.$assignid.'">';
                                                break;
                                            case 4:
                                                $output .= '<td class="text-center q4-'.$assignid.'">';
                                                break;
                                        }
                                        $sql_target = mysql_query("SELECT target FROM targetaccomplish WHERE assignID = '$assignid' AND month = '$i' AND year = '$year'");
                                        if(mysql_num_rows($sql_target) != 0){
                                            $fetch = mysql_fetch_assoc($sql_target);
                                            if($fetch['target'] != 0){
                                                $output .= $fetch['target'];
                                            }
                                            else{
                                                $output .= "-";
                                            }
                                        }
                                        $output .= '</td>';
                                    }
                                    $sql_remark = mysql_query("SELECT remark FROM targetaccomplish WHERE assignID = '$assignid' AND year = '$year'");
                                    $fetch_remark = mysql_fetch_assoc($sql_remark);
                                    $output .= '<td class="remark-'.$assignid.'">'.$fetch_remark['remark'].'</td>';
                                    if($input == true && $status == 1){
                                        $output .= '<td for="action" id="actionassign'.$assignid.'"><a><span onclick="editvalues('.$assignid.')" class="badge badge-default"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></a></td>';
                                    }		
                                    else{
                                        $output .= '<td></td>';
                                    }
                                }
                                $output .= '</tr>';
                                //level 4
                                $sql4 = mysql_query("SELECT assignID, program.programID AS programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE accID = '$accid' AND under = '$programid' AND reportID = '$reportid' ORDER BY title ASC");
                                if(mysql_num_rows($sql4) != 0){
                                    while($fetch4 = mysql_fetch_assoc($sql4)){
                                        $programid = $fetch4['programID'];
                                        $assignid = $fetch4['assignID'];
                                        $title = $fetch4['title'];
                                        $status = $fetch4['status'];
                                        $output .= 
                                        '<tr id="assign'.$assignid.'">
                                            <td for="title" style="padding-left: 60px;">'.$title.'</td>';
                                        if($status == 0){
                                            $output .= 
                                            '<td colspan="13" class="grey lighten-2"></td>';
                                        }
                                        else{
                                            for ($i = 1; $i <= 12 ; $i++) { 
                                                switch($i){
                                                    case 1:
                                                        $output .= '<td class="text-center q1-'.$assignid.'">';
                                                        break;
                                                    case 2:
                                                        $output .= '<td class="text-center q2-'.$assignid.'">';
                                                        break;
                                                    case 3:
                                                        $output .= '<td class="text-center q3-'.$assignid.'">';
                                                        break;
                                                    case 4:
                                                        $output .= '<td class="text-center q4-'.$assignid.'">';
                                                        break;
                                                }
                                                $sql_target = mysql_query("SELECT target FROM targetaccomplish WHERE assignID = '$assignid' AND month = '$i' AND year = '$year'");
                                                if(mysql_num_rows($sql_target) != 0){
                                                    $fetch = mysql_fetch_assoc($sql_target);
                                                    if($fetch['target'] != 0){
                                                        $output .= $fetch['target'];
                                                    }
                                                    else{
                                                        $output .= "-";
                                                    }
                                                }
                                                $output .= '</td>';
                                            }
                                            $sql_remark = mysql_query("SELECT remark FROM targetaccomplish WHERE assignID = '$assignid' AND year = '$year'");
                                            $fetch_remark = mysql_fetch_assoc($sql_remark);
                                            $output .= '<td class="remark-'.$assignid.'">'.$fetch_remark['remark'].'</td>';
                                            if($input == true && $status == 1){
                                                $output .= '<td for="action" id="actionassign'.$assignid.'"><a><span onclick="editvalues('.$assignid.')" class="badge badge-default"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></a></td>';
                                            }		
                                            else{
                                                $output .= '<td></td>';
                                            }
                                        }
                                        $output .= '</tr>';
                                        //level 5
                                        $sql5 = mysql_query("SELECT assignID, program.programID AS programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE accID = '$accid' AND under = '$programid' AND reportID = '$reportid' ORDER BY title ASC");
                                        if(mysql_num_rows($sql5) != 0){
                                            while($fetch5 = mysql_fetch_assoc($sql5)){
                                                $programid = $fetch5['programID'];
                                                $assignid = $fetch5['assignID'];
                                                $title = $fetch5['title'];
                                                $status = $fetch5['status'];
                                                $output .= 
                                                '<tr id="assign'.$assignid.'">
                                                    <td for="title" style="padding-left: 80px;">'.$title.'</td>';
                                                if($status == 0){
                                                    $output .= 
                                                    '<td colspan="13" class="grey lighten-2"></td>';
                                                }
                                                else{
                                                    for ($i = 1; $i <= 12 ; $i++) { 
                                                        switch($i){
                                                            case 1:
                                                                $output .= '<td class="text-center q1-'.$assignid.'">';
                                                                break;
                                                            case 2:
                                                                $output .= '<td class="text-center q2-'.$assignid.'">';
                                                                break;
                                                            case 3:
                                                                $output .= '<td class="text-center q3-'.$assignid.'">';
                                                                break;
                                                            case 4:
                                                                $output .= '<td class="text-center q4-'.$assignid.'">';
                                                                break;
                                                        }
                                                        $sql_target = mysql_query("SELECT target FROM targetaccomplish WHERE assignID = '$assignid' AND month = '$i' AND year = '$year'");
                                                        if(mysql_num_rows($sql_target) != 0){
                                                            $fetch = mysql_fetch_assoc($sql_target);
                                                            if($fetch['target'] != 0){
                                                                $output .= $fetch['target'];
                                                            }
                                                            else{
                                                                $output .= "-";
                                                            }
                                                        }
                                                        $output .= '</td>';
                                                    }
                                                    $sql_remark = mysql_query("SELECT remark FROM targetaccomplish WHERE assignID = '$assignid' AND year = '$year'");
                                                    $fetch_remark = mysql_fetch_assoc($sql_remark);
                                                    $output .= '<td class="remark-'.$assignid.'">'.$fetch_remark['remark'].'</td>';
                                                    if($input == true && $status == 1){
                                                        $output .= '<td for="action" id="actionassign'.$assignid.'"><a><span onclick="editvalues('.$assignid.')" class="badge badge-default"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></a></td>';
                                                    }		
                                                    else{
                                                        $output .= '<td></td>';
                                                    }
                                                }
                                                $output .= '</tr>';
                                                //level 6
                                                $sql6 = mysql_query("SELECT assignID, program.programID AS programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE accID = '$accid' AND under = '$programid' AND reportID = '$reportid' ORDER BY title ASC");
                                                if(mysql_num_rows($sql6) != 0){
                                                    while($fetch6 = mysql_fetch_assoc($sql6)){
                                                        $programid = $fetch6['programID'];
                                                        $assignid = $fetch6['assignID'];
                                                        $title = $fetch6['title'];
                                                        $status = $fetch6['status'];
                                                        $output .= 
                                                        '<tr id="assign'.$assignid.'">
                                                            <td for="title" style="padding-left: 80px;">'.$title.'</td>';
                                                        if($status == 0){
                                                            $output .= 
                                                            '<td colspan="13" class="grey lighten-2"></td>';
                                                        }
                                                        else{
                                                            for ($i = 1; $i <= 12 ; $i++) { 
                                                                switch($i){
                                                                    case 1:
                                                                        $output .= '<td class="text-center q1-'.$assignid.'">';
                                                                        break;
                                                                    case 2:
                                                                        $output .= '<td class="text-center q2-'.$assignid.'">';
                                                                        break;
                                                                    case 3:
                                                                        $output .= '<td class="text-center q3-'.$assignid.'">';
                                                                        break;
                                                                    case 4:
                                                                        $output .= '<td class="text-center q4-'.$assignid.'">';
                                                                        break;
                                                                }
                                                                $sql_target = mysql_query("SELECT target FROM targetaccomplish WHERE assignID = '$assignid' AND month = '$i' AND year = '$year'");
                                                                if(mysql_num_rows($sql_target) != 0){
                                                                    $fetch = mysql_fetch_assoc($sql_target);
                                                                    if($fetch['target'] != 0){
                                                                        $output .= $fetch['target'];
                                                                    }
                                                                    else{
                                                                        $output .= "-";
                                                                    }
                                                                }
                                                                $output .= '</td>';
                                                            }
                                                            $sql_remark = mysql_query("SELECT remark FROM targetaccomplish WHERE assignID = '$assignid' AND year = '$year'");
                                                            $fetch_remark = mysql_fetch_assoc($sql_remark);
                                                            $output .= '<td class="remark-'.$assignid.'">'.$fetch_remark['remark'].'</td>';
                                                            if($input == true && $status == 1){
                                                                $output .= '<td for="action" id="actionassign'.$assignid.'"><a><span onclick="editvalues('.$assignid.')" class="badge badge-default"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></a></td>';
                                                            }		
                                                            else{
                                                                $output .= '<td></td>';
                                                            }
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
        }
        else{
            $output .= 
			"<tr>
				<td colspan='7'><p class='h1-responsive text-center'>No Programs/Projects found</p></td>
			</tr>";
        }
		return $output;
	}
	if($action == "listassignedprogram"){
        $year = mysql_escape_string($_POST['year']);
        $reportid = mysql_escape_string($_POST['reportid']);
		echo json_encode(arrangeprogram($year, $reportid));
	}
	if($action == "savevalues"){
		$values = json_decode($_POST['data']);
		$date_added = date('Y-m-j H:i');
		$assignid = mysql_escape_string($_POST['assignid']);
        $arrlength = count($values);
        $remark = mysql_escape_string($_POST['remark']);
		$year = mysql_escape_string($_POST['year']);
        $sql = mysql_query("SELECT target FROM locked WHERE year = '$year'");
        $fetch = mysql_fetch_assoc($sql);
        $lock = $fetch['target'];
        if($lock == 0){
            for ($i = 1; $i <= $arrlength; $i++) { 
                $target = $values[$i];
                $count_blank = 0;
                if($target != ""){
                    $target = intval($target);
                    $sql = mysql_query("SELECT assignID FROM targetaccomplish WHERE assignID = '$assignid' AND month = '$i' AND year = '$year'");
                    if(mysql_num_rows($sql) != 0){
                        mysql_query("UPDATE targetaccomplish SET target = '$target', target_added = '$date_added', remark = '$remark' WHERE assignID = '$assignid' AND month = '$i' AND year = '$year'"); 
                    } 
                    else{
                        mysql_query("INSERT INTO targetaccomplish (assignID, target, month, year, target_added, remark) VALUES ('$assignid', '$target', '$i', '$year', '$date_added', '$remark')");
                    } 
                }
            }
            $sql = mysql_query("SELECT assignID FROM targetaccomplish WHERE assignID = '$assignid' AND year = '$year'");
            if(mysql_num_rows($sql) == 0 && $remark != ""){
                mysql_query("INSERT INTO targetaccomplish (assignID, target, month, year, target_added, remark) VALUES ('$assignid', '0', '1', '$year', '$date_added', '$remark')");
            }
        }
	}
	if($action == "inityear"){
		$latest = date('Y');
		for ($i = $latest; $i >= 2014 ; $i--) { 
			$output .= '<option value="'.$i.'">'.$i.'</option>';
		}
		echo json_encode($output);
	}
    if($action == "checknotice"){
        $year = mysql_escape_string($_POST['year']);
        $sql = mysql_query("SELECT target FROM locked WHERE year = '$year'");
        $fetch = mysql_fetch_assoc($sql);
        if($fetch['target'] == 1){
            $bool = true;
        }
        else{
            $bool = false;
        }
        echo json_encode($bool);
    }
?>