<html>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script type-"text/javascript">
var gSpread="1yvM1I3No6V64ksvnD9cgnuKvG4TFvGIwzgtIX7c0E5c";
var url="https://spreadsheets.google.com/feeds/list/"+gSpread+"/3/public/values?alt=json";

console.log('url: '+url);

var sheet = $.parseJSON(url);
var entry = sheet.feed.entry;
var content = entry.content;


$.getJSON(url, function(data) {
  //first row "title" column
	  var items = [];
	  $.each( content, function( key, val ) {
		  //console.log('key: '+key);
		  //console.log('val: '+val);
	    items.push( "<li>" + val[key] + "</li>" );
	  });
	 
	  $( "<ul/>", {
	    "class": "my-new-list",
	    html: items.join( "" )
	  }).appendTo( "body" );
});

</script>
</body>
</html>