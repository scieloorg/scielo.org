<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<title><?= $this->PageMetadata->get_page_title() ?></title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />
	<meta http-equiv="Expires" content="-1"/>
	<meta http-equiv="pragma" content="no-cache"/>
	<meta name="author" content="SciELO (http://scielo.org/)"/>
	<meta name="keywords" content="informação, bibliografia, biblioteca, conhecimento, biblioteca virtual, ciencia e saúde, bvs, bireme, saúde"/><meta name="description" content="Biblioteca Virtual em Saúde"/>
	<meta name="robots" content="all" />
	<meta name="MSSmartTagsPreventParsing" content="true" />	
	<link rel="icon" href="<?= get_static_image_path('ico/favicon.ico') ?>">
	
	<!-- css bootstrap -->
	<link href="<?= get_static_css_path('bootstrap.css') ?>" rel="stylesheet" type="text/css" media="screen" />

	<!-- css scielo.org novo -->
	<link href="<?= get_static_css_path('slick.css') ?>" rel="stylesheet">
	<link href="<?= get_static_css_path('slick-theme.css') ?>" rel="stylesheet">

	<!-- css scielo.org novo -->
	<link href="<?= get_static_css_path('style.css') ?>" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="<?= get_static_css_path('journal-print.css') ?>" media="print" />

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
	<meta name="description" content="<?= $this->PageMetadata->get_page_description() ?>"/>
</head>
<body>
