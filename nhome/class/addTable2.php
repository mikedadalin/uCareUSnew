<script type="text/javascript" src="js/jquery.appendDom.js"></script>
<script>

function blurselect(id) {//取得產品資訊aquire product info
	$.ajax({
		url: "class/searchSTK2a.php",
		type: "POST",
		data: {"STK_SELECT": $("#STK_NO"+id).val() },
		success: function(data) {
			var arr = data.split("||");
			$('#STK_NO'+id).val(arr[0]);
			$('#STK_NAME'+id).val(arr[1]);
			$('#STK_SPK'+id).val(arr[2]);
			$('#STK_MODEL'+id).val(arr[3]);
			$('#STK_UNIT'+id).val(arr[4]);
			$('#STK_NO_txt'+id).val(arr[0]);
			$('#OUT_PRC'+id).val(((arr[7]*100)/100).toFixed(2));
			$('#STOCK_INFO'+id).val(arr[6]);
			stockINFO(id);
			stockform(id);		
		}
	});
}
function stockINFO(id) {
	$.ajax({
		url: "class/stockInfo.php",
		type: "POST",
		data: { "PID": $("#STOCK_INFO"+id).val()},
		success: function(data) {
			var STOCK_INFO_NAME = document.getElementById('STOCK_INFO_NAME'+id);
			$('#STOCK_INFO_NAME'+id).val(data);		  
		}
	});
}	
function stockform(id) {
	$.ajax({
		url: "class/stockform.php",
		type: "POST",
		data: { "STK_NO": $("#STK_NO"+id).val(), "StockID":$("#STOCK_INFO"+id).val(),"STK_DATE":$("#STK_Date").val()},
		success: function(data) {
			var arr = data.split(':');
			////數量判斷開放使用小數點
			var num = "integer";
			if (arr[0]=='1') {
				//低於安全庫存量
				$("#dQTY"+id).css('background', '#f00');
				$("#dQTY"+id).css('color', '#fff');
				$("#dQTY"+id).addClass('validate[custom['+num+'],min[0],required]');
				$("#dQTY"+id).attr('title', $("#STK_NO"+id).val() + " [低於安全庫存量] 目前庫存量為" + arr[1]);
			} else {
				$("#dQTY"+id).css('background', '#fff');
				$("#dQTY"+id).css('color', '#21689F');
				$("#dQTY"+id).addClass('validate[custom['+num+'],min[0],required]');
				$("#dQTY"+id).attr('title', $("#STK_NO"+id).val() + "目前庫存量為 Yet Storage Quantity" + arr[1]);
			}
		}
	});
}
function S_AMT(id) { //計算金額 Quantity*Unit price calculate amount =number * unit price
	var QTY = parseFloat($('#dQTY'+id).val());
	var PRC = parseFloat($('#OUT_PRC'+id).val());
	var fCount = $("#fileCount1").val();
	var QTYabs = Math.abs(QTY);
	if(QTYabs >= 0 && PRC >= 0){
		var pt = (QTY*PRC).toFixed(2);
	    $("#T_PRC"+id).val(round(pt,0));
    }
	
	$("#T_PRC").val(round(pt,0)); //單項金額unit price
	
	  //全部金額total amount
	  var AMT=0;	  
	  for (i = 1; i <= fCount; i++){					  	
	  	if($("#T_PRC"+i).val()!='' && $("#T_PRC"+i).val()!=null){
		  p = parseFloat($("#T_PRC"+i).val());		  		  
		  AMT=AMT+p;		
		}		  
	  }
	  //for block
	  if($("#oldCount1").val() != ''){
		for (i = 1; i <= $("#oldCount1").val(); i++){					  	
		  if($("#oldT_PRC"+i).val()!='' && $("#oldT_PRC"+i).val()!=null){
			p = parseFloat($("#oldT_PRC"+i).val());		  		  
			AMT=AMT+p;		
		  }		  
	  }
	  }
	  $("#T_PRC").val(round(AMT,0));
	  
	S_NET(round(AMT,0));
}

function S_AMT1() { //移除金額 Quantity*單價remove amount = number * unit price
	var fCount = parseFloat($('#fileCount').val()-1);
	var dCount = parseFloat($('#fileCount1').val());
	$('#fileCount').val(fCount);
	
	  //全部金額total amount
	  AMT=0;
	  for (i = 1; i <= dCount; i++){				
	  	if($("#T_PRC"+i).val()!='' && $("#T_PRC"+i).val()!=null){
		  p = parseFloat($("#T_PRC"+i).val());		  		  
		  AMT=AMT+p;		
		}
	  }
	  //for block
	  if($("#oldCount1").val() !=''){
		for (i = 1; i <= $("#oldCount1").val(); i++){				
		  if($("#oldT_PRC"+i).val()!='' && $("#oldT_PRC"+i).val()!=null){
			p = parseFloat($("#oldT_PRC"+i).val());		  		  
			AMT=AMT+p;		
		  }
		}
	  }

	  $("#T_PRC").val(round(AMT,0));

	S_NET(round(AMT,0));
}

function S_NET(t) { //計算淨額 Amount of fee*折扣calculate amount = amount($)*discount
	var AMT = parseFloat(t);
	var DS = $('#log2').val()
	if(DS != 0){
		pt=((AMT*DS)/100).toFixed(2);
	}else{
		pt= (AMT).toFixed(2);
	}
	$('#STK_NET').val(round(pt,0));
	S_TAX(round(pt,0));
}

function S_TAX(t,bt) { //計算稅額 折扣後價格*稅額calculate tax amount($) = amount($)after discount + tax amount($)
	var NET = parseFloat(t);
	var TAX = $('#Tax_1').val()
	if(TAX == 1){
		if(NET > 0){
			pt=((NET*5)/100).toFixed(2);
		}else{
			pt=0;
		}
	}else{
		pt= 0;
	}
	$('#STK_TAX').val(round(pt,0));
	S_TOT(NET,pt);
}

function S_TOT(net,t) { //計算總額 淨額+稅額calcultae total amount($) = net amount($)
	var NET = parseFloat(net);
	var TAX = parseFloat(t);
	if(NET > 0 ){
		pt= NET+TAX;
	}else{
		pt= NET+TAX;
	}
	
	$('#STK_TOT').val(round(pt,0));
}

function round(num, pos)
{
  return (Math.round( num * Math.pow(10,pos) ) / Math.pow(10,pos)).toFixed(pos);
}

function RemoveRow (id){
	$('#removed'+id).val("1");
	$('#block'+id).remove();
	S_AMT1();
	if(($('#fileCount').val() == 0) && ($('#oldCount').val() ==0)){		
		$("#submit").hide();		
	}	
}

$(function () {
   
    var myTitleDom = [{
      tagName:'table', childNodes:[{
        tagName:'tbody', childNodes:[{
		tagName:'tr', childNodes:[{
		  tagName:'th', width:'80', className:'title', innerHTML:'Product serial number'},{
		  tagName:'th', width:'200', className:'title', innerHTML:'product name'},{	
		  tagName:'th', width:'50', className:'title', innerHTML:'Quantity'},{	
		  tagName:'th', width:'50', className:'title', innerHTML:'Unit'},{	
		  tagName:'th', width:'80', className:'title', innerHTML:'Unit price'},{	
		  tagName:'th', width:'80', className:'title', innerHTML:'Amount($)'},{	
		  tagName:'th', width:'200', className:'title', innerHTML:'Storage'},{	
		  tagName:'th', width:'*', className:'title', innerHTML:'Function'},{
		  }]
        }]//
      }],
    }];
	$('#myTitle').appendDom(myTitleDom);	
	$('#addShow').hide();
  
  
  var count = 0;
  var dcount = 0;
  
  // Create Block
  $('#addFile').click(function() {
	  
	var chkType = '<?php echo $type;?>'; 	
    count++;
	dcount++;

    var myTableDom = [{
      tagName:'table', id:'block' + count, className:'a1', childNodes:[{
        tagName:'tbody', childNodes:[{
		  
        }, {
          tagName:'tr', childNodes:[{            
              tagName:'td', width:'80', childNodes:[{//產品編號product	serial number					  
			  tagName:'input', type:'text', align:'middle', size:'8', className:'validate[custom[integer],required]', id:'STK_NO' + count, name:'STK_NO' + count, onblur:'blurselect('+count+')'}]},{
              tagName:'td', width:'200', childNodes:[{//product name						  
			  tagName:'input', type:'text', size:'28', id:'STK_NAME' + count, name:'STK_NAME' + count, readonly:'readonly'}]},{
              tagName:'td', width:'50', childNodes:[{//Quantity	quantity					  
			  tagName:'input', type:'text', size:'3', id:'dQTY' + count, name:'dQTY' + count, onblur:'S_AMT('+count+');'}]},{
              tagName:'td', width:'50', childNodes:[{//Unit						  
			  tagName:'input', type:'text', size:'3', id:'STK_UNIT' + count, name:'STK_UNIT' + count, disabled:'disabled'}]},{
              tagName:'td', width:'80',childNodes:[{//Unit price						  
			  tagName:'input', type:'text', size:'6', id:'OUT_PRC' + count, name:'OUT_PRC' + count, onblur:'S_AMT('+count+');'}]},{
              tagName:'td',width:'80', childNodes:[{//Amount($)						  
			  tagName:'input', type:'text', size:'6', id:'T_PRC' + count, name:'T_PRC' + count,  readonly:'readonly'}]},{
              tagName:'td', width:'200', childNodes:[{//Storage						  
			  tagName:'input', type:'text', size:'5', className:'validate[required]', id:'STOCK_INFO' + count, name:'STOCK_INFO' + count, onblur:'stockINFO('+count+');this.value = this.value.toUpperCase();'},{
			  tagName:'input', type:'button', value:'...', onclick:'window.open("class/consump.php?query=2&c='+count+'", "_blank", "width=300, height=200"); return false;'},{
			  tagName:'input', type:'text', size:'8', className:'validate[required]', id:'STOCK_INFO_NAME' + count,name:'STOCK_INFO_NAME' + count, readonly:'readonly'},]},{
              tagName:'td', width:'*', childNodes:[{//Function	
			  
			  //tagName:'input', type:'text', size:'25', id:'fmark' + count, name:'fmark' + count, onFocus:'if(this.value=="請在此輸入調整原因type adjustment reason") this.value=""', value:'請在此輸入調整原因type adjustment reason', onBlur:'if(this.value=="") this.value="請在此輸入調整原因type adjustment reason"', style:'color:#999999;'},{
			  
			  tagName:'input', type:'button', value:' Select product ', onclick:'window.open("class/searchSTK3.php?query='+count+'", "_blank", "width=960, height=150"); return true;'},{
			  tagName:'input', type:'button', onclick:"RemoveRow('"+count+"')", value: ' Remove '}]},{
          }]  
        }]//
      }],
    }, {
		tagName:'input', type:'hidden', id:'removed'+count, value:'0'
	}];
    $('#myFile').appendDom(myTableDom);	
    $('#fileCount').val(count);
	$('#fileCount1').val(dcount);
	$('#addShow').show();
	if($('#fileCount').val()> 0 ){
		$("#submit").show();
	}

  });
});
</script>
<table align="left"  width="100%" style="font-size:10pt; margin-left:0px;">
  <TBODY>
  <tr id="addShow">
    <td>
      <div id="myTitle"></div>
      <div id="myFile"></div>
      <div id="myFmark"></div>
    </td>
  </tr>
  <TR>
    <TD width="97%" align="left">
        <input type="button" id="addFile" name="addFile" value="Add new product">
    </TD>
  </TR>
  </TBODY>
</TABLE>
<input type="hidden" id="fileCount" name="fileCount">
<input type="hidden" id="fileCount1" name="fileCount1">

