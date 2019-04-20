$(function(){
  var w = $("#slider_content2").width();
  $('#slider_content2').css('height', ($(window).height() - 20) + 'px' ); //將區塊自動撐滿畫面高度
 
  $("#slider_tab2").mouseover(function(){ //滑鼠滑入時
    if ($("#slider_scroll2").css('right') == '-'+w+'px')
    {
      $("#slider_scroll2").animate({ right:'0px' }, 600 ,'swing');
    }
  });
  $("#slider_content2").mouseleave(function(){　//滑鼠離開後
    $("#slider_scroll2").animate( { right:'-'+w+'px' }, 600 ,'swing');  
  });
});