<?php

function wrapValidation($pageTitle, $CSS, $content){
$output = <<<HEADER
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>$pageTitle</title>
<link rel="stylesheet" type="text/css" href="$CSS" />
</head>
<body>
<div id = "wrapper">
$content
</div>
</body>
</html>
HEADER;
echo $output;
}
;
wrapValidation("hi","","task2.php");
?>