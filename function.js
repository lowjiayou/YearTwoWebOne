function $(id){
	return document.getElementById(id);
}
function one(){
	var welements = document.getElementsByName('viewer[]'); // Removed [0], that gets the **1st** node, not the NodeList.
	for (var i = 0, j = welements.length; i < j; i++) {
		var an_element = welements[i];
		alert(an_element.selectedIndex);
	}
}
function dump(obj) {
	var out = '';
	for (var i in obj) {
		out += i + ": " + obj[i] + "\n";
	}

	alert(out);

	// or, if you wanted to avoid alerts...

	var pre = document.createElement('pre');
	pre.innerHTML = out;
	document.body.appendChild(pre)
}	
// FN1 = if tn checked, text to black , remove bold  
function tncchecked(){
	var submitBtn = $('sub1');
	// get the checked value
	var tncChkbox = $('termsChkbx');
	// get tnc object
	var tncTxt = $('termsNcondition');// added ID to HTML
	// fn4 = submit button cannot be enable if tnc not check
	if(tncChkbox.checked){
		// if tnc checked, set to black
		tncTxt.style.fontWeight="normal";
		tncTxt.style.color="#000000";
		submitBtn.disabled = false;
	}else{
		// if unchecked, set to red and bold
		tncTxt.style.fontWeight="bold";
		tncTxt.style.color="#FF0000";
		submitBtn.disabled = true;
	}
}
// FN2 = cannot submit if 
// txtfield not filled or no checkbox checked
function isFormFilled(){
	// get the form
	var form = $("bookingForm");	
	// get names from form
	var forname = form.forename.value;
	var surname = form.surname.value;
	var companyName = form.companyName.value;
	// get events from form
	var events = form.elements['event[]'];
	var count=0;
	for (var i = 0; i < events.length; i++) {
		// add a count for each checked event
		(events[i].checked)? count++ : count ;
	}
	// if no event check, 
	if(count<=0){
	// 	return false, form not filed
		alert("Please check at least an event before continue");
		return false;
	}
	var customerType = form.customerType;//[i]
	if(strcmp(customerType.value,"")==0){
		// ask to select a value
		alert("Please select a customer type");
		return false;
	}
	if(strcmp(customerType.value,"nonCorp")==0){
		// if no field entered,
		if(!(forname)){
		// 	return false, form not field
			alert("Please fill in forename");
			return false;
		}else if(!(surname)){
		// 	return false, form not field
			alert("Please fill in surname");
			return false;
		}
	}else if(strcmp(customerType.value,"corp")==0){
		if(!(companyName)){
		// 	return false, form not field
			alert("Please fill in company name");
			return false;
		}
	}
	// return true since form are okay 
	return true;
}
// apply listener to radiobutton and checkbox
function applyListener(){
	var count=0;
	// get form from html document
	var form = $("bookingForm");
	form.onsubmit=function(){return isFormFilled()};
	// get events from html document
	var events = form.elements['event[]'];
	for (var i = 0; i < events.length; i++) {
		// add event listener on changed
		events[i].onchange = function(){
			//Recalculate subtotal onchange
			get_subtotal();
		};
	}
	var deliveryType = form.elements['deliveryType'];
	for (var i = 0; i < deliveryType.length; i++) {
		// add event listener on changed
		deliveryType[i].onchange = function(){
			//Recalculate subtotal onchange
			get_subtotal();
		};
	}
	// FN5 = if coperate, show company name namefield
	// if customer, fore n sur
	var customerType = form.customerType;//[i]
	customerType.onchange = function(){
		if(strcmp(this.value,"nonCorp")==0){
			console.log(" "+this.value);
			//corporateCustDetails corporateCustDetails
			$("corporateCustDetails").style.visibility="hidden";
			$("nonCorpCustDetails").style.visibility="visible";
		}else if(strcmp(this.value,"corp")==0){
			$("corporateCustDetails").style.visibility="visible";
			$("nonCorpCustDetails").style.visibility="hidden";
		}
	};
}
// FN3 = totalcost = selectedcheckbox+choiceofmethod
// then show at total textfield
function get_subtotal(){
	var subtotal=0;
	// get form from html document
	var form = $("bookingForm");
	// get total from html document
	var totalTxt = $("total");
	// traverse the whole events array
	var events = form.elements['event[]'];
	for (var i = 0; i < events.length; i++) {
		// if there is an event check, 
		if(events[i].checked){
			// add up the value
			subtotal+=parseFloat(events[i].title);
		}
	}
	// traverse the whole deliveryType array
	var deliveryType = form.elements['deliveryType'];
	for (var i = 0; i < deliveryType.length; i++) {
		// if there is an event check, 
		if(deliveryType[i].checked){
			// add up the value
			subtotal+=parseFloat(deliveryType[i].title);
		}
	}
	//var deliveryMethodAmount = form.deliveryType.checked;
	//subtotal += parseFloat(deliveryMethodAmount.title);
	// assign to text field
	totalTxt.value=subtotal.toFixed(2);
	tncchecked();
}
function strcmp(var1, var2) {
	if (var1.toString() < var2.toString()) return -1;
	if (var1.toString() > var2.toString()) return 1;
	return 0;
}

window.onload = function(){
	applyListener();
	get_subtotal();
}
