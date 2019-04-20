<script>
$(function() {
    $( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 560,
		width: 900,
		modal: true,
		buttons: {
			"Edit Menu": function() {
				$.ajax({
					url: "class/foodmenu.php",
					type: "POST",
					data: {"date": $(this).data('date'), "meal1": $('#meal1').val(), "meal2": $('#meal2').val(), "meal3": $('#meal3').val(), "meal4": $('#meal4').val(), "meal5": $('#meal5').val(), "meal6": $('#meal6').val(), "meal7": $('#meal7').val(), "memo": $('#memo').val(), "Qfiller": '<?php echo $_SESSION['ncareID_lwj']; ?>'},
					success: function(data) {
						$( "#dialog-form" ).dialog( "close" );
						location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#dialog-form" ).dialog( "close" );
			}
		}
	});
});
function editmenu(dateno) {
	var dateS = dateno.replace(/-/g, "");
	var dateno2 = dateno.replace(/-/g, "/");
	$("#meal1").val($("#meal1_"+dateS).html().replace(/<br>/g, ";"));
	$("#meal2").val($("#meal2_"+dateS).html().replace(/<br>/g, ";"));
	$("#meal3").val($("#meal3_"+dateS).html().replace(/<br>/g, ";"));
	$("#meal4").val($("#meal4_"+dateS).html().replace(/<br>/g, ";"));
	$("#meal5").val($("#meal5_"+dateS).html().replace(/<br>/g, ";"));
	$("#meal6").val($("#meal6_"+dateS).html().replace(/<br>/g, ";"));
	$("#meal7").val($("#meal7_"+dateS).html().replace(/<br>/g, ";"));
	$("#memo").val($("#memo_"+dateS).html().replace(/<br>/g, ";"));
	$( "#dialog-form" ).data('date',dateno2).dialog( "open" );
}
</script>
<?php
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
<div style="background-color:rgba(255,255,255,0.8); border-radius:24px; padding:40px; padding-top:10px; width:92%">
<div id="dialog-form" title="Menu setting" class="dialog-form"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title">Breakfast</td>
        <td><input type="text" name="meal1" id="meal1" size="80" /> <input type="button" value="Clear" onclick="document.getElementById('meal1').value=''" /></td>
      </tr>
      <tr>
        <td class="title">Refreshment</td>
        <td><input type="text" name="meal2" id="meal2" size="80" /> <input type="button" value="Clear" onclick="document.getElementById('meal2').value=''" /></td>
      </tr>
      <tr>
        <td class="title">Lunch</td>
        <td><input type="text" name="meal3" id="meal3" size="80" /> <input type="button" value="Clear" onclick="document.getElementById('meal3').value=''" /></td>
      </tr>
      <tr>
        <td class="title">Refreshment</td>
        <td><input type="text" name="meal4" id="meal4" size="80" /> <input type="button" value="Clear" onclick="document.getElementById('meal4').value=''" /></td>
      </tr>
      <tr>
        <td class="title">Dinner</td>
        <td><input type="text" name="meal5" id="meal5" size="80" /> <input type="button" value="Clear" onclick="document.getElementById('meal5').value=''" /></td>
      </tr>
      <tr>
        <td class="title">Night refreshment</td>
        <td><input type="text" name="meal6" id="meal6" size="80" /> <input type="button" value="Clear" onclick="document.getElementById('meal6').value=''" /></td>
      </tr>
      <tr>
        <td class="title">Happy meal</td>
        <td><input type="text" name="meal7" id="meal7" size="80" /> <input type="button" value="Clear" onclick="document.getElementById('meal7').value=''" /></td>
      </tr>
      <tr>
        <td class="title">Comment</td>
        <td><input type="text" name="memo" id="memo" size="80" /> <input type="button" value="Clear" onclick="document.getElementById('memo').value=''" /></td>
      </tr>
    </table>
    <font color="#ff0000">※Use <b>;</b> to separeate</font>
  </fieldset>
  </form>
</div>
<form>
<table border="0" width="960" style="text-align:left; margin-left:3px;">
  <tr>
	<td align="left" style="border:none;"><h3><?php echo $year.'Year'.$month.'Month meal menu'; ?></h3></td>
	<td align="right" style="border:none;" id="printbtn"><input type="button" value="Manage cycle menu" onclick="window.location.href='index.php?mod=mealadmin&func=roundmenu'" />&nbsp;&nbsp;<a href="print.php?<?php echo $_SERVER['QUERY_STRING']; ?>" target="_blank"><img src="Images/print.png" border="0"></a></td>
  </tr>
</table>
</form>
<div class="content-table">
<table width="960">
<tr class="title">
  <td><input type="button" value="Previous month" onclick="window.location.href='index.php?mod=mealadmin&func=foodmenu&month=<?php echo $prev_month; ?>&year=<?php echo $prev_year; ?>'" /></td>
  <td colspan="5">
  <input type="button" value="Current month" onclick="window.location.href='index.php?mod=mealadmin&func=foodmenu&month=<?php echo date(m); ?>&year=<?php echo date(Y); ?>'" /> Quick Jump:<input type="text" name="inputy" id="inputy" size="4" value="<?php echo $year; ?>" />Year<input type="text" name="inputm" id="inputm" size="2" value="<?php echo $month; ?>" />Month <input type="button" value="Jump to" onclick="quickdate();" />
  </td>
  <td><input type="button" value="Next month" onclick="window.location.href='index.php?mod=mealadmin&func=foodmenu&month=<?php echo $next_month; ?>&year=<?php echo $next_year; ?>'" /></td>
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
	  //print_r($arrDayinfo[$i]); echo "<br>";
	  //ksort($arrDayinfo[$i]);
	  sort($arrDayinfo[$i]);
	  //print_r($arrDayinfo[$i]);
	  if (count($arrDayinfo[$i])>0) {
      echo "<tr class='title_s'>\n";
	  echo '<td colspan="7"><form style="display:inline;">The '.$i.' week <input type="button" onclick="window.location.href=\'index.php?mod=mealadmin&func=setroundmenu&year='.$year.'&month='.$month.'&week='.$i.'\'" value="Apply cycle menu"> </form> <form style="display:inline;" target="_blank" method="post" action="printfoodmenu.php"><input type="hidden" name="arrDate" value="'; foreach ($arrDayinfo[$i] as $k=>$v) { echo $v.';'; } echo '"><input type="submit" value="Print menu"></form></td>';
	  echo "</tr>\n";
      echo "<tr>\n";
	  for ($j=0;$j<7;$j++) {
	      $dateno = $arrDayinfo[$i][$j];
			  $db = new DB;
			  $db->query("SELECT * FROM `foodmenu` WHERE `date`='".str_replace("-","",$dateno)."'");
			  $r = $db->fetch_assoc();
			  $db1 = new DB;
			  $db1->query("SELECT * FROM `happymeal` WHERE `date`='".str_replace("-","",$dateno)."'");
		      echo '
			  <td valign="top"';
			  if ($dateno == date("Y-m-d")) { echo ' bgcolor="#FFCC99"'; }
			  echo '>
			  <div align="left"><font color="#666666">'.substr($dateno,strlen($dateno)-5,5).'</font> <input type="image" src="Images/edit_icon.png" border="0" width="14" height="14" onclick="editmenu(\''.$dateno.'\')" > <input type="image" src="Images/exchange.png" border="0" width="14" height="14" onclick="window.location.href=\'index.php?mod=mealadmin&func=exchangemenu&date1='.$dateno.'\'" ></div>
			  <p align="left">
			  <fieldset><legend>Breakfast</legend><span id="meal1_'.str_replace("-","",$dateno).'">'.$r['meal1'].'</span></fieldset>
			  <fieldset><legend>Refreshment</legend><span id="meal2_'.str_replace("-","",$dateno).'">'.$r['meal2'].'</span></fieldset>
			  <fieldset><legend>Lunch</legend><span id="meal3_'.str_replace("-","",$dateno).'">'.$r['meal3'].'</span></fieldset>
			  <fieldset><legend>Refreshment</legend><span id="meal4_'.str_replace("-","",$dateno).'">'.$r['meal4'].'</span></fieldset>
			  <fieldset><legend>Dinner</legend><span id="meal5_'.str_replace("-","",$dateno).'">'.$r['meal5'].'</span></fieldset>
			  <fieldset><legend>Night refreshment</legend><span id="meal6_'.str_replace("-","",$dateno).'">'.$r['meal6'].'</span></fieldset>';
			  echo '<fieldset ';
			  if ($db1->num_rows()==0) { echo 'style="display:none;"'; }
			  echo '><legend>Happy meal</legend><span id="meal7_'.str_replace("-","",$dateno).'">';
			  $meal7 = "";
			  for ($i1=0;$i1<$db1->num_rows();$i1++) {
				  $r1 = $db1->fetch_assoc();
				  if ($meal7!="") { $meal7 .= '<br>'; }
				  $meal7 .= $r1['title'];
			  }
			  echo $meal7;
			  echo '</span></fieldset>
			  <fieldset><legend>Comment</legend><span id="memo_'.str_replace("-","",$dateno).'">'.$r['memo'].'</span></fieldset>
			  </p>
			  <font size="2">Filled：'.checkusername($r['Qfiller']);
			  if ($r['exchanger']!="") {
				  echo '<br>Modified：'.checkusername($r['exchanger']);
			  }
			  echo '</font>
			  </td>'."\n";
	  }
	  }
	  echo "</tr>\n";
  }
  ?>
<tr class="title">
  <td><input type="button" value="Previous month" onclick="window.location.href='index.php?mod=mealadmin&func=foodmenu&month=<?php echo $prev_month; ?>&year=<?php echo $prev_year; ?>'" /></td>
  <td colspan="5">
  <input type="button" value="Current month" onclick="window.location.href='index.php?mod=mealadmin&func=foodmenu&month=<?php echo date(m); ?>&year=<?php echo date(Y); ?>'" /> Quick Jump:<input type="text" name="inputy2" id="inputy2" size="4" value="<?php echo $year; ?>" />Year<input type="text" name="inputm2" id="inputm2" size="2" value="<?php echo $month; ?>" />Month <input type="button" value="Jump to" onclick="quickdate2();" />
  <script>
  function quickdate() {
	 window.location.href='index.php?mod=mealadmin&func=foodmenu&month='+document.getElementById('inputm').value+'&year='+document.getElementById('inputy').value; 
  }
  function quickdate2() {
	 window.location.href='index.php?mod=mealadmin&func=foodmenu&month='+document.getElementById('inputm2').value+'&year='+document.getElementById('inputy2').value; 
  }
  </script>
  </td>
  <td><input type="button" value="Next month" onclick="window.location.href='index.php?mod=mealadmin&func=foodmenu&month=<?php echo $next_month; ?>&year=<?php echo $next_year; ?>'" /></td>
</tr>
</table>
</div></div><br><br>