<?php
//計算年齡 calculate age
function calcage($birth) {
	$birthy = substr($birth,0,4);
	$birthm = substr($birth,4,2);
	$birthd = substr($birth,6,2);
	$bloody = date(Y);
	$bloodm = date(m);
	$bloodd = date(d);
	$bloodconv=mktime(0,0,0,$bloodm,$bloodd,$bloody);
	$birthconv=mktime(0,0,0,$birthm,$birthd,$birthy);
	$ageconv = ($bloodconv - $birthconv)/31557600;
	round($ageconv,1);
	$arrage = explode('.',$ageconv);
	$age_y = $arrage[0];
	$age_m = round(('0.'.$arrage[1])*12);
	if ($birth!="") {
		$ageconv = $age_y.'y'.$age_m.'m';
	} else {
		$ageconv = "---";
	}
	return $ageconv;
}

//計算年齡 calculage age
function calcagenum($birth) {
	$birthy = substr($birth,0,4);
	$birthm = substr($birth,4,2);
	$birthd = substr($birth,6,2);
	$bloody = date(Y);
	$bloodm = date(m);
	$bloodd = date(d);
	$bloodconv=mktime(0,0,0,$bloodm,$bloodd,$bloody);
	$birthconv=mktime(0,0,0,$birthm,$birthd,$birthy);
	$ageconv = ($bloodconv - $birthconv)/31557600;
	round($ageconv,1);
	$arrage = explode('.',$ageconv);
	$age_y = $arrage[0];
	$age_m = round(('0.'.$arrage[1])*12);
	if ($birth!="") {
		$ageconv = $age_y.'.'.$age_m;
	} else {
		$ageconv = "---";
	}
	return $ageconv;
}

//計算星期 calculate week
function getweek() {
	$t = time()+3600*8;
	$weeks[0] = date("Y-m-d",$t-3600*24*6);
	$weeks[1] = date("Y-m-d",$t-3600*24*5);
	$weeks[2] = date("Y-m-d",$t-3600*24*4);
	$weeks[3] = date("Y-m-d",$t-3600*24*3);
	$weeks[4] = date("Y-m-d",$t-3600*24*2);
	$weeks[5] = date("Y-m-d",$t-3600*24*1);
	$weeks[6] = date("Y-m-d",$t);
	return $weeks;
}

//轉換日期格式 Date Format Conversion
function formatdate($date) {
	if ($date!="0") {
		$year = substr($date,0,4);
		$month = substr($date,4,2);
		$day = substr($date,6,2);
		$newdate = $year."/".$month."/".$day;
	} else {
		$newdate = "---";
	}
	return $newdate;
}

//顯示checked  Display checked
function drawchecked($var,$thres) {
	if ($var==$thres) {
		return " checked";
	}
}

//顯示selected Display checked
function drawselected($var,$thres) {
	if ($var==$thres) {
		return " selected";
	}
}

//繪製表單選項按鈕 Draw Form Options check box
function draw_checkbox($id, $text, $pre, $multi) {
	$textarray = explode(";",$text);
	$prearray = explode(";",$pre);
	foreach ($prearray as $k=>$v) {
		if (in_array(($k+1),$prearray)) { $value = 1; } else { $value = 0; }
		$result .= '<input type="hidden" name="'.$id.'_'.($k+1).'" id="'.$id.'_'.($k+1).'" value="'.$value.'">';
		if ($v!="") { $result .= '<font size="5">&#9745;</font> '.$textarray[($v-1)]."<br>\n"; }
	}
	return $result;
}

//繪製表單選項按鈕 Draw Form Options button
function draw_option($id, $text, $size, $multi, $pre, $br, $brn) {
	$textarray = explode(";",$text);
	$prearray = explode(";",$pre);
	if (count($textarray)==2) {
		foreach ($textarray as $k=>$v) {
			if (in_array(($k+1),$prearray)) { $result .= $v.', '; }
		}
	} else {
		foreach ($textarray as $k=>$v) {
			if (in_array(($k+1),$prearray)) { $result .= $v.', '; }
		}
	}
	$result = substr($result,0,strlen($result)-2);
	return $result;
}

//縣市選單 State/City information menu list
function city_selection($id, $preselect) {
	$result = '<select name="'.$id.'" id="'.$id.'">';
	$arrCity = array();
	$db0 = new DB;
	$db0->query("SELECT DISTINCT  `city` FROM  `address`");
	for ($i=0;$i<$db0->num_rows();$i++) {
		$r0 = $db0->fetch_assoc();
		$result .= '<option value="'.$r0['city'].'"';
		if ($preselect == $r0['city']) { $result .= " selected"; }
		$result .= '>'.$r0['city'].'</option>';
	}
	$result .= '</select>';
	return $result;
}

//鄉鎮市區選單 Townships menu list
function town_selection($id, $preselect) {
	$result = '<select name="'.$id.'" id="'.$id.'">';
	$arrTown = array();
	$db0 = new DB;
	$db0->query("SELECT DISTINCT  `town` FROM  `address` WHERE `city`='台北市'");
	for ($i=0;$i<$db0->num_rows();$i++) {
		$r0 = $db0->fetch_assoc();
		$result .= '<option value="'.$r0['town'].'"';
		if ($preselect == $r0['town']) { $result .= " selected"; }
		$result .= '>'.$r0['town'].'</option>';
	}
	$result .= '</select>';
	return $result;
}

//計算天數   calculate days 
function calcdays($startdate) {
	$startymd = substr($startdate,0,4).'-'.substr($startdate,4,2).'-'.substr($startdate,6,2);
	$starthms = '00-00-00';
	$array_ymd = explode('-', $startymd );
	$array_hms = explode('-', $starthms);
	$startdate =mktime($array_hms[0],$array_hms[1],$array_hms[2],$array_ymd[1],$array_ymd[2],$array_ymd[0]);
	$enddate = mktime();
	$days=(($enddate-$startdate)/3600)/24 ;
	return round($days);
}

//計算天數   calculate days 
function calcperiod($startdate,$enddate) {
	$startymd = substr($startdate,0,4).'-'.substr($startdate,4,2).'-'.substr($startdate,6,2);
	$starthms = '00-00-00';
	$array_ymd = explode('-', $startymd );
	$array_hms = explode('-', $starthms);
	$endmd = substr($enddate,0,4).'-'.substr($enddate,4,2).'-'.substr($enddate,6,2);
	$array_ymd2 = explode('-', $endmd );
	$startdate =mktime($array_hms[0],$array_hms[1],$array_hms[2],$array_ymd[1],$array_ymd[2],$array_ymd[0]);
	$enddate = mktime('00','00','00',$array_ymd2[1],$array_ymd2[2],$array_ymd2[0]);
	$days=((($enddate-$startdate)/3600)/24)+1 ;
	return round($days);
}

//回傳使用者名稱  return user's name
function checkusername($userID) {
	$dbuser = new DB;
	$dbuser->query("SELECT `name` FROM `userinfo` WHERE `userID`='".$userID."'");
	$ruser = $dbuser->fetch_assoc();
	return $ruser['name'];
}

//回傳住民性別  return resident's gender
function checkgender($pid) {
	$db = new DB;
	$db->query("SELECT `Gender_1`, `Gender_2` FROM `patient` WHERE `patientID`='".$pid."'");
	$r = $db->fetch_assoc();
	if ($r['Gender_1']==1) {
		$sex = "Male";
	} elseif ($r['Gender_2']==1) {
		$sex = "Female";
	} else {
		$sex = "---";
	}
	return $sex;
}

//回傳病歷號碼 return Hospital number
function getHospNo($pid) {
	$db = new DB;
	$db->query("SELECT `HospNo` FROM `patient` WHERE `patientID`='".$pid."'");
	$r = $db->fetch_assoc();
	return $r['HospNo'];
}

//藥單日曆 (含文字) drug prescription calender (include text)
function drawmedcalwithtext() {
	$arrWeekDay = array("日","一","二","三","四","五","六");//week array
	//$num = cal_days_in_month(CAL_GREGORIAN, (int) substr(@$_GET['date'],4,2), substr(@$_GET['date'],0,4));
	$num = date('t', mktime(0, 0, 0, ((int) substr(@$_GET['date'],4,2))+1, 0, substr(@$_GET['date'],0,4)));
	for ($i=1;$i<=$num;$i++) {
		$week = date("w",mktime(0,0,0,(int) substr(@$_GET['date'],4,2),$i,substr(@$_GET['date'],0,4)));
		$result .= '<td>'.$i.'<br>'.$arrWeekDay[$week].'</td>';
	}
	return $result;
}

//藥單日曆 (空表格) drug prescription calender (blank form)
function drawmedcal($bg,$medDay) {
	$bg = explode(";",$bg);
	$medDay = explode(";",$medDay);
	$num = date('t', mktime(0, 0, 0, ((int) substr(@$_GET['date'],4,2))+1, 0, substr(@$_GET['date'],0,4)));
	if (in_array('7',$medDay)) {
		//每天用藥 daily base medicine(drug)
		for ($i=1;$i<=$num;$i++) {
			$result .= '<td width="27" ';
			if (in_array($i,$bg)) { $result .= ' class="title"'; }
			$result .= '>&nbsp;</td>';
		}
	} elseif (in_array('8',$medDay)) {
		//隔天 the next day or once two days
		$dayno = 0;
		for ($i=1;$i<=$num;$i++) {
			$result .= '<td width="27" ';
			if (in_array($i,$bg)) {
				if (($dayno%2)==0) {
					$result .= ' class="title"';
				}
				$dayno+=1;
			}
			$result .= '>&nbsp;</td>';
		}
	} else {
		//一般天數 general number of days
		for ($i=1;$i<=$num;$i++) {
			$week = date("w",mktime(0,0,0,(int) substr(@$_GET['date'],4,2),$i,substr(@$_GET['date'],0,4)));
			$result .= '<td width="27" ';
			if (in_array($i,$bg)) {
				if (in_array($week-1,$medDay)) {
					$result .= ' class="title"';
				}
			}
			$result .= '>&nbsp;</td>';
		}
	}
	return $result;
}

//菜單計算日期用  calculation for the meal date
function monthlastday($month,$year) {
	$arrMonth = array('','January','February','March','April','May','June','July','August','September','October','November','December');
	$lastmonth = '1 '.$arrMonth[$month].' '.$year;
	$lastmonth_days = date(t,strtotime($lastmonth));
	return $lastmonth_days;
}

//菜單計算日期用 calculation for the meal date
function weekcount($date) {
	$year = substr($date,0,4);
	$month = substr($date,4,2);
	$day = substr($date,6,2);
	$weekcount = 1;
	for ($i=1;$i<=$day;$i++) {
		$wday = date(w,strtotime($year.'-'.$month.'-'.$i));
		if ($wday=="0") { $weekcount += 1; }
	}
	return $weekcount;
}
?>