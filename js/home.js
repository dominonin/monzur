$(document).ready(function () {
    $("nav").hide();
    $("video").prop("muted", true);

    $(".open").click(function () {
        $("nav").fadeIn();
        $("#play").hide();
    });

    $("#play").click(function () {
        $("nav").fadeIn();
        $("#play").hide();
    });

    $.ajax({
        url: "ajax/getHomeContent.php",
        success: function (data) {
            addSources(JSON.parse(data));
        },
        cache: false
    });

    var audioElement = $("#audio").get(0);
    var playButton = $("#play");
    var welcomeText = $(".open");

    /*welcomeText.on("click", function () {
        audioElement.pause();
    });

    playButton.on("click", function () {
        audioElement.pause();

    });
*/

    /* $("#nav a").on("click auxclick", function (e) {
         if (e.which == 2) {
             audioElement.pause();
         }
 
         else {
             audioElement.pause();
         }
     }); */

});


function addSources(data) {
    $("#bgvid source").attr("src", data.home_video + "?timestamp=" + new Date().getTime()); // to do add video changes
    $("#bgvid").get(0).load();
    $("#audio source").attr("src", data.home_audio + "?timestamp=" + new Date().getTime());
    $("#audio").load();
    $("#audio").get(0).play();
    $("#bg").css("background", "url(" + data.home_img + "?timestamp=" + new Date().getTime() + ") no-repeat");
    $("#top-heading").html(data.top_heading);
    $("#bottom-heading").html(data.bottom_heading);
    $("#lower-right-heading").html(data.lower_right_heading);

}