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
});

$("#dataType").change(function () {
    dataReport();
});

function dataReport() {
    var dataType = $("#dataType").val();
    if (dataType == "appIncomeStatement") {
        $("#appIncomeStatement").css("display", "block");
        $("#filterSdate").css("display", "block");
        $("#filterEdate").css("display", "block");
        $("#filterTotal").css("display", "block");
        $("#filterParent").css("display", "block");
        $("#filterChild").css("display", "block");
        $("#filterZero").css("display", "block");
        $("#filterTotalParrent").css("display", "block");
        $("#filterPercent").css("display", "block");
        $("#filterValas").css("display", "block");
        $("#filterShowCoa").css("display", "block");
        tableIncomeStatement();
    } else {
        $("#filterSdate").css("display", "none");
        $("#filterEdate").css("display", "none");
        $("#filterTotal").css("display", "none");
        $("#filterParent").css("display", "none");
        $("#filterChild").css("display", "none");
        $("#filterZero").css("display", "none");
        $("#filterTotalParrent").css("display", "none");
        $("#filterPercent").css("display", "none");
        $("#filterValas").css("display", "none");
        $("#filterShowCoa").css("display", "none");
    }

    if (dataType == "appCoaTransaction") {
        $("#appCoaTransaction").css("display", "block");
        $("#filterTrxId").css("display", "block");
        $("#filterTrxType").css("display", "block");
        tableCoaTransaction();
    } else {
        $("#appCoaTransaction").css("display", "none");
        $("#filterTrxId").css("display", "none");
        $("#filterTrxType").css("display", "none");
    }
}

function tableIncomeStatement() {
    $("#tableIncomeStatement").DataTable().clear().destroy();

    var sdate = $('#sdate').val();
    var edate = $('#edate').val();
    var isTotal = "N";
    var isParent = "N";
    var isChild = "N";
    var isZero = "N";
    var isTotalParrent = "N";
    var isPercent = "N";
    var isValas = "N";
    var isShowCoa = "N";

    if ($('#isTotal').is(":checked")) {
        isTotal = $('#isTotal').val();
    }
    if ($('#isParent').is(":checked")) {
        isParent = $('#isParent').val();
    }
    if ($('#isChild').is(":checked")) {
        isChild = $('#isChild').val();
    }
    if ($('#isZero').is(":checked")) {
        isZero = $('#isZero').val();
    }
    if ($('#isTotalParrent').is(":checked")) {
        isTotalParrent = $('#isTotalParrent').val();
    }
    if ($('#isPercent').is(":checked")) {
        isPercent = $('#isPercent').val();
    }
    if ($('#isValas').is(":checked")) {
        isValas = $('#isValas').val();
    }
    if ($('#isShowCoa').is(":checked")) {
        isShowCoa = $('#isShowCoa').val();
    }

    var table = $("#tableIncomeStatement").DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        stateSave: true,
        deferRender: true,
        scrollX: true,
        paging: true,
        ordering: false,
        lengthMenu: [
            [10, 100, 250, 500, 1000, -1],
            [10, 100, 250, 500, 1000, "all"],
        ],
        dom: "<'row'<'col-sm-6'l><'col-sm-6'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        ajax: {
            url: rute_incomeStatement + '/' + sdate + '/' + edate + '/' + isTotal + '/' + isParent + '/' + isChild + '/' + isZero + '/' + isTotalParrent + '/' + isPercent + '/' + isValas + '/' + isShowCoa,
            type: "GET",
            dataType: "JSON",
        },
        columns: [{
                data: "no_rek2",
                name: "no_rek2",
                orderable: false,
            },
            {
                data: "nm_rek",
                name: "nm_rek",
                orderable: false,
                render: function (data, type, row) {
                    return data.split(' ').join('&nbsp;')
                },
            },
            {
                data: "nilai",
                name: "nilai",
                orderable: false,
                className: "dt-body-right",
                render: function (data, type, row) {
                    if (data != null) {
                        return addPeriod(parseFloat(data).toFixed(2), ",");
                    }
                },
            },
            {
                data: "persen",
                name: "persen",
                orderable: false,
                className: "dt-body-right",
                render: function (data, type, row) {
                    if (data != null) {
                        return addPeriod(parseFloat(data).toFixed(2), ",") + "%";
                    }
                },
            },
        ],
    });
    $("#no-sort").even().removeClass("sorting_asc sorting_disabled");
}
