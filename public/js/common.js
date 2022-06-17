// // Import vendor jQuery plugin example
// import '~/app/libs/mmenu/dist/mmenu.js'

document.addEventListener('DOMContentLoaded', () => {

	const navBtn = document.getElementById('navBtn');
	const navBtnShowSearch = document.getElementById('navBtnShowSearch');
	const searshBlock = document.querySelector('.top-search-wrap');


	//nav - top menu
	navBtn.addEventListener('click', function(event){
		const btn = document.getElementById('btnUse');
		const menu = document.getElementById('menu');
		if(!menu.classList.contains('active')){
			btn.href.baseVal = '#cross';
			menu.classList.add('active');
			//slideDown(menu, 500);


		}else{
			btn.href.baseVal = '#bars';
			menu.classList.remove('active');
			//slideUp(menu, 500);
		}
	});

	//вызов/сокрытие поиска по сайту
	navBtnShowSearch.addEventListener('click', function(e){
		slideToggle(searshBlock, 300);


	});
	document.getElementById('searchClosed').addEventListener('click', function(el){
		el.stopPropagation();
		slideUp(searshBlock, 300);
	});

		/* SLIDE UP */
	let slideUp = (target, duration=500) => {
		target.style.transitionProperty = 'height, margin, padding';
		target.style.transitionDuration = duration + 'ms';
		target.style.boxSizing = 'border-box';
		target.style.height = target.offsetHeight + 'px';
		target.offsetHeight;
		target.style.overflow = 'hidden';
		target.style.height = 0;
		target.style.paddingTop = 0;
		target.style.paddingBottom = 0;
		target.style.marginTop = 0;
		target.style.marginBottom = 0;
		window.setTimeout( () => {
					target.style.display = 'none';
					target.style.removeProperty('height');
					target.style.removeProperty('padding-top');
					target.style.removeProperty('padding-bottom');
					target.style.removeProperty('margin-top');
					target.style.removeProperty('margin-bottom');
					target.style.removeProperty('overflow');
					target.style.removeProperty('transition-duration');
					target.style.removeProperty('transition-property');
					//alert("!");
		}, duration);
	}

	/* SLIDE DOWN */
	let slideDown = (target, duration=500) => {
			target.style.removeProperty('display');
			let display = window.getComputedStyle(target).display;
			if (display === 'none') display = 'block';
			target.style.display = display;
			let height = target.offsetHeight;
			target.style.overflow = 'hidden';
			target.style.height = 0;
			target.style.paddingTop = 0;
			target.style.paddingBottom = 0;
			target.style.marginTop = 0;
			target.style.marginBottom = 0;
			target.offsetHeight;
			target.style.boxSizing = 'border-box';
			target.style.transitionProperty = "height, margin, padding";
			target.style.transitionDuration = duration + 'ms';
			target.style.height = height + 'px';
			target.style.removeProperty('padding-top');
			target.style.removeProperty('padding-bottom');
			target.style.removeProperty('margin-top');
			target.style.removeProperty('margin-bottom');
			window.setTimeout( () => {
				target.style.removeProperty('height');
				target.style.removeProperty('overflow');
				target.style.removeProperty('transition-duration');
				target.style.removeProperty('transition-property');
			}, duration);
	}

	/* TOOGLE */
	let slideToggle = (target, duration = 500) => {
			if (window.getComputedStyle(target).display === 'none') {
				return slideDown(target, duration);
			} else {
				return slideUp(target, duration);
			}
	}

	/*-- Social midea icon click --*/
	if(document.getElementById('socialMediaList')){
		document.getElementById('socialMediaList').addEventListener('click', toSocialMaeedia)
		function toSocialMaeedia(event){
			window.open('https://' + event.target.dataset.to, '_blank');
		}
	}

	// Comments - hide/show Overflow - content
	if(document.querySelectorAll('.comment_text')){

		function checkOverflow(e) {
			if(e.scrollWidth > e.offsetWidth || e.scrollHeight > e.offsetHeight){
				let overflowItem = e.querySelector('.overflow_wrap');
				overflowItem.style.display = 'flex';
				e.querySelector('.btn_show').addEventListener('click', function(event) {
					event.preventDefault();
					e.style.maxHeight = '100%';
					overflowItem.style.display = 'none';
				});
			}
		}
		document.querySelectorAll('.comment_text').forEach(item => checkOverflow(item));
	}

	// Comments Like / Dislike
	if(document.querySelectorAll('.btn_like_link')) {
		document.querySelectorAll('.btn_like_link').forEach(function (elem) {
			elem.addEventListener('click', function (event) {

				event.preventDefault();
				let commentId = elem.dataset.commit_id;
				let type = elem.dataset.type;

				console.log(commentId+' - '+type);


			});
		});
	}


	if(document.querySelectorAll('.comment_answer')){
		document.querySelectorAll('.comment_answer').forEach(function (item) {
			item.addEventListener('click', function(event) {
				//event.preventDefault();

				const comment = document.getElementById('comment');
				const form = document.getElementById('commentForm');
				const link = event.target;

				if(event.target.dataset.id) {
					document.getElementById('parentId').value = event.target.dataset.id;
				}
				const name = link.parentElement.parentElement.querySelector('.comment_user').innerText + ',  ';
				comment.textContent = name;

				function setCaretPosition(ctrl, pos) {
					// Modern browsers
					if (ctrl.setSelectionRange) {
						ctrl.focus();
						ctrl.setSelectionRange(pos, pos);
					// IE8 and below
					} else if (ctrl.createTextRange) {
						var range = ctrl.createTextRange();
						range.collapse(true);
						range.moveEnd('character', pos);
						range.moveStart('character', pos);
						range.select();
					}
				}

			setCaretPosition(comment, name.length);
			window.setTimeout( ()=>{ form.scrollIntoView({behavior: "smooth"}) }, 50 );


			})

		});


	}








	/*--same-hight-bloks-main-page--*/
	/*
	if(document.querySelector('.main_item_body'))	{
		funcItemsHeight()
		function funcItemsHeight() {
			var menuItems = document.querySelectorAll('.main_item_body');
			var top = menuItems[0].offsetTop;
			var arrHeight = [];
			var arrItems = [];
			for (var i = 0; i < menuItems.length; i++) {
				menuItems[i].style.height = 'auto';
			}
			for (var i = 0; i < menuItems.length; i++) {
				if (top != menuItems[i].offsetTop) {
					arrHeight.sort(function (a, b) { return b - a });
					for (var j = 0; j < arrItems.length; j++) {

						arrItems[j].style.height = arrHeight[0] + 'px';
					}
					top = menuItems[i].offsetTop;
					arrHeight.length = arrItems.length = 0;
					i = i - 1;
					continue;
				}
				arrHeight[arrHeight.length] = menuItems[i].offsetHeight;
				arrItems[arrItems.length] = menuItems[i];
			}
			arrHeight.sort(function (a, b) { return b - a });
			for (var j = 0; j < arrItems.length; j++) {
				arrItems[j].style.height = arrHeight[0] + 'px';
			}
		}
		window.onresize = funcItemsHeight
	}
	*/








})// - END DOM-louder
