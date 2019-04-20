<?php
if (isset($_POST['saveNurseplan'])) {
	foreach ($_POST as $k=>$v) {
		$arrData = explode("_",$k);
		//[0]=nurseform02c [1]Q1 [2]2
		$formID = $arrData[0];
		$formQ = $arrData[1].'_'.$arrData[2];
		$db1 = new DB;
		$db1->query("SELECT * FROM `nursecareplan` WHERE `formID`='".$formID."' AND `formQ`='".$formQ."'");
		if ($db1->num_rows()==0) {
			$sql = "INSERT INTO `nursecareplan` VALUES ('".$formID."', '".$formQ."', '".$v."');";
		} else {
			$sql = "UPDATE `nursecareplan` SET `pText`='".$v."' WHERE `formID`='".$formID."' AND `formQ`='".$formQ."'";
		}
		$db1a = new DB;
		$db1a->query($sql);
	}
}
$db1 = new DB;
$db1->query("SELECT * FROM `nursecareplan`");
for ($i=0;$i<$db1->num_rows();$i++) {
	$r1 = $db1->fetch_assoc();
	${$r1['formID'].'_'.$r1['formQ']} = $r1['pText'];
}
?>
<h3>護理計畫片語設定</h3>
<form method="POST">
<table width="100%">
  <tr>
    <td colspan="3" class="title">Barthel Index (ADL assessment)</td>
  </tr>
  <tr>
    <td rowspan="3" class="title">Self-feeding</td>
    <td class="title_s">Independent ( able to wear on/off if aids is needed).</td>
    <td><input type="text" name="nurseform02c_Q1_1" value="<?php echo $nurseform02c_Q1_1; ?>" size="50"></td>
  </tr>
  <tr>
    <td class="title_s">Needs help cutting, spreading butter, etc., or requires modified diet</td>
    <td><input type="text" name="nurseform02c_Q1_2" value="<?php echo $nurseform02c_Q1_2; ?>" size="50"></td>
  </tr>
  <tr>
    <td class="title_s">Unable (entirely depend on assistant to be fed). </td>
    <td><input type="text" name="nurseform02c_Q1_3" value="<?php echo $nurseform02c_Q1_3; ?>" size="50"></td>
  </tr>
  <tr>
    <td rowspan="4" class="title">輪椅與床位間的移位</td>
    <td class="title_s">Independent (but may use any aid. for example, stick)</td>
    <td><input type="text" name="nurseform02c_Q2_1" value="<?php echo $nurseform02c_Q2_1; ?>" size="50"></td>
  </tr>
  <tr>
    <td class="title_s">Walks with help of one person (verbal or physical) </td>
    <td><input type="text" name="nurseform02c_Q2_2" value="<?php echo $nurseform02c_Q2_2; ?>" size="50"></td>
  </tr>
  <tr>
    <td class="title_s">Wheelchair independent, including corners</td>
    <td><input type="text" name="nurseform02c_Q2_3" value="<?php echo $nurseform02c_Q2_3; ?>" size="50"></td>
  </tr>
  <tr>
    <td class="title_s">Immobile or < 50 yards (Fully depend on assistant)</td>
    <td><input type="text" name="nurseform02c_Q2_4" value="<?php echo $nurseform02c_Q2_4; ?>" size="50"></td>
  </tr>
  <tr>
    <td rowspan="2" class="title">Personal hygiene</td>
    <td class="title_s">可獨立自行完成洗手、洗臉、刷牙、梳頭髮、刮鬍子。</td>
    <td><input type="text" name="nurseform02c_Q3_1" value="<?php echo $nurseform02c_Q3_1; ?>" size="50"></td>
  </tr>
  <tr>
    <td class="title_s">需旁人部分或完成協助。</td>
    <td><input type="text" name="nurseform02c_Q3_2" value="<?php echo $nurseform02c_Q3_2; ?>" size="50"></td>
  </tr>
  <tr>
    <td rowspan="3" class="title">Toileting</td>
    <td class="title_s">Independent (on and off, dressing, wiping)</td>
    <td><input type="text" name="nurseform02c_Q4_1" value="<?php echo $nurseform02c_Q4_1; ?>" size="50"></td>
  </tr>
  <tr>
    <td class="title_s">Needs some help, but can do something alone</td>
    <td><input type="text" name="nurseform02c_Q4_2" value="<?php echo $nurseform02c_Q4_2; ?>" size="50"></td>
  </tr>
  <tr>
    <td class="title_s">Dependent (Need help).</td>
    <td><input type="text" name="nurseform02c_Q4_3" value="<?php echo $nurseform02c_Q4_3; ?>" size="50"></td>
  </tr>
  <tr>
    <td rowspan="2" class="title">Bathing</td>
    <td class="title_s">Independent (bath/ sponge bath or in shower).</td>
    <td><input type="text" name="nurseform02c_Q5_1" value="<?php echo $nurseform02c_Q5_1; ?>" size="50"></td>
  </tr>
  <tr>
    <td class="title_s">Dependent (Need help).</td>
    <td><input type="text" name="nurseform02c_Q5_2" value="<?php echo $nurseform02c_Q5_2; ?>" size="50"></td>
  </tr>
  <tr>
    <td rowspan="4" class="title">平地上行走</td>
    <td class="title_s">可自行行走約45公尺以上，包括使用輔具。</td>
    <td><input type="text" name="nurseform02c_Q6_1" value="<?php echo $nurseform02c_Q6_1; ?>" size="50"></td>
  </tr>
  <tr>
    <td class="title_s">需稍微協助或提醒，可行走約45公尺以上。</td>
    <td><input type="text" name="nurseform02c_Q6_2" value="<?php echo $nurseform02c_Q6_2; ?>" size="50"></td>
  </tr>
  <tr>
    <td class="title_s">不能行走，但可獨立操控輪椅 (轉彎、進出等)</td>
    <td><input type="text" name="nurseform02c_Q6_3" value="<?php echo $nurseform02c_Q6_3; ?>" size="50"></td>
  </tr>
  <tr>
    <td class="title_s">需旁人協助推輪椅。</td>
    <td><input type="text" name="nurseform02c_Q6_4" value="<?php echo $nurseform02c_Q6_4; ?>" size="50"></td>
  </tr>
  <tr>
    <td rowspan="3" class="title">Climbing stairs</td>
    <td class="title_s">能自行（或使用扶手、拐杖)上下樓梯。</td>
    <td><input type="text" name="nurseform02c_Q7_1" value="<?php echo $nurseform02c_Q7_1; ?>" size="50"></td>
  </tr>
  <tr>
    <td class="title_s">在旁人協助或提醒下能上下樓梯。</td>
    <td><input type="text" name="nurseform02c_Q7_2" value="<?php echo $nurseform02c_Q7_2; ?>" size="50"></td>
  </tr>
  <tr>
    <td class="title_s">無法上下樓梯。</td>
    <td><input type="text" name="nurseform02c_Q7_3" value="<?php echo $nurseform02c_Q7_3; ?>" size="50"></td>
  </tr>
  <tr>
    <td rowspan="3" class="title">穿脫衣服</td>
    <td class="title_s">Independent (including buttons, zips, laces, etc.)</td>
    <td><input type="text" name="nurseform02c_Q8_1" value="<?php echo $nurseform02c_Q8_1; ?>" size="50"></td>
  </tr>
  <tr>
    <td class="title_s">Needs help but can do about half unaided</td>
    <td><input type="text" name="nurseform02c_Q8_2" value="<?php echo $nurseform02c_Q8_2; ?>" size="50"></td>
  </tr>
  <tr>
    <td class="title_s">Dependent (Need help).</td>
    <td><input type="text" name="nurseform02c_Q8_3" value="<?php echo $nurseform02c_Q8_3; ?>" size="50"></td>
  </tr>
  <tr>
    <td rowspan="3" class="title">Defecate control</td>
    <td class="title_s">能排便不會失禁，或能自行使用塞劑或灌腸。</td>
    <td><input type="text" name="nurseform02c_Q9_1" value="<?php echo $nurseform02c_Q9_1; ?>" size="50"></td>
  </tr>
  <tr>
    <td class="title_s">偶會失禁 (每週&lt;1次)，或需旁人協助用塞劑。</td>
    <td><input type="text" name="nurseform02c_Q9_2" value="<?php echo $nurseform02c_Q9_2; ?>" size="50"></td>
  </tr>
  <tr>
    <td class="title_s">失禁需旁人處理。</td>
    <td><input type="text" name="nurseform02c_Q9_3" value="<?php echo $nurseform02c_Q9_3; ?>" size="50"></td>
  </tr>
  <tr>
    <td rowspan="3" class="title">Urine control</td>
    <td class="title_s">日夜均不會尿失禁，或能自行用尿套、尿袋。</td>
    <td><input type="text" name="nurseform02c_Q10_1" value="<?php echo $nurseform02c_Q10_1; ?>" size="50"></td>
  </tr>
  <tr>
    <td class="title_s">偶會失禁(每週&lt;1次)、尿急 (無法等待放好便盒或及時坐上馬桶)，或需旁人協助使用尿套。</td>
    <td><input type="text" name="nurseform02c_Q10_2" value="<?php echo $nurseform02c_Q10_2; ?>" size="50"></td>
  </tr>
  <tr>
    <td class="title_s">尿失禁需旁人處理。</td>
    <td><input type="text" name="nurseform02c_Q10_3" value="<?php echo $nurseform02c_Q10_3; ?>" size="50"></td>
  </tr>
  <tr>
    <td colspan="3">
    <center><input type="submit" name="saveNurseplan" value="Save"></center>
    </td>
  </tr>
</table>
</form>