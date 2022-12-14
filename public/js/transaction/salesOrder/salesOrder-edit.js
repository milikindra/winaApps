$(document).ready(function () {
    $("#frmSo input").prop("disabled", true);
    $("#frmSo textarea").prop("disabled", true);
    $("#addrow ").prop("disabled", true);
    $("#frmSo .btn-xs").css("display", 'none');
    $("#frmSo .input-group-append-edit").css("display", 'none');
    $("#frmSo select").prop("disabled", true);
    $("#cmbShippingKey").val($("#cmbShipping option:selected").text());
    loadAttach();
});
function loadAttach() {
    jQuery.each(attach, function (i, val) {
        $('#attachUpload').append('<input type="file" style="margin-bottom: 2px;" id="attach-' + i + '" name="attach[]">');
        const fileInput = document.getElementById('attach-' + i);
        var path = url_default + '/local/' + val.path;
        var request = new XMLHttpRequest();
        request.open('GET', path, true);
        request.responseType = 'blob';
        request.onload = function () {
            var reader = new FileReader();
            reader.readAsDataURL(request.response);
            reader.onload = function (e) {
                var oldFile = dataURLtoFile(e.target.result, val.path)
                const myFile = new File([oldFile], path);
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(myFile);
                fileInput.files = dataTransfer.files;
            };
        };
        request.send();
    });
}

function dataURLtoFile(dataurl, filename) {
    var arr = dataurl.split(','),
        mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[1]),
        n = bstr.length,
        u8arr = new Uint8Array(n);
    while (n--) {
        u8arr[n] = bstr.charCodeAt(n);
    }
    return new File([u8arr], filename, { type: mime });
}

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
    $('#attachDownload').css("display", 'none');
    $('#attachUpload').css("display", 'block');
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