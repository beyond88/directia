<?php

/**************
 * 
 * Handle directia as category in gutenberg blocks
 * 
 */
add_filter( 'block_categories_all' , function( $categories ) {

    // Adding a new category.
	$categories[] = array(
		'slug'  => 'directia',
		'title' => 'Directia'
	);

	return $categories;
} );

add_filter( 'rest_url', 'my_remove_locale_query_string', PHP_INT_MAX, 2 );
function my_remove_locale_query_string( $url, $path ) {
    // $url = remove_query_arg( '_locale', $url );
	$url = str_replace('?_locale=user','', $url);
    return $url;
}