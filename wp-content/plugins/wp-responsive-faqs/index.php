<?php
/*
	Plugin Name: WP Responsive FAQ
	Author: Pranab Kalita
    Author URI: http://www.pranabkalita.com
	Description: WP Responsive FAQ, a basic and simple FAQ system allows you to add, manage and display FAQs on your website.
	Version: 1.3
	License: GPL2
*/

global $wp_version;
if( version_compare( $wp_version, "3.8", "<" ) ) {
    die( 'You need to updated your Wordpress to atleast V3.8 to use this plugin.' );
}

/**
 * Constant variavle to store Version Number
 */
if ( !defined( "WP_RESPONSIVE_FAQ_VERSION_NUMBER" ) )
    define( "WP_RESPONSIVE_FAQ_VERSION_NUMBER", "1.3" );

/**
 * Constant Variable to store Table Name
 */
if ( !defined( "WP_RESPONSIVE_FAQ_TABLE_NAME" ) )
    define( "WP_RESPONSIVE_FAQ_TABLE_NAME", "ajax_faq" );

/**
 * Constant Variable to store Categories Table Name
 */
if ( !defined( "WP_RESPONSIVE_FAQ_CATEGORIES_TABLE_NAME" ) )
    define( "WP_RESPONSIVE_FAQ_CATEGORIES_TABLE_NAME", "ajax_faq_categories" );

/**
 * Constant Variable to store Categories Table Name
 */
if ( !defined( "WP_RESPONSIVE_FAQ_CAT_TABLE_NAME" ) )
    define( "WP_RESPONSIVE_FAQ_CAT_TABLE_NAME", "ajax_faq_cat" );

/**
 * Constant Variable to store Faq Count
 */
if ( !defined( "WP_RESPONSIVE_FAQ_COUNT" ) )
    define( "WP_RESPONSIVE_FAQ_COUNT", "5" );

/**
 * Creates the required table and options on activating the plugin
 */
register_activation_hook( __FILE__, 'activate' );
function activate() {
    global $wpdb;
    $table_name                 = $wpdb->prefix . WP_RESPONSIVE_FAQ_TABLE_NAME;
    $categories_table_name      = $wpdb->prefix . WP_RESPONSIVE_FAQ_CATEGORIES_TABLE_NAME;
    $faq_categories_table_name  = $wpdb->prefix . WP_RESPONSIVE_FAQ_CAT_TABLE_NAME;

    require( ABSPATH . 'wp-admin/includes/upgrade.php' );
    if( !$wpdb->get_var( 'SHOW TABLES LIKE ' . $table_name ) == $table_name ) {

        $sql_faq = '
            CREATE TABLE ' . $table_name . ' (
                id INTEGER(11) UNSIGNED AUTO_INCREMENT,
                question TEXT,
                answer TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP,
                order_id INT(11),
                PRIMARY KEY  (id)
            )
        ';
        dbDelta($sql_faq);

        $result = $wpdb->get_results( "SHOW COLUMNS FROM $table_name LIKE 'order'" );
        $exists = ($result->num_rows) ? true : false;
        if( !$exists )
        {
            $sql_add_column = "ALTER TABLE $table_name ADD order_id INT(11)";
            $wpdb->query( $sql_add_column );
            $old_records = $wpdb->get_results( "SELECT * FROM $table_name", ARRAY_A );
            foreach( $old_records as $one_record )
            {
                $sql_order_faq = "
                    UPDATE $table_name
                    SET order_id = ". $one_record['id'] ."
                    WHERE id = ". $one_record['id'] ."
                ";
                $wpdb->query( $sql_order_faq );
            }
        }
    }

    if( !$wpdb->get_var( 'SHOW TABLE LIKE ' . $categories_table_name ) == $categories_table_name ) {

        $sql_category = '
            CREATE TABLE ' . $categories_table_name . ' (
                id INTEGER(11) UNSIGNED AUTO_INCREMENT,
                name VARCHAR(255),
                PRIMARY KEY  (id)
            );
        ';
        //require( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql_category );
        $wpdb->query( "INSERT INTO {$categories_table_name} VALUES (1, 'uncategorized')" );

    }

    if( !$wpdb->get_var( 'SHOW TABLE LIKE ' . $faq_categories_table_name ) == $faq_categories_table_name ) {

        $sql_faq_category = '
            CREATE TABLE '. $faq_categories_table_name .'(
                id INTEGER(11) UNSIGNED AUTO_INCREMENT,
                faq_id INTEGER(11),
                category_id INTEGER(11),
                PRIMARY KEY (id)
            );
        ';
        //require( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql_faq_category );
    }

    add_option( 'wp_ajax_faq_count', WP_RESPONSIVE_FAQ_COUNT );
}

require( 'src/admin_menu.php' );
require( 'src/shortcode.php' );