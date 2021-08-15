jQuery( document ).ready(function() {
    let eccent_mobile_holder = document.getElementById("eccent_mobile_holder");
    let eccent_toggle = document.getElementById("eccent_toggle");
    let eccent_mobile_close = document.getElementById("eccent_mobile_close");
    let eccent_menu_mobile = document.getElementById("eccent_menu_mobile");
    let jseo_portfolio_content = document.getElementById("jseo_portfolio_content");
    let jseo_portfolio_catui = document.getElementById("jseo_portfolio_catui");
    let jseo_pagination = document.getElementById("jseo_pagination");
    let jseo_footer = document.getElementById("jseo_footer");
    let jseo_portfolio_all = document.getElementById("jseo_portfolio_all");

    let current_post_storage = [];
    let current_entry_max = 0;
    let no_of_pages = 0;
    let current_page = 0;
    let voff_init = false;

    let urlParams = new URLSearchParams(window.location.search);
    let filterParam = urlParams.get('filter');

    eccent_toggle.addEventListener("click", eccent_show_navigation);
    eccent_mobile_close.addEventListener("click", eccent_hide_navigation);

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
            if(current_post_storage[z] != null) {
                if(jseo_portfolio_content.classList.contains("grid")) {
                    jseo_portfolio_content.innerHTML += '<div class="jseo_column jseo_grid_link"><a href="' + current_post_storage[z]['the_permalink'] + '"><img src="' + current_post_storage[z]['the_featured_image'] + '"><span class="jseo_portfolio_title">' + current_post_storage[z]['the_title'] + '</span></a></div>';
                } else if(jseo_portfolio_content.classList.contains("voffset")) {
                    jseo_portfolio_content.innerHTML += '<div class="jseo_column voff_animation"><div class="jseo_voffset_f1"><a href="' + current_post_storage[z]['the_permalink'] + '"><img src="' + current_post_storage[z]['the_featured_image'] + '"></a></div><div class="jseo_voffset_f2"><a class="jseo_portfolio_title" href="' + current_post_storage[z]['the_permalink'] + '">' + current_post_storage[z]['the_title'] + '</a><p class="jseo_portfolio_description">' + current_post_storage[z]['the_excerpt'] + '</p><div class="jseo_portfolio_meta"><div class="jseo_portfolio_meta_item"><img src="' + themeDirURI + "/svg/calendar.svg" + '">' + current_post_storage[z]['the_date'] + '</div><div class="jseo_portfolio_meta_item"><img src="' + themeDirURI + "/svg/gallery.svg" + '">Gallery Images<span>' + current_post_storage[z]['the_gallery_count'] + '</span></div><div class="jseo_portfolio_meta_item"><img src="' + themeDirURI + "/svg/download-to-storage-drive.svg" + '">Files<span>' + current_post_storage[z]['the_files_count'] + '</span></div><div class="jseo_portfolio_meta_item"><img src="' + themeDirURI + "/svg/collaboration.svg" + '">Collaborators<span>' + current_post_storage[z]['the_collab_count'] + '</span></div> </div> <div class="jseo_portfolio_button_options"><a href="' + current_post_storage[z]['the_permalink'] + '">Read More</a></div> </div></div>';
                } else if(jseo_portfolio_content.classList.contains("vplain")) {
                    // jseo_portfolio_content.innerHTML = jseo_portfolio_content.innerHTML + '<div class="jseo_column"><a href="' + current_post_storage[z]['the_permalink'] + '"><img src="' + current_post_storage[z]['the_featured_image'] + '"><span class="jseo_portfolio_title">' + current_post_storage[z]['the_title'] + '</span></a></div>';
                }
            } 
        }

        if(jseo_portfolio_content.classList.contains("voffset")) {
            voff_animation();
        }

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
                    } else if(slug == 'game-design') {
                        jseo_portfolio_content.classList.add("voffset");
                    } else if(slug == 'uiux-design') {
                        jseo_portfolio_content.classList.add("vplain");
                    } else {
                        slug = 'all';
                        jseo_portfolio_content.classList.add("grid");
                    }

                    for(z = 0; z < current_entry_max; z++) {
                        if(current_post_storage[z] != null) {
                            if(jseo_portfolio_content.classList.contains("grid")) {
                                jseo_portfolio_content.innerHTML += '<div class="jseo_column jseo_grid_link"><a href="' + current_post_storage[z]['the_permalink'] + '"><img src="' + current_post_storage[z]['the_featured_image'] + '"><span class="jseo_portfolio_title">' + current_post_storage[z]['the_title'] + '</span></a></div>';
                            } else if(jseo_portfolio_content.classList.contains("voffset")) {
                                jseo_portfolio_content.innerHTML += '<div class="jseo_column voff_animation"><div class="jseo_voffset_f1"><a href="' + current_post_storage[z]['the_permalink'] + '"><img src="' + current_post_storage[z]['the_featured_image'] + '"></a></div><div class="jseo_voffset_f2"><a class="jseo_portfolio_title" href="' + current_post_storage[z]['the_permalink'] + '">' + current_post_storage[z]['the_title'] + '</a><p class="jseo_portfolio_description">' + current_post_storage[z]['the_excerpt'] + '</p><div class="jseo_portfolio_meta"><div class="jseo_portfolio_meta_item"><img src="' + themeDirURI + "/svg/calendar.svg" + '">' + current_post_storage[z]['the_date'] + '</div><div class="jseo_portfolio_meta_item"><img src="' + themeDirURI + "/svg/gallery.svg" + '">Gallery Images<span>' + current_post_storage[z]['the_gallery_count'] + '</span></div><div class="jseo_portfolio_meta_item"><img src="' + themeDirURI + "/svg/download-to-storage-drive.svg" + '">Files<span>' + current_post_storage[z]['the_files_count'] + '</span></div><div class="jseo_portfolio_meta_item"><img src="' + themeDirURI + "/svg/collaboration.svg" + '">Collaborators<span>' + current_post_storage[z]['the_collab_count'] + '</span></div> </div> <div class="jseo_portfolio_button_options"><a href="' + current_post_storage[z]['the_permalink'] + '">Read More</a></div> </div></div>';
                            } else if(jseo_portfolio_content.classList.contains("vplain")) {
                                // jseo_portfolio_content.innerHTML = jseo_portfolio_content.innerHTML + '<div class="jseo_column"><a href="' + current_post_storage[z]['the_permalink'] + '"><img src="' + current_post_storage[z]['the_featured_image'] + '"><span class="jseo_portfolio_title">' + current_post_storage[z]['the_title'] + '</span></a></div>';
                            }
                        } 
                    }

                    if(jseo_portfolio_content.classList.contains("voffset")) {
                        voff_animation();
                    }

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

    function grid_animation() {
        let jseo_grid_link = document.getElementsByClassName("jseo_grid_link");
        
        for(i = 0; i < jseo_grid_link.length; i++) {
            doSetGridTimeOut(jseo_grid_link[i], i);
        }
    }

    function voff_animation() {
        if(voff_init == false) {
            voff_init = true;
            window.addEventListener('scroll',(event) => {
                console.log('Scrolling...');
                let voff_animation = document.getElementsByClassName("voff_animation");
                for(v = 0; v < voff_animation.length; v++) {
                    if(isElementInViewport(voff_animation[v])) {
                        voff_animation[v].classList.add("show");
                    }
                }
            });

            window.addEventListener('resize', function(){
                console.log('Resizing...');
                let voff_animation = document.getElementsByClassName("voff_animation");
                for(v = 0; v < voff_animation.length; v++) {
                    if(isElementInViewport(voff_animation[v])) {
                        voff_animation[v].classList.add("show");
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

    function doSetGridTimeOut(gridobject, multiplier) {
        setTimeout(function() { gridobject.classList.add("show") }, multiplier * 100);
    }

    function isElementInViewport(el) {

        // Special bonus for those using jQuery
        if (typeof jQuery === "function" && el instanceof jQuery) {
            el = el[0];
        }
    
        var rect = el.getBoundingClientRect();
        console.log(rect);
    
        return (
            rect.top < window.innerHeight && rect.bottom >= 0
        );
    }

});