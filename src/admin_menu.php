<?php
    add_action( 'admin_menu',  'pt_init_menus' );
    add_action( 'plugin_action_links', 'pt_plugin_action_links', 10, 4 );

    /**
	 * Initialize admin menus.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	function pt_init_menus() {
		add_options_page(
			esc_html__( 'Plugin Task', 'plugin-task' ),
			esc_html__( 'Plugin Task', 'plugin-task' ),
			'manage_options',
			'plugin_task',
			'pt_display_main_page'
		);
    }

    /**
	 * Display main page.
	 *
	 * @return void
	 */
	function pt_display_main_page() {
		require_once dirname( PLUGIN_TASK_FILE ). '/templates/admin.php';
    }

    /**
	 * Add links under plugin name along with activate and deactivate.
	 *
	 * @since 1.0.0
	 *
	 * @param string[] $actions      An array of plugin action links. By default this can include 'activate', 'deactivate', and 'delete'. With Multisite active this can also include 'network_active' and 'network_only' items.
	 * @param string   $plugin_file  Path to the plugin file relative to the plugins directory.
	 * @param Array    $plugin_data  An array of plugin data. See get_plugin_data().
	 * @param string   $context      The plugin context. By default this can include 'all', 'active', 'inactive', 'recently_activated', 'upgrade', 'mustuse', 'dropins', and 'search'.
	 *
	 * @return string[]              Plugin action links.
	 */
	function pt_plugin_action_links( $actions, $plugin_file, $plugin_data, $context ) {

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

