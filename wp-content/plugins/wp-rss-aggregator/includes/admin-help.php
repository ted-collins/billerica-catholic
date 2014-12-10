<?php
    /**
     * Build the Help page
     * 
     * @since 4.2
     */ 
    function wprss_help_page_display() {
        ?>

		<div class="wrap">
			<?php screen_icon( 'wprss-aggregator' ); ?>

			<h2><?php _e( 'Help & Support', WPRSS_TEXT_DOMAIN ); ?></h2>
			<h3><?php _e( 'Documentation', WPRSS_TEXT_DOMAIN ) ?></h3>
			<?php echo wpautop( __('In the <a href="http://www.wprssaggregator.com/documentation/">documentation area</a> on the WP RSS Aggregator website you will find comprehensive details on how to use the core plugin and all the add-ons.
				
				There are also some videos to help you make a quick start to setting up and enjoying this plugin.', WPRSS_TEXT_DOMAIN) ) ?>
			<h3><?php _e( 'Frequently Asked Questions (FAQ)', WPRSS_TEXT_DOMAIN ) ?></h3>
			<?php echo wpautop( __('If after going through the documentation you still have questions, please take a look at the <a href="http://www.wprssaggregator.com/faq/">FAQ page</a> on the site, we set this up purposely to answer the most commonly asked questions by our users.', WPRSS_TEXT_DOMAIN) ) ?>
			
			<h3><?php _e( 'Support Forums - Core (free version) Plugin Users Only', WPRSS_TEXT_DOMAIN ) ?></h3>
			<?php echo wpautop( __( "If you're using the free version of the plugin found on WordPress.org, you can ask questions on the " . '<a href="http://wordpress.org/support/plugin/wp-rss-aggregator">support forum</a>.', WPRSS_TEXT_DOMAIN ) ) ?>
			<h3><?php _e( 'Email Ticketing System - Premium Add-on Users Only', WPRSS_TEXT_DOMAIN ) ?></h3>
			<?php echo wpautop( __( "If you still can't find an answer to your query after reading the documentation and going through the FAQ, just " . '<a href="http://www.wprssaggregator.com/contact/">open a support request ticket</a>.' . "
					We'll be happy to help you out.", WPRSS_TEXT_DOMAIN ) ) ?>
		</div>
    <?php
    }
    
/**
 * Encapsulates features for providing inline help in the admin interface.
 * 
 * The following filters are introduced:
 * 
 * - `wprss_help_default_options` - The default options to be extended.
 * 
 *	1.	The array of options
 * 
 * - `wprss_help_template_path` - The path of template retrieved by WPRSS_Help::get_template().
 * 
 *	1. The path to the template.
 *  2. The array of variables passed.
 * 
 * - `wprss_help_template_vars` - The variables for the template, received by WPRSS_Help::get_template().
 *
 *	1. The variables array.
 *	2. The path to the template, filtered by `wprss_help_template_path`.
 * 
 * - `wprss_help_tooltip_options` - Options that are in effect when adding tooltips with WPRSS_Help::add_tooltip().
 * - `wprss_help_tooltip_handle_html_options` - Options that are in effect when retrieving tooltip handle HTML with WPRSS_Help::wprss_help_tooltip_handle_html_options.
 * 
 * 
 * Also, the following options are available:
 * 
 * - `tooltip_id_prefix` - The HTML element ID prefix that will be used for tooltips.
 * - `tooltip_handle_text` - The text that will appear inside the handle HTML elements.
 * - `tooltip_handle_class` - The CSS class that will be assigned to tooltip handles.
 * - `tooltip_content_class` - The CSS class that will be assigned to tooltip content HTML elements.
 * - `enqueue_tooltip_content` - Whether or not content is to be enqueued, instead of being output directly.
 * 
 *	1. The absolute path to the core plugin directory
 */
class WPRSS_Help {

	static $_instance;
	
	protected $_options;
	protected $_enqueued_tooltip_content = array();
	protected $_tooltips = array();

	const OPTION_NAME = 'wprss_settings_help';
	const CODE_PREFIX = 'wprss_help_';
	const OVERRIDE_DEFAULT_PREFIX = '!';
	const TEXT_DOMAIN = WPRSS_TEXT_DOMAIN;
	const HASHING_CONCATENATOR = '|';
	const OPTIONS_FILTER_SUFFIX = '_options';
	
	const TOOLTIP_DATA_KEY_ID = 'id';
	const TOOLTIP_DATA_KEY_TEXT = 'text';
	const TOOLTIP_DATA_KEY_OPTIONS = 'options';

	/**
	 * Retrieve the singleton instance
	 * 
	 * @return WPRSS_Help
	 */
	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			$class_name = __CLASS__; // Late static bindings not allowed
			self::$_instance = new $class_name();
		}

		return self::$_instance;
	}
	

	public static function init() {
		// Actions
		add_action( 'admin_enqueue_scripts', array( self::get_instance(), '_admin_enqueue_scripts' ) );
		add_action( 'admin_footer', array( self::get_instance(), '_admin_footer' ) );
	}
	

	/**
	 * Filters used:
	 * 
	 * - `wprss_help_default_options`
	 * 
	 * @param array $options Options that will overwrite defaults.
	 */
	public function __construct( $options = array() ) {
		$defaults = apply_filters( 'wprss_help_default_options', array(
			'tooltip_id_prefix'				=> 'wprss-tooltip-',
			'tooltip_handle_text'			=> '',
			'tooltip_handle_class'			=> 'wprss-tooltip-handle', // Used in logic to identify handle elements
			'tooltip_handle_class_extra'	=> 'fa fa-question-circle', // Not used in logic
			'tooltip_content_class'			=> 'wprss-tooltip-content',
			'tooltip_class'					=> 'wprss-ui-tooltip', // Overrides default jQuery UI class
			'is_enqueue_tooltip_content'	=> '0',
			'tooltip_handle_template'		=> '%1$s/help-tooltip-handle.php',
			'tooltip_content_template'		=> '%1$s/help-tooltip-content.php',
			'admin_footer_js_template'		=> '%1$s/help-footer-js.php',
			'tooltip_not_found_handle_html'	=> '',
			'text_domain'					=> self::TEXT_DOMAIN
		));
		$db_options = $this->get_options_db();
		$this->_set_options( $this->array_merge_recursive_distinct( $db_options, $defaults ) );

		$this->_construct();
	}
	

	/**
	 * Used for parameter-less extension of constructor logic
	 */
	protected function _construct() {
		
	}
	

	/**
	 * Return an option value, or the whole array of internal options.
	 * These options are a product of the defaults, the database, and anything
	 * set later on, applied on top of eachother and overwriting in that order.
	 * 
	 * @param null|string $key The key of the option to return.
	 * @param null|mixed $default What to return if options with the specified key not found.
	 * @return array|mixed|null The option value, or an array of options.
	 */
	public function get_options( $key = null, $default = null ) {
		$options = $this->_options;

		if ( is_null( $key ) ) {
			return $options;
		}
		
		if( is_array( $key ) ) {
			return $this->array_merge_recursive_distinct( $options, $key );
		}

		return isset( $options[ $key ] ) ? $options[ $key ] : $default;
	}
	

	/**
	 * Set the value of an internal option or options.
	 * Existing options will be overwritten. New options will be added.
	 * Database options will not be modified.
	 * 
	 * @param string|array $key The key of the option to set, or an array of options.
	 * @param null|mixed $value The value of the option to set.
	 * @return WPRSS_Help This instance.
	 */
	public function set_options( $key, $value = null ) {
		if ( is_array( $key ) ) {
			foreach ( $key as $_key => $_value ) {
				$this->_set_options( $_key, $_value );
			}

			return $this;
		}

		$this->_set_options( $key, $value );
	}
	

	/**
	 * Set an option value, or all options.
	 * In latter case completely overrides the whole options array.
	 * 
	 * @param string|array $key The key of the option to set, or the whole options array.
	 * @param null|mixed $value Value of the option to set.
	 * @return WPRSS_Help This instance.
	 */
	protected function _set_options( $key, $value = null ) {
		if ( is_array( $key ) ) {
			$this->_options = $key;
			return $this;
		}

		$this->_options[ $key ] = $value;
		return $this;
	}
	

	/**
	 * Returns a WPRSS_Help option or options from the database.
	 * 
	 * @param string $key The key of the option to return.
	 * @param null|mixed $default What to return if option identified by $key is not found.
	 * @return null|array|mixed The options or option value.
	 */
	public function get_options_db( $key = null, $default = null ) {
		$options = (array) get_option( self::OPTION_NAME, array() );

		if ( is_null( $key ) ) {
			return $options;
		}

		return isset( $options[ $key ] ) ? $options[ $key ] : $default;
	}
	

	/**
	 * Get content of a template.
	 * 
	 * Filters used
	 * 
	 * - `wprss_help_template_path`
	 * - `wprss_help_template_vars`
	 * 
	 * @param string $path Full path to the template
	 * @param array $vars This will be passed to the template
	 */
	public function get_template( $path, $vars = array() ) {
		$vars = (array) $vars;

		// Entry points
		$path = apply_filters( 'wprss_help_template_path', $path, $vars );
		$vars = apply_filters( 'wprss_help_template_vars', $vars, $path );

		ob_start();
		include($path);
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
	

	/**
	 * This is called during the `admin_enqueue_scripts` action, and will
	 * enqueue scripts needed for the backend.
	 * 
	 * Filters used:
	 * 
	 * - `wprss_help_admin_scripts`
	 * 
	 * @return WPRSS_Help This instance.
	 */
	public function _admin_enqueue_scripts() {
		$scripts = $this->apply_filters( 'admin_scripts', array(
			'jquery-ui-tooltip'				=> array()
		));
		
		foreach ( $scripts as $_handle => $_args ) {
			// Allows numeric array with handles as values
			if ( is_numeric( $_handle ) ) {
				$_handle = $_args;
			}
			
			// Allows specifying null as value to simply enqueue handle
			if ( empty( $_args ) ){
				$_args = array();
			}
			
			array_unshift( $_args, $_handle );
			call_user_func_array( 'wp_enqueue_script', $_args );
		}
		
		return $this;
	}
	
	
	public function _admin_footer() {
		$html = '';
		$html .= $this->get_enqueued_tooltip_content_html() . "\n";
		$html .= $this->get_admin_footer_js_html();
		$html = $this->apply_filters( 'admin_footer', $html );
		
		echo $html;
	}
	
	
	public function is_overrides_default_prefix( $string ) {
		return strpos( $string, self::OVERRIDE_DEFAULT_PREFIX ) === 0;
	}
	
	
	/**
	 * @return string This class's text domain
	 */
	public function get_text_domain() {
		return self::TEXT_DOMAIN;
	}
	
	/**
	 * Format this string, replacing placeholders with values, and translate it
	 * in the class's text domain.
	 * 
	 * @see sprintf()
	 * @param string $string The string to translate.
	 * @param mixed $argN,.. Additional arguments.
	 */
	public function __( $string, $argN = null ) {
		$args = func_get_args();
		$args[0] = $string = __( $string, $this->get_text_domain() );
		
		$string = call_user_func_array( 'sprintf', $args );
		
		return $string;
	}
	
	/**
	 * Hashes all the given values into a single hash.
	 * Accepts an infinite number of parameters, all of which will be first
	 * glued together by a separator, then hashed.
	 * Non-scalar values will be serialized.
	 * 
	 * @param mixed $value The value to hash.
	 * @param mixed $argN Other values to hash.
	 * @return string The hash.
	 */
	public function get_hash( $value ) {
		$args = func_get_args();
		$glue = self::HASHING_CONCATENATOR;
		
		$blob = '';
		foreach ( $args as $_idx => $_arg ) {
			$blob .= is_scalar( $_arg ) ? $_arg : serialize( $_arg );
			$blob .= $glue;
		}
		
		$blob = substr( $blob, 0, -1 );
		
		return sha1( $blob );
	}
	
	/**
	 * Get the class code prefix, or the specified prefixed with it.
	 * 
	 * @param string $string A string to prefix.
	 * @return string The code prefix or the prefixed string.
	 */
	public function get_code_prefix( $string = '' ) {
		return self::CODE_PREFIX . (string)$string;
	}
	
	/**
	 * Optionally prefix a string with the class code prefix, unless it
	 * contains the "!" character in the very beginning, in which case it will
	 * simply be removed.
	 * 
	 * @param string $string The string to consider for prefixing.
	 * @return string The prefixed or clean string.
	 */
	public function prefix( $string ) {
		return $this->is_overrides_default_prefix( $string )
				? substr( $string, 1 )
				: $this->get_code_prefix( $string );
	}
	
	/**
	 * Applies filters, but prefixes the filter name with 'wprss_help_',
	 * unless '!' is specified as the first character of the filter.
	 * 
	 * @param string $filter_name Name or "tag" of the filter.
	 * @param mixed $subject The value to apply filters to.
	 * @param mixed $argN,.. Additional filter arguments
	 * @return mixed Result of filtering
	 */
	public function apply_filters( $filter_name, $subject, $argN = null ) {
		$args = func_get_args();
		
		$args[0] = $filter_name = $this->prefix( $filter_name );
		
		return call_user_func_array( 'apply_filters', $args );
	}
	
	
	/**
	 * Applies a filters with the specified name to the options that were
	 * applied on top of defaults.
	 * The name will be prefixed with the class prefix 'wprss_help_', and
	 * suffixed with '_options'.
	 * 
	 * @param string $filter_name Name of the filter to apply to the options
	 * @param array $options The options to filter
	 * @param mixed $filter_argN,.. Other filter arguments to be passed to filter
	 */
	public function apply_options_filters( $filter_name, $options = array(), $filter_argN = null ) {
		$args = func_get_args();
		
		// Adding sufix
		$args[0] = $filter_name .= self::OPTIONS_FILTER_SUFFIX;
		
		// Applying defaults
		$args[1] = $options = $this->get_options( $options );
		
		// Entry point. Order of args is already correct.
		$options = call_user_func_array( array( $this, 'apply_filters' ), $args );
		
		return $options;
	}
	
	
	/**
	 * Parses the tooltip handle template path for placeholders.
	 * 
	 * Filters used:
	 * 
	 * - `wprss_help_admin_footer_js_html_template`
	 * 
	 * @param null|string $path Optional path to parse and retrieve. Default: value of the 'admin_footer_js_template' option.
	 * @return string Path to the template.
	 */
	public function get_admin_footer_js_html_template( $path = null ) {
		// Default is from options
		if ( is_null( $path ) ) {
			$path = $this->get_options( 'admin_footer_js_template' );
		}
		
		// Entry point
		$path = $this->apply_filters( 'admin_footer_js_html_template', $path );
		
		return $this->parse_path( $path );
	}
	
	
	/**
	 * Get the HTML of the JavaScript for the footer in Admin Panel.
	 * 
	 * Filters used:
	 * 
	 * - `wprss_help_admin_footer_js_html`
	 * 
	 * @param array $options Any additional options to be used with defaults.
	 * @return string The HTML.
	 */
	public function get_admin_footer_js_html( $options = array() ) {
		$options = $this->apply_options_filters( 'admin_footer_js_html', $options);
		
		$templatePath = $this->get_admin_footer_js_html_template( $options['admin_footer_js_template'] );
		
		return $this->get_template($templatePath, $options);
	}
	
	
	/**
	 * Parses the tooltip handle template path for placeholders.
	 * 
	 * Filters used:
	 * 
	 * - `wprss_help_tooltip_handle_html_template`
	 * 
	 * @param null|string $path Optional path to parse and retrieve. Default: value of the 'tooltip_handle_template' option.
	 * @return string Path to the template.
	 */
	public function get_tooltip_handle_html_template( $path = null ) {
		// Default is from options
		if ( is_null( $path ) ) {
			$path = $this->get_options( 'tooltip_handle_template' );
		}
		
		// Entry point
		$path = $this->apply_filters( 'tooltip_handle_html_template', $path );
		
		return $this->parse_path( $path );
	}
	
	
	/**
	 * Get the HTML of the tooltip handle.
	 * 
	 * Filters used:
	 * 
	 * - `wprss_help_tooltip_handle_html_options`
	 * 
	 * @param string $text Content of the tooltip text.
	 * @param string $id ID of the tooltip.
	 * @param array $options Any additional options to be used with defaults.
	 * @return string The HTML.
	 */
	public function get_tooltip_handle_html( $text, $id, $options = array() ) {
		$options = $this->apply_options_filters( 'tooltip_handle_html', $options, $text, $id);

		// Add template varialbes
		$options['tooltip_id'] = $id;
		$options['tooltip_text'] = $text;
		
		$templatePath = $this->get_tooltip_handle_html_template( $options['tooltip_handle_template'] );
		
		return $this->get_template($templatePath, $options);
	}
	
	
	/**
	 * Parses the tooltip content template path for placeholders.
	 * 
	 * Filters used:
	 * 
	 * - `wprss_help_tooltip_content_html_template`
	 * 
	 * @param null|string $path Optional path to parse and retrieve. Default: value of the 'tooltip_handle_template' option.
	 * @return string Path to the template.
	 */
	public function get_tooltip_content_html_template( $path = null ) {
		// Default is from options
		if ( is_null( $path ) ) {
			$path = $this->get_options( 'tooltip_content_template' );
		}
		
		// Entry point
		$path = $this->apply_filters( 'tooltip_content_html_template', $path );
		
		return $this->parse_path( $path  );
	}
	
	
	/**
	 * Get the HTML of the tooltip content.
	 * 
	 * Filters used:
	 * 
	 * - `wprss_help_tooltip_content_html_options`
	 * 
	 * @param string $text Content of the tooltip text.
	 * @param string $id ID of the tooltip.
	 * @param array $options Any additional options to be used with defaults.
	 * @return string The HTML.
	 */
	public function get_tooltip_content_html( $text, $id, $options = array() ) {
		$options = $this->apply_options_filters( 'tooltip_content_html', $options, $text, $id );
		
		// Add template varialbes
		$options['tooltip_id'] = $id;
		$options['tooltip_text'] = $text;
		
		$templatePath = $this->get_tooltip_content_html_template( $options['tooltip_content_template'] );
		
		return $this->get_template( $templatePath, $options );
	}
	
	
	/**
	 * Add tooltip and get tooltip HTML.
	 * If $text is null, just get the HTML of tooltip with specified ID.
	 * The `is_enqueue_tooltip_content` option determines whether to enqueue
	 * the content, instead of outputting it after the handle.
	 * 
	 * @param string $id ID for this tooltip
	 * @param string|null $text Text of this tooltip. If null, tooltip will not be added, but only retrieved.
	 * @param array|bool $options The options for this operation, or a boolean indicating whether or not content is to be enqueued
	 * @return string The tooltip handle and, optionally, content.
	 */
	public function tooltip( $id, $text = null, $options = array() ) {
		$this->add_tooltip( $id, $text, $options );
		return $this->do_tooltip( $id );
	}
	
	
	/**
	 * Add tooltips in a batch, with optionally prefixed ID.
	 * 
	 * @param array $tooltips An array where key is tooltip ID and value is tooltip text.
	 * @param string $prefix A prefix to add to all tooltip IDs.
	 * @param array $options Arra of options for all the tooltips to add.
	 * @return \WPRSS_Help
	 */
	public function add_tooltips( $tooltips, $prefix = null, $options = array() ) {
		$prefix = (string) $prefix;
		if ( !is_array($options) ) $options = array();
		
		foreach ( $tooltips as $_id => $_text ) {
			$this->add_tooltip( $prefix . $_id, $_text, $options );
		}
		
		return $this;
	}
	
	
	/**
	 * Add a tooltip for later display.
	 * Text and options will be replaced by existing text and options, if they
	 * are empty, and a tooltip with the same ID is already registered.
	 * 
	 * @param string $id The ID of this tooltip
	 * @param string $text Text for this tooltip
	 * @param array $options Options for this tooltip.
	 * @return WPRSS_Help This instance.
	 */
	public function add_tooltip( $id, $text = null, $options = array() ) {
		if ( $tooltip = $this->get_tooltip( $id ) ) {
			if ( is_null( $text ) ) $text = isset( $tooltip[ self::TOOLTIP_DATA_KEY_TEXT ] ) ? $tooltip[ self::TOOLTIP_DATA_KEY_TEXT ] : $text;
			if ( empty( $options ) ) $options = isset( $tooltip[ self::TOOLTIP_DATA_KEY_OPTIONS ] ) ? $tooltip[ self::TOOLTIP_DATA_KEY_OPTIONS ] : $options;
		}
		
		$this->set_tooltip( $id, $text, $options );
		
		return $this;
	}
	
	
	/**
	 * Set a tooltip, existing or not.
	 * 
	 * @param string $id The ID of this tooltip
	 * @param string $text Text for this tooltip
	 * @param array $options Options for this tooltip.
	 * @return WPRSS_Help This instance.
	 */
	public function set_tooltip( $id, $text = null, $options = array() ) {
		$this->_tooltips[ $id ] = array(
			self::TOOLTIP_DATA_KEY_ID			=> $id,
			self::TOOLTIP_DATA_KEY_TEXT			=> $text,
			self::TOOLTIP_DATA_KEY_OPTIONS		=> $options
		);
		
		return $this;
	}
	
	
	/**
	 * Retrieve one tooltip, or an array containing all tooltips.
	 * 
	 * @param string|null $id The ID of the tooltip to retrieve.
	 * @param mixed|null $default What to return if tooltip with specified ID not found.
	 * @return array An array that contains the following indexes: 'id', 'text', 'options'. See {@link add_tooltip()} for details.
	 */
	public function get_tooltip( $id = null, $default = null ) {
		if ( is_null( $id ) ) {
			return $this->_tooltips;
		}
		
		return $this->has_tooltip( $id ) ? $this->_tooltips[ $id ] : $default;
	}
	
	
	/**
	 * Check whether a tooltip with the specified ID exists.
	 * 
	 * @param string $id ID of the tooltip to check for.
	 * @return boolean True if a tooltip with the specified ID exists; false otherwise.
	 */
	public function has_tooltip( $id ) {
		return isset( $this->_tooltips[ $id ] );
	}
	
	/**
	 * Get registered tooltip HTML.
	 * 
	 * Filters used:
	 * 
	 *  - `wprss_help_tooltip_options` - Filters options used for tooltip
	 * 
	 * @param string $id ID for this tooltip
	 * @param string $text Text of this tooltip
	 * @param array|bool $options The options for this operation, or a boolean indicating whether or not content is to be enqueued
	 * @return string The tooltip handle and, optionally, content.
	 */
	public function do_tooltip( $id ) {
		$options = $this->get_options();
		
		if ( !($tooltip = $this->get_tooltip( $id )) || !isset($tooltip[ self::TOOLTIP_DATA_KEY_TEXT ]) || !$tooltip[ self::TOOLTIP_DATA_KEY_TEXT ] ) {
			return isset( $options['tooltip_not_found_handle_html'] )
					? $options['tooltip_not_found_handle_html']
					: null;
		}
		
		$options = isset( $tooltip[ self::TOOLTIP_DATA_KEY_OPTIONS ] ) ? $tooltip[ self::TOOLTIP_DATA_KEY_OPTIONS ] : null;
		$text = isset( $tooltip[ self::TOOLTIP_DATA_KEY_TEXT ] ) ? $tooltip[ self::TOOLTIP_DATA_KEY_TEXT ] : null;
		
		if ( !is_array( $options ) ) {
			$options = array( 'is_enqueue_tooltip_content' => $options );
		}
		
		// Entry point
		$options = $this->apply_options_filters( 'tooltip', $options, $id, $text );
		
		// Get handle HTML
		$output = $this->get_tooltip_handle_html( $text, $id, $options );
		
		if ( $this->evaluate_boolean( $options['is_enqueue_tooltip_content'] ) ) {
			$this->enqueue_tooltip_content($text, $id, $options);
		}
		else {
			$output .= $this->get_tooltip_content_html( $text, $id, $options );
		}
		
		return $output;
	}
	
	
	/**
	 * Enqueue tooltip content to be displayed in another part of the page.
	 * 
	 * @param string $text The text of the tooltip content to enqueue.
	 * @param string $id ID of the tooltip, the content of which to enqueue.
	 * @param array $options This tooltip's options.
	 * @return \WP_Error|\WPRSS_Help This instance, or error if enqueue method is invalid.
	 */
	public function enqueue_tooltip_content( $text, $id, $options = array() ) {
		$queue_method = $this->apply_filters( 'enqueue_tooltip_content_method', array( $this, '_enqueue_tooltip_content' ), $options, $id, $text );
		
		// "Error handling" WP style
		if ( !is_callable( $queue_method ) ) {
			return new WP_Error( $this->prefix( 'invalid_queue_method' ), $this->__( 'Could not enqueue tooltip content: the queue method is not a valid callable.' ), array(
				'queue_method'			=> $queue_method,
				'text'					=> $text,
				'id'					=> $id,
				'options'				=> $options
			));
		}
		
		call_user_func_array( $queue_method, array( $text, $id, $options ) );
		
		return $this;
	}
	
	
	public function _enqueue_tooltip_content( $text, $id, $options = array() ) {
		$hash = $this->get_hash( $text, $id, $options );
		$this->_enqueued_tooltip_content[ $hash ] = array(
			self::TOOLTIP_DATA_KEY_TEXT			=> $text,
			self::TOOLTIP_DATA_KEY_ID			=> $id,
			self::TOOLTIP_DATA_KEY_OPTIONS		=> $options
		);
		
		return $this;
	}
	
	
	public function get_enqueued_tooltip_content() {
		return $this->_enqueued_tooltip_content;
	}
	
	
	public function get_enqueued_tooltip_content_html() {
		$output = '';
		foreach ( $this->get_enqueued_tooltip_content() as $_hash => $_vars ) {
			$options = is_array( $_vars[ self::TOOLTIP_DATA_KEY_OPTIONS ] ) ? $_vars[ self::TOOLTIP_DATA_KEY_OPTIONS ] : array();
			$output = $this->get_tooltip_content_html( $_vars[ self::TOOLTIP_DATA_KEY_ID ], $_vars[ self::TOOLTIP_DATA_KEY_ID ], $options );
		}
		
		echo $output;
	}
	
	
	/**
	 * Check whether or not the given value is false.
	 * False values are all {@link empty()} values, and also strings 'false' and 'no'.
	 * 
	 * @param mixed $value The value to check.
	 * @return boolean Whether or not the value is considered to be false.
	 */
	public function evaluate_boolean( $value ) {
		return (empty( $value ) || strtolower( $value ) === 'false' || strtolower( $value ) === 'no')
				? false
				: true;
	}
	

	/**
	 * Merge two arrays in an intuitive way.
	 * Input arrays remain unchanged.
	 * 
	 * @see http://php.net/manual/en/function.array-merge-recursive.php#92195
	 * @param array $array1 The array to merge.
	 * @param array $array2 The array to merge into.
	 * @return array The merged array.
	 */
	public function array_merge_recursive_distinct( array &$array1, array &$array2 ) {
		$merged = $array1;

		foreach ( $array2 as $key => &$value ) {
			if ( is_array( $value ) && isset( $merged[ $key ] ) && is_array( $merged[ $key ] ) ) {
				$merged[ $key ] = array_merge_recursive_distinct( $merged[ $key ], $value );
			} else {
				$merged[ $key ] = $value;
			}
		}

		return $merged;
	}
	
	
	/**
	 * Converts an array to a numeric array.
	 * If $map is empty, assumes that the array keys are already in order.
	 * If $map is a number, assumes it's the amount of elements to return.
	 * If $map is an array, assumes it is the map of intended numeric indexes to their value in the input array.
	 * 
	 * @param array $array The array to convert to a numeric array
	 * @param false|null|array $map The map of the array indexes, or number of array elements to slice, or nothing.
	 * @return array The resulting numeric array.
	 */
	public function array_to_numeric( $array, $map = null ) {
		$result = array();
		
		// If map is not an array, assume it's an indicator
		if ( !is_array( $map ) ) {
			$array = array_values( $array );
		}
		
		// If map is empty, assume keys are in order
		if ( empty( $map ) ) {
			return $array;
		}
		
		// If map is a number, assume it's the amount of elements to return
		if ( is_numeric( $map ) ) {
			$map = intval( $map );
			return array_slice( $array, 0, $map );
		}
		
		foreach( $map as $_idx => $_key ) {
			$result[ $_idx ] = $array[ $_key ];
		}
		
		return $result;
	}
	
	
	/**
	 * Parses the template and replaces placeholders with their values.
	 * This function uses {@see sprintf()} to format the template string using
	 * the values provided in $data.
	 * It is also possible for $data to be an associative array of key-value pairs.
	 * To achieve the same result, a map can be provided, mapping data keys to 
	 * their placeholder positions.
	 * If no map is provided, 
	 * 
	 * @param string $string The template string.
	 * @param array $data The key-value pairs of template data.
	 * @param false|null|array $map {@see array_to_numeric()} The template value map.
	 * @return string The parsed and modified template.
	 */
	public function parse_template( $string, $data, $map = null ) {
		$data = $this->array_to_numeric( $data, $map );
		array_unshift( $data, $string );
		return call_user_func_array( 'sprintf', $data );
	}
	
	
	/**
	 * Parses a path template specifically with WPRSS_Help path placeholders.
	 * 
	 * Filters used (in order):
	 * 
	 *  1. `parse_path_data_default`;
	 *  2. `parse_path_data`;
	 *  3. `parse_path_map`;
	 *  4. `parse_path_path`.
	 * 
	 * @see WPRSS_Help::parse_template()
	 * @param string $path The path to parse.
	 * @param null|array $data Any additional data. Will be merged with defaults.
	 * @param null|array $map The map for parsing.
	 * @return string The path with placeholders replaced
	 */
	public function parse_path( $path, $data = null, $map = null ) {
		if( is_null( $data ) ) {
			$data = array();
		}
		
		$defaults = $this->apply_filters( 'parse_path_data_default', array(
			'wprss_templates_dir'			=> wprss_get_templates_dir()
		));
		$data = $this->array_merge_recursive_distinct( $data, $defaults );
		$data = $this->apply_filters( 'parse_path_data', $data, $path, $map );
		$map = $this->apply_filters( 'parse_path_map', $map, $data, $path );
		$path = $this->apply_filters( 'parse_path_path', $path, $data, $map );
		
		return $this->parse_template( $path, $data, $map );
	}
}

WPRSS_Help::init();
