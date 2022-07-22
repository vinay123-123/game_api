<?php
//print_r($_POST);die;

header("Content-Type:application/json");
if ((isset($_POST['level']) && $_POST['level']!="") && (isset($_POST['level']) && $_POST['level']!="")) {
	include('db.php');
	$level = $_POST['level'];
	$date = $_POST['date'];
	
	$result = mysqli_query($con,"SELECT * FROM `tbl_question` WHERE `level`='$level' AND '$date' between created_date and end_date limit 1");
	if(mysqli_num_rows($result)>0){
	$row = mysqli_fetch_array($result);
	$question = $row['question'];
	$choices = array($row['choice1'],$row['choice2'],$row['choice3'],$row['choice4'],);
	$correct_ans = $row['correct_ans'];
	$level = $row['level'];
	
	$result2 = mysqli_query($con,"SELECT * FROM `tbl_level` WHERE id='$level'");
	if(mysqli_num_rows($result2)>0){
	$row2 = mysqli_fetch_array($result2);
 	$level_name = $row2['level'];
	}else{
	$level_name = "level does't exists";	
	}
			
		
	response($level, $question, $choices,$correct_ans,$level_name);
	mysqli_close($con);
	}else{
		response(NULL, NULL, 200,"No Record Found","");
		}
}else{
	response(NULL, NULL, 400,"Invalid Request","");
	}

function response($level,$question,$choices,$correct_ans,$level_name){
	
	if($correct_ans == "No Record Found"){
		$response['Code'] = 400;
		$response['Message'] = "Technical error occurs";
		$response['Data'] = array();
	
	}elseif($correct_ans == "Invalid Request")
	{
		$response['Code'] = 401;
		$response['Message'] = "Invalid Request";
		$response['Data'] = array();
	}
	else{
		$response['Code'] = 200;
		$response['Message'] = "Data Found";
		$response['Data'] = array('level'=>$level,'question'=>$question,'choices'=>$choices,'correct_ans'=>$correct_ans,'level_name'=>$level_name);
	}
	
	echo $json_response = json_encode($response);
} 
?>