<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Arts and Ents</title>
	<!-- Script and style-->
	<!--Javascripts-->
	<script type="text/javascript" src="http://yui.yahooapis.com/3.12.0/build/yui/yui.js"></script>
	<script type="text/javascript" src="ajaxReq.js"></script>
	<script type="text/javascript" src="weatherYUI.js"></script>
	<script type="text/javascript">
    //<![CDATA[
	function switch_style ( css_title ){
		var i, link_tag ;
		for (i = 0, link_tag = document.getElementsByTagName("link") ;
		i < link_tag.length ; i++ ) {
			if ((link_tag[i].rel.indexOf( "stylesheet" ) != -1) &&
				link_tag[i].title) {
				link_tag[i].disabled = true ;
				if (link_tag[i].title == css_title) {
					link_tag[i].disabled = false ;
				}
			}
		}
	}
    //]]
   </script>
	
	<link rel="stylesheet" type="text/css" title="default" href="style.css" />
	<link rel="stylesheet" type="text/css" title="verdana" href="style2.css" />
	<link rel="stylesheet" type="text/css" title="sanserif" href="style3.css" />
</head> 
<body>
	<div id="wrapper">
	<div id="header">
		<h1>Arts and Ents</h1>
	</div>
	<div id="afterHead">
		<div id="changeCSS">
			<a href="#" onclick="switch_style('default');">Default</a>&nbsp
			<a href="#" onclick="switch_style('verdana');">Pattern1</a>&nbsp
			<a href="#" onclick="switch_style('sanserif');">Pattern2</a>&nbsp
		</div>
		<?php include_once "login.php"; ?>
		
	</div>
	<div id="wrapBody">
	<div id="banner">
			<div id="offers"></div>
		</div>
		<div id="navigation">
			<h2>Navigation</h2>
			<ul>
				<li><a href = "showEvent.php">List Events</a></li>
				<li><a href = "searchPage.php">Search</a></li>
				<li><a href = "bookEventsForm.php">Book Events</a></li>
				<li><a href = "creditPage.php">Credits</a></li>
			</ul>
		</div>
		<div id="content">
			<h2>About us:</h2>
			<p>Arts and Ents is for anyone planning or attending an event. We empower event organizers to become more efficient and effective when bringing people together, and people everywhere are searching Arts and Ents to discover great events that matter to them.</p>
			<div id="upcomingEvents"></div>
		</div>
		<div id="weather"></div>
		</div>
	<div id="footer">
		<div id="XMLoffers"></div>
		&copy; 2014 Northumbria University
	</div>
</div>
</body>
</html>
