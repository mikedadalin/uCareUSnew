function closecol() {
	var w = $("#slider_content").width();
	$("#slider_scroll").animate( { right:'-'+w+'px' }, 600 ,'swing');
	var w = $("#slider_content2").width();
	$("#slider_scroll2").animate( { right:'-'+w+'px' }, 600 ,'swing');
	var w = $("#slider_content9").width();
	$("#slider_scroll9").animate( { right:'-'+w+'px' }, 600 ,'swing');
	$('#CalendarCliniccol').hide('slide', {direction: 'left'}, 500);
	$('#CalendarRemindercol').hide('slide', {direction: 'left'}, 500);
	$('#CalendarMedcol').hide('slide', {direction: 'left'}, 500);
	$('#CalendarInsulincol').hide('slide', {direction: 'left'}, 500);
	$('#CalendarPipelinecol').hide('slide', {direction: 'left'}, 500);
};