jQuery(document).ready(function($) {
    $('.accordion h3').on('click', function() {
        $(this).next().slideToggle();
        $(this).toggleClass('active');
    });
});
