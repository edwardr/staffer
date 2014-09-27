<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$currenttemplate = get_option( 'template' );

		switch( $currenttemplate ) {
			case 'twentyeleven' :
				echo '</div></div>';
				break;
			case 'twentytwelve' :
				echo '</div></div>';
				break;
			case 'twentythirteen' :
				echo '</div></div>';
				break;
			case 'twentyfourteen' :
				echo '</div></div></div>';
				break;
			default :
				echo '</div></div>';
				break;
		}