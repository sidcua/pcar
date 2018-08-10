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
    if($action == "fetchdata"){
        $region = mysql_escape_string($_POST['region']);
        $year = mysql_escape_string($_POST['year']);
        $accid = $_SESSION['accID'];
        $output = "";
        $target_qtotal = array(0,0,0,0,0);
        $accom_qtotal = array(0,0,0,0,0);
        $target_overalltotal = array(0, 0);
        $accom_overalltotal = array(0, 0);
        $ave_targetaccom = array(0,0,0);
        $ave_quarter = array(
            array(), array(0,0,0), array(0,0,0), array(0,0,0), array(0,0,0)
        );
        if($region != 0){
            $sub = " AND regionID = ".$region;
        }
        $output .= '<table class="table table-striped table-bordered"><thead class="mdb-color darken-3">
                        <tr class="text-center white-text">
                            <th rowspan="2" style="width: 10px;">Services Programs</th>
                            <th colspan="5">Success Indicators</th>
                            <th rowspan="2">Timelines</th>
                            <th rowspan="2">Weight</th>
                            <th rowspan="2">Person/Unit Responsible</th>
                            <th colspan="5">Actual Accomplishments</th>
                            <th rowspan="2">Rating</th>
                            <th rowspan="2">Remarks</th>
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
                    </thead><tbody>';
//        level 1
        $sql = mysql_query("SELECT program.programID, title, program.status FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN account ON assign.accID = account.accID WHERE level = 1 AND state = 1 AND account.accID = '$accid' ORDER BY title ASC");
        while($fetch = mysql_fetch_assoc($sql)){
            $programid = $fetch['programID'];
            $title = $fetch['title'];
            $status = $fetch['status'];
            $target_total = 0;
            $accom_total = 0;
            $output .= '<tr><td style="padding-left: 20px;">'.$title.'</td>';
            if($status == 0){
                $output .= '<td colspan="28" class="grey lighten-2"></td>';
            }
            else{
                $limit = 3;
                for($i = 1; $i <= 12; $i = $i + 3){
                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid'".$sub);
                    $get = mysql_fetch_assoc($query);
                    $target = $get['target'];
                    $accom = $get['accomplish'];
                    if($target != 0){
                        if($i == 1){
                            $target_q1 = $target;
                            $target_qtotal[1] += $target;
                        }
                        else if($i == 4){
                            $target_q2 = $target;
                            $target_qtotal[2] += $target;
                        }
                        else if($i == 7){
                            $target_q3 = $target;
                            $target_qtotal[3] += $target;
                        }
                        else if($i == 10){
                            $target_q4 = $target;
                            $target_qtotal[4] += $target;
                        }
                        $target_total += $target;
                        $target_overalltotal[0] += $target;
                        $target_overalltotal[1]++;
                    }
                    else{
                        if($i == 1){
                            $target_q1 = "-";
                        }
                        else if($i == 4){
                            $target_q2 = "-";
                        }
                        else if($i == 7){
                            $target_q3 = "-";
                        }
                        else if($i == 10){
                            $target_q4 = "-";
                        }
                    }
                    if($accom != 0){
                        if($i == 1){
                            $accom_q1 = $accom;
                            $accom_qtotal[1] += $accom;
                        }
                        else if($i == 4){
                            $accom_q2 = $accom;
                            $accom_qtotal[2] += $accom;
                        }
                        else if($i == 7){
                            $accom_q3 = $accom;
                            $accom_qtotal[3] += $accom;
                        }
                        else if($i == 10){
                            $accom_q4 = $accom;
                            $accom_qtotal[4] += $accom;
                        }
                        $accom_total += $accom;
                        $accom_overalltotal[0] += $accom;
                        $accom_overalltotal[1]++;
                    }
                    else{
                        if($i == 1){
                            $accom_q1 = "-";
                        }
                        else if($i == 4){
                            $accom_q2 = "-";
                        }
                        else if($i == 7){
                            $accom_q3 = "-";
                        }
                        else if($i == 10){
                            $accom_q4 = "-";
                        }
                    }
                    $limit = $limit + 3;
                }
                if($target_total == 0){
                    $target_total = "-";
                }
                if($accom_total == 0){
                    $accom_total = "-";
                }
                $output .= '<td class="text-center">'.$target_q1.'</td>
                <td class="text-center">'.$target_q2.'</td>
                <td class="text-center">'.$target_q3.'</td>
                <td class="text-center">'.$target_q4.'</td>
                <td class="text-center">'.$target_total.'</td>
                <td></td><td></td><td></td>
                <td class="text-center">'.$accom_q1.'</td>
                <td class="text-center">'.$accom_q2.'</td>
                <td class="text-center">'.$accom_q3.'</td>
                <td class="text-center">'.$accom_q4.'</td>
                <td class="text-center">'.$accom_total.'</td>';
                if($target_total != 0 && $accom_total != 0){
                    $remark = round((((($accom_total-$target_total)/$target_total)*100)+100),1);
                    if($remark >= 130){
                        $rating = 5;
                    }
                    else if($remark <= 129 && $remark >= 115){
                        $rating = 4;
                    }
                    else if($remark <= 114 && $remark >= 100){
                        $rating = 3;
                    }
                    else if($remark <= 99 && $remark >= 85){
                        $rating = 2;
                    }
                    else{
                        $rating = 1;
                    }
                    $ave_targetaccom[0] += $rating;
                    $ave_targetaccom[1] += $remark;
                    $ave_targetaccom[2]++;
                    $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                }
                else{
                    $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                }
                if($target_q1 != 0 && $accom_q1 != 0){
                    $remark = round((((($accom_q1-$target_q1)/$target_q1)*100)+100),1);
                    if($remark >= 130){
                        $rating = 5;
                    }
                    else if($remark <= 129 && $remark >= 115){
                        $rating = 4;
                    }
                    else if($remark <= 114 && $remark >= 100){
                        $rating = 3;
                    }
                    else if($remark <= 99 && $remark >= 85){
                        $rating = 2;
                    }
                    else{
                        $rating = 1;
                    }
                    $ave_quarter[1][0] += $rating;
                    $ave_quarter[1][1] += $remark;
                    $ave_quarter[1][2]++;
                    $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                }
                else{
                    $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                }
                if($target_q2 != 0 && $accom_q2 != 0){
                    $remark = round((((($accom_q2-$target_q2)/$target_q2)*100)+100),1);
                    if($remark >= 130){
                        $rating = 5;
                    }
                    else if($remark <= 129 && $remark >= 115){
                        $rating = 4;
                    }
                    else if($remark <= 114 && $remark >= 100){
                        $rating = 3;
                    }
                    else if($remark <= 99 && $remark >= 85){
                        $rating = 2;
                    }
                    else{
                        $rating = 1;
                    }
                    $ave_quarter[2][0] += $rating;
                    $ave_quarter[2][1] += $remark;
                    $ave_quarter[2][2]++;
                    $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                }
                else{
                    $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                }
                if($target_q3 != 0 && $accom_q3 != 0){
                    $remark = round((((($accom_q3-$target_q3)/$target_q3)*100)+100),1);
                    if($remark >= 130){
                        $rating = 5;
                    }
                    else if($remark <= 129 && $remark >= 115){
                        $rating = 4;
                    }
                    else if($remark <= 114 && $remark >= 100){
                        $rating = 3;
                    }
                    else if($remark <= 99 && $remark >= 85){
                        $rating = 2;
                    }
                    else{
                        $rating = 1;
                    }
                    $ave_quarter[3][0] += $rating;
                    $ave_quarter[3][1] += $remark;
                    $ave_quarter[3][2]++;
                    $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                }
                else{
                    $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                }
                if($target_q4 != 0 && $accom_q4 != 0){
                    $remark = round((((($accom_q4-$target_q4)/$target_q4)*100)+100),1);
                    if($remark >= 130){
                        $rating = 5;
                    }
                    else if($remark <= 129 && $remark >= 115){
                        $rating = 4;
                    }
                    else if($remark <= 114 && $remark >= 100){
                        $rating = 3;
                    }
                    else if($remark <= 99 && $remark >= 85){
                        $rating = 2;
                    }
                    else{
                        $rating = 1;
                    }
                    $ave_quarter[4][0] += $rating;
                    $ave_quarter[4][1] += $remark;
                    $ave_quarter[4][2]++;
                    $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                }
                else{
                    $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                }
            }
            $output .= '</tr>';
//            level 2
            $sql2 = mysql_query("SELECT program.programID, title, program.status FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN account ON assign.accID = account.accID WHERE under = '$programid' AND state = 1 AND account.accID = '$accid' ORDER BY title ASC");
            if(mysql_num_rows($sql2) != 0){
                while($fetch2 = mysql_fetch_assoc($sql2)){
                    $programid = $fetch2['programID'];
                    $title = $fetch2['title'];
                    $status = $fetch2['status'];
                    $target_total = 0;
                    $accom_total = 0;
                    $output .= '<tr><td style="padding-left: 40px;">'.$title.'</td>';
                    if($status == 0){
                        $output .= '<td colspan="28" class="grey lighten-2"></td>';
                    }
                    else{
                        $limit = 3;
                        for($i = 1; $i <= 12; $i = $i + 3){
                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid'".$sub);
                            $get = mysql_fetch_assoc($query);
                            $target = $get['target'];
                            $accom = $get['accomplish'];
                            if($target != 0){
                                if($i == 1){
                                    $target_q1 = $target;
                                    $target_qtotal[1] += $target;
                                }
                                else if($i == 4){
                                    $target_q2 = $target;
                                    $target_qtotal[2] += $target;
                                }
                                else if($i == 7){
                                    $target_q3 = $target;
                                    $target_qtotal[3] += $target;
                                }
                                else if($i == 10){
                                    $target_q4 = $target;
                                    $target_qtotal[4] += $target;
                                }
                                $target_total += $target;
                                $target_overalltotal[0] += $target;
                                $target_overalltotal[1]++;
                            }
                            else{
                                if($i == 1){
                                    $target_q1 = "-";
                                }
                                else if($i == 4){
                                    $target_q2 = "-";
                                }
                                else if($i == 7){
                                    $target_q3 = "-";
                                }
                                else if($i == 10){
                                    $target_q4 = "-";
                                }
                            }
                            if($accom != 0){
                                if($i == 1){
                                    $accom_q1 = $accom;
                                    $accom_qtotal[1] += $accom;
                                }
                                else if($i == 4){
                                    $accom_q2 = $accom;
                                    $accom_qtotal[2] += $accom;
                                }
                                else if($i == 7){
                                    $accom_q3 = $accom;
                                    $accom_qtotal[3] += $accom;
                                }
                                else if($i == 10){
                                    $accom_q4 = $accom;
                                    $accom_qtotal[4] += $accom;
                                }
                                $accom_total += $accom;
                                $accom_overalltotal[0] += $accom;
                                $accom_overalltotal[1]++;
                            }
                            else{
                                if($i == 1){
                                    $accom_q1 = "-";
                                }
                                else if($i == 4){
                                    $accom_q2 = "-";
                                }
                                else if($i == 7){
                                    $accom_q3 = "-";
                                }
                                else if($i == 10){
                                    $accom_q4 = "-";
                                }
                            }
                            $limit = $limit + 3;
                        }
                        if($target_total == 0){
                            $target_total = "-";
                        }
                        if($accom_total == 0){
                            $accom_total = "-";
                        }
                        $output .= '<td class="text-center">'.$target_q1.'</td>
                        <td class="text-center">'.$target_q2.'</td>
                        <td class="text-center">'.$target_q3.'</td>
                        <td class="text-center">'.$target_q4.'</td>
                        <td class="text-center">'.$target_total.'</td>
                        <td></td><td></td><td></td>
                        <td class="text-center">'.$accom_q1.'</td>
                        <td class="text-center">'.$accom_q2.'</td>
                        <td class="text-center">'.$accom_q3.'</td>
                        <td class="text-center">'.$accom_q4.'</td>
                        <td class="text-center">'.$accom_total.'</td>';
                        if($target_total != 0 && $accom_total != 0){
                            $remark = round((((($accom_total-$target_total)/$target_total)*100)+100),1);
                            if($remark >= 130){
                                $rating = 5;
                            }
                            else if($remark <= 129 && $remark >= 115){
                                $rating = 4;
                            }
                            else if($remark <= 114 && $remark >= 100){
                                $rating = 3;
                            }
                            else if($remark <= 99 && $remark >= 85){
                                $rating = 2;
                            }
                            else{
                                $rating = 1;
                            }
                            $ave_targetaccom[0] += $rating;
                            $ave_targetaccom[1] += $remark;
                            $ave_targetaccom[2]++;
                            $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                        }
                        else{
                            $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                        }
                        if($target_q1 != 0 && $accom_q1 != 0){
                            $remark = round((((($accom_q1-$target_q1)/$target_q1)*100)+100),1);
                            if($remark >= 130){
                                $rating = 5;
                            }
                            else if($remark <= 129 && $remark >= 115){
                                $rating = 4;
                            }
                            else if($remark <= 114 && $remark >= 100){
                                $rating = 3;
                            }
                            else if($remark <= 99 && $remark >= 85){
                                $rating = 2;
                            }
                            else{
                                $rating = 1;
                            }
                            $ave_quarter[1][0] += $rating;
                            $ave_quarter[1][1] += $remark;
                            $ave_quarter[1][2]++;
                            $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                        }
                        else{
                            $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                        }
                        if($target_q2 != 0 && $accom_q2 != 0){
                            $remark = round((((($accom_q2-$target_q2)/$target_q2)*100)+100),1);
                            if($remark >= 130){
                                $rating = 5;
                            }
                            else if($remark <= 129 && $remark >= 115){
                                $rating = 4;
                            }
                            else if($remark <= 114 && $remark >= 100){
                                $rating = 3;
                            }
                            else if($remark <= 99 && $remark >= 85){
                                $rating = 2;
                            }
                            else{
                                $rating = 1;
                            }
                            $ave_quarter[2][0] += $rating;
                            $ave_quarter[2][1] += $remark;
                            $ave_quarter[2][2]++;
                            $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                        }
                        else{
                            $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                        }
                        if($target_q3 != 0 && $accom_q3 != 0){
                            $remark = round((((($accom_q3-$target_q3)/$target_q3)*100)+100),1);
                            if($remark >= 130){
                                $rating = 5;
                            }
                            else if($remark <= 129 && $remark >= 115){
                                $rating = 4;
                            }
                            else if($remark <= 114 && $remark >= 100){
                                $rating = 3;
                            }
                            else if($remark <= 99 && $remark >= 85){
                                $rating = 2;
                            }
                            else{
                                $rating = 1;
                            }
                            $ave_quarter[3][0] += $rating;
                            $ave_quarter[3][1] += $remark;
                            $ave_quarter[3][2]++;
                            $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                        }
                        else{
                            $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                        }
                        if($target_q4 != 0 && $accom_q4 != 0){
                            $remark = round((((($accom_q4-$target_q4)/$target_q4)*100)+100),1);
                            if($remark >= 130){
                                $rating = 5;
                            }
                            else if($remark <= 129 && $remark >= 115){
                                $rating = 4;
                            }
                            else if($remark <= 114 && $remark >= 100){
                                $rating = 3;
                            }
                            else if($remark <= 99 && $remark >= 85){
                                $rating = 2;
                            }
                            else{
                                $rating = 1;
                            }
                            $ave_quarter[4][0] += $rating;
                            $ave_quarter[4][1] += $remark;
                            $ave_quarter[4][2]++;
                            $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                        }
                        else{
                            $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                        }
                    }
                    $output .= '</tr>';
//                    level 3
                    $sql3 = mysql_query("SELECT program.programID, title, program.status FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN account ON assign.accID = account.accID WHERE under = '$programid' AND state = 1 AND account.accID = '$accid' ORDER BY title ASC");
                    if(mysql_num_rows($sql3) != 0){
                        while($fetch3 = mysql_fetch_assoc($sql3)){
                            $programid = $fetch3['programID'];
                            $title = $fetch3['title'];
                            $status = $fetch3['status'];
                            $target_total = 0;
                            $accom_total = 0;
                            $output .= '<tr><td style="padding-left: 60px;">'.$title.'</td>';
                            if($status == 0){
                                $output .= '<td colspan="28" class="grey lighten-2"></td>';
                            }
                            else{
                                $limit = 3;
                                for($i = 1; $i <= 12; $i = $i + 3){
                                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid'".$sub);
                                    $get = mysql_fetch_assoc($query);
                                    $target = $get['target'];
                                    $accom = $get['accomplish'];
                                    if($target != 0){
                                        if($i == 1){
                                            $target_q1 = $target;
                                            $target_qtotal[1] += $target;
                                        }
                                        else if($i == 4){
                                            $target_q2 = $target;
                                            $target_qtotal[2] += $target;
                                        }
                                        else if($i == 7){
                                            $target_q3 = $target;
                                            $target_qtotal[3] += $target;
                                        }
                                        else if($i == 10){
                                            $target_q4 = $target;
                                            $target_qtotal[4] += $target;
                                        }
                                        $target_total += $target;
                                        $target_overalltotal[0] += $target;
                                        $target_overalltotal[1]++;
                                    }
                                    else{
                                        if($i == 1){
                                            $target_q1 = "-";
                                        }
                                        else if($i == 4){
                                            $target_q2 = "-";
                                        }
                                        else if($i == 7){
                                            $target_q3 = "-";
                                        }
                                        else if($i == 10){
                                            $target_q4 = "-";
                                        }
                                    }
                                    if($accom != 0){
                                        if($i == 1){
                                            $accom_q1 = $accom;
                                            $accom_qtotal[1] += $accom;
                                        }
                                        else if($i == 4){
                                            $accom_q2 = $accom;
                                            $accom_qtotal[2] += $accom;
                                        }
                                        else if($i == 7){
                                            $accom_q3 = $accom;
                                            $accom_qtotal[3] += $accom;
                                        }
                                        else if($i == 10){
                                            $accom_q4 = $accom;
                                            $accom_qtotal[4] += $accom;
                                        }
                                        $accom_total += $accom;
                                        $accom_overalltotal[0] += $accom;
                                        $accom_overalltotal[1]++;
                                    }
                                    else{
                                        if($i == 1){
                                            $accom_q1 = "-";
                                        }
                                        else if($i == 4){
                                            $accom_q2 = "-";
                                        }
                                        else if($i == 7){
                                            $accom_q3 = "-";
                                        }
                                        else if($i == 10){
                                            $accom_q4 = "-";
                                        }
                                    }
                                    $limit = $limit + 3;
                                }
                                if($target_total == 0){
                                    $target_total = "-";
                                }
                                if($accom_total == 0){
                                    $accom_total = "-";
                                }
                                $output .= '<td class="text-center">'.$target_q1.'</td>
                                <td class="text-center">'.$target_q2.'</td>
                                <td class="text-center">'.$target_q3.'</td>
                                <td class="text-center">'.$target_q4.'</td>
                                <td class="text-center">'.$target_total.'</td>
                                <td></td><td></td><td></td>
                                <td class="text-center">'.$accom_q1.'</td>
                                <td class="text-center">'.$accom_q2.'</td>
                                <td class="text-center">'.$accom_q3.'</td>
                                <td class="text-center">'.$accom_q4.'</td>
                                <td class="text-center">'.$accom_total.'</td>';
                                if($target_total != 0 && $accom_total != 0){
                                    $remark = round((((($accom_total-$target_total)/$target_total)*100)+100),1);
                                    if($remark >= 130){
                                        $rating = 5;
                                    }
                                    else if($remark <= 129 && $remark >= 115){
                                        $rating = 4;
                                    }
                                    else if($remark <= 114 && $remark >= 100){
                                        $rating = 3;
                                    }
                                    else if($remark <= 99 && $remark >= 85){
                                        $rating = 2;
                                    }
                                    else{
                                        $rating = 1;
                                    }
                                    $ave_targetaccom[0] += $rating;
                                    $ave_targetaccom[1] += $remark;
                                    $ave_targetaccom[2]++;
                                    $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                                }
                                else{
                                    $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                                }
                                if($target_q1 != 0 && $accom_q1 != 0){
                                    $remark = round((((($accom_q1-$target_q1)/$target_q1)*100)+100),1);
                                    if($remark >= 130){
                                        $rating = 5;
                                    }
                                    else if($remark <= 129 && $remark >= 115){
                                        $rating = 4;
                                    }
                                    else if($remark <= 114 && $remark >= 100){
                                        $rating = 3;
                                    }
                                    else if($remark <= 99 && $remark >= 85){
                                        $rating = 2;
                                    }
                                    else{
                                        $rating = 1;
                                    }
                                    $ave_quarter[1][0] += $rating;
                                    $ave_quarter[1][1] += $remark;
                                    $ave_quarter[1][2]++;
                                    $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                                }
                                else{
                                    $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                                }
                                if($target_q2 != 0 && $accom_q2 != 0){
                                    $remark = round((((($accom_q2-$target_q2)/$target_q2)*100)+100),1);
                                    if($remark >= 130){
                                        $rating = 5;
                                    }
                                    else if($remark <= 129 && $remark >= 115){
                                        $rating = 4;
                                    }
                                    else if($remark <= 114 && $remark >= 100){
                                        $rating = 3;
                                    }
                                    else if($remark <= 99 && $remark >= 85){
                                        $rating = 2;
                                    }
                                    else{
                                        $rating = 1;
                                    }
                                    $ave_quarter[2][0] += $rating;
                                    $ave_quarter[2][1] += $remark;
                                    $ave_quarter[2][2]++;
                                    $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                                }
                                else{
                                    $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                                }
                                if($target_q3 != 0 && $accom_q3 != 0){
                                    $remark = round((((($accom_q3-$target_q3)/$target_q3)*100)+100),1);
                                    if($remark >= 130){
                                        $rating = 5;
                                    }
                                    else if($remark <= 129 && $remark >= 115){
                                        $rating = 4;
                                    }
                                    else if($remark <= 114 && $remark >= 100){
                                        $rating = 3;
                                    }
                                    else if($remark <= 99 && $remark >= 85){
                                        $rating = 2;
                                    }
                                    else{
                                        $rating = 1;
                                    }
                                    $ave_quarter[3][0] += $rating;
                                    $ave_quarter[3][1] += $remark;
                                    $ave_quarter[3][2]++;
                                    $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                                }
                                else{
                                    $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                                }
                                if($target_q4 != 0 && $accom_q4 != 0){
                                    $remark = round((((($accom_q4-$target_q4)/$target_q4)*100)+100),1);
                                    if($remark >= 130){
                                        $rating = 5;
                                    }
                                    else if($remark <= 129 && $remark >= 115){
                                        $rating = 4;
                                    }
                                    else if($remark <= 114 && $remark >= 100){
                                        $rating = 3;
                                    }
                                    else if($remark <= 99 && $remark >= 85){
                                        $rating = 2;
                                    }
                                    else{
                                        $rating = 1;
                                    }
                                    $ave_quarter[4][0] += $rating;
                                    $ave_quarter[4][1] += $remark;
                                    $ave_quarter[4][2]++;
                                    $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                                }
                                else{
                                    $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                                }
                            }
                            $output .= '</tr>';
//                            level 4
                            $sql4 = mysql_query("SELECT program.programID, title, program.status FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN account ON assign.accID = account.accID WHERE under = '$programid' AND state = 1 AND account.accID = '$accid' ORDER BY title ASC");
                            if(mysql_num_rows($sql4) != 0){
                                while($fetch4 = mysql_fetch_assoc($sql4)){
                                    $programid = $fetch4['programID'];
                                    $title = $fetch4['title'];
                                    $status = $fetch4['status'];
                                    $target_total = 0;
                                    $accom_total = 0;
                                    $output .= '<tr><td style="padding-left: 80px;">'.$title.'</td>';
                                    if($status == 0){
                                        $output .= '<td colspan="28" class="grey lighten-2"></td>';
                                    }
                                    else{
                                        $limit = 3;
                                        for($i = 1; $i <= 12; $i = $i + 3){
                                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid'".$sub);
                                            $get = mysql_fetch_assoc($query);
                                            $target = $get['target'];
                                            $accom = $get['accomplish'];
                                            if($target != 0){
                                                if($i == 1){
                                                    $target_q1 = $target;
                                                    $target_qtotal[1] += $target;
                                                }
                                                else if($i == 4){
                                                    $target_q2 = $target;
                                                    $target_qtotal[2] += $target;
                                                }
                                                else if($i == 7){
                                                    $target_q3 = $target;
                                                    $target_qtotal[3] += $target;
                                                }
                                                else if($i == 10){
                                                    $target_q4 = $target;
                                                    $target_qtotal[4] += $target;
                                                }
                                                $target_total += $target;
                                                $target_overalltotal[0] += $target;
                                                $target_overalltotal[1]++;
                                            }
                                            else{
                                                if($i == 1){
                                                    $target_q1 = "-";
                                                }
                                                else if($i == 4){
                                                    $target_q2 = "-";
                                                }
                                                else if($i == 7){
                                                    $target_q3 = "-";
                                                }
                                                else if($i == 10){
                                                    $target_q4 = "-";
                                                }
                                            }
                                            if($accom != 0){
                                                if($i == 1){
                                                    $accom_q1 = $accom;
                                                    $accom_qtotal[1] += $accom;
                                                }
                                                else if($i == 4){
                                                    $accom_q2 = $accom;
                                                    $accom_qtotal[2] += $accom;
                                                }
                                                else if($i == 7){
                                                    $accom_q3 = $accom;
                                                    $accom_qtotal[3] += $accom;
                                                }
                                                else if($i == 10){
                                                    $accom_q4 = $accom;
                                                    $accom_qtotal[4] += $accom;
                                                }
                                                $accom_total += $accom;
                                                $accom_overalltotal[0] += $accom;
                                                $accom_overalltotal[1]++;
                                            }
                                            else{
                                                if($i == 1){
                                                    $accom_q1 = "-";
                                                }
                                                else if($i == 4){
                                                    $accom_q2 = "-";
                                                }
                                                else if($i == 7){
                                                    $accom_q3 = "-";
                                                }
                                                else if($i == 10){
                                                    $accom_q4 = "-";
                                                }
                                            }
                                            $limit = $limit + 3;
                                        }
                                        if($target_total == 0){
                                            $target_total = "-";
                                        }
                                        if($accom_total == 0){
                                            $accom_total = "-";
                                        }
                                        $output .= '<td class="text-center">'.$target_q1.'</td>
                                        <td class="text-center">'.$target_q2.'</td>
                                        <td class="text-center">'.$target_q3.'</td>
                                        <td class="text-center">'.$target_q4.'</td>
                                        <td class="text-center">'.$target_total.'</td>
                                        <td></td><td></td><td></td>
                                        <td class="text-center">'.$accom_q1.'</td>
                                        <td class="text-center">'.$accom_q2.'</td>
                                        <td class="text-center">'.$accom_q3.'</td>
                                        <td class="text-center">'.$accom_q4.'</td>
                                        <td class="text-center">'.$accom_total.'</td>';
                                        if($target_total != 0 && $accom_total != 0){
                                            $remark = round((((($accom_total-$target_total)/$target_total)*100)+100),1);
                                            if($remark >= 130){
                                                $rating = 5;
                                            }
                                            else if($remark <= 129 && $remark >= 115){
                                                $rating = 4;
                                            }
                                            else if($remark <= 114 && $remark >= 100){
                                                $rating = 3;
                                            }
                                            else if($remark <= 99 && $remark >= 85){
                                                $rating = 2;
                                            }
                                            else{
                                                $rating = 1;
                                            }
                                            $ave_targetaccom[0] += $rating;
                                            $ave_targetaccom[1] += $remark;
                                            $ave_targetaccom[2]++;
                                            $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                                        }
                                        else{
                                            $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                                        }
                                        if($target_q1 != 0 && $accom_q1 != 0){
                                            $remark = round((((($accom_q1-$target_q1)/$target_q1)*100)+100),1);
                                            if($remark >= 130){
                                                $rating = 5;
                                            }
                                            else if($remark <= 129 && $remark >= 115){
                                                $rating = 4;
                                            }
                                            else if($remark <= 114 && $remark >= 100){
                                                $rating = 3;
                                            }
                                            else if($remark <= 99 && $remark >= 85){
                                                $rating = 2;
                                            }
                                            else{
                                                $rating = 1;
                                            }
                                            $ave_quarter[1][0] += $rating;
                                            $ave_quarter[1][1] += $remark;
                                            $ave_quarter[1][2]++;
                                            $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                                        }
                                        else{
                                            $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                                        }
                                        if($target_q2 != 0 && $accom_q2 != 0){
                                            $remark = round((((($accom_q2-$target_q2)/$target_q2)*100)+100),1);
                                            if($remark >= 130){
                                                $rating = 5;
                                            }
                                            else if($remark <= 129 && $remark >= 115){
                                                $rating = 4;
                                            }
                                            else if($remark <= 114 && $remark >= 100){
                                                $rating = 3;
                                            }
                                            else if($remark <= 99 && $remark >= 85){
                                                $rating = 2;
                                            }
                                            else{
                                                $rating = 1;
                                            }
                                            $ave_quarter[2][0] += $rating;
                                            $ave_quarter[2][1] += $remark;
                                            $ave_quarter[2][2]++;
                                            $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                                        }
                                        else{
                                            $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                                        }
                                        if($target_q3 != 0 && $accom_q3 != 0){
                                            $remark = round((((($accom_q3-$target_q3)/$target_q3)*100)+100),1);
                                            if($remark >= 130){
                                                $rating = 5;
                                            }
                                            else if($remark <= 129 && $remark >= 115){
                                                $rating = 4;
                                            }
                                            else if($remark <= 114 && $remark >= 100){
                                                $rating = 3;
                                            }
                                            else if($remark <= 99 && $remark >= 85){
                                                $rating = 2;
                                            }
                                            else{
                                                $rating = 1;
                                            }
                                            $ave_quarter[3][0] += $rating;
                                            $ave_quarter[3][1] += $remark;
                                            $ave_quarter[3][2]++;
                                            $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                                        }
                                        else{
                                            $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                                        }
                                        if($target_q4 != 0 && $accom_q4 != 0){
                                            $remark = round((((($accom_q4-$target_q4)/$target_q4)*100)+100),1);
                                            if($remark >= 130){
                                                $rating = 5;
                                            }
                                            else if($remark <= 129 && $remark >= 115){
                                                $rating = 4;
                                            }
                                            else if($remark <= 114 && $remark >= 100){
                                                $rating = 3;
                                            }
                                            else if($remark <= 99 && $remark >= 85){
                                                $rating = 2;
                                            }
                                            else{
                                                $rating = 1;
                                            }
                                            $ave_quarter[4][0] += $rating;
                                            $ave_quarter[4][1] += $remark;
                                            $ave_quarter[4][2]++;
                                            $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                                        }
                                        else{
                                            $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                                        }
                                    }
                                    $output .= '</tr>';
//                                    level 5
                                    $sql5 = mysql_query("SELECT program.programID, title, program.status FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN account ON assign.accID = account.accID WHERE under = '$programid' AND state = 1 AND account.accID = '$accid' ORDER BY title ASC");
                                    if(mysql_num_rows($sql5) != 0){
                                        while($fetch5 = mysql_fetch_assoc($sql5)){
                                            $programid = $fetch5['programID'];
                                            $title = $fetch5['title'];
                                            $status = $fetch5['status'];
                                            $target_total = 0;
                                            $accom_total = 0;
                                            $output .= '<tr><td style="padding-left: 100px;">'.$title.'</td>';
                                            if($status == 0){
                                                $output .= '<td colspan="28" class="grey lighten-2"></td>';
                                            }
                                            else{
                                                $limit = 3;
                                                for($i = 1; $i <= 12; $i = $i + 3){
                                                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid'".$sub);
                                                    $get = mysql_fetch_assoc($query);
                                                    $target = $get['target'];
                                                    $accom = $get['accomplish'];
                                                    if($target != 0){
                                                        if($i == 1){
                                                            $target_q1 = $target;
                                                            $target_qtotal[1] += $target;
                                                        }
                                                        else if($i == 4){
                                                            $target_q2 = $target;
                                                            $target_qtotal[2] += $target;
                                                        }
                                                        else if($i == 7){
                                                            $target_q3 = $target;
                                                            $target_qtotal[3] += $target;
                                                        }
                                                        else if($i == 10){
                                                            $target_q4 = $target;
                                                            $target_qtotal[4] += $target;
                                                        }
                                                        $target_total += $target;
                                                        $target_overalltotal[0] += $target;
                                                        $target_overalltotal[1]++;
                                                    }
                                                    else{
                                                        if($i == 1){
                                                            $target_q1 = "-";
                                                        }
                                                        else if($i == 4){
                                                            $target_q2 = "-";
                                                        }
                                                        else if($i == 7){
                                                            $target_q3 = "-";
                                                        }
                                                        else if($i == 10){
                                                            $target_q4 = "-";
                                                        }
                                                    }
                                                    if($accom != 0){
                                                        if($i == 1){
                                                            $accom_q1 = $accom;
                                                            $accom_qtotal[1] += $accom;
                                                        }
                                                        else if($i == 4){
                                                            $accom_q2 = $accom;
                                                            $accom_qtotal[2] += $accom;
                                                        }
                                                        else if($i == 7){
                                                            $accom_q3 = $accom;
                                                            $accom_qtotal[3] += $accom;
                                                        }
                                                        else if($i == 10){
                                                            $accom_q4 = $accom;
                                                            $accom_qtotal[4] += $accom;
                                                        }
                                                        $accom_total += $accom;
                                                        $accom_overalltotal[0] += $accom;
                                                        $accom_overalltotal[1]++;
                                                    }
                                                    else{
                                                        if($i == 1){
                                                            $accom_q1 = "-";
                                                        }
                                                        else if($i == 4){
                                                            $accom_q2 = "-";
                                                        }
                                                        else if($i == 7){
                                                            $accom_q3 = "-";
                                                        }
                                                        else if($i == 10){
                                                            $accom_q4 = "-";
                                                        }
                                                    }
                                                    $limit = $limit + 3;
                                                }
                                                if($target_total == 0){
                                                    $target_total = "-";
                                                }
                                                if($accom_total == 0){
                                                    $accom_total = "-";
                                                }
                                                $output .= '<td class="text-center">'.$target_q1.'</td>
                                                <td class="text-center">'.$target_q2.'</td>
                                                <td class="text-center">'.$target_q3.'</td>
                                                <td class="text-center">'.$target_q4.'</td>
                                                <td class="text-center">'.$target_total.'</td>
                                                <td></td><td></td><td></td>
                                                <td class="text-center">'.$accom_q1.'</td>
                                                <td class="text-center">'.$accom_q2.'</td>
                                                <td class="text-center">'.$accom_q3.'</td>
                                                <td class="text-center">'.$accom_q4.'</td>
                                                <td class="text-center">'.$accom_total.'</td>';
                                                if($target_total != 0 && $accom_total != 0){
                                                    $remark = round((((($accom_total-$target_total)/$target_total)*100)+100),1);
                                                    if($remark >= 130){
                                                        $rating = 5;
                                                    }
                                                    else if($remark <= 129 && $remark >= 115){
                                                        $rating = 4;
                                                    }
                                                    else if($remark <= 114 && $remark >= 100){
                                                        $rating = 3;
                                                    }
                                                    else if($remark <= 99 && $remark >= 85){
                                                        $rating = 2;
                                                    }
                                                    else{
                                                        $rating = 1;
                                                    }
                                                    $ave_targetaccom[0] += $rating;
                                                    $ave_targetaccom[1] += $remark;
                                                    $ave_targetaccom[2]++;
                                                    $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                                                }
                                                else{
                                                    $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                                                }
                                                if($target_q1 != 0 && $accom_q1 != 0){
                                                    $remark = round((((($accom_q1-$target_q1)/$target_q1)*100)+100),1);
                                                    if($remark >= 130){
                                                        $rating = 5;
                                                    }
                                                    else if($remark <= 129 && $remark >= 115){
                                                        $rating = 4;
                                                    }
                                                    else if($remark <= 114 && $remark >= 100){
                                                        $rating = 3;
                                                    }
                                                    else if($remark <= 99 && $remark >= 85){
                                                        $rating = 2;
                                                    }
                                                    else{
                                                        $rating = 1;
                                                    }
                                                    $ave_quarter[1][0] += $rating;
                                                    $ave_quarter[1][1] += $remark;
                                                    $ave_quarter[1][2]++;
                                                    $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                                                }
                                                else{
                                                    $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                                                }
                                                if($target_q2 != 0 && $accom_q2 != 0){
                                                    $remark = round((((($accom_q2-$target_q2)/$target_q2)*100)+100),1);
                                                    if($remark >= 130){
                                                        $rating = 5;
                                                    }
                                                    else if($remark <= 129 && $remark >= 115){
                                                        $rating = 4;
                                                    }
                                                    else if($remark <= 114 && $remark >= 100){
                                                        $rating = 3;
                                                    }
                                                    else if($remark <= 99 && $remark >= 85){
                                                        $rating = 2;
                                                    }
                                                    else{
                                                        $rating = 1;
                                                    }
                                                    $ave_quarter[2][0] += $rating;
                                                    $ave_quarter[2][1] += $remark;
                                                    $ave_quarter[2][2]++;
                                                    $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                                                }
                                                else{
                                                    $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                                                }
                                                if($target_q3 != 0 && $accom_q3 != 0){
                                                    $remark = round((((($accom_q3-$target_q3)/$target_q3)*100)+100),1);
                                                    if($remark >= 130){
                                                        $rating = 5;
                                                    }
                                                    else if($remark <= 129 && $remark >= 115){
                                                        $rating = 4;
                                                    }
                                                    else if($remark <= 114 && $remark >= 100){
                                                        $rating = 3;
                                                    }
                                                    else if($remark <= 99 && $remark >= 85){
                                                        $rating = 2;
                                                    }
                                                    else{
                                                        $rating = 1;
                                                    }
                                                    $ave_quarter[3][0] += $rating;
                                                    $ave_quarter[3][1] += $remark;
                                                    $ave_quarter[3][2]++;
                                                    $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                                                }
                                                else{
                                                    $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
                                                }
                                                if($target_q4 != 0 && $accom_q4 != 0){
                                                    $remark = round((((($accom_q4-$target_q4)/$target_q4)*100)+100),1);
                                                    if($remark >= 130){
                                                        $rating = 5;
                                                    }
                                                    else if($remark <= 129 && $remark >= 115){
                                                        $rating = 4;
                                                    }
                                                    else if($remark <= 114 && $remark >= 100){
                                                        $rating = 3;
                                                    }
                                                    else if($remark <= 99 && $remark >= 85){
                                                        $rating = 2;
                                                    }
                                                    else{
                                                        $rating = 1;
                                                    }
                                                    $ave_quarter[4][0] += $rating;
                                                    $ave_quarter[4][1] += $remark;
                                                    $ave_quarter[4][2]++;
                                                    $output .= '<td class="text-center">'.$rating.'</td><td class="text-center">'.$remark.'</td>';
                                                }
                                                else{
                                                    $output .= '<td class="text-center">-</td><td class="text-center">-</td>';
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
        $output .= '<tr class="red-text"><td>TOTAL</td>
        <td class="text-center">'.$target_qtotal[1].'</td>
        <td class="text-center">'.$target_qtotal[2].'</td>
        <td class="text-center">'.$target_qtotal[3].'</td>
        <td class="text-center">'.$target_qtotal[4].'</td>
        <td class="text-center">'.$target_overalltotal[0].'</td>
        <td colspan="3"></td>
        <td class="text-center">'.$accom_qtotal[1].'</td>
        <td class="text-center">'.$accom_qtotal[2].'</td>
        <td class="text-center">'.$accom_qtotal[3].'</td>
        <td class="text-center">'.$accom_qtotal[4].'</td>
        <td class="text-center">'.$accom_overalltotal[0].'</td>
        <td class="text-center">'.round($ave_targetaccom[0]/$ave_targetaccom[2])    .'</td>
        <td class="text-center">'.round($ave_targetaccom[1]/$ave_targetaccom[2], 1).'</td>
        <td class="text-center">'.round($ave_quarter[1][0]/$ave_quarter[1][2]).'</td>
        <td class="text-center">'.round($ave_quarter[1][1]/$ave_quarter[1][2], 1).'</td>
        <td class="text-center">'.round($ave_quarter[2][0]/$ave_quarter[2][2]).'</td>
        <td class="text-center">'.round($ave_quarter[2][1]/$ave_quarter[2][2], 1).'</td>
        <td class="text-center">'.round($ave_quarter[3][0]/$ave_quarter[3][2]).'</td>
        <td class="text-center">'.round($ave_quarter[3][1]/$ave_quarter[3][2], 1).'</td>
        <td class="text-center">'.round($ave_quarter[4][0]/$ave_quarter[4][2]).'</td>
        <td class="text-center">'.round($ave_quarter[4][1]/$ave_quarter[4][2], 1).'</td></tr>';
        $output .= '</tbody>';
        echo json_encode($output);
    }
?>