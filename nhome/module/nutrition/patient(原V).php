<?php
$db = new DB;
$db->query("SELECT * FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."' ORDER BY `patientID` ASC");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT * FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	/*== 解 START ==*/
	$LWJArray = array('Name1','Name2','Name3','Name4');
	$LWJdataArray = array($r['Name1'],$r['Name2'],$r['Name3'],$r['Name4']);
	for($z=0;$z<count($LWJdataArray);$z++){
	    $rsa = new lwj('lwj/lwj');
	    $puepart = explode(" ",$LWJdataArray[$z]);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($m=0;$m<$puepartcount;$m++){
                $prdpart = $rsa->privDecrypt($puepart[$m]);
                $r[$LWJArray[$z]] = $r[$LWJArray[$z]].$prdpart;
            }
	    }else{
		   $r[$LWJArray[$z]] = $rsa->privDecrypt($LWJdataArray[$z]);
	    }
	}
	/*== 解 END ==*/
	if($r['Name2']!="" || $r['Name2']!=NULL){$r['Name2'] = " ".$r['Name2'];}
	if($r['Name3']!="" || $r['Name3']!=NULL){$r['Name3'] = " ".$r['Name3'];}
	if($r['Name4']!="" || $r['Name4']!=NULL){$r['Name4'] = " ".$r['Name4'];}
	$name = $r['Name1'].$r['Name2'].$r['Name3'].$r['Name4'];
	$birth = formatdate($r['Birth']);
	$indate = formatdate($r1['indate']);
}
$basicinfo = '<div class="content-query" style="width:510px;">
<table align="center" style="width:510px;">
  <tr>
    <td class="title">Full name</td>
    <td>'.$name.'</td>
    <td class="title">DOB</td>
    <td>'.$birth.'</td>
    <td class="title">Admission date</td>
    <td>'.$indate.'</td>
  </tr>
</table>
</div>'."\n";
?>
<table width="100%" style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 20px;">
  <tr>
    <td width="150" rowspan="2" valign="top"><div style="background-color:rgba(150,150,150,0.8); padding-top:10px;"><?php include("module/nutrition/leftcol.php"); ?></div></td>
    <td valign="top">
    <table width="100%">
      <tr>
        <td valign="middle" width="300"><h3 align="center">Body Weight</h3></td>
        <td align="right"><?php echo $basicinfo; ?></td>
      </tr>
    </table>
    <div id="bweightchart" style="width:720px;height:300px; margin-left:20px; background-color:rgba(0,0,0,0.5);"></div><br /><br />
    <table cellpadding="6px" width="100%">
      <tr bgcolor="#f54d5d" style="color:#ffffff;">
        <td>Full name</td>
        <td>Type(s)</td>
        <td>Value(s)</td>
        <td>Weight change</td>
        <td>Measured time</td>
        <td>Uploaded time</td>
        <td>Filled by</td>
      </tr>
      <?php
      $arr188334 = array();
	  $db2 = new DB;
	  $db2->query("SELECT * FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='18833-4' AND `IsValid`='1' ORDER BY `RecordedTime` ASC LIMIT 0,30");
	  if ($db2->num_rows()>0) {
	  for ($i=0;$i<$db2->num_rows();$i++) {
		  $r2 = $db2->fetch_assoc();
		  $db2a = new DB;
		  $db2a->query("SELECT `Name1`,`Name2`,`Name3`,`Name4` FROM `patient` WHERE `patientID`='".$r2['PersonID']."'");
		  $r2a = $db2a->fetch_assoc();
		  	/*== 解 START ==*/
			  $LWJArray = array('Name1','Name2','Name3','Name4');
			  $LWJdataArray = array($r2a['Name1'],$r2a['Name2'],$r2a['Name3'],$r2a['Name4']);
			  for($z=0;$z<count($LWJdataArray);$z++){
	    		  $r2asa = new lwj('lwj/lwj');
	    		  $puepart = explode(" ",$LWJdataArray[$z]);
	    		  $puepartcount = count($puepart);
	    		  if($puepartcount>1){
            		  for($m=0;$m<$puepartcount;$m++){
                		  $prdpart = $r2asa->privDecrypt($puepart[$m]);
                		  $r2a[$LWJArray[$z]] = $r2a[$LWJArray[$z]].$prdpart;
            		  }
	    		  }else{
		   		  $r2a[$LWJArray[$z]] = $r2asa->privDecrypt($LWJdataArray[$z]);
	    		  }
			  }
			  /*== 解 END ==*/
		  if($r2a['Name2']!="" || $r2a['Name2']!=NULL){$r2a['Name2'] = " ".$r2a['Name2'];}
		  if($r2a['Name3']!="" || $r2a['Name3']!=NULL){$r2a['Name3'] = " ".$r2a['Name3'];}
		  if($r2a['Name4']!="" || $r2a['Name4']!=NULL){$r2a['Name4'] = " ".$r2a['Name4'];}	
		  $r2a['Name'] = $r2a['Name1'].$r2a['Name2'].$r2a['Name3'].$r2a['Name4'];
		  $RecordTime = explode(".",$r2['RecordedTime']);
		  $UploadTime = explode(".",$r2['UploadedTime']);
		  if ($i%2==0) { $bgcolor = '#feeced'; } else { $bgcolor = '#ffffff'; }
		  if ($oldweight=="") {
			  $weightchange = "---";
		  } else {
			 $weightchange = round((($r2['Value']-$oldweight)/$oldweight)*100,2).' %';
		  }
		  echo '
	  <tr bgcolor="'.$bgcolor.'" align="left">
        <td><a href="index.php?mod=dailywork&func=patient&pid='.$r2['PersonID'].'" style="color:#5daeb1;">'.$r2a['Name'].'</a></td>
        <td>'.$arrVital[$r2['LoincCode']].'</td>
        <td>'.$r2['Value'].'</td>
        <td>'.$weightchange.'</td>
        <td>'.$RecordTime[0].'</td>
        <td>'.$UploadTime[0].'</td>
        <td>'.checkusername($r2['Qfiller']).'</td>
      </tr>  
		  '."\n";
		  $oldweight = $r2['Value'];
		  $RecordDate = explode(" ",$RecordTime[0]);
		  $arrRecordTime = explode(":",$RecordDate[1]); // 0:Hour 1:Minute 2:Second
		  $arrRecordDate = explode("-",$RecordDate[0]); // 0:Year 1:Month 2:Date
		  $second1970 = mktime($arrRecordTime[0],$arrRecordTime[1],$arrRecordTime[2],$arrRecordDate[1],$arrRecordDate[2],$arrRecordDate[0]);
		  $second1970ms = $second1970 * 1000;
		  $arr188334[number_format($second1970ms, 0, '.', '')] = $r2['Value'];
	  }
	  ksort($arr188334);
	  foreach ($arr188334 as $k1=>$v1) { $bweight .= "[".$k1.",".$v1."],"; }
	  $bweight=substr($bweight,0,strlen($bweight)-1);
	  $bweight = '['.$bweight.']';
	  } else {
		  echo '
	  <tr bgcolor="'.$bgcolor.'" align="left">
        <td colspan="7">Currently no data</td>
      </tr>  
		  '."\n";
	  }
	  ?>
    </table>
    <script type="text/javascript">
	$(function () {
		$.plot($("#bweightchart"), [
			{ label: "Body weight",  data: <?php echo $bweight; ?> }
		],
		{
            lines: { show: true },
            points: { show: true },
            xaxis: {
				mode: 'time',
				panRange: [-10, 10],
				'color':'#FFFFFF',
			},
			yaxis: { panRange: [-10, 10], 'color':'#FFFFFF', },
			zoom: { interactive: false },
			pan: { interactive: false },
			grid: {
				markings: [
				  {yaxis: { from: 12, to: 20 },color: "#FFE2CF"}
				],
				hoverable: true
			},
			crosshair: { mode: "x" }
		});
		function showTooltip(x, y, contents) {
			$('<div id="tooltip">' + contents + '</div>').css( {
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 5,
				border: '1px solid #fdd',
				padding: '2px',
				'background-color': '#fee',
				opacity: 0.80
			}).appendTo("body").fadeIn(200);
		}
		var previousPoint = null;
		$("#bweightchart").bind("plothover", function (event, pos, item) {
			$("#x").text(pos.x.toFixed(2));
			$("#y").text(pos.y.toFixed(2));
			if (item) {
				if (previousPoint != item.dataIndex) {
					previousPoint = item.dataIndex;
					$("#tooltip").remove();
					var x = item.datapoint[0].toFixed(0), y = item.datapoint[1].toFixed(0);
					var date = new Date();
					date.setTime(x);
					showTooltip(item.pageX, item.pageY, item.series.label + " " + y + "<br>" + date.getUTCFullYear() + '/' + (date.getUTCMonth() + 1) + '/' + date.getUTCDate() + ' ' + date.getUTCHours() + ':' + date.getUTCMinutes() );
				}
            } else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
		});
	});
    </script>
    </td>
  </tr>
</table>