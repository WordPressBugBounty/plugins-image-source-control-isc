<?php

namespace ISC\Site_Health;

/**
 * Shared Site Health checks for Image Source Control.
 */
abstract class Site_Health {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_filter( 'site_status_tests', [ $this, 'add_site_health_tests' ] );
	}

	/**
	 * Add Site Health tests.
	 *
	 * @param array $tests Existing Site Health tests.
	 * @return array
	 */
	abstract public function add_site_health_tests( array $tests ): array;
}
