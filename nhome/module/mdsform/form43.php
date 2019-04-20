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
$sql = "SELECT * FROM `mdsform43` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page43_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page43_Qfiller_name .= $v;
		}else{}
	}
}
}
$page43_Qfiller_name = str_replace(';',', ', $page43_Qfiller_name);
?>
  <body class="s-page2-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page43_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<!-------------------------------------------->
    <table cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.1875em">
      <tr>
        <td class="s-page2-section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section S</b></div></td>
        <td class="s-page2-section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Massachusetts State-Specific Items</b></div></td>
      </tr>
    </table>
<!-------------------------------------------->
    <table cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
      <tr>
	    <td class="s-page2-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
		  <b style="padding-left:0.3125em">S0173. Goals Of Care</b></div>
		</td>
	  </tr>
<!-------------------------------------------->
      <tr> 
	    <td class="s-page2-content" style="width:5.875em">
		  <div style="padding-left:2.4em">
          <table>
           <tr>
		    <td class="s-page2-answer"><?php echo $QS0173; ?><?php if (substr($url[3],0,5)!="print"){ if($S0173_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
		   </tr>
		  </table>
		  </div>
		</td>
		<td class="s-page2-part" style="width:50em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
		  <b style="padding-left:0.3125em">Is there documentation in the medical record that a discussion of</b><br>
          <b style="padding-left:0.3125em">goals of care with the resident or legal healthcare representative</b><br>
          <b style="padding-left:0.3125em">occurred since the last comprehensive OBRA assessment was</b><br>
          <b style="padding-left:0.3125em">completed? (answer "9" if this is an admission assessment)</b>
          <ol class="s-page2-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
            <li>No
			<li>Yes
			<li value="9">Not Applicable
          </ol></div>
		</td>
      </tr>	  	  
<!-------------------------------------------->
      <tr>
	    <td class="s-page2-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
		  <b style="padding-left:0.3125em">S6230. Has Resident Received Antipsychotic</b></div>
		</td>
	  </tr>
<!-------------------------------------------->
      <tr> 
	    <td class="s-page2-content">
		  <div style="padding-left:2.4em">
          <table>
           <tr>
		    <td class="s-page2-answer"><?php echo $QS6230; ?><?php if (substr($url[3],0,5)!="print"){ if($S6230_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
		   </tr>
		  </table>
		  </div>
		</td>
		<td class="s-page2-part"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
		  <b style="padding-left:0.3125em">Has this resident received an antipsychotic medication since the</b><br>
		  <b style="padding-left:0.3125em">ARD of the last OBRA assessment, or, if this is an admission</b><br>
		  <b style="padding-left:0.3125em">assessment, since the Entry Date (A1600)? (if you answer "no", skip</b><br>
		  <b style="padding-left:0.3125em">questions S6232, S6234, S6236, and S2060)</b>
          <ol class="s-page2-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
            <li>No
			<li>Yes
          </ol></div>
		</td>
      </tr>	  	  
<!-------------------------------------------->
      <tr>
	    <td class="s-page2-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
		  <b style="padding-left:0.3125em">S6232. Is Resident Currently Receiving Antipsychotic</b></div>
		</td>
	  </tr>
<!-------------------------------------------->
      <tr> 
	    <td class="s-page2-content">
		  <div style="padding-left:2.4em">
          <table>
           <tr>
		    <td class="s-page2-answer"><?php echo $QS6232; ?><?php if (substr($url[3],0,5)!="print"){ if($S6232_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
		   </tr>
		  </table>
		  </div>
		</td>
		<td class="s-page2-part"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
		  <b style="padding-left:0.3125em">Is the resident currently receiving an antipsychotic medication? (if</b><br>
		  <b style="padding-left:0.3125em">you answer "no", skip questions S6234 and S6236)</b>
          <ol class="s-page2-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
            <li>No
			<li>Yes
          </ol></div>
		</td>
      </tr>	  	  
<!-------------------------------------------->
      <tr>
	    <td class="s-page2-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
		  <b style="padding-left:0.3125em">S6234. Attempt to Reduce Amount of Antipsychotic</b></div>
		</td>
	  </tr>
<!-------------------------------------------->
      <tr> 
	    <td class="s-page2-content">
		  <div style="padding-left:2.4em">
          <table>
           <tr>
		    <td class="s-page2-answer"><?php echo $QS6234; ?><?php if (substr($url[3],0,5)!="print"){ if($S6234_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
		   </tr>
		  </table>
		  </div>
		</td>
		<td class="s-page2-part"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
		  <b style="padding-left:0.3125em">Has an attempt been made to reduce the total amount of</b><br>
		  <b style="padding-left:0.3125em">antipsychotic medication the resident receives since the ARD</b><br>
		  <b style="padding-left:0.3125em">of the last OBRA assessment, or, if this is an admission</b><br>
		  <b style="padding-left:0.3125em">assessment, since the Entry Date (A1600)? (if you answer "no",</b><br>
		  <b style="padding-left:0.3125em">skip question S6236)</b>
          <ol class="s-page2-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
            <li>No
			<li>Yes
          </ol></div>
		</td>
      </tr>	  	  
<!-------------------------------------------->
      <tr>
	    <td class="s-page2-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
		  <b style="padding-left:0.3125em">S6236. Was Reduction in Antipsychotic Maintained</b></div>
		</td>
	  </tr>
<!-------------------------------------------->
      <tr> 
	    <td class="s-page2-content">
		  <div style="padding-left:2.4em">
          <table>
           <tr>
		    <td class="s-page2-answer"><?php echo $QS6236; ?><?php if (substr($url[3],0,5)!="print"){ if($S6236_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
		   </tr>
		  </table>
		  </div>
		</td>
		<td class="s-page2-part"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
		  <b style="padding-left:0.3125em">Was the reduction in the total amount of antipsychotic</b><br>
          <b style="padding-left:0.3125em">medication that the resident receives maintained?</b>
          <ol class="s-page2-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
            <li>No
			<li>Yes
          </ol></div>
		</td>
      </tr>	  	  
<!-------------------------------------------->
      <tr>
	    <td class="s-page2-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
		  <b style="padding-left:0.3125em">S2060.<?php if (substr($url[3],0,5)!="print"){ if($S2060_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> Resident Centered Care - For this resident, are any of the non‐pharmacological resident centered care</b>
		  <br><b style="padding-left:3.8em">techniques supported by the programs listed below included in the individualized resident centered care</b>
		  <br><b style="padding-left:3.8em">approach?</b>
		  <br><b style="padding-left:2.7em">&#8595; Check all items that apply:</b></div>
		</td>
	  </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="s-page2-content" style="border-bottom-style:hidden">
		  <div style="padding-left:2.5em">
          <table>
           <tr>
		    <td class="s-page2-answer2"><?php echo $QS2060A; ?></td>
		   </tr>
		  </table>
		  </div>
		</td>
		<td class="s-page2-part" style="border-bottom-style:hidden">
		  <ul class="s-page2-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
		    <li>Oasis
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
      <tr> 
	    <td class="s-page2-content" style="border-top-style:hidden; border-bottom-style:hidden">
		  <div style="padding-left:2.5em">
          <table>
           <tr>
		    <td class="s-page2-answer2"><?php echo $QS2060B; ?></td>
		   </tr>
		  </table>
		  </div>
		</td>
		<td class="s-page2-part" style="border-top-style:hidden; border-bottom-style:hidden">
		  <ul class="s-page2-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
		    <li value="2">Habilitation Therapy
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="s-page2-content" style="border-top-style:hidden; border-bottom-style:hidden">
		  <div style="padding-left:2.5em">
          <table>
           <tr>
		    <td class="s-page2-answer2"><?php echo $QS2060C; ?></td>
		   </tr>
		  </table>
		  </div>
		</td>
		<td class="s-page2-part" style="border-top-style:hidden; border-bottom-style:hidden">
		  <ul class="s-page2-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
		    <li value="3">Hand in Hand
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="s-page2-content" style="border-top-style:hidden; border-bottom-style:hidden">
		  <div style="padding-left:2.5em">
          <table>
           <tr>
		    <td class="s-page2-answer2"><?php echo $QS2060D; ?></td>
		   </tr>
		  </table>
		  </div>
		</td>
		<td class="s-page2-part" style="border-top-style:hidden; border-bottom-style:hidden">
		  <ul class="s-page2-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
		    <li value="4">Consistent Assignment
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="s-page2-content" style="border-top-style:hidden; border-bottom-style:hidden">
		  <div style="padding-left:2.5em">
          <table>
           <tr>
		    <td class="s-page2-answer2"><?php echo $QS2060E; ?></td>
		   </tr>
		  </table>
		  </div>
		</td>
		<td class="s-page2-part" style="border-top-style:hidden; border-bottom-style:hidden">
		  <ul class="s-page2-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
		    <li value="5">Other
		  </ul>
		</td>
      </tr>
<!-------------------------------------------->
	  <tr> 
	    <td class="s-page2-content" style="border-top-style:hidden">
		  <div style="padding-left:2.5em">
          <table>
           <tr>
		    <td class="s-page2-answer2"><?php echo $QS2060Z; ?></td>
		   </tr>
		  </table>
		  </div>
		</td>
		<td class="s-page2-part" style="border-top-style:hidden">
		  <ul class="s-page2-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
		    <li value="26">None of the above
		  </ul>
		</td>
      </tr>
	</table>
<!-------------------------------------------->
    <p style="font-size:10px">MA Section S Form - Effective 10/01/2013</p>
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