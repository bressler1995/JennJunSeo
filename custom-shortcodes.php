<?php
    function jseo_show_function() {
        $jseo_markdown = '<div class="jseo_portfolio" id="jseo_portfolio">
        <div class="jseo_portfolio_controls">
            <button type="button" class="jseo_portfolio_opt"><img class="jseo_portfolio_opt_img" src="' . get_stylesheet_directory_uri() . '/img/button_left.png"></button>
            <button type="button" id="jseo_portfolio_all" class="jseo_portfolio_select">All
                <div class="jseo_portofolio_description"><span>All projects are being displayed.</span></div>
            </button>
            <button type="button" class="jseo_portfolio_opt"><img class="jseo_portfolio_opt_img" src="' . get_stylesheet_directory_uri() . '/img/button_right.png"></button>
        </div>
        <div class="jseo_portfolio_content grid">';

        // $args['category_name']   = 'featured';

        $the_query = new WP_Query(array('post_type' => 'portfolio', 
            'posts_per_page' => 9, 
            'post_status' => 'publish',
            'paged' => get_query_var('paged') ? get_query_var('paged') : 1 )
        );

        if ($the_query->have_posts()) {

            while ($the_query->have_posts()) {

                $the_query->the_post() ;
                $the_id = get_the_ID();
                $the_featured_image = get_the_post_thumbnail_url($the_id);
                $the_permalink = get_permalink($the_id);
                $the_title = get_the_title($the_id);

                if(isset($the_featured_image)) {
                    $jseo_markdown .= '<div class="jseo_column"><a href="' . $the_permalink . '"><img src="' . $the_featured_image . '"><span class="jseo_portfolio_title">' . $the_title . '</span></a></div>';
                }

            }

        }

        

        $big = 999999999; // need an unlikely integer

        $jseo_markdown .= '</div></div>';
        $jseo_markdown .= '<div class="jseo_pagination">';
        $jseo_markdown .= paginate_links( array(
            'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $the_query->max_num_pages,
            'prev_text'    => __('<'),
            'next_text'    => __('>')
        ));
        $jseo_markdown .= '</div>';
         wp_reset_postdata();
        return $jseo_markdown;
    }

    add_shortcode('jseoshow', 'jseo_show_function');
?>