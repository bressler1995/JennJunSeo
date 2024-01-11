jQuery( document ).ready(function() {
    let eccent_mobile_holder = document.getElementById("eccent_mobile_holder");
    let eccent_toggle = document.getElementById("eccent_toggle");
    let eccent_mobile_close = document.getElementById("eccent_mobile_close");
    let eccent_menu_mobile = document.getElementById("eccent_menu_mobile");
    let jseo_portfolio_content = document.getElementById("jseo_portfolio_content");

    let jseo_portfolio_catui = document.getElementById("jseo_portfolio_catui");
    let uicurrent = -1;
    let uilength = - 1;

    let jseo_pagination = document.getElementById("jseo_pagination");
    let jseo_footer = document.getElementById("jseo_footer");
    // let jseo_portfolio_all = document.getElementById("jseo_portfolio_all");

    let jseo_lightbox = document.getElementById("jseo_lightbox");
    let jseo_lbui_close = document.getElementById("jseo_lbui_close");
    let jseo_lbui_zoom = document.getElementById("jseo_lbui_zoom");
    let jseo_lightbox_ui_top = document.getElementById("jseo_lightbox_ui_top");
    let jseo_lightbox_image = document.getElementById("jseo_lightbox_image");
    let jseo_lightbox_video = document.getElementById("jseo_lightbox_video");
    let jseo_lightbox_video_container = document.getElementById("jseo_lightbox_video_container");
    let jseo_lightbox_pdf = document.getElementById("jseo_lightbox_pdf");
    let jseo_lightbox_pdf_container = document.getElementById("jseo_lightbox_pdf_container");
    let jseo_pdfreader_container = document.getElementById("jseo_pdfreader_container");
    let jseo_lbvideo_iframe = document.getElementById("jseo_lbvideo_iframe");
    let jseo_lbvideo_title = document.getElementById("jseo_lbvideo_title");
    let jseo_lbimage_img = document.getElementById("jseo_lbimage_img");
    let jseo_lbimage_title = document.getElementById("jseo_lbimage_title");
    let jseo_lbpdf_title = document.getElementById("jseo_lbpdf_title");
    let jseo_lightbox_image_media = document.getElementById("jseo_lightbox_image_media");
    let jseo_single_content = document.getElementById("jseo_single_content");
    let jseo_mini_works = document.getElementById("jseo_mini_works");
    let jseo_lightbox_zoom = -1;
    let jseo_lbimage_x = -50;
    let jseo_lbimage_y = -50;

    let jseo_lbimage_description = document.getElementById("jseo_lbimage_description");
    let jseo_lbvideo_description = document.getElementById("jseo_lbvideo_description");
    let jseo_lbpdf_description = document.getElementById("jseo_lbpdf_description");

    let jseo_lbimage_button = document.getElementById("jseo_lbimage_button");
    let jseo_lbvideo_button = document.getElementById("jseo_lbvideo_button");
    let jseo_lbpdf_button = document.getElementById("jseo_lbpdf_button");

    let jseo_lightbox_video_text = document.getElementById("jseo_lightbox_video_text");
    let jseo_lightbox_image_text = document.getElementById("jseo_lightbox_image_text");

    let current_post_storage = [];
    let current_entry_max = 0;
    let no_of_pages = 0;
    let current_page = 0;
    let voff_init = false;

    let urlParams = new URLSearchParams(window.location.search);
    let filterParam = urlParams.get('filter');

    let down = false;
    let downXStart = 0;
    let downYStart = 0;
    let downXDelta = 0;
    let downYDelta = 0;
    let directionX = 0;
    let directionY = 0;

    let uitopListener = (event) => {
        
    }

    let downListener = (event) => {
        down = true;
        downXStart = event.clientX;
        downYStart = event.clientY;

        if(down == true && jseo_lightbox_zoom == 1) {
            // downXDelta = event.clientX - downXStart;
            // downYDelta = event.clientY - downYStart;

            var rect = jseo_lbimage_img.getBoundingClientRect();
            downXPer = (event.clientX / jseo_lightbox_image_media.clientWidth) * 100;
            downYPer = (event.clientY / jseo_lightbox_image_media.clientHeight) * 100;

            console.log(downXPer + "%",  + downYPer + "%")

            // if(downXDelta > downXStart) {
            //     if(directionX == -1) {
            //         downXStart = event.clientX;
            //     }
            //     directionX = 1;
            // }

            // if(downXDelta < downXStart) {
            //     if(directionX == 1) {
            //         downXStart = event.clientX;
            //     }
            //     directionX = -1;
            // }

            // if(downYDelta > downYStart) {
            //     if(directionY == -1) {
            //         downYStart = event.clientY;
            //     }
            //     directionY = 1;
            // }

            // if(downYDelta < downYStart) {
            //     if(directionY == 1) {
            //         downYStart = event.clientY;
            //     }
            //     directionY = -1;
            // }

            // if(jseo_lbimage_x + (downXDelta * 0.01) >= -120  && jseo_lbimage_x + (downXDelta * 0.01) <= 20) {
            //     jseo_lbimage_x += downXDelta * (1 / 100);
            // }

            // if(jseo_lbimage_y + (downYDelta * 0.01) >= -120  && jseo_lbimage_y + (downYDelta * 0.01) <= 20) {
            //     jseo_lbimage_y += downYDelta * (1 / 100);
            // }

            var scaleX = scaleValue(downXPer, [0,100], [-170, 35]);
            var scaleY = scaleValue(downYPer, [0,100], [-170, 35]);

            jseo_lbimage_img.style.transform = 'translateX(' + scaleX + '%) translateY(' + scaleY + '%) scale(2.7)';
        }
    }

    let upListener = (e) => {
        down = false;
    }

    let moveListener = (event) => {
        if(down == true && jseo_lightbox_zoom == 1) {
            // downXDelta = event.clientX - downXStart;
            // downYDelta = event.clientY - downYStart;

            var rect = jseo_lbimage_img.getBoundingClientRect();
            downXPer = (event.clientX / jseo_lightbox_image_media.clientWidth) * 100;
            downYPer = (event.clientY / jseo_lightbox_image_media.clientHeight) * 100;

            console.log(downXPer + "%",  + downYPer + "%")

            // if(downXDelta > downXStart) {
            //     if(directionX == -1) {
            //         downXStart = event.clientX;
            //     }
            //     directionX = 1;
            // }

            // if(downXDelta < downXStart) {
            //     if(directionX == 1) {
            //         downXStart = event.clientX;
            //     }
            //     directionX = -1;
            // }

            // if(downYDelta > downYStart) {
            //     if(directionY == -1) {
            //         downYStart = event.clientY;
            //     }
            //     directionY = 1;
            // }

            // if(downYDelta < downYStart) {
            //     if(directionY == 1) {
            //         downYStart = event.clientY;
            //     }
            //     directionY = -1;
            // }

            // if(jseo_lbimage_x + (downXDelta * 0.01) >= -120  && jseo_lbimage_x + (downXDelta * 0.01) <= 20) {
            //     jseo_lbimage_x += downXDelta * (1 / 100);
            // }

            // if(jseo_lbimage_y + (downYDelta * 0.01) >= -120  && jseo_lbimage_y + (downYDelta * 0.01) <= 20) {
            //     jseo_lbimage_y += downYDelta * (1 / 100);
            // }

            var scaleX = scaleValue(downXPer, [0,100], [-170, 35]);
            var scaleY = scaleValue(downYPer, [0,100], [-170, 35]);

            jseo_lbimage_img.style.transform = 'translateX(' + scaleX + '%) translateY(' + scaleY + '%) scale(2.7)';
        }
    }

    eccent_toggle.addEventListener("click", eccent_show_navigation);
    eccent_mobile_close.addEventListener("click", eccent_hide_navigation);

    if (jseo_lightbox != null && jseo_lbui_close != null) {
        jseo_lbui_close.addEventListener("click", jseo_lbui_closefunc);
    }

    if (jseo_lightbox != null && jseo_lbui_zoom != null) {
        jseo_lbui_zoom.addEventListener("click", jseo_lbui_zoomfunc);
    }

    document.addEventListener('keydown', (event) => {
        var name = event.key;
        var code = event.code;
        // Alert the key name and key code on keydown
        // console.log(`Key pressed ${name} \r\n Key code value: ${code}`);

        if(name == 'ArrowUp') {
            jseo_lbui_zoomfunc_nav(0);
        } else if(name == 'ArrowRight') {
            jseo_lbui_zoomfunc_nav(1);
        } else if(name == 'ArrowDown') {
            jseo_lbui_zoomfunc_nav(2);
        } else if(name == 'ArrowLeft') {
            jseo_lbui_zoomfunc_nav(3);
        }
      }, false);

      if(jseo_lightbox_image_media != null && jseo_lbimage_img != null) {
        jseo_lightbox_image_media.addEventListener('mousedown', downListener);
        jseo_lightbox_image_media.addEventListener('mouseup', upListener);
        jseo_lightbox_image_media.addEventListener('mousemove', moveListener);
        jseo_lightbox_image_media.addEventListener("dragstart", function(){
            return false;
        });
      }

      if(jseo_lightbox_ui_top != null) {
        jseo_lightbox_ui_top.addEventListener("mouseenter", function(){
            down = false;
        });
      }

      if(jseo_lightbox_video_text != null) {
        jseo_lightbox_video_text.addEventListener("mouseenter", function(){
            down = false;
        });
      }

      if(jseo_lightbox_image_text != null) {
        jseo_lightbox_image_text.addEventListener("mouseenter", function(){
            down = false;
        });
      }

      if(jseo_single_content != null) {
        jQuery(document).on('click', 'a[href^="#"]', function (event) {
            event.preventDefault();
        
            jQuery('html, body').animate({
                scrollTop: jQuery(jQuery.attr(this, 'href')).offset().top
            }, 500);
        });
      }

    function eccent_show_navigation() {
        if(eccent_mobile_holder.classList.contains("eccent_mobile_holder_hide")) {
            eccent_mobile_holder.classList.remove("eccent_mobile_holder_hide");
        }

        if(eccent_menu_mobile.classList.contains("eccent_menu_mobile_show") == false) {
            eccent_menu_mobile.classList.add("eccent_menu_mobile_show");
        }
    }

    function eccent_hide_navigation() {
        if(eccent_mobile_holder.classList.contains("eccent_mobile_holder_hide") == false) {
            eccent_mobile_holder.classList.add("eccent_mobile_holder_hide");
        }

        if(eccent_menu_mobile.classList.contains("eccent_menu_mobile_show")) {
            eccent_menu_mobile.classList.remove("eccent_menu_mobile_show");
        }
    }

    function inject_portfolio() {
        let jseo_portfolio_catui_links = jseo_portfolio_catui.getElementsByTagName("a");

        for(i = 0; i < jseo_portfolio_catui_links.length; i++) {
            jseo_portfolio_catui_links[i].addEventListener("click", function(){
                load_portfolio(this.dataset.slug);
                let othercatlinks = jseo_portfolio_catui.getElementsByTagName("a");
                for(c = 0; c < othercatlinks.length; c++) {
                    if(othercatlinks[c].classList.contains("active")) {
                        othercatlinks[c].classList.remove("active");
                    }
                }

                this.classList.add("active");
                // if(jseo_portfolio_all != null) {
                //     jseo_portfolio_all.innerHTML = this.innerHTML;
                //     jseo_portfolio_all.innerHTML = jseo_portfolio_all.innerHTML + '<div class="jseo_portofolio_description"><span>' + this.innerHTML + ' projects are being displayed.</span></div>';
                // }
            });
        }

    }

    if(jseo_portfolio_catui != null && jseo_portfolio_content != null && jseo_pagination != null) {
        inject_portfolio();
    }

    function clearContentClasses() {
        jseo_portfolio_content.className ='';
        jseo_portfolio_content.classList.add("jseo_portfolio_content");
    }

    function changePage(targetPage) {
        document.body.scrollTop = document.documentElement.scrollTop = 0;
        
        current_page = targetPage;
        console.log("Change Page: " + current_page);

        jseo_portfolio_content.innerHTML = "";

        for(z = 0 + (targetPage * current_entry_max - current_entry_max); z < targetPage * current_entry_max; z++) {
            let thenum = z + 1;
            let thenumformatted = "";

            if(thenum < 10) {
                thenumformatted = "0" + thenum;
            } else {
                thenumformatted = thenum;
            }

            if(current_post_storage[z] != null) {

                let jseo_current_featured = current_post_storage[z]['the_featured_image'];
                let jseo_current_video = current_post_storage[z]['the_video'];
                let jseo_current_file = current_post_storage[z]['the_custom_file'];
                let jseo_current_lbdesc = current_post_storage[z]['the_lightbox_description'];
                let jseo_current_companydesc = current_post_storage[z]['the_company_description'];
                let jseo_current_cneeds = current_post_storage[z]['the_client_needs'];
                let jseo_current_output = '';

                if(jseo_current_featured != "-1" && jseo_current_video == "-1" && jseo_current_file == "-1") {
                    //Featured
                    jseo_current_output = '<div class="jseo_grid_icon"><div class="jgrid_iconobj"><img class="jgrid_iconobj_img" src="' + themeDirURI + '/svg/lightbox/image.svg"></div></div>';
                } else {
                    if(jseo_current_video != "-1" && jseo_current_file == "-1") {
                        //Video
                        jseo_current_output = '<div class="jseo_grid_icon"><div class="jgrid_iconobj"><img class="jgrid_iconobj_img" src="' + themeDirURI + '/svg/lightbox/film.svg"></div></div>';
                    } else if(jseo_current_video == "-1" && jseo_current_file != "-1") {
                        //PDF File
                        jseo_current_output = '<div class="jseo_grid_icon"><div class="jgrid_iconobj"><img class="jgrid_iconobj_img" src="' + themeDirURI + '/svg/lightbox/pdf.svg"></div></div>';
                    } else if(jseo_current_video != "-1" && jseo_current_file != "-1") {
                        //PDF File
                        jseo_current_output = '<div class="jseo_grid_icon"><div class="jgrid_iconobj"><img class="jgrid_iconobj_img" src="' + themeDirURI + '/svg/lightbox/pdf.svg"></div></div>';
                    } else {
                        //Featured
                        jseo_current_output = '<div class="jseo_grid_icon"><div class="jgrid_iconobj"><img class="jgrid_iconobj_img" src="' + themeDirURI + '/svg/lightbox/image.svg"></div></div>';
                    }
                }

                if(jseo_current_lbdesc == "-1" || jseo_current_lbdesc == -1 || jseo_current_lbdesc == "" || jseo_current_lbdesc == null) {
                    jseo_current_lbdesc = 'No description available for this item...';
                }

                if(jseo_current_cneeds == "-1" || jseo_current_cneeds == -1 || jseo_current_cneeds == "" || jseo_current_cneeds == null) {
                    cneeds_present = false;
                    jseo_current_cneeds = '';
                } else {
                    cneeds_present = true;
                    jseo_current_cneeds = jseo_current_cneeds;
                    console.log(jseo_current_cneeds);
                }

                if(jseo_current_companydesc == "-1" || jseo_current_companydesc == -1 || jseo_current_companydesc == "" || jseo_current_companydesc == null) {
                    jseo_current_companydesc = 'No written information available for this case study... Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
               
                    if(cneeds_present == true) {
                        jseo_current_companydesc = jseo_current_cneeds;
                    }
                } else {
                    if(cneeds_present == true) {
                        jseo_current_companydesc = jseo_current_companydesc + ' ' + jseo_current_cneeds;
                    }
                }

                if(jseo_portfolio_content.classList.contains("grid")) {
                    jseo_portfolio_content.innerHTML += '<div class="jseo_column jseo_grid_link"><a data-title="' + current_post_storage[z]['the_title'] + '" data-desc="' + current_post_storage[z]['the_lightbox_description'] + '" data-cfile="' + current_post_storage[z]['the_custom_file'] + '" data-video="' + current_post_storage[z]['the_video'] + '" data-featured="' + current_post_storage[z]['the_featured_image'] + '" data-hasarticle="' + current_post_storage[z]['has_article'] + '" data-permalink="' + current_post_storage[z]['the_permalink'] + '" href="javascript:void(0)"><img class="the_featured_image" style="filter: brightness(' + current_post_storage[z]['the_brightness'] + '%);" src="' + current_post_storage[z]['the_featured_image'] + '"><div class="jseo_portfolio_title">' + jseo_current_output + '<span>' + current_post_storage[z]['the_title'] + '</span></div></a></div>';
                } else if(jseo_portfolio_content.classList.contains("voffset")) {
                    jseo_portfolio_content.innerHTML += '<div class="jseo_column voff_animation"><div class="jseo_voffset_f1"><a href="' + current_post_storage[z]['the_permalink'] + '"><img style="filter: brightness(' + current_post_storage[z]['the_brightness'] + '%);" src="' + current_post_storage[z]['the_featured_image'] + '"></a></div><div class="jseo_voffset_f2"><a class="jseo_portfolio_title" href="' + current_post_storage[z]['the_permalink'] + '">' + current_post_storage[z]['the_title'] + '</a><p class="jseo_portfolio_description">' + truncate(jseo_current_companydesc, 450) + '</p><div class="jseo_portfolio_button_options"><a href="' + current_post_storage[z]['the_permalink'] + '">Read More</a></div> </div></div>';
                } else if(jseo_portfolio_content.classList.contains("vplain")) {
                    let vplain_variables = 'data-title="' + current_post_storage[z]['the_title'] + '" data-desc="' + current_post_storage[z]['the_lightbox_description'] + '" data-cfile="' + current_post_storage[z]['the_custom_file'] + '" data-video="' + current_post_storage[z]['the_video'] + '" data-featured="' + current_post_storage[z]['the_featured_image'] + '" data-hasarticle="' + current_post_storage[z]['has_article'] + '" data-permalink="' + current_post_storage[z]['the_permalink'] + '"';
                    let telemetry = '<div class="vplain_telemetry"><div class="vplain_telemetry_column"><span class="numforlooks">' + thenumformatted + '</span></div></div>';
                    jseo_portfolio_content.innerHTML += '<div class="jseo_column vplain_animation"><a ' + vplain_variables + ' href="javascript:void(0)" class="vplain_image"><img style="filter: brightness(' + current_post_storage[z]['the_brightness'] + '%);" src="' + current_post_storage[z]['the_featured_image'] + '">' + telemetry + '</a> <div class="vplain_information"><a ' + vplain_variables + ' href="javascript:void(0)" class="jseo_portfolio_title">' + current_post_storage[z]['the_title'] + '</a><p class="jseo_portfolio_description">' + truncate(jseo_current_lbdesc, 90) + '</p></div></div>';
                }
            } 
        }

        if(jseo_portfolio_content.classList.contains("voffset")) {
            voff_animation();
        }

        setTimeout(function(){
            if(jseo_portfolio_content.classList.contains("vplain")) {
                vplain_animation();
            }
        }, 300);

        setTimeout(function(){
            if(jseo_portfolio_content.classList.contains("grid")) {
                grid_animation();
            }
        }, 300);

    }

    function load_portfolio(slug) {

        console.log("Attempting to load slug: " + slug);
        document.body.scrollTop = document.documentElement.scrollTop = 0;
        jseo_portfolio_content.innerHTML = "";
        jseo_pagination.innerHTML = "";

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let theresponsetext = JSON.parse(this.responseText);
                current_entry_max = theresponsetext.entry_max;
                current_post_storage = theresponsetext.post_storage;
                current_page = 1;
                
                console.log(theresponsetext);

                if(theresponsetext != null) {
                    no_of_pages = theresponsetext.pagination_max;
                    if(no_of_pages > 1) {
                        for(y = 0; y < no_of_pages; y++) {
                            if(y == 0) {
                                jseo_pagination.innerHTML = jseo_pagination.innerHTML + '<button data-page="' + (y + 1) + '" class="current" type="button"><span>' + (y + 1) + '</span></button>';
                            } else {
                                jseo_pagination.innerHTML = jseo_pagination.innerHTML + '<button data-page="' + (y + 1) + '" type="button"><span>' + (y + 1) + '</span></button>';
                            }
                        }

                        let jseo_pagination_buttons = jseo_pagination.getElementsByTagName("button");
                        for(b = 0; b < jseo_pagination_buttons.length; b++) {
                            jseo_pagination_buttons[b].addEventListener("click", function(){
                                if(current_page != this.dataset.page) {
                                    changePage(this.dataset.page);
                                    let otherpagination_buttons = jseo_pagination.getElementsByTagName("button");
                                    for(ob = 0; ob < otherpagination_buttons.length; ob++) {
                                        if(otherpagination_buttons[ob].classList.contains("current") == true) {
                                            otherpagination_buttons[ob].classList.remove("current");
                                        }
                                    }
                                    if(this.classList.contains("current") == false) {
                                        this.classList.add("current");
                                    }
                                }
                            });
                        }

                    }

                    clearContentClasses();

                    if(slug == 'all' || slug == 'graphic-design') {
                        jseo_portfolio_content.classList.add("grid");
                    } else if(slug == 'motion-design') {
                        jseo_portfolio_content.classList.add("vplain");
                    } else if(slug == 'uiux-design') {
                        jseo_portfolio_content.classList.add("voffset");
                    } else if (slug == 'games') {
                        jseo_portfolio_content.classList.add("voffset");
                    } else {
                        slug = 'all';
                        jseo_portfolio_content.classList.add("grid");
                    }

                    for(z = 0; z < current_entry_max; z++) {
                        let thenum = z + 1;
                        let thenumformatted = "";
                        if(thenum < 10) {
                            thenumformatted = "0" + thenum;
                        } else {
                            thenumformatted = thenum;
                        }

                        if(current_post_storage[z] != null) {

                            let jseo_current_featured = current_post_storage[z]['the_featured_image'];
                            let jseo_current_video = current_post_storage[z]['the_video'];
                            let jseo_current_file = current_post_storage[z]['the_custom_file'];
                            let jseo_current_lbdesc = current_post_storage[z]['the_lightbox_description'];
                            let jseo_current_companydesc = current_post_storage[z]['the_company_description'];
                            let jseo_current_cneeds = current_post_storage[z]['the_client_needs'];
                            let jseo_current_output = '';
                            let cneeds_present = false;

                            if(jseo_current_featured != "-1" && jseo_current_video == "-1" && jseo_current_file == "-1") {
                                //Featured
                                jseo_current_output = '<div class="jseo_grid_icon"><div class="jgrid_iconobj"><img class="jgrid_iconobj_img" src="' + themeDirURI + '/svg/lightbox/image.svg"></div></div>';
                            } else {
                                if(jseo_current_video != "-1" && jseo_current_file == "-1") {
                                    //Video
                                    jseo_current_output = '<div class="jseo_grid_icon"><div class="jgrid_iconobj"><img class="jgrid_iconobj_img" src="' + themeDirURI + '/svg/lightbox/film.svg"></div></div>';
                                } else if(jseo_current_video == "-1" && jseo_current_file != "-1") {
                                    //PDF File
                                    jseo_current_output = '<div class="jseo_grid_icon"><div class="jgrid_iconobj"><img class="jgrid_iconobj_img" src="' + themeDirURI + '/svg/lightbox/pdf.svg"></div></div>';
                                } else if(jseo_current_video != "-1" && jseo_current_file != "-1") {
                                    //PDF File
                                    jseo_current_output = '<div class="jseo_grid_icon"><div class="jgrid_iconobj"><img class="jgrid_iconobj_img" src="' + themeDirURI + '/svg/lightbox/pdf.svg"></div></div>';
                                } else {
                                    //Featured
                                    jseo_current_output = '<div class="jseo_grid_icon"><div class="jgrid_iconobj"><img class="jgrid_iconobj_img" src="' + themeDirURI + '/svg/lightbox/image.svg"></div></div>';
                                }
                            }

                            if(jseo_current_lbdesc == "-1" || jseo_current_lbdesc == -1 || jseo_current_lbdesc == "" || jseo_current_lbdesc == null) {
                                jseo_current_lbdesc = 'No description available for this item...';
                            }

                            if(jseo_current_cneeds == "-1" || jseo_current_cneeds == -1 || jseo_current_cneeds == "" || jseo_current_cneeds == null) {
                                cneeds_present = false;
                                jseo_current_cneeds = '';
                            } else {
                                cneeds_present = true;
                                jseo_current_cneeds = jseo_current_cneeds;
                                console.log(jseo_current_cneeds);
                            }

                            if(jseo_current_companydesc == "-1" || jseo_current_companydesc == -1 || jseo_current_companydesc == "" || jseo_current_companydesc == null) {
                                jseo_current_companydesc = 'No written information available for this case study... Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
                           
                                if(cneeds_present == true) {
                                    jseo_current_companydesc = jseo_current_cneeds;
                                }
                            } else {
                                if(cneeds_present == true) {
                                    jseo_current_companydesc = jseo_current_companydesc + ' ' + jseo_current_cneeds;
                                }
                            }

                            if(jseo_portfolio_content.classList.contains("grid")) {
                                jseo_portfolio_content.innerHTML += '<div class="jseo_column jseo_grid_link"><a data-title="' + current_post_storage[z]['the_title'] + '" data-desc="' + current_post_storage[z]['the_lightbox_description'] + '" data-cfile="' + current_post_storage[z]['the_custom_file'] + '" data-video="' + current_post_storage[z]['the_video'] + '" data-featured="' + current_post_storage[z]['the_featured_image'] + '" data-hasarticle="' + current_post_storage[z]['has_article'] + '" data-permalink="' + current_post_storage[z]['the_permalink'] + '" href="javascript:void(0)"><img class="the_featured_image" style="filter: brightness(' + current_post_storage[z]['the_brightness'] + '%);" src="' + current_post_storage[z]['the_featured_image'] + '"><div class="jseo_portfolio_title">' + jseo_current_output + '<span>' + current_post_storage[z]['the_title'] + '</span></div></a></div>';
                            } else if(jseo_portfolio_content.classList.contains("voffset")) {
                                jseo_portfolio_content.innerHTML += '<div class="jseo_column voff_animation"><div class="jseo_voffset_f1"><a href="' + current_post_storage[z]['the_permalink'] + '"><img style="filter: brightness(' + current_post_storage[z]['the_brightness'] + '%);" src="' + current_post_storage[z]['the_featured_image'] + '"></a></div><div class="jseo_voffset_f2"><a class="jseo_portfolio_title" href="' + current_post_storage[z]['the_permalink'] + '">' + current_post_storage[z]['the_title'] + '</a><p class="jseo_portfolio_description">' + truncate(jseo_current_companydesc, 450) + '</p> <div class="jseo_portfolio_button_options"><a href="' + current_post_storage[z]['the_permalink'] + '">Read More</a></div> </div></div>';
                            } else if(jseo_portfolio_content.classList.contains("vplain")) {
                                let vplain_variables = 'data-title="' + current_post_storage[z]['the_title'] + '" data-desc="' + current_post_storage[z]['the_lightbox_description'] + '" data-cfile="' + current_post_storage[z]['the_custom_file'] + '" data-video="' + current_post_storage[z]['the_video'] + '" data-featured="' + current_post_storage[z]['the_featured_image'] + '" data-hasarticle="' + current_post_storage[z]['has_article'] + '" data-permalink="' + current_post_storage[z]['the_permalink'] + '"';
                                let telemetry = '<div class="vplain_telemetry"><div class="vplain_telemetry_column"><span class="numforlooks">' + thenumformatted + '</span></div></div>';
                                jseo_portfolio_content.innerHTML += '<div class="jseo_column vplain_animation"><a ' + vplain_variables + ' href="javascript:void(0)" class="vplain_image"><img style="filter: brightness(' + current_post_storage[z]['the_brightness'] + '%);" src="' + current_post_storage[z]['the_featured_image'] + '">' + telemetry + '</a> <div class="vplain_information"><a ' + vplain_variables + ' href="javascript:void(0)" class="jseo_portfolio_title">' + current_post_storage[z]['the_title'] + '</a><p class="jseo_portfolio_description">' + truncate(jseo_current_lbdesc, 90) + '</p></div></div>';
                            }
                        } 
                    }

                    if(jseo_portfolio_content.classList.contains("voffset")) {
                        voff_animation();
                    }

                    setTimeout(function(){
                        if(jseo_portfolio_content.classList.contains("vplain")) {
                            vplain_animation();
                        }
                    }, 300);

                    setTimeout(function(){
                        if(jseo_portfolio_content.classList.contains("grid")) {
                            grid_animation();
                        }
                    }, 300);
                    
                }
                
        }
        };

        xhttp.open("POST", themeDirURI + "/php/portfolio-ajax.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("filter=" + slug);
    }

    if(jseo_portfolio_content != null) {
        if(filterParam == '' || filterParam == null) {
            load_portfolio('uiux-design');
        } else {
            load_portfolio(filterParam);
        }
    }

    function grid_animation() {
        let jseo_grid_link = document.getElementsByClassName("jseo_grid_link");
        
        for(i = 0; i < jseo_grid_link.length; i++) {
            let jseo_grid_link_a = jseo_grid_link[i].getElementsByTagName('a');

            doSetGridTimeOut(jseo_grid_link[i], i);

            if (jseo_grid_link_a != null) {
                if(jseo_grid_link_a.length == 1) {
                    console.log(jseo_grid_link_a[0]);
                    jseo_grid_link_a[0].addEventListener("click", jseo_lbui_showfunc);
                }
            }
        }
    }

    function jseo_lbui_showfunc() {
        let jseo_current_file = this.dataset.cfile;
        let jseo_current_video = this.dataset.video;
        let jseo_current_desc = this.dataset.desc;
        let jseo_current_featured = this.dataset.featured;
        let jseo_current_hasarticle = this.dataset.hasarticle;
        let jseo_current_permalink = this.dataset.permalink;
        let jseo_current_mode = 0;
        let jseo_current_title = this.dataset.title;

        if(jseo_current_featured != "-1" && jseo_current_video == "-1" && jseo_current_file == "-1") {
            jseo_current_mode = 0;
        } else {
            if(jseo_current_video != "-1" && jseo_current_file == "-1") {
                jseo_current_mode = 1;
            } else if(jseo_current_video == "-1" && jseo_current_file != "-1") {
                jseo_current_mode = 2;
            } else if(jseo_current_video != "-1" && jseo_current_file != "-1") {
                jseo_current_mode = 2;
            } else {
                jseo_current_mode = 0;
            }
        }

        console.log("trigger lightbox");
        console.log(jseo_current_mode);
        if(jseo_lightbox != null) {
            document.body.style.overflowY = 'hidden';
            document.documentElement.style.overflowY = 'hidden';

            eccent_hide_navigation();
            
            console.log("PDF FIle: " + jseo_current_file + ", Video: " + jseo_current_video + ", Featured: " + jseo_current_featured);
            
            if(jseo_lightbox.classList.contains("show") == false) {
                jseo_lightbox.classList.add("show");
            }

            if(jseo_lightbox_overlay != null) {
                if(jseo_lightbox_overlay.classList.contains("show") == false) {
                    jseo_lightbox_overlay.classList.add("show");
                }
            }

            if(jseo_lightbox_ui_top != null) {
                if(jseo_lightbox_ui_top.classList.contains("show") == false) {
                    jseo_lightbox_ui_top.classList.add("show");
                }

            }

            if(jseo_current_mode == 0) {
                if(jseo_lightbox_image != null && jseo_lightbox_video != null && jseo_lightbox_pdf != null) {
                    // jseo_lightbox_image.style.height = "100%";
                    // jseo_lightbox_video.style.height = "0%";
                    // jseo_lightbox_pdf.style.height = "0%";

                    jseo_lightbox_image.style.display = "flex";
                    jseo_lightbox_video.style.display = "none";
                    jseo_lightbox_pdf.style.display = "none";
                }

                if(jseo_lightbox_image != null) {

                    setTimeout(function(){
                        if(jseo_lightbox_image.classList.contains("show") == false) {
                            jseo_lightbox_image.classList.add("show")
                        }
                    }, 300);
    
                    if(jseo_current_featured != null && jseo_current_featured != "" && jseo_current_featured != "-1") {
                        if(jseo_lbimage_img != null) {
                            jseo_lbimage_img.src = jseo_current_featured;
                        }
                    }
                }
    
                if(jseo_lbimage_title != null) {
                    jseo_lbimage_title.innerHTML = jseo_current_title;
                }      

                if(jseo_lbimage_description != null) {
                    if(jseo_current_desc != null && jseo_current_desc != "-1" && jseo_current_desc != -1) {
                        jseo_lbimage_description.innerHTML = jseo_current_desc;

                        if(jseo_lbimage_description.classList.contains("hidelbdesc") == true) {
                            jseo_lbimage_description.classList.remove("hidelbdesc");
                        }
                    }
                }

                if(jseo_lbimage_button != null) {
                    if(jseo_current_permalink != null && jseo_current_permalink != "-1" && jseo_current_permalink != -1 && jseo_current_hasarticle != null && jseo_current_hasarticle != "-1" && jseo_current_hasarticle != -1) {
                        if(jseo_current_hasarticle == 'true') {
                            jseo_lbimage_button.href = jseo_current_permalink;

                            if(jseo_lbimage_button.classList.contains("hidelbbutton") == true) {
                                jseo_lbimage_button.classList.remove("hidelbbutton");
                            }
                        }
                    }
                }

            } else if(jseo_current_mode == 1) {
                if(jseo_lightbox_image != null && jseo_lightbox_video != null && jseo_lightbox_pdf != null) {
                    // jseo_lightbox_image.style.height = "0%";
                    // jseo_lightbox_video.style.height = "100%";
                    // jseo_lightbox_pdf.style.height = "0%";

                    jseo_lightbox_image.style.display = "none";
                    jseo_lightbox_video.style.display = "flex";
                    jseo_lightbox_pdf.style.display = "none";
                }

                if(jseo_lbui_zoom.classList.contains("jseo_lbui_disabled") == false) {
                    jseo_lbui_zoom.classList.add("jseo_lbui_disabled");
                }

                if(jseo_lightbox_video != null) {
                    if(jseo_lightbox_video.classList.contains("show") == false) {
                        jseo_lightbox_video.classList.add("show");

                    }
                }

                if(jseo_lbvideo_iframe != null) {
                    if(jseo_current_video.includes("youtube.com/watch?v=")) {
                        let splitstring = jseo_current_video.split('v=');
                        if(splitstring != null) {
                            if(splitstring.length == 2) {
                                let finalstring = 'https://youtube.com/embed/' + splitstring[1];
                                jseo_lbvideo_iframe.src = finalstring;
                            }
                        }
                    } else if(jseo_current_video.includes("youtu.be")) {
                        let splitstring = jseo_current_video.split('.be/');
                        if(splitstring != null) {
                            if(splitstring.length == 2) {
                                let finalstring = 'https://youtube.com/embed/' + splitstring[1];
                                jseo_lbvideo_iframe.src = finalstring;
                            }
                        }
                    }
                }

                if(jseo_lbvideo_title != null) {
                    jseo_lbvideo_title.innerHTML = jseo_current_title;
                }  

                if(jseo_lbvideo_description != null) {
                    if(jseo_current_desc != null && jseo_current_desc != "-1" && jseo_current_desc != -1) {
                        jseo_lbvideo_description.innerHTML = jseo_current_desc;

                        if(jseo_lbvideo_description.classList.contains("hidelbdesc") == true) {
                            jseo_lbvideo_description.classList.remove("hidelbdesc");
                        }
                    }
                }

                if(jseo_lbvideo_button != null) {
                    if(jseo_current_permalink != null && jseo_current_permalink != "-1" && jseo_current_permalink != -1 && jseo_current_hasarticle != null && jseo_current_hasarticle != "-1" && jseo_current_hasarticle != -1) {
                        if(jseo_current_hasarticle == 'true') {
                            jseo_lbvideo_button.href = jseo_current_permalink;

                            if(jseo_lbvideo_button.classList.contains("hidelbbutton") == true) {
                                jseo_lbvideo_button.classList.remove("hidelbbutton");
                            }
                        }
                    }
                }

                if(jseo_lightbox_video_container != null) {
                    setTimeout(function(){
                        if(jseo_lightbox_video_container.classList.contains("show") == false) {
                            jseo_lightbox_video_container.classList.add("show")
                        }
                    }, 500);
                }

            } else if(jseo_current_mode == 2) {
                if(jseo_lightbox_image != null && jseo_lightbox_video != null && jseo_lightbox_pdf != null) {
                    // jseo_lightbox_image.style.height = "0%";
                    // jseo_lightbox_video.style.height = "0%";
                    // jseo_lightbox_pdf.style.height = "100%";

                    jseo_lightbox_image.style.display = "none";
                    jseo_lightbox_video.style.display = "none";
                    jseo_lightbox_pdf.style.display = "flex";
                }

                if(jseo_lbui_zoom.classList.contains("jseo_lbui_disabled") == false) {
                    jseo_lbui_zoom.classList.add("jseo_lbui_disabled");
                }

                if(jseo_lightbox_pdf != null) {
                    if(jseo_lightbox_pdf.classList.contains("show") == false) {
                        jseo_lightbox_pdf.classList.add("show");
                    }
                }

                if(jseo_pdfreader_container != null) {

                    let cfile_split = jseo_current_file.split("jennjunseo.com/");
                    if(cfile_split != null) {
                        if(cfile_split.length == 2) {
                            jseo_pdfreader_container.innerHTML = '<iframe src="https://jennjunseo.com/pdfjs/web/viewer.html?file=/' + cfile_split[1] + '">';
                        }
                    }
                }

                if(jseo_lbpdf_title != null) {
                    jseo_lbpdf_title.innerHTML = jseo_current_title;
                }  

                if(jseo_lbpdf_description != null) {
                    if(jseo_current_desc != null && jseo_current_desc != "-1" && jseo_current_desc != -1) {
                        jseo_lbpdf_description.innerHTML = jseo_current_desc;

                        if(jseo_lbpdf_description.classList.contains("hidelbdesc") == true) {
                            jseo_lbpdf_description.classList.remove("hidelbdesc");
                        }
                    }
                }

                if(jseo_lbpdf_button != null) {
                    if(jseo_current_permalink != null && jseo_current_permalink != "-1" && jseo_current_permalink != -1 && jseo_current_hasarticle != null && jseo_current_hasarticle != "-1" && jseo_current_hasarticle != -1) {
                        if(jseo_current_hasarticle == 'true') {
                            jseo_lbpdf_button.href = jseo_current_permalink;

                            if(jseo_lbpdf_button.classList.contains("hidelbbutton") == true) {
                                jseo_lbpdf_button.classList.remove("hidelbbutton");
                            }
                        }
                    }
                }

                if(jseo_lightbox_pdf_container != null) {
                    setTimeout(function(){
                        if(jseo_lightbox_pdf_container.classList.contains("show") == false) {
                            jseo_lightbox_pdf_container.classList.add("show")
                        }
                    }, 300);
                }

                

            }

        }
    }

    function jseo_lbui_closefunc() {
        document.body.style.overflowY = 'initial';
        document.documentElement.style.overflowY = 'initial';

        if(jseo_lightbox_overlay != null) {
            if(jseo_lightbox_overlay.classList.contains("show") == true) {
                jseo_lightbox_overlay.classList.remove("show");
            }
        }

        if(jseo_lightbox_ui_top != null) {
            if(jseo_lightbox_ui_top.classList.contains("show") == true) {
                jseo_lightbox_ui_top.classList.remove("show");
            }
        }

        if(jseo_lightbox_image != null) {
            if(jseo_lightbox_image.classList.contains("show") == true) {
                jseo_lightbox_image.classList.remove("show");
            }

            if(jseo_lightbox_zoom == 1) {
                jseo_lbui_zoomfunc(true);
            }
        }

        if(jseo_lightbox_video_container != null) {
            if(jseo_lightbox_video_container.classList.contains("show") == true) {
                jseo_lightbox_video_container.classList.remove("show");
            }
        }

        if(jseo_lightbox_pdf_container != null) {
            if(jseo_lightbox_pdf_container.classList.contains("show") == true) {
                jseo_lightbox_pdf_container.classList.remove("show");
            }
        }

        setTimeout(function(){
            
            if(jseo_lightbox.classList.contains("show") == true) {
                jseo_lightbox.classList.remove("show");
            }

            if(jseo_lbui_zoom != null) {
                if(jseo_lbui_zoom.classList.contains("jseo_lbui_disabled") == true) {
                    jseo_lbui_zoom.classList.remove("jseo_lbui_disabled");
                }
            }

            if(jseo_lightbox_video != null) {
                if(jseo_lightbox_video.classList.contains("show") == true) {
                    jseo_lightbox_video.classList.remove("show");
    
                }
            }

            if(jseo_lightbox_pdf != null) {
                if(jseo_lightbox_pdf.classList.contains("show") == true) {
                    jseo_lightbox_pdf.classList.remove("show");
    
                }
            }

            if(jseo_lbvideo_iframe != null) {
                jseo_lbvideo_iframe.src = '';
            }

            if(jseo_lbimage_description != null) {
                if(jseo_lbimage_description.classList.contains("hidelbdesc") == false) {
                    jseo_lbimage_description.classList.add("hidelbdesc");
                }
            }

            if(jseo_lbvideo_description != null) {
                if(jseo_lbvideo_description.classList.contains("hidelbdesc") == false) {
                    jseo_lbvideo_description.classList.add("hidelbdesc");
                }
            }

            if(jseo_lbpdf_description != null) {
                if(jseo_lbpdf_description.classList.contains("hidelbdesc") == false) {
                    jseo_lbpdf_description.classList.add("hidelbdesc");
                }
            }

            if(jseo_lbimage_button != null) {
                if(jseo_lbimage_button.classList.contains("hidelbbutton") == false) {
                    jseo_lbimage_button.classList.add("hidelbbutton");
                }
            }

            if(jseo_lbvideo_button != null) {
                if(jseo_lbvideo_button.classList.contains("hidelbbutton") == false) {
                    jseo_lbvideo_button.classList.add("hidelbbutton");
                }
            }

            if(jseo_lbpdf_button != null) {
                if(jseo_lbpdf_button.classList.contains("hidelbbutton") == false) {
                    jseo_lbpdf_button.classList.add("hidelbbutton");
                }
            }

            
        }, 1000);
    }

    function jseo_lbui_zoomfunc(override = false) {

        if(jseo_lightbox_image.classList.contains("show") || override == true) {
            jseo_lightbox_zoom *= -1;

            if(jseo_lightbox_zoom == 1) {
                if(jseo_lbimage_img != null) {
                    jseo_lightbox_image_media.style.cursor = "grabbing";
                    if(jseo_lbimage_img.classList.contains("zoom") == false) {
                        jseo_lbimage_img.classList.add("zoom");
                    }
                }
            } else if(jseo_lightbox_zoom == -1) {
                if(jseo_lbimage_img != null) {
                    jseo_lightbox_image_media.style.cursor = "initial";

                    if(jseo_lbimage_img.classList.contains("zoom") == true) {
                        jseo_lbimage_img.classList.remove("zoom");
                    }
    
                    jseo_lbimage_img.style.transform = "";
                    jseo_lbimage_x = -50;
                    jseo_lbimage_y = -50;
                }
            }
        }

    }

    function jseo_lbui_zoomfunc_nav(direction) {
        if(jseo_lbimage_img != null && jseo_lightbox_zoom == 1) {

            if(direction == 0) {
                if(jseo_lbimage_y + 7 <= 20) {
                    jseo_lbimage_y += 7;
                }
                
            } else if(direction == 1) {
                if(jseo_lbimage_x - 7 >= -120) {
                    jseo_lbimage_x -= 7;
                }
            } else if(direction == 2) {

                if(jseo_lbimage_y - 7 >= -120) {
                    jseo_lbimage_y -= 7;
                }
            } else if(direction == 3) {
                if(jseo_lbimage_x + 7 <= 20) {
                    jseo_lbimage_x += 7;
                }
            }

            jseo_lbimage_img.style.transform = 'translateX(' + jseo_lbimage_x + '%) translateY(' + jseo_lbimage_y + '%) scale(2.7)';
        }
        
    }

    function inject_single_lightbox() {

        let jseo_single_lbitems = document.getElementsByClassName("single_lightboxitem");

        if(jseo_single_lbitems != null) {
            if(jseo_single_lbitems.length > 0) {
                for(i = 0; i < jseo_single_lbitems.length; i++) {
                    let current_slb_item = jseo_single_lbitems[i];
                    current_slb_item.addEventListener("click", jseo_lbui_showfunc);
                }
            }
        }

    }

    function inject_content_lblinks() {
        let standard_text = document.getElementsByClassName("jseo_content_standard_text");
        let widget_text = document.getElementsByClassName("jseo_content_w_image");

        if(standard_text != null) {
            if(standard_text.length > 0) {
                for(i = 0; i < standard_text.length; i++) {
                    let st_item = standard_text[i];
                    let st_content = st_item.getElementsByClassName("contentspace");

                    if(st_content != null) {
                        if(st_content.length == 1) {
                            let st_content_object = st_content[0];
                            let st_content_figures = st_content_object.getElementsByTagName("figure");

                            if(st_content_figures != null) {
                                if(st_content_figures.length > 0) {

                                    console.log(st_content_figures.length + " Standard Content Figures Found");

                                    for(stf = 0; stf < st_content_figures.length; stf++) {
                                        let current_stf = st_content_figures[stf];

                                        let current_stf_a = current_stf.getElementsByTagName("a");
                                        let current_stf_already_link = false;

                                        if(current_stf_a != null) {
                                            if(current_stf_a.length > 0) {
                                                current_stf_already_link = true;
                                            }
                                        }

                                        if(current_stf_already_link == false) {
                                            let current_stf_img = current_stf.getElementsByTagName("img");
                                            let current_stf_caption = current_stf.getElementsByTagName("figcaption");
                                            let current_stf_caption_text = '';
                                            let current_stf_imagehtml = '';
                                            let current_stf_imagesrc = '';

                                            if(current_stf_img != null && current_stf_caption != null) {
                                                if(current_stf_img.length == 1 && current_stf_caption.length == 1) {
                                                    current_stf_caption_text = current_stf_caption[0].innerHTML;
                                                    current_stf_imagehtml = current_stf_img[0].outerHTML;
                                                    current_stf_imagesrc = current_stf_img[0].src;

                                                    current_stf_img[0].outerHTML = '<a data-title="' + current_stf_caption_text + '" data-cfile="-1" data-video="-1" data-featured="' + current_stf_imagesrc + '" data-desc="-1" data-hasarticle="false" data-permalink="-1" href="javascript:void(0)" class="single_lightboxitem">' + current_stf_imagehtml + '</a>';
                                                }
                                            }
                                        }
                                        
                                    }

                                }
                            }
                        }
                    }
                }

            }
        }

        if(widget_text != null) {
            if(widget_text.length > 0) {
                for(i = 0; i < widget_text.length; i++) {
                    let wt_item = widget_text[i];
                    let wt_content = wt_item.getElementsByClassName("contentwidget");

                    if(wt_content != null) {
                        if(wt_content.length == 1) {
                            let wt_content_object = wt_content[0];
                            let wt_content_figures = wt_content_object.getElementsByTagName("figure");

                            if(wt_content_figures != null) {
                                if(wt_content_figures.length > 0) {

                                    console.log(wt_content_figures.length + " Widget Content Figures Found");

                                    for(stf = 0; stf < wt_content_figures.length; stf++) {
                                        let current_stf = wt_content_figures[stf];

                                        let current_stf_a = current_stf.getElementsByTagName("a");
                                        let current_stf_already_link = false;

                                        if(current_stf_a != null) {
                                            if(current_stf_a.length > 0) {
                                                current_stf_already_link = true;
                                            }
                                        }

                                        if(current_stf_already_link == false) {
                                            let current_stf_img = current_stf.getElementsByTagName("img");
                                            let current_stf_caption = current_stf.getElementsByTagName("figcaption");
                                            let current_stf_caption_text = '';
                                            let current_stf_imagehtml = '';
                                            let current_stf_imagesrc = '';

                                            if(current_stf_img != null && current_stf_caption != null) {
                                                if(current_stf_img.length == 1 && current_stf_caption.length == 1) {
                                                    current_stf_caption_text = current_stf_caption[0].innerHTML;
                                                    current_stf_imagehtml = current_stf_img[0].outerHTML;
                                                    current_stf_imagesrc = current_stf_img[0].src;

                                                    current_stf_img[0].outerHTML = '<a data-title="' + current_stf_caption_text + '" data-cfile="-1" data-video="-1" data-featured="' + current_stf_imagesrc + '" data-desc="-1" data-hasarticle="false" data-permalink="-1" href="javascript:void(0)" class="single_lightboxitem">' + current_stf_imagehtml + '</a>';
                                                }
                                            }
                                        }
                                        
                                    }

                                }
                            }
                        }
                    }
                }

            }
        }

    }

    if(jseo_single_content != null) {
        inject_content_lblinks();
        inject_single_lightbox();
    }

    function inject_mini_lightbox() {
        let miniworkitems = jseo_mini_works.getElementsByClassName("jseo_mini_workitem");

        if(miniworkitems != null) {
            if(miniworkitems.length > 0) {
                for(i = 0; i < miniworkitems.length; i++) {
                    let current_item = miniworkitems[i];
                    current_item.addEventListener("click", jseo_lbui_showfunc);
                }
            }
        }
    }

    if(jseo_mini_works != null) {
        inject_mini_lightbox();
    }

    function vplain_animation() {
        let vplain_link = document.getElementsByClassName("vplain_animation");
        
        for(i = 0; i < vplain_link.length; i++) {
            let jseo_vplain_link_a = vplain_link[i].getElementsByTagName('a');

            doSetVPlainTimeOut(vplain_link[i], i);

            if (jseo_vplain_link_a != null) {
                if(jseo_vplain_link_a.length == 2) {
                    console.log(jseo_vplain_link_a[0]);
                    console.log(jseo_vplain_link_a[1]);
                    jseo_vplain_link_a[0].addEventListener("click", jseo_lbui_showfunc);
                    jseo_vplain_link_a[1].addEventListener("click", jseo_lbui_showfunc);
                }
            }

        }
    }

    function voff_animation() {
        if(voff_init == false) {
            voff_init = true;
            window.addEventListener('scroll',(event) => {

                if(jseo_portfolio_content.classList.contains("voffset")) {
                    // console.log('Scrolling...');
                    let voff_animation = document.getElementsByClassName("voff_animation");
                    for(v = 0; v < voff_animation.length; v++) {
                        if(isElementInViewport(voff_animation[v])) {
                            voff_animation[v].classList.add("show");
                        }
                    }
                }
                
            });

            window.addEventListener('resize', function() {

                if(jseo_portfolio_content.classList.contains("voffset")) {
                    // console.log('Resizing...');
                    let voff_animation = document.getElementsByClassName("voff_animation");
                    for(v = 0; v < voff_animation.length; v++) {
                        if(isElementInViewport(voff_animation[v])) {
                            voff_animation[v].classList.add("show");
                        }
                    }
                }

            });

        }

        setTimeout(function(){
            let voff_animation = document.getElementsByClassName("voff_animation");
            for(v = 0; v < voff_animation.length; v++) {
                if(isElementInViewport(voff_animation[v])) {
                    voff_animation[v].classList.add("show");
                }
            }
        }, 300);
    }

    function doSetVPlainTimeOut(vplainobject, multiplier) {
        setTimeout(function() { vplainobject.classList.add("show") }, multiplier * 300);
    }

    function doSetGridTimeOut(gridobject, multiplier) {
        setTimeout(function() { gridobject.classList.add("show") }, multiplier * 100);
    }

    function isElementInViewport(el) {

        // Special bonus for those using jQuery
        if (typeof jQuery === "function" && el instanceof jQuery) {
            el = el[0];
        }
    
        var rect = el.getBoundingClientRect();
        // console.log(rect);
    
        return (
            rect.top < window.innerHeight && rect.bottom >= 0
        );
    }

    function scaleValue(value, from, to) {
        var scale = (to[1] - to[0]) / (from[1] - from[0]);
        var capped = Math.min(from[1], Math.max(from[0], value)) - from[0];
        return ~~(capped * scale + to[0]);
    }

    function truncate(str, n){
        return (str.length > n) ? str.substr(0, n-1) + '&hellip;' : str;
    };

});