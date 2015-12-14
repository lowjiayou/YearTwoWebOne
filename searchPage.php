<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search Page</title>
</head> 
<body>
<?php echo searchPage(); ?>
</body>
</html>
<?php 
function searchPage(){
	include_once 'login.php';
	include_once 'database_conn.php';
	include_once 'showEventFunction.php';
	$pageHeader = "Search Page";
	$backURL = "<br/><a href = \"index.php\">Back to Home</a>";
	$venues = getFromDb($conn, "SELECT * FROM te_venue");
	$categories = getFromDb($conn, "SELECT * FROM te_category");
	$output = "<h1>$pageHeader</h1>";
	$output .=  "<form id=\"searchForm\" action=\"handleSearchPage.php\" method=\"post\">";
	$output .=  "<table border=0 >";		
	$output .= createRowData("Title",createTextField("title", ""));
	$output .= createRowData("Venue Name",createCombobox("venue", "", $venues));
	$output .= createRowData("Category",createCombobox("category", "", $categories));
	$output .= createRowData("Start Time",createDate("startTime", ""));
	$output .= createRowData("End Time",createDate("endTime", ""));
	$output .= createRowData("Price",createTextField("price", ""));
	$output .= "<tr><td><input type=\"submit\" name=\"submit\" value=\"Search\"></td></tr>";
	$output .= "</table></form>";
	return $output.$backURL;
}
?>