<?php
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
	$bedID = $r1['bed'];
	$HospNo = $r['HospNo'];
}
if (@$_GET['date']=="--Select month--" || @$_GET['date']=="") {
	$qdate = date(Y).'-'.date(m);
} else {
	$qdate = $_GET['date'];//substr(@$_GET['date'],0,4).'-'.substr(@$_GET['date'],4,2);
}
$d = new DateTime($qdate.'-01');
for ($page=1;$page<=2;$page++) {
	if ($page==1) {
		$loopstart = 1;
		$loopend = 15;
	} else {
		echo '<div style="page-break-before:always;">&nbsp;</div>';
		echo '<center><h3>'.$_SESSION['nOrgName_lwj'].'</h3></center>';
		$loopstart = 16;
		$loopend = date(t,strtotime(substr(@$_GET['date'],0,4).'/'.substr(@$_GET['date'],4,2).'/01'));
	}
	$count = 0;
	for ($i4=$loopstart;$i4<=$loopend;$i4++) {
		if ($count==0) { $n = 0; } else { $n = 1; }
		$d->modify("+".$n." day");
		$sd = $d->format('m/d');
		${'Day'.$i4} = $d->format('Ymd');
		$count++;
	}
?>
    <h3>Night shift work record - 
    <?php
    if (@$_GET['date']=="--Select month--" || @$_GET['date']=="") {
        echo date(Y).' '.getEnglishMonth(date(m));
    } else {
        echo substr(@$_GET['date'],0,4).' '.getEnglishMonth(substr(@$_GET['date'],5,2));
    }
    ?></h3>

   
    <table border="1" width="100%">
      <tr id="backtr"  style="border:none;" height="40">
        <td class="title" width="60" style="border:none;">Bed #</td>
        <td width="80" style="border:none;"><?php echo $bedID; ?></td>
        <td class="title" width="70" style="border:none;">Care ID#</td>
        <td width="90" style="border:none;"><?php echo $HospNo; ?></td>
        <td class="title" width="60" style="border:none;">Full name</td>
        <td width="80" style="border:none;"><?php echo $name; ?></td>
      </tr>
    </table>
    
    <?php
    foreach ($arrVital as $k=>$v) {
        ${'arrVital'.$k} = array();
    }
    ?>
    <?php
	$db2 = new DB;
	$db2->query("SELECT * FROM `careform05_2` WHERE `HospNo`='".$HospNo."' AND `date`>='".str_replace("-","",$qdate).(strlen($loopstart)==1?"0":"").$loopstart."' AND `date`<='".str_replace("-","",$qdate).(strlen($loopend)==1?"0":"").$loopend."'");
	for ($i3=0;$i3<$db2->num_rows();$i3++) {
	  $r2 = $db2->fetch_assoc();
	  //print_r($r1);
	  foreach ($r2 as $k=>$v) {
		if (substr($k,0,1)=="Q") {
			$arrAnswer = explode("_",$k);
			if (count($arrAnswer)==2) {
				if ($v==1) {
					${'Day'.$r2['date'].'_'.$arrAnswer[0]} .= $arrAnswer[1].';';
				}
			} else {
				${'Day'.$r2['date'].'_'.$k} = $v;
			}
		}  else {
			${'Day'.$r2['date'].'_'.$k} = $v;
		}
	  }
  }
	?>
    <table border="0" cellpadding="0" cellspacing="0" style="border:0px;">
      <tr>
        <td valign="top" align="center" colspan="2">Date</td>
        <?php
        for ($i=$loopstart;$i<=$loopend;$i++) {
            echo '<td align="center">'.$i.'</td>'."\n";
        }
        ?>
      </tr>
      <tr>
    <td rowspan="7" class="title">Diet</td>
    <td class="title">Breakfast/Milk Sarapan/susu</td>
	  <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
	  	echo '<td align="center">'.option_result('Day'.${'Day'.$i3}."_Q1","Good;Fair;Poor","s","single",${'Day'.${'Day'.$i3}.'_Q1'},false,4).'</td>';
	  }
	  ?>
  </tr>
  <tr>
      <td class="title">AM tea/refreshment</td>
       <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
	  	echo '<td align="center">'.option_result('Day'.${'Day'.$i3}."_Q2","Good;Fair;Poor","s","single",${'Day'.${'Day'.$i3}.'_Q2'},false,4).'</td>';
	  }
	  ?>
      </tr>
  <tr>
      <td class="title">Lunch</td>
       <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
	  	echo '<td align="center">'.option_result('Day'.${'Day'.$i3}."_Q3","Good;Fair;Poor","s","single",${'Day'.${'Day'.$i3}.'_Q3'},false,4).'</td>';
	  }
	  ?>
      </tr>
  <tr>
      <td class="title">Afternoon refreshment</td>
       <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
	  	echo '<td align="center">'.option_result('Day'.${'Day'.$i3}."_Q4","Good;Fair;Poor","s","single",${'Day'.${'Day'.$i3}.'_Q4'},false,4).'</td>';
	  }
	  ?>
      </tr>
  <tr>
      <td class="title">Dinner</td>
       <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
	  	echo '<td align="center">'.option_result('Day'.${'Day'.$i3}."_Q5","Good;Fair;Poor","s","single",${'Day'.${'Day'.$i3}.'_Q5'},false,4).'</td>';
	  }
	  ?>
      </tr>
  <tr>
      <td class="title">Evening refreshement/milk</td>
       <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
	  	echo '<td align="center">'.option_result('Day'.${'Day'.$i3}."_Q6","Good;Fair;Poor","s","single",${'Day'.${'Day'.$i3}.'_Q6'},false,4).'</td>';
	  }
	  ?>
      </tr>
  <tr>
      <td class="title">Tube feeding</td>
      <?php for ($i3=$loopstart;$i3<=$loopend;$i3++) {?>
      <td><?php echo draw_option('Day'.${'Day'.$i3}."_Q12","Good;Fair;Poor","m","single",${'Day'.${'Day'.$i3}.'_Q12'},false,4); ?></td>
      <?php }?>
  </tr>      
  <tr>
    <td rowspan="5" class="title">Activity</td>
    <td class="title">Rehabilitation</td>
      <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
		$arr = explode(";",${'Day'.${'Day'.$i3}."_Q7"});
	  	echo '<td align="center">'.(in_array('1', $arr)?"&#10004;":"").'</td>';
	  }
	  ?>
    </td>
  </tr>
  <tr>
      <td class="title">Practice walking</td>
      <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
		  $arr = explode(";",${'Day'.${'Day'.$i3}."_Q7"});
	  	echo '<td align="center">'.(in_array('2', $arr)?"&#10004;":"").'</td>';
	  }
	  ?>
  </tr>
  <tr>
      <td class="title">Transfer to wheelchair</td>
      <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
	  	$arr = explode(";",${'Day'.${'Day'.$i3}."_Q7"});
	  	echo '<td align="center">'.(in_array('3', $arr)?${'Day'.${'Day'.$i3}."_Q7a"}:"").'</td>';
	  }
	  ?>
  </tr>
  <tr>
      <td class="title">Bed rest</td>
      <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
	  	$arr = explode(";",${'Day'.${'Day'.$i3}."_Q7"});
	  	echo '<td align="center">'.(in_array('4', $arr)?"&#10004;":"").'</td>';
	  }
	  ?>
  </tr>
  <tr>
      <td class="title">Enhance Positioning(turn over)</td>
      <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
	  	$arr = explode(";",${'Day'.${'Day'.$i3}."_Q7"});
	  	echo '<td align="center">'.(in_array('5', $arr)?"&#10004;":"").'</td>';
	  }
	  ?>
  </tr>
  <tr>
    <td rowspan="5" class="title">Personal hygiene</td>
    <td class="title">Oral care</td>
      <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
		$arr = explode(";",${'Day'.${'Day'.$i3}."_Q8"});
	  	echo '<td align="center">'.(in_array('1', $arr)?${'Day'.${'Day'.$i3}."_Q8a"}."":"").'</td>';
	  }
	  ?>
    </td>
  </tr>
  <tr>
      <td class="title">Arrange bedsheet</td>
      <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
		  $arr = explode(";",${'Day'.${'Day'.$i3}."_Q8"});
	  	echo '<td align="center">'.(in_array('2', $arr)?${'Day'.${'Day'.$i3}."_Q8b"}:"").'</td>';
	  }
	  ?>
  </tr>
  <tr>
      <td class="title">Cut nails</td>
      <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
		  $arr = explode(";",${'Day'.${'Day'.$i3}."_Q8"});
	  	echo '<td align="center">'.(in_array('3', $arr)?"&#10004;":"").'</td>';
	  }
	  ?>
  </tr>
  <tr>
      <td class="title">
	  <?php 
		$txt = "Buttock clean/care";
		echo $txt;
	  ?>
      </td>
      <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
		  $arr = explode(";",${'Day'.${'Day'.$i3}."_Q8"});
	  	echo '<td align="center">'.(in_array('4', $arr)?${'Day'.${'Day'.$i3}."_Q8c"}:"").'</td>';
	  }
	  ?>
  </tr>
  <tr>
      <td class="title">Bathing</td>
      <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
		  $arr = explode(";",${'Day'.${'Day'.$i3}."_Q8"});
	  	echo '<td align="center">'.(in_array('5', $arr)?"&#10004;":"").'</td>';
	  }
	  ?>
  </tr>
  <tr>
    <td rowspan="4" class="title">Other</td>
    <td class="title">Out visiting (clinic,hospital,home...etc)</td>
      <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
		$arr = explode(";",${'Day'.${'Day'.$i3}."_Q9"});
	  	echo '<td align="center">'.(in_array('1', $arr)?"&#10004;":"").'</td>';
	  }
	  ?>
    </td>
  </tr>
  <tr>
      <td class="title">Steam inhalation</td>
      <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {		  
		  $arr = explode(";",${'Day'.${'Day'.$i3}."_Q9"});
	  	echo '<td align="center">'.(in_array('2', $arr)?${'Day'.${'Day'.$i3}."_Q9a"}:"").'</td>';
	  }
	  ?>
  </tr>
  <tr>
      <td class="title">Skin lotion</td>
      <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
		  $arr = explode(";",${'Day'.${'Day'.$i3}."_Q9"});
	  	echo '<td align="center">'.(in_array('3', $arr)?"&#10004;":"").'</td>';
	  }
	  ?>
  </tr>
  <tr>
      <td class="title">Vaseline</td>
      <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
		  $arr = explode(";",${'Day'.${'Day'.$i3}."_Q9"});
	  	echo '<td align="center">'.(in_array('4', $arr)?"&#10004;":"").'</td>';
	  }
	  ?>
  </tr>
  <tr>
    <td colspan="2" class="title">Family visit</td>
      <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
	  	echo '<td align="center">'.option_result(${'Day'.${'Day'.$i3}."_Q13"},"Spouse;Son;Daughter in law;Daughter;Grandson;Relative;Friend;Personal aide;Other-","s","multi",${'Day'.${'Day'.$i3}."_Q13"},false,2).${'Day'.${'Day'.$i3}."_Q10"}.'</td>';
	  }?>
  </tr>
  <tr>
    <td colspan="2" class="title">Filled by</td>
      <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
	  	echo '<td align="center">'.checkusername(${'Day'.${'Day'.$i3}."_Qfiller"}).'</td>';
	  }?>
  </tr>
  <tr>
    <td colspan="2" class="title">Comment</td>
    <td colspan="20">
      <?php
	  for ($i3=$loopstart;$i3<=$loopend;$i3++) {
	  	echo ${'Day'.${'Day'.$i3}."_Q11"}.' ';
	  }?>
    </td>
  </tr>
    </table>
<?php
}
?>

