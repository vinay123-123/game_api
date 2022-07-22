<?php
//print_r($_POST);die;

header("Content-Type:application/json");
if ((isset($_POST['user_id']) && $_POST['user_id']!="") && (isset($_POST['q_id']) && $_POST['q_id']!="")) {
	include('db.php');
	$q_id = $_POST['q_id'];
	$user_id = $_POST['user_id'];
	$ans_selected = $_POST['ans_selected'];
	if(isset($_POST['created_date'])){
	$created_date = $_POST['created_date'];
	}
	$game_id = $_POST['game_id'];

	
	
	$sql = "SELECT correct_ans from tbl_question where q_id='$q_id'";
		$result = mysqli_query($con, $sql);

		if (mysqli_num_rows($result) > 0) {
		  // output data of each row
	     $row = mysqli_fetch_assoc($result);
			$correct_ans = $row["correct_ans"];
		} else {
		  echo "No Records found against this q_id";
		}
		
		
   if($correct_ans == $ans_selected){
	   $points = 20;
	   $ans_status = 1;
   }else{
	   $points = 0;
	  $ans_status = 0;
   }

 //echo $game_id;die;
	
	if(!empty($created_date)){
	$sql = "INSERT INTO `tbl_quiz_records` (`user_id`, `q_id`, `ans_selected`, `created_date`, `ans_status`, `game_id`, `points`)
			VALUES ('".$user_id."', '".$q_id."', '".$ans_selected."','".$created_date."', '".$ans_status."', '".$game_id."', '".$points."')";
	}else{
		$sql = "INSERT INTO `tbl_quiz_records` (`user_id`, `q_id`, `ans_selected`, `ans_status`, `game_id`, `points`)
			VALUES ('".$user_id."', '".$q_id."', '".$ans_selected."', '".$ans_status."', '".$game_id."', '".$points."')";
	}
	
		if (mysqli_query($con, $sql)) {
		  response(200,"New record created successfully");
	    }else{
		response(400,"Technical error occurs");
		}
		mysqli_close($con);
}else{
	response(401,"Invalid Request");
	}

function response($code,$message){
	
	$response['Code'] = $code;
	$response['Message'] = $message;
	
	echo $json_response = json_encode($response);

} 
?>