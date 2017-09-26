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

	$(document).ready( function(e) {
		$('a.cw-launch-staffer-modal').on('click', function(e) {
			var bio,img,name,title, id, slug,
			department,website,phone,email,fb,
			linkedin,twitter,gplus,youtube,
			instagram,github, iconArr,
			iconOutput = '';

			bio = $(this).attr('data-bio');
			img = $(this).attr('data-large-image');
			img = img.replace('aligncenter', 'alignleft');
			img = img.replace('alignleft', 'alignleft cw-staffer-max-image');
			name = $(this).attr('data-name');
			title = $(this).attr('data-title');
			department = $(this).attr('data-departments');
			phone = $(this).attr('data-phone');
			email = $(this).attr('data-email');
			website = $(this).attr('data-website');
			id = $(this).attr('data-staff-id');
			slug = $(this).attr('data-staff-slug');

			fb = $(this).attr('data-facebook');
			twitter = $(this).attr('data-twitter');
			linkedin = $(this).attr('data-linkedin');
			gplus = $(this).attr('data-google-plus');

			youtube = $(this).attr('data-youtube');
			instagram = $(this).attr('data-instagram');
			github = $(this).attr('data-github');

			iconArr = {
				'facebook' : fb,
				'twitter' : twitter,
				'linkedin' : linkedin,
				'googleplus' : gplus,
				'youtube' : youtube,
				'instagram' : instagram,
				'github' : github
			}

			$.each( iconArr, function( key, value ) {
				if( value !== '' ) {
					iconOutput += '<a href="' + value + '"><img class="staffer-social-icon" src="' + cwStaffer.plugin_path + '../public/assets/' + key + '.svg' + '" alt="' + name + '"/>';
				}
			});

			$('.cw-staffer-modal .staff-name').text(name);
			$('.cw-staffer-modal .cw-modal-header .staff-title').text(title);
			$('.cw-staffer-modal .cw-modal-header .staff-department').text(department);

			$('.cw-staffer-modal .cw-modal-header .social-icons').html(iconOutput);

			if( website ) {
				$('.cw-staffer-modal .cw-modal-header .staff-website').html('<a class="staffer-website-link" href="' + website + '">' + website + '</a>');
			} else {
				$('.cw-staffer-modal .cw-modal-header .staff-website').html('');
			}

			$('.cw-staffer-modal .cw-modal-header .staff-phone').text(phone);
			$('.cw-staffer-modal .cw-modal-header .staff-email').text(email);

			$('.cw-staffer-modal .cw-modal-body').html(img + bio);

			$('.cw-staffer-modal').show();

			$('body').addClass('cw-staffer-overlay');
			$('html').addClass('cw-staffer-overlay');


			var state = { name: slug };
			history.pushState(state, '', '?uid=' + slug );

			return false;

		});

		$('.cw-staffer-modal .cw-modal-close').on('click', function(e) {
			$('.cw-staffer-modal').hide();
			$('body').removeClass('cw-staffer-overlay');
			$('html').removeClass('cw-staffer-overlay');

			var state = { name: 'none' };
			history.replaceState(state, '', '?' );

			return false;
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
