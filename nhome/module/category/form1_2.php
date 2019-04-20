<div class="moduleNoTab">
<?php
//模組名稱
$strModule = "service_cate";
$firmID = (int) @$_GET[$strModule.'ID'];
if (isset($_POST['submit'])) {
	
	//讀寫資料
		//新分類
		$db = new DB;
		$strQry = "UPDATE `".$strModule."` SET ";
		$strQry .="title = '".mysql_escape_string($_POST['title'])."',";
		$strQry .="isHidden_1= '".mysql_escape_string($_POST['isHidden_1'])."',";
		$strQry .="isHidden_2= '".mysql_escape_string($_POST['isHidden_2'])."'";
		$strQry .=" WHERE ".$strModule."ID=".$firmID;
		$db->query($strQry);
		if($_SESSION['level']==1){
			echo "<script>alert('Modify success!!');window.location.href='index.php?mod=category&func=formview&id=1&code=".$_GET['code']."&parentID=".$_POST['parentID']."&layer=".$_GET['layer']."'</script>";
		}else{
			echo "<script>alert('Modify success!');window.location.href='index.php?mod=category&func=formview&id=1&code=".$_GET['code']."'</script>";
		}
}

?>
<?php
$db = new DB;
$db->query("SELECT * FROM `".$strModule."` WHERE `".$strModule."ID`='".mysql_escape_string($firmID)."'");
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
<h3>Project maintenance</h3>
<table cellpadding="7">
  <tr>
  	<td class="title" width="150">Hierarchy select</td>
    <td>1st Hierarchy
	<?php 
	if($_SESSION['level']==0){
		$parentID = 0;
	}else{
        $LevDB = new DB;
        $LevDB->query("select * from ".$strModule." where service_cateID='".mysql_escape_string($_GET['parentID'])."'");		
        $lev = $LevDB->fetch_assoc();					
		echo "(".$lev['title'].")";
		$parentID = $lev[$strModule.'ID'];
	}
    ?>
	<input type="hidden" id="lbllevel1" name="lbllevel1" value="<?php echo $parentID;?>">
    </td>
  </tr>
  <tr>
    <td class="title" width="150">Name</td>
    <td>
    <textarea name="title" id="title" cols="60" rows="5"><?php echo $title; ?></textarea>
    </td>
  </tr>
  <tr>
    <td class="title" width="150">Display in the form</td>
    <td>
    <?php echo draw_option("isHidden","Display;Hide","xs","single",$isHidden,false,2); ?>
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
    <input type="hidden" id="<?php $strModule ?>ID" name="<?php $strModule ?>ID" value="<?php  echo $firmID; ?>" />
    <input type="hidden" id="parentID" name="parentID" value="<?php echo (strlen($_GET['parentID'])==0 ? 0 : $_GET['parentID']);?>">
</form>
<script language="javascript">
 $(function() {
	//Back to list
	$('#cmdBack').click(function(){
	  var type ='<?php echo $_GET['code'];?>';	
	  var layer = '<?php echo $_GET['layer']; ?>';
	  if(layer==2){
		  var parentID='<?php echo $_GET['parentID'];?>';
		  location.href = "index.php?mod=category&func=formview&id=1&code="+type+'&parentID='+parentID+'&layer='+layer; 
	  }else{
	  	  location.href='index.php?mod=category&func=formview&id=1&code='+type ;
	  }
	});	  
  });
  
</script></div>