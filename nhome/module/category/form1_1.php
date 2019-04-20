<div class="moduleNoTab">
<?php
//模組名稱
$strModule = "service_cate";
if (isset($_POST['submit'])) {
	
	//讀寫資料
		//新分類
		$db = new DB;
		$strQry ="INSERT INTO `".$strModule."` (`title`,`parentID`,`layer`,`typeCode`,`ord`,`isHidden_1`,`isHidden_2`) VALUES (";
		$strQry .=" '".mysql_escape_string($_POST['title'])."',";
		$strQry .=" '".mysql_escape_string($_POST['lbllevel1'])."',";
		$strQry .=" '".mysql_escape_string($_GET['layer'])."',";
		$strQry .=" '".mysql_escape_string($_GET['code'])."',";
		  $db1 = new DB;
		  $db1->query("select COUNT( * ) +1 AS new1 from `".$strModule."` where layer='".mysql_escape_string($_GET['layer'])."' and typeCode='".mysql_escape_string($_GET['code'])."' and parentID=".$_POST['parentID']."");
		  $r = $db1->fetch_assoc();
		  $strQry .=" '".mysql_escape_string($r['new1'])."',";
		$strQry .=" '".mysql_escape_string($_POST['isHidden_1'])."',";
		$strQry .=" '".mysql_escape_string($_POST['isHidden_2'])."'";
		$strQry .="  )";		
		$db->query($strQry);
		//echo $strQry;
		if($_SESSION['level']==0){
			echo "<script>alert('Add successfully!');window.location.href='index.php?mod=category&func=formview&id=1&code=".$_GET['code']."'</script>";
		}else{
			echo "<script>alert('Add successfully!');window.location.href='index.php?mod=category&func=formview&id=1&code=".$_GET['code']."&layer=2&parentID=".$_POST['parentID']."'</script>";
		}
}
?>
<form method="post" name="FSform" id="FSform">
<h3>New category</h3>
<table cellpadding="7">
  <tr>
  	<td class="title" width="150">Hierarchy select</td>
    <td style="padding: 0px 5px;">1st Hierarchy
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
    <textarea name="title" id="title" onblur="checkName()" cols="60" rows="5"></textarea>&nbsp;<span style="color:#F00;" id="err"></span>
    </td>
  </tr>
  <tr>
    <td class="title" width="150">Display in the form</td>
    <td>
    <?php $isHidden=1; echo draw_option("isHidden","Display;Hide","xs","single",$isHidden,false,2); ?>
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
  
function checkName() {
  $.ajax({
	  url: "class/cateInfo.php",
	  type: "POST",
	  data: { "NAME": $("#title").val(),"code":$("#code").val(),"layer":$("#layer").val(),"parent":$("#parentID").val()},
	  success: function(data) {
		  if(data == "T"){
			  $('#err').html('*輸入名稱重覆');
			  $('#submit').hide();
		  } else {
			  if($("#title").val()==''){
				  $('#err').html('*This field can not be blank');
			  	  $('#submit').hide();				  
			  }else{
				$('#err').html('');
				$('#submit').show();
			  }
		  }
	  }
  });
}
</script></div>