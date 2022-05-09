$(document).ready(function () {
    var voids = "1";
    var kategori = "all";
    var subkategori = "all";
    function dt(voids, kategori, subkategori) {
        console.log(voids);
        var table = $("#datatables").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            stateSave: true,
            lengthMenu: [
                [100, 250, 500, 1000, -1],
                [100, 250, 500, 1000, "all"],
            ],
            buttons: ["excel", "print"],
            dom:
                "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            drawCallback: function (settings, json) {},
            ajax: {
                url: rute + "/" + voids + "/" + kategori + "/" + subkategori,
                type: "GET",
                dataType: "JSON",
                error: function (xhr, textStatus, ThrownException) {
                    alert(
                        "Terjadi kesalahan pada server"
                        // "Error loading data. Exception: " +
                        //     ThrownException +
                        //     "\n" +
                        //     textStatus
                    );
                },
            },
            columns: [
                {
                    data: "no_stock",
                    name: "no_stock",
                },
                {
                    data: "nama_barang",
                    name: "nama_barang",
                },
                {
                    data: "sat",
                    name: "sat",
                },
                {
                    data: "saldo",
                    name: "saldo",
                },
                {
                    data: "booked",
                    name: "booked",
                },
                {
                    data: "orders",
                    name: "orders",
                },
                {
                    data: "transit",
                    name: "transit",
                },
                {
                    data: "kategori",
                    name: "kategori",
                },
                {
                    data: "kategori2",
                    name: "kategori2",
                },

                {
                    data: "no_stock",
                    render: function (data, type, row) {
                        return getActions(data, type, row);
                    },
                    orderable: false,
                    className: "text-center",
                },
            ],
            order: [[0, "asc"]],
        });
    }
    dt(voids, kategori, subkategori);

    $("#void").change(function () {
        if ($(this).is(":checked")) {
            $("#datatables").DataTable().destroy();
            voids = "0";
            dt(voids, kategori, subkategori);
        } else {
            $("#datatables").DataTable().destroy();
            voids = "1";
            dt(voids, kategori, subkategori);
        }
    });

    $("#kategori").change(function () {
        $("#datatables").DataTable().destroy();
        kategori = $("#kategori").val();
        dt(voids, kategori, subkategori);
    });

    $("#subkategori").change(function () {
        $("#datatables").DataTable().destroy();
        subkategori = $("#subkategori").val();
        dt(voids, kategori, subkategori);
    });

    window.getActions = function (data, tyoe, row) {
        var action_view =
            '<a href="' +
            url_default +
            "/inventoryEdit/" +
            data +
            '" title="Edit" class="btn btn-sm btn-flat btn-warning" style="margin-right: 5px;color:white"><i class="fa fa-edit"></i></a>';

        action_view +=
            '<a href="' +
            url_default +
            "/inventoryDelete/" +
            data +
            '" title="Delete" class="btn btn-sm btn-flat btn-danger" style="margin-right: 5px;color:white"><i class="fa fa-trash"></i></a>';

        action_view +=
            '<a href="' +
            url_default +
            "/inventorySaldoAwal/" +
            data +
            '" title="Saldo Awal" class="btn btn-sm btn-flat btn-success" style="margin-right: 5px;color:white"><i class="fa fa-dollar-sign"></i></a>';

        return action_view;
    };
});
$("#kategori").select2();
$("#subkategori").select2();
