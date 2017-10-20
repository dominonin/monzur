$(document).ready(function () {
    $.get("ajax/getNav.php",
        function (data) {
            $("body").prepend(JSON.parse(data));
            $("[href='" + getCurrentPage() + "']").parent("li").addClass("active");
        });

    $.get("ajax/getFooter.php",
        function (data) {
            $("body").append(JSON.parse(data));
        });

});


function getCurrentPage() {
    return document.location.pathname.match(/[^\/]+$/)[0];
}