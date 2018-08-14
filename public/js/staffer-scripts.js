(function( $ ) {
	'use strict';

	var getUrlParameter = function getUrlParameter(sParam) {
			var sPageURL = decodeURIComponent(window.location.search.substring(1)),
					sURLVariables = sPageURL.split('&'),
					sParameterName,
					i;

			for (i = 0; i < sURLVariables.length; i++) {
					sParameterName = sURLVariables[i].split('=');

					if (sParameterName[0] === sParam) {
							return sParameterName[1] === undefined ? true : sParameterName[1];
					}
			}
	};

	$(document).ready( function() {
		$('a.cw-launch-staffer-modal').on('click', function(e){

			var profile = {
				'id'          : $(this).attr('data-staff-id'),
				'slug'        : $(this).attr('data-staff-slug'),
				'name'        : $(this).attr('data-name'),
				'title'       : $(this).attr('data-title'),
				'departments' : $(this).attr('data-departments'),
				'website'     : $(this).attr('data-website'),
				'phone'       : $(this).attr('data-phone'),
				'email'       : $(this).attr('data-email'),
				'social'      : {
					'facebook'   : $(this).attr('data-facebook'),
					'twitter'    : $(this).attr('data-twitter'),
					'linkedin'   : $(this).attr('data-linkedin'),
					'googleplus' : $(this).attr('data-google-plus'),
					'youtube'    : $(this).attr('data-youtube'),
					'instagram'  : $(this).attr('data-instagram'),
					'github'     : $(this).attr('data-github'),
				},
				'img'         : $(this).attr('data-large-image'),
				'bio'         : $(this).closest('.staff-li').find('.staffer-staff-bio').html(),
			};

			var build = function( profile ){

				// modal header
				$('.cw-staffer-modal .staff-name').text( profile.name );
				$('.cw-staffer-modal .staff-title').text( profile.title );
				$('.cw-staffer-modal .staff-department').text( profile.departments );

				if ( profile.website ) {
					$('.cw-staffer-modal .staff-website').html('<a class="staffer-website-link" href="' + profile.website + '">' + profile.website + '</a>');
				} else {
					$('.cw-staffer-modal .staff-website').empty();
				}

				$('.cw-staffer-modal .staff-phone').text( profile.phone );
				$('.cw-staffer-modal .staff-email').text( profile.email );

				var social = '';
				$.each( profile.social, function( key, value ) {
					if( value ) {
						social += '<a href="' + value + '"><img class="staffer-social-icon" src="' + cwStaffer.plugin_path + '../public/assets/' + key + '.svg' + '" alt="' + name + '"/>';
					}
				});
				$('.cw-staffer-modal .social-icons').html(social);

				// modal body
				var image = '';
				if( profile.img ) {
					image = profile.img.replace('aligncenter', 'alignleft');
					image = profile.img.replace('alignleft', 'alignleft cw-staffer-max-image');
				}

				$('.cw-staffer-modal .cw-modal-body').html( image + profile.bio );
			};

			var open = function( slug ){
				$('.cw-staffer-modal').show();
				$('html, body').addClass('cw-staffer-overlay');
				var state = { name: slug };
				history.pushState( state, null, '?uid=' + slug );
			};

			build( profile );
			open( profile.slug );
			return false;
		});

		$('html').on('click', function(e){

			var close = function(){
				$('.cw-staffer-modal').hide();
				$('html, body').removeClass('cw-staffer-overlay');
				var state = { name: 'none' };
				history.replaceState( state, null, window.location.pathname );
			};

			// check if modal is open, otherwise continue
			if( $('html').hasClass('cw-staffer-overlay') ) {

				// clicked outside modal
				if( !$(e.target).closest('.cw-modal-inner').length && !$(e.target).is('.cw-modal-inner') ) {
					close();
				}
			}

			// clicked close button
			if( $(e.target).is('.cw-modal-close') ) {
				e.preventDefault();
				close();
			}
		});

		if( $('body').hasClass('staffer-main-page') ) {
			var staff_name = getUrlParameter('uid');
			if( staff_name ) {
				$('a.cw-launch-staffer-modal[data-staff-slug="' + staff_name + '"]').trigger('click');
			}

			$('.staffer-staff-email').each( function(i,obj) {
				var email = $(this).parent().find('a[data-email]').attr('data-email');
				$(this).find('em').text( email );
			});
		}

	});

})( jQuery );
