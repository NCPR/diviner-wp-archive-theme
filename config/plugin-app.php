<?php

return [
	/*
	|--------------------------------------------------------------------------
	| Plugin Textdomain
	|--------------------------------------------------------------------------
	|
	| Determines a textdomain for your plugin. Should be used to dynamically set
	| namespace for gettext strings across plugin. Remember, this value must
	| be in sync with `Text Domain:` entry inside plugin.php plugin file.
	|
	*/
	'textdomain'  => 'ncpr-diviner',

	/*
	|--------------------------------------------------------------------------
	| Templates files extension
	|--------------------------------------------------------------------------
	|
	| Determines the plugin's templates settings like an extension of the files.
	| By default, they use `.tpl.php` suffix to distinguish template files
	| from controllers, but you are free to change it however you like.
	|
	*/
	'templates'   => [
		'extension' => '.tpl.php',
	],

	/*
	|--------------------------------------------------------------------------
	| Plugin Root Paths
	|--------------------------------------------------------------------------
	|
	| This values determines the "root" paths of your plugin.
	|
	*/
	'paths'       => [
		'directory' => dirname( __DIR__ . '/../plugin.php' ),
		'uri'       => plugins_url( '', __DIR__ . '/../plugin.php' ),
	],

	/*
	|--------------------------------------------------------------------------
	| Plugin Directory Structure Paths
	|--------------------------------------------------------------------------
	|
	| This array of directories will be used within core for locating
	| and loading plugin files, assets and templates. They must be
	| given as relative to the `root` plugin directory.
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
	| Autoloaded Plugin Components
	|--------------------------------------------------------------------------
	|
	| The components listed below will be automatically loaded on the
	| plugin bootstrap by `plugin.php` file. Feel free to add your
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
		'Admin/Customizer.php',
		'Admin/Editor.php',
		'Config/General.php',
		'Post_Types/Archive_Item/Archive_Item.php',
		'Post_Types/Archive_Item/AdminModifications.php',
		'Post_Types/Archive_Item/Post_Meta.php',
		'Post_Types/Archive_Item/Rest.php',
		'Post_Types/Archive_Item/Theme.php',
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
		'Post_Types/Collection/Collection.php',
		'Post_Types/Collection/Post_Meta.php',
		'Theme/General.php',
		'Theme/Image.php',
		'Theme/Swatches.php',
		'Theme/BrowsePage.php',
		'Theme/Post_Meta.php',
		'Theme/Widgets/Widget_Related_Items.php',
		'Theme/JS_Config.php',
		'Http/assets.php',
		'Setup/actions.php',
		'Setup/filters.php',
		'Setup/language.php',
		'Setup/services.php',
		'Structure/widgets.php',
		'Structure/posttypes.php',
		'Structure/admin.php',
		'Structure/taxonomies.php',
		'Structure/shortcodes.php',
	],
];
