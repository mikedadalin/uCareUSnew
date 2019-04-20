<h3 style="margin-top:0px;">Staff attendance record</h3>
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
$selmonth = ($_POST['selmonth']!=""?$_POST['selmonth']:$_GET['selmonth']);
$col = ($_POST['col']==""?$_GET['col']:$_POST['col']);
$url="&selmonth=".$selmonth."&col=".$col;
?>
<form id="form1" method="post">
<div align="center" class="content-query">
<table width="100%" class="printcol">
  <tr class="title">
    <td colspan="2">Conditions Input</td>
  </tr>
  <tr>
    <td class="title">Month</td>
    <td align="left" style="padding:10px;">
      <select id="selmonth" name="selmonth">
        <?php
        $nextmonth = date(m)+1; if ($nextmonth>12) { $nextmonth = 1; $nextyear = date(Y)+1; } else { $nextyear = date(Y); }
        if (strlen($nextmonth)==1) { $nextmonth = "0".$nextmonth; }
        for ($i=date(m);$i>=(date(m)-12);$i--) {
            $month = $i;
            if ($year==NULL) { $year = date(Y); }
            if ($i<1) {
                $month = 12+$i;
                $year = date(Y)-1;
            }
            if (strlen($month)==1) {
                $month = "0".$month;
            }
            echo '<option value="'.$year.'-'.$month.'"';
            if ($selmonth==$year.'-'.$month) { echo ' selected'; }
            echo '>'.$year.'-'.$month.'</option>'."\n";
        }
        ?>
        </select>
	</td>
  </tr>
  <tr>
    <td class="title">Report</td>
    <td align="left" style="padding:10px;">
	<?php 
		$arrTitleE = array('1'=>'(Monthly) attendance sheet','2'=>'Work days statistical tables');	
		foreach($arrTitleE as $k=>$v){			
			$b++;
			echo '
			<label>
            <input type="radio" name="col" value="'.$k.'" id="col'.$k.'"';
			if ($col==$k) {echo 'checked';}
			echo '>'.$v.'</label>';
			//if(($b%9) ==0){echo "<br>";}
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
<center>
<form id="form2" method="post" action="printHRform15.php" target="_blank">
<div id="tabs" style="width:956px; padding:15px;">
  <ul>
  	<li><a href="#tabs-1">Domestic staff</a></li>
    <li><a href="#tabs-2">Foreign staff</a></li>
  </ul>
  <div id="tabs-1" style="padding:1px;">
    <div align="right">    
    <input type="submit" value="Print directly" name="report1" id="report1"/>
    <input type="button" value="All staff" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=15&view=1&status=2&query=2<?php echo $url;?>'" class="<?php echo ($class==2?"Do":"");?>"/>
    <input type="button" value="Current employees" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=15&view=1&status=2<?php echo $url;?>'" class="<?php echo ($class==1?"Do":"");?>"/>
    <input type="button" value="Former employees" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=15&view=1&status=2&query=3<?php echo $url;?>'" class="<?php echo ($class==3?"Do":"");?>"/>
    </div>
    
    <table id="hrtab13">
    <thead>
    <tr class="title">
      <th width="60" id="unCheck">Cancel</th>
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
          <td width="6%"><input type="checkbox" name="EmpID[]" id="EmpID'.$EmpID.'" value="'.$EmpID.'" checked></td>
          <td>'.$Position.'</td>
          <td>'.$Name.'</td>
          <td>'.$arrGender[$Gender].'</td>
          <td>'.$Birth.'</td>
          <td>'.$Startdate1.'</td>
        </tr>'."\n";
            } elseif ($Startdate2!=NULL && $Enddate2==NULL) {
            echo '
        <tr>
          <td width="6%"><input type="checkbox" name="EmpID[]" id="EmpID'.$EmpID.'" value="'.$EmpID.'" checked></td>
          <td>'.$Position.'</td>
          <td>'.$Name.'</td>
          <td>'.$arrGender[$Gender].'</td>  <td>'.$Birth.'</td>
          <td>'.$Startdate2.'</td>
        </tr>'."\n";
            } elseif ($Startdate3!=NULL && $Enddate3==NULL) {
            echo '
        <tr>
          <td width="6%"><input type="checkbox" name="EmpID[]" id="EmpID'.$EmpID.'" value="'.$EmpID.'" checked></td>
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
          <td width="6%"><input type="checkbox" name="EmpID[]" id="EmpID'.$EmpID.'" value="'.$EmpID.'" checked></td>
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
          <td width="6%"><input type="checkbox" name="EmpID[]" id="EmpID'.$EmpID.'" value="'.$EmpID.'" checked></td>
          <td>'.$Position.'</td>
          <td>'.$Name.'</td>
          <td>'.$arrGender[$Gender].'</td>
          <td>'.$Birth.'</td>
          <td>'.$Enddate3.'</td>
        </tr>'."\n";
            } elseif ($Startdate2!=NULL && $Enddate2!=NULL) {
            echo '
        <tr>
          <td width="6%"><input type="checkbox" name="EmpID[]" id="EmpID'.$EmpID.'" value="'.$EmpID.'" checked></td>
          <td>'.$Position.'</td>
          <td>'.$Name.'</td>
          <td>'.$arrGender[$Gender].'</td>  <td>'.$Birth.'</td>
          <td>'.$Enddate2.'</td>
        </tr>'."\n";
            } elseif ($Startdate1!=NULL && $Enddate1!=NULL) {
            echo '
        <tr>
          <td width="6%"><input type="checkbox" name="EmpID[]" id="EmpID'.$EmpID.'" value="'.$EmpID.'" checked></td>
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
  </div>
  <div id="tabs-2" style="padding:1px;">
    <div align="right">    
    <input type="submit" value="Print directly" name="report1" id="report1"/>
    <input type="button" value="All staff" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=15&view=2&status=2&query=2<?php echo $url;?>'" class="<?php echo ($class==2?"Do":"");?>"/>
    <input type="button" value="Current employees" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=15&view=2&status=2<?php echo $url;?>'" class="<?php echo ($class==1?"Do":"");?>"/>
    </div>
  <table id="hrtab12">
    <thead>
  	<tr>  
      <th id="unCheck2">Cancel</th>
      <th>Staff ID#</th>
      <th>Full name</th>
      <th>Gender</th>
      <th>Job title</th>
   	</tr>
    </thead>
<?php
$sql1 = "SELECT * FROM `foreignemployer` ORDER BY `foreignID` ASC";
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
  <td width="6%"><center><input type="checkbox" name="foreignID[]" id="foreignID'.$r['foreignID'].'" value="'.$r['foreignID'].'" checked></center></td>
  <td width="13%">'.$foreignID.'</td>
  <td width="13%">'.$eNickname.' '.$cNickname.'</td>
  <td width="13%">'.$arrGender[$Gender].'</td>
  <td width="13%">'.$position.'</td>
</tr>'."\n";
	} elseif ($Startdate2!=NULL && $Enddate2==NULL) {
	echo '
<tr>
  <td width="6%"><center><input type="checkbox" name="foreignID[]" id="foreignID'.$r['foreignID'].'" value="'.$r['foreignID'].'" checked></center></td>
  <td width="13%">'.$foreignID.'</td>
  <td width="13%">'.$eNickname.' '.$cNickname.'</td>
  <td width="13%">'.$arrGender[$Gender].'</td>
  <td width="13%">'.$position.'</td>
</tr>'."\n";
	} elseif ($Startdate3!=NULL && $Enddate3==NULL) {
	echo '
<tr>
  <td width="6%"><center><input type="checkbox" name="foreignID[]" id="foreignID'.$r['foreignID'].'" value="'.$r['foreignID'].'" checked></center></td>
  <td width="13%">'.$foreignID.'</td>
  <td width="13%">'.$eNickname.' '.$cNickname.'</td>
  <td width="13%">'.$arrGender[$Gender].'</td>
  <td width="13%">'.$position.'</td>
</tr>'."\n";
	} elseif ($Startdate4!=NULL && $Enddate4==NULL) {
	echo '
<tr>
  <td width="6%"><center><input type="checkbox" name="foreignID[]" id="foreignID'.$r['foreignID'].'" value="'.$r['foreignID'].'" checked></center></td>
  <td width="13%">'.$foreignID.'</td>
  <td width="13%">'.$eNickname.' '.$cNickname.'</td>
  <td width="13%">'.$arrGender[$Gender].'</td>
  <td width="13%">'.$position.'</td>
</tr>'."\n";
	} elseif ($Startdate5!=NULL && $Enddate5==NULL) {
	echo '
<tr>
  <td width="6%"><center><input type="checkbox" name="foreignID[]" id="foreignID'.$r['foreignID'].'" value="'.$r['foreignID'].'" checked></center></td>
  <td width="13%">'.$foreignID.'</td>
  <td width="13%">'.$eNickname.' '.$cNickname.'</td>
  <td width="13%">'.$arrGender[$Gender].'</td>
  <td width="13%">'.$position.'</td>
</tr>'."\n";
	}
	} elseif (@$_GET['query']==2) {
    echo '
<tr>
  <td width="6%"><center><input type="checkbox" name="foreignID[]" id="foreignID'.$r['foreignID'].'" value="'.$r['foreignID'].'" checked></center></td>
  <td width="13%">'.$foreignID.'</td>
  <td width="13%">'.$eNickname.' '.$cNickname.'</td>
  <td width="13%">'.$arrGender[$Gender].'</td>
  <td width="13%">'.$position.'</td>
</tr>'."\n";
	}
}
?>
</table>    
  </div>
</div>  
    <input type="hidden" name="selmonth" value="<?php echo $selmonth;?>">
    <input type="hidden" name="q" value="<?php echo $_GET['query'];?>">
    <input type="hidden" name="title" value="<?php echo $col; ?>">
    <input type="hidden" name="view" value="<?php echo $_GET['view'];?>" id="view">
</form>
</center>
<?php
}
?>
<p>&nbsp;</p>
<script>
function checkCol() {
	var method =$("input[name='col']:checked").val();
	if (typeof(method) == "undefined") {
		alert('請選擇要列印的報表!');
		return false;
	}
}
$(function(){
	$("#tabs").tabs({ active: <?php if (@$_GET['view']==NULL) { echo '0'; } else { echo (@$_GET['view']-1); } ?> });
	$('#hrtab13').dataTable({"paging": false});
	$('#hrtab12').dataTable({"paging": false});
	$("#tabs ul li a").click(function() {
		$("#view").val($("#tabs").tabs('option', 'active')+1);
	});
	$("#report1").click(function(){
		return checkCol();
	})
	$("#selmonth").change(function(){
		$('#form1').attr('action', "index.php?mod=humanresource&func=formview&id=15&status=2&selmonth="+$('#selmonth').val());
		$('#form1').submit();
	})
	$("input[id^=col]").click(function(){
		var query1 = '<?php echo $_GET['query'];?>';
		var query ="";
		if(query1 !=""){query="&query="+query1;}
		if (!isNaN($("#tabs").tabs('option', 'active'))) {
			var aa = $("#tabs").tabs('option', 'active')+1;
		} else {
			var aa ='1';
		}
		$('#form1').attr('action', "index.php?mod=humanresource&func=formview&id=15&status=2&view="+aa+"&selmonth="+$('#selmonth').val()+query);
		$('#form1').submit();
	})
	$("#unCheck").click(function(){
		if($('input[id^=EmpID]').attr('checked')=="checked"){
			$('input[id^=EmpID]').attr('checked',false);
			$('#unCheck').html('Select all');
		}else{
			$('input[id^=EmpID]').attr('checked',true);
			$('#unCheck').html('Cancel');
		}
	})
	$("#unCheck2").click(function(){
		if($('input[id^=foreignID]').attr('checked')=="checked"){
			$('input[id^=foreignID]').attr('checked',false);
			$('#unCheck2').html('Select all');
		}else{
			$('input[id^=foreignID]').attr('checked',true);
			$('#unCheck2').html('Cancel');
		}
	})
});
</script>