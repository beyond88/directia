<?php

namespace Root\Directia\Block;

/**
 * Form block handler class
 */
class FormBlock {

    public function __construct() {
		add_action( 'init', [ $this, 'listingFormBlock' ] );
	}

	public function listingFormBlock() {
		register_block_type( __DIR__ );
	}

}