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

$arrNoSelDate = array("1a_4", "4", "4_1", "5", "6", "6a", "8", "8a", "8b", "8c", "8d", "8_1b", "9", "10", "10a", "10b", "10b_1", "10b_2", "10b_3", "10b_4", "11b", "15", "15_1","17","17_1","18","18_1", "19","19_1", "20", "20_1", "20_2", "21_2", "31");
$arrPrint = array("6a");  /*需要列印*/
$arrNoQueryCol = array("8", "8a", "8b", "8c", "8d", "8_1b");
?>
<div ondblclick="closeResidentCol();">
<?php
if (!in_array(@$_GET['id'],$arrNoQueryCol)) {
?>
<div class="content-query2">
<table align="center" style="width:100%; font-size:10pt; margin: 0px 0px;">
  <tr id="backtr" style="border:none; height:28px;">
    <?php
	if (@$_GET['id']!=NULL) {
		echo '<td class="backbtnn" align="center" width="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?mod=socialwork&func=formview&pid='.mysql_escape_string($_GET['pid']).'">'.$word_Back.'</a></td>'; 
	}else{
		echo '<td class="backbtnn" align="center" width="40" id="backbtn"  style="border:none;" rowspan="3"><a href="index.php?func=sociallist" style="font-size:14px;">Resident List</a></td>';
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
						if (@$_GET['share']==NULL) {
				            $tablename = 'socialform'.$formID;
			            } else {
				            $tablename = @$_GET['share'];
			            }
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
					if (in_array(@$_GET['id'],$arrPrint)) {
						echo '<a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank" style="margin-left:5px;"><input type="button"  value="Print" style="background:rgb(149,219,208); color:white; font-size:15.35px; display:inline-block; padding:3px; border-radius:8px; border:1px; outline: none; width:60px;"></a>';
					}
		    	}
				echo '</td>';
	    	}else{
				echo'
				<td style="padding-left: 10px;" colspan="8">'.$diagMsg.'</td>
				<td style="border-bottom-right-radius:10px; padding-left: 5px;">';
				if (in_array(@$_GET['id'],$arrPrint)) {
					echo '<a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank" style="margin-left:5px;"><input type="button"  value="Print" style="background:rgb(149,219,208); color:white; font-size:15.35px; display:inline-block; padding:3px; border-radius:8px; border:1px; outline: none; width:60px;"></a>';
				}
				echo '</td>';
        	}
		}else{
			echo '<td style="border-bottom-right-radius:10px; padding-left: 10px;" colspan="9">'.$diagMsg.'</td>';
		}
	?>
  </tr>
</table>
</div>
<?php
}
?>

<?php  /* 表單下移 */
if (!in_array($_GET['id'],$arrNoQueryCol)) {
	echo '<div id="printbtn2" style="padding-top:72px;"></div>';
}
?>

<!-- 原廠魔力  時間 + 列印-->
<?php
if (@$_GET['id']!=NULL) {
	if (in_array(@$_GET['id'],$arrNoQueryCol)) {
		echo '<div id="printbtn" class="content-formview">';
	    if (!in_array(@$_GET['id'],$arrNoSelDate)) {
			echo '
			<div>
			<a style="font-size:14px; font-weight:bolder; color:#e87217;">Substituting the saved data:</a>
	        <select id="inputeddate" onchange="gotoselecteddate();" style="font-size:14px;">
	        <option></option>';
	        $formID = mysql_escape_string($_GET['id']);
	        if (strlen((int)$formID)==1) {
	   	        $formID = '0'.$formID;
	        }
	        if (@$_GET['share']==NULL) {
				$tablename = 'socialform'.$formID;
			} else {
				$tablename = @$_GET['share'];
			}
	        $db = new DB;
	        $db->query("SELECT * FROM `".$tablename."` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
	        for ($i=0;$i<$db->num_rows();$i++) {
	   	        $r = $db->fetch_assoc();
		        echo '<option value="'.$r['date'].'">'.formatdate($r['date']).'</option>';
	        }
	        echo '
	        </select>
		    </div>';
		}
	    if (in_array(@$_GET['id'],$arrPrint)){
			echo '
			<div style="border:1px; position:absolute; left:1006px; top:8px; background-color:rgba(255,255,255,0.8); border-radius:5px;" class="printcol" id="nurseformPrint">
			<a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank"><img src="Images/print.png" border="0"></a>
			</div>'; 
		}
		echo '</div>';
	}
}
?>
<?php include("Language_Form.php"); ?>
<table border="0" style="width:100%; text-align:center;" onclick="closeResidentCol();">
  <tr>
    <td style="border:none;" colspan="3">
    <?php
	if (@$_GET['id']!=NULL) {
		if (!in_array(@$_GET['id'],$arrNoSelDate)) {
	        $formID = mysql_escape_string($_GET['id']);
	        if (strlen((int)$formID)==1) {
	   	    	$formID = '0'.$formID;
			}
			if ($formID=="01a_1") {
				$tablename = "nurseform01";
			} elseif ($formID=="01a_2") {
				$tablename = "nurseform01a";
			} elseif ($formID=="01a_3") {
				$tablename = "nurseform22";
			} else {
				$tablename = 'socialform'.$formID;
			}
			$db = new DB;
			$db->query("SELECT * FROM `".$tablename."` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
			echo '<div id="tabs" style="padding-top:12px; margin:0 auto; width:100%; text-align:center;">'."\n";
			echo '<ul class="printcol">'."\n";
			if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){  /*== 居民判斷 ==*/
			    if ($_GET['date']!="") {
				    $arrVar2 = explode("_",$_GET['date']);
				    echo '<li><a href="#tabs-0">Edit record<br>'.formatdate($arrVar2[0]).'</a></li>'."\n";
			    } else {
				    echo '<li><a href="#tabs-0">New record<br>&nbsp;</a></li>'."\n";
			    }
			}
			$arrDate = array();
			for ($i=1;$i<=$db->num_rows();$i++) {
				$r = $db->fetch_assoc();
				$tmpDate = $r['date'];
				echo '<li><a href="#tabs-'.$i.'">'.formatdate($r['date']).'<br>'.checkusername($r['Qfiller']).'</a>';
				if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){  /*== 居民判斷 ==*/
				if (abs(calcperiod($r['date'], date(Ymd)) <= 5 && $r['Qfiller']==$_SESSION['ncareID_lwj']) || $_SESSION['ncareLevel_lwj']>=4) {
					echo ' <span class="ui-icon ui-icon-close" role="presentation" title="刪除資料" id="'.$tablename.'-'.$HospNo.'-'.$tmpDate.'-'.$r['no'].'">刪除資料</span>';
				}
				}
				echo '</li>';
				$arrDate[$i] = $r['date'];
	        }
			echo '</ul>'."\n";
			if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){  /*== 居民判斷 ==*/
			echo '<div id="tabs-0" class="nurseform-table" style="padding:1px; font-size:11pt;"><center>';
			if (@$_GET['id']!=17 && @$_GET['id']!='8a' && @$_GET['id']!='8b' && @$_GET['id']!='8_1b' && @$_GET['id']!='8c' && @$_GET['id']!='21_1' && @$_GET['id']!='21_2') { echo '<div style="position:absolute; right:14px; top:57px;" class="printcol"><a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank"><img src="Images/print.png" border="0"></a></div>'; }
			include("form".@$_GET['id'].".php");
			echo '</center></div>';
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
				if (@$_GET['id']!=17 && @$_GET['id']!='8a' && @$_GET['id']!='8b' && @$_GET['id']!='8_1b' && @$_GET['id']!='8c' && @$_GET['id']!='21_1' && @$_GET['id']!='21_2') { echo '<div style="position:absolute; right:14px; top:57px;" class="printcol"><a href="print.php?'.$_SERVER['QUERY_STRING'].'&date='.$v.'" target="_blank"><img src="Images/print.png" border="0"></a></div>'; }
				include("form".@$_GET['id'].".php");
				echo '</div>';
			}
			echo '</div>'."\n";
		} else {
			echo '<div class="nurseform-table">';
			include("form".@$_GET['id'].".php");
			echo '</div>';
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
if (substr($url[3],0,5)!="print" && !in_array(@$_GET['id'],$arrNoQueryCol)) {
	echo '<div id="ResidentCol" align="left">';
	echo '<div align="center" style="background-color:#eecb35; border-radius:10px; padding:7px; margin-bottom:20px;"><font style="color:white; font-size:26px; font-weight:bold;">Resident List</font></div>';
	include("ResidentCol.php");
	echo '</div>';
	echo '<script type="text/javascript" src="js/closeResidentCol.js"></script>';
}
?>
<script type="text/javascript" src="js/LWJ_deleteform.js"></script>
<script>
	var lastScrollTop = 0;
	$('#content2').scroll(function(event){
		var st = $(this).scrollTop();
        if(Math.abs(lastScrollTop - st) <= 5)
        return;
    if (st > lastScrollTop && st > 90){
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