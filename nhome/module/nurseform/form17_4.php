<h3>藥物諮詢評估表</h3>
<table width="100%">
  <tr class="title">
    <td><p>諮詢日期</p></td>
    <td><p>Medication</p></td>
    <td><p>問題</p></td>
    <td><p>Filled by</p></td>
    <td><p>回覆諮詢</p></td>
  </tr>
<?php
$db = new DB;
$db->query("SELECT * FROM `medicineq` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	echo '
  <tr>
    <td align="center">'.$r['date'].'</td>
	<td align="center">'.$r['Qmedicine'].'</td>
	<td align="center"><a href="javascript:void(0);">'.$r['question'].'</a></td>
    <td align="center">'.checkusername($r['Qfiller']).'</td>
    <td align="center"><form><input type="button" value="回覆" onclick="window.location.href=\'index.php?mod=nurseform&func=formview&id=17_4a&pid='.@$_GET['pid'].'&qID='.$r['qID'].'\'" /></form></td>
  </tr>
	'."\n";
	
	$db1 = new DB;
	$db1->query("SELECT * FROM `medicinea` WHERE `qID`='".$r['qID']."' ORDER BY `date` DESC");
	if ($db1->num_rows()>0) {
		echo '
		<tr>
		  <td colspan="6" align="right">
		    <table style="width:850px;">
			<tr style="height:14px;">
			  <td width="100" style="background:#21689F; color:#fff; border:2px solid #21689F; padding:4px;">Reply date</td>
			  <td width="750" style="background:#21689F; color:#fff; border:2px solid #21689F; padding:4px;">Advice</td>
			</tr>'."\n";
		for ($i1=0;$i1<$db1->num_rows();$i1++) {
			$r1 = $db1->fetch_assoc();
			foreach ($r1 as $k=>$v) {
				$arrPatientInfo = explode("_",$k);
				if (count($arrPatientInfo)==2) {
					if ($v==1) {
						${$arrPatientInfo[0]} .= $arrPatientInfo[1].';';
					}
				} else {
					${$k} = $v;
				}
			}
			echo '
			<tr style="height:14px;">
			  <td width="100" style="background:#fff; border:2px solid; padding:4px;">'.$date.'</td>
			  <td width="750" style="background:#fff; border:2px solid; padding:4px;">Advice:'.checkbox_result("Q1","會診醫師更改藥物劑量或頻次：".$Q1a.";會診醫師更改藥物或劑型：".$Q1b.";會診醫師停藥或改其他藥：".$Q1c.";進行藥物血中濃度監測：".$Q1d.";繼續維持目前用藥情形;住民服藥應注意事項：".$Q1e." ",$Q1,"multi").'<br><br>References:'.checkbox_result("Q2","仿單;藥品手冊;參考書籍(或文獻)：",$Q2,"multi").$answer.'</td>
			</tr>
			'."\n";
			$Q1="";
			$Q2="";
			$Q1a="";
			$Q1b="";
			$Q1c="";
			$Q1d="";
			$Q1e="";
		}
		echo '
			</table>
		  </td>
		</tr>'."\n";

	}
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				${$arrPatientInfo[0]} = "";
			}
		} else {
			${$k} = "";
		}
	}
}
?>
</table>