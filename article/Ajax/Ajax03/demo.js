
//Ajax--瀑布流--定位布局
$(function(){

    //一刷新进入页面 先瀑布流展示一次
    layout();


    //ajax请求数据 得到数据生成性新li后 再次调用layout()
    var flag = true;    //onscorll开关
    var batchNum = 1;   //当前图片批次
    $(window).scroll(function(){
        //获取最后三张图片中top值最小的那个图片的top值nMinTop
        var nTop1 = parseInt($('#wrap li').eq(-1).css('top'));
        var nTop2 = parseInt($('#wrap li').eq(-2).css('top'));
        var nTop3 = parseInt($('#wrap li').eq(-3).css('top'));
        var nMinTop = Math.min(nTop1, nTop2, nTop3) + $('#wrap').offset().top;

        //当最后三张图片的某张出现在视窗的时候 并且onscroll开起
        if((($(window).height() + $(window).scrollTop()) > nMinTop) && flag){
            //flag开关的作用！！！！！关键点！！！！！
            //onscroll会瞬间触发多次 此时的(($(window).height() + $(window).scrollTop()) > nMinTop)还没计算完成
            //所以只有马上改变flag才能阻止瞬间多次触发
            //所以onscroll第一次触发后flag就为flase 保证瞬间只一次ajax请求
            flag = false;

            //请求第batchNum批数据
            $.ajax({
                url: "data.php?batch="+batchNum,
                dataType: "json",         //返回json对象
                success: function(json){
                    //遍历出所有数据 生成li
                    for(var i in json.list[0].src){
                       $('#wrap').append('<li><img src="'+json.list[0].src[i]+'"/><p>'+json.list[0].title[i]+'</p></li>');
                    }
                    
                    //生成新li后 调用函数再次js定位布局
                    layout();

                    //当次ajax请求后 再打开触发onscroll的开关 以备触发下一批次的ajax请求
                    //此时已是若干秒后 (($(window).height()+$(window).scrollTop())>nMinTop)计算已完成 能正确用于if判断了
                    if(batchNum < 10){  //第10批是最后一批 之后不再开启onscroll开关
                      flag = true;
                    }

                    //ajax请求完毕后 批次数累加1 为下一批次数据准备
                    batchNum++;
                }
            });
        }
    });


    //瀑布流定位布局 函数封装
    function layout(){
        //预存当前列的高度
        var boxHeight = {   
            leftBox:[],
            centerBox:[],
            rightBox:[]
        }

        $('#wrap li').each(function(){
            var now = ($(this).index())%3;               //now形成case0 1 2 将图片分成3组(036 147 258) 集体设置left
            var now2 = Math.floor(($(this).index())/3);  //now2形成每个case里面的0 1 2 top通过now2分别设置
            
            switch(now){
                case 0:
                    $(this).css("left",0+"px");                //第0 3 6张 left都为0
                    boxHeight.leftBox.push($(this).height());  //预存0 3 6张的图片高度
                                                                
                    if(now2 == 0){                             //第0 3 6张经过now2计算后变成case0里面的0 1 2张 
                        $("#wrap li").eq(0).css("top",0+"px");   //第0张top为0
                    }else{                     
                        var nTop = 0;                                
                        for(var j=0 ; j<now2 ; j++){             //now2为1就循环一次 相当于nTop = boxHeight.leftBox[0] + 10;
                            nTop += boxHeight.leftBox[j] + 10;     //now2为2就循环两次 相当于nTop = boxHeight.leftBox[0] + 10 + boxHeight.leftBox[1] + 10;
                        }
                        $(this).css("top",nTop+"px");
                    }
                break;
                  
                case 1:
                    $(this).css("left",260+"px");
                    boxHeight.centerBox.push($(this).height());
                    
                    if(now2 == 0){
                        $(this).css("top",0+"px");
                    }else{
                        var nTop = 0;
                        for(var j=0 ; j<now2 ; j++){
                            nTop += boxHeight.centerBox[j] + 10;
                        }
                        $(this).css("top",nTop+"px");
                    }
                break;
                  
                case 2:
                    $(this).css("left",520+"px");
                    boxHeight.rightBox.push($(this).height());
                    
                    if(now2 == 0){
                        $(this).css("top",0+"px");
                    }else{
                        var nTop = 0;
                        for(var j=0 ; j<now2 ; j++){
                            nTop += boxHeight.rightBox[j] + 10;
                        }
                        $(this).css("top",nTop+"px");
                    }
                break;
            }
        });
    }

  	
});
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 



