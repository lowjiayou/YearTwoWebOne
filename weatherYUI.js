// using yahoo query and dom mix in
YUI().use('yql','node', function (Y) {
	// provided yql query
	var yql = 'select * from weather.forecast where woeid in (select woeid from geo.places where text="newcastle upon tyne, uk")';
	// pass in the query and the 
	Y.YQL(yql, function (r) {
		var rootXML = r;
		// save channel in variable
		var channel = rootXML.query.results.channel;
		//console.log(result.item[1]);
		// get the div name weather
		var weatherTag=Y.one('#weather');
		// get channel title and description
		var title = channel.item.title;
		var desc = channel.item.description;
		// append it in weather div
		weatherTag.append(title);
		weatherTag.append(desc);
	});
});