<script type="text/javascript" src="js/LWJ_tabs.js"></script>
<h3>Nursing record</h3>
<?php
if (@$_GET['nID']==NULL) {
	$sql1 = "SELECT * FROM `nurseform05` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
	$time="";
} else {
	$sql1 = "SELECT * FROM `nurseform05` WHERE `nID`='".mysql_escape_string($_GET['nID'])."'";
	$db1->query($sql1);
	$r1 = $db1->fetch_assoc();
	if ($db1->num_rows()>0) {
		foreach ($r1 as $k=>$v) {
			if (substr($k,0,1)=="Q") {
				$arrAnswer = explode("_",$k);
				if (count($arrAnswer)==2) {
					if ($v==1) {
						${$arrAnswer[0]} .= $arrAnswer[1].';';
					}
				} else {
					${$k} = $v;
				}
			}  else {
				${$k} = $v;
			}
		}
	}
}
	$validate = "";
?>
    <div class="content-query">
    <form action="index.php?func=databaseAI" method="post" id="base">
    <table width="100%">
      <tr>
        <td class="title" width="120">Date</td>
        <td><script>$(function() { $('#date').datepicker(); });</script>
		<input type="text" name="date" id="date" value="<?php echo ($date!=""?formatdate($date):date("Y/m/d")); ?>" size="12" <?php echo $validate;?>> <input type="text" name="time" id="time" size="4" value="<?php echo ($time!=""?$time:date("Hi")); ?>" /></td>
      </tr>
      <tr>
        <td class="title">Focus / problems (No.)</td>
        <td>
        <select onchange="if (this.selectedIndex==0) { document.getElementById('Q2').value = ''; } else { document.getElementById('Q2').value = this.value; }" >
	     <option>(Choose nursing diagnosis has been filled, or at the bottom to fill nursing problems ...)</option>
			<?php
			for ($i=1;$i<=28;$i++) {
				if (strlen($i)==1) { $num = '0'.$i; } else { $num = $i; }
				$db1 = new DB;
				$db1->query("SELECT * FROM `nursediag".$num."` WHERE `HospNo`='".$HospNo."' AND `Q2`=''");
				if ($db1->num_rows()>0) {
					echo '<option value="'.$i.'# '.$arrNursediag[$i].'">'.$i.'# '.$arrNursediag[$i].'</option>'."\n";
				}
			}
			?>
	    </select>
        <br><input type="text" name="Q2" id="Q2" size="40" value="<?php echo $Q2; ?>" />
        </td>
      </tr>
      <tr>
        <td class="title">Record content</td>
        <td>
        <div id="tabs" style="background:rgba(0,0,0,0.1); width:100%;">
          <ul>
            <li><a href="#tabs-1">Symbol</a></li>
            <li><a href="#tabs-2">Unit</a></li>
            <li><a href="#tabs-3">Professional terms</a></li>
            <li><a href="#tabs-5">Vital sign</a></li>
            <li><a href="#tabs-6">Current medication</a></li>
            <li><a href="#tabs-4">Custom terms</a></li>
            <li><a href="#tabs-7">History</a></li>
          </ul>
          <div id="tabs-1">
          <input type="button" value="、" onclick="addtotextarea('Qcontent', '、')" />
          <input type="button" value="，" onclick="addtotextarea('Qcontent', '，')" />
          <input type="button" value="。" onclick="addtotextarea('Qcontent', '。')" />
          <input type="button" value="&ge;" onclick="addtotextarea('Qcontent', '&ge;')" />
          <input type="button" value="&le;" onclick="addtotextarea('Qcontent', '&le;')" />
          <input type="button" value="&ordm;F" onclick="addtotextarea('Qcontent', '&ordm;F')" />
          <input type="button" value="&mdash;" onclick="addtotextarea('Qcontent', '&mdash;')" />
          <input type="button" value="&plusmn;" onclick="addtotextarea('Qcontent', '&plusmn;')" />
          <input type="button" value="#" onclick="addtotextarea('Qcontent', '#')" />
          <input type="button" value="%" onclick="addtotextarea('Qcontent', '&#037;')" />
          <input type="button" value="L/min" onclick="addtotextarea('Qcontent', 'L/min')" />
          <input type="button" value="/day" onclick="addtotextarea('Qcontent', '/day')" />
          <input type="button" value="/hr" onclick="addtotextarea('Qcontent', '/hr')" />
          </div>
          <div id="tabs-2">
          <input type="button" value="mg/dl" onclick="addtotextarea('Qcontent', 'mg/dl')" />
          <input type="button" value="mmHg" onclick="addtotextarea('Qcontent', 'mmHg')" />
          <input type="button" value="ml" onclick="addtotextarea('Qcontent', 'ml')" />
          <input type="button" value="kcal" onclick="addtotextarea('Qcontent', 'kcal')" />
          </div>
          <div id="tabs-3">
          <input type="button" value="GCS:E M V " onclick="addtotextarea('Qcontent', 'GCS:E M V ')" />
          <input type="button" value="V/S " onclick="addtotextarea('Qcontent', 'V/S')" />
          <input type="button" value="Nasal tube" onclick="addtotextarea('Qcontent', 'Nasal tube')" />
          <input type="button" value="Oxygen mask" onclick="addtotextarea('Qcontent', 'Oxygen mask')" />
          <input type="button" value="Oxygen mask" onclick="addtotextarea('Qcontent', 'Oxygen mask')" />
          <input type="button" value="Sputum suction" onclick="addtotextarea('Qcontent', 'Sputum suction')" />
          <input type="button" value="Output" onclick="addtotextarea('Qcontent', 'Output')" />
          <input type="button" value="Input" onclick="addtotextarea('Qcontent', 'Input')" /><br />
          <input type="button" value="SpO2: " onclick="addtotextarea('Qcontent', 'SpO2: ')" />
          <input type="button" value="BP: " onclick="addtotextarea('Qcontent', 'BP: ')" />
          <input type="button" value="BS: " onclick="addtotextarea('Qcontent', 'BS: ')" />
          <input type="button" value="NG" onclick="addtotextarea('Qcontent', 'NG')" />
          <input type="button" value="Tr." onclick="addtotextarea('Qcontent', 'Tr.')" />
          <input type="button" value="Foley tube" onclick="addtotextarea('Qcontent', 'Foley tube')" />
          <input type="button" value="Foley bag" onclick="addtotextarea('Qcontent', 'Foley bag')" />
          <input type="button" value="F/U" onclick="addtotextarea('Qcontent', 'F/U')" />
          <input type="button" value="obs: " onclick="addtotextarea('Qcontent', 'obs: ')" />
          <input type="button" value="irrigation" onclick="addtotextarea('Qcontent', 'irrigation')" />
          </div>
          <div id="tabs-4">
          <?php
		  $db_phrase = new DB;
		  $db_phrase->query("SELECT * FROM `phrase` WHERE `userID`='".$_SESSION['ncareID_lwj']."' OR (`userID`!='".$_SESSION['ncareID_lwj']."' AND `public`='1') ORDER BY `userID`, `order` ASC");
		  if ($db_phrase->num_rows()==0) {
			  echo '請至右上角「系統設定」中的「片語管理」新增自訂片語';
		  } else {
			  echo '<select id="r_phrase" style="width:600px; overflow:hidden;">';
			  for ($phrasei=0;$phrasei<$db_phrase->num_rows();$phrasei++) {
				  $r_phrase = $db_phrase->fetch_assoc();
				  echo '<option value="'.$r_phrase['text'].'">'.$r_phrase['text'].'</option>'."\n";
			  }
			  echo '</select>
			  <input type="button" value="Substitute" onclick="addtotextarea(\'Qcontent\', $(\'#r_phrase\').val())" />';
		  }
		  ?>
          </div>
          <div id="tabs-5">
          <?php
		  /* 原V
		  $dbvital = new DB;
		  $dbvital->query("SELECT GROUP_CONCAT(CONCAT(`LoincCode`,'|',`Value`,'|',DATE_FORMAT(`RecordedTime`, '%Y-%m-%d %H:%i')) SEPARATOR ';') AS `vitalData` FROM `vitalsigns` WHERE `PersonID`='".($_GET['pid'])."' GROUP BY `RecordedTime` ORDER BY `RecordedTime` DESC LIMIT 0,8");
		  for ($i1=0;$i1<$dbvital->num_rows();$i1++) {
			  $rvital = $dbvital->fetch_assoc();
			  $vData = explode(';',$rvital['vitalData']);
			  for ($i2=0;$i2<count($vData);$i2++) {
				  $vData2 = explode('|',$vData[$i2]);
				  $vData3[$vData2[2]][$vData2[0]] = $vData2[1];
			  }
		  }
		  if (count($vData3)>0) {
			  foreach ($vData3 as $k2=>$v2) {
				  $output = "V/S: ";
				  $output .= $v2['8310-5'].' '; //T
				  $output .= $v2['8867-4'].' '; //P
				  $output .= $v2['9279-1'].' '; //R
				  $output .= $v2['8480-6'].'/'.$v2['8462-4'].'mmHg'; //BP
				  if ($output!="V/S:    /mmHg") {
					  echo $k2.' <input type="button" value="'.$output.'" onclick="addtotextarea(\'Qcontent\', \''.$output.'\')" /><br>'."\n";
				  }
			  }
		  }
		  */
		  // 新V START
		  $dbvital = new DB;
		  $dbvital->query("SELECT * FROM `vitalsign` WHERE `PatientID`='".($_GET['pid'])."' ORDER BY `date` DESC, `time` DESC LIMIT 0,8");
		  for ($i1=0;$i1<$dbvital->num_rows();$i1++) {
			  $rvital = $dbvital->fetch_assoc();
			  //$output = "V/S: ";
			  //$output .= $rvital['loinc_8310_5'].' '; //T
			  //$output .= $rvital['loinc_8867_4'].' '; //P
			  //$output .= $rvital['loinc_9279_1'].' '; //R
			  //$output .= $rvital['loinc_8480_6'].'/'.$rvital['loinc_8462_4'].'mmHg'; //BP
			  //if ($output!="V/S:    /mmHg") {
			  //    echo date("Y-m-d",strtotime($rvital['date']))." ".date("H:i",strtotime($rvital['time'])).' <input type="button" value="'.$output.'" onclick="addtotextarea(\'Qcontent\', \''.$output.'\')" /><br>'."\n";
			  //}
			  $output = "";
				  if ($rvital['loinc_8310_5'] >0){
				  	$output .= "BT: ".$rvital['loinc_8310_5'].'&ordm;C ';//T
				  }
				  if ($rvital['loinc_8867_4'] >0){
				  	$output .= ' PR:'.$rvital['loinc_8867_4'].'times/min '; //PR
				  }
				  if ($rvital['loinc_9279_1'] >0){
				  	$output .= ' RR:'.$rvital['loinc_9279_1'].'times/min '; //RR
				  }
				  if ($rvital['loinc_8480_6'] >0 || $rvital['loinc_8462_4'] >0){
				  	$output .= ' BP:'.$rvital['loinc_8480_6'].'/'.$rvital['loinc_8462_4'].'mmHg '; //BP
				  }
				  if ($rvital['loinc_2710_2'] >0){
				  	$output .= ' SpO2:'.$rvital['loinc_2710_2'].'%'; //BP
				  }
				  if ($output!="") {
					  echo date("Y-m-d",strtotime($rvital['date']))." ".date("H:i",strtotime($rvital['time'])).' <input type="button" value="'.$output.'" onclick="addtotextarea(\'Qcontent\', \''.$output.'\')" /><br>'."\n";
				  }
				  $output1 = "";
				  if ($rvital['loinc_14743_9'] >0){
					$output1 = "AC: ".$rvital['loinc_14743_9'].' '; //AC;
				  }
				  if ($rvital['loinc_15075_5'] >0){
					if ($rvital['loinc_14743_9'] >0){ $output1 .="/";}  
					$output1 .= "PC: ".$rvital['loinc_15075_5'].' '; //PC;
				  }
				  if ($output1 !="") {
					  echo date("Y-m-d",strtotime($rvital['date']))." ".date("H:i",strtotime($rvital['time'])).' <input type="button" value="'.$output1.'" onclick="addtotextarea(\'Qcontent\', \''.$output1.'\')" /><br>'."\n";
				  }
		  }
		  // 新V END
		  ?>
          </div>
          <div id="tabs-6">
          <?php
		  $db_med = new DB;
		  $db_med->query("SELECT * FROM `nurseform17` WHERE `HospNo`='".$HospNo."' ORDER BY `order` ASC");
		  if ($db_med->num_rows()>0) {
			  for ($i3=0;$i3<$db_med->num_rows();$i3++) {
				  $rmed = $db_med->fetch_assoc();
				  $output = $rmed['Qmedicine'].' '.$rmed['Qdose'].$rmed['Qdoseq'].' '.$rmed['Qusage'].' '.$rmed['Qfreq'];
				  echo '<input type="button" value="'.$output.'" onclick="addtotextarea(\'Qcontent\', \''.$output.'\')" />'."\n";
			  }
		  } else {
			  echo '---Currently no data---'; 
		  }
		  ?>
          </div>
          <div id="tabs-7">
          <?php
		  $db2 = new DB;
		  $db2->query("SELECT * FROM `nurseform05` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC, `nID` DESC LIMIT 0,6");
		  if ($db2->num_rows()>0) {
			  for ($i4=0;$i4<$db2->num_rows();$i4++) {
				  $r2 = $db2->fetch_assoc();
				  $output_history = '
				  <div style="border-bottom:1px dotted #000; font-size:11pt; line-height:24px;">
				  <div style="width:25%; display:inline-block;">'.formatdate($r2['date']).' '.substr($r2['time'],0,2).':'.substr($r2['time'],2,2).'</div>
				  <div style="width:65%; display:inline-block;">'.$r2['Qcontent'].'</div>
				  </div>'.$output_history;
			  }
			  echo $output_history;
		  } else {
			  echo '---Currently no data---'; 
		  }
		  ?>
          </div>
        </div>
        </td>
      </tr>
      <tr>
        <td class="title">Record content</td>
        <td>
        <textarea name="Qcontent" id="Qcontent" rows="10"><?php echo str_replace("\'","'",$Qcontent); ?></textarea><br>
        <input type="checkbox" name="writeToNurseform24" id="writeToNurseform24" value="1" onclick="checkForm24Type();"> Fill into "nursing shift":
        <select name="writeForm24Type" id="writeForm24Type">
          <option></option>
          <option value="0">Day shift</option>
          <option value="1">Night shift</option>
          <option value="2">Graveyard shift</option>
        </select>
        <script>
		function checkForm24Type() {
			if (document.getElementById('writeToNurseform24').checked) {
				$('#writeForm24Type').addClass('validate[required]');
			} else {
				$('#writeForm24Type').removeClass();
			}
		}
		</script>
        </td>
      </tr>
    </table>
    <div style="margin-top:20px">
    <input type="hidden" name="formID" id="formID" value="nurseform05" />
    <input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" />
    <input type="hidden" name="nID" id="nID" value="<?php echo $_GET['nID']; ?>" />
    <input type="hidden" name="action" id="action" value="<?php echo $_GET['action']; ?>" />
    <?php
	if ($_GET['action']=='delete') {
		?><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud_Delete" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-trash-o fa-2x"></i>Delete</button><?
	} elseif ($_GET['action']=='edit') {
		?><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-pencil fa-2x"></i>Edit</button><?
	} elseif ($_GET['action']=='new') {
		?><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><?
	}
	?>
	<button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
    </div>
    </form>
    </div>

<script>
function addtotextarea(field, text) {
	var pos = $('#Qcontent').caret();
	document.getElementById(field).value = document.getElementById('Qcontent').value;
	var txt = document.getElementById(field).value;
	var txt_part_1 = txt.substring(0, pos);
	var txt_part_2 = txt.substring(pos, txt.length);
	document.getElementById(field).value = txt_part_1+text+txt_part_2;
	$('#Qcontent').caret(pos+text.length);
}
$(function() {
	$("#base").validationEngine();
});
</script>