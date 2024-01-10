<?php
/**
 * The template for displaying singular post-types: posts, pages and user-defined custom post types.
 *
 * @package HelloElementor
 */

    if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly.
    }

    global $post;
    get_header();

   if (! post_password_required( $post )):

    while ( have_posts() ) :
        the_post();
        $the_id = get_the_ID();
        $the_title = get_the_title();
        $the_featured_image = get_the_post_thumbnail_url($the_id,'full');
        $author_id = get_post_field( 'post_author', $the_id );
        $author_name = get_the_author_meta('display_name');
        $the_date = get_the_date("m/d/Y", $the_id );
        $is_game = false;

        $jseo_term_args = array(
            'taxonomy' => 'portfolio_category',
            'hide_empty' => false,
        );

        $jseo_taxcategories = get_terms($jseo_term_args);
        $custom_slug_order = 'UI/UX Design, Graphic Design, Motion Design, Games';
        $jseo_customordered_terms = get_terms_ordered( 'portfolio_category', $jseo_term_args, $custom_slug_order, 'name');
        
        $the_terms = get_terms(array(
            'taxonomy' => 'portfolio_category',
            'hide_empty' => false,
        ));

        $the_post_terms = get_the_terms($the_id, 'portfolio_category');
        
        if(empty($the_post_terms) == false) {
            foreach ($the_post_terms as $term) {
               if($term->name == 'Games') {
                    $is_game = true;
                    // echo $is_game;
               }
            }
        }

        //Hero Variables
        $the_custom_image = '';
        $the_custom_overlay = '';

        //Mini Banner Variables
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

        //UX Content Fields
        $content_client_needs = '';
        $content_the_problem = '';
        $content_solution = '';
        $content_research = '';
        $content_branding = '';
        $content_design_iterations = '';
        $content_mockups = '';
        $content_results = '';
        $content_final_thoughts = '';

        $content_client_needs_output = '';
        $content_the_problem_output = '';
        $content_solution_output = '';
        $content_research_output = '';
        $content_branding_output = '';
        $content_design_iterations_output = '';
        $content_mockups_output = '';
        $content_results_output = '';
        $content_final_thoughts_output = '';

        $clientneeds_displayed = false;
        $theproblem_displayed = false;
        $solution_displayed = false;
        $research_displayed = false;
        $branding_displayed = false;
        $results_displayed = false;

        //Game Content Fields
        $content_my_contribution = '';
        $content_my_contribution_output = '';
        $my_contribution_displayed = false;

        $content_game_mocks = '';
        $content_game_mocks_output = '';
        $game_mocks_displayed = false;

        $content_ui_elements = '';
        $content_ui_elements_output = '';
        $ui_elements_displayed = false;

        //Fields for Both
        $content_wireframes = '';
        $content_wireframes_output = '';
        $wireframes_displayed = false;

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
                // Get UX content fields
                $content_client_needs = get_sub_field('client_needs');
                $content_the_problem = get_sub_field('the_problem');
                $content_solution = get_sub_field('solution');
                $content_research = get_sub_field('research');
                $content_branding = get_sub_field('branding');
                $content_wireframes = get_sub_field('wireframes');
                $content_design_iterations = get_sub_field('design_iterations');
                $content_mockups = get_sub_field('mockups');
                $content_results = get_sub_field('results');
                $content_final_thoughts = get_sub_field('final_thoughts');

                // Get Game content fields
                $content_my_contribution = get_sub_field('my_contribution');
                $content_game_mocks = get_sub_field('game_mocks');
                $content_ui_elements = get_sub_field('ui_elements');
            }

            //WYSIWYG Updated
            if($content_client_needs == '' || empty($content_client_needs) == true || isset($content_client_needs) == false) {
                $content_client_needs_output = '';
            } else {
                $the_content = $content_client_needs['client_needs_content'];
                $the_darkmode = '';

                if($content_client_needs['client_needs_dark_mode'] != '' && empty($content_client_needs['client_needs_dark_mode']) == false && isset($content_client_needs['client_needs_dark_mode']) == true) {
                    if($content_client_needs['client_needs_dark_mode'] == 'Yes') {
                        $the_darkmode = 'darkmode';
                    }
                }

                if(empty($the_content) == false && $the_content != '' && isset($the_content) == true) {
                    $clientneeds_displayed = true;
                    //only needs to have content present to display
                    $content_client_needs_output .= '<div class="jseo_content_standard_text ' . $the_darkmode . '" id="clientsneeds">';
                    $content_client_needs_output .= "<h3>Client's Needs</h3>";
                    $content_client_needs_output .= '<div class="contentspace">' . $the_content . '</div>';
                    $content_client_needs_output .= '</div>';
                }

            }

            //Problem 2 Columns
            if($content_the_problem == '' || empty($content_the_problem) == true || isset($content_the_problem) == false) {
                $content_the_problem_output = '';
            } else {

                $content_present = false;
                $content_screen_present = false;
                $temp_problem_caption = -1;
                $temp_problem_caption_output = '';
                $the_problem_darkmode = '';
                $the_problem_content_pass = false;

                $problem_col_one_style = '';
                $problem_col_two_style = '';

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

                if($content_the_problem['problem_dark_mode'] != '' && empty($content_the_problem['problem_dark_mode']) == false && isset($content_the_problem['problem_dark_mode']) == true) {
                     if($content_the_problem['problem_dark_mode'] == 'Yes') {
                         $the_problem_darkmode = 'darkmode';
                     }
                }

                if($content_present == true && $content_screen_present == true) {
                    $problem_col_one_style = '';
                    $problem_col_two_style = '';
                    $the_problem_content_pass = true;
                } else if($content_present == true && $content_screen_present == false) {
                    $problem_col_one_style = 'width: 100% !important; padding-right: 0 !important; padding-bottom: 5px !important;';
                    $problem_col_two_style = 'width: 0% !important; display: none !important; padding-left: 0 !important; margin: 0 !important;'; 
                    $the_problem_content_pass = true;
                }

                if($the_problem_content_pass == true) {
                    $theproblem_displayed = true;

                    $content_the_problem_output .= '<div class="jseo_content_problem ' . $the_problem_darkmode . '" id="theproblem">
                        <div style="' . $problem_col_one_style . '" class="jseo_content_problem_col">
                             <h3 class="maintitle">The Problem</h3>' 
                            . $content_the_problem['problem_content'] . 
                        '</div>
                        <div style="' . $problem_col_two_style . '" class="jseo_content_problem_col">
                            <a data-title="The Problem" data-cfile="-1" data-video="-1" data-featured="'. $content_the_problem['problem_screenshot'] . '" data-desc="' . $temp_problem_caption . '" data-hasarticle="false" data-permalink="-1" class="single_lightboxitem" href="javascript:void(0)"><img src="' . $content_the_problem['problem_screenshot'] . '"></a>' . 
                            $temp_problem_caption_output . 
                        '</div>
                    </div>';
                } else {
                    $content_the_problem_output = '';
                }

                
            }

            //WYSIWYG Updated
            if($content_solution == '' || empty($content_solution) == true || isset($content_solution) == false) {
                $content_solution_output = '';
            } else {
                $the_content = $content_solution['solution_content'];
                $the_darkmode = '';

                if($content_solution['solution_dark_mode'] != '' && empty($content_solution['solution_dark_mode']) == false && isset($content_solution['solution_dark_mode']) == true) {
                    if($content_solution['solution_dark_mode'] == 'Yes') {
                        $the_darkmode = 'darkmode';
                    }
                }

                if(empty($the_content) == false && $the_content != '' && isset($the_content) == true) {
                    $solution_displayed = true;
                    //only needs to have content present to display
                    $content_solution_output .= '<div class="jseo_content_standard_text ' . $the_darkmode . '" id="solution">';
                    $content_solution_output .= "<h3>Solution</h3>";
                    $content_solution_output .= '<div class="contentspace">' . $the_content . '</div>';
                    $content_solution_output .= '</div>';
                }

            }

            //WYSIWYG Updated
            if($content_research == '' || empty($content_research) == true || isset($content_research) == false) {
                $content_research_output = '';
            } else {
                $the_content = $content_research['research_content'];
                $the_darkmode = '';

                if($content_research['research_dark_mode'] != '' && empty($content_research['research_dark_mode']) == false && isset($content_research['research_dark_mode']) == true) {
                    if($content_research['research_dark_mode'] == 'Yes') {
                        $the_darkmode = 'darkmode';
                    }
                }

                if(empty($the_content) == false && $the_content != '' && isset($the_content) == true) {
                    $research_displayed = true;
                    //only needs to have content present to display
                    $content_research_output .= '<div class="jseo_content_standard_text ' . $the_darkmode . '" id="research">';
                    $content_research_output .= "<h3>Research</h3>";
                    $content_research_output .= '<div class="contentspace">' . $the_content . '</div>';
                    $content_research_output .= '</div>';
                }

            }

            //WYSIWYG Updated
            if($content_branding == '' || empty($content_branding) == true || isset($content_branding) == false) {
                $content_branding_output = '';
            } else {
                $the_content = $content_branding['branding_content'];
                $the_darkmode = '';

                if($content_branding['branding_dark_mode'] != '' && empty($content_branding['branding_dark_mode']) == false && isset($content_branding['branding_dark_mode']) == true) {
                    if($content_branding['branding_dark_mode'] == 'Yes') {
                        $the_darkmode = 'darkmode';
                    }
                }

                if(empty($the_content) == false && $the_content != '' && isset($the_content) == true) {
                    $branding_displayed = true;
                    //only needs to have content present to display
                    $content_branding_output .= '<div class="jseo_content_standard_text ' . $the_darkmode . '" id="branding">';
                    $content_branding_output .= '<h3>Branding</h3>';
                    $content_branding_output .= '<div class="contentspace">' . $the_content . '</div>';
                    $content_branding_output .= '</div>';
                }

            }

             //WYSIWYG with images
             if($content_wireframes == '' || empty($content_wireframes) == true || isset($content_wireframes) == false) {
                $content_wireframes_output = '';
            } else {
                $the_content = $content_wireframes['wireframes_content'];
                $the_buttons = $content_wireframes['wireframes_buttons'];
                $the_embeds = $content_wireframes['wireframes_embeds'];
                $the_buttons_output = '';
                $the_embeds_output = '';
                $the_darkmode = '';
                // echo d($the_embeds);

                if($content_wireframes['wireframes_dark_mode'] != '' && empty($content_wireframes['wireframes_dark_mode']) == false && isset($content_wireframes['wireframes_dark_mode']) == true) {
                    if($content_wireframes['wireframes_dark_mode'] == 'Yes') {
                        $the_darkmode = 'darkmode';
                    }
                }

                if($the_embeds != '' && empty($the_embeds) == false && isset($the_embeds) == true) {
                    if(count($the_embeds) == 1) {
                        $embed_html = $the_embeds[0]['embed_html'];
                        $the_embeds_output .= '<div class="jseo_single_embeds single">';

                        if($embed_html != '' && empty($embed_html) == false && isset($embed_html) == true) {
                            $the_embeds_output .= '<div class="embeditem">' . $embed_html . '</div>';
                        }

                        $the_embeds_output .= '</div>';

                        
                    } else if(count($the_embeds) > 1) {
                        $the_embeds_output .= '<div class="jseo_single_embeds multiple">';
                        for($tem = 0; $tem < count($the_embeds); $tem++) {
                            $embed_html = $the_embeds[$tem]['embed_html'];

                            if($embed_html != '' && empty($embed_html) == false && isset($embed_html) == true) {
                                $the_embeds_output .= '<div class="embeditem">' . $embed_html . '</div>';
                            }
                        }
                        $the_embeds_output .= '</div>';
                    }
                }

                if($the_buttons != '' && empty($the_buttons) == false && isset($the_buttons) == true) {
                    if(count($the_buttons) > 0) {
                        $the_buttons_output .= '<div class="jseo_single_altbuttons">';
                        for($tb = 0; $tb < count($the_buttons); $tb++) {
                            $current_tb = $the_buttons[$tb];
                            $current_tb_text = $current_tb['button_text'];
                            $current_tb_link = $current_tb['button_link'];
                            $current_tb_color = $current_tb['button_color'];
                            $current_tb_color_style = '';

                            if($current_tb_color == 'Pink') {
                                $current_tb_color_style = 'background-color: #E891CF;';
                            } else if($current_tb_color == 'Purple') {
                                if($content_wireframes['wireframes_dark_mode'] == 'Yes') {
                                    $current_tb_color_style = 'background-color: transparent; border:1px solid #FFF; padding-top: 14px; padding-bottom: 14px;';
                                } else if($content_wireframes['wireframes_dark_mode'] == 'No') {
                                    $current_tb_color_style = 'background-color: #302E4A;';
                                }
                            } else {
                                $current_tb_color_style = 'background-color: #E891CF;';
                            }

                            if(empty($current_tb_link) == true || isset($current_tb_link) == false || $current_tb_link == '') {
                                $current_tb_link = 'https://jennjunseo.com';
                            }

                            if(empty($current_tb_text) == true || isset($current_tb_text) == false || $current_tb_text == '') {
                                $current_tb_text = 'Click Me';
                            }

                            $the_buttons_output .= '<a style="' . $current_tb_color_style . '" href="' . $current_tb_link . '" target="_blank">' . $current_tb_text . '</a>';
                        }
                        $the_buttons_output .= '</div>';
                    }
                }

                if(empty($the_content) == false && $the_content != '' && isset($the_content) == true) {
                    $wireframes_displayed = true;
                    $content_wireframes_output .= '<div class="jseo_content_w_image ' . $the_darkmode . '" id="wireframes">';
                    //only needs to have content present to display
                    $content_wireframes_output .= '<h3 class="maintitle">Wireframes</h3>';
                    $content_wireframes_output .= '<div class="contentwidget">' . $the_content . '</div>';
                    $content_wireframes_output .= $the_embeds_output;
                    $content_wireframes_output .= $the_buttons_output;
                    
                    $content_wireframes_output .= '</div>';
                }

                
            }

            //WYSIWYG Updated
            if($content_design_iterations == '' || empty($content_design_iterations) == true || isset($content_design_iterations) == false) {
                $content_design_iterations_output = '';
            } else {
                $the_content = $content_design_iterations['design_iterations_content'];
                $the_bna = $content_design_iterations['design_iterations_before_n_afters'];
                $the_bna_output = '';
                $the_darkmode = '';
                $the_alt_layout = '';

                if($content_design_iterations['design_iterations_dark_mode'] != '' && empty($content_design_iterations['design_iterations_dark_mode']) == false && isset($content_design_iterations['design_iterations_dark_mode']) == true) {
                    if($content_design_iterations['design_iterations_dark_mode'] == 'Yes') {
                        $the_darkmode = 'darkmode';
                    }
                }

                if($content_design_iterations['design_iterations_alt_layout'] != '' && empty($content_design_iterations['design_iterations_alt_layout']) == false && isset($content_design_iterations['design_iterations_alt_layout']) == true) {
                    if($content_design_iterations['design_iterations_alt_layout'] == 'Yes') {
                        $the_alt_layout = ' altlayout';
                    }
                }

                if($the_bna != '' && empty($the_bna) == false && isset($the_bna) == true) {
                    if(count($the_bna) > 0) {
                        $the_bna_output .= '<div class="jseo_single_bnasection">';

                        for($tbna = 0; $tbna < count($the_bna); $tbna++) {
                            $current_tbna = $the_bna[$tbna];
                            $current_tbna_before = $current_tbna['before_image'];
                            $current_tbna_after = $current_tbna['after_image'];
                            $current_tbna_description = $current_tbna['description'];
                            $current_tbna_desc_output = '';

                            if($current_tbna_description != '' && empty($current_tbna_description) == false && isset($current_tbna_description) == true) {
                                $current_tbna_desc_output = '<p>' . $current_tbna_description . '</p>';
                            }

                            if(empty($current_tbna_before) == false && empty($current_tbna_after) == false && isset($current_tbna_before) == true && isset($current_tbna_after) == true && $current_tbna_before != '' && $current_tbna_after != '') {
                                $the_bna_output .= '<div class="the_bna_item' . $the_alt_layout . '">
                                    <div class="the_bna_images">
                                        <a data-title="Before ' . ($tbna + 1) . '" data-cfile="-1" data-video="-1" data-featured="' . $current_tbna_before . '" data-desc="-1" data-hasarticle="false" data-permalink="-1" href="javascript:void(0)" class="single_lightboxitem"><img src="' . $current_tbna_before . '"></a>
                                        <a data-title="After ' . ($tbna + 1) . '" data-cfile="-1" data-video="-1" data-featured="' . $current_tbna_after . '" data-desc="-1" data-hasarticle="false" data-permalink="-1" href="javascript:void(0)" class="single_lightboxitem"><img src="' . $current_tbna_after . '"></a>
                                    </div>
                                    <div class="the_bna_text">' . 
                                        $current_tbna_desc_output . 
                                    '</div>
                                </div>';
                            }
                        }

                        $the_bna_output .= '</div>';
                    }
                }

                if(empty($the_content) == false && $the_content != '' && isset($the_content) == true) {
                    //only needs to have content present to display
                    $content_design_iterations_output .= '<div class="jseo_content_standard_text ' . $the_darkmode . '" id="designiterations">';
                    $content_design_iterations_output .= '<h3>Design Iterations</h3>';
                    $content_design_iterations_output .= '<div class="contentspace">' . $the_content . '</div>';
                    $content_design_iterations_output .= $the_bna_output;
                    $content_design_iterations_output .= '</div>';
                }

            }

            //WYSIWYG with images
            if($content_mockups == '' || empty($content_mockups) == true || isset($content_mockups) == false) {
                $content_mockups_output = '';
            } else {
                $the_content = $content_mockups['mockups_content'];
                $the_buttons = $content_mockups['mockups_buttons'];
                $the_embeds = $content_mockups['mockups_embeds'];
                $the_buttons_output = '';
                $the_embeds_output = '';
                $the_darkmode = '';

                if($content_mockups['mockups_dark_mode'] != '' && empty($content_mockups['mockups_dark_mode']) == false && isset($content_mockups['mockups_dark_mode']) == true) {
                    if($content_mockups['mockups_dark_mode'] == 'Yes') {
                        $the_darkmode = 'darkmode';
                    }
                }

                if($the_embeds != '' && empty($the_embeds) == false && isset($the_embeds) == true) {
                    if(count($the_embeds) == 1) {
                        $embed_html = $the_embeds[0]['embed_html'];
                        $the_embeds_output .= '<div class="jseo_single_embeds single">';

                        if($embed_html != '' && empty($embed_html) == false && isset($embed_html) == true) {
                            $the_embeds_output .= '<div class="embeditem">' . $embed_html . '</div>';
                        }

                        $the_embeds_output .= '</div>';

                        
                    } else if(count($the_embeds) > 1) {
                        $the_embeds_output .= '<div class="jseo_single_embeds multiple">';
                        for($tem = 0; $tem < count($the_embeds); $tem++) {
                            $embed_html = $the_embeds[$tem]['embed_html'];

                            if($embed_html != '' && empty($embed_html) == false && isset($embed_html) == true) {
                                $the_embeds_output .= '<div class="embeditem">' . $embed_html . '</div>';
                            }
                        }
                        $the_embeds_output .= '</div>';
                    }
                }

                if($the_buttons != '' && empty($the_buttons) == false && isset($the_buttons) == true) {
                    if(count($the_buttons) > 0) {
                        $the_buttons_output .= '<div class="jseo_single_altbuttons">';
                        for($tb = 0; $tb < count($the_buttons); $tb++) {
                            $current_tb = $the_buttons[$tb];
                            $current_tb_text = $current_tb['button_text'];
                            $current_tb_link = $current_tb['button_link'];
                            $current_tb_color = $current_tb['button_color'];
                            $current_tb_color_style = '';

                            if($current_tb_color == 'Pink') {
                                $current_tb_color_style = 'background-color: #E891CF;';
                            } else if($current_tb_color == 'Purple') {
                                if($content_mockups['mockups_dark_mode'] == 'Yes') {
                                    $current_tb_color_style = 'background-color: transparent; border:1px solid #FFF; padding-top: 14px; padding-bottom: 14px;';
                                } else if($content_mockups['mockups_dark_mode'] == 'No') {
                                    $current_tb_color_style = 'background-color: #302E4A;';
                                }
                            } else {
                                $current_tb_color_style = 'background-color: #E891CF;';
                            }

                            if(empty($current_tb_link) == true || isset($current_tb_link) == false || $current_tb_link == '') {
                                $current_tb_link = 'https://jennjunseo.com';
                            }

                            if(empty($current_tb_text) == true || isset($current_tb_text) == false || $current_tb_text == '') {
                                $current_tb_text = 'Click Me';
                            }

                            $the_buttons_output .= '<a style="' . $current_tb_color_style . '" href="' . $current_tb_link . '" target="_blank">' . $current_tb_text . '</a>';
                        }
                        $the_buttons_output .= '</div>';
                    }
                }

                if(empty($the_content) == false && $the_content != '' && isset($the_content) == true) {
                    //only needs to have content present to display
                    $content_mockups_output .= '<div class="jseo_content_w_image ' . $the_darkmode . '" id="mockup">';
                    $content_mockups_output .= '<h3 class="maintitle">Mock-Up</h3>';
                    $content_mockups_output .= '<div class="contentwidget">' . $the_content . '</div>';
                    $content_mockups_output .= $the_embeds_output;
                    $content_mockups_output .= $the_buttons_output;
                    $content_mockups_output .= '</div>';
                }

            }

            //WYSIWYG Updated
            if($content_results == '' || empty($content_results) == true || isset($content_results) == false) {
                $content_results_output = '';
            } else {
                $the_content = $content_results['results_content'];
                $the_darkmode = '';

                if($content_results['results_dark_mode'] != '' && empty($content_results['results_dark_mode']) == false && isset($content_results['results_dark_mode']) == true) {
                    if($content_results['results_dark_mode'] == 'Yes') {
                        $the_darkmode = 'darkmode';
                    }
                }

                if(empty($the_content) == false && $the_content != '' && isset($the_content) == true) {
                    $results_displayed = true;
                    //only needs to have content present to display
                    $content_results_output .= '<div class="jseo_content_standard_text ' . $the_darkmode . '" id="results">';
                    $content_results_output .= "<h3>Results</h3>";
                    $content_results_output .= '<div class="contentspace">' . $the_content . '</div>';
                    $content_results_output .= '</div>';
                }

            }

            //WYSIWYG Updated
            if($content_final_thoughts == '' || empty($content_final_thoughts) == true || isset($content_final_thoughts) == false) {
                $content_final_thoughts_output = '';
            } else {
                $the_content = $content_final_thoughts['final_thoughts_content'];
                $the_darkmode = '';

                if($content_final_thoughts['final_thoughts_dark_mode'] != '' && empty($content_final_thoughts['final_thoughts_dark_mode']) == false && isset($content_final_thoughts['final_thoughts_dark_mode']) == true) {
                    if($content_final_thoughts['final_thoughts_dark_mode'] == 'Yes') {
                        $the_darkmode = 'darkmode';
                    }
                }

                if(empty($the_content) == false && $the_content != '' && isset($the_content) == true) {
                    //only needs to have content present to display
                    $content_final_thoughts_output .= '<div class="jseo_content_standard_text ' . $the_darkmode . '" id="finalthoughts">';
                    $content_final_thoughts_output .= "<h3>Final Thoughts</h3>";
                    $content_final_thoughts_output .= '<div class="contentspace">' . $the_content . '</div>';
                    $content_final_thoughts_output .= '</div>';
                }

            }

            //UX SPECIFIC FIELDS

            //WYSIWYG Updated
            if($content_my_contribution == '' || empty($content_my_contribution) == true || isset($content_my_contribution) == false) {
                $content_my_contribution_output = '';
            } else {
                $the_content = $content_my_contribution['my_contribution_content'];
                $the_darkmode = '';

                if($content_my_contribution['my_contribution_dark_mode'] != '' && empty($content_my_contribution['my_contribution_dark_mode']) == false && isset($content_my_contribution['my_contribution_dark_mode']) == true) {
                    if($content_my_contribution['my_contribution_dark_mode'] == 'Yes') {
                        $the_darkmode = 'darkmode';
                    }
                }

                if(empty($the_content) == false && $the_content != '' && isset($the_content) == true) {
                    $my_contribution_displayed = true;
                    //only needs to have content present to display
                    $content_my_contribution_output .= '<div class="jseo_content_standard_text ' . $the_darkmode . '" id="mycontribution">';
                    $content_my_contribution_output .= "<h3>My Contribution</h3>";
                    $content_my_contribution_output .= '<div class="contentspace">' . $the_content . '</div>';
                    $content_my_contribution_output .= '</div>';
                }

            }

            //WYSIWYG Updated
            if($content_game_mocks == '' || empty($content_game_mocks) == true || isset($content_game_mocks) == false) {
                $content_game_mocks_output = '';
            } else {
                $the_content = $content_game_mocks['game_mocks_content'];
                $the_darkmode = '';

                if($content_game_mocks['game_mocks_dark_mode'] != '' && empty($content_game_mocks['game_mocks_dark_mode']) == false && isset($content_game_mocks['game_mocks_dark_mode']) == true) {
                    if($content_game_mocks['game_mocks_dark_mode'] == 'Yes') {
                        $the_darkmode = 'darkmode';
                    }
                }

                if(empty($the_content) == false && $the_content != '' && isset($the_content) == true) {
                    $game_mocks_displayed = true;
                    //only needs to have content present to display
                    $content_game_mocks_output .= '<div class="jseo_content_standard_text ' . $the_darkmode . '" id="gamemocks">';
                    $content_game_mocks_output .= "<h3>Game Mocks</h3>";
                    $content_game_mocks_output .= '<div class="contentspace">' . $the_content . '</div>';
                    $content_game_mocks_output .= '</div>';
                }

            }

            //WYSIWYG Updated
            if($content_ui_elements == '' || empty($content_ui_elements) == true || isset($content_ui_elements) == false) {
                $content_ui_elements_output = '';
            } else {
                $the_content = $content_ui_elements['ui_elements_content'];
                $the_darkmode = '';

                if($content_ui_elements['ui_elements_dark_mode'] != '' && empty($content_ui_elements['ui_elements_dark_mode']) == false && isset($content_ui_elements['ui_elements_dark_mode']) == true) {
                    if($content_ui_elements['ui_elements_dark_mode'] == 'Yes') {
                        $the_darkmode = 'darkmode';
                    }
                }

                if(empty($the_content) == false && $the_content != '' && isset($the_content) == true) {
                    $ui_elements_displayed = true;
                    //only needs to have content present to display
                    $content_ui_elements_output .= '<div class="jseo_content_standard_text ' . $the_darkmode . '" id="uielements">';
                    $content_ui_elements_output .= "<h3>UI Elements</h3>";
                    $content_ui_elements_output .= '<div class="contentspace">' . $the_content . '</div>';
                    $content_ui_elements_output .= '</div>';
                }

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
            <!-- <div class="jseo_single_meta">
                <div class="jseo_single_metaitem"><img src="<?php echo get_stylesheet_directory_uri() . '/svg/user.svg' ?>"><span><?php echo $author_name ?></span></div>
                <div class="jseo_single_metaitem"><img src="<?php echo get_stylesheet_directory_uri() . '/svg/calendar.svg' ?>"><span><?php echo  $the_date ?></span></div>
            </div> -->
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
                            $related_term = 'uiux-design';

                            if($is_game == true) {
                                $related_term = 'games';
                            }

                            $related_args = array(
                                'post_type' => 'portfolio',
                                'posts_per_page' => 5,
                                'tax_query' => array(
                                            array(
                                                'taxonomy' => 'portfolio_category',
                                                'field' => 'slug',
                                                'terms' => $related_term,
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
                                                $the_company_description = (strlen($the_company_description) > 70) ? substr($the_company_description,0,70).'...' : $the_company_description;
                                            } else {
                                                $the_company_description = 'No company description is available for this item...';
                                            }
                                            
                                            if(has_post_thumbnail($the_related_id)) {
                                                $the_related_thumb = get_the_post_thumbnail_url($the_related_id, 'thumbnail');
                                                $related_output .= '<div class="jseo_related_item">';
                                                $related_output .= '<div class="the_related_image"><a href="' . $the_related_permalink . '" class="jseo_related_linkimage"><img src="' . $the_related_thumb . '"></a></div>';
                                                $related_output .= '<div class="the_related_content">';
                                                $related_output .= '<a href="' . $the_related_permalink . '" class="jseo_related_link">' . $the_related_title . '</a>';
                                                $related_output .= '<p class="jseo_related_excerpt">' . $the_company_description . '</p>';
                                                // $related_output .= '<div class="jseo_related_meta">
                                                //     <span><img src="' . get_stylesheet_directory_uri() . '/svg/calendar.svg">' . $the_related_date . '</span>
                                                //     <span><img src="' . get_stylesheet_directory_uri() . '/svg/user.svg">' . $author_rel_name . '</span>
                                                // </div>';
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
                            <h4 style="color: <?php echo $mb_text_color ?>;">
                                <?php
                                    if($is_game == true) {
                                        echo 'About This Game';
                                    } else {
                                        echo 'About The Company';
                                    }
                                ?>
                            </h4>
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
                    if($is_game == true) {
                        echo $content_my_contribution_output;
                        echo $content_game_mocks_output;
                        echo $content_ui_elements_output;
                        echo $content_wireframes_output;
                    } else {
                        echo $content_client_needs_output;
                        echo $content_the_problem_output;
                        echo $content_solution_output;
                        echo $content_research_output;
                        echo $content_branding_output;
                        echo $content_wireframes_output;
                        echo $content_design_iterations_output;
                        echo $content_mockups_output;
                        echo $content_results_output;
                        echo $content_final_thoughts_output;
                    }
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
                                // for some reason design iterations, mockups, and final thoughts were omitted from the toc
                                $clientneeds_classes = '';
                                $the_problem_classes = '';
                                $solution_classes = '';
                                $research_classes = '';
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
                            ?>
                        </div>
                    </div>
                </div>
<?php
    endwhile;
    wp_reset_postdata();
?>
                <div class="jseo_single_related hide_sidewidget_onmobile">
                <?php
                    $related_term = 'uiux-design';

                    if($is_game == true) {
                        $related_term = 'games';
                    }

                    $related_args = array(
                        'post_type' => 'portfolio',
                        'posts_per_page' => 5,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'portfolio_category',
                                'field' => 'slug',
                                'terms' => $related_term,
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
                                $the_company_description = (strlen($the_company_description) > 70) ? substr($the_company_description,0,70).'...' : $the_company_description;
                            } else {
                                $the_company_description = 'No company description is available for this item...';
                            }
                            
                            if(has_post_thumbnail($the_related_id)) {
                                $the_related_thumb = get_the_post_thumbnail_url($the_related_id, 'thumbnail');
                                $related_output .= '<div class="jseo_related_item">';
                                $related_output .= '<div class="the_related_image"><a href="' . $the_related_permalink . '" class="jseo_related_linkimage"><img src="' . $the_related_thumb . '"></a></div>';
                                $related_output .= '<div class="the_related_content">';
                                $related_output .= '<a href="' . $the_related_permalink . '" class="jseo_related_link">' . $the_related_title . '</a>';
                                $related_output .= '<p class="jseo_related_excerpt">' . $the_company_description . '</p>';
                                // $related_output .= '<div class="jseo_related_meta">
                                //     <span><img src="' . get_stylesheet_directory_uri() . '/svg/calendar.svg">' . $the_related_date . '</span>
                                //     <span><img src="' . get_stylesheet_directory_uri() . '/svg/user.svg">' . $author_rel_name . '</span>
                                // </div>';
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

    <?php else: ?>
    <?php 
        while ( have_posts() ) :
            the_post();
            $the_id = get_the_ID();
            $the_title = get_the_title();

            //Hero Variables
            $the_custom_image = '';
            $the_custom_overlay = '';

            if( have_rows('hero_section')) {
                while(have_rows('hero_section') ) {
                        the_row();
                        $the_custom_image = get_sub_field('custom_background_image');
                        $the_custom_overlay = get_sub_field('custom_overlay_opacity');
                } 
    
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
        <!-- Hero: No need to hide with pass protection -->
        <div style="background-image: url(<?php echo $the_custom_image ?>) !important;" class="jseo_single_hero">
            <div class="hero_overlay" style="opacity: <?php echo $the_custom_overlay ?> !important;"></div>
            <div class="jseo_single_container">
                <h1><?php echo $the_title ?></h1>
                <!-- <div class="jseo_single_meta">
                    <div class="jseo_single_metaitem"><img src="<?php echo get_stylesheet_directory_uri() . '/svg/user.svg' ?>"><span><?php echo $author_name ?></span></div>
                    <div class="jseo_single_metaitem"><img src="<?php echo get_stylesheet_directory_uri() . '/svg/calendar.svg' ?>"><span><?php echo  $the_date ?></span></div>
                </div> -->
            </div>
        </div>
        <div id="jseo_single_content" class="jseo_single_content">
            <div class="jseo_single_container">
            <?php echo get_the_password_form(); ?>
    <?php 
        endwhile;
        wp_reset_postdata();
    ?>
            </div>
        </div>
    <?php endif; ?>

<?php

get_footer();