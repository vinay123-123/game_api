<?php
//print_r($_POST);die;

header("Content-Type:application/json");
if ((isset($_POST['game_id']) && $_POST['game_id']!="")) {
	include('db.php');
	$game_id = $_POST['game_id'];
	
	$quiz_result = array();
	
	$result2 = mysqli_query($con,"SELECT * FROM `tbl_quiz_records` WHERE game_id='$game_id'");
	if(mysqli_num_rows($result2)>0){
	while($row2 = mysqli_fetch_array($result2))
	{
 	$ans_status[] = $row2['ans_status'];
	if($row2['ans_status'] == 1){
	$quiz_result[$row2['q_id']] = 'Right';
	}else{
	$quiz_result[$row2['q_id']] = 'Wrong';	
	}
   }
	$result = 0;
	
	/* print_r($ans_status);
	print_r($quiz_result);die; */
	
	
	
	for($i=0;$i<count($ans_status);$i++)
	{
		$result = $result + $ans_status[$i];
	}
	//echo $result;die;
	if($result == 5)
	{
         response(200,"Won","Congratulation You Won The Game.",$quiz_result);	
	}else{
		response(200,"Lose","Bad Luck You Lose",$quiz_result);
	}
	
	}else{
      response(400,"","Technical error occurs","");	
	}
		mysqli_close($con);
	}else{
		response(401,"","Invalid Request","");
		}
		

function response($code,$result,$message,$quiz_result){
	
	$response['Code'] = $code;
	$response['Result'] = $result;
	$response['quiz_result'] = $quiz_result;
	$response['Message'] = $message;

	
	echo $json_response = json_encode($response);
} 
?>