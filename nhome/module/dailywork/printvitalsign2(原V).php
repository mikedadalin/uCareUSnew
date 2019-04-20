<?php
$db = new DB;
$db->query("SELECT * FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT * FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	/*== 解 START ==*/
	$LWJArray = array('Name1','Name2','Name3','Name4');
	$LWJdataArray = array($r['Name1'],$r['Name2'],$r['Name3'],$r['Name4']);
	for($i=0;$i<count($LWJdataArray);$i++){
	    $rsa = new lwj('lwj/lwj');
	    $puepart = explode(" ",$LWJdataArray[$i]);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($j=0;$j<$puepartcount;$j++){
                $prdpart = $rsa->privDecrypt($puepart[$j]);
                $r[$LWJArray[$i]] = $r[$LWJArray[$i]].$prdpart;
            }
	    }else{
		   $r[$LWJArray[$i]] = $rsa->privDecrypt($LWJdataArray[$i]);
	    }
	}
	/*== 解 END ==*/
	if($r['Name2']!="" || $r['Name2']!=NULL){$r['Name2'] = " ".$r['Name2'];}
    if($r['Name3']!="" || $r['Name3']!=NULL){$r['Name3'] = " ".$r['Name3'];}
    if($r['Name4']!="" || $r['Name4']!=NULL){$r['Name4'] = " ".$r['Name4'];}
	$name = $r['Name1'].$r['Name2'].$r['Name3'].$r['Name4'];
	$birth = formatdate($r['Birth']);
	$indate = formatdate($r1['indate']);
	$db2 = new DB;
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4`, `Qdiag5`, `Qdiag6`, `Qdiag7`, `Qdiag8` FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=8;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
	$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
}
?>
<div class="content-query">
<table border="1" style="border-collapse:collapse;" width="1080">
  <tr id="backtr"  style="border:none;" height="40">
    <?php if (@$_GET['id']!=NULL) { echo '<td align="center" bgcolor="#ffffff" width="40" id="backbtn"  style="border:none;"><a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'"><img src="Images/back_button.png"></a></td>'; } ?>
    <td class="title" width="60" style="border:none;">Full name</td>
    <td width="80" style="border:none;"><?php echo $name; ?></td>
    <td class="title" width="60" style="border:none;">DOB</td>
    <td width="180" style="border:none;"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
    <td class="title" width="80" style="border:none;">Admission date</td>
    <td width="80" style="border:none;"><?php echo $indate; ?></td>
  </tr>
</table>
</div>
<?php
foreach ($arrVital as $k=>$v) {
	${'arrVital'.$k} = array();
}
if (@$_GET['date']=="--Select month--") {
	$qdate = date(Y).'-'.date(m);
} else {
	$qdate = substr(@$_GET['date'],0,4).'-'.substr(@$_GET['date'],4,2);
}
$db = new DB;
$db->query("SELECT * FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`!='18833-4' AND `RecordedTime` LIKE '".$qdate."%' AND `IsValid`='1' ORDER BY `RecordedTime` ASC");
for ($i=1;$i<=31;$i++) {
	${'arrTimeArray'.$i} = array();
	${'arrQfillerArray'.$i} = array();
}
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$dateRecord = explode('-',$r['RecordedTime']);
	$day = (int) substr($dateRecord[2],0,2);
	$time = substr($dateRecord[2],2,6);
	$time = str_replace(" ","",$time);
	$time = str_replace(":","",$time);
	$VitalName = 'arrVital'.$r['LoincCode'];
	${$VitalName}[$day][$time] = $r['Value'];
	$arrQfillerArray[$day][$time] = checkusername($r['Qfiller']);
	if (!in_array($time,${'arrTimeArray'.$day})) { array_push(${'arrTimeArray'.$day},$time); }
}

$dbio = new DB;
$dbio->query("SELECT * FROM `iostatus` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `RecordedTime` LIKE '".$qdate."%' ORDER BY `RecordedTime` ASC");
for ($i=1;$i<=31;$i++) {
	${'arrIOTimeArray'.$i} = array();
	${'arrIOQfillerArray'.$i} = array();
}
for ($i=0;$i<$db->num_rows();$i++) {
	$rIO = $dbio->fetch_assoc();
	$dateRecord = explode('-',$rIO['RecordedTime']);
	$day = (int) substr($dateRecord[2],0,2);
	$time = substr($dateRecord[2],2,6);
	$time = str_replace(" ","",$time);
	$time = str_replace(":","",$time);
	$arrIO[$day][0] = $time;
	$arrIO[$day][1] = $rIO['input'];
	$arrIO[$day][2] = $rIO['output'];
	$arrIO[$day][3] = $rIO['output1'];
	$arrIO[$day][4] = $rIO['output2'];
	$arrIO[$day][5] = $rIO['output3'];
	$arrIO[$day][6] = $rIO['iostatus'];
	$arrIO[$day][7] = checkusername($rIO['Qfiller']);
	//if (!in_array($time,${'arrTimeArray'.$day})) { array_push(${'arrTimeArray'.$day},$time); }
}
?>
<div style="width:1080px;">
<h3>Daily vital signs record- 
<?php
if (@$_GET['date']=="--Select month--") {
	echo date(Y).'/'.date(m);
} else {
	echo substr(@$_GET['date'],0,4).'/'.substr(@$_GET['date'],4,2);
}
?></h3>
<table>
  <tr>
    <td valign="top" width="50%">
        <table border="0" cellpadding="0" cellspacing="0" style="border:0px;">
          <tr>
            <td valign="top">
              <table border="1" style="border-collapse:collapse; text-align:center;" >
                <tr class="title" height="40">
                  <td width="30">Date</td>
                  <td width="45">Time</td>
                  <td width="40">Temperature</td>
                  <td width="40">Heartbeat/Pulse</td>
                  <td width="40">Respiration</td>
                  <td width="90">Blood pressure</td>
                  <td width="40">SpO2</td>
                  <td width="50">Pain</td>
                  <td width="40">AC<br />Blood glucose</td>
                  <td width="40">PC<br />Blood glucose</td>
                  <td width="60">Signature</td>
                </tr>
                <?php
                for ($i=1;$i<=11;$i++) {
                    $ndday = $i+11;
                    if ($ndday>31) { $ndday = ""; }
                    if (count(${'arrTimeArray'.$i})>0) {
                        for ($j=0;$j<count(${'arrTimeArray'.$i});$j++) {
                            echo '
                            <tr height="40">';
                            if ($j==0) {
                                echo '<td class="title_s" rowspan="'.count(${'arrTimeArray'.$i}).'">'.$i.'</td>';
                            }
                            echo '
                            <td>'.substr(${'arrTimeArray'.$i}[$j],0,2).':'.substr(${'arrTimeArray'.$i}[$j],2,2).'</td>
                            <td>'.${'arrVital8310-5'}[$i][${'arrTimeArray'.$i}[$j]].'</td>
                            <td>'.${'arrVital8867-4'}[$i][${'arrTimeArray'.$i}[$j]].'</td>
                            <td>'.${'arrVital9279-1'}[$i][${'arrTimeArray'.$i}[$j]].'</td>
                            <td>'.${'arrVital8480-6'}[$i][${'arrTimeArray'.$i}[$j]].' / '.${'arrVital8462-4'}[$i][${'arrTimeArray'.$i}[$j]].'</td>
                            <td>'.${'arrVital2710-2'}[$i][${'arrTimeArray'.$i}[$j]].'</td>
                            <td>'.${'arrVital46033-7'}[$i][${'arrTimeArray'.$i}[$j]].'</td>
                            <td>'.${'arrVital14743-9'}[$i][${'arrTimeArray'.$i}[$j]].'</td>
                            <td>'.${'arrVital15075-5'}[$i][${'arrTimeArray'.$i}[$j]].'</td>
                            <td><font size="2" color="#CCC">'.${'arrQfillerArray'}[$i][${'arrTimeArray'.$i}[$j]].'</font></td>
                          </tr>';
                        }
                    } else {
                        echo '
                        <tr height="40">
                          <td class="title_s">'.$i.'</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;/&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>';
                    }
                }
                ?>
                </table>
            </td>
          </tr>
        </table>
    </td>
    <td valign="top" width="50%">
        <table border="0" cellpadding="0" cellspacing="0" style="border:0px; width:100%">
          <tr>
            <td valign="top">
              <table border="1" style="border-collapse:collapse; text-align:center; width:100%">
                <tr class="title" height="40">
                  <td width="30">Date</td>
                  <td width="45">Time</td>
                  <td width="40">Total intake</td>
                  <td width="40">Total output</td>
                  <td width="40">1.Stool</td>
                  <td width="40">2.Drainage tube</td>
                  <td width="40">3.Other</td>
                  <td width="40">Positive and negative status</td>
                  <td width="60">Signature</td>
                </tr>
                <?php
                for ($i=1;$i<=11;$i++) {
                    $ndday = $i+11;
                    if ($ndday>31) { $ndday = ""; }
                    echo '
				<tr height="40">
				  <td class="title_s" rowspan="'.count(${'arrTimeArray'.$i}).'">'.$i.'</td>';
				  	for ($j=0;$j<8;$j++) {
						if ($j==0 && $arrIO[$i][$j]!="") {
							echo '<td>'.substr($arrIO[$i][$j],0,2).':'.substr($arrIO[$i][$j],2,2).'</td>';
						} else {
							echo '<td>'.$arrIO[$i][$j].'</td>';
						}
					}
				    echo '
				</tr>'."\n";
				for ($j1=0;$j1<(count(${'arrTimeArray'.$i})-1);$j1++) {
						echo '<tr height="40">';
						for ($j=0;$j<8;$j++) {
							echo '<td>&nbsp;</td>';
						}
						echo '</tr>';
					}
                }
                ?>
                </table>
            </td>
          </tr>
        </table>
    </td>
  </tr>
</table>
</div>
<?php
for ($pageNo=1;$pageNo<=2;$pageNo++) {
?>
<p style="page-break-before:always;">&nbsp;</p>
<div style="width:1080px;">
<center><h3><?php echo $_SESSION['nOrgName_lwj']; ?></h3></center>
<div class="content-query">
<table border="1" style="border-collapse:collapse;" width="1080">
  <tr id="backtr"  style="border:none;" height="40">
    <?php if (@$_GET['id']!=NULL) { echo '<td align="center" bgcolor="#ffffff" width="40" id="backbtn"  style="border:none;"><a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'"><img src="Images/back_button.png"></a></td>'; } ?>
    <td class="title" width="60" style="border:none;">Full name</td>
    <td width="80" style="border:none;"><?php echo $name; ?></td>
    <td class="title" width="60" style="border:none;">DOB</td>
    <td width="180" style="border:none;"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
    <td class="title" width="80" style="border:none;">Admission date</td>
    <td width="80" style="border:none;"><?php echo $indate; ?></td>
  </tr>
</table>
</div>
<h3>Daily vital signs record- 
<?php
if (@$_GET['date']=="--Select month--") {
	echo date(Y).'/'.date(m);
} else {
	echo substr(@$_GET['date'],0,4).'/'.substr(@$_GET['date'],4,2);
}
?></h3>
<table>
  <tr>
    <td valign="top" width="50%">
		<table border="0" cellpadding="0" cellspacing="0" style="border:0px;">
  <tr>
    <td valign="top">
      <table border="1" style="border-collapse:collapse; text-align:center;" >
        <tr class="title" height="40">
          <td width="30">Date</td>
          <td width="45">Time</td>
          <td width="40">Temperature</td>
          <td width="40">Heartbeat/Pulse</td>
          <td width="40">Respiration</td>
          <td width="90">Blood pressure</td>
          <td width="40">SpO2</td>
          <td width="50">Pain</td>
          <td width="40">AC<br />Blood glucose</td>
          <td width="40">PC<br />Blood glucose</td>
          <td width="60">Signature</td>
        </tr>
        <?php
        for ($i=1;$i<=11;$i++) {
			$ndday = $i+($pageNo*11);
			if ($ndday>31) { $ndday = ""; }
			if (count(${'arrTimeArray'.$ndday})>0) {
				for ($j=0;$j<count(${'arrTimeArray'.$ndday});$j++) {
					echo '
					<tr height="40">';
					if ($j==0) {
						echo '<td class="title_s" rowspan="'.count(${'arrTimeArray'.$ndday}).'">'.$ndday.'</td>';
					}
					echo '
					<td>'.substr(${'arrTimeArray'.$ndday}[$j],0,2).':'.substr(${'arrTimeArray'.$ndday}[$j],2,2).'</td>
					<td>'.${'arrVital8310-5'}[$ndday][${'arrTimeArray'.$ndday}[$j]].'</td>
					<td>'.${'arrVital8867-4'}[$ndday][${'arrTimeArray'.$ndday}[$j]].'</td>
					<td>'.${'arrVital9279-1'}[$ndday][${'arrTimeArray'.$ndday}[$j]].'</td>
					<td>'.${'arrVital8480-6'}[$ndday][${'arrTimeArray'.$ndday}[$j]].' / '.${'arrVital8462-4'}[$ndday][${'arrTimeArray'.$ndday}[$j]].'</td>
					<td>'.${'arrVital2710-2'}[$ndday][${'arrTimeArray'.$ndday}[$j]].'</td>
					<td>'.${'arrVital46033-7'}[$ndday][${'arrTimeArray'.$ndday}[$j]].'</td>
					<td>'.${'arrVital14743-9'}[$ndday][${'arrTimeArray'.$ndday}[$j]].'</td>
					<td>'.${'arrVital15075-5'}[$ndday][${'arrTimeArray'.$ndday}[$j]].'</td>
					<td><font size="2" color="#CCC">'.${'arrQfillerArray'}[$ndday][${'arrTimeArray'.$ndday}[$j]].'</font></td>
				  </tr>';
				}
			} else {
				echo '
				<tr height="40">
				  <td class="title_s">'.$ndday.'</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;/&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				</tr>';
			}
		}
		?>
        </table>
    </td>
  </tr>
</table>
	</td>
    <td valign="top" width="50%">
    	<table border="0" cellpadding="0" cellspacing="0" style="border:0px; width:100%">
          <tr>
            <td valign="top">
              <table border="1" style="border-collapse:collapse; text-align:center; width:100%">
                <tr class="title" height="40">
                  <td width="30">Date</td>
                  <td width="45">Time</td>
                  <td width="40">Total intake</td>
                  <td width="40">Total output</td>
                  <td width="40">1.Stool</td>
                  <td width="40">2.Drainage tube</td>
                  <td width="40">3.Other</td>
                  <td width="40">Positive and negative status</td>
                  <td width="60">Signature</td>
                </tr>
                <?php
                for ($i=1;$i<=11;$i++) {
                    $ndday = $i+($pageNo*11);
                    if ($ndday>31) { $ndday = ""; }
                    echo '
				<tr height="40">
				  <td class="title_s" rowspan="'.count(${'arrTimeArray'.$ndday}).'">'.$ndday.'</td>';
				  	for ($j=0;$j<8;$j++) {
						if ($j==0 && $arrIO[$ndday][$j]!="") {
							echo '<td>'.substr($arrIO[$ndday][$j],0,2).':'.substr($arrIO[$ndday][$j],2,2).'</td>';
						} else {
							echo '<td>'.$arrIO[$ndday][$j].'</td>';
						}
					}
				    echo '
				</tr>'."\n";
				for ($j1=0;$j1<(count(${'arrTimeArray'.$ndday})-1);$j1++) {
						echo '<tr height="40">';
						for ($j=0;$j<8;$j++) {
							echo '<td>&nbsp;</td>';
						}
						echo '</tr>';
					}
                }
                ?>
                </table>
            </td>
          </tr>
        </table>
    </td>
  </tr>
</table>
</div>
<?php
}
?>