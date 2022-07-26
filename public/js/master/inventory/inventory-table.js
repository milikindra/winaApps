$(document).ready(function () {
    $(".selects2").select2();
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
            responsive: false,
            stateSave: false,
            deferRender: true,
            lengthMenu: [
                [100, 250, 500, 1000, -1],
                [100, 250, 500, 1000, "all"],
            ],
            buttons: [{
                    extend: "print",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    },
                    className: "btn-info",
                },
                {
                    extend: "excel",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    },
                    className: "btn-info",
                },
                {
                    extend: "pdf",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    },
                    className: "btn-info",
                },
                {
                    extend: "csv",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    },
                    className: "btn-info",
                },
                {
                    extend: "colvis",
                    className: "btn-info"
                },
            ],

            dom: "<'row'<'col-sm-12'B>>" +
                "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            drawCallback: function (settings, json) {},
            ajax: {
                url: rute + "/" + voids + "/" + kategori + "/" + subkategori,
                type: "GET",
                dataType: "JSON",
            },
            columns: [{
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
            order: [
                [0, "asc"]
            ],
        });
    }
    dt(voids, kategori, subkategori);

    $("#void").change(function () {
        if ($(this).is(":checked")) {
            $("#datatables").DataTable().clear().destroy();
            voids = "0";
            dt(voids, kategori, subkategori);
        } else {
            $("#datatables").DataTable().clear().destroy();
            voids = "1";
            dt(voids, kategori, subkategori);
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
            '" title="Edit" class="btn btn-sm btn-icon btn-warning" style="margin-right: 5px;"><i class="fa fa-edit"></i></button>';
        action_view +=
            '<button onclick="inventoryDelete(this)" data-inventory="' +
            data +
            '" title="Delete" class="btn btn-sm btn-icon btn-danger" style="margin-right: 5px;"><i class="fa fa-trash"></i></button>';
        return action_view;
    };

    window.inventoryDelete = function (element) {
        var inv = $(element).data("inventory");
        Swal.fire({
            title: "Are you sure?",
            text: "You cannot restore deleted data",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#FFC107",
            confirmButtonText: "Yes",
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
                                title: "Data cannot be deleted. The data is used in another table.",
                            });
                        } else {
                            Toast.fire({
                                icon: "success",
                                title: "Data has been successfully deleted",
                            });
                            $("#datatables").DataTable().clear().destroy();
                            dt(voids, kategori, subkategori);
                        }
                    },
                });
            }
        });
    };

    $("#datatables").on("click", "tbody tr", function () {
        var value = $(this).closest("tr").children("td:first").text();
        $("#kode_kartu_stok").val(value);
    });
});
