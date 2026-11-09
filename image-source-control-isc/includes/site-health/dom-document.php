<?php

namespace ISC\Site_Health;

/**
 * Site Health checks for the PHP DOM extension.
 */
class Dom_Document extends Site_Health {

	/**
	 * Add Site Health tests.
	 *
	 * @param array $tests Existing Site Health tests.
	 * @return array
	 */
	public function add_site_health_tests( array $tests ): array {
		if ( ! self::has_dom_document() ) {
			$tests['direct']['isc_dom_document_extension'] = [
				'label' => ISCNAME . ': ' . __( 'PHP DOM extension', 'image-source-control-isc' ),
				'test'  => [ $this, 'get_site_health_dom_document_test_result' ],
			];
		}

		return $tests;
	}

	/**
	 * Get Site Health result for the PHP DOM extension.
	 *
	 * @return array<string,mixed>
	 */
	public function get_site_health_dom_document_test_result(): array {
		return [
			'label'       => __( 'The PHP DOM extension is missing', 'image-source-control-isc' ),
			'status'      => 'critical',
			'badge'       => [
				'label' => __( 'Performance', 'image-source-control-isc' ),
				'color' => 'red',
			],
			'description' => '<p>' . esc_html( self::get_missing_dom_document_description() ) . '</p>',
			'test'        => 'isc_dom_document_extension',
		];
	}

	/**
	 * Return true if the PHP DOM extension is available.
	 *
	 * @return bool
	 */
	public static function has_dom_document(): bool {
		return (bool) apply_filters( 'isc_has_dom_document', class_exists( 'DOMDocument' ) );
	}

	/**
	 * Get the shared message for a missing PHP DOM extension.
	 *
	 * @return string
	 */
	public static function get_missing_dom_document_description(): string {
		return __( 'Image Source Control requires the PHP DOM extension to analyze HTML content. Please contact your hosting provider and ask them to install or enable the PHP DOM extension.', 'image-source-control-isc' );
	}
}
