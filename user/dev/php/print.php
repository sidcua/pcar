<?php 
//	session_start();
    include '../../../../php/connect.php';
    $print = mysql_escape_string($_GET['print']);
    function arrangeprogramreport($mode, $year, $region){
        $output .= "";
        $accid = $_SESSION['accID'];
        if($region != 0){
            $sub = " AND regionID = ".$region;
        }
        // level 1
        if($_SESSION['level'] == 3){
            $sql = mysql_query("SELECT assignID, program.programID AS programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE assign.accID = '$accid' AND level = 1 AND state = 1 ORDER BY title ASC");
        }
        else{
            $sql = mysql_query("SELECT programID, title, status FROM program WHERE level = 1 AND state = 1 ORDER BY title ASC");
        }
        while($fetch = mysql_fetch_assoc($sql)){
            $programid = $fetch['programID'];
            $title = $fetch['title'];
            $status = $fetch['status'];
            $output .= 
            '<tr>
                <td style="padding-left: 20px;">'.$title.'</td>';
            if($mode == "monthly"){
                if($status == 0){
                    $output .= 
                    '<td colspan="24" class="grey lighten-2"></td>';
                }
                else{
                    for ($i=1; $i <= 12; $i++) { 
                        if($_SESSION['level'] == 3){
                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                        }
                        else{
                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);    
                        }
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
                    }
                }
            }
            else if($mode == "quarterly"){
                if($status == 0){
                    $output .= 
                    '<td colspan="24" class="grey lighten-2"></td>';
                }
                else{
                    $limit = 3;
                    for ($i = 1; $i <= 12 ; $i = $i + 3) { 
                        if($_SESSION['level'] == 3){
                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                        }
                        else{
                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid'".$sub);   
                        }
                        $get = mysql_fetch_assoc($query);
                        $target = $get['target'];
                        if($target == 0){
                            $output .= '<td class="text-center">-</td>';
                        }
                        else{
                            $output .= '<td class="text-center">'.$target.'</td>';
                        }
                        $accomplish = $get['accomplish'];
                        if($accomplish == 0){
                            $output .= '<td class="text-center">-</td>';
                        }
                        else{
                            $output .= '<td class="text-center">'.$accomplish.'</td>';
                        }
                        $limit = $limit + 3;
                    }
                }
            }
            $output .= '</tr>';
            // level 2
            if($_SESSION['level'] == 3){
                $sql2 = mysql_query("SELECT program.programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE under = '$programid' AND state = 1 AND accID = '$accid' ORDER BY title ASC");
            }
            else{
                $sql2 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
            }
            if(mysql_num_rows($sql2) != 0){
                while($fetch2 = mysql_fetch_assoc($sql2)){
                    $programid = $fetch2['programID'];
                    $title = $fetch2['title'];
                    $status = $fetch2['status'];
                    $output .= 
                    '<tr>
                        <td style="padding-left: 40px;">'.$title.'</td>';
                    if($mode == "monthly"){
                        if($status == 0){
                            $output .= 
                            '<td colspan="24" class="grey lighten-2"></td>';
                        }
                        else{
                            for ($i=1; $i <= 12; $i++) { 
                                if($_SESSION['level'] == 3){
                                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                                }
                                else{
                                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);    
                                }
                                $get = mysql_fetch_assoc($query);
                                $target = $get['target'];
                                if($target == 0){
                                    $output .= '<td class="text-center">-</td>';
                                }
                                else{
                                    $output .= '<td class="text-center">'.$target.'</td>';
                                }
                                $accomplish = $get['accomplish'];
                                if($accomplish == 0){
                                    $output .= '<td class="text-center">-</td>';
                                }
                                else{
                                    $output .= '<td class="text-center">'.$accomplish.'</td>';
                                }
                            }
                        }
                    }
                    else if($mode == "quarterly"){
                        if($status == 0){
                            $output .= 
                            '<td colspan="24" class="grey lighten-2"></td>';
                        }
                        else{
                            $limit = 3;
                            for ($i = 1; $i <= 12 ; $i = $i + 3) { 
                                if($_SESSION['level'] == 3){
                                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                                }
                                else{
                                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid'".$sub);   
                                }
                                $target = $get['target'];
                                if($target == 0){
                                    $output .= '<td class="text-center">-</td>';
                                }
                                else{
                                    $output .= '<td class="text-center">'.$target.'</td>';
                                }
                                $accomplish = $get['accomplish'];
                                if($accomplish == 0){
                                    $output .= '<td class="text-center">-</td>';
                                }
                                else{
                                    $output .= '<td class="text-center">'.$accomplish.'</td>';
                                }
                                $limit = $limit + 3;
                            }
                        }
                    }
                    $output .= '</tr>';
                    // level 3
                    if($_SESSION['level'] == 3){
                        $sql3 = mysql_query("SELECT program.programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE under = '$programid' AND state = 1 AND accID = '$accid' ORDER BY title ASC");
                    }
                    else{
                        $sql3 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                    }
                    if(mysql_num_rows($sql3) != 0){
                            while($fetch3 = mysql_fetch_assoc($sql3)){
                            $programid = $fetch3['programID'];
                            $title = $fetch3['title'];
                            $status = $fetch3['status'];
                            $output .= 
                            '<tr>
                                <td style="padding-left: 60px;">'.$title.'</td>';
                            if($mode == "monthly"){
                                if($status == 0){
                                    $output .= 
                                    '<td colspan="24" class="grey lighten-2"></td>';
                                }
                                else{
                                    for ($i=1; $i <= 12; $i++) {
                                        if($_SESSION['level'] == 3){
                                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                                        }
                                        else{
                                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);    
                                        }
                                        $get = mysql_fetch_assoc($query);
                                        $target = $get['target'];
                                        if($target == 0){
                                            $output .= '<td class="text-center">-</td>';
                                        }
                                        else{
                                            $output .= '<td class="text-center">'.$target.'</td>';
                                        }
                                        $accomplish = $get['accomplish'];
                                        if($accomplish == 0){
                                            $output .= '<td class="text-center">-</td>';
                                        }
                                        else{
                                            $output .= '<td class="text-center">'.$accomplish.'</td>';
                                        }
                                    }
                                }
                            }
                            else if($mode == "quarterly"){
                                if($status == 0){
                                    $output .= 
                                    '<td colspan="24" class="grey lighten-2"></td>';
                                }
                                else{
                                    $limit = 3;
                                    for ($i = 1; $i <= 12 ; $i = $i + 3) { 
                                        if($_SESSION['level'] == 3){
                                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                                        }
                                        else{
                                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid'".$sub);   
                                        }
                                        $get = mysql_fetch_assoc($query);
                                        $target = $get['target'];
                                        if($target == 0){
                                            $output .= '<td class="text-center">-</td>';
                                        }
                                        else{
                                            $output .= '<td class="text-center">'.$target.'</td>';
                                        }
                                        $accomplish = $get['accomplish'];
                                        if($accomplish == 0){
                                            $output .= '<td class="text-center">-</td>';
                                        }
                                        else{
                                            $output .= '<td class="text-center">'.$accomplish.'</td>';
                                        }
                                        $limit = $limit + 3;
                                    }
                                }
                            }
                            $output .= '</tr>';
                            // level 4
                            if($_SESSION['level'] == 3){
                                $sql4 = mysql_query("SELECT program.programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE under = '$programid' AND state = 1 AND accID = '$accid' ORDER BY title ASC");
                            }
                            else{
                                $sql4 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                            }
                            if(mysql_num_rows($sql4) != 0){
                                while($fetch4 = mysql_fetch_assoc($sql4)){
                                    $programid = $fetch4['programID'];
                                    $title = $fetch4['title'];
                                    $status = $fetch4['status'];
                                    $output .= 
                                    '<tr>
                                        <td style="padding-left: 80px;">'.$title.'</td>';
                                    if($mode == "monthly"){
                                        if($status == 0){
                                            $output .= 
                                            '<td colspan="24" class="grey lighten-2"></td>';
                                        }
                                        else{
                                            for ($i=1; $i <= 12; $i++) { 
                                                if($_SESSION['level'] == 3){
                                                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                                                }
                                                else{
                                                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);    
                                                }
                                                $get = mysql_fetch_assoc($query);
                                                $target = $get['target'];
                                                if($target == 0){
                                                    $output .= '<td class="text-center">-</td>';
                                                }
                                                else{
                                                    $output .= '<td class="text-center">'.$target.'</td>';
                                                }
                                                $accomplish = $get['accomplish'];
                                                if($accomplish == 0){
                                                    $output .= '<td class="text-center">-</td>';
                                                }
                                                else{
                                                    $output .= '<td class="text-center">'.$accomplish.'</td>';
                                                }
                                            }
                                        }
                                    }
                                    else if($mode == "quarterly"){
                                        if($status == 0){
                                            $output .= 
                                            '<td colspan="24" class="grey lighten-2"></td>';
                                        }
                                        else{
                                            $limit = 3;
                                            for ($i = 1; $i <= 12 ; $i = $i + 3) { 
                                                if($_SESSION['level'] == 3){
                                                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                                                }
                                                else{
                                                    $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid'".$sub);   
                                                }
                                                $get = mysql_fetch_assoc($query);
                                                $target = $get['target'];
                                                if($target == 0){
                                                    $output .= '<td class="text-center">-</td>';
                                                }
                                                else{
                                                    $output .= '<td class="text-center">'.$target.'</td>';
                                                }
                                                $accomplish = $get['accomplish'];
                                                if($accomplish == 0){
                                                    $output .= '<td class="text-center">-</td>';
                                                }
                                                else{
                                                    $output .= '<td class="text-center">'.$accomplish.'</td>';
                                                }
                                                $limit = $limit + 3;
                                            }
                                        }
                                    }
                                    $output .= '</tr>';
    //                                level 5
                                    if($_SESSION['level'] == 3){
                                        $sql5 = mysql_query("SELECT program.programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE under = '$programid' AND state = 1 AND accID = '$accid' ORDER BY title ASC");
                                    }
                                    else{
                                        $sql5 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                                    }
                                    if(mysql_num_rows($sql5) != 0){
                                        while($fetch5 = mysql_fetch_assoc($sql5)){
                                            $programid = $fetch5['programID'];
                                            $title = $fetch5['title'];
                                            $status = $fetch5['status'];
                                            $output .= 
                                            '<tr>
                                                <td style="padding-left: 100px;">'.$title.'</td>';
                                            if($mode == "monthly"){
                                                if($status == 0){
                                                    $output .= 
                                                    '<td colspan="24" class="grey lighten-2"></td>';
                                                }
                                                else{
                                                    for ($i=1; $i <= 12; $i++) { 
                                                        if($_SESSION['level'] == 3){
                                                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                                                        }
                                                        else{
                                                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);    
                                                        }
                                                        $get = mysql_fetch_assoc($query);
                                                        $target = $get['target'];
                                                        if($target == 0){
                                                            $output .= '<td class="text-center">-</td>';
                                                        }
                                                        else{
                                                            $output .= '<td class="text-center">'.$target.'</td>';
                                                        }
                                                        $accomplish = $get['accomplish'];
                                                        if($accomplish == 0){
                                                            $output .= '<td class="text-center">-</td>';
                                                        }
                                                        else{
                                                            $output .= '<td class="text-center">'.$accomplish.'</td>';
                                                        }
                                                    }
                                                }
                                            }
                                            else if($mode == "quarterly"){
                                                if($status == 0){
                                                    $output .= 
                                                    '<td colspan="24" class="grey lighten-2"></td>';
                                                }
                                                else{
                                                    $limit = 3;
                                                    for ($i = 1; $i <= 12 ; $i = $i + 3) { 
                                                        if($_SESSION['level'] == 3){
                                                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                                                        }
                                                        else{
                                                            $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid'".$sub);   
                                                        }
                                                        $get = mysql_fetch_assoc($query);
                                                        $target = $get['target'];
                                                        if($target == 0){
                                                            $output .= '<td class="text-center">-</td>';
                                                        }
                                                        else{
                                                            $output .= '<td class="text-center">'.$target.'</td>';
                                                        }
                                                        $accomplish = $get['accomplish'];
                                                        if($accomplish == 0){
                                                            $output .= '<td class="text-center">-</td>';
                                                        }
                                                        else{
                                                            $output .= '<td class="text-center">'.$accomplish.'</td>';
                                                        }
                                                        $limit = $limit + 3;
                                                    }
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
        return $output;
    }
    if($print == "report"){
        $mode = mysql_escape_string($_GET['mode']);
        $year = mysql_escape_string($_GET['year']);
        $region = mysql_escape_string($_GET['region']);
        if($mode == "monthly"){
            $output .= 
            '<thead class="mdb-color darken-3">
                        <tr class="text-center white-text">
                            <th style="width: 300px;">Services Programs/Projects</th>
                            <th colspan="2">Jan</th>
                            <th colspan="2">Feb</th>
                            <th colspan="2">Mar</th>
                            <th colspan="2">Apr</th>
                            <th colspan="2">May</th>
                            <th colspan="2">Jun</th>
                            <th colspan="2">Jul</th>
                            <th colspan="2">Aug</th>
                            <th colspan="2">Sep</th>
                            <th colspan="2">Oct</th>
                            <th colspan="2">Nov</th>
                            <th colspan="2">Dec</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="white-text text-center">
                            <td></td>
                            <td class="bg-danger">T</td>
                            <td class="bg-success">A</td>
                            <td class="bg-danger">T</td>
                            <td class="bg-success">A</td>
                            <td class="bg-danger">T</td>
                            <td class="bg-success">A</td>
                            <td class="bg-danger">T</td>
                            <td class="bg-success">A</td>
                            <td class="bg-danger">T</td>
                            <td class="bg-success">A</td>
                            <td class="bg-danger">T</td>
                            <td class="bg-success">A</td>
                            <td class="bg-danger">T</td>
                            <td class="bg-success">A</td>
                            <td class="bg-danger">T</td>
                            <td class="bg-success">A</td>
                            <td class="bg-danger">T</td>
                            <td class="bg-success">A</td>
                            <td class="bg-danger">T</td>
                            <td class="bg-success">A</td>
                            <td class="bg-danger">T</td>
                            <td class="bg-success">A</td>
                            <td class="bg-danger">T</td>
                            <td class="bg-success">A</td>
                        </tr>';
            $output .= arrangeprogramreport($mode, $year, $region);
            $output .= '</tbody>';
        }
        else if($mode == "quarterly"){
            $output .= 
            '<thead class="mdb-color darken-3">
                        <tr class="text-center white-text">
                            <th style="width: 300px;">Services Programs/Projects</th>
                            <th colspan="2">Quarter 1</th>
                            <th colspan="2">Quarter 2</th>
                            <th colspan="2">Quarter 3</th>
                            <th colspan="2">Quarter 4</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="white-text text-center">
                            <td></td>
                            <td class="bg-danger">T</td>
                            <td class="bg-success">A</td>
                            <td class="bg-danger">T</td>
                            <td class="bg-success">A</td>
                            <td class="bg-danger">T</td>
                            <td class="bg-success">A</td>
                            <td class="bg-danger">T</td>
                            <td class="bg-success">A</td>
                        </tr>';
            $output .= arrangeprogramreport($mode, $year, $region);
            $output .= '</tbody>';
        }
    }
    else if($print == "performance"){
        $accid = $_SESSION['accID'];
        $year = mysql_escape_string($_GET['year']);
        $region = mysql_escape_string($_GET['region']);
        if($region != 0){
            $sub = " AND regionID = ".$region;
        }
        $output .= 
        '<thead class="mdb-color darken-3">
                    <tr class="text-center white-text">
                        <th style="width: 300px;">Services Programs/Projects</th>
                        <th colspan="3">Quarter 1</th>
                        <th colspan="3">Quarter 2</th>
                        <th colspan="3">Quarter 3</th>
                        <th colspan="3">Quarter 4</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td></td>
                        <td>Remarks</td>
                        <td>Rating</td>
                        <td>Adjective Rating</td>
                        <td>Remarks</td>
                        <td>Rating</td>
                        <td>Adjective Rating</td>
                        <td>Remarks</td>
                        <td>Rating</td>
                        <td>Adjective Rating</td>
                        <td>Remarks</td>
                        <td>Rating</td>
                        <td>Adjective Rating</td>
                    </tr>';
        // level 1
        if($_SESSION['level'] == 3){
            $sql = mysql_query("SELECT assignID, program.programID AS programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE assign.accID = '$accid' AND level = 1 AND state = 1 ORDER BY title ASC");
        }
        else{
            $sql = mysql_query("SELECT programID, title, status FROM program WHERE level = 1 AND state = 1 ORDER BY title ASC");
        }
		while($fetch = mysql_fetch_assoc($sql)){
			$programid = $fetch['programID'];
			$title = $fetch['title'];
			$status = $fetch['status'];
			$output .= 
			'<tr>
				<td style="padding-left: 20px;">'.$title.'</td>';
			if($status == 0){
				$output .= '<td colspan="12" class="grey lighten-2"></td>';
			}
			else{
				$limit = 3;
				for ($i = 1; $i <= 12 ; $i = $i + 3) { 
					if($_SESSION['level'] == 3){
                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                    }
                    else{
                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid'".$sub);   
                    }
					$get = mysql_fetch_assoc($query);
					$target = $get['target'];
					$accomplish = $get['accomplish'];
					if($target != 0 && $accomplish != 0){	
						$remark = round((((($accomplish - $target)/$target)*100)+100), 1);
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
						if($rating >= 4.8){
							$adj = "Outstanding";
						}
						else if($rating <= 4.79 && $rating >= 4){
							$adj = "Very Satisfactory";
						}
						else if($rating <= 3.99 && $rating >= 3){
							$adj = "Satisfactory";
						}
						else if($rating <= 2.99 && $rating >= 0){
							$adj = "Unsatisfactory";
						}
						$output .= 
							'<td class="text-center">'.$remark.'</td>
							<td class="text-center">'.$rating.'</td>
							<td class="text-center">'.$adj.'</td>';
					}
					else{
						$output .=
						'<td class="text-center">-</td>
						<td class="text-center">-</td>
						<td class="text-center">-</td>';
					}
					$limit = $limit + 3;
				}
			}
			$output .= '</tr>';
			// level 2
			if($_SESSION['level'] == 3){
                $sql2 = mysql_query("SELECT program.programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE under = '$programid' AND state = 1 AND accID = '$accid' ORDER BY title ASC");
            }
            else{
                $sql2 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
            }
			if(mysql_num_rows($sql2) != 0){
				while($fetch2 = mysql_fetch_assoc($sql2)){
					$programid = $fetch2['programID'];
					$title = $fetch2['title'];
					$status = $fetch2['status'];
					$output .= 
					'<tr>
						<td style="padding-left: 40px;">'.$title.'</td>';
					if($status == 0){
						$output .= '<td colspan="12" class="grey lighten-2"></td>';
					}
					else{
						$limit = 3;
						for ($i = 1; $i <= 12 ; $i = $i + 3) { 
							if($_SESSION['level'] == 3){
                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                            }
                            else{
                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid'".$sub);   
                            }
							$get = mysql_fetch_assoc($query);
							$target = $get['target'];
							$accomplish = $get['accomplish'];
							if($target != 0 && $accomplish != 0){	
								$remark = round((((($accomplish - $target)/$target)*100)+100), 1);
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
								if($rating >= 4.8){
									$adj = "Outstanding";
								}
								else if($rating <= 4.79 && $rating >= 4){
									$adj = "Very Satisfactory";
								}
								else if($rating <= 3.99 && $rating >= 3){
									$adj = "Satisfactory";
								}
								else if($rating <= 2.99 && $rating >= 0){
									$adj = "Unsatisfactory";
								}
								$output .= 
									'<td class="text-center">'.$remark.'</td>
									<td class="text-center">'.$rating.'</td>
									<td class="text-center">'.$adj.'</td>';
							}
							else{
								$output .=
								'<td class="text-center">-</td>
								<td class="text-center">-</td>
								<td class="text-center">-</td>';
							}
							$limit = $limit + 3;
						}
					}
					$output .= '</tr>';
					// level 3
					if($_SESSION['level'] == 3){
                        $sql3 = mysql_query("SELECT program.programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE under = '$programid' AND state = 1 AND accID = '$accid' ORDER BY title ASC");
                    }
                    else{
                        $sql3 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                    }
					if(mysql_num_rows($sql3) != 0){
						while($fetch3 = mysql_fetch_assoc($sql3)){
							$programid = $fetch3['programID'];
							$title = $fetch3['title'];
							$status = $fetch3['status'];
							$output .= 
							'<tr>
								<td style="padding-left: 60px;">'.$title.'</td>';
							if($status == 0){
								$output .= '<td colspan="12" class="grey lighten-2"></td>';
							}
							else{
								$limit = 3;
								for ($i = 1; $i <= 12 ; $i = $i + 3) { 
									if($_SESSION['level'] == 3){
                                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                                    }
                                    else{
                                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid'".$sub);   
                                    }
									$get = mysql_fetch_assoc($query);
									$target = $get['target'];
									$accomplish = $get['accomplish'];
									if($target != 0 && $accomplish != 0){	
										$remark = round((((($accomplish - $target)/$target)*100)+100), 1);
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
										if($rating >= 4.8){
											$adj = "Outstanding";
										}
										else if($rating <= 4.79 && $rating >= 4){
											$adj = "Very Satisfactory";
										}
										else if($rating <= 3.99 && $rating >= 3){
											$adj = "Satisfactory";
										}
										else if($rating <= 2.99 && $rating >= 0){
											$adj = "Unsatisfactory";
										}
										$output .= 
											'<td class="text-center">'.$remark.'</td>
											<td class="text-center">'.$rating.'</td>
											<td class="text-center">'.$adj.'</td>';
									}
									else{
										$output .=
										'<td class="text-center">-</td>
										<td class="text-center">-</td>
										<td class="text-center">-</td>';
									}
									$limit = $limit + 3;
								}
							}
							$output .= '</tr>';
							// level 4
							if($_SESSION['level'] == 3){
                                $sql4 = mysql_query("SELECT program.programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE under = '$programid' AND state = 1 AND accID = '$accid' ORDER BY title ASC");
                            }
                            else{
                                $sql4 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                            }
							if(mysql_num_rows($sql4) != 0){
								while($fetch4 = mysql_fetch_assoc($sql4)){
									$programid = $fetch4['programID'];
									$title = $fetch4['title'];
									$status = $fetch4['status'];
									$output .= 
									'<tr>
										<td style="padding-left: 80px;">'.$title.'</td>';
									if($status == 0){
										$output .= '<td colspan="12" class="grey lighten-2"></td>';
									}
									else{
										$limit = 3;
										for ($i = 1; $i <= 12 ; $i = $i + 3) { 
											if($_SESSION['level'] == 3){
                                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                                            }
                                            else{
                                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid'".$sub);   
                                            }
											$get = mysql_fetch_assoc($query);
											$target = $get['target'];
											$accomplish = $get['accomplish'];
											if($target != 0 && $accomplish != 0){	
												$remark = round((((($accomplish - $target)/$target)*100)+100), 1);
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
												if($rating >= 4.8){
													$adj = "Outstanding";
												}
												else if($rating <= 4.79 && $rating >= 4){
													$adj = "Very Satisfactory";
												}
												else if($rating <= 3.99 && $rating >= 3){
													$adj = "Satisfactory";
												}
												else if($rating <= 2.99 && $rating >= 0){
													$adj = "Unsatisfactory";
												}
												$output .= 
													'<td class="text-center">'.$remark.'</td>
													<td class="text-center">'.$rating.'</td>
													<td class="text-center">'.$adj.'</td>';
											}
											else{
												$output .=
												'<td class="text-center">-</td>
												<td class="text-center">-</td>
												<td class="text-center">-</td>';
											}
											$limit = $limit + 3;
										}
									}
									$output .= '</tr>';
									// level 5
									if($_SESSION['level'] == 3){
                                        $sql5 = mysql_query("SELECT program.programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE under = '$programid' AND state = 1 AND accID = '$accid' ORDER BY title ASC");
                                    }
                                    else{
                                        $sql5 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                                    }
									if(mysql_num_rows($sql5) != 0){
										while($fetch5 = mysql_fetch_assoc($sql5)){
											$programid = $fetch5['programID'];
											$title = $fetch5['title'];
											$status = $fetch5['status'];
											$output .= 
											'<tr>
												<td style="padding-left: 100px;">'.$title.'</td>';
											if($status == 0){
												$output .= '<td colspan="12" class="grey lighten-2"></td>';
											}
											else{
												$limit = 3;
												for ($i = 1; $i <= 12 ; $i = $i + 3) { 
													if($_SESSION['level'] == 3){
                                                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                                                    }
                                                    else{
                                                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);    
                                                    }
													$get = mysql_fetch_assoc($query);
													$target = $get['target'];
													$accomplish = $get['accomplish'];
													if($target != 0 && $accomplish != 0){	
														$remark = round((((($accomplish - $target)/$target)*100)+100), 1);
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
														if($rating >= 4.8){
															$adj = "Outstanding";
														}
														else if($rating <= 4.79 && $rating >= 4){
															$adj = "Very Satisfactory";
														}
														else if($rating <= 3.99 && $rating >= 3){
															$adj = "Satisfactory";
														}
														else if($rating <= 2.99 && $rating >= 0){
															$adj = "Unsatisfactory";
														}
														$output .= 
															'<td class="text-center">'.$remark.'</td>
															<td class="text-center">'.$rating.'</td>
															<td class="text-center">'.$adj.'</td>';
													}
													else{
														$output .=
														'<td class="text-center">-</td>
														<td class="text-center">-</td>
														<td class="text-center">-</td>';
													}
													$limit = $limit + 3;
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
        $output .= '</tbody>';
    }
    if($print == "target"){
        $accid = mysql_escape_string($_GET['accid']);
        $year = mysql_escape_string($_GET['year']);
		$output = "";
        $output .= '<thead class="mdb-color darken-3">
						<tr class="white-text text-center">
							<td style="width: 300px;">Services Programs/Projects</td>
							<td>Jan</td>
							<td>Feb</td>
							<td>Mar</td>
							<td>Apr</td>
							<td>May</td>
							<td>Jun</td>
							<td>Jul</td>
							<td>Aug</td>
							<td>Sep</td>
							<td>Oct</td>
							<td>Nov</td>
							<td>Dec</td>
						</tr>
					</thead>';
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
        $sql = mysql_query("SELECT assignID, program.programID AS programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE accID = '$accid' AND level = 1");
        if(mysql_num_rows($sql) != 0){
            while($fetch = mysql_fetch_assoc($sql)){
                $programid = $fetch['programID'];
				$assignid = $fetch['assignID'];
				$title = $fetch['title'];
				$status = $fetch['status'];
				$output .= 
				'<tr id="assign'.$assignid.'">
					<td width="40%" for="title">'.$title.'</td>';
				if($status == 0){
					$output .= 
					'<td colspan="13" class="grey lighten-2"></td>';
				}
				else{
					for ($i = 1; $i <= 12 ; $i++) { 
						switch($i){
							case 1:
								$output .= '<td class="text-center jan'.$assignid.'">';
								break;
							case 2:
								$output .= '<td class="text-center feb'.$assignid.'">';
								break;
							case 3:
								$output .= '<td class="text-center mar'.$assignid.'">';
								break;
							case 4:
								$output .= '<td class="text-center apr'.$assignid.'">';
								break;
							case 5:
								$output .= '<td class="text-center may'.$assignid.'">';
								break;
							case 6:
								$output .= '<td class="text-center jun'.$assignid.'">';
								break;
							case 7:
								$output .= '<td class="text-center jul'.$assignid.'">';
								break;
							case 8:
								$output .= '<td class="text-center aug'.$assignid.'">';
								break;
							case 9:
								$output .= '<td class="text-center sep'.$assignid.'">';
								break;
							case 10:
								$output .= '<td class="text-center oct'.$assignid.'">';
								break;
							case 11:
								$output .= '<td class="text-center nov'.$assignid.'">';
								break;
							case 12:
								$output .= '<td class="text-center dec'.$assignid.'">';
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
                }
				$output .= '</tr>';
                $sql2 = mysql_query("SELECT assignID, program.programID AS programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE accID = '$accid' AND under = '$programid'");
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
                                        $output .= '<td class="text-center jan'.$assignid.'">';
                                        break;
                                    case 2:
                                        $output .= '<td class="text-center feb'.$assignid.'">';
                                        break;
                                    case 3:
                                        $output .= '<td class="text-center mar'.$assignid.'">';
                                        break;
                                    case 4:
                                        $output .= '<td class="text-center apr'.$assignid.'">';
                                        break;
                                    case 5:
                                        $output .= '<td class="text-center may'.$assignid.'">';
                                        break;
                                    case 6:
                                        $output .= '<td class="text-center jun'.$assignid.'">';
                                        break;
                                    case 7:
                                        $output .= '<td class="text-center jul'.$assignid.'">';
                                        break;
                                    case 8:
                                        $output .= '<td class="text-center aug'.$assignid.'">';
                                        break;
                                    case 9:
                                        $output .= '<td class="text-center sep'.$assignid.'">';
                                        break;
                                    case 10:
                                        $output .= '<td class="text-center oct'.$assignid.'">';
                                        break;
                                    case 11:
                                        $output .= '<td class="text-center nov'.$assignid.'">';
                                        break;
                                    case 12:
                                        $output .= '<td class="text-center dec'.$assignid.'">';
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
                        }
                        $output .= '</tr>';
                        $sql3 = mysql_query("SELECT assignID, program.programID AS programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE accID = '$accid' AND under = '$programid'");
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
                                                $output .= '<td class="text-center jan'.$assignid.'">';
                                                break;
                                            case 2:
                                                $output .= '<td class="text-center feb'.$assignid.'">';
                                                break;
                                            case 3:
                                                $output .= '<td class="text-center mar'.$assignid.'">';
                                                break;
                                            case 4:
                                                $output .= '<td class="text-center apr'.$assignid.'">';
                                                break;
                                            case 5:
                                                $output .= '<td class="text-center may'.$assignid.'">';
                                                break;
                                            case 6:
                                                $output .= '<td class="text-center jun'.$assignid.'">';
                                                break;
                                            case 7:
                                                $output .= '<td class="text-center jul'.$assignid.'">';
                                                break;
                                            case 8:
                                                $output .= '<td class="text-center aug'.$assignid.'">';
                                                break;
                                            case 9:
                                                $output .= '<td class="text-center sep'.$assignid.'">';
                                                break;
                                            case 10:
                                                $output .= '<td class="text-center oct'.$assignid.'">';
                                                break;
                                            case 11:
                                                $output .= '<td class="text-center nov'.$assignid.'">';
                                                break;
                                            case 12:
                                                $output .= '<td class="text-center dec'.$assignid.'">';
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
                                }
                                $output .= '</tr>';
                                $sql4 = mysql_query("SELECT assignID, program.programID AS programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE accID = '$accid' AND under = '$programid'");
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
                                                        $output .= '<td class="text-center jan'.$assignid.'">';
                                                        break;
                                                    case 2:
                                                        $output .= '<td class="text-center feb'.$assignid.'">';
                                                        break;
                                                    case 3:
                                                        $output .= '<td class="text-center mar'.$assignid.'">';
                                                        break;
                                                    case 4:
                                                        $output .= '<td class="text-center apr'.$assignid.'">';
                                                        break;
                                                    case 5:
                                                        $output .= '<td class="text-center may'.$assignid.'">';
                                                        break;
                                                    case 6:
                                                        $output .= '<td class="text-center jun'.$assignid.'">';
                                                        break;
                                                    case 7:
                                                        $output .= '<td class="text-center jul'.$assignid.'">';
                                                        break;
                                                    case 8:
                                                        $output .= '<td class="text-center aug'.$assignid.'">';
                                                        break;
                                                    case 9:
                                                        $output .= '<td class="text-center sep'.$assignid.'">';
                                                        break;
                                                    case 10:
                                                        $output .= '<td class="text-center oct'.$assignid.'">';
                                                        break;
                                                    case 11:
                                                        $output .= '<td class="text-center nov'.$assignid.'">';
                                                        break;
                                                    case 12:
                                                        $output .= '<td class="text-center dec'.$assignid.'">';
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
                                        }
                                        $output .= '</tr>';
                                        $sql5 = mysql_query("SELECT assignID, program.programID AS programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE accID = '$accid' AND under = '$programid'");
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
                                                                $output .= '<td class="text-center jan'.$assignid.'">';
                                                                break;
                                                            case 2:
                                                                $output .= '<td class="text-center feb'.$assignid.'">';
                                                                break;
                                                            case 3:
                                                                $output .= '<td class="text-center mar'.$assignid.'">';
                                                                break;
                                                            case 4:
                                                                $output .= '<td class="text-center apr'.$assignid.'">';
                                                                break;
                                                            case 5:
                                                                $output .= '<td class="text-center may'.$assignid.'">';
                                                                break;
                                                            case 6:
                                                                $output .= '<td class="text-center jun'.$assignid.'">';
                                                                break;
                                                            case 7:
                                                                $output .= '<td class="text-center jul'.$assignid.'">';
                                                                break;
                                                            case 8:
                                                                $output .= '<td class="text-center aug'.$assignid.'">';
                                                                break;
                                                            case 9:
                                                                $output .= '<td class="text-center sep'.$assignid.'">';
                                                                break;
                                                            case 10:
                                                                $output .= '<td class="text-center oct'.$assignid.'">';
                                                                break;
                                                            case 11:
                                                                $output .= '<td class="text-center nov'.$assignid.'">';
                                                                break;
                                                            case 12:
                                                                $output .= '<td class="text-center dec'.$assignid.'">';
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
    if($print == "accomplish"){
        $accid = mysql_escape_string($_GET['accid']);
        $year = mysql_escape_string($_GET['year']);
		$output = "";
        $output .= '<thead class="mdb-color darken-3">
						<tr class="white-text text-center">
							<td style="width: 300px;">Services Programs/Projects</td>
							<td>Jan</td>
							<td>Feb</td>
							<td>Mar</td>
							<td>Apr</td>
							<td>May</td>
							<td>Jun</td>
							<td>Jul</td>
							<td>Aug</td>
							<td>Sep</td>
							<td>Oct</td>
							<td>Nov</td>
							<td>Dec</td>
						</tr>
					</thead>';
        $sql = mysql_query("SELECT accomplish FROM locked WHERE year = '$year'");
        if(mysql_num_rows($sql) == 0){
            $input = true;
        }
        else{
            $fetch = mysql_fetch_assoc($sql);
            if($fetch['accomplish'] == 1){
                $input = false;
            }
            else{
                $input = true;
            }
        }
        $sql = mysql_query("SELECT assignID, program.programID AS programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE accID = '$accid' AND level = 1");
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
								$output .= '<td class="text-center jan'.$assignid.'">';
								break;
							case 2:
								$output .= '<td class="text-center feb'.$assignid.'">';
								break;
							case 3:
								$output .= '<td class="text-center mar'.$assignid.'">';
								break;
							case 4:
								$output .= '<td class="text-center apr'.$assignid.'">';
								break;
							case 5:
								$output .= '<td class="text-center may'.$assignid.'">';
								break;
							case 6:
								$output .= '<td class="text-center jun'.$assignid.'">';
								break;
							case 7:
								$output .= '<td class="text-center jul'.$assignid.'">';
								break;
							case 8:
								$output .= '<td class="text-center aug'.$assignid.'">';
								break;
							case 9:
								$output .= '<td class="text-center sep'.$assignid.'">';
								break;
							case 10:
								$output .= '<td class="text-center oct'.$assignid.'">';
								break;
							case 11:
								$output .= '<td class="text-center nov'.$assignid.'">';
								break;
							case 12:
								$output .= '<td class="text-center dec'.$assignid.'">';
								break;
						}
                        $sql_accomplish = mysql_query("SELECT accomplish FROM targetaccomplish WHERE assignID = '$assignid' AND month = '$i' AND year = '$year'");
						if(mysql_num_rows($sql_accomplish) != 0){
							$fetch = mysql_fetch_assoc($sql_accomplish);
							if($fetch['accomplish'] != 0){
								$output .= $fetch['accomplish'];
							}
							else{
								$output .= "-";
							}
						}
						$output .= '</td>';
                    }
                }
				$output .= '</tr>';
                $sql2 = mysql_query("SELECT assignID, program.programID AS programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE accID = '$accid' AND under = '$programid'");
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
                                        $output .= '<td class="text-center jan'.$assignid.'">';
                                        break;
                                    case 2:
                                        $output .= '<td class="text-center feb'.$assignid.'">';
                                        break;
                                    case 3:
                                        $output .= '<td class="text-center mar'.$assignid.'">';
                                        break;
                                    case 4:
                                        $output .= '<td class="text-center apr'.$assignid.'">';
                                        break;
                                    case 5:
                                        $output .= '<td class="text-center may'.$assignid.'">';
                                        break;
                                    case 6:
                                        $output .= '<td class="text-center jun'.$assignid.'">';
                                        break;
                                    case 7:
                                        $output .= '<td class="text-center jul'.$assignid.'">';
                                        break;
                                    case 8:
                                        $output .= '<td class="text-center aug'.$assignid.'">';
                                        break;
                                    case 9:
                                        $output .= '<td class="text-center sep'.$assignid.'">';
                                        break;
                                    case 10:
                                        $output .= '<td class="text-center oct'.$assignid.'">';
                                        break;
                                    case 11:
                                        $output .= '<td class="text-center nov'.$assignid.'">';
                                        break;
                                    case 12:
                                        $output .= '<td class="text-center dec'.$assignid.'">';
                                        break;
                                }
                                $sql_accomplish = mysql_query("SELECT accomplish FROM targetaccomplish WHERE assignID = '$assignid' AND month = '$i' AND year = '$year'");
                                if(mysql_num_rows($sql_accomplish) != 0){
                                    $fetch = mysql_fetch_assoc($sql_accomplish);
                                    if($fetch['accomplish'] != 0){
                                        $output .= $fetch['accomplish'];
                                    }
                                    else{
                                        $output .= "-";
                                    }
                                }
                                $output .= '</td>';
                            }
                        }
                        $output .= '</tr>';
                        $sql3 = mysql_query("SELECT assignID, program.programID AS programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE accID = '$accid' AND under = '$programid'");
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
                                                $output .= '<td class="text-center jan'.$assignid.'">';
                                                break;
                                            case 2:
                                                $output .= '<td class="text-center feb'.$assignid.'">';
                                                break;
                                            case 3:
                                                $output .= '<td class="text-center mar'.$assignid.'">';
                                                break;
                                            case 4:
                                                $output .= '<td class="text-center apr'.$assignid.'">';
                                                break;
                                            case 5:
                                                $output .= '<td class="text-center may'.$assignid.'">';
                                                break;
                                            case 6:
                                                $output .= '<td class="text-center jun'.$assignid.'">';
                                                break;
                                            case 7:
                                                $output .= '<td class="text-center jul'.$assignid.'">';
                                                break;
                                            case 8:
                                                $output .= '<td class="text-center aug'.$assignid.'">';
                                                break;
                                            case 9:
                                                $output .= '<td class="text-center sep'.$assignid.'">';
                                                break;
                                            case 10:
                                                $output .= '<td class="text-center oct'.$assignid.'">';
                                                break;
                                            case 11:
                                                $output .= '<td class="text-center nov'.$assignid.'">';
                                                break;
                                            case 12:
                                                $output .= '<td class="text-center dec'.$assignid.'">';
                                                break;
                                        }
                                        $sql_accomplish = mysql_query("SELECT accomplish FROM targetaccomplish WHERE assignID = '$assignid' AND month = '$i' AND year = '$year'");
                                        if(mysql_num_rows($sql_accomplish) != 0){
                                            $fetch = mysql_fetch_assoc($sql_accomplish);
                                            if($fetch['accomplish'] != 0){
                                                $output .= $fetch['accomplish'];
                                            }
                                            else{
                                                $output .= "-";
                                            }
                                        }
                                        $output .= '</td>';
                                    }
                                }
                                $output .= '</tr>';
                                $sql4 = mysql_query("SELECT assignID, program.programID AS programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE accID = '$accid' AND under = '$programid'");
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
                                                        $output .= '<td class="text-center jan'.$assignid.'">';
                                                        break;
                                                    case 2:
                                                        $output .= '<td class="text-center feb'.$assignid.'">';
                                                        break;
                                                    case 3:
                                                        $output .= '<td class="text-center mar'.$assignid.'">';
                                                        break;
                                                    case 4:
                                                        $output .= '<td class="text-center apr'.$assignid.'">';
                                                        break;
                                                    case 5:
                                                        $output .= '<td class="text-center may'.$assignid.'">';
                                                        break;
                                                    case 6:
                                                        $output .= '<td class="text-center jun'.$assignid.'">';
                                                        break;
                                                    case 7:
                                                        $output .= '<td class="text-center jul'.$assignid.'">';
                                                        break;
                                                    case 8:
                                                        $output .= '<td class="text-center aug'.$assignid.'">';
                                                        break;
                                                    case 9:
                                                        $output .= '<td class="text-center sep'.$assignid.'">';
                                                        break;
                                                    case 10:
                                                        $output .= '<td class="text-center oct'.$assignid.'">';
                                                        break;
                                                    case 11:
                                                        $output .= '<td class="text-center nov'.$assignid.'">';
                                                        break;
                                                    case 12:
                                                        $output .= '<td class="text-center dec'.$assignid.'">';
                                                        break;
                                                }
                                                $sql_accomplish = mysql_query("SELECT accomplish FROM targetaccomplish WHERE assignID = '$assignid' AND month = '$i' AND year = '$year'");
                                                if(mysql_num_rows($sql_accomplish) != 0){
                                                    $fetch = mysql_fetch_assoc($sql_accomplish);
                                                    if($fetch['accomplish'] != 0){
                                                        $output .= $fetch['accomplish'];
                                                    }
                                                    else{
                                                        $output .= "-";
                                                    }
                                                }
                                                $output .= '</td>';
                                            }
                                        }
                                        $output .= '</tr>';
                                        $sql5 = mysql_query("SELECT assignID, program.programID AS programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE accID = '$accid' AND under = '$programid'");
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
                                                                $output .= '<td class="text-center jan'.$assignid.'">';
                                                                break;
                                                            case 2:
                                                                $output .= '<td class="text-center feb'.$assignid.'">';
                                                                break;
                                                            case 3:
                                                                $output .= '<td class="text-center mar'.$assignid.'">';
                                                                break;
                                                            case 4:
                                                                $output .= '<td class="text-center apr'.$assignid.'">';
                                                                break;
                                                            case 5:
                                                                $output .= '<td class="text-center may'.$assignid.'">';
                                                                break;
                                                            case 6:
                                                                $output .= '<td class="text-center jun'.$assignid.'">';
                                                                break;
                                                            case 7:
                                                                $output .= '<td class="text-center jul'.$assignid.'">';
                                                                break;
                                                            case 8:
                                                                $output .= '<td class="text-center aug'.$assignid.'">';
                                                                break;
                                                            case 9:
                                                                $output .= '<td class="text-center sep'.$assignid.'">';
                                                                break;
                                                            case 10:
                                                                $output .= '<td class="text-center oct'.$assignid.'">';
                                                                break;
                                                            case 11:
                                                                $output .= '<td class="text-center nov'.$assignid.'">';
                                                                break;
                                                            case 12:
                                                                $output .= '<td class="text-center dec'.$assignid.'">';
                                                                break;
                                                        }
                                                        $sql_accomplish = mysql_query("SELECT accomplish FROM targetaccomplish WHERE assignID = '$assignid' AND month = '$i' AND year = '$year'");
                                                        if(mysql_num_rows($sql_accomplish) != 0){
                                                            $fetch = mysql_fetch_assoc($sql_accomplish);
                                                            if($fetch['accomplish'] != 0){
                                                                $output .= $fetch['accomplish'];
                                                            }
                                                            else{
                                                                $output .= "-";
                                                            }
                                                        }
                                                        $output .= '</td>';
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
    if($print == "assign"){
        $region = mysql_escape_string($_GET['region']);
        if($region != 0){
            $sub = " AND regionID = ".$region;
        }
        $output = "";
        $output .= '<thead class="mdb-color darken-3">
						<tr class="text-center white-text">
							<th style="width: 500px;">Services Programs/Projects</th>
							<th colspan="2">Assigned Personnel</th>
						</tr>
					</thead>
					<tbody>';
        // level 1
        $sql = mysql_query("SELECT programID, title, status FROM program WHERE level = 1 AND state = 1 ORDER BY title ASC");
        while($fetch = mysql_fetch_assoc($sql)){
            $programid = $fetch['programID'];
            $title = $fetch['title'];
            $status = $fetch['status'];
            $output .= 
            '<tr>
            <td style="padding-left: 20px;">'.$title.'</td>';
            if($status == 0){
                $output .= 
                '<td colspan="24" class="grey lighten-2"></td>';
            }
            else{
                $query = mysql_query("SELECT name FROM assign INNER JOIN account ON assign.accID = account.accID WHERE programID = '$programid'".$sub." ORDER BY name ASC");
                if(mysql_num_rows($query) == 0){
                    $output .= '<td></td>';
                }
                else{
                    $output .= '<td>';
                    while($get = mysql_fetch_assoc($query)){
                        $name = $get['name'];
                        $output .= $name.', ';
                    }
                    $output .= '</td>';
                }
            }
            $output .= '</tr>';
            // level 2
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
                        $output .= 
                        '<td colspan="24" class="grey lighten-2"></td>';
                    }
                    else{
                        $query = mysql_query("SELECT name FROM assign INNER JOIN account ON assign.accID = account.accID WHERE programID = '$programid'".$sub." ORDER BY name ASC");
                        if(mysql_num_rows($query) == 0){
                            $output .= '<td></td>';
                        }
                        else{
                            $output .= '<td>';
                            while($get = mysql_fetch_assoc($query)){
                                $name = $get['name'];
                                $output .= $name.', ';
                            }
                            $output .= '</td>';
                        }
                    }
                    $output .= '</tr>';
                    // level 3
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
                                $output .= 
                                '<td colspan="24" class="grey lighten-2"></td>';
                            }
                            else{
                                $query = mysql_query("SELECT name FROM assign INNER JOIN account ON assign.accID = account.accID WHERE programID = '$programid'".$sub." ORDER BY name ASC");
                                if(mysql_num_rows($query) == 0){
                                    $output .= '<td></td>';
                                }
                                else{
                                    $output .= '<td>';
                                    while($get = mysql_fetch_assoc($query)){
                                        $name = $get['name'].', ';
                                        $output .= $name;
                                    }
                                    $output .= '</td>';
                                }
                            }
                            $output .= '</tr>';
                            // level 4
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
                                        $output .= 
                                        '<td colspan="24" class="grey lighten-2"></td>';
                                    }
                                    else{
                                        $query = mysql_query("SELECT name FROM assign INNER JOIN account ON assign.accID = account.accID WHERE programID = '$programid'".$sub." ORDER BY name ASC");
                                        if(mysql_num_rows($query) == 0){
                                            $output .= '<td></td>';
                                        }
                                        else{
                                            $output .= '<td>';
                                            while($get = mysql_fetch_assoc($query)){
                                                $name = $get['name'].', ';
                                                $output .= $name;
                                            }
                                            $output .= '</td>';
                                        }
                                    }
                                    $output .= '</tr>';
    //                                level 5
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
                                                $output .= 
                                                '<td colspan="24" class="grey lighten-2"></td>';
                                            }
                                            else{
                                               $query = mysql_query("SELECT name FROM assign INNER JOIN account ON assign.accID = account.accID WHERE programID = '$programid'".$sub." ORDER BY name ASC");
                                                if(mysql_num_rows($query) == 0){
                                                    $output .= '<td></td>';
                                                }
                                                else{
                                                    $output .= '<td>';
                                                    while($get = mysql_fetch_assoc($query)){
                                                        $name = $get['name'].', ';
                                                        $output .= $name;
                                                    }
                                                    $output .= '</td>';
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
        $output .= '</tbody>';
    }
    if($print == "percent"){
        $year = mysql_escape_string($_GET['year']);
        $region = mysql_escape_string($_GET['region']);
        $output = "";
        $totaltarget = 0;
        $totalaccomplish = 0;
        $totalequivalent = 0;
        $totalpercentage = 0;
        if($region != 0){
            $sub = " AND regionID = ".$region;
        }
//        level 1
        $sql = mysql_query("SELECT title, programID, percentage FROM program WHERE state = 1 AND level = 1 ORDER BY title ASC");
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
//                level 2
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
                $output .= '<tr><td style="width: 200px;">'.$title.'</td>
                <td class="text-center">'.$totaltarget.'</td>
                <td class="text-center">'.$totalaccomplish.'</td>
                <td class="text-center">'.$percent.'</td>
                <td class="text-center">'.($percentage/100).'</td>
                <td class="text-center">'.round($percent/$percentage, 2).'</td></tr>';
            }
            $output .= '<tr class="red-text"><td>Total</td><td colspan="3"></td><td class="text-center">'.$totalpercentage.'</td><td class="text-center">'.$totalequivalent.'</td></tr>';
        }
        $output .= '</tbody></table>';
        $output .= '<table class="table table-bordered">
                        <thead class="mdb-color darken-3 white-text text-center">
                            <tr><th>Prepared by:</th>
                            <th>Reviewed by:</th>
                            <th>Approved by:</th>
                            <th>Date</th></tr><tr>
                        </tr></thead>
                        <tbody>
                            <tr class="text-center">
                                <td><br></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>';
    }
    if($print == "monthlyreport"){
        $mode = mysql_escape_string($_GET['mode']);
        if($mode == "month"){
            $year = mysql_escape_string($_GET['year']);
            $month = mysql_escape_string($_GET['month']);
            if($month == 1){
                $output = '<table class="table table-bordered table-striped">
                        <thead class="mdb-color darken-3 table-striped">
                            <tr class="white-text text-center">
                                <td style="width: 500px;">Services Programs/Projects</td>
                                <td colspan="2">January</td>
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
        }
        if($mode == "quarter"){
            $year = mysql_escape_string($_GET['year']);
            $quarter = mysql_escape_string($_GET['quarter']);
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
        }
    }
    if($print == "opcr"){
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
        $sql = mysql_query("SELECT programID, title, status FROM program WHERE level = 1 AND state = 1 ORDER BY title ASC");
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
            $sql2 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
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
                    $sql3 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
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
                            $sql4 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
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
                                    $sql5 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
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
                                                        else if($target == 4){
                                                            $target_q2 = $target;
                                                            $target_qtotal[2] += $target;
                                                        }
                                                        else if($target == 7){
                                                            $target_q3 = $target;
                                                            $target_qtotal[3] += $target;
                                                        }
                                                        else if($target == 10){
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
        $sql = mysql_query("SELECT DISTINCT(account.accID), name FROM account INNER JOIN milestone ON account.accID = milestone.accID WHERE year = '$year'".$sub);
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
//        level 1
        $sql = mysql_query("SELECT title, programID, percentage FROM program WHERE state = 1 AND level = 1 ORDER BY title ASC");
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
//                level 2
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
    }
    if($print == 'ipcr'){
        $region = mysql_escape_string($_GET['region']);
        $year = mysql_escape_string($_GET['year']);
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
        $sql = mysql_query("SELECT DISTINCT(account.accID), name FROM account INNER JOIN milestone ON account.accID = milestone.accID WHERE year = '$year' AND milestone.accID = '$accid'".$sub);
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
//        level 1
        $sql = mysql_query("SELECT title, program.programID, percentage FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN account ON assign.accID = account.accID WHERE state = 1 AND level = 1 AND assign.accID = '$accid' ORDER BY title ASC");
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
//                level 2
                $sql2 = mysql_query("SELECT program.programID FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN account ON assign.accID = account.accID WHERE under = '$programid' AND assign.accID = '$accid'");
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
                        $sql3 = mysql_query("SELECT program.programID FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN account ON assign.accID = account.accID WHERE under = '$programid' AND assign.accID = '$accid'");
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
                                $sql4 = mysql_query("SELECT program.programID FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN account ON assign.accID = account.accID WHERE under = '$programid' AND assign.accID = '$accid'");
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
                                        $sql5 = mysql_query("SELECT program.programID FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN account ON assign.accID = account.accID WHERE under = '$programid' AND assign.accID = '$accid'");
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
    }
?>