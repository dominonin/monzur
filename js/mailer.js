$(document).ready(function () {
    $("form").submit(function (event) {
        event.preventDefault();
        $.post("php/mail.php",
            {
                "name": $("#name").val(),
                "email": $("#email").val(),
                "message": $("#msg").val()
            },
            function (data) {
                console.log(data);
            });
        $("#contact").hide();
        $("h1").append("<h2>Thanks for contacting us!</h2>");
    });
}); 