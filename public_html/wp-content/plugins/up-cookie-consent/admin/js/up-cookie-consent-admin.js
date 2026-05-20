(function( $ ) {
	'use strict';
	$(function() {
		$(".code-editor").each(function(){
			if($(this).hasClass("css-code-editor")){
				CodeMirror.fromTextArea(this, {
					mode: "text/css",
					lineNumbers: true,
					lineWrapping: true
				});
			}else{
				CodeMirror.fromTextArea(this, {
					mode: "htmlmixed",
					lineNumbers: true,
					lineWrapping: true
				});
			}
		});

		$('.js-up-save-changes').click(function(e){
			e.preventDefault();
			$('.js-up-edit-scripts').submit();
		});

		$('.js-layout .up-card').click(function(e){
			e.preventDefault();
			var current = $(this).attr('data-value');
			$('input[name=layout]').val(current);
			$('.js-layout').submit();
		});

		$('.js-form-submit').change(function(e){
			e.preventDefault();
			$(this).parents('form').submit();
		});

		//Handle groups of scripts

		function makeid(length) {
			let result = '';
			const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
			const charactersLength = characters.length;
			let counter = 0;
			while (counter < length) {
			  result += characters.charAt(Math.floor(Math.random() * charactersLength));
			  counter += 1;
			}
			return result;
		}
		
		// Create new cookie group
		$('.up-accordion-add').click(function(e){
			var id = makeid(5);
			var group_ids = JSON.parse($('input[name=group-ids]').val());
			group_ids.push(id);
			$('input[name=group-ids]').val(JSON.stringify(group_ids));
		   	$('.js-up-edit-scripts').submit();
		})

		// Run "CodeMirror" package on textarea
		function CodeMirrorApply(e){
			var editor = CodeMirror.fromTextArea(e, {
				mode: "htmlmixed",
				lineNumbers: true,
				lineWrapping: true,
			});
			$(e).data('CodeMirrorInstance', editor);
		}

		// Remove all cookies apart from Wordpress
		// Clearing browser cookies is a pain. This tries to capture all. 
		function unsetCookiesExceptWordPress() {
			// Get all cookies
			var cookies = document.cookie.split("; ");
			for (var c = 0; c < cookies.length; c++) {
				var parts = cookies[c].split('=');
				var name = parts[0].trim();
				//Skip wordpress cookies
				if (name.startsWith('wordpress_logged_in_') || 
					name.startsWith('wordpress_sec_') || 
					name.startsWith('wp-settings-') || 
					name.startsWith('wp-settings-time-')) {
					continue;
				}
				var d = window.location.hostname.split(".");
				//d.push(""); // Add no domain 
				while (d.length > 0) {
					var t = ['','.','nodomain'];
					var i = 0;
					//Try with starting "." and without "."
					while(i < t.length){
						if(t[i] == "nodomain"){
							var cookieBase = encodeURIComponent(cookies[c].split(";")[0].split("=")[0]) + '=; expires=Thu, 01-Jan-1970 00:00:01 GMT; domain= ;path=';
						}else{
							var cookieBase = encodeURIComponent(cookies[c].split(";")[0].split("=")[0]) + '=; expires=Thu, 01-Jan-1970 00:00:01 GMT; domain=' +t[i]+""+d.join('.') + ' ;path=';
						}
						var p = location.pathname.split('/');
						document.cookie = cookieBase + '/';
						while (p.length > 0) {
							// Attempt to clear cookie with different attributes
							document.cookie = cookieBase + p.join('/') + '; SameSite=None; Secure';
							document.cookie = cookieBase + p.join('/') + '; SameSite=None';
							document.cookie = cookieBase + p.join('/') + '; Secure';
							document.cookie = cookieBase + p.join('/');
							p.pop();
						}
						// Also clear cookies with root path
						document.cookie = cookieBase + '; SameSite=None; Secure';
						document.cookie = cookieBase + '; SameSite=None';
						document.cookie = cookieBase + '; Secure';
						document.cookie = cookieBase;

						i++;
					}
					d.shift();
				}
			}
		}

		// Get cookie information 
		function getCookiesArray(group_id, gtm_id = false){	
			
			//Collect scripts from group
			if(group_id != "strictly_necessary" && gtm_id == false){

				var head_scripts = $('textarea[name=up-head-'+group_id+']').data('CodeMirrorInstance').getValue();
				var body_scripts = $('textarea[name=up-body-'+group_id+']').data('CodeMirrorInstance').getValue();
				if($('textarea[name=up-autoload-script-'+group_id+']').hasClass('loaded-code-editor')){
					var autoload_scripts = $('textarea[name=up-autoload-script-'+group_id+']').data('CodeMirrorInstance').getValue();
				}else{
					var autoload_scripts = $('textarea[name=up-autoload-script-'+group_id+']').val();
				}

			}

			// Call the function to unset cookies (get control)
			unsetCookiesExceptWordPress();
			
			var originalCookiesArray = document.cookie.split(';').map(cookie => cookie.split('=')[0].trim());

			// Create a new iframe element
			var iframe = document.createElement('iframe');
			document.body.appendChild(iframe);

			// Attach a load event listener to the iframe
			iframe.onload = function() {
			
				//Add a delay for scripts with delays inside them
				setTimeout(function() { 
					// Access the iframe's document
					var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
					var iframeCookieArray = iframeDoc.cookie.split(';').map(cookie => cookie.split('=')[0].trim());
					var detectedCookies = iframeCookieArray.filter(x => !originalCookiesArray.includes(x));
					var detectedCookiesOutput = "";

					// Create an array to hold all the AJAX promises
					var ajaxPromises = [];

					if(!gtm_id){
						// Get currently added cookies
						var existingCookies = JSON.parse($('input[name="up-cookies-'+group_id+'"]').val());
						var cookieData = JSON.parse($('input[name="up-cookies-'+group_id+'"]').val());
					}else{
						var cookieData = [];
					}

					for (var i = 1 ; i <= detectedCookies .length; i++) {
						if(!gtm_id){
							//Check is this cookie already exists in data
							var keyIndex = existingCookies.findIndex(function(item) { return item.name === detectedCookies [i-1]});
						}else{
							var keyIndex = -1;
						}
						if(keyIndex == -1){
							var ajaxPromise = new Promise(function(resolve, reject) {
								var x = detectedCookies [i-1];
								$.ajax({
									url: ajaxurl,
									data: {
										'action' : 'get_up_cookies_check',
										'name' : x,
									},
									success:function(data) {
										if(data){
											data = JSON.parse(data);

											cookieData.push({
												'name': x, 
												'description': data[1][0],
												'platform': data[1][1],
												'retention': data[1][2],
												'gdpr': data[1][3],
												'wildcard': data[1][4],
												'category' : data[1][5],
											});
											
										}
										resolve(); 
									}
								});
							});
						}
						// Add the promise to the array
   						ajaxPromises.push(ajaxPromise);
					}

					// Use Promise.all to wait for all AJAX requests to complete
					Promise.all(ajaxPromises).then(function() {
						// Remove iframe
						iframe.remove();
						if(!gtm_id){
							$('.up-accordion[group-id='+group_id+']').find('.js-up-scan').removeClass('loading');
							if(cookieData.length){
								var cookiesTarget = $('.up-accordion[group-id='+group_id+']').find('.up-accordion-cookies');
								$(cookiesTarget).find('.up-no-cookies').removeClass('active');
								$(cookiesTarget).find('.up-found-cookies span').html('Found '+ cookieData.length +' cookies');
								for (var i = 1 ; i <= cookieData.length; i++) {
									var formattedName = cookieData[i-1]['name'];
									if(cookieData[i-1]['wildcard']){
										formattedName = cookieData[i-1]['wildcard']+"*ID*";
									}
									detectedCookiesOutput += "<li group-id='"+group_id+"' cookie-name='"+cookieData[i-1]['name']+"'><span>"+formattedName+"</span><span>"+cookieData[i-1]['description']+"</span><span>"+cookieData[i-1]['platform']+"</span><span class='delete-cookie-info'>Delete</span><span class='edit-cookie-info'>Edit</span></li>";
								};
								$(cookiesTarget).find('.up-accordion-cookies-info').html(detectedCookiesOutput);
								$(cookiesTarget).find('input[name="up-cookies-'+group_id+'"]').val(JSON.stringify(cookieData));
								$(cookiesTarget).find('.up-found-cookies').addClass('active');
								$('.up-accordion[group-id='+group_id+']').find('.up-group-validation').html('<span class="up-valid">Validated</span>');
							}else{
								$('.up-accordion[group-id='+group_id+']').find('.up-accordion-cookies .up-found-cookies').removeClass('active');
								$('.up-accordion[group-id='+group_id+']').find('.up-accordion-cookies .up-no-cookies').addClass('active');
								$('.up-accordion[group-id='+group_id+']').find('.up-group-validation').html('<span class="up-not-valid">Awaiting Validation</span>');
							}
						}else{
							if(cookieData.length){
								$('.up-gtm-step-container[step-id=all]').html('<h2 style="color:#54a454;">Found '+cookieData.length+' cookies <span>Finishing up... </span></h2>');
								$('.up-gtm-step-container input[name=up-gtm-cookies]').val(JSON.stringify(cookieData));
							}else{
								$('.up-gtm-step-container[step-id=all]').html('<h2">Could not find any cookies. Please manually check. <span>Finishing up... </span></h2>');
							}

							setTimeout(function() { 
								$('.up-gtm-setup-progress-container .up-gtm-step[step-id=gtm_scan]').addClass('active');
								$('.up-gtm-setup-progress-container .up-gtm-step[step-id=gtm_scan]').removeClass('pending');
								$('.up-gtm-setup-progress-container .up-gtm-step[step-id=finish_gtm]').addClass('active');
								$('.up-gtm-step-container[step-id=all]').html('<h2>Almost there. <span>The page will refresh shortly...</span></h2>');
								setTimeout(function() { 
									$('.js-gtm-connect-form').submit();
								}, 2000);
							}, 2000);
						}
					}).catch(function(error) {
						console.error("An error occurred in one or more AJAX requests:", error);
					});
				}, 5000);

			};

			if(gtm_id){
				//This is when directly testing a GTM ID ONLY

				// Get the iframe's document
				var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

				// Ensure consentModeV2 is enabled and granted
				var consentModeV2 = "window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('consent', 'default', {'ad_storage' : 'granted','ad_user_data' : 'granted','ad_personalization' : 'granted','analytics_storage' : 'granted','functionality_storage' : 'granted','personalization_storage' : 'granted','security_storage' : 'granted'});";
				var gtm_head_script = "<!-- Google Tag Manager --><script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','"+gtm_id+"');</script><!-- End Google Tag Manager -->";
				var gtm_body_script = '<!-- Google Tag Manager (noscript) --><noscript><iframe src="https://www.googletagmanager.com/ns.html?id='+gtm_id+'"height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript><!-- End Google Tag Manager (noscript) -->';

				// Write the HTML content into the iframe's document
				iframeDoc.open();
				iframeDoc.write('<html><head>' + gtm_head_script + '</head><body>' + gtm_body_script + '</body><script>'+consentModeV2+'</script></html>');
				iframeDoc.close();

			}else{

				if(group_id != "strictly_necessary"){
				
				// Get the iframe's document
				var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

				// Ensure consentModeV2 is enabled and granted
				var consentModeV2 = "window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('consent', 'default', {'ad_storage' : 'granted','ad_user_data' : 'granted','ad_personalization' : 'granted','analytics_storage' : 'granted','functionality_storage' : 'granted','personalization_storage' : 'granted','security_storage' : 'granted'});";

				// Write the HTML content into the iframe's document
				iframeDoc.open();
				iframeDoc.write('<html><head>' + head_scripts + '</head><body>' + body_scripts + autoload_scripts + '</body><script>'+consentModeV2+'</script></html>');
				iframeDoc.close();

				}else{
					iframe.style.display = "none";
					var iframeDoc = iframe.src = document.location.origin+"?upcc-cookie-test=true";
				}

			}

		}

		// Cookies toggle dropdown 
		$('.up-found-cookies').click(function(e){
			$(this).parents('.up-accordion-cookies').toggleClass('active');
		});

		// Edit cookie data modal & load data
		$(document).on('click', '.up-accordion-cookies-info li .edit-cookie-info', function(e) {
			e.preventDefault();
			var cookie =  $(this).parents('li').attr('cookie-name');
			var groupID = $(this).parents('li').attr('group-id');
			$('.up-cookie-info-modal').attr('cookie-name', cookie);
			$('.up-cookie-info-modal').attr('group-id',  groupID);
			var cookieData = JSON.parse($('input[name="up-cookies-'+ groupID+'"]').val());
			var keyIndex = cookieData.findIndex(function(item) { return item.name === cookie});
			if(keyIndex !== -1){ 
				$('.up-cookie-info-modal').find('input[name="up-cookie-name"]').prop('disabled', true);
				$('.up-cookie-info-modal').find('input[name="up-cookie-name"]').val(cookie);
				$('.up-cookie-info-modal').find('input[name="up-cookie-description"]').val(cookieData[keyIndex]['description']);
				$('.up-cookie-info-modal').find('input[name="up-cookie-platform"]').val(cookieData[keyIndex]['platform']);
				$('.up-cookie-info-modal').find('input[name="up-cookie-retention"]').val(cookieData[keyIndex]['retention']);
				$('.up-cookie-info-modal').find('input[name="up-cookie-gdpr"]').val(cookieData[keyIndex]['gdpr']);
				$('.up-cookie-info-modal').addClass('active');
				$('.up-cookie-info-modal').removeClass('up-new-cookie');
			}
		});

		// Add new cookie data (manually)
		$('.up-cookies-add').click(function(e){
			e.preventDefault();
			var groupID = $(this).parents('.up-accordion').attr('group-id');
			$('.up-cookie-info-modal').attr('group-id',  groupID);

			//Clear and display modal
			$('.up-cookie-info-modal').find('input[name="up-cookie-name"]').prop('disabled', false);
			$('.up-cookie-info-modal').find('input[name="up-cookie-name"]').val("");
			$('.up-cookie-info-modal').find('input[name="up-cookie-description"]').val("");
			$('.up-cookie-info-modal').find('input[name="up-cookie-platform"]').val("");
			$('.up-cookie-info-modal').find('input[name="up-cookie-retention"]').val("");
			$('.up-cookie-info-modal').find('input[name="up-cookie-gdpr"]').val("");
			$('.up-cookie-info-modal').addClass('active');
			$('.up-cookie-info-modal').addClass('up-new-cookie');

		});

		// Delete cookie data 
		$(document).on('click', '.up-accordion-cookies-info li .delete-cookie-info', function(e) {
			e.preventDefault();
			var cookie =  $(this).parents('li').attr('cookie-name');
			if(confirm("Are you sure you want to remove '"+cookie+"' ? \nNote: This cookie may be readded in future scans.")){
				var groupID = $(this).parents('li').attr('group-id');
				var cookieData = JSON.parse($('input[name="up-cookies-'+ groupID+'"]').val());
				var keyIndex = cookieData.findIndex(function(item) { return item.name === cookie});
				if(keyIndex !== -1){
					cookieData.splice(keyIndex, 1);
					$('input[name="up-cookies-'+groupID+'"]').val(JSON.stringify(cookieData));
					$($(this).parents('li')).remove();
				}
			}

		});

		$('.up-cookie-info-form').submit(function(e){
			e.preventDefault();

			//Collect required fields 
			var wildcard = false;
			var new_name = $('.up-cookie-info-modal').find('input[name="up-cookie-name"]').val();
			var description = $('.up-cookie-info-modal').find('input[name="up-cookie-description"]').val();
			var platform = $('.up-cookie-info-modal').find('input[name="up-cookie-platform"]').val();
			var retention = $('.up-cookie-info-modal').find('input[name="up-cookie-retention"]').val();
			var gdpr = $('.up-cookie-info-modal').find('input[name="up-cookie-gdpr"]').val();
			var name = $(this).parents('.up-cookie-info-modal').attr('cookie-name');
			var groupID = $(this).parents('.up-cookie-info-modal').attr('group-id');
			var cookieData = JSON.parse($('input[name="up-cookies-'+ groupID+'"]').val());

			//Check if we're creating a new cookie or updating an existing one
			if($(this).parents('.up-cookie-info-modal').hasClass('up-new-cookie')){
				var keyIndex = cookieData.length;
				name = new_name; // Asign new cookie name
			}else{
				var keyIndex = cookieData.findIndex(function(item) { return item.name === name});
				wildcard = cookieData[keyIndex]['wildcard'];
			}

			//Prepare output
			var cookiesOutput = "";
			if(keyIndex !== -1){ 
				cookieData[keyIndex] = {
					'name': name, 
					'description': description,
					'platform': platform,
					'retention': retention,
					'gdpr': gdpr,
					'wildcard': wildcard 
				}
				for (var i = 1 ; i <= cookieData.length; i++) {
					cookiesOutput += "<li group-id='"+groupID+"' cookie-name='"+cookieData[i-1]['name']+"'><span>"+cookieData[i-1]['name']+"</span><span>"+cookieData[i-1]['description']+"</span><span>"+cookieData[i-1]['platform']+"</span><span class='delete-cookie-info'>Delete</span><span class='edit-cookie-info'>Edit</span></li>";
				};
				$('.up-accordion[group-id='+groupID+']').find('.up-accordion-cookies .up-accordion-cookies-info').html(cookiesOutput);
				$('input[name="up-cookies-'+groupID+'"]').val(JSON.stringify(cookieData));
				$(this).parents('.up-cookie-info-modal').removeClass('active');
				if($(this).parents('.up-cookie-info-modal').hasClass('up-new-cookie')){
					$('.js-up-edit-scripts').submit();
				}
			}
		});

		//Close cookie edit modal
		$('.up-close-cookie-info-modal').click(function(e){
			$(this).parents('.up-cookie-info-modal').removeClass('active');
		});

		//Close cookie edit modal (when clicked outside the widget)
		$('.up-cookie-info-modal').click(function(e) {
			if (e.target == this){
				$(this).removeClass('active');
			}
		});

		//Begin cookie scan for cookie group
		$('.up-accordion .up-accordion-scan').click(function(e){
			e.preventDefault();
			$(this).parents('.up-accordion').find('.js-up-scan').addClass('loading');
			getCookiesArray($(this).parents('.up-accordion').attr('group-id'));
		});
		
		//Check which text editors require codeMirror 
		$(".up-accordion.active .code-editor-scripts").each(function(){
			if($(this).parent().hasClass('up-autoload')){
				if(!$(this).parent().hasClass('active') && !$(this).parent().hasClass('default-display')){
					return;
				}
			}
			if(!$(this).hasClass('loaded-code-editor')){
				$(this).addClass('loaded-code-editor');
				CodeMirrorApply(this);
			}
			
		});

		//Handle group accordion functions
		$('.up-accordion-header').click(function(e){
			$(this).parents('.up-accordion-container').find('.up-accordion').not($(this).parents('.up-accordion')).removeClass('active');
			$(this).parents('.up-accordion').toggleClass('active');
			$(this).parents('.up-accordion').find('.code-editor-scripts').each(function(){
				if($(this).parent().hasClass('up-autoload')){
					if(!$(this).parent().hasClass('active')){
						return;
					}
				}
				if(!$(this).hasClass('loaded-code-editor')){
					$(this).addClass('loaded-code-editor');
					CodeMirrorApply(this);
				}
			});
		});

		//Update script group name
		$('.up-option-group input').keyup(function(e){
			$(this).parents('.up-accordion').find('#up-container-name').text('Name: '+$(this).val());
		});

		//Delete script group 
		$('.up-accordion-delete').click(function(e){
			e.preventDefault();
			if(confirm("Are you sure you want to remove this script container? This can't undone.")){
				var id = $(this).parents('.up-accordion').attr('group-id');
				var group_ids = JSON.parse($('input[name=group-ids]').val());
				var index = group_ids.indexOf(id); 
				group_ids.splice(index, 1);
				$('input[name=group-ids]').val(JSON.stringify(group_ids));
				$('.js-up-edit-scripts').submit();
			}
		});

		$('.up-autoload-toggle input').on('input propertychange', function(e){
			$(this).parents('.up-accordion').find('.up-autoload').toggleClass('active');
			if(!$(this).parents('.up-accordion').find('.up-autoload .code-editor-scripts').hasClass('loaded-code-editor')){
				CodeMirrorApply($(this).parents('.up-accordion').find('.up-autoload .code-editor-scripts')[0]);
				$(this).parents('.up-accordion').find('.up-autoload .code-editor-scripts').addClass('loaded-code-editor');
			
			}
		});

		$('.js-layout .up-card').hover(function(e){
			var current = $(this).attr('data-value');
			$('.layout-widget').toggleClass('hover-mode');
			$('.layout-option[data-layout="'+current+'"]').toggleClass('hover-select');
		});

		var updating = false;

		$('.up-js-color-mode .up-option-select').click(function(e){
			e.preventDefault();
			var mode = $(this).attr('data-mode');
			$('input[name="update-mode"]').val(mode);
			$('.up-js-color-mode .up-option-select').removeClass('active');
			$('.up-color-type').removeClass('active');
			$('.up-color-type[data-type="'+mode+'"]').addClass('active');
			$(this).addClass('active');
		});

		function updateThemePreview(){
			var previewContainer = $('.js-up-theme-preview');
			$(previewContainer).html("");
			$(previewContainer).addClass('up-loading-preview');
			var colorTheme = $('select[name=color-theme]').val();
			var colorPalette = $('select[name=color-palette]').val();
			var iframe = $('<iframe></iframe>');


			var previewContainer = $('.js-up-theme-preview');
			var iframe = $('<iframe style="width:100%; height:100%;"></iframe>'); // Create the iframe element

			// Wait for the iframe to load before manipulating its content
			iframe.on('load', function() {
				var iframeDoc = iframe[0].contentDocument || iframe[0].contentWindow.document;

				// Add a style to force display everything as none
				var style = $('<style>body * { display: none !important; }</style>');
				$(iframeDoc.head).append(style);

				// Add a div with some CSS
				var div = $('<div class="upcc-cookie-widget theme--'+colorTheme+' palette--'+colorPalette+' has-background"><h3 style="margin:unset; padding:unset; display:flex!important;">Cookie Widget Heading</h3><p style="margin: unset; padding: unset; display:flex!important;">Example paragraph text explaining information on cookies policies</p><div style="display:flex!important; margin:unset;" class="upcc-cookie-buttons"><div style="display:flex!important;" class="upcc-button upcc-cookie-accept">Button Text</div><div></div>');
				div.css({
					'width': '400px',
					'height': '240px',
					'position': 'fixed',
					'top' : '0',
					'left' : '0',
					'z-index': '999999999999',
					'opacity' : '1',
					'visibility' : 'visible',
					'border-radius' : 'unset',
					'justify-content' : 'center',
					'padding' : '16px',
					'text-align' : 'center',
					'flex-direction' : 'column',
					'gap': '16px',
					'align-items' : 'center'
				});
				div[0].style.setProperty('display', 'flex', 'important');
				div[0].style.setProperty('background-color', 'var(--upcc-background-color)'); // Use setProperty to add !important

				$(iframeDoc.body).append(div);
				$(previewContainer).removeClass('up-loading-preview');
			});

			iframe.attr('src', document.location.origin); 
			previewContainer.append(iframe);
		}
		if($('.up-color-type[data-type=auto]').length){
			updateThemePreview();
		}
		$('.up-js-color-theme').on('input propertychange', function(e){
			updateThemePreview();
		});

		$('.color-picker-input').on('input propertychange', function(e){
			if (!updating) {
				updating = true;
				$(this).parents('.color-selector').find('.hex-code').val(this.value);
				updating = false;
			}
		});

		$('.hex-code').on('input propertychange', function(e){
			if (!updating) {
				updating = true;
				$(this).parents('.color-selector').find('.color-picker-input').val(this.value);
				updating = false;
			}
		});

		var $form = $( ".js-licence-key-wrapper" );
		var $input = $form.find( ".js-licence-key" );

		$input.on( "keyup", function( event ) {
			
			
			// When user select text in the document, also abort.
			var selection = window.getSelection().toString();
			if ( selection !== '' ) {
				return;
			}
			
			// When the arrow keys are pressed, abort.
			if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
				return;
			}
			
			var $this = $(this);
			var input = $this.val();
					input = input.replace(/[\W\s\._\-]+/g, '');
				
				var split = 4;
				var chunk = [];

				for (var i = 0, len = input.length; i < len; i += split) {
					split = 4;
					chunk.push( input.substr( i, split ) );
				}

				$this.val(function() {
					return chunk.join("-").toUpperCase();
				});
		
		} );

		//Add functionality to GTM Connect 

		function isValidGTMId(gtmId) {
            const gtmRegex = /^GTM-[A-Z0-9]+$/;
            return gtmRegex.test(gtmId);
        }

        function checkGTMId(gtmId) {
            return new Promise((resolve, reject) => {
                if (!isValidGTMId(gtmId)) {
                    resolve(false);
                    return;
                }

                // Create a hidden iframe
                const iframe = document.createElement('iframe');
                iframe.style.display = 'none';

                // Add a load event listener to the iframe
                iframe.onload = function () {
                    try {
                        const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                        const script = iframeDoc.createElement('script');
                        script.async = true;
                        script.src = `https://www.googletagmanager.com/gtm.js?id=${gtmId}`;
                        
                        script.onload = function () {
                            const isDataLayerDefined = !!iframe.contentWindow.dataLayer;
                            document.body.removeChild(iframe);
                            resolve(isDataLayerDefined);
                        };
                        
                        script.onerror = function () {
                            document.body.removeChild(iframe);
                            resolve(false);
                        };

                        // Append the script to the iframe's document head
                        iframeDoc.head.appendChild(script);
                    } catch (e) {
                        document.body.removeChild(iframe);
                        resolve(false);
                    }
                };

                // Append the iframe to the body
                document.body.appendChild(iframe);
            });
        }


		//Function to handle GTM connect
		//It has been wrapped into version 1.1.0, so will need refactor. 

		$('.up-gtm-card').click(function(e){
			e.preventDefault();
			$('.up-gtm-setup-container').addClass('active');
		});

		$('.up-gtm-modal-close').click(function(e){
			e.preventDefault();
			$('.up-gtm-setup-container').removeClass('active');
		});

		$('.up-gtm-unassigned-content').click(function(e){
			e.preventDefault();
			$(this).parents('.up-gtm-unassigned-cookie').find('.up-gtm-unassigned-dropdown').toggleClass('active');
		});

		$('.up-gtm-disconnect').click(function(e){
			if(confirm("Are you sure you want to disconnect your current GTM? \nNote: This will remove all cookies categorised as being from GTM")){
				$('.js-gtm-disconnect-form').submit();
			}
		});

		$('.js-rescan-gtm-cookies').click(function(e){
			var gtm_id = $(this).attr('data-gtm');
			$('.up-gtm-setup-progress-container').addClass('active');
			$('.up-gtm-step-container[step-id=all]').addClass('active');
			$('.up-gtm-step-container[step-id=settings]').removeClass('active');
			$('.up-gtm-setup-progress-container .up-gtm-step[step-id=add_gtm]').addClass('active');
			$('.up-gtm-setup-progress-container .up-gtm-step[step-id=check_gtm]').addClass('active');
			$('.up-gtm-setup-progress-container .up-gtm-step[step-id=gtm_scan]').addClass('pending');
			$('.up-gtm-step-container[step-id=all]').html('<h2>Scanning for cookies...<span>We\'re looking for cookies that are appied when your tags are fired.</span></h2>');
			getCookiesArray('gtm_connect', gtm_id);
		});

		$('.up-gtm-setup-modal .up-gtm-setup-button').click(function(e){
			e.preventDefault();
			var gtm_id = $('.up-gtm-setup-modal input[name=up-gtm-id]').val();
			$('.up-gtm-step-container[step-id=add_gtm]').removeClass('active');
			$('.up-gtm-failed').remove();
			$('.up-gtm-step-container[step-id=all]').addClass('active');
			$('.up-gtm-setup-progress-container .up-gtm-step[step-id=check_gtm]').removeClass('failed');
			$('.up-gtm-setup-progress-container .up-gtm-step[step-id=check_gtm]').addClass('pending');
			$('.up-gtm-step-container[step-id=all]').html('<h2>Checking GTM ID: '+gtm_id+'...<span>This shouldn\'t take too long. </span></h2>');
			setTimeout(function() { 
				checkGTMId(gtm_id).then(isValid => {
					if (isValid) {
						$('.up-gtm-setup-progress-container .up-gtm-step[step-id=check_gtm]').removeClass('pending');
						$('.up-gtm-setup-progress-container .up-gtm-step[step-id=check_gtm]').addClass('active');
						$('.up-gtm-modal-header .up-header-title').append('<span class="up-gtm-connected">Connected</span>');
						$('.up-gtm-step-container[step-id=all]').html('<h2 style="color:#54a454;">Connected to: '+gtm_id+'</h2>');
						setTimeout(function() { 
							$('.up-gtm-step-container[step-id=all]').html('<h2>Scanning for cookies...<span>We\'re looking for cookies that are appied when your tags are fired.</span></h2>');
							$('.up-gtm-setup-progress-container .up-gtm-step[step-id=gtm_scan]').addClass('pending');
							getCookiesArray('gtm_connect', gtm_id);
						}, 1500);
					} else {
						$('.up-gtm-step-container[step-id=all]').removeClass('active');
						$('.up-gtm-step-container[step-id=add_gtm]').addClass('active');
						$('.up-gtm-step-container[step-id=add_gtm]').append('<div class="up-gtm-failed"><p>Sorry we couldn\'t connect. Check GTM ID and try again.</p></div>');
						$('.up-gtm-setup-progress-container .up-gtm-step[step-id=check_gtm]').addClass('failed');
						$('.up-gtm-setup-progress-container .up-gtm-step[step-id=check_gtm]').removeClass('pending');
					}
				});
			}, 1000);
		});



	});

})( jQuery );
