<div class="moduleNoTab">
  <h3>Modify activity category</h3>
  <?php 
  if($_GET['del']=='y'){
    $db2 = new DB;
    $db2->query("SELECT * FROM `socialform08` WHERE actID='".mysql_escape_string($_GET['tid'])."'");
    if($db2->num_rows() > 0){
      echo '<script>alert("已有活動紀錄表無法刪除!!");</script>';
    }else{
     $db = new DB;
     $db->query("DELETE FROM `socialform08_act` WHERE actID='".mysql_escape_string($_GET['tid'])."' ");
     echo '<script>alert("刪除成功!!");location.replace("?mod=socialwork&func=formview&id=8c");</script>';
   }
 }

 ?>
 <table>
  <tr>
    <td valign="top">
      
      <form style="float:right;">
        <input type="button" value="New activity category" id="newrecord1" onclick="dialogform_set();" />
        <input type="button" value="Resident individual activities record" onclick="window.location.href='index.php?mod=socialwork&func=formview&id=8';">
      </form>
      <script>
      $(function() {
        $( "#dialog-form1" ).dialog({
          autoOpen: false,
          height: 250,
          width: 400,
          modal: true,
          buttons: {
           "Set category": function() {
             $.ajax({
              url: "class/socialwork08cate.php",
              type: "POST",
              data: {
               'actID':$(this).data('actID'),
               'cate1': $('#cate1').val(), 
               'cate2': $('#cate2').val()},
               success: function(data) {						
                 $( "#dialog-form1" ).dialog( "close" );
                 alert("已經成功設定類別！");
                 window.location.reload();
               }
             });
           },
           "Cancel": function() {
            $( "#dialog-form1" ).dialog( "close" );
          }
        }
      });
      });
function dialogform_set(){
	$( "#cate1" ).attr('disabled',false);
	$( "#cate2" ).val('');
	openVerificationForm('#dialog-form1');
}
function editCate(tid, aName) {
  $( "#cate2" ).val(aName);
  $( "#cate1" ).attr('disabled',true);
  $( "#dialog-form1" ).data('actID',tid).dialog( "open" );
}
</script>
<div id="dialog-form1" title="活動類別設定" class="dialog-form"> 
  <form id="base" method="post">
    <fieldset>
      <table>
        <tr>
          <td class="title">Activity category</td>
          <td>
            <?php 
            $db1 = new DB;
            $db1->query("SELECT DISTINCT(cateName) FROM socialform08_act");
            echo '<select id="cate1" name="cate1">';
            for($i=0;$i<$db1->num_rows();$i++){
              $r = $db1->fetch_assoc();
              echo '<option value="'.$r['cateName'].'">'.$r['cateName'].'</option>';
            }
            echo '</select>';
            ?>
          </td>
        </tr>
        <tr>
          <td class="title">Activity</td>
          <td><input type="text" name="cate2" id="cate2" ></td>
        </tr>
      </table>
    </fieldset>
  </form>
</div>
<div id="tab1_part1">
  <table class="content-query">
    <tr class="title">
      <td >Edit</td>
      <td >Activity category</td>
      <td >Activity</td>
      <td >Delete</td>
    </tr>
    <?php
    $dbp1_1 = new DB;
    $dbp1_1->query("SELECT * FROM `socialform08_act` ");
    if ($dbp1_1->num_rows()==0) {
     ?>
     <tr>
      <td colspan="37"><center>-------尚未有分類資料-------</center></td>
    </tr>
    <?php
  } else {
   for ($p1_i1=0;$p1_i1<$dbp1_1->num_rows();$p1_i1++) {
    $rp1_1 =$dbp1_1->fetch_assoc();
    ?>
    <tr>
      <td>
        <?php 
        $db2 = new DB;
        $db2->query("SELECT * FROM `socialform08` WHERE `actID` = '".$rp1_1['actID']."'");
        if($db2->num_rows() <= 0){?>
        <center>
          <input type="image" src="Images/edit_icon.png" onclick="editCate('<?php echo $rp1_1['actID']; ?>', '<?php echo $rp1_1['actName']; ?>');" width="25">
        </center>          
        <?php }?>
      </td>
      <td><?php echo $rp1_1['cateName']; ?></td>
      <td><?php echo $rp1_1['actName']; ?></td>
      <td><a href="index.php?mod=socialwork&func=formview&tid=<?php echo $rp1_1['actID']; ?>&id=8c&del=y"><img src="Images/delete2.png"></a></td>
    </tr>
    <?php
  }
}
?>
</table>
</div>
</td>
</tr>
</table>
</div>