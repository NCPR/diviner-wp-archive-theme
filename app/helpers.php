<?php

namespace Diviner_Archive\Helpers;

use Tonik\Gin\Asset\Asset;
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
function diviner_archive_theme($key = null, $parameters = [])
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
function diviner_archive_config($key = null)
{
    if (null !== $key) {
        return diviner_archive_theme('config')->get($key);
    }

    return diviner_archive_theme('config');
}

/**
 * Renders template file with data.
 *
 * @param  string $file Relative path to the template file.
 * @param  array  $data Dataset for the template.
 *
 * @return void
 */
function diviner_archive_template($file, $data = [])
{
    $template = new Template(diviner_archive_config());

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
function diviner_archive_asset($file)
{
    $asset = new Asset(diviner_archive_config());

    return $asset->setFile($file);
}

/**
 * Gets asset file from public directory.
 *
 * @param  string $file Relative file path to the asset file.
 *
 * @return string
 */
function diviner_archive_asset_path($file)
{
    return diviner_archive_asset($file)->getUri();
}
