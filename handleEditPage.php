<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Page</title>
</head> 
<body>
<?php
echo handleEditPage();
?>
</body>
</html>

<?php
function handleEditPage(){
	include_once 'login.php';
	include_once 'showEventFunction.php';
	$backURL = "<br/><a href = \"index.php\">Back to Home</a>";
	// client side validation, if error, disable submit
	// if form is set and not empty, continue
	$showError=true;
	$errOutput = isFormFilled($showError);
	if($errOutput){
		$output = "<h1>Error</h1>";
		return $output.$errOutput.$backURL;
	}
	$event = array();
	$errMsg = array();
	// prevent sql injection & data sanitize
	foreach ($_POST as $field => $value){
		$event[$field]=sanitizeData($value);
	}
	include_once 'database_conn.php';
	$columnLengthSql="
		SELECT COLUMN_NAME, CHARACTER_MAXIMUM_LENGTH
		FROM INFORMATION_SCHEMA.COLUMNS
		WHERE TABLE_NAME =  'te_events'
		AND (column_name =  'eventTitle'
		OR column_name =  'eventDescription')";//, DATA_TYPE
	$COLUMN_LENGTH=getColumnLength($conn, $columnLengthSql);

	// check data type and length validation
	$isError=false;
	$errMsg[]=validateStringLength($event['title'], $COLUMN_LENGTH['eventTitle']);//title
	$errMsg[]=validateStringLength($event['desc'],$COLUMN_LENGTH['eventDescription']);//desc
	$errMsg[]=validateDate($event['startTime']);//startTime
	$errMsg[]=validateDate($event['endTime']);//endTime
	$errMsg[]=validateDecimal($event['price']);//price
	
	for($i=0; $i<count($errMsg); $i++){
		if (!($errMsg[$i]===true)){
			$pageHeader = "Error";
			$output = "<h1>$pageHeader</h1>";
			$output. "{$errMsg[$i]}";
			$isError=true;
		}
	}
	//if contain error, halt continue executing the code
	if($isError)
		return $output.$backURL;
	// prepare sql statement	
	$sql="UPDATE te_events SET 
		eventTitle=?, eventDescription=?, 
		venueID=?, catID=?, eventStartDate=?, 
		eventEndDate=?, eventPrice=? WHERE eventID=?;";
	$stmt = mysqli_prepare($conn, $sql); 
	mysqli_stmt_bind_param($stmt, "ssssssss", 
		$event['title'], $event['desc'], 
		$event['venue'], $event['category'],
		$event['startTime'], $event['endTime'],
		$event['price'],$event['e_id']);
	// execute update statement
	mysqli_stmt_execute($stmt);	
	// check is it sucess update
	if (mysqli_stmt_affected_rows($stmt)){
		$output = "<h1>{$event['title']} was successfully updated.</h1>";
		return $output.$backURL;
	}else{
		$output = "<h1>Nothing update for {$event['title']}</h1>";
		return $output.$backURL;
	}
	echo "<br/>";
	return;
}
?>