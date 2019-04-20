<script type="text/javascript" src="js/share.js"></script>
<h3>Storehouse information</h3><?php

//模組名稱
$strModule = "stockinfo";

if($_POST["act"]=="delete"){
	
	//print_r($_POST);
	$DelCounter=count($_POST['chkLAY_NO']);
	//刪除進貨單
	$DelCount = 0;	
	$DelQry = "DELETE FROM `".$strModule."` WHERE `LAY_NO` in( ";
	  foreach ($_POST['chkLAY_NO'] as $k1=>$v1) {
		  $DelCount++;
		 if ($DelCounter == $DelCount){
			  $DelQry .= $v1;
		 }else{
			 $DelQry .= $v1.', ';		   
		 }  
	  }
	$DelQry .=" )";
	$db->query($DelQry);	
}


?>
<form method="post" action="index.php?<?php echo $_SERVER['QUERY_STRING']; ?>">
<div align="right">
<input type="button" name="btnBack" id="btnBack" value=" Back to list ">
<input type="button" name="btnDel" id="btnDel" value=" Delete ">
<input type="button" name="btnAdd" id="btnAdd" value=" Add storehouse " />
</div>

<div class="content-table">
<table>
<tr class="title">
  <td width="5%">&nbsp;</td>
  <td width="10%">Storehouse ID#</td>
  <td width="*">Vendor's name</td>
  <td width="10%">Function</td>
</tr>
<?php

$db = new DB;
$sql1 = "SELECT * FROM `".$strModule."` WHERE 1=1 order by ".$strModule."ID ";
$db->query($sql1);
if ($db->num_rows()>0) {
//echo $sql1;	
  for ($i=0;$i<$db->num_rows();$i++) {
	  $r = $db->fetch_assoc();
?>
<tr>
  <td align="center">
		<?php print_r("<input type='checkbox' id='chkLAY_NO' name='chkLAY_NO[]' value='".$r['LAY_NO']."'>"); ?>
  </td>
  <td align="center"><?php echo $r['stockinfoID']; ?></td>
  <td><?php echo $r['Title']; ?></td>
  <td>
  	<input type="button" value="Edit" onclick="window.location.href='index.php?mod=consump&func=formview&id=1d&LAY_NO=<?php echo $r['LAY_NO']; ?>'">
</td>
</tr>
<?php }}else{?>
<tr>
  <td align="center" colspan="7">No data yet!!</td>
</tr>

<?php
}
?>
</table>
</div>
<input type="hidden" name="act" id="act" />
</form>

<p>&nbsp;</p>
<script language="javascript">

$(function() {

  $('#btnAdd').click(function() {
	location.href='index.php?mod=consump&func=formview&id=1d';
   });
  $('#btnBack').click(function() {
	location.href='index.php?mod=consump&func=formview&id=9';
   });
  
  $('#btnDel').click(function() {
	if (DelDataCheck(document.forms[0].chkLAY_NO)){
	  $('#act').val('delete');
	  $('form').submit();
	}
  });
});

</script>
	