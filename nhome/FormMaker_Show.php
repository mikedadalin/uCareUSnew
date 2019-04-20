<?php
if(isset($_GET['id'])){
	$db = new DB;
	$db->query("SELECT * FROM `formmaker_list` WHERE `formID`='".mysql_escape_string($_GET['id'])."'");
	if($db->num_rows()>0){
		$r = $db->fetch_assoc();
		if($r['Enable']=="1" && isset($_GET['mod'])){
			if(strlen((int)$r['formID'])==1){
				$tableName = 'fmform0'.$r['formID'];
			}else{
				$tableName = 'fmform'.$r['formID'];
			}
			$db4 = new DB;
			if($_GET['date']!=""){
				$db4->query("SELECT * FROM `".$tableName."` WHERE `HospNo`='".getHospNo($_GET['pid'])."' AND `date`='".mysql_escape_string($_GET['date'])."' ORDER BY `date` DESC LIMIT 0,1");
			}else{
				$db4->query("SELECT * FROM `".$tableName."` WHERE `HospNo`='".getHospNo($_GET['pid'])."' ORDER BY `date` DESC LIMIT 0,1");
			}
			if($db4->num_rows()>0){
				$r4 = $db4->fetch_assoc();
				foreach ($r4 as $k=>$v) {
					if($k=="date"){ $v = str_replace("-","",$v); }
					if(substr($k,0,1)=="Q"){
						$arrAnswer = explode("_",$k);
						if(count($arrAnswer)==2){
							if($v==1){
								${$arrAnswer[0]} .= $arrAnswer[1].';';
							}
						}else{
							${$k} = $v;
						}
					}else{
						${$k} = $v;
					}
				}
			}
		}
		$db2 = new DB;
		$db2->query("SELECT * FROM `formmaker_set` WHERE `formID`='".$r['formID']."' ORDER BY `row` ASC,`cell` ASC");
		if($db2->num_rows()>0){
			echo '<div style="background-color:rgba(255,255,255,0.7); padding:20px;">';
			if(!isset($_GET['mod'])){
				echo '<table><tr><td>';
				echo '<form><input type="button" onclick="location.href=\'index.php?func=FormMaker_List&bk='.$_GET['bk'].'\'" value="Back To List"></form>';
				echo '</td></tr></table>';
			}
			echo '<div class="nurseform-table">';
			echo '<h3>'.$r['FormName'].'</h3>';
			echo '<center>';
			if(!isset($_GET['mod'])){
				echo '<form method="post" action="">';
			}else{
				echo '<form method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save" style="width:100%">';
			}
			echo '<table>';
			for($i=0;$i<$r['row'];$i++){
				echo '<tr align="left">';
				$db3 = new DB;
				$db3->query("SELECT * FROM `formmaker_set` WHERE `formID`='".$r['formID']."' AND `row`='".$i."' ORDER BY `cell` ASC");
				for($j=0;$j<$db3->num_rows();$j++){
					$r3 = $db3->fetch_assoc();
					if($i==0){ ${'Width_'.$r3['cell']} = ' style="width:'.$r3['Width'].'px;"'; }
					if($r3['Colspan']!=''){
						$Colspan = ' colspan="'.$r3['Colspan'].'"';
						if($r3['Type']=="title"){
							echo '<td class="title"'.$Colspan.${'Width_'.$r3['cell']}.'>';
							echo $r3['Title'];
							echo '</td>';
						}elseif($r3['Type']=="item"){
							echo '<td class="title_s"'.$Colspan.${'Width_'.$r3['cell']}.'>';
							echo $r3['Item'];
							echo '</td>';
						}elseif($r3['Type']=="note"){
							echo '<td '.$Colspan.${'Width_'.$r3['cell']}.'>';
							echo $r3['Note'];
							echo '</td>';
						}else{
							echo '<td'.$Colspan.${'Width_'.$r3['cell']}.'>';
							if($r3['InputType']=="text"){
								echo '<input type="text" size="'.$r3['Size'].'" name="Qr'.$i.'c'.$r3['cell'].'" id="Qr'.$i.'c'.$r3['cell'].'" value="'.${'Qr'.$i.'c'.$r3['cell']}.'">';
								if($r3['Note1']!=""){ echo ' '.$r3['Note1']; }
								if($r3['Note2']!=""){ echo '<br>'.$r3['Note2']; }
							}elseif($r3['InputType']=="textarea"){
								$arr_Textarea_Size = explode("_",$r3['Size']);
								echo '<textarea style="width:'.$arr_Textarea_Size[0].'px; height:'.$arr_Textarea_Size[1].'px;" name="Qr'.$i.'c'.$r3['cell'].'" id="Qr'.$i.'c'.$r3['cell'].'" value="'.${'Qr'.$i.'c'.$r3['cell']}.'"></textarea>';
								if($r3['Note1']!=""){ echo ' '.$r3['Note1']; }
								if($r3['Note2']!=""){ echo '<br>'.$r3['Note2']; }
							}elseif($r3['InputType']=="date"){
								${'Qr'.$i.'c'.$r3['cell']} = formatdate_Ymd(${'Qr'.$i.'c'.$r3['cell']});
								echo '<script> $(function() { $( "#Qr'.$i.'c'.$r3['cell'].'").datetimepicker({format:\'Y/m/d\', timepicker: false, mask: true}); }); </script>';
								echo '<input type="text" name="Qr'.$i.'c'.$r3['cell'].'" id="Qr'.$i.'c'.$r3['cell'].'" value="'.formatdate(${'Qr'.$i.'c'.$r3['cell']}).'" size="8">';
								if($r3['Note1']!=""){ echo ' '.$r3['Note1']; }
								if($r3['Note2']!=""){ echo '<br>'.$r3['Note2']; }
							}elseif($r3['InputType']=="number"){
								echo '<input type="number" name="Qr'.$i.'c'.$r3['cell'].'" id="Qr'.$i.'c'.$r3['cell'].'" style="text-align:center; width:90px;" value="'.${'Qr'.$i.'c'.$r3['cell']}.'">';
								if($r3['Note1']!=""){ echo ' '.$r3['Note1']; }
								if($r3['Note2']!=""){ echo '<br>'.$r3['Note2']; }
							}elseif($r3['InputType']=="select"){
								$arrOption = explode(";",$r3['InputOption']);
								echo '<select name="Qr'.$i.'c'.$r3['cell'].'" id="Qr'.$i.'c'.$r3['cell'].'">';
								echo '<option></option>';
								for($z=0;$z<count($arrOption);$z++){
									echo '<option value="'.$arrOption[$z].'"';
									if(${'Qr'.$i.'c'.$r3['cell']}==$arrOption[$z]){ echo ' selected="selected"'; }
									echo '>'.$arrOption[$z].'</option>';
								}
								echo '</select>';
								if($r3['Other']=="1"){ echo ' <input type="text" size="'.$r3['OtherSize'].'" name="Qr'.$i.'c'.$r3['cell'].'zOther" id="Qr'.$i.'c'.$r3['cell'].'zOther" style="text-align:center;" placeholder="Other" value="'.${'Qr'.$i.'c'.$r3['cell'].'zOther'}.'">'; }
								if($r3['Note1']!=""){ echo ' '.$r3['Note1']; }
								if($r3['Note2']!=""){ echo '<br>'.$r3['Note2']; }
							}elseif($r3['InputType']=="draw_option"){
								if($r3['LineFeed']>0){
									$br = "true";
								}else{
									$br = "false";
								}
								echo draw_option('Qr'.$i.'c'.$r3['cell'],$r3['InputOption'],$r3['Size'],$r3['Choice'],${'Qr'.$i.'c'.$r3['cell']},$br,$r3['LineFeed']);
								if($r3['Other']=="1"){ echo ' <input type="text" size="'.$r3['OtherSize'].'" name="Qr'.$i.'c'.$r3['cell'].'zOther" id="Qr'.$i.'c'.$r3['cell'].'zOther" style="text-align:center;" placeholder="Other" value="'.${'Qr'.$i.'c'.$r3['cell'].'zOther'}.'">'; }
								if($r3['Note1']!=""){ echo ' '.$r3['Note1']; }
								if($r3['Note2']!=""){ echo '<br>'.$r3['Note2']; }
							}elseif($r3['InputType']=="draw_checkbox"){
								if($r3['LineFeed']=="0"){ echo draw_checkbox_nobr('Qr'.$i.'c'.$r3['cell'],$r3['InputOption'],${'Qr'.$i.'c'.$r3['cell']},$r3['Choice']); }
								if($r3['LineFeed']=="1"){ echo draw_checkbox('Qr'.$i.'c'.$r3['cell'],$r3['InputOption'],${'Qr'.$i.'c'.$r3['cell']},$r3['Choice']); }
								if($r3['LineFeed']=="2"){ echo draw_checkbox_2col('Qr'.$i.'c'.$r3['cell'],$r3['InputOption'],${'Qr'.$i.'c'.$r3['cell']},$r3['Choice']); }
								if($r3['Other']=="1"){ echo ' <input type="text" size="'.$r3['OtherSize'].'" name="Qr'.$i.'c'.$r3['cell'].'zOther" id="Qr'.$i.'c'.$r3['cell'].'zOther" style="text-align:center;" placeholder="Other" value="'.${'Qr'.$i.'c'.$r3['cell'].'zOther'}.'">'; }
								if($r3['Note1']!=""){ echo ' '.$r3['Note1']; }
								if($r3['Note2']!=""){ echo '<br>'.$r3['Note2']; }
							}else{}
							echo '</td>';
						}
					}
				}
				echo '</tr>';
			}
			echo '</table>';
			echo '<table><tr>';
			echo '<td style="background:#ffffff;" align="left">';
			echo 'Filled date： ';
			echo '<script> $(function() { $( "#date").datetimepicker({format:\'Y/m/d\', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="'.formatdate($date).'" size="12">';
			echo '<input type="button" value="Today" onclick="inputdate(\'date\');" />';
			echo '</td>';
			echo '<td style="background:#ffffff;" align="right">';
			echo 'Filled by:';
			if($Qfiller==NULL){ echo checkusername($_SESSION['ncareID_lwj']); }else{ echo checkusername($Qfiller); }
			echo '</td>';
			echo '</tr></table>';
			echo '<center><input type="hidden" name="formID" id="formID" value="'.$tableName.'" /><input type="hidden" name="HospNo" id="HospNo" value="'.$HospNo.'" /><button type="submit" id="submit_'.$_GET['id'].'" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('.$_GET['id'].');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>';
			echo '</form>';
			echo '</center>';
			echo '</div>';
			echo '</div>';
		}
		if($r4){
			foreach($r4 as $k=>$v){
				if(substr($k,0,1)=="Q"){
					$arrAnswer = explode("_",$k);
					if(count($arrAnswer)==2){
						if($v==1){
							${$arrAnswer[0]} = "";
						}
					}else{
						${$k} = "";
					}
				}else{
					${$k} = "";
				}
			}			
		}
	}
}
?>