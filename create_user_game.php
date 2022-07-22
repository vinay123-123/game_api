<?php
//print_r($_POST);die;

header("Content-Type:application/json");
if (isset($_POST['user_id']) && $_POST['user_id']!="") {
	include('db.php');
	$user_id = $_POST['user_id'];
    $game_id = 'g_'.time();
 //echo $game_id;die;
	
	$sql = "INSERT INTO `tbl_user_game` (`user_id`, `game_id`)
			VALUES ('".$user_id."', '".$game_id."')";

	//echo $sql;die;
	
		if (mysqli_query($con, $sql)) {
		  response(200,"New record created successfully",$game_id);
	    }else{
		response(400,"Technical error occurs","");
		}
		mysqli_close($con);
}else{
	response(401,"Invalid Request","");
	}

function response($code,$message,$game_id){
	
	$response['Code'] = $code;
	$response['Game Id'] = $game_id;
	$response['Message'] = $message;
	
	echo $json_response = json_encode($response);

} 
?>