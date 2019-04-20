<?php
include("DB3.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<table border="1">
  <!--<tr>
    <td>STK_NO</td>
    <td>STK_NAME</td>
    <td>STK_SPK</td>
    <td>STK_MODEL</td>
    <td>STK_UNIT</td>
    <td>IN_PRC</td>
    <td>OUT_PRC</td>
    <td>KIND_NO</td>
    <td>STK_KIND1</td>
    <td>STK_KIND2</td>
    <td>STK_KIND3</td>
    <td>SAFE_QTY</td>
    <td>OUT_DATE</td>
    <td>PRC_ID</td>
    <td>LAY_NO</td>
    <td>STOP_ID</td>
    <td>STK_RMK</td>
    <td>CHG_DATE</td>
    <td>CHG_USER</td>
  </tr>-->
<?
$db = new DB3;
$db->query("SELECT * FROM `arkstock`");
//echo $db->num_rows()."<br>";
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	echo "<tr>\n";
	foreach ($r as $k=>$v) {
		echo '<td>'.iconv('big5','UTF-8',$v)."</td>\n";
	}
	echo "</tr>\n";
}
?>
</body>
</html>