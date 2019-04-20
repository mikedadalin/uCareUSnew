<script type="text/javascript" src="js/jquery.appendDom.js"></script>
<script>
$(function () {
  var count = 0;
  // Create Block
  $('#<?php echo $act; ?>addImg<?php echo $_GET['date']; ?>').click(function() {
	count++;
	var myImgDom = [{
	  tagName:'table', cellSpacing:'1', cellPadding:'3', border:'0', id:'block' + count, className:'a1', childNodes:[{
		tagName:'tbody', childNodes:[{
		  tagName:'tr', childNodes:[{
			tagName:'th', width:'12%', className:'title', innerHTML:'Photo'}, {
			tagName:'td', valign:'top', childNodes:[{
			  tagName:'input', type:'file', id:'dImg' + count, name:'dImg' + count
			}]}, {
			tagName:'td', width:'12%', className:'creattime', align:'center', vAlign:'bottom', childNodes:[{
			  tagName:'input', type:'button', onclick:function (){ $(this).parents('.a1').remove();}, value:' Remove '
			}]
		  }]
		}]
	  }]
	}];
	$('#<?php echo $act; ?>myFile<?php echo $_GET['date']; ?>').appendDom(myImgDom);

	$('#<?php echo $act; ?>imgCount<?php echo $_GET['date']; ?>').val(count);
  });
});
</script>
<table align="left"  width="100%">
  <TBODY>
  <tr>
    <td>
      <div id="<?php echo $act; ?>myFile<?php echo $_GET['date']; ?>"></div>
    </td>
  </tr>
  <TR>
    <TD width="100%" align="left">
        <input type="button" id="<?php echo $act; ?>addImg<?php echo $_GET['date']; ?>" name="<?php echo $act; ?>addImg<?php echo $_GET['date']; ?>" value=" Add photo ">
    </TD>
  </TR>
  </TBODY>
</TABLE>
<input type="hidden" id="<?php echo $act; ?>imgCount<?php echo $_GET['date']; ?>" name="<?php echo $act; ?>imgCount<?php echo $_GET['date']; ?>">