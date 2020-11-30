<?php
    add_action( 'admin_enqueue_scripts', 'pt_load_admin_scripts' );

    /**
     * Load admin scripts.
     *
     * @since 0.1.0
     *
     * @return void
     */
    function pt_load_admin_scripts() {
        global $pagenow;

        if ( 'options-general.php' === $pagenow && isset( $_GET['page'] ) && 'plugin_task' === $_GET['page'] ) {
            wp_enqueue_script(
                'pt-admin',
                plugin_dir_url( PLUGIN_TASK_FILE ) . '/assets/js/admin.js',
                array( 'jquery' ),
                PLUGIN_TASK_VERSION,
                true
            );
        }
    }