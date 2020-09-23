jQuery(document).ready(function($) {
	$('.parent').children('ul').hide();
	$('.parent').click(function() {
		var currentID = $(this).attr('id');
		$('.parent').children('ul').hide();
		$('.plus_minus').text('[+]');
		$(this).children('ul').toggle('slow',function(){
			if($(this).children().is(':visible')){
				$('#'+currentID+' .plus_minus').text('[-]');
			} else {
				$('#'+currentID+' .plus_minus').text('[+]');
			}
		});
	});
});
