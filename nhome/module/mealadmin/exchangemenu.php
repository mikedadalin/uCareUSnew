<?php
if (@$_GET['date1']!=NULL && @$_GET['date2']==NULL && @$_GET['confirm']=="") {
	if (@$_GET['month']==NULL) { $month = date(m); } else { $month = @$_GET['month']; }
	if (@$_GET['year']==NULL) { $year = date(Y); } else { $year = @$_GET['year']; }
	if (strlen($month)==1) { $month = '0'.$month; }
	$weeks = weekcount($year.$month.monthlastday($month,$year));
	$monthdays = date(t,strtotime($year.'-'.$month.'-01'));
	
	$arrDayinfo = array();
	
	for ($i=1;$i<=$monthdays;$i++) {
		$wday = date(w,strtotime($year.'-'.$month.'-'.$i));
		if ($wday==0) { $wday=7; }
		if (strlen($i)==1) { $day = '0'.$i; } else { $day = $i; }
		$weekno = weekcount($year.$month.$day);
		$arrDayinfo[$weekno][$wday] = $year.'-'.$month.'-'.$day;
	}
	
	$FirstWeekLastMonthDays = 7-count($arrDayinfo[1])-1;
	$lastmonth = $month-1; if ($lastmonth==0) { $lastmonth=12; $lastyear = $year-1; } else { $lastyear = $year; }
	if (strlen($lastmonth)==1) { $lastmonth = "0".$lastmonth; }
	$LastMonthLastDay = date(t,strtotime($lastyear.'-'.$lastmonth.'-01'));
	$LastMonthLastWeekStartDay = $LastMonthLastDay - $FirstWeekLastMonthDays;
	$lastmonthdaycount = 1;
	for ($i=$LastMonthLastWeekStartDay;$i<=$LastMonthLastDay;$i++) {
		$arrDayinfo[1][$lastmonthdaycount] = $lastyear.'-'.$lastmonth.'-'.$i;
		$lastmonthdaycount++;
	}
	$LastWeekNextMonthDays = 7-count($arrDayinfo[$weeks]);
	
	$FirstWeekNextMonthDays = 7-count($arrDayinfo[$weekno]);
	$nextmonth = $month+1; if ($nextmonth==13) { $nextmonth=1; $nextyear = $year+1; } else { $nextyear = $year; }
	if (strlen($nextmonth)==1) { $nextmonth = "0".$nextmonth; }
	for ($i=1;$i<=$FirstWeekNextMonthDays;$i++) {
		$arrDayinfo[$weekno][(1+count($arrDayinfo[$weekno]))] = $nextyear.'-'.$nextmonth.'-0'.$i;
	}
	
	//print_r($arrDayinfo);
	
	$prev_month = $month-1;
	$prev_year = $year;
	if ($prev_month==0) { $prev_month = 12; $prev_year = $prev_year-1; }
	$next_month = $month+1;
	$next_year = $year;
	if ($next_month==13) { $next_month = 1; $next_year = $next_year+1; }
	?>
	<table border="0" width="960" style="text-align:left; margin-left:3px;">
	  <tr>
		<td align="left" style="border:none;">
        <h3>菜單對調</h3>
        <script>alert('請選擇要與 <?php echo @$_GET['date1']; ?> 對調菜單的日期');</script>
        </td>
	  </tr>
	</table>
	</form>
	<div class="content-table">
	<table width="960">
	<tr class="title">
	  <td><input type="button" value="Previous month" onclick="window.location.href='index.php?mod=mealadmin&func=exchangemenu&month=<?php echo $prev_month; ?>&year=<?php echo $prev_year; ?>&date1=<?php echo @$_GET['date1']; ?>'" /></td>
	  <td colspan="5">
	  <input type="button" value="Current month" onclick="window.location.href='index.php?mod=mealadmin&func=exchangemenu&month=<?php echo date(m); ?>&year=<?php echo date(Y); ?>&date1=<?php echo @$_GET['date1']; ?>'" /> Quick Jump:<input type="text" name="inputy" id="inputy" size="4" value="<?php echo $year; ?>" />Year<input type="text" name="inputm" id="inputm" size="2" value="<?php echo $month; ?>" />Month <input type="button" value="Jump to" onclick="quickdate();" />
	  </td>
	  <td><input type="button" value="Next month" onclick="window.location.href='index.php?mod=mealadmin&func=exchangemenu&month=<?php echo $next_month; ?>&year=<?php echo $next_year; ?>&date1=<?php echo @$_GET['date1']; ?>'" /></td>
	</tr>
	<tr class="title">
	  <td width="14%">Mon</td>
	  <td width="14%">Tue</td>
	  <td width="14%">Wed</td>
	  <td width="14%">Thu</td>
	  <td width="14%">Fri</td>
	  <td width="14%">Sat</td>
	  <td width="14%">Sun</td>
	</tr>
	<?php
	//print_r($arrDayinfo);
	  for ($i=1;$i<=$weeks;$i++) {
		  ksort($arrDayinfo[$i]);
		  if (count($arrDayinfo[$i])>0) {
		  echo "<tr>\n";
		  for ($j=1;$j<=7;$j++) {
			  $dateno = $arrDayinfo[$i][$j];
				  $db = new DB;
				  $db->query("SELECT * FROM `foodmenu` WHERE `date`='".str_replace("-","",$dateno)."'");
				  $r = $db->fetch_assoc();
				  echo '
				  <td valign="top"';
				  if ($dateno == @$_GET['date1']) { echo ' bgcolor="#999999" style="color:#666666;"'; }
				  echo '>
				  <div align="left"><font color="#666666">'.substr($dateno,strlen($dateno)-5,5).'</font>';
				  if ($dateno != @$_GET['date1']) { echo ' <input type="image" src="Images/exchange.png" border="0" width="14" height="14" onclick="window.location.href=\'index.php?mod=mealadmin&func=exchangemenu&date1='.@$_GET['date1'].'&date2='.$dateno.'\'" >'; }
				  echo '</div>
				  <p align="left">
				  <fieldset><legend>Breakfast</legend><span id="meal1_'.str_replace("-","",$dateno).'">'.$r['meal1'].'</span></fieldset>
				  <fieldset><legend>Refreshment</legend><span id="meal2_'.str_replace("-","",$dateno).'">'.$r['meal2'].'</span></fieldset>
				  <fieldset><legend>Lunch</legend><span id="meal3_'.str_replace("-","",$dateno).'">'.$r['meal3'].'</span></fieldset>
				  <fieldset><legend>Refreshment</legend><span id="meal4_'.str_replace("-","",$dateno).'">'.$r['meal4'].'</span></fieldset>
				  <fieldset><legend>Dinner</legend><span id="meal5_'.str_replace("-","",$dateno).'">'.$r['meal5'].'</span></fieldset>
				  <fieldset><legend>Night refreshment</legend><span id="meal6_'.str_replace("-","",$dateno).'">'.$r['meal6'].'</span></fieldset>
				  </p>
				  </td>'."\n";
		  }
		  }
		  echo "</tr>\n";
	  }
	  ?>
	<tr class="title">
	  <td><input type="button" value="Previous month" onclick="window.location.href='index.php?mod=mealadmin&func=exchangemenu&month=<?php echo $prev_month; ?>&year=<?php echo $prev_year; ?>&date1=<?php echo @$_GET['date1']; ?>'" /></td>
	  <td colspan="5">
	  <input type="button" value="Current month" onclick="window.location.href='index.php?mod=mealadmin&func=exchangemenu&month=<?php echo date(m); ?>&year=<?php echo date(Y); ?>&date1=<?php echo @$_GET['date1']; ?>'" /> Quick Jump:<input type="text" name="inputy2" id="inputy2" size="4" value="<?php echo $year; ?>" />Year<input type="text" name="inputm2" id="inputm2" size="2" value="<?php echo $month; ?>" />Month <input type="button" value="Jump to" onclick="quickdate2();" />
	  <script>
	  function quickdate() {
		 window.location.href='index.php?mod=mealadmin&func=exchangemenu&month='+document.getElementById('inputm').value+'&year='+document.getElementById('inputy').value+'&date1=<?php echo @$_GET['date1']; ?>'; 
	  }
	  function quickdate2() {
		 window.location.href='index.php?mod=mealadmin&func=exchangemenu&month='+document.getElementById('inputm2').value+'&year='+document.getElementById('inputy2').value+'&date1=<?php echo @$_GET['date1']; ?>'; 
	  }
	  </script>
	  </td>
	  <td><input type="button" value="Next month" onclick="window.location.href='index.php?mod=mealadmin&func=exchangemenu&month=<?php echo $next_month; ?>&year=<?php echo $next_year; ?>&date1=<?php echo @$_GET['date1']; ?>'" /></td>
	</tr>
	</table>
	</div>
<?php
} elseif (@$_GET['date1']!=NULL && @$_GET['date2']!=NULL && @$_GET['confirm']=="") {
?>
<div style="min-height:400px;" align="left" class="nurseform-table">
<h3>你已經選擇要將 <?php echo @$_GET['date1']; ?> 與 <?php echo @$_GET['date2']; ?> 兩日的菜單對調</h3>
<form>
<table width="600">
  <tr class="title">
    <td width="80">&nbsp;</td>
    <td><?php echo @$_GET['date1']; ?></td>
    <td rowspan="7" width="60" class="title_s"><font size="6">&larr;<br>&rarr;</font></td>
    <td><?php echo @$_GET['date2']; ?></td>
  </tr>
  <?php
  $db1 = new DB;
  $db1->query("SELECT * FROM `foodmenu` WHERE `date`='".str_replace("-","",@$_GET['date1'])."'");
  $r1 = $db1->fetch_assoc();
  $db2 = new DB;
  $db2->query("SELECT * FROM `foodmenu` WHERE `date`='".str_replace("-","",@$_GET['date2'])."'");
  $r2 = $db2->fetch_assoc();
  ?>
  <tr>
    <td class="title_s">Breakfast</td>
    <td align="center"><?php echo $r1['meal1']; ?></td>
    <td align="center"><?php echo $r2['meal1']; ?></td>
  </tr>
  <tr>
    <td class="title_s">Refreshment</td>
    <td align="center"><?php echo $r1['meal2']; ?></td>
    <td align="center"><?php echo $r2['meal2']; ?></td>
  </tr>
  <tr>
    <td class="title_s">Lunch</td>
    <td align="center"><?php echo $r1['meal3']; ?></td>
    <td align="center"><?php echo $r2['meal3']; ?></td>
  </tr>
  <tr>
    <td class="title_s">Refreshment</td>
    <td align="center"><?php echo $r1['meal4']; ?></td>
    <td align="center"><?php echo $r2['meal4']; ?></td>
  </tr>
  <tr>
    <td class="title_s">Dinner</td>
    <td align="center"><?php echo $r1['meal5']; ?></td>
    <td align="center"><?php echo $r2['meal5']; ?></td>
  </tr>
  <tr>
    <td class="title_s">Night refreshment</td>
    <td align="center"><?php echo $r1['meal6']; ?></td>
    <td align="center"><?php echo $r2['meal6']; ?></td>
  </tr>
  <tr>
    <td class="title" colspan="4"><input type="button" value="Confirm" onclick="window.location.href='index.php?mod=mealadmin&func=exchangemenu&date1=<?php echo @$_GET['date1']; ?>&date2=<?php echo @$_GET['date2']; ?>&confirm=1'"> <input type="button" value="修改Select date" onclick="window.location.href='index.php?mod=mealadmin&func=exchangemenu&month=<?php echo date(m); ?>&year=<?php echo date(Y); ?>&date1=<?php echo @$_GET['date1']; ?>';
"> <input type="button" value="取消，返回菜單管理" onclick="window.location.href='index.php?mod=mealadmin&func=foodmenu&month=<?php echo date(m); ?>&year=<?php echo date(Y); ?>';"></td>
  </tr>
</table>
</form>
</div>
<?php
} elseif (@$_GET['date1']!="" && @$_GET['date2']!="" && @$_GET['confirm']==1) {
	$db3a = new DB;
	$db3a->query("UPDATE `foodmenu` SET `date`='99999999', `exchanger`='".$_SESSION['ncareID_lwj']."' WHERE `date`='".str_replace('-','',@$_GET['date1'])."'");
	$db3b = new DB;
	$db3b->query("UPDATE `foodmenu` SET `date`='".str_replace('-','',@$_GET['date1'])."', `exchanger`='".$_SESSION['ncareID_lwj']."' WHERE `date`='".str_replace('-','',@$_GET['date2'])."'");
	$db3c = new DB;
	$db3c->query("UPDATE `foodmenu` SET `date`='".str_replace('-','',@$_GET['date2'])."' WHERE `date`='99999999' AND `exchanger`='".$_SESSION['ncareID_lwj']."'");
	echo "<script>window.location.href='index.php?mod=mealadmin&func=foodmenu&month=".date(m)."&year=".date(Y)."';</script>";
} else {
?>
<script>
alert('系統錯誤，返回菜單列表');
window.location.href='index.php?mod=mealadmin&func=foodmenu&month=<?php echo date(m); ?>&year=<?php echo date(Y); ?>';
</script>
<?php
}
?>