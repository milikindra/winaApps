$(document).ready(function () {
    $("#frmSo input").prop("disabled", true);
    $("#frmSo textarea").prop("disabled", true);
    $("#addrow ").prop("disabled", true);
    $("#frmSo .btn-xs").css("display", 'none');
    $("#frmSo .input-group-append-edit").css("display", 'none');
    $("#frmSo select").prop("disabled", true);
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
    $('#print').css("display", 'none'); 
}

function btnDelete() {
    var id = $('#nomor_old').val();
    $.ajax({
        url: get_statusSo + "/" + id,
        type: "GET",
        dataType: "JSON",
        success: function (response) {
            if (response.status > 0) {
                Swal.fire({
                title: "Cannot delete!",
                text: "This SO already processing",
                icon: "warning",
                confirmButtonColor: "#17a2b8",
                confirmButtonText: "Ok",
                reverseButtons: true,
                })
            } else {
                window.location = void_url+"/"+id;
            }
        },
    });
}