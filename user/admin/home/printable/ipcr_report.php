<?php
    session_start();
    include '../../../../php/checksession.php';
    include '../../../../php/checkaccount.php';
    include '../../../../php/connect.php';
    $region = mysql_escape_string($_GET['region']);
    $year = mysql_escape_string($_GET['year']);
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
                </thead><tbody>';
    //level 1
    $sql = mysql_query("SELECT programID, title, status FROM program WHERE level = 1 AND state = 1 AND reportID = 2");
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
            for($i = 1; $i <= 4; $i++){
                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);
                $get = mysql_fetch_assoc($query);
                $target = $get['target'];
                $accom = $get['accomplish'];
                if($target != 0){
                    if($i == 1){
                        $target_q1 = $target;
                        $target_qtotal[1] += $target;
                    }
                    else if($i == 2){
                        $target_q2 = $target;
                        $target_qtotal[2] += $target;
                    }
                    else if($i == 3){
                        $target_q3 = $target;
                        $target_qtotal[3] += $target;
                    }
                    else if($i == 4){
                        $target_q4 = $target;
                        $target_qtotal[4] += $target;
                    }
                    $target_total += $target;
                    $target_overalltotal[0] += $target;
                    $target_overalltotal[1]++;
                }
                if($accom != 0){
                    if($i == 1){
                        $accom_q1 = $accom;
                        $accom_qtotal[1] += $accom;
                    }
                    else if($i == 2){
                        $accom_q2 = $accom;
                        $accom_qtotal[2] += $accom;
                    }
                    else if($i == 3){
                        $accom_q3 = $accom;
                        $accom_qtotal[3] += $accom;
                    }
                    else if($i == 4){
                        $accom_q4 = $accom;
                        $accom_qtotal[4] += $accom;
                    }
                    $accom_total += $accom;
                    $accom_overalltotal[0] += $accom;
                    $accom_overalltotal[1]++;
                }
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
        //level 2
        $sql2 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1");
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
                    for($i = 1; $i <= 4; $i++){
                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);
                        $get = mysql_fetch_assoc($query);
                        $target = $get['target'];
                        $accom = $get['accomplish'];
                        if($target != 0){
                            if($i == 1){
                                $target_q1 = $target;
                                $target_qtotal[1] += $target;
                            }
                            else if($i == 2){
                                $target_q2 = $target;
                                $target_qtotal[2] += $target;
                            }
                            else if($i == 3){
                                $target_q3 = $target;
                                $target_qtotal[3] += $target;
                            }
                            else if($i == 4){
                                $target_q4 = $target;
                                $target_qtotal[4] += $target;
                            }
                            $target_total += $target;
                            $target_overalltotal[0] += $target;
                            $target_overalltotal[1]++;
                        }
                        if($accom != 0){
                            if($i == 1){
                                $accom_q1 = $accom;
                                $accom_qtotal[1] += $accom;
                            }
                            else if($i == 2){
                                $accom_q2 = $accom;
                                $accom_qtotal[2] += $accom;
                            }
                            else if($i == 3){
                                $accom_q3 = $accom;
                                $accom_qtotal[3] += $accom;
                            }
                            else if($i == 4){
                                $accom_q4 = $accom;
                                $accom_qtotal[4] += $accom;
                            }
                            $accom_total += $accom;
                            $accom_overalltotal[0] += $accom;
                            $accom_overalltotal[1]++;
                        }
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
                //level 3
                $sql3 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1");
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
                            for($i = 1; $i <= 4; $i++){
                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);
                                $get = mysql_fetch_assoc($query);
                                $target = $get['target'];
                                $accom = $get['accomplish'];
                                if($target != 0){
                                    if($i == 1){
                                        $target_q1 = $target;
                                        $target_qtotal[1] += $target;
                                    }
                                    else if($i == 2){
                                        $target_q2 = $target;
                                        $target_qtotal[2] += $target;
                                    }
                                    else if($i == 3){
                                        $target_q3 = $target;
                                        $target_qtotal[3] += $target;
                                    }
                                    else if($i == 4){
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
                                    else if($i == 2){
                                        $target_q2 = "-";
                                    }
                                    else if($i == 3){
                                        $target_q3 = "-";
                                    }
                                    else if($i == 4){
                                        $target_q4 = "-";
                                    }
                                }
                                if($accom != 0){
                                    if($i == 1){
                                        $accom_q1 = $accom;
                                        $accom_qtotal[1] += $accom;
                                    }
                                    else if($i == 2){
                                        $accom_q2 = $accom;
                                        $accom_qtotal[2] += $accom;
                                    }
                                    else if($i == 3){
                                        $accom_q3 = $accom;
                                        $accom_qtotal[3] += $accom;
                                    }
                                    else if($i == 4){
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
                                    else if($i == 2){
                                        $accom_q2 = "-";
                                    }
                                    else if($i == 3){
                                        $accom_q3 = "-";
                                    }
                                    else if($i == 4){
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
                        //level 4
                        $sql4 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1");
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
                                    for($i = 1; $i <= 4; $i++){
                                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);
                                        $get = mysql_fetch_assoc($query);
                                        $target = $get['target'];
                                        $accom = $get['accomplish'];
                                        if($target != 0){
                                            if($i == 1){
                                                $target_q1 = $target;
                                                $target_qtotal[1] += $target;
                                            }
                                            else if($i == 2){
                                                $target_q2 = $target;
                                                $target_qtotal[2] += $target;
                                            }
                                            else if($i == 3){
                                                $target_q3 = $target;
                                                $target_qtotal[3] += $target;
                                            }
                                            else if($i == 4){
                                                $target_q4 = $target;
                                                $target_qtotal[4] += $target;
                                            }
                                            $target_total += $target;
                                            $target_overalltotal[0] += $target;
                                            $target_overalltotal[1]++;
                                        }
                                        if($accom != 0){
                                            if($i == 1){
                                                $accom_q1 = $accom;
                                                $accom_qtotal[1] += $accom;
                                            }
                                            else if($i == 2){
                                                $accom_q2 = $accom;
                                                $accom_qtotal[2] += $accom;
                                            }
                                            else if($i == 3){
                                                $accom_q3 = $accom;
                                                $accom_qtotal[3] += $accom;
                                            }
                                            else if($i == 4){
                                                $accom_q4 = $accom;
                                                $accom_qtotal[4] += $accom;
                                            }
                                            $accom_total += $accom;
                                            $accom_overalltotal[0] += $accom;
                                            $accom_overalltotal[1]++;
                                        }
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
                                //level 5
                                $sql5 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1");
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
                                            for($i = 1; $i <= 4; $i++){
                                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);
                                                $get = mysql_fetch_assoc($query);
                                                $target = $get['target'];
                                                $accom = $get['accomplish'];
                                                if($target != 0){
                                                    if($i == 1){
                                                        $target_q1 = $target;
                                                        $target_qtotal[1] += $target;
                                                    }
                                                    else if($target == 2){
                                                        $target_q2 = $target;
                                                        $target_qtotal[2] += $target;
                                                    }
                                                    else if($target == 3){
                                                        $target_q3 = $target;
                                                        $target_qtotal[3] += $target;
                                                    }
                                                    else if($target == 4){
                                                        $target_q4 = $target;
                                                        $target_qtotal[4] += $target;
                                                    }
                                                    $target_total += $target;
                                                    $target_overalltotal[0] += $target;
                                                    $target_overalltotal[1]++;
                                                }
                                                if($accom != 0){
                                                    if($i == 1){
                                                        $accom_q1 = $accom;
                                                        $accom_qtotal[1] += $accom;
                                                    }
                                                    else if($i == 2){
                                                        $accom_q2 = $accom;
                                                        $accom_qtotal[2] += $accom;
                                                    }
                                                    else if($i == 3){
                                                        $accom_q3 = $accom;
                                                        $accom_qtotal[3] += $accom;
                                                    }
                                                    else if($i == 4){
                                                        $accom_q4 = $accom;
                                                        $accom_qtotal[4] += $accom;
                                                    }
                                                    $accom_total += $accom;
                                                    $accom_overalltotal[0] += $accom;
                                                    $accom_overalltotal[1]++;
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
                                        //level 6
                                        $sql6 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1");
                                        if(mysql_num_rows($sql6) != 0){
                                            while($fetch6 = mysql_fetch_assoc($sql6)){
                                                $programid = $fetch6['programID'];
                                                $title = $fetch6['title'];
                                                $status = $fetch6['status'];
                                                $target_total = 0;
                                                $accom_total = 0;
                                                $output .= '<tr><td style="padding-left: 120px;">'.$title.'</td>';
                                                if($status == 0){
                                                    $output .= '<td colspan="28" class="grey lighten-2"></td>';
                                                }
                                                else{
                                                    for($i = 1; $i <= 4; $i++){
                                                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);
                                                        $get = mysql_fetch_assoc($query);
                                                        $target = $get['target'];
                                                        $accom = $get['accomplish'];
                                                        if($target != 0){
                                                            if($i == 1){
                                                                $target_q1 = $target;
                                                                $target_qtotal[1] += $target;
                                                            }
                                                            else if($target == 2){
                                                                $target_q2 = $target;
                                                                $target_qtotal[2] += $target;
                                                            }
                                                            else if($target == 3){
                                                                $target_q3 = $target;
                                                                $target_qtotal[3] += $target;
                                                            }
                                                            else if($target == 4){
                                                                $target_q4 = $target;
                                                                $target_qtotal[4] += $target;
                                                            }
                                                            $target_total += $target;
                                                            $target_overalltotal[0] += $target;
                                                            $target_overalltotal[1]++;
                                                        }
                                                        if($accom != 0){
                                                            if($i == 1){
                                                                $accom_q1 = $accom;
                                                                $accom_qtotal[1] += $accom;
                                                            }
                                                            else if($i == 2){
                                                                $accom_q2 = $accom;
                                                                $accom_qtotal[2] += $accom;
                                                            }
                                                            else if($i == 3){
                                                                $accom_q3 = $accom;
                                                                $accom_qtotal[3] += $accom;
                                                            }
                                                            else if($i == 4){
                                                                $accom_q4 = $accom;
                                                                $accom_qtotal[4] += $accom;
                                                            }
                                                            $accom_total += $accom;
                                                            $accom_overalltotal[0] += $accom;
                                                            $accom_overalltotal[1]++;
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
    <td class="text-center">'.round($ave_targetaccom[0]/$ave_targetaccom[2]).'</td>
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
    $output2 .= '
    <div class="row">
        <table class="table table-bordered">
            <thead class="mdb-color darken-3">
                    <tr class="text-center white-text">
                    <th colspan="2">Milestones</th>
                </tr>
                    <tr class="text-center white-text">
                            <th style="width: 300px;">Personnel</th>
                    <th>Milestone</th>
                    </tr>
            </thead>
            <tbody>';
    $sql = mysql_query("SELECT DISTINCT(account.accID), name FROM account INNER JOIN milestone ON account.accID = milestone.accID WHERE reportID = 2 AND year = '$year'".$sub);
            if(mysql_num_rows($sql) != 0){
                while($fetch = mysql_fetch_assoc($sql)){
                    $accid = $fetch['accID'];
                    $name = $fetch['name'];
                    $query = mysql_query("SELECT milestone FROM milestone WHERE accID = '$accid' AND year = '$year'");
                    while($get = mysql_fetch_assoc($query)){
                        $milestone = $get['milestone'];
                        $output2 .= '<tr><td class="text-center">'.$name.'</td><td>'.$milestone.'</td></tr>';
                    }
                }
            }
            else{
                $output2 .= '<tr><td></td><td></td></tr>';
            }
            $output2 .= '</tbody></table></div>';
    $q_adj = array("","","","","");
    for($i = 1; $i <= 4; $i++){
        if(round($ave_quarter[$i][0]/$ave_quarter[$i][2]) >= 4.8){
            $q_adj[$i] = "Outstanding";
        }
        else if(round($ave_quarter[$i][0]/$ave_quarter[$i][2]) <= 4.79 && round($ave_quarter[$i][0]/$ave_quarter[$i][2]) >= 4){
            $q_adj[$i] = "Very Satisfactory";
        }
        else if(round($ave_quarter[$i][0]/$ave_quarter[$i][2]) <= 3.99 && round($ave_quarter[$i][0]/$ave_quarter[$i][2]) >= 3){
            $q_adj[$i] = "Satisfactory";
        }
        else if(round($ave_quarter[$i][0]/$ave_quarter[$i][2]) <= 2.99 && round($ave_quarter[$i][0]/$ave_quarter[$i][2]) >= 0){
            $q_adj[$i] = "Unsatisfactory";
        }
    }
    $output2 .= '
    <div class="row">
        <div class="col-sm-6">
            <table class="table table-bordered">
                <tbody>
                    <tr><td class="text-center">5</td><td>Outstanding</td></tr>
                    <tr><td class="text-center">4</td><td>Very Satisfactory</td></tr>
                    <tr><td class="text-center">3</td><td>Satisfactory</td></tr>
                    <tr><td class="text-center">2</td><td>Unsatisfactory</td></tr>
                    <tr><td class="text-center">1</td><td>Poor</td></tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-6">
            <table class="table table-bordered">
                <thead class="mdb-color darken-3 text-center white-text"><tr><th colspan="3">Per Quarter Rating</th></tr></thead>
                <tbody>
                    <tr><td class="text-center">1stQ</td><td class="text-center">'.round($ave_quarter[1][0]/$ave_quarter[1][2]).'</td><td>'.$q_adj[1].'</td></tr>
                    <tr><td class="text-center">2ndQ</td><td class="text-center">'.round($ave_quarter[2][0]/$ave_quarter[2][2]).'</td><td>'.$q_adj[2].'</td></tr>
                    <tr><td class="text-center">3rdQ</td><td class="text-center">'.round($ave_quarter[3][0]/$ave_quarter[3][2]).'</td><td>'.$q_adj[3].'</td></tr>
                    <tr><td class="text-center">4thQ</td><td class="text-center">'.round($ave_quarter[4][0]/$ave_quarter[4][2]).'</td><td>'.$q_adj[4].'</td></tr>
                </tbody>
            </table>
        </div>';
    $output2 .= '</div><div class="row">';
    $output2 .= '<table class="table table-bordered">
                <thead class="mdb-color darken-3 table-striped">
                    <tr class="white-text text-center">
                        <th style="width: 300px;">Services Programs/Projects</th>
                        <th>Total Targets</th>
                        <th>Total Accopplishments</th>
                        <th></th>
                        <th>Percentage</th>
                        <th>Equivalent</th>
                    </tr>
                </thead>
                <tbody>';
    $totaltarget = 0;
    $totalaccomplish = 0;
    $totalequivalent = 0;
    $totalpercentage = 0;
    if($region != 0){
        $sub = " AND regionID = ".$region;
    }
    //level 1
    $sql = mysql_query("SELECT title, programID, percentage FROM program WHERE state = 1 AND level = 1 AND reportID = 2");
    if(mysql_num_rows($sql) != 0){
        while($fetch = mysql_fetch_assoc($sql)){
            $programid = $fetch['programID'];
            $title = $fetch['title'];
            $percentage = $fetch['percentage'];
            $totaltarget = 0;
            $totalaccomplish = 0;
            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM targetaccomplish INNER JOIN assign ON targetaccomplish.assignID = assign.assignID INNER JOIN program ON assign.programID = program.programID INNER JOIN account ON assign.accID = account.accID WHERE year = '$year' AND program.programID = '$programid'".$sub);
            if(mysql_num_rows($query) != 0){
                while($get = mysql_fetch_assoc($query)){
                    $totaltarget = $totaltarget + $get['target'];
                    $totalaccomplish = $totalaccomplish + $get['accomplish'];
                }
            }
            //level 2
            $sql2 = mysql_query("SELECT programID FROM program WHERE under = '$programid'");
            if(mysql_num_rows($sql2) != 0){
                while($fetch2 = mysql_fetch_assoc($sql2)){
                    $programid = $fetch2['programID'];
                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM targetaccomplish INNER JOIN assign ON targetaccomplish.assignID = assign.assignID INNER JOIN program ON assign.programID = program.programID INNER JOIN account ON assign.accID = account.accID WHERE year = '$year' AND program.programID = '$programid'".$sub);
                    if(mysql_num_rows($query) != 0){
                        while($get = mysql_fetch_assoc($query)){
                            $totaltarget = $totaltarget + $get['target'];
                            $totalaccomplish = $totalaccomplish + $get['accomplish'];
                        }
                    }
                    //level 3
                    $sql3 = mysql_query("SELECT programID FROM program WHERE under = '$programid'");
                    if(mysql_num_rows($sql3) != 0){
                        while($fetch3 = mysql_fetch_assoc($sql3)){
                            $programid = $fetch3['programID'];
                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM targetaccomplish INNER JOIN assign ON targetaccomplish.assignID = assign.assignID INNER JOIN program ON assign.programID = program.programID INNER JOIN account ON assign.accID = account.accID WHERE year = '$year' AND program.programID = '$programid'".$sub);
                            if(mysql_num_rows($query) != 0){
                                while($get = mysql_fetch_assoc($query)){
                                    $totaltarget = $totaltarget + $get['target'];
                                    $totalaccomplish = $totalaccomplish + $get['accomplish'];
                                }
                            }
                            //level 4
                            $sql4 = mysql_query("SELECT programID FROM program WHERE under = '$programid'");
                            if(mysql_num_rows($sql4) != 0){
                                while($fetch4 = mysql_fetch_assoc($sql4)){
                                    $programid = $fetch4['programID'];
                                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM targetaccomplish INNER JOIN assign ON targetaccomplish.assignID = assign.assignID INNER JOIN program ON assign.programID = program.programID INNER JOIN account ON assign.accID = account.accID WHERE year = '$year' AND program.programID = '$programid'".$sub);
                                    if(mysql_num_rows($query) != 0){
                                        while($get = mysql_fetch_assoc($query)){
                                            $totaltarget = $totaltarget + $get['target'];
                                              $totalaccomplish = $totalaccomplish + $get['accomplish'];
                                        }
                                    }
                                    //level 5
                                    $sql5 = mysql_query("SELECT programID FROM program WHERE under = '$programid'");
                                    if(mysql_num_rows($sql5) != 0){
                                        while($fetch5 = mysql_fetch_assoc($sql5)){
                                            $programid = $fetch5['programID'];
                                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM targetaccomplish INNER JOIN assign ON targetaccomplish.assignID = assign.assignID INNER JOIN program ON assign.programID = program.programID INNER JOIN account ON assign.accID = account.accID WHERE year = '$year' AND program.programID = '$programid'".$sub);
                                            if(mysql_num_rows($query) != 0){
                                                while($get = mysql_fetch_assoc($query)){
                                                    $totaltarget = $totaltarget + $get['target'];
                                                    $totalaccomplish = $totalaccomplish + $get['accomplish'];
                                                }
                                            }
                                            //level 6
                                            $sql6 = mysql_query("SELECT programID FROM program WHERE under = '$programid'");
                                            if(mysql_num_rows($sql6) != 0){
                                                while($fetch6 = mysql_fetch_assoc($sql6)){
                                                    $programid = $fetch6['programID'];
                                                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM targetaccomplish INNER JOIN assign ON targetaccomplish.assignID = assign.assignID INNER JOIN program ON assign.programID = program.programID INNER JOIN account ON assign.accID = account.accID WHERE year = '$year' AND program.programID = '$programid'".$sub);
                                                    if(mysql_num_rows($query) != 0){
                                                        while($get = mysql_fetch_assoc($query)){
                                                            $totaltarget = $totaltarget + $get['target'];
                                                            $totalaccomplish = $totalaccomplish + $get['accomplish'];
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
            $percent = round(($totalaccomplish/$totaltarget)*100, 2);
            if($totaltarget == 0){
                $totaltarget = "-";
            }
            if($totalaccomplish == 0){
                $totalaccomplish = "-";
            }
            if($percent == 0){
                $percent = "-";
            }
            $totalequivalent += round($percent/$percentage, 2);
            $totalpercentage += $percentage/100;
            $output2 .= '<tr><td style="width: 200px;">'.$title.'</td>
            <td class="text-center">'.$totaltarget.'</td>
            <td class="text-center">'.$totalaccomplish.'</td>
            <td class="text-center">'.$percent.'</td>
            <td class="text-center">'.($percentage/100).'</td>
            <td class="text-center">'.round($percent/$percentage, 2).'</td></tr>';
        }
        $output2 .= '<tr class="red-text"><td>Total</td><td colspan="3"></td><td class="text-center">'.$totalpercentage.'</td><td class="text-center">'.$totalequivalent.'</td></tr>';
    }
    $output2 .= '</tbody></table></div>';
    $output2 .= '<div class="row">
    <table class="table table-bordered"><thead class="mdb-color darken-3 white-text text-center">
        <tr><th>Category</th>
        <th>MFO</th>
        <th>Rating</th>
    </tr></thead><tbody>
    <tr>
        <td>Strategic Priority</td>
        <td class="text-center">2, 4</td>
        <td></td>
    </tr>
    <tr>
        <td>Core Functions</td>
        <td class="text-center">2, 4</td>
        <td></td>
    </tr>
    <tr>
        <td>Support Functions</td>
        <td class="text-center">4</td>
        <td></td>
    </tr>
    <tr>
        <td>Total Overall Rating</td>
        <td class="text-center">'.$ave_targetaccom[0].'</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">Final Average Rating</td>
        <td></td>
    </tr>';
    $output2 .= '</tbody></table></div>';
?>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
		<title>IPCR</title>
        <link rel="icon" href="../../../../img/custom/CHED LOGO WITH WHITE BACKGROUND.png" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="../../../../css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="../../../../css/mdb.css" />
		<link rel="stylesheet" type="text/css" href="../../../../css/font-awesome.css" />
		<link rel="stylesheet" type="text/css" href="../../../../css/style.css" />
	</head>
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
                <table class="table table-striped">
                    <tbody>
                        <?php echo $output; ?>
                        <?php echo $output2; ?>
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
    $(document).ready(function(){
        print();
    })
</script>