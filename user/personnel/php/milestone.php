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
    if($action == "listmilestone"){
        $accid = $_SESSION['accID'];
        $year = mysql_escape_string($_POST['year']);
        $output = "";
        $sql = mysql_query("SELECT milestoneID, milestone FROM milestone WHERE accID = '$accid' AND year = '$year' ORDER BY milestone ASC");
        if(mysql_num_rows($sql) == 0){
            $output .= '<tr><td colspan="2"><p class="h1-responsive text-center">No milestone found</p></td></tr>';
        }
        else{
            while($fetch = mysql_fetch_assoc($sql)){
                $milestoneid = $fetch['milestoneID'];
                $milestone = $fetch['milestone'];
                $output .= '<tr data-id="'.$milestoneid.'"><td class="milestone">'.$milestone.'</td><td><a><span data-toggle="modal" data-target="#modaleditmilestone" class="badge badge-warning editmilestone"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></span></a> <a><span data-toggle="modal" data-target="#modaldeletemilestone" class="badge badge-danger"><i class="fa fa-trash fa-2x" aria-hidden="true"></i></span></a></td></tr>';
            }
        }
        echo json_encode($output);
    }
    if($action == "deletemilestone"){
        $milestoneid = mysql_escape_string($_POST['milestoneid']);
        mysql_query("DELETE FROM milestone WHERE milestoneID = '$milestoneid'");
    }
    if($action == "addmilestone"){
        $accid = $_SESSION['accID'];
        $milestone = mysql_escape_string($_POST['milestone']);
        $year = mysql_escape_string($_POST['year']);
        mysql_query("INSERT INTO milestone (milestone, year, accID) VALUES ('$milestone', '$year', '$accid')");
    }
    if($action == "editmilestone"){
        $milestoneid = mysql_escape_string($_POST['milestoneid']);
        $milestone = mysql_escape_string($_POST['milestone']);
        $year = mysql_escape_string($_POST['year']);
        mysql_query("UPDATE milestone SET milestone = '$milestone', year = '$year' WHERE milestoneID = '$milestoneid'");
    }
?>