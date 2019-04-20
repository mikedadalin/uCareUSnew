<h3>Monthly billing operation</h3>
<?php

//模組名稱
$strModule = "stockform";

if (isset($_POST['submit'])) {
	
	 if($_POST['Smonth']=="01"){
		 $Y1 = date($_POST['Syear'])-1;
		 $M1 = "12";			 
	 } else{
		 $Y1 = date($_POST['Syear']);
		 $M1 = str_pad((date($_POST['Smonth'])-1),2,'0',STR_PAD_LEFT);
	 }	 
	$chkSdate = $Y1.'/'.$M1.'/'.chkDay($Y1.'/'.$M1.'/01',cSTKdate());
	$Y2 = date($_POST['Syear']);
	$M2 = str_pad(date($_POST['Smonth']),2,'0',STR_PAD_LEFT);
	$chkEdate = $Y2.'/'.$M2.'/'.chkDay($Y2.'/'.$M2.'/01',cSTKdate());
	$strQry = " AND `STK_Date` > '".$chkSdate."' AND `STK_Date` <='".$chkEdate."'";
	
	if (strtotime(date("Y/m/d"))>strtotime($chkEdate)) {
	
		if($_POST['Smonth']=="12"){
			$Y = date($_POST['Syear'])+1;  
			$m = "01";
		} else {
			$Y = date($_POST['Syear']);
			$m = str_pad((date($_POST['Smonth'])+1),2,'0',STR_PAD_LEFT);
		}
		
		$db4 = new DB;
		$db4->query("SELECT * FROM ".$strModule." WHERE isStatus='N' and STK_YEAR='".mysql_escape_string($_POST['Syear'])."' and STK_MONTH='".mysql_escape_string($_POST['Smonth'])."'");	
		if($db4->num_rows() > 0 ){	  
		  for ($i4=0;$i4<$db4->num_rows();$i4++) {
			  $r4 = $db4->fetch_assoc();
			  $db4a = new DB;
			  $db4a->query("SELECT * FROM ".$strModule." WHERE StockID='".$r4['StockID']."' AND STK_NO='".$r4['STK_NO']."' AND  isStatus='N' and STK_YEAR='".$Y."' and STK_MONTH='".$m."'");
			  if ($db4a->num_rows()>0) {
				  $r4a = $db4a->fetch_assoc();
				  $END_STK = ($r4['BE_STK']+$r4['IN_STK']-$r4['OUT_STK'])+$r4['ADJ_STK'];
				  $END_PRC = ($r4['BE_PRC']+$r4['IN_PRC']-$r4['OUT_PRC'])+$r4['ADJ_PRC'];
				  $db5 = new DB;
				  $db5->query("UPDATE ".$strModule." SET `BE_STK` = '".$END_STK."',`BE_PRC` = '".$END_PRC."' where StockID='".$r4a['StockID']."' AND STK_NO='".$r4a['STK_NO']."' AND isStatus='N' and STK_YEAR='".$Y."' and STK_MONTH='".$m."'");
			  } else {
				  $r4a = $db4a->fetch_assoc();
				  $END_STK = ($r4['BE_STK']+$r4['IN_STK']-$r4['OUT_STK'])+$r4['ADJ_STK'];
				  $END_PRC = ($r4['BE_PRC']+$r4['IN_PRC']-$r4['OUT_PRC'])+$r4['ADJ_PRC'];
				  $db6 = new DB;
				  $db6->query("INSERT INTO ".$strModule." (`StockID`,`STK_NO`,`Title`,`BE_STK`,`BE_PRC`,`STK_YEAR`,`STK_MONTH`) VALUES ('".$r4['StockID']."', '".$r4['STK_NO']."', '".$r4['Title']."', '".$END_STK."', '".$END_PRC."', '".$Y."', '".$m."')");
			  }
		  }
		  
		$db1 = new DB;	
		$db1->query("UPDATE ".$strModule." set IsStatus='M' where isStatus='N' AND STK_YEAR='".mysql_escape_string($_POST['Syear'])."' and STK_MONTH='".mysql_escape_string($_POST['Smonth'])."'");
		$db2 = new DB;	
		$db2->query("UPDATE firmstock set isStatus='M' where isStatus='N' ".$strQry." ");
		$db3 = new DB;
		$db3->query("UPDATE firmstockinfo set isStatus='M' where isStatus='N' ".$strQry." ");
		echo "<script>alert('過帳成功!');window.location.href='index.php?mod=consump&func=formview&id=9'</script>";
		  
		}else{
			echo "<script>alert('該月份已關帳!');window.location.href='index.php?mod=consump&func=formview&id=9_2'</script>";
		}
	} else {
		echo "<script>alert('此月份未到關帳日!');window.location.href='index.php?mod=consump&func=formview&id=9_2'</script>";
	}
}
?>
<form method="post" action="index.php?<?php echo $_SERVER['QUERY_STRING']; ?>" id="form1" name="form1">
<div align="left" class="content-query">
<table>
  <tr class="title">
    <td colspan="4" style="padding:10px 0px;">Monthly Billing Post Search</td>
  </tr>

   <tr>
    <td class="title" style="padding:10px 0px;">Inventory (annual) </td>
    <td align="center" >
	<select name="Syear" id="Syear">
    <?php for($ii = 2014 ;$ii<= 2024; $ii++){ ?>
    	<option value="<?php echo $ii; ?>" <?php if($_GET['Syear']==$ii) { echo 'selected'; } elseif ($_GET['Syear']==NULL && date(Y)==$ii) { echo 'selected'; } ?>><?php echo $ii." Year"; ?></option>
    <?php }?>
    </select>
	</td>
    <td class="title">Inventory (monthly) </td>
    <td align="center">
	<select name="Smonth" id="Smonth">
    <?php 
		
		for($ii = 1 ;$ii<= 12; $ii++){
			
	?>
    	<option value="<?php if($ii<10){echo "0".$ii;}else{echo $ii;} ?>" <?php if($_GET['Smonth']==$ii) { echo 'selected'; } elseif ($_GET['Smonth']==NULL && date(m)==$ii) { echo 'selected'; } ?>><?php echo $ii." Month"; ?></option>
      <?php }?>
    </select>
	</td>
    </tr>
</table>
<div style="margin-top:20px; text-align:center;">
	<input type="submit" value="Post" id="submit" name="submit" /> 
</div>
</div>
</form>
	