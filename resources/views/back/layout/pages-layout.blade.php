
<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>@yield('pageTitle')</title>

		<!-- Site favicon -->
		<link
			rel="apple-touch-icon"
			sizes="180x180"
			href="/back/vendors/images/apple-touch-icon.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="32x32"
			href="/back/vendors/images/main1.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="16x16"
			href="/back/vendors/images/main1.png"
		/>

		<!-- Mobile Specific Metas -->
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1, maximum-scale=1"
		/>

		<!-- Google Font -->
		<link
			href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
			rel="stylesheet"
		/>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="/back/vendors/styles/core.css" />
		<link
			rel="stylesheet"
			type="text/css"
			href="/back/vendors/styles/icon-font.min.css"
		/>
		<link rel="stylesheet" type="text/css" href="/back/vendors/styles/style.css" />
		<link rel="stylesheet" type="text/css" href="/back/vendors/styles/bootstrap.min.css" />
		
		<script>
			(function (w, d, s, l, i) {
				w[l] = w[l] || [];
				w[l].push({ "gtm.start": new Date().getTime(), event: "gtm.js" });
				var f = d.getElementsByTagName(s)[0],
					j = d.createElement(s),
					dl = l != "dataLayer" ? "&l=" + l : "";
				j.async = true;
				j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
				f.parentNode.insertBefore(j, f);
			})(window, document, "script", "dataLayer", "GTM-NXZMQSS"); 

		</script>
		<!-- End Google Tag Manager -->
		<link rel="stylesheet" href="/xassets/ijaboCropTool/ijaboCropTool.min.css">
		@livewireStyles
        @stack('stylesheet')

		<style>
			.brand-logo a .svg, .brand-logo a img {
				max-width: 600px;
				display: block;
				height: auto;
				}
		</style>
		
			<!-- BOOTSTRAP -->
		<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
		<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
		

	</head>
	<body>

		<div class="header">
			<div class="header-left">
				<div class="menu-icon bi bi-list"></div>
				<div
					data-toggle="header_search"
				></div>
				<div  class="text-nowrap fs-4 fw-semibold text-uppercase dark-logo text-light">GPS Based Monitoring and Tracking</div>
				
			</div>
			<div class="header-right">
				<div class="dashboard-setting user-notification">
					<div class="dropdown">
						<a
							class="dropdown-toggle no-arrow text-decoration-none"
							href="javascript:;"
							data-toggle="right-sidebar"
						>
							<i class="dw dw-settings2"></i>
						</a>
					</div>
				</div>

				@livewire('admin-header-profile-info')
			</div>
		</div>

		<div class="right-sidebar">
			<div class="sidebar-title">
				<h3 class="weight-600 font-16 text-blue">
					Layout Settings
					<span class="btn-block font-weight-400 font-12"
						>User Interface Settings</span
					>
				</h3>
				<div class="close-sidebar" data-toggle="right-sidebar-close">
					<i class="icon-copy ion-close-round"></i>
				</div>
			</div>
			<div class="right-sidebar-body customscroll">
				<div class="right-sidebar-body-content">
					<h4 class="weight-600 font-18 pb-10">Header Background</h4>
					<div class="sidebar-btn-group pb-30 mb-10">
						<a
							href="javascript:void(0);"
							class="btn btn-outline-primary header-white active"
							>White</a
						>
						<a
							href="javascript:void(0);"
							class="btn btn-outline-primary header-dark"
							>Dark</a
						>
					</div>

					<h4 class="weight-600 font-18 pb-10">Sidebar Background</h4>
					<div class="sidebar-btn-group pb-30 mb-10">
						<a
							href="javascript:void(0);"
							class="btn btn-outline-primary sidebar-light"
							>White</a
						>
						<a
							href="javascript:void(0);"
							class="btn btn-outline-primary sidebar-dark active"
							>Dark</a
						>
					</div>

					<div class="reset-options pt-30 text-center">
						<button class="btn btn-danger" id="reset-settings">
							Reset Settings
						</button>
					</div>
				</div>
			</div>
		</div>

		<div class="left-side-bar">
			<div class="brand-logo">
				<a href="{{ route('admin.home') }}" class="text-decoration-none">
					<img src="/back/vendors/images/logo1.png" alt="" class="dark-logo" width="220">
					<img
						src="/back/vendors/images/logo1.png"
						alt=""
						class="light-logo"
						width="220"
					/>
				</a>
				<div class="close-sidebar" data-toggle="left-sidebar-close">
					<i class="ion-close-round"></i>
				</div>
			</div>
			<div class="menu-block customscroll">
				<div class="sidebar-menu">
					<ul id="accordion-menu">
						
						@if (Route::is('admin.*'))
						<li class="py-1">
							<a href="{{ route('admin.home') }}" class="dropdown-toggle no-arrow text-decoration-none {{ Route::is ('admin.home') ? 'active' : '' }}">
								<span class="micon fa fa-home"></span
								><span class="mtext">Home</span>
							</a>
						</li>
						

						<li class="py-1">
							<a href="{{ route('admin.import') }}" class="dropdown-toggle no-arrow text-decoration-none {{ Route::is ('admin.import') ? 'active' : '' }}">
								<span class="micon fa fa-file-code-o"></span
								><span class="mtext">Import</span>
							</a>
						</li>

						<li class="py-1">
							<div class="dropdown-divider my-2"></div>
						</li>


						<li class="py-1">
							<div class="sidebar-small-cap text-dark">Settings</div>
						</li>
						
						<li class="py-1">
							<a
								href="{{ route('admin.profile') }}"
								
								class="dropdown-toggle no-arrow text-decoration-none {{ Route::is ('admin.profile') ? 'active' : '' }}"
							>
								<span class="micon fa fa-user"></span>
								<span class="mtext"
									>Profile
								</span>
							</a>
						</li>
						<li class="py-1">
							<a href="{{ route('admin.account-user') }}" class="dropdown-toggle no-arrow text-decoration-none {{ Route::is ('admin.account-user') ? 'active' : '' }}">
								<span class="micon fa fa-user-circle"></span>
								<span class="mtext">Accounts</span>
							</a>
						</li>
						@else

						@endif

						
					</ul>
				</div>
			</div>
		</div>
		<div class="mobile-menu-overlay"></div>

		<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
				
					<div>
                        @yield('content')
                    </div>
					
				</div>
			</div>
		</div>

		<!-- js -->
		<script src="/back/vendors/scripts/sweetalert.js"></script>
		<script src="/back/vendors/scripts/bootstrap.bundle.min.js"></script>
		<script src="/back/vendors/scripts/core.js"></script>
		<script src="/back/vendors/scripts/script.min.js"></script>
		<script src="/back/vendors/scripts/process.js"></script>
		<script src="/back/vendors/scripts/layout-settings.js"></script>
		<script src="/xassets/ijaboCropTool/ijaboCropTool.min.js"></script>
		<script>
		window.addEventListener('showToastr', function(event) {
			toastr.remove();
			if( event.detail.type === 'info'){ toastr.info(event.detail.message);}
			else if( event.detail.type === 'success' ){ toastr.success(event.detail.message);}
			else if( event.detail.type === 'error' ){ toastr.error(event.detail.message);}
			else if( event.detail.type === 'warning' ){ toastr.warning(event.detail.message);}
		});
		</script>
		@livewireScripts
        @stack('scripts')
	</body>
</html>
