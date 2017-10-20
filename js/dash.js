var dropzone;

$(document).ready(function () {
    $.ajaxSetup({ cache: false });

    tinymce.init({
        selector: '#about-body',
        inline: true,
        plugins: 'code',  // note the comma at the end of the line!
        toolbar: 'code',
        setup: function (editor) {
            editor.on('click', function (e) {
                editor.init_content = editor.getContent();
            });
        }
    });
    Dropzone.autoDiscover = false;
    dropzone = new Dropzone("#upload_form", { url: "upload.php" });

    registerPhotoEditorEvent();
    registerVideoEditorEvent();
    registerAccoladeEditorEvent();
    registerFAQEditorEvent();
    registerOverviewEvent();
    registerEditEvent();
    registerUpdateEvent();
    registerDeleteEvent();
    registerEditCancelEvent();
    registerDeleteConfirmEvent();
    registerSettingsEvent();
    registerAboutEditorEvent();
    registerAboutEditButtonEvent();
    registerAboutEditCancelEvent();
    registerAboutEditConfirmEvent();
    registerLogoutButton();
    registerSettingsCloseEvent();
    registerBGChangeSubmit();
    registerVBGChangeSubmit();
    registerAudioChangeSubmit();
    registerAddButtonEvent();
    registerMinusButtonEvent();
    registerReorderButtonEvent();
    registerTextChangeSubmit();
    populateStats();

});

function populateTable(jsonData) { // TODO: make this work with the other stuff - modularize (switch???)
    var tags = "<img src='' width='100px' height='100px'>";

    for (var i = 0; i < jsonData.length; i++) {

        $("#editor tbody").append("<tr id=" + jsonData[i].id + " type=" + jsonData[i].type + "></tr>"); // unqiue col identifier
        $("#editor tbody tr:last").html("<td class='media'></td><td class='title'><textarea class='form-control' disabled='true'></textarea></td><td class='caption'><textarea class='form-control' disabled='true'></textarea></td><td class='year'><textarea disabled='true' class='form-control'></textarea></td><td class='operations'></td>"); // prep rows

        $("#editor tbody tr:last .media").html(tags); // images

        if (jsonData[i].type === "Video") {
            $("#editor tbody tr:last .media [src]").attr("src", jsonData[i].thumb);
            $("#editor tbody tr:last .media [src]").attr("path", jsonData[i].path);
        }
        else {
            $("#editor tbody tr:last .media [src]").attr("src", "../" + jsonData[i].path);
        }
        $("#editor tbody tr:last .title textarea").html(jsonData[i].title); // title

        $("#editor tbody tr:last .caption textarea").html(jsonData[i].caption); // caption


        $("#editor tbody tr:last .year textarea").html(jsonData[i].year);


        $("#editor tbody tr:last .operations").html("<button id='edit'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button><button id='delete'><span class='glyphicon glyphicon-trash' aria-hidden='true'</button><button id='confirm'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span></button><button id='cancel'><span class='glyphicon glyphicon-remove' aria-hidden='true'</button>");
        $("#editor tbody tr:last .operations #confirm").hide(); // buttons n stuff
        $("#editor tbody tr:last .operations #cancel").hide();
    }

}

function preparePopulate(mediaType) {
    switch (mediaType) {
        case "photos":
            $("#editor .sub-header").html("Photo Gallery Editor");
            $("#editor #content").html("Photo");
            break;
        case "accolades":
            $("#editor .sub-header").html("Accolade Gallery Editor");
            $("#editor #content").html("Accolade");
            break;
        case "videos":
            $("#editor .sub-header").html("Video Gallery Editor");
            $("#editor #content").html("Video");
            break;
        case "faq":
            $("#editor .sub-header").html("FAQ Editor");
            $("#editor #content").html("");
            break;
        default:
            console.log("No suitable media");
            break;
    }
}


function registerPhotoEditorEvent() {
    $("[href='#photos']").on("click", function () { // Show editor on click
        hideElements();
        $(this).parent("li").addClass("active");

        preparePopulate("photos");

        $("#editor").hide();
        $("#editor tbody").empty();
        $("#about-body").empty();

        $.get("../ajax/getAllPhotos.php",
            function (data) {
                populateTable(JSON.parse(data));
                $("#editor").show();
                $("#add").show();
                $("#year").show();
                $("#reorder").show();
                $(".table").show();
                $(".table").attr("from", "photos");
            });

        $("#add").attr("add", "photo");

    });
}

function registerVideoEditorEvent() {
    $("[href='#videos']").on("click", function () { // Show editor on click
        hideElements();
        $(this).parent("li").addClass("active");

        preparePopulate("videos");

        $("#editor").hide();
        $("#editor tbody").empty();
        $("#about-body").empty();
        $("#add").attr("add", "video");

        $.get("../ajax/getAllVideos.php",
            function (data) {
                populateTable(JSON.parse(data));
                $("#add").show();
                $("#reorder").show();
                $("#year").show();
                $("#editor").show();
                $(".table").show();
                $(".table").attr("from", "videos");
            });
    });

}

function registerAccoladeEditorEvent() {
    $("[href='#accolades']").on("click", function () { // Show editor on click

        hideElements();
        $(this).parent("li").addClass("active");

        preparePopulate("accolades");

        $("#editor").hide();
        $("#editor tbody").empty();
        $("#about-body").empty();
        $("#add").attr("add", "accolade");

        $.get("../ajax/getAllAccolades.php",
            function (data) {
                populateTable(JSON.parse(data));
                $("#add").show();
                $("#reorder").show();
                $("#year").show();
                $("#editor").show();
                $(".table").show();
                $(".table").attr("from", "accolades");
            });
    });
}

function registerEditEvent() {
    $("#editor").on("click", "#edit", function () {
        $(this).closest("tr").find(".caption textarea").prop('disabled', false);
        $(this).closest("tr").find(".title textarea").prop('disabled', false);
        $(this).closest("tr").find(".year textarea").prop('disabled', false);
        $(this).closest("tr").find("#edit").hide();
        $(this).closest("tr").find("#delete").hide();
        $(this).closest("tr").find("#confirm").show();
        $(this).closest("tr").find("#cancel").show();
    });
}

function registerUpdateEvent() {
    $("#editor").on("click", "#confirm", function () { // get data for ajax request
        var title = $(this).closest("tr").find(".title textarea").val(); // get title
        var caption = $(this).closest("tr").find(".caption textarea").val(); //get caption
        var number = $(this).closest("tr").attr("id"); // get photo_num
        var type = $(this).closest("tr").attr("type");
        var from = $(".table").attr("from");
        var path;
        var url;
        var year = $(this).closest("tr").find(".year textarea").val(); // video year
        switch (from) {
            case "photos":
                url = "../ajax/updatePhoto.php";
                break;
            case "videos":
                url = "../ajax/updateVideo.php";
                break;
            case "accolades":
                url = "../ajax/updateAccolade.php";
                break;
            case "faq":
                url = "../ajax/updateFAQ.php";
                break;
            default:
                console.log("no suitable match");
                break;


        }


        $.post(url,
            {
                title: title,
                caption: caption,
                id: number,
                year: year
            },
            function (data) { // to do - on success, do green successful message box up top, on fail, do red, revert changes to box...
                if (data === "true") {
                    statusMessage("Update completed successfully!", "alert-success");
                }

                else {
                    statusMessage("Update failed! Refresh page and try again.", "alert-danger");
                    $(this).closest("tr").find(".title textarea").val($(this).closest("tr").find(".title textarea").text()); // restore text
                    $(this).closest("tr").find(".caption textarea").val($(this).closest("tr").find(".caption textarea").text());
                    $(this).closest("tr").find(".year textarea").val($(this).closest("tr").find(".year textarea").text());
                }

            });

        $(this).closest("tr").find("#confirm").hide(); // hide buttons
        $(this).closest("tr").find("#cancel").hide();
        $(this).closest("tr").find("#edit").show(); // show original ones
        $(this).closest("tr").find("#delete").show();
        $(this).closest("tr").find(".caption textarea").prop('disabled', true); // disable boxes
        $(this).closest("tr").find(".title textarea").prop('disabled', true);
        $(this).closest("tr").find(".year textarea").prop('disabled', true);
    });
}

function registerDeleteEvent() {
    $("#editor").on("click", "#delete", function () {

        $("#delete-modal img").attr("id", $(this).closest("tr").attr("id"));
        $("#delete-modal img").attr("type", $(this).closest("tr").attr("type"));
        $("#delete-modal img").attr("src", $(this).closest("tr").find(".media img").attr("src"));
        $("#delete-modal").modal();

    });
}

function registerEditCancelEvent() {
    $("#editor").on("click", "#cancel", function () { // cancel click
        $(this).closest("tr").find("#confirm").hide(); // hide buttons
        $(this).closest("tr").find("#cancel").hide();
        $(this).closest("tr").find("#edit").show(); // show original ones
        $(this).closest("tr").find("#delete").show();
        $(this).closest("tr").find(".caption textarea").prop('disabled', true); // disable boxes
        $(this).closest("tr").find(".title textarea").prop('disabled', true);
        $(this).closest("tr").find(".year textarea").prop('disabled', true);
        $(this).closest("tr").find(".title textarea").val($(this).closest("tr").find(".title textarea").text()); // restore text
        $(this).closest("tr").find(".caption textarea").val($(this).closest("tr").find(".caption textarea").text());
        $(this).closest("tr").find(".year textarea").val($(this).closest("tr").find(".year textarea").text());
    });
}

function registerDeleteConfirmEvent() {
    $("#delete-modal").on("click", "#delete-confirm", function () {
        var from = $(".table").attr("from");
        var number = $("#delete-modal img").attr("id");
        var path = $("#delete-modal img").attr("src");
        var media_type = $("#delete-modal img").attr("type");
        var url;
        switch (from) {
            case "photos":
                url = "../ajax/deletePhoto.php";
                break;
            case "videos":
                url = "../ajax/deleteVideo.php";
                break;
            case "accolades":
                url = "../ajax/deleteAccolade.php";
                break;
            case "faq":
                url = "../ajax/deleteFAQ.php";
                break;
            default:
                console.log("oh no");
                break;
        }

        $.post(url,
            {
                id: number,
                path: path,
                type: media_type
            },
            function (data) { // to do - on success, do green successful message box up top, on fail, do red, revert changes to box... AND ERASE OFF STORAGE
                console.log(data);
                var json = JSON.parse(data);

                if (media_type == "Photo") {

                    if (json.db == true && json.path == true) {
                        statusMessage("Content deleted succesfully!", "alert-success");
                        $("#editor tbody").empty();
                    }
                    else {
                        statusMessage("Delete failed! Refresh page and try again.", "alert-danger");
                        console.log("FAILED");
                    }

                }

                else {
                    if (json.db == true) {
                        statusMessage("Content Deleted Succesfully!", "alert-success");
                        $("#editor tbody").empty();
                        console.log("Bagel");
                    }

                    else {
                        statusMessage("Delete failed! Refresh page and try again.", "alert-danger");
                    }
                }

                $("#editor tbody").empty();
                $("#about-body").empty();

                switch (from) {
                    case "accolades":
                        $.get("../ajax/getAllAccolades.php",
                            function (data) {
                                populateTable(JSON.parse(data));
                                $("#editor").show();
                            });
                        break;
                    case "videos":
                        $.get("../ajax/getAllVideos.php",
                            function (data) {
                                populateTable(JSON.parse(data));
                                $("#editor").show();
                            });
                        break;
                    case "photos":
                        $.get("../ajax/getAllPhotos.php",
                            function (data) {
                                populateTable(JSON.parse(data));
                                $("#editor").show();
                            });
                        break;
                    case "faq":
                        $.get("../ajax/getFAQ.php",
                            function (data) {
                                preparePopulate("faq");
                                var json = JSON.parse(data);
                                populateFAQ(json);
                                $("#year").hide();
                                $("#add").show();
                                $("#reorder").show();
                                $("#editor").show();


                            });

                        break;
                }


            });

    });

}

function registerSettingsEvent() {
    $("#settings").on("click", function () {
        getSettingsModal();
    });
}

function registerAboutEditorEvent() {
    $("[href='#about']").on("click", function () { // Show editor on click
        hideElements();
        $(this).parent("li").addClass("active");

        $("#editor").hide();
        $("#editor tbody").empty();
        $("#about-body").empty();
        $("#editor #about-img").show();
        $("#editor #about-img img").empty();
        $.get("../ajax/getAboutContent.php",
            function (data) {
                populateAbout(JSON.parse(data));
                $(".sub-header").html("About Page Text Editor");
                $("#video-year-heading").hide();
                $(".year").hide();
                $("#editor").show();
                $("#upload_form").show();
                $("#add").hide();
            });
        $("#about-edit-btn").show();
        changePOST(dropzone, "upload.php", "photo");
        dropzone.off("success").on("success", function () {
            $("#about-body").empty();

            $.get("../ajax/getAboutContent.php",
                function (data) {
                    populateAbout(JSON.parse(data));
                    $(".sub-header").html("About Page Text Editor");
                    $("#video-year-heading").hide();
                    $(".year").hide();
                    $("#editor").show();
                    $("#upload_form").show();
                });
        });
    });

}

function registerAboutEditButtonEvent() {
    $("#about-edit-btn").click(function () {
        $("#about-edit-btn").hide();
        $("#about-edit-cancel").show();
        $("#about-edit-confirm").show();
        tinymce.get("about-body").show();
    });
}


function registerAboutEditConfirmEvent() {
    $("#about-edit-confirm").click(function () {
        var newBody = tinymce.get("about-body").getContent();
        $.post(
            "../ajax/updateAboutContent.php",
            {
                "about_body": newBody
            },
            function (data) {
                statusMessage(data, "alert-info");

            }
        );
        tinymce.get("about-body").hide();
        $("#about-edit-cancel").hide();
        $("#about-edit-confirm").hide();
        $("#about-edit-btn").show();
    });
}

function registerAboutEditCancelEvent() {
    $("#about-edit-cancel").click(function () {
        $("#about-edit-cancel").hide();
        $("#about-edit-confirm").hide();
        $("#about-edit-btn").show();
        tinymce.get("about-body").setContent(tinymce.get("about-body").init_content);
        tinymce.get("about-body").hide();
    });
}

function populateAbout(data) {
    $("#about-img").html("<img class='center-block' src=../" + data.image_path + ">");
    $("#about-img img").css("width", "25%");
    $("#about-body").append(data.about_body);
}

function registerOverviewEvent() {
    $("[href='#overview']").on("click", function () {
        hideElements();
        $(this).parent("li").addClass("active");
        $(".page-header").show();
        $("#stats").show();
    });
}

function populateStats(data) {
    $.get("../ajax/getMediaStats.php",
        function (data) {
            $data = JSON.parse(data);
            $("#photo-count").html("<h2>" + $data.photos["COUNT(id)"] + "</h2>");
            $("#accolades-count").html("<h2>" + $data.accolades["COUNT(id)"] + "</h2>");
            $("#videos-count").html("<h2>" + $data.videos["COUNT(id)"] + "</h2>");
        });
}

function changePOST(obj, url, content_type) {
    obj.options.url = url;
    $("#content_type").attr("value", content_type);
}

function registerLogoutButton() {
    $("[href='#logout']").on("click", function () {
        $.get("../ajax/authenticate.php", function () {
            window.location.href = "../index.html";
        });
    });
}

function registerSettingsCloseEvent() {
    $("#settings-close").on("click", function () {
        $("#settings-modal video").get(0).pause();
        $("#settings-modal video source").attr("src", "");
    });
}

function registerTextChangeSubmit() {
    var text;
    var heading;

    $("#top_submit").on("click", function () {
        text = $("#top-heading").val();
        heading = $(this).attr("data-pos");


        $.post("settings.php", {
            "media": heading,
            "heading": text
        },
            function (data) {
                alert(data);
                getSettingsModal();
            });
    });

    $("#bottom_submit").on("click", function () {
        text = $("#bottom-heading").val();
        heading = $(this).attr("data-pos");

        $.post("settings.php", {
            "media": heading,
            "heading": text
        },
            function (data) {
                alert(data);
                getSettingsModal();
            });
    });

    $("#lr_submit").on("click", function () {
        text = $("#lower-right-heading").val();
        heading = $(this).attr("data-pos");

        $.post("settings.php", {
            "media": heading,
            "heading": text
        },
            function (data) {
                alert(data);
                getSettingsModal();
            });
    });

}

function registerBGChangeSubmit() {
    $("#bg_submit").on("click", function () {
        var file = $("#mobile_bg").prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file);
        form_data.append('media', 'bg');
        $.ajax({
            url: 'settings.php', // point to server-side PHP script 
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (php_script_response) {
                alert(php_script_response);
                getSettingsModal();
            }
        });
    });
}

function registerVBGChangeSubmit() {
    $("#vbg_submit").on("click", function () {
        var file = $("#video_bg").prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file);
        form_data.append('media', 'vbg');
        $.ajax({
            url: 'settings.php', // point to server-side PHP script 
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (php_script_response) {
                alert(php_script_response);
                getSettingsModal();
            }
        });
    });
}


function registerAudioChangeSubmit() {
    $("#audio_submit").on("click", function () {
        var file = $("#audio").prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file);
        form_data.append('media', 'song');
        $.ajax({
            url: 'settings.php', // point to server-side PHP script 
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (php_script_response) {
                alert(php_script_response);
                getSettingsModal();
            }
        });
    });
}

function statusMessage(message, type) {
    $("#status").show();
    $("#status").html("<div class='alert " + type + " alert-dismissible'>" + message + "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
}

function registerAddButtonEvent() {
    $("#add").on("click", function () {

        $("#add").hide();
        $("#minus").show();
        var addingMedia = $("#add").attr("add");

        switch (addingMedia) {
            case "photo":
                $("#upload_form").show();
                changePOST(dropzone, "../ajax/insertPhoto.php", "photo");

                dropzone.off("success").on("success", function () {
                    $("#editor tbody").empty();
                    $("#about-body").empty();
                    $.get("../ajax/getAllPhotos.php",
                        function (data) {
                            populateTable(JSON.parse(data));
                            $("#editor").show();
                        });
                });
                break;

            case "video":
                $("#video_upload").show();
                $("#addVideo").off("click").on("click", function () {
                    event.preventDefault();
                    $.post("../ajax/insertVideo.php",
                        {
                            "path": $("#videourl").val()
                        },
                        function (data) {
                            $("#videourl").val("");
                            $("#editor tbody").empty();
                            $("#about-body").empty();
                            $.get("../ajax/getAllVideos.php",
                                function (data) {
                                    populateTable(JSON.parse(data));
                                    $("#editor").show();
                                });
                        });

                });
                break;

            case "accolade":
                $("#accolade_upload").show();
                var selection = $("#accolade_select option:selected").text();
                $("#upload_form").show();
                changePOST(dropzone, "../ajax/insertAccolade.php", "photo");
                dropzone.off("success").on("success", function () {
                    $("#editor tbody").empty();
                    $("#about-body").empty();
                    $.get("../ajax/getAllAccolades.php",
                        function (data) {
                            populateTable(JSON.parse(data));
                            $("#editor").show();
                        });
                });

                $("#accolade_select").on("change", function () {
                    var selection = $("#accolade_select option:selected").text();

                    switch (selection) {
                        case "Photo":
                            $("#video_upload").hide();
                            $("#upload_form").show();
                            changePOST(dropzone, "../ajax/insertAccolade.php", "photo");
                            dropzone.off("success").on("success", function () {
                                $("#editor tbody").empty();
                                $("#about-body").empty();
                                $.get("../ajax/getAllAccolades.php",
                                    function (data) {
                                        populateTable(JSON.parse(data));
                                        $("#editor").show();
                                    });
                            });
                            break;
                        case "Video":
                            $("#upload_form").hide();
                            $("#video_upload").show();
                            $("#addVideo").off("click").on("click", function () {
                                event.preventDefault();
                                $.post("../ajax/insertAccolade.php",
                                    {
                                        "path": $("#videourl").val(),
                                        "content": "video"
                                    },
                                    function (data) {
                                        $("#videourl").val("");
                                        console.log(data);
                                        $("#editor tbody").empty();
                                        $("#about-body").empty();

                                        $.get("../ajax/getAllAccolades.php",
                                            function (data) {
                                                populateTable(JSON.parse(data));
                                                $("#editor").show();
                                            });
                                    });


                            });
                            break;
                        default:
                            console.log("ERROR: Undefined state");
                            break;
                    }
                });
                break;
            case "faq":
                $("#upload_form").hide();
                $("#video_upload").hide();
                $("#add").show();
                $("#minus").hide();
                $.post("../ajax/insertFAQ.php",
                    {
                        "title": "New Heading",
                        "caption": "New Body"
                    },
                    function (data) {
                        console.log(data);
                        $("#editor tbody").empty();
                        $("#about-body").empty();
                        $("#add").attr("add", "faq");

                        $.get("../ajax/getFAQ.php",
                            function (data) {
                                preparePopulate("faq");
                                var json = JSON.parse(data);
                                populateFAQ(json);
                                $("#year").hide();
                                $("#add").show();
                                $("#reorder").show();
                                $("#editor").show();
                                $(".table").show();
                                $(".table").attr("from", "faq");

                            });
                    });


                break;
            default:
                console.log("Undefined adding button state");
                break;
        }
    });
}

function registerMinusButtonEvent() {
    $("#minus").on("click", function () {
        $("#minus").hide();
        $("#upload_form").hide();
        $("#video_upload").hide();
        $("#accolade_upload").hide();
        $("#add").show();
    });
}

function registerFAQEditorEvent() {
    $("[href='#faq']").on("click", function () { // Show editor on click
        hideElements();
        $(this).parent("li").addClass("active");

        $("#editor").hide();
        $("#editor tbody").empty();
        $("#about-body").empty();
        $("#add").attr("add", "faq");

        $.get("../ajax/getFAQ.php",
            function (data) {
                preparePopulate("faq");
                var json = JSON.parse(data);
                populateFAQ(json);
                $("#year").hide();
                $("#add").show();
                $("#reorder").show();
                $("#editor").show();
                $(".table").show();
                $(".table").attr("from", "faq");

            });

    });
}

function registerReorderButtonEvent() {
    $("#reorder").on("click", function () {
        var state = $("#reorder").attr("state");

        if (state === "re-order") {
            $("tbody").sortable();
            $("#reorder").html("Save order");
            $("#reorder").attr("state", "save");
        }

        else if (state === "save") {
            $("tbody").sortable("destroy");

            var order = [];
            $("tr").each(function () {
                order.push($(this).attr("id"));
            });

            $.post("../ajax/updateOrder.php",
                {
                    "table": $("table").attr("from"),
                    "order": order
                },
                function (data) {
                    console.log(data);
                    statusMessage(data + " rows updated", "alert-info");
                });

            $("#reorder").html("Re-order");
            $("#reorder").attr("state", "re-order");
        }
    });
}

function populateFAQ(jsonData) {
    for (var i = 0; i < jsonData.title.length; i++) {
        $("#editor tbody").append("<tr id=" + i + " type=faq></tr>"); // unqiue col identifier
        $("#editor tbody tr:last").html("<td class='media'></td><td class='title'><textarea class='form-control' disabled='true'></textarea></td><td class='caption'><textarea class='form-control' disabled='true'></textarea></td><td class='operations'></td>"); // prep rows
        $("#editor tbody tr:last .title textarea").html(jsonData.title[i]); // title

        $("#editor tbody tr:last .caption textarea").html(jsonData.body[i]); // caption

        $("#editor tbody tr:last .operations").html("<button id='edit'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button><button id='delete'><span class='glyphicon glyphicon-trash' aria-hidden='true'</button><button id='confirm'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span></button><button id='cancel'><span class='glyphicon glyphicon-remove' aria-hidden='true'</button>");
        $("#editor tbody tr:last .operations #confirm").hide(); // buttons n stuff
        $("#editor tbody tr:last .operations #cancel").hide();
    }
}

function hideElements() {
    $("#about-edit-btn").hide();
    $("#about-edit-cancel").hide();
    $("#about-edit-confirm").hide();
    $(".page-header").hide();
    $(".active").removeClass("active");
    $("#editor").hide();
    $("#stats").hide();
    $("#editor #about-img").hide();
    $("#upload_form").hide();
    tinymce.get("about-body").hide();
    $("#status").hide();
    $("#video_upload").hide();
    $("#accolade_upload").hide();
    $(".table").hide();
    $("#minus").hide();
    $("#reorder").hide();
}

function getSettingsModal() {
    $.get("../ajax/getHomeContent.php",
        function (data) {
            var json = JSON.parse(data);
            $("#settings-modal img").attr("src", "../" + json.home_img + "?timestamp=" + new Date().getTime());
            $("#settings-modal img").addClass("img-responsive");
            $("#settings-modal audio source").attr("src", "../" + json.home_audio + "?timestamp=" + new Date().getTime());
            $("#settings-modal audio source").attr("type", "audio/mpeg");
            $("#settings-modal video source").attr("src", "../" + json.home_video + "?timestamp=" + new Date().getTime());
            $("#settings-modal video source").attr("type", "video/mp4");
            $("#settings-modal video").attr("controls", "true");
            $("#settings-modal video").css("max-width", "100%");
            $("#settings-modal video").css("height", "auto");
            $("#settings-modal #top-heading").val(json.top_heading);
            $("#settings-modal #bottom-heading").val(json.bottom_heading);
            $("#settings-modal #lower-right-heading").val(json.lower_right_heading);

            $("#settings-modal audio").load();
            $("#settings-modal video").load();
            $("#settings-modal video").prop("muted", true);

            $("#settings-modal").modal();
        });
}