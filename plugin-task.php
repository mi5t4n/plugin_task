<?php
/**
 * Plugin Name:     Plugin Task
 * Plugin URI:      https://example.com
 * Description:     Plugin Task
 * Author:          Sagar Tamanng
 * Author URI:      https://sagartamang.com.np
 * Text Domain:     plugin-task
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         PluginTask
 */

defined( 'ABSPATH' ) || exit;

use Plugin\Task\PluginTask;

define( 'PLUGIN_TASK_SLUG', 'plugin_task' );
define( 'PLUGIN_TASK_VERSION', '0.1.0' );
define( 'PLUGIN_TASK_FILE', __FILE__ );
define( 'PLUGIN_TASK_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'PLUGIN_TASK_ASSETS', dirname( __FILE__ ) . '/assets' );
define( 'PLUGIN_TASK_TEMPLATES', dirname( __FILE__ ) . '/templates' );
define( 'PLUGIN_TASK_LANGUAGES', dirname( __FILE__ ) . '/i18n/languages' );

require_once dirname( __FILE__ ) . '/vendor/autoload.php';

/**
 * Returns the main instance of PluginTask.
 *
 * @since 0.1.0
 *
 * @return Plugin\Task\PluginTask
 */
function PluginTask() {
	return PluginTask::instance();
}

PluginTask();
