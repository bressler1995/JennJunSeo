<?php
    $jseo_filterparam = $_GET['filter'];

    if(isset($jseo_filterparam) == false && empty($jseo_filterparam)) {
        $jseo_filterparam = 'all';
    }

    function jseo_show_function() {
        global $jseo_filterparam;

        $jseo_currentopt_name = '';
        $jseo_hoverDescription = '';
        $jseo_contentClass = '';
        $jseo_has_cat = false;

        $jseo_catui_output = '<div id="jseo_portfolio_catui" class="jseo_portfolio_catui">';
        $jseo_taxcategories = get_terms( array(
            'taxonomy' => 'portfolio_category',
            'hide_empty' => false,
        ));

        if($jseo_filterparam == 'all') {
            $jseo_catui_output .= '<a class="active" data-slug="all" href="javascript:void(0);">All</a>';
            $jseo_hoverDescription = 'All projects are being displayed.';
            $jseo_has_cat = true;
            $jseo_currentopt_name = 'All';
        } else {
            $jseo_catui_output .= '<a data-slug="all" href="javascript:void(0);">All</a>';
        }
        

        if ( !empty($jseo_taxcategories) ) {
            foreach( $jseo_taxcategories as $category ) {
                if( $category->parent == 0 ) {
                    $jseo_cat_name = $category->name;
                    $jseo_cat_slug = $category->slug;
                    $jseo_cat_class = '';
                    if($jseo_cat_slug == $jseo_filterparam) {
                        $jseo_cat_class = 'active';
                        $jseo_hoverDescription = $jseo_cat_name . ' projects are being displayed.';
                        $jseo_has_cat = true;
                        $jseo_currentopt_name = $jseo_cat_name;
                    }

                    $jseo_catui_output .= '<a class="' . $jseo_cat_class . '" data-slug="' . $jseo_cat_slug . '" href="javascript:void(0);">' . $jseo_cat_name . '</a>';
                }
            }
         }

         $jseo_catui_output .= '</div>';


         if($jseo_has_cat == false) {
             $jseo_filterparam = 'all';
             $jseo_hoverDescription = 'Something weird happened...';
             $jseo_currentopt_name = 'All';
         }

        $jseo_markdown = '<div class="jseo_portfolio" id="jseo_portfolio">
        <div class="jseo_portfolio_controls">
            <div class="jseo_pcontrols_left">
                <button type="button" class="jseo_portfolio_opt" id="jseo_portfolio_prevOpt"><img class="jseo_portfolio_opt_img" src="' . get_stylesheet_directory_uri() . '/img/button_left.png"></button>
                <button type="button" id="jseo_portfolio_all" class="jseo_portfolio_select">' . 
                    $jseo_currentopt_name . 
                    '<div class="jseo_portofolio_description"><span>' . $jseo_hoverDescription . '</span></div>
                </button>
                <button type="button" class="jseo_portfolio_opt" id="jseo_portfolio_nextOpt"><img class="jseo_portfolio_opt_img" src="' . get_stylesheet_directory_uri() . '/img/button_right.png"></button>
            </div>
            <div class="jseo_pcontrols_right">' .
                $jseo_catui_output .
            '</div>
        </div>
        <div id="jseo_portfolio_content" class="jseo_portfolio_content">';

        // $args['category_name']   = 'featured';

        // $the_query = new WP_Query(array('post_type' => 'portfolio', 
        //     'posts_per_page' => 12, 
        //     'post_status' => 'publish',
        //     'paged' => get_query_var('paged') ? get_query_var('paged') : 1 )
        // );

        // if ($the_query->have_posts()) {

        //     while ($the_query->have_posts()) {

        //         $the_query->the_post() ;
        //         $the_id = get_the_ID();
        //         $the_featured_image = get_the_post_thumbnail_url($the_id);
        //         $the_permalink = get_permalink($the_id);
        //         $the_title = get_the_title($the_id);

        //         if(isset($the_featured_image)) {
        //             $jseo_markdown .= '<div class="jseo_column"><a href="' . $the_permalink . '"><img src="' . $the_featured_image . '"><span class="jseo_portfolio_title">' . $the_title . '</span></a></div>';
        //         }

        //     }

        // }

        

        // $big = 999999999;

        $jseo_markdown .= '</div></div>';
        $jseo_markdown .= '<div id="jseo_pagination" class="jseo_pagination">';
        // $jseo_markdown .= paginate_links( array(
        //     'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
        //     'format' => '?paged=%#%',
        //     'current' => max( 1, get_query_var('paged') ),
        //     'total' => $the_query->max_num_pages,
        //     'prev_text'    => __('<'),
        //     'next_text'    => __('>')
        // ));
        $jseo_markdown .= '</div>';
         wp_reset_postdata();
        return $jseo_markdown;
    }

    add_shortcode('jseoshow', 'jseo_show_function');
?>