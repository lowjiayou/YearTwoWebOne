<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Event Edit Page</title>
</head> 
<body>
<?php 
$var = $_GET['id'];
echo editPage($var);
?>
</body>
</html>
<?php
function editPage($id){
	include_once 'login.php';
	include_once 'database_conn.php';
	include_once 'showEventFunction.php';
	$pageHeader = "Event Edit Page";
	$sql = "SELECT * FROM te_events WHERE eventID = $id";
	$rslt = mysqli_query($conn,$sql) or die (mysqli_error($conn));
	// error message return if return empty result
	$row = mysqli_fetch_row($rslt);
	$venues = getFromDb($conn, "SELECT * FROM te_venue");
	$categories = getFromDb($conn, "SELECT * FROM te_category");
	$output="<h1>$pageHeader</h1>";
	$i=1;
	$output .=  "<form id=\"editForm\" action=\"handleEditPage.php\" method=\"post\">";
	$output .=  "<table border=0 >";		
	$output .= createRowData("Title",createTextField("title", $row[$i++]));
	$output .= createRowData("Description",createTextArea("desc", $row[$i++], 5, 40));
	$output .= createRowData("Venue Name",createCombobox("venue", $row[$i++], $venues));
	$output .= createRowData("Category",createCombobox("category", $row[$i++], $categories));
	$output .= createRowData("Start Time",createDate("startTime", $row[$i++]));
	$output .= createRowData("End Time",createDate("endTime", $row[$i++]));
	$output .= createRowData("Price",createTextField("price", $row[$i++]));
	$output .= "<tr><td><input type=\"submit\" name=\"submit\" value=\"Submit\"></td></tr>";
	$output .= "<input type=\"hidden\" name=\"e_id\" value=\"$id\">";
	$output .= "</table></form>";
	
	mysqli_free_result($rslt); 
	mysqli_close($conn);
	return $output;
}
?>