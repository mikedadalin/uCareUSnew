function CheckGF(id) {
	var ID = id;
	$.ajax({
		url: "class/CheckGF.php",
		type: "POST",
		data: {"ID": ID, },
		success: function(data) {
			var temp_data = data;
			var arr_data = temp_data.split(';');
			if(arr_data[0]=="1"){
				window.location.href= arr_data[1];
			}else{
				if(arr_data[1]=='none'){
					location.reload();
				}else{
					window.location.href= arr_data[1];
				}
			}
		}
	});
}