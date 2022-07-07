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

$(document).ajaxSend(function (event, request, settings) {
    $('#loading-indicator').show();
});

$(document).ajaxComplete(function (event, request, settings) {
    $('#loading-indicator').hide();
});

$("#dataType").change(function () {
    $("#appIncomeStatement").css("display", "none");
    $("#appBalanceSheet").css("display", "none");
    $("#appProjectPnl").css("display", "none");
    $("#appProjectPnlList").css("display", "none");

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
    $("#filterProjectBy").css("display", "none");
    $("#filterProject").css("display", "none");

    var dataType = $("#dataType").val();
    if (dataType == "appIncomeStatement") {
        $("#tableIncomeStatement table").empty();

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
        $("#tableBalanceSheet table").empty();
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
        $("#tablePnlProject table").empty();
        $("#appProjectPnl").css("display", "block");
        $("#filterEdate").css("display", "block");
        $("#filterSo").css("display", "block");
        $("#filterCommision").css("display", "block");
        $("#filterAssumptionCost").css("display", "block");
        $("#filterOverhead").css("display", "block");
        $("#filterPh").css("display", "block");
    }

    if (dataType == "appProjectPnlList") {
        $("#tablePnlProjectList table").empty();
        $("#appProjectPnlList").css("display", "block");
        $("#filterSdate").css("display", "block");
        $("#filterEdate").css("display", "block");
        $("#filterAssumptionCost").css("display", "block");
        $("#filterOverhead").css("display", "block");
        $("#filterProjectBy").css("display", "block");
        $("#filterProject").css("display", "block");

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
            datas[i].value = parseFloat(removePeriod($('#commision_value-' + i).val(),','));
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

    if (dataType == "appProjectPnlList") {
        tablePnlProjectList();
    }

}

function tableIncomeStatement() {
    $("#tableIncomeStatement").empty();

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

    $.ajax({
        type: 'GET',
        url: rute_incomeStatement + '/' + sdate + '/' + edate + '/' + isTotal + '/' + isParent + '/' + isChild + '/' + isZero + '/' + isTotalParent + '/' + isPercent + '/' + isValas + '/' + isShowCoa,
        dataType: 'json',
        success: function (data) {
            $('#titleIncomeStatement').html('PT. VIKTORI PROFINDO AUTOMATION');;
            $('#subtitleIncomeStatement').html('FINANCIAL REPORT - INCOME STATEMENT');;
            $('#filterIncomeStatement').html('Periode : ' + moment(sdate).format("DD/MM/YYYY") + ' to : ' + moment(edate).format("DD/MM/YYYY"));

            var html = '';
            html = '<thead> <tr style="text-align: center;"> <th colspan="2">Description</th> <th colspan="2">Balance</th> </tr></thead>';
            html += '<tbody>';

            var a = JSON.parse(JSON.stringify(data));
            $.each(a.data, function (i, item) {
                html += '<tr>';
                if (item.haschild == "Y") {
                    html += '<td><strong>' + item.no_rek2 + '</strong></td>';
                    html += '<td><strong>' + item.nm_rek + '</strong></td>';
                    if (item.tipe == "T") {
                        html += '<td style="text-align:right"><strong>' + numbro(item.nilai).format({
                            thousandSeparated: true,
                            negative: "parenthesis",
                            mantissa: 2
                        }) + '</strong></td>';
                        html += '<td style="text-align:right"><strong>' + numbro(item.persen).format({
                            thousandSeparated: true,
                            negative: "parenthesis",
                        }) + '%</strong></td>';
                    } else {
                        html += '<td></td>';
                        html += '<td></td>';
                    }
                } else {
                    html += '<td>' + item.no_rek2 + '</td>';
                    html += '<td>' + item.nm_rek.replace(' ', '&nbsp;') + '</td>';
                    html += '<td style="text-align:right">' + numbro(item.nilai).format({
                        thousandSeparated: true,
                        negative: "parenthesis",
                        mantissa: 2
                    }) + '</td>';
                    html += '<td style="text-align:right">' + numbro(item.persen).format({
                        thousandSeparated: true,
                        negative: "parenthesis",
                        mantissa: 2,
                    }) + '%</td>';
                }
                html += '</tr>';
            });
            html += '</tbody>'
            $("#tableIncomeStatement").html(html);
        }
    });
}

function tableBalanceSheet() {
    $("#overlay").fadeIn(300);

    $("#tableBalanceSheet").empty();
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


    $.ajax({
        type: 'GET',
        url: rute_balanceSheet + '/' + sdate + '/' + edate + '/' + isTotal + '/' + isParent + '/' + isChild + '/' + isZero + '/' + isTotalParent + '/' + isPercent + '/' + isValas + '/' + isShowCoa,
        dataType: 'json',
        success: function (data) {
            $('#titleBalanceSheet').html('PT. VIKTORI PROFINDO AUTOMATION');;
            $('#subtitleBalanceSheet').html('FINANCIAL REPORT - BALANCE SHEET');;
            $('#filterBalanceSheet').html('Per : ' + moment(edate).format("DD/MM/YYYY"));

            var html = '';
            html = '<thead> <tr style="text-align: center;"> <th colspan="2">Description</th> <th colspan="2">Balance</th> </tr></thead>';
            html += '<tbody>';

            var a = JSON.parse(JSON.stringify(data));
            $.each(a.data, function (i, item) {
                if (item.nm_rek != '') {
                    html += '<tr>';
                    if (item.haschild == "Y") {
                        html += '<td><strong>' + item.no_rek2 + '</strong></td>';
                        html += '<td><strong>' + item.nm_rek + '</strong></td>';
                        if (item.tipe == "T") {
                            html += '<td style="text-align:right"><strong>' + numbro(item.nilai).format({
                                thousandSeparated: true,
                                negative: "parenthesis",
                                mantissa: 2
                            }) + '</strong></td>';
                            html += '<td style="text-align:right"><strong>' + item.valas + '</strong></td>';
                        } else {
                            html += '<td></td>';
                            html += '<td></td>';
                        }
                    } else {
                        html += '<td>' + item.no_rek2 + '</td>';
                        html += '<td>' + item.nm_rek.replace(' ', '&nbsp;') + '</td>';
                        html += '<td style="text-align:right">' + numbro(item.nilai).format({
                            thousandSeparated: true,
                            negative: "parenthesis",
                            mantissa: 2
                        }) + '</td>';
                        html += '<td style="text-align:right">' + item.valas + '</td>';
                    }
                    html += '</tr>';
                }
            });
            html += '</tbody>'
            $("#tableBalanceSheet").html(html);
            setTimeout(function () {
                $("#overlay").fadeOut(300);
            }, 500);
        }
    });
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
    $("#tablePnlProject").empty();
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

    $.ajax({
        type: 'GET',
        url: rute_pnlProjectTable + '/' + edate + '/' + so_id + '/' + isAssumptionCost + '/' + isOverhead,
        dataType: 'json',
        success: function (data) {
            $('#titleProjectPnl').html('PT. VIKTORI PROFINDO AUTOMATION');;
            $('#subtitleProjectPnl').html('FINANCIAL REPORT - PROFIT AND LOSS PROJECT');;
            $('#filterProjectPnl').html('SO : ' + so_id + ' Per : ' + moment(edate).format("DD/MM/YYYY"));

            var html = '';
            html = '<thead> <tr style="text-align: center;"> <th>Description</th> <th colspan="2">Balance</th> </tr></thead>';
            html += '<tbody>';

            var a = JSON.parse(JSON.stringify(data));
            $.each(a.data, function (i, item) {
                if (item.uraian != '') {
                    html += '<tr>';
                    if (item.tipe == "X") {
                        html += '<td><strong>' + item.uraian + '</strong></td>';
                        html += '<td></td>';
                        html += '<td></td>';

                    } else if (item.tipe == "T") {
                        html += '<td><strong>' + item.uraian + '</strong></td>';
                        html += '<td style="text-align:right"><strong>' + numbro(item.nilai).format({
                            thousandSeparated: true,
                            negative: "parenthesis",
                            mantissa: 2
                        }) + '</strong></td>';
                        html += '<td style="text-align:right"><strong>' + numbro(item.prosentase).format({
                            thousandSeparated: true,
                            negative: "parenthesis",
                            mantissa: 2,
                        }) + '%</strong></td>';
                    } else {
                        html += '<td>' + item.uraian + '</td>';
                        if (item.nilai == null) {
                            html += '<td></td>';
                        } else {
                            html += '<td style="text-align:right">' + numbro(item.nilai).format({
                                thousandSeparated: true,
                                negative: "parenthesis",
                                mantissa: 2
                            }) + '</td>';
                        }
                        if (item.prosentase == null) {
                            html += '<td></td>';
                        } else {
                            html += '<td style="text-align:right">' + numbro(item.prosentase).format({
                                thousandSeparated: true,
                                negative: "parenthesis",
                                mantissa: 2,
                            }) + '%</td>';
                        }
                    }
                    html += '</tr>';
                }
            });
            html += '</tbody>'
            $("#tablePnlProject").html(html);
        }
    });
}

function tablePnlProjectList() {
    $("#overlay").fadeIn(300);
    $("#tablePnlProjectList").empty();
    var sdate = $('#sdate').val();
    var edate = $('#edate').val();
    var isAssumptionCost = "N";
    var isOverhead = "N";
    var showProjectBy = $('#showProjectBy').val();
    var showProject = $('#showProject').val();

    if ($('#isAssumptionCost').is(":checked")) {
        isAssumptionCost = $('#isAssumptionCost').val();
    }
    if ($('#isOverhead').is(":checked")) {
        isOverhead = $('#isOverhead').val();
    }

    $.ajax({
        type: 'GET',
        url: rute_pnlProjectListTable + '/' + sdate + '/' + edate + '/' + isAssumptionCost + '/' + isOverhead + '/' + showProjectBy + '/' + showProject,
        dataType: 'json',
        success: function (data) {
            $('#titleProjectPnlList').html('PT. VIKTORI PROFINDO AUTOMATION');;
            $('#subtitleProjectPnlList').html('FINANCIAL REPORT - PROFIT AND LOSS PROJECT (LIST)');;
            $('#filterProjectPnlList').html('Periode : ' + moment(sdate).format("DD/MM/YYYY") + ' To : ' + moment(edate).format("DD/MM/YYYY"));

            var html = '';
            html = '<thead> <tr style="text-align: center;"> <th>SO</th> <th>SO Date</th> <th>SO Type</th> <th>Customer</th> <th>Sales</th> <th>PO</th> <th>Tag</th> <th>Last DO</th> <th>Payment Date</th> <th>Age</th> <th>CR Create Date</th> <th>Revenue</th> <th>COGS</th> <th>In Ordered</th> <th>Stock In Hand</th> <th>Item Adjusment</th> <th>Gross Profit</th> <th>Gross Profit(%)</th> <th>Expense</th> <th>Ass Exp</th> <th>Profit</th> <th>Net Profit (%)</th> <th>PH</th> </tr></thead>';
            html += '<tbody>';
            var a = JSON.parse(JSON.stringify(data));
            $.each(a.data, function (i, item) {
                var umur = '-';
                if (item.umur != null) {
                    umur = item.umur;
                }

                var tgl_clear = '-';
                if (item.tgl_clear != null) {
                    tgl_clear = moment(item.tgl_clear).format("DD/MM/YYYY")
                }

                html += '<tr>';
                html += '<td>' + item.no_SO + '</td>';
                html += '<td style="text-align:center">' + moment(item.tgl_SO).format("DD/MM/YYYY") + '</td>';
                html += '<td>' + item.jenisSO + '</td>';
                html += '<td>' + item.nm_cust + '</td>';
                html += '<td>' + item.Sales + '</td>';
                html += '<td>' + item.no_po + '</td>';
                html += '<td>' + item.Tag + '</td>';
                html += '<td style="text-align:center">' + moment(item.tgl_Last_DO).format("DD/MM/YYYY") + '</td>';
                html += '<td style="text-align:center">' + tgl_clear  +
                    '</td>';
                html += '<td>' + umur + '</td>';
                html += '<td>' + moment(item.tgl_create_cr).format("DD/MM/YYYY") + '</td>';
                html += '<td style="text-align:right">' + numbro(item.REVENUE).format({
                    thousandSeparated: true,
                    negative: "parenthesis",
                    mantissa: 2
                }) + '</td>';
                html += '<td style="text-align:right">' + numbro(item.COGS).format({
                    thousandSeparated: true,
                    negative: "parenthesis",
                    mantissa: 2
                }) + '</td>';
                html += '<td style="text-align:right">' + numbro(item.InOrdered).format({
                    thousandSeparated: true,
                    negative: "parenthesis",
                    mantissa: 2
                }) + '</td>';
                html += '<td style="text-align:right">' + numbro(item.StockInHand).format({
                    thousandSeparated: true,
                    negative: "parenthesis",
                    mantissa: 2
                }) + '</td>';
                html += '<td style="text-align:right">' + numbro(item.ItemAdjustment).format({
                    thousandSeparated: true,
                    negative: "parenthesis",
                    mantissa: 2
                }) + '</td>';
                html += '<td style="text-align:right">' + numbro(item.Gross_Profit).format({
                    thousandSeparated: true,
                    negative: "parenthesis",
                    mantissa: 2
                }) + '</td>';
                html += '<td style="text-align:right">' + numbro(item.prosen1).format({
                    thousandSeparated: true,
                    negative: "parenthesis",
                    mantissa: 2
                }) + '%</td>';
                html += '<td style="text-align:right">' + numbro(item.other_exp).format({
                    thousandSeparated: true,
                    negative: "parenthesis",
                    mantissa: 2
                }) + '</td>';
                html += '<td style="text-align:right">' + numbro(item.Ass_Exp).format({
                    thousandSeparated: true,
                    negative: "parenthesis",
                    mantissa: 2
                }) + '</td>';
                html += '<td style="text-align:right">' + numbro(item.Profit).format({
                    thousandSeparated: true,
                    negative: "parenthesis",
                    mantissa: 2
                }) + '</td>';
                html += '<td style="text-align:right">' + numbro(item.prosen2).format({
                    thousandSeparated: true,
                    negative: "parenthesis",
                    mantissa: 2
                }) + '%</td>';
                html += '<td>' + item.note_PH + '</td>';
                html += '</tr>';
            });
            html += '</tbody>'
            $("#tablePnlProjectList").html(html);
            setTimeout(function () {
                $("#overlay").fadeOut(300);
            }, 500);
        }
    });
}
