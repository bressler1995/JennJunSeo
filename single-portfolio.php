<?php
/**
 * The template for displaying singular post-types: posts, pages and user-defined custom post types.
 *
 * @package HelloElementor
 */

    if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly.
    }

    get_header();


    while ( have_posts() ) :
        the_post();
        $the_id = get_the_ID();
        $the_title = get_the_title();
        $the_featured_image = get_the_post_thumbnail_url($the_id,'full');
        $author_id = get_post_field( 'post_author', $the_id );
        $author_name = get_the_author_meta('display_name');
        $the_date = get_the_date("m/d/Y", $the_id );

        $jseo_term_args = array(
            'taxonomy' => 'portfolio_category',
            'hide_empty' => false,
        );

        $jseo_taxcategories = get_terms($jseo_term_args);
        $custom_slug_order = 'UI/UX Design, Graphic Design, Motion Design';
        $jseo_customordered_terms = get_terms_ordered( 'portfolio_category', $jseo_term_args, $custom_slug_order, 'name');
        
        $the_terms = get_terms(array(
            'taxonomy' => 'portfolio_category',
            'hide_empty' => false,
        ));


        //Hero Variables
        $the_custom_image = '';
        $the_custom_overlay = '';

        //Min Banner Variables
        $mb_background_color = '';
        $mb_text_color = '';
        $mb_company_description = '';
        $mb_transparent_image = '';

        //Sidebar Categories
        $the_portfolio_names = array();
        $the_portfolio_links = array();

        //Introductory Information
        $intro_role = '';
        $intro_collab = '';
        $intro_programs = '';
        $intro_timeline = '';

        $intro_role_output = '';
        $intro_collab_output = '';
        $intro_programs_output = '';
        $intro_timeline_output = '';

        //Content Fields
        $content_client_needs = '';
        $content_the_problem = '';
        $content_solution = '';
        $content_research = '';
        $content_user_study = '';
        $content_branding = '';
        $content_wireframes = '';
        $content_design_iterations = '';
        $content_mockups = '';
        $content_results = '';
        $content_final_thoughts = '';

        $content_client_needs_output = '';
        $content_the_problem_output = '';
        $content_solution_output = '';
        $content_research_output = '';
        $content_user_study_output = '';
        $content_branding_output = '';
        $content_wireframes_output = '';
        $content_design_iterations_output = '';
        $content_mockups_output = '';
        $content_results_output = '';
        $content_final_thoughts_output = '';

        $clientneeds_displayed = false;
        $theproblem_displayed = false;
        $solution_displayed = false;
        $research_displayed = false;
        $userstudy_displayed = false;
        $branding_displayed = false;
        $wireframes_displayed = false;
        $results_displayed = false;

        for($x = 0; $x < count($jseo_customordered_terms); $x++) {
            // echo d($jseo_customordered_terms[$x]);

            $the_current = $jseo_customordered_terms[$x];
            $the_name = $the_current->name;
            $the_meta_id = $the_current->term_id;
            $the_term_meta = get_term_meta($the_meta_id);
            $the_portfolio_slug = $the_term_meta['portfolio_slug'][0];
            array_push($the_portfolio_names, $the_name);
            array_push($the_portfolio_links, $the_portfolio_slug);
            

            // echo d($the_term_meta);
            // echo $the_portfolio_slug;
            // $the_current->field('portfolio_slug');
        }


        if( have_rows('hero_section')) {
            while(have_rows('hero_section') ) {
                    the_row();
                    $the_custom_image = get_sub_field('custom_background_image');
                    $the_custom_overlay = get_sub_field('custom_overlay_opacity');
            } 

        }

        if( have_rows('mini_banner')) {
            while(have_rows('mini_banner') ) {
                    the_row();
                    $mb_background_color = get_sub_field('mbanner_background_color');
                    $mb_text_color = get_sub_field('mbanner_text_color');
                    $mb_company_description = get_sub_field('mbanner_company_description');
                    $mb_transparent_image = get_sub_field('mbanner_transparent_image');
            } 

        }

        if( have_rows('introductory_information')) {
            while(have_rows('introductory_information')) {
                the_row();
                $intro_role = get_sub_field('intro_role');
                $intro_collab = get_sub_field('intro_collab');
                $intro_programs = get_sub_field('intro_programs');
                $intro_timeline = get_sub_field('intro_timeline');
            }
        }

        if( have_rows('content_fields')) {
            while(have_rows('content_fields')) {
                the_row();
                $content_client_needs = get_sub_field('client_needs');
                $content_the_problem = get_sub_field('the_problem');
                $content_solution = get_sub_field('solution');
                $content_research = get_sub_field('research');
                $content_user_study = get_sub_field('user_study');
                $content_branding = get_sub_field('branding');
                $content_wireframes = get_sub_field('wireframes');
                $content_design_iterations = get_sub_field('design_iterations');
                $content_mockups = get_sub_field('mockups');
                $content_results = get_sub_field('results');
                $content_final_thoughts = get_sub_field('final_thoughts');
            }

            //WYSIWYG
            if($content_client_needs == '' || empty($content_client_needs) == true || isset($content_client_needs) == false) {
                $content_client_needs_output = '';
            } else {
                $clientneeds_displayed = true;
                $content_client_needs_output .= '<div class="jseo_content_standard_text" id="clientsneeds">';
                $content_client_needs_output .= "<h3>Client's Needs</h3>";
                $content_client_needs_output .= '<div class="contentspace">' . $content_client_needs . '</div>';
                $content_client_needs_output .= '</div>';
            }

            //Problem 2 Columns
            if($content_the_problem == '' || empty($content_the_problem) == true || isset($content_the_problem) == false) {
                $content_the_problem_output = '';
            } else {

                $content_present = false;
                $content_screen_present = false;
                $content_problem_pass = false;
                $temp_problem_caption = -1;
                $temp_problem_caption_output = '';

                if($content_the_problem['problem_content'] != '' && empty($content_the_problem['problem_content']) == false && isset($content_the_problem['problem_screenshot']) == true) {
                    $content_present = true;
                }

                if($content_the_problem['problem_screenshot'] != '' && empty($content_the_problem['problem_screenshot']) == false && isset($content_the_problem['problem_screenshot']) == true) {
                    $content_screen_present = true;
                }

                if($content_the_problem['problem_screenshot_caption'] != '' && empty($content_the_problem['problem_screenshot_caption']) == false && isset($content_the_problem['problem_screenshot_caption']) == true) {
                    $temp_problem_caption = $content_the_problem['problem_screenshot_caption'];
                    $temp_problem_caption_output = '<p class="the_problem_caption">' . $temp_problem_caption . '</p>';
                }

                if($content_present == true && $content_screen_present == true) {
                    $content_problem_pass = true;
                }

                if($content_problem_pass == true) {
                    $theproblem_displayed = true;

                    $content_the_problem_output .= '<div class="jseo_content_problem" id="theproblem">
                        <div class="jseo_content_problem_col">
                             <h3 class="maintitle">The Problem</h3>' 
                            . $content_the_problem['problem_content'] . 
                        '</div>
                        <div class="jseo_content_problem_col">
                            <a data-title="The Problem" data-cfile="-1" data-video="-1" data-featured="'. $content_the_problem['problem_screenshot'] . '" data-desc="' . $temp_problem_caption . '" data-hasarticle="false" data-permalink="-1" class="single_lightboxitem" href="javascript:void(0)"><img src="' . $content_the_problem['problem_screenshot'] . '"></a>' . 
                            $temp_problem_caption_output . 
                        '</div>
                    </div>';
                } else {
                    $content_the_problem_output = '';
                }

                
            }

            //WYSIWYG
            if($content_solution == '' || empty($content_solution) == true || isset($content_solution) == false) {
                $content_solution_output = '';
            } else {
                $solution_displayed = true;
                $content_solution_output .= '<div class="jseo_content_standard_text" id="solution">';
                $content_solution_output .= "<h3>Solution</h3>";
                $content_solution_output .= '<div class="contentspace">' . $content_solution . '</div>';
                $content_solution_output .= '</div>';
            }

            //WYSIWYG
            if($content_research == '' || empty($content_research) == true || isset($content_research) == false) {
                $content_research_output = '';
            } else {
                $research_displayed = true;
                $content_research_output .= '<div class="jseo_content_standard_text" id="research">';
                $content_research_output .= "<h3>Research</h3>";
                $content_research_output .= '<div class="contentspace">' . $content_research . '</div>';
                $content_research_output .= '</div>';
            }

            //WYSIWYG with images
            if($content_user_study == '' || empty($content_user_study) == true || isset($content_user_study) == false) {
                $content_user_study_output = '';
            } else {
                $study_content = $content_user_study['user_study_content'];
                $study_images = $content_user_study['user_study_images'];

                if(empty($study_content) == false && $study_content != '' && isset($study_content) == true) {
                    $userstudy_displayed = true;
                    //only needs to have content present to display
                    $content_user_study_output .= '<div class="jseo_content_w_image" id="userstudy">';
                    $content_user_study_output .= '<h3 class="maintitle">User Study</h3>';
                    $content_user_study_output .= '<div class="contentwidget">' . $study_content . '</div>';

                    if(empty($study_images) == false && isset($study_images) == true) {
                        if(count($study_images) > 0) {
                            $content_user_study_output .= '<div class="jseo_contentwimg_gallery">';
                            for($y = 0; $y < count($study_images); $y++) {
                                $content_user_study_output .= '<a data-title="User Study ' . ($y + 1) . '" data-cfile="-1" data-video="-1" data-featured="' . $study_images[$y]['url'] . '" data-desc="-1" data-hasarticle="false" data-permalink="-1" class="single_lightboxitem" href="javascript:void(0)"><img src="' . $study_images[$y]['url'] . '"></a>';
                            }
                            $content_user_study_output .= '</div>';
                        }
                    }

                    $content_user_study_output .= '</div>';
                }

            }

            //WYSIWYG with images
            if($content_branding == '' || empty($content_branding) == true || isset($content_branding) == false) {
                $content_branding_output = '';
            } else {
                $the_content = $content_branding['branding_content'];
                $the_images = $content_branding['branding_images'];

                if(empty($the_content) == false && $the_content != '' && isset($the_content) == true) {
                    $branding_displayed = true;
                    //only needs to have content present to display
                    $content_branding_output .= '<div class="jseo_content_w_image" id="branding">';
                    $content_branding_output .= '<h3 class="maintitle">Branding</h3>';
                    $content_branding_output .= '<div class="contentwidget">' . $the_content . '</div>';

                    if(empty($the_images) == false && isset($the_images) == true) {
                        if(count($the_images) > 0) {
                            $content_branding_output .= '<div class="jseo_contentwimg_gallery">';
                            for($w = 0; $w < count($the_images); $w++) {
                                $content_branding_output .= '<a data-title="Branding ' . ($w + 1) . '" data-cfile="-1" data-video="-1" data-featured="' . $the_images[$w]['url'] . '" data-desc="-1" data-hasarticle="false" data-permalink="-1" class="single_lightboxitem" href="javascript:void(0)"><img src="' . $the_images[$w]['url'] . '"></a>';
                            }
                            $content_branding_output .= '</div>';
                        }
                    }

                    $content_branding_output .= '</div>';
                }

            }

             //WYSIWYG with images
             if($content_wireframes == '' || empty($content_wireframes) == true || isset($content_wireframes) == false) {
                $content_wireframes_output = '';
            } else {
                $the_content = $content_wireframes['wireframes_content'];
                $the_images = $content_wireframes['wireframes_images'];

                if(empty($the_content) == false && $the_content != '' && isset($the_content) == true) {
                    $wireframes_displayed = true;
                    $content_wireframes_output .= '<div class="jseo_content_w_image" id="wireframes">';
                    //only needs to have content present to display
                    $content_wireframes_output .= '<h3 class="maintitle">Wireframes</h3>';
                    $content_wireframes_output .= '<div class="contentwidget">' . $the_content . '</div>';

                    if(empty($the_images) == false && isset($the_images) == true) {
                        if(count($the_images) > 0) {
                            $content_wireframes_output .= '<div class="jseo_contentwimg_gallery">';
                            for($w = 0; $w < count($the_images); $w++) {
                                $content_wireframes_output .= '<a data-title="Wireframes ' . ($w + 1) . '" data-cfile="-1" data-video="-1" data-featured="' . $the_images[$w]['url'] . '" data-desc="-1" data-hasarticle="false" data-permalink="-1" class="single_lightboxitem" href="javascript:void(0)"><img src="' . $the_images[$w]['url'] . '"></a>';
                            }
                            $content_wireframes_output .= '</div>';
                        }
                    }

                    $content_wireframes_output .= '</div>';
                }

                
            }

             //WYSIWYG with images
             if($content_design_iterations == '' || empty($content_design_iterations) == true || isset($content_design_iterations) == false) {
                $content_design_iterations_output = '';
            } else {
                $the_content = $content_design_iterations['design_iterations_content'];
                $the_images = $content_design_iterations['design_iterations_images'];

                if(empty($the_content) == false && $the_content != '' && isset($the_content) == true) {
                    //only needs to have content present to display
                    $content_design_iterations_output .= '<div class="jseo_content_w_image" id="designiterations">';
                    $content_design_iterations_output .= '<h3 class="maintitle">Design Iterations</h3>';
                    $content_design_iterations_output .= '<div class="contentwidget">' . $the_content . '</div>';

                    if(empty($the_images) == false && isset($the_images) == true) {
                        if(count($the_images) > 0) {
                            $content_design_iterations_output .= '<div class="jseo_contentwimg_gallery">';
                            for($w = 0; $w < count($the_images); $w++) {
                                $content_design_iterations_output .= '<a data-title="Design Iterations ' . ($w + 1) . '" data-cfile="-1" data-video="-1" data-featured="' . $the_images[$w]['url'] . '" data-desc="-1" data-hasarticle="false" data-permalink="-1" class="single_lightboxitem" href="javascript:void(0)"><img src="' . $the_images[$w]['url'] . '"></a>';
                            }
                            $content_design_iterations_output .= '</div>';
                        }
                    }

                    $content_design_iterations_output .= '</div>';
                }
                
            }

            //WYSIWYG with images
            if($content_mockups == '' || empty($content_mockups) == true || isset($content_mockups) == false) {
                $content_mockups_output = '';
            } else {
                $the_content = $content_mockups['mockups_content'];
                $the_images = $content_mockups['mockups_images'];

                if(empty($the_content) == false && $the_content != '' && isset($the_content) == true) {
                    //only needs to have content present to display
                    $content_mockups_output .= '<div class="jseo_content_w_image" id="mockup">';
                    $content_mockups_output .= '<h3 class="maintitle">Mock-Up</h3>';
                    $content_mockups_output .= '<div class="contentwidget">' . $the_content . '</div>';

                    if(empty($the_images) == false && isset($the_images) == true) {
                        if(count($the_images) > 0) {
                            $content_mockups_output .= '<div class="jseo_contentwimg_gallery">';
                            for($w = 0; $w < count($the_images); $w++) {
                                $content_mockups_output .= '<a data-title="Mockup ' . ($w + 1) . '" data-cfile="-1" data-video="-1" data-featured="' . $the_images[$w]['url'] . '" data-desc="-1" data-hasarticle="false" data-permalink="-1" class="single_lightboxitem" href="javascript:void(0)"><img src="' . $the_images[$w]['url'] . '"></a>';
                            }
                            $content_mockups_output .= '</div>';
                        }
                    }

                    $content_mockups_output .= '</div>';
                }

            }

            //WYSIWYG
            if($content_results == '' || empty($content_results) == true || isset($content_results) == false) {
                $content_results_output = '';
            } else {
                $results_displayed = true;
                $content_results_output .= '<div class="jseo_content_standard_text" id="results">';
                $content_results_output .= "<h3>Results</h3>";
                $content_results_output .= '<div class="contentspace">' . $content_results . '</div>';
                $content_results_output .= '</div>';
            }

            //WYSIWYG
            if($content_final_thoughts == '' || empty($content_final_thoughts) == true || isset($content_final_thoughts) == false) {
                $content_final_thoughts_output = '';
            } else {
                $content_final_thoughts_output .= '<div class="jseo_content_standard_text" id="finalthoughts">';
                $content_final_thoughts_output .= "<h3>Final Thoughts</h3>";
                $content_final_thoughts_output .= '<div class="contentspace">' . $content_final_thoughts . '</div>';
                $content_final_thoughts_output .= '</div>';
            }


        }

        
        if($mb_background_color == '' || empty($mb_background_color) == true) {
            $mb_background_color = "#4AB0ED";
        }

        if($mb_text_color == '' || empty($mb_text_color) == true) {
            $mb_text_color = "#FFFFFF";
        }

        if($mb_company_description == '' || empty($mb_company_description) == true) {
            $mb_company_description = "No description provided...";
        }

        if($mb_transparent_image == '' || empty($mb_transparent_image) == true) {
            $mb_transparent_image = get_stylesheet_directory_uri() . '/img/computer.png';
        }

        if($intro_role == '' || empty($intro_role) == true) {
            $intro_role_output = '<p class="nointro">No role items found.</p>';
        } else {
            if($intro_role) {
                $intro_role_output .= '<ul>';
                foreach($intro_role as $irole) {
                    $intro_role_output .= '<li>' . $irole['role_name'] . '</li>';
                }

                $intro_role_output .= '</ul>';
            }
        }

        if($intro_collab == '' || empty($intro_collab) == true) {
            $intro_collab_output = '<p class="nointro">No collaboration items found.</p>';
        } else {
            if($intro_collab) {
                $intro_collab_output .= '<ul>';
                foreach($intro_collab as $icoll) {
                    $intro_collab_output .= '<li>' . $icoll['collab_name'] . '</li>';
                }

                $intro_collab_output .= '</ul>';
            }
        }

        if($intro_programs == '' || empty($intro_programs) == true) {
            $intro_programs_output = '<p class="nointro">No program items found.</p>';
        } else {
            if($intro_programs) {
                $intro_programs_output .= '<ul>';
                foreach($intro_programs as $ipro) {
                    $intro_programs_output .= '<li>' . $ipro['program_name'] . '</li>';
                }

                $intro_programs_output .= '</ul>';
            }
        }

        if($intro_timeline == '' || empty($intro_timeline) == true) {
            $intro_timeline_output = '<p class="nointro">No timeline found.</p>';
        } else {
            $intro_timeline_output = '<p class="nointro">' . $intro_timeline . '</p>';
        }

        if($the_custom_overlay != -1 && $the_custom_overlay != '-1' && $the_custom_overlay != 0 && $the_custom_overlay != '0' && empty($the_custom_overlay == false)) {
            $the_custom_overlay = ((int)$the_custom_overlay) / 100;
        } else {
            $the_custom_overlay = '0.85';
        }

        if(empty($the_custom_image) == true || isset($the_custom_image) == false || $the_custom_image == "") {
            $the_custom_image = get_stylesheet_directory_uri() . '/img/singleportplaceholder.jpg';
        }

?>
    <div style="background-image: url(<?php echo $the_custom_image ?>) !important;" class="jseo_single_hero">
        <div class="hero_overlay" style="opacity: <?php echo $the_custom_overlay ?> !important;"></div>
        <div class="jseo_single_container">
            <h1><?php echo $the_title ?></h1>
            <div class="jseo_single_meta">
                <div class="jseo_single_metaitem"><img src="<?php echo get_stylesheet_directory_uri() . '/svg/user.svg' ?>"><span><?php echo $author_name ?></span></div>
                <div class="jseo_single_metaitem"><img src="<?php echo get_stylesheet_directory_uri() . '/svg/calendar.svg' ?>"><span><?php echo  $the_date ?></span></div>
            </div>
        </div>
    </div>
    
    <div id="jseo_single_content" class="jseo_single_content">
        <div class="jseo_single_container">
               <div class="jseo_single_content_sidebar hideondesktoptablet">
                         
                        <div class="jseo_single_sideitem">
                            <h3>Search Projects</h3>
                            <div class="jseo_single_sidedivider">
                                <div class="shapecontain"><span></span></div>
                                <div class="shapecontain"><span></span></div>
                                <div class="shapecontain"><span></span></div>
                            </div>
                            <div class="jseo_single_sidewidget">
                                <div class="jseo_single_search">
                                    <?php echo do_shortcode('[elementor-template id="991"]'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="jseo_single_sideitem">
                            <h3>Categories</h3>
                            <div class="jseo_single_sidedivider">
                                <div class="shapecontain"><span></span></div>
                                <div class="shapecontain"><span></span></div>
                                <div class="shapecontain"><span></span></div>
                            </div>
                            <div class="jseo_single_sidewidget">
                                <div class="jseo_single_cats">
                                    <?php 
                                        for($z = 0; $z < count($the_portfolio_names); $z++) {
                                            echo '<a href="' . $the_portfolio_links[$z] . '">' . $the_portfolio_names[$z] . '</a>';
                                        }

                                    wp_reset_postdata();
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="jseo_single_related">
                        <?php
                            $related_args = array(
                                'post_type' => 'portfolio',
                                'posts_per_page' => 5,
                                'tax_query' => array(
                                            array(
                                                'taxonomy' => 'portfolio_category',
                                                'field' => 'slug',
                                                'terms' => 'uiux-design',
                                            )
                                        ),
                                        'orderby' => 'rand',
                            );
                            $related = new WP_Query( $related_args );
                            $related_output = '';
                                    
                            if( $related->have_posts() ) {
                                echo '<h3>Related Work</h3>';
                                echo '<div class="jseo_single_sidedivider">
                                    <div class="shapecontain"><span></span></div>
                                    <div class="shapecontain"><span></span></div>
                                    <div class="shapecontain"><span></span></div>
                                </div>';
                                        
                                        while($related->have_posts()) {
                                            $related->the_post();
                                            $the_related_id = get_the_id();
                                            $the_related_permalink = get_the_permalink();
                                            $the_related_title = get_the_title();
                                            $the_company_description = '';
                                            $mini_banner = get_field('mini_banner', $the_related_id);
                                            $the_related_date = get_the_date("m/d/Y", $the_related_id );
                                            $author_rel_id = get_post_field( 'post_author', $the_related_id );
                                            $author_rel_name = get_the_author_meta('display_name');

                                            if(($mini_banner)) {
                                                
                                                $the_company_description = $mini_banner['mbanner_company_description'];
                                            }

                                            if($the_company_description != '' && empty($the_company_description) == false) {
                                                $the_company_description = (strlen($the_company_description) > 60) ? substr($the_company_description,0,60).'...' : $the_company_description;
                                            } else {
                                                $the_company_description = 'No company description provided...';
                                            }
                                            
                                            if(has_post_thumbnail($the_related_id)) {
                                                $the_related_thumb = get_the_post_thumbnail_url($the_related_id, 'thumbnail');
                                                $related_output .= '<div class="jseo_related_item">';
                                                $related_output .= '<div class="the_related_image"><a href="' . $the_related_permalink . '" class="jseo_related_linkimage"><img src="' . $the_related_thumb . '"></a></div>';
                                                $related_output .= '<div class="the_related_content">';
                                                $related_output .= '<a href="' . $the_related_permalink . '" class="jseo_related_link">' . $the_related_title . '</a>';
                                                $related_output .= '<p class="jseo_related_excerpt">' . $the_company_description . '</p>';
                                                $related_output .= '<div class="jseo_related_meta">
                                                    <span><img src="' . get_stylesheet_directory_uri() . '/svg/calendar.svg">' . $the_related_date . '</span>
                                                    <span><img src="' . get_stylesheet_directory_uri() . '/svg/user.svg">' . $author_rel_name . '</span>
                                                </div>';
                                                $related_output .= '</div></div>';
                                            }
                                            
                                        }
                                
                                    }
                                    
                                    echo $related_output;
                                    wp_reset_postdata();
                                ?>
                        </div>

            </div>
            <div class="jseo_single_content_text">
                <div class="jseo_about_whole">
                    <div style="background-color: <?php echo $mb_background_color ?>;" class="jseo_minibanner" id="about">
                        <div class="jseo_mb_col">
                            <h4 style="color: <?php echo $mb_text_color ?>;">About The Company</h4>
                            <p style="color: <?php echo $mb_text_color ?>;"><?php echo $mb_company_description ?></p>
                        </div>
                        <div class="jseo_mb_col"><img src="<?php echo $mb_transparent_image ?>"></div>
                    </div>
                    <div class="jseo_single_intro">
                        <div class="jseo_single_intro_col">
                            <h5>Role</h5>
                            <?php echo $intro_role_output ?>
                        </div>
                        <div class="jseo_single_intro_col">
                            <h5>Collaboration</h5>
                            <?php echo $intro_collab_output ?>
                        </div>
                        <div class="jseo_single_intro_col">
                            <h5>Programs</h5>
                            <?php echo $intro_programs_output ?>
                        </div>
                        <div class="jseo_single_intro_col">
                            <h5>Timeline</h5>
                            <?php echo $intro_timeline_output ?>
                        </div>
                    </div>
                </div>
                
                <?php
                    echo $content_client_needs_output;
                    echo $content_the_problem_output;
                    echo $content_solution_output;
                    echo $content_research_output;
                    echo $content_user_study_output;
                    echo $content_branding_output;
                    echo $content_wireframes_output;
                    echo $content_design_iterations_output;
                    echo $content_mockups_output;
                    echo $content_results_output;
                    echo $content_final_thoughts_output;
                ?>
            </div>

            <div class="jseo_single_content_sidebar">
                <div class="jseo_single_sideitem reduce_sidewidget_onmobile">
                    <h3>Content Navigation</h3>
                    <div class="jseo_single_sidedivider">
                        <div class="shapecontain"><span></span></div>
                        <div class="shapecontain"><span></span></div>
                        <div class="shapecontain"><span></span></div>
                    </div>
                    <div class="jseo_single_sidewidget">
                        <div class="jseo_single_cnav">
                            
                            <a href="#about">
                                <span>About</span>
                                <img src="<?php echo get_stylesheet_directory_uri() . '/svg/anchorgo.svg' ?>">
                            </a>

                            <?php 
                                $clientneeds_classes = '';
                                $the_problem_classes = '';
                                $solution_classes = '';
                                $research_classes = '';
                                $userstudy_classes = '';
                                $branding_classes = '';
                                $wireframes_classes = '';
                                $results_classes = '';

                                if($clientneeds_displayed == false) {
                                    $clientneeds_classes = 'hideme';
                                }

                                if($theproblem_displayed == false) {
                                    $the_problem_classes = 'hideme';
                                }

                                if($solution_displayed == false) {
                                    $solution_classes = 'hideme';
                                }

                                if($research_displayed == false) {
                                    $research_classes = 'hideme';
                                }

                                if($userstudy_displayed == false) {
                                    $userstudy_classes = 'hideme';
                                }

                                if($branding_displayed == false) {
                                    $branding_classes = 'hideme';
                                }

                                if($wireframes_displayed == false) {
                                    $wireframes_classes = 'hideme';
                                }

                                if($results_displayed == false) {
                                    $results_classes = 'hideme';
                                }
                            ?>

                            <a class="<?php echo $clientneeds_classes ?>" href="#clientsneeds"><span>Client's Needs</span>
                                <img src="<?php echo get_stylesheet_directory_uri() . '/svg/anchorgo.svg' ?>">
                            </a>
                            <a class="<?php echo $the_problem_classes ?>" href="#theproblem">
                                <span>The Problem</span>
                                <img src="<?php echo get_stylesheet_directory_uri() . '/svg/anchorgo.svg' ?>">
                            </a>
                            <a class="<?php echo $solution_classes ?>" href="#solution">
                                <span>Solution</span>
                                <img src="<?php echo get_stylesheet_directory_uri() . '/svg/anchorgo.svg' ?>">
                            </a>
                            <a class="<?php echo $research_classes ?>" href="#research">
                                <span>Research</span>
                                <img src="<?php echo get_stylesheet_directory_uri() . '/svg/anchorgo.svg' ?>">
                            </a>
                            <a class="<?php echo $userstudy_classes ?>" href="#userstudy">
                                <span>User Study</span>
                                <img src="<?php echo get_stylesheet_directory_uri() . '/svg/anchorgo.svg' ?>">
                            </a>
                            <a class="<?php echo $branding_classes ?>" href="#branding">
                                <span>Branding</span>
                                <img src="<?php echo get_stylesheet_directory_uri() . '/svg/anchorgo.svg' ?>">
                            </a>
                            <a class="<?php echo $wireframes_classes ?>" href="#wireframes">
                                <span>Wireframes</span>
                                <img src="<?php echo get_stylesheet_directory_uri() . '/svg/anchorgo.svg' ?>">
                            </a>
                            <a class="<?php echo $results_classes ?>" href="#results">
                                <span>Results</span>
                                <img src="<?php echo get_stylesheet_directory_uri() . '/svg/anchorgo.svg' ?>">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="jseo_single_sideitem hide_sidewidget_onmobile">
                    <h3>Search Projects</h3>
                    <div class="jseo_single_sidedivider">
                        <div class="shapecontain"><span></span></div>
                        <div class="shapecontain"><span></span></div>
                        <div class="shapecontain"><span></span></div>
                    </div>
                    <div class="jseo_single_sidewidget">
                        <div class="jseo_single_search">
                            <?php echo do_shortcode('[elementor-template id="991"]'); ?>
                        </div>
                    </div>
                </div>

                <div class="jseo_single_sideitem hide_sidewidget_onmobile">
                    <h3>Categories</h3>
                    <div class="jseo_single_sidedivider">
                        <div class="shapecontain"><span></span></div>
                        <div class="shapecontain"><span></span></div>
                        <div class="shapecontain"><span></span></div>
                    </div>
                    <div class="jseo_single_sidewidget">
                        <div class="jseo_single_cats">
                            <?php 
                                for($z = 0; $z < count($the_portfolio_names); $z++) {
                                    echo '<a href="' . $the_portfolio_links[$z] . '">' . $the_portfolio_names[$z] . '</a>';
                                }

                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                </div>
                <div class="jseo_single_related hide_sidewidget_onmobile">
                <?php
                    $related_args = array(
                        'post_type' => 'portfolio',
                        'posts_per_page' => 5,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'portfolio_category',
                                'field' => 'slug',
                                'terms' => 'uiux-design',
                            )
                        ),
                        'orderby' => 'rand',
                    );
                    $related = new WP_Query( $related_args );
                    $related_output = '';
                    
                    if( $related->have_posts() ) {
                        echo '<h3>Related Work</h3>';
                        echo '<div class="jseo_single_sidedivider">
                            <div class="shapecontain"><span></span></div>
                            <div class="shapecontain"><span></span></div>
                            <div class="shapecontain"><span></span></div>
                        </div>';
                        
                        while($related->have_posts()) {
                            $related->the_post();
                            $the_related_id = get_the_id();
                            $the_related_permalink = get_the_permalink();
                            $the_related_title = get_the_title();
                            $the_company_description = '';
                            $mini_banner = get_field('mini_banner', $the_related_id);
                            $the_related_date = get_the_date("m/d/Y", $the_related_id );
                            $author_rel_id = get_post_field( 'post_author', $the_related_id );
                            $author_rel_name = get_the_author_meta('display_name');

                            if(($mini_banner)) {
                                
                                $the_company_description = $mini_banner['mbanner_company_description'];
                            }

                            if($the_company_description != '' && empty($the_company_description) == false) {
                                $the_company_description = (strlen($the_company_description) > 60) ? substr($the_company_description,0,60).'...' : $the_company_description;
                            } else {
                                $the_company_description = 'No company description provided...';
                            }
                            
                            if(has_post_thumbnail($the_related_id)) {
                                $the_related_thumb = get_the_post_thumbnail_url($the_related_id, 'thumbnail');
                                $related_output .= '<div class="jseo_related_item">';
                                $related_output .= '<div class="the_related_image"><a href="' . $the_related_permalink . '" class="jseo_related_linkimage"><img src="' . $the_related_thumb . '"></a></div>';
                                $related_output .= '<div class="the_related_content">';
                                $related_output .= '<a href="' . $the_related_permalink . '" class="jseo_related_link">' . $the_related_title . '</a>';
                                $related_output .= '<p class="jseo_related_excerpt">' . $the_company_description . '</p>';
                                $related_output .= '<div class="jseo_related_meta">
                                    <span><img src="' . get_stylesheet_directory_uri() . '/svg/calendar.svg">' . $the_related_date . '</span>
                                    <span><img src="' . get_stylesheet_directory_uri() . '/svg/user.svg">' . $author_rel_name . '</span>
                                </div>';
                                $related_output .= '</div></div>';
                            }
                            
                        }
                
                    }
                    
                    echo $related_output;
                    wp_reset_postdata();
                ?>
                </div>

            </div>

        </div>
    </div>

<?php

get_footer();