<?php

namespace Diviner\Plugin;


use Tonik\Gin\Foundation\Exception\FileNotFoundException;

class Autoloader extends \Tonik\Gin\Foundation\Autoloader {

	public function load() {
		foreach ( $this->config['autoload'] as $file ) {
			$relative_path = $this->getRelativePath( $file );

			if ( ! file_exists( $this->config['paths']['directory'] . '/' . $relative_path ) ) {
				throw new FileNotFoundException( "Autoloaded file [{$this->getPath($file)}] cannot be found. Please, check your autoloaded entries in `config/app.php` file." );
			}
		}
	}
}
