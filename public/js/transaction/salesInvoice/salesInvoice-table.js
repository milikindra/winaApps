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
    filterSI();

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
                    data: "no_bukti2",
                    name: "no_bukti2",
                },
                {
                    data: "tag",
                    name: "tag",

                },
                {
                    data: "TGL_BUKTI",
                    name: "TGL_BUKTI",
                    render: function (data, type, row) {
                        return moment(data).format("DD/MM/YYYY");
                    },
                },
                {
                    data: "NM_CUST",
                    name: "NM_CUST",
                },
                {
                    data: "NM_SALES",
                    name: "NM_SALES",
                },
                {
                    data: "TEMPO",
                    name: "TEMPO",
                },
                {
                    data: "no_so",
                    name: "no_so",
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
                    data: "isWapu",
                    name: "isWapu",
                },
                {
                    data: "no_pajak",
                    name: "no_pajak",
                },
                {
                    data: "totdpp_rp",
                    name: "totdpp_rp",
                    className: "dt-body-right",
                    render: function (data, type, row) {
                        return addPeriod(parseFloat(data).toFixed(2), ",");
                    },
                },
                {
                    data: "totppn_rp",
                    name: "totppn_rp",
                    className: "dt-body-right",
                    render: function (data, type, row) {
                        return addPeriod(parseFloat(data).toFixed(2), ",");
                    },
                },
                {
                    data: "total_rp",
                    name: "total_rp",
                    className: "dt-body-right",
                    render: function (data, type, row) {
                        return addPeriod(parseFloat(data).toFixed(2), ",");
                    },
                },
                {
                    data: "no_tt",
                    name: "no_tt",
                },
                {
                    data: "tgl_tt",
                    name: "tgl_tt",
                    render: function (data, type, row) {
                        return moment(data).format("DD/MM/YYYY");
                    },
                },
                {
                    data: "penerima_tt",
                    name: "penerima_tt",
                },
                {
                    data: "due_date",
                    name: "due_date",
                    render: function (data, type, row) {
                        return moment(data).format("DD/MM/YYYY");
                    },
                },
                {
                    data: "age",
                    name: "age",
                    className: "dt-body-right",
                    render: function (data, type, row) {
                        return addPeriod(parseFloat(data).toFixed(2), ",");
                    },
                },
                {
                    data: "TOTAL_Pendapatan",
                    name: "TOTAL_Pendapatan",
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
                    data: "no_bukti2",
                    name: "no_bukti2",
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

    function filterSI() {
        if ($("#void").is(":checked")) {
            var voids = "Y";
        } else {
            var voids = "N";
        }

        $("#dtheader tr").remove();
        if (voids == "N") {
            tbl = '<tr style="text-align: center;"> <th>SI</th> <th>Tag</th> <th>Date</th> <th>Customers</th> <th>Sales</th> <th>Due</th> <th>SO</th> <th>Currency</th> <th>Rate</th> <th>WAPU</th> <th>Tax Number</th> <th>Total DPP</th> <th>Total Tax</th> <th>Total</th> <th>Receipt Number</th> <th>Receipt Date</th> <th>Received By</th> <th>Due Date</th> <th>Age</th> <th>Paid</th> </tr>';
            $("#datatables thead").append(tbl);
        } else {
            tbl =
                ' <tr style="text-align: center;"> <th>SI</th> <th>Tag</th> <th>Date</th> <th>Customers</th> <th>Sales</th> <th>Due</th> <th>SO</th> <th>Currency</th> <th>Rate</th> <th>WAPU</th> <th>Tax Number</th> <th>Total DPP</th> <th>Total Tax</th> <th>Total</th> <th>Receipt Number</th> <th>Receipt Date</th> <th>Received By</th> <th>Due Date</th> <th>Age</th> <th>DO</th> <th>Inventory Id</th> <th>Inventory Name</th> <th>Qty</th> <th>UoM</th> <th>Price</th> <th>Total Inventory</th> <th>Paid</th> </tr>';
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
        filterSI();
    });
    $("#sdate").change(function () {
        filterSI();
    });
    $("#edate").change(function () {
        filterSI();
    });
    $("#kategoriFilter").change(function () {
        filterSI();
    });
    $("#kategoriFilter").change(function () {
        filterSI();
    });
    $("#void").change(function () {
        filterSI();
    });

    // $('#datatables tbody').on('dblclick', 'tr', function (e) {
    //     no_stock = $(this).closest("tr").children("td:eq(0)").text();
    //     window.location.href = view_url + '/' + no_stock;
    // })

});
