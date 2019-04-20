<div id="printbtn" class="content-formview">
	<?php
	$arrNoSelDate = array("1a", "1b", "1c", "1d", "3", "3_1", "3_2", "4", "4_1", "5", "5_1", "5_2", "6", "7", "7a","8", "8_1", "8_2", "8_3", "8_4", "8_5", "8_6", "9", "9p", "9_1", "9_2", "9_3", "8a","8_1a","8_2a","8_1OC", "10", "10_1", "10_2", "11", "11_1", "11_2", "11_3", "11_4", "12", "12_1", "12_2","13","14","15","16","16_1","16_3","17","17_1", "17_2", "17_3", "17_4","17_5","17_6","18","18_1","19","19_1");
	if (@$_GET['id']!=NULL) {
		echo '
	<div>
	    ';
	         if (!in_array(@$_GET['id'],$arrNoSelDate)) {
			echo '<a style="font-size:14px; font-weight:bolder; color:#e87217;">Substituting the saved data:</a>
	    <select id="inputeddate" onchange="gotoselecteddate();" style="font-size:14px;">
	        <option></option>';
	        $formID = mysql_escape_string($_GET['id']);
	        if (strlen((int)$formID)==1) {
	   	    $formID = '0'.$formID;
	        }
	        $tablename = mysql_escape_string($_GET['mod']).'form'.$formID;
	        $db = new DB;
	        $db->query("SELECT `date` FROM `".$tablename."` GROUP BY `date`");
	        for ($i=0;$i<$db->num_rows();$i++) {
	   	    $r = $db->fetch_assoc();
		    echo '<option value="'.$r['date'].'">'.formatdate($r['date']).'</option>';
	        }
	         echo '
	     </select>';
		}
	         echo '
	</div>
	<div style="border:1px; position:absolute; left:1006px; top:8px; background-color:rgba(255,255,255,0.8); border-radius:5px;" class="printcol" id="nurseformPrint">';
	if (@$_GET['id']!=17 && @$_GET['id']!='5' && @$_GET['id']!='7' && @$_GET['id']!='7a' && @$_GET['id'] !='1b'  && @$_GET['id'] !='8' && @$_GET['id'] !='1d' && @$_GET['id'] !='9' && @$_GET['id'] !='9_1' && @$_GET['id'] !='8_4' && @$_GET['id'] !='13' && @$_GET['id'] !='18' && @$_GET['id'] !='19' ) { echo '<a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank"><img src="Images/print.png" border="0"></a>'; }
	elseif (@$_GET['id']=='9') {
		echo '<a href="print.php?'.$_SERVER['QUERY_STRING'].'&id=9p" target="_blank"><img src="Images/print.png" border="0"></a>';
	}
	echo '</div>'; } ?>
</div>

<table border="0" style="text-align:center; border-radius:10px; width:100%">
<?php include("BackToListButton.php"); ?>
  <tr>
    <td style="width: 100%; border:none; background-color:rgba(255,255,255,0.8); border-radius:10px; padding:15px 15px; text-align:center;" colspan="2">
    <?php
	if (@$_GET['id']!=NULL) {
		echo '<div class="content-table">';
		include("form".@$_GET['id'].".php");
		echo '</div>';
	} else {
		include("formlist.php");
	}
	?>
    </td>
  </tr>
</table>
<script>
	var lastScrollTop = 0;
	$('#content2').scroll(function(event){
		var st = $(this).scrollTop();
        if(Math.abs(lastScrollTop - st) <= 5)
        return;
    if (st > lastScrollTop && st > 200){
        $(function(){
        	$('.header').removeClass('nav-down').addClass('nav-goup')
        	$('#content2').removeClass('content2Nav').addClass('content2Nav');
        	$('.content-query2').addClass('content-query2Nav');
        });
    } else if(lastScrollTop>st && (lastScrollTop-st>20) || st<=90){
        $(function(){
        	$('.header').removeClass('nav-goup').addClass('nav-down')
        	$('#content2').removeClass('content2Nav').addClass('content2N');
        	$('.content-query2').removeClass('content-query2Nav');
        });
    }
        lastScrollTop = st;
	});
</script>