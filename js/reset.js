function checkPasswordMatch() {
    var password = $("#1").val();
    var confirmPassword = $("#2").val();

    if (password != confirmPassword) {
        $(".alert").html("Passwords do not match!");
        $(".alert").show();
        return false;
    }
    else {
        $(".alert").hide();
        return true;
    }
}

$(document).ready(function () {
    $(".container").prepend("<div class='alert alert-danger' role='alert'>Passwords do not match!</div>");
    $("#close").hide();
    $(".alert").hide();
    $("#1, #2").keyup(checkPasswordMatch);

    $("#close").on("click", function () {
        window.close();
    });

    $("#update").on("click", function () {

        if (checkPasswordMatch) {
            var shaObj = new jsSHA("SHA-256", "TEXT");
            shaObj.update($("#2").val());

            $.post("../ajax/updatePassword.php",
                {
                    "password": shaObj.getHash("HEX")
                },
                function (data) {
                    if (data == "blank") {
                        $(".alert").html("Password can't be blank, try again.");
                        $(".alert").show();
                    }

                    else {

                        $(".container .alert").html(data);
                        $(".container .alert").removeClass("alert-danger");
                        $(".container .alert").addClass("alert-info");
                        $(".container .alert").show();
                        $(".form-group, .text-center, #update").hide();
                        $("#close").show();
                    }
                });
        }
    });
}
);