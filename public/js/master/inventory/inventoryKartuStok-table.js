$(".selects2").select2({
    theme: "bootstrap4",
});

$(document).ready(function () {
    function dt() {
        var kode = $("#kode_kartu_stok").val();
        var sdate = $("#sdate").val();
        var edate = $("#edate").val();
        var lokasi = $("#lokasi").val();
        var item_transfer = "N";
        if ($("#item_transfer").is(":checked")) {
            item_transfer = "Y";
        }
        var table = $("#datatables").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            searching: false,
            orderable: false,
            dom: "Bfrtip",
            buttons: ["excel", "pdf", "print", "csv"],

            drawCallback: function (settings, json) {},
            ajax: {
                url:
                    rute +
                    "/" +
                    kode +
                    "/" +
                    sdate +
                    "/" +
                    edate +
                    "/" +
                    lokasi +
                    "/" +
                    item_transfer,
                type: "GET",
                dataType: "JSON",
                error: function (xhr, textStatus, ThrownException) {
                    alert("Terjadi kesalahan pada server");
                },
            },
            columns: [
                {
                    data: "trx",
                    name: "trx",
                    render: function (data, type, row) {
                        if (data == "PK") {
                            return "PAKAI";
                        } else {
                            return data;
                        }
                    },
                    orderable: false,
                },
                {
                    data: "no_bukti",
                    name: "no_bukti",
                    className: "text-center",
                    orderable: false,
                },
                {
                    data: "tgl_bukti",
                    name: "tgl_bukti",
                    render: function (data, type, row) {
                        return moment(data).format("DD MMM YYYY");
                    },
                    className: "text-center",
                    orderable: false,
                },
                {
                    data: "id_lokasi",
                    name: "id_lokasi",
                    className: "text-center",
                    orderable: false,
                },
                {
                    data: "qty",
                    name: "qty",
                    render: function (data, type, row) {
                        if (data >= 0) {
                            return addPeriod(parseFloat(data).toFixed(2), ",");
                        } else {
                            return "0.00";
                        }
                    },
                    className: "dt-body-right",
                    orderable: false,
                },
                {
                    data: "jml_pok",
                    name: "jml_pok",
                    render: function (data, type, row) {
                        if (data >= 0) {
                            return addPeriod(parseFloat(data).toFixed(2), ",");
                        } else {
                            return "0.00";
                        }
                    },
                    className: "dt-body-right",
                    orderable: false,
                },
                {
                    data: "qty",
                    name: "qty",
                    render: function (data, type, row) {
                        if (data < 0) {
                            return addPeriod(parseFloat(-data).toFixed(2), ",");
                        } else {
                            return "0.00";
                        }
                    },
                    className: "dt-body-right",
                    orderable: false,
                },
                {
                    data: "jml_pok",
                    name: "jml_pok",
                    render: function (data, type, row) {
                        if (data < 0) {
                            return addPeriod(parseFloat(-data).toFixed(2), ",");
                        } else {
                            return "0.00";
                        }
                    },
                    className: "dt-body-right",
                    orderable: false,
                },
                {
                    data: "saldo",
                    name: "saldo",
                    render: function (data, type, row) {
                        return addPeriod(parseFloat(data).toFixed(2), ",");
                    },
                    className: "dt-body-right",
                    orderable: false,
                },
                {
                    data: "nilai_saldo",
                    name: "nilai_saldo",
                    render: function (data, type, row) {
                        return addPeriod(parseFloat(data).toFixed(2), ",");
                    },
                    className: "dt-body-right",
                    orderable: false,
                },
            ],
            order: [[2, "asc"]],
        });
    }
    dt();

    window.kartuStok = function (element) {
        $("#datatables").DataTable().clear().destroy();
        dt();
    };
});
