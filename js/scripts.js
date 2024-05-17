jQuery(document).ready(function($) {
    $('#enter-chat').on('click', function() {
        var userName = $('#user-name').val();
        if (userName) {
            $('#lifecity-youtube-name-input').hide();
            $('#lifecity-youtube-chat').show();
        } else {
            alert('Please enter your name.');
        }
    });
});
