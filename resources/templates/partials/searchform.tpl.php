<form action="/" method="GET">
    <label for="search">
        <input
            id="search"
            type="text"
            name="s"
            value="<?php the_search_query(); ?>"
            placeholder="<?php echo __('Searching for...', 'diviner-archive'); ?>"
        >
    </label>

    <input type="submit" value="Search">
</form>
