<?php
$db1 = new DB;
if (@$_GET['nID']==NULL) {
	$sql1 = "SELECT * FROM `careform12` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql1 = "SELECT * FROM `careform12` WHERE `nID`='".mysql_escape_string($_GET['nID'])."'";
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
?>
<div class="moduleNoTab">
<form  method="post" onSubmit="return checkForm();" action="index.php?func=databaseAI">
<table cellpadding="5">
  <tr>
  	<td class="title" colspan="6">照顧計畫書</td>
  </tr>
  <tr height="25">
    <td class="title">主要問題</td>
    <td colspan="5"><?php echo draw_checkbox_2col("Q1","1.完全無法生活自理;2.部分無法生活自理;3.尚未適應機構生活;4.情緒經常不穩定;5.情緒有時不穩定;6.Other(s):<input type=\"text\" name=\"Q1a\" id=\"Q1a\" value=\"".$Q1a."\">",$Q1,"multi"); ?></td>
  </tr>
  <tr height="30">
    <td class="title">Resident/家屬 期望</td>
    <td colspan="5"><?php echo draw_checkbox_2col("Q2","1.給予關心及安撫情緒;2.給予協助盡快適應機構生活;3.給予協助上廁所;4.依需求給予食用家屬帶來的食物;5.依需求給予使用家屬帶來的用品;6.Other(s):<input type=\"text\" name=\"Q2a\" id=\"Q2a\" value=\"".$Q2a."\">",$Q2,"multi"); ?></td>
  </tr>
  <tr height="30">
    <td class="title">照顧目標</td>
    <td colspan="5"><?php echo draw_checkbox_2col("Q3","1.完成協助生活起居;2.給予關心及安撫情緒;3.給予協助盡快適應機構生活;4.給予協助上廁所;5.依需求給予食用家屬帶來的食物;6.依需求給予使用家屬帶來的用品;7.完成家屬合理交代事項;8.給予訓練生活自理功能;9.安排完整的休閒娛樂活動;10.Other(s):<input type=\"text\" name=\"Q3a\" id=\"Q3a\" value=\"".$Q3a."\">",$Q3,"multi"); ?></td>
  </tr>
  <tr>
  	<td class="title" colspan="6">長輩重點照護表</td>
  </tr>
  <tr height="30">
    <td class="title_s">Item(s)</td>
    <td class="title_s" width="185">一</td>
    <td class="title_s" width="185">二</td>
    <td class="title_s" width="185">三</td>
    <td class="title_s" width="185">四</td>
    <td class="title_s" width="185">五</td>
  </tr>
  <tr height="30">
    <td class="title_s">A.Diet</td>
    <td valign="top"><?php echo draw_checkbox("Q4","口食可自理;口食半自理;口食需協助;鼻胃管管灌;十二指腸管管灌;Other(s):<input type=\"text\" name=\"Q4a\" id=\"Q4a\" value=\"".$Q4a."\" size=\"15\">",$Q4,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q5","葷;素;早齋;初一十五齋日;特齋日：<input type=\"text\" name=\"Q5a\" id=\"Q5a\" value=\"".$Q5a."\" size=\"15\">;Other(s):<input type=\"text\" name=\"Q5b\" id=\"Q5b\" value=\"".$Q5b."\" size=\"15\">",$Q5,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q6","無食物禁忌;禁牛肉;禁豬肉;禁鴨肉;禁雞肉;禁魚;禁蝦;禁海鮮類;禁蛋;Other(s):<input type=\"text\" name=\"Q6a\" id=\"Q6a\" value=\"".$Q6a."\" size=\"15\">",$Q6,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q7","喜麵條;喜麵包;喜饅頭;喜稀飯;喜白飯;喜水餃;麵食類都好;Other(s):<input type=\"text\" name=\"Q7a\" id=\"Q7a\" value=\"".$Q7a."\" size=\"15\">",$Q7,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q8","限鹽（菜餚過水）;限糖;限鹽+限糖;低脂;低蛋白;高蛋白;無飲食限制;Other(s):<input type=\"text\" name=\"Q8a\" id=\"Q8a\" value=\"".$Q8a."\" size=\"15\">",$Q8,"multi"); ?></td>
  </tr>
  <tr height="30">
    <td class="title_s">B.餐食類別</td>

    <td valign="top"><?php echo draw_checkbox("Q9","Cooked rice;Porridge;半飯半稀飯;麵食類;Liquid;Other(s):<input type=\"text\" name=\"Q9a\" id=\"Q9a\" value=\"".$Q9a."\" size=\"15\">",$Q9,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q10","正常餐;粗碎餐;細碎餐;Mashed meal;管灌餐;Other(s):<input type=\"text\" name=\"Q10a\" id=\"Q10a\" value=\"".$Q10a."\" size=\"15\">",$Q10,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q11","一份;2/3 份;31/2 份;1/3 份;Other(s):<input type=\"text\" name=\"Q11a\" id=\"Q11a\" value=\"".$Q11a."\" size=\"15\">",$Q11,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q12","晚上多備一份餐;夜點銀奶;晚上自備夜點;不需要夜點;Other(s):<input type=\"text\" name=\"Q12a\" id=\"Q12a\" value=\"".$Q12a."\" size=\"15\">",$Q12,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q13","自備奶粉;自備亞培;自備營養品;None;Other(s):<input type=\"text\" name=\"Q13a\" id=\"Q13a\" value=\"".$Q13a."\" size=\"15\">",$Q13,"multi"); ?></td>
  </tr>
  <tr height="30">
    <td class="title_s">C.Excretion</td>
    <td valign="top"><?php echo draw_checkbox("Q14","自解;Indwelling catheter;膀胱造口;人工肛門;Other(s):<input type=\"text\" name=\"Q14a\" id=\"Q14a\" value=\"".$Q14a."\" size=\"15\">",$Q14,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q15","可自理;部分自理;需協助;協助每二小時檢查尿布;Other(s):<input type=\"text\" name=\"Q15a\" id=\"Q15a\" value=\"".$Q15a."\" size=\"15\">",$Q15,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q16","便盆椅;尿壺;學習褲;Diapers;不需要排泄輔助物;Other(s):<input type=\"text\" name=\"Q16a\" id=\"Q16a\" value=\"".$Q16a."\" size=\"15\">",$Q16,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q17","口服軟便錠;口服軟便液;軟便塞劑;Digital removal of faeces(DRF);不需要排便輔助;Other(s):<input type=\"text\" name=\"Q17a\" id=\"Q17a\" value=\"".$Q17a."\" size=\"15\">",$Q17,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q18","膀胱訓練;如廁訓練;無排泄訓練;Other(s):<input type=\"text\" name=\"Q18a\" id=\"Q18a\" value=\"".$Q18a."\" size=\"15\">",$Q18,"multi"); ?></td>

  </tr>
  <tr height="30">
    <td class="title_s">D.口腔</td>
    <td valign="top"><?php echo draw_checkbox("Q19","真牙;假牙",$Q19,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q20","固定假牙;活動假牙",$Q20,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q21","上排假牙;下排假牙;全口;無假牙",$Q21,"multi"); ?></td>

    <td valign="top"><?php echo draw_checkbox("Q22","自行清潔;需協助清潔;需協助假牙+浸泡;Other(s):<input type=\"text\" name=\"Q22a\" id=\"Q22a\" value=\"".$Q22a."\" size=\"15\">",$Q22,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q23","需假牙黏著劑;需牙刷尖;需假牙黏著劑+漱口水;需漱口水+牙刷尖;Need not;Other(s):<input type=\"text\" name=\"Q23a\" id=\"Q23a\" value=\"".$Q23a."\" size=\"15\">",$Q23,"multi"); ?></td>

  </tr>
  <tr height="30">
    <td class="title_s">E.Mobile</td>
    <td valign="top"><?php echo draw_checkbox("Q24","可自理;半自理;需協助",$Q24,"multi"); ?></td>

    <td valign="top"><?php echo draw_checkbox("Q25","Canes;Walker;Basic wheelchair;Highbacked wheelchair;Canes+Basic wheelchair;Canes+Highbacked wheelchair;Walker+Basic wheelchair;Walker+Highbacked wheelchair;無移位輔助器",$Q25,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q26","不需約束;輪椅約束;床上約束;手部約束;床上+輪椅約束;床上+手部+輪椅約束;網球拍約束;Other(s):<input type=\"text\" name=\"Q26a\" id=\"Q26a\" value=\"".$Q26a."\" size=\"15\">",$Q26,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q27","腰夾;背架;輕型固定架;八字固定架;腰背固定架;無軀幹輔助物;Other(s):<input type=\"text\" name=\"Q27a\" id=\"Q27a\" value=\"".$Q27a."\" size=\"15\">",$Q27,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q28","需固定煞車;需兩人一起執行;需注意傷口;需注意身上留置管;需注意患側肢體;需注意手術傷口;Need not;Other(s):<input type=\"text\" name=\"Q28a\" id=\"Q28a\" value=\"".$Q28a."\" size=\"15\">",$Q28,"multi"); ?></td>
  </tr>
  <tr height="30">
    <td class="title_s">F.Medication</td>

    <td valign="top"><?php echo draw_checkbox("Q29","一天一次;7點-17點;7點-11點-17點;7點-11點-17點-21點;6點-10點-14點-18點-22點;None;Other(s):<input type=\"text\" name=\"Q29a\" id=\"Q29a\" value=\"".$Q29a."\" size=\"15\">",$Q29,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q30","飯前藥;飯前藥+飯後藥;飯前藥+飯後藥+睡前藥;睡前藥;None;Other(s):<input type=\"text\" name=\"Q30a\" id=\"Q30a\" value=\"".$Q30a."\" size=\"15\">",$Q30,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q31","錠劑;Powdery;泡劑;舌下含錠;皮下針劑;肌肉針劑;Other(s):<input type=\"text\" name=\"Q31a\" id=\"Q31a\" value=\"".$Q31a."\" size=\"15\">",$Q31,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q32","眼藥;口服藥;皮膚藥膏;耳藥;止痛管制貼布;None;Other(s):<input type=\"text\" name=\"Q32a\" id=\"Q32a\" value=\"".$Q32a."\" size=\"15\">",$Q32,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q33","肛門塞劑;陰道塞劑;洗劑;痠痛貼布;外用浸泡劑;None;Other(s):<input type=\"text\" name=\"Q33a\" id=\"Q33a\" value=\"".$Q33a."\" size=\"15\">",$Q33,"multi"); ?></td>
  </tr>
  <tr height="30">
    <td class="title_s">G.認知情緒</td>
    <td valign="top"><?php echo draw_checkbox("Q34","Literate;Illiterate",$Q34,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q35","口語表達;失語;手語",$Q35,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q36","Clear;Orderless;Delirium;被害妄想;智能不足;Other(s):<input type=\"text\" name=\"Q36a\" id=\"Q36a\" value=\"".$Q36a."\" size=\"15\">",$Q36,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q37","對話能理解;人時地清楚;人、時清楚，地不清楚;人清楚，時、地不清楚;短暫清楚;人時地都不清楚;Other(s):<input type=\"text\" name=\"Q37a\" id=\"Q37a\" value=\"".$Q37a."\" size=\"15\">",$Q37,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q38","Emotion stabilized;情緒不穩定;輕度暴力;中度暴力;重度暴力;Other(s):<input type=\"text\" name=\"Q38a\" id=\"Q38a\" value=\"".$Q38a."\" size=\"15\">",$Q38,"multi"); ?></td>

  </tr>
  <tr height="30">
    <td class="title_s">H.Physical condition</td>
    <td valign="top"><?php echo draw_checkbox("Q39","肢體活動自如;上肢癱瘓;下肢癱瘓;左側癱瘓;右側癱瘓;全癱瘓;無力",$Q39,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q40","網拍約束;腹部約束;網拍+腹部約束;網拍+Abdomen+腳部約束;無約束;Other(s):<input type=\"text\" name=\"Q40a\" id=\"Q40a\" value=\"".$Q40a."\" size=\"15\">",$Q40,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q41","心臟節律器;V-P SHUNT;A-V SHUNT;人工血管;None;Other(s):<input type=\"text\" name=\"Q41a\" id=\"Q41a\" value=\"".$Q41a."\" size=\"15\">",$Q41,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q42","禁左手治療;禁右手治療;禁左腳治療;禁右腳治療;左側肢體禁治療;右側肢體禁治療;無肢體禁治療;Other(s):<input type=\"text\" name=\"Q42a\" id=\"Q42a\" value=\"".$Q42a."\" size=\"15\">",$Q42,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q43","左腳水腫;右腳水腫;左手水腫;右手水腫;左側水腫;右側水腫;None;Other(s):<input type=\"text\" name=\"Q43a\" id=\"Q43a\" value=\"".$Q43a."\" size=\"15\">",$Q43,"multi"); ?></td>

  </tr>
  <tr height="30">

    <td class="title_s">Notes(一)</td>
    <td valign="top"><?php echo draw_checkbox("Q44","睡眠6-8小時/Day(s);睡眠4-6小時/Day(s);睡眠1-2小時/Day(s);整天都沒睡;None;Other(s):<input type=\"text\" name=\"Q44a\" id=\"Q44a\" value=\"".$Q44a."\" size=\"15\">",$Q44,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q45","行走穩定;行走不穩易跌倒;無法行走;Other(s):<input type=\"text\" name=\"Q45a\" id=\"Q45a\" value=\"".$Q45a."\" size=\"15\">",$Q45,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q46","確實注意排便;每3-4小時注意小便量;注意排便+每3-4小時注意小便量;None;Other(s):<input type=\"text\" name=\"Q46a\" id=\"Q46a\" value=\"".$Q46a."\" size=\"15\">",$Q46,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q47","褥瘡;一般傷口;Wound+Drainage tube;糜爛傷口;清瘡傷口;Other(s):<input type=\"text\" name=\"Q47a\" id=\"Q47a\" value=\"".$Q47a."\" size=\"15\">",$Q47,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q48","需注意冒冷汗;需觀察意識及冒冷汗;None;Other(s):<input type=\"text\" name=\"Q48a\" id=\"Q48a\" value=\"".$Q48a."\" size=\"15\">",$Q48,"multi"); ?></td>
  </tr>
  <tr height="30">
    <td class="title_s">Notes(二)</td>
    <td valign="top"><?php echo draw_checkbox("Q49","需注意血壓+Blood glucose;需注意T.P.R.BP;需注意T.P.R.BP+呼吸狀況;需注意T.P.R.BP.BS+呼吸狀況;None;Other(s):<input type=\"text\" name=\"Q49a\" id=\"Q49a\" value=\"".$Q49a."\" size=\"15\">",$Q49,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q50","需協助上廁所;每2小時更換尿布;可自己上廁所;Other(s):<input type=\"text\" name=\"Q50a\" id=\"Q50a\" value=\"".$Q50a."\" size=\"15\">",$Q50,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q51","多注意下床及跌倒傾向;Other(s):<input type=\"text\" name=\"Q51a\" id=\"Q51a\" value=\"".$Q51a."\" size=\"15\">",$Q51,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q52","須觀察約束部位;不需約束;Other(s):<input type=\"text\" name=\"Q52a\" id=\"Q52a\" value=\"".$Q52a."\" size=\"15\">",$Q52,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q53","每天下午給自備水果;早晚飯後給自備水果;住民需要時給水果;無交待",$Q53,"multi"); ?></td>
  </tr>
  <tr height="30">
    <td class="title_s">Notes(三)</td>
    <td valign="top"><?php echo draw_checkbox("Q54","需常觀察褲子乾淨度;需常看褲子乾淨度及異味;None",$Q54,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q55","需常抹乳液;需常抹乳液+凡士林;Need not",$Q55,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q56","需經常提醒喝水一天至少2000-3000cc;需限水在500cc以下;不需特別要求;Other(s):<input type=\"text\" name=\"Q56a\" id=\"Q56a\" value=\"".$Q56a."\" size=\"15\">",$Q56,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q57","需陪診;需代拿藥;需陪診+代拿藥;Need not;Other(s):<input type=\"text\" name=\"Q57a\" id=\"Q57a\" value=\"".$Q57a."\" size=\"15\">",$Q57,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q58","喜愛唱歌看電影;喜愛看電影;喜愛唱歌;參與活動較被動;None;Other(s):<input type=\"text\" name=\"Q58a\" id=\"Q58a\" value=\"".$Q58a."\" size=\"15\">",$Q58,"multi"); ?></td>
  </tr>
  <tr height="30">
    <td class="title_s">Notes(四)</td>
    <td valign="top"><?php echo draw_checkbox("Q59","需注意容易嗆咳;需注意容易哽噎;需注意易嗆咳及哽噎;無嗆咳",$Q59,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q60","需飯1/2碗+青菜1.5份;需飯1碗+青菜2份;需飯1碗+青菜1份",$Q60,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q61","晚上多備一份餐;Need not;Other(s):<input type=\"text\" name=\"Q61a\" id=\"Q61a\" value=\"".$Q61a."\" size=\"15\">",$Q61,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q62","早餐吃稀飯;早餐吃乾飯;都可以;Other(s):<input type=\"text\" name=\"Q62a\" id=\"Q62a\" value=\"".$Q62a."\" size=\"15\">",$Q62,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q63","需多關心問候;需多詢問飯菜夠不夠;Need not;Other(s):<input type=\"text\" name=\"Q63a\" id=\"Q63a\" value=\"".$Q63a."\" size=\"15\">",$Q63,"multi"); ?></td>
  </tr>
</table>
<table>
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center>
  <div style="margin:20px 0 10px 0">
    <input type="hidden" name="formID" id="formID" value="careform12" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><input type="hidden" name="nID" id="nID" value="<?php echo $_GET['nID']; ?>" /><input type="hidden" name="action" id="action" value="<?php echo $_GET['action']; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
  </div>
</center>
</form>
</div>
