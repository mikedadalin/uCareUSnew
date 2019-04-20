<?php
if (@$_GET['date']=="--Select month--" || @$_GET['date']=="") {
	$qdate = date(Y);
} else {
	$qdate = $_GET['date'];//substr(@$_GET['date'],0,4).'-'.substr(@$_GET['date'],4,2);
}
?>
<center><h3><?php echo $qdate; ?> year annual property transaction</h3></center>
<table width="909" class="drawformborder" cellpadding="0" cellspacing="0" style="font-size:12pt;">
	<tr>
    	<td rowspan="2">Transaction date</td>
        <td rowspan="2">Property No.</td>
        <td rowspan="2">Property name</td>
        <td rowspan="2">Brand and model</td>
        <td colspan="2">Original unit</td>
        <td colspan="2">New unit</td>
        <td rowspan="2">Transaction reason</td>
    </tr>
    <tr>
    	<td>Original unit</td>
    	<td>Handled by staff</td>
    	<td>New unit</td>
    	<td>Handled by staff</td>
    </tr>
    <?php
	$sql = "SELECT * FROM `alldetail` a INNER JOIN `property` b ON a.parentID = b.propertyID WHERE a.parentName='property' AND year(a.`cDate`)='".$qdate."' ";
	$db1 = new DB;
	$db1->query($sql);
	for ($i1=0;$i1<$db1->num_rows();$i1++) {
		$r1 = $db1->fetch_assoc();
		echo '
	<tr>
		<td>'.date('Y-m-d', strtotime($r1['cDate'])).'</td>
		<td>'.$r1['p_no'].'</td>
		<td>'.$r1['p_name'].'</td>
		<td>'.$r1['p_spk'].' '.$r1['p_model'].'</td>
		<td>'.$r1['title'].'</td>
		<td>'.$r1['content1'].'</td>
		<td>'.$r1['content2'].'</td>
		<td>'.$r1['content3'].'</td>
		<td>'.$r1['content4'].'</td>
	</tr>	
		';
	}
	?>
</table>
<div style="width:200px; display:inline-block;">Administrator:</div>
<div style="width:200px; display:inline-block;">Vice administrator:</div>
<div style="width:200px; display:inline-block;">Supervisor:</div>
<div style="width:200px; display:inline-block;">Undertakes personnel:</div>