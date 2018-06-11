<?php

namespace Tonik\Theme\App;

use Pimple\Container;

class Main {

	protected static $_instance;

	/** @var Container */
	protected $container = null;

	/**
	 * @param Container $container
	 */
	public function __construct( $container ) {
		$this->container = $container;
	}

	public function init() {
		//$this->providers();
	}

	private function providers() {
		//$this->container->register(new AdminProvider());
		//$this->container->register(new GeneralProvider());
		//$this->container->register(new PostTypeProvider());
	}

	public function container() {
		return $this->container;
	}

	/**
	 * @param null|\ArrayAccess $container
	 *
	 * @return Main
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
