//CSS3-3D操作 IE9+ firebox chorme

window.onload = function(){

	//第一部分：模仿优酷 书本折叠效果 -----------------------------------------
	var oBook = document.getElementById('book');
	var aBooks = oBook.getElementsByTagName('div');
	var oCloseBook = document.getElementById('close_book');

	aBooks[0].onclick = function(){
		aBooks[0].style.transition = '1s ease-in 0s';
		aBooks[0].style.webkitTransition = '1s ease-in 0s';
		aBooks[0].style.transform = 'rotateY(-180deg)';
		aBooks[0].style.webkitTransform = 'rotateY(-180deg)';

		aBooks[1].style.transition = '1s ease-in 1s';
		aBooks[1].style.webkitTransition = '1s ease-in 1s';
		aBooks[1].style.transform = 'rotateY(180deg)';
		aBooks[1].style.webkitTransform = 'rotateY(180deg)';

		aBooks[2].style.transition = '1s ease-in 2s';
		aBooks[2].style.webkitTransition = '1s ease-in 2s';
		aBooks[2].style.transform = 'rotateX(180deg)';
		aBooks[2].style.webkitTransform = 'rotateX(180deg)';

		aBooks[3].style.transition = '1s ease-in 3s';
		aBooks[3].style.webkitTransition = '1s ease-in 3s';
		aBooks[3].style.transform = 'rotateX(-180deg)';
		aBooks[3].style.webkitTransform = 'rotateX(-180deg)';
	}

	oCloseBook.onclick = function(){
		aBooks[0].style.transition = '1s ease-in 3s';
		aBooks[0].style.webkitTransition = '1s ease-in 3s';
		aBooks[0].style.transform = 'rotateY(0deg)';
		aBooks[0].style.webkitTransform = 'rotateY(0deg)';

		aBooks[1].style.transition = '1s ease-in 2s';
		aBooks[1].style.webkitTransition = '1s ease-in 2s';
		aBooks[1].style.transform = 'rotateY(0deg)';
		aBooks[1].style.webkitTransform = 'rotateY(0deg)';

		aBooks[2].style.transition = '1s ease-in 1s';
		aBooks[2].style.webkitTransition = '1s ease-in 1.01s';	//chrome bug 设置为1图片消失 为1.01没事
		aBooks[2].style.transform = 'rotateX(0deg)';
		aBooks[2].style.webkitTransform = 'rotateX(0deg)';

		aBooks[3].style.transition = '1s ease-in 0s';
		aBooks[3].style.webkitTransition = '1s ease-in 0s';
		aBooks[3].style.transform = 'rotateX(0deg)';
		aBooks[3].style.webkitTransform = 'rotateX(0deg)';
	}



	//第二部分：3D轮播图 -----------------------------------------
	var oImages = document.getElementById('images');
	var aImg = oImages.getElementsByTagName('img');
	var oPrev = document.getElementById('prev_image');
	var oNext = document.getElementById('next_image');
	var num = 0;

	//轮流加class hide show
	oPrev.onclick = function(){
		aImg[num].className = 'hide';
		num--;
		if(num == -1){
			num = 4;
		}
		aImg[num].className = 'show';
	}
	oNext.onclick = function(){
		aImg[num].className = 'hide';
		num++;
		if(num == 5){
			num = 0;
		}
		aImg[num].className = 'show';
	}



	//第三部分：折纸下拉菜单
	var oMenuList = document.getElementById('menu_list');
	var aDivList = oMenuList.getElementsByTagName('div');
	var oTitle = document.getElementById('title');
	var listIndex = 0;
	var openTimer = null;
	var closeTimer = null;
	var openFlag = false;
	var closeFlag = false;

	oTitle.onmouseenter = function(){
		if(openFlag || closeFlag){		//下拉或者上拉菜单进行中的时候 都不开新定时器
			return;
		}
		openTimer = setInterval(function(){
			aDivList[listIndex].style.animation = 'open 1s ease-out forwards';
			aDivList[listIndex].style.webkitAnimation = 'open 1s ease-out forwards';
			listIndex++;
			if(listIndex == 7){
				listIndex = 6;
				openFlag = false;
				clearInterval(openTimer);
			}
		},300);
		openFlag = true;
	}

	oMenuList.onmouseleave = function(){
		if(openFlag || closeFlag){
			return;
		}
		closeTimer = setInterval(function(){
			aDivList[listIndex].style.animation = 'close 1s ease forwards';
			aDivList[listIndex].style.webkitAnimation = 'close 1s ease forwards';
			listIndex--;
			if(listIndex == -1){
				listIndex = 0;
				closeFlag = false;
				clearInterval(closeTimer);
			}
		},300);
		closeFlag = true;
	}


}

