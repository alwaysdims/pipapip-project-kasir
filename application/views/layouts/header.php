<!DOCTYPE html>
<html lang="en" class="light">

<head>
	<meta charset="utf-8">
	<link href="<?= base_url('assets/Enigma/Compiled/') ?>dist/images/logo.svg" rel="shortcut icon">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description"
		content="Enigma admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
	<meta name="keywords"
		content="admin template, Enigma Admin Template, dashboard template, flat admin template, responsive admin template, web app">
	<meta name="author" content="LEFT4CODE">
	<title>Application | <?= $title ?></title>
	<link rel="stylesheet" href="<?= base_url('assets/Enigma/Compiled/') ?>dist/css/app.css" /> <!-- END: CSS Assets-->
	<link rel="stylesheet" href="https://datatables.net/legacy/v1/media/css/jquery.dataTables.css">
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.4.3/css/foundation.min.css"> -->
	<!-- <link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.tailwindcss.css"> -->
</head> 
<!-- END: Head -->

<body class="py-5 md:py-0">
	<!-- BEGIN: Mobile Menu -->
	<div class="mobile-menu md:hidden">
		<div class="mobile-menu-bar"> <a href="" class="flex mr-auto"> <img alt="Midone - HTML Admin Template"
					class="w-6" src="<?= base_url('assets/Enigma/Compiled/') ?>dist/images/logo.svg"> </a> <a
				href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="bar-chart-2"
					class="w-8 h-8 text-white transform -rotate-90"></i> </a> </div>
		<div class="scrollable"> <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="x-circle"
					class="w-8 h-8 text-white transform -rotate-90"></i> </a>
			<ul class="scrollable__content py-2">
				<li> <a href="side-menu-light-point-of-sale.html" class="menu">
						<div class="menu__icon"> <i data-lucide="home"></i> </div>
						<div class="menu__title"> Point of Sale </div>
					</a> </li>
				<li> <a href="javascript:;.html" class="menu menu--active">
						<div class="menu__icon"> <i data-lucide="home"></i> </div>
						<div class="menu__title"> Dashboard <i data-lucide="chevron-down"
								class="menu__sub-icon transform rotate-180"></i> </div>
					</a>
					<ul class="menu__sub-open">
						<li> <a href="side-menu-light-dashboard-overview-1.html" class="menu">
								<div class="menu__icon"> <i data-lucide="activity"></i> </div>
								<div class="menu__title"> Overview 1 </div>
							</a> </li>
						<li> <a href="side-menu-light-dashboard-overview-2.html" class="menu">
								<div class="menu__icon"> <i data-lucide="activity"></i> </div>
								<div class="menu__title"> Overview 2 </div>
							</a> </li>
						<li> <a href="side-menu-light-dashboard-overview-3.html" class="menu">
								<div class="menu__icon"> <i data-lucide="activity"></i> </div>
								<div class="menu__title"> Overview 3 </div>
							</a> </li>
						<li> <a href="index.html" class="menu menu--active">
								<div class="menu__icon"> <i data-lucide="activity"></i> </div>
								<div class="menu__title"> Overview 4 </div>
							</a> </li>
					</ul>
				</li>
			</ul>
		</div>
	</div> 
	<!-- END: Mobile Menu -->
	<!-- BEGIN: Top Bar -->
	<div
		class="top-bar-boxed h-[70px] md:h-[65px] z-[51] border-b border-white/[0.08] mt-12 md:mt-0 -mx-3 sm:-mx-8 md:-mx-0 px-3 md:border-b-0 relative md:fixed md:inset-x-0 md:top-0 sm:px-8 md:px-10 md:pt-10 md:bg-gradient-to-b md:from-slate-100 md:to-transparent dark:md:from-darkmode-700">
		<div class="h-full flex items-center">
			<!-- BEGIN: Logo --> <a href="" class="logo -intro-x hidden md:flex xl:w-[180px] block"> <img
					alt="Midone - HTML Admin Template" class="logo__image w-6"
					src="<?= base_url('assets/Enigma/Compiled/') ?>dist/images/logo.svg"> <span
					class="logo__text text-white text-lg ml-3"> Enigma </span> </a> <!-- END: Logo -->
			<!-- BEGIN: Breadcrumb -->
			<nav aria-label="breadcrumb" class="-intro-x h-[45px] mr-auto">
				<ol class="breadcrumb breadcrumb-light">
					<li class="breadcrumb-item"><a href="#">Application</a></li>
					<li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
				</ol>
			</nav> <!-- END: Breadcrumb -->
			<!-- BEGIN: Account Menu -->
			<div class="intro-x dropdown w-8 h-8">
				<div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in scale-110"
					role="button" aria-expanded="false" data-tw-toggle="dropdown"> <img
						alt="Midone - HTML Admin Template"
						src="<?= base_url('assets/Enigma/Compiled/') ?>dist/images/profile-5.jpg"> </div>
				<div class="dropdown-menu w-56">
					<ul
						class="dropdown-content bg-primary/80 before:block before:absolute before:bg-black before:inset-0 before:rounded-md before:z-[-1] text-white">
						<li class="p-2">
							<div class="font-medium">
								<?= $this->session->userdata('username') ?>
							</div>

							<div class="text-xs text-white/60 mt-0.5 dark:text-slate-500">Pemilik aplikasi</div>
						</li>
						<li>
							<hr class="dropdown-divider border-white/[0.08]">
						</li>
						<li> <a href="" class="dropdown-item hover:bg-white/5"> <i data-lucide="user"
									class="w-4 h-4 mr-2"></i> Profile </a> </li>
						<li> <a href="" class="dropdown-item hover:bg-white/5"> <i data-lucide="lock"
									class="w-4 h-4 mr-2"></i> Reset Password </a> </li>
						<li>
							<hr class="dropdown-divider border-white/[0.08]">
						</li>
						<li> 
							<form action="<?= base_url('auth/logout') ?>" method="post"
								onsubmit="return confirm('Yakin ingin logout?');">
								<button type="submit"
									class="dropdown-item hover:bg-white/5 flex items-center w-full text-left">
									<i data-lucide="toggle-right" class="w-4 h-4 mr-2"></i>
									Logout
								</button>
							</form>		
						</li>
					</ul>
				</div>
			</div> <!-- END: Account Menu -->
		</div>
	</div> 
	<!-- END: Top Bar -->
	<div class="flex overflow-hidden">
		


	