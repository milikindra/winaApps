var get_salesOrder = "salesOrder/data/populateHead";
var rute_pnlProject = "getPnlProject";


arr = [];

function modalSo() {
    // arr.push(uid);
    $("#modalSO").modal("show");
    tabelModalSo();
    $("#tabelModalSo").one("click", "tbody tr", function () {
        no_so = $(this).closest("tr").children("td:eq(0)").text();
        $("#so_id").val(no_so);

        var str = "";
        str += "<small>";
        str += "SO Date : " + $(this).closest("tr").children("td:eq(1)").text();
        str += "<br/>Customer : " + $(this).closest("tr").children("td:eq(5)").text();
        str += "<br/>SO Type : " + $(this).closest("tr").children("td:eq(10)").text();
        str += "<small>";

        $("#so_descrription").html(str);
        $("#so_descrription").css('display', 'block');
        $("#so_id").trigger("change");
        $("#modalSO").modal("hide");
    });
}

function tabelModalSo() {
    $("#tabelModalSo").DataTable().clear().destroy();
    var table = $("#tabelModalSo").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
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
            url: get_salesOrder,
            type: "GET",
            dataType: "JSON",
        },
        columns: [{
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
            [0, "asc"]
        ],
    });
}


function getPnlProject() {
    var so_id = $('#so_id').val();
    $.ajax({
        type: "GET",
        dataType: "html",
        url: rute_pnlProject + '/' + so_id,
        success: function (hasil) {
            $("#filterCommision tbody").empty();
            var a = $.parseJSON(hasil);
            var rowCount = 0;
            $.each(a.body, function (i, item) {
                var str = '';
                str += "<tr>";
                str += ' <td> <input type="text" class="form-control form-control-sm" name="commision_desc[]" id="commision_desc-' + rowCount + '" value="' + item.ket + '">  </td>';
                if (item.nilai == '0.00') {
                    str += '<td> <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="commision_value[]" id="commision_value-' + rowCount + '" value="' + item.rate + '"> </td>';
                    str += '<td><select class="form-control form-control-sm selects2" name="commision_type[]" id="commision_type-' + rowCount + '"> <option value = "prosen" selected>%</option><option value = "idr"> IDR</option></select></td>';
                } else {
                    str += '<td> <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="commision_value[]" id="commision_value-' + rowCount + '" value="' + item.nilai + '"> </td>';
                    str += '<td><select class="form-control form-control-sm selects2" name="commision_type[]" id="commision_type-' + rowCount + '"> <option value = "prosen">%</option><option value = "idr" selected> IDR</option></select></td>';
                }
                str += "</tr>";

                $(".filterCommision").append(str);
                rowCount++;
            });

            $.each(a.so, function (i, item) {
                $("#notePh").html(item.note_ph);
            });



        },
    });


}
