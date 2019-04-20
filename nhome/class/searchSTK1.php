<?php
//include("DB3.php");
include("DB.php");

$KIND1 = $_POST['STK_KIND1'];
$KIND2 = $_POST['STK_KIND2'];
$KIND3 = $_POST['STK_KIND3'];
//if ($_POST['STK_KIND3']!='') {
	//$KIND3 = str_pad($_POST['STK_KIND3'],2,'0',STR_PAD_LEFT);
//}

$where = " WHERE `STOP_ID`='N' AND ";
if ($KIND1!='') { $where .= "`STK_KIND1`='".$KIND1."' AND "; }
if ($KIND2!='') { $where .= "`STK_KIND2` LIKE '%".$KIND2."%' AND "; }
if ($KIND3!='') { $where .= "`STK_KIND3` LIKE '%".$KIND3."%' AND "; }

$where = substr($where,0,strlen($where)-5);

$sql = "SELECT * FROM `arkstock` ".$where." ORDER BY `STK_NO` ASC, `STK_NAME` ASC";

//if ($r['STK_SPK']!='') { $STK_SPK = iconv('big5','utf-8',$r['STK_SPK']); } else { $STK_SPK = ' '; }
//if ($r['STK_MODEL']!='') { $STK_MODEL = iconv('big5','utf-8',$r['STK_MODEL']); } else { $STK_MODEL = ' '; }

if ($r['STK_SPK']!='') { $STK_SPK = $r['STK_SPK']; } else { $STK_SPK = ' '; }
if ($r['STK_MODEL']!='') { $STK_MODEL = $r['STK_MODEL']; } else { $STK_MODEL = ' '; }

//$db = new DB3;
$db = new DB;
$db->query($sql);
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	//$result .= iconv('big5','utf-8',$r['STK_NO']).'||'.iconv('big5','utf-8',$r['STK_NAME']).'||'.$STK_SPK.'||'.$STK_MODEL.'||'.iconv('big5','utf-8',$r['STK_UNIT']).';';
	$result .= $r['STK_NO'].'||'.$r['STK_NAME'].'||'.$STK_SPK.'||'.$STK_MODEL.'||'.$r['STK_UNIT'].';';
}

echo $result;
?>