<?php
$arrStatus = array("Handling", "Ready to ship", "Shipped", "Cancel");
?>
<h3>Supplies ordering</h3>
<p align="right"><form align="right"><input type="button" onclick="window.location.href='index.php?mod=consump&func=formview&id=7a'" value="New order" /></form></p>
<table width="100%" cellpadding="10">
  <tr class="title">
    <td>Order Number</td>
    <td>Order Date</td>
    <td>Product Serial Number</td>
    <td>Item</td>
    <td>Quantity</td>
    <td>Amount of Fee</td>
    <td>Ordering Staff</td>
    <td>Shippment Status</td>
    <td>Process Dates</td>
    <td>Process by Staff</td>
  </tr>
<?php
$db1 = new DB2;
$db1->query("SELECT * FROM `itemorder` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."' ORDER BY `OrderNo` DESC");
for ($i=0;$i<$db1->num_rows();$i++) {
	$r1 = $db1->fetch_assoc();
	echo '
  <tr align="center">
    <td>'.$r1['OrderNo'].'</td>
    <td>'.$r1['OrderDate'].'</td>
    <td>'.$r1['ItemNo'].'</td>
    <td>'.$r1['ItemName'].'</td>
    <td>'.$r1['ItemQty'].'</td>
    <td>'.$r1['ItemTotal'].'</td>
    <td>'.checkusername($r1['OrderFiller']).'</td>
    <td>'.$arrStatus[$r1['SendStatus']].'</td>
    <td>'.$r1['SendDate'].'</td>
    <td>'.checkusername($r1['SendFiller']).'</td>	
  </tr>
	'."\n";
}
?>
</table>