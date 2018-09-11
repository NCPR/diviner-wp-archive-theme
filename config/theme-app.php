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
	'textdomain'  => 'ncpr-diviner',

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
		'main.php',
		'helpers.php',
		'CarbonFields/Errors/UndefinedType.php',
		'CarbonFields/Boot.php',
		'CarbonFields/Helper.php',
		'Admin/Settings.php',
		'Setup/JS_Config.php',
		'Post_Types/Archive_Item/Archive_Item.php',
		'Post_Types/Archive_Item/AdminModifications.php',
		'Post_Types/Archive_Item/Post_Meta.php',
		'Post_Types/Diviner_Field/Diviner_Field.php',
		'Post_Types/Diviner_Field/PostMeta.php',
		'Post_Types/Diviner_Field/AdminModifications.php',
		'Post_Types/Diviner_Field/Preset_Fields_List_Table.php',
		'Post_Types/Diviner_Field/Types/iField.php',
		'Post_Types/Diviner_Field/Types/FieldType.php',
		'Post_Types/Diviner_Field/Types/Text_Field.php',
		'Post_Types/Diviner_Field/Types/Date_Field.php',
		'Post_Types/Diviner_Field/Types/Taxonomy_Field.php',
		'Post_Types/Diviner_Field/Types/Select_Field.php',
		'Post_Types/Diviner_Field/Types/CPT_Field.php',
		'Post_Types/Diviner_Field/Types/Related_Field.php',
		'Http/assets.php',
		'Http/ajaxes.php',
		'Setup/actions.php',
		'Setup/filters.php',
		'Setup/supports.php',
		'Setup/language.php',
		'Setup/services.php',
		'Structure/navs.php',
		'Structure/widgets.php',
		'Structure/sidebars.php',
		'Structure/templates.php',
		'Structure/posttypes.php',
		'Structure/admin.php',
		'Structure/taxonomies.php',
		'Structure/shortcodes.php',
		'Structure/thumbnails.php',
	],
];
