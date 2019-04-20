<div class="content-table">
<form><h3>Import examination report</h3>
<table width="100%">
  <tr class="title">
    <td>Resident name</td>
    <td>care ID#</td>
    <td>Import result</td>
    <td>Note</td>
    <td>View</td>
  </tr>
<?php
$DestDIR = "C:\inetpub\wwwroot\uCare\uploadfile";
$File_Extension = explode(".", $_FILES['labreportcsv']['name']);
$File_Extension = $File_Extension[count($File_Extension)-1];
$File_Extension = strtolower($File_Extension);
$ServerFilename = date(YmdHis) . "." . $File_Extension;
$msg = array();
if ($_FILES["labreportcsv"]['size']>0)
{
	$pathfile = $DestDIR . "/" . $ServerFilename;
	//copy($_FILES['labreportcsv']['tmp_name'] , $pathfile );
	$file_handle = fopen($_FILES['labreportcsv']['tmp_name'], "r");
	while (!feof($file_handle)) {
		$line = fgets($file_handle);
		$value = explode(',',$line);
		$reportdate = iconv("Big5", "UTF-8", $value[2]); //報告產出日期 report generated date
		$name = iconv("Big5", "UTF-8", $value[6]); //Resident name resident name
		$labID = iconv("Big5", "UTF-8", $value[7]); //檢驗項目ID examination category ID
		$labCode = iconv("Big5", "UTF-8", $value[8]); //檢驗項目醫囑代碼 exam category prescription code
		$labName = iconv("Big5", "UTF-8", $value[9]); //檢驗項目名稱exam category name
		$labValue = iconv("Big5", "UTF-8", $value[10]); //檢驗數值exam value
		if (count($value)>1) {
			$querydb = new DB;
			$querydb->query("SELECT `patientID`, `HospNo` FROM `patient` WHERE `Name` LIKE '".mysql_escape_string($name)."'");
			if ($querydb->num_rows()==0) {
				$msg[$name] = "<tr><td>".$name."</td><td>---</td><td><font color='#ff0000'>失敗</font></td><td>沒有此住民</td><td>---</td></tr>";
			} elseif ($querydb->num_rows()>1) {
				$msg[$name] = "<tr><td>".$name."</td><td>---</td><td><font color='#ff0000'>失敗</font></td><td>住民重複</td><td>---</td></tr>";
			} else {
				$rdb = $querydb->fetch_assoc();
				$querylabitem = new DB;
				$querylabitem->query("SELECT `name` FROM `labitem` WHERE `id`='".$labID."'");
				if ($querylabitem->num_rows()==0) {
					if (substr($labID,0,1)==3) { $cateName = "血液blood"; }
					elseif  (substr($labID,0,1)==4 && substr($labID,1,1)==8) { $cateName = "糞便stool"; }
					elseif  (substr($labID,0,1)==4 && substr($labID,1,1)==3) { $cateName = "糞便stool"; }
					elseif  (substr($labID,0,1)==4) { $cateName = "尿液urine"; }
					elseif  (substr($labID,0,1)==6) { $cateName = "生化血液biochemistry blood"; }
					else { $cateName = "---"; }
					$InsertNewLabItem = new DB;
					$InsertNewLabItem->query("INSERT INTO `labitem` VALUES ('".mysql_escape_string($labID)."', '".$cateName."', '".mysql_escape_string($labName)."')");
				}
				$updatedb = new DB;
				$updatedb->query("INSERT INTO `labpatient` VALUES ('".mysql_escape_string($rdb['patientID'])."', '".mysql_escape_string($reportdate)."', '".mysql_escape_string($labID)."', '".mysql_escape_string($labValue)."')");
				$msg[$name] = "<tr><td>".$name."</td><td>".$rdb['HospNo']."</td><td><font color='#00ff00'>已匯入</font></td><td>---</td><td><a href=\"index.php?mod=nurseform&func=formview&pid=".$rdb['patientID']."&id=20&query=0&date=".$reportdate."\" target=\"_blank\"><img src=\"Images/nurseform_icons/notes.png\"></a></td></tr>";
			}
		}
	}
	fclose($file_handle);
	unlink($_FILES['labreportcsv']['tmp_name']);
}
foreach ($msg as $k=>$v) { echo $v."\n"; }
?>
</table>
</form>
</div>