$(function() {
    $('.bg-video').videoBG({
        mp4:'../../../bundles/app/video/tunnel_animation.mp4',
        ogv:'../../../bundles/app/video/tunnel_animation.ogv',
        webm:'../../../bundles/app/video/tunnel_animation.webm',
        poster:'../../../bundles/app/video/tunnel_animation.jpg',
        scale:true
    });
    $('.intro, header').css('height', $(".videoBG_wrapper").height());
});
