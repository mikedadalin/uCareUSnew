<?php
if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){
	if(isset($_GET['pid'])){
	   if(@$_GET['pid']!=$_SESSION['pid_lwj']){
          echo "<script type='text/javascript'>";
          echo "window.location.href='index.php?func=home'";
          echo "</script>";
	   }
	}
	if($_GET['mod']=="nurseform"){
	   if(isset($_GET['id'])){
	      $idArray = array("1","2a","2n","2b","2m","2g_2a","2g_2","2j","2j_1","2j_3","3_6","3_4","3_3","3_2","3_1","23","23_1","18","17","17_3","19","19_1","13","11");
	      if(!in_array($_GET['id'],$idArray)){
             echo "<script type='text/javascript'>";
             echo "window.location.href='index.php?func=home'";
             echo "</script>";
	      }	
	   }
	}elseif($_GET['mod']=="nursediag"){
	   if(isset($_GET['id'])){
	      $idArray = array("0","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46");
	      if(!in_array($_GET['id'],$idArray)){
             echo "<script type='text/javascript'>";
             echo "window.location.href='index.php?func=home'";
             echo "</script>";
	      }	
	   }
	}elseif($_GET['mod']=="mdsform"){
	   if(isset($_GET['id'])){
	      $idArray = array("1-Alter","2-Alter","3-Alter","4-Alter","5-Alter","6-Alter","7-Alter","8-Alter","9-Alter","10-Alter","11-Alter","12-Alter","13-Alter","14-Alter","15-Alter","16-Alter","17-Alter","18-Alter","19-Alter","20-Alter","21-Alter","22-Alter","23-Alter","24-Alter","25-Alter","26-Alter","27-Alter","28-Alter","29-Alter","30-Alter","31-Alter","32-Alter","33-Alter","34-Alter","35-Alter","36-Alter","37-Alter","38-Alter","39-Alter","40-Alter","41-Alter","42-Alter","43-Alter");
	      if(in_array($_GET['id'],$idArray)){
             echo "<script type='text/javascript'>";
             echo "window.location.href='index.php?func=home'";
             echo "</script>";
	      }	
	   }
	}elseif($_GET['mod']=="carework"){
	   if(isset($_GET['id'])){
	      $idArray = array("7","7_1","7_2");
	      if(!in_array($_GET['id'],$idArray)){
             echo "<script type='text/javascript'>";
             echo "window.location.href='index.php?func=home'";
             echo "</script>";
	      }	
	   }
	}elseif($_GET['mod']=="dailywork"){
		if($_GET['func']=="respedit" || $_GET['func']=="resplist2" || $_GET['func']=="resplist2_weight"){
			echo "<script type='text/javascript'>";
			echo "window.location.href='index.php?func=home'";
			echo "</script>";
		}
	}elseif($_GET['mod']=="inputoutput"){
		if($_GET['func']=="resplist2"){
			echo "<script type='text/javascript'>";
			echo "window.location.href='index.php?func=home'";
			echo "</script>";
		}
	}elseif($_GET['mod']=="socialwork"){
	   if(isset($_GET['id'])){
	      $idArray = array("2","4","6","6a","7","11c");
	      if(!in_array($_GET['id'],$idArray)){
             echo "<script type='text/javascript'>";
             echo "window.location.href='index.php?func=home'";
             echo "</script>";
	      }	
	   }
	}elseif($_GET['mod']=="rehabilitation"){
	   if(isset($_GET['id'])){
	      $idArray = array("2","3","4","6");
	      if(!in_array($_GET['id'],$idArray)){
             echo "<script type='text/javascript'>";
             echo "window.location.href='index.php?func=home'";
             echo "</script>";
	      }	
	   }
	}elseif($_GET['mod']=="nutrition"){
	   if(isset($_GET['id'])){
	      $idArray = array("33","34","35");
	      if(!in_array($_GET['id'],$idArray)){
             echo "<script type='text/javascript'>";
             echo "window.location.href='index.php?func=home'";
             echo "</script>";
	      }	
	   }
	}elseif($_GET['mod']=="nutrition"){
		if($_GET['func']=="form31edit"){
			echo "<script type='text/javascript'>";
			echo "window.location.href='index.php?func=home'";
			echo "</script>";
		}
	}elseif($_GET['mod']=="management"){
	   if(isset($_GET['id'])){
	      $idArray = array("3b_1","3b_2","3b_3","3b_4");
	      if(!in_array($_GET['id'],$idArray)){
             echo "<script type='text/javascript'>";
             echo "window.location.href='index.php?func=home'";
             echo "</script>";
	      }	
	   }
	}elseif($_GET['mod']=="mealadmin"){
		if($_GET['func']=="editroundmenu" || $_GET['func']=="newroundmenu"){
			echo "<script type='text/javascript'>";
			echo "window.location.href='index.php?func=home'";
			echo "</script>";
		}
	}elseif($_GET['mod']=="consump" || $_GET['mod']=="humanresource" || $_GET['mod']=="category" || $_GET['mod']=="maintenance" || $_GET['func']=="NurseRounds" || $_GET['func']=="SystemUpdateInfoEdit" || $_GET['func']=="newcase" || $_GET['func']=="shiftadmin" || $_GET['func']=="shiftrecord1_1"){
		echo "<script type='text/javascript'>";
		echo "window.location.href='index.php?func=home'";
		echo "</script>";
	}else{}
}
?>