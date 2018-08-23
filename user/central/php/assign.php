<?php
    session_start();
    include '../../../php/connect.php';
    $action = $_POST['action'];
    
    if($action == "listassign"){
        $region = mysql_escape_string($_POST['region']);
        $report = mysql_escape_string($_POST['report']);
        if($region != 0){
            $sub = " AND regionID = ".$region;
        }
        $output .= "";
        $output .= '<thead class="mdb-color darken-3">
						<tr class="text-center white-text">
							<th style="width: 500px;">Services Programs/Projects</th>
							<th colspan="2">Assigned Personnel</th>
						</tr>
					</thead>
					<tbody>';
        // level 1
        $sql = mysql_query("SELECT programID, title, status FROM program WHERE level = 1 AND state = 1 AND reportID = '$report' ORDER BY title ASC");
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
            $sql2 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 AND reportID = '$report' ORDER BY title ASC");
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
                    $sql3 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 AND reportID = '$report' ORDER BY title ASC");
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
                            $sql4 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 AND reportID = '$report' ORDER BY title ASC");
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
                                    $sql5 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 AND reportID = '$report' ORDER BY title ASC");
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
                                            //level 6
                                            $sql6 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 AND reportID = '$report' ORDER BY title ASC");
                                            if(mysql_num_rows($sql6) != 0){
                                                while($fetch6 = mysql_fetch_assoc($sql6)){
                                                    $programid = $fetch6['programID'];
                                                    $title = $fetch6['title'];
                                                    $status = $fetch6['status'];
                                                    $output .= 
                                                    '<tr>
                                                    <td style="padding-left: 120px;">'.$title.'</td>';
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
            }
        }
        $output .= '</tbody>';
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
    if($action == "initreport"){
        $sql = mysql_query("SELECT * FROM report WHERE status = 1");
        $output = "";
        while($fetch = mysql_fetch_assoc($sql)){
            $reportid = $fetch['reportID'];
            $report = $fetch['report'];
            $output .= '<option value="'.$reportid.'">'.$report.'</option>';
        }
        echo json_encode($output);
    }
?>