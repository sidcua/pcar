<?php
    session_start();
    include '../../../php/connect.php';
    $action = $_POST['action'];
    if($action == "fetchdata"){
        $year = mysql_escape_string($_POST['year']);
        $region = mysql_escape_string($_POST['region']);
        $reportid = mysql_escape_string($_POST['report']);
        $output = "";
        $totaltarget = 0;
        $totalaccomplish = 0;
        $totalequivalent = 0;
        $totalpercentage = 0;
        if($region != 0){
            $sub = " AND regionID = ".$region;
        }
        //level 1
        $sql = mysql_query("SELECT title, programID, percentage FROM program WHERE state = 1 AND level = 1 AND reportID = '$reportid'");
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
                                //levle 4
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
        echo json_encode($output);
    }
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
        if($_SESSION['level'] < 2){
            $obj['level'] = true;
        }
        else{
            $obj['level'] = false;
        }
        echo json_encode($obj);
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