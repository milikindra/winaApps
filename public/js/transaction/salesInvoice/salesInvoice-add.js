$(".selects2").select2();
$(document).ready(function () {
    $("#overlay").fadeOut(300);
    if (performance.getEntriesByType("navigation")[0].type == "back_forward") {
        $("#overlay").fadeIn(300);
        location.reload(true);
    }
    var Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
    });
    var voids = "1";
    var kategori = "all";
    var subkategori = "all";

    var t_dp = $('.attachGroup input').length;
    if (t_dp > 0) {
        for (var i = 0; i < t_dp; i++) {
            addAttach()
        }
    }

    var t_dp = $('.down_payment tbody tr').length;
    if (t_dp > 0) {
        for (var i = 0; i < t_dp; i++) {

        }
    }

    var t_det = $('.trx tbody tr').length;
    for (var i = 0; i < t_det; i++) {
        itemTotal(i);
    }

    $(function () {
        $.contextMenu({
            selector: '.trx tbody tr',
            callback: function (key, options) {
                var indexs_row = $(this).closest("tr").children("td:first").children().attr('id').substring(9);
                var so = $('#nomor').val();
                var id = $(this).closest("tr").children("td:first").children().val();
                var state = $('#state-' + indexs_row).val();
                var qty = $('#qty-' + indexs_row).val();
                if (key == 'cancel') {
                    if (state == 'Cancel') {
                        Swal.fire({
                            title: "Cancel Item!",
                            text: "Are you sure not to cancel this item: " + id + "?",
                            icon: "warning",
                            confirmButtonColor: "#17a2b8",
                            reverseButtons: true,
                            showCancelButton: true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let _token = $('meta[name="csrf-token"]').attr('content');
                                $.ajax({
                                    type: 'POST',
                                    url: rute_saveState,
                                    data: {
                                        so: so,
                                        item: id,
                                        qty: qty,
                                        state: '',
                                        noteState: '',
                                        _token: _token
                                    },
                                    dataType: "text",
                                    success: function (resultData) {
                                        refreshWindow();
                                    },
                                    error: function () {
                                        Toast.fire({
                                            icon: "danger",
                                            title: "Something went wrong",
                                        });
                                    }
                                });
                            }
                        })
                    } else {
                        Swal.fire({
                            title: "Cancel Item!",
                            text: "Are you sure to cancel this item : " + id + "?",
                            icon: "warning",
                            confirmButtonColor: "#17a2b8",
                            confirmButtonText: "Yes, Of Course",
                            reverseButtons: true,
                            showCancelButton: true,
                            input: 'text',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let _token = $('meta[name="csrf-token"]').attr('content');
                                $.ajax({
                                    type: 'POST',
                                    url: rute_saveState,
                                    data: {
                                        so: so,
                                        item: id,
                                        qty: qty,
                                        state: 'B',
                                        noteState: result.value,
                                        _token: _token
                                    },
                                    dataType: "text",
                                    success: function (resultData) {
                                        refreshWindow();
                                    },
                                    error: function () {
                                        Toast.fire({
                                            icon: "danger",
                                            title: "Something went wrong",
                                        });
                                    }
                                });
                            }
                        })
                    }
                } else if (key == 'finish') {
                    if (state == 'Finish') {
                        Swal.fire({
                            title: "Finish Item!",
                            text: "Are you sure not to finish this item: " + id + "?",
                            icon: "warning",
                            confirmButtonColor: "#17a2b8",
                            reverseButtons: true,
                            showCancelButton: true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let _token = $('meta[name="csrf-token"]').attr('content');
                                $.ajax({
                                    type: 'POST',
                                    url: rute_saveState,
                                    data: {
                                        so: so,
                                        item: id,
                                        qty: qty,
                                        state: '',
                                        noteState: '',
                                        _token: _token
                                    },
                                    dataType: "text",
                                    success: function (resultData) {
                                        refreshWindow();
                                    },
                                    error: function () {
                                        Toast.fire({
                                            icon: "danger",
                                            title: "Something went wrong",
                                        });
                                    }
                                });
                            }
                        })
                    } else {
                        Swal.fire({
                            title: "Finish Item!",
                            text: "Are you sure to finish this item : " + id + "?",
                            icon: "warning",
                            confirmButtonColor: "#17a2b8",
                            confirmButtonText: "Yes, Of Course",
                            reverseButtons: true,
                            showCancelButton: true,
                            input: 'text',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let _token = $('meta[name="csrf-token"]').attr('content');
                                $.ajax({
                                    type: 'POST',
                                    url: rute_saveState,
                                    data: {
                                        so: so,
                                        item: id,
                                        qty: qty,
                                        state: 'F',
                                        noteState: result.value,
                                        _token: _token
                                    },
                                    dataType: "text",
                                    success: function (resultData) {
                                        refreshWindow();
                                    },
                                    error: function () {
                                        Toast.fire({
                                            icon: "danger",
                                            title: "Something went wrong",
                                        });
                                    }
                                });
                            }
                        })
                    }
                }
            },
            items: {
                "cancel": { name: "Cancel" },
                "finish": { name: "Finish" },
            }
        });
    });
});

function refreshWindow() {
    window.location.reload();
}

$('#customerSearch').focus(function () {
    if ($('#customerList option').length <= 1) {
        $.ajax({
            delay: 0,
            url: get_customer + "/all",
            type: "GET",
            dataType: "JSON",
            success: function (response) {
                var html = "<option selected disabled></option>";
                jQuery.each(response, function (i, val) {
                    html += "<option data-id='" + val.ID_CUST + "' data-name='" + val.NM_CUST + "' value='" + val.ID_CUST + " (" + val.NM_CUST + ")'>" + val.ID_CUST + " (" + val.NM_CUST + ")</option>";
                });
                $('#customerList').html(html);
            },
        });

    }
});

$('#customerSearch').focusout(function () {
    $('#customer_name').val($("#customerList option[value='" + $('#customerSearch').val() + "']").attr('data-name'));
    $('#customer').val($("#customerList option[value='" + $('#customerSearch').val() + "']").attr('data-id'));
    if ($('#cust_so').val() != $("#customerList option[value='" + $('#customerSearch').val() + "']").attr('data-id')) {
        $('#so_id').val('');
    }
    getCustomer();
});

function getCustomer() {
    var id_cust = $("#customer").val();
    $("#ship_to").val('');
    $("#use_branch").prop('checked', false);
    $.ajax({
        url: get_customer + "/" + id_cust,
        type: "GET",
        dataType: "JSON",
        success: function (response) {
            $("#cmbShipping").html('');
            $("#cmbShippingKey").val('');
            if (response.length > 0) {
                var customer_address =
                    response[0].ALAMAT1 +
                    "\r\n" +
                    response[0].ALAMAT2 +
                    "\r\n" +
                    response[0].KOTA +
                    "\r\n" +
                    response[0].PROPINSI;
                var opt = '<option value="' + customer_address + '">Main Address</option>';
                if (response[0].address_alias != '' && response[0].address_alias != 'null' && response[0].address_alias != null) {
                    opt += '<option value="' + response[0].other_address + '">' + response[0].address_alias + '</option>';
                }
                if (response.length > 1) {
                    for (var i = 1; i < response.length; i++) {
                        opt += '<option value="' + response[i].other_address + '">' + response[i].address_alias + '</option>';
                    }
                }
                $("#cmbShipping").html(opt);
                $("#cmbShipping").prop("selectedIndex", 0).trigger("change");
            }
        },
    });
};

function getSo() {
    $("#modalSO").modal("show");
    var customer_id = $("#customer").val();

    if (customer_id == '' || customer_id == null) {
        tabelModalSo('all', 'all');
    } else {
        tabelModalSo('kontrak_head.ID_CUST', customer_id);
    }
    $("#tabelModalSo").one("click", "tbody tr", function () {
        $("#so_id").val($(this).closest("tr").children("td:eq(0)").text());
        $("#cust_so").val($(this).closest("tr").children("td:eq(4)").text());
        $("#customer").val($(this).closest("tr").children("td:eq(4)").text());
        $("#customerSearch").val($(this).closest("tr").children("td:eq(4)").text() + " (" + $(this).closest("tr").children("td:eq(5)").text() + ")");
        $("#tempo").val($(this).closest("tr").children("td:eq(6)").text());
        $("#curr").val($(this).closest("tr").children("td:eq(7)").text());
        $("#rate_cur").val($(this).closest("tr").children("td:eq(8)").text());
        $("#payterm").val($(this).closest("tr").children("td:eq(13)").text());
        $("#acc_receivable").val($(this).closest("tr").children("td:eq(16)").text());

        if ($(this).closest("tr").children("td:eq(17)").text() == "Y") {
            $("#cek_wapu").prop('checked', true);
            $("#wapu").css('display', 'block');
        } else {
            $("#cek_wapu").prop('checked', false);
            $("#wapu").css('display', 'none');
        }
        getCustomer();
        $("#modalByDp").attr('disabled', false);

        $("#modalSO").modal("hide");
    });
}

function useDpSo() {
    // if ($('#use_dp').is(":checked")) {
    //     alert("A");
    // } else {
    // }
};

$("#modalByDp").on("click", function (e) {
    if ($('#use_dp').is(":checked")) {
        alert("A");
    } else {
        $("#modalDo").modal("show");
    }
});


$("#cmbShipping").change(function () {
    $("#ship_to").val('');
    $("#cmbShippingKey").val('');
    if ($("#cmbShipping").val() != '' && $("#cmbShipping").val() != null) {
        $("#ship_to").val($("#cmbShipping").val());
        $("#cmbShippingKey").val($("#cmbShipping option:selected").text());
    } else {
        $("#ship_to").prop("readonly", true);
    }
});

window.addAttach = function (element) {
    var rc = $('#attachUpload input').length;
    $(".attachUpload").append(
        '<input type="file" style="margin-bottom: 2px;" id="attach-' + rc + '" name="attach[]">'
    );
};

window.removeAttach = function (element) {
    $(".attachUpload input:last").remove();
};

window.addRowDp = function (element) {
    var rowCountDp = $('#down_payment tbody tr').length;
    var vatOption = "";
    jQuery.each(vat, function (i, val) {
        vatOption += "<option>" + val.kode + "</option>";
    });

    $(".down_payment").append(
        '<tr> <td> <input type="text" class="form-control form-control-sm" name="dp[]" id="dp-' +
        rowCountDp +
        '"  autocomplete="off" >  </td><td> <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="dp_value[]" id="dp_value-' +
        rowCountDp +
        '"> </td> <td><select class="form-control form-control-sm tax" name="dp_tax[]" id="dp_tax-' +
        rowCountDp +
        '">' +
        vatOption +
        '</select></td><td id="dp_tax_value-' + rowCountDp + '" style="display:none" ></td></tr>'
    );
    getTax();
};

window.removeRowDp = function (element) {
    $(".down_payment tr:last").remove();
};

window.addRow = function (element) {
    var rowCount = $('#trx tbody tr').length;
    var vatOption = '';
    jQuery.each(vat, function (i, val) {
        vatOption += "<option>" + val.kode + "</option>";
    });

    $(".trx").append(
        '<tr> <td> <input type="text" class="form-control form-control-sm" name="no_stock[]" id="no_stock-' +
        rowCount +
        '" onclick="addData(' +
        rowCount +
        ')" readonly > </td><td> <textarea class="form-control form-control-sm r1" name="nm_stock[]" id="nm_stock-' +
        rowCount +
        '" rows="3"></textarea> </td><td> <input type="text" class="form-control form-control-sm" name="ket[]" id="ket--' +
        rowCount +
        '"> </td><td><input type="hidden" name="base_qty[]" id="base_qty-' +
        rowCount +
        '"> <input type="number" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="qty[]" autocomplete="off"  id="qty-' +
        rowCount +
        '" onchange="itemTotal(' +
        rowCount +
        ')"> </td><td> <input type="text" class="form-control form-control-sm" name="sat[]" id="sat-' +
        rowCount +
        '"> </td><td> <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="price[]" autocomplete="off"  id="price-' +
        rowCount +
        '" onchange="itemTotal(' +
        rowCount +
        ')">  </td><td> <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="disc[]" autocomplete="off"  id="disc-' +
        rowCount +
        '" onchange="itemTotal(' +
        rowCount +
        ')"> </td><td> <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="disc2[]" autocomplete="off"  id="disc2-' +
        rowCount +
        '" onchange="itemTotal(' +
        rowCount +
        ')"> </td><td> <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;"  name="disc_val[]" autocomplete="off"  id="disc_val-' +
        rowCount +
        '" onchange="itemTotal(' +
        rowCount +
        ')">  </td><td> <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="total[]" autocomplete="off"  id="total-' +
        rowCount +
        '" readonly> <td><select class="form-control form-control-sm tax" name="tax[]" id="tax-' +
        rowCount +
        '" onchange="itemTotal(' +
        rowCount +
        ')">' +
        vatOption +
        '</select></td><td> <input type="text" class="form-control form-control-sm" name="state[]" id="state-' +
        rowCount +
        '" readonly> </td><td style="display:none" id="itemTotal-' +
        rowCount +
        '"></td> <td style="display:none" id = "itemTax-' +
        rowCount +
        '" > </td> <td style="display:none" id = "itemDisc-' +
        rowCount +
        '" > </td> <td style="display:none" id = "itemTotalDiscHead-' +
        rowCount +
        '" > </td> <td style="display:none" id = "itemBruto-' +
        rowCount +
        '" > </td> <td style="display:none" id = "itemTaxValue-' +
        rowCount +
        '" > </td><td style = "display:none" > <input type="hidden" name="itemKodeGroup[]" id="itemKodeGroup-' +
        rowCount +
        '"> </td><td style = "display:none" > <input type="hidden" name="itemVintrasId[]" id="itemVintrasId-' +
        rowCount +
        '"> </td><td style = "display:none" > <input type="hidden" name="itemTahunVintras[]" id="itemTahunVintras-' +
        rowCount +
        '"> </td><td style = "display:none" > <input type="hidden" name="merkItem[]" id="merkItem-' +
        rowCount +
        '"> </td></tr > '
    );
};

window.removeRow = function (element) {
    $(".trx tr:last").remove();
};

var arr = [];
function addData(uid) {
    arr.push(uid);
    if ($("#dtModalInventory tbody tr").length == 0) {
        dtModalInventory("0", "all", "all");
    }
    $("#modalInventory").modal("show");
    $("#dtModalInventory").on("click", "tbody tr", function (e) {
        if (uid == arr[arr.length - 1]) {
            no_stock = $(this).closest("tr").children("td:eq(0)").text();
            kodeBJ = $(this).closest("tr").children("td:eq(4)").text();
            if (kodeBJ == 'G') {
                $.ajax({
                    url: get_SoItemChild + "/" + no_stock,
                    type: "GET",
                    dataType: "JSON",
                    success: function (response) {
                        jQuery.each(response.child, function (i, val) {
                            addRow();
                            $("#no_stock-" + (uid + i + 1)).attr('onclick', '');
                            $("#nm_stock-" + (uid + i + 1)).html("--" + val.nama_barang);
                            $("#qty-" + (uid + i + 1)).attr('readonly', true);
                            $("#sat-" + (uid + i + 1)).attr('readonly', true);
                            $("#price-" + (uid + i + 1)).css('display', 'none');
                            $("#disc-" + (uid + i + 1)).css('display', 'none');
                            $("#disc2-" + (uid + i + 1)).css('display', 'none');
                            $("#disc_val-" + (uid + i + 1)).css('display', 'none');
                            $("#total-" + (uid + i + 1)).css('display', 'none');
                            $("#tax-" + (uid + i + 1)).css('display', 'none');
                            $("#tax-" + (uid + i + 1)).html('<option selected value="" ></option>');

                            $("#no_stock-" + (uid + i + 1)).val(val.no_stock);
                            $("#base_qty-" + (uid + i + 1)).val(val.saldo);
                            $("#qty-" + (uid + i + 1)).val(val.saldo);
                            $("#sat-" + (uid + i + 1)).val(val.sat);
                            $("#itemKodeGroup-" + (uid + i + 1)).val(no_stock);
                            $("#itemVintrasId-" + (uid + i + 1)).val(val.VINTRASID);
                            $("#itemTahunVintras-" + (uid + i + 1)).val(val.tahun);
                            $("#merkItem-" + (uid + i + 1)).val(val.merk);
                            $("#itemBruto-" + (uid + i + 1)).html('0');
                        });
                    },
                });
            }

            $("#no_stock-" + uid).val(no_stock);
            $("#nm_stock-" + uid).html($(this).closest("tr").children("td:eq(1)").text());
            $("#qty-" + uid).val('1');
            $("#sat-" + uid).val($(this).closest("tr").children("td:eq(2)").text());
            $("#itemVintrasId-" + (uid)).val($(this).closest("tr").children("td:eq(5)").text());
            $("#itemTahunVintras-" + (uid)).val($(this).closest("tr").children("td:eq(6)").text());
            $("#merkItem-" + (uid)).val($(this).closest("tr").children("td:eq(7)").text());
            e.stopImmediatePropagation();
        }
        $("#modalInventory").modal("hide");
    });
}

function itemTotal(uid) {
    var qty = $("#qty-" + uid).val() != "" ? parseFloat(removePeriod($("#qty-" + uid).val(), ',')) : 0;
    var price = $("#price-" + uid).val() != "" ? parseFloat(removePeriod($("#price-" + uid).val(), ',')) : 0;
    var disc = $("#disc-" + uid).val() != "" ? parseFloat(removePeriod($("#disc-" + uid).val(), ',')) : 0;
    var disc2 = $("#disc2-" + uid).val() != "" ? parseFloat(removePeriod($("#disc2-" + uid).val(), ',')) : 0;
    var disc_val = $("#disc_val-" + uid).val() != "" ? parseFloat(removePeriod($("#disc_val-" + uid).val(), ',')) : 0;
    var item_disc = $("#itemDisc-" + uid).html() != "" ? parseFloat(removePeriod($("#itemDisc-" + uid).html(), ',')) : 0;

    var totalBruto = price * qty;
    // var total = (price * qty * (1 - disc / 100) * (1 - disc2 / 100)) - ((price-disc_val)*qty);
    // var totalDiscHead = ((price * qty * (1 - disc / 100) * (1 - disc2 / 100)) - disc_val) - item_disc;
    var d1 = (price * qty) - (price * qty * disc);
    var d2 = d1 - (d1 * disc2);
    var d3 = d2 - (qty * disc_val);
    var total = d3;
    var totalDiscHead = ((price * qty * (1 - disc / 100) * (1 - disc2 / 100)) - disc_val) - item_disc;
    var tax = $("#tax-" + uid).val();
    var itemTax = 0;
    var itemTaxValue = 0;

    // if (tax != "") {
    //     jQuery.each(vat, function (i, val) {
    //         if (val.kode == tax) {
    //             itemTaxValue += val.prosen;
    //         }
    //     });
    // }
    if ($("#price-" + uid).val() != '') {
        $("#total-" + uid).val(total);
        $("#itemBruto-" + uid).html(totalBruto);
    } else {
        $("#itemBruto-" + uid).html('0');
        $("#total-" + uid).val('')
    }
    $("#itemTotal-" + uid).html(total);
    $("#itemTaxValue-" + uid).html(itemTaxValue);
    totalDpp();

    var no_stock = $('#no_stock-' + uid).val();
    var myTab = document.getElementById("trx");
    for (i = 1; i < myTab.rows.length; i++) {
        var objCells = myTab.rows.item(i).cells;
        // if (objCells.item(18).children[0].value == no_stock) {
        //     var saldo = $("#base_qty-" + (i - 1)).val();
        //     $("#qty-" + (i - 1)).val(saldo * qty);
        // }
    }
}

function totalDpp() {
    var myTab = document.getElementById("trx");
    var totalBruto = 0;
    var totalDpp = 0;
    for (i = 1; i < myTab.rows.length; i++) {
        var objCells = myTab.rows.item(i).cells;

        var itemTotal = objCells.item(12).innerHTML != "" ? parseFloat(removePeriod(objCells.item(12).innerHTML, ',')) : 0;
        var itemBruto = objCells.item(16).innerHTML != "" ? parseFloat(removePeriod(objCells.item(16).innerHTML, ',')) : 0;
        totalDpp += itemTotal;
        totalBruto += itemBruto;
    }
    $("#totalBruto").val(totalBruto);
    $("#totalDpp").val(totalDpp);
    discountHead('discountValueHead');
}

function discountHead(param) {
    var myTab = document.getElementById("trx");
    var discountProcentageHead = 0;
    var discountValueHead = 0;
    if (param == "discountValueHead" && $('#discountValueHead').val() != '') {
        discountValueHead = $('#discountValueHead').val();
        $('#discountProcentageHead').val(parseFloat(discountValueHead) / parseFloat($("#totalBruto").val()) * 100)
    } else if (param == "discountProcentageHead" && $('#discountProcentageHead').val() != '') {
        discountProcentageHead = $('#discountProcentageHead').val();
        discountValueHead = parseFloat(discountProcentageHead) * parseFloat($("#totalBruto").val()) / 100;
        $('#discountValueHead').val(discountValueHead);
    }

    for (i = 1; i < myTab.rows.length; i++) {
        var objCells = myTab.rows.item(i).cells;
        var itemBruto = objCells.item(16).innerHTML > 0 ? parseFloat(objCells.item(16).innerHTML) : 0;
        var itemDiscount = 0;
        if (discountValueHead != 0) {
            itemDiscount = (itemBruto / $("#totalDpp").val()) * discountValueHead;
        }
        objCells.item(14).innerHTML = itemDiscount;
        objCells.item(15).innerHTML = itemBruto - itemDiscount;
    }
    totalPpn();
}

function totalPpn() {
    var myTab = document.getElementById("trx");
    var totalDpp = parseFloat($('#totalDpp').val());
    var discountValueHead = $('#discountValueHead').val();
    if (discountValueHead != '') {
        discountValueHead = parseFloat($('#discountValueHead').val());
    }
    var totalPpn = 0;

    if (myTab.rows.length > 0) {
        for (i = 1; i < myTab.rows.length; i++) {
            var objCells = myTab.rows.item(i).cells;
            if (objCells.item(14).innerHTML > 0) {
                var itemTaxTotal = (parseFloat(objCells.item(16).innerHTML) - parseFloat(objCells.item(14).innerHTML)) * parseFloat(objCells.item(17).innerHTML) / 100;
            } else {
                if (objCells.item(12).innerHTML > 0) {
                    var itemTaxTotal = parseFloat(objCells.item(12).innerHTML) * parseFloat(objCells.item(17).innerHTML) / 100;
                } else {
                    var itemTaxTotal = 0;
                }
            }
            totalPpn += itemTaxTotal;
        }
    }

    var grandTotal = totalDpp - discountValueHead + totalPpn;
    $("#totalPpn").val(totalPpn);
    $("#grandTotal").val(grandTotal);
}

function getTax() {
    var sdate = $('#date_order').val();
    $.ajax({
        delay: 0,
        url: get_vat + "/" + sdate,
        type: "GET",
        dataType: "JSON",
        success: function (response) {
            $('.tax').html('');
            var html = '';
            jQuery.each(response, function (i, val) {
                html += "<option value='" + val.kode + "'>" + val.kode + "</option>";
            });
            $('.tax').html(html);
        },
    });
}

function cekSo() {
    var po = $('#po_customer').val();
    var customer = $('#customer').val();
    var so_id = $('#nomor').val();
    let _token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: 'POST',
        url: rute_cekSo,
        data: {
            po: po,
            customer: customer,
            so_id: so_id,
            _token: _token
        },
        dataType: "text",
        success: function (resultData) {
            var msg = JSON.parse(resultData);
            if (msg.so > 0) {
                Swal.fire({
                    title: "Cannot Add Sales Invoice!",
                    text: "Sales invoice number has been used",
                    icon: "error",
                    confirmButtonColor: "#17a2b8",
                })
            } else if (msg.customer.length > 0) {
                Swal.fire({
                    title: "Cannot Add Sales Invoice!",
                    text: "Customer and PO Customer has been used",
                    icon: "error",
                    confirmButtonColor: "#17a2b8",
                })
            } else if (msg.po.length > 0) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "This PO Customer that has been registered on SI: " + msg.po[0].NO_BUKTI,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#17a2b8",
                    cancelButtonColor: "#FFC107",
                    confirmButtonText: "Yes, Process it!",
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#salesOrderAddSave').submit();
                    }
                });
            } else {
                $('#salesOrderAddSave').submit();
            }
        },
        error: function (e) {
            console.log(e);
            console.log("Something went wrong");
        }
    });
};

$("#print").click(function (e) {
    e.preventDefault();
    $('#process').val('print');
    cekSo();
});
$("#save").click(function (e) {
    e.preventDefault();
    $('#process').val('save');
    cekSo();
});


