const eye = '<i class="fas fa-eye-slash"></i>'
    const pswrdField = $("input[type='password']");
    const toggleIcon = $("#icon");

    toggleIcon.on("click", function() {
        if (pswrdField.attr("type") === "password") {
            pswrdField.attr("type", "text");
            toggleIcon.removeClass("fa-eye").addClass("fa-eye-slash");
        } else {
            pswrdField.attr("type", "password");
            toggleIcon.removeClass("fa-eye-slash").addClass("fa-eye");
        }
    });