function getImages() { // Gets all images as JSON request, returns as array
    $.get("ajax/getAllPhotos.php",
        function (data) {
            printImages(JSON.parse(data));
        });
}

function printImages(jsondata) {
    for (i = 0; i < jsondata.length; i++) { // parse thru images, add to row, set properties

        $("#images").append("<a data-fancybox='images' /></a>");
        $("#images a:last").append("<img " + "src='" + jsondata[i].path + "' />");
        $("#images a:last").attr("year", jsondata[i].year);
        $("#images a:last").attr("href", jsondata[i].path);
        $("#images a:last").data("caption", (jsondata[i].title + " <br> " + jsondata[i].caption));
    }
}

function getAllVideos() {
    $.get("ajax/getAllVideos.php",
        function (data) {
            displayVideos(JSON.parse(data));
        })
}

function displayVideos(jsondata) {

    for (var i = 0; i < jsondata.length; i++) {
        $("#videos").append("<a data-fancybox></a>");
        $("#videos a:last").attr("href", jsondata[i].path);
        $("#videos a:last").attr("year", jsondata[i].year);
        $("#videos a:last").append("<img src='" + jsondata[i].thumb + "'>");
        $("#videos a:last").data("caption", (jsondata[i].title + " <br> " + jsondata[i].caption));
    }
}

function displayYears(mediaType) {
    switch (mediaType) {
        case "photos":
            $.post("ajax/getMediaYears.php",
                {
                    media: mediaType
                },
                function (data) {
                    json = JSON.parse(data);
                    for (var i = 0; i < json.length; i++) {
                        $("#photo_year").append("<option>" + json[i].year + "</option>");
                    }
                });
            break;

        case "videos":
            $.post("ajax/getMediaYears.php",
                {
                    media: mediaType
                },
                function (data) {
                    json = JSON.parse(data);
                    for (var i = 0; i < json.length; i++) {
                        $("#video_year").append("<option>" + json[i].year + "</option>");
                    }
                });
            break;

        default:
            console.log("Invalid selection");
            break;
    }
}

function registerYearClickEvent() {
    $("#photo_year").on("change", function () {
        if ($("#photo_year option:selected").text() == "All") {
            $("#images a").show();
        }

        else {
            $("#images a").show();
            $("#images a").not("[year=" + "'" + $("#photo_year option:selected").text() + "']").hide();
        }
    });

    $("#video_year").on("change", function () {
        if ($("#video_year option:selected").text() == "All") {
            $("#videos a").show();
        }

        else {
            $("#videos a").show();
            $("#videos a").not("[year=" + "'" + $("#video_year option:selected").text() + "']").hide();
        }
    });
}


$(document).ready(function () {
    getImages();
    getAllVideos();
    displayYears("photos");
    displayYears("videos");


    registerYearClickEvent();
});