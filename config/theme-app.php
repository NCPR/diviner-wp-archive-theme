<?php

return [
	/*
	|--------------------------------------------------------------------------
	| Theme Textdomain
	|--------------------------------------------------------------------------
	|
	| Determines a textdomain for your theme. Should be used to dynamically set
	| namespace for gettext strings across theme. Remember, this value must
	| be in sync with `Text Domain:` entry inside style.css theme file.
	|
	*/
	'textdomain'  => 'diviner-archive',

	/*
	|--------------------------------------------------------------------------
	| Templates files extension
	|--------------------------------------------------------------------------
	|
	| Determines the theme's templates settings like an extension of the files.
	| By default, they use `.tpl.php` suffix to distinguish template files
	| from controllers, but you are free to change it however you like.
	|
	*/
	'templates'   => [
		'extension' => '.tpl.php',
	],

	/*
	|--------------------------------------------------------------------------
	| Theme Root Paths
	|--------------------------------------------------------------------------
	|
	| This values determines the "root" paths of your theme. By default,
	| they use WordPress `get_template_directory` functions and
	| probably you don't need make any changes in here.
	|
	*/
	'paths'       => [
		'directory' => get_template_directory(),
		'uri'       => get_template_directory_uri(),
	],

	/*
	|--------------------------------------------------------------------------
	| Theme Directory Structure Paths
	|--------------------------------------------------------------------------
	|
	| This array of directories will be used within core for locating
	| and loading theme files, assets and templates. They must be
	| given as relative to the `root` theme directory.
	|
	*/
	'directories' => [
		'languages' => 'resources/languages',
		'templates' => 'resources/templates',
		'assets'    => 'resources/assets',
		'public'    => 'public',
		'app'       => 'app',
	],

	/*
	|--------------------------------------------------------------------------
	| Autoloaded Theme Components
	|--------------------------------------------------------------------------
	|
	| The components listed below will be automatically loaded on the
	| theme bootstrap by `functions.php` file. Feel free to add your
	| own files to this array which you would like to autoload.
	|
	*/
	'autoload'    => [
		'Diviner_Archive_Main.php',
		'helpers.php',
		'Admin/Diviner_Archive_General.php',
		'Admin/Diviner_Archive_Customizer.php',
		'Admin/Diviner_Archive_Editor.php',
		'Config/Diviner_Archive_General.php',
		'Post_Types/Archive_Item/Diviner_Archive_Archive_Item.php',
		'Theme/Diviner_Archive_General.php',
		'Theme/Diviner_Archive_Image.php',
		'Theme/Diviner_Archive_Swatches.php',
		'Theme/Diviner_Archive_FontAwesomeIcons.php',
		'Theme/Diviner_Archive_OEmbed.php',
		'Theme/Diviner_Archive_Swatches.php',
		'Theme/Diviner_Archive_Search_Page.php',
		'Theme/Diviner_Archive_Post_Meta.php',
		'Theme/Diviner_Archive_Title.php',
		'Theme/Diviner_Archive_Widgets.php',
		'Theme/Diviner_Archive_Pagination.php',
		'Structure/theme.php',
		'Structure/templates.php',
		'Structure/admin.php',
		'Structure/thumbnails.php',
	],
];
