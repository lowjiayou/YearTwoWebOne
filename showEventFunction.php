<?php
// Task 1 functions
function getFromDb($conn, $sql){
	$rslt = mysqli_query($conn,$sql) or die (mysqli_error($conn));
	$rows = array();
	while ($row = mysqli_fetch_row($rslt)) {
		$rows[] = $row;
	}
	mysqli_free_result($rslt); 
	return $rows;
}
// get all table fields and show events in table form
function showTable($datas, $editable){
	$output="";
	$openTable="<div id=\"myTable\" >";//border=1
	$closeTable="</div>";
	$openRow="<div class='item'>";
	$closeRow="</div>";
	$output .=$openTable;
	$venues=$datas['venues'] ;
	$categories=$datas['categories'];
	$events=$datas['events'];
	// for each item, create the table and store in variable
	foreach ($events as $event){
		$output .= $openRow. createTable($event, $venues, $categories, $editable). $closeRow. "\n";
	}
	$output .= $closeTable;
	return $output;
}
function createSpan($title, $val){
	$output = "<span class='$title'>".$val."</span>";
	return $output;
}
function createTable($row, $venues, $categories, $editable ){
	$openColumn="<td>";
	$closeColumn="</td>";	
	$table ="";
	
	for($i=1; $i < count($row); $i++){
		
		if ($i==1){
			$row[$i]=filter_var($row[$i], FILTER_SANITIZE_SPECIAL_CHARS);
			// where 1 is event title
			if($editable==true){
				$table .= createSpan("editField", "<a href=\"editPage.php?id=$row[0]\">Edit</a>");
				$table .= createSpan("eventTitle", "<a href=\"detailPage.php?id=$row[0]\">$row[$i]</a>");
			}else
			$table .= createSpan("eventTitle", "<a href=\"detailPage.php?id=$row[0]\">$row[$i]</a>");
			continue;
		}
		if ($i==2){
			// where 2 is event description
			continue;
		}
		if ($i==3){
			$table .= createSpan("catDesc", getDetailFromID($venues, $row[$i]));
			continue;
		}
		if ($i==4){
			$table .= createSpan("venueName", getDetailFromID($categories, $row[$i]));
			continue;
		}
		if ($i==5){
			$table .= createSpan("eventStartDate", $row[$i]);
			continue;
		}
		if ($i==6){
			$table .= createSpan("eventEndDate", $row[$i]);
			continue;
		}
		$table .= createSpan("eventPrice", $row[$i]);
	}
	return $table;
}
// get venue / category detail using ID
function getDetailFromID($lists, $key){ 
	$var="";
		foreach ($lists as $list){
			if(strcmp($list[0], $key)==0){
				$flag=true;
				for($i=1; $i<count($list); $i++){
					if($flag==true){
						$var .= $list[$i];
						$flag=false;
						continue;
					}
					$var .= ", ".$list[$i];
				}
				return $var;
			}
		}
} 

?>
<?php
// Task 2 functions
// edit page 
function createRowData($desc, $content){
	return "<tr><td>$desc</td>"."<td>:</td>"."<td >$content</td></tr>\n";
}
function createTextField($tagName, $tagValue){// remove size
	return "<input type=\"text\" name=\"$tagName\" value=\"$tagValue\" />";
}//size=\"100%\"
function createTextArea($tagName, $tagValue, $row, $cols ){// remove size
	return "<textarea name=\"$tagName\" rows=\"$row\" cols=\"$cols\">$tagValue</textarea>";
}
function createDate($tagName, $tagValue){// remove size
	return "<input type=\"date\" name=\"$tagName\" value=\"$tagValue\" />";
}
function createCombobox($tagName, $selected, $data){
	$dropdownlist="";
	$dropdownlist .= "<select name=\"$tagName\">\n";
	//Please, select any value
	$dropdownlist .= "<option value=\"0\">Please, select any value</option>\n";
	foreach($data as $r){
		$dropdownlist .= "<option value=".$r[0]."";
		// if selected then show selected on view
		$dropdownlist .= (strcmp($selected, $r[0])==0)?" selected":"" ;
		$dropdownlist .= ">" . getDetailFromID($data, $r[0])."</option>\n";//. 
	}
	$dropdownlist .= "</select>";
	return $dropdownlist;
}
// handle edit page
// http://buildinternet.com/2008/12/how-to-validate-a-form-complete-with-error-messages-using-php-part-1/
function isFormFilled(){
	// server side validation
	if ($_SERVER["REQUEST_METHOD"] == "POST"){//continue
		// check is form submitted
		//if(isset($_POST['submit'])){
		$errMsg="";
		foreach ($_POST as $field => $value){
			// check are the value not set
			if (!isset($_POST[$field]))
				$errMsg[]= "$field is not set.<br/>";
			// check are the form filled
			if (empty($value)){
				$errMsg[]= "$field is empty.<br/>";//There are still empty fields.<br/>
				//break;
			}
			if(isset($_POST['venue'])&&isset($_POST['venue'])){
				if ($_POST['venue']===0||$_POST['category']===0){
					$errMsg[]= "$field is not selected.<br/>";
				}
			}
		}
		if ($errMsg){ 
			$output =  "Fail continuing.<br/>";
			foreach($errMsg as $v){
				// capitalize first letter in string 
				// then lower case the rest of the string
				$output .= ucfirst(strtolower($v));
			}
			unset ($errMsg);
			return $output;
		}
	}else{
		$output = "Error proceeding. Form not submitted.";
		return $output;
	}
	return false;
}
// sanitize data
function sanitizeData($data){ 
	$data = stripslashes($data);
	$data = strip_tags($data);
	// clean excessing spaces in value except array
	$data = is_array($data) ? $data : trim($data);
	
	// repeating
	$data = htmlspecialchars($data);
	// $data = htmlentities($data);
	// $data = filter_var($data,FILTER_SANITIZE_SPECIAL_CHARS);/**/
	return $data;
}
function validateStringLength($data, $keyLen){
	return(strlen($data) <=$keyLen)?true:"Content cannot be larger than $keyLen letters.<br/>";
}
function validateDate($date){
	$dt = DateTime::createFromFormat("Y-m-d", $date);
	$isDate = $dt !== false && !array_sum($dt->getLastErrors());
	return($isDate==1)?true:"Wrong date key in<br/>";
}
function validateDecimal($data){
	$pattern = '/^[0-9]{1,2}+(\\.[0-9]{0,2})?$/';
	$result = preg_match( $pattern, $data );
	return ($result==1)?true:"Wrong price key in<br/>";
	/*
	^           # Start of string.
[0-9]+              # Must have one or more numbers.
(                   # Begin optional group.
\.              # The decimal point, . must be escaped, 
				# or it is treated as "any character".
[0-9]{1,2}      # One or two numbers.
)?                  # End group, signify it's optional with ?
$                   # End of string.
*/
}
// get column length
function getColumnLength($conn, $sql){
	$rslt = mysqli_query($conn, $sql);
	$rows=array();
	while ($row = mysqli_fetch_assoc ($rslt)) {
		$rows[$row['COLUMN_NAME']] =$row['CHARACTER_MAXIMUM_LENGTH'];
	}
	return $rows;
}

?>