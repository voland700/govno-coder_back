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


})// - END DOM-louder
