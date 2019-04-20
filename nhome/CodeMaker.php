<?php
// 模組#1:跳出式表單
// 模組#2:表單不跳頁儲存
// 模組#3:用POST取name,name假設為id,抓name,確認id==name
// 模組#99:輸出Code
//
//
// 使用方式:
//     1.搜尋上方欲使用之模組
//     2.使用"實際使用"區塊 (修改A區變數即可,B區視需求修改)
//     3.搜尋"模組#99"      (修改A區,欲儲存之路徑,檔名,檔案類型)
//     4.把其他模組全部備註掉
//
// Author: Wei-Jhih Liao
//
//
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////


// 產生換行跳格 START **********
// 範例:
//    $rnt0 = "\r\n";
//    $rnt1 = "\r\n\t";
//    $rnt2 = "\r\n\t\t";
// 視需求修改 $i<10
for($i=0;$i<10;$i++){
	$t = "";
	for($j=1;$j<=$i;$j++){
		$t .= "\t";
	}
	${'rnt'.$i} = "\r\n".$t;
}
// 產生換行跳格 END ************




// 模組#1:跳出式表單 START ***********************************************************************************************
// == 範例 == START
/*
// -- A區 --
$ButtonID_open = "#OpenForm";
$formID = '#NewRecordForm';
$button_title = "New Record";
$url = "class/YOYOYO.php";
$Array_variable = array("HospNo","date","Qfiller");
$Array_value_ID = array("#HospNo","#date","#Qfiller");
$alert = "New Record Added";
// -- B區 --
$code .= '<script>';
$code .= $rnt0.'$(function() {';
$code .= $rnt1.'$("'.$formID.'").dialog({';
$code .= $rnt2.'autoOpen: false,';
$code .= $rnt2.'height: 700,';
$code .= $rnt2.'width: 800,';
$code .= $rnt2.'modal: true,';
$code .= $rnt2.'buttons: {';
$code .= $rnt3.'"'.$button_title.'": function() {';
$code .= $rnt4.'$.ajax({';
$code .= $rnt5.'url: "'.$url.'",';
$code .= $rnt5.'type: "POST",';
$code .= $rnt5.'data: {';
for($i=0;$i<count($Array_variable);$i++){
	if($i==0){
		$code .= '"'.$Array_variable[$i].'": $("'.$Array_value_ID[$i].'").val()';
	}else{
		$code .= ', "'.$Array_variable[$i].'": $("'.$Array_value_ID[$i].'").val()';
	}
}
$code .= '},';
$code .= $rnt5.'success: function(data) {';
$code .= $rnt6.'$("'.$formID.'").dialog( "close" );';
$code .= $rnt6.'alert("'.$alert.'");';
$code .= $rnt5.'}';
$code .= $rnt4.'});';
$code .= $rnt3.'},';
$code .= $rnt3.'"Cancel": function() {';
$code .= $rnt4.'$("'.$formID.'").dialog( "close" );';
$code .= $rnt3.'}';
$code .= $rnt2.'}';
$code .= $rnt1.'});';
$code .= $rnt1.'$("'.$ButtonID_open.'").button().click(function() {';
$code .= $rnt2.'$("'.$formID.'").dialog( "open" );';
$code .= $rnt1.'});';
$code .= $rnt0.'});';
$code .= $rnt0.'</script>';
$code .= $rnt0.'<?php';
$code .= $rnt0.'?>';
*/
// == 範例 == END
// == 實際使用 == START
/*
// -- A區 --
$ButtonID_open = "#OpenForm";
$formID = '#NewRecordForm';
$button_title = "New Record";
$url = "class/YOYOYO.php";
$Array_variable = array("HospNo","date","Qfiller");
$Array_value_ID = array("#HospNo","#date","#Qfiller");
$alert = "New Record Added";
// -- B區 --
$code .= '<script>';
$code .= $rnt0.'$(function() {';
$code .= $rnt1.'$("'.$formID.'").dialog({';
$code .= $rnt2.'autoOpen: false,';
$code .= $rnt2.'height: 700,';
$code .= $rnt2.'width: 800,';
$code .= $rnt2.'modal: true,';
$code .= $rnt2.'buttons: {';
$code .= $rnt3.'"'.$button_title.'": function() {';
$code .= $rnt4.'$.ajax({';
$code .= $rnt5.'url: "'.$url.'",';
$code .= $rnt5.'type: "POST",';
$code .= $rnt5.'data: {';
for($i=0;$i<count($Array_variable);$i++){
	if($i==0){
		$code .= '"'.$Array_variable[$i].'": $("'.$Array_value_ID[$i].'").val()';
	}else{
		$code .= ', "'.$Array_variable[$i].'": $("'.$Array_value_ID[$i].'").val()';
	}
}
$code .= '},';
$code .= $rnt5.'success: function(data) {';
$code .= $rnt6.'$("'.$formID.'").dialog( "close" );';
$code .= $rnt6.'alert("'.$alert.'");';
$code .= $rnt5.'}';
$code .= $rnt4.'});';
$code .= $rnt3.'},';
$code .= $rnt3.'"Cancel": function() {';
$code .= $rnt4.'$("'.$formID.'").dialog( "close" );';
$code .= $rnt3.'}';
$code .= $rnt2.'}';
$code .= $rnt1.'});';
$code .= $rnt1.'$("'.$ButtonID_open.'").button().click(function() {';
$code .= $rnt2.'$("'.$formID.'").dialog( "open" );';
$code .= $rnt1.'});';
$code .= $rnt0.'});';
$code .= $rnt0.'</script>';
$code .= $rnt0.'<?php';
$code .= $rnt0.'?>';
*/
// == 實際使用 == END
// 模組#1:跳出式表單 END ***********************************************************************************************







// 模組#2:表單不跳頁儲存 START ***********************************************************************************************
// == 範例 == START
/*
// -- A區 --
//利用$_POST取name,套入陣列 (需先用模組#3確認id==name)
//$input_name ="";
//foreach($_POST as $k => $v){
//	$input_name .= '"'.$k.'",';
//}
//$input_name = substr($input_name,0,strlen($input_name)-1);
$Button_submit = "#submit_".@$_GET['id'];
$url = "class/YOYOYO.php";
$Array_variable = array("HospNo","date","Qfiller");
$Array_value_ID = array("#HospNo","#date","#Qfiller");
$alert = "New Record Added";
// -- B區 --
$code .= '<script>';
$code .= $rnt0.'$(function() {';
$code .= $rnt1.'$("'.$Button_submit.'").button().click(function() {';
$code .= $rnt2.'$.ajax({';
$code .= $rnt3.'url: "'.$url.'",';
$code .= $rnt3.'type: "POST",';
$code .= $rnt3.'data: {';
for($i=0;$i<count($Array_variable);$i++){
	if($i==0){
		$code .= '"'.$Array_variable[$i].'": $("'.$Array_value_ID[$i].'").val()';
	}else{
		$code .= ', "'.$Array_variable[$i].'": $("'.$Array_value_ID[$i].'").val()';
	}
}
$code .= '},';
$code .= $rnt3.'success: function(data) {';
$code .= $rnt4.'alert("'.$alert.'");';
$code .= $rnt3.'}';
$code .= $rnt2.'});';
$code .= $rnt1.'});';
$code .= $rnt0.'});';
$code .= $rnt0.'</script>';
*/
// == 範例 == END
// == 實際使用 == START
/*
// -- A區 --
//利用$_POST取name,套入陣列 (需先用模組#3確認id==name)
//$input_name ="";
//foreach($_POST as $k => $v){
//	$input_name .= '"'.$k.'",';
//}
//$input_name = substr($input_name,0,strlen($input_name)-1);
$Button_submit = "#submit_".@$_GET['id'];
$url = "class/YOYOYO.php";
$Array_variable = array("HospNo","date","Qfiller");
$Array_value_ID = array("#HospNo","#date","#Qfiller");
$alert = "New Record Added";
// -- B區 --
$code .= '<script>';
$code .= $rnt0.'$(function() {';
$code .= $rnt1.'$("'.$Button_submit.'").button().click(function() {';
$code .= $rnt2.'$.ajax({';
$code .= $rnt3.'url: "'.$url.'",';
$code .= $rnt3.'type: "POST",';
$code .= $rnt3.'data: {';
for($i=0;$i<count($Array_variable);$i++){
	if($i==0){
		$code .= '"'.$Array_variable[$i].'": $("'.$Array_value_ID[$i].'").val()';
	}else{
		$code .= ', "'.$Array_variable[$i].'": $("'.$Array_value_ID[$i].'").val()';
	}
}
$code .= '},';
$code .= $rnt3.'success: function(data) {';
$code .= $rnt4.'alert("'.$alert.'");';
$code .= $rnt3.'}';
$code .= $rnt2.'});';
$code .= $rnt1.'});';
$code .= $rnt0.'});';
$code .= $rnt0.'</script>';
*/
// == 實際使用 == END
// 模組#2:表單不跳頁儲存 END ***********************************************************************************************







// 模組#3:用$_POST取name,name假設為id,抓name,確認id==name START ***********************************************************************************************
// 設定<form action="CodeMaker.php">接收$_POST,action視路徑修改 
// 產生的php檔,include到欲測試的php檔裡
/* <?php include("CodeMaker/Catch-name_AND_id.php"); ?> */
// == 範例 == START
/*
// -- A區 --
$input_name ="";
foreach($_POST as $k => $v){
	$input_name .= '"'.$k.'",';
}
$input_name = substr($input_name,0,strlen($input_name)-1);
// -- B區 --
$code .= '<script>';
$code .= $rnt0.'$(function() {';
$code .= $rnt1.'var id_and_name ="";';
$code .= $rnt1.'var name ="";';
$code .= $rnt1.'var diff_id_and_name ="";';
$code .= $rnt1.'var array_id = new Array('.$input_name.');';
$code .= $rnt1.'for(var i=0;i<array_id.length;i++){';
$code .= $rnt2.'name = document.getElementById(array_id[i]).name;';
$code .= $rnt2.'if(name!=array_id[i]){';
$code .= $rnt3.'diff_id_and_name += array_id[i]+" == "+name+"<br>";';
$code .= $rnt2.'}';
$code .= $rnt2.'id_and_name += array_id[i]+" == "+name+"<br>";';
$code .= $rnt1.'}';
$code .= $rnt1.'//alert(id_and_name);';
$code .= $rnt1.'//alert(diff_id_and_name);';
$code .= $rnt1.'//document.getElementById(\'id_and_name\').value = id_and_name;';
$code .= $rnt1.'//document.getElementById(\'diff_id_and_name\').value = diff_id_and_name;';
$code .= $rnt1.'document.getElementById(\'id_and_name\').innerHTML = id_and_name;';
$code .= $rnt1.'document.getElementById(\'diff_id_and_name\').innerHTML = diff_id_and_name;';
$code .= $rnt0.'});';
$code .= $rnt0.'</script>';
$code .= $rnt0.'<!--<textarea id="id_and_name"></textarea>-->';
$code .= $rnt0.'<!--<textarea id="diff_id_and_name"></textarea>-->';
$code .= $rnt0.'<div id="id_and_name"></div>';
$code .= $rnt0.'<div id="diff_id_and_name" style="font-weight:bolder; color:red;"></div>';
*/
// == 範例 == END
// == 實際使用 == START
/*
// -- A區 --
$input_name ="";
foreach($_POST as $k => $v){
	$input_name .= '"'.$k.'",';
}
$input_name = substr($input_name,0,strlen($input_name)-1);
// -- B區 --
$code .= '<script>';
$code .= $rnt0.'$(function() {';
$code .= $rnt1.'var id_and_name ="";';
$code .= $rnt1.'var name ="";';
$code .= $rnt1.'var diff_id_and_name ="";';
$code .= $rnt1.'var array_id = new Array('.$input_name.');';
$code .= $rnt1.'for(var i=0;i<array_id.length;i++){';
$code .= $rnt2.'name = document.getElementById(array_id[i]).name;';
$code .= $rnt2.'if(name!=array_id[i]){';
$code .= $rnt3.'diff_id_and_name += array_id[i]+" == "+name+"<br>";';
$code .= $rnt2.'}';
$code .= $rnt2.'id_and_name += array_id[i]+" == "+name+"<br>";';
$code .= $rnt1.'}';
$code .= $rnt1.'//alert(id_and_name);';
$code .= $rnt1.'//alert(diff_id_and_name);';
$code .= $rnt1.'//document.getElementById(\'id_and_name\').value = id_and_name;';
$code .= $rnt1.'//document.getElementById(\'diff_id_and_name\').value = diff_id_and_name;';
$code .= $rnt1.'document.getElementById(\'id_and_name\').innerHTML = id_and_name;';
$code .= $rnt1.'document.getElementById(\'diff_id_and_name\').innerHTML = diff_id_and_name;';
$code .= $rnt0.'});';
$code .= $rnt0.'</script>';
$code .= $rnt0.'<!--<textarea id="id_and_name"></textarea>-->';
$code .= $rnt0.'<!--<textarea id="diff_id_and_name"></textarea>-->';
$code .= $rnt0.'<div id="id_and_name"></div>';
$code .= $rnt0.'<div id="diff_id_and_name" style="font-weight:bolder; color:red;"></div>';
// == 實際使用 == END
*/
// 模組#3:用POST取name,name假設為id,抓name,確認id==name END ***********************************************************************************************










// 模組#4:產生表單框架 START ***********************************************************************************************
// == 範例 == START

// -- A區 --
$css_table = 'style="border:red 5px solid; font-size:20px;"';
$css_tr = 'style="background-color:yellow;"';
$css_td = 'style="border:blue 5px solid;"';
if($css_td!=""){ $css_td = " ".$css_td; }

$num_tr = 5;
$num_td = 5;

//$row_tag = array("2-1-3","5-1-2");  //  第幾行-第幾格-包含幾行
//$col_tag = array("1-1-2","1-4-2","2-2-2","4-1-5");  //  第幾行-第幾格-包含幾格

// -- B區 --
echo '<table '.$css_table.'>';
if(count($row_tag)>0){
	if(count($col_tag)>0){
		
	}else{
		for($i=0;$i<$num_tr;$i++){
			echo '<tr '.$css_tr.'>';
			for($j=0;$j<$num_td;$j++){
				$Need_row = 0;
				for($rz=0;$rz<count($row_tag);$rz++){
					$row_tag_array = explode("-",$row_tag[$rz]);
					if($i==($row_tag_array[0]-1) && $j==($row_tag_array[1]-1)){
						$Need_row = 1;
						$row_number = $row_tag_array[2];
					}
				}
				if($Need_row==1){
					$row = ' rowspan="'.$row_number.'"';
					echo '<td'.$row.$css_td.'>';
					echo '@@@';
					echo '</td>';
					for($rj=$j;$rj<($num_td-1);$rj++){
						echo '<td'.$css_td.'>';
						echo '@@@';
						echo '</td>';
					}
					echo '</tr>';
					for($ri=0;$ri<($row_number-1);$ri++){
						echo '<tr '.$css_tr.'>';
						for($rj=0;$rj<($num_td-1);$rj++){
							echo '<td'.$css_td.'>';
							echo '###';
							echo '</td>';
						}
						echo '</tr>';
					}
					$j = $num_td;
				}else{
					echo '<td'.$css_td.'>';
					echo '---';
					echo '</td>';
				}
			}
			echo '</tr>';
		}
	}
}else{
	if(count($col_tag)>0){
		for($i=0;$i<$num_tr;$i++){
			echo '<tr '.$css_tr.'>';
			for($j=0;$j<$num_td;$j++){
				$Need_col = 0;
				for($cz=0;$cz<count($col_tag);$cz++){
					$col_tag_array = explode("-",$col_tag[$cz]);
					if($i==($col_tag_array[0]-1) && $j==($col_tag_array[1]-1)){
						$Need_col = 1;
						$col_number = $col_tag_array[2];
					}
				}
				if($Need_col==1){
					$col = ' colspan="'.$col_number.'"';
					echo '<td'.$col.$css_td.'>';
					echo '@@@';
					echo '</td>';
					$j = $j+($col_number-1);
				}else{
					echo '<td'.$css_td.'>';
					echo '@@@';
					echo '</td>';
				}
			}
			echo '</tr>';
		}
	}else{
		for($i=0;$i<$num_tr;$i++){
			echo '<tr '.$css_tr.'>';
			for($j=0;$j<$num_td;$j++){
				echo '<td'.$css_td.'>';
				echo '@@@';
				echo '</td>';
			}
			echo '</tr>';
		}
	}
}
echo '</table>';







$code .= '<table '.$css_table.'>';
if(count($row_tag)>0){
	if(count($col_tag)>0){
		
	}else{
		for($i=0;$i<$num_tr;$i++){
			for($j=0;$j<$num_td;$j++){
				if($j==0){
					$code .= $rnt1.'<tr '.$css_tr.'>';
				}
				$Need_row = 0;
				for($rz=0;$rz<count($row_tag);$rz++){
					$row_tag_array = explode("-",$row_tag[$rz]);
					if($i==($row_tag_array[0]-1) && $j==($row_tag_array[1]-1)){
						$Need_row = 1;
						$row_number = $row_tag_array[2];
					}
				}
				if($Need_row==1){
					$row = ' rowspan="'.$row_number.'"';
					$code .= $rnt2.'<td'.$row.$css_td.'>@@@</td>';
					for($rj=$j;$rj<($num_td-1);$rj++){
						$code .= $rnt2.'<td'.$css_td.'>@@@</td>';
					}
					$code .= $rnt1.'</tr>';
					for($ri=0;$ri<($row_number-1);$ri++){
						$code .= $rnt1.'<tr '.$css_tr.'>';
						for($rj=0;$rj<($num_td-1);$rj++){
							$code .= $rnt2.'<td'.$css_td.'>###</td>';
						}
						$code .= $rnt1.'</tr>';
					}
					$j = $num_td;
				}else{
					$code .= $rnt2.'<td'.$css_td.'>---</td>';
				}
				if($j==($num_td-1)){
					$code .= $rnt1.'</tr>';
				}
			}
		}
	}
}else{
	if(count($col_tag)>0){
		for($i=0;$i<$num_tr;$i++){
			$code .= $rnt1.'<tr '.$css_tr.'>';
			for($j=0;$j<$num_td;$j++){
				$Need_col = 0;
				for($cz=0;$cz<count($col_tag);$cz++){
					$col_tag_array = explode("-",$col_tag[$cz]);
					if($i==($col_tag_array[0]-1) && $j==($col_tag_array[1]-1)){
						$Need_col = 1;
						$col_number = $col_tag_array[2];
					}
				}
				if($Need_col==1){
					$col = ' colspan="'.$col_number.'"';
					$code .= $rnt2.'<td'.$col.$css_td.'>@@@</td>';
					$j = $j+($col_number-1);
				}else{
					$code .= $rnt2.'<td'.$css_td.'>@@@</td>';
				}
			}
			$code .= $rnt1.'</tr>';
		}
	}else{
		for($i=0;$i<$num_tr;$i++){
			$code .= $rnt1.'<tr '.$css_tr.'>';
			for($j=0;$j<$num_td;$j++){
				$code .= $rnt2.'<td'.$css_td.'>@@@</td>';
			}
			$code .= $rnt1.'</tr>';
		}
	}
}
$code .= $rnt0.'</table>';

// == 範例 == END
// == 實際使用 == START
// == 實際使用 == END
// 模組#4:產生表單框架 END ***********************************************************************************************












// 模組#99:輸出Code START ***********************************************************************************************
// == 範例 == START
/*
// -- A區 --
$uploaddir = 'CodeMaker/';
$FileName = 'CodeMaker-test';
$FileType = '.php';
$getFileName = $uploaddir.$FileName.$FileType;
// -- B區 --
if (!file_exists($uploaddir)) { mkdir($uploaddir, 0777); }
//$data = iconv("UTF-8","big5",$data); //--------utf8轉big5-------- 
touch($getFileName);
if(@$fp = fopen($getFileName, 'w+')){
	fwrite($fp, $code);
	fclose($fp);
	?><script>alert('Produce Code: <? echo $FileName.$FileType;?>');</script><?
}
*/
// == 範例 == END
//
//
//
// == 實際使用 == START

// -- A區 --
$uploaddir = 'CodeMaker/';
$FileName = 'Auto-From';
$FileType = '.php';
$getFileName = $uploaddir.$FileName.$FileType;
// -- B區 --
if (!file_exists($uploaddir)) { mkdir($uploaddir, 0777); }
//$data = iconv("UTF-8","big5",$data); //--------utf8轉big5-------- 
touch($getFileName);
if(@$fp = fopen($getFileName, 'w+')){
	fwrite($fp, $code);
	fclose($fp);
	?><script>alert('Produce Code: <? echo $FileName.$FileType;?>');</script><?
}

// == 實際使用 == END
// 模組#99:輸出Code END ***********************************************************************************************
?>