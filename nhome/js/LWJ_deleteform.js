$(function() {
	$("span.ui-icon-close").bind("click", function() {
		if (confirm('確定刪除此筆資料？')) {
			var fieldID = $(this).attr('id');
			var arrID = fieldID.split('-');
			$.ajax({
				url: "class/deleteform.php",
				type: "POST",
				data: {"formID": arrID[0], "HospNo": arrID[1], "date": arrID[2], "no": arrID[3] },
				success: function(data) {
					alert("已經刪除成功");
					window.location.reload();
				}
			});
		}
    });
});