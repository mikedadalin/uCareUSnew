<h3 style="margin-top:0px;">Roster output</h3>
<?php 
//使用說明 Start
//$manual_table="employer";
//include("class/useInfo.php");
//使用說明 End

if(@$_GET['query']==NULL){
	$class = 1;	
}else{
	$class = $_GET['query'];
}
$sDate = ($_POST['sDate']!=""?$_POST['sDate']:$_GET['sDate']);
$eDate = ($_POST['eDate']!=""?$_POST['eDate']:$_GET['eDate']);
$eDate1 = ($_POST['eDate1']!=""?$_POST['eDate1']:$_GET['eDate1']);
if($sDate!=""){	
	$strSQL = " AND (`Startdate1` >= '".$sDate."'";
   $strSQL .= " OR (`Startdate2`!='' AND `Startdate2` >= '".$sDate."')";
   $strSQL .= " OR (`Startdate3`!='' AND `Startdate3` >= '".$sDate."'))";
$url="&sDate=".$_GET['sDate'];
}
if($eDate!="" && $eDate1!=""){	
	$strSQL .= " AND (`Enddate3` != '' AND `Enddate3` >= '".$eDate."' AND `Enddate3` <= '".$eDate1."'";
   $strSQL .= " OR (`Enddate3` = '' AND `Enddate2`!='' AND `Enddate2` >= '".$eDate."' AND `Enddate2` <= '".$eDate1."')";
   $strSQL .= " OR (`Enddate3` = '' AND `Enddate2` = '' AND `Enddate1` >= '".$eDate."' AND `Enddate1` <= '".$eDate1."'))";
$url .="&eDate=".$_GET['eDate']."&eDate1=".$_GET['eDate1'];
}
//echo $url;
?>

<form id="form1" method="post">
  <div align="left" class="content-query">
    <table width="100%" class="printcol">
      <tr class="title">
        <td colspan="2">Conditions Input</td>
      </tr>
      <tr>
        <td class="title">Date of reporting for duty</td>
        <td align="left" style="padding:10px;">
          <input type="text" name="sDate" id="sDate" size="12" value="<?php echo ($sDate==""?"":$sDate);?>" > and after
        </td>
      </tr>
      <tr>
        <td class="title">Resignation date</td>
        <td align="left" style="padding:10px;">
          Start <input type="text" name="eDate" id="eDate" size="12" value="<?php echo ($eDate==""?"":$eDate);?>" > 
          Untill <input type="text" name="eDate1" id="eDate1" size="12" value="<?php echo ($eDate1==""?"":$eDate1);?>" > 
        </td>
      </tr>
      <tr>
        <td class="title">Field</td>
        <td align="left" style="padding:10px;">
          <?php 
          $arrTitleE = array('Job title', 'Full name', 'Gender', 'DOB', 'Social Security number', 'Date of reporting for duty', 'Education', 'Phone', 'Address', 'Tax form', '84-1核備', 'Physical examination status', 'Physical examination', 'Job training');		
          foreach($arrTitleE as $k=>$v){			
           $b++;
           echo '<input type="checkbox" name="col[]" id="col'.$k.'" value="'.$v.'" ';
           if (count($_POST['col'])>0) {
             foreach($_POST['col'] as $k1=>$v1){
              if ($v1==$v) { echo 'checked'; }
            }
          }
          echo '><label for="col'.$k.'">'.$v."</label>　";
          if(($b%9) ==0){echo "<br>";}
        }		
        ?>
      </td>
    </tr>
  </table>
</div>
</form>
<?php
if ($_GET['status']=='2') {
  ?>
  <form id="form2" method="post" action="printHRform12.php" target="_blank">
    <div align="right">
      <input type="submit" value="Physical examination" name="report1" id="report1"/>
      <input type="submit" value="Staff roster" name="report2" id="report2"/><span style="font-size:18px; margin-left:5px;">|</span>
      <input type="button" value="All staff" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=13&status=2&query=2<?php echo $url;?>'" class="<?php echo ($class==2?"Do":"");?>"/>
      <input type="button" value="Current employees" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=13&status=2<?php echo $url;?>'" class="<?php echo ($class==1?"Do":"");?>"/>
      <input type="button" value="Former employees" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=13&status=2&query=3<?php echo $url;?>'" class="<?php echo ($class==3?"Do":"");?>"/>
    </div>
    
    <table id="hrtab13">
      <thead>
        <tr class="title">
          <th width="60">Select</th>
          <th width="60">Job title</th>
          <th width="100">Full name</th>
          <th width="40">Gender</th>
          <th width="80">DOB</th>
          <th width="80"><?php echo ($_GET['query']==3?"Resignation date":"Date of reporting for duty"); ?></th>
          <?php echo ($_GET['query']==2?'<th width="80">Resignation date</th>':""); ?></tr>
        </thead>
        <?php
        $sql1 = "SELECT * FROM `employer` WHERE 1 ".$strSQL." ORDER BY `EmpID` ASC";
    //echo $sql1;
        $db = new DB;
        $db->query($sql1);
        for ($i=0;$i<$db->num_rows();$i++) {
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
          if (@$_GET['query']==NULL || @$_GET['query']==1) {
            if ($Enddate1==NULL) {
              echo '
              <tr>
              <td width="6%"><input type="checkbox" name="EmpID[]" value="'.$EmpID.'" checked></td>
              <td>'.$Position.'</td>
              <td>'.$Name.'</td>
              <td>'.$arrGender[$Gender].'</td>
              <td>'.$Birth.'</td>
              <td>'.$Startdate1.'</td>
              </tr>'."\n";
            } elseif ($Startdate2!=NULL && $Enddate2==NULL) {
              echo '
              <tr>
              <td width="6%"><input type="checkbox" name="EmpID[]" value="'.$EmpID.'" checked></td>
              <td>'.$Position.'</td>
              <td>'.$Name.'</td>
              <td>'.$arrGender[$Gender].'</td>  <td>'.$Birth.'</td>
              <td>'.$Startdate2.'</td>
              </tr>'."\n";
            } elseif ($Startdate3!=NULL && $Enddate3==NULL) {
              echo '
              <tr>
              <td width="6%"><input type="checkbox" name="EmpID[]" value="'.$EmpID.'" checked></td>
              <td>'.$Position.'</td>
              <td>'.$Name.'</td>
              <td>'.$arrGender[$Gender].'</td>
              <td>'.$Birth.'</td>
              <td>'.$Startdate3.'</td>
              </tr>'."\n";
            }
          } elseif (@$_GET['query']==2) {
            echo '
            <tr>
            <td width="6%"><input type="checkbox" name="EmpID[]" value="'.$EmpID.'" checked></td>
            <td>'.$Position.'</td>
            <td>'.$Name.'</td>
            <td>'.$arrGender[$Gender].'</td>
            <td>'.$Birth.'</td>
            <td>'.($Startdate3!=""?$Startdate3:($Startdate2!=""?$Startdate2:($Startdate1!=""?$Startdate1:""))).'</td>
            <td>'.($Enddate3!=""?$Enddate3:($Enddate2!=""?$Enddate2:($Enddate1!=""?$Enddate1:""))).'</td>
            </tr>'."\n";
          } elseif (@$_GET['query']==3) {
            if ($Enddate3!=NULL && $Startdate3!=NULL) {
              echo '
              <tr>
              <td width="6%"><input type="checkbox" name="EmpID[]" value="'.$EmpID.'" checked></td>
              <td>'.$Position.'</td>
              <td>'.$Name.'</td>
              <td>'.$arrGender[$Gender].'</td>
              <td>'.$Birth.'</td>
              <td>'.$Enddate3.'</td>
              </tr>'."\n";
            } elseif ($Startdate2!=NULL && $Enddate2!=NULL) {
              echo '
              <tr>
              <td width="6%"><input type="checkbox" name="EmpID[]" value="'.$EmpID.'" checked></td>
              <td>'.$Position.'</td>
              <td>'.$Name.'</td>
              <td>'.$arrGender[$Gender].'</td>  <td>'.$Birth.'</td>
              <td>'.$Enddate2.'</td>
              </tr>'."\n";
            } elseif ($Startdate1!=NULL && $Enddate1!=NULL) {
              echo '
              <tr>
              <td width="6%"><input type="checkbox" name="EmpID[]" value="'.$EmpID.'" checked></td>
              <td>'.$Position.'</td>
              <td>'.$Name.'</td>
              <td>'.$arrGender[$Gender].'</td>
              <td>'.$Birth.'</td>
              <td>'.$Enddate1.'</td>
              </tr>'."\n";
            }	
          }
        }
        ?>
      </table>
      <input type="hidden" name="date" value="<?php echo $sDate;?>">
      <input type="hidden" name="q" value="<?php echo $_GET['query'];?>">
      <input type="hidden" name="title" value="<?php foreach( $_POST['col'] as $k => $v) echo $v.';'; ?>">
    </form>
    <?php
  }
  ?>
  <p>&nbsp;</p>
  <script>
  function checkCol() {
   var clicked = 0;
   for(var i1=0;i1<<?php echo $b; ?>;i1++) {
    if ($('input[id="col'+i1+'"]').attr('checked')=="checked") {
     clicked++;
   }
 }
 if (clicked==0) {
  alert('請至少選一個欄位');
  return false;
} else {
  var query1 = '<?php echo $_GET['query'];?>';
  var query ="";
  if(query1 !=""){query="&query="+query1;}
  $('#form1').attr('action', "index.php?mod=humanresource&func=formview&id=13&status=2&sDate="+$('#sDate').val()+"&eDate="+$('#eDate').val()+query);
  $('#form1').submit();
	//}
}
}
$(function(){
	$('#hrtab13').dataTable({
		"paging": false
	});
	$("#sDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: false});
	$("#eDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: false});
	$("#eDate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: false});
	$("#report1").click(function(){
		return checkCol();
	})
	$("#report2").click(function(){
		return checkCol();
		if($("#sDate").val()==""){
			alert('請先輸入到職日條件');
			return false;
		}
	})
	$("#sDate").change(function(){
		$("#eDate").val("");
		$("#eDate1").val("");
		$('#form1').attr('action', "index.php?mod=humanresource&func=formview&id=13&status=2&sDate="+$('#sDate').val());
		$('#form1').submit();
	})
	$("#eDate").change(function(){
		$("#sDate").val("");
		var edate = $("#eDate1").val();
		if(edate !=""){
			if($("#eDate").val() > $("#eDate1").val()){
				alert('離職起日不可大於離職迄日');return false;
			}else{
				var date="&eDate1="+edate;		
				$('#form1').attr('action', "index.php?mod=humanresource&func=formview&id=13&status=2&query=3"+date);
				$('#form1').submit();
			}
		}else{
			alert('請選擇離職迄日');
			$("#eDate1").focus();
		}
	})
	$("#eDate1").change(function(){
		$("#sDate").val("");
		var edate = $("#eDate").val();
		if(edate !=""){
			if($("#eDate").val() > $("#eDate1").val()){
				alert('離職起日不可大於離職迄日');return false;
			}else{
				var date="&eDate="+edate;						
				$('#form1').attr('action', "index.php?mod=humanresource&func=formview&id=13&status=2&query=3"+date);
				$('#form1').submit();
			}
		}else{
			alert('請選擇離職起日');
			$("#eDate").focus();
		}
	})
	$("input[id^=col]").click(function(){
		var query1 = '<?php echo $_GET['query'];?>';
		var query ="";
		if(query1 !=""){query="&query="+query1;}
		$('#form1').attr('action', "index.php?mod=humanresource&func=formview&id=13&status=2&sDate="+$('#sDate').val()+"&eDate="+$('#eDate').val()+"&eDate1="+$('#eDate1').val()+query);
		$('#form1').submit();
	})
});
</script>