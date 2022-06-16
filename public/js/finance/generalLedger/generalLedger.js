$(document).ready(function () {
    $.fn.dataTable.ext.errMode = 'none';
    $(".selects2").select2();
    var Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
    });
    $("#dataType").prop("selectedIndex", 1).trigger("change");
    filterGlHead();
});

$("#dataType").change(function () {
    $("#appAccountHistory").css("display", "none");
    $("#filterAccount").css("display", "none");
    $("#filterEmployee").css("display", "none");
    $("#filterDepartment").css("display", "none");
    $("#filterSo").css("display", "none");

    var dataType = $("#dataType").val();
    if (dataType == "appAccountHistory") {
        $("#tableAccountHistory").DataTable().clear();
        $("#appAccountHistory").css("display", "block");
        $("#filterAccount").css("display", "block");
        $("#filterEmployee").css("display", "block");
        $("#filterDepartment").css("display", "block");
        $("#filterSo").css("display", "block");
    }
    if (dataType == "appCoaTransaction") {
        $("#tableCoaTransaction").DataTable().clear();
        $("#appCoaTransaction").css("display", "block");
        $("#filterTrxId").css("display", "block");
        $("#filterTrxType").css("display", "block");
    }
});

function dataReport() {
    var dataType = $("#dataType").val();
    if (dataType == "appAccountHistory") {
        tableAccountHistory();
    }

    if (dataType == "appCoaTransaction") {
        tableCoaTransaction();
    }
}

function tableAccountHistory() {
    $("#tableAccountHistory").DataTable().clear().destroy();

    var sdate = $('#sdate').val();
    var edate = $('#edate').val();
    var so_id = "null";
    var id_employee = $('#id_employee').val();
    var dept_id = $('#dept_id').val();
    var gl_code = "null";
    if ($('#so_id').val() != "") {
        so_id = $('#so_id').val();
    }
    if ($('#gl_code-0').val() != "") {
        gl_code = $('#gl_code-0').val();
    }

    var table = $("#tableAccountHistory").DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        stateSave: false,
        deferRender: true,
        scrollX: true,
        paging: true,
        lengthMenu: [
            [10, 100, 250, 500, 1000, -1],
            [10, 100, 250, 500, 1000, "all"],
        ],
        dom: "<'row'<'col-sm-6'l><'col-sm-6'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        ajax: {
            url: rute_accountHistory + '/' + gl_code + '/' + sdate + '/' + edate + '/' + so_id + '/' + id_employee + '/' + dept_id,
            type: "GET",
            dataType: "JSON",
        },
        columns: [{
                data: "no_rek",
                name: "no_rek",
                orderable: false,
            },
            {
                data: "nm_rek",
                name: "nm_rek",
                orderable: false,
            },
            {
                data: "no_bukti",
                name: "no_bukti",
                orderable: false,
            },
            {
                data: "tgl_bukti",
                name: "tgl_bukti",
                render: function (data, type, row) {
                    return moment(data).format("DD MMM YYYY");
                },
                orderable: false,
            },
            {
                data: "no_SO",
                name: "no_SO",
                orderable: false,
            },
            {
                data: "id_kyw",
                name: "id_kyw",
                orderable: false,
            },
            {
                data: "uraian",
                name: "uraian",
                orderable: false,
            },
            {
                data: "debet",
                name: "debet",
                className: "dt-body-right",
                render: function (data, type, row) {
                    return addPeriod(parseFloat(data).toFixed(2), ",");
                },
                orderable: false,
            },
            {
                data: "kredit",
                name: "kredit",
                className: "dt-body-right",
                render: function (data, type, row) {
                    return addPeriod(parseFloat(data).toFixed(2), ",");
                },
                orderable: false,
            },
            {
                data: "saldo",
                name: "saldo",
                className: "dt-body-right",
                render: function (data, type, row) {
                    return addPeriod(parseFloat(data).toFixed(2), ",");
                },
                orderable: false,
            },
            {
                data: "debet_us",
                name: "debet_us",
                className: "dt-body-right",
                render: function (data, type, row) {
                    return addPeriod(parseFloat(data).toFixed(2), ",");
                },
                orderable: false,
            },

            {
                data: "kredit_us",
                name: "kredit_us",
                className: "dt-body-right",
                render: function (data, type, row) {
                    return addPeriod(parseFloat(data).toFixed(2), ",");
                },
                orderable: false,
            },
            {
                data: "saldo_valas",
                name: "saldo_valas",
                className: "dt-body-right",
                render: function (data, type, row) {
                    return addPeriod(parseFloat(data).toFixed(2), ",");
                },
                orderable: false,
            },
            {
                data: "dept",
                name: "dept",
                orderable: false,
            },
        ],
    });
}

function tableCoaTransaction() {
    $("#tableCoaTransaction").DataTable().clear().destroy();

    var sdate = $('#sdate').val();
    var edate = $('#edate').val();

    var so_id = "null";
    var id_employee = $('#id_employee').val();
    var dept_id = $('#dept_id').val();
    var gl_code = "null";
    if ($('#so_id').val() != "") {
        so_id = $('#so_id').val();
    }
    if ($('#gl_code-0').val() != "") {
        gl_code = $('#gl_code-0').val();
    }

    if ($('#trx_id').val() != "") {
        var trx = $('#trx_id').val();
        var trxId = trx.replaceAll('/', ":")
    } else {
        var trxId = 'all';
    }
    var trxType = $('#trx_type').val();

    var table = $("#tableCoaTransaction").DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        stateSave: false,
        deferRender: true,
        scrollX: true,
        paging: true,
        lengthMenu: [
            [10, 100, 250, 500, 1000, -1],
            [10, 100, 250, 500, 1000, "all"],
        ],
        dom: "<'row'<'col-sm-6'l><'col-sm-6'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        ajax: {
            url: rute_coaTransaction + '/' + sdate + '/' + edate + '/' + trxType + '/' + trxId,
            type: "GET",
            dataType: "JSON",
            error: function (xhr, error, thrown) {
                $("#tableCoaTransaction").DataTable().clear().destroy();
            }
        },
        columns: [{
                data: "trx",
                name: "trx",
                orderable: false,
            },
            {
                data: "no_rek",
                name: "no_rek",
                orderable: false,
            },
            {
                data: "nm_rek",
                name: "nm_rek",
                orderable: false,
            },
            {
                data: "no_bukti",
                name: "no_bukti",
                orderable: false,
            },
            {
                data: "tgl_bukti",
                name: "tgl_bukti",
                render: function (data, type, row) {
                    return moment(data).format("DD MMM YYYY");
                },
                orderable: false,
            },
            {
                data: "uraian",
                name: "uraian",
                orderable: false,
            },
            {
                data: "debet",
                name: "debet",
                className: "dt-body-right",
                render: function (data, type, row) {
                    return addPeriod(parseFloat(data).toFixed(2), ",");
                },
                orderable: false,
            },
            {
                data: "kredit",
                name: "kredit",
                className: "dt-body-right",
                render: function (data, type, row) {
                    return addPeriod(parseFloat(data).toFixed(2), ",");
                },
                orderable: false,
            },

            {
                data: "debet_us",
                name: "debet_us",
                className: "dt-body-right",
                render: function (data, type, row) {
                    return addPeriod(parseFloat(data).toFixed(2), ",");
                },
                orderable: false,
            },
            {
                data: "kredit_us",
                name: "kredit_us",
                className: "dt-body-right",
                render: function (data, type, row) {
                    return addPeriod(parseFloat(data).toFixed(2), ",");
                },
                orderable: false,
            },
            {
                data: "dept",
                name: "dept",
                orderable: false,
            },

        ],

    });

}
