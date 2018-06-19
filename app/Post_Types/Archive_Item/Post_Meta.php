<?php


namespace Diviner\Post_Types\Archive_Item;

use Carbon_Fields\Container;
use Carbon_Fields\Field;


class Post_Meta {

	const FIELD_TYPE = 'div_ai_field_type';

	const FIELD_TYPE_PHOTO      = 'div_ai_field_photo';
	const FIELD_TYPE_VIDEO      = 'div_ai_field_video';
	const FIELD_TYPE_AUDIO      = 'div_ai_field_audio';
	const FIELD_TYPE_DOCUMENT   = 'div_ai_field_document';
	const FIELD_TYPE_MIXED      = 'div_ai_field_mixed';

	const FIELD_TYPE_OPTIONS = [
		self::FIELD_TYPE_PHOTO  => 'Photo',
		self::FIELD_TYPE_VIDEO   => 'Video',
		self::FIELD_TYPE_AUDIO   => 'Audio',
		self::FIELD_TYPE_DOCUMENT => 'Document',
		self::FIELD_TYPE_MIXED=> 'Mixed media',
	];

	const FIELD_RELATED = 'div_ai_field_related';
	const FIELD_AUDIO = 'div_ai_field_audio';
	const FIELD_AUDIO_OEMBED = 'div_ai_field_audio_oembed';

	const FIELD_VIDEO_OEMBED = 'div_ai_field_video_oembed';

	const FIELD_DOCUMENT = 'div_ai_field_document';
	const FIELD_DATE = 'div_ai_field_date';

	protected $container;

	public function add_post_meta() {
		$this->container = Container::make( 'post_meta', 'Type' )
			->where( 'post_type', '=', Archive_Item::NAME )
			->add_fields( array(
				$this->get_field_types(),
			))
			->set_priority( 'high' );


		$this->container = Container::make( 'post_meta', 'Date' )
			->where( 'post_type', '=', Archive_Item::NAME )
			->add_fields( array(
				$this->get_date_field(),
			))
			->set_priority( 'high' );


		$this->container = Container::make( 'post_meta', 'Related Items' )
			->where( 'post_type', '=', Archive_Item::NAME )
			->add_fields( array(
				$this->get_field_related(),
			))
			->set_priority( 'high' );

		$this->container = Container::make( 'post_meta', 'Audio' )
			->where( 'post_type', '=', Archive_Item::NAME )
			->add_fields( array(
				$this->get_field_audio(),
				$this->get_field_audio_oembed()
			))
			->set_priority( 'high' );

		$this->container = Container::make( 'post_meta', 'Video' )
			->where( 'post_type', '=', Archive_Item::NAME )
			->add_fields( array(
				$this->get_field_video_oembed()
			))
			->set_priority( 'high' );

		$this->container = Container::make( 'post_meta', 'Document' )
			->where( 'post_type', '=', Archive_Item::NAME )
			->add_fields( array(
				$this->get_field_document()
			))
			->set_priority( 'high' );

	}

	public function get_date_field()
	{
		return Field::make( 'date', self::FIELD_DATE , 'The date the archive item was created or written or recorded' );

	}

	public function get_field_document()
	{
		return Field::make( 'file', self::FIELD_DOCUMENT , 'Any other document not an image or video or audio. Ex: PDF ' );

	}

	public function get_field_video_oembed()
	{
		return Field::make( 'oembed', self::FIELD_VIDEO_OEMBED, 'Any oembed video url' );
	}

	public function get_field_audio()
	{
		return Field::make( 'file', self::FIELD_AUDIO , 'Any audio file' )
			->set_type( 'audio' );

	}

	public function get_field_audio_oembed()
	{
		return Field::make( 'oembed', self::FIELD_AUDIO_OEMBED, 'Any oembed audio file' );
	}

	public function get_field_related()
	{
		return Field::make('association', self::FIELD_RELATED, 'Related Items')
			->set_types(array(
				array(
					'type' => 'post',
					'post_type' => Archive_Item::NAME,
				),
			));
	}

	public function get_field_types() {
		$field = Field::make( 'select', self::FIELD_TYPE, 'Type of Archive Item' )
			->add_options(self::FIELD_TYPE_OPTIONS)
			->set_help_text( 'What kind of field is this' );
		if( isset( $_GET["type"] ) ) {
			$field->set_default_value( 'div_ai_field_' . $_GET["type"] );
		}
		return $field;
	}

}
