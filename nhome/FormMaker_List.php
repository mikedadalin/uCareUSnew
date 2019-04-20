<?php
if($_SESSION['ncareLevel_lwj']!=5){
	echo '<script>window.location.href="index.php?func=home"</script>';
}
echo '<div class="moduleNoTab">';
echo '<h3>Form Maker List</h3>';
echo '<table align="center"><tr><td>';
echo '<table><tr><td>';
echo '<form>';
if(isset($_GET['bk'])){
	$bk = explode("_",$_GET['bk']);
	if($bk[0]=="consump"){
		echo '<input type="button" onclick="location.href=\'index.php?mod='.$bk[0].'&func='.$bk[1].'\'" value="Back To List">';
	}elseif($bk[0]=="humanresource" || $bk[0]=="management"){
		echo '<input type="button" onclick="location.href=\'index.php?mod='.$bk[0].'&func=formview\'" value="Back To List">';
	}else{
		echo '<input type="button" onclick="location.href=\'index.php?mod='.$bk[0].'&func=formview&pid='.$bk[1].'\'" value="Back To List">';
	}
}
echo '<input type="button" onclick="location.href=\'index.php?func=FormMaker&bk='.$_GET['bk'].'\'" value="Add New Form">';
echo '<input type="button" onclick="location.href=\'index.php?func=FormMaker_Category_Edit&bk='.$_GET['bk'].'\'" value="Edit Category & Set Show Order">';
echo '</form>';
echo '</td></tr></table>';
$db = new DB;
$db->query("SELECT * FROM `formmaker_list` ORDER BY `formID` ASC");
if($db->num_rows()>0) {
	echo '<div class="nurseform-table">';
	echo '<table>';
	echo '<tr class="title">';
	echo '<td rowspan="2">Form ID#</td>';
	echo '<td rowspan="2">Form Name</td>';
	echo '<td rowspan="2">Category</td>';
	echo '<td colspan="7">Function</td>';
	echo '</tr>';
	echo '<tr class="title">';
	echo '<td>View</td>';
	echo '<td>Edit</td>';
	echo '<td>Delete</td>';
	echo '<td>Category</td>';
	echo '<td>Position</td>';
	echo '<td>Permission</td>';
	echo '<td>Enable</td>';
	echo '</tr>';
	for($i=0;$i<$db->num_rows();$i++) {
		$r = $db->fetch_assoc();
		echo '<tr>';
		echo '<td>'.$r['formID'].'</td>';
		echo '<td>'.$r['FormName'].'</td>';
		echo '<td>';
		$dbCategory = new DB;
		$dbCategory->query("SELECT * FROM `formmaker_category` WHERE `CategoryID`='".$r['CategoryID']."'");
		if($dbCategory->num_rows()>0){
			$rCategory = $dbCategory->fetch_assoc();
			echo $rCategory['CategoryName'];
			echo '<input type="hidden" name="NowCategoryID_'.$r['formID'].'" id="NowCategoryID_'.$r['formID'].'" value="'.$rCategory['CategoryID'].'">';
		}else{
			echo '<input type="hidden" name="NowCategoryID_'.$r['formID'].'" id="NowCategoryID_'.$r['formID'].'" value="">';
		}
		echo '</td>';
		if($r['Enable']==1){
			echo '<td class="link2"><a href="index.php?func=FormMaker_Show&id='.$r['formID'].'&bk='.$_GET['bk'].'" title="View"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-file-text-o fa-stack-1x fa-inverse"></i></span></a></td>';
			echo '<td class="link2"><a title="Can not edit"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-lock fa-stack-1x fa-inverse"></i></span></a></td>';
			echo '<td class="link2"><a title="Can not delete"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-lock fa-stack-1x fa-inverse"></i></span></a></td>';
			echo '<td class="link2"><a id="SetCategory_'.$r['formID'].'" title="Set category"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-cog fa-spin fa-stack-1x fa-inverse"></i></span></a></td>';
			echo '<td class="link2"><a id="SetModule_'.$r['formID'].'" title="Set position"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-cog fa-spin fa-stack-1x fa-inverse"></i></span></a></td>';
			echo '<td class="link2"><a id="SetPermission_'.$r['formID'].'" title="Set permissions"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-cog fa-spin fa-stack-1x fa-inverse"></i></span></a></td>';
			echo '<td class="link2"><a title="Enable"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-lightbulb-o fa-stack-1x fa-inverse"></i></span></a></td>';
		}else{
			echo '<td class="link1"><a href="index.php?func=FormMaker_Show&id='.$r['formID'].'&bk='.$_GET['bk'].'" title="View"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-file-text-o fa-stack-1x fa-inverse"></i></span></a></td>';
			echo '<td class="link1"><a href="index.php?func=FormMaker&id='.$r['formID'].'&bk='.$_GET['bk'].'" title="Edit"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-pencil fa-stack-1x fa-inverse"></i></span></a></td>';
			echo '<td class="link1"><a title="Delete" onclick="DeleteFormCheck(\''.$r['formID'].'\',\''.$r['FormName'].'\');"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-trash fa-stack-1x fa-inverse"></i></span></a></td>';
			echo '<td class="link1"><a id="SetCategory_'.$r['formID'].'" title="Set category"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-cog fa-stack-1x fa-inverse"></i></span></a></td>';
			echo '<td class="link1"><a id="SetModule_'.$r['formID'].'" title="Set position"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-cog fa-stack-1x fa-inverse"></i></span></a></td>';
			echo '<td class="link1"><a id="SetPermission_'.$r['formID'].'" title="Set permissions"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-cog fa-stack-1x fa-inverse"></i></span></a></td>';
			echo '<td class="link1"><a title="Enable" onclick="EnableFormCheck(\''.$r['formID'].'\',\''.$r['FormName'].'\');"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-lightbulb-o fa-stack-1x fa-inverse"></i></span></a></td>';
		}
		echo '</tr>';
	}
	echo '</table>';
	echo '</div>';
}else{
	echo '<div class="nurseform-table">';
	echo '<table><tr><td class="title">No Data</td></tr></table>';
	echo '</div>';
}
echo '</div>';
echo '</td></tr></table>';
?>
<script>
function DeleteFormCheck(formID,FormName) {
    if (confirm("Are you sure you want to delete this form? \n\nForm ID#: "+formID+"\nForm: "+FormName+"\n") == true) {
		if (confirm("If you do delete, this form can not be restored. Are you sure? \n\nForm ID#: "+formID+"\nForm: "+FormName+"\n") == true){
			document.location.href="index.php?func=FormMaker_Save&id="+formID+"&action=delete";
		}
    }
}
function EnableFormCheck(formID,FormName) {
    if (confirm("Are you sure you want to enable this form? \n\nForm ID#: "+formID+"\nForm: "+FormName+"\n") == true) {
		if (confirm("If you do enable, this form can not be edit and delete. Are you sure? \n\nForm ID#: "+formID+"\nForm: "+FormName+"\n") == true){
			document.location.href="index.php?func=FormMaker_Enable&id="+formID+"";
		}
    }
}
$(function() {
    $( "#Set-Category" ).dialog({
		autoOpen: false,
		height: 210,
		width: 390,
		modal: true,
		buttons: {
			"Set Category": function() {
				$.ajax({
					url: "class/FormMaker_Category.php",
					type: "POST",
					data: {"formID": $("#formID_Category").val(), "CategoryID": $("#CategoryID").val(), },
					success: function(data) {
						$( "#Set-Category" ).dialog( "close" );
						if (data=="OK") {
							alert("Set Category!");
							window.location.reload();
						}
					}
				});
			},
			"Cancel": function() {
				$( "#Set-Category" ).dialog( "close" );
			}
		}
    });
	$('[id^="SetCategory_"]').click(function() {
		var ID = this.id;
		var arrID = ID.split('_');
		var NowCategoryID = '#NowCategoryID_'+arrID[1];
		var CategoryID = $(NowCategoryID).val();
		$('#formID_Category').val(arrID[1]);
		document.getElementById('CategoryID').value = CategoryID;
		openVerificationForm('#Set-Category');
	});
    $( "#Set-Module" ).dialog({
		autoOpen: false,
		height: 290,
		width: 450,
		modal: true,
		buttons: {
			"Set Position": function() {
				$.ajax({
					url: "class/FormMaker_Module.php",
					type: "POST",
					data: {"formID": $("#formID_Module").val(), "Module_1": $("#Module_1").val(), "Module_2": $("#Module_2").val(), "Module_3": $("#Module_3").val(), "Module_4": $("#Module_4").val(), "Module_5": $("#Module_5").val(), "Module_6": $("#Module_6").val(), "Module_7": $("#Module_7").val(), "Module_8": $("#Module_8").val(), },
					success: function(data) {
						$( "#Set-Module" ).dialog( "close" );
						if (data=="OK") {
							alert("Set Position!");
							window.location.reload();
						}
					}
				});
			},
			"Cancel": function() {
				$( "#Set-Module" ).dialog( "close" );
			}
		}
    });
	$('[id^="SetModule_"]').click(function() {
		var ID = this.id;
		var arrID = ID.split('_');
		$('#formID_Module').val(arrID[1]);
		for(i=1;i<=8;i++){
			if (i%2==1){ var classname = "tabbtn_l_left_off"; }else
			if (i%2==0){ var classname = "tabbtn_l_right_off"; }else{}
			document.getElementById('btn_Module_'+i).className = classname;
			document.getElementById('Module_'+i).value = "0";
		}
		$.ajax({
			url: "class/GetModule.php",
			type: "POST",
			data: {"formID": arrID[1],},
			success: function(data){
				var arr_Module = data.split(';');
				for (var i=0;i<arr_Module.length;i++){
					var Module = parseInt(arr_Module[i]);
					var Moduletxt = Module.toString();
					if (Module%2==1){ var classname2 = "tabbtn_l_left_on"; }else
					if (Module%2==0){ var classname2 = "tabbtn_l_right_on"; }else{}
					document.getElementById('btn_Module_'+Moduletxt).className = classname2;
					document.getElementById('Module_'+Moduletxt).value = '1';
				}
			}
		});
		openVerificationForm('#Set-Module');
	});
    $( "#Set-Permission" ).dialog({
		autoOpen: false,
		height: 390,
		width: 460,
		modal: true,
		buttons: {
			"Set Permission": function() {
				$.ajax({
					url: "class/FormMaker_Permission.php",
					type: "POST",
					data: {"formID": $("#formID_Permission").val(), "PermissionGroup_1": $("#PermissionGroup_1").val(), "PermissionGroup_2": $("#PermissionGroup_2").val(), "PermissionGroup_3": $("#PermissionGroup_3").val(), "PermissionGroup_4": $("#PermissionGroup_4").val(), "PermissionGroup_5": $("#PermissionGroup_5").val(), "PermissionGroup_6": $("#PermissionGroup_6").val(), "PermissionGroup_7": $("#PermissionGroup_7").val(), "PermissionGroup_8": $("#PermissionGroup_8").val(), "PermissionGroup_9": $("#PermissionGroup_9").val(), "PermissionGroup_10": $("#PermissionGroup_10").val(), "PermissionLevel_1": $("#PermissionLevel_1").val(), "PermissionLevel_2": $("#PermissionLevel_2").val(), },
					success: function(data) {
						$( "#Set-Permission" ).dialog( "close" );
						if (data=="OK") {
							alert("Set Permission!");
						}
					}
				});
			},
			"Cancel": function() {
				$( "#Set-Permission" ).dialog( "close" );
			}
		}
    });
	$('[id^="SetPermission_"]').click(function() {
		var ID = this.id;
		var arrID = ID.split('_');
		$('#formID_Permission').val(arrID[1]);
		for(i=1;i<=10;i++){
			if (i%2==1){ var classname = "tabbtn_l_left_off"; }else
			if (i%2==0){ var classname = "tabbtn_l_right_off"; }else{}
			document.getElementById('btn_PermissionGroup_'+i).className = classname;
			document.getElementById('PermissionGroup_'+i).value = "0";
		}
		$.ajax({
			url: "class/GetPermissionGroup.php",
			type: "POST",
			data: {"formID": arrID[1],},
			success: function(data){
				var PermissionGroup = data.split(';');
				for (var i=0;i<PermissionGroup.length;i++){
					var Group = parseInt(PermissionGroup[i]);
					var Grouptxt = Group.toString();
					if (Group%2==1){ var classname2 = "tabbtn_l_left_on"; }else
					if (Group%2==0){ var classname2 = "tabbtn_l_right_on"; }else{}
					document.getElementById('btn_PermissionGroup_'+Grouptxt).className = classname2;
					document.getElementById('PermissionGroup_'+Grouptxt).value = '1';
				}
			}
		});
		for(i=1;i<=2;i++){
			if(i==1){ var classname = "tabbtn_xxxl_left_off"; }
			if(i==2){ var classname = "tabbtn_xxxl_right_off"; }
			document.getElementById('btn_PermissionLevel_'+i).className = classname;
			document.getElementById('PermissionLevel_'+i).value = "0";
		}
		$.ajax({
			url: "class/GetPermissionLevel.php",
			type: "POST",
			data: {"formID": arrID[1],},
			success: function(data){
				var PermissionLevel = data.split(';');
				for (var i=0;i<PermissionLevel.length;i++){
					var Level = parseInt(PermissionLevel[i]);
					var Leveltxt = Level.toString();
					if(Leveltxt==1){ var classname2 = "tabbtn_xxxl_left_on"; }
					if(Leveltxt==2){ var classname2 = "tabbtn_xxxl_right_on"; }
					document.getElementById('btn_PermissionLevel_'+Leveltxt).className = classname2;
					document.getElementById('PermissionLevel_'+Leveltxt).value = '1';
				}
			}
		});
		openVerificationForm('#Set-Permission');
	});
});
</script>
<div class="nurseform-table">
<div name="Set-Category" id="Set-Category" title="Set Category" class="dialog-form">
	<form>
	<fieldset>
		<table align="center">
          <tr>
			<td class="title">Category</td>
            <td>
			<?
			$dbCategory_set = new DB;
			$dbCategory_set->query("SELECT * FROM `formmaker_category` ORDER BY `CategoryID` ASC");
			echo '<select name="CategoryID" id="CategoryID">';
			echo '<option value=""></option>';
			for($iCategory_set=0;$iCategory_set<$dbCategory_set->num_rows();$iCategory_set++){
				$rCategory_set = $dbCategory_set->fetch_assoc();
				echo '<option value="'.$rCategory_set['CategoryID'].'">'.$rCategory_set['CategoryName'].'</option>';
			}
			echo '</select>';
			?>
			</td>
          </tr>
        </table>    	
        <input type="hidden" name="formID_Category" id="formID_Category">
	</fieldset>
    </form>
</div>
<div name="Set-Module" id="Set-Module" title="Set Position" class="dialog-form">
	<form>
	<fieldset>
		<table align="center">
          <tr>
			<td class="title">Position</td>
            <td><? echo draw_option("Module","Nursing Care;Care Work;Social Work;Rehab;Nutrition;Gen Manage;HR Manage;Admin","l","multi","",true,2);?></td>
          </tr>
        </table>    	
        <input type="hidden" name="formID_Module" id="formID_Module">
    </fieldset>
	</form>
</div>
<div name="Set-Permission" id="Set-Permission" title="Set Permission" class="dialog-form">
	<form>
	<fieldset>
		<table align="center">
          <tr>
			<td class="title">Group</td>
            <td><? echo draw_option("PermissionGroup","Administration;Nursing;Domestic CNA;Pharmacy;Social worker;Physiotherapist;Nutritionist;Public work;General manage;Foreign CNA","l","multi","",true,2);?></td>
          </tr>
		  <tr>
			<td class="title">Permission</td>
			<td><? echo draw_option("PermissionLevel","All;Only Manager","xxxl","single","",false,1);?></td>
		  </tr>
        </table>    	
        <input type="hidden" name="formID_Permission" id="formID_Permission">
    </fieldset>
	</form>
</div>
</div>