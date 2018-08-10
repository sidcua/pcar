<?php
    session_start();
    include '../../../php/connect.php';
    $action = $_POST['action'];
    if($action == "fetchdata"){
        $output = "";
        $totalweight = 0;
        $sql = mysql_query("SELECT programID, title, percentage FROM program WHERE level = 1 AND state = 1 ORDER BY title ASC");
        if(mysql_num_rows($sql) == 0){
            $output .= '<tr><td colspan="3" class="text-center h1-responsive">No programs found</td></tr>';
        }
        else{
            while($fetch = mysql_fetch_assoc($sql)){
                $programid = $fetch['programID'];
                $title = $fetch['title'];
                $percentage = $fetch['percentage'];
                $totalweight += $percentage;
                $output .= '<tr data-id="'.$programid.'"><td>'.$title.'</td><td class="weight">'.$percentage.'</td><td><a><span data-toggle="modal" data-target="#modaleditweight" class="badge badge-warning editweight"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></a></td></tr>';
            }
            $output .= '<tr class="red-text"><td></td><td>'.$totalweight.'</td><td></td></tr>';
        }
        echo json_encode($output);
    }
    if($action == "editweight"){
        $programid = mysql_escape_string($_POST['programid']);
        $percentage = mysql_escape_string($_POST['weight']);
        $percentage = round($percentage,2);
        $sql = mysql_query("SELECT SUM(percentage) AS percentage FROM program WHERE level = 1 AND programID != '$programid'");
        $fetch = mysql_fetch_assoc($sql);
        $total_percentage = $fetch['percentage'] + $percentage;
        if($total_percentage > 100){
            echo json_encode(false);
        }
        else{
            mysql_query("UPDATE program SET percentage = '$percentage' WHERE programID = '$programid'");
            echo json_encode(true);
        }
    }
?>