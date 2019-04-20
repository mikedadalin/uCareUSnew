<?php
if(substr($_SESSION['ncareID_lwj'],0,8)=="resident" && $_SESSION['ncareName_lwj']==""){
		$db2 = new DB;
		$db2->query("SELECT `patientID` FROM `patient` WHERE `HospNo`='".substr($_SESSION['ncareID_lwj'],8,6)."'");
		$r2 = $db2->fetch_assoc();
		$_SESSION['ncareName_lwj'] = getPatientName($r2['patientID']);
}
?>
<script type="text/javascript" src="js/LWJ_AutoLogOFF.js"></script>
<script type="text/javascript" src="js/LWJ_SelectLanguage.js"></script>
<script type="text/javascript" src="js/LWJ_closecol.js"></script>
<script type="text/javascript" src="js/LWJ_closecol2.js"></script>
<div id="container">

	<div class="yo">

	<div class="header nav-down">
		<a href="index.php?func=home"><div class='logoshape' style="float:left;"></div></a>
		<a href="index.php?func=home"><span class="title" style="float:left;">UCare System</span></a>		
		<div style="float:right; position: relative; top:50%; transform:translateY(-50%); text-align:center;">
			<div id="loginAs">Login as: <?php echo $_SESSION['ncareName_lwj'].'&nbsp;'.$_SESSION['ncarePos_lwj'].'&nbsp;'; ?></div>
			<div id="logoutInfo2"><span id="countdown">1800 sec before log off</span></div>
		</div>
	</div>

	<span id="toolList">
		  <!--<div>Login as: <?php echo $_SESSION['ncareName_lwj'].'&nbsp;'.$_SESSION['ncarePos_lwj'].'&nbsp;'; ?></div>-->
		  <div onclick="closecol2();"><a href="#menu" id="toggle"><span></span></a>
		  	<div id="menu" onclick="closecol();">
		  	  <ul>
				<li><i class="fa fa-clock-o"></i>  <input type="text" name="ClockAlarm" id="ClockAlarm" readonly="readonly" style="border:none; outline:none; background-color:rgba(255,255,255,0); color:white; font-size:40px; font-weight:bold; width:500px;"></li>
				<li style="line-height:22px">
				   <table align="center">
				     <tr>
				       <?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
				       <?php
					     $db2 = new DB;
					     $db2->query("SELECT `GroupID` FROM `shift_group` WHERE `GroupLeader`='".$_SESSION['ncareID_lwj']."'");
					     if ($db2->num_rows()>0 || $_SESSION['ncareID_lwj']=="Mor3Geneki6nge08" || $_SESSION['ncareID_lwj']=="Lejla05Mirzada12Asmira01" || substr($_SESSION['ncareID_lwj'],0,8)=="uarkdemo") {
						     $r2 = $db2->fetch_assoc();
						     if ($r2['GroupID']==NULL) { $groupid='1'; } else { $groupid = $r2['GroupID']; $_SESSION['GroupLeader_lwj']=1;}
						     echo '<td style="width:20%;"><a href="index.php?func=shiftadmin&group='.$groupid.'" title="Shift schedule" style="font-size:20px;"><i class="fa fa-list-alt fa-2x"></i><br>Shift schedule</a></td>';
					     } else {
							 $_SESSION['GroupLeader_lwj']=0;
						     echo '<td style="width:20%;"><a href="printshift.php" target="_blank" title="Shift schedule" style="font-size:20px;"><i class="fa fa-list-alt fa-2x"></i><br>Shift schedule</a></td>';
					     }
					  ?>
		  			  <td style="width:20%;"><a href="index.php?mod=consump&func=formview&id=10" title="Item Application" style="font-size:20px;"><i class="fa fa-medkit fa-2x"></i><br>Item Application</a></td>
					  <td style="width:20%;"><a href="index.php?func=maintenance" title="Maintenance apply" style="font-size:20px;"><i class="fa fa-wrench fa-2x"></i><br>Maintenance apply</a></td>
				      <td style="width:20%;"><a href="index.php?func=noticelist" title="Announcement" style="font-size:20px;"><i class="fa fa-bullhorn fa-2x"></i><br>Announcement</a></td>
					  <td style="width:20%;"><a href="index.php?func=Calendar" title="Calendar(Memo)" style="font-size:20px;"><i class="fa fa-calendar fa-2x"></i><br>Calendar (Memo)</a></td>
				      <?php }?>
				     </tr>
				   </table>
				   <table align="center">
					 <tr>
					  <td style="width:25%;"><a href="index.php?func=Feedbacklist" title="Feedback Form" style="font-size:20px;"><i class="fa fa-comments-o fa-2x"></i><br>Feedback Form</a></td>
				      <?php if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){?>
					  <td style="width:25%;"><a href="index.php?func=infoeditResident" title="Setting" style="font-size:20px;"><i class="fa fa-cog fa-spin fa-2x"></i><br>Setting</a></td>
				      <?php }else{ ?>
					  <td style="width:25%;"><a href="index.php?func=infoedit" title="Setting" style="font-size:20px;"><i class="fa fa-cog fa-spin fa-2x"></i><br>Setting</a></td>
					  <td style="width:25%;"><a href="index.php?func=ClassVideo" title="Classroom film" style="font-size:20px;"><i class="fa fa-youtube-play fa-2x"></i><br>Classroom film</a></td>
				      <?php }?>
					  <td style="width:25%;"><a href="logout.php" title="Log off" style="font-size:20px;"><i class="fa fa-power-off fa-2x"></i><br>Log off</a></td>
					 </tr>
				   </table>
				</li>
				<li><a href="index.php?func=home"><i class="fa fa-home fa-2x"></i>Main Page</a></li>
					<?php
				    $db1 = new DB2;
				    $db1->query("SELECT * FROM `permissionset` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."' AND `Group`='".$_SESSION['ncareGroup_lwj']."'");
				    $r1 = $db1->fetch_assoc();
    
				    $arrHomeLink = array();
				    
				    if ($r1['PermissionSet']==NULL) {
				        echo "<script>window.locaion.href='".$r1['DirectLink']."'</script>";
				    } else {
				        $arrPermissionSet = explode(";",$r1['PermissionSet']);
				        foreach ($arrPermissionSet as $k=>$v) {
				            $db1a = new DB2;
				            $db1a->query("SELECT * FROM `permission` WHERE `PermissionID`='".$v."'");
				            $r1a = $db1a->fetch_assoc();
				            echo $r1a['HeadLink'];
 				       }
 				   }
 				   ?>
				<li>&nbsp;</li>
			    <li>&nbsp;</li>
		  	  </ul>
		  	</div>
		  </div><!--
		  <?php if($_SESSION['ncareID_lwj']=="Mor3Geneki6nge08" || $_SESSION['ncareID_lwj']=="Lejla05Mirzada12Asmira01"){?>
		  <div>
		    <div id="LanguangSetting">
			<form>
		    <select onchange="SelectLanguage();" id="LanguangOption" style="font-size:10px;">
              <?php/*
		      $db3 = new DB2;
		      $db3->query("SELECT * FROM `languang` ORDER BY `LanguangNumber` LIMIT 2");
		      for ($i=0;$i<$db3->num_rows();$i++) {
		    	  $r3 = $db3->fetch_assoc();
		    	  echo '<option value="'.$r3['LanguangNumber'].'"';
				  if($_SESSION['LanguangNumber_lwj']==$r3['LanguangNumber']){ echo 'selected="selected"';}
				  echo '>'.$r3['Original'].'</option>'."\n";
		      }*/
		      ?>
            </select>
			</form>
			</div>
		  </div>
		  <?php }?>-->
		</span>

<!-- js for toggle menu-->
<script>var theToggle = document.getElementById('toggle');
	// based on Todd Motto functions
	// http://toddmotto.com/labs/reusable-js/

	// hasClass
	function hasClass(elem, className) {
	return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
	}
	// addClass
	function addClass(elem, className) {
    	if (!hasClass(elem, className)) {
    		elem.className += ' ' + className;
    	}
	}
	// removeClass
	function removeClass(elem, className) {
		var newClass = ' ' + elem.className.replace( /[\t\r\n]/g, ' ') + ' ';
		if (hasClass(elem, className)) {
        	while (newClass.indexOf(' ' + className + ' ') >= 0 ) {
            	newClass = newClass.replace(' ' + className + ' ', ' ');
        	}
        	elem.className = newClass.replace(/^\s+|\s+$/g, '');
    	}
	}
	// toggleClass
	function toggleClass(elem, className) {
		var newClass = ' ' + elem.className.replace( /[\t\r\n]/g, " " ) + ' ';
    	if (hasClass(elem, className)) {
        	while (newClass.indexOf(" " + className + " ") >= 0 ) {
            	newClass = newClass.replace( " " + className + " " , " " );
        	}
        	elem.className = newClass.replace(/^\s+|\s+$/g, '');
    	} else {
        	elem.className += ' ' + className;
    	}
	}

	theToggle.onclick = function() {
   		toggleClass(this, 'on');
   		return false;
	}
</script>
<div class="yo2">
	<?php
	session_start();
	$UserActionURL = $_SERVER['REQUEST_URI'];
	$UserActionURL = explode("/uCareUSnew/",$UserActionURL);
	if($_GET['pid']!=""){ $urlpid = $_GET['pid']; }else{ $urlpid = ""; }
	if($_GET['mod']!=""){ $urlmod = $_GET['mod']; }else{ $urlmod = ""; }
	if($_GET['func']!=""){ $urlfunc = $_GET['func']; }else{ $urlfunc = ""; }
	if($_GET['id']!=""){ $urlid = $_GET['id']; }else{ $urlid = ""; }
	if($_GET['nID']!=""){ $urlnID = $_GET['nID']; }else{ $urlnID = ""; }
	if($_GET['scheduleID']!=""){ $urlscheduleID = $_GET['scheduleID']; }else{ $urlscheduleID = ""; }
	if($_GET['action']!=""){ $_SESSION['userAction_lwj'] = $_GET['action']; }
	$userAction = $_SESSION['userAction_lwj'];
	$dbTrackURL = new DB;
	$dbTrackURL->query("INSERT INTO `useractiontrack` (`date`, `time`, `action`, `userID`, `OrgID`, `username`, `position`, `pid`, `mod`, `func`, `id`, `nID`, `scheduleID`, `url`) VALUES ('".date(Ymd)."', '".date("H:i:s")."', '".$userAction."', '".$_SESSION['ncareID_lwj']."', '".$_SESSION['nOrgID_lwj']."', '".$_SESSION['ncareName_lwj']."', '".$_SESSION['ncarePos_lwj']."', '".$urlpid."', '".$urlmod."', '".$urlfunc."', '".$urlid."', '".$urlnID."', '".$urlscheduleID."', '".$UserActionURL[1]."');");
	if($_SESSION['userAction_lwj']!="View"){ $_SESSION['userAction_lwj'] = "View";}

	$User_Shift_Area = explode(",",getShift_Area($_SESSION['EmpGroup_lwj'],$_SESSION['EmpID_lwj']));//排班權限
	include('Defense_Competence.php');
	include('Defense_Shift_Area.php');
	include('Defense_Resident.php');
	include('Language_ResidentTitle.php');
	include('GoAwayAlert.php');
	include('VerificationNumber-Form.php');
	include('FormGroup_check.php');
	if (@$_GET['mod']==NULL) {
		if (@$_GET['func']==NULL) {
			echo '<center><div id="content2" class="content2N">';
			include('home.php');
			echo '</div></center>';
		} else {
			echo '<center><div id="content2" class="content2N">';
			include(@$_GET['func'].'.php');
			echo '</div></center>';
		}
	} else {
		echo '<center><div id="content2" class="content2N">';
		include('module/'.@$_GET['mod'].'/'.@$_GET['func'].'.php');
		echo '</div></center>';
	}
	?>
</div> <!-- </yo2> -->
	</div> <!-- </yo> -->	
	<div id="footerMain">Copyright &copy; U-ARK America. 2015.</div>
</div>