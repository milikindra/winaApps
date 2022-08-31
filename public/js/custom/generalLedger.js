var get_generalLedger = "generalLedger/data/populateCoaTransaction";

arr = [];

function modalGl() {
    if ($("#tableModalGeneralLedger tbody tr").length > 0) {
        $("#tableModalGeneralLedger").DataTable().clear().destroy();
    }
    var trxType = "all";
    var trxId = 'all';
    if ($('#si_id').val() != '' && $('#si_id').val() != null) {
        trxId = btoa($('#si_id').val());
    }
    var sdate = $('#sdateGeneralLedger').val();
    var edate = $('#edateGeneralLedger').val();
    var table = $("#tableModalGeneralLedger").DataTable({
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
            url: url_default + '/' + get_generalLedger + '/' + sdate + '/' + edate + '/' + trxType + '/' + trxId,
            type: "GET",
            dataType: "JSON",
            error: function (xhr, error, thrown) {
                $("#tableModalGeneralLedger").DataTable().clear().destroy();
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
                return moment(data).format("DD/MM/YYYY");
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
                return numbro(data).format({
                    thousandSeparated: true,
                    negative: "parenthesis",
                    mantissa: 2
                })
            },
            orderable: false,
        },
        {
            data: "kredit",
            name: "kredit",
            className: "dt-body-right",
            render: function (data, type, row) {
                return numbro(data).format({
                    thousandSeparated: true,
                    negative: "parenthesis",
                    mantissa: 2
                })
            },
            orderable: false,
        },

        {
            data: "debet_us",
            name: "debet_us",
            className: "dt-body-right",
            render: function (data, type, row) {
                return numbro(data).format({
                    thousandSeparated: true,
                    negative: "parenthesis",
                    mantissa: 2
                })
            },
            orderable: false,
        },
        {
            data: "kredit_us",
            name: "kredit_us",
            className: "dt-body-right",
            render: function (data, type, row) {
                return numbro(data).format({
                    thousandSeparated: true,
                    negative: "parenthesis",
                    mantissa: 2
                })
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

    $("#modalGenerelLedger").modal("show");
}
