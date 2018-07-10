<?php
/*
|-----------------------------------------------------------
| Create the Plugin
|-----------------------------------------------------------
|
| Create a new Plugin instance which behaves as singleton.
| This allows for easily bind and resolve various
| parts across all theme components.
|
*/

/** @var \Diviner\Plugin\Plugin $plugin */
$plugin = Diviner\Plugin\Plugin::getInstance();


/*
|-----------------------------------------------------------
| Bind Theme Config
|-----------------------------------------------------------
|
| We need to bind configs like plugin's paths, directories and
| files to autoload. These values will be used by the rest
| of plugin components like assets, templates etc.
|
*/

$config = require __DIR__ . '/../config/plugin-app.php';

$plugin->bind( 'config', function () use ( $config ) {
	return new Tonik\Gin\Foundation\Config( $config );
} );


/*
|-----------------------------------------------------------
| Return the Plugin
|-----------------------------------------------------------
|
| Here we return the plugin instance. Later, this instance
| is used for autoload all plugin's core component.
|
*/

return $plugin;
