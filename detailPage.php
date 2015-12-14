<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Event Details</title>
</head> 
<body>
<?php 
$var = $_GET['id'];
echo detailPage($var);
?>

</body>
</html>
<?php
function detailPage($id){
	include_once 'login.php';
	include_once 'database_conn.php';	
	$pageHeader = "Event Details";
	$sql = "
	SELECT eventTitle, eventDescription, v.venueName, v.location, c.catDesc, eventStartDate, eventEndDate, eventPrice
	FROM te_events AS e
	INNER JOIN te_venue AS v ON e.venueID = v.venueID
	INNER JOIN te_category AS c ON e.catID = c.catID
	WHERE eventID = $id
	ORDER BY eventTitle ASC";
	$rslt = mysqli_query($conn,$sql) or die (mysqli_error($conn));
	// error message return if return empty result
	$row = mysqli_fetch_row($rslt);
	$backURL = "<br/><a href = \"showEvent.php\">Back</a>
	<br/><a href = \"index.php\">Back to Home</a>
	";
	$output = "<h1>$pageHeader</h1>";
	$output .= "<table border=0>";
	$i=0;
	$output .= setInTable("Title",$row[$i++]);
	$output .= setInTable("Description",$row[$i++]);
	$output .= setInTable("Venue",$row[$i++].", ".$row[$i++]);
	$output .= setInTable("Category",$row[$i++]);
	$output .= setInTable("Time",$row[$i++]." to ".$row[$i++]);
	$output .= setInTable("Price",$row[$i++]);
	$output .= "</table>";
	mysqli_free_result($rslt); 
	mysqli_close($conn);
	return $output.$backURL;
}
function setInTable($var1, $var2){
	return "<tr><td>$var1</td>"."<td>:</td>"."<td>$var2</td></tr>\n";
}
?>