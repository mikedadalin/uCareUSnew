function SelectLanguage(){
	var LanguangNumber = $("#LanguangOption").val();
		$.ajax({
			url: "class/settingLanguage.php",
			type: "POST",
			data: {"LanguangNumber": LanguangNumber },
		});
		window.location.reload();
}