<?php
    session_start();
    include '../../../php/connect.php';
    $action = $_POST['action'];

    if($action == "inityear_lock"){
		$latest = date('Y');
		for ($i = $latest; $i >= 2014 ; $i--) { 
			$output .= '<option value="'.$i.'">'.$i.'</option>';
		}
		echo json_encode($output);
	}
    if($action == "initswitch"){
        $year = mysql_escape_string($_POST['year']);
        $sql = mysql_query("SELECT target, accomplish FROM locked WHERE year = '$year'");
        if(mysql_num_rows($sql) == 0){
            $obj['target'] = 0;
            $obj['accomplish'] = 0;
        }
        else{
            $fetch = mysql_fetch_assoc($sql);
            $obj['target'] = $fetch['target'];
            $obj['accomplish'] = $fetch['accomplish'];
        }
        echo json_encode($obj);
    }
    if($action == "targettoggle"){
        $year = mysql_escape_string($_POST['year']);
        $value = mysql_escape_string($_POST['value']);
        $sql = mysql_query("SELECT year FROM locked WHERE year = ' $year'");
        if(mysql_num_rows($sql) == 0){
            mysql_query("INSERT INTO locked (target, year) VALUES ('$value', '$year')");
        }
        else{
            mysql_query("UPDATE locked SET target = '$value' WHERE year = '$year'");
        }
    }
    if($action == "accomplishtoggle"){
        $year = mysql_escape_string($_POST['year']);
        $value = mysql_escape_string($_POST['value']);
        $sql = mysql_query("SELECT year FROM locked WHERE year = ' $year'");
        if(mysql_num_rows($sql) == 0){
            mysql_query("INSERT INTO locked (accomplish, year) VALUES ('$value', '$year')");
        }
        else{
            mysql_query("UPDATE locked SET accomplish = '$value' WHERE year = '$year'");
        }
    }
?>