        //撤銷的array
        var cancelList = new Array();
        //撤銷的次數
        var cancelIndex = 0;

        $(function(){
            initCanvas();
            $("img")[4].click();
        });     

        //初始化
        var initCanvas = function(){
            graphType = 'pencil';
            canvas =  document.getElementById('canvas');
            canvas.width = canvasWidth;
            canvas.height = canvasHeight;
            context = canvas.getContext('2d');
            canvasTop = $(canvas).offset().top;
            canvasLeft = $(canvas).offset().left;
            //add the background 
            var pic1 = new Image();
            pic1.src="/uCareUSnew/nhome/module/nurseform/img/woundcare.png";
            pic1.onload = function(){
                context.drawImage(pic1 , 0 ,0 , pic1.width , pic1.height , 0 ,0 , canvasWidth , canvasHeight);
            }

            canvas_bak =  document.getElementById("canvas_bak");
            canvas_bak.width = canvasWidth;
            canvas_bak.height = canvasHeight;
            context_bak = canvas_bak.getContext('2d');      
            }
        




        //撤銷上一個操作
        var cancel = function(){
            cancelIndex++;
            context.clearRect(0,0,canvasWidth,canvasHeight);
            var image = new Image();
            var index = cancelList.length-1 - cancelIndex;
            var url = cancelList[index];
            image.src = url;
            image.onload = function(){
                context.drawImage(image , 0 ,0 , image.width , image.height , 0 ,0 , canvasWidth , canvasHeight);
            }
        }

        //重做上一個操作
        var next = function(){
            cancelIndex--;
            context.clearRect(0,0,canvasWidth,canvasHeight);
            var  image = new Image();
            var index = cancelList.length-1 - cancelIndex  ;
            var url = cancelList[index];
            image.src = url;
            image.onload = function(){
                context.drawImage(image , 0 ,0 , image.width , image.height , 0 ,0 , canvasWidth , canvasHeight);
            }
        }

        //保存歷史 用於撤銷
        var saveImageToAry = function (){
            cancelIndex = 0;
            var dataUrl =  canvas.toDataURL();
            cancelList.push(dataUrl);       
        }       
        
