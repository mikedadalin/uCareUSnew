<?php
$db1 = new DB;
$db1->query("SELECT * FROM `opdinfo` WHERE `opdID`='".mysql_real_escape_string(@$_GET['opdID'])."' ORDER BY `date` DESC");
$r1 = $db1->fetch_assoc();
$arrSelectedList = explode(';',$r1['patient']);

$totalNo = count($arrSelectedList);
$nowNo = $_GET['nowNo'];

if ($nowNo == '') { $nowNo = 0; }

$v = $arrSelectedList[$nowNo];

$db0 = new DB;
$db0->query("DELETE FROM `opddata` WHERE `opdID`='".mysql_real_escape_string(@$_GET['opdID'])."' AND `HospNo`='".mysql_real_escape_string($v)."'");

$count = $nowNo;

if ($_GET['action']=="end") {
	echo 'Generate reports完成，請<a href="index.php?mod=management&func=formview&id=26">按此</a>返回診間列表'."\n";
} else {
	echo 'Generate reports中，請稍候... ('.($count+1).'/'.$totalNo.')'."\n";

//foreach ($arrSelectedList as $k=>$v) {
	$db1a = new DB;
	$db1a->query("SELECT * FROM `nurseform01` WHERE `HospNo`='".$v."' ORDER BY `date` DESC LIMIT 0,1");
	$r1a = $db1a->fetch_assoc();
	$queryYear = date("Y",strtotime($r1['date']));
	$queryYearPrev = $queryYear - 1;
	$db1b = new DB;
	$db1b->query("SELECT DAY(`date`) AS DAY FROM `opdinfo` WHERE `date` LIKE '".$queryYearPrev."-12-%' AND `department`='".$r1['department']."' AND `patient` LIKE '%".$v."%'");
	$arrMaxSize = array();
	//藥單
	$arrMed = array();
	$db1c = new DB;
	$db1c->query("SELECT * FROM `nurseform17` WHERE `HospNo`='".$v."' AND `Qenddate` >= ".date("Y/m/d")." ORDER BY `order` ASC");
	$arrMaxSize[$v] = $db1c->num_rows();
	for ($i1c=0;$i1c<$db1c->num_rows();$i1c++) {
		$r1c = $db1c->fetch_assoc();
		$arrMed[$v][$i1c] = $r1c['Qmedicine'].' '.$r1c['Qusage'].' '.$r1c['Qfreq'];
	}
	//熱量
	$db1d = new DB;
	$db1d->query("SELECT `Q18` FROM `socialform33` WHERE `HospNo`='".$v."' ORDER BY `date` DESC LIMIT 0,1");
	$r1d = $db1d->fetch_assoc();
	//體重 (1)
	$db1e = new DB;
	// 原V $db1e->query("SELECT `Value` FROM `vitalsigns` WHERE `PersonID`='".getPID($v)."' AND `LoincCode`='18833-4' AND `IsValid`='1' ORDER BY `RecordedTime` DESC LIMIT 0,1");
	// 新V START
	$db1e->query("SELECT `loinc_18833_4` AS `Value` FROM `vitalsign` WHERE `PatientID`='".getPID($v)."' AND `loinc_18833_4`!='' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
	// 新V END
	$r1e = $db1e->fetch_assoc();
	$weight = $r1e['Value'];
	//體重 (2)
	$db1e = new DB;
	// 原V $db1e->query("SELECT `Value` FROM `vitalsigns` WHERE `PersonID`='".getPID($v)."' AND `LoincCode`='18833-4' AND `IsValid`='1' ORDER BY `RecordedTime` DESC LIMIT 1,1");
	// 新V START
	$db1e->query("SELECT `loinc_18833_4` AS `Value` FROM `vitalsign` WHERE `PatientID`='".getPID($v)."' AND `loinc_18833_4`!='' ORDER BY `date` DESC, `time` DESC LIMIT 1,1");
	// 新V END
	$r1e = $db1e->fetch_assoc();
	$weight2 = $r1e['Value'];
	//體重 (3)
	$db1e2 = new DB;
	// 原V $db1e2->query("SELECT `Value` FROM `vitalsigns` WHERE `PersonID`='".getPID($v)."' AND `LoincCode`='18833-4' AND `IsValid`='1' ORDER BY `RecordedTime` DESC LIMIT 2,1");
	// 新V START
	$db1e2->query("SELECT `loinc_18833_4` AS `Value` FROM `vitalsign` WHERE `PatientID`='".getPID($v)."' AND `loinc_18833_4`!='' ORDER BY `date` DESC, `time` DESC LIMIT 2,1");
	// 新V END
	$r1e2 = $db1e2->fetch_assoc();
	$weight3 = $r1e2['Value'];
	//身高
	$db1f = new DB;
	$db1f->query("SELECT `height` FROM `patient` WHERE `patientID`='".getPID($v)."'");
	$r1f = $db1f->fetch_assoc();
	$heightsq = $r1f['height']*$r1f['height'];
	$bmi = round($weight/$heightsq*703,1);
	$bmi2 = round($weight2/$heightsq*703,1);
	$bmi3 = round($weight3/$heightsq*703,1);
	//血糖 (早AC)
	$arrBGdate = array();
	$arrMorningAC = array();
	$Data_i = 1;
	$db1e = new DB;
	// 原V $db1e->query("SELECT YEAR(`RecordedTime`) as year, MONTH(`RecordedTime`) as month, DAY(`RecordedTime`) as day, `Value` FROM `vitalsigns` WHERE `PersonID`='".getPID($v)."' AND `LoincCode`='14743-9' AND `IsValid`='1' AND HOUR(`RecordedTime`)<=12 ORDER BY `RecordedTime` DESC LIMIT 0,8");
	// 新V START
	$db1e->query("SELECT YEAR(`date`) as year, MONTH(`date`) as month, DAY(`date`) as day, `loinc_14743_9` AS `Value` FROM `vitalsign` WHERE `PatientID`='".getPID($v)."' AND `loinc_14743_9`!='' AND `time`<=1200 ORDER BY `date` DESC, `time` DESC LIMIT 0,8");
	// 新V END
	for ($i1e=0;$i1e<$db1e->num_rows();$i1e++) {
		$r1e = $db1e->fetch_assoc();
		if ($r1e['Value']>0) {
			$arrMorningAC[$v][$r1e['year'].'/'.$r1e['month'].'/'.$r1e['day']] = $r1e['Value'];
			$arrBGdate[$v][$Data_i] = $r1e['year'].'/'.$r1e['month'].'/'.$r1e['day'];
			$Data_i++;
		}
	}
	//血糖 (早PC)
	$arrMorningPC = array();
	$db1e = new DB;
	// 原V $db1e->query("SELECT YEAR(`RecordedTime`) as year, MONTH(`RecordedTime`) as month, DAY(`RecordedTime`) as day, `Value` FROM `vitalsigns` WHERE `PersonID`='".getPID($v)."' AND `LoincCode`='15075-5' AND `IsValid`='1' AND HOUR(`RecordedTime`)<=12 ORDER BY `RecordedTime` DESC LIMIT 0,8");
	// 新V START
	$db1e->query("SELECT YEAR(`date`) as year, MONTH(`date`) as month, DAY(`date`) as day, `loinc_15075_5` AS `Value` FROM `vitalsign` WHERE `PatientID`='".getPID($v)."' AND `loinc_15075_5`!='' AND `time`<=1200 ORDER BY `date` DESC, `time` DESC LIMIT 0,8");
	// 新V END
	for ($i1e=0;$i1e<$db1e->num_rows();$i1e++) {
		$r1e = $db1e->fetch_assoc();
		if ($r1e['Value']>0) {
			$arrMorningPC[$v][$r1e['year'].'/'.$r1e['month'].'/'.$r1e['day']] = $r1e['Value'];
			$arrBGdate[$v][$Data_i] = $r1e['year'].'/'.$r1e['month'].'/'.$r1e['day'];
			$Data_i++;
		}
	}
	//血糖 (午AC)
	$arrNoonAC = array();
	$db1e = new DB;
	// 原V $db1e->query("SELECT YEAR(`RecordedTime`) as year, MONTH(`RecordedTime`) as month, DAY(`RecordedTime`) as day, `Value` FROM `vitalsigns` WHERE `PersonID`='".getPID($v)."' AND `LoincCode`='14743-9' AND `IsValid`='1' AND (HOUR(`RecordedTime`)>12 AND HOUR(`RecordedTime`)<=18) ORDER BY `RecordedTime` DESC LIMIT 0,8");
	// 新V START
	$db1e->query("SELECT YEAR(`date`) as year, MONTH(`date`) as month, DAY(`date`) as day, `loinc_14743_9` AS `Value` FROM `vitalsign` WHERE `PatientID`='".getPID($v)."' AND `loinc_14743_9`!='' AND (`time`>1200 AND `time`<=1800) ORDER BY `date` DESC, `time` DESC LIMIT 0,8");
	// 新V END
	for ($i1e=0;$i1e<$db1e->num_rows();$i1e++) {
		$r1e = $db1e->fetch_assoc();
		if ($r1e['Value']>0) {
			$arrNoonAC[$v][$r1e['year'].'/'.$r1e['month'].'/'.$r1e['day']] = $r1e['Value'];
			$arrBGdate[$v][$Data_i] = $r1e['year'].'/'.$r1e['month'].'/'.$r1e['day'];
			$Data_i++;
		}
	}
	//血糖 (午PC)
	$arrNoonPC = array();
	$db1e = new DB;
	// 原V $db1e->query("SELECT YEAR(`RecordedTime`) as year, MONTH(`RecordedTime`) as month, DAY(`RecordedTime`) as day, `Value` FROM `vitalsigns` WHERE `PersonID`='".getPID($v)."' AND `LoincCode`='15075-5' AND `IsValid`='1' AND (HOUR(`RecordedTime`)>12 AND HOUR(`RecordedTime`)<=18) ORDER BY `RecordedTime` DESC LIMIT 0,8");
	// 新V START
	$db1e->query("SELECT YEAR(`date`) as year, MONTH(`date`) as month, DAY(`date`) as day, `loinc_15075_5` AS `Value` FROM `vitalsign` WHERE `PatientID`='".getPID($v)."' AND `loinc_15075_5`!='' AND (`time`>1200 AND `time`<=1800) ORDER BY `date` DESC, `time` DESC LIMIT 0,8");
	// 新V END
	for ($i1e=0;$i1e<$db1e->num_rows();$i1e++) {
		$r1e = $db1e->fetch_assoc();
		if ($r1e['Value']>0) {
			$arrNoonPC[$v][$r1e['year'].'/'.$r1e['month'].'/'.$r1e['day']] = $r1e['Value'];
			$arrBGdate[$v][$i1e] = $r1e['year'].'/'.$r1e['month'].'/'.$r1e['day'];
			$Data_i++;
		}
	}
	//血糖 (晚AC)
	$arrNightAC = array();
	$db1e = new DB;
	// 原V $db1e->query("SELECT YEAR(`RecordedTime`) as year, MONTH(`RecordedTime`) as month, DAY(`RecordedTime`) as day, `Value` FROM `vitalsigns` WHERE `PersonID`='".getPID($v)."' AND `LoincCode`='14743-9' AND `IsValid`='1' AND HOUR(`RecordedTime`)>18 ORDER BY `RecordedTime` DESC LIMIT 0,8");
	// 新V START
	$db1e->query("SELECT YEAR(`date`) as year, MONTH(`date`) as month, DAY(`date`) as day, `loinc_14743_9` AS `Value` FROM `vitalsign` WHERE `PatientID`='".getPID($v)."' AND `loinc_14743_9`!='' AND `time`>1800 ORDER BY `date` DESC, `time` DESC LIMIT 0,8");
	// 新V END
	for ($i1e=0;$i1e<$db1e->num_rows();$i1e++) {
		$r1e = $db1e->fetch_assoc();
		if ($r1e['Value']>0) {
			$arrNightAC[$v][$r1e['year'].'/'.$r1e['month'].'/'.$r1e['day']] = $r1e['Value'];
			$arrBGdate[$v][$i1e] = $r1e['year'].'/'.$r1e['month'].'/'.$r1e['day'];
			$Data_i++;
		}
	}
	//血糖 (晚PC)
	$arrNightPC = array();
	$db1e = new DB;
	// 原V $db1e->query("SELECT YEAR(`RecordedTime`) as year, MONTH(`RecordedTime`) as month, DAY(`RecordedTime`) as day, `Value` FROM `vitalsigns` WHERE `PersonID`='".getPID($v)."' AND `LoincCode`='15075-5' AND `IsValid`='1' AND HOUR(`RecordedTime`)>18 ORDER BY `RecordedTime` DESC LIMIT 0,8");
	// 新V START
	$db1e->query("SELECT YEAR(`date`) as year, MONTH(`date`) as month, DAY(`date`) as day, `loinc_15075_5` AS `Value` FROM `vitalsign` WHERE `PatientID`='".getPID($v)."' AND `loinc_15075_5`!='' AND `time`>1800 ORDER BY `date` DESC, `time` DESC LIMIT 0,8");
	// 新V END
	for ($i1e=0;$i1e<$db1e->num_rows();$i1e++) {
		$r1e = $db1e->fetch_assoc();
		if ($r1e['Value']>0) {
			$arrNightPC[$v][$r1e['year'].'/'.$r1e['month'].'/'.$r1e['day']] = $r1e['Value'];
			$arrBGdate[$v][$i1e] = $r1e['year'].'/'.$r1e['month'].'/'.$r1e['day'];
			$Data_i++;
		}
	}
	if (count($arrBGdate[$v])>0) {
		$arrBGdate[$v] = array_unique($arrBGdate[$v]);
		natsort($arrBGdate[$v]);
		reset($arrBGdate[$v]);
		$arrBGdate[$v]=array_merge(array(),$arrBGdate[$v]);
	}
	//生理數值
	$arrVS1 = array();
	$arrVS1time = array();
	$arrVS1date = array();
	$arrVS2 = array();
	$arrVS2time = array();
	$arrVS2date = array();
	$db1f = new DB;
	// 原V $db1f->query("SELECT DISTINCT `RecordedTime` FROM `vitalsigns` WHERE `PersonID`='".getPID($v)."' AND `LoincCode`='8480-6' AND `IsValid`='1' ORDER BY `RecordedTime` DESC LIMIT 0,20");
	// 新V START
	$db1f->query("SELECT DISTINCT `date` FROM `vitalsign` WHERE `PatientID`='".getPID($v)."' AND `loinc_8480_6`!='' ORDER BY `date` DESC, `time` DESC LIMIT 0,20");
	// 新V END
	for ($i1f=0;$i1f<$db1f->num_rows();$i1f++) {
		$r1f = $db1f->fetch_assoc();
		
		//收縮壓
		$db1g = new DB;
		// 原V $db1g->query("SELECT MONTH(`RecordedTime`) as month, DAY(`RecordedTime`) as day, HOUR(`RecordedTime`) as hour, MINUTE(`RecordedTime`) as min, `Value` FROM `vitalsigns` WHERE `PersonID`='".getPID($v)."' AND `LoincCode`='8480-6' AND `RecordedTime`='".$r1f['RecordedTime']."' AND `IsValid`='1' ORDER BY `RecordedTime` ASC LIMIT 0,3");
		// 新V START
		$db1g->query("SELECT MONTH(`date`) as month, DAY(`date`) as day, HOUR(`time`) as hour, MINUTE(`time`) as min, `loinc_8480_6` AS `Value` FROM `vitalsign` WHERE `PatientID`='".getPID($v)."' AND `loinc_8480_6`!='' AND `date`='".$r1f['date']."' ORDER BY `date` ASC, `time` ASC LIMIT 0,3");
		// 新V END
		for ($i1g=0;$i1g<$db1g->num_rows();$i1g++) {
			$r1g = $db1g->fetch_assoc();
			$arrVS1[$v][$r1g['month'].'/'.$r1g['day']][$r1g['hour'].':'.$r1g['min']] = $r1g['Value'];
			if (count($arrVS1time[$v][$r1g['month'].'/'.$r1g['day']])==0) { $arrVS1time[$v][$r1g['month'].'/'.$r1g['day']] = array(); }
			array_push($arrVS1time[$v][$r1g['month'].'/'.$r1g['day']], $r1g['hour'].':'.$r1g['min']);
			if (count($arrVS1date[$v])==0) { $arrVS1date[$v] = array(); }
			if (!in_array($r1g['month'].'/'.$r1g['day'],$arrVS1date[$v])) { array_push($arrVS1date[$v], $r1g['month'].'/'.$r1g['day']); }
		}
		
		//舒張壓
		$db1g = new DB;
		// 原V $db1g->query("SELECT MONTH(`RecordedTime`) as month, DAY(`RecordedTime`) as day, HOUR(`RecordedTime`) as hour, MINUTE(`RecordedTime`) as min, `Value` FROM `vitalsigns` WHERE `PersonID`='".getPID($v)."' AND `LoincCode`='8462-4' AND `RecordedTime`='".$r1f['RecordedTime']."' AND `IsValid`='1' ORDER BY `RecordedTime` ASC LIMIT 0,3");
		// 新V START
		$db1g->query("SELECT MONTH(`date`) as month, DAY(`date`) as day, HOUR(`time`) as hour, MINUTE(`time`) as min, `loinc_8462_4` AS `Value` FROM `vitalsign` WHERE `PatientID`='".getPID($v)."' AND `loinc_8462_4`!='' AND `date`='".$r1f['date']."' ORDER BY `date` ASC, `time` ASC LIMIT 0,3");
		// 新V END
		for ($i1g=0;$i1g<$db1g->num_rows();$i1g++) {
			$r1g = $db1g->fetch_assoc();
			$arrVS2[$v][$r1g['month'].'/'.$r1g['day']][$r1g['hour'].':'.$r1g['min']] = $r1g['Value'];
			if (count($arrVS2time[$v][$r1g['month'].'/'.$r1g['day']])==0) { $arrVS2time[$v][$r1g['month'].'/'.$r1g['day']] = array(); }
			array_push($arrVS2time[$v][$r1g['month'].'/'.$r1g['day']], $r1g['hour'].':'.$r1g['min']);
			if (count($arrVS2date[$v])==0) { $arrVS2date[$v] = array(); }
			if (!in_array($r1g['month'].'/'.$r1g['day'],$arrVS2date[$v])) { array_push($arrVS2date[$v], $r1g['month'].'/'.$r1g['day']); }
		}
		
		//心跳
		$db1g = new DB;
		// 原V $db1g->query("SELECT MONTH(`RecordedTime`) as month, DAY(`RecordedTime`) as day, HOUR(`RecordedTime`) as hour, MINUTE(`RecordedTime`) as min, `Value` FROM `vitalsigns` WHERE `PersonID`='".getPID($v)."' AND `LoincCode`='8867-4' AND `RecordedTime`='".$r1f['RecordedTime']."' AND `IsValid`='1' ORDER BY `RecordedTime` ASC LIMIT 0,3");
		// 新V START
		$db1g->query("SELECT MONTH(`date`) as month, DAY(`date`) as day, HOUR(`time`) as hour, MINUTE(`time`) as min, `loinc_8867_4` AS `Value` FROM `vitalsign` WHERE `PatientID`='".getPID($v)."' AND `loinc_8867_4`!='' AND `date`='".$r1f['date']."' ORDER BY `date` ASC, `time` ASC LIMIT 0,3");
		// 新V END
		for ($i1g=0;$i1g<$db1g->num_rows();$i1g++) {
			$r1g = $db1g->fetch_assoc();
			$arrVS3[$v][$r1g['month'].'/'.$r1g['day']][$r1g['hour'].':'.$r1g['min']] = $r1g['Value'];
			if (count($arrVS3time[$v][$r1g['month'].'/'.$r1g['day']])==0) { $arrVS3time[$v][$r1g['month'].'/'.$r1g['day']] = array(); }
			array_push($arrVS3time[$v][$r1g['month'].'/'.$r1g['day']], $r1g['hour'].':'.$r1g['min']);
			if (count($arrVS3date[$v])==0) { $arrVS3date[$v] = array(); }
			if (!in_array($r1g['month'].'/'.$r1g['day'],$arrVS3date[$v])) { array_push($arrVS3date[$v], $r1g['month'].'/'.$r1g['day']); }
		}
	}
	
	$data = ($count+1).'||'.getBedID(getPID($v)).'||'.getPatientName(getPID($v)).'||'.calcagenum(str_replace('/','',formatdate(getPatientBOD(getPID($v))))).'||'.$r1a['Qdiag1'].'||'.$arrMed[$v][0].'||'.$r1d['Q18'].'||'.$weight.'||'.$bmi.'||'.$arrBGdate[$v][0].'||'.$arrMorningAC[$v][$arrBGdate[$v][0]].'||'.$arrMorningPC[$v][$arrBGdate[$v][0]].'||'.$arrNoonAC[$v][$arrBGdate[$v][0]].'||'.$arrNoonPC[$v][$arrBGdate[$v][0]].'||'.$arrNightAC[$v][$arrBGdate[$v][0]].'||'.$arrNightPC[$v][$arrBGdate[$v][0]];
	$db2a = new DB;
	$db2a->query("INSERT INTO `opddata` VALUES ('".mysql_real_escape_string(@$_GET['opdID'])."', '".mysql_real_escape_string($v)."', '', '".$data."')");
	
	if ($arrMaxSize[$v]>10) { $maxsize = $arrMaxSize[$v]; } else { $maxsize=9; }
	for ($i=1;$i<=$maxsize;$i++) {
		//first column
		if ($i==1||$i==5) { ${'data'.$i} = $arrVS1date[$v][($i-1)]; }   //量心跳血壓日期
		elseif ($i==2||$i==6) { ${'data'.$i} = $arrVS1[$v][$arrVS1date[$v][($i-2)]][$arrVS1time[$v][$arrVS1date[$v][($i-2)]][0]].'/'.$arrVS2[$v][$arrVS2date[$v][($i-2)]][$arrVS2time[$v][$arrVS2date[$v][($i-2)]][0]].'/'.$arrVS3[$v][$arrVS3date[$v][($i-2)]][$arrVS3time[$v][$arrVS3date[$v][($i-2)]][0]]; }   //收縮壓/舒張壓/心跳  早
		elseif ($i==3||$i==7) { ${'data'.$i} = $arrVS1[$v][$arrVS1date[$v][($i-3)]][$arrVS1time[$v][$arrVS1date[$v][($i-3)]][1]].'/'.$arrVS2[$v][$arrVS2date[$v][($i-3)]][$arrVS2time[$v][$arrVS2date[$v][($i-3)]][1]].'/'.$arrVS3[$v][$arrVS3date[$v][($i-3)]][$arrVS3time[$v][$arrVS3date[$v][($i-3)]][1]]; }   //收縮壓/舒張壓/心跳  中
		elseif ($i==4||$i==8) { ${'data'.$i} = $arrVS1[$v][$arrVS1date[$v][($i-4)]][$arrVS1time[$v][$arrVS1date[$v][($i-4)]][2]].'/'.$arrVS2[$v][$arrVS2date[$v][($i-4)]][$arrVS2time[$v][$arrVS2date[$v][($i-4)]][2]].'/'.$arrVS3[$v][$arrVS3date[$v][($i-4)]][$arrVS3time[$v][$arrVS3date[$v][($i-4)]][2]]; }   //收縮壓/舒張壓/心跳  晚
		//else { ${'data'.$i} = '||'; }
		//second column
		if ($i==1||$i==5) { ${'data'.$i} .= '||' . $arrVS1date[$v][($i)]; }   //量心跳血壓日期
		elseif ($i==2||$i==6) { ${'data'.$i} .= '||' . $arrVS1[$v][$arrVS1date[$v][($i-1)]][$arrVS1time[$v][$arrVS1date[$v][($i-1)]][0]].'/'.$arrVS2[$v][$arrVS2date[$v][($i-1)]][$arrVS2time[$v][$arrVS2date[$v][($i-1)]][0]].'/'.$arrVS3[$v][$arrVS3date[$v][($i-1)]][$arrVS3time[$v][$arrVS3date[$v][($i-1)]][0]]; }   //收縮壓/舒張壓/心跳  早
		elseif ($i==3||$i==7) { ${'data'.$i} .= '||' . $arrVS1[$v][$arrVS1date[$v][($i-2)]][$arrVS1time[$v][$arrVS1date[$v][($i-2)]][1]].'/'.$arrVS2[$v][$arrVS2date[$v][($i-2)]][$arrVS2time[$v][$arrVS2date[$v][($i-2)]][1]].'/'.$arrVS3[$v][$arrVS3date[$v][($i-2)]][$arrVS3time[$v][$arrVS3date[$v][($i-2)]][1]]; }   //收縮壓/舒張壓/心跳  中
		elseif ($i==4||$i==8) { ${'data'.$i} .= '||' . $arrVS1[$v][$arrVS1date[$v][($i-3)]][$arrVS1time[$v][$arrVS1date[$v][($i-3)]][2]].'/'.$arrVS2[$v][$arrVS2date[$v][($i-3)]][$arrVS2time[$v][$arrVS2date[$v][($i-3)]][2]].'/'.$arrVS3[$v][$arrVS3date[$v][($i-3)]][$arrVS3time[$v][$arrVS3date[$v][($i-3)]][2]]; }   //收縮壓/舒張壓/心跳  晚
		else { ${'data'.$i} .= '||'; }
		//third column
		if ($i==1||$i==5) { ${'data'.$i} .= '||' . $arrVS1date[$v][($i+1)]; }   //量心跳血壓日期
		elseif ($i==2||$i==6) { ${'data'.$i} .= '||' . $arrVS1[$v][$arrVS1date[$v][($i)]][$arrVS1time[$v][$arrVS1date[$v][($i)]][0]].'/'.$arrVS2[$v][$arrVS2date[$v][($i)]][$arrVS2time[$v][$arrVS2date[$v][($i)]][0]].'/'.$arrVS3[$v][$arrVS3date[$v][($i)]][$arrVS3time[$v][$arrVS3date[$v][($i)]][0]]; }   //收縮壓/舒張壓/心跳  早
		elseif ($i==3||$i==7) { ${'data'.$i} .= '||' . $arrVS1[$v][$arrVS1date[$v][($i-1)]][$arrVS1time[$v][$arrVS1date[$v][($i-1)]][1]].'/'.$arrVS2[$v][$arrVS2date[$v][($i-1)]][$arrVS2time[$v][$arrVS2date[$v][($i-1)]][1]].'/'.$arrVS3[$v][$arrVS3date[$v][($i-1)]][$arrVS3time[$v][$arrVS3date[$v][($i-1)]][1]]; }   //收縮壓/舒張壓/心跳  中
		elseif ($i==4||$i==8) { ${'data'.$i} .= '||' . $arrVS1[$v][$arrVS1date[$v][($i-2)]][$arrVS1time[$v][$arrVS1date[$v][($i-2)]][2]].'/'.$arrVS2[$v][$arrVS2date[$v][($i-2)]][$arrVS2time[$v][$arrVS2date[$v][($i-2)]][2]].'/'.$arrVS3[$v][$arrVS3date[$v][($i-2)]][$arrVS3time[$v][$arrVS3date[$v][($i-2)]][2]]; }   //收縮壓/舒張壓/心跳  晚
		else { ${'data'.$i} .= '||'; }
		//forth column
		if ($i==1||$i==5) { ${'data'.$i} .= '||' . $arrVS1date[$v][($i+2)]; }   //量心跳血壓日期 but目前只取3筆 所以這行下面都是空的
		elseif ($i==2||$i==6) { ${'data'.$i} .= '||' . $arrVS1[$v][$arrVS1date[$v][($i+1)]][$arrVS1time[$v][$arrVS1date[$v][($i+1)]][0]].'/'.$arrVS2[$v][$arrVS2date[$v][($i+1)]][$arrVS2time[$v][$arrVS2date[$v][($i+1)]][0]].'/'.$arrVS3[$v][$arrVS3date[$v][($i+1)]][$arrVS3time[$v][$arrVS3date[$v][($i+1)]][0]]; }   //收縮壓/舒張壓/心跳  早
		elseif ($i==3||$i==7) { ${'data'.$i} .= '||' . $arrVS1[$v][$arrVS1date[$v][($i+2)]][$arrVS1time[$v][$arrVS1date[$v][($i+2)]][1]].'/'.$arrVS2[$v][$arrVS2date[$v][($i+2)]][$arrVS2time[$v][$arrVS2date[$v][($i+2)]][1]].'/'.$arrVS3[$v][$arrVS3date[$v][($i+2)]][$arrVS3time[$v][$arrVS3date[$v][($i+2)]][1]]; }   //收縮壓/舒張壓/心跳  中
		elseif ($i==4||$i==8) { ${'data'.$i} .= '||' . $arrVS1[$v][$arrVS1date[$v][($i+3)]][$arrVS1time[$v][$arrVS1date[$v][($i+3)]][2]].'/'.$arrVS2[$v][$arrVS2date[$v][($i+3)]][$arrVS2time[$v][$arrVS2date[$v][($i+3)]][2]].'/'.$arrVS3[$v][$arrVS3date[$v][($i+3)]][$arrVS3time[$v][$arrVS3date[$v][($i+3)]][2]]; }   //收縮壓/舒張壓/心跳  晚
		else { ${'data'.$i} .= '||'; }
		//other columns
		${'data'.$i} .= '||' . $r1a['Qdiag'.($i+1)];    //診斷
		${'data'.$i} .= '||' . $arrMed[$v][$i];         //用藥
		${'data'.$i} .= '||' . '&nbsp;';                //熱量
		${'data'.$i} .= '||' . ($i==1?$weight2:($i==2?$weight3:""));   //體重
		${'data'.$i} .= '||' . ($i==1?$bmi2:($i==2?$bmi3:""));         //BMI 
		${'data'.$i} .= '||' . $arrBGdate[$v][$i];                     //量血糖日期
		${'data'.$i} .= '||' . $arrMorningAC[$v][$arrBGdate[$v][$i]];  //早飯前
		${'data'.$i} .= '||' . $arrMorningPC[$v][$arrBGdate[$v][$i]];  //早飯後
		${'data'.$i} .= '||' . $arrNoonAC[$v][$arrBGdate[$v][$i]];     //午飯前
		${'data'.$i} .= '||' . $arrNoonPC[$v][$arrBGdate[$v][$i]];     //午飯後
		${'data'.$i} .= '||' . $arrNightAC[$v][$arrBGdate[$v][$i]];    //晚飯前
		${'data'.$i} .= '||' . $arrNightPC[$v][$arrBGdate[$v][$i]];    //晚飯後
		$db2b = new DB;
		$db2b->query("INSERT INTO `opddata` VALUES ('".mysql_real_escape_string(@$_GET['opdID'])."', '".mysql_real_escape_string($v)."', '', '".mysql_escape_string(${'data'.$i})."')");
	}
	if ($nowNo<$totalNo) { $count++; echo '<script>window.location.href=\'index.php?mod=management&func=formview&id=26e&opdID='.$_GET['opdID'].'&nowNo='.$count.'\'</script>'; } else {
		echo '<script>window.location.href=\'index.php?mod=management&func=formview&id=26e&opdID='.$_GET['opdID'].'&nowNo='.$count.'&action=end\'</script>';
	}
}
?>