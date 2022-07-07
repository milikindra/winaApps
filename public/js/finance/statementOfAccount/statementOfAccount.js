$(document).ready(function () {
    $.fn.dataTable.ext.errMode = 'none';
    $(".selects2").select2();

    $("#dataType").prop("selectedIndex", 1).trigger("change");
    dt_customer();
    dt_so();
    dt_sales();
    dt_supplier();
    dt_inventory();
});
var Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
});

$("#dataType").change(function () {
    $("#appCustomerSOA").css("display", "none");
    $("#appSupplierSOA").css("display", "none");

    $("#filterEdate").css("display", "none");
    $("#filterCustomer").css("display", "none");
    $("#filterSO").css("display", "none");
    $("#filterSales").css("display", "none");
    $("#filterOverdueCustomer").css("display", "none");
    $("#filterTotalCustomer").css("display", "none");
    $("#filterSupplier").css("display", "none");
    $("#filterInventory").css("display", "none");
    $("#filterTag").css("display", "none");
    $("#filterOverdueSupplier").css("display", "none");
    $("#filterTotalSupplier").css("display", "none");

    var dataType = $("#dataType").val();
    if (dataType == "appCustomerSOA") {
        $("#appCustomerSOA").css("display", "block");
        $("#filterEdate").css("display", "block");
        $("#filterCustomer").css("display", "block");
        $("#filterSO").css("display", "block");
        $("#filterSales").css("display", "block");
        $("#filterOverdueCustomer").css("display", "block");
        $("#filterTotalCustomer").css("display", "block");
    }
    if (dataType == "appSupplierSOA") {
        $("#appSupplierSOA").css("display", "block");
        $("#filterEdate").css("display", "block");
        $("#filterSupplier").css("display", "block");
        $("#filterInventory").css("display", "block");
        $("#filterTag").css("display", "block");
        $("#filterOverdueSupplier").css("display", "block");
        $("#filterTotalSupplier").css("display", "block");
    }
});

function dataReport() {
    var dataType = $("#dataType").val();
    if (dataType == "appCustomerSOA") {
        tableCustomerSOA();
    }
    
    if (dataType == "appSupplierSOA") {
        tableSupplierSOA();
    }

}

function tableCustomerSOA() {
    $("#overlay").fadeIn(300);
    $("#tableCustomerSOA").empty();

    var edate = 'all';
    var customer = 'all';
    var so = 'all';
    var sales = 'all';
    var overdue = 'all';
    var isTotalCustomer = "N"

    if ($('#edate').val() !== '') {
        edate = $('#edate').val();
    }
    if ($('#customer').val() !== '') {
        customer = $('#customer').val();
    }
    if ($('#so').val() !== '') {
        so = $('#so').val();
    }
    if ($('#sales').val() !== '') {
        sales = $('#sales').val();
    }
    if ($('#overdueCustomer').val() !== '') {
        overdue = $('#overdueCustomer').val();
    }
    if ($('#isTotalCustomer').is(":checked")) {
        isTotalCustomer = $('#isTotalCustomer').val();
    }
    $.ajax({
        type: 'GET',
        url: rute_customer_soa + '/' + edate + '/' + customer + '/' + so + '/' + sales + '/' + overdue + '/' + isTotalCustomer,
        dataType: 'json',
        success: function (data) {
            $('#titleCustomerSOA').html('PT. VIKTORI PROFINDO AUTOMATION');;
            $('#subtitleCustomerSOA').html('CUSTOMER STATEMENT OF ACCOUNT');;
            $('#filterCustomerSOA').html('Per : ' + moment(edate).format("DD/MM/YYYY"));

            var html = '';
            html = '<thead><tr style="text-align:center"><th id="no-sort">Customer</th><th>Invoice</th><th>Invoice Date</th><th>Due Date</th><th>Est Date</th><th>PO</th><th>Total</th><th>Sales</th><th>Overdue > 100 days</th><th>Overdue 1 - 30 days</th><th>Overdue 31 - 60 days</th><th>Overdue 61 - 100 days</th><th>Not Due</th></tr></thead>';
            html += '<tbody>';

            var a = JSON.parse(JSON.stringify(data));
            $.each(a.data, function (i, item) {
                var no_inv = '';
                if (item.no_inv != null) {
                    no_inv =item.no_inv 
                }
                var tgl_bukti = '';
                if (item.tgl_bukti != null) {
                    tgl_bukti = moment(item.tgl_bukti).format("DD/MM/YYYY")
                }
                var due_date = '';
                if (item.tgl_due != null) {
                    due_date = moment(item.tgl_due).format("DD/MM/YYYY")
                }
                var est_date = '';
                if (item.est_date != null) {
                    est_date = moment(item.est_date).format("DD/MM/YYYY")
                }
                var no_po = '';
                if (item.no_po != null) {
                    no_po =item.no_po 
                }
                var sales = '';
                if (item.sales != null) {
                    sales =item.sales 
                }
                if ( item.total != null) {
                    var total = numbro(item.total).format({
                        thousandSeparated: true,
                        negative: "parenthesis",
                        mantissa: 2
                    });
                } else {
                    var total = "";
                }
                if (item.overdue_100 != null) {
                    var overdue_100 = numbro(item.overdue_100).format({
                        thousandSeparated: true,
                        negative: "parenthesis",
                        mantissa: 2
                    });
                } else {
                    var overdue_100 = "";
                }
                if (item.overdue_1_30 != null) {
                    var overdue_1_30 = numbro(item.overdue_1_30).format({
                        thousandSeparated: true,
                        negative: "parenthesis",
                        mantissa: 2
                    });
                } else {
                    var overdue_1_30 = "";
                }
                if (item.overdue_31_60 != null) {
                    var overdue_31_60 = numbro(item.overdue_31_60).format({
                        thousandSeparated: true,
                        negative: "parenthesis",
                        mantissa: 2
                    });
                } else {
                    var overdue_31_60 = "";
                }
                if (item.overdue_61_100 != null) {
                    var overdue_61_100 = numbro(item.overdue_61_100).format({
                        thousandSeparated: true,
                        negative: "parenthesis",
                        mantissa: 2
                    });
                } else {
                    var overdue_61_100 = "";
                }
                if (item.notdue != null) {
                    var notdue = numbro(item.notdue).format({
                        thousandSeparated: true,
                        negative: "parenthesis",
                        mantissa: 2
                    });
                } else {
                    var notdue = "";
                }
                if (item.sisa != null) {
                    var sisa = numbro(item.sisa).format({
                        thousandSeparated: true,
                        negative: "parenthesis",
                        mantissa: 2
                    });
                } else {
                    var sisa = "";
                }

                var nm_cust = item.nm_cust;
                if (nm_cust.substr(0, 17) == 'Total Outstanding') {
                    html += '<tr style="font-weight:bold">';
                } else {
                    html += '<tr>';
                }

                html += '<td>'+item.nm_cust+'</td>';
                html += '<td>'+no_inv+'</td>';
                html += '<td style="text-align:center">'+ tgl_bukti +'</td>';
                html += '<td style="text-align:center">'+ due_date +'</td>';
                html += '<td style="text-align:center">'+ est_date +'</td>';
                html += '<td style="word-wrap: break-word">'+no_po+'</td>';
                html += '<td style="text-align:right">' + total + '</td>';
                html += '<td>'+sales+'</td>';
                html += '<td style="text-align:right">' + overdue_100 + '</td>';
                html += '<td style="text-align:right">' + overdue_1_30 + '</td>';
                html += '<td style="text-align:right">' + overdue_31_60 + '</td>';
                html += '<td style="text-align:right">' + overdue_61_100 + '</td>';
                html += '<td style="text-align:right">' + notdue + '</td>';
                html += '<td style="display:none">' + item.internal_notes + '</td>';
                html += '<td style="display:none">' + item.est_date + '</td>';
                html += '</tr>';
                if (item.internal_notes != null) {
                    html += '<tr>';
                    html += '<td colspan="100%"><small>Notes : <i>'+item.internal_notes+'<i></small></td>';
                    html += '</tr>';
                }
            });
            html += '</tbody>'
            $("#tableCustomerSOA").html(html);
            setTimeout(function () {
                $("#overlay").fadeOut(300);
            }, 500);
        }
    });
}

$('#tableCustomerSOA').on('dblclick tbody', 'tr', function (e) {
    $("#cnmInvoice").val($(this).closest("tr").children("td:eq(1)").text());
    if ($(this).closest("tr").children("td:eq(13)").text() != 'null') {
        $("#cnmInNotes").html($(this).closest("tr").children("td:eq(13)").text());
    } else {
        $("#cnmInNotes").html('');
    }
    if ($(this).closest("tr").children("td:eq(14)").text() != 'null') {
        $("#cnmEstDate").val($(this).closest("tr").children("td:eq(14)").text());
    } else {
        $("#cnmEstDate").val('');
    }
    $("#customerNotesModal").modal("show");

})

$("#customerNote_save").on("click", function (e) {
    var soaType = 'customer';
    var cnmInvoice = $("#cnmInvoice").val();
    var cnmEstDate = $("#cnmEstDate").val();
    var cnmInNotes = $("#cnmInNotes").val();
    let _token = $("input[name=_token]").val();
    $.ajax({
        type: 'POST',
        url: rute_internal_notes,
        data: {
                soaType: soaType,
                cnmInvoice: cnmInvoice,
                cnmEstDate: cnmEstDate,
                cnmInNotes: cnmInNotes,
                _token: _token
            },
        dataType: 'json',
        success: function (data) {
            Toast.fire({
                icon: "success",
                title: "Successfully save data",
            });
        }
    });
    $("#customerNotesModal").modal("hide");
    $("#processFilter").trigger("click");
    
});
    
function tableSupplierSOA() {
    $("#overlay").fadeIn(300);
    $("#tableSupplierSOA").empty();

    var edate = 'all';
    var supplier = 'all';
    var inventory = 'all';
    var tag = 'all';
    var overdue = 'all';
    var isTotalSupplier = "N"

    if ($('#edate').val() !== '') {
        edate = $('#edate').val();
    }
    if ($('#supplier').val() !== '') {
        supplier = $('#supplier').val();
    }
    if ($('#inventory').val() !== '') {
        inventory = $('#inventory').val();
    }
    if ($('#tag').val() !== '') {
        tag = $('#tag').val();
    }
    if ($('#overdueSupplier').val() !== '') {
        overdue = $('#overdueSupplier').val();
    }
    if ($('#isTotalSupplier').is(":checked")) {
        isTotalSupplier = $('#isTotalSupplier').val();
    }
    $.ajax({
        type: 'GET',
        url: rute_supplier_soa +  '/' + edate + '/' + supplier + '/' + inventory + '/' + tag + '/' + overdue + '/' + isTotalSupplier,
        dataType: 'json',
        success: function (data) {
            $('#titleSupplierSOA').html('PT. VIKTORI PROFINDO AUTOMATION');;
            $('#subtitleSupplierSOA').html('SUPPLIER STATEMENT OF ACCOUNT');;
            $('#filterSupplierSOA').html('Per : ' + moment(edate).format("DD/MM/YYYY"));

            var html = '';
            html = '<thead> <tr style="text-align: center;"> <th>Supplier</th> <th>PI</th> <th>PI Date</th> <th>Due Date</th> <th>Invoice</th> <th>Currency</th> <th>Total</th> <th>Payment Paid</th> <th>Age</th> <th>Overdue < 15 days</th> <th>Overdue 15 - 30 days</th> <th>Overdue 31 - 60 days</th> <th>Overdue > 60 days</th> <th>Due In 1 Week</th> <th>Due In 2 Weeks</th> <th>On Scheduled</th> <th>Total (IDR)</th> </tr></thead>';
            html += '<tbody>';

            var a = JSON.parse(JSON.stringify(data));
            $.each(a.data, function (i, item) {
                var nm_supplier = '';
                if (item.nm_supplier != null) {
                    nm_supplier = item.nm_supplier;
                }
                var no_pi = '';
                if (item.no_pi != null) {
                    no_pi = item.no_pi;
                }
                var tgl_bukti = '';
                if (item.tgl_bukti != null) {
                    tgl_bukti = moment(item.tgl_bukti).format("DD/MM/YYYY")
                }
                var due_date = '';
                if (item.tgl_due != null) {
                    due_date = moment(item.tgl_due).format("DD/MM/YYYY")
                }
                var no_inv = '';
                if (item.no_inv != null) {
                    no_inv = item.no_inv;
                }
                var currency = '';
                if (item.currency != null) {
                    currency = item.currency;
                }
                if ( item.total != null) {
                    var total = numbro(item.total).format({
                        thousandSeparated: true,
                        negative: "parenthesis",
                        mantissa: 2
                    });
                } else {
                    var total = "";
                }
                var paid = '';
                if (item.paid != null) {
                    paid = numbro(item.paid).format({
                        thousandSeparated: true,
                        negative: "parenthesis",
                        mantissa: 2
                    }) 
                }
                var age = '';
                if (item.age != null) {
                    age = item.age;
                }
                if (item.overdue_1_14 != null) {
                    var overdue_1_14 = numbro(item.overdue_1_14).format({
                        thousandSeparated: true,
                        negative: "parenthesis",
                        mantissa: 2
                    });
                } else {
                    var overdue_1_14 = "";
                }
                if (item.overdue_15_30 != null) {
                    var overdue_15_30 = numbro(item.overdue_15_30).format({
                        thousandSeparated: true,
                        negative: "parenthesis",
                        mantissa: 2
                    });
                } else {
                    var overdue_15_30 = "";
                }
                if (item.overdue_31_60 != null) {
                    var overdue_31_60 = numbro(item.overdue_31_60).format({
                        thousandSeparated: true,
                        negative: "parenthesis",
                        mantissa: 2
                    });
                } else {
                    var overdue_31_60 = "";
                }
                if (item.overdue_60 != null) {
                    var overdue_60 = numbro(item.overdue_60).format({
                        thousandSeparated: true,
                        negative: "parenthesis",
                        mantissa: 2
                    });
                } else {
                    var overdue_60 = "";
                }
                if (item.in_1_weeks != null) {
                    var in_1_weeks = numbro(item.in_1_weeks).format({
                        thousandSeparated: true,
                        negative: "parenthesis",
                        mantissa: 2
                    });
                } else {
                    var in_1_weeks = "";
                }
                if (item.in_2_weeks != null) {
                    var in_2_weeks = numbro(item.in_2_weeks).format({
                        thousandSeparated: true,
                        negative: "parenthesis",
                        mantissa: 2
                    });
                } else {
                    var in_2_weeks = "";
                }
                if (item.on_schedule != null) {
                    var on_schedule = numbro(item.on_schedule).format({
                        thousandSeparated: true,
                        negative: "parenthesis",
                        mantissa: 2
                    });
                } else {
                    var on_schedule = "";
                }
                if (item.total_idr != null) {
                    var total_idr = numbro(item.total_idr).format({
                        thousandSeparated: true,
                        negative: "parenthesis",
                        mantissa: 2
                    });
                } else {
                    var total_idr = "";
                }

                var nm_supplier = item.nm_supplier;
                if (nm_supplier.substr(0, 17) == 'Total Outstanding') {
                    html += '<tr style="font-weight:bold">';
                } else {
                    html += '<tr>';
                }
                html += '<td>'+nm_supplier+'</td>';
                html += '<td>'+no_pi+'</td>';
                html += '<td style="text-align:center">'+ tgl_bukti +'</td>';
                html += '<td style="text-align:center">'+due_date+'</td>';
                html += '<td>'+no_inv+'</td>';
                html += '<td style="text-align:center">'+currency+'</td>';
                html += '<td style="text-align:right">' +total+ '</td>';
                html += '<td style="text-align:right">' + paid + '</td>';
                html += '<td style="text-align:center">'+age+'</td>';
                html += '<td style="text-align:right">' + overdue_1_14+'</td>';
                html += '<td style="text-align:right">' +overdue_15_30 + '</td>';
                html += '<td style="text-align:right">' + overdue_31_60 + '</td>';
                html += '<td style="text-align:right">' + overdue_60 + '</td>';
                html += '<td style="text-align:right">' + in_1_weeks+ '</td>';
                html += '<td style="text-align:right">' + in_2_weeks + '</td>';
                html += '<td style="text-align:right">' + on_schedule + '</td>';
                html += '<td style="text-align:right">' + total_idr + '</td>';
                html += '<td style="display:none">' + item.internal_notes + '</td>';
                html += '</tr>';
                if (item.internal_notes != null) {
                    html += '<tr>';
                    html += '<td colspan="100%"><small>Notes : <i>'+item.internal_notes+'<i></small></td>';
                    html += '</tr>';
                }

            });
            html += '</tbody>'
            $("#tableSupplierSOA").html(html);
            setTimeout(function () {
                $("#overlay").fadeOut(300);
            }, 500);
        }
    });
}

$('#tableSupplierSOA').on('dblclick tbody', 'tr', function (e) {
    
     $("#snmInvoice").val($(this).closest("tr").children("td:eq(1)").text());
    if ($(this).closest("tr").children("td:eq(17)").text() != 'null') {
        $("#snmInNotes").html($(this).closest("tr").children("td:eq(17)").text());
    } else {
        $("#snmInNotes").html('');
    }
    
    $("#supplierNotesModal").modal("show");

})

$("#supplierNote_save").on("click", function (e) {
    var soaType = 'supplier';
    var snmInvoice = $("#snmInvoice").val();
    var snmInNotes = $("#snmInNotes").val();
    let _token = $("input[name=_token]").val();
    $.ajax({
        type: 'POST',
        url: rute_internal_notes,
        data: {
                soaType: soaType,
                snmInvoice: snmInvoice,
                snmInNotes: snmInNotes,
                _token: _token
            },
        dataType: 'json',
        success: function (data) {
            Toast.fire({
                icon: "success",
                title: "Successfully save data",
            });
        }
    });
    $("#supplierNotesModal").modal("hide");
    $("#processFilter").trigger("click");
    
});

function dt_customer() {
    var table = $(".tbl_customer").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        stateSave: false,
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
            url: get_customer +"/0",
            type: "GET",
            dataType: "JSON",
        },
        columns: [{
                data: "ID_CUST",
                render: function (data, type, row) {
                    return cbCustomer(data, type, row);
                },
                orderable: false,
                className: "text-center",
            },{
                data: "ID_CUST",
                name: "ID_CUST",
            },
            {
                data: "NM_CUST",
                name: "NM_CUST",
            },
            {
                data: "ALAMAT1",
                name: "ALAMAT1",
            },
            
        ],
        order: [
            [1, "asc"]
        ],
    });
}

window.cbCustomer = function (data, tyoe, row) {
    var action_view = '<input type="checkbox" value="Y">';
    return action_view;
};


$("#customer_modal").on("click", function (e) {
    e.preventDefault();
    var nilai = $("#customer").val();
    if (!nilai.includes('||')) {
        nilai += '||';
    }
    var arr_nilai = nilai.split("||");
    var table = $(".tbl_customer tbody");
    table.find("tr").each(function (i, el) {
        var tds = $(this).find("td");
        var kode = tds.eq(1).text().trim();
        var inp = $(this).find("input");
        inp.prop( "checked", false );
        for (var j = 0; j < arr_nilai.length - 1; j++) {
            if (kode == arr_nilai[j]) {
                inp.prop( "checked", true );
            }
        }
    });
    $("#customerModal").modal("show");
});

$("#customer_save").on("click", function (e) {
    e.preventDefault();
    var table = $(".tbl_customer tbody");
    var customer = "";
    table.find("tr").each(function (i, el) {
        var tds = $(this).find("td");
        var kode = tds.eq(1).text().trim();
        var inp = $(this).find("input");
        var cek = inp.eq(0).val();
        if (inp.eq(0).is(":checked")) {
            customer += kode + "||";
        }
    });
    $("#customer").val(customer);
    $("#customerModal").modal("hide");
});

function dt_so() {
    var table = $(".tbl_so").DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
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
            url: get_salesOrder ,
            type: "GET",
            dataType: "JSON",
        },
        columns: [{
                data: "NO_BUKTI",
                render: function (data, type, row) {
                    return cbSo(data, type, row);
                },
                orderable: false,
                className: "text-center",
            },{
                data: "NO_BUKTI",
                name: "NO_BUKTI",
                width: "10%",
            },
            {
                data: "TGL_BUKTI",
                name: "TGL_BUKTI",
                width: "5%",
                render: function (data, type, row) {
                    return moment(data).format("DD MMM YYYY");
                },
            },
            {
                data: "ID_SALES",
                name: "ID_SALES",
                width: "10%",
            },
            {
                data: "NM_SALES",
                name: "NM_SALES",
                width: "10%",
            },
            {
                data: "ID_CUST",
                name: "ID_CUST",
                width: "10%",
            },
            {
                data: "NM_CUST",
                name: "NM_CUST",
                width: "20%",
            },
            {
                data: "TEMPO",
                name: "TEMPO",
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
                data: "PO_CUST",
                name: "PO_CUST",
            },
            {
                data: "jenis",
                name: "jenis",
            },
            {
                data: "no_ref",
                name: "no_ref",
            },
            {
                data: "DIVISI",
                name: "DIVISI",
            },
            {
                data: "total_rp",
                name: "total_rp",
                className: "dt-body-right",
                width: "10%",
                render: function (data, type, row) {
                    return addPeriod(parseFloat(data).toFixed(2), ",");
                },
            },
        ],
        order: [
            [1, "asc"]
        ],
    });
}

window.cbSo = function (data, tyoe, row) {
    var action_view = '<input type="checkbox" value="Y">';
    return action_view;
};

$("#so_modal").on("click", function (e) {
    e.preventDefault();
    var nilai = $("#so").val();
    if (!nilai.includes('||')) {
        nilai += '||';
    }
    console.log(nilai);
    var arr_nilai = nilai.split("||");
    var table = $(".tbl_so tbody");
    table.find("tr").each(function (i, el) {
        var tds = $(this).find("td");
        var kode = tds.eq(1).text().trim();
        var inp = $(this).find("input");
        inp.prop( "checked", false );
        for (var j = 0; j < arr_nilai.length - 1; j++) {
            if (kode == arr_nilai[j]) {
                inp.prop( "checked", true );
            }
        }
    });
    $("#soModal").modal("show");
});

$("#so_save").on("click", function (e) {
    e.preventDefault();
    var table = $(".tbl_so tbody");
    var so = "";
    table.find("tr").each(function (i, el) {
        var tds = $(this).find("td");
        var kode = tds.eq(1).text().trim();
        var inp = $(this).find("input");
        var cek = inp.eq(0).val();
        if (inp.eq(0).is(":checked")) {
            so += kode + "||";
        }
    });
    $("#so").val(so);
    $("#soModal").modal("hide");
});

function dt_sales() {
    var table = $(".tbl_sales").DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
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
            url: get_sales+'/0' ,
            type: "GET",
            dataType: "JSON",
        },
        columns: [{
                data: "ID_SALES",
                render: function (data, type, row) {
                    return cbSales(data, type, row);
                },
                orderable: false,
                className: "text-center",
            },{
                data: "ID_SALES",
                name: "ID_SALES",
                width: "10%",
            },
            {
                data: "NM_SALES",
                name: "NM_SALES",
                width: "5%",
            },
            
        ],
        order: [
            [1, "asc"]
        ],
    });
}

window.cbSales = function (data, tyoe, row) {
    var action_view = '<input type="checkbox" value="Y">';
    return action_view;
};

$("#sales_modal").on("click", function (e) {
    e.preventDefault();
    var nilai = $("#sales").val();
    if (!nilai.includes('||')) {
        nilai += '||';
    }
    var arr_nilai = nilai.split("||");
    var table = $(".tbl_sales tbody");
    table.find("tr").each(function (i, el) {
        var tds = $(this).find("td");
        var kode = tds.eq(1).text().trim();
        var inp = $(this).find("input");
        inp.prop( "checked", false );
        for (var j = 0; j < arr_nilai.length - 1; j++) {
            if (kode == arr_nilai[j]) {
                inp.prop( "checked", true );
            }
        }
    });
    $("#salesModal").modal("show");
});

$("#sales_save").on("click", function (e) {
    e.preventDefault();
    var table = $(".tbl_sales tbody");
    var sales = "";
    table.find("tr").each(function (i, el) {
        var tds = $(this).find("td");
        var kode = tds.eq(1).text().trim();
        var inp = $(this).find("input");
        var cek = inp.eq(0).val();
        if (inp.eq(0).is(":checked")) {
            sales += kode + "||";
        }
    });
    $("#sales").val(sales);
    $("#salesModal").modal("hide");
    
});

$("#overdueCustomer_modal").on("click", function (e) {
    e.preventDefault();
    var nilai = $("#overdueCustomer").val();
    if (!nilai.includes('||')) {
        nilai += '||';
    }
    var arr_nilai = nilai.split("||");
    var table = $(".tbl_overdueCustomer tbody");
    table.find("tr").each(function (i, el) {
        var tds = $(this).find("td");
        var kode = tds.eq(1).text().trim();
        var inp = $(this).find("input");
        inp.prop( "checked", false );
        for (var j = 0; j < arr_nilai.length - 1; j++) {
            if (kode == arr_nilai[j]) {
                inp.prop( "checked", true );
            }
        }
    });
    $("#modalOverdueCustomer").modal("show");
});

$("#overdueCustomer_save").on("click", function (e) {
    e.preventDefault();
    var table = $(".tbl_overdueCustomer tbody");
    var overdue = "";
    table.find("tr").each(function (i, el) {
        var tds = $(this).find("td");
        var kode = tds.eq(1).text().trim();
        var inp = $(this).find("input");
        var cek = inp.eq(0).val();
        if (inp.eq(0).is(":checked")) {
            overdue += kode + "||";
        }
    });
    $("#overdueCustomer").val(overdue);
    $("#modalOverdueCustomer").modal("hide");
    
});

function dt_supplier() {
    var table = $(".tbl_supplier").DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
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
            url: get_supplier+'/0' ,
            type: "GET",
            dataType: "JSON",
        },
        columns: [{
                data: "id_supplier",
                render: function (data, type, row) {
                    return cbSupplier(data, type, row);
                },
                orderable: false,
                className: "text-center",
            },{
                data: "id_supplier",
                name: "id_supplier",
                width: "10%",
            },
            {
                data: "nm_supplier",
                name: "nm_supplier",
                width: "5%",
            },
            {
                data: "TELP",
                name: "TELP",
                width: "5%",
            },
            {
                data: "ALAMAT1",
                name: "ALAMAT1",
                width: "5%",
            },
        ],
        order: [
            [1, "asc"]
        ],
    });
}

window.cbSupplier= function (data, tyoe, row) {
    var action_view = '<input type="checkbox" value="Y">';
    return action_view;
};

$("#supplier_modal").on("click", function (e) {
    e.preventDefault();
    var nilai = $("#supplier").val();
    if (!nilai.includes('||')) {
        nilai += '||';
    }
    var arr_nilai = nilai.split("||");
    var table = $(".tbl_supplier tbody");
    table.find("tr").each(function (i, el) {
        var tds = $(this).find("td");
        var kode = tds.eq(1).text().trim();
        var inp = $(this).find("input");
        inp.prop( "checked", false );
        for (var j = 0; j < arr_nilai.length - 1; j++) {
            if (kode == arr_nilai[j]) {
                inp.prop( "checked", true );
            }
        }
    });
    $("#supplierModal").modal("show");
});

$("#supplier_save").on("click", function (e) {
    e.preventDefault();
    var table = $(".tbl_supplier tbody");
    var supplier = "";
    table.find("tr").each(function (i, el) {
        var tds = $(this).find("td");
        var kode = tds.eq(1).text().trim();
        var inp = $(this).find("input");
        var cek = inp.eq(0).val();
        if (inp.eq(0).is(":checked")) {
            supplier += kode + "||";
        }
    });
    $("#supplier").val(supplier);
    $("#supplierModal").modal("hide");
    
});

function dt_inventory() {
    var table = $(".tbl_inventory").DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
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
            url: get_inventory+'/1/all/all' ,
            type: "GET",
            dataType: "JSON",
        },
        columns: [{
                    data: "no_stock",
                    render: function (data, type, row) {
                        return cbInventory(data, type, row);
                    },
                    orderable: false,
                    className: "text-center",
                },{
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
        ],
        order: [
            [1, "asc"]
        ],
    });
}

window.cbInventory= function (data, tyoe, row) {
    var action_view = '<input type="checkbox" value="Y">';
    return action_view;
};

$("#inventory_modal").on("click", function (e) {
    e.preventDefault();
    var nilai = $("#inventory").val();
    if (!nilai.includes('||')) {
        nilai += '||';
    }
    var arr_nilai = nilai.split("||");
    var table = $(".tbl_inventory tbody");
    table.find("tr").each(function (i, el) {
        var tds = $(this).find("td");
        var kode = tds.eq(1).text().trim();
        var inp = $(this).find("input");
        inp.prop( "checked", false );
        for (var j = 0; j < arr_nilai.length - 1; j++) {
            if (kode == arr_nilai[j]) {
                inp.prop( "checked", true );
            }
        }
    });
    $("#inventoryModal").modal("show");
});

$("#inventory_save").on("click", function (e) {
    e.preventDefault();
    var table = $(".tbl_inventory tbody");
    var inventory = "";
    table.find("tr").each(function (i, el) {
        var tds = $(this).find("td");
        var kode = tds.eq(1).text().trim();
        var inp = $(this).find("input");
        var cek = inp.eq(0).val();
        if (inp.eq(0).is(":checked")) {
            inventory += kode + "||";
        }
    });
    $("#inventory").val(inventory);
    $("#inventoryModal").modal("hide");
    
});

$("#overdueSupplier_modal").on("click", function (e) {
    e.preventDefault();
    var nilai = $("#overdueSupplier").val();
    if (!nilai.includes('||')) {
        nilai += '||';
    }
    var arr_nilai = nilai.split("||");
    var table = $(".tbl_overdueSupplier tbody");
    table.find("tr").each(function (i, el) {
        var tds = $(this).find("td");
        var kode = tds.eq(1).text().trim();
        var inp = $(this).find("input");
        inp.prop( "checked", false );
        for (var j = 0; j < arr_nilai.length - 1; j++) {
            if (kode == arr_nilai[j]) {
                inp.prop( "checked", true );
            }
        }
    });
    $("#modalOverdueSupplier").modal("show");
});

$("#overdueSupplier_save").on("click", function (e) {
    e.preventDefault();
    var table = $(".tbl_overdueSupplier tbody");
    var overdue = "";
    table.find("tr").each(function (i, el) {
        var tds = $(this).find("td");
        var kode = tds.eq(1).text().trim();
        var inp = $(this).find("input");
        var cek = inp.eq(0).val();
        if (inp.eq(0).is(":checked")) {
            overdue += kode + "||";
        }
    });
    $("#overdueSupplier").val(overdue);
    $("#modalOverdueSupplier").modal("hide");
    
});