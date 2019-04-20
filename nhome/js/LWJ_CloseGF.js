function CloseGF() {
	$.ajax({
		url: "class/CloseGF.php",
		type: "POST",
		data: {"Close": "1", },
		success: function(data) {
			if(data=="OK"){
				document.getElementById('ContinuousForm').style = 'display:none';
			}
		}
	});
}