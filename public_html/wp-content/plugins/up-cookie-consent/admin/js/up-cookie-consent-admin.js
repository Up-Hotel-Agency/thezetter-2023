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
		

		$('.js-layout .up-card').hover(function(e){
			var current = $(this).attr('data-value');
			$('.layout-widget').toggleClass('hover-mode');
			$('.layout-option[data-layout="'+current+'"]').toggleClass('hover-select');
		});

		var updating = false;

		$('.color-picker-input').on('input propertychange', function(e){
			if (!updating) {
				updating = true;
				$(this).parents('.color-selector').find('.hex-code').val(this.value);
				console.log("COLOUR PICKER: "+this.value);
				updating = false;
			}
		});

		$('.hex-code').on('input propertychange', function(e){
			if (!updating) {
				updating = true;
				$(this).parents('.color-selector').find('.color-picker-input').val(this.value);
				console.log("HEX CODE: "+this.value);
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

	});

})( jQuery );
