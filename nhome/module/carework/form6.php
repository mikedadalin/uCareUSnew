<div class="moduleNoTab">
<h3 style="width:100%;">Toileting schedule record</h3>
<?php 
if (@$_GET['qdate']==NULL) { $qdate = date('Y-m-d'); } else { $qdate = @$_GET['qdate']; }
?>
<form  class="printcol" style="width:100%; margin:0 auto;">
<div style="float:left">
<a style="color:#3F3F3F; font-size:18px; font-weight:bold;">Select month: </a><select id="selmonth">
<option>--Select month--</option>
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
    if (@$_GET['qdate']==$year.'-'.$month) { echo ' selected'; }
    echo '>'.$year.'-'.$month.'</option>'."\n";
}
?>
</select>
</div>
<div style="float:right;">
<input type="button" value="New work record" id="Add">
</div>
</form>
<form method="post" onsubmit="return checkForm();" style="text-align:center; width:100%; margin:0 auto; padding-bottom:20px;">
<?php

$arrDates = getdays($qdate);
//print_r($arrDates);
$d = new DateTime($arrDates[0]);
$dlw = new DateTime($arrDates[0]);
$dnw = new DateTime($arrDates[0]);
$dlw->modify('-7 day'); $lastweek = $dlw->format('Y-m-d');
$dnw->modify('+7 day'); $nextweek = $dnw->format('Y-m-d');
echo '<span class="noShowCol">'.substr($qdate,0,4).'Year'.substr($qdate,5,2).'Month'.'</span>';
?>
<table border="0" cellpadding="5" style="width:100%; margin:0px auto;">
  <tr class="title printcol">
    <td colspan="8"><input type="button" onclick="window.location.href='index.php?mod=carework&func=formview&id=6&pid=<?php echo $_GET['pid']; ?>&qdate=<?php echo $lastweek; ?>'" value="Previous week"> <input type="button" onclick="window.location.href='index.php?mod=carework&func=formview&pid=<?php echo $_GET['pid']; ?>&id=6'" value="Back to current week"> <input type="button" onclick="window.location.href='index.php?mod=carework&func=formview&id=6&pid=<?php echo $_GET['pid']; ?>&qdate=<?php echo $nextweek; ?>'" value="Next week"></td>
  </tr>
  <tr class="title">
    <td width="80">Item(s)</td>
    <?php
	$i1 = 0;
	foreach ($arrPHPDay as $k=>$v) {
		if ($i1==0) { $n = 0; } else { $n = 1; }
		$d->modify("+".$n." day");
		$sd = $d->format('m/d');
		${'Day'.$i1} = $d->format('Ymd');
    ?>
    <td width="60" align="center"><?php echo $k;?><br><?php echo $sd;?></td>
    <?php 
	    $i1++;
	}
	?>
  </tr>
  <?php
  $db1 = new DB;
  $db1->query("SELECT * FROM `careform06` WHERE `HospNo`='".$HospNo."' AND `date`>='".$Day0."' AND `date`<='".$Day6."'");
  for ($i2=0;$i2<$db1->num_rows();$i2++) {
	  $r1 = $db1->fetch_assoc();
	  //print_r($r1);
	  foreach ($r1 as $k=>$v) {
		if (substr($k,0,1)=="Q") {
			$arrAnswer = explode("_",$k);
			if (count($arrAnswer)==2) {
				if ($v==1) {
					${'Day'.$r1['date'].'_'.$arrAnswer[0]} .= $arrAnswer[1].';';					
				}
				${'Day'.$r1['date'].'_'.$arrAnswer[0].'_filler'} = $v;
			} else {
				${'Day'.$r1['date'].'_'.$k} = $v;				
			}
		}  else {
			${'Day'.$r1['date'].'_'.$k} = $v;
		}
	  }
  }
  ?>
  <tr class="printcol">
    <td class="title"></td>
	  <?php
	  for ($i3=0;$i3<7;$i3++) {
	  	echo '<td align="center"><a href="index.php?mod=carework&func=formview&pid='.$_GET['pid'].'&id=6_1&date='.${'Day'.$i3}.'"><img src="Images/edit_icon.png" width="24"></a></td>';
	  }
	  ?>
  </tr>
  <tr>
    <td class="title">06：00</td>
	  <?php
	  for ($i3=0;$i3<7;$i3++) {
		$filler = (checkusername(${'Day'.${'Day'.$i3}.'_Q1_filler'})==""?"":"<br>Filled by:(".checkusername(${'Day'.${'Day'.$i3}.'_Q1_filler'}).")");
	  	echo '<td align="center">'.option_result('Day'.${'Day'.$i3}."_Q1","Micturition (frequently);Induced urinary;Self-controlled voiding;None;Incontinence","s","single",${'Day'.${'Day'.$i3}.'_Q1'},false,4).$filler.'</td>';
	  }
	  ?>
  </tr>
  <tr>
    <td class="title">08：00</td>
	  <?php
	  for ($i3=0;$i3<7;$i3++) {
		$filler = (checkusername(${'Day'.${'Day'.$i3}.'_Q2_filler'})==""?"":"<br>Filled by:(".checkusername(${'Day'.${'Day'.$i3}.'_Q2_filler'}).")");  
	  	echo '<td align="center">'.option_result('Day'.${'Day'.$i3}."_Q2","Micturition (frequently);Induced urinary;Self-controlled voiding;None;Incontinence","s","single",${'Day'.${'Day'.$i3}.'_Q2'},false,4).$filler.'</td>';
	  }
	  ?>
  </tr>
  <tr>
    <td class="title">10：00</td>
	  <?php
	  for ($i3=0;$i3<7;$i3++) {
		$filler = (checkusername(${'Day'.${'Day'.$i3}.'_Q3_filler'})==""?"":"<br>Filled by:(".checkusername(${'Day'.${'Day'.$i3}.'_Q3_filler'}).")");  
	  	echo '<td align="center">'.option_result('Day'.${'Day'.$i3}."_Q3","Micturition (frequently);Induced urinary;Self-controlled voiding;None;Incontinence","s","single",${'Day'.${'Day'.$i3}.'_Q3'},false,4).$filler.'</td>';
	  }
	  ?>
  </tr>
  <tr>
    <td class="title">12：00</td>
	  <?php
	  for ($i3=0;$i3<7;$i3++) {
		$filler = (checkusername(${'Day'.${'Day'.$i3}.'_Q4_filler'})==""?"":"<br>Filled by:(".checkusername(${'Day'.${'Day'.$i3}.'_Q4_filler'}).")");  		  
	  	echo '<td align="center">'.option_result('Day'.${'Day'.$i3}."_Q4","Micturition (frequently);Induced urinary;Self-controlled voiding;None;Incontinence","s","single",${'Day'.${'Day'.$i3}.'_Q4'},false,4).$filler.'</td>';
	  }
	  ?>
  </tr>
  <tr>
    <td class="title">14：00</td>
	  <?php
	  for ($i3=0;$i3<7;$i3++) {
		$filler = (checkusername(${'Day'.${'Day'.$i3}.'_Q5_filler'})==""?"":"<br>Filled by:(".checkusername(${'Day'.${'Day'.$i3}.'_Q5_filler'}).")");  		  
	  	echo '<td align="center">'.option_result('Day'.${'Day'.$i3}."_Q5","Micturition (frequently);Induced urinary;Self-controlled voiding;None;Incontinence","s","single",${'Day'.${'Day'.$i3}.'_Q5'},false,4).$filler.'</td>';
	  }
	  ?>
  </tr>
  <tr>
    <td class="title">16：00</td>
	  <?php
	  for ($i3=0;$i3<7;$i3++) {
		$filler = (checkusername(${'Day'.${'Day'.$i3}.'_Q6_filler'})==""?"":"<br>Filled by:(".checkusername(${'Day'.${'Day'.$i3}.'_Q6_filler'}).")");  		  
	  	echo '<td align="center">'.option_result('Day'.${'Day'.$i3}."_Q6","Micturition (frequently);Induced urinary;Self-controlled voiding;None;Incontinence","s","single",${'Day'.${'Day'.$i3}.'_Q6'},false,4).$filler.'</td>';
	  }
	  ?>
  </tr>
  <tr>
    <td class="title">18：00</td>
	  <?php
	  for ($i3=0;$i3<7;$i3++) {
		$filler = (checkusername(${'Day'.${'Day'.$i3}.'_Q7_filler'})==""?"":"<br>Filled by:(".checkusername(${'Day'.${'Day'.$i3}.'_Q7_filler'}).")");  		  
	  	echo '<td align="center">'.option_result('Day'.${'Day'.$i3}."_Q7","Micturition (frequently);Induced urinary;Self-controlled voiding;None;Incontinence","s","single",${'Day'.${'Day'.$i3}.'_Q7'},false,4).$filler.'</td>';
	  }
	  ?>
  </tr>
  <tr>
    <td class="title">20：00</td>
	  <?php
	  for ($i3=0;$i3<7;$i3++) {
		$filler = (checkusername(${'Day'.${'Day'.$i3}.'_Q8_filler'})==""?"":"<br>Filled by:(".checkusername(${'Day'.${'Day'.$i3}.'_Q8_filler'}).")");  		  
	  	echo '<td align="center">'.option_result('Day'.${'Day'.$i3}."_Q8","Micturition (frequently);Induced urinary;Self-controlled voiding;None;Incontinence","s","single",${'Day'.${'Day'.$i3}.'_Q8'},false,4).$filler.'</td>';
	  }
	  ?>
  </tr>
<!--  <tr>
    <td class="title">Filled by</td>
      <?php
	  /*for ($i3=0;$i3<7;$i3++) {
	  	echo '<td align="center">'.checkusername(${'Day'.${'Day'.$i3}."_Qfiller"}).'</td>';
	  }*/?>
  </tr>
--></table>
</form>
</div>
<script language="javascript">
$(function() {
	$('#Add').click(function(){
		location.href = "index.php?mod=carework&func=formview&id=6_1&pid=<?php echo $_GET['pid']; ?>";
	});	
	$("#selmonth").change(function(){
		location.href = "index.php?mod=carework&func=formview&id=6&pid=<?php echo $_GET['pid']; ?>&qdate="+$("#selmonth").val();	
	})
	
});
</script>
