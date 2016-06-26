$(function() {
    $('.bg-video').videoBG({
        mp4:'assets/plugins/jquery-videoBG/assets/tunnel_animation.mp4',
        ogv:'assets/plugins/jquery-videoBG/assets/tunnel_animation.ogv',
        webm:'assets/plugins/jquery-videoBG/assets/tunnel_animation.webm',
        poster:'assets/plugins/jquery-videoBG/assets/tunnel_animation.jpg',
        scale:true
    });
    $('.intro, header').css('height', $(".videoBG_wrapper").height());
});
