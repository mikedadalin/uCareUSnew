$(function() {
	$('button:button[id^="CheckRound_"]').click(function() {
		var arrID = $(this).attr('id');
		arrID = arrID.split('_');
		var PID = arrID[2];
		var Action = arrID[1];
		$.ajax({
			url: "class/CheckRounds.php",
			type: "POST",
			data: {"PID": PID, "Action": Action }
		});
		var id = $(this).attr('id');
		if(Action=="ON"){
			document.getElementById(id+"_icon").className = "fa fa-check-square-o";
			document.getElementById(id).id = "CheckRound_OFF_"+PID;
			document.getElementById(id+"_icon").id = "CheckRound_OFF_"+PID+"_icon";
		}
		if(Action=="OFF"){
			document.getElementById(id+"_icon").className = "fa fa-square-o";
			document.getElementById(id).id = "CheckRound_ON_"+PID;
			document.getElementById(id+"_icon").id = "CheckRound_ON_"+PID+"_icon";
		}
	});
});