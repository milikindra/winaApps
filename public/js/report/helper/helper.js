$(".selects2").select2();

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
});
var rowCountTr = 0;
var no = 1;
window.addRowTr = function (element) {
    rowCountTr++;
    no++;
    // var vatOption = "";
    // jQuery.each(vat, function (i, val) {
    //     vatOption += "<option>" + val.kode + "</option>";
    // });

    $(".tr").append(
        '<tr> <td style="text-align:right;"> ' + no + '</td><td> <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="Tr_value[]" id="Tr_value-' +
        rowCountTr +
        '" onchange="addTr(' + rowCountTr + ')"> </td></tr>'
    );
};

window.removeRowTr = function (element) {
    $(".tr tr:last").remove();
};
