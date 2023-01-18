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

