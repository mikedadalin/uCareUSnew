<?php
if ($_GET['EmpID']!="") {
	$EmpID = (int) @$_GET['EmpID'];
} else {
	$EmpID = "";
}
if($_GET['humanID']==''){
	$humanID="";
}else{
	$humanID=(int) @$_GET['humanID'];
}

$db5a = new DB;
$db5a->query("SELECT * FROM `employer` WHERE `EmpID`='".$EmpID."';");
$r5a = $db5a->fetch_assoc();
$Name = $r5a['Name'];
$Position = $r5a['Position'];
$Position2 = $r5a['Position2'];

if (isset($_POST['submit'])) {
	if ($_POST['humanID']==''){
		$db1 = new DB;
		$db1->query("INSERT INTO `humanresource10` (`EmpID`, `title`, `qty`, `content1`, `content2`, `date`, `handover`, `Qfiller`) VALUES ('".mysql_escape_string($_POST['EmpID'])."', '".mysql_escape_string($_POST['title'])."', '".mysql_escape_string($_POST['qty'])."', '".mysql_escape_string($_POST['content1'])."', '".mysql_escape_string($_POST['content3'])."', '".date("Y-m-d")."', '".mysql_escape_string($_POST['handover'])."', '".mysql_escape_string($_POST['Qfiller'])."');");		
	}else{
		$db1->query("UPDATE `humanresource10` SET `title`='".mysql_escape_string($_POST['title'])."',`qty`='".mysql_escape_string($_POST['qty'])."', `content1`='".mysql_escape_string($_POST['content1'])."', `content2`='".mysql_escape_string($_POST['content2'])."', `handover`='".mysql_escape_string($_POST['handover'])."', `Qfiller`='".mysql_escape_string($_POST['Qfiller'])."' WHERE `humanID`='".mysql_escape_string($_POST['humanID'])."';");
		
	}
	echo "<script>history.go(-1);</script>";
}

$sql = "SELECT * FROM `humanresource10` WHERE `EmpID`='".mysql_escape_string($EmpID)."'";
if ($humanID!='') { $sql .= " AND `humanID`='".mysql_escape_string($humanID)."'"; }
$sql .= " ORDER BY `date` DESC LIMIT 0,1";
$db1 = new DB;
$db1->query($sql);
if ($db1->num_rows()>0) {
	$r1 = $db1->fetch_assoc();
	foreach ($r1 as $k=>$v){
		${$k} = $v;
	}
}	
?>
<div class="moduleNoTab">
<h3>Transfer list</h3>
<form  method="post" onSubmit="return checkForm();">
  <table border="0" style="width:100%;">
   <tr>
     <td width="120" class="title">Unit</td>
     <td width="120">&nbsp;</td>
     <td width="120" class="title">Title</td>
     <td width="120"><?php echo $Position;?></td>
     <td width="120" class="title">Full name</td>
     <td width="120"><?php echo $Name;?></td>
   </tr>
 </table>
 <table border="0" style="width:100%;">
  <tr>
    <td class="title_s" width="100">Handover item</td>
    <td colspan="3">
      <textarea name="title"  cols="20" rows="5" id="title"><?php echo $title; ?></textarea>
    </td>
  </tr>
  <tr>
    <td class="title_s" width="100">Quantity of handover</td>
    <td colspan="3">
      <input type="text" name="qty" id="qty" value="<?php echo $qty; ?>">
    </td>
  </tr>
  <tr>
    <td  class="title_s" width="100">Contents</td>
    <td colspan="3">
      <textarea name="content1"  cols="60" rows="5" id="content1"><?php echo $content1; ?></textarea>
    </td>
  </tr>
  <tr>
    <td  class="title_s" width="100">Not yet progressed focus</td>
    <td colspan="3">
      <textarea name="content2" cols="60" rows="5" id="content3"><?php echo $content2; ?></textarea>
    </td>
  </tr>
  <tr>
    <td  class="title_s" width="100">Handover personnel</td>
    <td align="center">
      <select name="handover" id="handover">
        <?php 
        $EmpList = getWorkingStaff(1);
        foreach ($EmpList as $k=>$v) {
          echo '<option value="1_'.$k.'" '.($k==$handover?"selected":"").'>'.$v.'</option>';
        }
        ?>
      </select>
    </td>
    <td class="title_s">Handover supervised by</td>
    <td align="center"><select name="Qfiller" id="Qfiller">
      <?php 
      $EmpList = getWorkingStaff(1);
      foreach ($EmpList as $k=>$v) {
        echo '<option value="1_'.$k.'" '.($k==$Qfiller?"selected":"").'>'.$v.'</option>';
      }
      ?>
    </select></td>
  </tr>
</table>
<center>
  <div style="margin-top:30px;">
    <input type="hidden" name="humanID" id="humanID" value="<?php echo $_GET['humanID']; ?>" />
    <input type="hidden" name="EmpID" id="EmpID" value="<?php echo $_GET['EmpID']; ?>" />
    <input type="button" name="back" onClick="window.location='index.php?mod=humanresource&func=formview&id=10&EmpID=<?php echo $EmpID; ?>'" value="回上頁">
    <input type="submit" id="submit" name="submit" value="Save" />
  </div>
</center>
</form>
<?php ?>
</div>
