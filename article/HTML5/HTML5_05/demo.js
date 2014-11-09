
//HTML5小游戏--祖玛
window.onload = function(){

	var oC1 = document.getElementById('canvas1');
	var oGc1 = oC1.getContext('2d');
	var imgRadian = 0;

	var oImg = new Image();
	oImg.src = 'person.png';
	oImg.onload = function(){
		//核心 每秒绘图60次
		var timer1 = setInterval(function(){
			oGc1.clearRect(0, 0, oC1.width, oC1.height);				//清空整个画布

			//画大小圆轨迹 
			oGc1.beginPath();
			oGc1.arc(300, 200, 200, -90*Math.PI/180, 180*Math.PI/180);	//画大圆轨迹
			oGc1.arc(250, 200, 150, 180*Math.PI/180, 360*Math.PI/180);	//画小圆轨迹
			oGc1.stroke();		//stroke如果closePath下面 就先闭合路径(首尾连起)再画轨迹 放这里就只画轨迹
			oGc1.closePath();

			//画终点圆轨迹
			oGc1.beginPath();
			oGc1.arc(400, 200, 20, 0*Math.PI/180, 360*Math.PI/180);		 
			oGc1.stroke();		 
			oGc1.closePath();

			//画沿着圆轨迹运动的小球
			for(var i in ball){					//遍历每个小球对象
				ball[i].angle++;

				if(ball[i].angle == 270){		//当小球走到270度的时候 要开始围绕小圆轨迹运动
					ball[i].r = 150;			//改变当前球的r为小圆半径150
					ball[i].startX = 250;		//起始X Y坐标变为小圆的起始坐标250 50(注意这里是270度 所以起始坐标也是小圆顶部)
					ball[i].startY = 50;
				}

				if(ball[i].angle == 450){		//当小球到达终点圆 游戏结束
					// alert('游戏结束');
					window.location.reload();
				}

				oGc1.beginPath();		 
				oGc1.arc(
					//数学推导过程 定时器的循环让角度不断加1 从而让这个球的新x y坐标不断变化
					//新x坐标 = 起始x坐标 + 半径r*sin角度
					//新y坐标 = 起始x坐标 + 半径r - 半径r*cos角度
					ball[i].startX + (ball[i].r)*(Math.sin(ball[i].angle*Math.PI/180)), 
					ball[i].startY + (ball[i].r)*(1-Math.cos(ball[i].angle*Math.PI/180)), 
					20, 
					0*Math.PI/180, 360*Math.PI/180
				);	
				oGc1.fill();
				oGc1.closePath();
			}

			//中心图片绘制 接收imgRadian 让图片跟随鼠标旋转
			oGc1.save();
			oGc1.translate(300, 200);				//设定围绕这个点旋转
			oGc1.rotate(imgRadian+Math.PI/2);		//Math.atan2得出的数学角度 与canvas定义的角度有90度的差值
			oGc1.drawImage(oImg, -40, -40, 80, 80);	//铺上图片 注意相对旋转点坐标是-40 -40 这样就能围绕图片中心旋转
			oGc1.restore();
			
			//子弹绘制
			for(var i in redBall){					//遍历每一个子弹对象
				redBall[i].num++;
				oGc1.save();						//下面的红色不影响其他小球
				oGc1.beginPath();
				oGc1.arc(
					//定时器的每次循环让每个子弹对象的num属性值加1 从而让这个子弹的x y坐标加speedX speedY 形成运动
					redBall[i].x + (redBall[i].speedX)*(redBall[i].num), 
					redBall[i].y + (redBall[i].speedY)*(redBall[i].num), 
					20, 
					0*Math.PI/180, 360*Math.PI/180
				);
				oGc1.fillStyle = 'red';
				oGc1.fill();
				oGc1.closePath();
				oGc1.restore();
			}	

			//小球与子弹碰撞处理
			for(var i in redBall){	
				for(var j in ball){				//枚举所有的子弹和小球
					//每个小球与子弹的当前坐标
					var x1 = redBall[i].x + (redBall[i].speedX)*(redBall[i].num);	
					var y1 = redBall[i].y + (redBall[i].speedY)*(redBall[i].num);
					var x2 = ball[j].startX + (ball[j].r)*(Math.sin(ball[j].angle*Math.PI/180));
					var y2 = ball[j].startY + (ball[j].r)*(1-Math.cos(ball[j].angle*Math.PI/180));
					if(isPz(x1, y1, x2, y2)){	//碰到了
						redBall.splice(i, 1);	//删除这个数组元素 让这个子弹消失 
						ball.splice(j, 1);		//删除这个数组元素 让这个小球消失 
						break;					//删除后原数组长度变化 会造成报错 既然碰撞检测到了 就退出循环即可
					}
				}
			}

		},1000/60);		
	}

	//每400毫秒 产生一个小球对象 存入ball数组
	var ball = [];			 
	setInterval(function(){
		ball.push({			 
			r: 200,			//半径
			angle: 0,		//角度
			startX: 300,	//起始坐标	
			startY: 0
		});
	}, 400);

	//鼠标放上画布后 触发事件计算imgRadian 然后传递到oGc1.rotate()里
	oC1.onmousemove = function(ev){
		var ev = ev || event;
		var diffX = ev.clientX - this.offsetLeft - 300;
		var diffY = ev.clientY - this.offsetTop - 200;
		//atan()方法只能返回PI/2到-PI/2的弧度 所以有一半的象限区域取反了 采用atan2方法
		imgRadian = Math.atan2(diffY, diffX);	
	}

	//每次点击 产生一个子弹对象 存入redBall数组
	var redBall = [];
	var speed = 10;
	oC1.onclick = function(ev){
		var ev = ev || event;
		var diffX = ev.clientX - this.offsetLeft - 300;
		var diffY = ev.clientY - this.offsetTop - 200;
		var distance = Math.sqrt(diffX*diffX + diffY*diffY);
		 
		redBall.push({
			x: 300,
			y: 200,
			speedX: speed * diffX/distance,		//分解出当前对象的X轴速度
			speedY: speed * diffY/distance,		//分解出当前对象的Y轴速度
			num:0
		});
	}

	//碰撞检测
	function isPz(x1, y1, x2, y2){		//两球的x y坐标
		var a = x1 - x2;
		var b = y1 - y2;
		var c = Math.sqrt(a*a + b*b);	//两球中心点的距离

		if(c < 40){						//如果小于 20+20 说明两球碰上了
			return true;
		}else{
			return false;
		}
	}

}


