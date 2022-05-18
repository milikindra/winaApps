$(".selects2").select2();
$(document).ready(function () {
    var Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
    });

    var tbl =
        '<tr style="text-align: center;"><th width="10%">Nomor</th><th>Tanggal</th><th>Kode</th><th>Nama</th><th>Dept</th><th>PO Customer</th><th>Total DPP</th><th>Total PPn</th><th>Total</th></tr>';
    $("#datatables thead").append(tbl);
    var voids = "N";
    var kategori = "all";
    var fdate = "all";
    var sdate = "all";
    var edate = "all";
    function dt(voids, kategori, fdate, sdate, edate) {
        if (voids == "N") {
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
                    },
                    {
                        data: "TGL_BUKTI",
                        name: "TGL_BUKTI",
                    },
                    {
                        data: "ID_CUST",
                        name: "ID_CUST",
                    },
                    {
                        data: "NM_CUST",
                        name: "NM_CUST",
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
                        render: function (data, type, row) {
                            return addPeriod(parseFloat(data).toFixed(2), ",");
                        },
                    },
                    {
                        data: "totppn",
                        name: "totppn",
                        className: "dt-body-right",
                        render: function (data, type, row) {
                            return addPeriod(parseFloat(data).toFixed(2), ",");
                        },
                    },
                    {
                        data: "total",
                        name: "total",
                        className: "dt-body-right",
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

    $("#void").change(function () {
        if ($(this).is(":checked")) {
            $("#datatables").DataTable().clear().destroy();
            voids = "Y";
            dt(voids, kategori, fdate, sdate, edate);
        } else {
            $("#datatables").DataTable().clear().destroy();
            voids = "N";

            dt(voids, kategori, fdate, sdate, edate);
        }
    });

    $("#kategoriFilter").change(function () {
        $("#datatables").DataTable().clear().destroy();
        kategori = $("#kategoriFilter").val();
        dt(voids, kategori, subkategori);
    });

    $("#subkategoriFilter").change(function () {
        $("#datatables").DataTable().clear().destroy();
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
                            $("#datatables").DataTable().clear().destroy();
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
                    $("#aktifEdit").prop("checked", true);
                } else {
                    $("#aktifEdit").prop("checked", false);
                }

                if (response.data.isKonsi == "Y") {
                    $("#konsinyansiEdit").prop("checked", true);
                } else {
                    $("#konsinyansiEdit").prop("checked", false);
                }

                if (response.data.isMinus == "Y") {
                    $("#isMinusEdit").prop("checked", true);
                } else {
                    $("#isMinusEdit").prop("checked", false);
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
                $("#harga_jual").val(response.data.hrg_jual);
                $("#keterangan").val(response.data.keterangan);
                if (response.data.isMinus == "Y") {
                    $("#isMinusEdit").prop("checked", true);
                } else {
                    $("#isMinusEdit").prop("checked", false);
                }
                $("#salesAccEdit")
                    .select2()
                    .val(response.data.NO_REK1)
                    .trigger("change");
                $("#purchaseAccEdit")
                    .select2()
                    .val(response.data.NO_REK2)
                    .trigger("change");
                if (response.data.PphPs23 == "Y") {
                    $("#PphPs23Edit").prop("checked", true);
                } else {
                    $("#PphPs23Edit").prop("checked", false);
                }
                if (response.data.PPhPs21 == "Y") {
                    $("#PPhPs21Edit").prop("checked", true);
                } else {
                    $("#PPhPs21Edit").prop("checked", false);
                }
                if (response.data.PPhPs4Ayat2 == "Y") {
                    $("#PPhPs4Ayat2Edit").prop("checked", true);
                } else {
                    $("#PPhPs4Ayat2Edit").prop("checked", false);
                }
                if (response.data.PPhPs21OP == "Y") {
                    $("#PPhPs21OPEdit").prop("checked", true);
                } else {
                    $("#PPhPs21OPEdit").prop("checked", false);
                }
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
    };

    // GET KODE FOR FILTER KARTU STOK
    $("#datatables").on("click", "tbody tr", function () {
        var value = $(this).closest("tr").children("td:first").text();
        $("#kode_kartu_stok").val(value);
    });

    $("#isMinus").change(function () {
        if ($(this).is(":checked")) {
            $("#salesAcc").attr("required", "true");
            $("#purchaseAcc").attr("required", "true");
        } else {
            $("#salesAcc").removeAttr("required");
            $("#purchaseAcc").removeAttr("required");
        }
    });

    $("#isMinusEdit").change(function () {
        if ($(this).is(":checked")) {
            $("#salesAccEdit").attr("required", "true");
            $("#purchaseAccEdit").attr("required", "true");
        } else {
            $("#salesAccEdit").removeAttr("required");
            $("#purchaseAccEdit").removeAttr("required");
        }
    });
});
