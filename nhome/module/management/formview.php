<table style="width:100%;">
<?php include("BackToListButton.php"); ?>
  <tr>
    <td style="border:none;">
    <?php
	if (@$_GET['id']!=NULL) {
		echo '<div class="nurseform-table" style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 20px;">';
		include("form".@$_GET['id'].".php");
		echo '</div>';
	} else {
		include("formlist.php");
	}
	?>
    </td>
  </tr>
</table>
<script>/*
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
	});*/
</script>