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
    $("#appIncomeStatement").css("display", "none");
    $("#appBalanceSheet").css("display", "none");

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
    $("#filterSo").css("display", "none");

    var dataType = $("#dataType").val();
    if (dataType == "appIncomeStatement") {
        $("#tableIncomeStatement").DataTable().clear();
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
    }

    if (dataType == "appBalanceSheet") {
        $("#tableBalanceSheet").DataTable().clear();
        $("#appBalanceSheet").css("display", "block");
        $("#filterEdate").css("display", "block");
        $("#filterTotal").css("display", "block");
        $("#filterParent").css("display", "block");
        $("#filterChild").css("display", "block");
        $("#filterZero").css("display", "block");
        $("#filterTotalParrent").css("display", "block");
        $("#filterValas").css("display", "block");
        $("#filterShowCoa").css("display", "block");
    }

    if (dataType == "appProjectPnl") {
        $("#filterEdate").css("display", "block");
        $("#filterSo").css("display", "block");
    }
});

function dataReport() {
    var dataType = $("#dataType").val();
    if (dataType == "appIncomeStatement") {
        tableIncomeStatement();
    }

    if (dataType == "appBalanceSheet") {
        tableBalanceSheet();
    }
    console.log(dataType);

    if (dataType == "appProjectPnl") {

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
    var isTotalParent = "N";
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
    if ($('#isTotalParent').is(":checked")) {
        isTotalParent = $('#isTotalParent').val();
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
        paging: false,
        ordering: false,
        lengthMenu: [
            [10, 100, 250, 500, 1000, -1],
            [10, 100, 250, 500, 1000, "all"],
        ],
        dom: "<'row'<'col-sm-6'l><'col-sm-6'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'><'col-sm-6'p>>",
        ajax: {
            url: rute_incomeStatement + '/' + sdate + '/' + edate + '/' + isTotal + '/' + isParent + '/' + isChild + '/' + isZero + '/' + isTotalParent + '/' + isPercent + '/' + isValas + '/' + isShowCoa,
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

function tableBalanceSheet() {
    $("#tableBalanceSheet").DataTable().clear().destroy();
    var sdate = $('#sdate').val();
    var edate = $('#edate').val();
    var isTotal = "N";
    var isParent = "N";
    var isChild = "N";
    var isZero = "N";
    var isTotalParent = "N";
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
    if ($('#isTotalParent').is(":checked")) {
        isTotalParent = $('#isTotalParent').val();
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

    var table = $("#tableBalanceSheet").DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        stateSave: true,
        deferRender: true,
        scrollX: true,
        paging: false,
        ordering: false,
        lengthMenu: [
            [10, 100, 250, 500, 1000, -1],
            [10, 100, 250, 500, 1000, "all"],
        ],
        dom: "<'row'<'col-sm-6'l><'col-sm-6'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'><'col-sm-6'p>>",
        ajax: {
            url: rute_balancesheet + '/' + sdate + '/' + edate + '/' + isTotal + '/' + isParent + '/' + isChild + '/' + isZero + '/' + isTotalParent + '/' + isPercent + '/' + isValas + '/' + isShowCoa,
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
                data: "valas",
                name: "valas",
                orderable: false,
                className: "dt-body-right"
            }
        ],
    });
    $("#no-sort").even().removeClass("sorting_asc sorting_disabled");
}
