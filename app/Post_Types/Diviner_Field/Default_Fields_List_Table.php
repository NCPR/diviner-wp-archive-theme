<?php

namespace Diviner\Post_Types\Diviner_Field;

// WP_List_Table is not loaded automatically so we need to load it in our application
if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Create a new table class that will extend the WP_List_Table
 */
class Default_Fields_List_Table extends \WP_List_Table
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
		$data = $this->table_data();
		// usort( $data, array( &$this, 'sort_data' ) );
		// $perPage = 2;
		// $currentPage = $this->get_pagenum();
		// $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);
		$this->_column_headers = array($columns, $hidden, $sortable);
		$this->items = $data;
	}
	/**
	 * Override the parent columns method. Defines the columns to use in your listing table
	 *
	 * @return Array
	 */
	public function get_columns()
	{
		$columns = array(
			'id'          => 'ID',
			'type'       => 'Type',
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
	 * Get the table data
	 *
	 * @return Array
	 */
	private function table_data()
	{
		$data = array();
		$data[] = array(
			'id'          => 1,
			'type'       => 'Title',
			'description' => 'Maecenas dapibus elit luctus tempor placerat.'
		);
		$data[] = array(
			'id'          => 2,
			'type'       => 'Description',
			'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. '
		);
		$data[] = array(
			'id'          => 3,
			'type'       => 'Publish Date',
			'description' => 'Nam egestas odio a nisl aliquet, et lacinia nisi luctus. Maecenas dapibus elit luctus tempor placerat.'
		);
		$data[] = array(
			'id'          => 4,
			'type'       => 'Feature Image',
			'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam egestas odio a nisl aliquet, et lacinia nisi luctus. '
		);
		$data[] = array(
			'id'          => 5,
			'type'       => 'Post Author',
			'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam egestas odio a nisl aliquet, et lacinia nisi luctus. Maecenas dapibus elit luctus tempor placerat.'
		);
		return $data;
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
			case 'type':
			case 'description':
				return $item[ $column_name ];
			default:
				return print_r( $item, true ) ;
		}
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
