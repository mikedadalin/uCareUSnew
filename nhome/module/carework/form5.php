<div class="moduleNoTab">
<h3>Work schedule/record</h3>
<?php 
if (@$_GET['qdate']==NULL) { $qdate = date('Y-m-d'); } else { $qdate = @$_GET['qdate']; }
?>
<form class="printcol" style="width:100%; margin:0 auto;">
	<div style="float:left;">
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
	<input type="button" value="Day shift" id="Add">
	<input type="button" value="Night shift" id="Add1">
	<input type="button" value="Print" id="Print">
</div>
</form>
<form  method="post" onsubmit="return checkForm();" style="text-align:center; width:100%; margin:0 auto;">
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
	<table border="0" align="center" cellpadding="5" style="width:100%; margin:0px auto;">
		<tr class="title printcol">
			<td colspan="9"><input type="button" onclick="window.location.href='index.php?mod=carework&func=formview&id=5&pid=<?php echo $_GET['pid']; ?>&qdate=<?php echo $lastweek; ?>'" value="Previous week"> <input type="button" onclick="window.location.href='index.php?mod=carework&func=formview&pid=<?php echo $_GET['pid']; ?>&id=5'" value="Back to current week"> <input type="button" onclick="window.location.href='index.php?mod=carework&func=formview&id=5&pid=<?php echo $_GET['pid']; ?>&qdate=<?php echo $nextweek; ?>'" value="Next week"></td>
		</tr>
		<tr class="title">
			<td width="200" colspan="2">Item(s)</td>
			<?php
			$i1 = 0;
			foreach ($arrPHPDay as $k=>$v) {
				if ($i1==0) { $n = 0; } else { $n = 1; }
				$d->modify("+".$n." day");
				$sd = $d->format('m/d');
				${'Day'.$i1} = $d->format('Ymd');
				?>
				<td width="70" align="center"><?php echo $k;?><br><?php echo $sd;?></td>
				<?php 
				$i1++;
			}
			?>
		</tr>
		<?php
		$db1 = new DB;
		$db1->query("SELECT * FROM `careform05` WHERE `HospNo`='".$HospNo."' AND `date`>='".$Day0."' AND `date`<='".$Day6."'");
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
					} else {
						${'Day'.$r1['date'].'_'.$k} = $v;
					}
				}  else {
					${'Day'.$r1['date'].'_'.$k} = $v;
				}
			}
		}
		$db2 = new DB;
		$db2->query("SELECT * FROM `careform05_2` WHERE `HospNo`='".$HospNo."' AND `date`>='".$Day0."' AND `date`<='".$Day6."'");
		for ($i4=0;$i4<$db2->num_rows();$i4++) {
			$r2 = $db2->fetch_assoc();
	  //print_r($r2);
			foreach ($r2 as $k=>$v) {
				if (substr($k,0,1)=="Q") {
					$arrAnswer = explode("_",$k);
					if (count($arrAnswer)==2) {
						if ($v==1) {
							${'Night'.$r2['date'].'_'.$arrAnswer[0]} .= $arrAnswer[1].';';
						}
					} else {
						${'Night'.$r2['date'].'_'.$k} = $v;
					}
				}  else {
					${'Night'.$r2['date'].'_'.$k} = $v;
				}
			}
		}
		?>
		<tr class="printcol">
			<td colspan="2" class="title"></td>
			<?php
			for ($i3=0;$i3<7;$i3++) {
				echo '<td align="center"><a href="index.php?mod=carework&func=formview&pid='.$_GET['pid'].'&id=5_1&date='.${'Day'.$i3}.'" title="Click on to modify">Day</a> / <a href="index.php?mod=carework&func=formview&pid='.$_GET['pid'].'&id=5_2&date='.${'Day'.$i3}.'" title="Click on to modify">Night</a></td>';
			}
			?>
		</tr>
		<tr>
			<td rowspan="7" class="title" width="80">Diet</td>
			<td class="title" width="120">Breakfast/Milk Sarapan/Susu</td>
			<?php
			for ($i3=0;$i3<7;$i3++) {
				$DQ1 =   option_result('Day'.${'Day'.$i3}."_Q1","Good;Fair;Poor","s","single",  ${'Day'.${'Day'.$i3}.'_Q1'},false,4);
				$NQ1 = option_result('Night'.${'Day'.$i3}."_Q1","Good;Fair;Poor","s","single",${'Night'.${'Day'.$i3}.'_Q1'},false,4);
				echo '<td align="center">'.($DQ1==""?"-":$DQ1).' / '.($NQ1==""?"-":$NQ1).'</td>';
			}
			?>
		</tr>
		<tr>
			<td class="title">AM Tea/Refreshment</td>
			<?php
			for ($i3=0;$i3<7;$i3++) {
				$DQ2 =   option_result('Day'.${'Day'.$i3}."_Q2","Good;Fair;Poor","s","single",  ${'Day'.${'Day'.$i3}.'_Q2'},false,4);
				$NQ2 = option_result('Night'.${'Day'.$i3}."_Q2","Good;Fair;Poor","s","single",${'Night'.${'Day'.$i3}.'_Q2'},false,4);
				echo '<td align="center">'.($DQ2==""?"-":$DQ2).' / '.($NQ2==""?"-":$NQ2).'</td>';	  }
				?>
			</tr>
			<tr>
				<td class="title">Lunch</td>
				<?php
				for ($i3=0;$i3<7;$i3++) {
					$DQ3 =   option_result('Day'.${'Day'.$i3}."_Q3","Good;Fair;Poor","s","single",  ${'Day'.${'Day'.$i3}.'_Q3'},false,4);
					$NQ3 = option_result('Night'.${'Day'.$i3}."_Q3","Good;Fair;Poor","s","single",${'Night'.${'Day'.$i3}.'_Q3'},false,4);
					echo '<td align="center">'.($DQ3==""?"-":$DQ3).' / '.($NQ3==""?"-":$NQ3).'</td>';
				}
				?>
			</tr>
			<tr>
				<td class="title">Afternoon Refreshment</td>
				<?php
				for ($i3=0;$i3<7;$i3++) {
					$DQ4 =   option_result('Day'.${'Day'.$i3}."_Q4","Good;Fair;Poor","s","single",  ${'Day'.${'Day'.$i3}.'_Q4'},false,4);
					$NQ4 = option_result('Night'.${'Day'.$i3}."_Q4","Good;Fair;Poor","s","single",${'Night'.${'Day'.$i3}.'_Q4'},false,4);
					echo '<td align="center">'.($DQ4==""?"-":$DQ4).' / '.($NQ4==""?"-":$NQ4).'</td>';
				}
				?>
			</tr>
			<tr>
				<td class="title">Dinner</td>
				<?php
				for ($i3=0;$i3<7;$i3++) {
					$DQ5 =   option_result('Day'.${'Day'.$i3}."_Q5","Good;Fair;Poor","s","single",  ${'Day'.${'Day'.$i3}.'_Q5'},false,4);
					$NQ5 = option_result('Night'.${'Day'.$i3}."_Q5","Good;Fair;Poor","s","single",${'Night'.${'Day'.$i3}.'_Q5'},false,4);
					echo '<td align="center">'.($DQ5==""?"-":$DQ5).' / '.($NQ5==""?"-":$NQ5).'</td>';
				}
				?>
			</tr>
			<tr>
				<td class="title">Evening Refreshement/Milk</td>
				<?php
				for ($i3=0;$i3<7;$i3++) {
					$DQ6 =   option_result('Day'.${'Day'.$i3}."_Q6","Good;Fair;Poor","s","single",  ${'Day'.${'Day'.$i3}.'_Q6'},false,4);
					$NQ6 = option_result('Night'.${'Day'.$i3}."_Q6","Good;Fair;Poor","s","single",${'Night'.${'Day'.$i3}.'_Q6'},false,4);
					echo '<td align="center">'.($DQ6==""?"-":$DQ6).' / '.($NQ6==""?"-":$NQ6).'</td>';
				}
				?>
			</tr>
			<tr>
				<td class="title">NGT Feeding</td>
				<?php
				for ($i3=0;$i3<7;$i3++) {
					$DQ7 =   option_result('Day'.${'Day'.$i3}."_Q12","Good;Fair;Poor","s","single",  ${'Day'.${'Day'.$i3}.'_Q12'},false,4);
					$NQ7 = option_result('Night'.${'Day'.$i3}."_Q12","Good;Fair;Poor","s","single",${'Night'.${'Day'.$i3}.'_Q12'},false,4);
					echo '<td align="center">'.($DQ7==""?"-":$DQ7).' / '.($NQ7==""?"-":$NQ7).'</td>';
				}
				?>
			</tr>
			<tr>
				<td rowspan="5" class="title">Activity</td>
				<td class="title">Rehabilitation</td>
				<?php
				for ($i3=0;$i3<7;$i3++) {
					$arr = explode(";",${'Day'.${'Day'.$i3}."_Q7"});
					$arr1 = explode(";",${'Night'.${'Day'.$i3}."_Q7"});
					echo '<td align="center">'.(in_array('1', $arr)?"&#10004;":"-").' / '.(in_array('1', $arr1)?"&#10004;":"-").'</td>';
				}
				?>
			</td>
		</tr>
		<tr>
			<td class="title">Practice Walking</td>
			<?php
			for ($i3=0;$i3<7;$i3++) {
				$arr = explode(";",${'Day'.${'Day'.$i3}."_Q7"});
				$arr1 = explode(";",${'Night'.${'Day'.$i3}."_Q7"});
				echo '<td align="center">'.(in_array('2', $arr)?"&#10004;":"-").' / '.(in_array('2', $arr1)?"&#10004;":"-").'</td>';
			}
			?>
		</tr>
		<tr>
			<td class="title">Transfer To Wheelchair</td>
			<?php
			for ($i3=0;$i3<7;$i3++) {
				$arr = explode(";",${'Day'.${'Day'.$i3}."_Q7"});
				$arr1 = explode(";",${'Night'.${'Day'.$i3}."_Q7"});
				echo '<td align="center">'.(in_array('3', $arr)?${'Day'.${'Day'.$i3}."_Q7a"}:"-").' / '.(in_array('3', $arr1)?${'Night'.${'Day'.$i3}."_Q7a"}:"-").'</td>';
			}
			?>
		</tr>
		<tr>
			<td class="title">Bed Rest</td>
			<?php
			for ($i3=0;$i3<7;$i3++) {
				$arr = explode(";",${'Day'.${'Day'.$i3}."_Q7"});
				$arr1 = explode(";",${'Night'.${'Day'.$i3}."_Q7"});
				echo '<td align="center">'.(in_array('4', $arr)?"&#10004;":"-").' / '.(in_array('4', $arr1)?"&#10004;":"-").'</td>';
			}
			?>
		</tr>
		<tr>
			<td class="title">Enhance Positioning(turn over)</td>
			<?php
			for ($i3=0;$i3<7;$i3++) {
				$arr = explode(";",${'Day'.${'Day'.$i3}."_Q7"});
				$arr1 = explode(";",${'Night'.${'Day'.$i3}."_Q7"});
				echo '<td align="center">'.(in_array('5', $arr)?"&#10004;":"-").' / '.(in_array('5', $arr1)?"&#10004;":"-").'</td>';
			}
			?>
		</tr>
		<tr>
			<td rowspan="5" class="title">Personal<br>Hygiene</td>
			<td class="title">Oral care</td>
			<?php
			for ($i3=0;$i3<7;$i3++) {
				$arr = explode(";",${'Day'.${'Day'.$i3}."_Q8"});
				$arr1 = explode(";",${'Night'.${'Day'.$i3}."_Q8"});
				echo '<td align="center">'.(in_array('1', $arr)?${'Day'.${'Day'.$i3}."_Q8a"}:"-").' / '.(in_array('1', $arr1)?${'Night'.${'Day'.$i3}."_Q8a"}:"-").'</td>';
			}
			?>
		</td>
	</tr>
	<tr>
		<td class="title">Arrange Bedsheet</td>
		<?php
		for ($i3=0;$i3<7;$i3++) {
			$arr = explode(";",${'Day'.${'Day'.$i3}."_Q8"});
			$arr1 = explode(";",${'Night'.${'Day'.$i3}."_Q8"});
			echo '<td align="center">'.(in_array('2', $arr)?${'Day'.${'Day'.$i3}."_Q8b"}:"-").' / '.(in_array('2', $arr1)?${'Night'.${'Day'.$i3}."_Q8b"}:"-").'</td>';
		}
		?>
	</tr>
	<tr>
		<td class="title">Cut Nails</td>
		<?php
		for ($i3=0;$i3<7;$i3++) {
			$arr = explode(";",${'Day'.${'Day'.$i3}."_Q8"});
			$arr1 = explode(";",${'Night'.${'Day'.$i3}."_Q8"});
			echo '<td align="center">'.(in_array('3', $arr)?"&#10004;":"-").' / '.(in_array('3', $arr1)?"&#10004;":"-").'</td>';
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
		for ($i3=0;$i3<7;$i3++) {
			$arr = explode(";",${'Day'.${'Day'.$i3}."_Q8"});
			$arr1 = explode(";",${'Night'.${'Day'.$i3}."_Q8"});
			echo '<td align="center">'.(in_array('4', $arr)?${'Day'.${'Day'.$i3}."_Q8c"}:"-").' / '.(in_array('4', $arr1)?${'Night'.${'Day'.$i3}."_Q8c"}:"-").'</td>';
		}
		?>
	</tr>
	<tr>
		<td class="title">Bathing</td>
		<?php
		for ($i3=0;$i3<7;$i3++) {
			$arr = explode(";",${'Day'.${'Day'.$i3}."_Q8"});
			$arr1 = explode(";",${'Night'.${'Day'.$i3}."_Q8"});
			echo '<td align="center">'.(in_array('5', $arr)?"&#10004;":"-").' / '.(in_array('5', $arr1)?"&#10004;":"-").'</td>';
		}
		?>
	</tr>
	<tr>
		<td rowspan="4" class="title">Other</td>
		<td class="title">Out Visiting (clinic,hospital,home...etc)</td>
		<?php
		for ($i3=0;$i3<7;$i3++) {
			$arr = explode(";",${'Day'.${'Day'.$i3}."_Q9"});
			$arr1 = explode(";",${'Night'.${'Day'.$i3}."_Q9"});
			echo '<td align="center">'.(in_array('1', $arr)?"&#10004;":"-").' / '.(in_array('1', $arr1)?"&#10004;":"-").'</td>';
		}
		?>
	</td>
</tr>
<tr>
	<td class="title">Steam Inhalation</td>
	<?php
	for ($i3=0;$i3<7;$i3++) {
		$arr = explode(";",${'Day'.${'Day'.$i3}."_Q9"});
		$arr1 = explode(";",${'Night'.${'Day'.$i3}."_Q9"});
		echo '<td align="center">'.(in_array('2', $arr)?${'Day'.${'Day'.$i3}."_Q9a"}:"-").' / '.(in_array('2', $arr1)?${'Night'.${'Day'.$i3}."_Q9a"}:"-").'</td>';
	}
	?>
</tr>
<tr>
	<td class="title">Skin Lotion</td>
	<?php
	for ($i3=0;$i3<7;$i3++) {
		$arr = explode(";",${'Day'.${'Day'.$i3}."_Q9"});
		$arr1 = explode(";",${'Night'.${'Day'.$i3}."_Q9"});
		echo '<td align="center">'.(in_array('3', $arr)?"&#10004;":"-").' / '.(in_array('3', $arr1)?"&#10004;":"-").'</td>';
	}
	?>
</tr>
<tr>
	<td class="title">Vaseline</td>
	<?php
	for ($i3=0;$i3<7;$i3++) {
		$arr = explode(";",${'Day'.${'Day'.$i3}."_Q9"});
		$arr1 = explode(";",${'Night'.${'Day'.$i3}."_Q9"});
		echo '<td align="center">'.(in_array('4', $arr)?"&#10004;":"-").' / '.(in_array('4', $arr1)?"&#10004;":"-").'</td>';
	}
	?>
</tr>
<tr>
	<td colspan="2" class="title">Family Visit</td>
	<?php
	for ($i3=0;$i3<7;$i3++) {
		echo '<td align="center">';
		  //早
		if(option_result(${'Day'.${'Day'.$i3}."_Q13"},"Spouse;Son;Daughter in law;Daughter;Grandson;Relative Relative;Friend;Personal aide;Other-","s","multi",${'Day'.${'Day'.$i3}."_Q13"},false,2).${'Day'.${'Day'.$i3}."_Q10"} !=""){
			echo option_result(${'Day'.${'Day'.$i3}."_Q13"},"Spouse;Son;Daughter in law;Daughter;Grandson;Relative Relative;Friend;Personal aide;Other-","s","multi",${'Day'.${'Day'.$i3}."_Q13"},false,2).${'Day'.${'Day'.$i3}."_Q10"};
		} else{
			echo '-';
		}
		echo ' / ';
		  //晚
		if(option_result(${'Night'.${'Day'.$i3}."_Q13"},"Spouse;Son;Daughter in law;Daughter;Grandson;Relative Relative;Friend;Personal aide;Other-","s","multi",${'Night'.${'Day'.$i3}."_Q13"},false,2).${'Night'.${'Day'.$i3}."_Q10"}!=""){
			echo option_result(${'Night'.${'Day'.$i3}."_Q13"},"Spouse;Son;Daughter in law;Daughter;Grandson;Relative Relative;Friend;Personal aide;Other-","s","multi",${'Night'.${'Day'.$i3}."_Q13"},false,2).${'Night'.${'Day'.$i3}."_Q10"};
		} else{
			echo '-';
		}
		echo '</td>';
	}?>
</tr>
<tr>
	<td colspan="2" class="title">Day Shift Record Filled By</td>
	<?php
	for ($i3=0;$i3<7;$i3++) {
		echo '<td align="center">'.checkusername(${'Day'.${'Day'.$i3}."_Qfiller"}).'</td>';
	}?>
</tr>
<tr>
	<td colspan="2" class="title">Night Shift Record Filled By</td>
	<?php
	for ($i3=0;$i3<7;$i3++) {
		echo '<td align="center">'.checkusername(${'Night'.${'Day'.$i3}."_Qfiller"}).'</td>';
	}?>
</tr>
<tr>
	<td colspan="2" class="title">Comment</td>
	<?php
	for ($i3=0;$i3<7;$i3++) {
		echo '<td align="center">'.(${'Day'.${'Day'.$i3}."_Q11"}==""?"-":${'Day'.${'Day'.$i3}."_Q11"}).' / '.(${'Night'.${'Day'.$i3}."_Q11"}==""?"-":${'Night'.${'Day'.$i3}."_Q11"}).'</td>';
	}?>
</tr>
</table>
</form>
</div>
<script language="javascript">
$(function() {
	$('#Add').click(function(){
		location.href = "index.php?mod=carework&func=formview&id=5_1&pid=<?php echo $_GET['pid']; ?>";
	});	
	$('#Add1').click(function(){
		location.href = "index.php?mod=carework&func=formview&id=5_2&pid=<?php echo $_GET['pid']; ?>";
	});	
	$('#Print').click(function(){
		var $dialog = $('<div title="Print" class="dialog-form"><table width="100%"><tr><td class="title">Select record</td></tr></table></div>').dialog({
			buttons: [{
				text: "Day shift work record",
				click: function(){
					window.open('print.php?mod=carework&func=printform5&pid=<?php echo $_GET['pid']; ?>&date='+$("#selmonth").val());
					$dialog.remove();
				}
			},
			{
				text: "Night shift work record",
				click: function(){
					window.open('print.php?mod=carework&func=printform5_2&pid=<?php echo $_GET['pid']; ?>&date='+$("#selmonth").val());
					$dialog.remove();
				}
			}]
		});	
	});
	$("#selmonth").change(function(){
		location.href = "index.php?mod=carework&func=formview&id=5&pid=<?php echo $_GET['pid']; ?>&qdate="+$("#selmonth").val();	
	})
	
});
</script>

