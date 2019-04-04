<?php

namespace Diviner\Admin;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Diviner\Post_Types\Diviner_Field\AdminModifications;

/**
 * Class Settings
 *
 * Functions for Settings
 *
 * @package Diviner\Admin
 */
class Settings {

	const FIELD_GENERAL_PERMISSIONS = 'diviner_field_general_permissions';
	const FIELD_GENERAL_BROWSE_TITLE = 'diviner_field_general_browse_title';
	const FIELD_GENERAL_BROWSE_MODAL = 'diviner_field_general_browse_modal';
	const FIELD_GENERAL_HELP_PAGE = 'diviner_field_general_help_page';
	const FIELD_GENERAL_FOOTER_COPY = 'diviner_field_general_footer_copy';
	const FIELD_GENERAL_RELATED_FIELD = 'diviner_field_general_related';
	const FIELD_GENERAL_LOOP_CARDS_FIELD = 'diviner_field_general_loop_cards';
	const FIELD_GENERAL_SOCIAL_TWITTER = 'diviner_field_general_social_twitter';
	const FIELD_GENERAL_SOCIAL_FACEBOOK = 'diviner_field_general_social_facebook';
	const FIELD_GENERAL_SOCIAL_INSTAGRAM = 'diviner_field_general_social_instagram';
	const FIELD_GENERAL_COLLECTION = 'diviner_field_general_collection_active';
	const FIELD_GENERAL_COLLECTION_SINGULAR = 'diviner_field_general_collection_singular';
	const FIELD_GENERAL_COLLECTION_PLURAL = 'diviner_field_general_collection_plural';
	const FIELD_GENERAL_COLLECTION_DESCRIPTION = 'diviner_field_general_collection_description';
	const FIELD_GENERAL_COLLECTION_CARDS = 'diviner_field_general_collection_cards';

	const GENERAL_SETTINGS_SLUG = 'diviner_general_settings_slug';

	/**
	 * The built instance of the theme options container.
	 *
	 * @var \Carbon_Fields\Container\Theme_Options_Container
	 */
	protected static $theme_options;

	public function hooks() {
		add_action( 'admin_menu', [ $this, 'create_admin_menus' ], 9 );
		add_action( 'carbon_fields_register_fields', [$this, 'crb_attach_theme_options'], 0, 0 );
		add_filter( 'diviner_js_config', [ $this, 'custom_diviner_js_config' ] );
	}

	public function custom_diviner_js_config( $data  ) {
		$display_popup = carbon_get_theme_option(static::FIELD_GENERAL_BROWSE_MODAL);

		$settings = [
			'permission_notice' => carbon_get_theme_option(static::FIELD_GENERAL_PERMISSIONS),
			'display_popup'     => empty( $display_popup ) ? false : $display_popup,
			'help_page_link'    => carbon_get_theme_option(static::FIELD_GENERAL_HELP_PAGE),
		];
		$data['settings'] = $settings;
		return $data;
	}

	/**
	 * Add admin menus
	 */
	public function create_admin_menus() {
		add_menu_page( // add_menu_page
			__( 'Diviner', 'ncpr-diviner' ),
			__( 'Diviner', 'ncpr-diviner' ),
			'manage_options',
			static::GENERAL_SETTINGS_SLUG,
			[ &$this, 'general_settings_render' ],
			'dashicons-star-filled'
		);
	}

	public function general_settings_render() {
		// check user capabilities
		if (!current_user_can('manage_options')) {
			return;
		}
		?>
		<div class="wrap wrap-diviner wrap-diviner--limited wrap-diviner--default">

			<h2>Diviner Archiving Theme</h2>

			<p>
				Thank you for installing the Diviner Archiving Theme. This wordpress theme allows small institutions and media organizations to create a public-facing, custom archive interface for a themed collection of media.
			</p>

			<p>The main features of this project are</p>
			<ul>
				<li>Small scale archiving tool for a wide array of media materials (audio, video, documents, articles)</li>
				<li>Dublin Core like meta data fields</li>
				<li>Customizable multi-faceted search mechanism</li>
			</ul>

			<p>
				Read more about this theme on the <a href="https://ncpr.github.io/diviner-wp-archive-theme/" target="_blank">documentation website</a>.
			</p>

			<p>
				Start by reviewing the general settings of your archive.
			</p>

			<p>
				<a href="admin.php?page=<?php echo esc_attr( static::$theme_options->get_page_file() ); ?>" class="button button-primary">
					General Settings
				</a>
			</p>

			<p>
				Next, create new meta data fields for your archive items.
			</p>

			<p>
				<a href="index.php?page=<?php echo esc_attr( AdminModifications::SLUG_WIZARD ); ?>" class="button button-primary">
					Create New Diviner Meta Field
				</a>
			</p>

		</div>

		<?php
	}

	/**
	 * Returns the menu slug of the theme options main page.
	 *
	 * This is the slug that should be used as `parent_slug` to
	 * add sub-menus to the main theme options page or to hide it.
	 *
	 * @since TBD
	 *
	 * @return string The main theme options page slug.
	 */
	public static function menu_slug() {
		return static::GENERAL_SETTINGS_SLUG;
	}

	/**
	 * Setup Basic plugin settings
	 * This function creates submenu too which must be modified above in the modify_menus function.
	 */
	public function crb_attach_theme_options() {
		// We can save the result of an instance call in a static property as it will be called once per HTTP request.
		static::$theme_options = Container::make(
			'theme_options',
			__( 'General Settings', 'ncpr-diviner' )
		)
			->set_page_parent( static::GENERAL_SETTINGS_SLUG )
			->add_fields(
			[
				$this->permissions_field(),
				$this->browse_field(),
				$this->browse_modal_field(),
				$this->help_page_field(),
				$this->related_field(),
				$this->loop_as_cards_field(),
				$this->footer_copy(),
				$this->get_separator( __( 'Connect Social Media Accounts', 'ncpr-diviner' ) ),
				$this->social_media_link_twitter(),
				$this->social_media_link_facebook(),
				$this->social_media_link_instagram(),
				$this->get_separator( __( 'Customize Your Collections', 'ncpr-diviner' ) ),
				$this->collection(),
				$this->collection_title_singular(),
				$this->collection_title_plural(),
				$this->collection_loop_as_cards_field(),
				$this->collection_description()
			]
		);
	}

	public function get_separator( $header = 'More' ) {
		return Field::make( 'separator', uniqid('diviner_field_general_seperator'), $header );
	}

	public function permissions_field() {
		return Field::make( 'rich_text', static::FIELD_GENERAL_PERMISSIONS, __( 'Permissions/Rights Note on Archive item', 'ncpr-diviner' ) )
			->set_help_text( __( 'This statement will appear on all archive items if you choose to add one. This is the primary way to communicate to your audience who owns/has the copyright to media (photos, videos, documents, etc.) in your archive', 'ncpr-diviner' ) );
	}

	public function browse_field() {
		return Field::make( 'text', static::FIELD_GENERAL_BROWSE_TITLE, __( 'Browse Page Title', 'ncpr-diviner' ) )
			->set_help_text( __( 'Name your Browse Page/Archive! Example: Explore Photos','ncpr-diviner' ) );
	}

	public function browse_modal_field() {
		return Field::make( 'checkbox', static::FIELD_GENERAL_BROWSE_MODAL, __( 'Activate Modal in browse page on click', 'ncpr-diviner' ) )
			->set_help_text( __( 'Modal displays by default mid size image, title, and copyright information', 'ncpr-diviner' ) );
	}

	public function loop_as_cards_field() {
		return Field::make( 'checkbox', static::FIELD_GENERAL_LOOP_CARDS_FIELD, __( 'Display blog loop as cards', 'ncpr-diviner' ) )
			->set_option_value( '1' )
			->set_default_value( '0' );
	}

	public function related_field() {
		return Field::make( 'checkbox', static::FIELD_GENERAL_RELATED_FIELD, __( 'Activate Related Items Field on Archive Items', 'ncpr-diviner' ) )
			->set_help_text( __( 'Related Items – add related items if you want to be able to manually connect your items to one another. For example, you might choose to link a sculpture to a series of paintings, or a video of a downtown area to pictures of downtown businesses. You add related items ONCE only, and it will work for your entire collection. ', 'ncpr-diviner' ) );
	}

	public function collection() {
		return Field::make( 'checkbox', static::FIELD_GENERAL_COLLECTION, __( 'Activate Collections', 'ncpr-diviner' ) )
			->set_help_text( __( 'Activate collections to take advantage of groups of archive items that can be curated manually.', 'ncpr-diviner' ) )
			->set_option_value( '1' )
			->set_default_value( '1' );
	}

	public function collection_title_singular() {
		return Field::make( 'text', static::FIELD_GENERAL_COLLECTION_SINGULAR, __( 'Collections Title Singular', 'ncpr-diviner' ) )
			->set_default_value( 'Collection' )
			->set_help_text( __( 'Title used to describe collections in interface and loop page','ncpr-diviner' ) )
			->set_required( true );
	}

	public function collection_title_plural() {
		return Field::make( 'text', static::FIELD_GENERAL_COLLECTION_PLURAL, __( 'Collections Title Plural', 'ncpr-diviner' ) )
			->set_default_value( 'Collections' )
			->set_help_text( __( 'Title used to describe collections in interface. Also used in slug','ncpr-diviner' ) );
	}

	public function collection_description() {
		return Field::make( 'rich_text', static::FIELD_GENERAL_COLLECTION_DESCRIPTION, __( 'Collection Description ', 'ncpr-diviner' ) )
			->set_help_text( __( 'Appears at the top of the collections looop page', 'ncpr-diviner' ) );
	}

	public function collection_loop_as_cards_field() {
		return Field::make( 'checkbox', static::FIELD_GENERAL_COLLECTION_CARDS, __( 'Display collection loop as cards', 'ncpr-diviner' ) )
			->set_option_value( '1' )
			->set_default_value( '1' );
	}

	public function get_pages() {
		$cleaned = [
			0 => ''
		];
		$args = [
			'post_type'    => 'page',
			'sort_column'  => 'menu_order'
		];
		$pages = get_pages( $args );
		foreach ($pages as $page) {
			$cleaned[$page->ID] = $page->post_title;
		}
		return $cleaned;
	}

	public function help_page_field() {
		return Field::make( 'select', static::FIELD_GENERAL_HELP_PAGE, __( 'Help Page', 'ncpr-diviner' ) )
			->add_options( [ $this, 'get_pages' ] )
			->set_help_text( __( 'If you want a help page, create one under pages in the main menu, then select that page in this dropdown', 'ncpr-diviner' ) );
	}

	public function social_media_link_twitter() {
		return Field::make( 'text', static::FIELD_GENERAL_SOCIAL_TWITTER, __( 'Twitter Link', 'ncpr-diviner' ) )
			->set_help_text( __( 'Ex: https://twitter.com/nytimes','ncpr-diviner' ) );
	}

	public function social_media_link_facebook() {
		return Field::make( 'text', static::FIELD_GENERAL_SOCIAL_FACEBOOK, __( 'Facebook Link', 'ncpr-diviner' ) )
			->set_help_text( __( 'Ex: https://www.facebook.com/nytimes/','ncpr-diviner' ) );
	}

	public function social_media_link_instagram() {
		return Field::make( 'text', static::FIELD_GENERAL_SOCIAL_INSTAGRAM, __( 'Instagram Link', 'ncpr-diviner' ) )
			->set_help_text( __( 'Ex: https://www.instagram.com/nytimes','ncpr-diviner' ) );
	}

	public function footer_copy() {
		return Field::make( 'rich_text', static::FIELD_GENERAL_FOOTER_COPY, __( 'Footer Copy', 'ncpr-diviner' ) );
	}

}
