<?php


namespace Diviner\Post_Types\Collection;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Diviner\CarbonFields\Helper;

/**
 * Class Post Meta
 *
 * @package Diviner\Post_Types\Collection
 */
class Post_Meta {

	const FIELD_ARCHIVE_ITEMS = 'div_collection_field_archive_items';

	protected $container;

	public function hooks() {
		add_action( 'carbon_fields_register_fields', [ $this, 'add_post_meta' ], 3, 0 );
	}

	public function add_post_meta() {
		$this->container = Container::make( 'post_meta', __( 'Archive items', 'ncpr-diviner' ) )
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
					'post_type' => Collection::NAME,
				],
			] )
			->help_text(__( 'Select a curated collection of archive items', 'ncpr-diviner' ));

	}

}
