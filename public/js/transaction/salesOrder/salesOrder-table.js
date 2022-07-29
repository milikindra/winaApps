$(".selects2").select2();
$(document).ready(function () {
    var Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
    });
    var tbl = '<tr style="text-align: center;"></tr>';
    $("#datatables thead").append(tbl);
    filterSO();

    function dt(voids, kategori, fdate, sdate, edate) {
        if (voids == "N") {
            var table = $("#datatables").DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                stateSave: false,
                deferRender: true,
                bAutoWidth: false,
                lengthMenu: [
                    [100, 250, 500, 1000, -1],
                    [100, 250, 500, 1000, "all"],
                ],
                buttons: [{
                    extend: "print",
                    className: "btn-info"
                },
                {
                    extend: "excel",
                    className: "btn-info"
                },
                {
                    extend: "pdf",
                    className: "btn-info"
                },
                {
                    extend: "csv",
                    className: "btn-info"
                },
                {
                    extend: "colvis",
                    className: "btn-info"
                },
                ],
                dom:
                    // "<'row'<'col-sm-12'B>>" +
                    "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                // drawCallback: function (settings, json) {},

                ajax: {
                    url: rute +
                        "/" +
                        voids +
                        "/" +
                        kategori +
                        "/" +
                        fdate +
                        "/" +
                        sdate +
                        "/" +
                        edate,
                    type: "GET",
                    dataType: "JSON",
                },
                columns: [{
                    data: "NO_BUKTI",
                    name: "NO_BUKTI",
                    width: "15%",
                },
                {
                    data: "TGL_BUKTI",
                    name: "TGL_BUKTI",
                    width: "10%",
                    render: function (data, type, row) {
                        return moment(data).format("DD/MM/YYYY");
                    },
                },
                {
                    data: "NM_CUST",
                    name: "NM_CUST",
                    width: "50%",
                },
                {
                    data: "Dept",
                    name: "Dept",
                },
                {
                    data: "PO_CUST",
                    name: "PO_CUST",
                    width: "10%",
                },
                {
                    data: "totdpp",
                    name: "totdpp",
                    className: "dt-body-right",
                    width: "10%",
                    render: function (data, type, row) {
                        return addPeriod(parseFloat(data).toFixed(2), ",");
                    },
                },
                {
                    data: "totppn",
                    name: "totppn",
                    className: "dt-body-right",
                    width: "10%",
                    render: function (data, type, row) {
                        return addPeriod(parseFloat(data).toFixed(2), ",");
                    },
                },
                {
                    data: "total",
                    name: "total",
                    className: "dt-body-right",
                    width: "10%",
                    render: function (data, type, row) {
                        return addPeriod(parseFloat(data).toFixed(2), ",");
                    },
                },
                {
                    data: "QTY",
                    name: "QTY",
                    className: "dt-body-right",
                    width: "10%",
                    render: function (data, type, row) {
                        return addPeriod(parseFloat(data).toFixed(2), ",");
                    },
                },
                {
                    data: "SJ_QTY",
                    name: "SJ_QTY",
                    className: "dt-body-right",
                    width: "10%",
                    render: function (data, type, row) {
                        return addPeriod(parseFloat(data).toFixed(2), ",");
                    },
                },
                {
                    data: "RJ_QTY",
                    name: "RJ_QTY",
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
        } else {
            var table = $("#datatables").DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                stateSave: false,
                deferRender: true,
                bAutoWidth: false,
                lengthMenu: [
                    [5, 100, 250, 500, 1000, -1],
                    [5, 100, 250, 500, 1000, "all"],
                ],
                buttons: ["excel", "pdf", "print", "csv", "colvis"],
                dom:
                    // "<'row'<'col-sm-12'B>>" +
                    "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                // drawCallback: function (settings, json) {},

                ajax: {
                    url: rute +
                        "/" +
                        voids +
                        "/" +
                        kategori +
                        "/" +
                        fdate +
                        "/" +
                        sdate +
                        "/" +
                        edate,
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
                        return moment(data).format("DD/MMM/YYYY");
                    },
                },
                {
                    data: "NM_CUST",
                    name: "NM_CUST",
                    width: "20%",
                },
                {
                    data: "Dept",
                    name: "Dept",
                },
                {
                    data: "PO_CUST",
                    name: "PO_CUST",
                },
                {
                    data: "totdpp",
                    name: "totdpp",
                    className: "dt-body-right",
                    width: "10%",
                    render: function (data, type, row) {
                        return addPeriod(parseFloat(data).toFixed(2), ",");
                    },
                },
                {
                    data: "totppn",
                    name: "totppn",
                    className: "dt-body-right",
                    width: "10%",
                    render: function (data, type, row) {
                        return addPeriod(parseFloat(data).toFixed(2), ",");
                    },
                },
                {
                    data: "total",
                    name: "total",
                    className: "dt-body-right",
                    width: "10%",
                    render: function (data, type, row) {
                        return addPeriod(parseFloat(data).toFixed(2), ",");
                    },
                },
                {
                    data: "NO_STOCK",
                    name: "NO_STOCK",
                    width: "10%",
                },
                {
                    data: "NM_STOCK",
                    name: "NM_STOCK",
                    width: "30%",
                },
                {
                    data: "QTY",
                    name: "QTY",
                    className: "dt-body-right",
                    render: function (data, type, row) {
                        return addPeriod(parseFloat(data).toFixed(2), ",");
                    },
                },
                {
                    data: "SAT",
                    name: "SAT",
                },
                {
                    data: "HARGA",
                    name: "HARGA",
                    className: "dt-body-right",
                    width: "10%",
                    render: function (data, type, row) {
                        return addPeriod(parseFloat(data).toFixed(2), ",");
                    },
                },
                {
                    data: "SJ_QTY",
                    name: "SJ_QTY",
                    className: "dt-body-right",
                    render: function (data, type, row) {
                        return addPeriod(parseFloat(data).toFixed(2), ",");
                    },
                },
                {
                    data: "RJ_QTY",
                    name: "RJ_QTY",
                    className: "dt-body-right",
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
    }

    function filterSO() {
        if ($("#void").is(":checked")) {
            var voids = "Y";
        } else {
            var voids = "N";
        }

        $("#dtheader tr").remove();
        if (voids == "N") {
            tbl =
                '<tr style="text-align: center;"><th>SO</th><th>Date</th><th>Customers</th><th>Dept</th><th>PO Customer</th><th>Total DPP</th><th>Total PPn</th><th>Total</th><th>Qty SO</th><th>Qty DO</th><th>Qty SR</th></tr>';
            $("#datatables thead").append(tbl);
        } else {
            tbl =
                '<tr style="text-align: center;"><th>SO</th><th>Date</th><th width="10%">Customers</th><th>Dept</th><th>PO Customer</th><th>Total DPP</th><th>Total PPn</th><th>Total</th><th>Inventory Id</th><th width="20%">Inventory Name</th><th>Qty SO</th><th>UoM</th><th>Price</th><th>Qty DO</th><th>Qty SR</th></tr>';
            $("#datatables thead").append(tbl);
        }
        var kategori = $("#kategoriFilter").val();
        var sdate = $("#sdate").val();
        var edate = $("#edate").val();
        if ($("#fdate").is(":checked")) {
            var fdate = "Y";
        } else {
            var fdate = "N";
        }
        $("#datatables").DataTable().clear().destroy();
        dt(voids, kategori, fdate, sdate, edate);
    }

    $("#fdate").change(function () {
        filterSO();
    });
    $("#sdate").change(function () {
        filterSO();
    });
    $("#edate").change(function () {
        filterSO();
    });
    $("#kategoriFilter").change(function () {
        filterSO();
    });
    $("#kategoriFilter").change(function () {
        filterSO();
    });
    $("#void").change(function () {
        filterSO();
    });

    $('#datatables tbody').on('dblclick', 'tr', function (e) {
        no_stock = $(this).closest("tr").children("td:eq(0)").text();
        window.location.href = view_url + '/' + no_stock;
    })

});
