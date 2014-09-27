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
			default :
				echo '<div id="staffer-container"><div id="content" role="main">';
				break;
		}