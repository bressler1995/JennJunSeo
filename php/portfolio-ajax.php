<?php
    require_once("../../../../wp-load.php");

    $request_filter = urldecode($_POST['filter']);
    $jseo_taxcategories = get_terms( array(
        'taxonomy' => 'portfolio_category',
        'hide_empty' => false,
    ));

    $jseo_category_exists = false;
    $jseo_request_set = false;
    $jseo_catname_array = array();
    $jseo_catslug_array = array();
    $jseo_entrymax = 12;

    if(!empty($request_filter)) {
        $jseo_request_set = true;
        if ( !empty($jseo_taxcategories) ) {
            foreach( $jseo_taxcategories as $category ) {
                if( $category->parent == 0 ) {
                    array_push($jseo_catname_array, $category->name);
                    array_push($jseo_catslug_array, $category->slug);
                }
            }
         }
    
        if($request_filter == 'all') {
            $jseo_category_exists = true;
        } else {
            if($request_filter == 'motion-design') {
                $jseo_entrymax = 6;
            }

            for($x = 0; $x < count($jseo_catslug_array); $x++) {
                if($request_filter == $jseo_catslug_array[$x]) {
                   $jseo_category_exists = true;
                }
            }
        }
    }
     
    if($jseo_category_exists == true && $jseo_request_set == true) {
        $jseo_post_storage = array();
        $inner_tax = array();

        if($request_filter != 'all') {
            $inner_tax = array (
                'taxonomy' => 'portfolio_category',
                'field' => 'slug',
                'terms' => $request_filter,
            );
        }

        if(count($inner_tax) > 0) {
            $paginated_query = new WP_Query(array('post_type' => 'portfolio', 
                'posts_per_page' => $jseo_entrymax, 
                'post_status' => 'publish',
                'tax_query' => array($inner_tax),
                'paged' => get_query_var('paged') ? get_query_var('paged') : 1
            ));

            $full_query = new WP_Query(array('post_type' => 'portfolio', 
                    'posts_per_page' => -1, 
                    'post_status' => 'publish',
                    'tax_query' => array($inner_tax)
            ));
        } else {
            $paginated_query = new WP_Query(array('post_type' => 'portfolio', 
                'posts_per_page' => $jseo_entrymax, 
                'post_status' => 'publish',
                'paged' => get_query_var('paged') ? get_query_var('paged') : 1
            ));

            $full_query = new WP_Query(array('post_type' => 'portfolio', 
                    'posts_per_page' => -1, 
                    'post_status' => 'publish'
            ));
        }

        if ($paginated_query->have_posts()) {

            while ($paginated_query->have_posts()) {

                $paginated_query->the_post();

                // $the_post_object = array();
                // $the_id = get_the_ID();
                // $the_featured_image = get_the_post_thumbnail_url($the_id);
                // $the_permalink = get_permalink($the_id);
                // $the_title = get_the_title($the_id);

                // if(isset($the_featured_image)) {
                //     // $jseo_markdown .= '<div class="jseo_column"><a href="' . $the_permalink . '"><img src="' . $the_featured_image . '"><span class="jseo_portfolio_title">' . $the_title . '</span></a></div>';
                //     array_push($the_post_object, $the_id);
                //     array_push($the_post_object, $the_featured_image);
                //     array_push($the_post_object, $the_permalink);
                //     array_push($the_post_object, $the_title);
                //     array_push($jseo_post_storage, $the_post_object);
                // }

            }

        }

        $big = 999999999; // need an unlikely integer
        $jseo_ajax_pagination_max = $paginated_query->max_num_pages;
        // $jseo_ajax_pagination_max = paginate_links( array(
        //     'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
        //     'format' => '?paged=%#%',
        //     'current' => max( 1, get_query_var('paged') ),
        //     'total' => $the_query->max_num_pages,
        //     'prev_text'    => __('<'),
        //     'next_text'    => __('>')
        // ));

        wp_reset_postdata();
        
        $object_result = 0;
        if ($full_query->have_posts()) {
            while ($full_query->have_posts()) {
                $full_query->the_post();

                $the_post_object = array();
                $the_id = get_the_ID();
                $the_featured_image = get_the_post_thumbnail_url($the_id);
                $the_permalink = get_permalink($the_id);
                $the_title = get_the_title($the_id);
                $the_excerpt = get_the_excerpt($the_id);
                $the_date = get_the_date('Y-m-d', $the_id);
                $the_author_id = get_post_field( 'post_author', $the_id );
                $the_author_name = get_the_author_meta('display_name', $the_author_id);

                if($the_date == false) {
                    $the_date = 'Date Missing';
                }

                $the_custom_file = get_field('custom_file', $the_id);
                $the_video = get_field('the_video', $the_id);
                $the_gallery_array = get_field('gallery_images', $the_id);
                $the_gallery_count = 0;

                if($the_custom_file) {
                    $the_custom_file = $the_custom_file;
                } else {
                    $the_custom_file = -1;
                }

                if($the_video) {
                    $the_video = $the_video;
                } else {
                    $the_video = -1;
                }

                if(empty($the_gallery_array) == false && isset($the_gallery_array)) {
                    $the_gallery_count = count($the_gallery_array);
                }

                if(isset($the_featured_image)) {
                    // $jseo_markdown .= '<div class="jseo_column"><a href="' . $the_permalink . '"><img src="' . $the_featured_image . '"><span class="jseo_portfolio_title">' . $the_title . '</span></a></div>';
                    $the_post_object = array(
                        "the_id"=>$the_id,
                        "the_featured_image"=>$the_featured_image,
                        "the_permalink"=>$the_permalink,
                        "the_title"=>$the_title,
                        "the_excerpt"=>$the_excerpt,
                        "the_custom_file"=>$the_custom_file,
                        "the_video"=>$the_video,
                        "the_gallery_count"=>$the_gallery_count,
                        "the_date"=>$the_date,
                        "the_author"=>$the_author_name
                    );
    
                    array_push($jseo_post_storage, $the_post_object);
                }
            }
            
            $jseo_full_storage = array(
                "pagination_max"=>$jseo_ajax_pagination_max,
                "entry_max"=>$jseo_entrymax,
                "post_storage"=>$jseo_post_storage
            );
            
            $object_result = json_encode($jseo_full_storage);
        }

        echo $object_result;

    } else {
        echo -1;
    }
     

?>