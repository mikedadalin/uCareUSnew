<?php
//print_r($_POST);
foreach ($_POST as $k=>$v) {
	if (substr($k,0,8)=="Qmedtime") {
		if ($v==1) {
			$options = explode("_",$k);
			$Qmedtime .= ($options[1]-1).';';
		}
	} elseif (substr($k,0,7)=="Qmedday") {
		if ($v==1) {
			$options = explode("_",$k);
			$Qmedday .= ($options[1]-1).';';
		}
	} elseif (substr($k,0,13)=="QeffectOption") {
		if ($v==1) {
			$options = explode("_",$k);
			$QeffectOption .= ($options[1]).';';
		}
	} else {
		${$k} = $v;
	}
}

if (@$_GET['action']=="new") {
$medname = explode('(',$Qmedicine);
$medname1 = trim($medname[0]);
$medname2 = explode(')',$medname[1]);
$medname2 = trim($medname2[0]);
$db0 = new DB;
$db0->query("SELECT `drugID` FROM `drug` WHERE `name` = '".$medname1."' AND `name2` = '".$medname2."'");
if ($db0->num_rows()>0) {
	$r0 = $db0->fetch_assoc();
	$drugID = $r0['drugID'];
} else {
	$db0a = new DB;
	$db0a->query("INSERT INTO `drug` (`name`, `name2`) VALUES ('".$medname1."', '".$medname1."')");
	$db0b = new DB;
	$db0b->query("SELECT `drugID` FROM `drug` ORDER BY `drugID` DESC LIMIT 0,1");
	$r0b = $db0b->fetch_assoc();
	$drugID = $r0b['drugID'];
}
$date = str_replace('/','',$date);

/*$db1=new DB;
$db1->query("SELECT * FROM `nurseform17` WHERE `HospNo`='".$HospNo."' AND `date`='".$date."' AND `drugID`='".$drugID."'");
if ($db1->num_rows()==0) {
	$db2a = new DB;
	$db2a->query("INSERT INTO `nurseform17` VALUES ('".$HospNo."', '".$date."', '".$drugID."',  '".$Qmedicine."', '".$Qusage."', '".$Qdose."', '".$Qdoseq."', '".$Qway."', '".$Qmedtime."', '".$Qmedday."', '".$Qfreq."', '".$Qstartdate."', '".$Qenddate."', '', '".$_SESSION['ncareID_lwj']."')");
} else {
	$db2a = new DB;
	$db2a->query("UPDATE `nurseform17` SET `Qusage`='".$Qusage."', `Qdose`='".$Qdose."', `Qdoseq`='".$Qdoseq."', `Qway`='".$Qway."', `Qmedtime`='".$Qmedtime."', `Qmedday`='".$Qmedday."', `Qfreq`='".$Qfreq."', `Qstartdate`='".$Qstartdate."', `Qenddate`='".$Qenddate."' WHERE `HospNo`='".$HospNo."' AND `date`='".$date."' AND `drugID`='".$drugID."'");
}*/
	$db2a = new DB;
	$db2a->query("INSERT INTO `nurseform17` VALUES ('".$HospNo."', '".$date."', '".$drugID."',  '".$Qmedicine."', '".$Qsource."', '".$Qeffect."', '".$QeffectOption."', '".$Qusage."', '".$Qdose."', '".$Qdoseq."', '".$Qway."', '".$Qmedtime."', '".$Qmedday."', '".$Qfreq."', '".$Qstartdate."', '".$Qenddate."', '".$Qdoctor."', '', '".$_SESSION['ncareID_lwj']."')");
} elseif (@$_GET['action']=="edit") {
	$date = str_replace('/','',$date);
	$db2a = new DB;
	$db2a->query("UPDATE `nurseform17` SET `Qsource`='".$Qsource."', `Qeffect`='".$Qeffect."', `QeffectOption`='".$QeffectOption."', `Qusage`='".$Qusage."', `Qdose`='".$Qdose."', `Qdoseq`='".$Qdoseq."', `Qway`='".$Qway."', `Qmedtime`='".$Qmedtime."', `Qmedday`='".$Qmedday."', `Qfreq`='".$Qfreq."', `Qstartdate`='".$Qstartdate."', `Qenddate`='".$Qenddate."', `Qdoctor`='".$Qdoctor."' WHERE `HospNo`='".$HospNo."' AND `date`='".$date."' AND `order`='".$order."'");
}
?>
<script>window.location.href = 'index.php?mod=nurseform&func=formview&pid=<?php echo @$_GET['pid']; ?>&id=17';</script>