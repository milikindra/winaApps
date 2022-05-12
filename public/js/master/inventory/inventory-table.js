$(".selects2").select2();
$(document).ready(function () {
    var Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
    });

    var voids = "1";
    var kategori = "all";
    var subkategori = "all";
    function dt(voids, kategori, subkategori) {
        var table = $("#datatables").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            stateSave: true,
            deferRender: true,
            lengthMenu: [
                [100, 250, 500, 1000, -1],
                [100, 250, 500, 1000, "all"],
            ],
            buttons: ["excel", "pdf", "print", "csv"],
            dom:
                // "<'row'<'col-sm-12'B>>" +
                "<'row'<'col-sm-6'lB><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            drawCallback: function (settings, json) {},
            ajax: {
                url: rute + "/" + voids + "/" + kategori + "/" + subkategori,
                type: "GET",
                dataType: "JSON",
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
                    className: "dt-body-right",
                },
                {
                    data: "booked",
                    name: "booked",
                    className: "dt-body-right",
                },
                {
                    data: "orders",
                    name: "orders",
                    className: "dt-body-right",
                },
                {
                    data: "transit",
                    name: "transit",
                    className: "dt-body-right",
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

    $("#kategoriFilter").change(function () {
        $("#datatables").DataTable().destroy();
        kategori = $("#kategoriFilter").val();
        dt(voids, kategori, subkategori);
    });

    $("#subkategoriFilter").change(function () {
        $("#datatables").DataTable().destroy();
        subkategori = $("#subkategoriFilter").val();
        dt(voids, kategori, subkategori);
    });

    window.getActions = function (data, tyoe, row) {
        var action_view =
            '<button onclick="inventoryEdit(this)" data-inventory="' +
            data +
            '" title="Edit" class="btn btn-sm btn-flat btn-icon btn-warning" style="margin-right: 5px;"><i class="fa fa-edit"></i></button>';

        action_view +=
            '<button onclick="inventoryDelete(this)" data-inventory="' +
            data +
            '" title="Hapus" class="btn btn-sm btn-flat btn-icon btn-danger" style="margin-right: 5px;"><i class="fa fa-trash"></i></button>';

        // action_view +=
        //     '<a href="' +
        //     url_default +
        //     "/inventorySaldoAwal/" +
        //     data +
        //     '" title="Saldo Awal" class="btn btn-sm btn-flat btn-icon btn-success" style="margin-right: 5px;color:white"><i class="fa fa-dollar-sign"></i></a>';

        return action_view;
    };

    window.inventoryDelete = function (element) {
        var inv = $(element).data("inventory");
        Swal.fire({
            title: "Apakah anda yakin",
            text: "Anda tidak bisa mengembalikan data yang sudah di hapus",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#FFC107",
            confirmButtonText: "Yakin",
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: rute_delete + "/" + inv,
                    type: "GET",
                    dataType: "JSON",
                    success: function (response) {
                        if (response.result == false) {
                            console.log(response.result);
                            Toast.fire({
                                icon: "warning",
                                title: "Data tidak bisa dihapus. Data digunakan di tabel lain.",
                            });
                        } else {
                            Toast.fire({
                                icon: "success",
                                title: "Data berhasil di hapus.",
                            });
                            $("#datatables").DataTable().destroy();
                            dt(voids, kategori, subkategori);
                        }
                    },
                });
            }
        });
    };

    window.inventoryEdit = function (element) {
        var inv = $(element).data("inventory");
        $.ajax({
            url: rute_edit + "/" + inv,
            type: "GET",
            dataType: "JSON",
            success: function (response) {
                $("#kode").val(inv);
                if (response.data.aktif == "Y") {
                    $("#aktif").prop("checked", true);
                } else {
                    $("#aktif").prop("checked", false);
                }

                if (response.data.isKonsi == "Y") {
                    $("#konsinyansi").prop("checked", true);
                } else {
                    $("#konsinyansi").prop("checked", false);
                }
                $("#nama_barang").val(response.data.nm_stock);
                $("#satuan").val(response.data.sat);
                $("#stok_minimal").val(response.data.minstock);
                $("#kategoriEdit")
                    .select2()
                    .val(response.data.kategori)
                    .trigger("change");
                $("#subkategoriEdit")
                    .select2()
                    .val(response.data.kategori2)
                    .trigger("change");
                $("#merkEdit")
                    .select2()
                    .val(response.data.merk)
                    .trigger("change");
                console.log(response.data.merk);
                $("#harga_jual").val(response.data.hrg_jual);
                $("#keterangan").val(response.data.keterangan);
            },
            error: function (xhr, textStatus, ThrownException) {
                console.log(
                    "Error loading data. Exception: " +
                        ThrownException +
                        "\n" +
                        textStatus
                );
            },
        });

        $("#editInventory").modal("show");
        // Swal.fire({
        //     title: "Apakah anda yakin",
        //     text: "Anda tidak bisa mengembalikan data yang sudah di hapus",
        //     icon: "warning",
        //     showCancelButton: true,
        //     confirmButtonColor: "#d33",
        //     cancelButtonColor: "#FFC107",
        //     confirmButtonText: "Yakin",
        //     reverseButtons: true,
        // }).then((result) => {
        //     if (result.isConfirmed) {
        //         $.ajax({
        //             url: rute_delete + "/" + inv,
        //             type: "GET",
        //             dataType: "JSON",
        //             success: function (response) {
        //                 if (response.result == false) {
        //                     Toast.fire({
        //                         icon: "warning",
        //                         title: "Data tidak bisa dihapus. Data digunakan di tabel lain.",
        //                     });
        //                 } else {
        //                     Toast.fire({
        //                         icon: "success",
        //                         title: "Data berhasil di hapus.",
        //                     });
        //                     $("#datatables").DataTable().destroy();
        //                     dt(voids, kategori, subkategori);
        //                 }
        //             },
        //         });
        //     }
        // });
    };

    // GET KODE FOR FILTER KARTU STOK
    $("#datatables").on("click", "tbody tr", function () {
        var value = $(this).closest("tr").children("td:first").text();
        $("#kode_kartu_stok").val(value);
    });
});
