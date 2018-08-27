<?php

namespace Diviner\Post_Types\Diviner_Field\Types;

interface iField {

	static public function render( $post_id, $id, $field_label, $helper = '');

	static public function setup( $post_id );

}
