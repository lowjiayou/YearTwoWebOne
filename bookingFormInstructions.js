YUI().use('node', function (Y) {
		// create instruction
		var instructionDiv = Y.Node.create('<div></div>');
		instructionDiv.set('id','instruction');
		var orderedList = Y.Node.create('<ol></ol>');
		var instructionMsg = new Array(
		"An event must be select before submitting","Select a delivery method",
		"Total cost is the sum of delivery moethod and event ticket","Select customer or coperate and fill in the form");
		Y.each(instructionMsg, function(content){
			var text = "<li>"+content+"</li>";
			// append or insert children
			orderedList.append(text);
		});
		instructionDiv.append(orderedList);
		// add and hide instruction after booking form
		var bookingForm= Y.one('#bookingForm');
		bookingForm.insert(instructionDiv,'after');
		instructionDiv.hide();
	//}
	// toggle the message then mouseover the form
	var showMsg = function (e,key){
		// mouseover
		// set xy 
		// loop over which to show
		// show the thing 
		// 3 second fade out
		var instruction= Y.one('#instruction');
		var listItems= Y.all('li')._nodes;
		//Y.log(listItems);
		for(var c = 0;c<listItems.length;c++ ){
			var smth = (c+1)+". "+listItems[c].innerText;
			// when match
			if (key==c){
				//instruction.setStyle('style', "background: #111111; top:"+(e.pageY+15)+"px; left:"+(e.pageX+15)+"px;");
				Y.log(instruction);
				//instruction._node.children[0].children[c];
				
				instruction.setStyle('top', (e.pageY+15));
				instruction.setStyle('left', (e.pageX+15));
				instruction.show();
				//Y.log(instruction);
				Y.log(c+"my c"+key);
				//Y.log("X:"+e.pageX+"Y:"+e.pageY);
				//e.stopPropagation();
				Y.log(smth);
				break;
			}
		}
	};
	
	var hideMsg = function (){
		var instruction= Y.one('#instruction');
		instruction.hide();
		//instructionDiv.hide();
	}
	// add event to div
	var selectEventsTag= Y.one('#selectEvents');
	selectEventsTag.on('mousemove', function(e){showMsg(e,0)});
	selectEventsTag.on('mouseout', function(){hideMsg()});
	var collectionTag= Y.one('#collection');
	collectionTag.on('mousemove', function(e){showMsg(e,1)});
	collectionTag.on('mouseout', function(){hideMsg()});
	var checkCostTag= Y.one('#checkCost');
	checkCostTag.on('mousemove', function(e){showMsg(e,2)});
	checkCostTag.on('mouseout', function(){hideMsg()});
	var makeBookingTag= Y.one('#makeBooking');
	makeBookingTag.on('mousemove', function(e){showMsg(e,3)});
	makeBookingTag.on('mouseout', function(){hideMsg()});
});