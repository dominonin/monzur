$(document).ready(function () {
    $(".alert").hide();

    $.get("../ajax/forgot.php",
        function (data) {
            var json = JSON.parse(data);
            for (var i = 0; i < json.length; i++) {
                $("[for='q" + i + "']").html(json[i].question);
            }
        });

    $(".row button").on("click", function () {
        event.preventDefault();



        $.post("../ajax/forgot.php",
            {
                "answers[0]": $("#1").val(),
                "answers[1]": $("#2").val(),
                "answers[2]": $("#3").val()
            },
            function (data) {
                json = JSON.parse(data);
                console.log(json.reset);

                if (json.reset) {
                    window.location.href = "reset.php";
                }

                else {
                    $(".container").prepend("<div class='alert alert-danger' role='alert'>You answered one or more questions wrong. <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>");
                    $(".alert").show();
                }
            });
    });
});