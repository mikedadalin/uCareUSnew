<script type="text/javascript" src="js/LWJ_tabs.js"></script>
<?php
$url = explode("/",$_SERVER['PHP_SELF']);
$db = new DB;
$db->query("SELECT `patientID`,`HospNo`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	$name = getPatientName($r['patientID']);
	$birth = formatdate($r['Birth']);
	$indate = formatdate($r1['indate']);
	$HospNo = $r['HospNo'];
	$bedID = $r1['bed'];
	$db2 = new DB;
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4`, `Qdiag5`, `Qdiag6`, `Qdiag7`, `Qdiag8` FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=8;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
	$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
}
$db_remind = new DB;
$db_remind->query("SELECT * FROM `reminder` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `remindDate` LIKE '".date('Y/m')."%' AND `active`='1'");
for ($i=0;$i<$db_remind->num_rows();$i++) {
	$reminder = $db_remind->fetch_assoc();
	if ($marqueetext != "") { $marqueetext .= ' ||| '; }
	$marqueetext .= '['.$reminder['remindDate'].'] '.$reminder['remindContent'];
}
?>

<div ondblclick="closeResidentCol();">
<?php
$arrNoPrint = array("17","21_1","21_2","4");
$arrNoSelDate = array("1", "2", "10b", "10b_1", "10b_2", "10b_3", "10b_4", "20", "20_1", "21_1","21_2","3","5","6");
?>
<div class="content-query2">
<table align="center" style=" width:100%; font-size:10pt; margin: 0px 0px;">
  <tr id="backtr" style="border:none; height:28px;">
    <?php
	if (@$_GET['id']!=NULL) {
		if ($_SESSION['ncareGroup_lwj']!=4) {
			echo '<td class="backbtnn" align="center" width="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?mod=rehabilitation&func=formview&pid='.mysql_escape_string($_GET['pid']).'">'.$word_Back.'</a></td>';
		} else {
			echo '<td class="backbtnn" align="center" bgcolor="#ffffff" width="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?func=medlist" style="font-size:14px;">Resident List</a></td>';
		}
	}else{
		if ($_SESSION['ncareGroup_lwj']!=4) {
			echo '<td class="backbtnn" align="center" width="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?func=rehabilitationlist" style="font-size:14px;">Resident List</a></td>';
		} else {
			echo '<td class="backbtnn" align="center" bgcolor="#ffffff" width="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?func=medlist" style="font-size:14px;">Resident List</a></td>';
		}
	}
	?>
    <td class="title" width="80" style="border-top-left-radius:10px; background-color:#EECB35;"><?php echo $word_Bed; ?></td>
    <td width="80" style="border:none; padding-left: 10px;"><?php echo $bedID; ?></td>   
    <td class="title" width="60" style="border:none;"><?php echo $word_Name; ?></td>
    <td width="160" style="border:none; padding-left: 10px;"><?php echo $name; ?></td>
    <td class="title" width="70" style="border:none;"><?php echo $word_CareID; ?></td>
    <td width="90" style="border:none; padding-left: 10px;"><?php echo getHospNoDisplayByHospNo($HospNo); ?></td>
    <td width="100" class="title" style="border:none;"><?php echo $word_AdmissionDate; ?></td>
    <td width="80" style="border:none; padding-left: 10px;"><?php echo $indate; ?></td>    
    <td class="title" width="70" style="border:none;"><?php echo $word_DOB; ?></td>
    <td width="170" style="border-top-right-radius:10px; padding-left: 10px;"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
  </tr>
  <tr style="border:none; height:28px;">  <!-- 診斷 + Jump to + 時間 + Print -->
    <?php
		echo '<td class="title" style="background-color:#b79810; border-bottom-left-radius:10px;">'.$word_Diagnosis.'</td>';
		if(substr($url[3],0,5)!="print"){
			if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
				echo '
				<td style="=padding-left: 10px;" colspan="7">'.$diagMsg.'</td>
				<td style="border-bottom-right-radius:10px; padding-left: 5px;" colspan="2">';
				?><input class="residentListButton" type="button" onclick="$('#ResidentCol').show('slide', {direction: 'left'}, 500);" value="Resident List"><?php
	        	if (@$_GET['id']!=NULL) {
					if (!in_array(@$_GET['id'],$arrNoSelDate)) {
						echo '
						<select id="inputeddate" onchange="gotoselecteddate();" style="font-size:14px;">
						<option>Select date</option>';
						$formID = mysql_escape_string($_GET['id']);
						if (strlen((int)$formID)==1) {
	   	                	$formID = '0'.$formID;
	                	}
						$tablename = mysql_escape_string($_GET['mod']).'form'.$formID;
	                	$db = new DB;
	                	$db->query("SELECT * FROM `".$tablename."` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
	                	for ($i=0;$i<$db->num_rows();$i++) {
	   	                	$r = $db->fetch_assoc();
		                	echo '<option value="'.$r['date'].'">'.formatdate($r['date']).'</option>';
	                	}
			        	echo '
						<option value="" >[New record]</option>
	                	</select>';
		        	}
					if (!in_array(@$_GET['id'],$arrNoPrint)) {
						echo '<a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank" style="margin-left:5px;"><input type="button"  value="Print" style="background:rgb(149,219,208); color:white; font-size:15.35px; display:inline-block; padding:3px; border-radius:8px; border:1px; outline: none; width:60px;"></a>';
					}
					if($_GET['id']=="21_1"){
						echo '<a href="printsocialform21_1.php?pid='.$_GET['pid'].'&date='.$_GET['date'].'" target="_blank" style="margin-left:5px;"><input type="button"  value="Print" style="background:rgb(149,219,208); color:white; font-size:15.35px; display:inline-block; padding:3px; border-radius:8px; border:1px; outline: none; width:60px;"></a>';
					}
					if($_GET['id']=="21_2"){
						echo '<a href="printsocialform21_2.php?pid='.$_GET['pid'].'&date='.$_GET['date'].'" target="_blank" style="margin-left:5px;"><input type="button"  value="Print" style="background:rgb(149,219,208); color:white; font-size:15.35px; display:inline-block; padding:3px; border-radius:8px; border:1px; outline: none; width:60px;"></a>';
					}
		    	}
				    $db5 = new DB;
				    $db5->query("SELECT `round` FROM `nurserounds` WHERE `HospNo`='".$HospNo."' AND `date`='".date(Ymd)."' AND `Qfiller`='".$_SESSION['ncareID_lwj']."'");
				    if($db5->num_rows()>0){
					    echo '&nbsp;<button id="CheckRound_OFF_'.$_GET['pid'].'"><i id="CheckRound_OFF_'.$_GET['pid'].'_icon" class="fa fa-check-square-o"></i></button>';
				    }else{
					    echo '&nbsp;<button id="CheckRound_ON_'.$_GET['pid'].'"><i id="CheckRound_ON_'.$_GET['pid'].'_icon" class="fa fa-square-o"></i></button>';
				    }
				echo '</td>';
	    	}else{
				echo'
				<td style="padding-left: 10px;" colspan="8">'.$diagMsg.'</td>
				<td style="border-bottom-right-radius:10px; padding-left: 5px;">';
				if (!in_array(@$_GET['id'],$arrNoPrint)) {
					echo '<a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank" style="margin-left:5px;"><input type="button"  value="Print" style="background:rgb(149,219,208); color:white; font-size:15.35px; display:inline-block; padding:3px; border-radius:8px; border:1px; outline: none; width:60px;"></a>';
				}
				if($_GET['id']=="21_1"){
					echo '<a href="printsocialform21_1.php?pid='.$_GET['pid'].'&date='.$_GET['date'].'" target="_blank" style="margin-left:5px;"><input type="button"  value="Print" style="background:rgb(149,219,208); color:white; font-size:15.35px; display:inline-block; padding:3px; border-radius:8px; border:1px; outline: none; width:60px;"></a>';
				}
				if($_GET['id']=="21_2"){
					echo '<a href="printsocialform21_2.php?pid='.$_GET['pid'].'&date='.$_GET['date'].'" target="_blank" style="margin-left:5px;"><input type="button"  value="Print" style="background:rgb(149,219,208); color:white; font-size:15.35px; display:inline-block; padding:3px; border-radius:8px; border:1px; outline: none; width:60px;"></a>';
				}
				echo '</td>';
        	}
		}else{
			echo'<td style="border-bottom-right-radius:10px; padding-left: 10px;" colspan="9">'.$diagMsg.'</td>';
		}
	?>
  </tr>
</table>
</div>

<?php  /* 表單下移 */
	echo '<div id="printbtn2" style="padding-top:72px;"></div>';
?>

<table border="0" style="text-align:left; width: 100%; margin-bottom:30px;" onclick="closeResidentCol();">
  <tr>
    <td style="border:none;" colspan="3">
    <?php
	if (@$_GET['id']!=NULL) {
		if (!in_array(@$_GET['id'],$arrNoSelDate)) {
	        $formID = mysql_escape_string($_GET['id']);
	        if (strlen((int)$formID)==1) {
	   	    	$formID = '0'.$formID;
	        }
			$tablename = mysql_escape_string($_GET['mod']).'form'.$formID;
			//echo $tablename;
			$db = new DB;
			$db->query("SELECT * FROM `".$tablename."` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
			echo '<div id="tabs" style="padding-top:12px;">'."\n";
			echo '<ul class="printcol">'."\n";
			if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){  /*== 居民判斷 ==*/
			    if ($_GET['date']!="") {
				    $arrVar2 = explode("_",$_GET['date']);
				    echo '<li><a href="#tabs-0">Edit record<br>'.formatdate($arrVar2[0]).'</a></li>'."\n";
			    } else {
				    echo '<li><a href="#tabs-0">New record</a></li>'."\n";
			    }
			}
			$arrDate = array();
			for ($i=1;$i<=$db->num_rows();$i++) {
				$r = $db->fetch_assoc();
				echo '<li><a href="#tabs-'.$i.'">'.formatdate($r['date']).'<br>'.checkusername($r['Qfiller']).'</a></li>';
				$arrDate[$i] = $r['date'];
	        }
			echo '</ul>'."\n";
			if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){  /*== 居民判斷 ==*/
			echo '<div id="tabs-0" class="nurseform-table" style="padding:1px; font-size:11pt;">';
			if (!in_array(@$_GET['id'],$arrNoSelDate)) { echo '<div style="position:absolute; right:14px; top:57px;" class="printcol"><a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank"><img src="Images/print.png" border="0"></a></div>'; }
			include("form".@$_GET['id'].".php");
			echo '</div>';
			}
			foreach ($arrDate as $k=>$v) {
				?>
				<script>
                $('#tabs-<?php echo $k; ?>').ready( function() {
                    $('#tabs-<?php echo $k; ?> :input[type=text]').each( function () {
                        var cell = $(this);
						cell.attr('readonly', true);
						var cell_id = $(this).attr('id');
						$(this).attr('id', cell_id+'_<?php echo $v; ?>');
                    });
					$('#tabs-<?php echo $k; ?> textarea').each( function () {
                        var cell = $(this);
						$(this).replaceWith('<p>'+$(this).html()+'</p>');
						var cell_id = $(this).attr('id');
						$(this).attr('id', cell_id+'_<?php echo $v; ?>');
                    });
					$('#tabs-<?php echo $k; ?> select').each( function () {
                        var cell = $(this);
						cell.attr('disabled', true);
						var cell_id = $(this).attr('id');
						$(this).attr('id', cell_id+'_<?php echo $v; ?>');
                    });
                    $("#tabs-<?php echo $k; ?> :input[type=button]").each( function () {
                        $(this).hide();
                    });
					$("#tabs-<?php echo $k; ?> button[id^='btn_']").each( function () {
						$(this).show();
                        var cell = $(this);
						var cell_id = $(this).attr('id');
						$(this).attr('id', 'nouse_'+cell_id+'_<?php echo $v; ?>');
						$(this).attr('onmouseover', '');
						$(this).attr('onclick', '');
                    });
                    $("#tabs-<?php echo $k; ?> :input[type=submit]").each( function () {
                        $(this).remove();
                    });
                });
                </script>
                <?php
				echo '<div id="tabs-'.$k.'" class="nurseform-table" style="padding:1px; font-size:11pt;">';
				@$_GET['date']=$v;
				if (!in_array(@$_GET['id'],$arrNoSelDate)) { echo '<div style="position:absolute; right:14px; top:57px;" class="printcol"><a href="print.php?'.$_SERVER['QUERY_STRING'].'&date='.$v.'" target="_blank"><img src="Images/print.png" border="0"></a></div>'; }
				include("form".@$_GET['id'].".php");
				echo '</div>';
			}
			echo '</div>'."\n";
		} else {
			echo '<center><div class="nurseform-table formNoSelDate">';
			include("form".@$_GET['id'].".php");
			echo '</div></center>';
		}
	} else {
		include("formlist.php");
	}
	?>
    </td>
  </tr>
</table>
</div>
<?php
if (substr($url[3],0,5)!="print") {
	echo '<div id="ResidentCol" align="left">';
	echo '<div align="center" style="background-color:#eecb35; border-radius:10px; padding:7px; margin-bottom:20px;"><font style="color:white; font-size:26px; font-weight:bold;">Resident List</font></div>';
	include("ResidentCol.php");
	echo '</div>';
	echo '<script type="text/javascript" src="js/closeResidentCol.js"></script>';
}
?>
<script type="text/javascript" src="js/LWJ_CheckRound.js"></script>
<script>
	var lastScrollTop = 0;
	$('#content2').scroll(function(event){
		var st = $(this).scrollTop();
        if(Math.abs(lastScrollTop - st) <= 5)
        return;
    if (st > lastScrollTop && st > 130){
        $(function(){
        	$('.header').removeClass('nav-down').addClass('nav-goup')
        	$('#content2').removeClass('content2Nav').addClass('content2Nav');
        	$('.content-query2').addClass('content-query2Nav');
        });
    } else if(lastScrollTop>st && (lastScrollTop-st>20) || st<=90){
        $(function(){
        	$('.header').removeClass('nav-goup').addClass('nav-down')
        	$('#content2').removeClass('content2Nav').addClass('content2N');
        	$('.content-query2').removeClass('content-query2Nav');
        });
    }
        lastScrollTop = st;
	});
</script>