<?php 
	session_start();
	include 'connect.php';
	$action = $_POST['action'];
	if($action == "login"){
		$email = mysql_escape_string($_POST['email']);
		$password = mysql_escape_string($_POST['password']);
		$password = sha1(md5($password));
		$sql = mysql_query("SELECT accID, email, password, name, position, account.regionID, region_code, account.levelID, account.status, levelname, directory FROM (SELECT * FROM account UNION ALL SELECT * FROM super_account) account INNER JOIN level ON account.levelID = level.levelID INNER JOIN region ON account.regionID = region.regionID WHERE email = '$email' AND password = '$password'");
		if(mysql_num_rows($sql) != 0){
			$fetch = mysql_fetch_assoc($sql);
            $_SESSION['accID'] = $fetch['accID'];
            $_SESSION['email'] = $fetch['email'];
            $_SESSION['name'] = $fetch['name'];
            $_SESSION['position'] = $fetch['position'];	
            $_SESSION['level'] = $fetch['levelID'];
			$_SESSION['region'] = $fetch['regionID'];
			$_SESSION['region_code'] = $fetch['region_code'];
			$_SESSION['status'] = $fetch['status'];
			$_SESSION['directory'] = $fetch['directory'];
            if($_SESSION['status'] == 0){
                $obj['status'] = 0;
            }
			else{
				$obj['status'] = 1;
				$obj['asd'] = $fetch['status'];
				$obj['directory'] = "user/".$fetch['directory']."/home";
				$obj['level'] = $fetch['levelID'];
			}
			echo json_encode($obj);
		}
		else{
			echo json_encode(false);
		}
	}
?>