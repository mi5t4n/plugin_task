<?php
/**
 * Admin Menu.
 *
 * @package Plugin\Task
 *
 * @since 0.1.0
 */

namespace Plugin\Task;

defined( 'ABSPATH' ) || exit;

/**
 * Aajx class.
 *
 * @class Plugin\Task\AdminMenu
 */

class AdminMenu {
	/**
	 * Constructor.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Initialize.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	private function init() {
		$this->init_hooks();
	}

	/**
	 * Initialize admin menus.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public function init_menus() {
		add_options_page(
			esc_html__( 'Plugin Task', 'plugin-task' ),
			esc_html__( 'Plugin Task', 'plugin-task' ),
			'manage_options',
			'plugin_task',
			array( $this, 'display_main_page' )
		);
	}

	/**
	 * Initialize hooks.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	private function init_hooks() {
		add_action( 'admin_menu', array( $this, 'init_menus' ) );
		add_action( 'plugin_action_links', array( $this, 'plugin_action_links' ), 10, 4 );
	}

	/**
	 * Display main page.
	 *
	 * @return void
	 */
	public function display_main_page() {
		require_once PluginTask()->plugin_path() . '/templates/admin.php';
	}

	/**
	 * Add links under plugin name along with activate and deactivate.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string[] $actions      An array of plugin action links. By default this can include 'activate', 'deactivate', and 'delete'. With Multisite active this can also include 'network_active' and 'network_only' items.
	 * @param string   $plugin_file  Path to the plugin file relative to the plugins directory.
	 * @param Array    $plugin_data  An array of plugin data. See get_plugin_data().
	 * @param string   $context      The plugin context. By default this can include 'all', 'active', 'inactive', 'recently_activated', 'upgrade', 'mustuse', 'dropins', and 'search'.
	 *
	 * @return string[]              Plugin action links.
	 */
	public function plugin_action_links( $actions, $plugin_file, $plugin_data, $context ) {

		// Get plugin file.
		$plugin = plugin_basename( PLUGIN_TASK_FILE );

		// Bail early if the plugin is not Affiliate Engine.
		if ( $plugin !== $plugin_file ) {
			return $actions;
		}

		// Show settings link if the plugin is active.
		if ( is_plugin_active( $plugin ) ) {
			$settings_page_url   = get_admin_url( null, 'options-general.php?page=plugin_task' );
			$actions['settings'] = "<a href=\"{$settings_page_url}\">Settings</a>";
		}

		return $actions;
	}
}
