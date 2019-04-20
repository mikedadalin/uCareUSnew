<?php
if ($_SESSION['ncareID_lwj']!="Lejla05Mirzada12Asmira01") {
	echo '<script>window.location.href=\'logout.php\';</script>';
}else{
?>
<script type="text/javascript" src="js/LWJ_tabs.js"></script>
<table align="center" style="width:100%;">
	<tr>
		<td>
		<div align="left">
			<form><input type="button" id="AddNewOrg" value="Add New Org"></form>
		</div>
		<div id="tabs" style="width:100%;" align="center">
		<ul>
			<li><a href="#tabs-1">Orginfo</a></li>
			<li><a href="#tabs-2">System Setting</a></li>
			<li><a href="#tabs-3">Permissionset</a></li>
			<li><a href="#tabs-4">Group</a></li>
			<li><a href="#tabs-5">Group User</a></li>
			<li><a href="#tabs-6">User</a></li>
		</ul>
		<div id="tabs-1">
			<iframe src="LWJ_orginfo_grid.php" frameborder="0" width="1500" height="670"></iframe>
		</div>
		<div id="tabs-2">
			<iframe src="LWJ_system_setting_grid.php" frameborder="0" width="1500" height="670"></iframe>
		</div>
		<div id="tabs-3">
			<iframe src="LWJ_permissionset_grid.php" frameborder="0" width="1500" height="670"></iframe>
		</div>
		<div id="tabs-4">
			<iframe src="LWJ_orggroup_grid.php" frameborder="0" width="1500" height="670"></iframe>
		</div>
		<div id="tabs-5">
			<iframe src="LWJ_orggroupuser_grid.php" frameborder="0" width="1500" height="670"></iframe>
		</div>
		<div id="tabs-6">
			<iframe src="LWJ_userinfo_grid.php" frameborder="0" width="1500" height="670"></iframe>
		</div>
		</div>
		</td>
	</tr>
</table>
<script>
$(function() {
    $( "#New-Org" ).dialog({
		autoOpen: false,
		height: 210,
		width: 320,
		modal: true,
		buttons: {
			"New": function() {
				$.ajax({
					url: "class/LWJ_new_org.php",
					type: "POST",
					data: {"OrgID": $("#NewOrgID").val(), },
					success: function(data) {
						$( "#New-Org" ).dialog( "close" );
						if (data=="OK") {
							alert("New Org!");
							window.location.reload();
						}else if(data=="NO") {
							alert("OrgID 已存在!");
						}
					}
				});
			},
			"Cancel": function() {
				$( "#New-Org" ).dialog( "close" );
			}
		}
    });
	$('#AddNewOrg').click(function() {
		openVerificationForm('#New-Org');
	});
});
</script>
<div class="nurseform-table">
<div name="New-Org" id="New-Org" title="New Org" class="dialog-form">
	<form>
	<fieldset>
		<table align="center">
          <tr>
			<td class="title">OrgID</td>
            <td><input type="text" name="NewOrgID" id="NewOrgID"></td>
          </tr>
        </table>
    </fieldset>
	</form>
</div>
</div>
<? } ?>