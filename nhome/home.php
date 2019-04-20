<script>
$(function() {
    $( "div[id^=notice]" ).accordion({
		heightStyle: "content",
		collapsible: true
	});
	$(".ui-accordion-content").show();
	$("h3[id^=ui-accordion-notice1-header]").removeClass('ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-accordion-icons').addClass('ui-accordion-header ui-helper-reset ui-state-default ui-accordion-header-active ui-state-active ui-corner-top ui-accordion-icons');
});
</script>
<?php
$db1 = new DB2;
$db1->query("SELECT * FROM `permissionset` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."' AND `Group`='".$_SESSION['ncareGroup_lwj']."'");
$r1 = $db1->fetch_assoc();

$arrHomeLink = array();
$arrPermissionSet = explode(";",$r1['PermissionSet']);

if (count($arrPermissionSet)==1 || $r1['PermissionSet']==NULL) {
	echo "<script>window.location.href='".$r1['DirectLink']."';</script>";
} else {
	$db1a = new DB2;
	$db1a->query("SELECT a.`order`, a.`link`, a.`color`, a.`Name`, a.`icon` FROM `permission2` a INNER JOIN `permission_subcate` b ON a.`PermissionID`=b.`cateID` INNER JOIN `permission_item` c ON b.subcateID=c.subcateID INNER JOIN `user_permission` d ON d.serNo = c.serNo AND d.userID='".$_SESSION['ncareID_lwj']."' AND d.level='1' GROUP BY a.Name ORDER BY `order`;");
	for ($i1a=0;$i1a<$db1a->num_rows();$i1a++) {
		$r1a = $db1a->fetch_assoc();
		$arrHomeLink[$r1a['order']] = array('Name'=>$r1a['Name'], 'link'=>$r1a['link'], 'color'=>$r1a['color'], 'icon'=>$r1a['icon']);
	}
}

$table_rowno = ceil(count($arrHomeLink)/3);

?>
<table id="carelistTable" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" width="100%">
      <div style="text-align:center">
        <?php
        $dbstat1 = new DB;
        $dbstat1->query("SELECT * FROM `bedinfo` a LEFT JOIN `inpatientinfo` b ON a.`bedID`=b.`bed` WHERE a.`bedID`!=''");
        $TotalBed = $dbstat1->num_rows();        
        $dbstat2 = new DB;
        $dbstat2->query("SELECT * FROM `inpatientinfo` a INNER JOIN `patient` b ON a.`patientID`=b.`patientID`;");
        $InpaitentNo = $dbstat2->num_rows();
        $EmptyBed = $TotalBed - $InpaitentNo;
        $dbstat3a = new DB;
        $dbstat3a->query("SELECT b.`gender_1`, b.`gender_2`, b.`type` FROM `inpatientinfo` a LEFT JOIN `patient` b ON a.patientID=b.patientID");
        for ($i=0;$i<$dbstat3a->num_rows();$i++) {
            $r3a = $dbstat3a->fetch_assoc();
            if ($r3a['gender_1']==1) { $Mpatient++; }
            if ($r3a['gender_2']==1) { $Fpatient++; }
            ${'type_'.$r3a['type']}++;
        }
        $dbstat4 = new DB;
        $dbstat4->query("SELECT * FROM `general_io` WHERE (`indate`='' OR `indate`='____/__/__') AND `outdate`<='".date("Y/m/d")."'");
        $reason1 = 0;
        $reason2 = 0;
        $reason3 = 0;
        $reason4 = 0;
        for ($i=0;$i<$dbstat4->num_rows();$i++) {
            $r4 = $dbstat4->fetch_assoc();
            if ($r4['reason_1']==1) {
                $reason1++;
            } elseif ($r4['reason_2']==1) {
                $reason2++;
            } elseif ($r4['reason_3']==1) {
                $reason3++;
            } elseif ($r4['reason_4']==1) {
                $reason4++;
            }
        }
        $totalReason = $reason1 + $reason2 + $reason3 + $reason4;
		$dbstat5 = new DB;
        $dbstat5->query("SELECT `patientID` FROM `closedcase` WHERE LEFT(`outdate`,6) = '".date("Ym")."'");
		?>
		<table style="min-width:600px;" align="center">
		  <tr>
		    <td><h3 style="padding-left:1px; padding-right:1px;"><font class="peoplecount_type">Total residents: </font><br><?php echo $InpaitentNo; ?></h3></td>
			<td><h3 style="padding-left:1px; padding-right:1px;"><font class="peoplecount_type">Census in the facility: </font><br><?php echo ($InpaitentNo - $totalReason); ?></h3></td>
			<td><h3 style="padding-left:1px; padding-right:1px;"><font class="peoplecount_type">Medicalleave of absent: </font><br><?php echo $reason4; ?></h3></td>
			<td><h3 style="padding-left:1px; padding-right:1px;"><font class="peoplecount_type">Non-medical leave of absent: </font><br><?php echo ($totalReason-$reason4); ?></h3></td>
			<td><h3 style="padding-left:1px; padding-right:1px;"><font class="peoplecount_type">Discharge (current month): </font><br><?php echo ($dbstat5->num_rows()); ?></h3></td>
		  </tr>
		</table>
      </div>
	</td>
  </tr>
  <tr>
    <td valign="top" width="100%">
      <?php
	  foreach ($arrHomeLink as $k1=>$v1) {
		  echo '<div class="patlistbtn" style="width:220px; height:180px; display:inline-block; font-size:14pt; border:0px; "><a style="color:'.$v1['color'].';" href="'.$v1['link'].'"><span class="fa-stack fa-4x"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-'.$v1['icon'].' fa-stack-1x fa-inverse"></i></span><br>'.$v1['Name'].'</a></div>'."\n";
      }
	  ?>
    </td>
  </tr>
</table>

