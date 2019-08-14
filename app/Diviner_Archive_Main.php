<?php

namespace Diviner_Archive;

use Pimple\Container;

class Diviner_Archive_Main {

	protected static $_instance;

	/** @var Container */
	protected $container = null;

	/**
	 * @param Container $container
	 */
	public function __construct( $container ) {
		$this->container = $container;
	}

	/**
	 * @return Container $container
	 */
	public function container() {
		return $this->container;
	}

	/**
	 * @param null|\ArrayAccess $container
	 *
	 * @return Diviner_Archive_Main
	 * @throws \Exception
	 */
	public static function instance() {
		if ( !isset( self::$_instance ) ) {
			//if ( empty( $container ) ) {
			//	throw new \Exception( 'You need to provide a Pimple container' );
			//}

			$className       = __CLASS__;
			self::$_instance = new $className( new \Pimple\Container( [ 'plugin_file' => __FILE__ ] ) );
		}

		return self::$_instance;
	}
}
