jQuery( document ).ready(function() {
    let eccent_mobile_holder = document.getElementById("eccent_mobile_holder");
    let eccent_toggle = document.getElementById("eccent_toggle");
    let eccent_mobile_close = document.getElementById("eccent_mobile_close");
    let eccent_menu_mobile = document.getElementById("eccent_menu_mobile");
    let jseo_portfolio_content = document.getElementById("jseo_portfolio_content");

    let jseo_portfolio_catui = document.getElementById("jseo_portfolio_catui");
    let jseo_portfolio_nextOpt = document.getElementById("jseo_portfolio_nextOpt");
    let jseo_portfolio_prevOpt = document.getElementById("jseo_portfolio_prevOpt");
    let uicurrent = -1;
    let uilength = - 1;

    let jseo_pagination = document.getElementById("jseo_pagination");
    let jseo_footer = document.getElementById("jseo_footer");
    let jseo_portfolio_all = document.getElementById("jseo_portfolio_all");

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
    let jseo_lightbox_zoom = -1;
    let jseo_lbimage_x = -50;
    let jseo_lbimage_y = -50;

    let current_post_storage = [];
    let current_entry_max = 0;
    let no_of_pages = 0;
    let current_page = 0;
    let voff_init = false;

    let urlParams = new URLSearchParams(window.location.search);
    let filterParam = urlParams.get('filter');

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
        console.log(`Key pressed ${name} \r\n Key code value: ${code}`);

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
                if(jseo_portfolio_all != null) {
                    jseo_portfolio_all.innerHTML = this.innerHTML;
                    jseo_portfolio_all.innerHTML = jseo_portfolio_all.innerHTML + '<div class="jseo_portofolio_description"><span>' + this.innerHTML + ' projects are being displayed.</span></div>';
                }
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

                if(jseo_portfolio_content.classList.contains("grid")) {
                    jseo_portfolio_content.innerHTML += '<div class="jseo_column jseo_grid_link"><a data-title="' + current_post_storage[z]['the_title'] + '" data-cfile="' + current_post_storage[z]['the_custom_file'] + '" data-video="' + current_post_storage[z]['the_video'] + '" data-featured="' + current_post_storage[z]['the_featured_image'] + '" href="javascript:void(0)"><img class="the_featured_image" src="' + current_post_storage[z]['the_featured_image'] + '"><div class="jseo_portfolio_title">' + jseo_current_output + '<span>' + current_post_storage[z]['the_title'] + '</span></div></a></div>';
                } else if(jseo_portfolio_content.classList.contains("voffset")) {
                    jseo_portfolio_content.innerHTML += '<div class="jseo_column voff_animation"><div class="jseo_voffset_f1"><a href="' + current_post_storage[z]['the_permalink'] + '"><img src="' + current_post_storage[z]['the_featured_image'] + '"></a></div><div class="jseo_voffset_f2"><a class="jseo_portfolio_title" href="' + current_post_storage[z]['the_permalink'] + '">' + current_post_storage[z]['the_title'] + '</a><p class="jseo_portfolio_description">' + current_post_storage[z]['the_excerpt'] + '</p><div class="jseo_portfolio_meta"><div class="jseo_portfolio_meta_item"><img src="' + themeDirURI + "/svg/calendar.svg" + '">' + current_post_storage[z]['the_date'] + '</div><div class="jseo_portfolio_meta_item"><img src="' + themeDirURI + "/svg/user.svg" + '">' + current_post_storage[z]['the_author'] + '</div><div class="jseo_portfolio_meta_item"><img src="' + themeDirURI + "/svg/gallery.svg" + '">Gallery Images<span>' + current_post_storage[z]['the_gallery_count'] + '</span></div></div> <div class="jseo_portfolio_button_options"><a href="' + current_post_storage[z]['the_permalink'] + '">Read More</a></div> </div></div>';
                } else if(jseo_portfolio_content.classList.contains("vplain")) {
                    let telemetry = '<div class="vplain_telemetry"><div class="vplain_telemetry_column"><span class="numforlooks">' + thenumformatted + '</span></div><div class="vplain_telemetry_column"><ul class="vplain_telemetry_list"><li><img src="' + themeDirURI + "/svg/calendar.svg" + '"><span>' + current_post_storage[z]['the_date'] + '</span></li><li><img src="' + themeDirURI + "/svg/user.svg" + '"><span>' + current_post_storage[z]['the_author'] + '</span></li><li><img src="' + themeDirURI + "/svg/gallery.svg" + '"><span>Gallery: ' + current_post_storage[z]['the_gallery_count'] + '</span></li></ul></div></div>';
                    jseo_portfolio_content.innerHTML += '<div class="jseo_column vplain_animation"><a href="' + current_post_storage[z]['the_permalink']  + '" class="vplain_image"><img src="' + current_post_storage[z]['the_featured_image'] + '">' + telemetry + '</a> <div class="vplain_information"><a href="' + current_post_storage[z]['the_permalink'] + '" class="jseo_portfolio_title">' + current_post_storage[z]['the_title'] + '</a><p class="jseo_portfolio_description">' + current_post_storage[z]['the_excerpt'].substring(0, 100) + '</p></div></div>';
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

                    if(slug == 'all' || slug == 'graphic-design' || slug == 'visual-design') {
                        jseo_portfolio_content.classList.add("grid");
                    } else if(slug == 'motion-design') {
                        jseo_portfolio_content.classList.add("voffset");
                    } else if(slug == 'uiux-design') {
                        jseo_portfolio_content.classList.add("vplain");
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

                            if(jseo_portfolio_content.classList.contains("grid")) {
                                jseo_portfolio_content.innerHTML += '<div class="jseo_column jseo_grid_link"><a data-title="' + current_post_storage[z]['the_title'] + '" data-cfile="' + current_post_storage[z]['the_custom_file'] + '" data-video="' + current_post_storage[z]['the_video'] + '" data-featured="' + current_post_storage[z]['the_featured_image'] + '" href="javascript:void(0)"><img class="the_featured_image" src="' + current_post_storage[z]['the_featured_image'] + '"><div class="jseo_portfolio_title">' + jseo_current_output + '<span>' + current_post_storage[z]['the_title'] + '</span></div></a></div>';
                            } else if(jseo_portfolio_content.classList.contains("voffset")) {
                                jseo_portfolio_content.innerHTML += '<div class="jseo_column voff_animation"><div class="jseo_voffset_f1"><a href="' + current_post_storage[z]['the_permalink'] + '"><img src="' + current_post_storage[z]['the_featured_image'] + '"></a></div><div class="jseo_voffset_f2"><a class="jseo_portfolio_title" href="' + current_post_storage[z]['the_permalink'] + '">' + current_post_storage[z]['the_title'] + '</a><p class="jseo_portfolio_description">' + current_post_storage[z]['the_excerpt'] + '</p><div class="jseo_portfolio_meta"><div class="jseo_portfolio_meta_item"><img src="' + themeDirURI + "/svg/calendar.svg" + '">' + current_post_storage[z]['the_date'] + '</div><div class="jseo_portfolio_meta_item"><img src="' + themeDirURI + "/svg/user.svg" + '">' + current_post_storage[z]['the_author'] + '</div><div class="jseo_portfolio_meta_item"><img src="' + themeDirURI + "/svg/gallery.svg" + '">Gallery Images<span>' + current_post_storage[z]['the_gallery_count'] + '</span></div></div> <div class="jseo_portfolio_button_options"><a href="' + current_post_storage[z]['the_permalink'] + '">Read More</a></div> </div></div>';
                            } else if(jseo_portfolio_content.classList.contains("vplain")) {
                                let telemetry = '<div class="vplain_telemetry"><div class="vplain_telemetry_column"><span class="numforlooks">' + thenumformatted + '</span></div><div class="vplain_telemetry_column"><ul class="vplain_telemetry_list"><li><img src="' + themeDirURI + "/svg/calendar.svg" + '"><span>' + current_post_storage[z]['the_date'] + '</span></li><li><img src="' + themeDirURI + "/svg/user.svg" + '"><span>' + current_post_storage[z]['the_author'] + '</span></li><li><img src="' + themeDirURI + "/svg/gallery.svg" + '"><span>Gallery: ' + current_post_storage[z]['the_gallery_count'] + '</span></li></ul></div></div>';
                                jseo_portfolio_content.innerHTML += '<div class="jseo_column vplain_animation"><a href="' + current_post_storage[z]['the_permalink']  + '" class="vplain_image"><img src="' + current_post_storage[z]['the_featured_image'] + '">' + telemetry + '</a> <div class="vplain_information"><a href="' + current_post_storage[z]['the_permalink'] + '" class="jseo_portfolio_title">' + current_post_storage[z]['the_title'] + '</a><p class="jseo_portfolio_description">' + current_post_storage[z]['the_excerpt'].substring(0, 100) + '</p></div></div>';
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
            load_portfolio('all');
        } else {
            load_portfolio(filterParam);
        }
    }

    function inject_portfolio_ui_controls() {
        console.log("Injecting portfolio UI controls...");

        jseo_portfolio_prevOpt.addEventListener("click", function(){

        });

        jseo_portfolio_nextOpt.addEventListener("click", function(){
            
        });
    }

    if(jseo_portfolio_catui != null && jseo_portfolio_prevOpt != null && jseo_portfolio_nextOpt != null) {
        inject_portfolio_ui_controls();
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
        let jseo_current_featured = this.dataset.featured;
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
                    jseo_lightbox_image.style.height = "100%";
                    jseo_lightbox_video.style.height = "0%";
                    jseo_lightbox_pdf.style.height = "0%";
                }

                if(jseo_lightbox_image != null) {
                    if(jseo_lightbox_image.classList.contains("show") == false) {
                        jseo_lightbox_image.classList.add("show");
                    }
    
                    if(jseo_current_featured != null && jseo_current_featured != "" && jseo_current_featured != "-1") {
                        if(jseo_lbimage_img != null) {
                            jseo_lbimage_img.src = jseo_current_featured;
                        }
                    }
                }
    
                if(jseo_lbimage_title != null) {
                    jseo_lbimage_title.innerHTML = jseo_current_title;
                }       
            } else if(jseo_current_mode == 1) {
                if(jseo_lightbox_image != null && jseo_lightbox_video != null && jseo_lightbox_pdf != null) {
                    jseo_lightbox_image.style.height = "0%";
                    jseo_lightbox_video.style.height = "100%";
                    jseo_lightbox_pdf.style.height = "0%";
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

                if(jseo_lightbox_video_container != null) {
                    setTimeout(function(){
                        if(jseo_lightbox_video_container.classList.contains("show") == false) {
                            jseo_lightbox_video_container.classList.add("show")
                        }
                    }, 100);
                }

            } else if(jseo_current_mode == 2) {
                if(jseo_lightbox_image != null && jseo_lightbox_video != null && jseo_lightbox_pdf != null) {
                    jseo_lightbox_image.style.height = "0%";
                    jseo_lightbox_video.style.height = "0%";
                    jseo_lightbox_pdf.style.height = "100%";
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
                            jseo_pdfreader_container.innerHTML = '<iframe src="https://jennjunseo.com/staging/pdfjs/web/viewer.html?file=/' + cfile_split[1] + '">';
                        }
                    }
                }

                if(jseo_lbpdf_title != null) {
                    jseo_lbpdf_title.innerHTML = jseo_current_title;
                }  

                if(jseo_lightbox_pdf_container != null) {
                    setTimeout(function(){
                        if(jseo_lightbox_pdf_container.classList.contains("show") == false) {
                            jseo_lightbox_pdf_container.classList.add("show")
                        }
                    }, 100);
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
        }, 1000);
    }

    function jseo_lbui_zoomfunc(override = false) {

        if(jseo_lightbox_image.classList.contains("show") || override == true) {
            jseo_lightbox_zoom *= -1;

            if(jseo_lightbox_zoom == 1) {
                if(jseo_lbimage_img != null) {
                    if(jseo_lbimage_img.classList.contains("zoom") == false) {
                        jseo_lbimage_img.classList.add("zoom");
                    }
                }
            } else if(jseo_lightbox_zoom == -1) {
                if(jseo_lbimage_img != null) {
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

            jseo_lbimage_img.style.transform = 'translateX(' + jseo_lbimage_x + '%) translateY(' + jseo_lbimage_y + '%) scale(2.0)';
        }
        
    }

    function vplain_animation() {
        let vplain_link = document.getElementsByClassName("vplain_animation");
        
        for(i = 0; i < vplain_link.length; i++) {
            doSetVPlainTimeOut(vplain_link[i], i);
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

//     // intial params
// let pdf ;
// let canvas;
// let isPageRendering;
// let  pageRenderingQueue = null;
// let canvasContext;
// let totalPages;
// let currentPageNum = 1;

// // events
// function triggerpdfload(thefile) {
//     document.getElementById("loader").style.display = "block";
//     isPageRendering= false;
//     pageRenderingQueue = null;
//     canvas = document.getElementById('pdf_canvas');
//     canvasContext = canvas.getContext('2d');
    
//     initEvents();
//     initPDFRenderer(thefile);
// }

// function initEvents() {
//     let prevPageBtn = document.getElementById('prev_page');
//     let nextPageBtn = document.getElementById('next_page');
//     let goToPage = document.getElementById('go_to_page');
//     prevPageBtn.addEventListener('click', renderPreviousPage);
//     nextPageBtn.addEventListener('click',renderNextPage);
//     goToPage.addEventListener('click', goToPageNum);
// }

// // init when window is loaded
// function initPDFRenderer(thefile) {
    
//     var url = thefile;

//     // const url = 'test1.pdf'; // replace with your pdf location

//     let option  = { url};
    

//     pdfjsLib.getDocument(option).promise.then(pdfData => {
//         totalPages = pdfData.numPages;
//         let pagesCounter= document.getElementById('total_page_num');
//         pagesCounter.textContent = totalPages;
//         // assigning read pdfContent to global variable
//         pdf = pdfData;
//         renderPage(currentPageNum);
//     });
// }

// function renderPage(pageNumToRender = 1, scale = 1) {
//     isPageRendering = true;
//     document.getElementById('current_page_num').textContent = pageNumToRender;
//     pdf.getPage(pageNumToRender).then(page => {
//         document.getElementById("loader").style.display = "none";
//         const viewport = page.getViewport({scale :1});
//         canvas.height = viewport.height;
//         canvas.width = viewport.width;  
//         let renderCtx = {canvasContext ,viewport};
//         page.render(renderCtx).promise.then(()=> {
//             isPageRendering = false;
//             if(pageRenderingQueue !== null) { // this is to check of there is next page to be rendered in the queue
//                 renderPage(pageNumToRender);
//                 pageRenderingQueue = null; 
//             }
//         });        
//     }); 
// }

// function renderPageQueue(pageNum) {
//     if(pageRenderingQueue != null) {
//         pageRenderingQueue = pageNum;
//     } else {
//         renderPage(pageNum);
//     }
// }

// function renderNextPage(ev) {
//     if(currentPageNum >= totalPages) {
//         alert("This is the last page");
//         return ;
//     } 
//     currentPageNum++;
//     renderPageQueue(currentPageNum);
// }

// function renderPreviousPage(ev) {
//     if(currentPageNum<=1) {
//         alert("This is the first page");
//         return ;
//     }
//     currentPageNum--;
//     renderPageQueue(currentPageNum);
// }

// function goToPageNum(ev) {
//     let numberInput = document.getElementById('page_num');
//     let pageNumber = parseInt(numberInput.value);
//     if(pageNumber) {
//         if(pageNumber <= totalPages && pageNumber >= 1){
//             currentPageNum = pageNumber;
//             numberInput.value ="";
//             renderPageQueue(pageNumber);
//             return ;
//         }
//     }
//         alert("Enter a valide page numer");
// }

});