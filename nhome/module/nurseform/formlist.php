<?php
if(@$_GET['pid']==""){
	echo "<script type='text/javascript'>";
	echo "window.location.href='index.php?func=home'";
	echo "</script>";
}
?>
<div class="formlist">
<?php
include('FormGroup_Link.php');
$db5 = new DB;
$db5->query("SELECT `indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET["pid"])."'");
$r5 = $db5->fetch_assoc();
$db1 = new DB2;
$db1->query("SELECT *, a.`name` as `catename` FROM `permission_subcate` a INNER JOIN `permission_item` b ON a.subcateID = b.subcateID AND a.cateID='1' INNER JOIN `user_permission` c ON c.`serNo`=b.`serNo` AND c.`userID`='".$_SESSION['ncareID_lwj']."' AND c.`level`='1' ORDER BY b.subcateID, b.ord");
for ($i1=0;$i1<$db1->num_rows();$i1++) {
	$r1 = $db1->fetch_assoc();
	$db2 = new DB2;
	$db2->query("SELECT * FROM `formnamealias` WHERE `serNo`='".$r1['serNo']."' AND `OrgID`='".$_SESSION['nOrgID_lwj']."'");
	if ($db2->num_rows()==0) {
		$formName = $r1['name'];  // permission_item    name 表單名稱
	} else {
		$r2 = $db2->fetch_assoc();
		$formName = $r2['formName'];
	}
	$catename = explode(";",$r1['catename']);
	if ($r1['subcateID']!=$tmpSubcate) { echo '<div class="formlistStyle">'.$catename[$_SESSION['LanguangNumber_lwj']].'</div>'; }
	  echo '
	  <div class="formlistItem">';
	  /*============ 提示需填寫表單 STRAT ============*/
	  $formMod = explode("mod=",$r1['link']);
	  $formMod = explode("&",$formMod[1]);
	  $linkformID = explode("&id=",$r1['link']);
	  $linkformIDArray = array("1","2a","2b","2c","2d","2e","2f","2g","2h","2g_1","2g_2","2k","5");
	  if(in_array($linkformID[1],$linkformIDArray)){
		  $linkformID = '0'.$linkformID[1];
	  }else{
		  $linkformID = $linkformID[1];
	  }	  
	  $SearchformID = $formMod[0].$linkformID;
	  $db4 = new DB;
	  $db4->query("SELECT * FROM `formremind` WHERE `formType`='Nursing Care' AND `formID`='".$SearchformID."' AND `remindDay`>0 ORDER BY `formID`");
	  if($db4->num_rows()>0){
		for ($i2=0;$i2<$db4->num_rows();$i2++) {
			$r4 = $db4->fetch_assoc();
			$db3 = new DB;
			$db3->query("SELECT `date` FROM `".$r4['formID']."` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC LIMIT 0,1");
			$r3 = $db3->fetch_assoc();
			if($r4['formID']=="mdsform99"){
				$dateFilled = formatdate_Ymd($r3['date']);
			}else{
				$dateFilled = $r3['date'];
			}
			$today = date('Ymd');
			$linktmp = $r4['formLink'];
			$link = str_replace('{PID}',$_GET['pid'],$linktmp);
			if ($dateFilled!="") {
				$dateDiff = abs(calcperiod($dateFilled, $today));
				$dateDiff2 = abs(calcperiod($dateFilled, $r5["indate"]));
				if ($r4['remindDay']==3) {
					echo '<a href="'.str_replace('{PID}',$_GET['pid'],$r1['link']).'">';
				} elseif ($r4['remindDay']>0 && $dateDiff > $r4['remindDay']) {
					echo '<a class="point" href="'.str_replace('{PID}',$_GET['pid'],$r1['link']).'">';
				} else {
					echo '<a href="'.str_replace('{PID}',$_GET['pid'],$r1['link']).'">';
				}
			} else {
				$dateDiff = abs(calcperiod($r5["indate"], $today));
				if ($r4['remindDay']==3 && $dateDiff <= $r4['remindDay']) {
					echo '<a class="point_unfilled" href="'.str_replace('{PID}',$_GET['pid'],$r1['link']).'">';
				} elseif ($r4['remindDay']>0 && $dateDiff > $r4['remindDay']) {
					echo '<a class="point" href="'.str_replace('{PID}',$_GET['pid'],$r1['link']).'">';
				} else {
					echo '<a href="'.str_replace('{PID}',$_GET['pid'],$r1['link']).'">';
				}
			}
		}
	  }else{
	    echo '<a href="'.str_replace('{PID}',$_GET['pid'],$r1['link']).'">';
	  }
	  /*============ 提示需填寫表單 END ============*/
	  /*
	  if(需要填寫){
		  echo '<a class="point" href="'.str_replace('{PID}',$_GET['pid'],$r1['link']).'">';
	  }else{
		  echo '<a href="'.str_replace('{PID}',$_GET['pid'],$r1['link']).'">';
	  }*/
	  echo '
	  <span class="fa-stack fa-2x"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-'.$r1['icon'].' fa-stack-1x fa-inverse"></i></span><br>'.$formName.'</a>
	  </div>';
	  $tmpSubcate = $r1['subcateID'];
}
include('FormMaker_Link.php');
?>
</div>