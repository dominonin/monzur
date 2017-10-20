$(document).ready(getContent());

function getContent() {
    $.get(
        "ajax/getAboutContent.php",
        function(data) {
            var json = JSON.parse(data);
            insertData(json);
        }
    )
}

function insertData(data) {
    $(".container img").attr("src", data.image_path);
    $("#about").html(data.about_body);
}