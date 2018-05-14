$(document).ready(function () {
    $('form').on('submit', function (e) {
        e.preventDefault();

        console.log($(this).serialize());
    });
});