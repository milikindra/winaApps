$(document).ready(function () {
    $("#salesInvoiceUpdate input").prop("disabled", true);
    $("#salesInvoiceUpdate textarea").prop("disabled", true);
    $("#addrow ").prop("disabled", true);
    $("#btnSo ").prop("disabled", true);
    $("#modalByDp ").prop("disabled", true);

    $("#salesInvoiceUpdate .btn-xs").css("display", 'none');
    $("#salesInvoiceUpdate .input-group-append-edit").css("display", 'none');
    $("#salesInvoiceUpdate select").prop("disabled", true);
    $("#cmbShippingKey").val($("#cmbShipping option:selected").text());
    getCustomer();
    $("#modalByDp").attr('disabled', false);
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
    $("#salesInvoiceUpdate input").prop("disabled", false);
    $("#salesInvoiceUpdate textarea").prop("disabled", false);
    $("#addrow ").prop("disabled", false);
    $("#salesInvoiceUpdate .btn-xs").css("display", 'block');
    $("#salesInvoiceUpdate .input-group-append-edit").css("display", 'block');
    $("#salesInvoiceUpdate select").prop("disabled", false);
    $("#salesInvoiceUpdate button").css("display", 'block');
    $('#edit').css("display", 'none');
    $('#printPage').css("display", 'none');
    $('#attachDownload').css("display", 'none');
    $('#attachUpload').css("display", 'block');
}

function btnDel() {
    console.log("A");
}
function btnDelete() {
    var id = $('#si_id').val();
    Swal.fire({
        title: "Delete Sales Invoice!",
        text: "Are you sure to delete this Sales Invoice : " + id + "?",
        icon: "warning",
        confirmButtonColor: "#17a2b8",
        confirmButtonText: "Yes, Of Course",
        reverseButtons: true,
        showCancelButton: true,
    }).then((result) => {
        window.location = void_url + "/" + btoa(id);
        // if (result.isConfirmed) {
        //     $.ajax({
        //         url: get_statusSi + "/" + btoa(id),
        //         type: "GET",
        //         dataType: "JSON",
        //         success: function (response) {
        //             if (response.status > 0) {
        //                 Swal.fire({
        //                     title: "Cannot delete!",
        //                     text: "This SI already processing",
        //                     icon: "error",
        //                     confirmButtonColor: "#17a2b8",
        //                     confirmButtonText: "Ok",
        //                     reverseButtons: true,
        //                 })
        //             } else {
        //                 window.location = void_url + "/" + btoa(id);
        //             }
        //         },
        //     });
        // }
    });
}

$("#f1Update").click(function (e) {
    e.preventDefault();
    $('#process').val('f1');
    $('#salesInvoiceUpdate').submit();
});
$("#f2Update").click(function (e) {
    e.preventDefault();
    $('#process').val('f2');
    $('#salesInvoiceUpdate').submit();
});
$("#f3Update").click(function (e) {
    e.preventDefault();
    $('#process').val('f3');
    $('#salesInvoiceUpdate').submit();
});
$("#update").click(function (e) {
    e.preventDefault();
    $('#process').val('save');
    $('#salesInvoiceUpdate').submit();
});