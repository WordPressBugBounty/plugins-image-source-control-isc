<?php
if ( ! defined( 'ABSPATH' ) && ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

// check if the option to remove data on uninstall is enabled
$options = get_option( 'isc_options' );
if ( ! empty( $options['remove_on_uninstall'] ) ) {
	global $wpdb;

	// delete post meta fields
	delete_post_meta_by_key( 'isc_post_images' );
	delete_post_meta_by_key( 'isc_image_posts' );
	delete_post_meta_by_key( 'isc_image_source' );
	delete_post_meta_by_key( 'isc_image_source_own' );
	delete_post_meta_by_key( 'isc_image_source_url' );
	delete_post_meta_by_key( 'isc_possible_usages' );
	delete_post_meta_by_key( 'isc_possible_usages_last_check' );
	delete_post_meta_by_key( 'isc_post_images_before_update' );

	// delete main plugin options
	delete_option( 'isc_options' );
	// delete storage
	delete_option( 'isc_storage' );
	// delete the total number of unused images (Pro)
	delete_option( 'isc_unused_images_total_items' );

	// delete user meta
	delete_metadata( 'user', null, 'isc_newsletter_subscribed', '', true );

	// drop the index table
	$table_name = $wpdb->prefix . 'isc_index';
	// phpcs:ignore
	$wpdb->query( "DROP TABLE IF EXISTS $table_name" );
}
