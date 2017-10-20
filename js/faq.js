$(document).ready(getContent());

function getContent() {
    $.get(
        "ajax/getFAQ.php",
        function (data) {
            var json = JSON.parse(data);
            insertData(json);
        }
    )
}

function insertData(data) {
    for (var i = 0; i < data.title.length; i++) {
        var body = "<div class='panel panel-default'><div class='panel-heading'><h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordion' href=#" + i + ">" + data.title[i] + "</a></div></h4></div><div id='" + i + "' class='panel-collapse collapse'><div class='panel-body'>" + data.body[i] + "</div></div></div>";
        console.log(body);
        $("#accordion").append(body);
    }
}