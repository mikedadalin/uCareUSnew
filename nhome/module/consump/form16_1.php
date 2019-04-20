<?php
//模組名稱
$strModule = "property";
$firmID = (int) @$_GET['pno'];
$parentName = $strModule;
$parentID = $firmID;

if (isset($_POST['saveproduct'])) {
	//print_r($_POST);
	array_pop($_POST);
		$db0 = new DB;
		$db0->query("UPDATE `property` SET `itemID`='' WHERE `propertyID`='".mysql_escape_string($_POST['propertyID'])."'");
	foreach ($_POST as $k=>$v) {
		$arrVarName = explode('_',$k);
		if (count($arrVarName)==2) {
			//General
			
			$db6 = new DB;
			$db6->query("SELECT * FROM `maintenance_item` WHERE `itemName`='".$v."'");
			$r6 = $db6->fetch_assoc();
			if($r6['itemName']==$v){
				$v = $r6['itemID'];
			}			

			$db0 = new DB;
			$db0->query("UPDATE `property` SET `".str_replace("a1_","",$k)."`='".$v."' WHERE `propertyID`='".mysql_escape_string($_POST['propertyID'])."'");
			//echo "UPDATE `property` SET `".str_replace("a1_","",$k)."`='".$v."' WHERE `propertyID`='".mysql_escape_string($_POST['propertyID'])."'<br>";
		} elseif (count($arrVarName)==3) {
			//stop_ID PRC_ID處理
			if ($v==1) {
				if ($arrVarName[2]==1) {
					$vtowrite="0";
				} elseif ($arrVarName[2]==2) {
					$vtowrite="1";
				}
			$db0 = new DB;
			$db0->query("UPDATE `property` SET `".$arrVarName[0].'_'.$arrVarName[1]."`='".$vtowrite."' WHERE `propertyID`='".mysql_escape_string($_POST['propertyID'])."'");
			//echo "UPDATE `property` SET `".$arrVarName[0].'_'.$arrVarName[1]."`='".$vtowrite."' WHERE `propertyID `='".mysql_escape_string($_POST['propertyID'])."'<br>--";
			}
		}
	}
	//print_r($_POST);
	include('class/insertDetail.php');
	include('class/updateDetail.php');	
	echo "<script>alert('Edited successfully!');</script>";
}

$p_no = mysql_escape_string($_GET['pno']);
$db = new DB;
$db->query("SELECT * FROM `property` WHERE `propertyID`='".$p_no."'");
$r = $db->fetch_assoc();
?>
<form method="post" id="base">
<input type="hidden" id="propertyID" name="propertyID" value="<?php echo $p_no; ?>" >
<table width="100%">
  <tr>
    <td class="title" colspan="10">Edit Property Information</td>
  </tr>
  <tr>
    <td class="title" width="100">ID #</td>
    <td width="200" align="left"><input type="text" name="p_no" id="p_no" value="<?php echo $r['p_no']; ?>" class="validate[required]"></td>
    <td class="title" width="80">Name</td>
    <td colspan="3" align="left"><input type="text" name="p_name" id="p_name" size="80" value="<?php echo $r['p_name']; ?>" class="validate[required]"></td>
    
  </tr>
  <tr>
    <td class="title" width="100">Spec.</td>
    <td align="left"><input type="text" name="p_spk" id="p_spk" size="20" value="<?php echo $r['p_spk']; ?>"></td>
    <td class="title">Model</td>
    <td width="200" align="left"><input type="text" name="p_model" id="p_model" size="20" value="<?php echo $r['p_model']; ?>"></td>
    <td class="title">Unit</td>
    <td align="left"><input type="text" name="p_unit" id="p_unit" size="20" value="<?php echo $r['p_unit']; ?>"></td>
  </tr>
  <tr>
    <td class="title">Storage Unit</td>
    <td align="left">
    <?php
	$db1 = new DB;
	$db1->query("select * from service_cate where typeCode='property' and layer =1 and isHidden_1");
	if($db1->num_rows() > 0 ){
		echo '<select id="service_cateID" name="service_cateID"><option value="0">========</option>';
		for($i1=0;$i1<$db1->num_rows();$i1++){
			$r1 = $db1->fetch_assoc();
			echo '<option value="'.$r1['service_cateID'].'" '.($r1['service_cateID']==$r['service_cateID']?'selected':'').'>'.$r1['title'].'</option>';
		}
		echo '</select>';
	}
    ?>    
    </td>
    <td class="title">Placed Location</td>
    <td colspan="3" align="left">
    <?php
	$db1 = new DB;
	$db1->query("select * from maintenance_area where 1 order by areaName");
	if($db1->num_rows() > 0 ){
		echo '<select id="a1_areaID" name="a1_areaID" class="validate[required]"><option value="">========</option>';
		for($i1=0;$i1<$db1->num_rows();$i1++){
			$r1 = $db1->fetch_assoc();
			echo '<option value="'.$r1['areaID'].'" '.($r1['areaID']==$r['areaID']?'selected':'').'>'.$r1['areaName'].'</option>';
		}
		echo '</select>';
	}
    ?>    
	</td>
  </tr>
  <tr>
    <td class="title">Item(s)</td>
    <td colspan="5" align="left">
    <select name="mainCate" id="mainCate" onchange="changeitem(this)">
          <option></option>
          <?php
		  $db5 = new DB;
		  $db5->query("SELECT * FROM `maintenance_item` WHERE `itemID`='".$r['itemID']."'");
		  $r5 = $db5->fetch_assoc();
		  
		  $db3 = new DB;
		  $db3->query("SELECT * FROM `maintenance_cate` ORDER BY `cateID` ASC");
		  $arrCate = array();
		  for ($i=0;$i<$db3->num_rows();$i++) {
			  $r3 = $db3->fetch_assoc();
			  echo '<option value="'.$r3['cateID'].'" '.($r3['cateID']==$r5['cateID']?'selected':'').'>'.$r3['cateName'].'</option>'."\n";
			  $arrCate[$r3['cateID']] = $r3['cateName'];
		  }
		  ?>
        </select>
          <select name="a1_itemID" id="a1_itemID">
            <option></option>
          </select>
        <script>
		changeitem(document.getElementById('mainCate'));
		function changeitem(selectObj) {
			var itemLists = new Array(<?php echo count($arrCate); ?>);
			<?php
			foreach ($arrCate as $k=>$v) {
				$db4 = new DB;
				$db4->query("SELECT * FROM `maintenance_item` WHERE `cateID`='".$k."' ORDER BY `itemID` ASC");
				$itemList = "";
				for ($i=0;$i<$db4->num_rows();$i++) {
					$r4 = $db4->fetch_assoc();
					if ($itemList!=NULL) { $itemList .= ', '; }
					$itemList .= '"'.$r4['itemName'].'"';					
				}
				echo 'itemLists["'.$k.'"] = ['.$itemList.'];'."\n";
			}
			?>
			// get the index of the selected option 
			var idx = selectObj.selectedIndex;

			// get the value of the selected option 
			var which = selectObj.options[idx].value; 
			// use the selected option value to retrieve the list of items from the countryLists array 
			cList = itemLists[which]; 
			
			// get the country select element via its known id 
			var cSelect = document.getElementById("a1_itemID"); 

			// remove the current options from the country select 
			var len=cSelect.options.length; 
			while (cSelect.options.length > 0) { cSelect.remove(0); } 
			var newOption;
			var test = '<?php echo $r5['itemName'];?>';
			// create new options
			for (var i=0; i<cList.length; i++) { 
				newOption = document.createElement("option"); 
				newOption.value = cList[i];  // assumes option string and value are the same 
				newOption.text=cList[i]; 
				
				// add the new option 
				try { cSelect.add(newOption); }  // this will fail in DOM browsers but is needed for IE
				catch (e) { cSelect.appendChild(newOption); }
				
				if(test==newOption.value){
					document.getElementById("a1_itemID").options[i].selected = true;
				}
			}
			
		}
		</script>
		</td>
    </tr>
  <tr>
        <td class="title">Funding / Subsidy Serial Number</td>
        <td colspan="3" align="left"><input type="text" name="p_source" id="p_source" size="50" value="<?php echo $r['p_source']; ?>"></td>
      <td class="title">Purchase date</td>
      <td align="left"><script>$(function(){$("#p_date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true});})</script><input type="text" name="p_date" id="p_date" value="<?php echo $r['p_date'];?>"></td>
  </tr>
  <tr>
    <td class="title">Usage</td>
    <td align="center">
    <?php
	if ($r['stop_ID']=='0') { $STOPID = '1'; } elseif ($r['stop_ID']=='1') { $STOPID = '2'; }
	echo draw_option("stop_ID","Retire;Usable", "xs", "single", $STOPID, false, 0);
	?>
    </td>
  
    <td class="title">Comment</td>
    <td><input type="text" name="p_rmk" id="p_rmk" size="40" value="<?php echo $r['p_rmk']; ?>"></td>
    <td class="title">Modified by</td>
    <td><?php echo checkusername($r['userID']); ?><input type="hidden" name="userID" id="userID" value="<?php echo $_SESSION['ncareID_lwj']; ?>"></td>
  </tr>
</table>
<br />
<table width="100%">
<tr>
	<td class="title">Property Alert</td>
</tr>
</table>
<?php 
$tmpArr=array("Original unit","Handled by staff in original unit","New unit","Handled by staff in new unit","Transaction reason","Transaction date","Modified by");
$tmpLength = count($tmpArr);
include("class/blockDetail.php");
include("class/addDetail.php");
?>
<div class="printcol" style="margin-top:50px;">
<center><input type="button" value="Back to list" onclick="window.location.href='index.php?mod=consump&func=formview&id=16'"> <input type="submit" name="saveproduct" id="saveproduct" value="Save"></center>
</div>
</form>
<script>$("#base").validationEngine();</script>