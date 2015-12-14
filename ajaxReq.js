// get the request
function getRequest( url, callbackFunction, tag ,useXML) {
	// try to get httpReq object
	var httpRequest;
	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
		httpRequest = new XMLHttpRequest();
	}else if (window.ActiveXObject) { // IE
		try {
			httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try {
				httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e) {}
		}
	}
	// return error if fail
	if (!httpRequest) {
		alert('Giving up :( Cannot create an XMLHTTP instance');
		return false;
	}
	// open the httpReq by : the method, url and whether async
	httpRequest.open('get', url, true);
	// ????????????????
	// if it is a xml and then override it
	if (useXML && httpRequest.overrideMimeType) {
		// set doc
		httpRequest.overrideMimeType('text/xml');
	}
	// assign handler /  listener onreadystatechange
	httpRequest.onreadystatechange = function() {
		var completed = 4, successful = 200;
		// when httpReq readystate is complete
		if (httpRequest.readyState == completed) {
		// and status is sucess
			if (httpRequest.status == successful) {
				if (useXML) {
					returnValue = httpRequest.responseXML;
				}else{
					returnValue = httpRequest.responseText;
				}
			 // invoke callback passing in the value get
				callbackFunction( returnValue );
			}else {
				alert('Canceling ajax request and moving to other page.');
			}
		}
	}
	// send the request
	httpRequest.send(null);
}  // end of function getRequest

// handles offers response, adds the html
function showOffers(data) {
	var container = document.getElementById('offers');
	container.innerHTML = data;
}
// handles XMLoffers response, adds the html
function showXMLOffers(data) {
	var container = document.getElementById('XMLoffers');
	container.innerHTML = data;}
// ajax with timer
function getWithTimer(){
	getRequest('getOffers.php', showOffers, false);
	setTimeout(getWithTimer, 1000);// 10 sec
}
// do these when windows load
window.onload = function() {  
	// on load page complete, request to fill offers tag
	getRequest('getOffers.php?useXML', showXMLOffers, true);
	getWithTimer();
};