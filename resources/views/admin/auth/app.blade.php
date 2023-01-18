<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
        <base href="../../../">
		<title>رنه</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta charset="utf-8" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="رنه" />
		<link rel="shortcut icon" href="assets/media/logos/logo.png" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	</head>
	<body id="kt_body" class="bg-dark" style="direction: rtl;">
		<div class="d-flex flex-column flex-root">
			<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/unitedpalms-1/14-dark.png">
				<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
					<a href="#" class="mb-12">
						<img alt="Logo" src="assets/media/logos/logo.png" class="h-40px" />
					</a>
					<div class="w-lg-600px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                        @yield('content')
					</div>
				</div>
			</div>
		</div>
        @yield('js')
		<script>var hostUrl = "assets/";</script>
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<script src="assets/js/custom/authentication/sign-in/general.js"></script>
	</body>
</html>
