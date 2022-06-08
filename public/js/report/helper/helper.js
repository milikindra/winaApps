$(".selects2").select2();
$(".eds").editableSelect();

$(document).ready(function () {
    $("#reportType").prop("selectedIndex", 1).trigger("change");
    filterReport();
    $("#reportType").change(function () {
        filterReport();
    });

    function filterReport() {
        var reportType = $("#reportType").val();
        if (reportType == "appTransmitalReceipt") {
            $("#appTransmitalReceipt").css("display", "block");
            $("#type").val("appTransmitalReceipt");
        } else {
            $("#appTransmitalReceipt").css("display", "none");
        }
    }


});

$("#trCustomer").change(function () {
    getCustomer();
});

function getCustomer() {
    var id_cust = $("#trCustomer").val();
    jQuery.each(customer, function (i, val) {
        if (val.ID_CUST == id_cust) {
            $("#trNmCustomer").val(val.NM_CUST);
            var customer_address =
                val.ALAMAT1 +
                "\r\n" +
                val.ALAMAT2 +
                "\r\n" +
                val.KOTA +
                "\r\n" +
                val.PROPINSI +
                "\r\n" +
                val.TELP;
            $("#trAddress").html(customer_address);
        }
    });
    getSelectBox();
}

function getSelectBox() {
    var id_cust = $("#trCustomer").val();
    var option = '';
    $.ajax({
        url: get_customer + "/" + id_cust,
        type: "GET",
        dataType: "JSON",
        success: function (response) {
            var len = response.length;
            $(".trOriginialInvoice").empty();
            $(".trOriginialInvoice").append("<option selected disabled></option>");
            for (var i = 0; i < len; i++) {
                var id = response[i]['no_bukti2'];
                var name = response[i]['no_bukti2'];
                $(".trOriginialInvoice").append("<option value='" + id + "'>" + name + "</option>");
            }
        },
    });
}

function getSelectFromOriginalInvoice(id) {
    var idx = id.replace('trOriginialInvoice-', '');
    var id = $("#" + id).val();

    var new_id = id.replaceAll('/', ":");
    var option = '';
    $.ajax({
        url: get_efaktur + "/" + new_id,
        type: "GET",
        dataType: "JSON",
        success: function (response) {
            $('#trEfaktur-' + idx).val(response['si'][0]['no_pajak']);
            $('#trOriginalDn-' + idx).val(response['si'][0]['DO_id']);
            $('#trOriginalPo-' + idx).val(response['so'][0]['PO_CUST']);

        },
    });
}

var rowCountTrTbody = 0;
window.addRowTrTbody = function (element) {
    indexs = $('.tr .trTb').length;
    $("#trOriginialInvoice-" + indexs).select2();
    no = indexs + 1;
    rowCountTrTbody++;
    $(".tr").append(
        '<tbody id="trTb-' + indexs + '" class="trTb"><tr id="trTb-' + indexs + '-0"><td style="text-align:right">' + no + '</td><td>Original Invoice</td><td><select class="form-control selects2 trOriginialInvoice" name="trOriginialInvoice[]" id="trOriginialInvoice-' + indexs + '" onchange="getSelectFromOriginalInvoice(&apos;trOriginialInvoice-' + indexs + '&apos;)"></select></td><td></td></tr><tr id=" trTb-' + indexs + '-1"><td></td><td>E-Faktur</td><td><input class="form-control" name="trEfaktur[]" id="trEfaktur-' + indexs + '"></td><td><a href="javascript:void(0)" onclick="removeRowTr("trTb-' + indexs + '-1")" class="btn btn-xs btn-warning float-right" title="remove row"><i class="fa fa-minus"></i></a></td></tr><tr id="trTb-' + indexs + '-2"><td></td><td>Original DN</td><td><input class="form-control" name="trOriginalDn[]" id="trOriginalDn-' + indexs + '"></td><td><a href="javascript:void(0)" onclick="removeRowTr("trTb-' + indexs + '-2")" class="btn btn-xs btn-warning float-right" title="remove row"><i class="fa fa-minus"></i></a></td></tr><tr id="trTb-' + indexs + '-3"><td></td><td>Copy Purchase Order</td><td><input class="form-control" name="trOriginalPo[]" id="trOriginalPo-' + indexs + '"></td><td><a href="javascript:void(0)" onclick="removeRowTr("trTb-' + indexs + '-3")" class="btn btn-xs btn-warning float-right" title="remove row"><i class="fa fa-minus"></i></a></td></tr></tbody><tbody><tr><td colspan="3"></td><td><a href="javascript:void(0)" onclick="addRowTr(&apos;trTb-' + indexs + '&apos;)" class="btn btn-xs btn-info float-right" title="add row"><i class="fa fa-plus"></i></a></td></tr></tbody>'
    );

    $(".selects2").select2();

    var id_cust = $("#trCustomer").val();
    var option = '';
    $.ajax({
        url: get_customer + "/" + id_cust,
        type: "GET",
        dataType: "JSON",
        success: function (response) {
            var len = response.length;
            $("#trOriginialInvoice-" + indexs).empty();
            $("#trOriginialInvoice-" + indexs).append("<option selected disabled></option>");
            for (var i = 0; i < len; i++) {
                var id = response[i]['no_bukti2'];
                var name = response[i]['no_bukti2'];
                $("#trOriginialInvoice-" + indexs).append("<option value='" + id + "'>" + name + "</option>");
            }
        },
    });
};

window.removeRowTrTbody = function (element) {
    $(".tr tbody:last").remove();
};


function removeRowTr(id) {
    $('#' + id).remove()
}

rowCountTr = 0;

function addRowTr(id) {
    var no = $('#' + id + ' tr').length;
    var trId = id + '-' + no;

    $("#" + id).append('<tr id="trTb-0-' + no + '"> <td></td><td><input type="text" class="form-control"></td><td> <input class="form-control" name="trOriginialInvoice[]" id="trOriginialInvoice-' + no + '"></td><td><a href=" javascript:void(0)" onclick="removeRowTr(&apos;' + trId + '&apos;)" class="btn btn-xs btn-warning float-right" title="remove row"><i class="fa fa-minus"></i></a></td></tr>');
}
