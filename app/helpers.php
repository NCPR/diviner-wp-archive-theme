<?php

namespace Tonik\Theme\App;

use Diviner\Plugin\Plugin;
use Tonik\Gin\Asset\Asset;
use Tonik\Gin\Foundation\Exception\BindingResolutionException;
use Tonik\Gin\Foundation\Theme;
use Tonik\Gin\Template\Template;

/**
 * Gets theme instance.
 *
 * @param string|null $key
 * @param array $parameters
 *
 * @return \Tonik\Gin\Foundation\Theme
 */
function theme($key = null, $parameters = [])
{
    if (null !== $key) {
        return Theme::getInstance()->get($key, $parameters);
    }

    return Theme::getInstance();
}

/**
 * Gets theme config instance.
 *
 * @param string|null $key
 *
 * @return array
 */
function config($key = null)
{
    if (null !== $key) {
        return theme('config')->get($key);
    }

    return theme('config');
}

/**
 * Gets plugin instance.
 *
 * @param string|null $key
 * @param array $parameters
 *
 * @return Plugin|mixed
 */
function plugin($key = null, $parameters = [])
{
	if (null !== $key) {
		return Plugin::getInstance()->get($key, $parameters);
	}

	return Plugin::getInstance();
}

/**
 * Gets plugin config instance.
 *
 * @param string|null $key
 *
 * @return array
 *
 * @throws BindingResolutionException If the config is not bound.
 */
function plugin_config($key = null)
{
	if (null !== $key) {
		return plugin('config')->get($key);
	}

	return plugin('config');
}

/**
 * Renders template file with data.
 *
 * @param  string $file Relative path to the template file.
 * @param  array  $data Dataset for the template.
 *
 * @return void
 */
function template($file, $data = [])
{
    $template = new Template(config());

    return $template
        ->setFile($file)
        ->render($data);
}

/**
 * Gets asset instance.
 *
 * @param  string $file Relative file path to the asset file.
 *
 * @return \Tonik\Gin\Asset\Asset
 */
function asset($file)
{
    $asset = new Asset(config());

    return $asset->setFile($file);
}

/**
 * Gets asset file from public directory.
 *
 * @param  string $file Relative file path to the asset file.
 *
 * @return string
 */
function asset_path($file)
{
    return asset($file)->getUri();
}
