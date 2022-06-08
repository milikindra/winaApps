$(".selects2").select2();
$(document).ready(function () {
    var voids = "1";
    var kategori = "all";
    var subkategori = "all";

    dt(voids, kategori, subkategori);
});

function dt(voids, kategori, subkategori) {
    var table = $("#datatables").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        stateSave: true,
        deferRender: true,
        lengthMenu: [
            [10, 100, 250, 500, 1000, -1],
            [10, 100, 250, 500, 1000, "all"],
        ],
        dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        drawCallback: function (settings, json) {},
        ajax: {
            url: get_inventory +
                "/" +
                voids +
                "/" +
                kategori +
                "/" +
                subkategori,
            type: "GET",
            dataType: "JSON",
        },
        columns: [{
                data: "no_stock",
                name: "no_stock",
                ordering: false,
            },
            {
                data: "nama_barang",
                name: "nama_barang",
                ordering: false,
            },
            {
                data: "sat",
                name: "sat",
                ordering: false,
            },
        ],
        order: [
            [0, "asc"]
        ],
    });
}

$("#customer").change(function () {
    var id_cust = $("#customer").val();
    $.ajax({
        url: get_customer + "/" + id_cust,
        type: "GET",
        dataType: "JSON",
        success: function (response) {
            $("#curr").val(response[0].curr);
            $("#rate_cur").val(response[0].rate);
            $("#tempo").val(response[0].TEMPO);
            $("#customer_name").val(response[0].NM_CUST);
            var customer_address =
                response[0].ALAMAT1 +
                "\r\n" +
                response[0].ALAMAT2 +
                "\r\n" +
                response[0].KOTA +
                "\r\n" +
                response[0].PROPINSI +
                "\r\n" +
                response[0].TELP;
            $("#customer_address").html(customer_address);
        },
    });
});

$("#sales").change(function () {
    var id_sales = $("#sales").val();
    jQuery.each(sales, function (i, val) {
        if (id_sales == val.ID_SALES) {
            $("#sales_name").val(val.NM_SALES);
        }
    });
});

$("#bu_modal").on("click", function (e) {
    e.preventDefault();
    var nilai = $("#bu_val").val();
    var arr_nilai = nilai.split(";");
    var arr = [];
    for (var i = 0; i < arr_nilai.length; i++) {
        arr_val = arr_nilai[i].split(":");
        arr.push(arr_val);
    }

    var m = new Map(arr);
    var indexKey = Array.from(m.keys());
    var indexValue = Array.from(m.values());

    var table = $(".tbl_bu tbody");
    table.find("tr").each(function (i, el) {
        var tds = $(this).find("td");
        var kode = tds.eq(0).text().trim();
        var inp = $(this).find("input");
        inp.val("");
        for (var j = 0; j < indexKey.length - 1; j++) {
            if (kode == indexKey[j]) {
                inp.val(indexValue[j]);
            }
        }
    });

    $("#modalBu").modal("show");
});

$("#bu_save").on("click", function (e) {
    e.preventDefault();
    var table = $(".tbl_bu tbody");
    var bu = "";
    var t_prosen = 0;
    table.find("tr").each(function (i, el) {
        var tds = $(this).find("td");
        var kode = tds.eq(0).text().trim();
        var inp = $(this).find("input");
        var prosentase = inp.eq(0).val();
        if (prosentase != "" || prosentase > 0) {
            bu += kode + ":" + prosentase + ";";
            t_prosen += parseFloat(prosentase);
        }
    });
    if (t_prosen < 100) {
        alert("Prosentase Kurang Dari 100%");
    } else if (t_prosen > 100) {
        $("#bu_val").val(bu);
        alert("Prosentase Lebih Dari 100%");
        $("#bu_val").val(bu);
    } else {
        $("#bu_val").val(bu);
        $("#modalBu").modal("hide");
    }
});

$("#dept_modal").on("click", function (e) {
    e.preventDefault();
    var nilai = $("#dept_val").val();
    var arr_nilai = nilai.split(";");
    var arr = [];
    for (var i = 0; i < arr_nilai.length; i++) {
        arr_val = arr_nilai[i].split(":");
        arr.push(arr_val);
    }

    var m = new Map(arr);
    var indexKey = Array.from(m.keys());
    var indexValue = Array.from(m.values());

    var table = $(".tbl_dept tbody");
    table.find("tr").each(function (i, el) {
        var tds = $(this).find("td");
        var kode = tds.eq(0).text().trim();
        var inp = $(this).find("input");
        inp.val("");
        for (var j = 0; j < indexKey.length - 1; j++) {
            if (kode == indexKey[j]) {
                inp.val(indexValue[j]);
            }
        }
    });

    $("#modalDept").modal("show");
});

$("#dept_save").on("click", function (e) {
    e.preventDefault();
    var table = $(".tbl_dept tbody");
    var dept = "";
    var t_prosen = 0;
    table.find("tr").each(function (i, el) {
        var tds = $(this).find("td");
        var kode = tds.eq(0).text().trim();
        var inp = $(this).find("input");
        var prosentase = inp.eq(0).val();
        if (prosentase != "" || prosentase > 0) {
            dept += kode + ":" + prosentase + ";";
            t_prosen += parseFloat(prosentase);
        }
    });
    if (t_prosen < 100) {
        alert("Prosentase Kurang Dari 100%");
        $("#dept_val").val(dept);
    } else if (t_prosen > 100) {
        alert("Prosentase Lebih Dari 100%");
        $("#dept_val").val(dept);
    } else {
        $("#dept_val").val(dept);
        $("#modalDept").modal("hide");
    }
});

var rowCountDp = 0;
window.addRowDp = function (element) {
    rowCountDp++;
    var vatOption = "";
    jQuery.each(vat, function (i, val) {
        vatOption += "<option>" + val.kode + "</option>";
    });

    $(".down_payment").append(
        '<tr> <td> <input type="text" class="form-control form-control-sm" name="dp[]" id="dp-' +
        rowCountDp +
        '" onchange="addDp(' + rowCountDp + ')">  </td><td> <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="dp_value[]" id="dp_value-' +
        rowCountDp +
        '" onchange="addDp(' + rowCountDp + ')"> </td> <td><select class="form-control form-control-sm" name="dp_tax[]" id="dp_tax-' +
        rowCountDp +
        '" onchange="addDp(' + rowCountDp + ')">' +
        vatOption +
        '</select></td><td id="dp_tax_value-' + rowCountDp + '" style="display:none"></td></tr>'
    );
};

window.removeRowDp = function (element) {
    $(".down_payment tr:last").remove();
};

function addDp(uid) {
    var dp_value = $("#dp_value-" + uid).val();
    var dp_tax = $("#dp_tax-" + uid).val();
    var itemTaxValue = 0;
    jQuery.each(vat, function (i, val) {
        if (val.kode == dp_tax) {
            itemTaxValue = val.prosen;
        }
    });
    document.getElementById("dp_tax_value-" + uid).innerHTML = itemTaxValue;
    totalDownPayment();
}

function totalDownPayment() {
    var myTab = document.getElementById("down_payment");
    var totalDp = 0;
    var totalDpTax = 0;
    for (i = 1; i < myTab.rows.length; i++) {
        var dpValue = $("#dp_value-" + (i - 1)).val() != "" ? parseFloat($("#dp_value-" + (i - 1)).val()) : 0;
        var dpTax = $("#dp_value-" + (i - 1)).val() != "" ? parseFloat($("#dp_value-" + (i - 1)).val()) * parseFloat($("#dp_tax_value-" + (i - 1)).html()) / 100 : 0;
        totalDp += dpValue;
        totalDpTax += dpTax;
    }
    $("#totalDpTax").val(totalDpTax);
    $("#totalDp").val(totalDp);
}


var rowCount = 0;
window.addRow = function (element) {
    rowCount++;
    var vatOption = '';
    jQuery.each(vat, function (i, val) {
        vatOption += "<option>" + val.kode + "</option>";
    });

    $(".trx").append(
        '<tr> <td> <input type="text" class="form-control form-control-sm" name="no_stock[]" id="no_stock-' +
        rowCount +
        '" onclick="addData(' +
        rowCount +
        ')" readonly > </td><td> <textarea class="form-control form-control-sm" name="nm_stock[]" id="nm_stock-' +
        rowCount +
        '" rows="3"></textarea> </td><td> <input type="text" class="form-control form-control-sm" name="ket[]" id="ket--' +
        rowCount +
        '"> </td><td> <input type="number" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="qty[]" id="qty-' +
        rowCount +
        '" onchange="itemTotal(' +
        rowCount +
        ')"> </td><td> <input type="text" class="form-control form-control-sm" name="sat[]" id="sat-' +
        rowCount +
        '"> </td><td> <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="price[]" id="price-' +
        rowCount +
        '" onchange="itemTotal(' +
        rowCount +
        ')">  </td><td> <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="disc[]" id="disc-' +
        rowCount +
        '" onchange="itemTotal(' +
        rowCount +
        ')"> </td><td> <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="disc2[]" id="disc2-' +
        rowCount +
        '" onchange="itemTotal(' +
        rowCount +
        ')"> </td><td> <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;"  name="disc_val[]" id="disc_val-' +
        rowCount +
        '" onchange="itemTotal(' +
        rowCount +
        ')">  </td><td> <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="total[]" id="total-' +
        rowCount +
        '" readonly"> <td><select class="form-control form-control-sm" name="tax[]" id="tax-' +
        rowCount +
        '" onchange="itemTotal(' +
        rowCount +
        ')">' +
        vatOption +
        '</select></td><td> <input type="text" class="form-control form-control-sm" name="state[]" id="state-' +
        rowCount +
        '" readonly> </td><td style="display: none;" id="itemTotal-' +
        rowCount +
        '"></td> <td style="display: none;" id = "itemTax-' +
        rowCount +
        '" > < /td> <td style="display: none;" id = "itemDisc-' +
        rowCount +
        '" > < /td> <td style="display: none;" id = "itemTotalDiscHead-' +
        rowCount +
        '" > < /td> <td style="display: none;" id = "itemBruto-' +
        rowCount +
        '" > < /td> <td style="display: none;" id = "itemTaxValue-' +
        rowCount +
        '" > < /td></tr > '
    );
};

window.removeRow = function (element) {
    $(".trx tr:last").remove();
};

var arr = [];

function addData(uid) {
    arr.push(uid);
    $("#modalBarang").modal("show");
    $("#datatables").on("click", "tbody tr", function () {
        if (uid == arr[arr.length - 1]) {
            no_stock = $(this).closest("tr").children("td:eq(0)").text();
            nm_stock = $(this).closest("tr").children("td:eq(1)").text();
            sat = $(this).closest("tr").children("td:eq(2)").text();
            document.getElementById("no_stock-" + uid).value = no_stock;
            document.getElementById("nm_stock-" + uid).innerHTML = nm_stock;
            document.getElementById("sat-" + uid).value = sat;
        }
        $("#modalBarang").modal("hide");
    });
}

function itemTotal(uid) {
    var qty = $("#qty-" + uid).val() != "" ? parseFloat($("#qty-" + uid).val()) : 0;
    var price = $("#price-" + uid).val() != "" ? parseFloat($("#price-" + uid).val()) : 0;
    var disc = $("#disc-" + uid).val() != "" ? parseFloat($("#disc-" + uid).val()) : 0;
    var disc2 = $("#disc2-" + uid).val() != "" ? parseFloat($("#disc2-" + uid).val()) : 0;
    var disc_val = $("#disc_val-" + uid).val() != "" ? parseFloat($("#disc_val-" + uid).val()) : 0;
    var item_disc = $("#itemDisc-" + uid).html() != "" ? parseFloat($("#itemDisc-" + uid).html()) : 0;

    var totalBruto = price * qty;
    var total = (price * qty * (1 - disc / 100) * (1 - disc2 / 100)) - disc_val;
    var totalDiscHead = ((price * qty * (1 - disc / 100) * (1 - disc2 / 100)) - disc_val) - item_disc;
    var tax = $("#tax-" + uid).val();
    var itemTax = 0;
    var itemTaxValue = 0;

    if (tax != "") {
        jQuery.each(vat, function (i, val) {
            if (val.kode == tax) {
                itemTaxValue += val.prosen;
            }
        });
    }
    document.getElementById("total-" + uid).value = total;
    document.getElementById("itemTotal-" + uid).innerHTML = total;
    document.getElementById("itemTaxValue-" + uid).innerHTML = itemTaxValue;
    document.getElementById("itemBruto-" + uid).innerHTML = totalBruto;
    totalDpp();
}

function totalDpp() {
    var myTab = document.getElementById("trx");
    var totalBruto = 0;
    var totalDpp = 0;
    for (i = 1; i < myTab.rows.length; i++) {
        var objCells = myTab.rows.item(i).cells;
        var itemTotal = objCells.item(12).innerHTML != "" ? parseFloat(objCells.item(12).innerHTML) : 0;
        var itemBruto = objCells.item(16).innerHTML != "" ? parseFloat(objCells.item(16).innerHTML) : 0;
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
        $('#discountProcentageHead').val(parseFloat(discountValueHead) * $("#totalBruto").val() / 100)
    } else if (param == "discountProcentageHead") {
        discountProcentageHead = $('#discountProcentageHead').val();
        discountValueHead = parseFloat(discountProcentageHead) * $("#totalBruto").val() / 100;
        $('#discountValueHead').val(discountValueHead);
    }

    for (i = 1; i < myTab.rows.length; i++) {
        var objCells = myTab.rows.item(i).cells;
        var itemBruto = objCells.item(16).innerHTML != "" ? parseFloat(objCells.item(16).innerHTML) : 0;
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
    var totalPpn = 0;

    for (i = 1; i < myTab.rows.length; i++) {
        var objCells = myTab.rows.item(i).cells;

        if (objCells.item(14).innerHTML > 0) {
            var itemTaxTotal = (parseFloat(objCells.item(16).innerHTML) - parseFloat(objCells.item(14).innerHTML)) * parseFloat(objCells.item(17).innerHTML) / 100;
        } else {
            var itemTaxTotal = parseFloat(objCells.item(12).innerHTML) * parseFloat(objCells.item(17).innerHTML) / 100;
        }
        totalPpn += itemTaxTotal;
    }

    var grandTotal = totalDpp - discountValueHead + totalPpn;
    $("#totalPpn").val(totalPpn);
    $("#grandTotal").val(grandTotal);
}