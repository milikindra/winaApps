var forms = $("form").each(function () {
    var validator = $("#form").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 5,
            },
        },
        messages: {
            email: {
                required: "Please enter a email address",
                email: "Please enter a valid email address",
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
            },
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            element.closest(".form-group").append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass("is-invalid");
        },
    });
});
$(".select2").select2();
function getCity() {
    var val = $("#province").val();
    $.ajax({
        type: "POST",
        dataType: "html",
        url: rute_city,
        data: "province_id=" + val,
        success: function (hasil) {
            alert(hasil);
            if (hasil == "0") {
                $("#jumlah").val("0");
                $("#jumlah").attr("disabled", true);
                $("#satuan").attr("disabled", true);
                $("#tambah").attr("disabled", true);
            } else {
                var a = $.parseJSON(hasil);
                $("#jumlah").attr({
                    disabled: false,
                    max: parseInt(a.max),
                    min: 1,
                });
                $("#satuan").attr("disabled", false);
                $("#satuan").html(a.batch);
                $("#tambah").attr("disabled", false);
            }
        },
    });
}
