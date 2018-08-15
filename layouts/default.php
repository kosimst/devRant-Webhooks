<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" href="/css/main.css">
		<link rel="stylesheet" href="/css/<?php echo $cssFile; ?>.css">

		<link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css" integrity="sha256-zIG416V1ynj3Wgju/scU80KAEWOsO5rRLfVyRDuOv7Q=" crossorigin="anonymous" />

		<script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js"></script>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

		<title>devRant-Webhooks</title>
	</head>
	<body>
		<div class="columns-overlay"></div>

		<main class="columns">
			<div class="page-content-column column is-half is-offset-one-quarter">
				<header>
					<h1 class="title is-1 has-text-white has-text-centered is-vcentered">
						<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
						     width="70" height="70"
						     viewBox="0 0 50 50"
						     style="fill:#fff;">
							<g id="surface1">
								<path style=" " d="M 25 4 C 19.488281 4 15 8.488281 15 14 C 15 17.289063 16.632813 20.175781 19.09375 22 L 14.15625 30.15625 C 14.117188 30.144531 14.074219 30.136719 14.03125 30.125 C 13 29.847656 11.925781 30 11 30.53125 C 9.089844 31.636719 8.429688 34.089844 9.53125 36 C 10.269531 37.28125 11.617188 38 13 38 C 13.679688 38 14.371094 37.832031 15 37.46875 C 15.925781 36.933594 16.597656 36.0625 16.875 35.03125 C 17.152344 34 17.003906 32.925781 16.46875 32 C 16.300781 31.710938 16.070313 31.453125 15.84375 31.21875 L 21.28125 22.28125 L 21.8125 21.40625 L 20.9375 20.90625 C 18.582031 19.515625 17 16.941406 17 14 C 17 9.570313 20.570313 6 25 6 C 29.429688 6 33 9.570313 33 14 C 33 14.824219 32.886719 15.597656 32.65625 16.34375 L 34.5625 16.9375 C 34.851563 16.003906 35 15.023438 35 14 C 35 8.488281 30.511719 4 25 4 Z M 25 10 C 22.792969 10 21 11.792969 21 14 C 21 16.207031 22.792969 18 25 18 C 25.332031 18 25.660156 17.953125 25.96875 17.875 L 30.78125 26.59375 L 31.25 27.46875 L 32.15625 27 C 33.300781 26.367188 34.597656 26 36 26 C 40.429688 26 44 29.570313 44 34 C 44 38.429688 40.429688 42 36 42 C 33.839844 42 31.878906 41.136719 30.4375 39.75 L 29.0625 41.1875 C 30.859375 42.917969 33.3125 44 36 44 C 41.511719 44 46 39.511719 46 34 C 46 28.488281 41.511719 24 36 24 C 34.613281 24 33.328125 24.363281 32.125 24.875 L 27.71875 16.90625 C 28.5 16.175781 29 15.152344 29 14 C 29 11.792969 27.207031 10 25 10 Z M 10.5625 24.28125 C 6.207031 25.367188 3 29.324219 3 34 C 3 39.511719 7.488281 44 13 44 C 18.15625 44 22.285156 40.019531 22.8125 35 L 32.15625 35 C 32.601563 36.722656 34.140625 38 36 38 C 38.207031 38 40 36.207031 40 34 C 40 31.792969 38.207031 30 36 30 C 34.140625 30 32.601563 31.277344 32.15625 33 L 21 33 L 21 34 C 21 38.429688 17.429688 42 13 42 C 8.570313 42 5 38.429688 5 34 C 5 30.242188 7.585938 27.117188 11.0625 26.25 Z "></path>
							</g>
						</svg>
						<span class="header-title">devRant-Webhooks</span>
					</h1>
				</header>

				<div class="page-content box">
					<?php include(VIEWS_DIR . $view . ".php"); ?>
				</div>
			</div>
		</main>
	</body>
</html>