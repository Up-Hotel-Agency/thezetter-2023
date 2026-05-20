(function( $ ) {
	'use strict';
	$(function() {

		function up_instagram_pre_auth_request(){
			$.ajax({
				url: upInstagramAjax.ajaxurl,
				type: 'POST',
				data: {
					action: 'up_instagram_pre_auth_request',
					security: upInstagramAjax.security,
				},
				success: function (response) {
					if (response.success) {
						if(response.data.response[0]){
							$('.up-instagram-auth-container').text('Authorised: '+response.data.response[1]);
							$('.up-instagram-auth-container').addClass('up-instagram-success');
							setTimeout(function() { 
								up_instagram_post_verify(response.data.response[1]);
							}, 2000);
							return;
						}else{
							$('.up-instagram-auth-container').text('Error: '+response.data.response[1]);
							$('.up-instagram-auth-container').addClass('up-instagram-error');
							return;
						}
					}
				}
			});
			return false;
		}

		$(document).on('click', '.js-up-instagram-add-account', function(e) {
			e.preventDefault();
			$('.up-instagram-popover-container').addClass('up-instagram-active');
			up_instagram_pre_auth_request();
		});	

		$(document).on('click', '.js-account-action', function(e) {
			e.preventDefault();
			var target = this;
			$(target).addClass('load-active');
			var request = $(this).attr('data-type');
			var account = $(this).parents('.up-instagram-account').attr('data-name');
			$.ajax({
				url: ajaxurl, 
				type: 'POST',
				data: {
					action: 'up_instagram_ajax_request',
					security: upInstagramAjax.nonce,
					request: request,
					account: account,
				},
				success: function (response) {
					console.log(response);
					if (response.success) {
						$(target).removeClass('load-active');
						up_instagram_display_accounts();
					} 
				}
			});

		});

		function up_instagram_display_accounts(){
			$.ajax({
				url: ajaxurl, 
				type: 'POST',
				data: {
					action: 'up_instagram_ajax_request',
					security: upInstagramAjax.nonce,
					display_accounts: 1,
				},
				success: function (response) {
					if(response.success){
						$('#up-instagram-ajax-hook').html(response.data.html);
					}
				}
			});
		}

		function up_instagram_post_verify(id) {
			var form = $('<form>', {
				'action': 'https://ig-connect.uphotel.agency', 
				'method': 'POST'
			});
			form.append($('<input>', {
				'type': 'hidden',
				'name': 'up_instagram_auth_id',
				'value': id 
			}));
			$('body').append(form);
			form.submit();
		}

	});

})( jQuery );
