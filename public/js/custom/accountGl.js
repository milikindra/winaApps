var get_accountGl = "generalLedger/data/populateAccount";

function filterGlHead() {
    var str = '';
    str += '<table class="table gl_account table-modal" id="gl_account" style="width: 100%;">';
    str += '<thead><tr><th style="width:30%">Account</th><th style="width:70%">Name</th></tr></thead>';
    str += '<tbody class="filterGlBody"></tbody>';
    str += '</table>';
    // str += '<table width="100%"><tr><td style="width: 50%;">';
    // str += '<a href="javascript:void(0)" onclick="removeGlAccount(this)" class="btn btn-xs btn-warning float-right" title="remove row"><i class="fa fa-minus"></i></a>';
    // str += '<a href="javascript:void(0)" onclick="addGlAccount(this)" class="btn btn-xs btn-info float-right" title="add row"><i class="fa fa-plus"></i></a>';
    // str += '</td></tr></table>';
    $(".filterGlHead").append(str);
    addGlAccount();
}

function addGlAccount() {
    var indexs = $(".filterGlBody tr").length;
    var str = '';
    str += '<tr><td><input type="text" class="form-control form-control-sm" name="gl_code[]" id="gl_code-' + indexs + '" onclick="modalGl(' + indexs + ')"></td>';
    str += '<td><input type="text" class="form-control form-control-sm" name="gl_value[]" id="gl_value-' + indexs + '" onclick="modalGl(' + indexs + ')"></td></tr>';
    $(".filterGlBody").append(str);
}

function removeGlAccount() {
    $(".filterGlBody tr:last").remove();
}

arr = [];

function modalGl(uid) {
    arr.push(uid);
    $("#modalAccountGl").modal("show");
    tableModalGl();
    $("#tableModalGl").on("click", "tbody tr", function () {
        if (uid == arr[arr.length - 1]) {
            no_rek = $(this).closest("tr").children("td:eq(0)").text();
            nm_rek = $(this).closest("tr").children("td:eq(1)").text();
            sat = $(this).closest("tr").children("td:eq(2)").text();
            document.getElementById("gl_code-" + uid).value = no_rek;
            document.getElementById("gl_value-" + uid).value = nm_rek;
        }
        $("#modalAccountGl").modal("hide");
    });
}

function tableModalGl() {
    $("#tableModalGl").DataTable().clear().destroy();
    var table = $("#tableModalGl").DataTable({
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
            url: get_accountGl,
            type: "GET",
            dataType: "JSON",
        },
        columns: [{
                data: "no_rek",
                name: "no_rek",
            },
            {
                data: "nm_rek",
                name: "nm_rek",
            },

        ],
        order: [
            [0, "asc"]
        ],
    });
}
