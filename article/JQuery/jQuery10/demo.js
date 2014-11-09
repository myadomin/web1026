//联动下拉菜单
$(function(){

	//模拟后台json数据
	var data = {
		"provinces":[
			{
				"name":"广东",
				"area":2000,
				"cities":[
					{
						"name": "深圳",
						"area":200,
						"districts": [
							{"name":"南山区", "area":111}, 
							{"name":"福田区", "area":222}, 
							{"name":"罗湖区", "area":333}
						]
					},
					{
						"name": "广州",
						"area":201,
						"districts": [
							{"name":"广州一区", "area":111}, 
							{"name":"广州二区", "area":222}, 
							{"name":"广州三区", "area":333}
						]
					},
					{
						"name": "珠海",
						"area":202,
						"districts": [
							{"name":"珠海一区", "area":111}, 
							{"name":"珠海二区", "area":222}, 
							{"name":"珠海三区", "area":333}
						]
					}
				]
			},
			{
				"name":"湖南",
				"area":2100,
				"cities":[
					{
						"name": "衡阳",
						"area":210,
						"districts": [
							{"name":"衡阳一区", "area":111}, 
							{"name":"衡阳二区", "area":222}, 
							{"name":"衡阳三区", "area":333}
						]
					},
					{
						"name": "长沙",
						"area":211,
						"districts": [
							{"name":"长沙一区", "area":111}, 
							{"name":"长沙二区", "area":222}, 
							{"name":"长沙三区", "area":333}
						]
					},
					{
						"name": "株洲",
						"area":212,
						"districts": [
							{"name":"株洲一区", "area":111}, 
							{"name":"株洲二区", "area":222}, 
							{"name":"株洲三区", "area":333}
						]
					}
				]
			},
			{
				"name":"江西",
				"area":2200,
				"cities":[
					{
						"name": "南昌",
						"area":220,
						"districts": [
							{"name":"南昌一区", "area":111}, 
							{"name":"南昌二区", "area":222}, 
							{"name":"南昌三区", "area":333}
						]
					},
					{
						"name": "九江",
						"area":221,
						"districts": [
							{"name":"九江一区", "area":111}, 
							{"name":"九江二区", "area":222}, 
							{"name":"九江三区", "area":333}
						]
					},
					{
						"name": "宜春",
						"area":222,
						"districts": [
							{"name":"宜春一区", "area":111}, 
							{"name":"宜春二区", "area":222}, 
							{"name":"宜春三区", "area":333}
						]
					}
				]
			}
		]
	}
	// alert(data.provinces[1].cities[2].districts[0].name);

	var arrOp = ['<option>省份</option>', "<option>城市</option>", '<option>区域</option>']

	//data有多少个省就动态生成多少个selecta标签 放入div下
	for( var i in data.provinces ){
		$('#div1').append('<select></select>');
	}
	
	//第一个select标签动态放入n个option 分别是省份 省份1 省份2 ... 省份x
	var str0 = arrOp[0];
	for( var i in data.provinces ){
		str0 += '<option>' + data.provinces[i].name + '</option>';
	}
	$('#div1 select').eq(0).html(str0);

	//第二个select初始只生成一个option(城市) 第三个select初始只生成一个option(区域)
	$('#div1 select').eq(1).html(arrOp[1]);
	$('#div1 select').eq(2).html(arrOp[2]);

	//点击第一个select下面的option(广东等) 生成第二个select下不同的option 例如点击广东 第二个select就生成深圳 广州 珠海三个option
	$('#div1 select').eq(0).find('option').click(function(){
		var _this = this;
		if( $(_this).index() == 0 ){
			//如果点击第一个select下面的省份 第二个第三个select初始化
			$('#div1 select').eq(1).html(arrOp[1]);
			$('#div1 select').eq(2).html(arrOp[2]);
			return;
		}
		$('#div1 select').eq(2).html(arrOp[2]);
		//生成第二个select下的option
		var str1 = arrOp[1];
		for( var k=0; k<data.provinces[$(_this).index()-1].cities.length; k++ ){
			str1 += '<option>' + data.provinces[$(_this).index()-1].cities[k].name + "</option>";
		}
		$('#div1 select').eq(1).html(str1);

		//点击第二个select下面的option(深圳等) 生成第三个select下不同的option 例如点击深圳 第三个select就生成南山 福田 罗湖三个option
		$('#div1 select').eq(1).find('option').click(function(){
			if( $(this).index() == 0 ){
				//如果点击第二个select下面的城市 第三个select初始化
				$('#div1 select').eq(2).html(arrOp[2]);
				return;
			}
			//生成第三个select下的option
			var str2 = arrOp[2];
			for( var k=0; k<data.provinces[$(_this).index()-1].cities[$(this).index()-1].districts.length; k++ ){
				str2 += '<option>' + data.provinces[$(_this).index()-1].cities[$(this).index()-1].districts[k].name + "</option>";
			}
			$('#div1 select').eq(2).html(str2); 
		});	 
	});

	//在IE6-8及chrome中 option的click事件偶尔会无响应 实际开发中用ul li代替select option就能解决这个问题
	//在IE6-8中 使用原生js innerHTML赋值时 第一个option标签会无故消失掉 jquery html()方法无此问题
});	



