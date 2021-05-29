let eccent_mobile_holder = document.getElementById("eccent_mobile_holder");
let eccent_toggle = document.getElementById("eccent_toggle");
let eccent_mobile_close = document.getElementById("eccent_mobile_close");
let eccent_menu_mobile = document.getElementById("eccent_menu_mobile");
let jseo_portfolio = document.getElementById("jseo_portfolio");

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