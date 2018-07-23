<?php


namespace Diviner\Post_Types\Archive_Item;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Diviner\Post_Types\Diviner_Field\Diviner_Field;
use Diviner\Post_Types\Diviner_Field\PostMeta as FieldPostMeta;
use Diviner\CarbonFields\Helper;
use Diviner\CarbonFields\Errors\UndefinedType;

use Diviner\Post_Types\Diviner_Field\PostMeta;
use Diviner\Post_Types\Diviner_Field\Types\Text_Field;
use Diviner\Post_Types\Diviner_Field\Types\Date_Field;
use Diviner\Post_Types\Diviner_Field\Types\Taxonomy_Field;
use Diviner\Post_Types\Diviner_Field\Types\CPT_Field;
use Diviner\Post_Types\Diviner_Field\Types\Select_Field;
use Diviner\Post_Types\Diviner_Field\Types\Related_Field;

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

	static public function get_type_label_from_id($id)
	{
		return isset(self::FIELD_TYPE_OPTIONS[$id]) ? self::FIELD_TYPE_OPTIONS[$id] : '';
	}

	public function add_post_meta()
	{
		$this->add_permanent_fields();
		$this->add_dynamic_fields();

	}

	public function add_permanent_fields()
	{
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
			->set_priority( 'default' );


		$this->container = Container::make( 'post_meta', 'Related Items' )
			->where( 'post_type', '=', Archive_Item::NAME )
			->add_fields( array(
				$this->get_field_related(),
			))
			->set_priority( 'default' );

		$this->container = Container::make( 'post_meta', 'Audio' )
			->where( 'post_type', '=', Archive_Item::NAME )
			->add_fields( array(
				$this->get_field_audio(),
				$this->get_field_audio_oembed()
			))
			->set_priority( 'default' );

		$this->container = Container::make( 'post_meta', 'Video' )
			->where( 'post_type', '=', Archive_Item::NAME )
			->add_fields( array(
				$this->get_field_video_oembed()
			))
			->set_priority( 'default' );

		$this->container = Container::make( 'post_meta', 'Document' )
			->where( 'post_type', '=', Archive_Item::NAME )
			->add_fields( array(
				$this->get_field_document()
			))
			->set_priority( 'default' );

	}

	/**
	 * Adds one or more classes to the body tag in the dashboard.
	 *
	 * @param  \WP_Post $post Current field post.
	 * @return String          Class name.
	 */
	public function get_class( $post ) {
		$field_type = carbon_get_the_post_meta( FieldPostMeta::FIELD_TYPE, 'carbon_fields_container_field_variables' );
		$map = [
			Text_Field::NAME        => Text_Field::class,
			Date_Field::NAME        => Date_Field::class,
		];

		if( !array_key_exists( $field_type, $map ) ){
			// developer-land exception, let's make it clear
			throw UndefinedType("{$field_type} is not a valid field type");
		}

		return $map[$field_type];
	}

	public function get_field($type) {
		$id = carbon_get_the_post_meta( FieldPostMeta::FIELD_ID );
		$label = carbon_get_the_post_meta( FieldPostMeta::FIELD_LABEL_TITLE );
		$helper = carbon_get_the_post_meta( FieldPostMeta::FIELD_ADMIN_HELPER_TEXT);

		// return call_user_func([$type, 'render']);

		$static_call_name = sprintf(
			'%s::render',
			$type
		);
		return call_user_func($static_call_name, $id, $label, $helper);
	}

	public function add_dynamic_fields(){
		$field_query = new \WP_Query( array(
			'post_type' => Diviner_Field::NAME,
			'meta_query'=> array(
				array(
					'key'     => Helper::get_real_field_name(FieldPostMeta::FIELD_ACTIVE ),
					'value'   => FieldPostMeta::FIELD_CHECKBOX_VALUE
				),
			),
		) );
		$dyn_fields = [];

		// $type = carbon_get_post_meta( $cptid, Post_Meta::FIELD_TYPE );
		while( $field_query->have_posts() ) : $field_query->the_post();
			// add fields
			$type = $this->get_class( get_post() );
			if ( $type ) {
				$dyn_fields[] = $this->get_field( $type );
			}
		endwhile;
		wp_reset_postdata();

		$dyn_fields_container = Container::make( 'post_meta', 'Additional Fields' )
			->where( 'post_type', '=', Archive_Item::NAME )
			->add_fields( $dyn_fields )
			->set_priority( 'default' );

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
