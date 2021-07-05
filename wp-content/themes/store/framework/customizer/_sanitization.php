<?php
/* Sanitization Functions Common to Multiple Settings go Here, Specific Sanitization Functions are defined along with add_setting() */
function store_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}

function store_sanitize_positive_number( $input ) {
    if ( ($input >= 0) && is_numeric($input) )
        return $input;
    else
        return '';
}

function store_sanitize_category( $input ) {
    if ( term_exists(get_cat_name( $input ), 'category') )
        return $input;
    else
        return '';
}

function store_sanitize_product_category( $input ) {
    if ( get_term( $input, 'product_cat' ) )
        return $input;
    else
        return '';
}