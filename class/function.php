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


//顯示checked
function drawchecked($var,$thres) {
	if ($var==$thres) {
		return " checked";
	}
}

//顯示selected   Display checked
function drawselected($var,$thres) {
	if ($var==$thres) {
		return " selected";
	}
}

//繪製表單選項核取方塊  Draw Form Options check box
function draw_checkbox($id, $text, $pre, $multi) {
	$textarray = explode(";",$text);
	$prearray = explode(";",$pre);
	$result = '<table border="0" class="tableinside">'."\n";
	foreach ($textarray as $k=>$v) {
		$result .= '<tr>';
		if (in_array(($k+1),$prearray)) { $value = 1; } else { $value = 0; }
		$result .= '<input type="hidden" name="'.$id.'_'.($k+1).'" id="'.$id.'_'.($k+1).'" value="'.$value.'">';
		//value="'.($k+1).'"
		$result .= '
		<td width="40" align="center" valign="middle">
		  <div class="checkbox';
		  if (in_array(($k+1),$prearray)) { $result .= '_hold'; } else { $result .= '_off'; }
		  $result .= '" onmouseover="hovercheckbox(this.id);" onmouseout="outcheckbox(this.id);" onclick="click_'.$multi.'_checkbox(this.id,\''.$id.'\',\''.count($textarray).'\');" id="btn_'.$id.'_'.($k+1).'"></div>
		</td>
		<td align="left" valign="middle">'.$v.'</td>
		</tr>'."\n";
	}
	$result .= "</table>\n";
	return $result;
}

//繪製表單選項按鈕 Draw Form Options button
function draw_option($id, $text, $size, $multi, $pre, $br, $brn) {
	$textarray = explode(";",$text);
	$prearray = explode(";",$pre);
	foreach ($textarray as $k=>$v) {
		if (in_array(($k+1),$prearray)) { $value = 1; } else { $value = 0; }		
		$result .= '<input type="hidden" name="'.$id.'_'.($k+1).'" id="'.$id.'_'.($k+1).'" value="'.$value.'">';
		//value="'.($k+1).'"
	}
	if (count($textarray)==2) {
		foreach ($textarray as $k=>$v) {
			$pos = "";
			if ($k==0) { $pos = 'left'; } else { $pos = 'right'; }
			$result .= '<div class="tabbtn_'.$size.'_'.$pos;
			if (in_array(($k+1),$prearray)) { $result .= '_hold'; } else { $result .= '_off'; }
			$result .= '" onmouseover="hoverbtn(this.id,\''.$pos.'\',\''.$size.'\');" onmouseout="outbtn(this.id,\''.$pos.'\',\''.$size.'\');" onclick="click_'.$multi.'_btn(this.id,\''.$pos.'\',\''.$size.'\',\''.$id.'\',\''.count($textarray).'\');" id="btn_'.$id.'_'.($k+1).'"><span>'.$v.'</span></div>';
		}
	} else {
		if ($br) {
			foreach ($textarray as $k=>$v) {
				$pos = "";
				$return = "";
				if ($k%$brn==0) { $pos = 'left'; } elseif ($k==count($textarray)-1) { $pos = 'right'; } elseif ($k%$brn==($brn-1)) { $pos = 'right'; $return="<br>"; } else { $pos = 'middle'; }
				$result .= '<div class="tabbtn_'.$size.'_'.$pos;
				if (in_array(($k+1),$prearray)) { $result .= '_hold'; } else { $result .= '_off'; }
				$result .= '" onmouseover="hoverbtn(this.id,\''.$pos.'\',\''.$size.'\');" onmouseout="outbtn(this.id,\''.$pos.'\',\''.$size.'\');" onclick="click_'.$multi.'_btn(this.id,\''.$pos.'\',\''.$size.'\',\''.$id.'\',\''.count($textarray).'\');" id="btn_'.$id.'_'.($k+1).'"><span>'.$v.'</span></div>';
				$result .= $return;
			}
		} else {
			foreach ($textarray as $k=>$v) {
				$pos = "";
				$return = "";
				if ($k==0) { $pos = 'left'; } elseif ($k==count($textarray)-1) { $pos = 'right'; } else { $pos = 'middle'; }
				$result .= '<div class="tabbtn_'.$size.'_'.$pos;
				if (in_array(($k+1),$prearray)) { $result .= '_hold'; } else { $result .= '_off'; }
				$result .= '" onmouseover="hoverbtn(this.id,\''.$pos.'\',\''.$size.'\');" onmouseout="outbtn(this.id,\''.$pos.'\',\''.$size.'\');" onclick="click_'.$multi.'_btn(this.id,\''.$pos.'\',\''.$size.'\',\''.$id.'\',\''.count($textarray).'\');" id="btn_'.$id.'_'.($k+1).'"><span>'.$v.'</span></div>';
				$result .= $return;
			}
		}
	}
	return $result;
}

//縣市選單  State/City information menu list
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

//鄉鎮市區選單  Townships menu list
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

//計算天數 (至計算當日)   calculate days (until that day)
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

//計算天數 (輸入兩天的時間差)  calculate days (input two dates' time difference)
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

//計算天數 (輸入兩天的時間差) 天數為整數，小時轉為點數 calculate days (input two dates' time difference) day become integer, hours become decimal
function calcperiodwithtime($startdate,$starttime,$enddate,$endtime) {
	$startymd = substr($startdate,0,4).'-'.substr($startdate,4,2).'-'.substr($startdate,6,2);
	$starthms = substr($starttime,0,2).'-'.substr($starttime,2,2).'-00';
	$array_ymd = explode('-', $startymd );
	$array_hms = explode('-', $starthms);
	$endmd = substr($enddate,0,4).'-'.substr($enddate,4,2).'-'.substr($enddate,6,2);
	$array_ymd2 = explode('-', $endmd );
	$startdate =mktime($array_hms[0],$array_hms[1],$array_hms[2],$array_ymd[1],$array_ymd[2],$array_ymd[0]);
	$enddate = mktime(substr($endtime,0,2),'00',substr($endtime,2,2),$array_ymd2[1],$array_ymd2[2],$array_ymd2[0]);
	$days=((($enddate-$startdate)/3600)/24) ;
	$days = round($days,1);
	$daycount = explode (".",$days);
	if ($daycount[1]>=5) {
		$decimal = '5';
	} else {
		$decimal = '0';
	}
	$daycounted = $daycount[0].'.'.$decimal;
	return $daycounted;
}

//回傳使用者名稱  return user's name
function checkusername($userID) {
	$dbuser = new DB;
	$dbuser->query("SELECT `name` FROM `userinfo` WHERE `userID`='".$userID."'");
	$ruser = $dbuser->fetch_assoc();
	return $ruser['name'];
}

//回傳住民性別 return resident's gender
function checkgender($pid) {
	$db = new DB;
	$db->query("SELECT `Gender_1`, `Gender_2` FROM `patient` WHERE `patientID`='".$pid."'");
	$r = $db->fetch_assoc();
	if ($r['Gender_1']==1) {
		$sex = "Male";// male
	} elseif ($r['Gender_2']==1) {
		$sex = "Female";//female
	} else {
		$sex = "---";
	}
	return $sex;
}

//回傳病歷號碼  return Hospital number
function getHospNo($pid) {
	$db = new DB;
	$db->query("SELECT `HospNo` FROM `patient` WHERE `patientID`='".$pid."'");
	$r = $db->fetch_assoc();
	return $r['HospNo'];
}

//回傳病人ID  return patient's ID
function getPID($HospNo) {
	$db = new DB;
	$db->query("SELECT `patientID` FROM `patient` WHERE `HospNo`='".$HospNo."'");
	$r = $db->fetch_assoc();
	return $r['patientID'];
}

//菜單計算日期用 calculation for the meal date
function monthlastday($month,$year) {
	$arrMonth = array('','January','February','March','April','May','June','July','August','September','October','November','December');
	$lastmonth = '1 '.$arrMonth[$month].' '.$year;
	$lastmonth_days = date(t,strtotime($lastmonth));
	return $lastmonth_days;
}

//菜單計算日期用 //calculation for the meal date
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

//計算$startdate起後$period天數之日期
function calcdayafterday($startdate,$period) {
	$startdate = str_replace("/","",$startdate);
	$period = str_replace("天","",$period);
	$startdate = substr($startdate,0,4).'-'.substr($startdate,4,2).'-'.substr($startdate,6,2);
	$enddate = date('Y/m/d',strtotime($startdate.' +'.$period.' days'));
	return $enddate;
}

//機構DB, dailypatientno/dialypatientno1, Date
function autoPatNo($DBname, $tablename, $date) {
	
	$dayBefore = calcdayafterday($date, -1);
	
	//新入住人數
	$dbstat2a = new DB;
	$dbstat2a->query("SELECT * FROM `".$DBname."`.`inpatientinfo` WHERE `indate`='".$date."'");
	$dbstat2b = new DB;
	$dbstat2b->query("SELECT * FROM `".$DBname."`.`general_io` WHERE `indate`='".$date."'");
	$NewpatientNo = $dbstat2a->num_rows() + $dbstat2b->num_rows();
	
	//退住人數
	$dbstat3 = new DB;
	$dbstat3->query("SELECT * FROM `".$DBname."`.`closedcase` WHERE `outdate`='".$date."'");
	$OutpatientNo = $dbstat3->num_rows();
	
	//目前在院人數
	$dbstat1 = new DB;
	$dbstat1->query("SELECT * FROM `".$DBname."`.`inpatientinfo` WHERE `indate`<='".$date."'");
	$InpatientNo = $dbstat1->num_rows();
	
	//使用尿管人數
	$countFoley = 0;
	$dPeriod = str_replace("/","",calcdayafterday($date, -30));
	$dbstat3 = new DB;
	$dbstat3->query("SELECT * FROM `".$DBname."`.`nurseform02k` WHERE (`Q1`='1' OR `Q1`='2') AND `date`>='".$dPeriod."' AND `date`<='".$date."'");
	for ($i3=0;$i3<$dbstat3->num_rows();$i3++) {
		$r3 = $dbstat3->fetch_assoc();
		if (str_replace("/","",calcdayafterday($r3['date'],$r3['Q4']))>$date) {
			$countFoley++;
		}
	}
	
	//轉住院人數
	$dbstat4 = new DB;
	$dbstat4->query("SELECT * FROM `".$DBname."`.`general_io` WHERE `outdate`='".$date."' AND `reason_4`='1'");
	$HospPatient = $dbstat4->num_rows();
	
	//返回機構人數
	$dbstat5 = new DB;
	$dbstat5->query("SELECT * FROM `".$DBname."`.`general_io` WHERE `indate`='".$date."' AND `reason_4`='1'");
	$BackPatient = $dbstat5->num_rows();
	
	//死亡人數
	$dbstat6 = new DB;
	$dbstat6->query("SELECT * FROM `".$DBname."`.`closedcase` WHERE `outdate`='".$date."' AND `reason`='4'");
	$DeadPatient = $dbstat6->num_rows();
	
	//寫到DB去
	$dbW = new DB;
	$dbW->query("INSERT INTO `".$DBname."`.`".$tablename."` VALUES ('".str_replace("/","-",formatdate($date))."', '".$NewpatientNo."', '".$InpatientNo."', '".$OutpatientNo."', '".$countFoley."', '".($InpatientNo-$countFoley)."', '".$HospPatient."', '".$BackPatient."', '".$DeadPatient."', 'AUTO')");
}
?>