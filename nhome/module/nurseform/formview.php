<script type="text/javascript" src="js/LWJ_tabs.js"></script>
<script>
	var lastScrollTop = 0;
	$('#content2').scroll(function(event){
		var st = $(this).scrollTop();
        if(Math.abs(lastScrollTop - st) <= 5)
        return;//終止函數執行
    if (st > lastScrollTop && st > 90){ //90就是 .header nav-down的height
        $(function(){
        	$('.header').removeClass('nav-down').addClass('nav-goup')
        	$('#content2').removeClass('content2N').addClass('content2Nav');
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

$arrNoSelDate = array("1b", "3_1", "3_2", "3_3", "3_4", "3_5", "3_6", "4", "4_1", "5", "5_1", "6a", "6", "6_1", "2g_2a", "2j", "2j_1", "2j_2", "2j_3", "2k", "8", "8_1", "8_2", "10b", "10b_1", "10b_2", "10b_3", "10b_4", "16", "16_1", "17", "17_1", "17_2", "17_3","17_4","17_4a", "18_1", "19", "19_1", "20", "20_1", "20_2", "22","30_1","30_2","23","23_1","2o","2o_1","31","31_1","59");
$arrNoHeader = array("6","6_1"); //不列印住民資訊抬頭
$arrNoMagic = array("6");
$arrNoResidentList = array("6_1");
?>

<div onclick="closecol();" style="width:100%">
<div ondblclick="closeResidentCol();">
<?php
if (!in_array($_GET['id'],$arrNoHeader)) {
?>
<div class="content-query2" style="margin:0 auto;">
<table align="center" cellpadding="5" style="font-size:10pt; margin: 0px auto;">
  <tr id="backtr" style="border:none; height:28px;">
    <?php
	if (@$_GET['id']!=NULL) {
		if ($_SESSION['ncareGroup_lwj']!=4) {
			echo '<td class="backbtnn" align="center" width="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'">'.$word_Back.'</a></td>';
		} else {
			echo '<td class="backbtnn" align="center" bgcolor="#ffffff" width="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?func=medlist" style="font-size:14px;">Resident List</a></td>';
		}
	}else{
		if ($_SESSION['ncareGroup_lwj']!=4) {
			echo '<td class="backbtnn" align="center" width="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?func=patientlist" style="font-size:14px;">Resident List</a></td>';
		} else {
			echo '<td class="backbtnn" align="center" bgcolor="#ffffff" width="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?func=medlist" style="font-size:14px;">Resident List</a></td>';
		}
	}
	?>
    <td class="title"  style="border-top-left-radius:10px; background-color:#EECB35;"><?php echo $word_Bed; ?></td>
    <td  style="border:none; padding-left: 10px;"><?php echo $bedID; ?></td>
    <td class="title"  style="border:none;"><?php echo $word_Name; ?></td>
    <td  style="border:none; padding-left: 10px;"><?php echo $name; ?></td>
    <td class="title"  style="border:none;"><?php echo $word_CareID; ?></td>
    <td  style="border:none; padding-left: 10px;"><?php echo getHospNoDisplayByHospNo($HospNo); ?></td>
    <td  class="title" style="border:none;"><?php echo $word_AdmissionDate; ?></td>
    <td  style="border:none; padding-left: 10px;"><?php echo $indate; ?></td>    
    <td class="title"  style="border:none;"><?php echo $word_DOB; ?></td>
    <td  style="border-top-right-radius:10px; padding-left: 10px;"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
  </tr>
  <tr style="border:none; height:28px;">  <!-- 診斷 + Jump to + 時間 + Print -->
    <?php
	if ($db_remind->num_rows()>0) {
		echo '
		<td class="title" style="background-color:#b79810;">'.$word_Diagnosis.'</td>
		<td style="padding-left: 10px;" colspan="9">'.$diagMsg.'</td>
		';
	}else{
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
	                	$tablename = mysql_escape_string($_GET['mod']).$formID;
	                	$db = new DB;
	                	$db->query("SELECT * FROM `".$tablename."` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
	                	for ($i=0;$i<$db->num_rows();$i++) {
	   	                	$r = $db->fetch_assoc();
		                	echo '<option value="'.$r['date'].($formID=="02g_2" || $formID=="13" || $formID=="2n"?"_".$r['no']:"").'" >'.formatdate($r['date']).($formID=="02g_2" || $formID=="13" || $formID=="2n"?" (".$r['no'].")":"").'</option>';
	                	}
			        	echo '
						<option value="" >[New record]</option>
	                	</select>';
		        	}
					if (in_array(@$_GET['id'],$arrNoSelDate)) {
						echo '<a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank" style="margin-left:5px;"><input type="button"  value="Print" style="background:rgb(149,219,208); color:white; font-size:15.35px; display:inline-block; padding:3px; border-radius:8px; border:1px; outline: none; width:60px;"></a>';
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
				if (in_array(@$_GET['id'],$arrNoSelDate)) {
					echo '<a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank" style="margin-left:5px;"><input type="button"  value="Print" style="background:rgb(149,219,208); color:white; font-size:15.35px; display:inline-block; padding:3px; border-radius:8px; border:1px; outline: none; width:60px;"></a>';
				}
				echo '</td>';
        	}
		}else{
			echo '<td style="border-bottom-right-radius:10px; padding-left: 10px;" colspan="9">'.$diagMsg.'</td>';
		}
	}
	?>
  </tr>
  <?php      /* 備忘錄 + Jump to + 時間 + Print */
  if ($db_remind->num_rows()>0) {
	  if(substr($url[3],0,5)!="print"){
		  if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
			  echo '
		      <tr class="printcol">
	            <td class="title" width="70" style="border:none; background-color:#e87217; border-bottom-left-radius:10px;">'.$word_Reminders.'</td>
	            <td style="border:none;" colspan="7"><marquee scrollamount="3">'.$marqueetext.'</marquee></td>
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
	                	$tablename = mysql_escape_string($_GET['mod']).$formID;
	                	$db = new DB;
	                	$db->query("SELECT * FROM `".$tablename."` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
	                	for ($i=0;$i<$db->num_rows();$i++) {
	   	                	$r = $db->fetch_assoc();
		                	echo '<option value="'.$r['date'].($formID=="02g_2" || $formID=="13" || $formID=="2n"?"_".$r['no']:"").'" >'.formatdate($r['date']).($formID=="02g_2" || $formID=="13" || $formID=="2n"?" (".$r['no'].")":"").'</option>';
	                	}
			        	echo '
						<option value="" >[New record]</option>
	                	</select>';
		        	}
					if (in_array(@$_GET['id'],$arrNoSelDate)) {
						echo '<a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank" style="margin-left:5px;"><input type="button"  value="Print" style="background:rgb(149,219,208); color:white; font-size:15.35px; display:inline-block; padding:3px; border-radius:8px; border:1px; outline: none; width:60px;"></a>';
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
		  }
	  }
  }
  ?>
</table>
</div>
<?php
}
?>

<?php  /* 表單下移 */
if (!in_array($_GET['id'],$arrNoHeader)) {
    if($db_remind->num_rows()>0) {
	    echo '<div id="printbtn2" style="padding-top:106px;"></div>';
    }else{
	    echo '<div id="printbtn2" style="padding-top:72px;"></div>';
    }
}
?>

<!-- 原廠魔力 jump to + 時間 + 列印 -->
<?php
if (@$_GET['id']!=NULL) {
    if(in_array($_GET['id'],$arrNoHeader)){
		if(!in_array($_GET['id'],$arrNoMagic)){
	        echo '<div id="printbtn" class="content-formview">';
		    if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){  /*== 居民判斷 ==*/
			    if (!in_array(@$_GET['id'],$arrNoResidentList)) {
		        echo '<div>';
			    ?><input class="residentListButton" type="button" onclick="$('#ResidentCol').show('slide', {direction: 'left'}, 500);" value="Resident List"><?php
	            echo '</div>';
				}
		    }

	        if (!in_array(@$_GET['id'],$arrNoSelDate)) {
		        echo '
			    <div>
	            <select id="inputeddate" onchange="gotoselecteddate();" style="font-size:14px;">
	            <option>Please select record date</option>';
	            $formID = mysql_escape_string($_GET['id']);
	            if (strlen((int)$formID)==1) {
	   	            $formID = '0'.$formID;
	            }
	            $tablename = mysql_escape_string($_GET['mod']).$formID;
	            $db = new DB;
	            $db->query("SELECT * FROM `".$tablename."` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
	            for ($i=0;$i<$db->num_rows();$i++) {
	   	            $r = $db->fetch_assoc();
		            echo '<option value="'.$r['date'].($formID=="02g_2" || $formID=="13" || $formID=="2n"?"_".$r['no']:"").'" >'.formatdate($r['date']).($formID=="02g_2" || $formID=="13" || $formID=="2n"?" (".$r['no'].")":"").'</option>';
	            }
			    echo '
			    <option value="">[Add new record]</option>
	            </select>
			    </div>';
		    }
		    if (in_array(@$_GET['id'],$arrNoSelDate)) {
		        echo '
		        <div class="printcol nurseformPrint">
	            <a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank"><img src="Images/print.png" border="0"></a>
	            </div>';
		    }
            echo '</div>';
	    }
    }
}
?>
<?php
include("Language_Form.php");

if ($_GET['id']=="2g_2"){
	if (substr($url[3],0,5)!="print"){
		include("form2g_2b.php");
	}
}
if ($_GET['id']=="2n"){
	if (substr($url[3],0,5)!="print"){
		include("form2n_2.php");
	}
}
?>
</div>
<table border="0" align="center" style="text-align:center; margin:0 auto 30px auto; width:100%;" onclick="closeResidentCol();">
  <tr>
    <td style="border:none;" colspan="3">
    <?php
	if (@$_GET['id']!=NULL) {
		if (!in_array(@$_GET['id'],$arrNoSelDate)) {
	        $formID = mysql_escape_string($_GET['id']);
	        if (strlen((int)$formID)==1) {
	   	    	$formID = '0'.$formID;
	        }
			$tablename = mysql_escape_string($_GET['mod']).$formID;
			$db = new DB;

			if ($_GET['id']=="2g_2" || $_GET['id']=="2n"){
				$db->query("SELECT * FROM `".$tablename."` WHERE `HospNo`='".$HospNo."' AND `no`='".(int)$_GET['no']."' ORDER BY `date` DESC");
			}else{
				$db->query("SELECT * FROM `".$tablename."` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
			}
			echo '<center><div id="tabs" style="padding-top:12px; width:100%;">'."\n";  /*=== YOYOYO =====*/

			echo '<ul class="printcol">'."\n";
			if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){  /*== 居民判斷 ==*/
			    if ($_GET['date']!="") { //網頁的id是否在裡面
				    $arrVar2 = explode("_",$_GET['date']);
				    echo '<li><a href="#tabs-0">Edit record<br>'.formatdate($arrVar2[0]).($formID=="02g_2" || $formID=="13" || $formID=="2n"?" - (".$arrVar2[1].")":"").'</a></li>'."\n";
			    } else {
				    echo '<li><a href="#tabs-0">New record</a></li>'."\n";
			    }
			}
			$arrDate = array();
			for ($i=1;$i<=$db->num_rows();$i++) {
				$r = $db->fetch_assoc();
				$tmpDate = $r['date'];

				if($formID=="02g_2" || $formID=="13" || $formID=="02n"){$no=" - (NO.".$r['no'].')'; $arrDate[$i] = $r['date'].'_'.$r['no']; }else{ $no=""; $arrDate[$i] = $r['date'];}

				echo '<li><a href="#tabs-'.$i.'">'.formatdate($r['date']).$no.(checkusername($r['Qfiller'])==""?"":"<br>".checkusername($r['Qfiller'])).'</a>';
				if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){  /*== 居民判斷 ==*/
				if (abs(calcperiod($r['date'], date(Ymd)) <= 5 && $r['Qfiller']==$_SESSION['ncareID_lwj']) || $_SESSION['ncareLevel_lwj']>=4) {
					echo ' <span class="ui-icon ui-icon-close" role="presentation" title="刪除資料" id="'.$_GET['mod'].$formID.'-'.$HospNo.'-'.$tmpDate.'-'.$r['no'].'">刪除資料</span>';
				}
				}
				echo '</li>';
	        }
			echo '</ul>'."\n";
			if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){  /*== 居民判斷 ==*/
			echo '<div id="tabs-0" class="nurseform-table" style="padding:1px; font-size:11pt;">';
			$tabsID=0;
			if (!in_array(@$_GET['id'],$arrNoSelDate)) { echo '<div style="position:absolute; right:14px; top:57px;" class="printcol"><a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank"><img src="Images/print.png" border="0"></a></div>'; }
			$act = "";
			if (is_file("form".$_GET['id']."_".$_SESSION['nOrgID_lwj'].".php")) {
				include("form".$_GET['id']."_".$_SESSION['nOrgID_lwj'].".php");
			} else {
				include("form".@$_GET['id'].".php");
			}
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
					$('#tabs-<?php echo $k; ?> div[id^="control"]').each( function () {
						var cell = $(this);
						var cell_id = $(this).attr('id');
						$(this).attr('id', cell_id+'_<?php echo $v; ?>');
						//alert(cell_id+'_<?php echo $v; ?>');
					});
					$('#tabs-<?php echo $k; ?> :input[id^="Qdeg"]').each( function () {
                        var cell = $(this);
						var cell_id = $(this).attr('id');
						var control_id = cell_id.replace('Qdeg', 'control');
						$(this).attr('id', cell_id+'_<?php echo $v; ?>');
						$('#'+control_id+'_<?php echo $v; ?>').knobKnob({
							snap : 0,
							value: $('#'+cell_id+'_<?php echo $v; ?>').val(),
							turn: function (ratio) {
								var degree = Math.round(360*ratio);
								$('#'+cell_id+'_<?php echo $v; ?>').val(degree);
							}
						});
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
					$("#tabs-<?php echo $k; ?> div[id=myFile]").each( function () {
                        $(this).remove();
                    });
					$("#tabs-<?php echo $k; ?> span[id^=txtDel]").each( function () {
                        $(this).remove();
                    });
                });
                </script>
                <?php
				echo '<div id="tabs-'.$k.'" class="nurseform-table" style="padding:1px;">';
				$tabsID=1;
				if ($formID=="02g_2" || $formID=="02n") {
					$_GET['date']=$v;
					$act = "view";
				} else { @$_GET['date']=$v; }
				if (!in_array(@$_GET['id'],$arrNoSelDate)) { echo '<div style="position:absolute; right:14px; top:57px;" class="printcol"><a href="print.php?'.$_SERVER['QUERY_STRING'].'&date='.$v.'" target="_blank"><img src="Images/print.png" border="0"></a></div>'; }
				if (is_file("form".$_GET['id']."_".$_SESSION['nOrgID_lwj'].".php")) {
					include("form".$_GET['id']."_".$_SESSION['nOrgID_lwj'].".php");
				} else {
					include("form".@$_GET['id'].".php");
				}
				echo '</div>';
			}
			echo '</div></center>'."\n";
            if($formID=="18"){ include("form18_1.php");}
		} else {
			echo '<center><div class="nurseform-table formNoSelDate">';
			if (is_file("form".$_GET['id']."_".$_SESSION['nOrgID_lwj'].".php")) {
				include("form".$_GET['id']."_".$_SESSION['nOrgID_lwj'].".php");
			} else {
				include("form".@$_GET['id'].".php");
			}
			if($_GET['id']=="17" && substr($url[3],0,5)!="print"){ include("form17a.php");}
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
if (substr($url[3],0,5)!="print" && !in_array($_GET['id'],$arrNoHeader)) {
	echo '<div id="ResidentCol" align="left">';
	echo '<div align="center" style="background-color:#eecb35; border-radius:10px; padding:7px; margin-bottom:20px;"><font style="color:white; font-size:26px; font-weight:bold;">Resident List</font></div>';
	include("ResidentCol.php");
	echo '</div>';
	echo '<script type="text/javascript" src="js/closeResidentCol.js"></script>';
}
if (substr($url[3],0,5)!="print" && substr($_SESSION['ncareID_lwj'],0,8)!="resident" && $_GET['pid']!=""){
	include("EasyWork_slider.php");
	echo '<script type="text/javascript" src="js/WYJ_slider9.js"></script>';
}
?>
<script type="text/javascript" src="js/LWJ_deleteform.js"></script>
<script type="text/javascript" src="js/LWJ_CheckRound.js"></script>
<script>
$(function() {
	$('#control').knobKnob({
		snap : 0,
		value: $('#Qdeg').val(),
		turn: function (ratio) {
			var degree = Math.round(360*ratio);
			$('#Qdeg').val(degree);
		}
	});
	$('#control2').knobKnob({
		snap : 0,
		value: $('#Qdeg2').val(),
		turn: function (ratio) {
			var degree2 = Math.round(360*ratio);
			$('#Qdeg2').val(degree2);
		}
	});
	$('#control3').knobKnob({
		snap : 0,
		value: $('#Qdeg3').val(),
		turn: function (ratio) {
			var degree3 = Math.round(360*ratio);
			$('#Qdeg3').val(degree3);
		}
	});
});
</script>