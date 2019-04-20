<?php
if(@$_GET['date']!="" && $_GET['pid']!=""){
	$db = new DB;
	$db->query("SELECT * FROM `mdsform99` WHERE `HospNo`=".$HospNo." AND `date`='".formatdate_Ymd_Dash($_GET['date'])."'");
	if($db->num_rows()==0){
		echo '<div style="font-size:40px; font-weight:bolder; padding:50px;"><font>No date!<br>Please select date<font></div>';
	}else{
		$TableName = array();
		for($i=1;$i<44;$i++){
			if(strlen($i)==1){
				$formNo = "0".$i;
			}else{
				$formNo = $i;
			}
			$formID = "mdsform".$formNo;
			array_push($TableName,$formID);
		}
		$test_status = 0; //測試狀態 0 1   是否顯示分頁
		$Array_date = array("A0900","A1600","A1900","A2000","A2200","A2300","A2400B","A2400C","M0300B3","O0250B","O0400A5","O0400A6","O0400B5","O0400B6","O0400C5","O0400C6","O0450B","V0100C","V0200B","V0200C","X0400","X0700A","X0700B","X0700C","X1100E","Z0500B");
		$Array_date2 = array("Z0400A3","Z0400B3","Z0400C3","Z0400D3","Z0400E3","Z0400F3","Z0400G3","Z0400H3","Z0400I3","Z0400J3","Z0400K3","Z0400L3");
		$Array_Decryption = array("QA0500A_1","QA0500A_2","QA0500A_3","QA0500A_4","QA0500A_5","QA0500A_6","QA0500A_7","QA0500A_8","QA0500A_9","QA0500A_10","QA0500A_11","QA0500A_12","QA0500B","QA0500C_1","QA0500C_2","QA0500C_3","QA0500C_4","QA0500C_5","QA0500C_6","QA0500C_7","QA0500C_8","QA0500C_9","QA0500C_10","QA0500C_11","QA0500C_12","QA0500C_13","QA0500C_14","QA0500C_15","QA0500C_16","QA0500C_17","QA0500C_18","QA0500D_1","QA0500D_2","QA0500D_3","QA0600A_1","QA0600A_2","QA0600A_3","QA0600A_4","QA0600A_5","QA0600A_6","QA0600A_7","QA0600A_8","QA0600A_9","QA0600B_1","QA0600B_2","QA0600B_3","QA0600B_4","QA0600B_5","QA0600B_6","QA0600B_7","QA0600B_8","QA0600B_9","QA0600B_10","QA0600B_11","QA0600B_12","QA0700_1","QA0700_2","QA0700_3","QA0700_4","QA0700_5","QA0700_6","QA0700_7","QA0700_8","QA0700_9","QA0700_10","QA0700_11","QA0700_12","QA1300A_1","QA1300A_2","QA1300A_3","QA1300A_4","QA1300A_5","QA1300A_6","QA1300A_7","QA1300A_8","QA1300A_9","QA1300A_10","QA1300A_11","QA1300A_12","QX0200A_1","QX0200A_2","QX0200A_3","QX0200A_4","QX0200A_5","QX0200A_6","QX0200A_7","QX0200A_8","QX0200A_9","QX0200A_10","QX0200A_11","QX0200A_12","QX0200C_1","QX0200C_2","QX0200C_3","QX0200C_4","QX0200C_5","QX0200C_6","QX0200C_7","QX0200C_8","QX0200C_9","QX0200C_10","QX0200C_11","QX0200C_12","QX0200C_13","QX0200C_14","QX0200C_15","QX0200C_16","QX0200C_17","QX0200C_18","QX0500_1","QX0500_2","QX0500_3","QX0500_4","QX0500_5","QX0500_6","QX0500_7","QX0500_8","QX0500_9");
		$Array_C0800_C0900 = array("C0800","C0900A","C0900B","C0900C","C0900D","C0900Z");
		$Array_C0900 = array("C0900A","C0900B","C0900C","C0900D","C0900Z");
		$Array_C0900_C1000 = array("C0900A","C0900B","C0900C","C0900D","C0900Z","C1000");
		$Array_Pressure_size = array("M0610A","M0610B","M0610C");
		$Select = "*";
		$date = formatdate_Ymd_Dash($_GET['date']);
		$Condition = "WHERE `HospNo`=".$HospNo." AND `date`='".$date."'";
		$data_tab = "Page";
		$uploaddir = 'MDS/'.$_SESSION['nOrgID_lwj'].'/';
		$FileName = 'MDS-'.date("Y-m-d").'_'.$_GET['pid'].'.xml';
		$getFileName = 'MDS/'.$_SESSION['nOrgID_lwj'].'/'.$FileName;
		$data = '<?xml version="1.0" encoding="UTF-8"?>';
		$data .= "\r\n\n".'<ASSESSMENT>';
		
		$data .= "\r\n\n".'<ASMT_SYS_CD>MDS</ASMT_SYS_CD>';
		$data .= "\r\n\n".'<ITM_SBST_CD>NC</ITM_SBST_CD>';
		$data .= "\r\n\n".'<ITM_SET_VRSN_CD>1.13</ITM_SET_VRSN_CD>';
		$data .= "\r\n\n".'<SPEC_VRSN_CD>1.15</SPEC_VRSN_CD>';
		$data .= "\r\n\n".'<PRODN_TEST_CD>P</PRODN_TEST_CD>';
		$data .= "\r\n\n".'<STATE_CD>MA</STATE_CD>';
		$data .= "\r\n\n".'<FAC_ID>1231_B</FAC_ID>';
		$data .= "\r\n\n".'<SFTWR_VNDR_ID>12321345</SFTWR_VNDR_ID >';
		$data .= "\r\n\n".'<SFTWR_VNDR_NAME>SOME VENDOR</SFTWR_VNDR_NAME >';
		$data .= "\r\n\n".'<SFTWR_VNDR_EMAIL_ADR>SUPPORT@VENDOR.COM</SFTWR_VNDR_EMAIL_ADR>';
		$data .= "\r\n\n".'<SFTWR_PROD_NAME>U-ARK America</SFTWR_PROD_NAME>';
		$data .= "\r\n\n".'<SFTWR_PROD_VRSN_CD>V2.44</SFTWR_PROD_VRSN_CD>';
		$data .= "\r\n\n".'<FAC_DOC_ID>A1334001</FAC_DOC_ID>';
		
		for($i=0;$i<count($TableName);$i++){
			$db = new DB;
			$db->query("SELECT ".$Select." FROM `".$TableName[$i]."` ".$Condition."");
			for ($i2=0;$i2<$db->num_rows();$i2++) {
				$r = $db->fetch_assoc();
				if($test_status==1){
					$data .= "\r\n\n".'<'.$data_tab.'_'.($i+1).'>';
				}
				$old_k = "";
				foreach ($r as $k=>$v) {
					if(in_array($k,$Array_Decryption)){
						/*== 解 START ==*/
	    				$rsa = new lwj('lwj/lwj');
	    				$puepart = explode(" ",$v);
	    				$puepartcount = count($puepart);
	    				if($puepartcount>1){
            				for($j=0;$j<$puepartcount;$j++){
                				$prdpart = $rsa->privDecrypt($puepart[$j]);
                				$v = $v.$prdpart;
            				}
	    				}else{
		   					$v = $rsa->privDecrypt($v);
	    				}
						/*== 解 END ==*/
					}
					$array_k = explode('_',$k);
					if(count($array_k)==2){
						$k_len = strlen($array_k[0])-1;
						$k_tab = substr($array_k[0],1,$k_len);
						if(in_array($k_tab,$Array_Pressure_size)){
							if($array_k[1]=="1"){ $v1 = $v;}
							if($array_k[1]=="2"){ $v2 = $v;}
							if($array_k[1]=="3"){ $v3 = $v;}
							${$k_tab} = $v1.$v2.".".$v3;
						}else{
							${$k_tab} .= $v;
						}
						if($old_k!=$k_tab){
							if($old_k==""){
								$old_k = $k_tab;
							}else{
								if(in_array($old_k,$Array_date)){
									${$old_k} = substr(${$old_k},4,4).substr(${$old_k},0,4);
								}
								$data .= "\r\n\n".'<'.$old_k.'>'.${$old_k}.'</'.$old_k.'>';
								$old_k = "";
							}
						}
					}else{
						if($old_k!=""){
							if(in_array($old_k,$Array_date)){
								if($old_k=="V0200B"){ $old_k="V0200B2"; }
								if($old_k=="V0200C"){ $old_k="V0200C2"; }
								${$old_k} = substr(${$old_k},4,4).substr(${$old_k},0,4);
							}
							$data .= "\r\n\n".'<'.$old_k.'>'.${$old_k}.'</'.$old_k.'>';
							$old_k = "";
						}
						if($k!="HospNo" && $k!="date" && $k!="Qfiller" && $k!="no"){
							$k_len = strlen($k)-1;
							$k_tab = substr($k,1,$k_len);
							if($k_tab=="O0100L"){ $k_tab="O0100L2"; }							
							if(in_array($k_tab,$Array_date2)){
								$v = explode("/",$v);
								$v = $v[2].$v[0].$v[1];
							}
							$tab_annex = '';
							/*
							if(in_array($k_tab,$Array_C0800_C0900)){
								$tab_annex = ' LOINC_ITEM="99999-9"';
							}
							if(in_array($k_tab,$Array_C0900_C1000)){
								$tab_annex .= ' LOINC_RESP="99999-9"';
							}
							*/
							if(in_array($k_tab,$Array_C0900)){
								if($v=="X"){ $v = "1"; }else{ $v = "0"; }
							}
							if($v=="X"){
								$v = "^";
							}
							if($k_tab=="A1000"){
								$arrA1000= array("A","B","C","D","E","F");
								for($iA1000=0;$iA1000<count($arrA1000);$iA1000++){
									if($v==$arrA1000[$iA1000]){
										$data .= "\r\n\n".'<'.$k_tab.$arrA1000[$iA1000].'>1</'.$k_tab.$arrA1000[$iA1000].'>';
									}else{
										$data .= "\r\n\n".'<'.$k_tab.$arrA1000[$iA1000].'>0</'.$k_tab.$arrA1000[$iA1000].'>';
									}
								}
							}else{
								${$k_tab} = $v;
								$data .= "\r\n\n".'<'.$k_tab.$tab_annex.'>'.${$k_tab}.'</'.$k_tab.'>';
							}
						}
					}
				}
				if($test_status==1){
					$data .= "\r\n\n".'</'.$data_tab.'_'.($i+1).'>';
				}
			}
		}
		$data .= "\r\n\n".'</ASSESSMENT>';
		
		if (!file_exists($uploaddir)) { mkdir($uploaddir, 0777); }
		//$data = iconv("UTF-8","big5",$data); //--------utf8轉big5-------- 
		touch($getFileName);
		if(@$fp = fopen($getFileName, 'w+')){
			fwrite($fp, $data);
			fclose($fp);
			?><script>alert('Export XML: <? echo $FileName;?>');</script><?
		}
		$url = "Download_MDS_XML.php?file=".$FileName;
?>
<div style="font-size:40px; font-weight:bolder; padding:50px;">
<a href="<?php echo $url;?>">Download XML:<br><?php echo $FileName;?></a>
</div>
<?php
	}
}else{
	echo '<div style="font-size:40px; font-weight:bolder; padding:50px;"><font>No date!<br>Please select date<font></div>';
}
?>