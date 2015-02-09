<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$currenttemplate = get_option( 'template' );

		switch( $currenttemplate ) {
			case 'twentyeleven' :
				echo '<div id="primary"><div id="content" role="main">';
				break;
			case 'twentytwelve' :
				echo '<div id="primary" class="site-content"><div id="content" role="main">';
				break;
			case 'twentythirteen' :
				echo '<div id="primary" class="site-content"><div id="content" role="main" class="entry-content twentythirteen">';
				break;
			case 'twentyfourteen' :
				echo '<div id="primary" class="content-area"><div id="content" role="main" class="site-content twentyfourteen"><div class="tfwc">';
				break;
			case 'bartleby' :
				echo '<div class="row"><div class="sixteen columns"><div class="single-page">';
				break;
			case 'newsframe' :
				echo '<div class="row"><div class="twelve columns"><div class="single-page">';
				break;
			case 'ifeature' :
				echo '<div class="container-full-width" id="page_section_section"><div class="container"><div class="container-fluid"><div id="container" class="row-fluid"><div id="content" class="span12">';
				break;
			case 'colorway' :
				echo '<style>.staffer-archive-grid li { width: 30%; }</style><div class="grid_24 content"><div class="content-wrapper">';
				break;
			case 'virtue' :
				echo '<div class="wrap contentclass" role="document">';
				break;
			default :
				echo '<div id="staffer-container"><div id="staffer-content" role="main">';
				break;
		}