jQuery(function($){

	// on upload button click
	$('body').on( 'click', '.alex-upload', function(e){

		e.preventDefault();

		var button = $(this),
		custom_uploader = wp.media({
			title: 'Insert image',
			library : {
				// uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
				type : 'image'
			},
			button: {
				text: 'Use this image' // button label text
			},
			multiple: false
		}).on('select', function() { // it also has "open" and "close" events
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			button.html('<img src="' + attachment.url + '">').next().show();
            $('#trip-img').val(attachment.id);
		}).open();
	
	});

	// on remove button click
	$('body').on('click', '.alex-remove', function(e){

		e.preventDefault();

		var button = $(this);
		button.next().val(''); // emptying the hidden field
		button.hide().prev().html('Upload image');
	});

		// on clear metabox
	$('body').on('click', '#custom_woo_clear_metabox', function(e){

		e.preventDefault();

		$('.alex-remove:first').next().val(''); // emptying the hidden field
		$('.alex-remove:first').hide().prev().html('Upload image');

		$("input[name=trip-start]").val('');
        $('#custom_select').val('');
		
	});


	// on submit metabox
	$('body').on('click', '#custom_woo_submit_metabox', function(e){

		e.preventDefault();

		$('#post').submit();

		
		
	});


});