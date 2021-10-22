$(document).ready(function () {

    "use strict";

    // ------------------------------------------------------- //
    // For demo purposes only
    // ------------------------------------------------------ //

    var stylesheet = $("link#theme-stylesheet");
    $("<link id='new-stylesheet' rel='stylesheet'>").insertAfter(stylesheet);
    var alternateColour = $("link#new-stylesheet");

    if ($.cookie("theme_csspath")) {
        alternateColour.attr("href", $.cookie("theme_csspath"));
    }

    $("#colour").change(function () {

        if ($(this).val() !== "") {

            var themeCsspath = "css/style." + $(this).val() + ".css";

            alternateColour.attr("href", themeCsspath);

            $.cookie("theme_csspath", themeCsspath, {
                expires: 365,
                path: document.URL.substr(0, document.URL.lastIndexOf("/"))
            });

        }

        return false;
    });


    // ---------------------------------------------- //
    // Preventing URL update on navigation link click
    // ---------------------------------------------- //
    $(".link-scroll").bind("click", function (e) {
        var anchor = $(this);
        $("html, body").stop().animate({
            scrollTop: $(anchor.attr("href")).offset().top + 2
        }, 700);
        e.preventDefault();
    });


    // ---------------------------------------------- //
    // FancyBox
    // ---------------------------------------------- //
    $("[data-fancybox]").fancybox();


    // ---------------------------------------------- //
    // Divider Section Parallax Background
    // ---------------------------------------------- //
    $(window).on("scroll", function () {

        var scroll = $(this).scrollTop();

        if ($(window).width() > 1250) {
            $("section.divider").css({
                "background-position": "left -" + scroll / 8 + "px"
            });
        } else {
            $("section.divider").css({
                "background-position": "center bottom"
            });
        }
    });


    // ---------------------------------------------- //
    // Navbar Toggle Button
    // ---------------------------------------------- //
    $(".navbar-toggler").on("click", function () {
        $(".navbar-toggler").toggleClass("active");
    });

});
