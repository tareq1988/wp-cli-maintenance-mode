<?php

if ( ! class_exists( 'WP_CLI' ) ) {
	return;
}

/**
 * Plugin History
 */
class WP_CLI_Maintenance_Mode {

    function __construct() {
        WP_Filesystem();
    }

    /**
     * Put WordPress into maintenance mode
     *
     * ## EXAMPLES
     *
     * wp down
     */
    public function enable() {
        global $wp_filesystem;

        $content = '<?php $upgrading = ' . time() . '; ?>';

        $file = ABSPATH . '.maintenance';
        $wp_filesystem->delete( $file );
        $wp_filesystem->put_contents( $file, $content, FS_CHMOD_FILE );

        WP_CLI::success( 'Maintenance mode enabled' );
    }

    /**
     * Put WordPress out of maintenance mode
     *
     * ## EXAMPLES
     *
     * wp up
     */
    public function disable() {
        global $wp_filesystem;

        $file = ABSPATH . '.maintenance';
        $wp_filesystem->delete( $file );

        WP_CLI::success( 'Maintenance mode disabled' );
    }
}

WP_CLI::add_command( 'up', array( 'WP_CLI_Maintenance_Mode', 'disable' ) );
WP_CLI::add_command( 'down', array( 'WP_CLI_Maintenance_Mode', 'enable' ) );
