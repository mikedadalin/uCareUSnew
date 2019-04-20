<?php 
$date1 = ($_POST['date']=="" ? $_GET['date'] : $_POST['date']);
$date = "&date=".$date1;
?>
<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 0px 30px 0px; margin-bottom: 20px; width:100%;">
<table style="width:98%; margin:5px">
  <tr>
    <td valign="top" style="width:15%;">
      <div style="width:100%; background:rgba(88,88,88,0.9); border-radius:5px; padding: 7px 0px;"><?php include("ResidentCol.php"); ?></div>
    </td>
    <td valign="top" style="width:85%;">
      <table style="width:100%;">
        <tr>
          <td valign="middle" colspan="2"><h3 align="center">Overview</h3></td>
        </tr>

        <tr>
          <td align="left">
            <form style="float:left;"><input type="button" value="Input I/O value" onclick="window.location.href='index.php?mod=inputoutput&func=resplist2'"></form>
            <form style="float:left; margin-left:5px;" method="post" action="index.php?mod=inputoutput&func=formview"><a style="color:#ceac12; font-size:16px; font-weight:bold;">Date: </a><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php echo ""; ?>" size="12" ><input type="submit" value="Search"></form>
          </td>
          <td align="right">
            <font size="2"><a style="color:#3F3F3F; font-size:14px; font-weight:bold;">Each page display</a>
                              <a href="index.php?mod=inputoutput&func=formview&page=1&display=10<?php echo $date; ?>" style="color:#ceac12; font-size:14px; font-weight:bold;">10</a> 
                              <a href="index.php?mod=inputoutput&func=formview&page=1&display=20<?php echo $date; ?>" style="color:#ceac12; font-size:14px; font-weight:bold;">20</a> 
                              <a href="index.php?mod=inputoutput&func=formview&page=1&display=30<?php echo $date; ?>" style="color:#ceac12; font-size:14px; font-weight:bold;">30</a> 
                              <a href="index.php?mod=inputoutput&func=formview&page=1&display=50<?php echo $date; ?>" style="color:#ceac12; font-size:14px; font-weight:bold;">50</a> 
                              <a href="index.php?mod=inputoutput&func=formview&page=1&display=100<?php echo $date; ?>" style="color:#ceac12; font-size:14px; font-weight:bold;">100</a><a style="color:#3F3F3F; font-size:14px; font-weight:bold;"> Pieces of data</a></font>
          </td>
        </tr>
      </table>
<?php

//分頁顯示
switch (@$_GET['display']) {
	default:
	  $data_rows = 20;
	break;
	case '10':
	  $data_rows =10;
	break;
	case '20':
	  $data_rows =20;
	break;
	case '30':
	  $data_rows =30;
	break;
	case '50':
	  $data_rows =50;
	break;
	case '100':
	  $data_rows =100;
	break;
}

if (@$_GET['page']=="") { @$_GET['page']=1; }

if($date1 != ""){
	$dbqdate = " DATE_FORMAT(`RecordedTime`,'%Y-%m-%d') = '".str_replace('/','-',$date1)."' ";
}else{
	$dbqdate = " `RecordedTime` > '".str_replace('/','-',calcdayafterday(date('Y/m/d'),'-3'))."' ";
}
$dbpage = new DB;
$dbpage->query("SELECT `PersonID` FROM `iostatus` WHERE ".$dbqdate." GROUP BY `PersonID`, `RecordedTime` ORDER BY `RecordedTime` DESC ");

$pages = round(($dbpage->num_rows() / $data_rows) + 0.5); //計算頁數
$page_now = (@$_GET['page']-1)*$data_rows;
$previous_page = @$_GET['page']-1;
$next_page = @$_GET['page']+1;

if ($_SESSION['ncareOrgStatus_lwj']==2) {
	$arrNotStat = array();
	$db3 = new DB;
	$db3->query("SELECT `patientID`, `instat` FROM `patient` WHERE `instat`='0';");
	for ($i3=0; $i3<$db3->num_rows(); $i3++) {
		$r3 = $db3->fetch_assoc();
		$arrNotStat[$i3] = $r3['patientID'];
	}
}

?>
    <table cellpadding="6px" width="100%" style="font-size:10pt;">
      <tr bgcolor="#f54d5d" style="color:#ffffff;" class="title">
        <td>Full name<br />Name</td>
        <td>Total daily intake<br />I (Intake)</td>
        <td>Total daily output<br />O (Output)</td>
        <td>1. Stool<br />(STOOL)</td>
        <td>2. Number of other drainage tube<br />(Drain)</td>
        <td>3. Other<br />(Other)</td>
        <td>I-O = Daily<br />Positive and negative status</td>
        <td>Input time</td>
        <td>Filled by</td>
        <?php
        if ($_SESSION['ncareLevel_lwj']>=4) {
			echo '<td>Modify</td>';
		}
		?>
      </tr>
      <?php
	  $db2 = new DB;
	  $db2->query("SELECT * FROM `iostatus` WHERE ".$dbqdate." ORDER BY `RecordedTime` DESC LIMIT ".$page_now.",".$data_rows."");
	  for ($i=0;$i<$db2->num_rows();$i++) {
		  $r2 = $db2->fetch_assoc();
		  $recocordedtime = substr($r2['RecordedTime'],0,19);
		  if ($i%2==0) { $bgcolor = '#fee9e4'; } else { $bgcolor = '#ffffff'; }
		  echo '
	  <tr bgcolor="'.$bgcolor.'" align="left"'.($_SESSION['ncareOrgStatus_lwj']==2 && in_array($r2['PersonID'], $arrNotStat)?' style="display:none;"':"").'>
        <td><a href="index.php?mod=inputoutput&func=formview&pid='.$r2['PersonID'].'">'.getPatientName($r2['PersonID']).'</a></td>
        <td align="left">'.$r2['input'].'</td>
        <td align="left">'.$r2['output'].'</td>
        <td align="left">'.$r2['output1'].'</td>
        <td align="left">'.$r2['output2'].'</td>
        <td align="left">'.$r2['output3'].'</td>
        <td align="left">'.$r2['iostatus'].'</td>
        <td align="left">'.substr($recocordedtime,0,strlen($recocordedtime)-3).'</td>
		<td align="left">'.checkusername($r2['Qfiller']).'</td>'."\n";
		if ($_SESSION['ncareLevel_lwj']>=4) {
			echo '<td><a href="index.php?mod=inputoutput&func=respedit&pid='.$r2['PersonID'].'&time='.$recocordedtime.'"><img src="Images/edit_icon.png" width="20" border="0"></a></td>';
		}
		echo '
      </tr>
		  '."\n";
	  }
	  ?>
    </table>
<?php
echo '<table style="border-collapse: collapse;" cellpadding="5" bordercolor="#f7bbc3" border="1" width="100%"'.">\n";
echo '
  <tr>
    <td width="1000" align="center">'."\n";
if (@$_GET['page']!=1) { echo '<a href="index.php?mod=inputoutput&func=formview&page=1&display='.@$_GET['display'].$date.'"><<第一頁</a>　'."\n"; }
if (@$_GET['page']>1) { echo '<a href="index.php?mod=inputoutput&func=formview&page='.$previous_page.'&display='.@$_GET['display'].$date.'"><上一頁</a>　'."\n"; }
if (@$_GET['page']<=10) {
    $start = 1;
	$finish = 10;
} else {
	$multi = ceil(@$_GET['page']/10);
    $start = ($multi*10)-9;
	$finish = $multi*10;
}
if ($finish>$pages) { $finish=$pages; }
for ($i=$start;$i<=$finish;$i++) {
	if ($i!=@$_GET['page'])
	  {
		  echo '<a href="index.php?mod=inputoutput&func=formview&page='.$i.'&display='.@$_GET['display'].$date.'">'.$i.'</a>　'."\n";
	  } else {
		  echo '<font color="#FF0000"><u><b>'.$i.'</b></u></font>　'."\n";  
	  }
}
if (@$_GET['page']<$pages) { echo '<a href="index.php?mod=inputoutput&func=formview&page='.$next_page.'&display='.@$_GET['display'].$date.'">下一頁></a>　'."\n"; }
if (@$_GET['page']!=$pages) { echo '<a href="index.php?mod=inputoutput&func=formview&page='.$pages.'&display='.@$_GET['display'].$date.'">最後一頁>></a>　'."\n"; }
echo '  
	</td>
  </tr>'."\n";
echo "</table>\n";
?>
    </div>
    </td>
  </tr>
</table>
</div>