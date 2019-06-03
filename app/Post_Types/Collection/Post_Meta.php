<?php


namespace Diviner\Post_Types\Collection;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Diviner\Post_Types\Archive_Item\Archive_Item;

/**
 * Class Post Meta
 *
 * @package Diviner\Post_Types\Collection
 */
class Post_Meta {

	const FIELD_ARCHIVE_ITEMS = 'div_collection_field_archive_items';
	const FIELD_BROWSE_LINK = 'div_collection_field_browse_link';

	protected $container;

	public function hooks() {
		add_action( 'carbon_fields_register_fields', [ $this, 'add_post_meta' ], 3, 0 );
	}

	public function add_post_meta() {
		$this->container = Container::make( 'post_meta', __( 'Collection Details', 'ncpr-diviner' ) )
			->where( 'post_type', '=', Collection::NAME )
			->add_fields( [
				$this->get_archive_items_field(),
			] )
			->set_priority( 'high' );
	}

	public function get_archive_items_field() {

		return Field::make('association', static::FIELD_ARCHIVE_ITEMS, __( 'Archive items', 'ncpr-diviner' ))
			->set_types( [
				[
					'type' => 'post',
					'post_type' => Archive_Item::NAME,
				],
			] )
			->help_text(__( 'Select a curated collection of archive items', 'ncpr-diviner' ));

	}

}
