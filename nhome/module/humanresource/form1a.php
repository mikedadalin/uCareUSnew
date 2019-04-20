<h3>Domestic staff profile maintain</h3>
<div align="right">
<form>
<?php
if (@$_GET['query']==NULL || @$_GET['query']==1) {
?>
<input type="button" value="Display all staff" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=2&query=2'" />
<?php
} elseif (@$_GET['query']==2) {
?>
<input type="button" value="只顯示目前在職員工" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=2'" />
<?php
}
?>
<input type="button" value="Add new staff" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=2_1'" />
</form>
</div>
<div class="content-table">
<table>
<tr class="title">
  <td width="60">&nbsp;</td>
  <td width="60">Job title</td>
  <td width="70">Full name</td>
  <td width="40">Gender</td>
  <td width="80">DOB</td>
  <td>Date of reporting for duty</td>
  <td>Serving duration</td>
  <td>Resignation proof</td>
  <td>Served certificate</td>
  <td>Employment certificate</td>
</tr>
<?php
$sql1 = "SELECT * FROM `employer` ORDER BY `EmpID` ASC";
$db = new DB;
$db->query($sql1);
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				${$arrPatientInfo[0]} = $arrPatientInfo[1];
			}
		} else {
			${$k} = $v;
		}
	}
	if (@$_GET['query']==NULL || @$_GET['query']==1) {
	if ($Enddate1==NULL) {
	echo '
<tr>
  <td width="6%"><center><a href="index.php?mod=humanresource&func=formview&id=2_1&empid='.$r['EmpID'].'"><img src="Images/select.png"></a></center></td>
  <td>'.$Position.'</td>
  <td>'.$Name.'</td>
  <td>'.$arrGender[$Gender].'</td>
  <td>'.$Birth.'</td>
  <td>'.$Startdate1.'</td>
  <td>'.calcperiodwithyear(changedateformat1("/",$Startdate1),date(Ymd)).'</td>
  <td><form target="_blank" action="printHRform01a.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
  <td><form target="_blank" action="printHRform01b.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
  <td><form target="_blank" action="printHRform01c.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
</tr>'."\n";
	} elseif ($Startdate2!=NULL && $Enddate2==NULL) {
	echo '
<tr>
  <td width="6%"><center><a href="index.php?mod=humanresource&func=formview&id=2_1&empid='.$r['EmpID'].'"><img src="Images/select.png"></a></center></td>
  <td>'.$Position.'</td>
  <td>'.$Name.'</td>
  <td>'.$arrGender[$Gender].'</td>  <td>'.$Birth.'</td>
  <td>'.$Startdate2.'</td>
  <td>'.calcperiodwithyear(changedateformat1("/",$Startdate2),date(Ymd)).'</td>
  <td><form target="_blank" action="printHRform01a.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
  <td><form target="_blank" action="printHRform01b.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
  <td><form target="_blank" action="printHRform01c.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
</tr>'."\n";
	} elseif ($Startdate3!=NULL && $Enddate3==NULL) {
	echo '
<tr>
  <td width="6%"><center><a href="index.php?mod=humanresource&func=formview&id=2_1&empid='.$r['EmpID'].'"><img src="Images/select.png"></a></center></td>
  <td>'.$Position.'</td>
  <td>'.$Name.'</td>
  <td>'.$arrGender[$Gender].'</td>
  <td>'.$Birth.'</td>
  <td>'.$Startdate3.'</td>
  <td>'.calcperiodwithyear(changedateformat1("/",$Startdate3),date(Ymd)).'</td>
  <td><form target="_blank" action="printHRform01a.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
  <td><form target="_blank" action="printHRform01b.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
  <td><form target="_blank" action="printHRform01c.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
</tr>'."\n";
	}
	} elseif (@$_GET['query']==2) {
    echo '
<tr>
  <td width="6%"><center><a href="index.php?mod=humanresource&func=formview&id=2_1&empid='.$r['EmpID'].'"><img src="Images/select.png"></a></center></td>
  <td>'.$Position.'</td>
  <td>'.$Name.'</td>
  <td>'.$arrGender[$Gender].'</td>
  <td>'.$Birth.'</td>
  <td>---</td>
  <td>---</td>
  <td><form target="_blank" action="printHRform01a.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
  <td><form target="_blank" action="printHRform01b.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
  <td><form target="_blank" action="printHRform01c.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
</tr>'."\n";
	}
}
?>
</table>
</div>
<p>&nbsp;</p>