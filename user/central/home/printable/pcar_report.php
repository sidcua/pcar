<?php
    session_start();
    include '../../../../php/checksession.php';
    include '../../../../php/checkaccount.php';
    include '../../../../php/connect.php';
    $year = mysql_escape_string($_GET['year']);
    $region = mysql_escape_string($_GET['region']);
    $output = "";
    if($region != 0){
        $sub = " AND regionID = ".$region;
    }
    $sql = mysql_query("SELECT programID, title, status FROM program WHERE level = 1 AND state = 1 AND reportID = 1");
    while($fetch = mysql_fetch_assoc($sql)){
        $programid = $fetch['programID'];
        $title = $fetch['title'];
        $status = $fetch['status'];
        $target_total = 0;
        $accom_total = 0;
        $output .= '<tr><td style="padding-left: 20px;">'.$title.'</td>';
        if($status == 0){
            $output .= '<td colspan="12" class="grey lighten-2"></td>';
        }
        else{
            for($i = 1; $i <= 4; $i = $i++){
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
            }
            if($target_total == 0){
                $target_total = "-";
            }
            if($accom_total == 0){
                $accom_total = "-";
            }
            $output .= '<td class="text-center">'.$target_total.'</td>
            <td class="text-center">'.$target_q1.'</td>
            <td class="text-center">'.$target_q2.'</td>
            <td class="text-center">'.$target_q3.'</td>
            <td class="text-center">'.$target_q4.'</td>
            <td class="text-center">'.$accom_q1.'</td>
            <td class="text-center">'.$accom_q2.'</td>
            <td class="text-center">'.$accom_q3.'</td>
            <td class="text-center">'.$accom_q4.'</td>
            <td class="text-center">'.$accom_total.'</td>
            <td></td>';
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
                    $output .= '<td colspan="12" class="grey lighten-2"></td>';
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
                    }
                    if($target_total == 0){
                        $target_total = "-";
                    }
                    if($accom_total == 0){
                        $accom_total = "-";
                    }
                    $output .= '<td class="text-center">'.$target_total.'</td>
                    <td class="text-center">'.$target_q1.'</td>
                    <td class="text-center">'.$target_q2.'</td>
                    <td class="text-center">'.$target_q3.'</td>
                    <td class="text-center">'.$target_q4.'</td>
                    <td class="text-center">'.$accom_q1.'</td>
                    <td class="text-center">'.$accom_q2.'</td>
                    <td class="text-center">'.$accom_q3.'</td>
                    <td class="text-center">'.$accom_q4.'</td>
                    <td class="text-center">'.$accom_total.'</td>
                    <td></td>';
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
                            $output .= '<td colspan="12" class="grey lighten-2"></td>';
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
                            }
                            if($target_total == 0){
                                $target_total = "-";
                            }
                            if($accom_total == 0){
                                $accom_total = "-";
                            }
                            $output .= '<td class="text-center">'.$target_total.'</td>
                            <td class="text-center">'.$target_q1.'</td>
                            <td class="text-center">'.$target_q2.'</td>
                            <td class="text-center">'.$target_q3.'</td>
                            <td class="text-center">'.$target_q4.'</td>
                            <td class="text-center">'.$accom_q1.'</td>
                            <td class="text-center">'.$accom_q2.'</td>
                            <td class="text-center">'.$accom_q3.'</td>
                            <td class="text-center">'.$accom_q4.'</td>
                            <td class="text-center">'.$accom_total.'</td>
                            <td></td>';
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
                                    $output .= '<td colspan="12" class="grey lighten-2"></td>';
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
                                    }
                                    if($target_total == 0){
                                        $target_total = "-";
                                    }
                                    if($accom_total == 0){
                                        $accom_total = "-";
                                    }
                                    $output .= '<td class="text-center">'.$target_total.'</td>
                                    <td class="text-center">'.$target_q1.'</td>
                                    <td class="text-center">'.$target_q2.'</td>
                                    <td class="text-center">'.$target_q3.'</td>
                                    <td class="text-center">'.$target_q4.'</td>
                                    <td class="text-center">'.$accom_q1.'</td>
                                    <td class="text-center">'.$accom_q2.'</td>
                                    <td class="text-center">'.$accom_q3.'</td>
                                    <td class="text-center">'.$accom_q4.'</td>
                                    <td class="text-center">'.$accom_total.'</td>
                                    <td></td>';
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
                                            $output .= '<td colspan="12" class="grey lighten-2"></td>';
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
                                            }
                                            if($target_total == 0){
                                                $target_total = "-";
                                            }
                                            if($accom_total == 0){
                                                $accom_total = "-";
                                            }
                                            $output .= '<td class="text-center">'.$target_total.'</td>
                                            <td class="text-center">'.$target_q1.'</td>
                                            <td class="text-center">'.$target_q2.'</td>
                                            <td class="text-center">'.$target_q3.'</td>
                                            <td class="text-center">'.$target_q4.'</td>
                                            <td class="text-center">'.$accom_q1.'</td>
                                            <td class="text-center">'.$accom_q2.'</td>
                                            <td class="text-center">'.$accom_q3.'</td>
                                            <td class="text-center">'.$accom_q4.'</td>
                                            <td class="text-center">'.$accom_total.'</td>
                                            <td></td>';
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
                                                    $output .= '<td colspan="12" class="grey lighten-2"></td>';
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
                                                    }
                                                    if($target_total == 0){
                                                        $target_total = "-";
                                                    }
                                                    if($accom_total == 0){
                                                        $accom_total = "-";
                                                    }
                                                    $output .= '<td class="text-center">'.$target_total.'</td>
                                                    <td class="text-center">'.$target_q1.'</td>
                                                    <td class="text-center">'.$target_q2.'</td>
                                                    <td class="text-center">'.$target_q3.'</td>
                                                    <td class="text-center">'.$target_q4.'</td>
                                                    <td class="text-center">'.$accom_q1.'</td>
                                                    <td class="text-center">'.$accom_q2.'</td>
                                                    <td class="text-center">'.$accom_q3.'</td>
                                                    <td class="text-center">'.$accom_q4.'</td>
                                                    <td class="text-center">'.$accom_total.'</td>
                                                    <td></td>';
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
?>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
		<title>PCAR</title>
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
                            <p>Office: <b>
                                <?php 
                                    $sql = mysql_query("SELECT region_code FROM region WHERE regionID = '$region'"); 
                                    $fetch = mysql_fetch_assoc($sql);
                                    echo $fetch['region_code'];
                                ?>
                            </b></p>
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
                    <thead class="mdb-color darken-3 table-striped">
                        <tr class="white-text text-center">
                            <th rowspan="2" style="width: 23%">Services Programs/Projects</th>
                            <th rowspan="2">Total Targets</th>
                            <th colspan="4">Quarterly Targets</th>
                            <th colspan="4">Quarterly Accomplishments</th>
                            <th rowspan="2">Total Accomplishmnets</th>
                            <th rowspan="2" style="width: 20%">Remarks</th>
                        </tr>
                        <tr class="white-text text-center">
                            <th>Q1</th>
                            <th>Q2</th>
                            <th>Q3</th>
                            <th>Q4</th>
                            <th>Q1</th>
                            <th>Q2</th>
                            <th>Q3</th>
                            <th>Q4</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $output; ?>
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