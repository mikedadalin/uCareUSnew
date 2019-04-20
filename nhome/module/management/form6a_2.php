<h3>Administrative meeting record</h3>
<?php
if (@$_GET['action']=='save') {
	$date = str_replace("/","",$_POST['date']);
	$time = $_POST['time'];
	$Qcate = $_POST['Qcate'];
	$Q1 = $_POST['Q1'];
	$Q2 = $_POST['Q2'];
	//$Qcontent = str_replace("\n","<br>",$_POST['Qcontent']);
	$Qcontent = $_POST['Qcontent'];
	$db = new DB;
	$db->query("UPDATE `nurseform06a` SET `Qcate`='".$Qcate."', `Q1`='".$Q1."', `Q2`='".$Q2."', `Qcontent`='".$Qcontent."' WHERE `date`='".$date."' AND `time`='".$time."'");
	echo '<script>window.location.href="index.php?mod=management&func=formview&id=6a"</script>';
}
$db = new DB;
$db->query("SELECT * FROM `nurseform06a` WHERE `date`='".mysql_escape_string($_GET['date'])."' AND `time`='".mysql_escape_string($_GET['time'])."'");
$r = $db->fetch_assoc();
?>
<form action="index.php?mod=management&func=formview&id=6a_2&action=save" method="post">
  <table style="width:100%; text-align:left;">
    <tr>
      <td class="title" width="120">Date/Time</td>
      <td><input type="hidden" name="date" id="date" value="<?php echo @$_GET['date']; ?>"><input type="hidden" name="time" id="time" value="<?php echo @$_GET['time']; ?>"><?php echo formatdate(@$_GET['date']).' '.substr(@$_GET['time'],0,2).':'.substr(@$_GET['time'],2,2); ?></td>
    </tr>
    <tr>
      <td class="title">Category</td>
      <td><select name="Qcate" id="Qcate">
        <option></option>
        <?php
        $db3 = new DB;
        $db3->query("SELECT * FROM `nurseform06a_cate` ORDER BY `order` ASC");
        $arrForm6aCate = array("0"=>"Not categorized");
        for ($i=0;$i<$db3->num_rows();$i++) {
          $r3 = $db3->fetch_assoc();
          $arrForm6aCate[$r3['ID']] = $r3['name'];
          echo '<option value="'.$r3['ID'].'" '.($r3['ID']==$r['Qcate']?"selected":"").'>'.$r3['name'].'</option>';
        }
        ?>
      </select></td>
    </tr>
    <tr>
      <td class="title">Attendee</td>
      <td><input type="text" name="Q1" id="Q1" value="<?php echo $r['Q1']; ?>" size="80"></td>
    </tr>
    <tr>
      <td class="title" style="padding:5px 10px;">Conference Theme</td>
      <td><input type="text" name="Q2" id="Q2" value="<?php echo $r['Q2']; ?>" size="80"></td>
    </tr>
    <tr>
      <td class="title" style="padding:5px 10px;">Meeting Minutes</td>
      <td>
        <textarea name="Qcontent" id="Qcontent" cols="80" rows="20"><?php echo $r['Qcontent']; ?></textarea>
        <script>
        CKEDITOR.replace('Qcontent');
        </script>
      </td>
    </tr>
  </table>
  <div style="margin-top:30px; text-align:center">
    <input type="submit" name="save" id="save" value="Save">
  </div>
</form>