<?php

namespace Diviner\Post_Types\Diviner_Field\Types;

use Diviner\Post_Types\Archive_Item\Archive_Item;
use Carbon_Fields\Field;

class Related_Field extends FieldType  {

	const NAME = 'diviner_related_field';
	const TITLE = 'Related Items Field';
	const TYPE = 'association';

	static public function render( $post_id, $id, $field_label, $helper = '') {

		$field = Field::make(static::TYPE, $id, $field_label)
			->set_types(array(
				array(
					'type' => 'post',
					'post_type' => Archive_Item::NAME,
				),
			));

		if ( ! empty( $helper ) ) {
			$field->help_text($helper);
		}
		return $field;
	}


}
