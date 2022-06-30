<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('meta-title', 'Програмированеие и вебразработка, руководства, статьи, обзоры технологий по прогрмированю, разработки сайтов')</title>
    <meta name="description" content="@yield('meta-description', 'Печи для бани, отопительные печи для дома и дачи, садовые и уличные печи -очаги: грил, мангалы и барбекю. Каталог товаров Везувий в Москве')">
    <meta name="keywords" content="@yield('meta-keywords', 'печи, камины, дымоходы, банные, бани, чугунные, дровяные, литье, для печей, купить, цена, офоициальный, сайт, везувий')">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    <link rel="icon" type="image/svg+xml"  href="/images/favicon/favicon.svg" >
    <link rel="manifest" href="/images/favicon/site.webmanifest">
    <link rel="mask-icon" href="/images/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
	<link rel="stylesheet" href="/css/main.css">
</head>
<body>
	<header class="top">
		<div class="top-search-wrap">
			<div class="top-search-btn-closed" id="searchClosed">×</div>
			<div class="top-search-inner">
				<form action="#" name="s" class="top-search-form">
					<input type="text" name="serch" class="top-search-input" placeholder="Поиск...">
					<input type="submit" class="top-search-btn-sub" value="Искать">
				</form>
			</div>
		</div>
		<div class="navbar_wrap">
			<div class="container">
			<div class="navbar">
				<div class="logo_wrap">
                    @if ((request()->route()->getName()) === 'index')
                        <span class="logo_link">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path class="fa-primary" d="M373.3 226.6C379.9 216.6 384 204.9 384 192c0-35.38-28.62-64-64-64h-5.875C317.8 118 320 107.3 320 96c0-53-43-96-96-96C218.9 0 213.9 .75 208.9 1.5C218.3 14.62 224 30.62 224 48C224 92.13 188.1 128 144 128H128C92.63 128 64 156.6 64 192c0 12.88 4.117 24.58 10.72 34.55C31.98 236.3 0 274.3 0 320c0 53.02 42.98 96 96 96h12.79c-4.033-4.414-7.543-9.318-9.711-15.1c-7.01-18.64-1.645-39.96 13.32-53.02l127.9-111.9C249.1 228.2 260.3 223.1 271.1 224c10.19 0 19.95 3.174 28.26 9.203c18.23 13.27 24.76 36.1 15.89 57.71l-19.33 45.1h7.195c19.89 0 37.95 12.51 44.92 31.11C355.3 384 351 402.8 339.1 416H352c53.02 0 96-42.98 96-96C448 274.3 416 236.3 373.3 226.6z" />
                                <path class="fa-secondary" d="M304 368H248.3l38.45-89.7c2.938-6.859 .7187-14.84-5.312-19.23c-6.096-4.422-14.35-4.031-19.94 .8906l-128 111.1c-5.033 4.391-6.783 11.44-4.439 17.67c2.346 6.25 8.314 10.38 14.97 10.38H199.7l-38.45 89.7c-2.938 6.859-.7187 14.84 5.312 19.23C169.4 510.1 172.7 512 175.1 512c3.781 0 7.531-1.328 10.53-3.953l128-111.1c5.033-4.391 6.783-11.44 4.439-17.67C316.6 372.1 310.7 368 304 368z" />
                            </svg>
                        </span>
                    @else
                        <a href="{{route('index')}}" class="logo_link">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path class="fa-primary" d="M373.3 226.6C379.9 216.6 384 204.9 384 192c0-35.38-28.62-64-64-64h-5.875C317.8 118 320 107.3 320 96c0-53-43-96-96-96C218.9 0 213.9 .75 208.9 1.5C218.3 14.62 224 30.62 224 48C224 92.13 188.1 128 144 128H128C92.63 128 64 156.6 64 192c0 12.88 4.117 24.58 10.72 34.55C31.98 236.3 0 274.3 0 320c0 53.02 42.98 96 96 96h12.79c-4.033-4.414-7.543-9.318-9.711-15.1c-7.01-18.64-1.645-39.96 13.32-53.02l127.9-111.9C249.1 228.2 260.3 223.1 271.1 224c10.19 0 19.95 3.174 28.26 9.203c18.23 13.27 24.76 36.1 15.89 57.71l-19.33 45.1h7.195c19.89 0 37.95 12.51 44.92 31.11C355.3 384 351 402.8 339.1 416H352c53.02 0 96-42.98 96-96C448 274.3 416 236.3 373.3 226.6z" />
                                <path class="fa-secondary" d="M304 368H248.3l38.45-89.7c2.938-6.859 .7187-14.84-5.312-19.23c-6.096-4.422-14.35-4.031-19.94 .8906l-128 111.1c-5.033 4.391-6.783 11.44-4.439 17.67c2.346 6.25 8.314 10.38 14.97 10.38H199.7l-38.45 89.7c-2.938 6.859-.7187 14.84 5.312 19.23C169.4 510.1 172.7 512 175.1 512c3.781 0 7.531-1.328 10.53-3.953l128-111.1c5.033-4.391 6.783-11.44 4.439-17.67C316.6 372.1 310.7 368 304 368z" />
                            </svg>
                        </a>
                    @endif
				</div>
					<nav class="menu" id="menu">
						<ul class="menu_list">
							<li class="menu_item">
								<a href="{{route('news')}}" class="menu_link">Новости</a>
							</li>
							<li class="menu_item __active">
								<a href="{{route('index')}}" class="menu_link many">Статьи</a>
                                @if($categories)
								<ul class="submenu_list">
                                    @foreach($categories as $category)
									<li class="submenu_item">
										<a href="{{route('posts', $category->slug)}}" class="submenu_link">{{$category->name}}</a>
									</li>
                                    @endforeach
								</ul>
                                @endif
							</li>
							<li class="menu_item">
								<a href="{{route('tags')}}" class="menu_link">Теги</a>
							</li>
						</ul>
					</nav>
					<div class="nav_btn_search" id="navBtnShowSearch">
						<svg>
							<use xlink:href="#search"></use>
						</svg>
					</div>
					<div class="nav_btn" id="navBtn">
						<svg>
							<use id="btnUse" xlink:href="#bars"></use>
						</svg>
					</div>
			</div>
			</div>
		</div>
	</header>
