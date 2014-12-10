jQuery(document).ready( function($) {
    $('#instafilta-field').instaFilta({
        targets: '.faq_question .faq_answer',
        markMatches: true
    });
    $('#instafilta-field-site').instaFilta({
        targets: '.faq_question',
        markMatches: true
    });

    $( '.category' ).click( function() {
    	var category_id = $( this ).attr( 'id' );
    	if ( category_id == 0 ) {
    		$( '.ac-container div' ).show( 'slow' );
    		return false;
    	}

    	$( '.ac-container div' ).each( function() {
    		if ( $(this).hasClass( category_id ) ) {
                $( this ).show( 'slow' );
    		} else {
    			$( this ).hide( 'slow' );
    		}
    	} );

    	return false;
    } );

    $( '.category-admin' ).click( function() {
        var category_id = $( this ).attr( 'id' );
        if ( category_id == 0 ) {
            $( '.accordion div' ).show( 'slow' );
            $( '.accordion div .panel-content' ).hide();
            return false;
        }

        $( '.accordion div.faq-block' ).each( function() {
            if ( $(this).hasClass( category_id ) ) {
                $( this ).show( 'slow' );
            } else {
                $( this ).hide( 'slow' );
            }
        } );

        return false;
    } );
});