'use strict';

( function( $ ) {
	var $form     = $( '#plugin-task-form' ),
	    $nonce    = $form.find( '#_wpnonce' ),
	    $referer  = $form.find( 'input[name="_wp_http_referer"]'),
	    $submit   = $form.find( '#submit' ),
	    $fullname = $form.find( 'input[name="fullname"]' ),
	    $result   = $form.find( '#result' );


	$form.submit( function( e ) {
		e.preventDefault();

		$.ajax({
			method: 'POST',
			url: '/wp-admin/admin-ajax.php',
			data: {
				action: 'plugin_task_get_json',
				'_wpnonce': $nonce.val(),
				'_wp_http_referer': $referer.val(),
				fullname: $fullname.val(),
			},
			beforeSend: function ( xhr ) {
				// Remove the result.
				$result.val( '' );

				// Remove previous error notices.
				$form.parents( '.wrap' ).first().find( '.notice' ).remove();

				// Add loading button.
				$submit.removeClass( 'button-primary' );
				$submit.html( '<span class="spinner" style="visibility: visible"></span>' );

				// Disable submit button.
				$submit.prop( 'disabled', true );
			}
		} ).done( function( result ) {
			$result.val( result.data );
		}).fail( function( xhr ) {
			var errors = xhr.responseJSON;

			// Display error notice.
			if ( undefined !== errors ) {
				$.each( errors.data, function ( index, error ) {
					var notice = [
						'<div class="notice notice-error">',
						'<p>' + error.message + '</p>',
						'</div>'
					].join('');

					$form.parents( '.wrap' ).first().find('h1').append(notice);
				} );
			} else {
				var notice = [
					'<div class="notice notice-error">',
					'<p>Invalid nonce</p>',
					'</div>'
				].join('');

				$form.parents( '.wrap' ).first().find('h1').append(notice);
			}
		}).always( function() {
			$submit.addClass( 'button-primary' );
			$submit.html( 'Submit' );
			$submit.prop( 'disabled', false );
		});
	} );
}) ( jQuery );
