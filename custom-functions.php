<?php
    function get_terms_ordered( $taxonomy = '', $args = [], $term_order = '', $sort_by = 'slug' ) {
        // Check if we have a taxonomy set and if the taxonomy is valid. Return false on failure
        if ( !$taxonomy )
            return false;

        if ( !taxonomy_exists( $taxonomy ) )
            return false;

        // Get our terms    
        $terms = get_terms( $taxonomy, $args ); 

        // Check if we have terms to display. If not, return false
        if ( empty( $terms ) || is_wp_error( $terms ) )
            return false;

        /** 
         * We have made it to here, lets continue to output our terms
         * Lets first check if we have a custom sort order. If not, return our
         * object of terms as is
         */
        if ( !$term_order )
            return $terms;

        // Check if $term_order is an array, if not, convert the string to an array
        if ( !is_array( $term_order ) ) {
            // Remove white spaces before and after the comma and convert string to an array
            $no_whitespaces = preg_replace( '/\s*,\s*/', ',', filter_var( $term_order, FILTER_SANITIZE_STRING ) );
            $term_order = explode( ',', $no_whitespaces );
        }

        // Remove the set of terms from the $terms array so we can move them to the front in our custom order
        $array_a = [];
        $array_b = [];
        foreach ( $terms as $term ) {
            if ( in_array( $term->$sort_by, $term_order ) ) {
                $array_a[] = $term;
            } else {
                $array_b[] = $term;
            }
        }

        /**
         * If we have a custom term order, lets sort our array of terms
         * $term_order can be a comma separated string of slugs or names or an array
         */
        usort( $array_a, function ( $a, $b ) use( $term_order, $sort_by )
        {
            // Flip the array
            $term_order = array_flip( $term_order );

            return $term_order[$a->$sort_by] - $term_order[$b->$sort_by];
        });

        return array_merge( $array_a, $array_b );
    }
?>