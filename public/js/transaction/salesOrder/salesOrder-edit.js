$(document).ready(function () {
    $("#frmSo input").prop("disabled", true);
    $("#frmSo textarea").prop("disabled", true);
    $("#addrow ").prop("disabled", true);
    $("#frmSo .btn-xs").css("display", 'none');
    $("#frmSo .input-group-append-edit").css("display", 'none');
    $("#frmSo select").prop("disabled", true);
    $("#cmbShippingKey").val($("#cmbShipping option:selected").text());
});


function btnEdit() {
    $("#frmSo input").prop("disabled", false);
    $("#frmSo textarea").prop("disabled", false);
    $("#addrow ").prop("disabled", false);
    $("#frmSo .btn-xs").css("display", 'block');
    $("#frmSo .input-group-append-edit").css("display", 'block');
    $("#frmSo select").prop("disabled", false);
    $("#frmSo button").css("display", 'block');
    $('#edit').css("display", 'none');
    $('#printPage').css("display", 'none');
}

function btnDelete() {
    var id = $('#nomor_old').val();

    Swal.fire({
        title: "Delete Sales Order!",
        text: "Are you sure to delete this SO : " + id + "?",
        icon: "warning",
        confirmButtonColor: "#17a2b8",
        confirmButtonText: "Yes, Of Course",
        reverseButtons: true,
        showCancelButton: true,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: get_statusSo + "/" + id,
                type: "GET",
                dataType: "JSON",
                success: function (response) {
                    if (response.status > 0) {
                        Swal.fire({
                            title: "Cannot delete!",
                            text: "This SO already processing",
                            icon: "error",
                            confirmButtonColor: "#17a2b8",
                            confirmButtonText: "Ok",
                            reverseButtons: true,
                        })
                    } else {
                        window.location = void_url + "/" + id;
                    }
                },
            });
        }
    });
}

$("#printEdit").click(function (e) {
    e.preventDefault();
    $('#process').val('print');
    $('#frmSo').submit();
});
$("#saveEdit").click(function (e) {
    e.preventDefault();
    $('#process').val('save');
    $('#frmSo').submit();
});