$(document).ready(() => {
    function showSnackbar(message, type = "default") {
        Snackbar.show({
            text: message,
            pos: "bottom-center",
            actionTextColor: "#fff",
            backgroundColor: type === "error" ? "#d32f2f" : "#4CAF50",
        });
    }

    // Temp Password Route from Blade
    const setTempPasswordRoute = $("meta[name='set-temp-password-route']").attr(
        "content"
    );
    const changeRoleRoute = $("meta[name='change-role-route']").attr("content");

    function generateTempPassword(userId) {
        $.ajax({
            url: setTempPasswordRoute + "/" + userId, // Verwende die Route aus dem Meta-Tag
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success(response) {
                showSnackbar(response.message, response.status);
                if (response.status === "success") {
                    const tempPasswordCell = $(
                        '.generate-temp-password-btn[data-user-id="' +
                            userId +
                            '"]'
                    )
                        .closest("tr")
                        .find(".temp-password");
                    tempPasswordCell.text(response.temp_password);
                }
            },
            error() {
                showSnackbar("Fehler beim Senden der Anfrage", "error");
            },
        });
    }

    $(".generate-temp-password-btn").click(function (event) {
        event.preventDefault(); // Verhindert das direkte Absenden des Formulars
        const userId = $(this).data("user-id");
        generateTempPassword(userId);
    });

    function changeUserRole(userId, newRole, dropdownElement) {
        $.ajax({
            url: changeRoleRoute, // Verwende die Route aus dem Meta-Tag
            type: "POST",
            data: { user_id: userId, new_role: newRole },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success(response) {
                showSnackbar(response.message, response.status);
                if (response.status === "success") {
                    dropdownElement
                        .closest("tr")
                        .find(".current-role")
                        .text(newRole);
                }
            },
            error() {
                showSnackbar("Fehler beim Ändern der Rolle.", "error");
            },
        });
    }

    $(".role-dropdown").change(function () {
        const userId = $(this).data("user-id");
        const newRole = $(this).val();
        changeUserRole(userId, newRole, $(this));
    });
});
