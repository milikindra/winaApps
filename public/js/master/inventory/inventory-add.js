$(document).ready(function () {
    window.inventoryEdit = function (element) {
        resetInventory();
        var inv = $(element).data("inventory");
        $.ajax({
            url: rute_edit + "/" + inv,
            type: "GET",
            dataType: "JSON",
            success: function (response) {
                $("#kodeOld").val(inv);
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

                if (response.data.isMinus == "Y") {
                    $("#isMinus").prop("checked", true);
                } else {
                    $("#isMinus").prop("checked", false);
                }

                $("#nama_barang").val(response.data.nm_stock);
                $("#satuan").val(response.data.sat);
                $("#stok_minimal").val(response.data.minstock);
                $("#kategoriInventory")
                    .select2()
                    .val(response.data.kategori)
                    .trigger("change");
                $("#subKategoriInventory")
                    .select2()
                    .val(response.data.kategori2)
                    .trigger("change");
                $("#merkInventory")
                    .select2()
                    .val(response.data.merk)
                    .trigger("change");
                $("#harga_jual").val(response.data.hrg_jual);
                $("#keterangan").val(response.data.keterangan);

                $("#salesAcc")
                    .select2()
                    .val(response.data.NO_REK1)
                    .trigger("change");
                $("#purchaseAcc")
                    .select2()
                    .val(response.data.NO_REK2)
                    .trigger("change");
                if (response.data.PphPs23 == "Y") {
                    $("#PphPs23").prop("checked", true);
                } else {
                    $("#PphPs23").prop("checked", false);
                }
                if (response.data.PPhPs21 == "Y") {
                    $("#PPhPs21").prop("checked", true);
                } else {
                    $("#PPhPs21").prop("checked", false);
                }
                if (response.data.PPhPs4Ayat2 == "Y") {
                    $("#PPhPs4Ayat2").prop("checked", true);
                } else {
                    $("#PPhPs4Ayat2").prop("checked", false);
                }
                if (response.data.PPhPs21OP == "Y") {
                    $("#PPhPs21OP").prop("checked", true);
                } else {
                    $("#PPhPs21OP").prop("checked", false);
                }
                $("#vintrasId").val(response.data.VINTRASID);
                $("#kodeBJ").val(response.data.kodeBJ);

                if (response.data.kodeBJ == 'I') {
                    $('#titleInventory').html('Edit Inventory')
                    $('#inventoryName').html('Item Name')
                    $('.isBj').css('display', 'block');
                    $('.nBj').css('display', 'none');
                } else {
                    $(".trxInventory tbody tr").remove();
                    jQuery.each(response.child, function (i, val) {
                        addRowChild();
                        $('#no_stock-' + i).val(val.NO_STOCK);
                        $('#nm_stock-' + i).val(val.NM_STOCK);
                        $('#qty-' + i).val(val.QTY);
                        $('#sat-' + i).val(val.SAT);
                    });

                    $('#titleInventory').html('Edit Group Inventory')
                    $('#inventoryName').html('Group Item Name')
                    $('.isBj').css('display', 'none');
                    $('.nBj').css('display', 'block');
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

        $('#formInventory').prop('action', update_inventory);
        $("#inventoryModal").modal("show");
    }

    $("#isMinus").change(function () {
        if ($(this).is(":checked")) {
            $("#salesAcc").attr("required", "true");
            $("#purchaseAcc").attr("required", "true");
        } else {
            $("#salesAcc").removeAttr("required");
            $("#purchaseAcc").removeAttr("required");
        }
    });

    $(".btnVintras").on("click", function (e) {
        e.preventDefault();
        $("#vintrasPeriod").modal("show");
    });

    $("#vintrasYear").change(function () {
        var periode = $("#vintrasYear").val();
        dtVintras(periode);
    });

    function dtVintras(periode) {
        $("#vintrasTable").DataTable().clear().destroy();
        var table = $("#vintrasTable").DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            stateSave: false,
            deferRender: true,
            lengthMenu: [
                [100, 250, 500, 1000, -1],
                [100, 250, 500, 1000, "all"],
            ],
            dom:
                "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            drawCallback: function (settings, json) { },
            ajax: {
                url: rute_vintras + "/" + periode,
                type: "GET",
                dataType: "JSON",
            },
            columns: [{
                data: "Kode_Ref",
                name: "Kode_Ref",
            },
            {
                data: "Spec_Barang",
                name: "Spec_Barang",
                render: function (data, type, row) {
                    var str = "";
                    html = $.parseHTML(data),
                        nodeNames = "";
                    $.each(html, function (i, el) {
                        nodeNames += this.data;
                    });
                    return nodeNames;
                },
            },
            {
                data: "Tanggal",
                name: "Tanggal",
                render: function (data, type, row) {
                    return moment(data).format("DD/MM/YYYY");
                },
            },
            {
                data: "Nama_Pelanggan",
                name: "Nama_Pelanggan",
            },
            {
                data: "Brand",
                name: "Brand",
            },
            {
                data: "Ket_Ref",
                name: "Ket_Ref",
            },
            {
                data: "Spec_Lain",
                name: "Spec_Lain",
            }
                ,
            {
                data: "Keterangan",
                name: "Keterangan",
            }
            ],
            order: [
                [0, "asc"]
            ],
        });
    }

    $('#vintrasTable tbody').on('dblclick', 'tr', function (e) {
        no_ref = $(this).closest("tr").children("td:eq(0)").text();
        spesification = $(this).closest("tr").children("td:eq(1)").text();
        $('.vintrasId').val(no_ref);
        $('.specificationName').val(spesification);
        $("#vintrasPeriod").modal("hide");
    })

    $('#btnAddSave').on('click', function (e) {
        if ($('#kode').val() != '') {
            if ($('#kodeBJ') == "I") {
                if ($('#vintrasId').val() == "") {
                    e.preventDefault();
                    var form = $(this).parents('form');
                    Swal.fire({
                        title: "Are you sure?",
                        text: "This Item Does Not Have Vintras Id",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#17a2b8",
                        cancelButtonColor: "#FFC107",
                        confirmButtonText: "Yes, Process it!",
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            }
        }
    });
});
function addRowChild() {
    var rowCount = $(".trxInventory tr").length - 1;
    $(".trxInventory").append(
        '<tr> <td> <input type="text" class="form-control form-control-sm" name="no_stockGroup[]" id="no_stockGroup-' +
        rowCount +
        '" onclick="addChild(' +
        rowCount +
        ')" readonly > </td><td> <textarea class="form-control form-control-sm r1" name="nm_stockGroup[]" id="nm_stockGroup-' +
        rowCount +
        '" ></textarea> </td><td> <input type="number" class="form-control form-control-sm numajaDesimal" value="1" min="1" style="text-align: right;" name="qtyGroup[]" autocomplete="off"  id="qtyGroup-' +
        rowCount +
        '"> </td><td> <input type="text" class="form-control form-control-sm" name="satGroup[]" id="satGroup-' +
        rowCount +
        '"> </td></tr > '
    );
}

function removeRowChild() {
    $(".trxInventory tr:last").remove();
}
function inventoryAdd(kodeBJ) {
    resetInventory();
    $('#kodeBJ').val(kodeBJ);
    if (kodeBJ == 'I') {
        $('#titleInventory').html('Add Inventory')
        $('#inventoryName').html('Item Name')
        $('.isBj').css('display', 'block');
        $('.nBj').css('display', 'none');
    } else {
        $('#titleInventory').html('Add Group Inventory')
        $('#inventoryName').html('Group Item Name')
        $('.isBj').css('display', 'none');
        $('.nBj').css('display', 'block');
        $(".trxInventory tbody tr").remove();
        addRowChild();
    }
    $('#formInventory').prop('action', save_inventory);
    $("#inventoryModal").modal("show");
}

var arrChild = [];
function addChild(uid) {
    arrChild.push(uid);
    if ($("#dtModalInventory tbody tr").length == 0) {
        dtModalInventory("0", "all", "all");
    }
    $("#modalInventory").modal("show");
    $("#dtModalInventory").on("click", "tbody tr", function () {
        if (uid == arrChild[arrChild.length - 1]) {
            no_stock = $(this).closest("tr").children("td:eq(0)").text();
            nm_stock = $(this).closest("tr").children("td:eq(1)").text();
            sat = $(this).closest("tr").children("td:eq(2)").text();
            document.getElementById("no_stockGroup-" + uid).value = no_stock;
            document.getElementById("nm_stockGroup-" + uid).innerHTML = nm_stock;
            document.getElementById("satGroup-" + uid).value = sat;
        }
        $("#modalInventory").modal("hide");
    });
}

function resetInventory() {
    $("#kode").val('');
    $("#satuan").val('');
    $("#harga_jual").val('');
    $("#keterangan").val('');
    $("#stok_minimal").val('');
    $("#vintrasId").val('');
    $("#kodeBJ").val('');
    $("#kodeOld").val('');
    $("#formInventory textarea").val('');
    $("#kategoriInventory")
        .select2()
        .val('')
        .trigger("change");
    $("#subKategoriInventory")
        .select2()
        .val('')
        .trigger("change");
    $("#merkInventory")
        .select2()
        .val('')
        .trigger("change");
    $("#salesAcc")
        .select2()
        .val('')
        .trigger("change");
    $("#purchaseAcc")
        .select2()
        .val('')
        .trigger("change");

    $("#aktif").prop("checked", true);
    $("#konsinyansi").prop("checked", false);
    $("#isMinus").prop("checked", false);
}

$('#kategoriInventory').on('select2:opening', function (e) {
    if ($('#kategoriInventory option').length <= 1) {
        $.ajax({
            delay: 0,
            url: get_customer + "/all",
            type: "GET",
            dataType: "JSON",
            success: function (response) {
                var html = "<option value=''>Select Category</option>";
                jQuery.each(response, function (i, val) {
                    html += "<option value='" + val.ID_CUST + "'>" + val.ID_CUST + " (" + val.NM_CUST + ")</option>";
                });
                $('#customer').html(html);
            },
        });
        $("#kategoriInventory")
            .select2()
            .val('')
            .trigger("change");
    }
});

$('#kategoriInventory').on('select2:opening', function (e) {
    if ($('#kategoriInventory option').length <= 1) {
        $.ajax({
            delay: 0,
            url: get_categoryInventory + "/all",
            type: "GET",
            dataType: "JSON",
            success: function (response) {
                var html = "<option value=''>Select Category</option>";
                jQuery.each(response, function (i, val) {
                    html += "<option value='" + val.kategori + "'>" + val.kategori + " - " + val.keterangan + "</option>";
                });
                $('#kategoriInventory').html(html);
            },
        });
        $("#kategoriInventory")
            .select2()
            .val('')
            .trigger("change");
    }
});

$('#subKategoriInventory').on('select2:opening', function (e) {
    if ($('#subKategoriInventory option').length <= 1) {
        $.ajax({
            delay: 0,
            url: get_subCategoryInventory + "/all",
            type: "GET",
            dataType: "JSON",
            success: function (response) {
                var html = "<option value=''>Select Subcategory</option>";
                jQuery.each(response, function (i, val) {
                    html += "<option value='" + val.kode + "'>" + val.kode + " - " + val.keterangan + "</option>";
                });
                $('#subKategoriInventory').html(html);
            },
        });
        $("#subKategoriInventory")
            .select2()
            .val('')
            .trigger("change");
    }
});

$('#merkInventory').on('select2:opening', function (e) {
    if ($('#merkInventory option').length <= 1) {
        $.ajax({
            delay: 0,
            url: get_merkInventory + "/all",
            type: "GET",
            dataType: "JSON",
            success: function (response) {
                var html = "<option value=''>Select Brand</option>";
                jQuery.each(response, function (i, val) {
                    html += "<option value='" + val.Kode + "'>" + val.Kode + "</option>";
                });
                $('#merkInventory').html(html);
            },
        });
        $("#merkInventory")
            .select2()
            .val('')
            .trigger("change");
    }
});

$('#salesAcc').on('select2:opening', function (e) {
    if ($('#salesAcc option').length <= 1) {
        $.ajax({
            delay: 0,
            url: get_coaInventory + "/all",
            type: "GET",
            dataType: "JSON",
            success: function (response) {
                var html = "<option value=''>Select Account</option>";
                jQuery.each(response, function (i, val) {
                    html += "<option value='" + val.no_rek + "'>" + val.no_rek + " - " + val.nm_rek + "</option>";
                });
                $('#salesAcc').html(html);
                $('#purchaseAcc').html(html);
            },
        });
        $("#salesAcc")
            .select2()
            .val('')
            .trigger("change");
        $("#purchaseAcc")
            .select2()
            .val('')
            .trigger("change");
    }
});

$('#purchaseAcc').on('select2:opening', function (e) {
    if ($('#purchaseAcc option').length <= 1) {
        $.ajax({
            delay: 0,
            url: get_coaInventory + "/all",
            type: "GET",
            dataType: "JSON",
            success: function (response) {
                var html = "<option value=''>Select Account</option>";
                jQuery.each(response, function (i, val) {
                    html += "<option value='" + val.no_rek + "'>" + val.no_rek + " - " + val.nm_rek + "</option>";
                });
                $('#salesAcc').html(html);
                $('#purchaseAcc').html(html);
            },
        });
        $("#salesAcc")
            .select2()
            .val('')
            .trigger("change");
        $("#purchaseAcc")
            .select2()
            .val('')
            .trigger("change");
    }
});