<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Event List</title>
<link rel="stylesheet" type="text/css" href="bookEvent.css"/>
</head> 
<body>
<?php 
include_once 'login.php';
include_once 'showEventFunction.php';
include 'database_conn.php';
$pageHeader = "Event List";
$output = "<h1>$pageHeader</h1>";
$backURL = "<br/><a href = \"index.php\">Back to Home</a>";
echo $output.$backURL;
$datas = array();
$datas['venues'] = getFromDb($conn, "SELECT * FROM te_venue");
$datas['categories'] = getFromDb($conn, "SELECT * FROM te_category");
$datas['events'] = getFromDb($conn, "SELECT * FROM te_events ORDER BY eventTitle ASC");
$formEdible = false;
if(isset($_SESSION['logged-in'])){
	$formEdible = true;
}else{
	$formEdible = false;
}
echo showTable($datas,$formEdible);
mysqli_close($conn);
?>
</body>
</html>