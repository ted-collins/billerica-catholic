<?php
/*
 * Register the menu to the admin panel
 */
add_action( 'admin_menu', 'wp_responsive_faq_admin_menu' );
function wp_responsive_faq_admin_menu()
{
    add_menu_page( 'WP Responsive FAQ', 'WP FAQ', 'manage_options', 'wp-responsive-faq-settings', 'wp_responsive_faq_options' );

    wp_enqueue_style( 'wp-responsive-faq-css', plugin_dir_url( __FILE__ ) . '../css/wp-responsive-faq.css' );
    wp_enqueue_style( 'wp-responsive-faq-css-accordion', plugin_dir_url( __FILE__ ) . '../css/accordion.css' );
    wp_enqueue_script( 'wp-responsive-faq-js', plugin_dir_url( __FILE__ ) . '../js/modernizr.js', ['jquery']  );
    wp_enqueue_script( 'wp-responsive-faq-js-custom', plugin_dir_url( __FILE__ ) . '../js/wp-responsive-faq.js', ['jquery']  );

    wp_enqueue_script( 'wp_responsive_faq_gulpfile', plugin_dir_url( __FILE__ ) . '../js/jq_filter/gulpfile.js', ['jquery']  );
    wp_enqueue_script( 'wp_responsive_faq_instafilta', plugin_dir_url( __FILE__ ) . '../js/jq_filter/instafilta.min.js', ['jquery']  );
    wp_enqueue_script( 'wp_responsive_faq_faq', plugin_dir_url( __FILE__ ) . '../js/jq_filter/wp_ajax_faq.js', ['jquery']  );
    wp_enqueue_script( 'wp_responsive_faq_jquery_ui', plugin_dir_url( __FILE__ ) . '../js/jquery-ui.min.js', ['jquery']  );
}
function wp_responsive_faq_options()
{
    if( !current_user_can( 'manage_options' ) )
    {
        die( 'You do not have sufficient permissions to access this page.' );
    }
    ?>

    <div class="wrap">
        <?php require( '/partials/_form_elements.php' ) ?>
        <h2>Create WP FAQ</h2>
        <div id="faq_success" class="alert alert-success hide"></div>
        <div id="faq_error" class="alert alert-danger hide"></div>


        <div id="poststuff">
            <div class="left-col">
                <div id="faq-body" class="metabox-holder columns-1">
                    <div id="faq-body-content">
                        <form id="wp_ajax_faq_form">

                            <?php
                            global $wpdb;
                            $table_name         = $wpdb->prefix . WP_RESPONSIVE_FAQ_TABLE_NAME;
                            $categories_table   = $wpdb->prefix . WP_RESPONSIVE_FAQ_CATEGORIES_TABLE_NAME;
                            $results            = $wpdb->get_results( 'SELECT * FROM ' . $categories_table . ' ORDER BY id ASC', ARRAY_A );
                            $categories = [];
                            foreach( $results as $result )
                            {
                                $categories[ $result['id'] ] = $result['name'];
                            }
                            $category_list = $categories;
                            FaqForm( '', '', '', false, $categories, null );
                            ?>

                            <div class="alert alert-success hide" id="checking"></div>
                            <div id="postdivrich" class="postarea wp-editor-expand">
                                <input
                                    type="submit"
                                    name="submit"
                                    id="wp_ajax_faq_submit"
                                    class="button button-primary button-large">
                                <button type="reset" value="Cancel" class="button button-large">Cancel</button>
                            </div>
                        </form>

                    </div><!-- /faq-body-content -->

                </div><!-- /faq-body -->

                <br class="clear">

                <div class="faq-list-body">
                    <div class="wp_responsive_faq_container">

                        <header>
                            <h1>WP <span>FAQ List</span></h1>
                            <!--<input type="text" id="instafilta-field" placeholder="Type to filter">-->
                            <p class="clr"></p>
                        </header>
                        <?php echo CategoryList(); ?>
                        <section class="accordion" id="sortMe">
                            <?php
                            global $wpdb;
                            $table_name             = $wpdb->prefix . WP_RESPONSIVE_FAQ_TABLE_NAME;
                            $category_table_name    = $wpdb->prefix . WP_RESPONSIVE_FAQ_CATEGORIES_TABLE_NAME;
                            $faq_cat_table_name     = $wpdb->prefix . WP_RESPONSIVE_FAQ_CAT_TABLE_NAME;

                            $sql        = '
                                SELECT '. $table_name .'.*, GROUP_CONCAT( '. $faq_cat_table_name .'.category_id) AS categories FROM '. $table_name .'
                                LEFT JOIN '. $faq_cat_table_name .'
                                ON '. $faq_cat_table_name .'.faq_id = '. $table_name .'.id
                                GROUP BY '. $table_name .'.id
                                ORDER BY order_id ASC
                            ';
                            $results    = $wpdb->get_results( $sql, ARRAY_A );
                            ?>
                            <?php if( $results ): foreach( $results as $result ) : ?>
                                <?php
                                $faq_cats = explode(',', $result['categories']);
                                $category_class = '';
                                foreach ($faq_cats as $category) {
                                    if ( !$category ) {
                                        $category = 1;
                                    }
                                    $category_class .= 'cat' . $category . ' ';
                                }
                                ?>
                                <div class="faq-block <?php echo $category_class ?>" id="item_<?php echo $result['id']; ?>">
                                    <form id='faq-<?php echo $result['id'] ?>' class="wp_responsive_faq_edit_form">
                                        <input type="hidden" name="faq_id" value="<?php echo $result['id']; ?>" class="faq_id" >
                                        <h3 class="panel-title faq_question"><span class="ques-icon">Q:</span><?php echo stripslashes( trim( $result['question'] ) ) ?></h3>
                                        <div class="panel-content">
                                            <p class="answer-box">
                                                <?php
                                                $sql = '
                                                    SELECT '. $category_table_name .'.id, '. $category_table_name .'.name
                                                    FROM '. $category_table_name .'
                                                    LEFT JOIN '. $faq_cat_table_name .'
                                                    ON '. $faq_cat_table_name .'.category_id = '. $category_table_name .'.id
                                                    WHERE '. $faq_cat_table_name .'.faq_id = %s
                                                ';
                                                $prepared_query = $wpdb->prepare( $sql, $result['id'] );
                                                $cats           = $wpdb->get_results( $prepared_query, ARRAY_A );
                                                $faq_cats       = '';
                                                $active_categories = [];
                                                if( $cats ) {
                                                    foreach ($cats as $categories) {
                                                        $faq_cats .= ucwords($categories['name']) . ', ';
                                                        $active_categories[] = $categories['id'];
                                                    }
                                                } else {
                                                    $sql            = 'SELECT * FROM '. $category_table_name .' WHERE id = 1';
                                                    $cats           = $wpdb->get_results( $sql, ARRAY_A );
                                                    $faq_cats       = ucwords( $cats[0]['name'] );
                                                }
                                                ?>
                                                <span><i style="font-weight: 800;">In Categories: </i> <?php echo esc_attr( $faq_cats ); ?></span> <br><br>
                                                <?php echo stripslashes( $result['answer'] ) ?>
                                            </p>
                                            <p class="answer-edit">
                                                <?php FaqForm( 1 ,$result['question'], $result['answer'], true, $category_list, $active_categories );  ?>
                                            </p>
                                            <div class="panel-button">
                                                <span class="edit-buttons">
                                                    <span class="answer_edit_links">
                                                        <button class="button button-primary button-large faq_edit edit-panel" name="edit">Edit</button>
                                                        <button class="button button-large faq_delete edit-panel" name="delete">Delete</button>
                                                    </span>
                                                    <span class="answer_update_links">
                                                        <button class="button button-primary button-large faq_submit cancel-panel" name="edit">Submit</button>
                                                        <button class="button button-large faq_cancel cancel-panel" name="delete">Cancel</button>
                                                    </span>
                                                </span>
                                                <span class="checking_update"></span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php endforeach; endif; ?>
                        </section>
                    </div>
                </div>
            </div>
        </div>

        <div class="rigth-col">
            <form action="" method="post" id="add_faq_category">
                <div id="side-sortables" class="meta-box-sortables ui-sortable" style="">
                    <div id="submitdiv" class="postbox ">
                        <h3 class="hndle"><span>Categories</span></h3>
                        <div class="inside">
                            <div class="submitbox" id="submitpost">
                                <div id="minor-publishing">
                                    <?php
                                    global $wpdb;
                                    $table_name             = $wpdb->prefix . WP_RESPONSIVE_FAQ_TABLE_NAME;
                                    $categories_table       = $wpdb->prefix . WP_RESPONSIVE_FAQ_CATEGORIES_TABLE_NAME;
                                    $results                = $wpdb->get_results( 'SELECT * FROM ' . $categories_table . ' ORDER BY id ASC', ARRAY_A );
                                    foreach( $results as $result )
                                    {
                                        Category( $result[ 'id' ], $result['name'] );
                                    }
                                ?>
                                </div>
                            </div>

                            <div id="major-publishing-actions">
                                <input type="text" class="widefat" placeholder="Category Name" id="faq_category">
                                <input name="categories" type="submit" class="button button-primary button-large" value="Add">
                            </div>
                        </div>
                    </div>
                </div>
            <form>
        </div>

    </div>

    <?php
}

/**
 * Add a new category
 */
add_action( 'wp_ajax_add_category', 'add_categories' );
function add_categories() {
    $category_string = isset( $_POST['category_string'] ) ? $_POST['category_string'] : null;
    $message = '';

    if ( $category_string ) {
        require( '/partials/_form_elements.php' );

        global $wpdb;
        $table_name         = $wpdb->prefix . WP_RESPONSIVE_FAQ_TABLE_NAME;
        $categories_table   = $wpdb->prefix . WP_RESPONSIVE_FAQ_CATEGORIES_TABLE_NAME;

        $category_array = explode(',', $category_string);
        foreach ($category_array as $category) {
            $category = trim( strtolower( $category ) );
            $prepared_query     = $wpdb->prepare( 'SELECT * FROM ' . $categories_table . ' WHERE name = %s', $category );
            $category_present   = $wpdb->query( $prepared_query );
            if ( !$category_present ) {
                $sql                    = 'INSERT INTO '. $categories_table .' (name) VALUES(%s)';
                $prepared_sql           = $wpdb->prepare( $sql, $category );
                $result_new_category    = $wpdb->query( $prepared_sql );
                $id                     = $wpdb->insert_id;
                $message                .= Category( $id, $category );
            }
        }

    }

    echo $message;
    die();
}

/**
 * Update a category
 */
add_action( 'wp_ajax_update_category_name', 'update_category' );
function update_category() {
    $id         = isset( $_POST['id'] ) ? $_POST['id'] : null;
    $category   = isset( $_POST['category'] ) ? $_POST['category'] : null;

    $message = '';

    if ( !$id ) {
        echo 'fail';
        exit();
    }

    global $wpdb;
    $table_name         = $wpdb->prefix . WP_RESPONSIVE_FAQ_CATEGORIES_TABLE_NAME;
    $categories_table   = $wpdb->prefix . WP_RESPONSIVE_FAQ_CATEGORIES_TABLE_NAME;

    $sql = '
        UPDATE '. $categories_table .'
        SET name = %s
        WHERE id = %s
    ';
    $prepared_query = $wpdb->prepare( $sql, $category, $id );
    $result = $wpdb->query( $prepared_query );

    $message = 'success';
    echo $message;
    exit();
}

/**
 * Delete a category
 */
add_action( 'wp_ajax_delete_category_name', 'delete_category' );
function delete_category() {
    $id         = isset( $_POST['id'] ) ? $_POST['id'] : null;
    if ( !$id ) {
        echo 'fail';
        exit();
    }

    global $wpdb;
    $table_name         = $wpdb->prefix . WP_RESPONSIVE_FAQ_TABLE_NAME;
    $categories_table   = $wpdb->prefix . WP_RESPONSIVE_FAQ_CATEGORIES_TABLE_NAME;
    $faq_cat_table      = $wpdb->prefix . WP_RESPONSIVE_FAQ_CAT_TABLE_NAME;

    $sql = '
        DELETE FROM '. $categories_table .'
        WHERE id = %s
    ';
    $prepared_query = $wpdb->prepare( $sql, $id );
    $result         = $wpdb->query( $prepared_query );

    $message = 'success';
    echo $message;
    exit();
}

/**
 * Add a new FAQ
 */
add_action( 'wp_ajax_post_faq', 'post_faq' );
function post_faq() {
    $question   = isset( $_POST['question'] ) ? $_POST['question'] : null;
    $answer     = isset( $_POST['answer'] ) ? $_POST['answer'] : null;
    $categories = isset( $_POST['categories'] ) ? $_POST['categories'] : null;

    $errors = [];
    if( !$question )
        $errors[] = 'Please type in your FAQ Question.';
    if( !$answer )
        $errors[] = 'Please type in the answer of the question.';


    $message = '';
    if( !empty( $errors ) ) {
        $message .= '<p>Something went wrong.</h2><p>';
        foreach( $errors as $error ) {
            $message .= '<li>'. $error .'</li>';
        }
    } else {
        global $wpdb;
        $table_name     = $wpdb->prefix . WP_RESPONSIVE_FAQ_TABLE_NAME;
        $faq_cat_table  = $wpdb->prefix . WP_RESPONSIVE_FAQ_CAT_TABLE_NAME;

        $sql = 'INSERT INTO ' . $table_name . ' '
            . '(question,answer) '
            . 'VALUES(%s, %s)';

        $prepared_query = $wpdb->prepare( $sql, $question, $answer );
        $wpdb->query( $prepared_query );
        $faq_id = $wpdb->insert_id;

        $sql_order_id = 'UPDATE ' . $table_name . ' SET order_id = ' . $faq_id . ' WHERE id = ' . $faq_id;
        $wpdb->query( $sql_order_id );

        if ( $categories ) {
            foreach ($categories as $category) {
                $sql = 'INSERT INTO ' . $faq_cat_table . ' '
                    . '(faq_id,category_id) '
                    . 'VALUES(%s, %s)';

                $prepared_query = $wpdb->prepare( $sql, $faq_id, $category );
                $wpdb->query( $prepared_query );
            }
        } else {
            $category = 1;
            $sql = 'INSERT INTO ' . $faq_cat_table . ' '
                . '(faq_id,category_id) '
                . 'VALUES(%s, %s)';

            $prepared_query = $wpdb->prepare( $sql, $faq_id, $category );
            $wpdb->query( $prepared_query );
        }
    }
    echo $message;
    die();
}

/**
 * Update a FAQ
 */
add_action( 'wp_ajax_edit_faq', 'edit_faq' );
function edit_faq() {
    $faq_id     = isset( $_POST['id'] ) ? $_POST['id'] : null;
    $question   = isset( $_POST['question'] ) ? $_POST['question'] : null;
    $answer     = isset( $_POST['answer'] ) ? $_POST['answer'] : null;
    $categories = isset( $_POST['categories'] ) ? $_POST['categories'] : null;

    $errors = [];
    if( !$question )
        $errors[] = 'Please type in your FAQ Question.';
    if( !$answer )
        $errors[] = 'Please type in the answer of the question.';

    $message = '';
    if( !empty( $errors ) ) {
        $message .= '<p>Something went wrong.</h2><p>';
        foreach( $errors as $error ) {
            $message .= '<li>'. $error .'</li>';
        }
    } else {

        global $wpdb;
        $table_name     = $wpdb->prefix . WP_RESPONSIVE_FAQ_TABLE_NAME;
        $faq_cat_table  = $wpdb->prefix . WP_RESPONSIVE_FAQ_CAT_TABLE_NAME;

        $sql = 'UPDATE ' . $table_name . ' '
            . 'SET '
            . 'question = %s, '
            . 'answer = %s, '
            . 'updated_at = CURRENT_TIMESTAMP() '
            . 'WHERE id = ' . $faq_id;

        $prepared_query = $wpdb->prepare( $sql, $question, $answer );
        $wpdb->query( $prepared_query );

        $delete_previous = 'DELEtE FROM ' . $faq_cat_table . ' WHERE faq_id = %d';
        $prepared_delete_query = $wpdb->prepare( $delete_previous, $faq_id );
        $resul_delete_previous = $wpdb->query( $prepared_delete_query, ARRAY_A );

        if ( $categories ) {

            foreach ($categories as $category) {

                $update_new = 'INSERT INTO ' . $faq_cat_table . ' '
                    . '(faq_id,category_id) '
                    . 'VALUES(%s, %s)';

                $prepared_update_new_query = $wpdb->prepare( $update_new, $faq_id, $category );
                $wpdb->query( $prepared_update_new_query );
            }
        } else {
            $category = 1;
            $sql = 'INSERT INTO ' . $faq_cat_table . ' '
                . '(faq_id,category_id) '
                . 'VALUES(%s, %s)';

            $prepared_query = $wpdb->prepare( $sql, $faq_id, $category );
            $wpdb->query( $prepared_query );
        }
    }

    echo $message;
    die();
}

/**
 * Delete a FAQ
 */
add_action( 'wp_ajax_delete_faq', 'delete_faq' );
function delete_faq() {
    $faq_id     = isset( $_POST['id'] ) ? $_POST['id'] : null;

    global $wpdb;
    $table_name = $wpdb->prefix . WP_RESPONSIVE_FAQ_TABLE_NAME;
    $wpdb->query( 'DELETE FROM ' . $table_name . ' WHERE id = ' . $faq_id );

    die();
}

add_action( 'admin_head', 'faq_sort' );
function faq_sort()
{
    ?>
    <script>
        jQuery( document).ready( function( $ ) {
            var faqs = [];
            $( '.faq_id' ).each( function() {
                    faqs.push( $( this).val() );
            } );
            $( '#sortMe' ).sortable( {
                update: function( event, ui ) {
                    var postData = $( this ).sortable( 'serialize' );
                    $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {faq_order: faqs, list: postData, action: 'faq_sort'},
                        success: function( data ){
                            console.log( data );
                        }
                    });
                }
            } );
        } );
    </script>
    <?php
}
add_action( 'wp_ajax_faq_sort', function() {
    $list           = $_POST['list'];
    $output         = [];
    $list           = parse_str( $list, $output );
    $list           = $output['item'];
    $faq_order      = $_POST['faq_order'];

    global $wpdb;
    $table_name     = $wpdb->prefix . WP_RESPONSIVE_FAQ_TABLE_NAME;

    foreach( $list as $key => $value )
    {
        $faq_id     = $value;
        $new_order  = ( $key + 1 );
        $sql_rearrange = '
            UPDATE '. $table_name .'
            SET order_id = '. $new_order .'
            WHERE id = '. $faq_id .'
        ';
        $wpdb->query( $sql_rearrange );
    }
    die();
} );