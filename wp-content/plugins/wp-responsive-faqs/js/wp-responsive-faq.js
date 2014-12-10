jQuery( document ).ready( function( $ ) {
    // Hiding the panel content. If JS is inactive, content will be displayed
    $('.panel-content').hide();

// Preparing the DOM

// -- Update the markup of accordion container
    $('.accordion').attr({
        role: 'tablist',
        multiselectable: 'true'
    });

// -- Adding ID, aria-labelled-by, role and aria-labelledby attributes to panel content
    $('.panel-content').attr('id', function (IDcount) {
        return 'panel-' + IDcount;
    });
    $('.panel-content').attr('aria-labelledby', function (IDcount) {
        return 'control-panel-' + IDcount;
    });
    $('.panel-content').attr('aria-hidden', 'true');
// ---- Only for accordion, add role tabpanel
    $('.accordion .panel-content').attr('role', 'tabpanel');

// -- Wrapping panel title content with a <a href="">
    $('.panel-title').each(function (i) {

        // ---- Need to identify the target, easy it's the immediate brother
        $target = $(this).next('.panel-content')[0].id;

        // ---- Creating the link with aria and link it to the panel content
        $link = $('<a>', {
            'href': '#' + $target,
            'aria-expanded': 'false',
            'aria-controls': $target,
            'id': 'control-' + $target
        });

        // ---- Output the link
        $(this).wrapInner($link);

    });

// Optional : include an icon. Better in JS because without JS it have non-sense.
    $('.panel-title a').append('<span class="icon">+</span>');

// Now we can play with it
    $('.panel-title a').click(function () {

        if ($(this).attr('aria-expanded') == 'false') { //If aria expanded is false then it's not opened and we want it opened !

            // -- Only for accordion effect (2 options) : comment or uncomment the one you want

            // ---- Option 1 : close only opened panel in the same accordion
            //      search through the current Accordion container for opened panel and close it, remove class and change aria expanded value
            $(this).parents('.accordion').find('[aria-expanded=true]').attr('aria-expanded', false).removeClass('active').parent().next('.panel-content').slideUp(200).attr('aria-hidden', 'true');

            // Option 2 : close all opened panels in all accordion container
            //$('.accordion .panel-title > a').attr('aria-expanded', false).removeClass('active').parent().next('.panel-content').slideUp(200);

            // Finally we open the panel, set class active for styling purpos on a and aria-expanded to "true"
            $(this).attr('aria-expanded', true).addClass('active').parent().next('.panel-content').slideDown(200).attr('aria-hidden', 'false');

        } else { // The current panel is opened and we want to close it

            $(this).attr('aria-expanded', false).removeClass('active').parent().next('.panel-content').slideUp(200).attr('aria-hidden', 'true');
            ;

        }
        // No Boing Boing
        return false;
    });


    /*----------------------------------------Add Category--------------------------*/
    $( '.edit_category' ).hide();
    $( '.category_update_links' ).hide();
    $( '#add_faq_category' ).submit( function(){
        var element         = $(this);
        var categories      = $( '#faq_category' ).val();

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {category_string: categories, action: 'add_category'},
            beforeSend: function() {
                element.find( '.button' ).after( ' <i>Adding Categories...</i>' );
            },
            success: function( data ) {
                element.find( 'i' ).remove();

                if( data ) {
                    element.find('#minor-publishing').append( data );
                    element.find('#faq_category').val( ' ' );

                    var cat_name = '<span style="margin:5px; float: left;"><input type="checkbox" name="'+ ToUpper( categories ) +'">'+ ToUpper( categories ) +'</span>';
                    var add_cat_to_list = '<a href="#" class="category-admin"> | '+ ToUpper( categories ) +'</a>';

                    $( '.category_collection' ).append( cat_name );
                    $( '.category-block').append( add_cat_to_list );
                }
            }
        });


        return false;
    } );
    /*----------------------------------------Add Category--------------------------*/


    /*----------------------------------------Edit Category--------------------------*/
    $( '.category_edit' ).click( function() {
        $(this).closest( 'p' ).find( '.category_edit_links' ).hide();
        $(this).closest( 'p' ).find( '.category_update_links' ).show();
        $(this).closest( 'p' ).find( '.edit_category' ).show();
        $(this).closest( 'p' ).find( '.category_name' ).hide();
        return false;
    } );

    $( '.category_cancel' ).click( function() {
        $(this).closest( 'p' ).find( '.category_edit_links' ).show();
        $(this).closest( 'p' ).find( '.category_update_links' ).hide();
        $(this).closest( 'p' ).find( '.edit_category' ).hide();
        $(this).closest( 'p' ).find( '.category_name' ).show();
        return false;
    } );
    /*----------------------------------------Edit Category--------------------------*/


    /*----------------------------------------Update Category--------------------------*/
    $( '.category_update' ).click( function() {
        var new_name    = $( this ).closest( 'p' ).find( '.edit_category' ).val();
        var category_id = $( this ).closest( 'p' ).find( '.category_id' ).val();
        var element     = $(this);

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {category: new_name, id: category_id, action: 'update_category_name'},
            beforeSend: function() {
                //$(this).after( '<i>  Updating category...</i>' );
            },
            success: function( data ) {
                console.log( data );
                if ( data === 'success' ) {
                    element.closest( 'p' ).find( '.category_name' ).html( new_name );
                    element.closest( 'p' ).find( '.category_edit_links' ).show();
                    element.closest( 'p' ).find( '.category_update_links' ).hide();
                    element.closest( 'p' ).find( '.edit_category' ).hide();
                    element.closest( 'p' ).find( '.category_name' ).show();
                    alert( 'Category updated. Please wait till the changes takes affect.' );
                    setTimeout(function(){
                        location.reload();
                    },100);
                }
                element.siblings('i').remove();

            }
        });


        return false;
    } );
    /*----------------------------------------Update Category--------------------------*/

    /*----------------------------------------Delete Category--------------------------*/
    $( '.category_delete' ).click( function() {
        var r = confirm("This can not be undone. Are you sure want to delete this Category ?");
        if ( r == true ) {
            var element     = $(this);
            var category_id = $( this ).closest( 'p' ).find( '.category_id' ).val();

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {id: category_id, action: 'delete_category_name'},
                beforeSend: function() {
                    //$(this).after( '<i>  Updating category...</i>' );
                },
                success: function( data ) {
                    console.log( data );
                    if ( data === 'success' ) {
                        // element.closest( 'p' ).remove();
                        // $( '.category_collection :input[value="'+ category_id +'"]' ).closest( 'span' ).remove();
                        alert( 'Category Deleted. Please wait till the changes takes affect.' );
                        setTimeout(function(){
                            location.reload();
                        },100);
                    }
                    element.siblings('i').remove();

                }
            });
        }

        return false;
    } );
    /*----------------------------------------Delete Category--------------------------*/

    /*----------------------------------------Post Faq--------------------------*/
    $('#wp_ajax_faq_form').submit(function() {
        var faq_question    = $('#wp_responsive_faq_question').val();
        var faq_answer      = $('#wp_responsive_faq_answer').val();
        var faq_categories  = [];
        $( '.new_faq .wp_responsive_faq_category:checked' ).each( function() {
            faq_categories.push( $(this).val() );
        } );

        $.ajax({
            type: 'POST',
            data: {question: faq_question,categories: faq_categories, answer: faq_answer, action: 'post_faq'},
            url: ajaxurl,
            beforeSend: function() {
                $("#checking").show().html('Saving FAQ....');
            },
            success: function( data ) {
                $("#checking").hide();
                if( data.indexOf( 'Something' ) >= 0 ) {
                    $( '#faq_error' ).show().html( data );
                } else {
                    $( '#faq_error' ).hide();
                    $('#wp_responsive_faq_question').val('');
                    $('#wp_responsive_faq_answer').val('');
                    $( '#faq_success' ).show().html( 'FAQ with question " ' + faq_question + ' ", saved successfully! <br>Please wait till result updates.' );
                    setTimeout(function(){
                        location.reload();
                    },1000);
                }
            }
        });

        return false;
    });
    /*----------------------------------------Post Faq--------------------------*/

    /*------------Faq List------------------*/
    $('.answer-edit').hide();
    $('.answer_update_links').hide();

    $('.faq_edit').click( function() {
        $( this ).closest( '.edit-buttons' ).find( '.answer_edit_links' ).hide();
        $( this ).closest( '.edit-buttons' ).find( '.answer_update_links' ).show();

        $( this ).closest( '.panel-content' ).find( '.answer-box').hide();
        $( this ).closest( '.panel-content' ).find( '.answer-edit').show();
        return false;
    });

    $('.faq_cancel').click( function() {
        $( this ).closest( '.edit-buttons' ).find( '.answer_edit_links' ).show();
        $( this ).closest( '.edit-buttons' ).find( '.answer_update_links' ).hide();

        $( this ).closest( '.panel-content' ).find( '.answer-box').show();
        $( this ).closest( '.panel-content' ).find( '.answer-edit').hide();
        return false;
    });
    /*------------Faq List------------------*/

    /*---------------------Edit FAQ-------------------------*/
    $('form.wp_responsive_faq_edit_form').submit( function() {
        var faq_id          =  $(this).find('.faq_id').val();
        var faq_question    =  $(this).find('.wp_ajax_faq_question_edit').val();
        var faq_answer      =  $(this).find('.wp_ajax_faq_answer_edit').val();
        var message_box     =  $(this).find('.checking_update');
        var faq_categories = [];
        $(this).find( '.wp_responsive_faq_category_edit:checked' ).each( function() {
            faq_categories.push( $(this).val() );
        } );

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {id: faq_id,question: faq_question,categories: faq_categories, answer: faq_answer, action: 'edit_faq'},
            beforeSend: function() {
                message_box.show().html('Updating FAQ....');
            },
            success: function( data ){
                if( data.indexOf( 'Something' ) >= 0 ) {
                    message_box.css( 'color', 'red' ).show().html( 'Something went wrong. Please check if both question and answer is provided.' );
                } else {
                    message_box.css( 'color', 'green').show().html( 'FAQ with question " ' + faq_question + ' ", updated successfully! Please wait till result updates.' );
                    setTimeout(function(){
                        location.reload();
                    },1000);
                }
            }
        });

        return false;
    });
    /*---------------------Edit FAQ-------------------------*/


    /*-------------------------Delete FAQ-----------------------------*/
    $('.faq_delete').click( function() {
        var r = confirm("This can not be undone. Are you sure want to delete this FAQ ?");
        if ( r == true ) {
            var faq_id          = $(this).closest('form.wp_responsive_faq_edit_form').find('.faq_id').val();
            var faq_question    = $(this).closest('form.wp_responsive_faq_edit_form').find('.wp_responsive_faq_question_edit').val();
            var message_box     = $(this).find('.checking_update');
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {id: faq_id, action: 'delete_faq'},
                beforeSend: function() {
                    $(this).siblings(".checking_update").show().html('Deleting FAQ....');
                },
                success: function( data ){
                    if( data.indexOf( 'Something' ) >= 0 ) {
                        message_box.show().html( data );
                    } else {
                        alert( 'FAQ with question " ' + faq_question + ' ", deleted successfully! Please wait till result updates.' );
                        setTimeout(function(){
                            location.reload();
                        },1000);
                    }
                }
            });
        }

        return false;
    });
    /*-------------------------Delete FAQ-----------------------------*/



    function ToUpper( str ) {
        str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase();
        });

        return str;
    }
} );