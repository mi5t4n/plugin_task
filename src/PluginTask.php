<?php
/**
 * Main plugin task file.
 *
 * @since 0.1.0.
 */

namespace Plugin\Task;

defined( 'ABSPATH' ) || exit;

use Plugin\Task\Ajax;
use Plugin\Task\ScriptStyle;
use Plugin\Task\Traits\Singleton;

/**
 * Main PluginTask class.
 *
 * @class Plugin\Task\PluginTask
 */

class PluginTask {

	use Singleton;

	/**
	 * Script Style.
	 *
	 * @since 0.1.0
	 *
	 * @var Plugin\Task\ScriptStyle
	 */
	public $script_style;

	/**
	 * Ajax.
	 *
	 * @since 0.1.0
	 *
	 * @var Plugin\Task\Ajax
	 */
	public $ajax;

	/**
	 * Constructor.
	 *
	 * @since 0.1.0
	 */
	private function __construct() {
		$this->init_hooks();
	}

	/**
	 * Initialize hooks.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	private function init_hooks() {
		add_action( 'init', array( $this, 'init' ), 0 );
	}

	/**
	 * Initialize Task when WordPress initializes.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public function init() {
		// Before init action.
		do_action( 'before_plugintask_init' );

		// Set up localization.
		$this->load_plugin_textdomain();

		// Update the plugin version.
		$this->update_plugin_version();

		// Load class instances.
		$this->ajax         = new Ajax();
		$this->script_style = new ScriptStyle();
		$this->admin_menu   = new AdminMenu();

		// After init action.
		do_action( 'after_plugintask_init' );
	}

	/**
	 * Load localization files.
	 *
	 * Note: the first-loaded translation file overrides any following ones
	 * if the same translation is present.
	 *
	 * Locales found in:
	 *      - WP_LANG_DIR/Task/Task-LOCALE.mo
	 *      - WP_LANG_DIR/plugins/Task-LOCALE.mo
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public function load_plugin_textdomain() {
		if ( function_exists( 'determine_locale' ) ) {
			$locale = determine_locale();
		} else {
			// TODO Remove when start supporting WP 5.0 or later.
			$locale = is_admin() ? get_user_locale() : get_locale();
		}

		$locale = apply_filters( 'plugin_locale', $locale, 'Task' );

		unload_textdomain( 'Task' );
		load_textdomain(
			'Task',
			WP_LANG_DIR . '/Task/Task-' . $locale . '.mo'
		);
		load_plugin_textdomain(
			'Task',
			false,
			PLUGIN_TASK_LANGUAGES
		);
	}

	/**
	 * Get the plugin url.
	 *
	 * @since 0.1.0
	 *
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', PLUGIN_TASK_FILE ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @since 0.1.0
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( PLUGIN_TASK_FILE ) );
	}

	/**
	 * Update the plugin version.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	private function update_plugin_version() {
		if ( false === get_option( 'plugin_task_version' ) ) {
			update_option( 'plugin_task_version', PLUGIN_TASK_VERSION );
		}
	}
}
