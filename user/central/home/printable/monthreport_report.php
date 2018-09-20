<?php
    session_start();
    include '../../../../php/connect.php';
    $year = mysql_escape_string($_GET['year']);
    $quarter = mysql_escape_string($_GET['quarter']);
    $reportid = mysql_escape_string($_GET['report']);
    $region = $_SESSION['region'];
    $output = "";
    if($quarter == 1){
        $output .= '<table class="table table-bordered table-striped">
                <thead class="mdb-color darken-3 table-striped">
                    <tr class="white-text text-center">
                        <td style="width: 30%;">Services Programs/Projects</td>
                        <td colspan="2">Quarter 1</td>
                        <td colspan="2">Total</td>
                    </tr>
                </thead><tbody>
                <tr class="white-text text-center"><td></td>
                <td class="bg-danger">T</td>
                <td class="bg-success">A</td>
                <td class="bg-danger">T</td>
                <td class="bg-success">A</td></tr>';
        //level 1
        $sql = mysql_query("SELECT programID, title, status FROM program WHERE level = 1 AND state = 1 AND reportID = '$reportid'");
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
                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = 1 AND year = '$year' AND program.programID = '$programid' AND regionID = '$region'");
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
            //level 2
            $sql2 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1");
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
                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = 1 AND year = '$year' AND program.programID = '$programid' AND regionID = '$region'");
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
                        //level 3
                        $sql3 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1");
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
                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = 1 AND year = '$year' AND program.programID = '$programid' AND regionID = '$region'");
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
                            $sql4 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1");
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
                                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = 1 AND year = '$year' AND program.programID = '$programid' AND regionID = '$region'");
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
                                    //level 5
                                    $sql5 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1");
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
                                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = 1 AND year = '$year' AND program.programID = '$programid' AND regionID = '$region'");
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
                                                $sql6 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1");
                                                if(mysql_num_rows($sql6) != 0){
                                                    while($fetch6 = mysql_fetch_assoc($sql6)){
                                                        $programid = $fetch6['programID'];
                                                        $title = $fetch6['title'];
                                                        $status = $fetch6['status'];
                                                        $output .= 
                                                        '<tr>
                                                            <td style="padding-left: 120px;">'.$title.'</td>';
                                                        if($status == 0){
                                                            $output .= '<td colspan="4" class="grey lighten-2"></td>';
                                                        }
                                                        else{
                                                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = 1 AND year = '$year' AND program.programID = '$programid' AND regionID = '$region'");
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
        else if($quarter == 3){
            $con = "Quarter 1 - 2";
            $monthlbl = "Quarter 3";
        }
        else{
            $con = "Quarter 1 - 3";
            $monthlbl = "Quarter 4";
        }
        $before = $quarter - 1;
        $current = $quarter;
        $output = '<table class="table table-bordered table-striped">
                <thead class="mdb-color darken-3 table-striped">
                    <tr class="white-text text-center">
                        <td style="width: 30%;">Services Programs/Projects</td>
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
        //level 1
        $sql = mysql_query("SELECT programID, title, status FROM program WHERE level = 1 AND state = 1 AND reportID = '$reportid'");
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
                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month <= '$before' AND year = '$year' AND program.programID = '$programid' AND regionID = '$region'");
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
                $query2 = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month >= '$before' AND month <= '$current' AND year = '$year' AND program.programID = '$programid' AND regionID = '$region'");
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
            //level 2
            $sql2 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1");
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
                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month <= '$before' AND year = '$year' AND program.programID = '$programid' AND regionID = '$region'");
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
                        $query2 = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month > '$before' AND month <= '$current' AND year = '$year' AND program.programID = '$programid' AND regionID = '$region'");
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
                    //evel 3
                    $sql3 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1");
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
                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month <= '$before' AND year = '$year' AND program.programID = '$programid' AND regionID = '$region'");
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
                                $query2 = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month > '$before' AND month <= '$current' AND year = '$year' AND program.programID = '$programid' AND regionID ='$region'");
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
                            //level 4
                            $sql4 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1");
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
                                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month <= '$before' AND year = '$year' AND program.programID = '$programid' AND regionID = '$region'");
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
                                        $query2 = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month > '$before' AND month <= '$current' AND year = '$year' AND program.programID = '$programid' AND regionID = '$region'");
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
                                    //level 5
                                    $sql5 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1");
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
                                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month <= '$before' AND year = '$year' AND program.programID = '$programid' AND regionID = '$region'");
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
                                                $query2 = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month > '$before' AND month <= '$current' AND year = '$year' AND program.programID = '$programid' AND regionID = '$region'");
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
                                            //level 6
                                            $sql6 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1");
                                            if(mysql_num_rows($sql6) != 0){
                                                while($fetch6 = mysql_fetch_assoc($sql6)){
                                                    $programid = $fetch6['programID'];
                                                    $title = $fetch6['title'];
                                                    $status = $fetch6['status'];
                                                    $output .= 
                                                    '<tr>
                                                        <td style="padding-left: 100px;">'.$title.'</td>';
                                                    if($status == 0){
                                                        $output .= '<td colspan="6" class="grey lighten-2"></td>';
                                                    }
                                                    else{
                                                        $totaltarget = 0;
                                                        $totalaccomplish = 0;
                                                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month <= '$before' AND year = '$year' AND program.programID = '$programid' AND regionID = '$region'");
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
                                                        $query2 = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month > '$before' AND month <= '$current' AND year = '$year' AND program.programID = '$programid' AND regionID = '$region'");
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
            }
        }
        $output .= '</tbody></table>';
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
                <?php echo $output; ?>
            </div>
        </div>
	</body>
	<script type="text/javascript" src="../../../../js/mdb/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="../../../../js/mdb/mdb.js"></script>
	<script type="text/javascript" src="../../../../js/mdb/bootstrap.js"></script>
	<script type="text/javascript" src="../../../../js/mdb/popper.min.js"></script>
</html>
<script>
    // $(document).ready(function(){
    //     print();
    // })
</script>