(function( $ ) {
	'use strict';
	$(function() {
		console.log("FOUND");
		$(".code-editor").each(function(){
			console.log("FOUND");
			CodeMirror.fromTextArea(this, {
				mode: "htmlmixed",
				lineNumbers: true,
				lineWrapping: true
			});
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

		$('.js-update-widget-setting').change(function(e){
			e.preventDefault();
			$('.js-widget-setting').submit();
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
	});

})( jQuery );
