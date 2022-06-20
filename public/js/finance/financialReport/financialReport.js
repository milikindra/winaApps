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
    $("#appProjectPnl").css("display", "none");

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
    $("#filterCommision").css("display", "none");
    $("#filterAssumptionCost").css("display", "none");
    $("#filterOverhead").css("display", "none");
    $("#filterPh").css("display", "none");

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
        $("#tablePnlProject").DataTable().clear();
        $("#appProjectPnl").css("display", "block");
        $("#filterEdate").css("display", "block");
        $("#filterSo").css("display", "block");
        $("#filterCommision").css("display", "block");
        $("#filterAssumptionCost").css("display", "block");
        $("#filterOverhead").css("display", "block");
        $("#filterPh").css("display", "block");
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

    if (dataType == "appProjectPnl") {
        var so_id = $('#so_id').val();
        var notePh = $('#notePh').val();
        var tbodyRowCount = $("#filterCommision tbody tr").length;
        var datas = [];
        for (i = 0; i < tbodyRowCount; i++) {
            datas[i] = new Object();
            datas[i].ket = $('#commision_desc-' + i).val();
            datas[i].value = $('#commision_value-' + i).val();
            datas[i].type = $('#commision_type-' + i).val();
        }
        let _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'POST',
            url: rute_pnlProjectSave,
            data: {
                datas: datas,
                so_id: so_id,
                notePh: notePh,
                _token: _token
            },
            dataType: "text",
            success: function (resultData) {
                console.log("Save Complete")
            },
            error: function () {
                console.log("Something went wrong");
            }
        });
        tablePnlProject();
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
            url: rute_balanceSheet + '/' + sdate + '/' + edate + '/' + isTotal + '/' + isParent + '/' + isChild + '/' + isZero + '/' + isTotalParent + '/' + isPercent + '/' + isValas + '/' + isShowCoa,
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




var rowCount = 0;
window.addRowCommision = function (element) {
    rowCount = $("#filterCommision tbody tr").length;
    $(".filterCommision").append(
        '<tr> <td> <input type="text" class="form-control form-control-sm" name="commision_desc[]" id="commision_desc-' +
        rowCount +
        '" >  </td><td> <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="commision_value[]" id="commision_value-' +
        rowCount +
        '"> </td> <td><select class="form-control form-control-sm selects2" name="commision_type[]" id="commision_type-' +
        rowCount +
        '"> <option value = "prosen" selected>%</option><option value = "idr"> IDR</option></select></td></tr>'
    );
};

window.removeRowCommision = function (element) {
    $(".filterCommision tbody tr:last").remove();
};

function tablePnlProject() {
    $("#tablePnlProject").DataTable().clear().destroy();

    var edate = $('#edate').val();
    var so_id = $('#so_id').val();
    var isAssumptionCost = "N";
    var isOverhead = "N";


    if ($('#isAssumptionCost').is(":checked")) {
        isAssumptionCost = $('#isAssumptionCost').val();
    }
    if ($('#isOverhead').is(":checked")) {
        isOverhead = $('#isOverhead').val();
    }

    console.log(rute_pnlProjectTable + '/' + edate + '/' + so_id + '/' + isAssumptionCost + '/' + isOverhead);
    var table = $("#tablePnlProject").DataTable({
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
            url: rute_pnlProjectTable + '/' + edate + '/' + so_id + '/' + isAssumptionCost + '/' + isOverhead,
            type: "GET",
            dataType: "JSON",
        },
        columns: [{
                data: "uraian",
                name: "uraian",
                orderable: false,
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
                data: "prosentase",
                name: "prosentase",
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
