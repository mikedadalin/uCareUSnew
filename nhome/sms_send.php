<script>
function TextArea1WordCount() {
	//文字輸入//取得計算字數的物件塊
	TextArea1 = document.getElementById("sMessage");
	//取得計算字數的物件 
	lblWordCountNow = document.getElementById("lblWordCountNow");
	//將文字輸入方塊表度寫入顯示Label
	lblWordCountNow.innerHTML = TextArea1.value.length;
	if (TextArea1.value.length>=70 && TextArea1.value.length<335 ) {
		lblWordCountNow.className = "rangeL";
	} else if (TextArea1.value.length>=335) {
		lblWordCountNow.className = "rangeH";
	} else {
		lblWordCountNow.className = "";
	}
	//250毫秒後再執行一次此function
	setTimeout("TextArea1WordCount()", 250);
}
$(document).ready(function() {
	TextArea1WordCount();
})
</script>

<?
if( strlen(trim($_REQUEST["sUserName"]))>0 && strlen(trim($_REQUEST["sPassword"]))>0 && strlen(trim($_REQUEST["sTelNo"]))>0 && strlen(trim($_REQUEST["sMessage"]))>0 ){
	$msg="username=uarktech&password=uark6524&dstaddr=".$_REQUEST["sTelNo"]."&smbody=".urlencode(iconv('utf-8','big5',$_REQUEST["sMessage"]));
	$host="202.39.48.216";
	$to_url="http://".$host."/kotsmsapi-1.php?".$msg;
	
	if (!$getfile=file($to_url)){
		echo "<br><br><br><br><center>ERROR:無法連接</center>";
		exit;
	}
	$term_tmp = implode ('', $getfile);
	$term=$term_tmp;
	
	//將紀錄寫入DB
	$db2 = new DB2;
	$db2->query("INSERT INTO `sms_record` (`date`, `receiver`, `content`, `OrgID`, `Qfiller`) VALUES ('".date("Y-m-d H:i:s")."', '".$_REQUEST["sTelNo"]."', '".$_REQUEST["sMessage"]."', '".$_SESSION['nOrgID_lwj']."', '".$_SESSION['ncareID_lwj']."')");
	
	echo "<script>alert('已經成功發放簡訊');</script>";
}
if ($_REQUEST["sTelNo"]=="") {
	$tel = $_REQUEST["tel"];
} else {
	$tel = $_REQUEST["sTelNo"];
}
if (substr($tel,0,3)=='886') {
	$tel = '0'.substr($tel,3,9);
}
?>
<form id="form1" name="form1" method="post" action="index.php?func=sms_send&tel=<?php echo $tel; ?>">
<table width="800" border="1" align="center"  cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
  <tr>
    <td colspan="2" bgcolor="#0099CC"><h3>發送新簡訊</h3></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" width="160">接收門號</td>
    <td><input name="sUserName" type="hidden" id="sUserName" value="sssss" readonly="readonly" /><input name="sPassword" type="hidden" id="sPassword" value="dddddd" readonly="readonly" /><input type="text" name="sTelNo" id="sTelNo" value="<?php echo $tel  ?>" readonly /></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC">簡訊內容</td>
    <td><textarea name="sMessage" rows="5" cols="50" id="sMessage"></textarea><br />目前字數：<span id="lblWordCountNow">0</span>字<br /><font color="#999999" size="2">最多為70~335個中英文混合字元。(若超過70字將以長簡訊計算)<br />一般簡訊：新台幣1.5元<br />長簡訊：新台幣2.5元</font></td>
  </tr>
  <!--<tr>
    <td bgcolor="#CCCCCC">剩餘點數</td>
    <td>
    <?php
	/*$check_point_url = "http://mail2sms.com.tw/memberpoint.php?username=uarktech&password=uark6524";
	if (!$getpointfile=file($check_point_url)){
		echo "<br><br><br><br><center>ERROR:無法連接</center>";
		exit;
	}
	$point_tmp = implode ('', $getpointfile);
	$points=$point_tmp;
	echo ($points<=10?'<font color="#f00">':"").$points.($points<=10?'</font>':"");*/
	?>
    </td>
  </tr>-->
  <tr>
    <td colspan="2" align="center"><input type="button" name="button" id="button" value="送出" onclick="document.form1.submit();this.disabled=true"  /><input type="submit" name="button" value="send" style="display:none"></td>
    </tr>
</table>
</form>
<br />
<table width="800" border="1" align="center" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
  <tr>
    <td colspan="2" bgcolor="#0099CC"><h3>發送紀錄</h3></td>
  </tr>
  <tr>
    <td width="160" bgcolor="#CCCCCC">Date and time</td>
    <td bgcolor="#CCCCCC">Contents</td>
  </tr>
  <?php
  $db1 = new DB2;
  $db1->query("SELECT * FROM `sms_record` WHERE `receiver`='".$tel."' ORDER BY `date` DESC");
  for ($i1=0;$i1<$db1->num_rows();$i1++) {
	  $r1 = $db1->fetch_assoc();
	  echo '
  <tr>
    <td valign="top">'.$r1['date'].'</td>
    <td valign="top">'.$r1['content'].'</td>
  </tr>
	  '."\n";
  }
  ?>
</table>
</body>
</html>
