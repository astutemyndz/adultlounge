<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $heading; ?></title>
	<meta property="og:title" content="Adult Lounge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link rel="stylesheet" href="<?= base_url('assets/css/jquery.mCustomScrollbar.css') ?>">
	<link rel="stylesheet" href="<?= base_url('backend/node_modules/bootstrap-utilities/bootstrap-utilities.css') ?>">
	<link href="<?= base_url('assets/css/Os-theme-round-dark.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('assets/css/OverlayScrollbars.min.css') ?>" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('assets/css/custom.css') ?>" rel="stylesheet" type="text/css" />
</head>

<body id="body-content" class="hide">

	<section class="header-wrap">
		<div class="header-layout">
			<header class="main-header">
				<div class="hdr-lft m-auto">
					<a href="<?= base_url() ?>" class="sitelogo">
						<img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo">
					</a>
				</div>				
			</header>

		</div>
	</section>

	<section class="pagewrapper">
		<main class="content-wrapper">
			<section class="content-sec">
				<div class="col-md-12">
					<div class="dash_box">
						<div class="dash_box_hed">
							<p><?php echo $heading; ?></p>
						</div>
						<div class="content-area p-3">
							<?php echo $message; ?>
							<br>
							<a href="<?= base_url() ?>">&laquo; Back to homepage</a>
						</div>
					</div>
				</div>
			</section>
		</main>
	</section>
</body>

</html>