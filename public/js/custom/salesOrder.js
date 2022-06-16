var get_salesOrder = "salesOrder/data/populateHead";


arr = [];

function modalSo() {
    // arr.push(uid);
    $("#modalSO").modal("show");
    tabelModalSo();
    $("#tabelModalSo").on("click", "tbody tr", function () {
        no_so = $(this).closest("tr").children("td:eq(0)").text();
        $("#so_id").val(no_so);
        $("#so_descrription").html(no_so);

        $("#modalSO").modal("hide");
    });
}

function tabelModalSo() {
    $("#tabelModalSo").DataTable().clear().destroy();
    var table = $("#tabelModalSo").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        stateSave: true,
        deferRender: true,
        lengthMenu: [
            [10, 100, 250, 500, 1000, -1],
            [10, 100, 250, 500, 1000, "all"],
        ],
        dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        drawCallback: function (settings, json) {},
        ajax: {
            url: get_salesOrder,
            type: "GET",
            dataType: "JSON",
        },
        columns: [{
                data: "NO_BUKTI",
                name: "NO_BUKTI",
                width: "10%",
            },
            {
                data: "TGL_BUKTI",
                name: "TGL_BUKTI",
                width: "5%",
                render: function (data, type, row) {
                    return moment(data).format("DD MMM YYYY");
                },
            },
            {
                data: "ID_SALES",
                name: "ID_SALES",
                width: "10%",
            },
            {
                data: "NM_SALES",
                name: "NM_SALES",
                width: "10%",
            },
            {
                data: "ID_CUST",
                name: "ID_CUST",
                width: "10%",
            },
            {
                data: "NM_CUST",
                name: "NM_CUST",
                width: "20%",
            },
            {
                data: "TEMPO",
                name: "TEMPO",
            },
            {
                data: "curr",
                name: "curr",
            },
            {
                data: "rate",
                name: "rate",
            },
            {
                data: "PO_CUST",
                name: "PO_CUST",
            },
            {
                data: "jenis",
                name: "jenis",
            },
            {
                data: "no_ref",
                name: "no_ref",
            },
            {
                data: "DIVISI",
                name: "DIVISI",
            },
            {
                data: "total_rp",
                name: "total_rp",
                className: "dt-body-right",
                width: "10%",
                render: function (data, type, row) {
                    return addPeriod(parseFloat(data).toFixed(2), ",");
                },
            },

        ],
        order: [
            [0, "asc"]
        ],
    });
}
