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
    addRowTrTbody(this);

});

$("#trCustomer").change(function () {
    $(".tr > tbody").remove();
    addRowTrTbody(this);
    trGetCustomer();
});

function trGetCustomer() {
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
    trGetSelectBox();
}

function trGetSelectBox() {
    var id_cust = $("#trCustomer").val();
    $.ajax({
        url: get_customer + "/" + id_cust,
        type: "GET",
        dataType: "JSON",
        success: function (response) {
            var len = response.length;
            $(".trOriginialInvoice").empty();
            for (var i = 0; i < len; i++) {
                var id = response[i]['no_bukti2'];
                $("#si").append("<option value='" + id + "'>");
            }
        },
    });
}

function getSelectFromOriginalInvoice(id) {
    var id_val = $("#" + id + '-0-1').val();
    var new_id = id_val.replaceAll('/', ":");
    $('#' + id + '-1-1').val();
    $('#' + id + '-2-1').val();
    $('#' + id + '-3-1').val();
    $.ajax({
        url: get_efaktur + "/" + new_id,
        type: "GET",
        dataType: "JSON",
        success: function (response) {
            $('#' + id + '-1-1').val(response['si'][0]['no_pajak']);
            $('#' + id + '-2-1').val(response['si'][0]['DO_id']);
            $('#' + id + '-3-1').val(response['so'][0]['PO_CUST']);
        },
    });
}

var rowCountTrTbody = 0;
window.addRowTrTbody = function (element) {
    indexs = $('.tr .trTb').length;
    no = indexs + 1;
    rowCountTrTbody++;

    var str = '';
    str += '<tbody id="trTb-' + indexs + '" class="trTb">';
    str += '<tr id="trTb-' + indexs + '-0">';
    str += '<td style="text-align: right;">' + no + '</td>';
    str += '<td> <input type="text" class="form-control form-control-sm" name="row[' + indexs + '][0][0]" id="row-' + indexs + '-0-0" value="Original Invoice"> </td>';
    str += '<td><input class="form-control form-control-sm" list="si"  name="row[' + indexs + '][0][1]" id="row-' + indexs + '-0-1" onchange="getSelectFromOriginalInvoice(&apos;row-' + indexs + '&apos;)"></td > ';
    str += '<td></td>';
    str += '</tr>';
    str += '<tr id="trTb-' + indexs + '-1">';
    str += '<td></td>';
    str += '<td><input type="text" class="form-control form-control-sm" name="row[' + indexs + '][1][0]" id="row-' + indexs + '-1-0" value = "E-Faktur"></td>';
    str += '<td> <input class="form-control form-control-sm"name = "row[' + indexs + '][1][1]"id = "row-' + indexs + '-1-1"></td>';
    str += '<td><a href=" javascript:void(0)" onclick="removeRowTr(&apos;trTb-' + indexs + '-1&apos;)" class="btn btn-xs btn-warning float-right " title="remove row "><i class="fa fa-minus"></i></a></td>';
    str += '</tr>';
    str += '<tr id="trTb-' + indexs + '-2">';
    str += '<td></td>';
    str += '<td><input type="text" class="form-control form-control-sm" name="row[' + indexs + '][2][0]" id="row-' + indexs + '-2-0" value="Original DN"> </td>';
    str += '<td><input class="form-control form-control-sm" name="row[' + indexs + '][2][1]" id="row-' + indexs + '-2-1"></td>';
    str += '<td><a href=" javascript:void(0)" onclick="removeRowTr(&apos;trTb-' + indexs + '-2&apos;)" class="btn btn-xs btn-warning float-right" title="remove row"><i class="fa fa-minus"></i></a></td>';
    str += '</tr>';
    str += '<tr id="trTb-' + indexs + '-3">';
    str += '<td></td>';
    str += '<td><input type="text" class="form-control form-control-sm" name="row[' + indexs + '][3][0]" id="row-' + indexs + '-3-0" value = "Copy Purchase Order" > </td>';
    str += '<td> <input class = "form-control form-control-sm" name="row[' + indexs + '][3][1]" id = "row-' + indexs + '-3-1" ></td>';
    str += '<td><a href=" javascript:void(0)" onclick="removeRowTr(&apos;trTb-' + indexs + '-3&apos;)" class="btn btn-xs btn-warning float-right" title="remove row "><i class="fa fa-minus"></i></a></td>';
    str += '</tr>';
    str += '</tbody>';
    str += '<tbody><tr><td colspan="3"></td><td><a href="javascript:void(0)" onclick ="addRowTr(&apos;trTb-' + indexs + '&apos;)" class="btn btn-xs btn-info float-right" title="add row"> <i class="fa fa-plus"></i></a></td></tr></tbody>';
    $(".tr").append(str);

    var id_cust = $("#trCustomer").val();
    $.ajax({
        url: get_customer + "/" + id_cust,
        type: "GET",
        dataType: "JSON",
        success: function (response) {
            var len = response.length;
            $("#row-" + indexs + '-0-1').empty();
            var str2 = '';
            $("#row-" + indexs + "-0-1").append("<option selected disabled></option>");
            for (var i = 0; i < len; i++) {
                var id = response[i]['no_bukti2'];
                var name = response[i]['no_bukti2'];
                $("#row-" + indexs + '-0-1').append("<option value='" + id + "'>" + name + "</option>");
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

function addRowTr(id) {
    var no = $('#' + id + ' tr').length;
    var trId = id + '-' + no;
    var tbody = ($('.tr .trTb').length) - 1;
    var str = '';
    str += '<tr id="' + trId + '">';
    str += '<td></td>';
    str += '<td><input type="text" class="form-control" name="row[' + tbody + '][' + no + '][0]" id="row-' + tbody + '-' + no + '-0"></td>';
    str += '<td><input class="form-control"  name="row[' + tbody + '][' + no + '][1]" id="row-' + tbody + '-' + no + '-1"></td>';
    str += '<td><a href=" javascript:void(0)" onclick="removeRowTr(&apos;' + trId + '&apos;)" class="btn btn-xs btn-warning float-right" title="remove row"><i class="fa fa-minus"></i></a></td></tr> ';
    $("#" + id).append(str);
}
