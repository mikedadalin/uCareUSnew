<script type="text/javascript" src="js/LWJ_tabs.js"></script>
<table border="0" style="border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 20px; width:100%;">
<?php include("BackToListButton.php"); ?>
  <tr id="printbtn">
	<?php
	$arrSelDate = array("8_1", "8_2");
	$arrPrint = array("2_2");
	if (@$_GET['id']!=NULL) {
		echo '
	<td align="left" style="border:none;" width="540">
	    ';
	         if (in_array(@$_GET['id'],$arrSelDate)) {
			echo '<font style="color:yellow">Substituting the saved data:</font>
	    <select id="inputeddate" onchange="gotoselecteddate();">
	        <option></option>';
	        $formID = mysql_escape_string($_GET['id']);
	        if (strlen((int)$formID)==1) {
	   	    //$formID = '0'.$formID;
	        }
	        $tablename = mysql_escape_string($_GET['mod']).$formID;
	        $db = new DB;
	        $db->query("SELECT * FROM `".$tablename."` WHERE `EmpID`='".(mysql_escape_string($_GET['EmpID']))."' AND `EmpGroup`='".(mysql_escape_string($_GET['EmpGroup']))."' ORDER BY `date` DESC");
	        for ($i=0;$i<$db->num_rows();$i++) {
	   	    $r = $db->fetch_assoc();
		    echo '<option value="'.$r['date'].'">'.formatdate($r['date']).'</option>';
	        }
	         echo '
	     </select>';
		}
	         echo '
	</td>
	<td align="right" style="border:none;">';
	if (in_array(@$_GET['id'],$arrPrint)) { echo '<a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank"><img src="Images/print.png" border="0"></a>'; }
	echo '</td>'; } ?>
  </tr>
  <tr>
    <td style="border:none;" colspan="3">
    <?php
	if (@$_GET['id']!=NULL) {
		if (in_array(@$_GET['id'],$arrSelDate)) {
	        $formID = mysql_escape_string($_GET['id']);
	        if (strlen((int)$formID)==1) {
	   	    	//$formID = '0'.$formID;
	        }
			$tablename = mysql_escape_string($_GET['mod']).$formID;
			$db = new DB;
			$db->query("SELECT * FROM `".$tablename."` WHERE `EmpID`='".(mysql_escape_string($_GET['EmpID']))."' AND `EmpGroup`='".(mysql_escape_string($_GET['EmpGroup']))."' ORDER BY `date` DESC");
			echo '<div id="tabs" style="padding-top:12px;">'."\n";
			echo '<ul class="printcol">'."\n";
			echo '<li><a href="#tabs-0">New record</a></li>'."\n";
			$arrDate = array();
			for ($i=1;$i<=$db->num_rows();$i++) {
				$r = $db->fetch_assoc();
				echo '<li><a href="#tabs-'.$i.'">'.formatdate($r['date']).'<br>'.checkusername($r['Qfiller']).'</a></li>';
				$arrDate[$i] = $r['date'];
	        }
			echo '</ul>'."\n";
			
			echo '<div id="tabs-0" class="nurseform-table" style="padding:1px; font-size:11pt;">';
			if (in_array(@$_GET['id'],$arrSelDate)) { echo '<div style="position:absolute; right:14px; top:57px;" class="printcol"><a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank"><img src="Images/print.png" border="0"></a></div>'; }
			include("form".@$_GET['id'].".php");
			echo '</div>';
			
			foreach ($arrDate as $k=>$v) {
				?>
				<script>
                $('#tabs-<?php echo $k; ?>').ready( function() {
                    $('#tabs-<?php echo $k; ?> :input[type=text]').each( function () {
                        var cell = $(this);
						cell.attr('readonly', true);
						var cell_id = $(this).attr('id');
						$(this).attr('id', cell_id+'_<?php echo $v; ?>');
                    });
					$('#tabs-<?php echo $k; ?> textarea').each( function () {
                        var cell = $(this);
						$(this).replaceWith('<p>'+$(this).html()+'</p>');
						var cell_id = $(this).attr('id');
						$(this).attr('id', cell_id+'_<?php echo $v; ?>');
                    });
					$('#tabs-<?php echo $k; ?> select').each( function () {
                        var cell = $(this);
						cell.attr('disabled', true);
						var cell_id = $(this).attr('id');
						$(this).attr('id', cell_id+'_<?php echo $v; ?>');
                    });
                    $("#tabs-<?php echo $k; ?> :input[type=button]").each( function () {
                        $(this).hide();
                    });
					$("#tabs-<?php echo $k; ?> button[id^='btn_']").each( function () {
						$(this).show();
                        var cell = $(this);
						var cell_id = $(this).attr('id');
						$(this).attr('id', 'nouse_'+cell_id+'_<?php echo $v; ?>');
						$(this).attr('onmouseover', '');
						$(this).attr('onclick', '');
                    });
                    $("#tabs-<?php echo $k; ?> :input[type=submit]").each( function () {
                        $(this).remove();
                    });
                });
                </script>
                <?php
				echo '<div id="tabs-'.$k.'" class="nurseform-table" style="padding:1px; font-size:11pt;">';
				@$_GET['date']=$v;
				if (in_array(@$_GET['id'],$arrSelDate)) { echo '<div style="position:absolute; right:14px; top:57px;" class="printcol"><a href="print.php?'.$_SERVER['QUERY_STRING'].'&date='.$v.'" target="_blank"><img src="Images/print.png" border="0"></a></div>'; }
				include("form".@$_GET['id'].".php");
				echo '</div>';
			}
			echo '</div>'."\n";
		} else {
			
			echo '<div class="nurseform-table">';
			include("form".@$_GET['id'].".php");
			echo '</div>';
		}
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
    if (st > lastScrollTop && st > 90){
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