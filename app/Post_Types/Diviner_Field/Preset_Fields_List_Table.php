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
		$columns = $this->get_columns();
		$hidden = $this->get_hidden_columns();
		$sortable = $this->get_sortable_columns();
		$fields = $this->get_fields();
		$this->_column_headers = array($columns, $hidden, $sortable);
		$this->items = $fields;
	}

	public function get_fields()
	{
		$args = [
			'post_type' => \Diviner\Post_Types\Diviner_Field\Diviner_Field::NAME
		];

		// The Query
		$the_query = new \WP_Query( $args );
		$fields = [];

		if ( $the_query->have_posts() ) {
			// The 2nd Loop
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				//echo '<li>' . get_the_title( $the_query->post->ID ) . '</li>';
				$fields[] = [
					'id' => $the_query->post->ID,
					'title' => get_the_title( $the_query->post->ID ),
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
		$columns = array(
			'cb'          => '',
			'id'          => 'ID',
			'title'       => 'Title',
			'description' => 'Description'
		);
		return $columns;
	}
	/**
	 * Define which columns are hidden
	 *
	 * @return Array
	 */
	public function get_hidden_columns()
	{
		return array();
	}
	/**
	 * Define the sortable columns
	 *
	 * @return Array
	 */
	public function get_sortable_columns()
	{
		return array('title' => array('title', false));
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
			// case 'title':
			case 'description':
				return $item[ $column_name ];
			default:
				return print_r( $item, true ) ;
		}
	}

	public function column_cb( $item )
	{
		return sprintf(
			'<input type="checkbox" name="field[]" value="%s" />', $item['id']
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
