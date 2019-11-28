<?php
$unique_id = uniqid( 'search-form-' );
?>
<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search" class="search-form">
	<label for="<?php echo esc_attr( $unique_id ); ?>">
		<span class="a11y-hidden"><?php echo __( 'Search for:', 'diviner-archive' ); ?></span>
		<input
			id="<?php echo esc_attr( $unique_id ); ?>"
			type="search"
			name="s"
			value="<?php the_search_query(); ?>"
			placeholder="<?php echo esc_attr__('Searching for...', 'diviner-archive'); ?>"
		>
	</label>
	<button type="submit" value="Search">
		<?php echo __( 'Search', 'diviner-archive' ); ?>
	</button>
</form>
