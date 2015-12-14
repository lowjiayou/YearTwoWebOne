<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search Page</title>
<link rel="stylesheet" type="text/css" href="bookEvent.css"/>
</head> 
<body>
<?php echo handleSearchPage(); ?>
</body>
</html>
<?php
function handleSearchPage(){
	include_once 'login.php';
	include_once 'database_conn.php';
	include_once 'showEventFunction.php';
	$pageHeader = "Result";
	$output = "<h1>$pageHeader</h1>";
	$backURL = "<br/><a href = \"searchPage.php\">Back</a>
	<br/><a href = \"index.php\">Back to Home</a>
	";
	
	$event = array();
	foreach ($_POST as $field => $value){
		//echo "$field => $value <br/>";
		if(strcmp($field, "submit")===0)
			continue;
		$event[$field]=$value;// sanitizeData($value);
	}
	$event=array_filter($event);
	//if any field is not filled, stop user
	//then ask user to enter something 
	if (empty($event)){
		$output .= "Please describe something to search.";
		return $output.$backURL;
	}
	$sql=generateSQL($event);
	$datas = array();
	$datas['venues'] = getFromDb($conn, "SELECT * FROM te_venue");
	$datas['categories'] = getFromDb($conn, "SELECT * FROM te_category");
	$datas['events']=getFromDb($conn, $sql);
	$datas['events']=array_filter($datas['events']);
	// if there is record, show in table
	if(!(empty($datas['events']))){
		$output .=showTable($datas, false);
		return $output.$backURL;
	}else {
		//if there is no result, result not found
		$output .= "No record found.";
		return $output.$backURL;
	}
}
?>
<?php
// generate sql from form by the value passed
function generateSQL($event){
	$sqlhead="SELECT * FROM te_events WHERE ";
	$sqltail="";
	$showError=false;
	$isTailEmpty = empty($sqltail);
	// if any field is not empty 
	// means it is filled
	// do something with the data
	if(!(empty($event['title']))){
		$str1 = "eventTitle LIKE \"%" . $event['title'] . "%\" ";
		$str2 = "AND eventTitle LIKE \"%" . $event['title'] . "%\" ";
		$sqltail .= (empty($sqltail)) ? $str1 : $str2;
	}
	// from strcmp to is empty because array_filter //!(strcmp($event['venue'], "0")==0)
	if(!(empty($event['venue']))){
		$str1 = "venueID = \"" . $event['venue'] . "\" ";
		$str2 = "AND venueID = \"" . $event['venue'] . "\" ";
		$sqltail .= (empty($sqltail)) ? $str1 : $str2;
	}
	if(!(empty($event['category']))){
		$str1 = "catID = \"" . $event['category'] . "\" ";
		$str2 = "AND catID = \"" . $event['category'] . "\" ";
		$sqltail .= (empty($sqltail)) ? $str1 : $str2;
	}
	if(!(empty($event['startTime']))){
		$str1 = "eventStartDate = \"" . $event['startTime'] . "\" ";
		$str2 = "AND eventStartDate = \"" . $event['startTime'] . "\" ";
		$sqltail .= (empty($sqltail)) ? $str1 : $str2;
	}
	if(!(empty($event['endTime']))){
		$str1 = "eventEndDate = \"" . $event['endTime'] . "\" ";
		$str2 = "AND eventEndDate = \"" . $event['endTime'] . "\" ";
		$sqltail .= (empty($sqltail)) ? $str1 : $str2;
	}
	if(!(empty($event['price']))){
		$str1 = "eventPrice = \"" . $event['price'] . "\" ";
		$str2 = "AND eventPrice = \"" . $event['price'] . "\" ";
		$sqltail .= (empty($sqltail)) ? $str1 : $str2;
	}
	return $sqlhead . $sqltail . "ORDER BY eventTitle ASC";
}
?>