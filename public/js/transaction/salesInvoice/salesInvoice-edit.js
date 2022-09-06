$(document).ready(function () {
    $("#salesInvoiceUpdate input").prop("disabled", true);
    $("#salesInvoiceUpdate textarea").prop("disabled", true);
    $("#addrow ").prop("disabled", true);
    $("#btnSo ").prop("disabled", true);
    $("#modalByDp ").prop("disabled", true);

    $("#baEfaktur ").prop("disabled", false);
    $("#bcEfaktur ").prop("disabled", false);

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
function lockInv() {
    var sdate = $('#date_order').val();
    if (sdate < lock_inventory) {
        Swal.fire({
            title: "Inventory Locked",
            text: "Qty of inventory has been locked : " + moment(lock_inventory).format("DD-MM-YYYY"),
            icon: "warning",
        })
        $(".qtyItem").prop("readonly", true);
    } else {
        $(".qtyItem").prop("readonly", false);
    }
}

function btnEdit() {
    $("#salesInvoiceUpdate input").prop("disabled", false);
    $("#salesInvoiceUpdate textarea").prop("disabled", false);
    $("#addrow ").prop("disabled", false);
    $("#salesInvoiceUpdate .btn-xs").css("display", 'block');
    $("#salesInvoiceUpdate .input-group-append-edit").css("display", 'block');
    $("#salesInvoiceUpdate select").prop("disabled", false);
    $("#salesInvoiceUpdate button").css("display", 'block');


    $('#det').css("display", 'none');
    $('#editGroup').css("display", 'block');
    $('#attachDownload').css("display", 'none');
    $('#attachUpload').css("display", 'block');
    $('#btnEfakturUpdate').css("display", 'block');
    $('#btnEfakturView').css("display", 'none');

    lockInv();
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

$("#btnEfakturUpdate").click(function (e) {
    e.preventDefault();
    $('#salesInvoiceUpdate').attr("target", "_blank");
    $('#process').val('efaktur');
    $('#salesInvoiceUpdate').submit();
    window.location.reload();
});

$("#btnEfakturView").click(function (e) {
    e.preventDefault();
    var ba = 'void';
    if ($('#baEfaktur').val() != '') {
        ba = $('#baEfaktur').val();
    }
    var bc = 'void';
    if ($('#bcEfaktur').val() != '') {
        bc = $('#bcEfaktur').val();
    }
    window.open(efaktur_url + "/" + btoa($('#si_id').val()) + "/" + btoa(ba) + "/" + btoa(bc), '_blank');
    $("#modalEfaktur").modal("hide");
    $('#baEfaktur').val('');
    $('#bcEfaktur').val('');
});