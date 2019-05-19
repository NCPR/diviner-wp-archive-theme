<?php


namespace Diviner\Post_Types\Archive_Item;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Diviner\Post_Types\Diviner_Field\Diviner_Field;
use Diviner\Post_Types\Diviner_Field\PostMeta as FieldPostMeta;
use Diviner\Admin\Settings;
use Diviner\Post_Types\Diviner_Field\Types\Related_Field;

/**
 * Class Post Meta
 *
 * @package Diviner\Post_Types\Archive_Item
 */
class Post_Meta {

	const FIELD_TYPE = 'div_ai_field_type';

	const FIELD_TYPE_PHOTO      = 'div_ai_field_photo';
	const FIELD_TYPE_VIDEO      = 'div_ai_field_video';
	const FIELD_TYPE_AUDIO      = 'div_ai_field_audio';
	const FIELD_TYPE_DOCUMENT   = 'div_ai_field_document';
	const FIELD_TYPE_MIXED      = 'div_ai_field_mixed';

	const CONTAINER_TYPES           = 'div_ai_container_types';
	const CONTAINER_TYPE_PHOTO      = 'div_ai_container_photo';
	const CONTAINER_TYPE_VIDEO      = 'div_ai_container_video';
	const CONTAINER_TYPE_AUDIO      = 'div_ai_container_audio';
	const CONTAINER_TYPE_DOCUMENT   = 'div_ai_container_document';
	const CONTAINER_TYPE_MIXED      = 'div_ai_container_mixed';

	const FIELD_TYPE_OPTIONS = [
		self::FIELD_TYPE_PHOTO    => 'Photo',
		self::FIELD_TYPE_VIDEO    => 'Video',
		self::FIELD_TYPE_AUDIO    => 'Audio',
		self::FIELD_TYPE_DOCUMENT => 'Document',
		self::FIELD_TYPE_MIXED    => 'Mixed media',
	];

	const FIELD_PHOTO        = 'div_ai_field_feature_photo';
	const FIELD_RELATED      = 'div_ai_field_related';
	const FIELD_AUDIO        = 'div_ai_field_feature_audio';
	const FIELD_AUDIO_OEMBED = 'div_ai_field_audio_feature_oembed';
	const FIELD_VIDEO_OEMBED = 'div_ai_field_video_feature_oembed';
	const FIELD_DOCUMENT     = 'div_ai_field_feature_document';

	protected $container;

	public function hooks() {
		add_action( 'carbon_fields_register_fields', [ $this, 'add_post_meta' ], 3, 0 );
	}

	static public function get_type_label_from_id($id) {
		return isset( static::FIELD_TYPE_OPTIONS[$id] ) ? static::FIELD_TYPE_OPTIONS[$id] : '';
	}

	public function add_post_meta()
	{
		$this->add_permanent_fields();
		$this->add_dynamic_fields();
	}

	public function add_permanent_fields()
	{
		$this->container = Container::make(
			'post_meta',
			static::CONTAINER_TYPES,
			__( 'Type', 'ncpr-diviner' )
		)
			->where( 'post_type', '=', Archive_Item::NAME )
			->add_fields( [
				$this->get_field_types(),
			] )
			->set_priority( 'high' );

		$this->container = Container::make(
			'post_meta',
			static::CONTAINER_TYPE_PHOTO,
			__( 'Photo', 'ncpr-diviner' )
		)
			->where( 'post_type', '=', Archive_Item::NAME )
			->add_fields( [
				$this->get_field_photo()
			] )
			->set_priority( 'high' );

		$this->container = Container::make(
			'post_meta',
			static::CONTAINER_TYPE_AUDIO,
			__( 'Audio', 'ncpr-diviner' )
		)
			->where( 'post_type', '=', Archive_Item::NAME )
			->add_fields( [
				$this->get_field_audio(),
				$this->get_field_audio_oembed()
			] )
			->set_priority( 'high' );

		$this->container = Container::make(
			'post_meta',
			static::CONTAINER_TYPE_VIDEO,
			__( 'Video', 'ncpr-diviner' )
		)
			->where( 'post_type', '=', Archive_Item::NAME )
			->add_fields( [
				$this->get_field_video_oembed()
			] )
			->set_priority( 'high' );

		$this->container = Container::make(
			'post_meta',
			static::CONTAINER_TYPE_DOCUMENT,
			__( 'Document', 'ncpr-diviner' )
		)
			->where( 'post_type', '=', Archive_Item::NAME )
			->add_fields( [
				$this->get_field_document()
			] )
			->set_priority( 'high' );

	}

	public function get_field( $cpt_field_id, $type ) {
		$id = Diviner_Field::get_field_post_meta( $cpt_field_id, FieldPostMeta::FIELD_ID );
		$label = get_the_title( $cpt_field_id );
		$helper = Diviner_Field::get_field_post_meta( $cpt_field_id, FieldPostMeta::FIELD_ADMIN_HELPER_TEXT);
		if( is_callable( [ $type,'render' ] ) ){
			return call_user_func( [ $type, 'render' ], $cpt_field_id, $id, $label, $helper);
		}
		return '';
	}

	public function add_dynamic_fields(){
		$cpt_fields_ids = Diviner_Field::get_active_fields();
		$dynamic_fields = [];

		foreach($cpt_fields_ids as $cpt_field_id) {
			$field_type = Diviner_Field::get_field_post_meta($cpt_field_id, FieldPostMeta::FIELD_TYPE );
			$type = Diviner_Field::get_class( $field_type );
			if ( $type ) {
				$field_rendered = $this->get_field( $cpt_field_id,  $type );
				if ( ! empty( $field_rendered ) ) {
					$dynamic_fields[] = $field_rendered;
				}

			}
		}

		// add the related field
		$related = carbon_get_theme_option(Settings::FIELD_GENERAL_RELATED_FIELD);
		if ( $related ) {
			$field = Related_Field::render(
				0,
				static::FIELD_RELATED,
				__( 'Related Archive Items', 'ncpr-diviner' ),
				__( 'Appears on each archive item single page as a slider. Scroll down for the full list of archive items to choose from.', 'ncpr-diviner' )
			);
			$dynamic_fields[] = $field;
		}

		if ( count($dynamic_fields) ) {
			$dyn_fields_container = Container::make( 'post_meta', __( 'Additional Fields', 'ncpr-diviner' ) )
				->where( 'post_type', '=', Archive_Item::NAME )
				->add_fields( $dynamic_fields )
				->set_priority( 'default' );
		}

	}

	public function get_field_document()
	{
		return Field::make(
			'file',
			static::FIELD_DOCUMENT ,
			__( 'Any other document not an image or video or audio. Ex: PDF', 'ncpr-diviner' )
		);

	}

	public function get_field_photo()
	{
		return Field::make(
			'image',
			static::FIELD_PHOTO,
			__( 'Large feature image to appear in single page.', 'ncpr-diviner' )
		);

	}

	public function get_field_video_oembed()
	{
		return Field::make(
			'oembed',
			static::FIELD_VIDEO_OEMBED,
			__( 'Any oembed video url', 'ncpr-diviner' )
		);
	}

	public function get_field_audio()
	{
		return Field::make( 'file', static::FIELD_AUDIO , __( 'Any Audio File', 'ncpr-diviner' ) )
			->set_type( 'audio' );

	}

	public function get_field_audio_oembed()
	{
		return Field::make( 'oembed', static::FIELD_AUDIO_OEMBED, __( 'Any Oembed Audio File', 'ncpr-diviner' ) );
	}

	public function get_field_types() {
		$field = Field::make( 'select', static::FIELD_TYPE, __( 'Type of Archive Item', 'ncpr-diviner' ) )
			->add_options( static::FIELD_TYPE_OPTIONS )
			->set_help_text( __( 'What kind of field is this?', 'ncpr-diviner' ) );
		if( isset( $_GET["type"] ) ) {
			$field->set_default_value( 'div_ai_field_' . $_GET["type"] );
		}
		return $field;
	}

}
