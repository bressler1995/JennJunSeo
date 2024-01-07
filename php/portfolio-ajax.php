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
            if($request_filter == 'uiux-design') {
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
                $the_post = get_post($the_id);
                $is_protected = false;
                $the_featured_image = get_the_post_thumbnail_url($the_id);
                $the_permalink = get_permalink($the_id);
                $the_title = get_the_title($the_id);
                $the_excerpt = get_the_excerpt($the_id);
                $the_date = get_the_date('Y-m-d', $the_id);
                $the_author_id = get_post_field( 'post_author', $the_id );
                $the_author_name = get_the_author_meta('display_name', $the_author_id);

                $the_current_terms = get_the_terms($the_id, 'portfolio_category');
                $the_terms_string = join(', ', wp_list_pluck($the_current_terms, 'name'));
                $has_article = 'false';

                if(!empty($the_post->post_password)) {
                    $is_protected = true;
                }

                if(str_contains($the_terms_string, 'UI/UX Design')) {
                    $has_article = 'true';
                }

                if(str_contains($the_terms_string, 'Games')) {
                    $has_article = 'true';
                }

                if($the_date == false) {
                    $the_date = 'Date Missing';
                }

                $the_custom_file = get_field('custom_file', $the_id);
                $the_video = get_field('the_video', $the_id);
                $the_lightbox_description = get_field('lightbox_description', $the_id);
                $the_brightness = get_field('brightness', $the_id);
                $the_mini_banner = get_field('mini_banner', $the_id);
                $the_content_cneeds = get_field('content_fields', $the_id);

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

                if($the_lightbox_description) {
                    $the_lightbox_description = $the_lightbox_description;
                } else {
                    $the_lightbox_description = -1;
                }

                if($the_mini_banner) {
                    $the_mini_banner_companydesc = $the_mini_banner['mbanner_company_description'];

                    if($the_mini_banner_companydesc != '' && empty($the_mini_banner_companydesc) == false && isset($the_mini_banner_companydesc) == true) {
                        if($is_protected == true) {
                            $the_mini_banner = 'This post is protected for security reasons, possibly due to the presence of sensitive information covered by a Non-Disclosure Agreement (NDA) or other confidentiality measures. To access the content, please click on the post and enter the password that has been sent to you.';
                        } else {
                            $the_mini_banner = $the_mini_banner_companydesc;
                        }
                    } else {
                        $the_mini_banner = -1;  
                    }
                } else {
                    $the_mini_banner = -1;
                }

                if($the_content_cneeds) {
                    $temp_cneeds = $the_content_cneeds['client_needs'];

                    if($temp_cneeds != '' && empty($temp_cneeds) == false && isset($temp_cneeds) == true) {
                        $temp_cneeds_content = $temp_cneeds['client_needs_content'];

                        if($temp_cneeds_content != '' && empty($temp_cneeds_content) == false && isset($temp_cneeds_content) == true) {
                            $noimages = preg_replace("/<img[^>]+\>/i", "(image) ", $temp_cneeds_content); 
                            $the_content_cneeds = strip_tags($noimages);
                        } else {
                            $the_content_cneeds = -1;  
                        }
                        
                    } else {
                        $the_content_cneeds = -1;  
                    }
                } else {
                    $the_content_cneeds = -1;
                }

                if($the_brightness) {
                    $the_brightness = $the_brightness;
                } else {
                    $the_brightness = 100;
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
                        "the_lightbox_description"=>$the_lightbox_description,
                        "the_brightness"=>$the_brightness,
                        'the_company_description'=>$the_mini_banner,
                        'the_client_needs'=>$the_content_cneeds,
                        "the_date"=>$the_date,
                        "the_author"=>$the_author_name,
                        'has_article'=>$has_article
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