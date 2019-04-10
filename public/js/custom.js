$(document).ready(function() {
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('#scroll').fadeIn();
        } else {
            $('#scroll').fadeOut();
        }
    });
    $('#scroll').click(function() {
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });
});

$(function () {
    $('a[href="#search"]').on('click', function(event) {
        event.preventDefault();
        $('#search').addClass('open');
        $('#search > form > input[type="search"]').focus();
    });

    $('#search, #search button.close').on('click keyup', function(event) {
        if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
            $(this).removeClass('open');
        }
    });
    
});

// $(document).ready(function(){
//     $("#galery-divisi").hide();
//
//     $("#divisi-post").click(function(){
//         $("#galery-divisi").hide();
//         $("#divisi-post").addClass("active");
//         $("#post-divisi").show();
//         $("#divisi-galery").removeClass("active");
//
//     });
//     $("#divisi-galery").click(function(){
//         $("#post-divisi").hide();
//         $("#divisi-galery").addClass("active")
//         $("#galery-divisi").show();
//         $("#divisi-post").removeClass("active");
//
//     });
//
// });
//
// $(document).ready(function(){
//     $("#galery-divisi2").hide();
//
//     $("#divisi-post2").click(function(){
//         $("#galery-divisi2").hide();
//         $("#divisi-post2").addClass("active");
//         $("#post-divisi2").show();
//         $("#divisi-post2").removeClass("active");
//     });
//     $("#divisi-galery2").click(function(){
//         $("#post-divisi2").hide();
//         $("#divisi-galery2").addClass("active");
//         $("#galery-divisi2").show();
//         $("#divisi-post2").removeClass("active");
//
//     });
//
// });

// // galery
// $(function(){
//     var $gallery = $('.gallery a').simpleLightbox();
//
//     $gallery.on('show.simplelightbox', function(){
//         console.log('Requested for showing');
//     })
//         .on('shown.simplelightbox', function(){
//             console.log('Shown');
//         })
//         .on('close.simplelightbox', function(){
//             console.log('Requested for closing');
//         })
//         .on('closed.simplelightbox', function(){
//             console.log('Closed');
//         })
//         .on('change.simplelightbox', function(){
//             console.log('Requested for change');
//         })
//         .on('next.simplelightbox', function(){
//             console.log('Requested for next');
//         })
//         .on('prev.simplelightbox', function(){
//             console.log('Requested for prev');
//         })
//         .on('nextImageLoaded.simplelightbox', function(){
//             console.log('Next image loaded');
//         })
//         .on('prevImageLoaded.simplelightbox', function(){
//             console.log('Prev image loaded');
//         })
//         .on('changed.simplelightbox', function(){
//             console.log('Image changed');
//         })
//         .on('nextDone.simplelightbox', function(){
//             console.log('Image changed to next');
//         })
//         .on('prevDone.simplelightbox', function(){
//             console.log('Image changed to prev');
//         })
//         .on('error.simplelightbox', function(e){
//             console.log('No image found, go to the next/prev');
//             console.log(e);
//         });
// });
