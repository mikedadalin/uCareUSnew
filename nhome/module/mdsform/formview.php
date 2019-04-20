<?php
$url = explode("/",$_SERVER['PHP_SELF']);
$db = new DB;
$db->query("SELECT `patientID`,`HospNo`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	$name = getPatientName($r['patientID']);
	$birth = formatdate($r['Birth']);
	$indate = formatdate($r1['indate']);
	$HospNo = $r['HospNo'];
	$bedID = $r1['bed'];
	$db2 = new DB;
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4`, `Qdiag5`, `Qdiag6`, `Qdiag7`, `Qdiag8` FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=8;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
	$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
}
$db_remind = new DB;
$db_remind->query("SELECT * FROM `reminder` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `remindDate` LIKE '".date('Y/m')."%' AND `active`='1'");
for ($i=0;$i<$db_remind->num_rows();$i++) {
	$reminder = $db_remind->fetch_assoc();
	if ($marqueetext != "") { $marqueetext .= ' ||| '; }
	$marqueetext .= '['.$reminder['remindDate'].'] '.$reminder['remindContent'];
}
?>

<div class="content-query2" ondblclick="closeResidentCol();">
<table align="center" style=" width:100%; font-size:10pt; margin: 0px 0px;">
  <tr id="backtr"  style="border:none; height:28px;" >
    <?php
	if (@$_GET['id']!=NULL) {
		if ($_SESSION['ncareGroup_lwj']!=4) {
			echo '<td class="backbtnn" align="center" width="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'">'.$word_Back.'</a></td>';
		} else {
			echo '<td class="backbtnn" align="center" bgcolor="#ffffff" width="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?func=medlist" style="font-size:14px;">Resident List</a></td>';
		}
	}else{
		if ($_SESSION['ncareGroup_lwj']!=4) {
			echo '<td class="backbtnn" align="center" width="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?func=patientlist" style="font-size:14px;">Resident List</a></td>';
		} else {
			echo '<td class="backbtnn" align="center" bgcolor="#ffffff" width="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?func=medlist" style="font-size:14px;">Resident List</a></td>';
		}
	}
	?>
    <td class="title" width="80" style="border-top-left-radius:10px; background-color:#EECB35;"><?php echo $word_Bed; ?></td>
    <td width="80" style="border:none; padding-left: 10px;"><?php echo $bedID; ?></td>
    <td class="title" width="60" style="border:none;"><?php echo $word_Name; ?></td>
    <td width="160" style="border:none; padding-left: 10px;"><?php echo $name; ?></td>
    <td class="title" width="70" style="border:none;"><?php echo $word_CareID; ?></td>
    <td width="90" style="border:none; padding-left: 10px;"><?php echo getHospNoDisplayByHospNo($HospNo); ?></td>
    <td width="100" class="title" style="border:none;"><?php echo $word_AdmissionDate; ?></td>
    <td width="80" style="border:none; padding-left: 10px;"><?php echo $indate; ?></td>    
    <td class="title" width="70" style="border:none;"><?php echo $word_DOB; ?></td>
    <td width="170" style="border-top-right-radius:10px; padding-left: 10px;"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
  </tr>
  <tr style="border:none; height:28px;" >  <!-- 診斷 + Jump to + 時間 + Print -->
    <?php
	if ($db_remind->num_rows()>0) {
		echo '
		<td class="title" style="background-color:#b79810;">'.$word_Diagnosis.'</td>
		<td style="padding-left: 10px;" colspan="9">'.$diagMsg.'</td>
		';
	}else{
		echo '<td class="title" style="background-color:#b79810; border-bottom-left-radius:10px;">'.$word_Diagnosis.'</td>';
		if(substr($url[3],0,5)!="print"){
			if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
				echo '
				<td style="=padding-left: 10px;" colspan="7">'.$diagMsg.'</td>
				<td style="border-bottom-right-radius:10px; padding-left: 5px;" colspan="2">';
				?><input class="residentListButton" type="button" onclick="$('#ResidentCol').show('slide', {direction: 'left'}, 500);" value="Resident List"><?php
	        	if (@$_GET['id']!=NULL) {
						echo '
						<select id="inputeddate" onchange="gotoselecteddate();" style="font-size:14px;">
						<option>Select date</option>';
	                	$db = new DB;
	                	$db->query("SELECT * FROM `mdsform99` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
	                	for ($i=0;$i<$db->num_rows();$i++) {
	   	                	$r = $db->fetch_assoc();
		                	echo '<option value="'.formatdate_Ymd($r['date']).'" >'.formatdate_Ymd_Slash($r['date']).'</option>';
	                	}
			        	echo '
						<option value="" >[New record]</option>
	                	</select>';
		    	}
				$db5 = new DB;
				$db5->query("SELECT `round` FROM `nurserounds` WHERE `HospNo`='".$HospNo."' AND `date`='".date(Ymd)."' AND `Qfiller`='".$_SESSION['ncareID_lwj']."'");
				if($db5->num_rows()>0){
					echo '&nbsp;<button id="CheckRound_OFF_'.$_GET['pid'].'"><i id="CheckRound_OFF_'.$_GET['pid'].'_icon" class="fa fa-check-square-o"></i></button>';
				}else{
					echo '&nbsp;<button id="CheckRound_ON_'.$_GET['pid'].'"><i id="CheckRound_ON_'.$_GET['pid'].'_icon" class="fa fa-square-o"></i></button>';
				}
				echo '</td>';
	    	}else{
				echo '<td style="border-bottom-right-radius:10px; padding-left: 10px;" colspan="9">'.$diagMsg.'</td>';
        	}
		}else{
			echo '<td style="border-bottom-right-radius:10px; padding-left: 10px;" colspan="9">'.$diagMsg.'</td>';
		}
	}
	?>
  </tr>
  <?php      /* 備忘錄 + Jump to + 時間 + Print */
  if ($db_remind->num_rows()>0) {
	  if(substr($url[3],0,5)!="print"){
		  if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
			  echo '
		      <tr class="printcol">
	            <td class="title" width="70" style="border:none; background-color:#e87217; border-bottom-left-radius:10px;">'.$word_Reminders.'</td>
	            <td style="border:none;" colspan="7"><marquee scrollamount="3">'.$marqueetext.'</marquee></td>
				<td style="border-bottom-right-radius:10px; padding-left: 5px;" colspan="2">';
				?><input class="residentListButton" type="button" onclick="$('#ResidentCol').show('slide', {direction: 'left'}, 500);" value="Resident List"><?php
	        	if (@$_GET['id']!=NULL) {
						echo '
						<select id="inputeddate" onchange="gotoselecteddate();" style="font-size:14px;">
						<option>Select date</option>';
	                	$db = new DB;
	                	$db->query("SELECT * FROM `mdsform99` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
	                	for ($i=0;$i<$db->num_rows();$i++) {
	   	                	$r = $db->fetch_assoc();
		                	echo '<option value="'.formatdate_Ymd($r['date']).'" >'.formatdate_Ymd_Slash($r['date']).'</option>';
	                	}
			        	echo '
						<option value="" >[New record]</option>
	                	</select>';
		    	}
				$db5 = new DB;
				$db5->query("SELECT `round` FROM `nurserounds` WHERE `HospNo`='".$HospNo."' AND `date`='".date(Ymd)."' AND `Qfiller`='".$_SESSION['ncareID_lwj']."'");
				if($db5->num_rows()>0){
					echo '&nbsp;<button id="CheckRound_OFF_'.$_GET['pid'].'"><i id="CheckRound_OFF_'.$_GET['pid'].'_icon" class="fa fa-check-square-o"></i></button>';
				}else{
					echo '&nbsp;<button id="CheckRound_ON_'.$_GET['pid'].'"><i id="CheckRound_ON_'.$_GET['pid'].'_icon" class="fa fa-square-o"></i></button>';
				}
			  echo '</td>';
		  }
	  }
  }
  ?>
</table>
</div>

<?php  /* 表單下移 */
    if($db_remind->num_rows()>0) {
	    echo '<div id="printbtn2" style="padding-top:108px;"></div>';
    }else{
	    echo '<div id="printbtn2" style="padding-top:74px;"></div>';
    }
?>

<table border="0" style="text-align:left; width:100%; background-color:rgba(255,255,255,0.8); border-top-left-radius:16px; border-top-right-radius:16px;">
  <tr>
    <td colspan="2">
	<?php
	   	 $formSection = array("SectionA", "SectionB", "SectionC", "SectionD", "SectionE", "SectionF", "SectionG", "SectionH", "SectionI", "SectionJ", "SectionK", "SectionL", "SectionM", "SectionN", "SectionO", "SectionP", "SectionQ", "SectionV", "SectionX", "SectionZ", "SectionS");
		 $formPage = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40", "41", "42", "43");
		 $formAlter = array("1-Alter", "2-Alter", "3-Alter", "4-Alter", "5-Alter", "6-Alter", "7-Alter", "8-Alter", "9-Alter", "10-Alter", "11-Alter", "12-Alter", "13-Alter", "14-Alter", "15-Alter", "16-Alter", "17-Alter", "18-Alter", "19-Alter", "20-Alter", "21-Alter", "22-Alter", "23-Alter", "24-Alter", "25-Alter", "26-Alter", "27-Alter", "28-Alter", "29-Alter", "30-Alter", "31-Alter", "32-Alter", "33-Alter", "34-Alter", "35-Alter", "36-Alter", "37-Alter", "38-Alter", "39-Alter", "40-Alter", "41-Alter", "42-Alter", "43-Alter");
		 if($_GET['id']=='99'){
			echo '<div><table><tr>';
			echo '<td><form><input type="button" value="Produce MDS" onclick="location.href=\'index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=ProduceMDSselect\'" /></form></td>';
			if($_GET['date']!=""){
				echo '<td><form><input type="button" value="XML" onclick="location.href=\'index.php?mod=mdsform&func=formview&id=MDSxml&pid='.$_GET['pid'].'&date='.$_GET['date'].'\'" /></form></td>';
			}
			echo '</tr></table></div>'; 
		 }elseif(@$_GET['id']=="MDS"){
			echo '<div><table><tr>';
		  /*echo '<td><form><input type="button" value="MDS Home" onclick="location.href=\'index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=99&date='.$_GET['date'].'\'" /></form></td>';
			echo '<td><form><a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank"><input type="button" value="Print"/></a></form></td>';
			echo '<td><form><input type="button" value="Delete" onclick="deleteMDScheck()" /></form></td>';      */
/*Home圖片*/echo '<td><a href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=99&date='.$_GET['date'].'"><img src="Images/MDSHome.png" border="0"></a></td>';
            echo '<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>';
/*Print圖片*/echo '<td align="right" style="border:none;" class="printcol"><a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank"><img src="Images/print.png" border="0"></a></td>';
            echo '<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>';
/*Delete圖片*/echo '<td><input type="image" src="Images/delete3.png" onclick="deleteMDScheck()" /></td>';
			echo '</tr><tr><td>&nbsp</td>';
			echo '</tr><tr><td>&nbsp</td>'; 
			echo '</tr></table></div>'; 
		 }elseif(in_array(@$_GET['id'],$formSection)){
			echo '<div><table><tr>';
		  /*echo '<td><form><input type="button" value="MDS Home" onclick="location.href=\'index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=99&date='.$_GET['date'].'\'" /></form></td>';
			echo '<td><form><a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank"><input type="button" value="Print"/></a></form></td>';  */
/*Home圖片*/echo '<td><a href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=99&date='.$_GET['date'].'"><img src="Images/MDSHome.png" border="0"></a></td>';
            echo '<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>';
/*Print圖片*/echo '<td><a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank"><img src="Images/print.png" border="0"></a></td>';
			echo '<td style="width:900px">&nbsp</td></tr><tr><td>&nbsp</td>';
			echo '</tr><tr><td colspan="4" style="text-align:center">';
			$SectionArray = array("SectionA","SectionB","SectionC","SectionD","SectionE","SectionF","SectionG","SectionH","SectionI","SectionJ","SectionK","SectionL","SectionM","SectionN","SectionO","SectionP","SectionQ","SectionV","SectionX","SectionZ","SectionS");
			echo '<b>Section:</b>&nbsp&nbsp&nbsp&nbsp';
			if($_GET['id']==$SectionArray[0]){ echo '<a style="color:#f33548"><b><u>A</u></b></a>&nbsp&nbsp&nbsp&nbsp';}else{ echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=SectionA&date='.$_GET['date'].'"><u>A</u></a>&nbsp&nbsp&nbsp&nbsp';}
			if($_GET['id']==$SectionArray[1]){ echo '<a style="color:#f33548"><b><u>B</u></b></a>&nbsp&nbsp&nbsp&nbsp';}else{ echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=SectionB&date='.$_GET['date'].'"><u>B</u></a>&nbsp&nbsp&nbsp&nbsp';}
			if($_GET['id']==$SectionArray[2]){ echo '<a style="color:#f33548"><b><u>C</u></b></a>&nbsp&nbsp&nbsp&nbsp';}else{ echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=SectionC&date='.$_GET['date'].'"><u>C</u></a>&nbsp&nbsp&nbsp&nbsp';}
			if($_GET['id']==$SectionArray[3]){ echo '<a style="color:#f33548"><b><u>D</u></b></a>&nbsp&nbsp&nbsp&nbsp';}else{ echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=SectionD&date='.$_GET['date'].'"><u>D</u></a>&nbsp&nbsp&nbsp&nbsp';}
			if($_GET['id']==$SectionArray[4]){ echo '<a style="color:#f33548"><b><u>E</u></b></a>&nbsp&nbsp&nbsp&nbsp';}else{ echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=SectionE&date='.$_GET['date'].'"><u>E</u></a>&nbsp&nbsp&nbsp&nbsp';}
			if($_GET['id']==$SectionArray[5]){ echo '<a style="color:#f33548"><b><u>F</u></b></a>&nbsp&nbsp&nbsp&nbsp';}else{ echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=SectionF&date='.$_GET['date'].'"><u>F</u></a>&nbsp&nbsp&nbsp&nbsp';}
			if($_GET['id']==$SectionArray[6]){ echo '<a style="color:#f33548"><b><u>G</u></b></a>&nbsp&nbsp&nbsp&nbsp';}else{ echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=SectionG&date='.$_GET['date'].'"><u>G</u></a>&nbsp&nbsp&nbsp&nbsp';}
			if($_GET['id']==$SectionArray[7]){ echo '<a style="color:#f33548"><b><u>H</u></b></a>&nbsp&nbsp&nbsp&nbsp';}else{ echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=SectionH&date='.$_GET['date'].'"><u>H</u></a>&nbsp&nbsp&nbsp&nbsp';}
			if($_GET['id']==$SectionArray[8]){ echo '<a style="color:#f33548"><b><u>I</u></b></a>&nbsp&nbsp&nbsp&nbsp';}else{ echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=SectionI&date='.$_GET['date'].'"><u>I</u></a>&nbsp&nbsp&nbsp&nbsp';}
			if($_GET['id']==$SectionArray[9]){ echo '<a style="color:#f33548"><b><u>J</u></b></a>&nbsp&nbsp&nbsp&nbsp';}else{ echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=SectionJ&date='.$_GET['date'].'"><u>J</u></a>&nbsp&nbsp&nbsp&nbsp';}
			if($_GET['id']==$SectionArray[10]){ echo '<a style="color:#f33548"><b><u>K</u></b></a>&nbsp&nbsp&nbsp&nbsp';}else{ echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=SectionK&date='.$_GET['date'].'"><u>K</u></a>&nbsp&nbsp&nbsp&nbsp';}
			if($_GET['id']==$SectionArray[11]){ echo '<a style="color:#f33548"><b><u>L</u></b></a>&nbsp&nbsp&nbsp&nbsp';}else{ echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=SectionL&date='.$_GET['date'].'"><u>L</u></a>&nbsp&nbsp&nbsp&nbsp';}
			if($_GET['id']==$SectionArray[12]){ echo '<a style="color:#f33548"><b><u>M</u></b></a>&nbsp&nbsp&nbsp&nbsp';}else{ echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=SectionM&date='.$_GET['date'].'"><u>M</u></a>&nbsp&nbsp&nbsp&nbsp';}
			if($_GET['id']==$SectionArray[13]){ echo '<a style="color:#f33548"><b><u>N</u></b></a>&nbsp&nbsp&nbsp&nbsp';}else{ echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=SectionN&date='.$_GET['date'].'"><u>N</u></a>&nbsp&nbsp&nbsp&nbsp';}
			if($_GET['id']==$SectionArray[14]){ echo '<a style="color:#f33548"><b><u>O</u></b></a>&nbsp&nbsp&nbsp&nbsp';}else{ echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=SectionO&date='.$_GET['date'].'"><u>O</u></a>&nbsp&nbsp&nbsp&nbsp';}
			if($_GET['id']==$SectionArray[15]){ echo '<a style="color:#f33548"><b><u>P</u></b></a>&nbsp&nbsp&nbsp&nbsp';}else{ echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=SectionP&date='.$_GET['date'].'"><u>P</u></a>&nbsp&nbsp&nbsp&nbsp';}
			if($_GET['id']==$SectionArray[16]){ echo '<a style="color:#f33548"><b><u>Q</u></b></a>&nbsp&nbsp&nbsp&nbsp';}else{ echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=SectionQ&date='.$_GET['date'].'"><u>Q</u></a>&nbsp&nbsp&nbsp&nbsp';}
			if($_GET['id']==$SectionArray[17]){ echo '<a style="color:#f33548"><b><u>V</u></b></a>&nbsp&nbsp&nbsp&nbsp';}else{ echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=SectionV&date='.$_GET['date'].'"><u>V</u></a>&nbsp&nbsp&nbsp&nbsp';}
			if($_GET['id']==$SectionArray[18]){ echo '<a style="color:#f33548"><b><u>X</u></b></a>&nbsp&nbsp&nbsp&nbsp';}else{ echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=SectionX&date='.$_GET['date'].'"><u>X</u></a>&nbsp&nbsp&nbsp&nbsp';}
			if($_GET['id']==$SectionArray[19]){ echo '<a style="color:#f33548"><b><u>Z</u></b></a>&nbsp&nbsp&nbsp&nbsp';}else{ echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=SectionZ&date='.$_GET['date'].'"><u>Z</u></a>&nbsp&nbsp&nbsp&nbsp';}
			if($_GET['id']==$SectionArray[20]){ echo '<a style="color:#f33548"><b><u>S</u></b></a>&nbsp&nbsp&nbsp&nbsp';}else{ echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=SectionS&date='.$_GET['date'].'"><u>S</u></a>&nbsp&nbsp&nbsp&nbsp';}
			echo '</td></tr></table></div>';
		 }elseif(in_array(@$_GET['id'],$formPage)){
			echo '<div><table><tr>';
		  /*echo '<td><form><input type="button" value="MDS Home" onclick="location.href=\'index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=99&date='.$_GET['date'].'\'" /></form></td>';
			echo '<td><form><a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank"><input type="button" value="Print"/></a></form></td>';    
			echo '<td><form><input type="button" value="Edit" onclick="location.href=\'index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.$_GET['id'].'-Alter&date='.$_GET['date'].'\'" /></form></td>';   */
/*Home圖片*/echo '<td><a href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=99&date='.$_GET['date'].'"><img src="Images/MDSHome.png" border="0"></a></td>';
            echo '<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>';
/*Print圖片*/echo '<td><a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank"><img src="Images/print.png" border="0"></a></td>';
            echo '<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>';
/*Edit圖片*/echo '<td><a href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.$_GET['id'].'-Alter&date='.$_GET['date'].'"><img src="Images/Edit.png" border="0"></a></td>';
			echo '<td style="width:800px">&nbsp</td></tr><tr><td>&nbsp</td></tr><tr><td colspan="6" style="text-align:center">';
			if($_GET['id'] > 1){?>
	  	    <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'];?>&id=1&date=<?php echo $_GET['date'];?>"> << First Page</a>&nbsp&nbsp&nbsp
	  	    <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'];?>&id=<?php echo ($_GET['id']-1); ?>&date=<?php echo $_GET['date'];?>"> < Previous</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
	  	    <?php };
		    echo 'Page:&nbsp&nbsp';
			if($_GET['id']==1){
			echo '<a style="color:#f33548"><b><u>'.$_GET['id'].'</u></b></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($_GET['id']+1).'&date='.$_GET['date'].'"><u>'.($_GET['id']+1).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($_GET['id']+2).'&date='.$_GET['date'].'"><u>'.($_GET['id']+2).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($_GET['id']+3).'&date='.$_GET['date'].'"><u>'.($_GET['id']+3).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($_GET['id']+4).'&date='.$_GET['date'].'"><u>'.($_GET['id']+4).'</u></a>&nbsp&nbsp&nbsp&nbsp';
			}elseif($_GET['id']==2){
			echo '<a href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($_GET['id']-1).'&date='.$_GET['date'].'"><u>'.($_GET['id']-1).'</u></a>&nbsp&nbsp&nbsp&nbsp
			      <a style="color:#f33548"><b><u>'.$_GET['id'].'</u></b></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($_GET['id']+1).'&date='.$_GET['date'].'"><u>'.($_GET['id']+1).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($_GET['id']+2).'&date='.$_GET['date'].'"><u>'.($_GET['id']+2).'</u></a>&nbsp&nbsp&nbsp&nbsp
                  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($_GET['id']+3).'&date='.$_GET['date'].'"><u>'.($_GET['id']+3).'</u></a>&nbsp&nbsp&nbsp&nbsp';
			}elseif($_GET['id']==42){
			echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($_GET['id']-3).'&date='.$_GET['date'].'"><u>'.($_GET['id']-3).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($_GET['id']-2).'&date='.$_GET['date'].'"><u>'.($_GET['id']-2).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($_GET['id']-1).'&date='.$_GET['date'].'"><u>'.($_GET['id']-1).'</u></a>&nbsp&nbsp&nbsp&nbsp
                  <a style="color:#f33548"><b><u>'.$_GET['id'].'</u></b></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($_GET['id']+1).'&date='.$_GET['date'].'"><u>'.($_GET['id']+1).'</u></a>&nbsp&nbsp&nbsp&nbsp';	
			}elseif($_GET['id']==43){
			echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($_GET['id']-4).'&date='.$_GET['date'].'"><u>'.($_GET['id']-4).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($_GET['id']-3).'&date='.$_GET['date'].'"><u>'.($_GET['id']-3).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($_GET['id']-2).'&date='.$_GET['date'].'"><u>'.($_GET['id']-2).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($_GET['id']-1).'&date='.$_GET['date'].'"><u>'.($_GET['id']-1).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#f33548"><b><u>'.$_GET['id'].'</u></b></a>&nbsp&nbsp&nbsp&nbsp';
			}else{
			echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($_GET['id']-2).'&date='.$_GET['date'].'"><u>'.($_GET['id']-2).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($_GET['id']-1).'&date='.$_GET['date'].'"><u>'.($_GET['id']-1).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#f33548"><b><u>'.$_GET['id'].'</u></b></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($_GET['id']+1).'&date='.$_GET['date'].'"><u>'.($_GET['id']+1).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($_GET['id']+2).'&date='.$_GET['date'].'"><u>'.($_GET['id']+2).'</u></a>&nbsp&nbsp&nbsp&nbsp';
			}
	  	    if($_GET['id'] < 43){?>
		    &nbsp&nbsp&nbsp&nbsp&nbsp
	  	    <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'];?>&id=<?php echo ($_GET['id']+1); ?>&date=<?php echo $_GET['date'];?>">Next ></a>&nbsp&nbsp&nbsp
	  	    <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'];?>&id=43&date=<?php echo $_GET['date'];?>">Last Page >></a>
	  	    <?php };
			echo '</td></tr><tr><td>&nbsp</td></tr></table></div>';
		 }elseif(in_array(@$_GET['id'],$formAlter)){
			echo '<div><table style="font-size:19px"><tr>';
      	  /*echo '<td><form><input type="button" value="MDS Home" onclick="location.href=\'index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=99&date='.$_GET['date'].'\'" /></form></td>';  */
/*Home圖片*/echo '<td><a href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=99&date='.$_GET['date'].'"><img src="Images/MDSHome.png" border="0"></a></td>';
            echo '<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>';
			$AlterformID = explode('-',$_GET['id']);
			echo '<td><a href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.$AlterformID[0].'&date='.$_GET['date'].'"><img src="Images/MDSView.png" border="0"></a></td>';
			echo '<td style="width:1200px">&nbsp</td></tr><tr><td colspan="4" style="text-align:center">';
			if($AlterformID[0] > 1){?>
	  	    <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'];?>&id=1-Alter&date=<?php echo $_GET['date'];?>"> << First Page</a>&nbsp&nbsp&nbsp
	  	    <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'];?>&id=<?php echo ($AlterformID[0]-1)."-Alter"; ?>&date=<?php echo $_GET['date'];?>"> < Previous</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
	  	    <?php };
		    echo 'Page:&nbsp&nbsp';
			if($AlterformID[0]==1){
			echo '<a style="color:#f33548;"><b><u>'.$AlterformID[0].'</u></b></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($AlterformID[0]+1)."-Alter".'&date='.$_GET['date'].'"><u>'.($AlterformID[0]+1).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($AlterformID[0]+2)."-Alter".'&date='.$_GET['date'].'"><u>'.($AlterformID[0]+2).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($AlterformID[0]+3)."-Alter".'&date='.$_GET['date'].'"><u>'.($AlterformID[0]+3).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($AlterformID[0]+4)."-Alter".'&date='.$_GET['date'].'"><u>'.($AlterformID[0]+4).'</u></a>&nbsp&nbsp&nbsp&nbsp';
			}elseif($AlterformID[0]==2){
			echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($AlterformID[0]-1)."-Alter".'&date='.$_GET['date'].'"><u>'.($AlterformID[0]-1).'</u></a>&nbsp&nbsp&nbsp&nbsp
			      <a style="color:#f33548;"><b><u>'.$AlterformID[0].'</u></b></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($AlterformID[0]+1)."-Alter".'&date='.$_GET['date'].'"><u>'.($AlterformID[0]+1).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($AlterformID[0]+2)."-Alter".'&date='.$_GET['date'].'"><u>'.($AlterformID[0]+2).'</u></a>&nbsp&nbsp&nbsp&nbsp
                  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($AlterformID[0]+3)."-Alter".'&date='.$_GET['date'].'"><u>'.($AlterformID[0]+3).'</u></a>&nbsp&nbsp&nbsp&nbsp';
			}elseif($AlterformID[0]==42){
			echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($AlterformID[0]-3)."-Alter".'&date='.$_GET['date'].'"><u>'.($AlterformID[0]-3).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($AlterformID[0]-2)."-Alter".'&date='.$_GET['date'].'"><u>'.($AlterformID[0]-2).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($AlterformID[0]-1)."-Alter".'&date='.$_GET['date'].'"><u>'.($AlterformID[0]-1).'</u></a>&nbsp&nbsp&nbsp&nbsp
                  <a style="color:#f33548;"><b><u>'.$AlterformID[0].'</u></b></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($AlterformID[0]+1)."-Alter".'&date='.$_GET['date'].'"><u>'.($AlterformID[0]+1).'</u></a>&nbsp&nbsp&nbsp&nbsp';	
			}elseif($AlterformID[0]==43){
			echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($AlterformID[0]-4)."-Alter".'&date='.$_GET['date'].'"><u>'.($AlterformID[0]-4).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($AlterformID[0]-3)."-Alter".'&date='.$_GET['date'].'"><u>'.($AlterformID[0]-3).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($AlterformID[0]-2)."-Alter".'&date='.$_GET['date'].'"><u>'.($AlterformID[0]-2).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($AlterformID[0]-1)."-Alter".'&date='.$_GET['date'].'"><u>'.($AlterformID[0]-1).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#f33548;"><b><u>'.$AlterformID[0].'</u></b></a>&nbsp&nbsp&nbsp&nbsp';
			}else{
			echo '<a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($AlterformID[0]-2)."-Alter".'&date='.$_GET['date'].'"><u>'.($AlterformID[0]-2).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($AlterformID[0]-1)."-Alter".'&date='.$_GET['date'].'"><u>'.($AlterformID[0]-1).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#f33548;"><b><u>'.$AlterformID[0].'</u></b></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($AlterformID[0]+1)."-Alter".'&date='.$_GET['date'].'"><u>'.($AlterformID[0]+1).'</u></a>&nbsp&nbsp&nbsp&nbsp
				  <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id='.($AlterformID[0]+2)."-Alter".'&date='.$_GET['date'].'"><u>'.($AlterformID[0]+2).'</u></a>&nbsp&nbsp&nbsp&nbsp';
			}
	  	    if($AlterformID[0] < 43){?>
		    &nbsp&nbsp&nbsp&nbsp&nbsp
	  	    <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'];?>&id=<?php echo ($AlterformID[0]+1)."-Alter"; ?>&date=<?php echo $_GET['date'];?>">Next ></a>&nbsp&nbsp&nbsp
	  	    <a style="color:#009a93;" href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid'];?>&id=43-Alter&date=<?php echo $_GET['date'];?>">Last Page >></a>
	  	    <?php };
			echo '</td></tr><tr><td>&nbsp</td></tr><tr><td>&nbsp</td></tr></table></div>';
		 }elseif(@$_GET['id']=="MDSxml"){
			echo '<div><table><tr>';
/*Home圖片*/echo '<td><a href="index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=99&date='.$_GET['date'].'"><img src="Images/MDSHome.png" border="0"></a></td>';
			echo '</tr></table></div>'; 
		 }
	?>
    </td>
  </tr>
</table>
<table style="background-color:rgba(255,255,255,0.8); width:100%; border-bottom-left-radius:16px; border-bottom-right-radius:16px; margin-bottom:40px;" onclick="closeResidentCol();">
  <tr>
    <td align="center">
    <div><table><tr>
    <?php
	if (@$_GET['id']!=NULL) {
	  $formID = explode('-',$_GET['id']);
	  if(count($formID)==1){
	    if(@$_GET['id']!=99 && $_GET['id']!="ProduceMDS" && $_GET['id']!="ProduceMDSselect"){
		  ?>
		  <link type="text/css" rel="stylesheet" href="css/MDS-CSS.css">
		  <?php
	    }
	  }
	  include("RedPoint.php");
	  include("form".@$_GET['id'].".php");
	}else{
		?><script>document.location.href="index.php?mod=nurseform&func=formview&pid=<?php echo $_GET['pid']; ?>";</script><?
	}
	?></tr></table></div>
	</td>
  </tr>
</table>
<?php
if (substr($url[3],0,5)!="print") {
	echo '<div id="ResidentCol" align="left">';
	echo '<div align="center" style="background-color:#eecb35; border-radius:10px; padding:7px; margin-bottom:20px;"><font style="color:white; font-size:26px; font-weight:bold;">Resident List</font></div>';
	include("ResidentCol.php");
	echo '</div>';
	echo '<script type="text/javascript" src="js/closeResidentCol.js"></script>';
}
?>
<script type="text/javascript" src="js/LWJ_CheckRound.js"></script>
<script>
function deleteMDScheck() {
	if (confirm("Are you sure you want to delete this data? \n( MDS: <?php echo formatdate_Ymd_Slash($_GET['date']);?> )") == true) {
		if (confirm("If you do delete, this data( MDS: <?php echo formatdate_Ymd_Slash($_GET['date']);?> ) can not be restored. Are you sure?") == true){
			document.location.href="index.php?func=MDS-Delete&pid=<?php echo $_GET['pid']; ?>&date=<?php echo $_GET['date']; ?>";
		}
	}
}
</script>
<script>
	var lastScrollTop = 0;
	$('#content2').scroll(function(event){
		var st = $(this).scrollTop();
        if(Math.abs(lastScrollTop - st) <= 5)
        return;
    if (st > lastScrollTop && st > 90){
        $(function(){
        	$('.header').removeClass('nav-down').addClass('nav-goup')
        	$('#content2').removeClass('content2Nav').addClass('content2Nav');
        	$('.content-query2').addClass('content-query2Nav');
        });
    } else if(lastScrollTop>st && (lastScrollTop-st>20) || st<=90){
        $(function(){
        	$('.header').removeClass('nav-goup').addClass('nav-down')
        	$('#content2').removeClass('content2Nav').addClass('content2N');
        	$('.content-query2').removeClass('content-query2Nav');
        });
    }
        lastScrollTop = st;
	});
</script>