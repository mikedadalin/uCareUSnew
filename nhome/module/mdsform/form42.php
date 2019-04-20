<?php
if($_GET['date']!=NULL){
  if($_GET['date']=='Select dates to edit information or new record'){
    $db = new DB;
    $db->query("SELECT * FROM `mdsform99` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
    $r = $db->fetch_assoc();
    $r['date'] = str_replace('-','',$r['date']);
    ?>
    <script>
    document.location.href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=<?php echo $_GET['id']; ?>&date=<?php echo $r['date'];?>";
    </script>
    <?php
  }
?>
<?php
$sql = "SELECT * FROM `mdsform42` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		${$k} = $v;
	}
}

$Qfiller = explode("&",$Qfiller);
for($i=0;$i<count($Qfiller);$i++){
$sql = "SELECT `name` FROM `userinfo` WHERE `userID`='".$Qfiller[$i]."'";
$db2 = new DB2;
$db2->query($sql);
if ($db2->num_rows()>0) {
	$r2 = $db2->fetch_assoc();
	foreach ($r2 as $k=>$v) {
		if((count($Qfiller)-$i)>2){
			$page42_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page42_Qfiller_name .= $v;
		}else{}
	}
}
}
$page42_Qfiller_name = str_replace(';',', ', $page42_Qfiller_name);
?>
<body class="s-page1-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page42_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<!-------------------------------------------->
<table cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.1875em">
<tr>
<td class="s-page1-section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section S</b></div></td>
<td class="s-page1-section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Massachusetts State-Specific Items</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="s-page1-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">S0170. Advanced Directives<?php if (substr($url[3],0,5)!="print"){ if($S0170_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - For those items with supporting documentation in the medical record, </b><br><b style="padding-left:2.7em">&#8595; Check all that apply:</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="s-page1-content" style="border-bottom-style:hidden; width:5.875em">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="s-page1-answer2"><?php echo $QS0170A; ?></td>
</tr>
</table>
</div>
</td>
<td class="s-page1-part" style="border-bottom-style:hidden; width:50em">
<ul class="s-page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li>Guardian
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="s-page1-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="s-page1-answer2"><?php echo $QS0170B; ?></td>
</tr>
</table>
</div>
</td>
<td class="s-page1-part" style="border-top-style:hidden; border-bottom-style:hidden">
<ul class="s-page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2">DPOA-HC
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="s-page1-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="s-page1-answer2"><?php echo $QS0170C; ?></td>
</tr>
</table>
</div>
</td>
<td class="s-page1-part" style="border-top-style:hidden; border-bottom-style:hidden">
<ul class="s-page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3">Living Will
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="s-page1-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="s-page1-answer2"><?php echo $QS0170D; ?></td>
</tr>
</table>
</div>
</td>
<td class="s-page1-part" style="border-top-style:hidden; border-bottom-style:hidden">
<ul class="s-page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4">Do Not Resuscitate
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="s-page1-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="s-page1-answer2"><?php echo $QS0170E; ?></td>
</tr>
</table>
</div>
</td>
<td class="s-page1-part" style="border-top-style:hidden; border-bottom-style:hidden">
<ul class="s-page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5">Do Not Hospitalize
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="s-page1-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="s-page1-answer2"><?php echo $QS0170F; ?></td>
</tr>
</table>
</div>
</td>
<td class="s-page1-part" style="border-top-style:hidden; border-bottom-style:hidden">
<ul class="s-page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6">Do Not Intubate
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="s-page1-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="s-page1-answer2"><?php echo $QS0170G; ?></td>
</tr>
</table>
</div>
</td>
<td class="s-page1-part" style="border-top-style:hidden; border-bottom-style:hidden">
<ul class="s-page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="7">Feeding Restrictions
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="s-page1-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="s-page1-answer2"><?php echo $QS0170H; ?></td>
</tr>
</table>
</div>
</td>
<td class="s-page1-part" style="border-top-style:hidden; border-bottom-style:hidden">
<ul class="s-page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="8">Other Treatment Restrictions
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="s-page1-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="s-page1-answer2"><?php echo $QS0170Z; ?></td>
</tr>
</table>
</div>
</td>
<td class="s-page1-part" style="border-top-style:hidden">
<ul class="s-page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="26">None Of The Above
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="s-page1-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">S0171. Health Care Proxy</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="s-page1-content" style="border-bottom-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="s-page1-answer"><?php echo $QS0171A; ?><?php if (substr($url[3],0,5)!="print"){ if($S0171A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="s-page1-part" style="border-bottom-style:hidden">
<ul class="s-page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Does resident have a health care proxy?</b>
</ul>
<ol class="s-page1-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li>No
<li>Yes
</ol>		  
</td>
</tr>	  	  
<!-------------------------------------------->
<tr> 
<td class="s-page1-content" style="border-top-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="s-page1-answer"><?php echo $QS0171B; ?><?php if (substr($url[3],0,5)!="print"){ if($S0171B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="s-page1-part" style="border-top-style:hidden">
<ul class="s-page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Has health care proxy been invoked?</b>
</ul>
<ol class="s-page1-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li>No
<li>Yes
</ol>		  
</td>
</tr>	  	  
<!-------------------------------------------->
<tr>
<td class="s-page1-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">S0172. Goals Of Care</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="s-page1-content" style="border-bottom-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="s-page1-answer"><?php echo $QS0172A; ?><?php if (substr($url[3],0,5)!="print"){ if($S0172A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="s-page1-part" style="border-bottom-style:hidden">
<ul class="s-page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>On admission, was documentation received by the facility from <br>the referring provider that a discussion of goals of care with the <br>resident or legal healthcare representative occurred?</b>
</ul>
<ol class="s-page1-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li>No
<li>Yes
<li value="9">Not Applicable
</ol>	
</td>
</tr>	  	  
<!-------------------------------------------->
<tr> 
<td class="s-page1-content" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="s-page1-part" style="border-top-style:hidden; border-bottom-style:hidden"><div style="margin-top:0.5em; margin-bottom:0.5em">
<b style="padding-left:0.3125em"><?php if (substr($url[3],0,5)!="print"){ if($S0172B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>If you answered `yes' to question S0172A, in which setting(s) did the </b><br><b style="padding-left:0.3125em">discussion take place? (check all that apply):</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="s-page1-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="s-page1-answer2"><?php echo $QS0172B; ?></td>
</tr>
</table>
</div>
</td>
<td class="s-page1-part" style="border-top-style:hidden; border-bottom-style:hidden">
<ul class="s-page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2">Hospital
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="s-page1-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="s-page1-answer2"><?php echo $QS0172C; ?></td>
</tr>
</table>
</div>
</td>
<td class="s-page1-part" style="border-top-style:hidden; border-bottom-style:hidden">
<ul class="s-page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3">Previous Nursing Home
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="s-page1-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="s-page1-answer2"><?php echo $QS0172D; ?></td>
</tr>
</table>
</div>
</td>
<td class="s-page1-part" style="border-top-style:hidden; border-bottom-style:hidden">
<ul class="s-page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4">Home without Home Health Services
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="s-page1-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="s-page1-answer2"><?php echo $QS0172E; ?></td>
</tr>
</table>
</div>
</td>
<td class="s-page1-part" style="border-top-style:hidden; border-bottom-style:hidden">
<ul class="s-page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5">Home with Home Health Services
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="s-page1-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="s-page1-answer2"><?php echo $QS0172F; ?></td>
</tr>
</table>
</div>
</td>
<td class="s-page1-part" style="border-top-style:hidden; border-bottom-style:hidden">
<ul class="s-page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6">PCP Office
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="s-page1-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="s-page1-answer2"><?php echo $QS0172G; ?></td>
</tr>
</table>
</div>
</td>
<td class="s-page1-part" style="border-top-style:hidden">
<ul class="s-page1-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="7">Other
</ul>
</td>
</tr>
</table>
<!-------------------------------------------->
<p style="font-size:0.8em">Form continues on next page<p>
<p style="font-size:0.8em">MA Section S Form - Effective 10/01/2013</p>
</body>
<?php
  }else{
	$db = new DB;
	$db->query("SELECT * FROM `mdsform99` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
	if($db->num_rows()>0){
		$r = $db->fetch_assoc();
		$r['date'] = str_replace('-','',$r['date']);
		?>
		<script>
        document.location.href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=<?php echo $_GET['id']; ?>&date=<?php echo $r['date'];?>";
        </script>
		<?php
	}else{
	  echo '
	  <div>
	    <table>
	      <tr>
	        <td>
		      Not have any record.
		    </td>
		  </tr>
		  <tr>
			<td>
		      Please click the button to preduce MDS.
		    </td>
	      </tr>
	    </table>
	  </div>
	  ';		
	}
  }
?>