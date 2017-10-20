$(document).ready(function () {
    $(".btn").click(function () {
        var user = $("#userName").val();
        var pw = $("#userPassword").val();
        var shaObj = new jsSHA("SHA-256", "TEXT");
        shaObj.update(pw);


        $.post("../ajax/authenticate.php",
            {
                username: user,
                password: shaObj.getHash("HEX")
            },
            function (data) {
                obj = JSON.parse(data);

                if (obj.URL) {
                    window.location.href = obj.URL;
                }

                else {
                    $("#text").html("<h3>" + obj.error + "</h3>");
                    $("#text").css("color", "red");
                }
            }
        );
    });

    $("#forgot").on("click", function () {
        window.open("iforgot.html", 'newwindow', 'width=500,height=600');
    });
});
