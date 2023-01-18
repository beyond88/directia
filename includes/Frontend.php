<?php

namespace Root\Directia;
// use Root\Directia\Block;

/**
 * Frontend handler class
 */
class Frontend {

    /**
     * Initialize the class
     */
    function __construct() {

        //new Frontend\ListingShortcode();

        new Frontend\FormShortcode();
        new Block\FormBlock();
        
    }
}