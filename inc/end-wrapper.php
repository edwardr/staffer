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
			case 'bartleby' :
				echo '</div></div></div>';
				break;
			case 'newsframe' :
				echo '</div></div></div>';
				break;
			case 'ifeature' :
				echo '</div></div></div></div></div>';
				break;
			case 'colorway' :
				echo '</div></div><div class="clear"></div>';
				break;
			case 'virtue' :
				echo '</div>';
				break;
			default :
				echo '</div></div>';
				break;
		}