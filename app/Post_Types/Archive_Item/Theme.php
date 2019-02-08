<?php

namespace Diviner\Post_Types\Archive_Item;

use Diviner\Post_Types\Diviner_Field\Diviner_Field;
use Diviner\Post_Types\Diviner_Field\PostMeta as DivinerFieldPostMeta;
use Diviner\Post_Types\Diviner_Field\Types\Text_Field;
use Diviner\Post_Types\Diviner_Field\Types\Date_Field;
use Diviner\Post_Types\Diviner_Field\Types\Taxonomy_Field;
use Diviner\Post_Types\Diviner_Field\Types\CPT_Field;
use Diviner\Post_Types\Diviner_Field\Types\Select_Field;

use Diviner\CarbonFields\Helper;


class Theme {

	static public function render_meta_fields($post_id = null) {
		if (!isset($post_id)) {
			$post_id = get_the_ID();
		}
		$active_field_posts_ids = Diviner_Field::get_active_fields();
		$field_output = [];


		foreach($active_field_posts_ids as $active_field_post_id) {
			$field_name = carbon_get_post_meta(
				$active_field_post_id,
				DivinerFieldPostMeta::FIELD_ID,
				'carbon_fields_container_field_variables'
			);
			$field_type = carbon_get_post_meta(
				$active_field_post_id,
				DivinerFieldPostMeta::FIELD_TYPE,
				'carbon_fields_container_field_variables'
			);
			// var_dump($field_type);
			$field_class = Diviner_Field::get_class($field_type);
			// var_dump($field_class);
			if( is_callable( [ $field_class, 'get_value' ] ) ) {
				$field_value = call_user_func( [ $field_class, 'get_value' ], $post_id, $field_name, $active_field_post_id);
			}
			// var_dump($field_value);
			$field_title = get_the_title( $active_field_post_id );
			if (isset($field_value)) {
				$field_output[] = sprintf(
					'<li class="archive-item-meta__item"><label class="archive-item-meta__item-label">%s</label><div class="archive-item-meta__item-value">%s</div></li>',
					$field_title,
					$field_value
				);
			}
		}
		 return sprintf(
		 	'<div class="archive-item-meta"><ul class="archive-item-meta__list">%s</ul></div>',
			 implode( '', $field_output)
		 );
	}

}
