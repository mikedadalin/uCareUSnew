<h3>Prescription record</h3>
<script>
$(function() {
	var medicine = $("#medicine").val();
    $( "#AllergicDrug-form" ).dialog({
		autoOpen: false,
		height: 210,
		width: 480,
		modal: true,
		buttons: {
			"Add allergic drug": function() {
				$.ajax({
					url: "class/allergicmed.php",
					type: "POST",
					data: {"HospNo": $("#HospNo").val(), "drugName":$("#drugName").val() },
					success: function(data) {
						var arrData = data.split(':');
						$( "#AllergicDrugrecordlist tbody" ).append( "<tr>" + "<td>" + arrData[1] + ".</td>" + "<td>" + arrData[0] + "</td>" +  "</tr>" );
						$( "#AllergicDrug-form" ).dialog( "close" );
						alert("已經成功新增過敏藥物！");
					}
				});
			},
			"Cancel": function() {
				$( this ).dialog( "close" );
			}
		}
	});
});
$(function() {
    $( "#dialog-qa" ).dialog({
		autoOpen: false,
		height: 680, //760
		width: 900,
		modal: true,
		buttons: {
			"New drug treatment assessment and consultation": function() {
				$.ajax({
					url: "class/qamed.php",
					type: "POST",
					data: {"HospNo": $("#HospNo").val(), "Qmedicine":$("#Qmedicine").val(), "question":$("#question").val(),
					'Qfiller': $("#Qfiller").val(),
					'Q1_1': $('#Q1_1').val(),'Q1_2': $('#Q1_2').val(),'Q1_3': $('#Q1_3').val(),'Q1_4': $('#Q1_4').val(),
					'Q1_5': $('#Q1_5').val(),'Q1_6': $('#Q1_6').val(),'Q1_7': $('#Q1_7').val(),'Q1_8': $('#Q1_8').val(),
					'Q1_9': $('#Q1_9').val(),'Q1_10': $('#Q1_10').val(),
					'Q2_1': $('#Q2_1').val(),'Q2_2': $('#Q2_2').val(),'Q2_3': $('#Q2_3').val(),
					'Q3_1': $('#Q3_1').val(),'Q3a': $('#Q3a').val(),'Q4_1': $('#Q4_1').val(),
					'Q4_2': $('#Q4_2').val(),'Q4_3': $('#Q4_3').val()
					},
					success: function(data) {
						$( "#dialog-qa" ).dialog( "close" );
						alert(data);
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$( this ).dialog( "close" );
			}
		}
	});
});
function newquestion(i){
	$("#Qmedicine").val(i);
	$( "#dialog-qa" ).dialog( "open" );
}

function loadMedNames(id){
	var medicine= $("#"+id).val();
	var medList = "";
	$.ajax({
		url: 'class/med.php',
		type: "POST",
		async: false,
		data: { med: medicine}
	}).done(function(meds){
		medList = meds.split(',');
	});
	return medList;
}
function autocompleteMeds(id){
	var meds = loadMedNames(id);
	$("#"+id).autocomplete({ source: meds, minLength:3 });
}
</script>
<div id="AllergicDrug-form" title="Add allergic drug" class="dialog-form"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title">Medication</td>
        <td><input type="text" name="drugName" id="drugName" value="" class="text ui-widget-content ui-corner-all" size="40" onkeyup="autocompleteMeds(this.id)" onclick="autocompleteMeds(this.id)"/></td>
      </tr>
    </table>
  </fieldset>
  </form>
</div>
<div id="dialog-qa" title="New drug treatment assessment and consultation" class="dialog-form">
	<form>
    	<table>
        	<tr>
            	<td class="title">Medication</td>
                <td><input type="text" name="Qmedicine" id="Qmedicine" size="40"> </td>
            </tr>
        	<tr>
            	<td class="title">Drug treatment issues</td>
                <td style="border:1px solid #999;"><?php echo draw_checkbox_2col("Q1","No indications;Have untreated disease(s);Contraindications or precautions;Formulations / dosage or frequency need to adjust;Drug-drug interaction;Repeated drug;Adverse drug reactions;Inappropriate treatment;Drugs health education;Drug expired(Please continue to fill)",$Q1,"multi"); ?><div style="margin-left:50px;"><?php echo draw_checkbox("Q2","Incorrect administration time (interval, before/after meal);Fail to comply with the special administration instructions (with food, flour, mix, open capsules, with one other solution);Drug dose to inappropriate (excessive or insufficient)",$Q2,"multi");?></div><?php echo draw_checkbox_2col("Q3","Other <input type=\"text\" id=\"Q3a\" name=\"Q3a\">",$Q3,"multi");?></td>
            </tr>
        	<tr>
            	<td class="title">Information source</td>
                <td  style="border:1px solid #999;"><?php echo draw_checkbox_nobr("Q4","Pharmacist personally visit;Phone;e-mail;Fax",$Q4,"multi");?></td>
            </tr>
        	<tr>
            	<td class="title">Problems description</td>
                <td><textarea name="question" id="question" rows="4"></textarea></td>
            </tr>
        </table>
        <input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
    </form>
</div>
<?php
$db1 = new DB;
$db1->query("SELECT * FROM `medintake` WHERE `HospNo`='".$HospNo."';");
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		if (substr($k,0,1)=="Q") {
			$arrAnswer = explode("_",$k);
			if (count($arrAnswer)==2) {
				if ($v==1) {
					${$arrAnswer[0]} .= $arrAnswer[1].';';
				}
			} else {
				${$k} = $v;
			}
		}  else {
			${$k} = $v;
		}
	}
}
?>
<table width="100%" class="printcol">
  <tr>
    <?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
    <td style="background:#ffffff;" width="250"><form><input type="button" value="New medication" onclick="window.location.href='index.php?mod=nurseform&func=formview&pid=<?php echo @$_GET['pid']; ?>&id=17_1';" /><input type="button" id="newAllergicrecord" name="newAllergicrecord" value="Add allergic drug" onclick="openVerificationForm('#AllergicDrug-form');" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /></form></td>
    <td style="background:#ffffff;" align="center"><form action="index.php?func=medintake" method="post"><?php echo draw_option("Qintake","Powdery;NG","xs","multi",$Qintake,false,5); ?><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><input type="submit" value="Save" /></form></td>
	<?php }?>
    <td style="background:#ffffff;" align="right"><!--<form><input type="button" value="給藥紀錄" onclick="window.location.href='index.php?mod=nurseform&func=formview&pid=<?php echo @$_GET['pid']; ?>&id=17_2';" /></form>-->
    Medication Record:
	<select id="selmonth">
			<option>--Select month--</option>
			<?php
			$nextmonth = date(m)+1; if ($nextmonth>12) { $nextmonth = 1; $nextyear = date(Y)+1; } else { $nextyear = date(Y); }
			if (strlen($nextmonth)==1) { $nextmonth = "0".$nextmonth; }
			echo '<option value="'.$nextyear.$nextmonth.'">'.$nextyear.'-'.$nextmonth.'</option>'."\n";
			for ($i=date(m);$i>=(date(m)-5);$i--) {
				$month = $i;
				$year = date(Y);
				if ($i<1) {
					$month = 12+$i;
					$year = date(Y)-1;
				}
				if (strlen($month)==1) {
					$month = "0".$month;
				}
				echo '<option value="'.$year.$month.'">'.$year.'-'.$month.'</option>'."\n";
			}
			?>
		</select>
		<input type="image" src="Images/print.png" onclick="printmed('<?php echo @$_GET['pid']; ?>', '<?php echo ($_SESSION['ncaremedFormat_lwj']==""?"1":$_SESSION['ncaremedFormat_lwj']); ?>')">
		<script>
		function printmed(pid, no) {
			var selectedmonth = document.getElementById('selmonth').value;
			window.open('printmed'+no+'.php?pid='+pid+'&date='+selectedmonth, '_blank' );
		}
		</script>
        </td>
  </tr>
</table>
<table width="100%">
  <tr class="title">
    <td width="10%" class="printcol">&nbsp;</td>
    <td width="120" class="printcol">Sort</td>
    <td>Date</td>
    <td>Time</td>
    <td>Medication</td>
    <td>Dose</td>
    <td>Frequency</td>
    <td>Pathway</td>
	<td>Doctor</td>
	<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
    <td width="6%" class="printcol">&nbsp;</td>
	<?php }?>
  </tr>
<?php
$db = new DB;$db->query("SELECT * FROM `nurseform17` WHERE `HospNo`='".$HospNo."' ORDER BY `order` ASC");
for ($j=1;$j<=$db->num_rows();$j++) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) { ${$k} = $v; }
	echo '
  <tr>
    <td class="printcol"><center>';
	if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
	echo '<input type="image" src="Images/comments.png" onclick="newquestion(\''.$Qmedicine.'\');" title="New drug treatment assessment and consultation" alt="New drug treatment assessment and consultation"/>';
	}
	echo '
	<a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'&id=17_3&date='.$date.'&order='.$order.'" ><img src="Images/select.png"></a></center></td>
	<td class="printcol"><center>';
	  if ($j!=1) { echo '<a href="medorder.php?HospNo='.$HospNo.'&action=upper&order='.$r['order'].'" target="_blank"><span class="goUpper">UPPER</span></a>'; }
	  if ($j!=($db->num_rows()-0)) { echo '<a href="medorder.php?HospNo='.$HospNo.'&action=lower&order='.$r['order'].'" target="_blank"><span class="goLower">LOWER</span></a>'; }
	echo '
	</center></td>
    <td><center>'.$Qstartdate.'~'.$Qenddate.' ('.calcperiod(str_replace('/','',$Qstartdate),str_replace('/','',$Qenddate)).'Day(s))</center></td>
	<td><center>';
        $Qtime = explode(";",$Qmedtime);
        for ($i=0;$i<count($Qtime);$i++) {
            if ($Qtime[$i]!="") {
	 	if (strlen($Qtime[$i])==1) {
			$Time = "0".$Qtime[$i].":00";
		} else {
			$Time = $Qtime[$i].":00";
		}
	 	echo $Time;
		if ($i<(count($Qtime)-2)) {
			echo ' / ';
		}
	 }
        }
	echo '</center></td>
    <td><center>'.$Qmedicine.' ('.$Qdose.$Qdoseq.')</center></td>
    <td><center>'.$Qusage.'</center></td>
    <td><center>'.$Qfreq.'</center></td>
    <td><center>'.$Qway.'</center></td>
	<td><center>'.$Qdoctor.'</center></td>';
	if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){
	echo '<td width="6%" class="printcol"><center><a href="index.php?mod=nurseform&func=formdelete17&pid='.mysql_escape_string($_GET['pid']).'&date='.$date.'&dID='.$drugID.'"><img src="Images/delete2.png" border="0"></a></center></td>';
	}
	echo '
  </tr>'."\n";
 }
 ?>

</table>
<hr />
<?php
if (isset($_POST['savesuggestion'])) {
	$db1c = new DB;
	$db1c->query("SELECT * FROM `medsuggest` WHERE `HospNo`='".$HospNo."' AND `date`='".date(Ym)."'");
	if ($db1c->num_rows()==0) {
		$db1c = new DB;
		$db1c->query("INSERT INTO `medsuggest` VALUES ('".$HospNo."', '".date(Ym)."', '".mysql_escape_string($_POST['suggestion'])."', '".$_SESSION['ncareID_lwj']."');");
	} else {
		$db1c = new DB;
		$db1c->query("UPDATE `medsuggest` SET `suggestion`='".mysql_escape_string($_POST['suggestion'])."', `Qfiller`='".$_SESSION['ncareID_lwj']."' WHERE `HospNo`='".$HospNo."' AND `date`='".date(Ym)."'");
	}
}

$sql = "SELECT * FROM `medsuggest` WHERE `HospNo`='".mysql_escape_string($HospNo)."'";
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		if (substr($k,0,1)=="Q") {
			$arrAnswer = explode("_",$k);
			if (count($arrAnswer)==2) {
				if ($v==1) {
					${$arrAnswer[0]} .= $arrAnswer[1].';';
				}
			} else {
				${$k} = $v;
			}
		}  else {
			${$k} = $v;
		}
	}
}
if($_SESSION['nhomecare']==1){
?>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
    <table width="100%">
        <tr>
            <td class="title" width="120">服藥協助</td>
            <td><?php echo draw_checkbox_nobr("Q1","自行服用;需督促;需人協助給予;Other:<input type=\"text\" id=\"Q1a\" name=\"Q1a\" \" value=\"".$Q1a."\">",$Q1,"single"); ?></td>
        </tr>
        <tr>
            <td class="title">服藥遵從</td>
            <td><?php echo draw_checkbox_nobr("Q2","無用藥;完全正確用藥;能80%以上依指示;少於80%依指示;完全不依指示用藥;Other:<input type=\"text\" id=\"Q2a\" name=\"Q2a\" \" value=\"".$Q2a."\">",$Q2,"single"); ?></td>
        </tr>
        <tr>
            <td class="title">服藥反應</td>
            <td><?php echo draw_checkbox_nobr("Q3","無服藥;藥物副作用<input type=\"text\" id=\"Q3a\" name=\"Q3a\" value=\"".$Q3a."\">;血中濃度測定:<input type=\"text\" id=\"Q3b\" name=\"Q3b\" \" value=\"".$Q3b."\">",$Q3,"single"); ?></td>
        </tr>
    </table>
    <input type="hidden" name="url" id="url" value="index.php?mod=nurseform&func=formview&pid=<?php echo $pid;?>&id=17">
	<input type="hidden" name="formID" id="formID" value="medsuggest1" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><input type="submit" id="submit" value="更新" />
</form>
<hr />
<?php }?>
<table width="100%">
  <tr class="title">
    <td>Medication recommendations of this month</td>
  </tr>
  <tr>
    <td>
    <?php
	$db1 = new DB;
	$db1->query("SELECT * FROM `medsuggest` WHERE `HospNo`='".$HospNo."' AND `date`='".date(Ym)."'");
	$r1 = $db1->fetch_assoc();
	if ($_SESSION['ncareGroup_lwj']==4) {
	?>
    <form action="index.php?mod=nurseform&func=formview&pid=<?php echo @$_GET['pid']; ?>&id=17" method="POST">
    <textarea cols="110" rows="5" name="suggestion"><?php echo $r1['suggestion']; ?></textarea><br />
    <input type="submit" value="Save" name="savesuggestion" />
    </form>
    <?php
	} else {
		echo $r1['suggestion'];
	}
	?>
    </td>
  </tr>
</table>
<hr />
<table width="100%">
  <tr class="title">
    <td>Medication recommendations of last month</td>
  </tr>
  <tr>
    <td>
    <?php
	$lastmonth = date(m)-1;
	if ($lastmonth==0) { $lastmonth = 12; $lastyear = date(Y)-1; } else { $lastyear = date(Y); }
	if (strlen($lastmonth)==1) { $lastmonth = "0".$lastmonth; }
	$lastdate = $lastyear.$lastmonth;
	$db1b = new DB;
	$db1b->query("SELECT * FROM `medsuggest` WHERE `HospNo`='".$HospNo."' AND `date`='".$lastdate."'");
	$r1b = $db1b->fetch_assoc();
	echo $r1b['suggestion'];
	?>
    </td>
  </tr>
</table>
<table width="100%" id="AllergicDrugrecordlist">
  <tbody>
  <tr class="title">
    <td colspan="2">Allergic drug</td>
  </tr>
	<?php
    $db_amed = new DB;
	$db_amed->query("SELECT * FROM `allergicmed` WHERE `HospNo`='".$HospNo."' Order By `drugID` ASC");
	for ($i=0;$i<$db_amed->num_rows();$i++) {
		$amed = $db_amed->fetch_assoc();
		echo '
  <tr>
    <td width="40">'.($i+1).'.</td>
	<td>'.$amed['DrugName'].'</td>
  </tr>'."\n";
    }
	?>
  </tbody>
</table>
<table width="100%" id="recordlist">
  <tbody>
  <tr class="title">
    <td colspan="3">Medication advice</td>
  </tr>
  <tr>
  	<td class="title_s">Medication</td>
    <td class="title_s">Problems description</td>
    <td class="title_s">&nbsp;</td>
  </tr>
	<?php
    $db_amed = new DB;
	$db_amed->query("SELECT * FROM `medicineq` WHERE `HospNo`='".$HospNo."' Order By `date` DESC");
	for ($i=0;$i<$db_amed->num_rows();$i++) {
		$amed = $db_amed->fetch_assoc();
		echo '
  <tr>
    <td><center>'.$amed['Qmedicine'].'</center></td>
	<td><center>'.$amed['question'].'</center></td>
	<td><center><form><input type="button" value="View" id="view_'.$amed['qID'].'"></form></center></td>
  </tr>'."\n";
	$db1 = new DB;
	$db1->query("SELECT * FROM `medicinea` WHERE `qID`='".$amed['qID']."' ORDER BY `date` DESC");
	if ($db1->num_rows()>0) {
		echo '
		<tr>
		  <td colspan="6" align="right">
		    <table style="width:850px;" id="show_'.$amed['qID'].'">
			<tr style="height:14px;">
			  <td width="100" style="background:#21689F; color:#fff; border:2px solid #21689F; padding:4px;">Reply date</td>
			  <td width="690" style="background:#21689F; color:#fff; border:2px solid #21689F; padding:4px;">Advice</td>
		      <td width="60" style="background:#21689F; color:#fff; border:2px solid #21689F; padding:4px;">Print</td>
			</tr>'."\n";
		for ($i1=0;$i1<$db1->num_rows();$i1++) {
			$r1 = $db1->fetch_assoc();
			foreach ($r1 as $k=>$v) {
				$arrPatientInfo = explode("_",$k);
				if (count($arrPatientInfo)==2) {
					if ($v==1) {
						${$arrPatientInfo[0]} .= $arrPatientInfo[1].';';
					}
				} else {
					${$k} = $v;
				}
			}
			echo '
			<tr style="height:14px;">
			  <td width="100" style="background:#fff; border:2px solid; padding:4px;">'.$date.'</td>
			  <td width="690" style="background:#fff; border:2px solid; padding:4px;">Advice:'.checkbox_result("Q1","會診醫師更改藥物劑量或頻次：".$Q1a.";會診醫師更改藥物或劑型：".$Q1b.";會診醫師停藥或改其他藥：".$Q1c.";進行藥物血中濃度監測：".$Q1d.";繼續維持目前用藥情形;住民服藥應注意事項：".$Q1e." ",$Q1,"multi").'<br><br>References:'.checkbox_result("Q2","仿單;藥品手冊;參考書籍(或文獻)：",$Q2,"multi").$answer.'</td>
			 <td width="60" align="center" style="background:#fff; border:2px solid; padding:4px;"><a href="print.php?mod=nurseform&func=printform17&pid='.$_GET['pid'].'&qid='.$r1['qID'].'&aid='.$r1['aID'].'" target="_blank" title="藥物治療評估諮詢單"><img src="Images/printer.png" width="30"></a></td>
			</tr>
			'."\n";
			$Q1="";
			$Q2="";
			$Q1a="";
			$Q1b="";
			$Q1c="";
			$Q1d="";
			$Q1e="";
		}
		echo '
			</table>
		  </td>
		</tr>'."\n";
	} else{
		echo '
		<tr>
		  <td colspan="6" align="right">
		    <table style="width:850px;" id="show_'.$amed['qID'].'">
			<tr style="height:14px;">
			  <td width="850" style="background:#fff; color:#21689F; border:2px solid #21689F; padding:4px;">尚未回覆</td>
			</tr>'."\n";
		echo '</table></td>
		';
	}
    }
	?>
  </tbody>
</table><br><br>
<script>
$(function(){	
	$('table[id^="show_"]').hide();
	$('input[id^="view_"]').click(function(){
		var qid = this.id;
		qid = qid.split(/_/);
		$("#show_"+qid[1]).toggle();
	})
})
</script>