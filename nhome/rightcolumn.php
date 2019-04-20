<script>
$(function() {
	$("div[id^=dialog_]").dialog({
		autoOpen: false,
		width:600,
		height:400,
		show: {
			effect: "blind", duration: 600
		},
		hide: {
			effect: "blind", duration: 600
		}
	});
});
function opendialog(id) {
	$("div[id^=dialog_]").dialog("close");
	var vartxt = 'dialog_'+id;
	$("#"+vartxt).dialog("open");
}
$(document).ready(function () {
	$("#notice1").css("width","250px");
})
</script>
    <?php
	if ($_SESSION['ncareOrgStatus_lwj']!=2) {
	?>
    <div id="notice1">
    <h3>Center's basic information</h3>
    <?php
	$dbstat1 = new DB;
	$dbstat1->query("SELECT * FROM `bedinfo` a LEFT JOIN `inpatientinfo` b ON a.`bedID`=b.`bed` WHERE a.`bedID`!=''");
	$TotalBed = $dbstat1->num_rows();
	$strQry = " a INNER JOIN `patient` b ON a.`patientID`=b.`patientID` WHERE b.`type`='1';";
	$strQry2 = "  WHERE b.`type`='1';";
	$dbstat2 = new DB;
	$dbstat2->query("SELECT `patientID` FROM `inpatientinfo`".$strQry);
	$InpaitentNo = $dbstat2->num_rows();
	$EmptyBed = $TotalBed - $InpaitentNo;
	$dbstat3a = new DB;
	$dbstat3a->query("SELECT `gender_1`, `gender_2` FROM `inpatientinfo` a LEFT JOIN `patient` b ON a.patientID=b.patientID".$strQry2);
	for ($i=0;$i<$dbstat3a->num_rows();$i++) {
		$r3a = $dbstat3a->fetch_assoc();
		if ($r3a['gender_1']==1) { $Mpatient++; }
		if ($r3a['gender_2']==1) { $Fpatient++; }
	}
	$dbstat4 = new DB;
	$dbstat4->query("SELECT * FROM `general_io` WHERE (`indate`='' OR `indate`='____/__/__') AND `outdate`<='".date("Y/m/d")."'");
	$reason1 = 0;
	$reason2 = 0;
	$reason3 = 0;
	$reason4 = 0;
	for ($i=0;$i<$dbstat4->num_rows();$i++) {
		$r4 = $dbstat4->fetch_assoc();
		if ($r4['reason_1']==1) {
			$reason1++;
		} elseif ($r4['reason_2']==1) {
			$reason2++;
		} elseif ($r4['reason_3']==1) {
			$reason3++;
		} elseif ($r4['reason_4']==1) {
			$reason4++;
		}
	}
	$totalReason = $reason1 + $reason2 + $reason3 + $reason4;
	?>
    <div style="font-size:10pt;">
    <table>
      <!--<tr>
        <td class="title" width="120">總床數</td>
        <td><?php echo $TotalBed; ?>Bed</td>
      </tr>-->
      <tr>
        <td class="title">住民人數</td>
        <td><?php echo $InpaitentNo; ?>人</td>
      </tr>
      <tr>
        <td class="title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Male</td>
		<td><?php echo $Mpatient; ?>人</td>
      </tr>
      <tr>
        <td class="title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Female</td>
		<td><?php echo $Fpatient; ?>人</td>
      </tr>
      <tr>
        <td colspan="2"><hr></td>
      </tr>
      <tr>
        <td class="title">請假人數</td>
        <td><?php echo $totalReason; ?>人</td>
      </tr>
      <tr>
        <td class="title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Return/visit home</td>
        <td><?php echo $reason1; ?>人</td>
      </tr>
      <tr>
        <td class="title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;出國</td>
        <td><?php echo $reason2; ?>人</td>
      </tr>
      <tr>
        <td class="title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;請假出門</td>
        <td><?php echo $reason3; ?>人</td>
      </tr>
      <tr>
        <td class="title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hospitalization</td>
        <td><?php echo $reason4; ?>人</td>
      </tr>
    </table>
    </div>
    </div>
    <?php
	}
	?>
    <div id="notice2">
    <h3>Announcement</h3>
    <div style="font-size:10pt;">
    <center><form><input type="button" onclick="window.location.href='index.php?func=noticelist'" value="View all announcement"></form></center><hr>
    <?php
    $db = new DB;
	$db->query("SELECT * FROM `management07a` WHERE `available`='1' AND DATE_FORMAT(`date`,'%Y%m%d')>='".date(Ymd)."' ORDER BY `datetime` DESC LIMIT 0,8");
	$noticetxt = "";
	for ($i=0;$i<$db->num_rows();$i++) {
		$r = $db->fetch_assoc();
		if ($noticetxt!=NULL) { $noticetxt .= '<hr>'; }
		$noticetxt .= '<b>'.substr($r['datetime'],5,5).'</b> '.checkusername($r['Qfiller']).checkuserposition($r['Qfiller']).'<br><a onclick="opendialog('.$r['noticeID'].')" style="cursor:pointer;">'.$r['Q1'].'</a>';
		$dialogtxt .= '<div id="dialog_'.$r['noticeID'].'" title="'.$r['Q1'].'"><p>'.str_replace("\n","<br>",$r['Qcontent']).'</p>';
		if ($r['Attach']!="") {
			$dialogtxt .= '<p align="left">appendix 1：<a href="'.$r['Attach'].'" target="_blank">'.str_replace('announcement_files/','',$r['Attach']).'</a></p>';
		}
		if ($r['Attach2']!="") {
			$dialogtxt .= '<p align="left">appendix 2：<a href="'.$r['Attach2'].'" target="_blank">'.str_replace('announcement_files/','',$r['Attach2']).'</a></p>';
		}
		if ($r['Attach3']!="") {
			$dialogtxt .= '<p align="left">appendix 3：<a href="'.$r['Attach3'].'" target="_blank">'.str_replace('announcement_files/','',$r['Attach3']).'</a></p>';
		}
		$dialogtxt .= '<p align="right"><font size="2">'.substr($r['datetime'],5,5).' '.substr($r['datetime'],11,2).':'.substr($r['datetime'],14,2).' <em>by</em> '.checkusername($r['Qfiller']).' '.checkuserposition($r['Qfiller']).'</font></p></div>';
	}
	echo $noticetxt;
	echo $dialogtxt;
	?>
    </div>
    </div>
    <div id="notice3">
    <h3>Reminder Content</h3>
    <div style="font-size:10pt;">
    <?php
    $db_remind = new DB;
	$db_remind->query("SELECT DISTINCT `remindContent`, `HospNo`, `remindDate`, `Qfiller` FROM `reminder` WHERE `remindDate`>='".date('Y/m/d')."' AND `remindDate` LIKE '".date('Y/m')."%' AND `active`='1' ORDER BY `remindDate` ASC LIMIT 0,15");
	for ($i=0;$i<$db_remind->num_rows();$i++) {
		$reminder = $db_remind->fetch_assoc();
		$pid = getPID($reminder['HospNo']);
		if ($_SESSION['ncareOrgStatus_lwj']==2) {
			$db_instat = new DB;
			$db_instat->query("SELECT `instat` FROM `patient` WHERE `patientID`='".$pid."'");
			$r_instat = $db_instat->fetch_assoc();
			if ($r_instat==1) {
				if ($noticetxt3!=NULL) { $noticetxt3 .= '<hr>'; }
				$noticetxt3 .= '<b>'.$reminder['remindDate'].'</b><br>'.getBedID($pid).' '.getPatientName($pid).'<br>'.$reminder['remindContent'];
			}
		} else {
			if ($noticetxt3!=NULL) { $noticetxt3 .= '<hr>'; }
			$noticetxt3 .= '<b>'.$reminder['remindDate'].'</b><br>'.getBedID($pid).' '.getPatientName($pid).'<br>'.$reminder['remindContent'];
		}
	}
	echo $noticetxt3;
	?>
    </div>
    </div>
    <div id="notice4">
    <h3>System update announcement</h3>
    <div style="font-size:10pt;">
    <?php
    $db_notice = new DB2;
	$db_notice->query("SELECT `date`, `content` FROM `notice` WHERE (`orgID` LIKE '%".$_SESSION['nOrgID_lwj']."%' OR `orgID`='ALL') ORDER BY `date` DESC LIMIT 0,3");
	for ($inotice=0;$inotice<$db_notice->num_rows();$inotice++) {
		$r_notice = $db_notice->fetch_assoc();
		if ($noticetxt2!=NULL) { $noticetxt2 .= '<hr>'; }
		$noticetxt2 .= '<b>'.substr($r_notice['date'],0,10).'</b><br>'.$r_notice['content'];
	}
	echo $noticetxt2;
	?>
    </div>
    </div>