<div class="moduleNoTab">
<h3 style="margin-top:0px;">Domestic staff profile maintain</h3>
<div align="right">
	<form>
		<?php 

		if(@$_GET['query']==NULL){
			$class = 1;	
		}else{
			$class = $_GET['query'];
		}

		?>
		<input type="button" value="All staff" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=2&query=2'" class="<?php echo ($class==2?"Do":"");?>"/>
		<input type="button" value="Current employees" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=2'" class="<?php echo ($class==1?"Do":"");?>"/>
		<input type="button" value="Former employees" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=2&query=3'" class="<?php echo ($class==3?"Do":"");?>"/>
		<input type="button" value="Add new staff" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=2_1'" />
	</form>
</div>
<div class="content-table" style="width:100%;">
	<table style="width:100%;">
		<tr class="title">
			<td width="60">&nbsp;</td>
			<td width="60">Job title</td>
			<td width="70">Full name</td>
			<td width="40">Gender</td>
			<td width="80">DOB</td>
			<td>Serving duration</td>
			<td>Physical examination status</td>
			<td>Transfer list</td>
			<td>Resume</td>
			<td>Resignation application</td>
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
					<td align="center">'.$Position.'</td>
					<td align="center">'.$Name.'</td>
					<td align="center">'.$arrGender[$Gender].'</td>
					<td align="center">'.$Birth.'</td>
					<td align="center">'.calcperiodwithyear(changedateformat1("/",$Startdate1),date(Ymd)).'</td>
					<td align="center"><form action="index.php?mod=humanresource&func=formview&id=12&EmpID='.$EmpID.'" method="post"><input type="submit" value="Physical examination report"></form></td>  
					<td align="center"><form action="index.php?mod=humanresource&func=formview&id=10&EmpID='.$EmpID.'" method="post"><input type="submit" value="Transfer list"></form></td>  
					<td align="center"><form action="index.php?mod=humanresource&func=formview&id=2_2&empid='.$EmpID.'" method="post"><input type="submit" value="Resume"></form></td>
					<td align="center"><form target="_blank" action="printHRform01d.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					<td align="center"><form target="_blank" action="printHRform01a.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					<td align="center"><form target="_blank" action="printHRform01b.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					<td align="center"><form target="_blank" action="printHRform01c.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					</tr>'."\n";
				} elseif ($Startdate2!=NULL && $Enddate2==NULL) {
					echo '
					<tr>
					<td width="6%"><center><a href="index.php?mod=humanresource&func=formview&id=2_1&empid='.$r['EmpID'].'"><img src="Images/select.png"></a></center></td>
					<td align="center">'.$Position.'</td>
					<td align="center">'.$Name.'</td>
					<td align="center">'.$arrGender[$Gender].'</td>  <td align="center">'.$Birth.'</td>
					<td align="center">'.calcperiodwithyear(changedateformat1("/",$Startdate2),date(Ymd)).'</td>
					<td align="center"><form action="index.php?mod=humanresource&func=formview&id=12&EmpID='.$EmpID.'" method="post"><input type="submit" value="Physical examination report"></form></td>  
					<td align="center"><form action="index.php?mod=humanresource&func=formview&id=10&EmpID='.$EmpID.'" method="post"><input type="submit" value="Transfer list"></form></td>  
					<td align="center"><form action="index.php?mod=humanresource&func=formview&id=2_2&empid='.$EmpID.'" method="post"><input type="submit" value="Resume"></form></td>
					<td align="center"><form target="_blank" action="printHRform01d.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					<td align="center"><form target="_blank" action="printHRform01a.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					<td align="center"><form target="_blank" action="printHRform01b.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					<td align="center"><form target="_blank" action="printHRform01c.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					</tr>'."\n";
				} elseif ($Startdate3!=NULL && $Enddate3==NULL) {
					echo '
					<tr>
					<td width="6%"><center><a href="index.php?mod=humanresource&func=formview&id=2_1&empid='.$r['EmpID'].'"><img src="Images/select.png"></a></center></td>
					<td align="center">'.$Position.'</td>
					<td align="center">'.$Name.'</td>
					<td align="center">'.$arrGender[$Gender].'</td>
					<td align="center">'.$Birth.'</td>
					<td align="center">'.calcperiodwithyear(changedateformat1("/",$Startdate3),date(Ymd)).'</td>
					<td align="center"><form action="index.php?mod=humanresource&func=formview&id=12&EmpID='.$EmpID.'" method="post"><input type="submit" value="Physical examination report"></form></td>  
					<td align="center"><form action="index.php?mod=humanresource&func=formview&id=10&EmpID='.$EmpID.'" method="post"><input type="submit" value="Transfer list"></form></td>  
					<td align="center"><form action="index.php?mod=humanresource&func=formview&id=2_2&empid='.$EmpID.'" method="post"><input type="submit" value="Resume"></form></td>
					<td align="center"><form target="_blank" action="printHRform01d.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					<td align="center"><form target="_blank" action="printHRform01a.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					<td align="center"><form target="_blank" action="printHRform01b.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					<td align="center"><form target="_blank" action="printHRform01c.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					</tr>'."\n";
				}
			} elseif (@$_GET['query']==2) {
				echo '
				<tr>
				<td width="6%"><center><a href="index.php?mod=humanresource&func=formview&id=2_1&empid='.$r['EmpID'].'"><img src="Images/select.png"></a></center></td>
				<td align="center">'.$Position.'</td>
				<td align="center">'.$Name.'</td>
				<td align="center">'.$arrGender[$Gender].'</td>
				<td align="center">'.$Birth.'</td>
				<td align="center">---</td>
				<td align="center"><form action="index.php?mod=humanresource&func=formview&id=12&EmpID='.$EmpID.'" method="post"><input type="submit" value="Physical examination report"></form></td>  
				<td align="center"><form action="index.php?mod=humanresource&func=formview&id=10&EmpID='.$EmpID.'" method="post"><input type="submit" value="Transfer list"></form></td>  
				<td align="center"><form action="index.php?mod=humanresource&func=formview&id=2_2&empid='.$EmpID.'" method="post"><input type="submit" value="Resume"></form></td>
				<td align="center"><form target="_blank" action="printHRform01d.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
				<td align="center"><form target="_blank" action="printHRform01a.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
				<td align="center"><form target="_blank" action="printHRform01b.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
				<td align="center"><form target="_blank" action="printHRform01c.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
				</tr>'."\n";
			} elseif (@$_GET['query']==3) {
				if ($Enddate3!=NULL && $Startdate3!=NULL) {
					echo '
					<tr>
					<td width="6%"><center><a href="index.php?mod=humanresource&func=formview&id=2_1&empid='.$r['EmpID'].'"><img src="Images/select.png"></a></center></td>
					<td align="center">'.$Position.'</td>
					<td align="center">'.$Name.'</td>
					<td align="center">'.$arrGender[$Gender].'</td>
					<td align="center">'.$Birth.'</td>
					<td align="center">'.calcperiodwithyear(changedateformat1("/",$Startdate3),changedateformat1("/",$Enddate3)).'</td>
					<td align="center"><form action="index.php?mod=humanresource&func=formview&id=12&EmpID='.$EmpID.'" method="post"><input type="submit" value="Physical examination report"></form></td>    
					<td align="center"><form action="index.php?mod=humanresource&func=formview&id=10&EmpID='.$EmpID.'" method="post"><input type="submit" value="Transfer list"></form></td>  
					<td align="center"><form action="index.php?mod=humanresource&func=formview&id=2_2&empid='.$EmpID.'" method="post"><input type="submit" value="Resume"></form></td>
					<td align="center"><form target="_blank" action="printHRform01d.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					<td align="center"><form target="_blank" action="printHRform01a.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					<td align="center"><form target="_blank" action="printHRform01b.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					<td align="center"><form target="_blank" action="printHRform01c.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					</tr>'."\n";
				} elseif ($Startdate2!=NULL && $Enddate2!=NULL) {
					echo '
					<tr>
					<td width="6%"><center><a href="index.php?mod=humanresource&func=formview&id=2_1&empid='.$r['EmpID'].'"><img src="Images/select.png"></a></center></td>
					<td align="center">'.$Position.'</td>
					<td align="center">'.$Name.'</td>
					<td align="center">'.$arrGender[$Gender].'</td>  <td align="center">'.$Birth.'</td>
					<td align="center">'.calcperiodwithyear(changedateformat1("/",$Startdate2),changedateformat1("/",$Enddate2)).'</td>
					<td align="center"><form action="index.php?mod=humanresource&func=formview&id=12&EmpID='.$EmpID.'" method="post"><input type="submit" value="Physical examination report"></form></td>  
					<td align="center"><form action="index.php?mod=humanresource&func=formview&id=10&EmpID='.$EmpID.'" method="post"><input type="submit" value="Transfer list"></form></td>  
					<td align="center"><form action="index.php?mod=humanresource&func=formview&id=2_2&empid='.$EmpID.'" method="post"><input type="submit" value="Resume"></form></td>
					<td align="center"><form target="_blank" action="printHRform01d.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					<td align="center"><form target="_blank" action="printHRform01a.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					<td align="center"><form target="_blank" action="printHRform01b.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					<td align="center"><form target="_blank" action="printHRform01c.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					</tr>'."\n";
				} elseif ($Startdate1!=NULL && $Enddate1!=NULL) {
					echo '
					<tr>
					<td width="6%"><center><a href="index.php?mod=humanresource&func=formview&id=2_1&empid='.$r['EmpID'].'"><img src="Images/select.png"></a></center></td>
					<td align="center">'.$Position.'</td>
					<td align="center">'.$Name.'</td>
					<td align="center">'.$arrGender[$Gender].'</td>
					<td align="center">'.$Birth.'</td>
					<td align="center">'.calcperiodwithyear(changedateformat1("/",$Startdate1),changedateformat1("/",$Enddate1)).'</td>
					<td align="center"><form action="index.php?mod=humanresource&func=formview&id=12&EmpID='.$EmpID.'" method="post"><input type="submit" value="Physical examination report"></form></td>  
					<td align="center"><form action="index.php?mod=humanresource&func=formview&id=10&EmpID='.$EmpID.'" method="post"><input type="submit" value="Transfer list"></form></td>  
					<td align="center"><form action="index.php?mod=humanresource&func=formview&id=2_2&empid='.$EmpID.'" method="post"><input type="submit" value="Resume"></form></td>
					<td align="center"><form target="_blank" action="printHRform01d.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					<td align="center"><form target="_blank" action="printHRform01a.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					<td align="center"><form target="_blank" action="printHRform01b.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					<td align="center"><form target="_blank" action="printHRform01c.php?empid='.$EmpID.'" method="post"><input type="submit" value="Print"></form></td>
					</tr>'."\n";
				}	
			}
		}
		?>
	</table>
</div>
</div>