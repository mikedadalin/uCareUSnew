<?php
if($_SESSION['ncareLevel_lwj']!=5){
	echo '<script>window.location.href="index.php?func=home"</script>';
}
?>
<div style="background-color:rgba(255,255,255,0.7); padding:20px;">
	<?
	if(!isset($_GET['id'])){
		echo '
		<div style="padding:20px;">
			<h3>Form Maker</h3>
			<form method="post">
				<table>
					<tr>
						<td>Row</td>
						<td><input type="number" name="form_row" id="form_row" min="1" style="text-align:center;"></td>
						<td rowspan="2" style="padding:20px;"><input type="submit" name="submit" id="submit" value="Produce"></td>
					</tr>
					<tr>
						<td>Column</td>
						<td><input type="number" name="form_cell" id="form_cell" min="1" style="text-align:center;"></td>
					</tr>
				</table>
			</form>
		</div>
		<table><tr><td>
		<form><input type="button" onclick="location.href=\'index.php?func=FormMaker_List&bk='.$_GET['bk'].'\'" value="Back To List"></form>
		</td></tr></table>	
		';
	
		if(isset($_POST['submit'])){
			if($_POST['form_row']=="" || $_POST['form_cell']==""){
				?><script>alert('Please input Row and Column.');</script><?
			}else{
				echo '<form method="post" action="index.php?func=FormMaker_Save">';
				echo '<table><tr><td>';
				echo '<input type="button" onclick="addRow();" value="Add Row">';
				echo '<input type="button" onclick="delRow();" value="Delete Row">';
				echo '<input type="button" onclick="addCol();" value="Add Column">';
				echo '<input type="button" onclick="delCol();" value="Delete Column">';
				echo '<input type="button" onclick="MergeColspan();" value="Merge Column">';
				echo '<input type="button" onclick="SeparationColspan();" value="Separation Column">';
				//echo '<input type="button" onclick="MergeRow();" value="Merge Row">';
				echo '<input type="button" id="Button_ALL_ShowButton" onclick="Show_ALL_Button(this.id);" style="display:none;" value="Show All Button">';
				echo '<input type="button" id="Button_ALL_HiddenButton" onclick="Hidden_ALL_Button(this.id);" style="display:inline;" value="Hidden All Button">';
				//echo '<input type="button" onclick="Preview();" value="Preview">';
				echo '<input type="submit" name="submit" id="submit" value="Submit">';
				echo '<input type="hidden" name="row" id="row" value="'.$_POST['form_row'].'">';
				echo '<input type="hidden" name="cell" id="cell" value="'.$_POST['form_cell'].'">';
				echo '<input type="hidden" name="action" id="action" value="new">';
				echo '</td></tr></table>';
				echo '<div class="nurseform-table">';
				echo '<div align="left">';
				echo 'Form Category: ';
				$dbCategory = new DB;
				$dbCategory->query("SELECT * FROM `formmaker_category` ORDER BY `CategoryID` ASC");
				echo '<select name="CategoryID" id="CategoryID">';
				echo '<option value=""></option>';
				for($iCategory=0;$iCategory<$dbCategory->num_rows();$iCategory++){
					$rCategory = $dbCategory->fetch_assoc();
					echo '<option value="'.$rCategory['CategoryID'].'">'.$rCategory['CategoryName'].'</option>';
				}
				echo '</select>';
				echo '</div>';
				echo '<div align="left">';
				echo 'Form Name: <input type="text" name="FormName" id="FormName" size="50" style="text-align:center;" placeholder="Form Name" value="">';
				echo '</div>';
				echo '<table id="table">';
				echo '<tr id="WidthRow" style="background-color:rgba(0,0,0,0.1);">';
				for($j=0;$j<$_POST['form_cell'];$j++){
					echo '<td id="WidthCell_'.$j.'">Width: <input type="number" name="Column_Width_0_'.$j.'" id="Column_Width_0_'.$j.'" min="0" style="width:60px; text-align:center;" onclick="Set_td_width(this.id);"></td>';
				}
				echo '</tr>';
				for($i=0;$i<$_POST['form_row'];$i++){
					echo '<tr id="row_'.$i.'">';
					for($j=0;$j<$_POST['form_cell'];$j++){
						echo '<td id="cell_'.$i.'_'.$j.'" style="text-align:left; vertical-align:top;">';
						echo '<div id="Column_'.$i.'_'.$j.'">';
						echo '<div id="div_0_'.$i.'_'.$j.'">';
						echo '<button type="button" id="Button_ShowButton_'.$i.'_'.$j.'" onclick="Show_Button(this.id);" style="display:none; background-color:#BDBD00; color:black;"><i class="fa fa-caret-down"></i></button>';
						echo '<button type="button" id="Button_HiddenButton_'.$i.'_'.$j.'" onclick="Hidden_Button(this.id);" style="display:inline; background-color:#BDBD00; color:black;"><i class="fa fa-caret-down"></i></button>';
						echo '<input type="checkbox" id="CheckBox_Colspan_'.$i.'_'.$j.'" style="float:right;">';
						echo '<input type="hidden" name="Column_Colspan_'.$i.'_'.$j.'" id="Column_Colspan_'.$i.'_'.$j.'" value="1">';
						echo '</div>';
						echo '<div id="div_99_'.$i.'_'.$j.'">';
						echo '<div id="div_1_'.$i.'_'.$j.'">';
						echo '<button type="button" id="Button_ShowContentType_'.$i.'_'.$j.'" onclick="Show_ContentType(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>';
						echo '<button type="button" id="Button_HiddenContentType_'.$i.'_'.$j.'" onclick="Hidden_ContentType(this.id);" style="display:inline; float:left;"><i class="fa fa-caret-down"></i></button>';
						echo '<input type="hidden" name="Old_Type_'.$i.'_'.$j.'" id="Old_Type_'.$i.'_'.$j.'" value="">';
						echo '<div id="Column_ContentType_'.$i.'_'.$j.'">';
						echo 'Column Type: ';
						echo '<select name="Column_Type_'.$i.'_'.$j.'" id="Column_Type_'.$i.'_'.$j.'" onclick="Column_Type_change(this.id);">';
						echo '<option value=""></option>';
						echo '<option value="title">Title</option>';
						echo '<option value="item">Item</option>';
						echo '<option value="note">Note</option>';
						echo '<option value="input">Input</option>';
						echo '</select>';
						echo '</div>';
						echo '</div>';
						echo '<div id="div_2_'.$i.'_'.$j.'">';
						echo '<button type="button" id="Button_ShowContentInputType_'.$i.'_'.$j.'" onclick="Show_ContentInputType(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>';
						echo '<button type="button" id="Button_HiddenContentInputType_'.$i.'_'.$j.'" onclick="Hidden_ContentInputType(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>';
						echo '<input type="hidden" name="Old_InputType_'.$i.'_'.$j.'" id="Old_InputType_'.$i.'_'.$j.'" value="">';
						echo '<div id="Column_ContentInputType_'.$i.'_'.$j.'"></div>';
						echo '</div>';
						echo '<div id="div_3_'.$i.'_'.$j.'">';
						echo '<button type="button" id="Button_ShowContentInputOption_'.$i.'_'.$j.'" onclick="Show_ContentInputOption(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>';
						echo '<button type="button" id="Button_HiddenContentInputOption_'.$i.'_'.$j.'" onclick="Hidden_ContentInputOption(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>';
						echo '</div>';
						echo '<div id="div_4_'.$i.'_'.$j.'">';
						echo '<div id="Column_ContentInputOption_'.$i.'_'.$j.'"></div>';
						echo '</div>';
						echo '</div>';
						echo '<div id="div_5_'.$i.'_'.$j.'">';
						echo '<div id="Column_ContentTitle_'.$i.'_'.$j.'"></div>';
						echo '<div id="Column_Sample_'.$i.'_'.$j.'"></div>';
						echo '</div>';
						echo '</div>';
						echo '</td>';
					}
					echo '</tr>';
				}
				echo '</table>';
				echo '</div>';
				echo '</form>';
			}
		}
	}else{
		$db = new DB;
		$db->query("SELECT * FROM `formmaker_list` WHERE `formID`='".mysql_escape_string($_GET['id'])."'");
		if ($db->num_rows()>0) {
			$r = $db->fetch_assoc();
			$db2 = new DB;
			$db2->query("SELECT * FROM `formmaker_set` WHERE `formID`='".$r['formID']."' AND `row`='0' ORDER BY `cell` ASC");
			if ($db2->num_rows()>0) {
				echo '<h3>Edit Form</h3>';
				echo '<table><tr><td>';
				echo '<form><input type="button" onclick="location.href=\'index.php?func=FormMaker_List&bk='.$_GET['bk'].'\'" value="Back To List"></form>';
				echo '</td></tr></table>';
				echo '<form method="post" action="index.php?func=FormMaker_Save">';
				echo '<table><tr><td>';
				echo '<input type="button" onclick="addRow();" value="Add Row">';
				echo '<input type="button" onclick="delRow();" value="Delete Row">';
				echo '<input type="button" onclick="addCol();" value="Add Column">';
				echo '<input type="button" onclick="delCol();" value="Delete Column">';
				echo '<input type="button" onclick="MergeColspan();" value="Merge Column">';
				echo '<input type="button" onclick="SeparationColspan();" value="Separation Column">';
				//echo '<input type="button" onclick="MergeRow();" value="Merge Row">';
				echo '<input type="button" id="Button_ALL_ShowButton" onclick="Show_ALL_Button(this.id);" style="display:none;" value="Show All Button">';
				echo '<input type="button" id="Button_ALL_HiddenButton" onclick="Hidden_ALL_Button(this.id);" style="display:inline;" value="Hidden All Button">';
				//echo '<input type="button" onclick="Preview();" value="Preview">';
				echo '<input type="submit" name="submit" id="submit" value="Submit">';
				echo '<input type="hidden" name="row" id="row" value="'.$r['row'].'">';
				echo '<input type="hidden" name="cell" id="cell" value="'.$r['cell'].'">';
				echo '<input type="hidden" name="action" id="action" value="edit">';
				echo '<input type="hidden" name="formID" id="formID" value="'.$r['formID'].'">';//new
				echo '</td></tr></table>';
				echo '<div class="nurseform-table">';
				echo '<div align="left">';
				echo 'Form Category: ';
				$dbCategory = new DB;
				$dbCategory->query("SELECT * FROM `formmaker_category` ORDER BY `CategoryID` ASC");
				echo '<select name="CategoryID" id="CategoryID">';
				echo '<option value=""></option>';
				for($iCategory=0;$iCategory<$dbCategory->num_rows();$iCategory++){
					$rCategory = $dbCategory->fetch_assoc();
					echo '<option value="'.$rCategory['CategoryID'].'"';
					if($r['CategoryID']==$rCategory['CategoryID']){ echo ' selected="selected"';}
					echo '>'.$rCategory['CategoryName'].'</option>';
				}
				echo '</select>';
				echo '</div>';
				echo '<div align="left">';
				echo 'Form Name: <input type="text" name="FormName" id="FormName" size="50" style="text-align:center;" placeholder="Form Name" value="'.$r['FormName'].'">';
				echo '</div>';
				echo '<table id="table">';
				echo '<tr id="WidthRow" style="background-color:rgba(0,0,0,0.1);">';
				for($j=0;$j<$r['cell'];$j++){
					$r2 = $db2->fetch_assoc();
					if($r2['row']=='0'){
						echo '<td id="WidthCell_'.$j.'" style="width:'.$r2['Width'].'px;">Width: <input type="number" name="Column_Width_0_'.$j.'" id="Column_Width_0_'.$j.'" min="0" style="width:60px; text-align:center;" onclick="Set_td_width(this.id);" value="'.$r2['Width'].'"></td>';
					}
				}
				echo '</tr>';
				for($i=0;$i<$r['row'];$i++){
					echo '<tr id="row_'.$i.'">';
					$db3 = new DB;
					$db3->query("SELECT * FROM `formmaker_set` WHERE `formID`='".$r['formID']."' AND `row`='".$i."' ORDER BY `cell` ASC");
					for($j=0;$j<$db3->num_rows();$j++){
						$r3 = $db3->fetch_assoc();
						if($r3['Colspan']!=''){
							$Colspan = ' colspan="'.$r3['Colspan'].'"';
							if($r3['Type']=="title"){
								echo '<td'.$Colspan.' id="cell_'.$i.'_'.$r3['cell'].'" class="title" style="text-align:left; vertical-align:top;">';
							}elseif($r3['Type']=="item"){
								echo '<td'.$Colspan.' id="cell_'.$i.'_'.$r3['cell'].'" class="title_s" style="text-align:left; vertical-align:top;">';
							}else{
								echo '<td'.$Colspan.' id="cell_'.$i.'_'.$r3['cell'].'" style="text-align:left; vertical-align:top;">';
							}
							echo '<div id="Column_'.$i.'_'.$r3['cell'].'">';
							echo '<div id="div_0_'.$i.'_'.$r3['cell'].'">';
							echo '<button type="button" id="Button_ShowButton_'.$i.'_'.$r3['cell'].'" onclick="Show_Button(this.id);" style="display:none; background-color:#BDBD00; color:black;"><i class="fa fa-caret-down"></i></button>';
							echo '<button type="button" id="Button_HiddenButton_'.$i.'_'.$r3['cell'].'" onclick="Hidden_Button(this.id);" style="display:inline; background-color:#BDBD00; color:black;"><i class="fa fa-caret-down"></i></button>';
							echo '<input type="checkbox" id="CheckBox_Colspan_'.$i.'_'.$r3['cell'].'" style="float:right;">';
							echo '<input type="hidden" name="Column_Colspan_'.$i.'_'.$r3['cell'].'" id="Column_Colspan_'.$i.'_'.$r3['cell'].'" value="'.$r3['Colspan'].'">';
							echo '</div>';
							echo '<div id="div_99_'.$i.'_'.$r3['cell'].'">';
							echo '<div id="div_1_'.$i.'_'.$r3['cell'].'">';
							echo '<button type="button" id="Button_ShowContentType_'.$i.'_'.$r3['cell'].'" onclick="Show_ContentType(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>';
							echo '<button type="button" id="Button_HiddenContentType_'.$i.'_'.$r3['cell'].'" onclick="Hidden_ContentType(this.id);" style="display:inline; float:left;"><i class="fa fa-caret-down"></i></button>';
							echo '<input type="hidden" name="Old_Type_'.$i.'_'.$r3['cell'].'" id="Old_Type_'.$i.'_'.$r3['cell'].'" value="'.$r3['Type'].'">';
							echo '<div id="Column_ContentType_'.$i.'_'.$r3['cell'].'">';
							echo 'Column Type: ';
							echo '<select name="Column_Type_'.$i.'_'.$r3['cell'].'" id="Column_Type_'.$i.'_'.$r3['cell'].'" onclick="Column_Type_change(this.id);">';
							echo '<option value=""';
							if($r3['Type']==""){ echo ' selected="selected"';}
							echo '></option>';
							echo '<option value="title"';
							if($r3['Type']=="title"){ echo ' selected="selected"';}
							echo '>Title</option>';
							echo '<option value="item"';
							if($r3['Type']=="item"){ echo ' selected="selected"';}
							echo '>Item</option>';
							echo '<option value="note"';
							if($r3['Type']=="note"){ echo ' selected="selected"';}
							echo '>Note</option>';
							echo '<option value="input"';
							if($r3['Type']=="input"){ echo ' selected="selected"';}
							echo '>Input</option>';
							echo '</select>';
							echo '</div>';
							echo '</div>';
							echo '<div id="div_2_'.$i.'_'.$r3['cell'].'">';
							echo '<button type="button" id="Button_ShowContentInputType_'.$i.'_'.$r3['cell'].'" onclick="Show_ContentInputType(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>';
							if($r3['Type']=="input"){
								echo '<button type="button" id="Button_HiddenContentInputType_'.$i.'_'.$r3['cell'].'" onclick="Hidden_ContentInputType(this.id);" style="display:inline; float:left;"><i class="fa fa-caret-down"></i></button>';
							}else{
								echo '<button type="button" id="Button_HiddenContentInputType_'.$i.'_'.$r3['cell'].'" onclick="Hidden_ContentInputType(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>';
							}
							echo '<input type="hidden" name="Old_InputType_'.$i.'_'.$r3['cell'].'" id="Old_InputType_'.$i.'_'.$r3['cell'].'" value="'.$r3['InputType'].'">';
							echo '<div id="Column_ContentInputType_'.$i.'_'.$r3['cell'].'">';
							if($r3['Type']=="input"){
								echo 'Input Type: ';
								echo '<select name="Column_InputType_'.$i.'_'.$r3['cell'].'" id="Column_InputType_'.$i.'_'.$r3['cell'].'" onclick="Column_InputType_change(this.id);">';
								echo '<option value=""';
								if($r3['InputType']==""){ echo ' selected="selected"';}
								echo '></option>';
								echo '<option value="text"';
								if($r3['InputType']=="text"){ echo ' selected="selected"';}
								echo '>Text</option>';
								echo '<option value="textarea"';
								if($r3['InputType']=="textarea"){ echo ' selected="selected"';}
								echo '>Text Area</option>';
								echo '<option value="date"';
								if($r3['InputType']=="date"){ echo ' selected="selected"';}
								echo '>Date</option>';
								echo '<option value="number"';
								if($r3['InputType']=="number"){ echo ' selected="selected"';}
								echo '>Number</option>';
								echo '<option value="select"';
								if($r3['InputType']=="select"){ echo ' selected="selected"';}
								echo '>Select</option>';
								echo '<option value="draw_option"';
								if($r3['InputType']=="draw_option"){ echo ' selected="selected"';}
								echo '>Button</option>';
								echo '<option value="draw_checkbox"';
								if($r3['InputType']=="draw_checkbox"){ echo ' selected="selected"';}
								echo '>CheckBox</option>';
								echo '<option value="image"';
								if($r3['InputType']=="image"){ echo ' selected="selected"';}
								echo '>Image</option>';
								echo '</select>';
							}
							echo '</div>';
							echo '</div>';
							echo '<div id="div_3_'.$i.'_'.$r3['cell'].'">';
							echo '<button type="button" id="Button_ShowContentInputOption_'.$i.'_'.$r3['cell'].'" onclick="Show_ContentInputOption(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>';
							if($r3['Type']=="input"){
								echo '<button type="button" id="Button_HiddenContentInputOption_'.$i.'_'.$r3['cell'].'" onclick="Hidden_ContentInputOption(this.id);" style="display:inline; float:left;"><i class="fa fa-caret-down"></i></button>';
							}else{
								echo '<button type="button" id="Button_HiddenContentInputOption_'.$i.'_'.$r3['cell'].'" onclick="Hidden_ContentInputOption(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>';
							}
							echo '</div>';
							echo '<div id="div_4_'.$i.'_'.$r3['cell'].'">';
							echo '<div id="Column_ContentInputOption_'.$i.'_'.$r3['cell'].'">';
							if($r3['Type']=="input"){
								if($r3['InputType']=="text"){
									echo '<br>';
									echo 'Size: <input type="number" min="1" style="text-align:center; width:60px;" name="Column_Size_'.$i.'_'.$r3['cell'].'" id="Column_Size_'.$i.'_'.$r3['cell'].'" value="'.$r3['Size'].'"><br>';
									echo 'Note 1: <input type="text" name="Column_Note1_'.$i.'_'.$r3['cell'].'" id="Column_Note1_'.$i.'_'.$r3['cell'].'" style="text-align:center;" placeholder="Note 1" value="'.$r3['Note1'].'"><br>';
									echo 'Note 2: <input type="text" name="Column_Note2_'.$i.'_'.$r3['cell'].'" id="Column_Note2_'.$i.'_'.$r3['cell'].'" style="text-align:center;" placeholder="Note 2" value="'.$r3['Note2'].'"><br>';
									echo '<input type="button" id="Button_SetTextSize_'.$i.'_'.$r3['cell'].'" onclick="SetSize_Text(this.id);" value="Set">';
								}elseif($r3['InputType']=="textarea"){
									$arr_Textarea_Size = explode("_",$r3['Size']);
									echo '<br>';
									echo 'Width: <input type="number" min="1" style="text-align:center; width:60px;" name="Temp_Width_'.$i.'_'.$r3['cell'].'" id="Temp_Width_'.$i.'_'.$r3['cell'].'" value="'.$arr_Textarea_Size[0].'"><br>';
									echo 'Height: <input type="number" min="1" style="text-align:center; width:60px;" name="Temp_Height_'.$i.'_'.$r3['cell'].'" id="Temp_Height_'.$i.'_'.$r3['cell'].'" value="'.$arr_Textarea_Size[1].'"><br>';
									echo '<input type="hidden" name="Column_Size_'.$i.'_'.$r3['cell'].'" id="Column_Size_'.$i.'_'.$r3['cell'].'" value="'.$r3['Size'].'">';
									echo 'Note 1: <input type="text" name="Column_Note1_'.$i.'_'.$r3['cell'].'" id="Column_Note1_'.$i.'_'.$r3['cell'].'" style="text-align:center;" placeholder="Note 1" value="'.$r3['Note1'].'"><br>';
									echo 'Note 2: <input type="text" name="Column_Note2_'.$i.'_'.$r3['cell'].'" id="Column_Note2_'.$i.'_'.$r3['cell'].'" style="text-align:center;" placeholder="Note 2" value="'.$r3['Note2'].'"><br>';
									echo '<input type="button" id="Button_SetTextareaSize_'.$i.'_'.$r3['cell'].'" onclick="SetSize_Textarea(this.id);" value="Set">';
								}elseif($r3['InputType']=="date"){
									echo '<br>';
									echo 'Note 1: <input type="text" name="Column_Note1_'.$i.'_'.$r3['cell'].'" id="Column_Note1_'.$i.'_'.$r3['cell'].'" style="text-align:center;" placeholder="Note 1" value="'.$r3['Note1'].'"><br>';
									echo 'Note 2: <input type="text" name="Column_Note2_'.$i.'_'.$r3['cell'].'" id="Column_Note2_'.$i.'_'.$r3['cell'].'" style="text-align:center;" placeholder="Note 2" value="'.$r3['Note2'].'"><br>';
									echo '<input type="button" id="Button_SetDateNote_'.$i.'_'.$r3['cell'].'" onclick="SetNote_Date(this.id);" value="Set">';
								}elseif($r3['InputType']=="number"){
									echo '<br>';
									echo 'Note 1: <input type="text" name="Column_Note1_'.$i.'_'.$r3['cell'].'" id="Column_Note1_'.$i.'_'.$r3['cell'].'" style="text-align:center;" placeholder="Note 1" value="'.$r3['Note1'].'"><br>';
									echo 'Note 2: <input type="text" name="Column_Note2_'.$i.'_'.$r3['cell'].'" id="Column_Note2_'.$i.'_'.$r3['cell'].'" style="text-align:center;" placeholder="Note 2" value="'.$r3['Note2'].'"><br>';
									echo '<input type="button" id="Button_SetNumberNote_'.$i.'_'.$r3['cell'].'" onclick="SetNote_Number(this.id);" value="Set">';
								}elseif($r3['InputType']=="select"){
									echo '<br>';
									echo 'Option: <input type="text" name="Column_InputOption_'.$i.'_'.$r3['cell'].'" id="Column_InputOption_'.$i.'_'.$r3['cell'].'" style="text-align:center;" placeholder="( ex: 1;2;3 )" value="'.$r3['InputOption'].'"><br>';
									echo 'Other: <select name="Column_Other_'.$i.'_'.$r3['cell'].'" id="Column_Other_'.$i.'_'.$r3['cell'].'">';
									echo '<option value="0"';
									if($r3['Other']=="0"){ echo ' selected="selected"';}
									echo '>None</option>';
									echo '<option value="1"';
									if($r3['Other']=="1"){ echo ' selected="selected"';}
									echo '>Has</option>';
									echo '</select><br>';
									echo '(Size: <input type="number" min="1" style="text-align:center; width:60px;" name="Column_OtherSize_'.$i.'_'.$r3['cell'].'" id="Column_OtherSize_'.$i.'_'.$r3['cell'].'" value="'.$r3['OtherSize'].'">)<br>';
									echo 'Note 1: <input type="text" name="Column_Note1_'.$i.'_'.$r3['cell'].'" id="Column_Note1_'.$i.'_'.$r3['cell'].'" style="text-align:center;" placeholder="Note 1" value="'.$r3['Note1'].'"><br>';
									echo 'Note 2: <input type="text" name="Column_Note2_'.$i.'_'.$r3['cell'].'" id="Column_Note2_'.$i.'_'.$r3['cell'].'" style="text-align:center;" placeholder="Note 2" value="'.$r3['Note2'].'"><br>';
									echo '<input type="button" id="Button_SetOption_'.$i.'_'.$r3['cell'].'" onclick="SetOption_Select(this.id);" value="Set">';
								}elseif($r3['InputType']=="draw_option"){
									echo '<br>';
									echo 'Option: <input type="text" name="Column_InputOption_'.$i.'_'.$r3['cell'].'" id="Column_InputOption_'.$i.'_'.$r3['cell'].'" style="text-align:center;" placeholder="( ex: 1;2;3 )" value="'.$r3['InputOption'].'"><br>';
									echo 'Button(s) per line: <input type="number" name="Column_LineFeed_'.$i.'_'.$r3['cell'].'" id="Column_LineFeed_'.$i.'_'.$r3['cell'].'" style="text-align:center; width:60px;" min="0" value="'.$r3['LineFeed'].'"><br>';
									echo 'Choice: <select name="Column_Choice_'.$i.'_'.$r3['cell'].'" id="Column_Choice_'.$i.'_'.$r3['cell'].'">';
									echo '<option value="multi"';
									if($r3['Choice']=="multi"){ echo ' selected="selected"';}
									echo '>Multiple</option><option value="single"';
									if($r3['Choice']=="single"){ echo ' selected="selected"';}
									echo '>Single</option></select><br>';
									echo 'Size: <select name="Column_Size_'.$i.'_'.$r3['cell'].'" id="Column_Size_'.$i.'_'.$r3['cell'].'">';
									echo '<option value="ss"';
									if($r3['Size']=="ss"){ echo ' selected="selected"';}
									echo '>1</option>';
									echo '<option value="s"';
									if($r3['Size']=="s"){ echo ' selected="selected"';}
									echo '>2</option>';
									echo '<option value="xs"';
									if($r3['Size']=="xs"){ echo ' selected="selected"';}
									echo '>3</option>';
									echo '<option value="sm"';
									if($r3['Size']=="sm"){ echo ' selected="selected"';}
									echo '>4</option>';
									echo '<option value="m"';
									if($r3['Size']=="m"){ echo ' selected="selected"';}
									echo '>5</option>';
									echo '<option value="xm"';
									if($r3['Size']=="xm"){ echo ' selected="selected"';}
									echo '>6</option>';
									echo '<option value="sl"';
									if($r3['Size']=="sl"){ echo ' selected="selected"';}
									echo '>7</option>';
									echo '<option value="l"';
									if($r3['Size']=="l"){ echo ' selected="selected"';}
									echo '>8</option>';
									echo '<option value="xl"';
									if($r3['Size']=="xl"){ echo ' selected="selected"';}
									echo '>9</option>';
									echo '<option value="xxl"';
									if($r3['Size']=="xxl"){ echo ' selected="selected"';}
									echo '>10</option>';
									echo '<option value="xxxl"';
									if($r3['Size']=="xxxl"){ echo ' selected="selected"';}
									echo '>11</option>';
									echo '<option value="xxxxl"';
									if($r3['Size']=="xxxxl"){ echo ' selected="selected"';}
									echo '>12</option>';
									echo '<option value="xxxxxl"';
									if($r3['Size']=="xxxxxl"){ echo ' selected="selected"';}
									echo '>13</option>';
									echo '</select><br>';
									echo 'Other: <select name="Column_Other_'.$i.'_'.$r3['cell'].'" id="Column_Other_'.$i.'_'.$r3['cell'].'">';
									echo '<option value="0"';
									if($r3['Other']=="0"){ echo ' selected="selected"';}
									echo '>None</option>';
									echo '<option value="1"';
									if($r3['Other']=="1"){ echo ' selected="selected"';}
									echo '>Has</option>';
									echo '</select><br>';
									echo '(Size: <input type="number" min="1" style="text-align:center; width:60px;" name="Column_OtherSize_'.$i.'_'.$r3['cell'].'" id="Column_OtherSize_'.$i.'_'.$r3['cell'].'" value="'.$r3['OtherSize'].'">)<br>';
									echo 'Note 1: <input type="text" name="Column_Note1_'.$i.'_'.$r3['cell'].'" id="Column_Note1_'.$i.'_'.$r3['cell'].'" style="text-align:center;" placeholder="Note 1" value="'.$r3['Note1'].'"><br>';
									echo 'Note 2: <input type="text" name="Column_Note2_'.$i.'_'.$r3['cell'].'" id="Column_Note2_'.$i.'_'.$r3['cell'].'" style="text-align:center;" placeholder="Note 2" value="'.$r3['Note2'].'"><br>';
									echo '<input type="button" id="Button_SetOption_'.$i.'_'.$r3['cell'].'" onclick="SetOption_Button(this.id);" value="Set">';
								}elseif($r3['InputType']=="draw_checkbox"){
									echo '<br>';
									echo 'Option: <input type="text" name="Column_InputOption_'.$i.'_'.$r3['cell'].'" id="Column_InputOption_'.$i.'_'.$r3['cell'].'" style="text-align:center;" placeholder="( ex: 1;2;3 )" value="'.$r3['InputOption'].'"><br>';
									echo 'Choice: <select name="Column_Choice_'.$i.'_'.$r3['cell'].'" id="Column_Choice_'.$i.'_'.$r3['cell'].'">';
									echo '<option value="multi"';
									if($r3['Choice']=="multi"){ echo ' selected="selected"';}
									echo '>Multiple</option><option value="single"';
									if($r3['Choice']=="single"){ echo ' selected="selected"';}
									echo '>Single</option></select><br>';
									echo 'Type: <select name="Column_LineFeed_'.$i.'_'.$r3['cell'].'" id="Column_LineFeed_'.$i.'_'.$r3['cell'].'">';
									echo '<option value="0"';
									if($r3['LineFeed']=="0"){ echo ' selected="selected"';}
									echo '>A</option>';
									echo '<option value="1"';
									if($r3['LineFeed']=="1"){ echo ' selected="selected"';}
									echo '>B</option>';
									echo '<option value="2"';
									if($r3['LineFeed']=="2"){ echo ' selected="selected"';}
									echo '>C</option>';
									echo '</select><br>';
									echo 'Other: <select name="Column_Other_'.$i.'_'.$r3['cell'].'" id="Column_Other_'.$i.'_'.$r3['cell'].'">';
									echo '<option value="0"';
									if($r3['Other']=="0"){ echo ' selected="selected"';}
									echo '>None</option>';
									echo '<option value="1"';
									if($r3['Other']=="1"){ echo ' selected="selected"';}
									echo '>Has</option>';
									echo '</select><br>';
									echo '(Size: <input type="number" min="1" style="text-align:center; width:60px;" name="Column_OtherSize_'.$i.'_'.$r3['cell'].'" id="Column_OtherSize_'.$i.'_'.$r3['cell'].'" value="'.$r3['OtherSize'].'">)<br>';
									echo 'Note 1: <input type="text" name="Column_Note1_'.$i.'_'.$r3['cell'].'" id="Column_Note1_'.$i.'_'.$r3['cell'].'" style="text-align:center;" placeholder="Note 1" value="'.$r3['Note1'].'"><br>';
									echo 'Note 2: <input type="text" name="Column_Note2_'.$i.'_'.$r3['cell'].'" id="Column_Note2_'.$i.'_'.$r3['cell'].'" style="text-align:center;" placeholder="Note 2" value="'.$r3['Note2'].'"><br>';
									echo '<input type="button" id="Button_SetOption_'.$i.'_'.$r3['cell'].'" onclick="SetOption_CheckBox(this.id);" value="Set">';
								}elseif($r3['InputType']=="image"){
									//////////////// 額外條件 /////////////
									echo 'image';
								}else{
									
								}
							}
							echo '</div>';
							echo '</div>';
							echo '</div>';
							echo '<div id="div_5_'.$i.'_'.$r3['cell'].'">';
							echo '<div id="Column_ContentTitle_'.$i.'_'.$r3['cell'].'">';
							if($r3['Type']=="title"){
								echo 'Title: <input type="text" name="Column_Title_'.$i.'_'.$r3['cell'].'" id="Column_Title_'.$i.'_'.$r3['cell'].'" style="text-align:center;" placeholder="Title" value="'.$r3['Title'].'">';
							}
							if($r3['Type']=="item"){
								echo 'Item: <input type="text" name="Column_Item_'.$i.'_'.$r3['cell'].'" id="Column_Item_'.$i.'_'.$r3['cell'].'" style="text-align:center;" placeholder="Item" value="'.$r3['Item'].'">';
							}
							if($r3['Type']=="note"){
								echo 'Note: <input type="text" name="Column_Note_'.$i.'_'.$r3['cell'].'" id="Column_Note_'.$i.'_'.$r3['cell'].'" style="text-align:center;" placeholder="Note" value="'.$r3['Note'].'">';
							}
							echo '</div>';
							echo '<div id="Column_Sample_'.$i.'_'.$r3['cell'].'">';
							if($r3['Type']=="input"){
								if($r3['InputType']=="text"){
									echo 'Sample:<br><input type="text" size="'.$r3['Size'].'">';
									if($r3['Note1']!=""){ echo ' '.$r3['Note1']; }
									if($r3['Note2']!=""){ echo '<br>'.$r3['Note2']; }
								}elseif($r3['InputType']=="textarea"){
									$arr_Textarea_Size = explode("_",$r3['Size']);
									echo 'Sample:<br><textarea style="width:'.$arr_Textarea_Size[0].'px; height:'.$arr_Textarea_Size[1].'px;"></textarea>';
									if($r3['Note1']!=""){ echo ' '.$r3['Note1']; }
									if($r3['Note2']!=""){ echo '<br>'.$r3['Note2']; }
								}elseif($r3['InputType']=="date"){
									echo 'Sample:<br>';
									echo '<script> $(function() { $( "#Sample_date_'.$i.'_'.$r3['cell'].'").datetimepicker({format:\'Y/m/d\', timepicker: false, mask: true}); }); </script>';
									echo '<input type="text" name="Sample_date_'.$i.'_'.$r3['cell'].'" id="Sample_date_'.$i.'_'.$r3['cell'].'" value="'.date("Y/m/d").'" size="12">';
									if($r3['Note1']!=""){ echo ' '.$r3['Note1']; }
									if($r3['Note2']!=""){ echo '<br>'.$r3['Note2']; }
								}elseif($r3['InputType']=="number"){
									echo 'Sample:<br><input type="number">';
									if($r3['Note1']!=""){ echo ' '.$r3['Note1']; }
									if($r3['Note2']!=""){ echo '<br>'.$r3['Note2']; }
								}elseif($r3['InputType']=="select"){
									echo 'Sample:<br>';
									echo '<select>';
									echo '<option value=""></option>';
									if($r3['InputOption']!=""){
										$arrInputOption = explode(";",$r3['InputOption']);
										for($z=0;$z<count($arrInputOption);$z++){
											echo '<option value="'.$arrInputOption[$z].'">'.$arrInputOption[$z].'</option>';
										}
									}else{
										echo '<option value="">1</option>';
										echo '<option value="">2</option>';
										echo '<option value="">3</option>';
									}
									echo '</select>';
									if($r3['Other']=="1"){ echo ' <input type="text" size="'.$r3['OtherSize'].'">'; }
									if($r3['Note1']!=""){ echo ' '.$r3['Note1']; }
									if($r3['Note2']!=""){ echo '<br>'.$r3['Note2']; }
								}elseif($r3['InputType']=="draw_option"){
									if($r3['LineFeed']>0){
										$br = "true";
									}else{
										$br = "false";
									}
									echo 'Sample:<br>'.draw_option("Sample".$i."n".$r3['cell'],$r3['InputOption'],$r3['Size'],$r3['Choice'],"",$br,$r3['LineFeed']);
									if($r3['Other']=="1"){ echo ' <input type="text" size="'.$r3['OtherSize'].'">'; }
									if($r3['Note1']!=""){ echo ' '.$r3['Note1']; }
									if($r3['Note2']!=""){ echo '<br>'.$r3['Note2']; }
								}elseif($r3['InputType']=="draw_checkbox"){
									if($r3['LineFeed']=="0"){ echo 'Sample:<br>'.draw_checkbox_nobr("Sample".$i."n".$r3['cell'],$r3['InputOption'],"",$r3['Choice']); }
									if($r3['LineFeed']=="1"){ echo 'Sample:<br>'.draw_checkbox("Sample".$i."n".$r3['cell'],$r3['InputOption'],"",$r3['Choice']); }
									if($r3['LineFeed']=="2"){ echo 'Sample:<br>'.draw_checkbox_2col("Sample".$i."n".$r3['cell'],$r3['InputOption'],"",$r3['Choice']); }
									if($r3['Other']=="1"){ echo ' <input type="text" size="'.$r3['OtherSize'].'">'; }
									if($r3['Note1']!=""){ echo ' '.$r3['Note1']; }
									if($r3['Note2']!=""){ echo '<br>'.$r3['Note2']; }
								}elseif($r3['InputType']=="image"){
									//////////////// Sample /////////////
									echo 'Sample:<br>image';
								}else{
									
								}
							}
							echo '</div>';
							echo '</div>';
							echo '</div>';
							echo '</td>';
						}
					}
					echo '</tr>';
				}
				echo '</table>';
				echo '</div>';
				echo '</form>';
			}
		}
	}
	?>
</div>
<? if(!isset($_GET['id'])){ ?>
<script>
$(function() {
	var num_cell = Number(document.getElementById('cell').value);
	for(var j=0;j<num_cell;j++){
		var Target_td_ID = '#cell_0_' + j;
		var Target_input_ID = 'Column_Width_0_' + j;
		var new_width = $(Target_td_ID).width();
		document.getElementById(Target_input_ID).value = new_width;
	}
});	
</script>
<? } ?>
<script>
/*
function Preview(){
	alert('123');
}
function MergeRow(){
	alert('123');
}
*/
function MergeColspan(){
	var num_row = Number(document.getElementById("row").value);
	var num_cell = Number(document.getElementById('cell').value);
	for(var i=0;i<num_row;i++){
		var GGtime = Number(0);
		var Array_Colspan = [];
		var Array_AlreadyColspan = [];
		for(var j=0;j<num_cell;j++){
			var CheckBox_ID = 'CheckBox_Colspan_'+ i + '_' + j;
			if(document.getElementById(CheckBox_ID)){
				var Checked = document.getElementById(CheckBox_ID);
				if(Checked.checked){
					var id = i+'_'+j;
					Array_Colspan.push(id);
				}
			}else{
				Array_AlreadyColspan.push(j);
			}
		}
		var Array_Ready_Colspan = [];
		for(var z=0;z<Array_Colspan.length;z++){
			var arrCell = Array_Colspan[z].split('_');
			if(z==0){
				var first = Number(arrCell[1]);
				var last = Number(arrCell[1]);
				Array_Ready_Colspan.push(arrCell[1]);
				if((z+1)==Array_Colspan.length){
					var CheckBox_ID = 'CheckBox_Colspan_'+ i + '_' + first;
					document.getElementById(CheckBox_ID).checked = '';
				}
			}else{
				if(eval(last+1)==Number(arrCell[1])){
					Array_Ready_Colspan.push(arrCell[1]);
					last = Number(arrCell[1]);
					if((z+1)==Array_Colspan.length){
						var Delete_Target_Row = document.getElementById('row_'+arrCell[0]);
						var num_cell = Number(document.getElementById('cell').value);
						var bz = Number(0);
						for(var zz=0;zz<num_cell;zz++){
							if(zz<=first){
								bz++;
								for(var s=0;s<Array_AlreadyColspan.length;s++){
									var data = Number(Array_AlreadyColspan[s].toString());
									if(data==zz){
										bz--;
									}
								}
							}
						}
						for(var zz=1;zz<Array_Ready_Colspan.length;zz++){
							Delete_Target_Row.deleteCell(bz);
						}
						var Array_AlreadyColspan2 = [];
						for(var j2=0;j2<num_cell;j2++){
							var CheckBox_ID = 'CheckBox_Colspan_'+ i + '_' + j2;
							if(document.getElementById(CheckBox_ID)){
								
							}else{
								Array_AlreadyColspan2.push(j2);
							}
						}
						var AlreadyColspan = Number(0);
						var Colspan_num = Array_Ready_Colspan.length;
						var temp_last = last;
						for(var s=0;s<Array_AlreadyColspan2.length;s++){
							var data = Number(Array_AlreadyColspan2[s].toString());
							if(data<first){
								AlreadyColspan++;
							}
							if(result){
								if(data==temp_last){
									Colspan_num = eval(Colspan_num+GGtime);
									result = false;
								}
							}
							if(data==eval(temp_last+1)){
								Colspan_num++;
								temp_last++;
							}
						}
						var Change_Colspan_Cell = eval(num_cell-(num_cell-first)-AlreadyColspan);
						var Change_Colspan_Row = eval(Number(arrCell[0])+1);
						var x=document.getElementById('table').rows[Change_Colspan_Row].cells;
						x[Change_Colspan_Cell].colSpan = Colspan_num;
						var CheckBox_ID = 'CheckBox_Colspan_'+ i + '_' + first;
						document.getElementById(CheckBox_ID).checked = '';
						var Column_Colspan_ID = 'Column_Colspan_'+ i + '_' + first;
						document.getElementById(Column_Colspan_ID).value = Colspan_num;
					}
				}else{
					if(Array_Ready_Colspan.length>1){
						var result = false;
						var temp_last = last;
						for(var s=0;s<Array_AlreadyColspan.length;s++){
							var data = Number(Array_AlreadyColspan[s].toString());
							if(eval(temp_last+1)==data){
								GGtime++;
								if(eval(data+1)==Number(arrCell[1])){
									result = true;
								}else{
									temp_last++;
								}
							}
						}
						if(result){//判斷 AB~DEF 之間有連續 last~D    AG~AGAˇ    AG~GA  AG~G~GA
						Array_Ready_Colspan.push(arrCell[1]);
						last = Number(arrCell[1]);
					if((z+1)==Array_Colspan.length){
						var Delete_Target_Row = document.getElementById('row_'+arrCell[0]);
						var num_cell = Number(document.getElementById('cell').value);
						var bz = Number(0);
						for(var zz=0;zz<num_cell;zz++){
							if(zz<=first){
								bz++;
								for(var s=0;s<Array_AlreadyColspan.length;s++){
									var data = Number(Array_AlreadyColspan[s].toString());
									if(data==zz){
										bz--;
									}
								}
							}
						}
						for(var zz=1;zz<Array_Ready_Colspan.length;zz++){
							Delete_Target_Row.deleteCell(bz);
						}
						var Array_AlreadyColspan2 = [];
						for(var j2=0;j2<num_cell;j2++){
							var CheckBox_ID = 'CheckBox_Colspan_'+ i + '_' + j2;
							if(document.getElementById(CheckBox_ID)){
								
							}else{
								Array_AlreadyColspan2.push(j2);
							}
						}
						var AlreadyColspan = Number(0);
						var Colspan_num = Array_Ready_Colspan.length;
						var temp_last = last;
						for(var s=0;s<Array_AlreadyColspan2.length;s++){
							var data = Number(Array_AlreadyColspan2[s].toString());
							if(data<first){
								AlreadyColspan++;
							}
							if(result){
								if(data==temp_last){
									Colspan_num = eval(Colspan_num+GGtime);
									result = false;
								}
							}
							if(data==eval(temp_last+1)){
								Colspan_num++;
								temp_last++;
							}
						}
						var Change_Colspan_Cell = eval(num_cell-(num_cell-first)-AlreadyColspan);
						var Change_Colspan_Row = eval(Number(arrCell[0])+1);
						var x=document.getElementById('table').rows[Change_Colspan_Row].cells;
						x[Change_Colspan_Cell].colSpan = Colspan_num;
						var CheckBox_ID = 'CheckBox_Colspan_'+ i + '_' + first;
						document.getElementById(CheckBox_ID).checked = '';
						var Column_Colspan_ID = 'Column_Colspan_'+ i + '_' + first;
						document.getElementById(Column_Colspan_ID).value = Colspan_num;
					}
						}else{// AB C DEF 之間不連續
						var Delete_Target_Row = document.getElementById('row_'+arrCell[0]);
						var num_cell = Number(document.getElementById('cell').value);
						var bz = Number(0);
						for(var zz=0;zz<num_cell;zz++){
							if(zz<=first){
								bz++;
								for(var s=0;s<Array_AlreadyColspan.length;s++){
									var data = Number(Array_AlreadyColspan[s].toString());
									if(data==zz){
										bz--;
									}
								}
							}
						}
						for(var zz=1;zz<Array_Ready_Colspan.length;zz++){
							Delete_Target_Row.deleteCell(bz);
						}
						var Array_AlreadyColspan2 = [];
						for(var j2=0;j2<num_cell;j2++){
							var CheckBox_ID = 'CheckBox_Colspan_'+ i + '_' + j2;
							if(document.getElementById(CheckBox_ID)){
								
							}else{
								Array_AlreadyColspan2.push(j2);
							}
						}
						var AlreadyColspan = Number(0);
						var Colspan_num = Array_Ready_Colspan.length;
						var temp_last = last;
						Colspan_num = eval(Colspan_num+GGtime);
						for(var s=0;s<Array_AlreadyColspan2.length;s++){
							var data = Number(Array_AlreadyColspan2[s].toString());
							if(data<first){
								AlreadyColspan++;
							}
							if(data==eval(temp_last+1)){
								Colspan_num++;
								temp_last++;
							}
						}
						var Change_Colspan_Cell = eval(num_cell-(num_cell-first)-AlreadyColspan);
						var Change_Colspan_Row = eval(Number(arrCell[0])+1);
						var x=document.getElementById('table').rows[Change_Colspan_Row].cells;
						x[Change_Colspan_Cell].colSpan = Colspan_num;
						var CheckBox_ID = 'CheckBox_Colspan_'+ i + '_' + first;
						document.getElementById(CheckBox_ID).checked = '';
						var Column_Colspan_ID = 'Column_Colspan_'+ i + '_' + first;
						document.getElementById(Column_Colspan_ID).value = Colspan_num;
						
						first = Number(arrCell[1]);
						last = Number(arrCell[1]);
						Array_Ready_Colspan = [];
						Array_Ready_Colspan.push(arrCell[1]);
						var Array_AlreadyColspan = [];
						for(var jj=0;jj<num_cell;jj++){
							var CheckBox_ID = 'CheckBox_Colspan_'+ i + '_' + jj;
							if(document.getElementById(CheckBox_ID)){
								
							}else{
								Array_AlreadyColspan.push(jj);
							}
						}
						}
					}else{
						var result = false;
						var temp_last = last;
						for(var s=0;s<Array_AlreadyColspan.length;s++){
							var data = Number(Array_AlreadyColspan[s].toString());
							if(eval(temp_last+1)==data){
								GGtime++;
								if(eval(data+1)==Number(arrCell[1])){
									result = true;
								}else{
									temp_last++;
								}
							}
						}
						if(result){//判斷 A CDEF 之間有連續   G~G G~A A~G A~A 
						Array_Ready_Colspan.push(arrCell[1]);
						last = Number(arrCell[1]);
					if((z+1)==Array_Colspan.length){
						var Delete_Target_Row = document.getElementById('row_'+arrCell[0]);
						var num_cell = Number(document.getElementById('cell').value);
						var bz = Number(0);
						for(var zz=0;zz<num_cell;zz++){
							if(zz<=first){
								bz++;
								for(var s=0;s<Array_AlreadyColspan.length;s++){
									var data = Number(Array_AlreadyColspan[s].toString());
									if(data==zz){
										bz--;
									}
								}
							}
						}
						for(var zz=1;zz<Array_Ready_Colspan.length;zz++){
							Delete_Target_Row.deleteCell(bz);
						}
						var Array_AlreadyColspan2 = [];
						for(var j2=0;j2<num_cell;j2++){
							var CheckBox_ID = 'CheckBox_Colspan_'+ i + '_' + j2;
							if(document.getElementById(CheckBox_ID)){
								
							}else{
								Array_AlreadyColspan2.push(j2);
							}
						}
						var AlreadyColspan = Number(0);
						var Colspan_num = Array_Ready_Colspan.length;
						var temp_last = last;
						for(var s=0;s<Array_AlreadyColspan2.length;s++){
							var data = Number(Array_AlreadyColspan2[s].toString());
							if(data<first){
								AlreadyColspan++;
							}
							if(result){
								if(data==temp_last){
									Colspan_num = eval(Colspan_num+GGtime);
									result = false;
								}
							}
							if(data==eval(temp_last+1)){
								Colspan_num++;
								temp_last++;
							}
						}
						var Change_Colspan_Cell = eval(num_cell-(num_cell-first)-AlreadyColspan);
						var Change_Colspan_Row = eval(Number(arrCell[0])+1);
						var x=document.getElementById('table').rows[Change_Colspan_Row].cells;
						x[Change_Colspan_Cell].colSpan = Colspan_num;
						var CheckBox_ID = 'CheckBox_Colspan_'+ i + '_' + first;
						document.getElementById(CheckBox_ID).checked = '';
						var Column_Colspan_ID = 'Column_Colspan_'+ i + '_' + first;
						document.getElementById(Column_Colspan_ID).value = Colspan_num;
					}
						}else{//判斷 A CDEF 之間沒連續
						var CheckBox_ID = 'CheckBox_Colspan_'+ i + '_' + first;
						document.getElementById(CheckBox_ID).checked = '';
						var CheckBox_ID = 'CheckBox_Colspan_'+ i + '_' + arrCell[1];
						document.getElementById(CheckBox_ID).checked = '';
						first = Number(arrCell[1]);
						last = Number(arrCell[1]);
						Array_Ready_Colspan = [];
						Array_Ready_Colspan.push(arrCell[1]);
						var Array_AlreadyColspan = [];
						for(var jj=0;jj<num_cell;jj++){
							var CheckBox_ID = 'CheckBox_Colspan_'+ i + '_' + jj;
							if(document.getElementById(CheckBox_ID)){
								
							}else{
								Array_AlreadyColspan.push(jj);
							}
						}
						}
					}
				}
			}
		}
	}
}
function SeparationColspan(){
	var num_row = Number(document.getElementById("row").value);
	var num_cell = Number(document.getElementById('cell').value);
	for(var i=0;i<num_row;i++){
		for(var j=0;j<num_cell;j++){
			var CheckBox_ID = 'CheckBox_Colspan_'+ i + '_' + j;
			if(document.getElementById(CheckBox_ID)){
				var Checked = document.getElementById(CheckBox_ID);
				if(Checked.checked){
					var Column_Colspan_ID = 'Column_Colspan_'+ i + '_' + j;
					var Colspan_num = Number(document.getElementById(Column_Colspan_ID).value);
					if(Colspan_num>1){
						var Array_AlreadyColspan = [];
						for(var j3=0;j3<num_cell;j3++){
							if(document.getElementById(CheckBox_ID)){
								
							}else{
								Array_AlreadyColspan.push(j3);
							}
						}
						var AlreadyColspan = Number(0);
						for(var s=0;s<Array_AlreadyColspan.length;s++){
							var data = Number(Array_AlreadyColspan[s].toString());
							if(data<j){
								AlreadyColspan++;
							}
						}
						var Change_Colspan_Cell = eval(num_cell-(num_cell-j)-AlreadyColspan);
						var Change_Colspan_Row = eval(Number(i)+1);
						var x=document.getElementById('table').rows[Change_Colspan_Row].cells;
						x[Change_Colspan_Cell].colSpan = 1;
						document.getElementById(Column_Colspan_ID).value = 1;
						for(var j2=1;j2<Colspan_num;j2++){
							var row = 'row_'+i;
							var cell = document.getElementById(row).insertCell(Change_Colspan_Cell+j2);
							cell.id = 'cell_'+ i +'_'+ eval(j+j2);
							cell.style = 'text-align:left; vertical-align:top;';
							cell.innerHTML = '<div id="Column_'+ i +'_'+ eval(j+j2) +'">\
							<div id="div_0_'+ i +'_'+ eval(j+j2) +'">\
							<button type="button" id="Button_ShowButton_'+ i +'_'+ eval(j+j2) +'" onclick="Show_Button(this.id);" style="display:none; background-color:#BDBD00; color:black;"><i class="fa fa-caret-down"></i></button>\
							<button type="button" id="Button_HiddenButton_'+ i +'_'+ eval(j+j2) +'" onclick="Hidden_Button(this.id);" style="display:inline; background-color:#BDBD00; color:black;"><i class="fa fa-caret-down"></i></button>\
							<input type="checkbox" id="CheckBox_Colspan_'+ i +'_'+ eval(j+j2) +'" style="float:right;">\
							<input type="hidden" name="Column_Colspan_'+ i +'_'+ eval(j+j2) +'" id="Column_Colspan_'+ i +'_'+ eval(j+j2) +'" value="1">\
							</div>\
							<div id="div_99_'+ i +'_'+ eval(j+j2) +'">\
							<div id="div_1_'+ i +'_'+ eval(j+j2) +'">\
							<button type="button" id="Button_ShowContentType_'+ i +'_'+ eval(j+j2) +'" onclick="Show_ContentType(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>\
							<button type="button" id="Button_HiddenContentType_'+ i +'_'+ eval(j+j2) +'" onclick="Hidden_ContentType(this.id);" style="display:inline; float:left;"><i class="fa fa-caret-down"></i></button>\
							<input type="hidden" name="Old_Type_'+ i +'_'+ eval(j+j2) +'" id="Old_Type_'+ i +'_'+ eval(j+j2) +'" value="">\
							<div id="Column_ContentType_'+ i +'_'+ eval(j+j2) +'">\
							Column Type: \
							<select name="Column_Type_'+ i +'_'+ eval(j+j2) +'" id="Column_Type_'+ i +'_'+ eval(j+j2) +'" onclick="Column_Type_change(this.id);">\
							<option value=""></option>\
							<option value="title">Title</option>\
							<option value="item">Item</option>\
							<option value="note">Note</option>\
							<option value="input">Input</option>\
							</select>\
							</div>\
							</div>\
							<div id="div_2_'+ i +'_'+ eval(j+j2) +'">\
							<button type="button" id="Button_ShowContentInputType_'+ i +'_'+ eval(j+j2) +'" onclick="Show_ContentInputType(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>\
							<button type="button" id="Button_HiddenContentInputType_'+ i +'_'+ eval(j+j2) +'" onclick="Hidden_ContentInputType(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>\
							<input type="hidden" name="Old_InputType_'+ i +'_'+ eval(j+j2) +'" id="Old_InputType_'+ i +'_'+ eval(j+j2) +'" value="">\
							<div id="Column_ContentInputType_'+ i +'_'+ eval(j+j2) +'"></div>\
							</div>\
							<div id="div_3_'+ i +'_'+ eval(j+j2) +'">\
							<button type="button" id="Button_ShowContentInputOption_'+ i +'_'+ eval(j+j2) +'" onclick="Show_ContentInputOption(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>\
							<button type="button" id="Button_HiddenContentInputOption_'+ i +'_'+ eval(j+j2) +'" onclick="Hidden_ContentInputOption(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>\
							</div>\
							<div id="div_4_'+ i +'_'+ eval(j+j2) +'">\
							<div id="Column_ContentInputOption_'+ i +'_'+ eval(j+j2) +'"></div>\
							</div>\
							</div>\
							<div id="div_5_'+ i +'_'+ eval(j+j2) +'">\
							<div id="Column_ContentTitle_'+ i +'_'+ eval(j+j2) +'"></div>\
							<div id="Column_Sample_'+ i +'_'+ eval(j+j2) +'"></div>\
							</div>\
							</div>';
							document.getElementById(CheckBox_ID).checked = '';
						}
					}else{
						document.getElementById(CheckBox_ID).checked = '';
					}
				}
			}
		}
	}
}
function Set_td_width(id){
	var ID = id;
	var arrID = ID.split('_');
	var Target_td_ID = '#WidthCell_' + arrID[3];
	var Target_input_ID = 'Column_Width_0_' + arrID[3];
	var num_row = Number(document.getElementById('row').value);
	var num_cell = Number(document.getElementById('cell').value);
	var new_width = Number(document.getElementById(ID).value);
	$(Target_td_ID).width(new_width);
	for(var i=0;i<num_row;i++){
		var td_id = '#cell_'+ i +'_'+ arrID[3];
		if(document.getElementById(td_id)){
			$(td_id).width(new_width);
		}
	}
	for(var j=0;j<num_cell;j++){
		if(j!=arrID[3]){
			var Target_td_ID = '#WidthCell_' + j;
			var Target_input_ID = 'Column_Width_0_' + j;
			new_width = $(Target_td_ID).width();
			for(var i=0;i<num_row;i++){
				var td_id = '#cell_'+ i +'_'+ j;
				if(document.getElementById(td_id)){
					$(td_id).width(new_width);
				}
			}
			document.getElementById(Target_input_ID).value = new_width;			
		}
	}
}
function Show_ALL_Button(id){
	var num_row = Number(document.getElementById("row").value);
	var num_cell = Number(document.getElementById('cell').value);
	var ID = id;
	var Button_ALL_HiddenButton_ID = 'Button_ALL_HiddenButton';
	document.getElementById(ID).style.display = 'none';
	document.getElementById(Button_ALL_HiddenButton_ID).style.display = 'inline';
	for(var i=0;i<num_row;i++){
		for(var j=0;j<num_cell;j++){
			var divID = 'div_99_'+ i + '_' + j;
			var Button_ShowButton_ID = 'Button_ShowButton_'+ i + '_' + j;
			var Button_HiddenButton_ID = 'Button_HiddenButton_'+ i + '_' + j;
			if(document.getElementById(divID)){
				document.getElementById(divID).style.display = 'inline';
				document.getElementById(Button_ShowButton_ID).style.display = 'none';
				document.getElementById(Button_HiddenButton_ID).style.display = 'inline';
			}
		}
	}
}
function Hidden_ALL_Button(id){
	var num_row = Number(document.getElementById("row").value);
	var num_cell = Number(document.getElementById('cell').value);
	var ID = id;
	var Button_ALL_ShowButton_ID = 'Button_ALL_ShowButton';
	document.getElementById(ID).style.display = 'none';
	document.getElementById(Button_ALL_ShowButton_ID).style.display = 'inline';
	for(var i=0;i<num_row;i++){
		for(var j=0;j<num_cell;j++){
			var divID = 'div_99_'+ i + '_' + j;
			var Button_ShowButton_ID = 'Button_ShowButton_'+ i + '_' + j;
			var Button_HiddenButton_ID = 'Button_HiddenButton_'+ i + '_' + j;
			if(document.getElementById(divID)){
				document.getElementById(divID).style.display = 'none';
				document.getElementById(Button_ShowButton_ID).style.display = 'inline';
				document.getElementById(Button_HiddenButton_ID).style.display = 'none';
			}
		}
	}
}
function Show_Button(id){
	var ID = id;
	var arrID = ID.split('_');
	var Button_HiddenButton_ID = 'Button_HiddenButton_'+ arrID[2] + '_' + arrID[3];
	var divID = 'div_99_'+ arrID[2] + '_' + arrID[3];
	document.getElementById(divID).style.display = 'inline';
	document.getElementById(ID).style.display = 'none';
	document.getElementById(Button_HiddenButton_ID).style.display = 'inline';
}
function Hidden_Button(id){
	var ID = id;
	var arrID = ID.split('_');
	var Button_ShowButton_ID = 'Button_ShowButton_'+ arrID[2] + '_' + arrID[3];
	var divID = 'div_99_'+ arrID[2] + '_' + arrID[3];
	document.getElementById(divID).style.display = 'none';
	document.getElementById(ID).style.display = 'none';
	document.getElementById(Button_ShowButton_ID).style.display = 'inline';
}
function Show_ContentType(id){
	var ID = id;
	var arrID = ID.split('_');
	var newID_ContentType = 'Column_ContentType_' + arrID[2] + '_' + arrID[3];
	var newID_Hidden_ContentType = 'Button_HiddenContentType_' + arrID[2] + '_' + arrID[3];
	document.getElementById(newID_ContentType).style.display = 'inline';
	document.getElementById(ID).style.display = 'none';
	document.getElementById(newID_Hidden_ContentType).style.display = 'inline';
}
function Hidden_ContentType(id){
	var ID = id;
	var arrID = ID.split('_');
	var newID_ContentType = 'Column_ContentType_' + arrID[2] + '_' + arrID[3];
	var newID_Show_ContentType = 'Button_ShowContentType_' + arrID[2] + '_' + arrID[3];
	document.getElementById(newID_ContentType).style.display = 'none';
	document.getElementById(ID).style.display = 'none';
	document.getElementById(newID_Show_ContentType).style.display = 'inline';
}
function Show_ContentInputType(id){
	var ID = id;
	var arrID = ID.split('_');
	var newID_ContentInputType = 'Column_ContentInputType_' + arrID[2] + '_' + arrID[3];
	var newID_Hidden_ContentInputType = 'Button_HiddenContentInputType_' + arrID[2] + '_' + arrID[3];
	document.getElementById(newID_ContentInputType).style.display = 'inline';
	document.getElementById(ID).style.display = 'none';
	document.getElementById(newID_Hidden_ContentInputType).style.display = 'inline';
}
function Hidden_ContentInputType(id){
	var ID = id;
	var arrID = ID.split('_');
	var newID_ContentInputType = 'Column_ContentInputType_' + arrID[2] + '_' + arrID[3];
	var newID_Show_ContentInputType = 'Button_ShowContentInputType_' + arrID[2] + '_' + arrID[3];
	document.getElementById(newID_ContentInputType).style.display = 'none';
	document.getElementById(ID).style.display = 'none';
	document.getElementById(newID_Show_ContentInputType).style.display = 'inline';
}
function Show_ContentInputOption(id){
	var ID = id;
	var arrID = ID.split('_');
	var newID_ContentInputOption = 'Column_ContentInputOption_' + arrID[2] + '_' + arrID[3];
	var newID_Hidden_ContentInputOption = 'Button_HiddenContentInputOption_' + arrID[2] + '_' + arrID[3];
	document.getElementById(newID_ContentInputOption).style.display = 'inline';
	document.getElementById(ID).style.display = 'none';
	document.getElementById(newID_Hidden_ContentInputOption).style.display = 'inline';
}
function Hidden_ContentInputOption(id){
	var ID = id;
	var arrID = ID.split('_');
	var newID_ContentInputOption = 'Column_ContentInputOption_' + arrID[2] + '_' + arrID[3];
	var newID_Show_ContentInputOption = 'Button_ShowContentInputOption_' + arrID[2] + '_' + arrID[3];
	document.getElementById(newID_ContentInputOption).style.display = 'none';
	document.getElementById(ID).style.display = 'none';
	document.getElementById(newID_Show_ContentInputOption).style.display = 'inline';
}
function SetSize_Text(id){
	var ID = id;
	var arrID = ID.split('_');
	var newID_Sample = 'Column_Sample_' + arrID[2] + '_' + arrID[3];
	var newID_Size = 'Column_Size_'+ arrID[2] + '_' + arrID[3];
	var newID_Note1 = 'Column_Note1_' + arrID[2] + '_' + arrID[3];
	var newID_Note2 = 'Column_Note2_' + arrID[2] + '_' + arrID[3];
	var Size = document.getElementById(newID_Size).value;
	var Note1 = document.getElementById(newID_Note1).value;
	var Note2 = document.getElementById(newID_Note2).value;
	if(Size!='' && Size>0){
		var new_Sample = 'Sample:<br><input type="text" size="'+ Size +'">';
		if(Note1!=''){ new_Sample = new_Sample+' '+Note1; }
		if(Note2!=''){ new_Sample = new_Sample+'<br>'+Note2; }
		document.getElementById(newID_Sample).innerHTML = new_Sample;
	}else{
		alert('Please input size');
	}
}
function SetSize_Textarea(id){
	var ID = id;
	var arrID = ID.split('_');
	var newID_Sample = 'Column_Sample_' + arrID[2] + '_' + arrID[3];
	var Temp_Width_ID = 'Temp_Width_'+ arrID[2] + '_' + arrID[3];
	var Temp_Height_ID = 'Temp_Height_'+ arrID[2] + '_' + arrID[3];
	var newID_Size = 'Column_Size_'+ arrID[2] + '_' + arrID[3];
	var newID_Note1 = 'Column_Note1_' + arrID[2] + '_' + arrID[3];
	var newID_Note2 = 'Column_Note2_' + arrID[2] + '_' + arrID[3];
	var Temp_Width = document.getElementById(Temp_Width_ID).value;
	var Temp_Height = document.getElementById(Temp_Height_ID).value;
	var Note1 = document.getElementById(newID_Note1).value;
	var Note2 = document.getElementById(newID_Note2).value;
	if(Temp_Width!='' && Temp_Width>0 && Temp_Height!='' && Temp_Height>0){
		var new_Sample = 'Sample:<br><textarea style="width:'+Temp_Width+'px; height:'+Temp_Height+'px;"></textarea>';
		if(Note1!=''){ new_Sample = new_Sample+' '+Note1; }
		if(Note2!=''){ new_Sample = new_Sample+'<br>'+Note2; }
		document.getElementById(newID_Sample).innerHTML = new_Sample;
		document.getElementById(newID_Size).value = Temp_Width+'_'+Temp_Height;
	}else{
		alert('Please input width and height');
	}
}
function SetNote_Date(id){
	var ID = id;
	var arrID = ID.split('_');
	var newID_Sample = 'Column_Sample_' + arrID[2] + '_' + arrID[3];
	var newID_Note1 = 'Column_Note1_' + arrID[2] + '_' + arrID[3];
	var newID_Note2 = 'Column_Note2_' + arrID[2] + '_' + arrID[3];
	var Note1 = document.getElementById(newID_Note1).value;
	var Note2 = document.getElementById(newID_Note2).value;
	var new_Sample = 'Sample:<br><input type="date">';
	if(Note1!=''){ new_Sample = new_Sample+' '+Note1; }
	if(Note2!=''){ new_Sample = new_Sample+'<br>'+Note2; }
	document.getElementById(newID_Sample).innerHTML = new_Sample;
}
function SetNote_Number(id){
	var ID = id;
	var arrID = ID.split('_');
	var newID_Sample = 'Column_Sample_' + arrID[2] + '_' + arrID[3];
	var newID_Note1 = 'Column_Note1_' + arrID[2] + '_' + arrID[3];
	var newID_Note2 = 'Column_Note2_' + arrID[2] + '_' + arrID[3];
	var Note1 = document.getElementById(newID_Note1).value;
	var Note2 = document.getElementById(newID_Note2).value;
	var new_Sample = 'Sample:<br><input type="number">';
	if(Note1!=''){ new_Sample = new_Sample+' '+Note1; }
	if(Note2!=''){ new_Sample = new_Sample+'<br>'+Note2; }
	document.getElementById(newID_Sample).innerHTML = new_Sample;
}
function SetOption_Select(id){
	var ID = id;
	var arrID = ID.split('_');
	var newID_Sample = 'Column_Sample_' + arrID[2] + '_' + arrID[3];
	var newID_InputOption = 'Column_InputOption_'+ arrID[2] + '_' + arrID[3];
	var newID_Other = 'Column_Other_' + arrID[2] + '_' + arrID[3];
	var newID_OtherSize = 'Column_OtherSize_' + arrID[2] + '_' + arrID[3];
	var newID_Note1 = 'Column_Note1_' + arrID[2] + '_' + arrID[3];
	var newID_Note2 = 'Column_Note2_' + arrID[2] + '_' + arrID[3];
	var InputOption = document.getElementById(newID_InputOption).value;
	var Other = document.getElementById(newID_Other).value;
	var OtherSize = document.getElementById(newID_OtherSize).value;
	var Note1 = document.getElementById(newID_Note1).value;
	var Note2 = document.getElementById(newID_Note2).value;
	if(InputOption!=''){
		var arrOption = InputOption.split(';');
		var new_Sample = 'Sample:<br><select>';
		new_Sample = new_Sample + '<option value=""></option>';
		for(var i=0;i<arrOption.length;i++){
			new_Sample = new_Sample + '<option value="'+ arrOption[i] +'">'+ arrOption[i] +'</option>';
		}
		new_Sample = new_Sample + '</select>';Other
		if(Other=='1'){ new_Sample = new_Sample+' <input type="text" size="'+ OtherSize +'">'; }
		if(Note1!=''){ new_Sample = new_Sample+' '+Note1; }
		if(Note2!=''){ new_Sample = new_Sample+'<br>'+Note2; }
		document.getElementById(newID_Sample).innerHTML = new_Sample;
	}else{
		alert('Please input options');
	}
}
function SetOption_Button(id){
	var ID = id;
	var arrID = ID.split('_');
	var newID_Sample = 'Column_Sample_' + arrID[2] + '_' + arrID[3];
	var newID_InputOption = 'Column_InputOption_'+ arrID[2] + '_' + arrID[3];
	var newID_LineFeed = 'Column_LineFeed_'+ arrID[2] + '_' + arrID[3];
	var newID_Choice = 'Column_Choice_'+ arrID[2] + '_' + arrID[3];
	var newID_Size = 'Column_Size_'+ arrID[2] + '_' + arrID[3];
	var newID_Other = 'Column_Other_' + arrID[2] + '_' + arrID[3];
	var newID_OtherSize = 'Column_OtherSize_' + arrID[2] + '_' + arrID[3];
	var newID_Note1 = 'Column_Note1_' + arrID[2] + '_' + arrID[3];
	var newID_Note2 = 'Column_Note2_' + arrID[2] + '_' + arrID[3];
	var InputOption = document.getElementById(newID_InputOption).value;
	var LineFeed = Number(document.getElementById(newID_LineFeed).value);
	var Choice = document.getElementById(newID_Choice).value;
	var Size = document.getElementById(newID_Size).value;
	var Other = document.getElementById(newID_Other).value;
	var OtherSize = document.getElementById(newID_OtherSize).value;
	var Note1 = document.getElementById(newID_Note1).value;
	var Note2 = document.getElementById(newID_Note2).value;
	var brnRun = Number(LineFeed);
	if(InputOption!=''){
		var arrOption = InputOption.split(';');
		var new_Sample = 'Sample:<br>';
		for(var i=0;i<arrOption.length;i++){
			if(LineFeed==0){
				var pos = 'middle';
				if(i==0){ var pos = 'left'; }
				if(i==eval(arrOption.length-1)){ var pos = 'right'; }
				new_Sample = new_Sample + '<input type="hidden" name="Sample'+ arrID[2] + 'n' + arrID[3] + '_' + eval(i+1) +'" id="Sample'+ arrID[2] + 'n' + arrID[3] + '_' + eval(i+1) +'" value="0">';
				new_Sample = new_Sample + '<button type="button" name="btn_Sample'+ arrID[2] + 'n' + arrID[3] + '_' + eval(i+1) +'" id="btn_Sample'+ arrID[2] + 'n' + arrID[3] + '_' + eval(i+1) +'" class="tabbtn_'+ Size +'_'+ pos +'_off" onclick="click_'+ Choice +'_btn2(this.id,\''+ pos +'\',\''+ Size +'\',\'Sample'+ arrID[2] + 'n' + arrID[3] +'\',\''+ arrOption.length +'\');">'+ arrOption[i] +'</button>';
			}else{
				var pos = 'middle';
				if(i==0){ var pos = 'left'; }
				if ((i+1)==arrOption.length) { pos = 'right'; }
				if (i==(brnRun-1)) { pos = 'right'; }
				if (i==brnRun) { pos = 'left'; brnRun = eval(brnRun+LineFeed); }
				new_Sample = new_Sample + '<input type="hidden" name="Sample'+ arrID[2] + 'n' + arrID[3] + '_' + eval(i+1) +'" id="Sample'+ arrID[2] + 'n' + arrID[3] + '_' + eval(i+1) +'" value="0">';
				new_Sample = new_Sample + '<button type="button" name="btn_Sample'+ arrID[2] + 'n' + arrID[3] + '_' + eval(i+1) +'" id="btn_Sample'+ arrID[2] + 'n' + arrID[3] + '_' + eval(i+1) +'" class="tabbtn_'+ Size +'_'+ pos +'_off" onclick="click_'+ Choice +'_btn2(this.id,\''+ pos +'\',\''+ Size +'\',\'Sample'+ arrID[2] + 'n' + arrID[3] +'\',\''+ arrOption.length +'\');">'+ arrOption[i] +'</button>';
				if (i==(brnRun-1)) { new_Sample = new_Sample +'<br>'; }
			}
		}
		if(Other=='1'){ new_Sample = new_Sample+' <input type="text" size="'+ OtherSize +'">'; }
		if(Note1!=''){ new_Sample = new_Sample+' '+Note1; }
		if(Note2!=''){ new_Sample = new_Sample+'<br>'+Note2; }
		document.getElementById(newID_Sample).innerHTML = new_Sample;
	}else{
		alert('Please input options');
	}
}
function SetOption_CheckBox(id){
	var ID = id;
	var arrID = ID.split('_');
	var newID_Sample = 'Column_Sample_' + arrID[2] + '_' + arrID[3];
	var newID_InputOption = 'Column_InputOption_'+ arrID[2] + '_' + arrID[3];
	var newID_LineFeed = 'Column_LineFeed_'+ arrID[2] + '_' + arrID[3];
	var newID_Choice = 'Column_Choice_'+ arrID[2] + '_' + arrID[3];
	var newID_Other = 'Column_Other_' + arrID[2] + '_' + arrID[3];
	var newID_OtherSize = 'Column_OtherSize_' + arrID[2] + '_' + arrID[3];
	var newID_Note1 = 'Column_Note1_' + arrID[2] + '_' + arrID[3];
	var newID_Note2 = 'Column_Note2_' + arrID[2] + '_' + arrID[3];
	var InputOption = document.getElementById(newID_InputOption).value;
	var LineFeed = document.getElementById(newID_LineFeed).value;
	var Choice = document.getElementById(newID_Choice).value;
	var Other = document.getElementById(newID_Other).value;
	var OtherSize = document.getElementById(newID_OtherSize).value;
	var Note1 = document.getElementById(newID_Note1).value;
	var Note2 = document.getElementById(newID_Note2).value;
	if(InputOption!=''){
		var arrOption = InputOption.split(';');
		var new_Sample = 'Sample:<br>';
		for(var i=0;i<arrOption.length;i++){
			new_Sample = new_Sample + '<tr>';
			new_Sample = new_Sample + '<input type="hidden" name="Sample'+ arrID[2] + 'n' + arrID[3] + '_' + eval(i+1) +'" id="Sample'+ arrID[2] + 'n' + arrID[3] + '_' + eval(i+1) +'" value="1">';
			new_Sample = new_Sample + '<td width="40">';
			new_Sample = new_Sample + '<button type="button" class="checkbox_off" onclick="click_'+ Choice +'_checkbox2(this.id,\'Sample'+ arrID[2] + 'n' + arrID[3] +'\',\''+ arrOption.length +'\');" id="btn_Sample'+ arrID[2] + 'n' + arrID[3] + '_' + eval(i+1) +'"><font style="color:white;">✔</font></button>';
			new_Sample = new_Sample + '</td>';
			new_Sample = new_Sample + '<td> '+ arrOption[i] +' </td>';
			new_Sample = new_Sample + '</tr>';
			if(LineFeed=="0"){
				
			}else if(LineFeed=="1"){
				new_Sample = new_Sample + '<br>';
			}else if(LineFeed=="2"){
				if(eval((i+1)%2)==0){
					new_Sample = new_Sample + '<br>';
				}
			}
		}
		if(Other=='1'){ new_Sample = new_Sample+' <input type="text" size="'+ OtherSize +'">'; }
		if(Note1!=''){ new_Sample = new_Sample+' '+Note1; }
		if(Note2!=''){ new_Sample = new_Sample+'<br>'+Note2; }
		document.getElementById(newID_Sample).innerHTML = new_Sample;
	}else{
		alert('Please input options');
	}
}
function addRow(){
	var num_row = Number(document.getElementById("row").value);
	var num_cell = Number(document.getElementById('cell').value);
	var table = document.getElementById('table');
	var row = document.createElement('tr');
	row.id = 'row_'+ num_row;
	for(var j=0;j<num_cell;j++){
		var cell = document.createElement('td');
		cell.id = 'cell_'+ num_row +'_'+ j;
		cell.style = 'text-align:left; vertical-align:top;';
		cell.innerHTML = '<div id="Column_'+ num_row +'_'+ j +'">\
		<div id="div_0_'+ num_row +'_'+ j +'">\
		<button type="button" id="Button_ShowButton_'+ num_row +'_'+ j +'" onclick="Show_Button(this.id);" style="display:none; background-color:#BDBD00; color:black;"><i class="fa fa-caret-down"></i></button>\
		<button type="button" id="Button_HiddenButton_'+ num_row +'_'+ j +'" onclick="Hidden_Button(this.id);" style="display:inline; background-color:#BDBD00; color:black;"><i class="fa fa-caret-down"></i></button>\
		<input type="checkbox" id="CheckBox_Colspan_'+ num_row +'_'+ j +'" style="float:right;">\
		<input type="hidden" name="Column_Colspan_'+ num_row +'_'+ j +'" id="Column_Colspan_'+ num_row +'_'+ j +'" value="1">\
		</div>\
		<div id="div_99_'+ num_row +'_'+ j +'">\
		<div id="div_1_'+ num_row +'_'+ j +'">\
		<button type="button" id="Button_ShowContentType_'+ num_row +'_'+ j +'" onclick="Show_ContentType(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>\
		<button type="button" id="Button_HiddenContentType_'+ num_row +'_'+ j +'" onclick="Hidden_ContentType(this.id);" style="display:inline; float:left;"><i class="fa fa-caret-down"></i></button>\
		<input type="hidden" name="Old_Type_'+ num_row +'_'+ j +'" id="Old_Type_'+ num_row +'_'+ j +'" value="">\
		<div id="Column_ContentType_'+ num_row +'_'+ j +'">\
		Column Type: \
		<select name="Column_Type_'+ num_row +'_'+ j +'" id="Column_Type_'+ num_row +'_'+ j +'" onclick="Column_Type_change(this.id);">\
		<option value=""></option>\
		<option value="title">Title</option>\
		<option value="item">Item</option>\
		<option value="note">Note</option>\
		<option value="input">Input</option>\
		</select>\
		</div>\
		</div>\
		<div id="div_2_'+ num_row +'_'+ j +'">\
		<button type="button" id="Button_ShowContentInputType_'+ num_row +'_'+ j +'" onclick="Show_ContentInputType(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>\
		<button type="button" id="Button_HiddenContentInputType_'+ num_row +'_'+ j +'" onclick="Hidden_ContentInputType(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>\
		<input type="hidden" name="Old_InputType_'+ num_row +'_'+ j +'" id="Old_InputType_'+ num_row +'_'+ j +'" value="">\
		<div id="Column_ContentInputType_'+ num_row +'_'+ j +'"></div>\
		</div>\
		<div id="div_3_'+ num_row +'_'+ j +'">\
		<button type="button" id="Button_ShowContentInputOption_'+ num_row +'_'+ j +'" onclick="Show_ContentInputOption(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>\
		<button type="button" id="Button_HiddenContentInputOption_'+ num_row +'_'+ j +'" onclick="Hidden_ContentInputOption(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>\
		</div>\
		<div id="div_4_'+ num_row +'_'+ j +'">\
		<div id="Column_ContentInputOption_'+ num_row +'_'+ j +'"></div>\
		</div>\
		</div>\
		<div id="div_5_'+ num_row +'_'+ j +'">\
		<div id="Column_ContentTitle_'+ num_row +'_'+ j +'"></div>\
		<div id="Column_Sample_'+ num_row +'_'+ j +'"></div>\
		</div>\
		</div>';
		row.appendChild(cell);
	}
	table.appendChild(row);
	document.getElementById("row").value = eval(num_row+1);
}
function delRow(){
	var num_row = Number(document.getElementById("row").value);
	if(num_row-1<=0){
		
	}else{
		var table = document.getElementById('table');
		table.deleteRow(table.rows.length-1);
		document.getElementById("row").value = eval(num_row-1);
	}
}
function addCol(){
	var num_row = Number(document.getElementById("row").value);
	var num_cell = Number(document.getElementById('cell').value);
	
	var row = document.getElementById('WidthRow');
	var cell = document.createElement('td');
	cell.id = 'WidthCell_'+ num_cell;
	cell.innerHTML = 'Width: <input type="number" name="Column_Width_0_'+ num_cell +'" id="Column_Width_0_'+ num_cell +'" min="0" style="width:60px; text-align:center;" onclick="Set_td_width(this.id);">';
	row.appendChild(cell);
	
	for(var i=0;i<num_row;i++){
		var row = document.getElementById('row_'+i);
		var cell = document.createElement('td');
		cell.id = 'cell_'+ i +'_'+ num_cell;
		cell.style = 'text-align:left; vertical-align:top;';
		cell.innerHTML = '<div id="Column_'+ i +'_'+ num_cell +'">\
		<div id="div_0_'+ i +'_'+ num_cell +'">\
		<button type="button" id="Button_ShowButton_'+ i +'_'+ num_cell +'" onclick="Show_Button(this.id);" style="display:none; background-color:#BDBD00; color:black;"><i class="fa fa-caret-down"></i></button>\
		<button type="button" id="Button_HiddenButton_'+ i +'_'+ num_cell +'" onclick="Hidden_Button(this.id);" style="display:inline; background-color:#BDBD00; color:black;"><i class="fa fa-caret-down"></i></button>\
		<input type="checkbox" id="CheckBox_Colspan_'+ i +'_'+ num_cell +'" style="float:right;">\
		<input type="hidden" name="Column_Colspan_'+ i +'_'+ num_cell +'" id="Column_Colspan_'+ i +'_'+ num_cell +'" value="1">\
		</div>\
		<div id="div_99_'+ i +'_'+ num_cell +'">\
		<div id="div_1_'+ i +'_'+ num_cell +'">\
		<button type="button" id="Button_ShowContentType_'+ i +'_'+ num_cell +'" onclick="Show_ContentType(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>\
		<button type="button" id="Button_HiddenContentType_'+ i +'_'+ num_cell +'" onclick="Hidden_ContentType(this.id);" style="display:inline; float:left;"><i class="fa fa-caret-down"></i></button>\
		<input type="hidden" name="Old_Type_'+ i +'_'+ num_cell +'" id="Old_Type_'+ i +'_'+ num_cell +'" value="">\
		<div id="Column_ContentType_'+ i +'_'+ num_cell +'">\
		Column Type: \
		<select name="Column_Type_'+ i +'_'+ num_cell +'" id="Column_Type_'+ i +'_'+ num_cell +'" onclick="Column_Type_change(this.id);">\
		<option value=""></option>\
		<option value="title">Title</option>\
		<option value="item">Item</option>\
		<option value="note">Note</option>\
		<option value="input">Input</option>\
		</select>\
		</div>\
		</div>\
		<div id="div_2_'+ i +'_'+ num_cell +'">\
		<button type="button" id="Button_ShowContentInputType_'+ i +'_'+ num_cell +'" onclick="Show_ContentInputType(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>\
		<button type="button" id="Button_HiddenContentInputType_'+ i +'_'+ num_cell +'" onclick="Hidden_ContentInputType(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>\
		<input type="hidden" name="Old_InputType_'+ i +'_'+ num_cell +'" id="Old_InputType_'+ i +'_'+ num_cell +'" value="">\
		<div id="Column_ContentInputType_'+ i +'_'+ num_cell +'"></div>\
		</div>\
		<div id="div_3_'+ i +'_'+ num_cell +'">\
		<button type="button" id="Button_ShowContentInputOption_'+ i +'_'+ num_cell +'" onclick="Show_ContentInputOption(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>\
		<button type="button" id="Button_HiddenContentInputOption_'+ i +'_'+ num_cell +'" onclick="Hidden_ContentInputOption(this.id);" style="display:none; float:left;"><i class="fa fa-caret-down"></i></button>\
		</div>\
		<div id="div_4_'+ i +'_'+ num_cell +'">\
		<div id="Column_ContentInputOption_'+ i +'_'+ num_cell +'"></div>\
		</div>\
		</div>\
		<div id="div_5_'+ i +'_'+ num_cell +'">\
		<div id="Column_ContentTitle_'+ i +'_'+ num_cell +'"></div>\
		<div id="Column_Sample_'+ i +'_'+ num_cell +'"></div>\
		</div>\
		</div>';
		row.appendChild(cell);
	}
	document.getElementById("cell").value = eval(num_cell+1);
	
	var num_cell = Number(document.getElementById('cell').value);
	for(var j=0;j<num_cell;j++){
		var Target_td_ID = '#WidthCell_' + j;
		var Target_input_ID = 'Column_Width_0_' + j;
		var new_width = $(Target_td_ID).width();
		document.getElementById(Target_input_ID).value = new_width;
	}
}
function delCol(){
	var num_row = Number(document.getElementById("row").value);
	var num_cell = Number(document.getElementById("cell").value);
	if(num_cell-1<=0){
		
	}else{
		var result = true;
		for(var i=0;i<num_row;i++){
			var Array_Cell_ID = [];
			for(var j=0;j<num_cell;j++){
				var Cell_ID = 'cell_'+ i + '_' + j;
				if(document.getElementById(Cell_ID)){
					Array_Cell_ID.push(j);
				}
			}
			if(Array_Cell_ID[eval(Array_Cell_ID.length-1)]!=eval(num_cell-1)){
				result = false;
			}
		}
		if(result){
			var row = document.getElementById('WidthRow');
			row.deleteCell(num_cell-1);
			
			for(var i=0;i<num_row;i++){
				var row = document.getElementById('row_'+i);
				var cell_num = Number(0);
				for(var j=0;j<num_cell;j++){
					var Cell_ID = 'cell_'+ i + '_' + j;
					if(document.getElementById(Cell_ID)){
						cell_num++;
					}
				}
				row.deleteCell(cell_num-1);
			}
			document.getElementById("cell").value = eval(num_cell-1);			
			
			var num_cell = Number(document.getElementById('cell').value);
			for(var j=0;j<num_cell;j++){
				var Target_td_ID = '#WidthCell_' + j;
				var Target_input_ID = 'Column_Width_0_' + j;
				var new_width = $(Target_td_ID).width();
				document.getElementById(Target_input_ID).value = new_width;
			}			
		}else{
			alert('Column isn\'t match');
		}
	}
}
function Column_Type_change(id){
	var ID = id;
	var arrID = ID.split('_');
	var newID_cell = 'cell_' + arrID[2] + '_' + arrID[3];
	var newID_ContentType = 'Column_ContentType_' + arrID[2] + '_' + arrID[3];
	var newID_Old_Type = 'Old_Type_' + arrID[2] + '_' + arrID[3];
	var newID_Old_InputType = 'Old_InputType_' + arrID[2] + '_' + arrID[3];
	var newID_Show_ContentType = 'Button_ShowContentType_' + arrID[2] + '_' + arrID[3];
	var newID_Hidden_ContentType = 'Button_HiddenContentType_' + arrID[2] + '_' + arrID[3];
	var newID_Show_ContentInputType = 'Button_ShowContentInputType_' + arrID[2] + '_' + arrID[3];
	var newID_Hidden_ContentInputType = 'Button_HiddenContentInputType_' + arrID[2] + '_' + arrID[3];
	var newID_Show_ContentInputOption = 'Button_ShowContentInputOption_' + arrID[2] + '_' + arrID[3];
	var newID_Hidden_ContentInputOption = 'Button_HiddenContentInputOption_' + arrID[2] + '_' + arrID[3];
	var newID_ContentTitle = 'Column_ContentTitle_' + arrID[2] + '_' + arrID[3];
	var newID_ContentInputType = 'Column_ContentInputType_' + arrID[2] + '_' + arrID[3];
	var newID_ContentInputOption = 'Column_ContentInputOption_'+ arrID[2] + '_' + arrID[3];
	var newID_Sample = 'Column_Sample_' + arrID[2] + '_' + arrID[3];
	var value = document.getElementById(ID).value;
	var old_Type = document.getElementById(newID_Old_Type).value;
	if(value=='' && value!=old_Type){
		document.getElementById(newID_ContentTitle).innerHTML = '';
		document.getElementById(newID_ContentInputType).innerHTML = '';
		document.getElementById(newID_Sample).innerHTML = '';
		document.getElementById(newID_ContentInputOption).innerHTML = '';
		document.getElementById(newID_cell).className = '';
		document.getElementById(newID_Old_Type).value = value;
		document.getElementById(newID_Old_InputType).value = '';
		document.getElementById(newID_Show_ContentType).style.display = 'none';
		document.getElementById(newID_Hidden_ContentType).style.display = 'inline';
		document.getElementById(newID_Show_ContentInputType).style.display = 'none';
		document.getElementById(newID_Hidden_ContentInputType).style = 'display:none; float:left;';
		document.getElementById(newID_Show_ContentInputOption).style.display = 'none';
		document.getElementById(newID_Hidden_ContentInputOption).style.display = 'none';
	}else if(value=='title' && value!=old_Type){
		document.getElementById(newID_ContentInputType).innerHTML = '';
		document.getElementById(newID_Sample).innerHTML = '';
		document.getElementById(newID_ContentInputOption).innerHTML = '';
		document.getElementById(newID_ContentType).style.display = 'none';
		document.getElementById(newID_Show_ContentType).style = 'display:inline';
		document.getElementById(newID_Hidden_ContentType).style.display = 'none';
		document.getElementById(newID_Show_ContentInputType).style.display = 'none';
		document.getElementById(newID_Hidden_ContentInputType).style = 'display:none; float:left;';
		document.getElementById(newID_Show_ContentInputOption).style.display = 'none';
		document.getElementById(newID_Hidden_ContentInputOption).style.display = 'none';
		document.getElementById(newID_ContentTitle).innerHTML = 'Title: <input type="text" name="Column_Title_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Title_'+ arrID[2] + '_' + arrID[3] +'" style="text-align:center;" placeholder="Title">';
		document.getElementById(newID_cell).className = 'title';
		document.getElementById(newID_Old_Type).value = value;
		document.getElementById(newID_Old_InputType).value = '';
	}else if(value=='item' && value!=old_Type){
		document.getElementById(newID_ContentInputType).innerHTML = '';
		document.getElementById(newID_Sample).innerHTML = '';
		document.getElementById(newID_ContentInputOption).innerHTML = '';
		document.getElementById(newID_ContentType).style.display = 'none';
		document.getElementById(newID_Show_ContentType).style = 'display:inline';
		document.getElementById(newID_Hidden_ContentType).style.display = 'none';
		document.getElementById(newID_Show_ContentInputType).style.display = 'none';
		document.getElementById(newID_Hidden_ContentInputType).style = 'display:none; float:left;';
		document.getElementById(newID_Show_ContentInputOption).style.display = 'none';
		document.getElementById(newID_Hidden_ContentInputOption).style.display = 'none';
		document.getElementById(newID_ContentTitle).innerHTML = 'Item: <input type="text" name="Column_Item_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Item_'+ arrID[2] + '_' + arrID[3] +'" style="text-align:center;" placeholder="Item">';
		document.getElementById(newID_cell).className = 'title_s';
		document.getElementById(newID_Old_Type).value = value;
		document.getElementById(newID_Old_InputType).value = '';
	}else if(value=='note' && value!=old_Type){
		document.getElementById(newID_ContentInputType).innerHTML = '';
		document.getElementById(newID_Sample).innerHTML = '';
		document.getElementById(newID_ContentInputOption).innerHTML = '';
		document.getElementById(newID_ContentType).style.display = 'none';
		document.getElementById(newID_Show_ContentType).style = 'display:inline';
		document.getElementById(newID_Hidden_ContentType).style.display = 'none';
		document.getElementById(newID_Show_ContentInputType).style.display = 'none';
		document.getElementById(newID_Hidden_ContentInputType).style = 'display:none; float:left;';
		document.getElementById(newID_Show_ContentInputOption).style.display = 'none';
		document.getElementById(newID_Hidden_ContentInputOption).style.display = 'none';
		document.getElementById(newID_ContentTitle).innerHTML = 'Note: <input type="text" name="Column_Note_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Note_'+ arrID[2] + '_' + arrID[3] +'" style="text-align:center;" placeholder="Note">';
		document.getElementById(newID_cell).className = '';
		document.getElementById(newID_Old_Type).value = value;
		document.getElementById(newID_Old_InputType).value = '';
	}else if(value=='input' && value!=old_Type){
		document.getElementById(newID_ContentTitle).innerHTML = '';
		document.getElementById(newID_Sample).innerHTML = '';
		document.getElementById(newID_ContentInputOption).innerHTML = '';
		document.getElementById(newID_ContentType).style = 'display:none';
		document.getElementById(newID_ContentInputType).style = 'display:inline';
		document.getElementById(newID_Show_ContentType).style = 'display:inline';
		document.getElementById(newID_Hidden_ContentType).style = 'display:none';
		document.getElementById(newID_Show_ContentInputType).style = 'display:none';
		document.getElementById(newID_Hidden_ContentInputType).style = 'display:inline; float:left;';
		document.getElementById(newID_Show_ContentInputOption).style = 'display:none';
		document.getElementById(newID_Hidden_ContentInputOption).style = 'display:none';
		document.getElementById(newID_ContentInputType).innerHTML = 'Input Type: \
		<select name="Column_InputType_'+ arrID[2] + '_' + arrID[3] +'" id="Column_InputType_'+ arrID[2] + '_' + arrID[3] +'" onclick="Column_InputType_change(this.id);">\
		<option value=""></option>\
		<option value="text">Text</option>\
		<option value="textarea">Text Area</option>\
		<option value="date">Date</option>\
		<option value="number">Number</option>\
		<option value="select">Select</option>\
		<option value="draw_option">Button</option>\
		<option value="draw_checkbox">CheckBox</option>\
		</select>';
		document.getElementById(newID_cell).className = '';
		document.getElementById(newID_Old_Type).value = value;
		document.getElementById(newID_Old_InputType).value = '';
	}
}
function Column_InputType_change(id){
	var ID = id;
	var arrID = ID.split('_');
	var newID_InputType = id;
	var newID_ContentInputOption = 'Column_ContentInputOption_'+ arrID[2] + '_' + arrID[3];
	var newID_Sample = 'Column_Sample_' + arrID[2] + '_' + arrID[3];
	var newID_Show_ContentInputOption = 'Button_ShowContentInputOption_' + arrID[2] + '_' + arrID[3];
	var newID_Hidden_ContentInputOption = 'Button_HiddenContentInputOption_' + arrID[2] + '_' + arrID[3];
	var newID_Old_InputType = 'Old_InputType_' + arrID[2] + '_' + arrID[3];
	var old_InputType = document.getElementById(newID_Old_InputType).value;
	var value = document.getElementById(newID_InputType).value;
	if(value=='' && value!=old_InputType){
		document.getElementById(newID_Show_ContentInputOption).style = 'display:none';
		document.getElementById(newID_Hidden_ContentInputOption).style = 'display:none';
		document.getElementById(newID_Sample).innerHTML = '';
		document.getElementById(newID_ContentInputOption).innerHTML = '';
		document.getElementById(newID_Old_InputType).value = value;
	}else if(value=='text' && value!=old_InputType){
		document.getElementById(newID_Show_ContentInputOption).style = 'display:none';
		document.getElementById(newID_Hidden_ContentInputOption).style = 'display:inline';
		document.getElementById(newID_Sample).innerHTML = 'Sample:<br><input type="text" size="15">';
		document.getElementById(newID_ContentInputOption).innerHTML = '\
		Size: <input type="number" min="1" style="text-align:center; width:60px;" name="Column_Size_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Size_'+ arrID[2] + '_' + arrID[3] +'" value="15"><br>\
		Note 1: <input type="text" name="Column_Note1_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Note1_'+ arrID[2] + '_' + arrID[3] +'" style="text-align:center;" placeholder="Note 1" value=""><br>\
		Note 2: <input type="text" name="Column_Note2_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Note2_'+ arrID[2] + '_' + arrID[3] +'" style="text-align:center;" placeholder="Note 2" value=""><br>\
		<input type="button" id="Button_SetTextSize_'+ arrID[2] + '_' + arrID[3] +'" onclick="SetSize_Text(this.id);" value="Set">';
		document.getElementById(newID_Old_InputType).value = value;
	}else if(value=='textarea' && value!=old_InputType){
		document.getElementById(newID_Show_ContentInputOption).style = 'display:none';
		document.getElementById(newID_Hidden_ContentInputOption).style = 'display:inline';
		document.getElementById(newID_Sample).innerHTML = 'Sample:<br><textarea style="width:200px; height:60px;"></textarea>';
		document.getElementById(newID_ContentInputOption).innerHTML = '\
		Width: <input type="number" min="1" style="text-align:center; width:60px;" name="Temp_Width_'+ arrID[2] + '_' + arrID[3] +'" id="Temp_Width_'+ arrID[2] + '_' + arrID[3] +'" value="200"><br>\
		Height: <input type="number" min="1" style="text-align:center; width:60px;" name="Temp_Height_'+ arrID[2] + '_' + arrID[3] +'" id="Temp_Height_'+ arrID[2] + '_' + arrID[3] +'" value="60"><br>\
		<input type="hidden" name="Column_Size_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Size_'+ arrID[2] + '_' + arrID[3] +'" value="200_60">\
		Note 1: <input type="text" name="Column_Note1_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Note1_'+ arrID[2] + '_' + arrID[3] +'" style="text-align:center;" placeholder="Note 1" value=""><br>\
		Note 2: <input type="text" name="Column_Note2_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Note2_'+ arrID[2] + '_' + arrID[3] +'" style="text-align:center;" placeholder="Note 2" value=""><br>\
		<input type="button" id="Button_SetTextareaSize_'+ arrID[2] + '_' + arrID[3] +'" onclick="SetSize_Textarea(this.id);" value="Set">';
		document.getElementById(newID_Old_InputType).value = value;
	}else if(value=='date' && value!=old_InputType){
		document.getElementById(newID_Show_ContentInputOption).style = 'display:none';
		document.getElementById(newID_Hidden_ContentInputOption).style = 'display:none';
		document.getElementById(newID_Sample).innerHTML = 'Sample:<br><input type="date">';
		/*
		document.getElementById(newID_Sample).innerHTML = 'Sample: \
		<script> $(function() { $( "#Sample_date_'+ arrID[2] + '_' + arrID[3] +'").datetimepicker({format:\'Y/m/d\', timepicker: false, mask: true}); }); <\/script> \
		<input type="text" name="Sample_date_'+ arrID[2] + '_' + arrID[3] +'" id="Sample_date_'+ arrID[2] + '_' + arrID[3] +'" value="2016/01/01" size="12">';
		*/
		document.getElementById(newID_ContentInputOption).innerHTML = 'Note 1: <input type="text" name="Column_Note1_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Note1_'+ arrID[2] + '_' + arrID[3] +'" style="text-align:center;" placeholder="Note 1" value=""><br>\
		Note 2: <input type="text" name="Column_Note2_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Note2_'+ arrID[2] + '_' + arrID[3] +'" style="text-align:center;" placeholder="Note 2" value=""><br>\
		<input type="button" id="Button_SetDateNote_'+ arrID[2] + '_' + arrID[3] +'" onclick="SetNote_Date(this.id);" value="Set">';
		document.getElementById(newID_Old_InputType).value = value;
	}else if(value=='number' && value!=old_InputType){
		document.getElementById(newID_Show_ContentInputOption).style = 'display:none';
		document.getElementById(newID_Hidden_ContentInputOption).style = 'display:none';
		document.getElementById(newID_Sample).innerHTML = 'Sample:<br><input type="number">';
		document.getElementById(newID_ContentInputOption).innerHTML = 'Note 1: <input type="text" name="Column_Note1_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Note1_'+ arrID[2] + '_' + arrID[3] +'" style="text-align:center;" placeholder="Note 1" value=""><br>\
		Note 2: <input type="text" name="Column_Note2_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Note2_'+ arrID[2] + '_' + arrID[3] +'" style="text-align:center;" placeholder="Note 2" value=""><br>\
		<input type="button" id="Button_SetNumberNote_'+ arrID[2] + '_' + arrID[3] +'" onclick="SetNote_Number(this.id);" value="Set">';
		document.getElementById(newID_Old_InputType).value = value;
	}else if(value=='select' && value!=old_InputType){
		document.getElementById(newID_Show_ContentInputOption).style = 'display:none';
		document.getElementById(newID_Hidden_ContentInputOption).style = 'display:inline';
		document.getElementById(newID_Sample).innerHTML = 'Sample:<br>\
		<select>\
		<option value=""></option>\
		<option value="">1</option>\
		<option value="">2</option>\
		<option value="">3</option>\
		</select>';
		document.getElementById(newID_ContentInputOption).innerHTML = 'Option: <input type="text" name="Column_InputOption_'+ arrID[2] + '_' + arrID[3] +'" id="Column_InputOption_'+ arrID[2] + '_' + arrID[3] +'" style="text-align:center;" placeholder="( ex: 1;2;3 )"><br>\
		Other: <select name="Column_Other_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Other_'+ arrID[2] + '_' + arrID[3] +'"><option value="0">None</option><option value="1">Has</option></select><br>\
		(Size: <input type="number" min="1" style="text-align:center; width:60px;" name="Column_OtherSize_'+ arrID[2] + '_' + arrID[3] +'" id="Column_OtherSize_'+ arrID[2] + '_' + arrID[3] +'" value="15">)<br>\
		Note 1: <input type="text" name="Column_Note1_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Note1_'+ arrID[2] + '_' + arrID[3] +'" style="text-align:center;" placeholder="Note 1" value=""><br>\
		Note 2: <input type="text" name="Column_Note2_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Note2_'+ arrID[2] + '_' + arrID[3] +'" style="text-align:center;" placeholder="Note 2" value=""><br>\
		<input type="button" id="Button_SetOption_'+ arrID[2] + '_' + arrID[3] +'" onclick="SetOption_Select(this.id);" value="Set">';
		document.getElementById(newID_Old_InputType).value = value;
	}else if(value=='draw_option' && value!=old_InputType){
		document.getElementById(newID_Show_ContentInputOption).style = 'display:none';
		document.getElementById(newID_Hidden_ContentInputOption).style = 'display:inline';
		var Sample_Button ='';
		var Sample_Option = '1;2;3';
		var arrSample_Option = Sample_Option.split(';');
		for(var i=0;i<arrSample_Option.length;i++){
			if(i==0){ var pos = 'left'; }
			if(i==1){ var pos = 'middle'; }
			if(i==2){ var pos = 'right'; }
			Sample_Button = Sample_Button + '<input type="hidden" name="Sample'+ arrID[2] + 'n' + arrID[3] + '_' + eval(i+1) +'" id="Sample'+ arrID[2] + 'n' + arrID[3] + '_' + eval(i+1) +'" value="0">';
			Sample_Button = Sample_Button + '<button type="button" name="btn_Sample'+ arrID[2] + 'n' + arrID[3] + '_' + eval(i+1) +'" id="btn_Sample'+ arrID[2] + 'n' + arrID[3] + '_' + eval(i+1) +'" class="tabbtn_s_'+ pos +'_off" onclick="click_multi_btn2(this.id,\''+ pos +'\',\'s\',\'Sample'+ arrID[2] + 'n' + arrID[3] +'\',\''+ arrSample_Option.length +'\');">'+ arrSample_Option[i] +'</button>';
		}
		document.getElementById(newID_Sample).innerHTML = 'Sample:<br>'+ Sample_Button;
		document.getElementById(newID_ContentInputOption).innerHTML = 'Option: <input type="text" name="Column_InputOption_'+ arrID[2] + '_' + arrID[3] +'" id="Column_InputOption_'+ arrID[2] + '_' + arrID[3] +'" style="text-align:center;" placeholder="( ex: 1;2;3 )"><br>\
		Button(s) per line: <input type="number" name="Column_LineFeed_'+ arrID[2] + '_' + arrID[3] +'" id="Column_LineFeed_'+ arrID[2] + '_' + arrID[3] +'" style="text-align:center; width:60px;" min="0" value="0"><br>\
		Choice: <select name="Column_Choice_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Choice_'+ arrID[2] + '_' + arrID[3] +'"><option value="multi">Multiple</option><option value="single">Single</option></select><br>\
		Size: <select name="Column_Size_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Size_'+ arrID[2] + '_' + arrID[3] +'">\
		<option value="ss">1</option>\
		<option value="s" selected="selected">2</option>\
		<option value="xs">3</option>\
		<option value="sm">4</option>\
		<option value="m">5</option>\
		<option value="xm">6</option>\
		<option value="sl">7</option>\
		<option value="l">8</option>\
		<option value="xl">9</option>\
		<option value="xxl">10</option>\
		<option value="xxxl">11</option>\
		<option value="xxxxl">12</option>\
		<option value="xxxxxl">13</option>\
		</select><br>\
		Other: <select name="Column_Other_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Other_'+ arrID[2] + '_' + arrID[3] +'"><option value="0">None</option><option value="1">Has</option></select><br>\
		(Size: <input type="number" min="1" style="text-align:center; width:60px;" name="Column_OtherSize_'+ arrID[2] + '_' + arrID[3] +'" id="Column_OtherSize_'+ arrID[2] + '_' + arrID[3] +'" value="15">)<br>\
		Note 1: <input type="text" name="Column_Note1_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Note1_'+ arrID[2] + '_' + arrID[3] +'" style="text-align:center;" placeholder="Note 1" value=""><br>\
		Note 2: <input type="text" name="Column_Note2_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Note2_'+ arrID[2] + '_' + arrID[3] +'" style="text-align:center;" placeholder="Note 2" value=""><br>\
		<input type="button" id="Button_SetOption_'+ arrID[2] + '_' + arrID[3] +'" onclick="SetOption_Button(this.id);" value="Set">';
		document.getElementById(newID_Old_InputType).value = value;
	}else if(value=='draw_checkbox' && value!=old_InputType){
		document.getElementById(newID_Show_ContentInputOption).style = 'display:none';
		document.getElementById(newID_Hidden_ContentInputOption).style = 'display:inline';
		var Sample_CheckBox ='';
		var Sample_Option = '1;2;3';
		var arrSample_Option = Sample_Option.split(';');
		for(var i=0;i<arrSample_Option.length;i++){
			Sample_CheckBox = Sample_CheckBox + '<tr>';
			Sample_CheckBox = Sample_CheckBox + '<input type="hidden" name="Sample'+ arrID[2] + 'n' + arrID[3] + '_' + eval(i+1) +'" id="Sample'+ arrID[2] + 'n' + arrID[3] + '_' + eval(i+1) +'" value="1">';
			Sample_CheckBox = Sample_CheckBox + '<td width="40">';
			Sample_CheckBox = Sample_CheckBox + '<button type="button" class="checkbox_off" onclick="click_multi_checkbox2(this.id,\'Sample'+ arrID[2] + 'n' + arrID[3] +'\',\''+ arrSample_Option.length +'\');" id="btn_Sample'+ arrID[2] + 'n' + arrID[3] + '_' + eval(i+1) +'"><font style="color:white;">✔</font></button>';
			Sample_CheckBox = Sample_CheckBox + '</td>';
			Sample_CheckBox = Sample_CheckBox + '<td> '+ arrSample_Option[i] +'</td>';
			Sample_CheckBox = Sample_CheckBox + '</tr><br>';
		}
		document.getElementById(newID_Sample).innerHTML = 'Sample:<br>'+ Sample_CheckBox;
		document.getElementById(newID_ContentInputOption).innerHTML = 'Option: <input type="text" name="Column_InputOption_'+ arrID[2] + '_' + arrID[3] +'" id="Column_InputOption_'+ arrID[2] + '_' + arrID[3] +'" style="text-align:center;" placeholder="( ex: 1;2;3 )"><br>\
		Choice: <select name="Column_Choice_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Choice_'+ arrID[2] + '_' + arrID[3] +'"><option value="multi">Multiple</option><option value="single">Single</option></select><br>\
		Style: <select name="Column_LineFeed_'+ arrID[2] + '_' + arrID[3] +'" id="Column_LineFeed_'+ arrID[2] + '_' + arrID[3] +'"><option value="0">A</option><option value="1" selected="selected">B</option><option value="2">C</option></select><br>\
		Other: <select name="Column_Other_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Other_'+ arrID[2] + '_' + arrID[3] +'"><option value="0">None</option><option value="1">Has</option></select><br>\
		(Size: <input type="number" min="1" style="text-align:center; width:60px;" name="Column_OtherSize_'+ arrID[2] + '_' + arrID[3] +'" id="Column_OtherSize_'+ arrID[2] + '_' + arrID[3] +'" value="15">)<br>\
		Note 1: <input type="text" name="Column_Note1_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Note1_'+ arrID[2] + '_' + arrID[3] +'" style="text-align:center;" placeholder="Note 1" value=""><br>\
		Note 2: <input type="text" name="Column_Note2_'+ arrID[2] + '_' + arrID[3] +'" id="Column_Note2_'+ arrID[2] + '_' + arrID[3] +'" style="text-align:center;" placeholder="Note 2" value=""><br>\
		<input type="button" id="Button_SetOption_'+ arrID[2] + '_' + arrID[3] +'" onclick="SetOption_CheckBox(this.id);" value="Set">';
		document.getElementById(newID_Old_InputType).value = value;
	}else if(value=='image' && value!=old_InputType){
		document.getElementById(newID_Show_ContentInputOption).style = 'display:none';
		document.getElementById(newID_Hidden_ContentInputOption).style = 'display:inline';
		document.getElementById(newID_Sample).innerHTML = 'Sample:<br>Image';
		document.getElementById(newID_ContentInputOption).innerHTML = '';
		document.getElementById(newID_Old_InputType).value = value;
	}
}
</script>