//畫布
        var canvas;
        var context;
        //蒙版
        var canvas_bak;
        var context_bak;

        var canvasWidth = 800;
        var canvasHeight = 600;

        var canvasTop;
        var canvasLeft;

        //畫筆大小
        var size = 1;
        var color  = '#ff0000';

        //畫圖形
        var draw_graph = function(graphType,obj){   
            //把蒙版放於畫板上面
            $("#canvas_bak").css("z-index",998);
            //先畫在蒙版上 再複製到畫布上

            chooseImg(obj);         
            var canDraw = false;    
            
            var startX;
            var startY;

            //鼠標按下獲取 開始xy開始畫圖
            var mousedown = function(e){
                //strokeStyle 屬性設置或返回用於筆觸的顏色、漸變或模式。
                context.strokeStyle= color;
                context_bak.strokeStyle= color;
                //lineWidth 屬性設置或返回當前線條的寬度，以像素計。
                context_bak.lineWidth = size;
                //define event
                e=e||window.event;
                //get the x, y coordinate of the mouse
                //clientX 事件屬性返回當事件被觸發時鼠標指針向對於瀏覽器頁面（或客戶區）的水平坐標。客戶區指的是當前窗口。
                startX = e.clientX - canvasLeft;
                if ($('.header').hasClass('nav-goup') || $('#content2').hasClass('content2Nav') || $('.content-query2').hasClass('content-query2Nav')) {
                    startY = e.clientY - canvasTop + 70;
                } else {
                    startY = e.clientY - canvasTop;
                }         

                context_bak.moveTo(startX ,startY);
                canDraw = true;         
                
                //決定graphType的畫筆樣式
                /*
                    .moveTo(x坐標 , y坐標)      
                    可以理解為定位畫筆在畫布上的位置（注意所有繪圖方法所定義的坐標是相對canvas而言的而不是瀏覽器窗口，對canvas來說，最左上角的點的坐標是(0,0)）

                    .lineTo(x坐標 , y坐標)      
                    顧名思義，就是畫一條直線到某個點，很好理解。BUT, 此方法僅僅做路徑運動，而不存在任何視覺上的繪圖效果（上色、描邊）

                    .stroke()     
                    描邊方法，想要運動路徑軌跡能有視覺效果，需要使用相應的上色/描邊方法
                */
                if(graphType == 'pencil'){
                    context_bak.beginPath();
                }else if(graphType == 'circle'){
                    context.beginPath();
                    // context.moveTo(startX ,startY);
                    // context.lineTo(startX +2 ,startY+2);
                    // context.stroke();   
                }   
            };  

            //鼠標離開 把蒙版canvas的圖片生成到canvas中
            var mouseup = function(e){
                e=e||window.event;
                canDraw = false;
                var image = new Image();
                if(graphType ='pencil'){    
                    //transform canvas_bak content to img style file
                    image.src = canvas_bak.toDataURL();
                    //after object 'image' is loaded
                    image.onload = function(){
                        //剪切圖像，並在畫布上定位被剪切的部分：context.drawImage(img,sx,sy,swidth,sheight,x,y,width,height);
                        context.drawImage(image , 0 ,0 , image.width , image.height , 0 ,0 , canvasWidth , canvasHeight);
                        // clearContext();
                        saveImageToAry();
                    }
                    //catch the end point coordinate
                    var x = e.clientX  - canvasLeft;
                    var y = e.clientY  - canvasTop; 
                    context.beginPath();
                    context.moveTo(x ,y );
                    context.lineTo(x +2 ,y+2);
                    context.stroke();   
                }
            };

            //選擇功能按鈕 修改樣式
            function chooseImg(obj){
                var imgAry  = $("#drawController img");
                //for loop 跑一遍陣列, 初始化
                for(var i=0;i<imgAry.length;i++){
                    $(imgAry[i]).removeClass('border_choose');
                    $(imgAry[i]).addClass('border_nochoose');               
                }
                //對於所選的的img做addClass---border_choose的動作
                $(obj).removeClass("border_nochoose");
                $(obj).addClass("border_choose");
            }

            // 鼠標移動
            var  mousemove = function(e){
                e=e||window.event;
                var x = e.clientX  - canvasLeft ;
                var y = e.clientY  - canvasTop ; 
                //方塊  4條直線搞定
                if(graphType == 'square'){
                    if(canDraw){
                        context_bak.beginPath();
                        clearContext(1);
                        context_bak.moveTo(startX + $('#content2').scrollLeft(), startY + $('#content2').scrollTop());                        
                        context_bak.lineTo(x + $('#content2').scrollLeft() ,startY + $('#content2').scrollTop());
                        context_bak.lineTo(x + $('#content2').scrollLeft() ,y + $('#content2').scrollTop());
                        context_bak.lineTo(startX + $('#content2').scrollLeft() ,y+ $('#content2').scrollTop() );
                        context_bak.lineTo(startX + $('#content2').scrollLeft(), startY + $('#content2').scrollTop());
                        context_bak.stroke();
                    }
                
                //畫筆
                }else if(graphType == 'pencil'){
                    clearContext(1);
                    if(canDraw){
                        if($('.header').hasClass('nav-goup') || $('#content2').hasClass('content2Nav') || $('.content-query2').hasClass('content-query2Nav')) {
                            context_bak.lineTo(e.clientX - canvasLeft + $('#content2').scrollLeft(), e.clientY - canvasTop + $('#content2').scrollTop() + 70);
                        } else {
                            context_bak.lineTo(e.clientX - canvasLeft + $('#content2').scrollLeft(), e.clientY - canvasTop + $('#content2').scrollTop());
                        }        
                        context_bak.stroke();                       
                    }
                //圓 
                }else if(graphType == 'circle'){                        
                    clearContext(1);
                    if(canDraw){
                        context_bak.beginPath();   
                        //圓方程式 表示出半徑         
                        var radii = Math.sqrt((startX - x) *  (startX - x)  + (startY - y) * (startY - y));
                        //context.arc(x,y,r,sAngle,eAngle,counterclockwise); 畫圓
                        context_bak.arc(startX + $('#content2').scrollLeft(),startY + $('#content2').scrollTop(),radii,0,Math.PI * 2,false);                                   
                        context_bak.stroke();
                    
                    }
                
                }
            };


            
            //bind() & unbind(), attach the event object to the element which id = canvas_bak
            //It means like add 'onclick' to the html element. 
            $(canvas_bak).unbind();
            $(canvas_bak).bind('mousedown',mousedown);
            $(canvas_bak).bind('mousemove',mousemove);
            $(canvas_bak).bind('mouseup',mouseup);
            // $(canvas_bak).bind('mouseout',mouseout);
        }






        //清空層
        var clearContext = function(type){
            if(type == 1){
                context_bak.clearRect(0,0,canvasWidth,canvasHeight);
                // initCanvas();
                // var pic1 = new Image();
                // pic1.src="/uCareUSnew/nhome/module/nurseform/img/woundcare.png";
                // pic1.onload = function(){
                //     context.drawImage(pic1 , 0 ,0 , pic1.width , pic1.height , 0 ,0 , canvasWidth , canvasHeight);}
                
            }else{
                context.clearRect(0,0,canvasWidth,canvasHeight);
                context_bak.clearRect(0,0,canvasWidth,canvasHeight);
                // initCanvas();
                var pic1 = new Image();
                pic1.src="/uCareUSnew/nhome/module/nurseform/img/woundcare.png";
                pic1.onload = function(){
                    context.drawImage(pic1 , 0 ,0 , pic1.width , pic1.height , 0 ,0 , canvasWidth , canvasHeight);
                }
            }
        }
