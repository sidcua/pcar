<?php
    session_start();
    include '../../../php/connect.php';
    $action = $_POST['action'];
    if($action == "inityear"){
		$latest = date('Y');
		for ($i = $latest; $i >= 2014 ; $i--) { 
			$output .= '<option value="'.$i.'">'.$i.'</option>';
		}
		echo json_encode($output);
	}
    if($action == "month"){
        $year = mysql_escape_string($_POST['year']);
        $month = mysql_escape_string($_POST['value']);
        if($month == 1){
            $output = '<table class="table table-bordered table-striped">
					<thead class="mdb-color darken-3">
						<tr class="white-text text-center">
							<th style="width: 500px;">Services Programs/Projects</th>
							<th colspan="2">January</th>
							<th colspan="2">Total</th>
						</tr>
					</thead><tbody>
                    <tr class="white-text text-center"><td></td>
                    <td class="bg-danger">T</td>
                    <td class="bg-success">A</td>
                    <td class="bg-danger">T</td>
                    <td class="bg-success">A</td></tr>';
//            level 1
            $sql = mysql_query("SELECT programID, title, status FROM program WHERE level = 1 AND state = 1 ORDER BY title ASC");
            while($fetch = mysql_fetch_assoc($sql)){
                $programid = $fetch['programID'];
                $title = $fetch['title'];
                $status = $fetch['status'];
                $output .= 
                '<tr>
                    <td style="padding-left: 20px;">'.$title.'</td>';
                if($status == 0){
                    $output .= '<td colspan="4" class="grey lighten-2"></td>';
                }
                else{
                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = 1 AND year = '$year' AND program.programID = '$programid'");
                    $get = mysql_fetch_assoc($query);
					$target = $get['target'];
					if($target == 0){
						$output .= '<td class="text-center">-</td>';
					}
					else{
						$output .= '<td class="text-center">'.$target.'</td>';;
					}
					$accomplish = $get['accomplish'];
					if($accomplish == 0){
						$output .= '<td class="text-center">-</td>';
					}
					else{
						$output .= '<td class="text-center">'.$accomplish.'</td>';
					}
                    if($target == 0){
						$output .= '<td class="text-center">-</td>';
					}
					else{
						$output .= '<td class="text-center">'.$target.'</td>';;
					}
					$accomplish = $get['accomplish'];
					if($accomplish == 0){
						$output .= '<td class="text-center">-</td>';
					}
					else{
						$output .= '<td class="text-center">'.$accomplish.'</td>';
					}
                }
                $output .= '</tr>';
//                level 2
                $sql2 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                if(mysql_num_rows($sql2) != 0){
                    while($fetch2 = mysql_fetch_assoc($sql2)){
                        $programid = $fetch2['programID'];
                        $title = $fetch2['title'];
                        $status = $fetch2['status'];
                        $output .= 
                        '<tr>
                            <td style="padding-left: 40px;">'.$title.'</td>';
                        if($status == 0){
                            $output .= '<td colspan="4" class="grey lighten-2"></td>';
                        }
                        else{
                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = 1 AND year = '$year' AND program.programID = '$programid'");
                            $get = mysql_fetch_assoc($query);
                            $target = $get['target'];
                            if($target == 0){
                                $output .= '<td class="text-center">-</td>';
                            }
                            else{
                                $output .= '<td class="text-center">'.$target.'</td>';;
                            }
                            $accomplish = $get['accomplish'];
                            if($accomplish == 0){
                                $output .= '<td class="text-center">-</td>';
                            }
                            else{
                                $output .= '<td class="text-center">'.$accomplish.'</td>';
                            }
                            if($target == 0){
                                $output .= '<td class="text-center">-</td>';
                            }
                            else{
                                $output .= '<td class="text-center">'.$target.'</td>';;
                            }
                            $accomplish = $get['accomplish'];
                            if($accomplish == 0){
                                $output .= '<td class="text-center">-</td>';
                            }
                            else{
                                $output .= '<td class="text-center">'.$accomplish.'</td>';
                            }
                        }
                        $output .= '</tr>';
//                        level 3
                        $sql3 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                        if(mysql_num_rows($sql3) != 0){
                            while($fetch3 = mysql_fetch_assoc($sql3)){
                                $programid = $fetch3['programID'];
                                $title = $fetch3['title'];
                                $status = $fetch3['status'];
                                $output .= 
                                '<tr>
                                    <td style="padding-left: 60px;">'.$title.'</td>';
                                if($status == 0){
                                    $output .= '<td colspan="4" class="grey lighten-2"></td>';
                                }
                                else{
                                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = 1 AND year = '$year' AND program.programID = '$programid'");
                                    $get = mysql_fetch_assoc($query);
                                    $target = $get['target'];
                                    if($target == 0){
                                        $output .= '<td class="text-center">-</td>';
                                    }
                                    else{
                                        $output .= '<td class="text-center">'.$target.'</td>';;
                                    }
                                    $accomplish = $get['accomplish'];
                                    if($accomplish == 0){
                                        $output .= '<td class="text-center">-</td>';
                                    }
                                    else{
                                        $output .= '<td class="text-center">'.$accomplish.'</td>';
                                    }
                                    if($target == 0){
                                        $output .= '<td class="text-center">-</td>';
                                    }
                                    else{
                                        $output .= '<td class="text-center">'.$target.'</td>';;
                                    }
                                    $accomplish = $get['accomplish'];
                                    if($accomplish == 0){
                                        $output .= '<td class="text-center">-</td>';
                                    }
                                    else{
                                        $output .= '<td class="text-center">'.$accomplish.'</td>';
                                    }
                                }
                                
                                $output .= '</tr>';
//                                    level 4
                                $sql4 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                                if(mysql_num_rows($sql4) != 0){
                                    while($fetch4 = mysql_fetch_assoc($sql4)){
                                        $programid = $fetch4['programID'];
                                        $title = $fetch4['title'];
                                        $status = $fetch4['status'];
                                        $output .= 
                                        '<tr>
                                            <td style="padding-left: 80px;">'.$title.'</td>';
                                        if($status == 0){
                                            $output .= '<td colspan="4" class="grey lighten-2"></td>';
                                        }
                                        else{
                                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = 1 AND year = '$year' AND program.programID = '$programid'");
                                            $get = mysql_fetch_assoc($query);
                                            $target = $get['target'];
                                            if($target == 0){
                                                $output .= '<td class="text-center">-</td>';
                                            }
                                            else{
                                                $output .= '<td class="text-center">'.$target.'</td>';;
                                            }
                                            $accomplish = $get['accomplish'];
                                            if($accomplish == 0){
                                                $output .= '<td class="text-center">-</td>';
                                            }
                                            else{
                                                $output .= '<td class="text-center">'.$accomplish.'</td>';
                                            }
                                            if($target == 0){
                                                $output .= '<td class="text-center">-</td>';
                                            }
                                            else{
                                                $output .= '<td class="text-center">'.$target.'</td>';;
                                            }
                                            $accomplish = $get['accomplish'];
                                            if($accomplish == 0){
                                                $output .= '<td class="text-center">-</td>';
                                            }
                                            else{
                                                $output .= '<td class="text-center">'.$accomplish.'</td>';
                                            }
                                        }
                                        $output .= '</tr>';
//                                                level 5
                                        $sql5 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                                        if(mysql_num_rows($sql5) != 0){
                                            while($fetch5 = mysql_fetch_assoc($sql5)){
                                                $programid = $fetch5['programID'];
                                                $title = $fetch5['title'];
                                                $status = $fetch5['status'];
                                                $output .= 
                                                '<tr>
                                                    <td style="padding-left: 100px;">'.$title.'</td>';
                                                if($status == 0){
                                                    $output .= '<td colspan="4" class="grey lighten-2"></td>';
                                                }
                                                else{
                                                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = 1 AND year = '$year' AND program.programID = '$programid'");
                                                    $get = mysql_fetch_assoc($query);
                                                    $target = $get['target'];
                                                    if($target == 0){
                                                        $output .= '<td class="text-center">-</td>';
                                                    }
                                                    else{
                                                        $output .= '<td class="text-center">'.$target.'</td>';;
                                                    }
                                                    $accomplish = $get['accomplish'];
                                                    if($accomplish == 0){
                                                        $output .= '<td class="text-center">-</td>';
                                                    }
                                                    else{
                                                        $output .= '<td class="text-center">'.$accomplish.'</td>';
                                                    }
                                                    if($target == 0){
                                                        $output .= '<td class="text-center">-</td>';
                                                    }
                                                    else{
                                                        $output .= '<td class="text-center">'.$target.'</td>';;
                                                    }
                                                    $accomplish = $get['accomplish'];
                                                    if($accomplish == 0){
                                                        $output .= '<td class="text-center">-</td>';
                                                    }
                                                    else{
                                                        $output .= '<td class="text-center">'.$accomplish.'</td>';
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
            $output .= '</tbody></table>';
        }
        else{
            if($month == 2){
                $con = "January";
                $monthlbl = "February";
            }
            else if($month == 3){
                $con = "January - February";
                $monthlbl = "March";
            }
            else if($month == 4){
                $con = "January - March";
                $monthlbl = "April";
            }
            else if($month == 5){
                $con = "January - April";
                $monthlbl = "May";
            }
            else if($month == 6){
                $con = "January - May";
                $monthlbl = "June";
            }
            else if($month == 7){
                $con = "January - June";
                $monthlbl = "July";
            }
            else if($month == 8){
                $con = "January - July";
                $monthlbl = "August";
            }
            else if($month == 9){
                $con = "January - August";
                $monthlblh = "September";
            }
            else if($month == 10){
                $con = " January - September";
                $monthlbl = "October";
            }
            else if($month == 11){
                $con = "January - October";
                $monthlbl = "November";
            }
            else{
                $con = "January - November";
                $monthlbl = "December";
            }
            $before = $month - 1;
            $output = '<table class="table table-bordered table-striped">
					<thead class="mdb-color darken-3 table-striped">
						<tr class="white-text text-center">
							<td style="width: 500px;">Services Programs/Projects</td>
                            <td colspan="2">'.$con.'</td>
							<td colspan="2">'.$monthlbl.'</td>
							<td colspan="2">Total</td>
						</tr>
					</thead><tbody>
                    <tr class="white-text text-center"><td></td>
                    <td class="bg-danger">T</td>
                    <td class="bg-success">A</td>
                    <td class="bg-danger">T</td>
                    <td class="bg-success">A</td>
                    <td class="bg-danger">T</td>
                    <td class="bg-success">A</td></tr>';
//            level 1
            $sql = mysql_query("SELECT programID, title, status FROM program WHERE level = 1 AND state = 1 ORDER BY title ASC");
            while($fetch = mysql_fetch_assoc($sql)){
                $programid = $fetch['programID'];
                $title = $fetch['title'];
                $status = $fetch['status'];
                $output .= 
                '<tr>
                    <td style="padding-left: 20px;">'.$title.'</td>';
                if($status == 0){
                    $output .= '<td colspan="6" class="grey lighten-2"></td>';
                }
                else{
                    $totaltarget = 0;
                    $totalaccomplish = 0;
                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month <= '$before' AND year = '$year' AND program.programID = '$programid'");
                    $get = mysql_fetch_assoc($query);
                    $target = $get['target'];
                    if($target == 0){
                        $output .= '<td class="text-center">-</td>';
                    }
                    else{
                        $output .= '<td class="text-center">'.$target.'</td>';
                        $totaltarget += $target;
                    }
                    $accomplish = $get['accomplish'];
                    if($accomplish == 0){
                        $output .= '<td class="text-center">-</td>';
                    }
                    else{
                        $output .= '<td class="text-center">'.$accomplish.'</td>';
                        $totalaccomplish += $accomplish;
                    }
                    $query2 = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$month' AND year = '$year' AND program.programID = '$programid'");
                    $get2 = mysql_fetch_assoc($query2);
                    $target2 = $get2['target'];
                    if($target2 == 0){
                        $output .= '<td class="text-center">-</td>';
                    }
                    else{
                        $output .= '<td class="text-center">'.$target2.'</td>';
                        $totaltarget += $target2;
                    }
                    $accomplish2 = $get2['accomplish'];
                    if($accomplish2 == 0){
                        $output .= '<td class="text-center">-</td>';
                    }
                    else{
                        $output .= '<td class="text-center">'.$accomplish2.'</td>';
                        $totalaccomplish += $accomplish2;
                    }
                    if($totaltarget == 0){
                        $output .= '<td class="text-center">-</td>';
                    }
                    else{
                        $output .= '<td class="text-center">'.$totaltarget.'</td>';
                    }
                    if($totalaccomplish == 0){
                        $output .= '<td class="text-center">-</td>';
                    }
                    else{
                        $output .= '<td class="text-center">'.$totalaccomplish.'</td>';
                    }
                }
                $output .= '</tr>';
//                level 2
                $sql2 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                if(mysql_num_rows($sql2) != 0){
                    while($fetch2 = mysql_fetch_assoc($sql2)){
                        $programid = $fetch2['programID'];
                        $title = $fetch2['title'];
                        $status = $fetch2['status'];
                        $output .= 
                        '<tr>
                            <td style="padding-left: 40px;">'.$title.'</td>';
                        if($status == 0){
                            $output .= '<td colspan="6" class="grey lighten-2"></td>';
                        }
                        else{
                            $totaltarget = 0;
                            $totalaccomplish = 0;
                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month <= '$before' AND year = '$year' AND program.programID = '$programid'");
                            $get = mysql_fetch_assoc($query);
                            $target = $get['target'];
                            if($target == 0){
                                $output .= '<td class="text-center">-</td>';
                            }
                            else{
                                $output .= '<td class="text-center">'.$target.'</td>';
                                $totaltarget += $target;
                            }
                            $accomplish = $get['accomplish'];
                            if($accomplish == 0){
                                $output .= '<td class="text-center">-</td>';
                            }
                            else{
                                $output .= '<td class="text-center">'.$accomplish.'</td>';
                                $totalaccomplish += $accomplish;
                            }
                            $query2 = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$month' AND year = '$year' AND program.programID = '$programid'");
                            $get2 = mysql_fetch_assoc($query2);
                            $target2 = $get2['target'];
                            if($target2 == 0){
                                $output .= '<td class="text-center">-</td>';
                            }
                            else{
                                $output .= '<td class="text-center">'.$target2.'</td>';
                                $totaltarget += $target2;
                            }
                            $accomplish2 = $get2['accomplish'];
                            if($accomplish2 == 0){
                                $output .= '<td class="text-center">-</td>';
                            }
                            else{
                                $output .= '<td class="text-center">'.$accomplish2.'</td>';
                                $totalaccomplish += $accomplish2;
                            }
                            if($totaltarget == 0){
                                $output .= '<td class="text-center">-</td>';
                            }
                            else{
                                $output .= '<td class="text-center">'.$totaltarget.'</td>';
                            }
                            if($totalaccomplish == 0){
                                $output .= '<td class="text-center">-</td>';
                            }
                            else{
                                $output .= '<td class="text-center">'.$totalaccomplish.'</td>';
                            }
                        }
                        $output .= '</tr>';
//                        level 3
                        $sql3 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                        if(mysql_num_rows($sql3) != 0){
                            while($fetch3 = mysql_fetch_assoc($sql3)){
                                $programid = $fetch3['programID'];
                                $title = $fetch3['title'];
                                $status = $fetch3['status'];
                                $output .= 
                                '<tr>
                                    <td style="padding-left: 60px;">'.$title.'</td>';
                                if($status == 0){
                                    $output .= '<td colspan="6" class="grey lighten-2"></td>';
                                }
                                else{
                                    $totaltarget = 0;
                                    $totalaccomplish = 0;
                                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month <= '$before' AND year = '$year' AND program.programID = '$programid'");
                                    $get = mysql_fetch_assoc($query);
                                    $target = $get['target'];
                                    if($target == 0){
                                        $output .= '<td class="text-center">-</td>';
                                    }
                                    else{
                                        $output .= '<td class="text-center">'.$target.'</td>';
                                        $totaltarget += $target;
                                    }
                                    $accomplish = $get['accomplish'];
                                    if($accomplish == 0){
                                        $output .= '<td class="text-center">-</td>';
                                    }
                                    else{
                                        $output .= '<td class="text-center">'.$accomplish.'</td>';
                                        $totalaccomplish += $accomplish;
                                    }
                                    $query2 = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$month' AND year = '$year' AND program.programID = '$programid'");
                                    $get2 = mysql_fetch_assoc($query2);
                                    $target2 = $get2['target'];
                                    if($target2 == 0){
                                        $output .= '<td class="text-center">-</td>';
                                    }
                                    else{
                                        $output .= '<td class="text-center">'.$target2.'</td>';
                                        $totaltarget += $target2;
                                    }
                                    $accomplish2 = $get2['accomplish'];
                                    if($accomplish2 == 0){
                                        $output .= '<td class="text-center">-</td>';
                                    }
                                    else{
                                        $output .= '<td class="text-center">'.$accomplish2.'</td>';
                                        $totalaccomplish += $accomplish2;
                                    }
                                    if($totaltarget == 0){
                                        $output .= '<td class="text-center">-</td>';
                                    }
                                    else{
                                        $output .= '<td class="text-center">'.$totaltarget.'</td>';
                                    }
                                    if($totalaccomplish == 0){
                                        $output .= '<td class="text-center">-</td>';
                                    }
                                    else{
                                        $output .= '<td class="text-center">'.$totalaccomplish.'</td>';
                                    }
                                }
                                
                                $output .= '</tr>';
//                                    level 4
                                $sql4 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                                if(mysql_num_rows($sql4) != 0){
                                    while($fetch4 = mysql_fetch_assoc($sql4)){
                                        $programid = $fetch4['programID'];
                                        $title = $fetch4['title'];
                                        $status = $fetch4['status'];
                                        $output .= 
                                        '<tr>
                                            <td style="padding-left: 80px;">'.$title.'</td>';
                                        if($status == 0){
                                            $output .= '<td colspan="6" class="grey lighten-2"></td>';
                                        }
                                        else{
                                            $totaltarget = 0;
                                            $totalaccomplish = 0;
                                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month <= '$before' AND year = '$year' AND program.programID = '$programid'");
                                            $get = mysql_fetch_assoc($query);
                                            $target = $get['target'];
                                            if($target == 0){
                                                $output .= '<td class="text-center">-</td>';
                                            }
                                            else{
                                                $output .= '<td class="text-center">'.$target.'</td>';
                                                $totaltarget += $target;
                                            }
                                            $accomplish = $get['accomplish'];
                                            if($accomplish == 0){
                                                $output .= '<td class="text-center">-</td>';
                                            }
                                            else{
                                                $output .= '<td class="text-center">'.$accomplish.'</td>';
                                                $totalaccomplish += $accomplish;
                                            }
                                            $query2 = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$month' AND year = '$year' AND program.programID = '$programid'");
                                            $get2 = mysql_fetch_assoc($query2);
                                            $target2 = $get2['target'];
                                            if($target2 == 0){
                                                $output .= '<td class="text-center">-</td>';
                                            }
                                            else{
                                                $output .= '<td class="text-center">'.$target2.'</td>';
                                                $totaltarget += $target2;
                                            }
                                            $accomplish2 = $get2['accomplish'];
                                            if($accomplish2 == 0){
                                                $output .= '<td class="text-center">-</td>';
                                            }
                                            else{
                                                $output .= '<td class="text-center">'.$accomplish2.'</td>';
                                                $totalaccomplish += $accomplish2;
                                            }
                                            if($totaltarget == 0){
                                                $output .= '<td class="text-center">-</td>';
                                            }
                                            else{
                                                $output .= '<td class="text-center">'.$totaltarget.'</td>';
                                            }
                                            if($totalaccomplish == 0){
                                                $output .= '<td class="text-center">-</td>';
                                            }
                                            else{
                                                $output .= '<td class="text-center">'.$totalaccomplish.'</td>';
                                            }
                                        }
                                        $output .= '</tr>';
//                                                level 5
                                        $sql5 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                                        if(mysql_num_rows($sql5) != 0){
                                            while($fetch5 = mysql_fetch_assoc($sql5)){
                                                $programid = $fetch5['programID'];
                                                $title = $fetch5['title'];
                                                $status = $fetch5['status'];
                                                $output .= 
                                                '<tr>
                                                    <td style="padding-left: 100px;">'.$title.'</td>';
                                                if($status == 0){
                                                    $output .= '<td colspan="6" class="grey lighten-2"></td>';
                                                }
                                                else{
                                                    $totaltarget = 0;
                                                    $totalaccomplish = 0;
                                                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month <= '$before' AND year = '$year' AND program.programID = '$programid'");
                                                    $get = mysql_fetch_assoc($query);
                                                    $target = $get['target'];
                                                    if($target == 0){
                                                        $output .= '<td class="text-center">-</td>';
                                                    }
                                                    else{
                                                        $output .= '<td class="text-center">'.$target.'</td>';
                                                        $totaltarget += $target;
                                                    }
                                                    $accomplish = $get['accomplish'];
                                                    if($accomplish == 0){
                                                        $output .= '<td class="text-center">-</td>';
                                                    }
                                                    else{
                                                        $output .= '<td class="text-center">'.$accomplish.'</td>';
                                                        $totalaccomplish += $accomplish;
                                                    }
                                                    $query2 = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$month' AND year = '$year' AND program.programID = '$programid'");
                                                    $get2 = mysql_fetch_assoc($query2);
                                                    $target2 = $get2['target'];
                                                    if($target2 == 0){
                                                        $output .= '<td class="text-center">-</td>';
                                                    }
                                                    else{
                                                        $output .= '<td class="text-center">'.$target2.'</td>';
                                                        $totaltarget += $target2;
                                                    }
                                                    $accomplish2 = $get2['accomplish'];
                                                    if($accomplish2 == 0){
                                                        $output .= '<td class="text-center">-</td>';
                                                    }
                                                    else{
                                                        $output .= '<td class="text-center">'.$accomplish2.'</td>';
                                                        $totalaccomplish += $accomplish2;
                                                    }
                                                    if($totaltarget == 0){
                                                        $output .= '<td class="text-center">-</td>';
                                                    }
                                                    else{
                                                        $output .= '<td class="text-center">'.$totaltarget.'</td>';
                                                    }
                                                    if($totalaccomplish == 0){
                                                        $output .= '<td class="text-center">-</td>';
                                                    }
                                                    else{
                                                        $output .= '<td class="text-center">'.$totalaccomplish.'</td>';
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
            $output .= '</tbody></table>';
        }
        echo json_encode($output);
    }
    if($action == "quarter"){
        $year = mysql_escape_string($_POST['year']);
        $quarter = mysql_escape_string($_POST['value']);
        if($quarter == 1){
            $output = '<table class="table table-bordered table-striped">
					<thead class="mdb-color darken-3 table-striped">
						<tr class="white-text text-center">
							<td style="width: 500px;">Services Programs/Projects</td>
							<td colspan="2">Quarter 1</td>
							<td colspan="2">Total</td>
						</tr>
					</thead><tbody>
                    <tr class="white-text text-center"><td></td>
                    <td class="bg-danger">T</td>
                    <td class="bg-success">A</td>
                    <td class="bg-danger">T</td>
                    <td class="bg-success">A</td></tr>';
//            level 1
            $sql = mysql_query("SELECT programID, title, status FROM program WHERE level = 1 AND state = 1 ORDER BY title ASC");
            while($fetch = mysql_fetch_assoc($sql)){
                $programid = $fetch['programID'];
                $title = $fetch['title'];
                $status = $fetch['status'];
                $output .= 
                '<tr>
                    <td style="padding-left: 20px;">'.$title.'</td>';
                if($status == 0){
                    $output .= '<td colspan="4" class="grey lighten-2"></td>';
                }
                else{
                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month <= 3 AND year = '$year' AND program.programID = '$programid'");
                    $get = mysql_fetch_assoc($query);
					$target = $get['target'];
					if($target == 0){
						$output .= '<td class="text-center">-</td>';
					}
					else{
						$output .= '<td class="text-center">'.$target.'</td>';;
					}
					$accomplish = $get['accomplish'];
					if($accomplish == 0){
						$output .= '<td class="text-center">-</td>';
					}
					else{
						$output .= '<td class="text-center">'.$accomplish.'</td>';
					}
                    if($target == 0){
						$output .= '<td class="text-center">-</td>';
					}
					else{
						$output .= '<td class="text-center">'.$target.'</td>';;
					}
					$accomplish = $get['accomplish'];
					if($accomplish == 0){
						$output .= '<td class="text-center">-</td>';
					}
					else{
						$output .= '<td class="text-center">'.$accomplish.'</td>';
					}
                }
                $output .= '</tr>';
//                level 2
                $sql2 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                if(mysql_num_rows($sql2) != 0){
                    while($fetch2 = mysql_fetch_assoc($sql2)){
                        $programid = $fetch2['programID'];
                        $title = $fetch2['title'];
                        $status = $fetch2['status'];
                        $output .= 
                        '<tr>
                            <td style="padding-left: 40px;">'.$title.'</td>';
                        if($status == 0){
                            $output .= '<td colspan="4" class="grey lighten-2"></td>';
                        }
                        else{
                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month <= 3 AND year = '$year' AND program.programID = '$programid'");
                            $get = mysql_fetch_assoc($query);
                            $target = $get['target'];
                            if($target == 0){
                                $output .= '<td class="text-center">-</td>';
                            }
                            else{
                                $output .= '<td class="text-center">'.$target.'</td>';;
                            }
                            $accomplish = $get['accomplish'];
                            if($accomplish == 0){
                                $output .= '<td class="text-center">-</td>';
                            }
                            else{
                                $output .= '<td class="text-center">'.$accomplish.'</td>';
                            }
                            if($target == 0){
                                $output .= '<td class="text-center">-</td>';
                            }
                            else{
                                $output .= '<td class="text-center">'.$target.'</td>';;
                            }
                            $accomplish = $get['accomplish'];
                            if($accomplish == 0){
                                $output .= '<td class="text-center">-</td>';
                            }
                            else{
                                $output .= '<td class="text-center">'.$accomplish.'</td>';
                            }
                        }
                        $output .= '</tr>';
//                        level 3
                        $sql3 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                        if(mysql_num_rows($sql3) != 0){
                            while($fetch3 = mysql_fetch_assoc($sql3)){
                                $programid = $fetch3['programID'];
                                $title = $fetch3['title'];
                                $status = $fetch3['status'];
                                $output .= 
                                '<tr>
                                    <td style="padding-left: 60px;">'.$title.'</td>';
                                if($status == 0){
                                    $output .= '<td colspan="4" class="grey lighten-2"></td>';
                                }
                                else{
                                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month <= 3 AND year = '$year' AND program.programID = '$programid'");
                                    $get = mysql_fetch_assoc($query);
                                    $target = $get['target'];
                                    if($target == 0){
                                        $output .= '<td class="text-center">-</td>';
                                    }
                                    else{
                                        $output .= '<td class="text-center">'.$target.'</td>';;
                                    }
                                    $accomplish = $get['accomplish'];
                                    if($accomplish == 0){
                                        $output .= '<td class="text-center">-</td>';
                                    }
                                    else{
                                        $output .= '<td class="text-center">'.$accomplish.'</td>';
                                    }
                                    if($target == 0){
                                        $output .= '<td class="text-center">-</td>';
                                    }
                                    else{
                                        $output .= '<td class="text-center">'.$target.'</td>';;
                                    }
                                    $accomplish = $get['accomplish'];
                                    if($accomplish == 0){
                                        $output .= '<td class="text-center">-</td>';
                                    }
                                    else{
                                        $output .= '<td class="text-center">'.$accomplish.'</td>';
                                    }
                                }
                                
                                $output .= '</tr>';
//                                    level 4
                                $sql4 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                                if(mysql_num_rows($sql4) != 0){
                                    while($fetch4 = mysql_fetch_assoc($sql4)){
                                        $programid = $fetch4['programID'];
                                        $title = $fetch4['title'];
                                        $status = $fetch4['status'];
                                        $output .= 
                                        '<tr>
                                            <td style="padding-left: 80px;">'.$title.'</td>';
                                        if($status == 0){
                                            $output .= '<td colspan="4" class="grey lighten-2"></td>';
                                        }
                                        else{
                                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month <= 3 AND year = '$year' AND program.programID = '$programid'");
                                            $get = mysql_fetch_assoc($query);
                                            $target = $get['target'];
                                            if($target == 0){
                                                $output .= '<td class="text-center">-</td>';
                                            }
                                            else{
                                                $output .= '<td class="text-center">'.$target.'</td>';;
                                            }
                                            $accomplish = $get['accomplish'];
                                            if($accomplish == 0){
                                                $output .= '<td class="text-center">-</td>';
                                            }
                                            else{
                                                $output .= '<td class="text-center">'.$accomplish.'</td>';
                                            }
                                            if($target == 0){
                                                $output .= '<td class="text-center">-</td>';
                                            }
                                            else{
                                                $output .= '<td class="text-center">'.$target.'</td>';;
                                            }
                                            $accomplish = $get['accomplish'];
                                            if($accomplish == 0){
                                                $output .= '<td class="text-center">-</td>';
                                            }
                                            else{
                                                $output .= '<td class="text-center">'.$accomplish.'</td>';
                                            }
                                        }
                                        $output .= '</tr>';
//                                                level 5
                                        $sql5 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                                        if(mysql_num_rows($sql5) != 0){
                                            while($fetch5 = mysql_fetch_assoc($sql5)){
                                                $programid = $fetch5['programID'];
                                                $title = $fetch5['title'];
                                                $status = $fetch5['status'];
                                                $output .= 
                                                '<tr>
                                                    <td style="padding-left: 100px;">'.$title.'</td>';
                                                if($status == 0){
                                                    $output .= '<td colspan="4" class="grey lighten-2"></td>';
                                                }
                                                else{
                                                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month <= 3 AND year = '$year' AND program.programID = '$programid'");
                                                    $get = mysql_fetch_assoc($query);
                                                    $target = $get['target'];
                                                    if($target == 0){
                                                        $output .= '<td class="text-center">-</td>';
                                                    }
                                                    else{
                                                        $output .= '<td class="text-center">'.$target.'</td>';;
                                                    }
                                                    $accomplish = $get['accomplish'];
                                                    if($accomplish == 0){
                                                        $output .= '<td class="text-center">-</td>';
                                                    }
                                                    else{
                                                        $output .= '<td class="text-center">'.$accomplish.'</td>';
                                                    }
                                                    if($target == 0){
                                                        $output .= '<td class="text-center">-</td>';
                                                    }
                                                    else{
                                                        $output .= '<td class="text-center">'.$target.'</td>';;
                                                    }
                                                    $accomplish = $get['accomplish'];
                                                    if($accomplish == 0){
                                                        $output .= '<td class="text-center">-</td>';
                                                    }
                                                    else{
                                                        $output .= '<td class="text-center">'.$accomplish.'</td>';
                                                    }
                                                    $output .= '</tr>';
                                                    //level 6
                                                    $sql6 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                                                    if(mysql_num_rows($sql6) != 0){
                                                        while($fetch6 = mysql_fetch_assoc($sql6)){
                                                            $programid = $fetch6['programID'];
                                                            $title = $fetch6['title'];
                                                            $status = $fetch6['status'];
                                                            $output .= 
                                                            '<tr>
                                                                <td style="padding-left: 100px;">'.$title.'</td>';
                                                            if($status == 0){
                                                                $output .= '<td colspan="4" class="grey lighten-2"></td>';
                                                            }
                                                            else{
                                                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month <= 3 AND year = '$year' AND program.programID = '$programid'");
                                                                $get = mysql_fetch_assoc($query);
                                                                $target = $get['target'];
                                                                if($target == 0){
                                                                    $output .= '<td class="text-center">-</td>';
                                                                }
                                                                else{
                                                                    $output .= '<td class="text-center">'.$target.'</td>';;
                                                                }
                                                                $accomplish = $get['accomplish'];
                                                                if($accomplish == 0){
                                                                    $output .= '<td class="text-center">-</td>';
                                                                }
                                                                else{
                                                                    $output .= '<td class="text-center">'.$accomplish.'</td>';
                                                                }
                                                                if($target == 0){
                                                                    $output .= '<td class="text-center">-</td>';
                                                                }
                                                                else{
                                                                    $output .= '<td class="text-center">'.$target.'</td>';;
                                                                }
                                                                $accomplish = $get['accomplish'];
                                                                if($accomplish == 0){
                                                                    $output .= '<td class="text-center">-</td>';
                                                                }
                                                                else{
                                                                    $output .= '<td class="text-center">'.$accomplish.'</td>';
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
            }
            $output .= '</tbody></table>';
        }
        else{
            if($quarter == 2){
                $con = "Quarter 1";
                $monthlbl = "Quarter 2";
            }
            else if($month == 3){
                $con = "Quarter 1 - 2";
                $monthlbl = "Quarter 3";
            }
            else{
                $con = "Quarter 1 - 3";
                $monthlbl = "Quarter 4";
            }
            $before = ($quarter - 1) * 3;
            $current = $quarter * 3;
            $output = '<table class="table table-bordered table-striped">
					<thead class="mdb-color darken-3 table-striped">
						<tr class="white-text text-center">
							<td style="width: 500px;">Services Programs/Projects</td>
                            <td colspan="2">'.$con.'</td>
							<td colspan="2">'.$monthlbl.'</td>
							<td colspan="2">Total</td>
						</tr>
					</thead><tbody>
                    <tr class="white-text text-center"><td></td>
                    <td class="bg-danger">T</td>
                    <td class="bg-success">A</td>
                    <td class="bg-danger">T</td>
                    <td class="bg-success">A</td>
                    <td class="bg-danger">T</td>
                    <td class="bg-success">A</td></tr>';
//            level 1
            $sql = mysql_query("SELECT programID, title, status FROM program WHERE level = 1 AND state = 1 ORDER BY title ASC");
            while($fetch = mysql_fetch_assoc($sql)){
                $programid = $fetch['programID'];
                $title = $fetch['title'];
                $status = $fetch['status'];
                $output .= 
                '<tr>
                    <td style="padding-left: 20px;">'.$title.'</td>';
                if($status == 0){
                    $output .= '<td colspan="6" class="grey lighten-2"></td>';
                }
                else{
                    $totaltarget = 0;
                    $totalaccomplish = 0;
                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month <= '$before' AND year = '$year' AND program.programID = '$programid'");
                    $get = mysql_fetch_assoc($query);
                    $target = $get['target'];
                    if($target == 0){
                        $output .= '<td class="text-center">-</td>';
                    }
                    else{
                        $output .= '<td class="text-center">'.$target.'</td>';
                        $totaltarget += $target;
                    }
                    $accomplish = $get['accomplish'];
                    if($accomplish == 0){
                        $output .= '<td class="text-center">-</td>';
                    }
                    else{
                        $output .= '<td class="text-center">'.$accomplish.'</td>';
                        $totalaccomplish += $accomplish;
                    }
                    $query2 = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month >= '$before' AND month <= '$current' AND year = '$year' AND program.programID = '$programid'");
                    $get2 = mysql_fetch_assoc($query2);
                    $target2 = $get2['target'];
                    if($target2 == 0){
                        $output .= '<td class="text-center">-</td>';
                    }
                    else{
                        $output .= '<td class="text-center">'.$target2.'</td>';
                        $totaltarget += $target2;
                    }
                    $accomplish2 = $get2['accomplish'];
                    if($accomplish2 == 0){
                        $output .= '<td class="text-center">-</td>';
                    }
                    else{
                        $output .= '<td class="text-center">'.$accomplish2.'</td>';
                        $totalaccomplish += $accomplish2;
                    }
                    if($totaltarget == 0){
                        $output .= '<td class="text-center">-</td>';
                    }
                    else{
                        $output .= '<td class="text-center">'.$totaltarget.'</td>';
                    }
                    if($totalaccomplish == 0){
                        $output .= '<td class="text-center">-</td>';
                    }
                    else{
                        $output .= '<td class="text-center">'.$totalaccomplish.'</td>';
                    }
                }
                $output .= '</tr>';
//                level 2
                $sql2 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                if(mysql_num_rows($sql2) != 0){
                    while($fetch2 = mysql_fetch_assoc($sql2)){
                        $programid = $fetch2['programID'];
                        $title = $fetch2['title'];
                        $status = $fetch2['status'];
                        $output .= 
                        '<tr>
                            <td style="padding-left: 40px;">'.$title.'</td>';
                        if($status == 0){
                            $output .= '<td colspan="6" class="grey lighten-2"></td>';
                        }
                        else{
                            $totaltarget = 0;
                            $totalaccomplish = 0;
                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month <= '$before' AND year = '$year' AND program.programID = '$programid'");
                            $get = mysql_fetch_assoc($query);
                            $target = $get['target'];
                            if($target == 0){
                                $output .= '<td class="text-center">-</td>';
                            }
                            else{
                                $output .= '<td class="text-center">'.$target.'</td>';
                                $totaltarget += $target;
                            }
                            $accomplish = $get['accomplish'];
                            if($accomplish == 0){
                                $output .= '<td class="text-center">-</td>';
                            }
                            else{
                                $output .= '<td class="text-center">'.$accomplish.'</td>';
                                $totalaccomplish += $accomplish;
                            }
                            $query2 = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month > '$before' AND month <= '$current' AND year = '$year' AND program.programID = '$programid'");
                            $get2 = mysql_fetch_assoc($query2);
                            $target2 = $get2['target'];
                            if($target2 == 0){
                                $output .= '<td class="text-center">-</td>';
                            }
                            else{
                                $output .= '<td class="text-center">'.$target2.'</td>';
                                $totaltarget += $target2;
                            }
                            $accomplish2 = $get2['accomplish'];
                            if($accomplish2 == 0){
                                $output .= '<td class="text-center">-</td>';
                            }
                            else{
                                $output .= '<td class="text-center">'.$accomplish2.'</td>';
                                $totalaccomplish += $accomplish2;
                            }
                            if($totaltarget == 0){
                                $output .= '<td class="text-center">-</td>';
                            }
                            else{
                                $output .= '<td class="text-center">'.$totaltarget.'</td>';
                            }
                            if($totalaccomplish == 0){
                                $output .= '<td class="text-center">-</td>';
                            }
                            else{
                                $output .= '<td class="text-center">'.$totalaccomplish.'</td>';
                            }
                        }
                        $output .= '</tr>';
//                        level 3
                        $sql3 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                        if(mysql_num_rows($sql3) != 0){
                            while($fetch3 = mysql_fetch_assoc($sql3)){
                                $programid = $fetch3['programID'];
                                $title = $fetch3['title'];
                                $status = $fetch3['status'];
                                $output .= 
                                '<tr>
                                    <td style="padding-left: 60px;">'.$title.'</td>';
                                if($status == 0){
                                    $output .= '<td colspan="6" class="grey lighten-2"></td>';
                                }
                                else{
                                    $totaltarget = 0;
                                    $totalaccomplish = 0;
                                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month <= '$before' AND year = '$year' AND program.programID = '$programid'");
                                    $get = mysql_fetch_assoc($query);
                                    $target = $get['target'];
                                    if($target == 0){
                                        $output .= '<td class="text-center">-</td>';
                                    }
                                    else{
                                        $output .= '<td class="text-center">'.$target.'</td>';
                                        $totaltarget += $target;
                                    }
                                    $accomplish = $get['accomplish'];
                                    if($accomplish == 0){
                                        $output .= '<td class="text-center">-</td>';
                                    }
                                    else{
                                        $output .= '<td class="text-center">'.$accomplish.'</td>';
                                        $totalaccomplish += $accomplish;
                                    }
                                    $query2 = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month > '$before' AND month <= '$current' AND year = '$year' AND program.programID = '$programid'");
                                    $get2 = mysql_fetch_assoc($query2);
                                    $target2 = $get2['target'];
                                    if($target2 == 0){
                                        $output .= '<td class="text-center">-</td>';
                                    }
                                    else{
                                        $output .= '<td class="text-center">'.$target2.'</td>';
                                        $totaltarget += $target2;
                                    }
                                    $accomplish2 = $get2['accomplish'];
                                    if($accomplish2 == 0){
                                        $output .= '<td class="text-center">-</td>';
                                    }
                                    else{
                                        $output .= '<td class="text-center">'.$accomplish2.'</td>';
                                        $totalaccomplish += $accomplish2;
                                    }
                                    if($totaltarget == 0){
                                        $output .= '<td class="text-center">-</td>';
                                    }
                                    else{
                                        $output .= '<td class="text-center">'.$totaltarget.'</td>';
                                    }
                                    if($totalaccomplish == 0){
                                        $output .= '<td class="text-center">-</td>';
                                    }
                                    else{
                                        $output .= '<td class="text-center">'.$totalaccomplish.'</td>';
                                    }
                                }
                                
                                $output .= '</tr>';
//                                    level 4
                                $sql4 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                                if(mysql_num_rows($sql4) != 0){
                                    while($fetch4 = mysql_fetch_assoc($sql4)){
                                        $programid = $fetch4['programID'];
                                        $title = $fetch4['title'];
                                        $status = $fetch4['status'];
                                        $output .= 
                                        '<tr>
                                            <td style="padding-left: 80px;">'.$title.'</td>';
                                        if($status == 0){
                                            $output .= '<td colspan="6" class="grey lighten-2"></td>';
                                        }
                                        else{
                                            $totaltarget = 0;
                                            $totalaccomplish = 0;
                                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month <= '$before' AND year = '$year' AND program.programID = '$programid'");
                                            $get = mysql_fetch_assoc($query);
                                            $target = $get['target'];
                                            if($target == 0){
                                                $output .= '<td class="text-center">-</td>';
                                            }
                                            else{
                                                $output .= '<td class="text-center">'.$target.'</td>';
                                                $totaltarget += $target;
                                            }
                                            $accomplish = $get['accomplish'];
                                            if($accomplish == 0){
                                                $output .= '<td class="text-center">-</td>';
                                            }
                                            else{
                                                $output .= '<td class="text-center">'.$accomplish.'</td>';
                                                $totalaccomplish += $accomplish;
                                            }
                                            $query2 = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month > '$before' AND month <= '$current' AND year = '$year' AND program.programID = '$programid'");
                                            $get2 = mysql_fetch_assoc($query2);
                                            $target2 = $get2['target'];
                                            if($target2 == 0){
                                                $output .= '<td class="text-center">-</td>';
                                            }
                                            else{
                                                $output .= '<td class="text-center">'.$target2.'</td>';
                                                $totaltarget += $target2;
                                            }
                                            $accomplish2 = $get2['accomplish'];
                                            if($accomplish2 == 0){
                                                $output .= '<td class="text-center">-</td>';
                                            }
                                            else{
                                                $output .= '<td class="text-center">'.$accomplish2.'</td>';
                                                $totalaccomplish += $accomplish2;
                                            }
                                            if($totaltarget == 0){
                                                $output .= '<td class="text-center">-</td>';
                                            }
                                            else{
                                                $output .= '<td class="text-center">'.$totaltarget.'</td>';
                                            }
                                            if($totalaccomplish == 0){
                                                $output .= '<td class="text-center">-</td>';
                                            }
                                            else{
                                                $output .= '<td class="text-center">'.$totalaccomplish.'</td>';
                                            }
                                        }
                                        $output .= '</tr>';
//                                                level 5
                                        $sql5 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                                        if(mysql_num_rows($sql5) != 0){
                                            while($fetch5 = mysql_fetch_assoc($sql5)){
                                                $programid = $fetch5['programID'];
                                                $title = $fetch5['title'];
                                                $status = $fetch5['status'];
                                                $output .= 
                                                '<tr>
                                                    <td style="padding-left: 100px;">'.$title.'</td>';
                                                if($status == 0){
                                                    $output .= '<td colspan="6" class="grey lighten-2"></td>';
                                                }
                                                else{
                                                    $totaltarget = 0;
                                                    $totalaccomplish = 0;
                                                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month <= '$before' AND year = '$year' AND program.programID = '$programid'");
                                                    $get = mysql_fetch_assoc($query);
                                                    $target = $get['target'];
                                                    if($target == 0){
                                                        $output .= '<td class="text-center">-</td>';
                                                    }
                                                    else{
                                                        $output .= '<td class="text-center">'.$target.'</td>';
                                                        $totaltarget += $target;
                                                    }
                                                    $accomplish = $get['accomplish'];
                                                    if($accomplish == 0){
                                                        $output .= '<td class="text-center">-</td>';
                                                    }
                                                    else{
                                                        $output .= '<td class="text-center">'.$accomplish.'</td>';
                                                        $totalaccomplish += $accomplish;
                                                    }
                                                    $query2 = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month > '$before' AND month <= '$current' AND year = '$year' AND program.programID = '$programid'");
                                                    $get2 = mysql_fetch_assoc($query2);
                                                    $target2 = $get2['target'];
                                                    if($target2 == 0){
                                                        $output .= '<td class="text-center">-</td>';
                                                    }
                                                    else{
                                                        $output .= '<td class="text-center">'.$target2.'</td>';
                                                        $totaltarget += $target2;
                                                    }
                                                    $accomplish2 = $get2['accomplish'];
                                                    if($accomplish2 == 0){
                                                        $output .= '<td class="text-center">-</td>';
                                                    }
                                                    else{
                                                        $output .= '<td class="text-center">'.$accomplish2.'</td>';
                                                        $totalaccomplish += $accomplish2;
                                                    }
                                                    if($totaltarget == 0){
                                                        $output .= '<td class="text-center">-</td>';
                                                    }
                                                    else{
                                                        $output .= '<td class="text-center">'.$totaltarget.'</td>';
                                                    }
                                                    if($totalaccomplish == 0){
                                                        $output .= '<td class="text-center">-</td>';
                                                    }
                                                    else{
                                                        $output .= '<td class="text-center">'.$totalaccomplish.'</td>';
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
            $output .= '</tbody></table>';
        }
        echo json_encode($output);
    }
?>


