<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <title>Book Events</title>
	<script src="function.js" type="text/javascript"></script>	
	<script type="text/javascript" src="http://yui.yahooapis.com/3.12.0/build/yui/yui.js"></script>
	<script type="text/javascript" src="bookingFormInstructions.js"></script>
	<link rel="stylesheet" type="text/css" href="bookEvent.css"/>
</head>
<body>

<div id="wrapper">
	<?php include_once 'login.php'; ?>
  <h1>Book Events</h1>

  <form id="bookingForm" action="#" method="get">
  <div id="selectEvents">

    <h2>Select events</h2>
<?php
include_once('database_conn.php');
$sqlEvents = 'SELECT eventID, eventTitle, eventStartDate, eventEndDate, catDesc, venueName, eventPrice FROM te_events e inner join te_category c on e.catID = c.catID inner join te_venue v on e.venueID = v.venueID WHERE 1 order by eventTitle';
$rsEvents = mysqli_query($conn, $sqlEvents);
while ($event = mysqli_fetch_assoc($rsEvents)) {
echo "\t<div class='item'>
            <span class='eventTitle'>".filter_var($event['eventTitle'], FILTER_SANITIZE_SPECIAL_CHARS)."</span>
            <span class='eventStartDate'>{$event['eventStartDate']}</span>
            <span class='eventEndDate'>{$event['eventEndDate']}</span>
            <span class='catDesc'>{$event['catDesc']}</span>
            <span class='venueName'>{$event['venueName']}</span>
            <span class='eventPrice'>{$event['eventPrice']}</span>
            <span class='chosen'><input type='checkbox' name='event[]' value='{$event['eventID']}' title='{$event['eventPrice']}' /></span>
        </div>\n";
}
?>

  </div>

  <div id="collection">
    <h2>Delivery method</h2>
	    <p>Please select whether you want the tickets for your chosen event(s) to be delivered to your home address (a charge applies for this) or whether you want to collect them yourself.</p>
	    <p>
	    Home address - &pound;3.99 <input type="radio" name="deliveryType" value="home" title="3.99" checked = "checked" />&nbsp; | &nbsp;
	    Collect from ticket office - no charge <input type="radio" name="deliveryType" value="ticketOffice" title="0" />
	    </p>
  </div>

  <div id="checkCost">
    <h2>Total cost</h2>
	    Total <input type="text" name="total" id="total" size="10" readonly="readonly" />
  </div>

  <div id="makeBooking">
    <h2>Make booking</h2>
	Your details
	    Customer Type: <select name="customerType">
	      <option value="">Customer Type?</option>
	      <option value="nonCorp">Customer</option>
	      <option value="corp">Corporate</option>
	    </select>	    
	    <div id="nonCorpCustDetails" class="custDetails">
	    	Forename <input type="text" name="forename" id="forename" />
	    	Surname <input type="text" name="surname" id="surname" />
	    </div>
	    <div id="corporateCustDetails" class="custDetails" style="visibility:hidden">
	    	Company Name <input type="text" name="companyName" id="companyName" />
	    </div>
	    <p id="termsNcondition" style="color: #FF0000; font-weight: bold;">I have read and agree to the terms and conditions
	    <input type="checkbox" id="termsChkbx" onclick="tncchecked()" /></p>

	    <p><input type="submit" name="submit" value="Make booking" id="sub1" disabled="disabled"/></p>
  </div>
</form>
</div>
</body>
</html>