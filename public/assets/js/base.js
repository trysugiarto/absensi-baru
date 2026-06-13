///////////////////////////////////////////////////////////////////////////
// SERVICE WORKER DINONAKTIFKAN SEMENTARA
///////////////////////////////////////////////////////////////////////////

// if ('serviceWorker' in navigator) {
//     window.addEventListener('load', async () => {
//         try {
//             await navigator.serviceWorker.register('/service-worker.js');
//             console.log('Service Worker aktif');
//         } catch (error) {
//             console.log('Service Worker gagal:', error);
//         }
//     });
// }
///////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////
// PAGE LOADER
///////////////////////////////////////////////////////////////////////////

$(document).ready(function () {

    setTimeout(() => {

        $("#loader").fadeOut(250);

    }, 700);

});
///////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////
// FIX HREF #
///////////////////////////////////////////////////////////////////////////

$('a[href="#"]').click(function (e) {

    e.preventDefault();

});
///////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////
// GO TOP BUTTON
///////////////////////////////////////////////////////////////////////////

$(".goTop").click(function (event) {

    event.preventDefault();

    $("html, body").animate({
        scrollTop: 0
    }, "slow");

});

function goDownButton() {

    var scrollD = $(window).scrollTop();

    if (scrollD > 350) {

        $(".goTop.button").addClass("show");

    } else {

        $(".goTop.button").removeClass("show");

    }
}

goDownButton();

$(window).scroll(function () {

    goDownButton();

});
///////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////
// GO BACK BUTTON
///////////////////////////////////////////////////////////////////////////

$(".goBack").click(function () {

    window.history.back();

});
///////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////
// TOOLTIP
///////////////////////////////////////////////////////////////////////////

$(function () {

    $('[data-toggle="tooltip"]').tooltip();

});
///////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////
// INPUT FORM
///////////////////////////////////////////////////////////////////////////

$(".clear-input").click(function () {

    $(this)
        .parent(".input-wrapper")
        .find(".form-control")
        .focus();

    $(this)
        .parent(".input-wrapper")
        .find(".form-control")
        .val("");

    $(this)
        .parent(".input-wrapper")
        .removeClass("not-empty");

});

$(".form-group .form-control")
    .focus(function () {

        $(this)
            .parent(".input-wrapper")
            .addClass("active");

    })
    .blur(function () {

        $(this)
            .parent(".input-wrapper")
            .removeClass("active");

    });

$(".form-group .form-control").keyup(function () {

    var inputCheck = $(this).val().length;

    if (inputCheck > 0) {

        $(this)
            .parent(".input-wrapper")
            .addClass("not-empty");

    } else {

        $(this)
            .parent(".input-wrapper")
            .removeClass("not-empty");

    }

});
///////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////
// SEARCHBOX
///////////////////////////////////////////////////////////////////////////

$(".toggle-searchbox").click(function () {

    if ($("#search").hasClass("show")) {

        $("#search").removeClass("show");

    } else {

        $("#search").addClass("show");

        $("#search .form-control").focus();

    }

});
///////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////
// OWL CAROUSEL
///////////////////////////////////////////////////////////////////////////

if (typeof $.fn.owlCarousel !== 'undefined') {

    $('.carousel-full').owlCarousel({
        loop: true,
        margin: 0,
        nav: false,
        items: 1,
        dots: false,
    });

    $('.carousel-single').owlCarousel({
        stagePadding: 30,
        loop: true,
        margin: 16,
        nav: false,
        dots: false,
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 3,
            }
        }
    });

    $('.carousel-multiple').owlCarousel({
        stagePadding: 32,
        loop: true,
        margin: 16,
        nav: false,
        items: 2,
        dots: false,
        responsive: {
            0: {
                items: 2,
            },
            768: {
                items: 4,
            }
        }
    });

}
///////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////
// TOAST
///////////////////////////////////////////////////////////////////////////

function toastbox(target, time) {

    var a = "#" + target;

    $(".toast-box").removeClass("show");

    setTimeout(() => {

        $(a).addClass("show");

    }, 100);

    if (time) {

        time = time + 100;

        setTimeout(() => {

            $(".toast-box").removeClass("show");

        }, time);

    }

}

$(".toast-box .close-button").click(function (event) {

    event.preventDefault();

    $(".toast-box.show").removeClass("show");

});

$(".toast-box.tap-to-close").click(function () {

    $(this).removeClass("show");

});
///////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////
// HEADER SCROLLED
///////////////////////////////////////////////////////////////////////////

function animatedHeader() {

    var scrollS = $(window).scrollTop();

    if (scrollS > 20) {

        $(".appHeader.scrolled").addClass("is-active");

    } else {

        $(".appHeader.scrolled").removeClass("is-active");

    }

}

animatedHeader();

$(window).scroll(function () {

    animatedHeader();

});
///////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////
// OFFLINE / ONLINE MODE
///////////////////////////////////////////////////////////////////////////

var OnlineText = "Connected to Internet";
var OfflineText = "No Internet Connection";

window.addEventListener('online', function () {

    console.log(OnlineText);

});

window.addEventListener('offline', function () {

    console.log(OfflineText);

});
///////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////
// DARK MODE
///////////////////////////////////////////////////////////////////////////

var checkDarkModeStatus =
    localStorage.getItem("MobilekitDarkModeActive");

if (checkDarkModeStatus === "1") {

    $(".dark-mode-switch").prop('checked', true);

    $("body").addClass("dark-mode-active");

}

$('.dark-mode-switch').change(function () {

    if ($(this).is(':checked')) {

        $("body").addClass("dark-mode-active");

        localStorage.setItem("MobilekitDarkModeActive", "1");

    } else {

        $("body").removeClass("dark-mode-active");

        localStorage.setItem("MobilekitDarkModeActive", "0");

    }

});
///////////////////////////////////////////////////////////////////////////