<?php
/**
 * Creates the shordcode to be pasted in a page to display the list of FAQs.
 * @param array $atts
 * @param string $content
 * @return string
 */
function wp_responsive_faq_code( $atts, $content = null ) {

    wp_enqueue_style( 'wp_responsive_faq_admin_css', plugin_dir_url( __FILE__ ) . '../css/wp-responsive-faq.css' );

    wp_enqueue_style( 'wp_responsive_faq_list_css_style', plugin_dir_url( __FILE__ ) . '../css/style.css' );
    wp_enqueue_script( 'wp_responsive_faq_list_js', plugin_dir_url( __FILE__ ) . '../js/modernizr.custom.29473.js', ['jquery']  );
    wp_enqueue_script( 'wp_responsive_faq_gulpfile', plugin_dir_url( __FILE__ ) . '../js/jq_filter/gulpfile.js', ['jquery']  );
    wp_enqueue_script( 'wp_responsive_faq_instafilta', plugin_dir_url( __FILE__ ) . '../js/jq_filter/instafilta.min.js', ['jquery']  );
    wp_enqueue_script( 'wp_responsive_faq_faq', plugin_dir_url( __FILE__ ) . '../js/jq_filter/wp_ajax_faq.js', ['jquery']  );

    global $wpdb;
    $table_name             = $wpdb->prefix . WP_RESPONSIVE_FAQ_TABLE_NAME;
    $category_table_name    = $wpdb->prefix . WP_RESPONSIVE_FAQ_CATEGORIES_TABLE_NAME;
    $faq_cat_table_name     = $wpdb->prefix . WP_RESPONSIVE_FAQ_CAT_TABLE_NAME;

    $faq_order  = '';
    $faq_list   = $wpdb->get_results( 'SELECT order_id FROM ' . $table_name,ARRAY_A );
    $num_rows   = $wpdb->num_rows;
    $count      = 1;
    foreach ($faq_list as $order_id) {
        $faq_order .= $order_id['order_id'];
        if( $count < $num_rows )
        {
            $faq_order .= ',';
        }
        $count++;
    }

    $atts = shortcode_atts([
        'title'         => "FAQ's",
        'categories'    => 'all',
        'category'      => null
    ], $atts);

    extract( $atts );

    $output = '<div class="wp_ajax_faq_container">
			<header>
				<h1>'. $title .'</h1>
                <input type="text" id="instafilta-field-site" placeholder="Type to filter">
			</header>
            <div class="clr"></div>';

    $output .= '<div class="category-block">';

    if ( $category != null ) {
        $sql        = '
            SELECT '. $table_name .'.*, GROUP_CONCAT( '. $faq_cat_table_name .'.category_id) AS categories FROM '. $table_name .'
            LEFT JOIN '. $faq_cat_table_name .'
            ON '. $faq_cat_table_name .'.faq_id = '. $table_name .'.id
        ';

        $category_prepared_query = $wpdb->prepare( 'SELECT id FROM ' . $category_table_name . ' WHERE LOWER(name) = LOWER(%s)', $category );
        $category_result = $wpdb->get_results( $category_prepared_query );

        $sql .= ' WHERE LOWER( '. $faq_cat_table_name .'.category_id ) = LOWER( ' . $category_result[0]->id . ' )';
        $sql .=  ' GROUP BY '. $table_name .'.id ORDER BY '. $table_name .'.order_id ASC ';

    } else if ( $categories == 'all' ) {
        $output .= '<a href="#" class="category" id="0">All</a> ';
        $category_list = $wpdb->get_results( 'SELECT * FROM ' . $category_table_name, ARRAY_A );
        foreach ($category_list as $category) {
            $output .= '<a href="#" id="cat'. $category['id'] .'" class="category"> | '. ucwords( $category['name'] ) .'</a>';
        }

        $sql        = '
            SELECT '. $table_name .'.*, GROUP_CONCAT( '. $faq_cat_table_name .'.category_id) AS categories FROM '. $table_name .'
            LEFT JOIN '. $faq_cat_table_name .'
            ON '. $faq_cat_table_name .'.faq_id = '. $table_name .'.id
            GROUP BY '. $table_name .'.id
            ORDER BY order_id ASC
        ';
    } else {
        $output .= '<a href="#" class="category" id="0">All</a> ';

        $sql        = '
            SELECT '. $table_name .'.*, GROUP_CONCAT( '. $faq_cat_table_name .'.category_id) AS categories FROM '. $table_name .'
            LEFT JOIN '. $faq_cat_table_name .'
            ON '. $faq_cat_table_name .'.faq_id = '. $table_name .'.id
        ';

        $category_array = explode(',', $categories);
        $first = true;
        foreach ($category_array as $category) {
            $category_prepared_query = $wpdb->prepare( 'SELECT id FROM ' . $category_table_name . ' WHERE LOWER(name) = LOWER(%s)', $category );
            $category_result = $wpdb->get_results( $category_prepared_query );

            $output .= '<a href="#" id="cat'. $category_result[0]->id .'" class="category"> | '. ucwords( $category ) .'</a> ';
            if ( $first ) {
                $sql .= ' WHERE LOWER('. $faq_cat_table_name .'.category_id) = LOWER(' . $category_result[0]->id .')';
                $first = false;
            } else {
                $sql .= ' OR '. $faq_cat_table_name .'.category_id = ' . $category_result[0]->id;
            }
        }

        $sql .=  '    GROUP BY '. $table_name .'.id ORDER BY '. $table_name .'.order_id ASC';

    }

    $output .= '<div class="clr"></div></div>';
    $output .= '<section class="ac-container">';

    $results    = $wpdb->get_results( $sql, ARRAY_A );

    if( $results ): foreach( $results as $result ) :

        $faq_cats = explode(',', $result['categories']);
        $category_class = '';
        foreach ($faq_cats as $category) {
            if ( !$category ) {
                $category = 1;
            }
            $category_class .= 'cat' . $category . ' ';
        }

        $output .= '
        <div class="'. $category_class .'">
            <input id="ac-'. $result['id'] .'" name="accordion-'. $result['id'] .'" type="checkbox" />
            <label for="ac-'. $result['id'] .'" class="faq_question"><span style="font-weight: 800;">Q. </span>'. stripslashes( $result['question'] ) .'</label>
            <article class="ac-small"><p class="answer_box">'. stripslashes( $result['answer'] ) .'</p></article>
        </div>';

    endforeach; endif;

    $output .=	'</section>
    </div>';

    return $output;
}
add_shortcode('wp_responsive_faq', 'wp_responsive_faq_code');