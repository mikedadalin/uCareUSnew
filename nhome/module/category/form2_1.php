<div style="background-color:rgba(255,255,255,0.8); border-radius:24px; padding:40px; padding-top:10px; width:80%">
<?php
//模組名稱
$strModule = "service_cate";
$strModule2 = "service_item";
if (isset($_POST['submit'])) {
	
	//讀寫資料
		//新分類
		$cate = ($_POST['lbllevel2']==0?$_POST['lbllevel1']:$_POST['lbllevel2']);
		$db = new DB;
		$strQry ="INSERT INTO `".$strModule2."` (`title`,`service_cateID`,`ord`,`isHidden_1`,`isHidden_2`) VALUES (";
		$strQry .=" '".mysql_escape_string($_POST['title'])."',";
		$strQry .=" '".$cate."',";
		  $db1 = new DB;
		  $db1->query("select COUNT( * ) +1 AS new1 from `".$strModule2."` where service_cateID='".$cate."' ");
		  $r = $db1->fetch_assoc();
		  $strQry .=" '".mysql_escape_string($r['new1'])."',";
		$strQry .=" '".mysql_escape_string($_POST['isHidden_1'])."',";
		$strQry .=" '".mysql_escape_string($_POST['isHidden_2'])."'";
		$strQry .="  )";		
		$db->query($strQry);
		//echo $strQry;
		echo "<script>alert('Add successfully!');window.location.href='index.php?mod=category&func=formview&id=2&code=".$_GET['code']."&cate2=".$cate."'</script>";
}
?>
<form method="post" name="FSform" id="FSform">
<h3>Add list</h3>
<table width="100%">
  <tr>
  	<td class="title" width="150">Category select</td>
    <td width="200"><div id="1st">1st Hierarchy
    <select name="lbllevel1" id="lbllevel1" style="overflow:hidden;">
	<?php 
        $LevDB = new DB;
        $LevDB->query("select * from ".$strModule." where parentID=0 and typeCode='".mysql_escape_string($_GET['code'])."' and isHidden_1=1 order by ord");		
		if($LevDB->num_rows() > 0 ){
			echo '<option value="0"> --- </option>';						
			for ($i=0;$i<$LevDB->num_rows();$i++) {
        		$lev = $LevDB->fetch_assoc();
				echo '<option value='.$lev['service_cateID'].'>'.$lev['title'].'</option>';					
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
    <textarea name="title" type="text" id="title" cols="60" rows="5" onblur="checkName()"></textarea>&nbsp;<span style="color:#F00;" id="err"></span>
    </td>
  </tr>
  <tr>
    <td class="title" width="150">Display in the form</td>
    <td colspan="2">
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
</form>

<script language="javascript">
 $(function() {
	 
	//Back to list
	$('#cmdBack').click(function(){
	  var type ='<?php echo $_GET['code'];?>';	
	  var layer = '<?php echo $_GET['layer']; ?>';
	  	  location.href='index.php?mod=category&func=formview&id=1&code='+type ;
	});	  
   $('#lbllevel1').change(function() {
      checkL();
	 });   
    $("#lbllevel2").chained("#lbllevel1");
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
function checkL() {
  $.ajax({
	  url: "class/levelJSON.php",
	  type: "POST",
	  data: { "code":$("#code").val(),"parent":$("#lbllevel1").val()},
	  success: function(data) {
		  $("#2nd").html(data);
	  }
  });
}

</script></div>