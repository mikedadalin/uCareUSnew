<div style="background-color:rgba(255,255,255,0.8); border-radius:24px; padding:40px; padding-top:10px; width:80%">
<?php
//模組名稱
$strModule = "service_cate";
$strModule2 = "service_item";
$firmID = (int) @$_GET['service_cateID'];
$firmID2 = (int) @$_GET['service_itemID'];
if (isset($_POST['submit'])) {
	
	//讀寫資料
		$cate = ($_POST['lbllevel2']==0?$_POST['lbllevel1']:$_POST['lbllevel2']);
		$db = new DB;
		$strQry = "UPDATE `".$strModule2."` SET ";
		$strQry .="title = '".mysql_escape_string($_POST['title'])."',";
		$strQry .="service_cateID= '".$cate."',";
		$strQry .="isHidden_1= '".mysql_escape_string($_POST['isHidden_1'])."',";
		$strQry .="isHidden_2= '".mysql_escape_string($_POST['isHidden_2'])."'";
		$strQry .=" WHERE ".$strModule2."ID=".$firmID2;
		//echo $strQry;
		$db->query($strQry);
		echo "<script>alert('Modify success!');window.location.href='index.php?mod=category&func=formview&id=2&code=".$_GET['code']."&cate2=".$cate."'</script>";

}
$db = new DB;
$db->query("SELECT * FROM `".$strModule2."` WHERE `".$strModule2."ID`='".mysql_escape_string($firmID2)."'");
if ($db->num_rows()>0) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				${$arrPatientInfo[0]} = $arrPatientInfo[1];
			}
		} else {
			${$k} = $v;
		}
	}
}
?>

<form method="post" name="FSform" id="FSform">
<h3>Edit list</h3>
<table width="100%">
  <tr>
  	<td class="title" width="150">Category select</td>
    <td width="200"><div id="1st">1st Hierarchy
    <select name="lbllevel1" id="lbllevel1">
	<?php 
        $LevDB = new DB;
        $LevDB->query("select * from ".$strModule." where parentID=0 and typeCode='".mysql_escape_string($_GET['code'])."' and isHidden_1=1 order by ord");		
		if($LevDB->num_rows() > 0 ){
			echo '<option value="0"> --- </option>';						
			for ($i=0;$i<$LevDB->num_rows();$i++) {
        		$lev = $LevDB->fetch_assoc();
				$Lev1 = new DB;
				$Lev1->query("select * from ".$strModule." where service_cateID='".mysql_escape_string($_GET['service_cateID'])."' ");		
				$lev1 = $Lev1->fetch_assoc();
				echo '<option value='.$lev['service_cateID'].' '.($lev['service_cateID']==$lev1['parentID']?"selected='selected'":"").'>'.$lev['title'].'</option>';					
			}
		}
	
    ?>
	</select>
     </div>
   </td>
    <td><div id="2nd"></div></td>
  </tr>
  <tr>
    <td class="title" width="150">Name</td>
    <td colspan="2">
    <input name="title" type="text" id="title" maxlength="30" size="50" value="<?php echo $title; ?>">
    </td>
  </tr>
  <tr>
    <td class="title" width="150">Display in the form</td>
    <td colspan="2">
    <?php echo draw_option("isHidden","Display;Hide","s","single",$isHidden,false,2); ?>
    </td>
  </tr>  
</table>
<br />
<center>
    <input type="button" id="cmdBack" name="cmdBack" value="Back to list"  />
	<input type="submit" name="submit" id="submit" value="Save" />
</center>
</div>
	<input type="hidden" id="code" name="code" value="<?php echo $_GET['code'];?>">
    <input type="hidden" id="layer" name="layer" value="<?php echo $_GET['layer'];?>">
    <input type="hidden" id="service_cateID" name="service_cateID" value="<?php echo $firmID;?>">
    <input type="hidden" id="servece_itemID" name="servece_itemID" value="<?php echo $firmID2;?>">
</form>

<script language="javascript">
 $(function() {
	 checkL();
	//Back to list
	$('#cmdBack').click(function(){
	  var type ='<?php echo $_GET['code'];?>';	
	  var layer = '<?php echo $_GET['layer']; ?>';
	  	  location.href='index.php?mod=category&func=formview&id=2&code='+type ;
	});	  
   $('#lbllevel1').change(function() {
      checkL();
	 });   
    $("#lbllevel2").chained("#lbllevel1");
  });
  
function checkL() {
  $.ajax({
	  url: "class/levelJSON.php",
	  type: "POST",
	  data: { "code":$("#code").val(),"parent":$("#lbllevel1").val(),"id":$("#service_cateID").val()},
	  success: function(data) {
		  $("#2nd").html(data);
	  }
  });
}

</script></div>