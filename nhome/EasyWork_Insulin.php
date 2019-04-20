<?php
  $Insulin_db3 = new DB;
  $Insulin_db3->query("SELECT * FROM `nurseform18_1` WHERE `HospNo`='".$HospNo."' ORDER BY `Qstartdate1` ASC, `Qmedtime1` ASC");
  for ($i=0;$i<$Insulin_db3->num_rows();$i++) {
    $Insulin_r3 = $Insulin_db3->fetch_assoc();
    if (($Insulin_db3->num_rows()-$i)<4) {
        $spantext3 .= '
          <tr>
            <td>'.formatdate($Insulin_r3['Qstartdate1']).'</td>
            <td>'.substr($Insulin_r3['Qmedtime1'],0,2).':'.substr($Insulin_r3['Qmedtime1'],2,2).'</td>
            <td>'.$Insulin_r3['QACvalue1'].'</td>
            <td>'.$Insulin_r3['Qmedicine1'].'</td>
            <td>'.$Insulin_r3['Qdose1']; if ($Insulin_r3['Qdose1']!="") { $spantext3 .= "Unit"; }
            $spantext3 .= '</td>
            <td>'.$Insulin_r3['Qpart1'].'</td>
          </tr>'."\n";
    }
        if ($Insulin_r3) {
            foreach ($Insulin_r3 as $k=>$v) {
              if (substr($k,0,1)=="Q") {
                $arrAnswer = explode("_",$k);
                if (count($arrAnswer)==2) {
                  if ($v==1) {
                    ${$arrAnswer[0]} = "";
                  }
                } else {
                  ${$k} = "";
                }
              }  else {
				  if($k!="HospNo"){
					  ${$k} = "";
				  }
              }
            }
        }
  }
?>
<script>
function downloadInsulin(){
	var medicine3= $("#Qmedicine3").val();
	var HospNo= $("#HospNo").val();
		$.ajax({
			url: "class/InsulinDownload.php",
			type: "POST",
			data: {"Qmedicine": medicine3 , "HospNo": HospNo},
			success: function(data) {
				var meddata = data.split('||');
				console.log(meddata);
				$('#Qmedicine3').val(meddata[0]);
				$('#Qdose3').val(meddata[1]);
			}
		});
}
</script>
<script>
$(function() {
    $( "#newrecordformInsulin" ).dialog({
        autoOpen: false,
        height: 680, //700
        width: 750,
        modal: true,
        buttons: {
            "New injection record": function() {
                $.ajax({
                    url: "class/nurseform18.php",
                    type: "POST",
                    data: {"HospNo": $("#HospNo").val(), "Qstartdate1": $("#Qstartdate3").val(), "Qmedtime1": $("#Qmedtime3").val(), "QACvalue1": $("#QACvalue3").val(), "Qmedicine1": $("#Qmedicine3").val(), "Qdose1": $("#Qdose3").val(), "Qpart1": $("#Qpart3").val(), "QNeedUseDate": $("#QNeedUseDate3").val(), "QNeedUseTime": $("#QNeedUseTime3").val(), "QInsulinRecordType": $("#QInsulinRecordType").val(), "Qfiller": $("#Qfiller").val()  },
                    success: function(data) {
                       $( "#newrecordformInsulin" ).dialog( "close" );
                       alert("New Insulin Injection Record");
                       window.location.reload();
                    }
                });
            },
            "Cancel": function() {
                $( "#newrecordformInsulin" ).dialog( "close" );
            }
        }
    });

	//#newUSErecord3_20151201_order_MedName_24HR
	$('button:button[id^="newUSErecord3_"]').click(function() {
		var w = $("#slider_content9").width();
		$("#slider_scroll9").animate( { right:'-'+w+'px' }, 600 ,'swing');
		openVerificationForm('#newrecordformInsulin');
		var arrID = $(this).attr('id');
		arrID = arrID.split('_');
		var NeedUseDate = arrID[1];
		var NeedUseTime = arrID[4];
		var needgiveMed = arrID[3];
		document.getElementById('QNeedUseDate3').value = NeedUseDate;
		document.getElementById('QNeedUseTime3').value = NeedUseTime;
		document.getElementById('Qmedicine3').value = needgiveMed;
		downloadInsulin();
	});
});
</script>
<div class="nurseform-table">
<?php
$arrPart = array(
    '1' => array('A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7', 'B8', 'C1', 'C2', 'C3', 'C4', 'C5', 'C6', 'C7', 'C8', 'D1', 'D2', 'D3', 'D4', 'D5', 'D6', 'D7', 'D8', 'E1', 'E2', 'E3', 'E4', 'E5', 'E6', 'E7', 'E8', 'F1', 'F2', 'F3', 'F4', 'F5', 'F6', 'F7', 'F8', 'G1', 'G2', 'G3', 'G4', 'G5', 'G6', 'G7', 'G8', 'H1', 'H2', 'H3', 'H4', 'H5', 'H6', 'H7', 'H8'),
    '2' => array('1A', '1B', '1C', '1D', '1E', '1F', '1G', '2A', '2B', '2C', '2D', '2E', '2F', '2G', '3A', '3B', '3C', '3D', '3E', '3F', '3G', '4A', '4B', '4C', '4D', '4E', '4F', '4G', '5A', '5B', '5C', '5D', '5E', '5F', '5G', '6A', '6B', '6C', '6D', '6E', '6F', '6G'),
    '3' => array('1A', '1B', '1C', '1D', '1E', '1F', '2A', '2B', '2C', '2D', '2E', '2F', '3A', '3B', '3C', '3D', '3E', '3F', '4A', '4B', '4C', '4D', '4E', '4F', '5A', '5B', '5C', '5D', '5E', '5F', '6A', '6B', '6C', '6D', '6E', '6F', '7A', '7B', '7C', '7D', '7E', '7F', '8A', '8B', '8C', '8D', '8E', '8F'),
    '4' => array('1A', '1B', '1C', '1D', '1E', '1F', '1G', '1H', '2A', '2B', '2C', '2D', '2E', '2F', '2G', '2H', '3A', '3B', '3C', '3D', '3E', '3F', '3G', '3H', '4A', '4B', '4C', '4D', '4E', '4F', '4G', '4H', '5A', '5B', '5C', '5D', '5E', '5F', '5G', '5H', '6A', '6B', '6C', '6D', '6E', '6F', '6G', '6H')
);
?>
<div name="newrecordformInsulin" id="newrecordformInsulin" title="New Insulin Injection Record" onclick="filloldrecord3()" class="dialog-form">
    <fieldset>
        <table>
            <tr>
                <td class="title">Record Type</td>
				<td colspan="3" style="font-size:22px;">
                  <select name="QInsulinRecordType" id="QInsulinRecordType">
	                 <option value="1">Drug delivered</option>
					 <option value="2">(NPO)</option>
					 <option value="3">(Ref)</option>
					 <option value="4">(Out)</option>
					 <option value="5">Shortage of drug(A)</option>
					 <option value="6">Pause medication(Hold)</option>
					 <option value="7">Other(＊)</option>
                  </select>
				</td>
            </tr>
            <tr>
                <td class="title">Date</td>
                <td colspan="2"><script> $(function() { $( "#Qstartdate3").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Qstartdate3" id="Qstartdate3" value="<?php echo date(Y."/".m."/".d); ?>" size="12">
                  <span class="title">Time</span>
                  <input type="text" name="Qmedtime3" id="Qmedtime3" value="<?php echo date(Hi); ?>" size="4" />
                <font size="2">(Format:HHmm)</font></td>
            </tr>
            <tr>
                <td class="title">Blood glucose level</td>
                <td colspan="2"><input type="text" name="QACvalue3" id="QACvalue3" value="<?php echo $ACvalue; ?>" size="4">mg/dl</td>
            </tr>
            <tr>
                <td class="title" valign="top">Medication</td>
                <td colspan="2">
                <input type="text" name="Qmedicine3" id="Qmedicine3" value="" size="30"><br />
                <input type="button" onclick="writetomed3('Novomix')" value="Novomix" />
                <input type="button" onclick="writetomed3('Regular Insulin (RI)')" value="Regular Insulin (RI)" />
                <input type="button" onclick="writetomed3('Humulin N')" value="Humulin N" />
                <input type="button" onclick="writetomed3('Lantus')" value="Lantus" />
                <input type="button" onclick="writetomed3('Forteo')" value="Forteo" /><br />
                <input type="button" onclick="writetomed3('Humalog mix Kwikpen')" value="Humalog mix Kwikpen" />
                <input type="button" onclick="writetomed3('Apidra')" value="Apidra" />
                <input type="button" onclick="writetomed3('Novorapid')" value="Novorapid" />
                <input type="button" onclick="writetomed3('Insulatard')" value="Insulatard" />
                <input type="button" onclick="writetomed3('Levemir')" value="Levemir" />
                <input type="button" onclick="writetomed3('Hold')" value="Hold" />
                <script>
                function writetomed3(name) {
                    if (document.getElementById('Qmedicine3').value!='') {
                        if (confirm('是否取代原有內容？\n按「確定」為「取代」，按「取消」為「加在原內容後方」')) {
                            document.getElementById('Qmedicine3').value = name;
                        } else {
                            document.getElementById('Qmedicine3').value = document.getElementById('Qmedicine3').value + ' ' + name;
                        }
                    } else {
                        document.getElementById('Qmedicine3').value = name;
                    }
                }
                </script>
                </td>
            </tr>
            <tr>
                <td class="title">Dose</td>
                <td colspan="2"><input type="text" name="Qdose3" id="Qdose3" value="" size="4">Unit</td>
            </tr>
            <tr>
                <td>Last 3 records</td>
                <td colspan="2"><div id="oldrecord3"></div></td>
            <tr>
                <td class="title" valign="top">Body part</td>
                <td valign="top">
                <select id="Qpart3" name="Qpart3">
                  <option></option>
                  <?php
                  foreach ($arrPart[$_SESSION['ncareInsulinImage_lwj']] as $k=>$v) {
                      echo '<option value="'.$v.'">'.$v.'</option>';
                  }
                  ?>
                </select>
				<input type="hidden" name="QNeedUseDate3" id="QNeedUseDate3" value="">
				<input type="hidden" name="QNeedUseTime3" id="QNeedUseTime3" value="">
                <input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
                <input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
                </td>
                <td>
                <?php
                if ($_SESSION['ncareInsulinImage_lwj']==1) {
                    echo '<img src="module/nurseform/img/pic2.png" border="0" width="440" />';
                } elseif ($_SESSION['ncareInsulinImage_lwj']==2) {
                    echo '<img src="module/nurseform/img/pic2a.png" border="0" width="220" />';
                } elseif ($_SESSION['ncareInsulinImage_lwj']==3) {
                    echo '<img src="module/nurseform/img/pic2b.png" border="0" width="440" />';
                } elseif ($_SESSION['ncareInsulinImage_lwj']==4) {
                    echo '<img src="module/nurseform/img/pic2c.png" border="0" width="220" />';
                }
                ?>
                </td>
            </tr>
        </table>
    </fieldset>
</div>
<div id="spantext3" style="display:none;">
<table style="font-size:10pt; width:100%">
  <thead><tr>
    <td>Date</td>
    <td>Time</td>
    <td>Blood glucose level</td>
    <td>Medication</td>
    <td>Dose</td>
    <td>Body part</td>
  </tr></thead>
  <?php echo $spantext3; ?>
</table>
</div>
<script>
function filloldrecord3() {
  document.getElementById('oldrecord3').innerHTML = document.getElementById('spantext3').innerHTML;
}
</script>
</div>
<?php
if($_GET['InsulinDate']!=""){
	$qdate_Insulin = $_GET['InsulinDate'];
}else{
	$qdate_Insulin = date(Ym);
}
?>
<?php
$insulinno = 6;
$Insulin_dbno = new DB;
$Insulin_dbno->query("SELECT * FROM `nurseform18` WHERE `HospNo`='".$HospNo."' AND (`Qstartdate` < '".substr($qdate_Insulin,0,4).'/'.substr($qdate_Insulin,4,2)."/31' AND (`Qenddate` > '".substr($qdate_Insulin,0,4).'/'.substr($qdate_Insulin,4,2)."/01' OR `Qenddate`=''))");
$pageno = ceil($Insulin_dbno->num_rows()/$insulinno);
$URL_InsulinDate = $qdate_Insulin;
$URL_InsulinDate_Year = substr($URL_InsulinDate,0,4);
$URL_InsulinDate_Month = substr($URL_InsulinDate,4,2);

$Previous_Month = $URL_InsulinDate_Month-1;
$Next_Month = $URL_InsulinDate_Month+1;
if($Previous_Month==0){
	$Previous_Month = "12";
	$Previous_Month_Year = $URL_InsulinDate_Year-1;
}else{
	$Previous_Month_Year = $URL_InsulinDate_Year;
}
if (strlen((int)$Previous_Month)==1) {
	$Previous_Month = "0".$Previous_Month;
}
if($Next_Month==13){
	$Next_Month = "1";
	$Next_Month_Year = $URL_InsulinDate_Year+1;
}else{
	$Next_Month_Year = $URL_InsulinDate_Year;
}
if (strlen((int)$Next_Month)==1) {
	$Next_Month = "0".$Next_Month;
}
$URL_InsulinDate_Previous = $URL_Insulin."InsulinDate=".$Previous_Month_Year.$Previous_Month;
$URL_InsulinDate_Next = $URL_Insulin."InsulinDate=".$Next_Month_Year.$Next_Month;
?>
<div style="font-size:10pt; background-color: rgba(255,255,255,0.7); border-radius: 10px; padding: 0% 2%; margin-bottom:0px; min-width:960px;">
<div align="center" style="padding-top:15px; min-width:900px;"><h3 style="color:#69b3b6;"><a style="font-size:20px; color:rgb(238,203,53);" href="<?php echo $URL_InsulinDate_Previous;?>"><i class="fa fa-chevron-circle-left"></i> Previous</a><font style="padding-left:50px; padding-right:50px;"><?php echo substr($qdate_Insulin,0,4).' / '.substr($qdate_Insulin,4,2); ?> Insulin injection record</font><a style="font-size:20px; color:rgb(238,203,53);" href="<?php echo $URL_InsulinDate_Next;?>">Next <i class="fa fa-chevron-circle-right"></i></a></h3></div>
<div style="overflow-x:auto; text-align:center; margin-bottom:0px;">
<?php
if($Insulin_dbno->num_rows()!=0){
for ($page=1;$page<=$pageno;$page++) {
	$startno = ($page-1)*$insulinno;
	$Insulin_rowno = $pageno*$insulinno;
?>
<?php
	if ($pageno==$page) {
		echo '<p><font size="2">Abbreviation: Not through mouth-NPO　Refuse - Ref　Outgoing - Out　Shortage of drug -A　Pause medication - Hold　Other-＊ (Noted in Nursing records)</font></p>';
	} else {
		echo '<p style="page-break-after: always;"><font size="2">Abbreviation: Not through mouth-NPO　Refuse - Ref　Outgoing - Out　Shortage of drug -A　Pause medication - Hold　Other-＊ (Noted in Nursing records)</font></p>';
	}
?>
<table width="100%">
  <tr height="20" style="background-color:rgba(255,255,255,0.8);">
    <td style="background-color:rgba(105,179,182,0.9); color:white;" width="60">Bed #</td>
    <td width="80"><?php echo $bedID; ?></td>
    <td style="background-color:rgba(105,179,182,0.9); color:white;" width="60">Full name</td>
    <td width="80"><?php echo $name; ?></td>
    <td style="background-color:rgba(105,179,182,0.9); color:white;" width="60">Care ID#</td>
    <td width="80"><?php echo $HospNo; ?></td>
    <td style="background-color:rgba(105,179,182,0.9); color:white;" width="60">DOB</td>
    <td width="180"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
    <td style="background-color:rgba(105,179,182,0.9); color:white;" width="80">Admission date</td>
    <td width="80"><?php echo $indate; ?></td>
  </tr>
  <tr height="20" style="background-color:rgba(255,255,255,0.8);">
    <td style="background-color:rgba(105,179,182,0.9); color:white;">Allergic drug</td>
    <td colspan="9" align="left">
	<?php
	$outputamed2 = '';
    $Insulin_db_amed2 = new DB;
	$Insulin_db_amed2->query("SELECT * FROM `allergicmed` WHERE `HospNo`='".$HospNo."' Order By `drugID` ASC");
	for ($i=0;$i<$Insulin_db_amed2->num_rows();$i++) {
		if ($outputamed2!="") { $outputamed2.='、'; }
		$amed2 = $Insulin_db_amed2->fetch_assoc();
		$outputamed2 .= $amed2['DrugName'];
    }
	echo $outputamed2;
	?>
    </td>
  </tr>
</table>
<table style="text-align:center;">
  <tr style="background-color:rgba(105,179,182,0.9); color:white;" height="30">
    <td width="30">Date<br>(Doctor)</td>
    <td width="100">Medication<br>(Dose)</td>
    <td width="40">Time</td>
    <?php
	echo drawmedcalwithtext($qdate_Insulin);
	?>
  </tr>
  <?php
  $Insulin_db = new DB;
  $Insulin_db->query("SELECT * FROM `nurseform18` WHERE `HospNo`='".$HospNo."' AND (`Qstartdate` < '".substr($qdate_Insulin,0,4).'/'.substr($qdate_Insulin,4,2)."/31' AND (`Qenddate` > '".substr($qdate_Insulin,0,4).'/'.substr($qdate_Insulin,4,2)."/01' OR `Qenddate`='')) LIMIT ".$startno.",".$Insulin_rowno);
  if ($page == $pageno) { $stopno = $Insulin_db->num_rows(); } else { $stopno = $insulinno; }
  for ($i=0;$i<$stopno;$i++) {
	  $bgday = "";
	  $Qmedtime = "";
	  $Qmedday = "";
	  $Insulin_r = $Insulin_db->fetch_assoc();
  	  foreach ($Insulin_r as $k=>$v) {
   	      $arrPatientInfo_Insulin = explode("_",$k);
    	  if (count($arrPatientInfo_Insulin)==2) {
     	      if ($v==1) {
     	          ${$arrPatientInfo_Insulin[0]} .= $arrPatientInfo_Insulin[1].';';
    	      }
    	  } else {
      	      ${$k} = $v;
   	      }
  	  }
	  $time = explode(';',$Qmedtime);
	  $time2 = array_pop($time);
	  if (count($time)<=4) { $Insulin_rowspan=4; } else { $Insulin_rowspan = count($time); }
	  $pstartday = str_replace('/','',substr($Insulin_r['Qstartdate'],0,7));
	  $pendday = str_replace('/','',substr($Insulin_r['Qenddate'],0,7));
	  if ($pstartday<$qdate_Insulin) {
		  $startday = 1;
	  } else {
		  $startday = substr($Insulin_r['Qstartdate'],8,2);
	  }
	  if ($qdate_Insulin < str_replace('/','',substr($Insulin_r['Qenddate'],0,7))) {
		  $endday = date('t',strtotime(formatdate($qdate_Insulin.'01')));
	  } elseif ($Insulin_r['Qenddate']=="") {
		  $endday = date('t',strtotime(formatdate($qdate_Insulin.'01')));
	  } else {
		  $endday = substr($Insulin_r['Qenddate'],8,2);
	  }
	  for ($starti=$startday;$starti<=$endday;$starti++) {
		  $bgday .= $starti.';';
	  }
	  echo '
  <tr height="24" style="background-color:rgba(255,255,255,0.8);">
	<td rowspan="'.$Insulin_rowspan.'" style="white-space:nowrap;">'.$Insulin_r['Qstartdate'].'<br>~<br>'.$Insulin_r['Qenddate'].'<br>('.$Insulin_r['Qdoctor'].')</td>
    <td rowspan="'.$Insulin_rowspan.'" style="white-space:nowrap;">'.$Insulin_r['Qmedicine'].'<br>('.$Insulin_r['Qdose'].' Unit)</td>
    <td style="white-space:nowrap;">'; if (count($time)>0 && ($time[0]-1)<=9) { echo ($time[0]-1).' am'; $needgive1=1;} else { echo '&nbsp;'; $needgive1=0;} $time1_24HR = ($time[0]-1); echo '</td>'.drawInsulin($bgday,$Qmedday,$needgive1,$i,$Insulin_r['Qmedicine'],$time1_24HR,$HospNo,$qdate_Insulin).'
  </tr>'."\n";
    if (count($time)<=4) {
		$time2 = '&nbsp;';
		$needgive2=0;
		$time3 = '&nbsp;';
		$needgive3=0;
		$time4 = '&nbsp;';
		$needgive4=0;
		for ($t1=0;$t1<count($time);$t1++) {
			if (($time[$t1]-1)>9 && ($time[$t1]-1)<=13) { if (($time[$t1]-1)>12) { $time2 = (($time[$t1]-1)-12).' pm'; $needgive2=1;} elseif (($time[$t1]-1)==12) { $time2 = '12 pm'; $needgive2=1;} else { $time2 = ($time[$t1]-1).' am'; $needgive2=1;} $time2_24HR = ($time[$t1]-1); }
			elseif (($time[$t1]-1)>13 && ($time[$t1]-1)<=18) { $time3 = (($time[$t1]-1)-12).' pm'; $needgive3=1; $time3_24HR = ($time[$t1]-1);}
			elseif (($time[$t1]-1)>18 && ($time[$t1]-1)<=23) { $time4 = (($time[$t1]-1)-12).' pm'; $needgive4=1; $time4_24HR = ($time[$t1]-1);}
		}
		echo '
		<tr height="24" style="background-color:rgba(255,255,255,0.8);"><td style="white-space:nowrap;">'.$time2.'</td>'.drawInsulin($bgday,$Qmedday,$needgive2,$i,$Insulin_r['Qmedicine'],$time2_24HR,$HospNo,$qdate_Insulin).'</tr>
		<tr height="24" style="background-color:rgba(255,255,255,0.8);"><td style="white-space:nowrap;">'.$time3.'</td>'.drawInsulin($bgday,$Qmedday,$needgive3,$i,$Insulin_r['Qmedicine'],$time3_24HR,$HospNo,$qdate_Insulin).'</tr>
		<tr height="24" style="background-color:rgba(255,255,255,0.8);"><td style="white-space:nowrap;">'.$time4.'</td>'.drawInsulin($bgday,$Qmedday,$needgive4,$i,$Insulin_r['Qmedicine'],$time4_24HR,$HospNo,$qdate_Insulin).'</tr>
		';
	} elseif (count($time)==0) {
		echo '<tr height="24" style="background-color:rgba(255,255,255,0.8);"><td>&nbsp;</td>'.drawInsulin('','','','','','','',$qdate_Insulin).'</tr>'."\n";
		echo '<tr height="24" style="background-color:rgba(255,255,255,0.8);"><td>&nbsp;</td>'.drawInsulin('','','','','','','',$qdate_Insulin).'</tr>'."\n";
		echo '<tr height="24" style="background-color:rgba(255,255,255,0.8);"><td>&nbsp;</td>'.drawInsulin('','','','','','','',$qdate_Insulin).'</tr>'."\n";
	} else {
		for ($t1=1;$t1<count($time);$t1++) {
			if (($time[$t1]-1)>12) { $manytime = (($time[$t1]-1)-12).' pm'; ${"needgive".$t1}=1;} elseif (($time[$t1]-1)==12) { $manytime = '12 pm'; ${"needgive".$t1}=1;} else { $manytime = ($time[$t1]-1).' am'; ${"needgive".$t1}=1;}
			$manytime_24HR = ($time[$t1]-1);
			echo '<tr height="24" style="background-color:rgba(255,255,255,0.8);"><td style="white-space:nowrap;">'.$manytime.'</td>'.drawInsulin($bgday,$Qmedday, ${"needgive".$t1},$i,$Insulin_r['Qmedicine'],$manytime_24HR,$HospNo,$qdate_Insulin).'</tr>'."\n";
		}
	}
  }
  if ($pageno == $page && $Insulin_db->num_rows()<$insulinno) {
	  $addspaceno = $insulinno - $Insulin_db->num_rows();
	  for ($k=0;$k<$addspaceno;$k++) {
  ?>
  <tr height="24" style="background-color:rgba(255,255,255,0.8);">
    <td rowspan="4">&nbsp;</td>
    <td rowspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <?php echo drawInsulin('','','','','','','',$qdate_Insulin); ?>
  </tr>
  <tr height="24" style="background-color:rgba(255,255,255,0.8);">
    <td>&nbsp;</td>
    <?php echo drawInsulin('','','','','','','',$qdate_Insulin); ?>
  </tr>
  <tr height="24" style="background-color:rgba(255,255,255,0.8);">
    <td>&nbsp;</td>
    <?php echo drawInsulin('','','','','','','',$qdate_Insulin); ?>
  </tr>
  <tr height="24" style="background-color:rgba(255,255,255,0.8);">
    <td>&nbsp;</td>
    <?php echo drawInsulin('','','','','','','',$qdate_Insulin); ?>
  </tr>
  <?php
	  }
  }
  ?>
</table>
<br>
<?php
}
}else{
	echo '<div><p style="font-size:20px;">no data</p></div>';
}
?>
</div></div>