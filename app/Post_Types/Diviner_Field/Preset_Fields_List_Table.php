<?php

namespace Diviner\Post_Types\Diviner_Field;


// WP_List_Table is not loaded automatically so we need to load it in our application
if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Create a new table class that will extend the WP_List_Table
 */
class Preset_Fields_List_Table extends \WP_List_Table
{

	/**
	 * Prepare the items for the table to process
	 *
	 * @return Void
	 */
	public function prepare_items()
	{
		$this->process_bulk_action();
		$columns = $this->get_columns();
		$hidden = $this->get_hidden_columns();
		$sortable = $this->get_sortable_columns();
		$this->items = $this->get_fields();
		$this->_column_headers = [ $columns, $hidden, $sortable ];
	}

	public function is_empty() {
		return (bool) ( isset( $this->items ) && count( $this->items ) === 0 );
	}

	public function get_fields()
	{
		$args = [
			'post_type' => Diviner_Field::NAME,
			'posts_per_page' => -1,
		];

		// The Query
		$the_query = new \WP_Query( $args );
		$fields = [];

		if ( $the_query->have_posts() ) {
			// The 2nd Loop
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$fields[] = [
					'id' => $the_query->post->ID,
					'title' => get_the_title( $the_query->post->ID ),
					'type' => get_the_title( $the_query->post->ID ),
					'description' => get_the_excerpt( $the_query->post->ID ),
				];
			}

			// Restore original Post Data
			wp_reset_postdata();
		}
		return $fields;
	}


	/**
	 * Override the parent columns method. Defines the columns to use in your listing table
	 *
	 * @return Array
	 */
	public function get_columns()
	{
		return [
			'cb'          => '<input type="checkbox" />',
			'id'          => 'ID',
			'active'      => 'Active',
			'title'       => 'Title',
			'type'        => 'Field Type',
			'description' => 'Description'
		];
	}
	/**
	 * Define which columns are hidden
	 *
	 * @return Array
	 */
	public function get_hidden_columns()
	{
		return [];
	}

	function get_bulk_actions() {
		$actions = [
			'activate'    => 'Activate',
			'deactivate'    => 'Deactivate'
		];
		return $actions;
	}

	function process_bulk_action() {

		$action = $this->current_action();

		if( 'activate' === $action) {
			foreach($_GET['field'] as $id) {
				carbon_set_post_meta( (int) $id, PostMeta::FIELD_ACTIVE,  PostMeta::FIELD_CHECKBOX_VALUE);
			}
		}

		if( 'deactivate' === $action) {
			foreach($_GET['field'] as $id) {
				carbon_set_post_meta( (int) $id, PostMeta::FIELD_ACTIVE,  '');
			}
		}
	}

	/**
	 * Define the sortable columns
	 *
	 * @return Array
	 */
	public function get_sortable_columns()
	{
		return [ 'title' => [ 'title', false ] ];
	}

	/**
	 * Define what data to show on each column of the table
	 *
	 * @param  Array $item        Data
	 * @param  String $column_name - Current column name
	 *
	 * @return Mixed
	 */
	public function column_default( $item, $column_name )
	{
		switch( $column_name ) {
			case 'id':
			case 'description':
			case 'type':
				return $item[ $column_name ];
			default:
				return print_r( $item, true ) ;
		}
	}

	public function column_type( $item )
	{
		$field_type = carbon_get_post_meta($item['id'], PostMeta::FIELD_TYPE);
		return Diviner_Field::get_class_title($field_type);
	}

	public function column_active( $item )
	{
		$field_active = carbon_get_post_meta($item['id'], PostMeta::FIELD_ACTIVE );
		return ( (int)$field_active === 1 ) ? '✓' : '';
	}

	public function column_cb( $item )
	{
		return sprintf(
			'<input type="checkbox" name="field[]" value="%s"/>',
			$item['id']
		);
	}

	public function column_title( $item )
	{
		return sprintf(
			'<a href="%s">%s</a>',
			get_edit_post_link( $item[ 'id' ] ),
			$item[ 'title' ]
		);
	}

	/**
	 * Allows you to sort the data by the variables set in the $_GET
	 *
	 * @return Mixed
	 */
	private function sort_data( $a, $b )
	{
		// Set defaults
		$orderby = 'type';
		$order = 'asc';
		// If orderby is set, use this as the sort column
		if(!empty($_GET['orderby']))
		{
			$orderby = $_GET['orderby'];
		}
		// If order is set use this as the order
		if(!empty($_GET['order']))
		{
			$order = $_GET['order'];
		}
		$result = strcmp( $a[$orderby], $b[$orderby] );
		if($order === 'asc')
		{
			return $result;
		}
		return -$result;
	}
}
