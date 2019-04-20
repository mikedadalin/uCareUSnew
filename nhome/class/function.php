<?php
function getdays($day){
	//Array ( [0] => 2014-06-30 [1] => 2014-07-06 )
	//回傳輸入日期當週之第一日與最後一日 return the first and last day of the week base on the import date
    $lastday=date('Y-m-d',strtotime("$day Sunday"));
    $firstday=date('Y-m-d',strtotime("$lastday -6 days"));
    return array($firstday,$lastday);
}

//計算年齡calculate age
function calcage($birth) {
	if (strlen($birth)==8) {
		$birthy = substr($birth,0,4);
		$birthm = substr($birth,4,2);
		$birthd = substr($birth,6,2);
	} elseif (strlen($birth)==7) {
		$birthy = (substr($birth,0,3))+1911;
		$birthm = substr($birth,3,2);
		$birthd = substr($birth,5,2);
	}
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

//計算年齡calculate age
function calcagenum($birth) {
	if (strlen($birth)==8) {
		$birthy = substr($birth,0,4);
		$birthm = substr($birth,4,2);
		$birthd = substr($birth,6,2);
	} elseif (strlen($birth)==7) {
		$birthy = (substr($birth,0,3))+1911;
		$birthm = substr($birth,3,2);
		$birthd = substr($birth,5,2);
	}
	$bloody = date(Y);
	$bloodm = date(m);
	$bloodd = date(d);
	$bloodconv=mktime(0,0,0,$bloodm,$bloodd,$bloody);
	$birthconv=mktime(0,0,0,$birthm,$birthd,$birthy);
	$ageconv = ($bloodconv - $birthconv)/31557600;
	round($ageconv,1);
	$arrage = explode('.',$ageconv);
	$age_y = $arrage[0];
	$age_m = round(('0.'.$arrage[1]),1);
	if ($birth!="") {
		$ageconv = $age_y + $age_m;
	} else {
		$ageconv = "---";
	}
	return $ageconv;
}

//計算星期calculate week
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

//轉換日期格式convert date form
function formatdate($date) {
	if ($date!="0" && $date!="" && $date!="____/__/__") {
		$year = substr($date,0,4);
		$month = substr($date,4,2);
		$day = substr($date,6,2);
		$newdate = $year."/".$month."/".$day;
	} else {
		$newdate = "---";
	}
	return $newdate;
}


//正規DB 轉換日期格式  Y-m-d、d-m-Y、m/d/Y、Ymd -> Y/m/d
function formatdate_Ymd_Slash($date) {
	if ($date!="0" && $date!="" && $date!="____/__/__") {
		$newdate = date('Y/m/d',strtotime($date));
	} else {
		$newdate = "";
	}
	return $newdate;
}
//正規DB 轉換日期格式  Y-m-d、d-m-Y、Y/m/d、m/d/Y -> Ymd
function formatdate_Ymd($date) {
	if ($date!="0" && $date!="") {
		$newdate = date('Ymd',strtotime($date));
	} else {
		$newdate = "";
	}
	return $newdate;
}
//正規DB 轉換日期格式  d-m-Y、Y/m/d、m/d/Y、Ymd -> Y-m-d
function formatdate_Ymd_Dash($date) {
	if ($date!="0" && $date!="") {
		$newdate = date('Y-m-d',strtotime($date));
	} else {
		$newdate = "";
	}
	return $newdate;
}

//轉換日期格式 (只show月日) convert date form (only showing month and date)
function formatshortdate($date) {
	if ($date!="0" && $date!="" && $date!="____/__/__") {
		$month = substr($date,4,2);
		$day = substr($date,6,2);
		$newdate = $month."/".$day;
	} else {
		$newdate = "---";
	}
	return $newdate;
}

function formatdatetostring($date, $delimeter) {
	$arrDate = explode($delimeter, $date);
	$year = $arrDate[0];
	$month = $arrDate[1];
	$day = $arrDate[2];
	if (strlen($month)==1) $month = "0".$month;
	if (strlen($day)==1) $day = "0".$day;
	return $year.$month.$day;
}

//顯示checked
function drawchecked($var,$thres) {
	if ($var==$thres) {
		return " checked";
	}
}

//顯示selected display selected
function drawselected($var,$thres) {
	if ($var==$thres) {
		return " selected";
	}
}

//繪製表單選項核取方塊draw form options check box
/*
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
*/
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
		  <button type="button" class="checkbox';
		  if (in_array(($k+1),$prearray)) { $result .= '_on'; } else { $result .= '_off'; }
		  $result .= '" onclick="click_'.$multi.'_checkbox2(this.id,\''.$id.'\',\''.count($textarray).'\');" id="btn_'.$id.'_'.($k+1).'"><font style="color:white;">✔</font></button>
		</td>
		<td align="left" valign="middle">'.$v.'</td>
		</tr>'."\n";
	}
	$result .= "</table>\n";
	return $result;
}

//繪製表單選項核取方塊draw form options check box
/*
function draw_checkbox_nobr($id, $text, $pre, $multi) {
	$textarray = explode(";",$text);
	$prearray = explode(";",$pre);
	foreach ($textarray as $k=>$v) {
		if (in_array(($k+1),$prearray)) { $value = 1; } else { $value = 0; }
		$result .= '<input type="hidden" name="'.$id.'_'.($k+1).'" id="'.$id.'_'.($k+1).'" value="'.$value.'">';
		//value="'.($k+1).'"
		$result .= '<div class="checkbox';
		if (in_array(($k+1),$prearray)) { $result .= '_hold'; } else { $result .= '_off'; }
		$result .= '" style="margin:5px 2px -6px 32px;" onmouseover="hovercheckbox(this.id);" onmouseout="outcheckbox(this.id);" onclick="click_'.$multi.'_checkbox(this.id,\''.$id.'\',\''.count($textarray).'\');" id="btn_'.$id.'_'.($k+1).'" style="line-height:40px;"></div><span style="line-height:40px;">'.$v."</span> \n";
	}
	return $result;
}
*/
function draw_checkbox_nobr($id, $text, $pre, $multi) {
	$textarray = explode(";",$text);
	$prearray = explode(";",$pre);
	foreach ($textarray as $k=>$v) {
		if (in_array(($k+1),$prearray)) { $value = 1; } else { $value = 0; }
		$result .= '<input type="hidden" name="'.$id.'_'.($k+1).'" id="'.$id.'_'.($k+1).'" value="'.$value.'">';
		//value="'.($k+1).'"
		$result .= '<button type="button" class="checkbox';
		if (in_array(($k+1),$prearray)) { $result .= '_on'; } else { $result .= '_off'; }
		$result .= '" style="margin:5px 2px -6px 32px;" onclick="click_'.$multi.'_checkbox2(this.id,\''.$id.'\',\''.count($textarray).'\');" id="btn_'.$id.'_'.($k+1).'" style="line-height:40px;"><font style="color:white;">✔</font></button><span style="line-height:40px;">'.$v."</span> \n";
	}
	return $result;
}

//繪製表單選項核取方塊draw form options check box
function checkbox_result($id, $text, $pre, $multi) {
	$textarray = explode(";",$text);
	$prearray = explode(";",$pre);
	foreach ($textarray as $k=>$v) {
		if (in_array(($k+1),$prearray)) { if ($result!=NULL) { $result .= '、'; } $result .= $v; }
	}
	return $result;
}

//繪製表單選項核取方塊draw form options check box
function checkbox_2col_result($id, $text, $pre, $multi) {
	$textarray = explode(";",$text);
	$prearray = explode(";",$pre);
	foreach ($textarray as $k=>$v) {
		if (in_array(($k+1),$prearray)) { if ($result!=NULL) { $result .= '、'; } $result .= $v; }
	}
	return $result;
}

//繪製表單選項核取方塊draw form options check box
/*
function draw_checkbox_2col($id, $text, $pre, $multi) {
	$textarray = explode(";",$text);
	$prearray = explode(";",$pre);
	$result = '<table border="0" class="tableinside">'."\n";
	$col2 = ceil(count($textarray)/2);
	for ($i=0;$i<$col2;$i++) {
		$result .= '<tr>';
		$k=$i;
		if (in_array(($k+1),$prearray)) { $value1 = 1; } else { $value1 = 0; }
		if (in_array(($k+1+$col2),$prearray)) { $value2 = 1; } else { $value2 = 0; }
		$result .= '<input type="hidden" name="'.$id.'_'.($k+1).'" id="'.$id.'_'.($k+1).'" value="'.$value1.'">';
		if ($textarray[($k+$col2)]!=NULL) { $result .= '<input type="hidden" name="'.$id.'_'.($k+1+$col2).'" id="'.$id.'_'.($k+1+$col2).'" value="'.$value2.'">'; }
		$result .= '
		<td width="10%" align="center" valign="middle">
		  <div class="checkbox';
		  if (in_array(($k+1),$prearray)) { $result .= '_hold'; } else { $result .= '_off'; }
		  $result .= '" onmouseover="hovercheckbox(this.id);" onmouseout="outcheckbox(this.id);" onclick="click_'.$multi.'_checkbox(this.id,\''.$id.'\',\''.count($textarray).'\');" id="btn_'.$id.'_'.($k+1).'"></div>
		</td>
		<td width="" align="left" valign="middle">'.$textarray[$k].'</td>';
		if ($textarray[($k+$col2)]!=NULL) {
			$result .= '
		<td width="10%" align="center" valign="middle">
		  <div class="checkbox';
		  if (in_array(($k+1+$col2),$prearray)) { $result .= '_hold'; } else { $result .= '_off'; }
		  $result .= '" onmouseover="hovercheckbox(this.id);" onmouseout="outcheckbox(this.id);" onclick="click_'.$multi.'_checkbox(this.id,\''.$id.'\',\''.count($textarray).'\');" id="btn_'.$id.'_'.($k+1+$col2).'"></div>
		</td>
		<td width="" align="left" valign="middle">'.$textarray[($k+$col2)].'</td>';
		} else {
			$result .= '<td>&nbsp;</td><td>&nbsp;</td>';
		}
		$result .= '		</tr>'."\n";
	}
	$result .= "</table>\n";
	return $result;
}
*/
function draw_checkbox_2col($id, $text, $pre, $multi) {
	$textarray = explode(";",$text);
	$prearray = explode(";",$pre);
	$result = '<table border="0" class="tableinside">'."\n";
	$col2 = ceil(count($textarray)/2);
	for ($i=0;$i<$col2;$i++) {
		$result .= '<tr>';
		$k=$i;
		if (in_array(($k+1),$prearray)) { $value1 = 1; } else { $value1 = 0; }
		if (in_array(($k+1+$col2),$prearray)) { $value2 = 1; } else { $value2 = 0; }
		$result .= '<input type="hidden" name="'.$id.'_'.($k+1).'" id="'.$id.'_'.($k+1).'" value="'.$value1.'">';
		if ($textarray[($k+$col2)]!=NULL) { $result .= '<input type="hidden" name="'.$id.'_'.($k+1+$col2).'" id="'.$id.'_'.($k+1+$col2).'" value="'.$value2.'">'; }
		$result .= '
		<td width="10%" align="center" valign="middle">
		  <button type="button" class="checkbox';
		  if (in_array(($k+1),$prearray)) { $result .= '_on'; } else { $result .= '_off'; }
		  $result .= '" onclick="click_'.$multi.'_checkbox2(this.id,\''.$id.'\',\''.count($textarray).'\');" id="btn_'.$id.'_'.($k+1).'"><font style="color:white;">✔</font></button>
		</td>
		<td width="" align="left" valign="middle">'.$textarray[$k].'</td>';
		if ($textarray[($k+$col2)]!=NULL) {
			$result .= '
		<td width="10%" align="center" valign="middle">
		  <button type="button" class="checkbox';
		  if (in_array(($k+1+$col2),$prearray)) { $result .= '_on'; } else { $result .= '_off'; }
		  $result .= '" onclick="click_'.$multi.'_checkbox2(this.id,\''.$id.'\',\''.count($textarray).'\');" id="btn_'.$id.'_'.($k+1+$col2).'"><font style="color:white;">✔</font></button>
		</td>
		<td width="" align="left" valign="middle">'.$textarray[($k+$col2)].'</td>';
		} else {
			$result .= '<td>&nbsp;</td><td>&nbsp;</td>';
		}
		$result .= '		</tr>'."\n";
	}
	$result .= "</table>\n";
	return $result;
}
//繪製表單選項按鈕draw form options button
/*
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
				if($id=="Qmedtime"){
					$result .= '" onmouseover="hoverbtn(this.id,\''.$pos.'\',\''.$size.'\');" onmouseout="outbtn(this.id,\''.$pos.'\',\''.$size.'\');" onclick="click_'.$multi.'_btn(this.id,\''.$pos.'\',\''.$size.'\',\''.$id.'\',\''.count($textarray).' \'); checkSelectQmedtime(this.id);" id="btn_'.$id.'_'.($k+1).'"><span>'.$v.'</span></div>';
				}elseif($id=="Qmedday"){
					$result .= '" onmouseover="hoverbtn(this.id,\''.$pos.'\',\''.$size.'\');" onmouseout="outbtn(this.id,\''.$pos.'\',\''.$size.'\');" onclick="click_'.$multi.'_btn(this.id,\''.$pos.'\',\''.$size.'\',\''.$id.'\',\''.count($textarray).' \'); checkSelectQmedday(this.id);" id="btn_'.$id.'_'.($k+1).'"><span>'.$v.'</span></div>';
				}else{
					$result .= '" onmouseover="hoverbtn(this.id,\''.$pos.'\',\''.$size.'\');" onmouseout="outbtn(this.id,\''.$pos.'\',\''.$size.'\');" onclick="click_'.$multi.'_btn(this.id,\''.$pos.'\',\''.$size.'\',\''.$id.'\',\''.count($textarray).' \');" id="btn_'.$id.'_'.($k+1).'"><span>'.$v.'</span></div>';
				}
				$result .= $return;
			}
		} else {
			foreach ($textarray as $k=>$v) {
				$pos = "";
				$return = "";
				if ($k==0) { $pos = 'left'; } elseif ($k==count($textarray)-1) { $pos = 'right'; } else { $pos = 'middle'; }
				$result .= '<div class="tabbtn_'.$size.'_'.$pos;
				if (in_array(($k+1),$prearray)) { $result .= '_hold'; } else { $result .= '_off'; }
				if($id=="Qmedtime"){
					$result .= '" onmouseover="hoverbtn(this.id,\''.$pos.'\',\''.$size.'\');" onmouseout="outbtn(this.id,\''.$pos.'\',\''.$size.'\');" onclick="click_'.$multi.'_btn(this.id,\''.$pos.'\',\''.$size.'\',\''.$id.'\',\''.count($textarray).' \'); checkSelectQmedtime(this.id);" id="btn_'.$id.'_'.($k+1).'"><span>'.$v.'</span></div>';
				}elseif($id=="Qmedday"){
					$result .= '" onmouseover="hoverbtn(this.id,\''.$pos.'\',\''.$size.'\');" onmouseout="outbtn(this.id,\''.$pos.'\',\''.$size.'\');" onclick="click_'.$multi.'_btn(this.id,\''.$pos.'\',\''.$size.'\',\''.$id.'\',\''.count($textarray).' \'); checkSelectQmedday(this.id);" id="btn_'.$id.'_'.($k+1).'"><span>'.$v.'</span></div>';
				}else{
					$result .= '" onmouseover="hoverbtn(this.id,\''.$pos.'\',\''.$size.'\');" onmouseout="outbtn(this.id,\''.$pos.'\',\''.$size.'\');" onclick="click_'.$multi.'_btn(this.id,\''.$pos.'\',\''.$size.'\',\''.$id.'\',\''.count($textarray).' \');" id="btn_'.$id.'_'.($k+1).'"><span>'.$v.'</span></div>';
				}
				$result .= $return;
			}
		}
	}
	return $result;
}
*/
function draw_option($id, $text, $size, $multi, $pre, $br, $brn) {
	$textarray = explode(";",$text);
	$prearray = explode(";",$pre);
	$textarrayCount = count($textarray);
	$brnRun = $brn;
	foreach ($textarray as $k=>$v) {
		if (in_array(($k+1),$prearray)) { $value = 1; } else { $value = 0; }
		$result .= '<input type="hidden" name="'.$id.'_'.($k+1).'" id="'.$id.'_'.($k+1).'" value="'.$value.'">';
		$result .= '<button type="button" name="btn_'.$id.'_'.($k+1).'" id="btn_'.$id.'_'.($k+1).'"';
		if ($textarrayCount==2) {
			if ($k==0) { $pos = 'left'; } else { $pos = 'right'; }
		}else{
			$pos = "middle";
			if ($k==0) { $pos = 'left'; }
			if (($k+1)==$textarrayCount) { $pos = 'right'; }
			if ($br) {
				if ($k==($brnRun-1)) { $pos = 'right'; }
				if ($k==$brnRun) { $pos = 'left'; $brnRun = $brnRun+$brn; }
			}
		}
		if(in_array(($k+1),$prearray)){ $result .= ' class="tabbtn_'.$size.'_'.$pos.'_on"'; }else{ $result .= ' class="tabbtn_'.$size.'_'.$pos.'_off"'; }
		$result .= ' onclick="click_'.$multi.'_btn2(this.id,\''.$pos.'\',\''.$size.'\',\''.$id.'\',\''.$textarrayCount.'\');';
		if($id=="Qmedtime"){ $result .= ' checkSelectQmedtime(this.id);'; }
		if($id=="Qmedday"){ $result .= ' checkSelectQmedday(this.id);'; }
		$result .= '" >'.$v.'</button>';
		if ($br) {
			if ($k==($brnRun-1)) { $result .= '<br>'; }
		}
	}
	return $result;
}
//繪製表單選項核取方塊draw form options check box
function option_result($id, $text, $size, $multi, $pre, $br, $brn) {
	$textarray = explode(";",$text);
	$prearray = explode(";",$pre);
	foreach ($textarray as $k=>$v) {
		if (in_array(($k+1),$prearray)) { if ($result!=NULL) { $result .= '、'; } $result .= $v; }
	}
	return $result;
}

//縣市選單state list
/*
function city_selection($id, $preselect) {
	$result = '<select name="'.$id.'" id="'.$id.'">';
	$arrCity = array();
	$db0 = new DB2;
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
*/
//鄉鎮市區選單township select
/*
function town_selection($id, $preselect, $preselect2) {
	$result = '<select name="'.$id.'" id="'.$id.'">';
	$arrTown = array();
	if ($preselect=="") { $preselect = '台北市'; }
	$db0 = new DB2;
	$db0->query("SELECT DISTINCT  `town` FROM  `address` WHERE `city`='".$preselect."'");
	for ($i=0;$i<$db0->num_rows();$i++) {
		$r0 = $db0->fetch_assoc();
		$result .= '<option value="'.$r0['town'].'"';
		if ($preselect2 == $r0['town']) { $result .= " selected"; }
		$result .= '>'.$r0['town'].'</option>';
	}
	$result .= '</select>';
	return $result;
} 
*/

//洲選單state list
function state_selection($id, $preselect) {
	$result = '<select name="'.$id.'" id="'.$id.'">';
	$arrCity = array();
	$db0 = new DB2;
	$db0->query("SELECT DISTINCT `state` FROM `address`");
	for ($i=0;$i<$db0->num_rows();$i++) {
		$r0 = $db0->fetch_assoc();
		$result .= '<option value="'.$r0['state'].'"';
		if ($preselect == $r0['state']) { $result .= " selected"; }
		$result .= '>'.$r0['state'].'</option>';
	}
	$result .= '</select>';
	return $result;
}

//縣選單country list
function country_selection($id, $preselect, $preselect2) {
	$result = '<select name="'.$id.'" id="'.$id.'">';
	$arrTown = array();
	$db0 = new DB2;
	$db0->query("SELECT DISTINCT `country` FROM `address` WHERE `state`='".$preselect."'");
	for ($i=0;$i<$db0->num_rows();$i++) {
		$r0 = $db0->fetch_assoc();
		$result .= '<option value="'.$r0['country'].'"';
		if ($preselect2 == $r0['country']) { $result .= " selected"; }
		$result .= '>'.$r0['country'].'</option>';
	}
	$result .= '</select>';
	return $result;
}

//城市選單city select
function city_selection($id, $preselect, $preselect2, $preselect3) {
	$result = '<select name="'.$id.'" id="'.$id.'">';
	$arrTown = array();
	$db0 = new DB2;
	$db0->query("SELECT DISTINCT `city` FROM `address` WHERE `state`='".$preselect."' AND `country`='".$preselect2."'");
	for ($i=0;$i<$db0->num_rows();$i++) {
		$r0 = $db0->fetch_assoc();
		$result .= '<option value="'.$r0['city'].'"';
		if ($preselect3 == $r0['city']) { $result .= " selected"; }
		$result .= '>'.$r0['city'].'</option>';
	}
	$result .= '</select>';
	return $result;
}

//郵遞區號選單zip select
function zip_selection($id, $preselect, $preselect2, $preselect3, $Postcodeselect) {
	$result = '<select name="'.$id.'" id="'.$id.'">';
	$arrTown = array();
	$db0 = new DB2;
	$db0->query("SELECT DISTINCT `zip` FROM `address` WHERE `state`='".$preselect."' AND `country`='".$preselect2."' AND `city`='".$preselect3."'");
	for ($i=0;$i<$db0->num_rows();$i++) {
		$r0 = $db0->fetch_assoc();
		$result .= '<option value="'.$r0['zip'].'"';
		if ($Postcodeselect == $r0['zip']) { $result .= " selected"; }
		$result .= '>'.$r0['zip'].'</option>';
	}
	$result .= '</select>';
	return $result;
}

//Calculate day(s) (至計算當日) calculate day (untill the date used/view)
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

//Calculate day(s) (大於一年即回傳年數)calculate day(will add year value if greater then 1 year)
function calcperiodwithyear($startdate,$enddate) {
	if ($startdate!="" && $enddate!="" && $startdate!="____/__/__" && $enddate!="____/__/__") {
		$startymd = substr($startdate,0,4).'-'.substr($startdate,4,2).'-'.substr($startdate,6,2);
		$starthms = '00-00-00';
		$array_ymd = explode('-', $startymd );
		$array_hms = explode('-', $starthms);
		$endmd = substr($enddate,0,4).'-'.substr($enddate,4,2).'-'.substr($enddate,6,2);
		$array_ymd2 = explode('-', $endmd );
		$startdate =mktime($array_hms[0],$array_hms[1],$array_hms[2],$array_ymd[1],$array_ymd[2],$array_ymd[0]);
		$enddate = mktime('00','00','00',$array_ymd2[1],$array_ymd2[2],$array_ymd2[0]);
		$days=((($enddate-$startdate)/3600)/24)+1 ;
		if ($days >= 365) {
			$years = round(($days/365),1);
			return $years."Year";
		} else {
			return round($days)."Day(s)";
		}
	} else {
		return "---";
	}
}

// 將YYYY/mm/dd改成YYYYmmdd格式  YYYY/mm/dd form ->YYYYmmdd form
function changedateformat1($delimiter, $date) {
	$arrDate = explode($delimiter,$date);
	$Year = $arrDate[0];
	if ($Year<1000) { $Year = $Year+1911; }
	$Month = $arrDate[1];
	if (strlen($Month)==1) { $Month = "0".$Month; }
	$Day = $arrDate[2];
	if (strlen($Day)==1) { $Day = "0".$Day; }
	if ($date!="" && $date!="____/__/__") {
		return $Year.$Month.$Day;
	}
}

//Calculate day(s) (輸入兩天的時間差) calculate date (input two day and show the different of day)
function calcperiod($startdate,$enddate) {
	$enddate = str_replace("_","",$enddate);
	$enddate = str_replace("/","",$enddate);
	if ($enddate=="") {
	return "------";
	} else {
	$startymd = substr($startdate,0,4).'-'.substr($startdate,4,2).'-'.substr($startdate,6,2);
	$starthms = '00-00-00';
	$array_ymd = explode('-', $startymd );
	$array_hms = explode('-', $starthms);
	$endmd = substr($enddate,0,4).'-'.substr($enddate,4,2).'-'.substr($enddate,6,2);
	$array_ymd2 = explode('-', $endmd );
	$startdate = @mktime($array_hms[0],$array_hms[1],$array_hms[2],$array_ymd[1],$array_ymd[2],$array_ymd[0]);
	$enddate = @mktime('00','00','00',$array_ymd2[1],$array_ymd2[2],$array_ymd2[0]);
	$days=((($enddate-$startdate)/3600)/24)+1 ;
	return round($days);
	}
}

//Calculate day(s) (輸入兩天的時間差) 天數為整數，小時轉為點數 calculate date (input two day and show the different of day) integer-> day, decimal->hour
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

//計算$startdate起後$period天數之日期 calculate $startdate+$period date
function calcdayafterday($startdate,$period) {
	$startdate = str_replace("/","",$startdate);
	$period = str_replace("天day","",$period);
	$startdate = substr($startdate,0,4).'-'.substr($startdate,4,2).'-'.substr($startdate,6,2);
	$enddate = date('Y/m/d',strtotime($startdate.' +'.$period.' days'));
	return $enddate;
}

//回傳當月最後一天return the last date of the month
function lastday($month, $year) {
   if (empty($month)) {
      $month = date('m');
   }
   if (empty($year)) {
      $year = date('Y');
   }
   $result = strtotime("{$year}-{$month}-01");
   $result = strtotime('-1 second', strtotime('+1 month', $result));
   return date('t', $result);
}

//回傳住民生日
function getPatientBOD($pid) {
	$db = new DB;
	$db->query("SELECT `Birth` FROM `patient` WHERE `patientID`='".$pid."'");
	$r = $db->fetch_assoc();
	return $r['Birth'];
}

//回傳使用者名稱
function checkusername($userID) {
	$dbuser = new DB2;
	$dbuser->query("SELECT `name` FROM `userinfo` WHERE `userID`='".$userID."'");
	$ruser = $dbuser->fetch_assoc();
	return $ruser['name'];
}

//回傳使用者職稱return user job title
function checkuserposition($userID) {
	$dbuser = new DB2;
	$dbuser->query("SELECT `position` FROM `userinfo` WHERE `userID`='".$userID."'");
	$ruser = $dbuser->fetch_assoc();
	return $ruser['position'];
}


//回傳居民使用者職稱return user job title
function checkuserposition_resident($userID) {
	$dbuser = new DB2;
	$dbuser->query("SELECT `position` FROM `userinfo_resident` WHERE `userID`='".$userID."'");
	$ruser = $dbuser->fetch_assoc();
	return $ruser['position'];
}

//回傳員工名稱
function getEmployerName($EmpID) {
	$dbuser = new DB;
	$dbuser->query("SELECT `Name` FROM `employer` WHERE `EmpID`='".$EmpID."'");
	$ruser = $dbuser->fetch_assoc();
	return $ruser['Name'];
}

//回傳外藉員工名稱
function getForeignFullName($EmpID) {
	$dbuser = new DB;
	$dbuser->query("SELECT concat(`cNickname`,' ',`eNickname`) Name FROM `foreignemployer` WHERE `foreignID`='".$EmpID."'");
	$ruser = $dbuser->fetch_assoc();
	return $ruser['Name'];
}

//回傳員工名稱
function getEmpName($EmpID, $EmpGroup) {
	if ($EmpGroup==1) {
		$dbuser = new DB;
		$dbuser->query("SELECT `Name` FROM `employer` WHERE `EmpID`='".$EmpID."'");
		$ruser = $dbuser->fetch_assoc();
		return $ruser['Name'];
	} elseif ($EmpGroup==2) {
		$dbuser = new DB;
		$dbuser->query("SELECT concat(`cNickname`,' ',`eNickname`) Name FROM `foreignemployer` WHERE `foreignID`='".$EmpID."'");
		$ruser = $dbuser->fetch_assoc();
		return $ruser['Name'];
	}
}

//回傳住民性別
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

//回傳護字號return care ID#
function getHospNo($pid) {
	$db = new DB;
	$db->query("SELECT `HospNo` FROM `patient` WHERE `patientID`='".$pid."'");
	$r = $db->fetch_assoc();
	return $r['HospNo'];
}

function getHospNoDisplayByPID($pid) {
	$db = new DB;
	$db->query("SELECT `HospNoDisplay` FROM `patient` WHERE `patientID`='".$pid."'");
	$r = $db->fetch_assoc();
	return $r['HospNoDisplay'];
}

function getHospNoDisplayByHospNo($pid) {
	$db = new DB;
	$db->query("SELECT `HospNoDisplay` FROM `patient` WHERE `HospNo`='".$pid."'");
	$r = $db->fetch_assoc();
	return $r['HospNoDisplay'];
}

function getHospNoByHospNoDisplay($type, $input) {
	$db = new DB;
	$db->query("SELECT `HospNo` FROM `patient` WHERE `type`='".$type."' AND `HospNoDisplay`='".$input."'");
	$r = $db->fetch_assoc();
	return $r['HospNo'];
}

function getHospNoByHospNoDisplayNoType($input) {
	$db = new DB;
	$db->query("SELECT `HospNo` FROM `patient` WHERE `HospNoDisplay`='".$input."'");
	$r = $db->fetch_assoc();
	return $r['HospNo'];
}

//回傳病人ID
function getPID($HospNo) {
	$db = new DB;
	$db->query("SELECT `patientID` FROM `patient` WHERE `HospNo`='".$HospNo."'");
	$r = $db->fetch_assoc();
	return $r['patientID'];
}

function getPIDByHospNoDisplay($HospNoDisplay) {
	$db = new DB;
	$db->query("SELECT `patientID` FROM `patient` WHERE `HospNoDisplay`='".$HospNoDisplay."'");
	$r = $db->fetch_assoc();
	return $r['patientID'];
}

//回傳病人類型
function getTypeByPID($pid) {
	$db = new DB;
	$db->query("SELECT `type` FROM `patient` WHERE `patientID`='".$pid."'");
	$r = $db->fetch_assoc();
	return $r['type'];
}

function getTypeByHospNo($hospno) {
	$db = new DB;
	$db->query("SELECT `type` FROM `patient` WHERE `HospNo`='".$hospno."'");
	$r = $db->fetch_assoc();
	return $r['type'];
}

function getTypeByHospNoDisplay($hospno) {
	$db = new DB;
	$db->query("SELECT `type` FROM `patient` WHERE `HospNoDisplay`='".$hospno."'");
	$r = $db->fetch_assoc();
	return $r['type'];
}

//回傳病床
function getBedID($pid) {
	$db = new DB;
	$db->query("SELECT `bed` FROM `inpatientinfo` WHERE `patientID`='".$pid."'");
	$r = $db->fetch_assoc();
	if($pid==""){
		return "Not specified";
	} elseif ($r['bed']=="") {
		return "Discharged/case closed";
	} else {
		return $r['bed'];
	}
}

//回傳樓層
function getPatientArea($pid) {
	$bedID = getBedID($pid);
	$db = new DB;
	$db->query("SELECT b.`areaName` FROM `bedinfo` a, `areainfo` b WHERE a.`bedID`='".$bedID."' AND a.`Area`=b.`areaID`");
	$r = $db->fetch_assoc();
	if ($r['areaName']=="") {
		return "---";
	} else {
		return $r['areaName'];
	}
}

//回傳樓層住民PID
function getAreaPatient($areaID) {
	$db = new DB;
	$db->query("SELECT c.`patientID` FROM `areainfo` a, `bedinfo` b, `inpatientinfo` c WHERE a.`areaID`=b.`Area` AND b.`bedID`=c.`bed` AND a.`areaID`='".$areaID."'");
	for ($i=0;$i<$db->num_rows();$i++) {
		$r = $db->fetch_assoc();
		$output .= $r['patientID'].';';
	}
	$output = substr($output,0,strlen($output)-1);
	return $output;
}

//回傳住民姓名
function getPatientName($pid) {
	$db = new DB;
	$db->query("SELECT `Name1`,`Name2`,`Name3`,`Name4` FROM `patient` WHERE `patientID`='".$pid."'");
	$r = $db->fetch_assoc();
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
	$r = $r['Name1'].$r['Name2'].$r['Name3'].$r['Name4'];
	return $r;
}

//菜單計算日期用for calculate date of diet menu
function monthlastday($month,$year) {
	$arrMonth = array('','January','February','March','April','May','June','July','August','September','October','November','December');
	$lastmonth = '1 '.$arrMonth[$month].' '.$year;
	$lastmonth_days = date(t,strtotime($lastmonth));
	return $lastmonth_days;
}

//菜單計算日期用for calculate date of diet menu
function weekcount($date) {
	$year = substr($date,0,4);
	$month = substr($date,4,2);
	$day = substr($date,6,2);
	$weekcount = 1;
	for ($i=1;$i<=$day;$i++) {
		$wday = date(w,strtotime($year.'-'.$month.'-'.$i));
		if ($wday=="1") { $weekcount += 1; }
	}
	return $weekcount;
}

//phpGrid需要用到的function  phpGrid required function
if (!function_exists('array_replace_recursive')) {
	function array_replace_recursive($array, $array1) {
		if (!function_exists('recurse')) {
			function recurse($array, $array1) {
				foreach ($array1 as $key => $value) {
					// create new key in $array, if it is empty or not an array
					if (!isset($array[$key]) || (isset($array[$key]) && !is_array($array[$key]))) { $array[$key] = array(); }
					// overwrite the value in the base array
					if (is_array($value)) { $value = recurse($array[$key], $value); }
					$array[$key] = $value;
				}
				return $array;
			}
		}
	
		// handle the arguments, merge one by one
		$args = func_get_args();
    	$array = $args[0];
    	if (!is_array($array)) { return $array; }
    	for ($i = 1; $i < count($args); $i++) {
			if (is_array($args[$i])) { $array = recurse($array, $args[$i]); }
    	}
		return $array;
	}
}

/*
列表換頁next page of list
changePageManager(總筆數total data, 總頁數total page, 本頁頁次current page, 每頁筆數number of data per page, 其他字串other text,url)
*/
function changePageManager($totalRecord,$totalPage,$pn,$ps,$pageString,$url){
	
      $maxPage = $ps;
      $pf = ceil($totalRecord / $maxPage);  
      //if ($pn % $maxPage > 0 ){$pf +=1;}

      if($pageString<>""){$pString="&".$pageString;}else{$pString="";}
      if($totalRecord <> ""){
          $strPage.='';
          if($pn <> 1){  
              $strPage .="<a href='".$url."&pn=1".$pString."' title='first page'>first page</a>&nbsp;│&nbsp;";
          }
          if($pn > 10){
              $strPage .= "<a href='".$url."&pn=".($maxPage * ($pf-10))."".$pString."' title='firt 10 pages'>first 10 pages</a>&nbsp;│&nbsp;";
          }
          if($pn > 1){
              $strPage .= "<a href='".$url."&pn=".($pn-1)."".$pString."' title='previous page'>previous page</a>&nbsp;│&nbsp;";
          }
		  $startpage = $pn-(($pn)%10)+1;
		  if (($pn%10)==0) { $startpage -= 10; }
		  $endpage = $startpage+10;
		  if ($endpage>$pf) { $endpage = $pf+1; }
          for ($i= $startpage ; $i < $endpage ; $i++ ){
			  if($i <> $pn){
				  $class="";
			  }else{
				  $class="class='Do'";
			  }
              $strPage .="<a href='".$url."&pn=".$i.$pString."' title='the".$j.""."th page' ".$class.">".$i."</a>";
			  if ($i!=($endpage-1)) { $strPage .= '&nbsp;，'; }
          }
          if($pn < $totalPage){
             $strPage .="&nbsp;│&nbsp;<a href='".$url."&pn=".($pn+1).$pString."' title='to next page'>to next page</a>&nbsp;│&nbsp;";
          }

          if($pn <> $totalPage){
             $strPage .="<a href='".$url."&pn=".$totalPage.$pString."' title='last page'>last page</a>";
          }
          $strPage .= "<br><font size='2'>totally".$totalRecord."data,totally".$totalPage."pages</font>";
       }
	   echo $strPage;
}

function checkLayNo($layno) {
	if ($layno!="") {
		$db = new DB;
		$db->query("SELECT * FROM `stockinfo` WHERE `stockinfoID`='".mysql_escape_string($layno)."'");
		$r = $db->fetch_assoc();
		return $r['stockinfoID'].' '.$r['Title'];
	}
}

//確認是否有退貨confirm if return the product or not
function chkReturned($IN){
	$db1 = new DB;
	$db1->query("SELECT sum(b.QTY) OC_QTY FROM `firmstock` a inner join `firmstockinfo` b on a.firmStockID=b.firmStockID and a.type=b.type WHERE a.type='OC' and a.`IsStatus`='N' and a.IN_firmStockID='".$IN."'");
	if ($db1->num_rows()>0) {
		$rs = $db1->fetch_assoc();
		if($rs['OC_QTY']==NULL){
			return 0;
		}else{
			return 1;
		}
	}
}

//回傳產品名稱return product name
function STK_NAME($STK_NO){
	$db1 = new DB;
	$db1 ->query("SELECT STK_NAME FROM `arkstock` where STK_NO='".$STK_NO."'");
	if($db1->num_rows()>0){
		$rs = $db1->fetch_assoc();
		return $rs['STK_NAME'];
	}
}
//回傳產品名稱short return short(abbreviate) product name
function STK_NAME_s($STK_NO){
	$db1 = new DB;
	$db1 ->query("SELECT left(STK_NAME,10) name FROM `arkstock` where STK_NO='".$STK_NO."'");
	if($db1->num_rows()>0){
		$rs = $db1->fetch_assoc();
		return $rs['name'];
	}
}

//回傳倉庫名稱return storage(inventory) name
function getStockName($stockinfoID){
	$db1 = new DB;
	$db1 ->query("SELECT Title FROM `stockinfo` where stockinfoID='".$stockinfoID."'");
	if($db1->num_rows()>0){
		$rs = $db1->fetch_assoc();
		return $rs['Title'];
	}
}
//回傳目前庫存數return current storage
function getStockQTY($StockID,$STK_NO,$STK_YEAR,$STK_MONTH){
	$db1 = new DB;
	$strSQL = "SELECT (`BE_STK` + `IN_STK` - `OUT_STK`) + `ADJ_STK` QTY FROM  `stockform` ";
	$strSQL .= " WHERE `StockID` =  '".$StockID."' AND `STK_NO` = '".$STK_NO."'";
	$strSQL .= " AND `STK_YEAR` = '".$STK_YEAR."' AND `STK_MONTH` = '".$STK_MONTH."'";
	$db1 ->query($strSQL);
	if($db1->num_rows()>0){
		$rs = $db1->fetch_assoc();
		return $rs['QTY'];
	}else{
		return 0;
	}
}

//回傳區域樓層return section and floor
function getArkAreaName($areaID) {
	$areaID = str_replace('Area','',$areaID);
	$db1 = new DB;
	$db1->query("SELECT * FROM `arkarea` WHERE `areaID`='".$areaID."'");
	$r1 = $db1->fetch_assoc();
	return $r1['areaName'];
}
//回傳廠商名稱return vondor name
function getFirmName($firmID){
	$db1 = new DB;
	$db1 ->query("SELECT Title FROM `firm` where firmID='".$firmID."'");
	if($db1->num_rows()>0){
		$rs = $db1->fetch_assoc();
		return $rs['Title'];
	}
}
//回傳產品單位return product unit
function getUNIT($STK_NO){
	$db1 = new DB;
	$db1 ->query("SELECT STK_UNIT FROM `arkstock` where STK_NO='".$STK_NO."'");
	if($db1->num_rows()>0){
		$rs = $db1->fetch_assoc();
		return $rs['STK_UNIT'];
	}
}
//回傳外藉姓名
function getforeignName($foreignID) {
	$db = new DB;
	$db->query("SELECT cNickname FROM `foreignemployer` WHERE `foreignID`='".$foreignID."'");
	$r = $db->fetch_assoc();
	return $r['cNickname'];
}
//外藉是否離職
function getQuit($foreignID) {
	$db = new DB;
	$db->query("SELECT * FROM `foreignemployer` WHERE `foreignID`='".$foreignID."'");
	$r = $db->fetch_assoc();
	if($r['Enddate1']=='' || $r['Enddate1']=='---'){
		return 0;
	}elseif($r['Startdate2']!='' && ($r['Enddate2']=='' || $r['Enddate2']=='---')){
		return 0;
	}elseif($r['Startdate3']!='' && ($r['Enddate3']=='' || $r['Enddate3']=='---')){
		return 0;
	}elseif($r['Startdate4']!='' && ($r['Enddate4']=='' || $r['Enddate4']=='---')){
		return 0;
	}elseif($r['Startdate5']!='' && ($r['Enddate5']=='' || $r['Enddate5']=='---')){
		return 0;
	}else{
		return 1;
	}
}
//
function getWorkingStaff($EmpGroup) {
	$arrList = array();
	if ($EmpGroup==1) {
		$sql1 = "SELECT * FROM `employer` ORDER BY `EmpID` ASC";
		$db = new DB;
		$db->query($sql1);
		for ($i=0;$i<$db->num_rows();$i++) {
			$r = $db->fetch_assoc();
			foreach ($r as $k=>$v) {
				${$k}=$v;
			}
			if ($Enddate1==NULL) {
				$arrList[$EmpID] = $Name;
			} elseif ($Startdate2!=NULL && $Enddate2==NULL) {
				$arrList[$EmpID] = $Name;
			} elseif ($Startdate3!=NULL && $Enddate3==NULL) {
				$arrList[$EmpID] = $Name;
			}
		}
		return $arrList;
	} elseif ($EmpGroup==2) {
		$sql1 = "SELECT * FROM `foreignemployer` ORDER BY `foreignID` ASC";
		$db = new DB;
		$db->query($sql1);
		for ($i=0;$i<$db->num_rows();$i++) {
			$r = $db->fetch_assoc();
			foreach ($r as $k=>$v) {
				${$k}=$v;
			}
			if ($Enddate1==NULL) {
				$arrList[$foreignID] = $cNickname;
			} elseif ($Startdate2!=NULL && $Enddate2==NULL) {
				$arrList[$foreignID] = $cNickname;
			} elseif ($Startdate3!=NULL && $Enddate3==NULL) {
				$arrList[$foreignID] = $cNickname;
			} elseif ($Startdate4!=NULL && $Enddate4==NULL) {
				$arrList[$foreignID] = $cNickname;
			} elseif ($Startdate5!=NULL && $Enddate5==NULL) {
				$arrList[$foreignID] = $cNickname;
			}
		}
		return $arrList;
	}
}
//檢查員工在職狀況
function checkWorkingStatus($EmpID, $EmpGroup) {
	$arrEmpList = getWorkingStaff($EmpGroup);
	foreach ($arrEmpList as $k=>$v) {
		if ($EmpID==$k) {
			$status = "1"; //在職
		}
	}
	return $status;
}
//取得最後到職日
function getLastStartdate($EmpID, $EmpGroup) {
	if ($EmpGroup==1) {
		$db1a = new DB;
		$db1a->query("SELECT GREATEST(`startdate1`, `startdate2`, `startdate3`) AS `startdate` FROM `employer` WHERE `EmpID`='".$EmpID."'");
		$r1a = $db1a->fetch_assoc();
		$arrSD = explode("/",$r1a['startdate']);
		$sd_y = $arrSD[0];
		$sd_m = str_pad($arrSD[1],2,"0",STR_PAD_LEFT);
		$sd_d = str_pad($arrSD[2],2,"0",STR_PAD_LEFT);
		$sd = $sd_y.$sd_m.$sd_d;
	} else {
		$db1a = new DB;
		$db1a->query("SELECT GREATEST(`startdate1`, `startdate2`, `startdate3`, `startdate4`, `startdate5`) AS `startdate` FROM `foreignemployer` WHERE `foreignID`='".$EmpID."'");
		$r1a = $db1a->fetch_assoc();
		$sd = $r1a['startdate'];
	}
	return $sd;
}
//回傳分類名稱
function getCateName($cID){
	$db = new DB;
	$db->query("SELECT * FROM `service_cate` WHERE `service_cateID`='".$cID."'");
	$r = $db->fetch_assoc();
	return $r['title'];
	
}

//智慧型護理診斷
function smartDiag($diag, $arrNursediag) {
	
	$arrDiagList = array(); //診斷陣列
	$arrNurseDiagList = array(); //診斷對應護理診斷陣列
	$diag = mysql_escape_string($diag);
	
	$db1 = new DB;
	$db1->query("SELECT `HospNo`, `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4`, `Qdiag5`, `Qdiag6`, `Qdiag7`, `Qdiag8` FROM `nurseform01` WHERE `Qdiag1`='".$diag."' OR 	`Qdiag2`='".$diag."' OR 	`Qdiag3`='".$diag."' OR 	`Qdiag4`='".$diag."' OR 	`Qdiag5`='".$diag."' OR 	`Qdiag6`='".$diag."' OR 	`Qdiag7`='".$diag."' OR `Qdiag8`='".$diag."'");
	for ($i1=0;$i1<$db1->num_rows();$i1++) {
		$r1 = $db1->fetch_assoc();
		if ($r1['Qdiag1']!="" && $r1['Qdiag1']==$diag) { $arrDiagList[$r1['Qdiag1']] .= $r1['HospNo'].';'; }
		if ($r1['Qdiag2']!="" && $r1['Qdiag2']==$diag) { $arrDiagList[$r1['Qdiag2']] .= $r1['HospNo'].';'; }
		if ($r1['Qdiag3']!="" && $r1['Qdiag3']==$diag) { $arrDiagList[$r1['Qdiag3']] .= $r1['HospNo'].';'; }
		if ($r1['Qdiag4']!="" && $r1['Qdiag4']==$diag) { $arrDiagList[$r1['Qdiag4']] .= $r1['HospNo'].';'; }
		if ($r1['Qdiag5']!="" && $r1['Qdiag5']==$diag) { $arrDiagList[$r1['Qdiag5']] .= $r1['HospNo'].';'; }
		if ($r1['Qdiag6']!="" && $r1['Qdiag6']==$diag) { $arrDiagList[$r1['Qdiag6']] .= $r1['HospNo'].';'; }
		if ($r1['Qdiag7']!="" && $r1['Qdiag7']==$diag) { $arrDiagList[$r1['Qdiag7']] .= $r1['HospNo'].';'; }
		if ($r1['Qdiag8']!="" && $r1['Qdiag8']==$diag) { $arrDiagList[$r1['Qdiag8']] .= $r1['HospNo'].';'; }
	}
	foreach ($arrDiagList as $k=>$v) {
		//$v = 護字號
		$arrNurseDiag2 = array(); //護理診斷陣列
		$arrHospNo = explode(";",$v);
		for ($i1=1;$i1<=count($arrNursediag);$i1++) {
			$diagNo = $i1;
			if (strlen($diagNo)==1) { $diagNo = "0".$diagNo; }
			$tmpNo = 0;
			foreach ($arrHospNo as $k1=>$v1) {
				$db2 = new DB;
				$db2->query("SELECT `HospNo` FROM `nursediag".$diagNo."` WHERE `HospNo`='".$v1."'");
				$tmpNo += $db2->num_rows();
			}
			if ($tmpNo>1) { $arrNurseDiag2[$diagNo] = $tmpNo; }
		}
		$arrNurseDiagList[$k] = $arrNurseDiag2;
	}
	$output = array();
	foreach ($arrNurseDiagList as $k2=>$v2) {
		//if (!in_array($k2,$output)) { array_push($output, $k2); }
		arsort($v2);
		foreach ($v2 as $k3=>$v3) {
			$output[$k2] .= (int) $k3.':'.$v3.';';
		}
	}
	return $output;
}
//檢查結帳日是否為月底
function chkDay($date,$closeDay){			
	if($closeDay==0){
		return date('t', strtotime($date));	
	}else{
		return $closeDay;
	}	
}
//取得關帳日
function cSTKdate(){
	$db_cSTKdate = new DB2;
	$db_cSTKdate->query("SELECT `cSTKdate` FROM `system_setting` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
	$r_cSTKdate = $db_cSTKdate->fetch_assoc();
	$db_cSTKdate = new DB;
	return $r_cSTKdate['cSTKdate'];
}
//回傳要寫入的庫存年月
function chkDate($thisDay){	
	 //2015/01/20
	 if(substr($thisDay,5,2)=="01"){
		 $Y1 = date(substr($thisDay,0,4))-1;
		 $M1 = "12";			 
	 } else{
		 $Y1 = date(substr($thisDay,0,4));
		 $M1 = str_pad((date(substr($thisDay,5,2))-1),2,'0',STR_PAD_LEFT);
	 }	 
	$chkSdate = strtotime($Y1.'/'.$M1.'/'.chkDay($Y1.'/'.$M1.'/01',cSTKdate()));
	$Y2 = date(substr($thisDay,0,4));
	$M2 = str_pad(date(substr($thisDay,5,2)),2,'0',STR_PAD_LEFT);
	$chkEdate = strtotime($Y2.'/'.$M2.'/'.chkDay($Y2.'/'.$M2.'/01',cSTKdate()));
	$thisDay1 = strtotime($thisDay);
	if($thisDay1 > $chkSdate && $thisDay1 <= $chkEdate){
		$Y = $Y2;
		$m = $M2;
	} else {
		if(substr($thisDay,5,2)=="12"){
			$Y = date(substr($thisDay,0,4))+1;  
			$m = "01";
		} else {
			$Y = date(substr($thisDay,0,4));
			$m = str_pad((date(substr($thisDay,5,2))+1),2,'0',STR_PAD_LEFT);
		}
	}	
	return array('year'=>$Y, 'month'=>$m, 'chkSdate'=>$chkSdate, 'chkEdate'=>$chkEdate);
}
//回傳是否已過帳
function getStatus($thisDay){
	 if(substr($thisDay,5,2)=="01"){
		 $Y1 = date(substr($thisDay,0,4))-1;
		 $M1 = "11";			 
	 } elseif(substr($thisDay,5,2)=="02"){
		 $Y1 = date(substr($thisDay,0,4))-1;
		 $M1 = "12";			 
	 } else {
		 $Y1 = date(substr($thisDay,0,4));
		 $M1 = str_pad((date(substr($thisDay,5,2))-2),2,'0',STR_PAD_LEFT);
	 }
	 if(substr($thisDay,5,2)=="01"){
		 $Y2 = date(substr($thisDay,0,4))-1;
		 $M2 = "12";			 
	 } else {
		 $Y2 = date(substr($thisDay,0,4));
		 $M2 = str_pad((date(substr($thisDay,5,2))-1),2,'0',STR_PAD_LEFT);
	 }	 
	$chkSdate = $Y1.'/'.$M1.'/'.chkDay($Y1.'/'.$M1.'/01',cSTKdate());
	//$Y2 = date(substr($thisDay,0,4));
	//$M2 = str_pad(date(substr($thisDay,5,2)-1),2,'0',STR_PAD_LEFT);
	$chkEdate = $Y2.'/'.$M2.'/'.chkDay($Y2.'/'.$M2.'/01',cSTKdate());
	$strQry = " AND `STK_Date` > '".$chkSdate."' AND `STK_Date` <='".$chkEdate."' ";
    $dba = new DB;
    $dba->query("SELECT * FROM `firmstock` WHERE `isStatus`='M' ".$strQry."");
	if($dba->num_rows() > 0){
		return "1";
	}else{
		$db1a = new DB;
		$db1a->query("SELECT * FROM `firmstock` WHERE 1 ".$strQry."");
		if($db1a->num_rows() == 0){
			return "1";
		}else{
			return "0";
		}
	}
}
//回傳雜物品項
function getItemName($mID){
	$db1 = new DB;
	$db1 ->query("SELECT itemName FROM `applyitem2` where itemID='".$mID."'");
	if($db1->num_rows()>0){
		$rs = $db1->fetch_assoc();
		return $rs['itemName'];
	}
}
//回傳住民基本資料陣列 key為欄位名稱
function getPatientInfo($pid) {
	$db1 = new DB;
	$db1->query("SELECT * FROM `patient` WHERE `patientID`='".$pid."'");
	$r1 = $db1->fetch_assoc();
	return $r1;
}
// 回傳名稱
// 資料表,欄位名稱,編號,編號名稱,顯示編號
function getTitle($table,$title,$id,$idName,$displayID,$order="",$orderby="",$where=""){
	if ($order != "" && $orderby != "") {
		$ordertxt = " ORDER BY `".$order."` ".$orderby;
	}
	$sql = "SELECT * FROM `".$table."` where `".$idName."`='".$id."' ".$where." ".$ordertxt;
	$db1 = new DB;
	$db1 ->query($sql);
	if($db1->num_rows()>0){
		$rs = $db1->fetch_assoc();
		return ($displayID==""?"":"【".$rs[$displayID]."】").$rs[$title];
	}
}

function getGroupTitle($table,$title,$delimiter,$titleno,$id,$idName,$displayID,$order="",$orderby="",$type="1"){
	if ($order != "" && $orderby != "") {
		$ordertxt = " ORDER BY `".$order."` ".$orderby;
	}
	$db1 = new DB;
	$db1 ->query("SELECT * FROM `".$table."` where `".$idName."`='".$id."'".$ordertxt);
	if($db1->num_rows()>0){
		$response = array();
		$rs = $db1->fetch_assoc();
		for ($i=1;$i<=$titleno;$i++) {
			if ($type==1) {
				if ($rs[$title.$delimiter.$i]==1) {
					array_push($response, $i);
				}
			} elseif ($type==2) {
				if ($rs[$title.$delimiter.$i]!="") {
					array_push($response, $rs[$title.$delimiter.$i]);
				}
			}
		}
		return $response;
	}
}

function getSystemSetting($option) {
	$db1 = new DB2;
	$db1->query("SELECT `".$option."` FROM `system_setting` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
	$r1 = $db1->fetch_assoc();
	return $r1[$option];
}

/* backup the db OR just a table */
function backup_tables($tables = '*') {
	//get all of the tables
	if($tables == '*') {
		$tables = array();
		$dbresult = new DB;
		$dbresult->query('SHOW TABLES');
		for ($i1=0;$i1<$dbresult->num_rows();$i1++) {
			$result = $dbresult->fetch_assoc();
			$tables[]=$result['Tables_in_'.$_SESSION['ncareDBno_lwj']];
		}
	} else {
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	foreach($tables as $table) {
		$return = "";
		$db1 = new DB;
		$db1->query('SELECT * FROM '.$table);
		$num_fields = $db1->num_fields();
		
		$return.= 'DROP TABLE `'.$table.'`;';
		
		$db1b = new DB;
		$db1b->query('SHOW CREATE TABLE '.$table);
		for ($i1b=0;$i1b<$db1b->num_rows();$i1b++) {
			$r1b = $db1b->fetch_assoc();
			$return.= "\n\n".$r1b['Create Table'].";\n\n";	
		}
		
		//for ($i = 0; $i < $num_fields; $i++) {
			//while($row = mysql_fetch_row($result)) {
		for ($i1c=0;$i1c<$db1->num_rows();$i1c++) {
			$r1c = $db1->fetch_row();
			$return.= 'INSERT INTO '.$table.' VALUES(';
			for($j=0; $j<$num_fields; $j++)  {
				$row[$j] = addslashes($r1c[$j]);
				$row[$j] = preg_replace("/\n/","\\n",$r1c[$j]);
				if (isset($r1c[$j])) { $return.= '"'.$r1c[$j].'"' ; } else { $return.= '""'; }
				if ($j<($num_fields-1)) { $return.= ','; }
			}
			$return.= ");\n";
			//}
		}
		//$return.="\n\n\n";
		//save file
		$dbno = explode("-",$_SESSION['ncareDBno_lwj']);
		$uploaddir1 = 'tmp/';
		if (!file_exists($uploaddir1)) { mkdir($uploaddir1, 0777); }
		$uploaddir2 = 'tmp/db'.$dbno[1].'/';
		delTree($uploaddir2);
		if (!file_exists($uploaddir2)) { mkdir($uploaddir2, 0777); }
		$filename = 'tmp/db'.$dbno[1].'/'.$table.'.sql';
		$handle = fopen($filename,'w+');
		fwrite($handle,$return);
		fclose($handle);
	}
	$folder = 'tmp/db'.$dbno[1].'/';
	$downlaod = create_zip($folder, 'tmp/db'.$dbno[1].'.zip', true);
	return array($filename, $download);
}

function delTree($dir) { 
   $files = array_diff(scandir($dir), array('.','..')); 
    foreach ($files as $file) { 
      (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
    } 
    return rmdir($dir); 
}

/* creates a compressed zip file */
function create_zip($folder ,$destination = '',$overwrite = false) {
	$valid_files = scandir($folder);
	$zip = new ZipArchive();
	if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
		return false;
	}
	//add the files
	foreach($valid_files as $file) {
		$zip->addFile($file,$file);
	}
	
	//close the zip -- done!
	$zip->close();
	//debug
	return 'The zip archive contains '.$zip->numFiles.' files with a status of '.$zip->status;
	
	//check to make sure the file exists
	if (file_exists($destination)) {
		//return $destination;
	};
}

/*function reorder_shift() {
	$db = new DB;
	$db->query("UPDATE `shift_member` SET `order`='777' WHERE `available`='0'");
	$db1 = new DB;
	$db1->query("SELECT * FROM `shift_group` ORDER BY `GroupID` ASC");
	for ($i1=0;$i1<$db1->num_rows();$i1++) {
		$r1 = $db1->fetch_assoc();
		$db2 = new DB;
		$db2->query("SELECT * FROM `shift_member` WHERE `GroupID`='".$r1['GroupID']."' AND `available`='1' ORDER BY `order` ASC");
		for ($i2=0;$i2<$db2->num_rows();$i2++) {
			$db3 = new DB;
			$db3->query("UPDATE `shift_member` SET `order`='".($i2+1)."' WHERE `GroupID`='".$r2['GroupID']."' AND `EmpID`='".$r2['EmpID']."'");
		}
	}
}*/

function vsRange ($loinc, $value) {
	//$loinc = vs83105
	//$value = 量測數值
	$dbrange = new DB;
	$dbrange->query("SELECT * FROM `vitalsign_range` WHERE `itemID`='".$loinc."'");
	for ($i1=0;$i1<$dbrange->num_rows();$i1++) {
		$rrange = $dbrange->fetch_assoc();
		$arrRangeLow[$rrange['itemID']] = $rrange['viewlow'];
		$arrRangeHigh[$rrange['itemID']] = $rrange['viewhigh'];
	}
	
	if ($value!="" && $value < $arrRangeLow[$loinc]) {
		$response = ' class="rangeL"';
	} elseif ($value!="" && $value > $arrRangeHigh[$loinc]) {
		$response = ' class="rangeH"';
	} else {
		$response = '';
	}
	
	return $response;
}
//藥單日曆 (含文字)
function drawmedcalwithtext($qdate) {
	$arrWeekDay = array("Sun","Mon","Tues","Wed","Thurs","Fri","Sat");
	//$num = cal_days_in_month(CAL_GREGORIAN, (int) substr(@$_GET['date'],4,2), substr(@$_GET['date'],0,4));
	$num = date('t', mktime(0, 0, 0, ((int) substr($qdate,4,2))+1, 0, substr($qdate,0,4)));
	for ($i=1;$i<=$num;$i++) {
		$week = date("w",mktime(0,0,0,(int) substr($qdate,4,2),$i,substr($qdate,0,4)));
		$result .= '<td>'.$i.'<br>'.$arrWeekDay[$week].'</td>';
	}
	return $result;
}

//藥單日曆 (空表格)medicine list calender(blank)
function drawmedcal($bg,$medDay,$needgive,$order,$needgiveMed,$time_24HR,$HospNo,$qdate) {
	$bg = explode(";",$bg);
	$medDay = explode(";",$medDay);
	$num = date('t', mktime(0, 0, 0, ((int) substr($qdate,4,2))+1, 0, substr($qdate,0,4)));
	if (in_array('7',$medDay)) {
		//每天用藥daily usage medicine
		for ($i=1;$i<=$num;$i++) {
			if (in_array($i,$bg) && $needgive!=0) {
				if (strlen($i)==1) {
					$needdate = '0'.$i;
				}else{
		  			$needdate = $i;
				}
				$dbMatch = new DB;
				$dbMatch->query("SELECT * FROM `nurseform17a` WHERE `HospNo`='".$HospNo."' AND `Qmedicine1`='".$needgiveMed."' AND `QNeedUseDate`='".$qdate.$needdate."' AND `QNeedUseTime`='".$time_24HR."'");
				if ($dbMatch->num_rows()>0) {
					if(($order%2)==1){
						$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
					}else{
						$result .= '<td width="27">';
					}
					$rdbMatch = $dbMatch->fetch_assoc();
					if($rdbMatch['QMedicationRecordType']=="1"){
						$result .= '<i class="fa fa-check"></i></td>';
					}elseif($rdbMatch['QMedicationRecordType']=="2"){
						$result .= 'NPO</td>';
					}elseif($rdbMatch['QMedicationRecordType']=="3"){
						$result .= 'Ref</td>';
					}elseif($rdbMatch['QMedicationRecordType']=="4"){
						$result .= 'Out</td>';
					}elseif($rdbMatch['QMedicationRecordType']=="5"){
						$result .= 'A</td>';
					}elseif($rdbMatch['QMedicationRecordType']=="6"){
						$result .= 'Hold</td>';
					}elseif($rdbMatch['QMedicationRecordType']=="7"){
						$result .= '＊</td>';
					}else{
						$result .= '<i class="fa fa-check"></i></td>';
					}
					//$result .= '<td width="27"><button id="newUSErecord2_'.date(Ym).$needdate.'_'.$order.'_'.$needgiveMed.'_'.$time_24HR.'"/><i class="fa fa-check"></i></button></td>';
				}else{
					$ListDate = $qdate.$needdate;
					if($ListDate == date(Ymd)){
						if($time_24HR <= date(H)){
							if(($order%2)==1){
								$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
							}else{
								$result .= '<td width="27">';
							}
							$result .= '<button id="newUSErecord2_'.$qdate.$needdate.'_'.$order.'_'.$needgiveMed.'_'.$time_24HR.'" style="background-color:red;"/><i class="fa fa-exclamation"></i></button></td>';
							$_SESSION['Easy_Medicine_Red_lwj']++;
						}else{
							if(($order%2)==1){
								$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
							}else{
								$result .= '<td width="27">';
							}
							$result .= '<button id="newUSErecord2_'.$qdate.$needdate.'_'.$order.'_'.$needgiveMed.'_'.$time_24HR.'" style="background-color:orange;"/><i class="fa fa-exclamation"></i></button></td>';
							$_SESSION['Easy_Medicine_Orange_lwj']++;
						}
					}else{
						if(($order%2)==1){
							$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
						}else{
							$result .= '<td width="27">';
						}
						$result .= '<button id="newUSErecord2_'.$qdate.$needdate.'_'.$order.'_'.$needgiveMed.'_'.$time_24HR.'"/><i class="fa fa-exclamation"></i></button></td>';
					}
				}
			}else{
				if(($order%2)==1){
					$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
				}else{
					$result .= '<td width="27">';
				}
				$result .= '&nbsp;</td>';
			}
		}
	} elseif (in_array('8',$medDay)) {
		//隔天once two days
		$dayno = 0;
		for ($i=1;$i<=$num;$i++) {
			if (in_array($i,$bg) && $needgive!=0) {
				if (strlen($i)==1) {
				    $needdate = '0'.$i;
				}else{
		  			$needdate = $i;
				}
				if (($dayno%2)==0) {
					$dbMatch = new DB;
					$dbMatch->query("SELECT * FROM `nurseform17a` WHERE `HospNo`='".$HospNo."' AND `Qmedicine1`='".$needgiveMed."' AND `QNeedUseDate`='".$qdate.$needdate."' AND `QNeedUseTime`='".$time_24HR."'");
					if ($dbMatch->num_rows()>0) {
						if(($order%2)==1){
							$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
						}else{
							$result .= '<td width="27">';
						}
						$rdbMatch = $dbMatch->fetch_assoc();
						if($rdbMatch['QMedicationRecordType']=="1"){
							$result .= '<i class="fa fa-check"></i></td>';
						}elseif($rdbMatch['QMedicationRecordType']=="2"){
							$result .= 'NPO</td>';
						}elseif($rdbMatch['QMedicationRecordType']=="3"){
							$result .= 'Ref</td>';
						}elseif($rdbMatch['QMedicationRecordType']=="4"){
							$result .= 'Out</td>';
						}elseif($rdbMatch['QMedicationRecordType']=="5"){
							$result .= 'A</td>';
						}elseif($rdbMatch['QMedicationRecordType']=="6"){
							$result .= 'Hold</td>';
						}elseif($rdbMatch['QMedicationRecordType']=="7"){
							$result .= '＊</td>';
						}else{
							$result .= '<i class="fa fa-check"></i></td>';
						}
					}else{
						$ListDate = $qdate.$needdate;
						if($ListDate == date(Ymd)){
							if($time_24HR <= date(H)){
								if(($order%2)==1){
									$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
								}else{
									$result .= '<td width="27">';
								}
								$result .= '<button id="newUSErecord2_'.$qdate.$needdate.'_'.$order.'_'.$needgiveMed.'_'.$time_24HR.'" style="background-color:red;"/><i class="fa fa-exclamation"></i></button></td>';
								$_SESSION['Easy_Medicine_Red_lwj']++;
							}else{
								if(($order%2)==1){
									$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
								}else{
									$result .= '<td width="27">';
								}
								$result .= '<button id="newUSErecord2_'.$qdate.$needdate.'_'.$order.'_'.$needgiveMed.'_'.$time_24HR.'" style="background-color:orange;"/><i class="fa fa-exclamation"></i></button></td>';
								$_SESSION['Easy_Medicine_Orange_lwj']++;
							}
						}else{
							if(($order%2)==1){
								$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
							}else{
								$result .= '<td width="27">';
							}
							$result .= '<button id="newUSErecord2_'.$qdate.$needdate.'_'.$order.'_'.$needgiveMed.'_'.$time_24HR.'"/><i class="fa fa-exclamation"></i></button></td>';
						}
					}
				}else{
					if(($order%2)==1){
						$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
					}else{
						$result .= '<td width="27">';
					}
					$result .= '&nbsp;</td>';
				}
				$dayno+=1;
			}else{
				if(($order%2)==1){
					$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
				}else{
					$result .= '<td width="27">';
				}
				$result .= '&nbsp;</td>';
			}
		}
	} else {
		//一般天數general day number
		for($i=0;$i<count($medDay)-1;$i++){
			$medDay[$i] = $medDay[$i]+1;
			if($medDay[$i]=="7"){
				$medDay[$i]=0;
			}
		}
		for ($i=1;$i<=$num;$i++) {
			$week = date("w",mktime(0,0,0,(int) substr($qdate,4,2),$i,substr($qdate,0,4)));
			if (in_array($i,$bg) && $needgive!=0) {
				if (in_array($week,$medDay)) {
					if (strlen($i)==1) {
				    	$needdate = '0'.$i;
					}else{
		  				$needdate = $i;
					}
					$dbMatch = new DB;
					$dbMatch->query("SELECT * FROM `nurseform17a` WHERE `HospNo`='".$HospNo."' AND `Qmedicine1`='".$needgiveMed."' AND `QNeedUseDate`='".$qdate.$needdate."' AND `QNeedUseTime`='".$time_24HR."'");
					if ($dbMatch->num_rows()>0) {
						if(($order%2)==1){
							$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
						}else{
							$result .= '<td width="27">';
						}
						$rdbMatch = $dbMatch->fetch_assoc();
						if($rdbMatch['QMedicationRecordType']=="1"){
							$result .= '<i class="fa fa-check"></i></td>';
						}elseif($rdbMatch['QMedicationRecordType']=="2"){
							$result .= 'NPO</td>';
						}elseif($rdbMatch['QMedicationRecordType']=="3"){
							$result .= 'Ref</td>';
						}elseif($rdbMatch['QMedicationRecordType']=="4"){
							$result .= 'Out</td>';
						}elseif($rdbMatch['QMedicationRecordType']=="5"){
							$result .= 'A</td>';
						}elseif($rdbMatch['QMedicationRecordType']=="6"){
							$result .= 'Hold</td>';
						}elseif($rdbMatch['QMedicationRecordType']=="7"){
							$result .= '＊</td>';
						}else{
							$result .= '<i class="fa fa-check"></i></td>';
						}
					}else{
						$ListDate = $qdate.$needdate;
						if($ListDate == date(Ymd)){
							if($time_24HR <= date(H)){
								if(($order%2)==1){
									$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
								}else{
									$result .= '<td width="27">';
								}
								$result .= '<button id="newUSErecord2_'.$qdate.$needdate.'_'.$order.'_'.$needgiveMed.'_'.$time_24HR.'" style="background-color:red;"/><i class="fa fa-exclamation"></i></button></td>';
								$_SESSION['Easy_Medicine_Red_lwj']++;
							}else{
								if(($order%2)==1){
									$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
								}else{
									$result .= '<td width="27">';
								}
								$result .= '<button id="newUSErecord2_'.$qdate.$needdate.'_'.$order.'_'.$needgiveMed.'_'.$time_24HR.'" style="background-color:orange;"/><i class="fa fa-exclamation"></i></button></td>';
								$_SESSION['Easy_Medicine_Orange_lwj']++;
							}
						}else{
							if(($order%2)==1){
								$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
							}else{
								$result .= '<td width="27">';
							}
							$result .= '<button id="newUSErecord2_'.$qdate.$needdate.'_'.$order.'_'.$needgiveMed.'_'.$time_24HR.'"/><i class="fa fa-exclamation"></i></button></td>';
						}
					}
				}else{
					if(($order%2)==1){
						$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
					}else{
						$result .= '<td width="27">';
					}
					$result .= '&nbsp;</td>';
				}
			}else{
				if(($order%2)==1){
					$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
				}else{
					$result .= '<td width="27">';
				}
				$result .= '&nbsp;</td>';
			}
		}
	}
	return $result;
}
//藥單日曆 (空表格、加高空格)medicine list calender(blank, larger tab/space)
function drawmedcal_br($bg,$medDay) {
	if (@$_GET['date']=="--select month--") {
		$qdate = date(Ym);
	} else {
		$qdate = @$_GET['date'];
	}
	$bg = explode(";",$bg);
	$medDay = explode(";",$medDay);
	$num = date('t', mktime(0, 0, 0, ((int) substr($qdate,4,2))+1, 0, substr($qdate,0,4)));
	if (in_array('7',$medDay)) {
		//每天用藥daily usage medicine
		for ($i=1;$i<=$num;$i++) {
			$result .= '<td width="27" ';
			if (in_array($i,$bg)) {
				//$result .= ' class="title"';
			}
			$result .= '>&nbsp;<br>&nbsp;<br>&nbsp;</td>';
		}
	} elseif (in_array('8',$medDay)) {
		//隔天once two days
		$dayno = 0;
		for ($i=1;$i<=$num;$i++) {
			$result .= '<td width="27" ';
			if (in_array($i,$bg)) {
				if (($dayno%2)==0) {
					//$result .= ' class="title"';
				}
				$dayno+=1;
			}
			$result .= '>&nbsp;<br>&nbsp;<br>&nbsp;</td>';
		}
	} else {
		//一般天數general days number
		for ($i=1;$i<=$num;$i++) {
			$week = date("w",mktime(0,0,0,(int) substr($qdate,4,2),$i,substr($qdate,0,4)));
			$result .= '<td width="27" ';
			if (in_array($i,$bg)) {
				if (in_array($week-1,$medDay)) {
					//$result .= ' class="title"';
				}
			}
			$result .= '>&nbsp;<br>&nbsp;<br>&nbsp;</td>';
		}
	}
	return $result;
}

//胰島素日曆 (空表格)Insulin list calender(blank)
function drawInsulin($bg,$medDay,$needgive,$order,$needgiveInsulin,$time_24HR,$HospNo,$qdate) {
	$bg = explode(";",$bg);
	$medDay = explode(";",$medDay);
	$num = date('t', mktime(0, 0, 0, ((int) substr($qdate,4,2))+1, 0, substr($qdate,0,4)));
	if (in_array('8',$medDay)) {
		//每天用胰島素daily usage Insulin
		for ($i=1;$i<=$num;$i++) {
			if (in_array($i,$bg) && $needgive!=0) {
				if (strlen($i)==1) {
					$needdate = '0'.$i;
				}else{
		  			$needdate = $i;
				}
				$dbMatch = new DB;
				$dbMatch->query("SELECT * FROM `nurseform18_1` WHERE `HospNo`='".$HospNo."' AND `Qmedicine1`='".$needgiveInsulin."' AND `QNeedUseDate`='".$qdate.$needdate."' AND `QNeedUseTime`='".$time_24HR."'");
				if ($dbMatch->num_rows()>0) {
					if(($order%2)==1){
						$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
					}else{
						$result .= '<td width="27">';
					}
					$rdbMatch = $dbMatch->fetch_assoc();
					if($rdbMatch['QInsulinRecordType']=="1"){
						$result .= '<i class="fa fa-check"></i></td>';
					}elseif($rdbMatch['QInsulinRecordType']=="2"){
						$result .= 'NPO</td>';
					}elseif($rdbMatch['QInsulinRecordType']=="3"){
						$result .= 'Ref</td>';
					}elseif($rdbMatch['QInsulinRecordType']=="4"){
						$result .= 'Out</td>';
					}elseif($rdbMatch['QInsulinRecordType']=="5"){
						$result .= 'A</td>';
					}elseif($rdbMatch['QInsulinRecordType']=="6"){
						$result .= 'Hold</td>';
					}elseif($rdbMatch['QInsulinRecordType']=="7"){
						$result .= '＊</td>';
					}else{
						$result .= '<i class="fa fa-check"></i></td>';
					}
					//$result .= '<td width="27"><button id="newUSErecord3_'.date(Ym).$needdate.'_'.$order.'_'.$needgiveInsulin.'_'.$time_24HR.'"/><i class="fa fa-check"></i></button></td>';
				}else{
					$ListDate = $qdate.$needdate;
					if($ListDate == date(Ymd)){
						if($time_24HR <= date(H)){
							if(($order%2)==1){
								$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
							}else{
								$result .= '<td width="27">';
							}
							$result .= '<button id="newUSErecord3_'.$qdate.$needdate.'_'.$order.'_'.$needgiveInsulin.'_'.$time_24HR.'" style="background-color:red;"/><i class="fa fa-exclamation"></i></button></td>';
							$_SESSION['Easy_Insulin_Red_lwj']++;
						}else{
							if(($order%2)==1){
								$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
							}else{
								$result .= '<td width="27">';
							}
							$result .= '<button id="newUSErecord3_'.$qdate.$needdate.'_'.$order.'_'.$needgiveInsulin.'_'.$time_24HR.'" style="background-color:orange;"/><i class="fa fa-exclamation"></i></button></td>';
							$_SESSION['Easy_Insulin_Orange_lwj']++;
						}
					}else{
						if(($order%2)==1){
							$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
						}else{
							$result .= '<td width="27">';
						}
						$result .= '<button id="newUSErecord3_'.$qdate.$needdate.'_'.$order.'_'.$needgiveInsulin.'_'.$time_24HR.'"/><i class="fa fa-exclamation"></i></button></td>';
					}
				}
			}else{
				if(($order%2)==1){
					$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
				}else{
					$result .= '<td width="27">';
				}
				$result .= '&nbsp;</td>';
			}
		}
	} elseif (in_array('9',$medDay)) {
		//隔天once two days
		$dayno = 0;
		for ($i=1;$i<=$num;$i++) {
			if (in_array($i,$bg) && $needgive!=0) {
				if (strlen($i)==1) {
				    $needdate = '0'.$i;
				}else{
		  			$needdate = $i;
				}
				if (($dayno%2)==0) {
					$dbMatch = new DB;
					$dbMatch->query("SELECT * FROM `nurseform18_1` WHERE `HospNo`='".$HospNo."' AND `Qmedicine1`='".$needgiveInsulin."' AND `QNeedUseDate`='".$qdate.$needdate."' AND `QNeedUseTime`='".$time_24HR."'");
					if ($dbMatch->num_rows()>0) {
						if(($order%2)==1){
							$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
						}else{
							$result .= '<td width="27">';
						}
						$rdbMatch = $dbMatch->fetch_assoc();
						if($rdbMatch['QInsulinRecordType']=="1"){
							$result .= '<i class="fa fa-check"></i></td>';
						}elseif($rdbMatch['QInsulinRecordType']=="2"){
							$result .= 'NPO</td>';
						}elseif($rdbMatch['QInsulinRecordType']=="3"){
							$result .= 'Ref</td>';
						}elseif($rdbMatch['QInsulinRecordType']=="4"){
							$result .= 'Out</td>';
						}elseif($rdbMatch['QInsulinRecordType']=="5"){
							$result .= 'A</td>';
						}elseif($rdbMatch['QInsulinRecordType']=="6"){
							$result .= 'Hold</td>';
						}elseif($rdbMatch['QInsulinRecordType']=="7"){
							$result .= '＊</td>';
						}else{
							$result .= '<i class="fa fa-check"></i></td>';
						}
					}else{
						$ListDate = $qdate.$needdate;
						if($ListDate == date(Ymd)){
							if($time_24HR <= date(H)){
								if(($order%2)==1){
									$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
								}else{
									$result .= '<td width="27">';
								}
								$result .= '<button id="newUSErecord3_'.$qdate.$needdate.'_'.$order.'_'.$needgiveInsulin.'_'.$time_24HR.'" style="background-color:red;"/><i class="fa fa-exclamation"></i></button></td>';
								$_SESSION['Easy_Insulin_Red_lwj']++;
							}else{
								if(($order%2)==1){
									$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
								}else{
									$result .= '<td width="27">';
								}
								$result .= '<button id="newUSErecord3_'.$qdate.$needdate.'_'.$order.'_'.$needgiveInsulin.'_'.$time_24HR.'" style="background-color:orange;"/><i class="fa fa-exclamation"></i></button></td>';
								$_SESSION['Easy_Insulin_Orange_lwj']++;
							}
						}else{
							if(($order%2)==1){
								$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
							}else{
								$result .= '<td width="27">';
							}
							$result .= '<button id="newUSErecord3_'.$qdate.$needdate.'_'.$order.'_'.$needgiveInsulin.'_'.$time_24HR.'"/><i class="fa fa-exclamation"></i></button></td>';
						}
					}
				}else{
					if(($order%2)==1){
						$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
					}else{
						$result .= '<td width="27">';
					}
					$result .= '&nbsp;</td>';
				}
				$dayno+=1;
			}else{
				if(($order%2)==1){
					$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
				}else{
					$result .= '<td width="27">';
				}
				$result .= '&nbsp;</td>';
			}
		}
	} else {
		//一般天數general day number
		for($i=0;$i<count($medDay)-1;$i++){
			$medDay[$i] = $medDay[$i];
			if($medDay[$i]=="7"){
				$medDay[$i]=0;
			}
		}
		for ($i=1;$i<=$num;$i++) {
			$week = date("w",mktime(0,0,0,(int) substr($qdate,4,2),$i,substr($qdate,0,4)));
			if (in_array($i,$bg) && $needgive!=0) {
				if (in_array($week,$medDay)) {
					if (strlen($i)==1) {
				    	$needdate = '0'.$i;
					}else{
		  				$needdate = $i;
					}
					$dbMatch = new DB;
					$dbMatch->query("SELECT * FROM `nurseform18_1` WHERE `HospNo`='".$HospNo."' AND `Qmedicine1`='".$needgiveInsulin."' AND `QNeedUseDate`='".$qdate.$needdate."' AND `QNeedUseTime`='".$time_24HR."'");
					if ($dbMatch->num_rows()>0) {
						if(($order%2)==1){
							$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
						}else{
							$result .= '<td width="27">';
						}
						$rdbMatch = $dbMatch->fetch_assoc();
						if($rdbMatch['QInsulinRecordType']=="1"){
							$result .= '<i class="fa fa-check"></i></td>';
						}elseif($rdbMatch['QInsulinRecordType']=="2"){
							$result .= 'NPO</td>';
						}elseif($rdbMatch['QInsulinRecordType']=="3"){
							$result .= 'Ref</td>';
						}elseif($rdbMatch['QInsulinRecordType']=="4"){
							$result .= 'Out</td>';
						}elseif($rdbMatch['QInsulinRecordType']=="5"){
							$result .= 'A</td>';
						}elseif($rdbMatch['QInsulinRecordType']=="6"){
							$result .= 'Hold</td>';
						}elseif($rdbMatch['QInsulinRecordType']=="7"){
							$result .= '＊</td>';
						}else{
							$result .= '<i class="fa fa-check"></i></td>';
						}
					}else{
						$ListDate = $qdate.$needdate;
						if($ListDate == date(Ymd)){
							if($time_24HR <= date(H)){
								if(($order%2)==1){
									$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
								}else{
									$result .= '<td width="27">';
								}
								$result .= '<button id="newUSErecord3_'.$qdate.$needdate.'_'.$order.'_'.$needgiveInsulin.'_'.$time_24HR.'" style="background-color:red;"/><i class="fa fa-exclamation"></i></button></td>';
								$_SESSION['Easy_Insulin_Red_lwj']++;
							}else{
								if(($order%2)==1){
									$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
								}else{
									$result .= '<td width="27">';
								}
								$result .= '<button id="newUSErecord3_'.$qdate.$needdate.'_'.$order.'_'.$needgiveInsulin.'_'.$time_24HR.'" style="background-color:orange;"/><i class="fa fa-exclamation"></i></button></td>';
								$_SESSION['Easy_Insulin_Orange_lwj']++;
							}
						}else{
							if(($order%2)==1){
								$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
							}else{
								$result .= '<td width="27">';
							}
							$result .= '<button id="newUSErecord3_'.$qdate.$needdate.'_'.$order.'_'.$needgiveInsulin.'_'.$time_24HR.'"/><i class="fa fa-exclamation"></i></button></td>';
						}
					}
				}else{
					if(($order%2)==1){
						$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
					}else{
						$result .= '<td width="27">';
					}
					$result .= '&nbsp;</td>';
				}
			}else{
				if(($order%2)==1){
					$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
				}else{
					$result .= '<td width="27">';
				}
				$result .= '&nbsp;</td>';
			}
		}
	}
	return $result;
}

//管線日曆 (空表格)Pipeline list calender(blank)
function drawPipeline($HospNo,$PipelineNo,$countday,$order,$qdate) {
	$num = date('t', mktime(0, 0, 0, ((int) substr($qdate,4,2))+1, 0, substr($qdate,0,4)));
	$db = new DB;
	$db->query("SELECT * FROM `nurseform02k` WHERE `HospNo`='".$HospNo."' AND `PipelineNo`='".$PipelineNo."' ORDER BY `date` ASC ");
	$needgiveDate="";
	$needgiveDateArray="";
	for($i=0;$i<$db->num_rows();$i++){
		$r = $db->fetch_assoc();
  		foreach ($r as $k=>$v) {
      		${"nurseform02k_".$k} = $v;
  		}
		$dateYearMonth = substr($nurseform02k_date,0,6);
		if($dateYearMonth==$qdate){
			$needgiveDate .= substr($nurseform02k_date,6,2).";";
		}
	}
	$countdayArray = explode("/",$countday);
	$NextDate = $countdayArray[0].$countdayArray[1];
	if($NextDate==$qdate){
		$needgiveDate .= $countdayArray[2];
	}
	$needgiveDateArray = explode(";",$needgiveDate);
		for ($i=1;$i<=$num;$i++) {
			if (strlen($i)==1) {
				$needdate = '0'.$i;
			}else{
		  		$needdate = $i;
			}
			if (in_array($needdate,$needgiveDateArray)) {
				$dbMatch = new DB;
				$dbMatch->query("SELECT * FROM `nurseform02k` WHERE `HospNo`='".$HospNo."' AND `PipelineNo`='".$PipelineNo."' AND `date`='".$qdate.$needdate."'");
				if ($dbMatch->num_rows()>0) {
					$rdbMatch = $dbMatch->fetch_assoc();
					if(($order%2)==1){
						$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
					}else{
						$result .= '<td width="27">';
					}
					$result .= '<i class="fa fa-check"></i></td>';
					//$result .= '<td width="27"><button id="newUSErecord3_'.date(Ym).$needdate.'_'.$order.'_'.$needgiveInsulin.'_'.$time_24HR.'"/><i class="fa fa-check"></i></button></td>';
				}else{
					if($needdate<=date(d) || $qdate<date(Ym)){
						$_SESSION['Easy_Pipeline_Red_lwj']++;
						$result .= '<td width="27" style="background-color:red;">';
					}else{
						$_SESSION['Easy_Pipeline_Orange_lwj']++;
						$result .= '<td width="27" style="background-color:orange;">';
					}
					$db2 = new DB;
					$db2->query("SELECT * FROM `nurseform02k` WHERE `HospNo`='".$HospNo."' AND `PipelineNo`='".$PipelineNo."' ORDER BY `date` DESC LIMIT 0,1");
					$db2 = $db2->fetch_assoc();
					$date = $db2['date'];
					$result .= '<form>
					            <input type="hidden" id="Q4_'.$HospNo.'_'.$date.'_'.$PipelineNo.'" value="'.$countday.'">
					            <input type="button" id="status_'.$HospNo.'_'.$date.'_'.$PipelineNo.'" onclick="confirmStatus_Pipeline(this.id,1);" value="Replace">
					            <input type="button" id="status_'.$HospNo.'_'.$date.'_'.$PipelineNo.'" onclick="confirmStatus_Pipeline(this.id,2);" value="Remove">
								</form>
					            </td>';
				}
			}else{
				if(($order%2)==1){
					$result .= '<td width="27" style="background-color:rgba(255,255,0,0.2);">';
				}else{
					$result .= '<td width="27">';
				}
				$result .= '&nbsp;</td>';
			}
		}
	return $result;
}

//住民安全 (空表格)
function drawSafe($HospNo,$hm,$qdate) {
	$num = date('t', mktime(0, 0, 0, ((int) substr($qdate,4,2))+1, 0, substr($qdate,0,4)));
	$result = '';
	$arr_hm = explode(":",$hm);
	if(strlen($arr_hm[0])==1){
		$hm = '0'.$hm;
	}
	$arr_hm = explode(":",$hm);
	for ($i=1;$i<=$num;$i++) {
		if(strlen($i)==1){
			$id = '0'.$i;
		}else{
			$id = $i;
		}
		$checktime = substr($qdate,0,4).'-'.substr($qdate,4,2).'-'.$id.' '.$hm.':00';
		$checktimeID = $qdate.$id.'_'.$arr_hm[0].$arr_hm[1].'00';
		$dbMatch = new DB;
		$dbMatch->query("SELECT * FROM `careform14` WHERE `HospNo`='".$HospNo."' AND `checktime`='".$checktime."'");
		if ($dbMatch->num_rows()>0) {
			$rdbMatch = $dbMatch->fetch_assoc();
			echo '<div name="QfillerName_'.$checktimeID.'" id="QfillerName_'.$checktimeID.'" style="display:none; z-index:999; position:fixed; background-color:rgba(0,0,0,0.7); color:yellow;"><div style="padding:7px;">'.checkusername($rdbMatch['Qfiller']).'</div></div>';
			if($rdbMatch['status']==0){
				if($arr_hm[0]<8){
					$result .= '<td>';
				}elseif($arr_hm[0]>8 && $arr_hm[0]<16){
					$result .= '<td style="background-color:rgba(210,233,233,1);">';
				}else{
					$result .= '<td>';
				}
				$result .= '<a onmouseover="showQfillerName(\''.$checktimeID.'\');" onmouseout="hiddenQfillerName(\''.$checktimeID.'\');"><i class="fa fa-check"></i></a></td>';
			}else{
				if($arr_hm[0]<8){
					$result .= '<td style="color:red;">';
				}elseif($arr_hm[0]>8 && $arr_hm[0]<16){
					$result .= '<td style="background-color:rgba(210,233,233,1); color:red;">';
				}else{
					$result .= '<td style="color:red;">';
				}
				$result .= '<a onmouseover="showQfillerName(\''.$checktimeID.'\');" onmouseout="hiddenQfillerName(\''.$checktimeID.'\');"><i class="fa fa-check-circle-o fa-2x" aria-hidden="true"></i></a></td>';
			}
		}else{
			$arr_checktime = explode(" ",$checktime);
			if($arr_checktime[0]>date("Y-m-d")){
				if($arr_hm[0]<8){
					$result .= '<td>';
				}elseif($arr_hm[0]>8 && $arr_hm[0]<16){
					$result .= '<td style="background-color:rgba(210,233,233,1);">';
				}else{
					$result .= '<td>';
				}
				$result .= '</td>';
			}else{
				if($id==date("d")){
					if($hm<date("H:i")){
						$result .= '<td style="background-color:rgba(255,0,0,0.4);">';
					}else{
						$result .= '<td style="background-color:rgba(255,255,0,0.4);">';
					}
				}else{
					if($arr_hm[0]<8){
						$result .= '<td>';
					}elseif($arr_hm[0]>8 && $arr_hm[0]<16){
						$result .= '<td style="background-color:rgba(210,233,233,1);">';
					}else{
						$result .= '<td>';
					}
				}
				if($id!=date("d")){
					$result .= '<button id="newCheckSafe_'.$checktime.'"/><i class="fa fa-exclamation"></i></button></td>';
				}else{
					if($arr_checktime[1]<=date("H:i:s",strtotime("+1800 seconds"))){
						$result .= '<button id="newCheckSafe_'.$checktime.'"/><i class="fa fa-exclamation"></i></button></td>';
					}else{
						$result .= '</td>';
					}
				}
				
			}
		}
	}
	return $result;
}

function checkRace($Race){
	if($Race=="A"){ return "American Indian or Alaska Native";}
	if($Race=="B"){ return "Asian";}
	if($Race=="C"){ return "Black or African American";}
	if($Race=="D"){ return "Hispanic or Latino";}
	if($Race=="E"){ return "Native Hawaiian or Other Pacific Islander";}
	if($Race=="F"){ return "White";}
}


function getPatientPic($HospNo){
	$dbPhoto = new DB;
	$dbPhoto->query("SELECT * FROM `pat_idphoto` WHERE `HospNo`='".$HospNo."'");
	$rPhoto = $dbPhoto->fetch_assoc();
	$photo = $rPhoto['photo'];
	$filename = 'uploadfile/'.$_SESSION['nOrgID_lwj'].'/'.$HospNo.'/'.$photo;
	if ($photo=="") {
		$pic ='<img src="Images/noImage.png" width="180"></img>';
	}else{
		$pic ='<img src="'.$filename.'" border="0" width="180"></img>';
	}
	return $pic;
}


function getShift_Area($EmpGroup,$EmpID){
	if($EmpGroup!="" && $EmpID!=""){
		if($EmpGroup==1){ $table = "employer_shift"; $WHERE_EmpID = "EmpID"; }
		if($EmpGroup==2){ $table = "foreignemployer_shift"; $WHERE_EmpID = "foreignID"; }
		$db = new DB;
		$db->query("SELECT * FROM `".$table."` WHERE `".$WHERE_EmpID."`='".$EmpID."' AND `date`='".date("Ymd")."'");
		if ($db->num_rows()>0) {
			$r = $db->fetch_assoc();
			return $r['area'];
		}else{
			return '<script>alert("尚未排班");</script>';
		}
	}
}

function getPrimary_Duty_Nurse($areaName){
	$db = new DB;
	$db->query("SELECT * FROM `areainfo` WHERE `areaName`='".$areaName."'");
	if ($db->num_rows()>0) {
		$r = $db->fetch_assoc();
		return $r['PrimaryDutyNurse'];
	}else{
		return 'NotPrimary';
	}
}

function getEnglishMonth($month){
	if(substr($month,0,1)=="0"){ $month = substr($month,1,1); }
	$arrMonth = array('','January','February','March','April','May','June','July','August','September','October','November','December');
	return $arrMonth[$month];
}
?>