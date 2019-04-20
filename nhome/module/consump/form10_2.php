<h3>Items Requisitions</h3>
<div align="left">
<form>
<input type="button" value="Back to list" onclick="window.location.href='index.php?mod=consump&func=formview&id=10&aID=<?php echo @$_GET['aID']; ?>'">
</form>
</div>
<form  method="post">
<table width="100%" id="newformtable">
  <tr class="title">
    <td>ID #</td>
    <td>Name</td>
    <td>Quantity</td>
    <td>Unit</td>
  </tr>
  <?php
  $db3 = new DB;
  $db3->query("SELECT * FROM `arkord` WHERE `ORD_SEQ`='".mysql_escape_string($_GET['ORDSEQ'])."' ORDER BY `ORD_SEQ1` ASC");
  for ($i=0;$i<$db3->num_rows();$i++) {
	  $r3 = $db3->fetch_assoc();
	  echo '
	  <tr>
		<td>'.$r3['STK_NO'].'</td>
        <td>'.$r3['STK_NAME'].'</td>
		<td>'.$r3['ORD_QTY'].'</td>
		<td>'.$r3['STK_UNIT'].'</td>
	  </tr>
	  '."\n";
  }
  ?>
  <tbody>
  </tbody>
</table>