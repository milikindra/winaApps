$(".selects2").select2();
$(document).ready(function () {
    var Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
    });

    var tbl =
        '<tr style="text-align: center;"><th>Nomor</th><th>Tanggal</th><th>Kode</th><th>Nama</th><th>Dept</th><th>PO Customer</th><th>Total DPP</th><th>Total PPn</th><th>Total</th><th>Qty SO</th><th>Qty DO</th><th>Qty SR</th></tr>';
    $("#datatables thead").append(tbl);
    var voids = "N";
    var kategori = "all";
    var fdate = "N";
    var sdate = $("#sdate").val();
    var edate = $("#edate").val();
    function dt(voids, kategori, fdate, sdate, edate) {
        if (voids == "N") {
            var table = $("#datatables").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                stateSave: true,
                deferRender: true,
                bAutoWidth: false,
                lengthMenu: [
                    [5, 100, 250, 500, 1000, -1],
                    [5, 100, 250, 500, 1000, "all"],
                ],
                buttons: ["excel", "pdf", "print", "csv"],
                dom:
                    // "<'row'<'col-sm-12'B>>" +
                    "<'row'<'col-sm-6'lB><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                drawCallback: function (settings, json) {},
                ajax: {
                    url:
                        rute +
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
                columns: [
                    {
                        data: "NO_BUKTI",
                        name: "NO_BUKTI",
                        width: "15%",
                    },
                    {
                        data: "TGL_BUKTI",
                        name: "TGL_BUKTI",
                        width: "10%",
                        render: function (data, type, row) {
                            return moment(data).format("DD MMM YYYY");
                        },
                    },
                    {
                        data: "ID_CUST",
                        name: "ID_CUST",
                        width: "15%",
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
                order: [[0, "asc"]],
            });
        } else {
        }
    }
    dt(voids, kategori, fdate, sdate, edate);

    function filterSO() {
        if ($("#fdate").is(":checked")) {
            fdate = "Y";
            sdate = $("#sdate").val();
            edate = $("#edate").val();
            $("#datatables").DataTable().clear().destroy();
            dt(voids, kategori, fdate, sdate, edate);
        } else {
            fdate = "N";
            sdate = $("#sdate").val();
            edate = $("#edate").val();
            $("#datatables").DataTable().clear().destroy();
            dt(voids, kategori, fdate, sdate, edate);
        }
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

    // $("#void").change(function () {
    //     if ($(this).is(":checked")) {
    //         $("#datatables").DataTable().clear().destroy();
    //         voids = "Y";
    //         dt(voids, kategori, fdate, sdate, edate);
    //     } else {
    //         $("#datatables").DataTable().clear().destroy();
    //         voids = "N";

    //         dt(voids, kategori, fdate, sdate, edate);
    //     }
    // });

    // $("#kategoriFilter").change(function () {
    //     $("#datatables").DataTable().clear().destroy();
    //     kategori = $("#kategoriFilter").val();
    //     dt(voids, kategori, subkategori);
    // });

    // $("#subkategoriFilter").change(function () {
    //     $("#datatables").DataTable().clear().destroy();
    //     subkategori = $("#subkategoriFilter").val();
    //     dt(voids, kategori, subkategori);
    // });
});
