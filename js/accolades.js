function getAccolades() { // Gets all images as JSON request, returns as array
    $.get("ajax/getAllAccolades.php",
        function (data) {
            printAccolades(JSON.parse(data));
        });
}

function printAccolades(jsondata) {
    for (i = 0; i < jsondata.length; i++) { // parse thru images, add to row, set properties
        $("#accolades").append("<img>");
        $("#accolades img:last").attr("id", jsondata[i].id);
        $("#accolades img:last").attr("type", jsondata[i].type);

        if (jsondata[i].type === "Video") {
            $("#accolades img:last").attr("src", jsondata[i].thumb);
            $("#accolades img:last").attr("path", jsondata[i].path);
        }

        else {

            $("#accolades img:last").attr("src", jsondata[i].path);
        }

        $("#accolades img:last").attr("alt", jsondata[i].title);
        $("#accolades img:last").attr("caption", jsondata[i].caption);
        $("#accolades img:last").attr("year", jsondata[i].year);
    }
}

function clearModal() {
    $("#accolade-photo-modal img").attr("src", "");
    $("#accolade-video-modal .embed-responsive-item").attr("src", "");
}



$(document).ready(function () {
    $.post("ajax/getMediaYears.php",
        {
            media: "accolades"
        },
        function (data) {
            json = JSON.parse(data);
            for (var i = 0; i < json.length; i++) {
                $("#accolade_year").append("<option>" + json[i].year + "</option>");
            }
        });

    $("#accolade_year").on("change", function () {
        if ($("#accolade_year option:selected").text() == "All") {
            $("#accolades img").show();
        }

        else {
            $("#accolades img").show();
            $("#accolades img").not("[year=" + "'" + $("#accolade_year option:selected").text() + "']").hide();
        }
    });

    getAccolades();

    $('.modal').on('hidden.bs.modal', function () { // on modal close
        clearModal();
    });

    $("#accolades").on("click", "img", function () {
        if ($(this).attr("type") == "Video") {
            $("#accolade-video-modal .embed-responsive-item").attr("src", $(this).attr("path"));
            $("#accolade-video-modal h4").html($(this).attr("alt"));
            $("#accolade-video-modal p").html($(this).attr("caption"));
            $("#accolade-video-modal").modal();
        }

        else {
            $("#accolade-photo-modal img").attr("src", $(this).attr("src"));
            $("#accolade-photo-modal h4").html($(this).attr("alt"));
            $("#accolade-photo-modal p").html($(this).attr("caption"));
            $("#accolade-photo-modal").modal();
        }

    });
});