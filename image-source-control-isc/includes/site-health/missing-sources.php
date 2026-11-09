<?php

namespace ISC\Site_Health;

/**
 * Site Health checks for images without sources.
 */
class Missing_Sources extends Site_Health {

	/**
	 * Get the current count of images missing sources.
	 *
	 * @return int
	 */
public static function get_missing_sources_count(): int {
		$missing_sources = get_transient( 'isc-show-missing-sources-warning' );

		if ( false === $missing_sources ) {
			$missing_sources = \ISC_Model::update_missing_sources_transient();
		}

		return absint( $missing_sources );
	}

	/**
	 * Add Site Health tests.
	 *
	 * @param array $tests Existing Site Health tests.
	 * @return array
	 */
	public function add_site_health_tests( array $tests ): array {
		if ( self::get_missing_sources_count() <= 0 ) {
			return $tests;
		}

		$tests['direct']['isc_missing_sources'] = [
			'label' => ISCNAME . ': ' . __( 'Image Sources', 'image-source-control-isc' ),
			'test'  => [ $this, 'get_site_health_missing_sources_test_result' ],
		];

		return $tests;
	}

	/**
	 * Get Site Health result for missing image sources.
	 *
	 * @return array<string,mixed>
	 */
	public function get_site_health_missing_sources_test_result(): array {
		$missing_sources = self::get_missing_sources_count();
		$description     = sprintf(
			// translators: %s is the number of images without credits.
			_n( '%s image has no credits.', '%s images have no credits.', absint( $missing_sources ), 'image-source-control-isc' ),
			absint( $missing_sources )
		);

		return [
			'label'       => __( 'Images without sources', 'image-source-control-isc' ),
			'status'      => 'recommended',
			'badge'       => [
				'label' => __( 'Image Sources', 'image-source-control-isc' ),
				'color' => 'blue',
			],
			'description' => '<p>' . esc_html( $description ) . '</p>',
			'test'        => 'isc_missing_sources',
		];
	}
}
