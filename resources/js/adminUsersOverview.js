
$('.active-toggle').click(function () {

    var id = $(this).data("id");
    var url = root + "/admin/users/active-toggle";

    if (id) {
        $.ajax({
            method: "POST",
            url: url,
            data: {
                id: id,
                is_active: (this.checked) ? 1 : 0,
            }
        });
    }
});