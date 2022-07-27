$(document).ready(function () {
    var table = $("#datatables").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        stateSave: false,
        lengthMenu: [
            [50, 100, 250, 500, 1000],
            [50, 100, 250, 500, 1000],
        ],
        buttons: ["excel", "print"],
        dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        drawCallback: function (settings, json) { },
        ajax: {
            url: rute + "/all",
            type: "GET",
            dataType: "JSON",
            error: function (xhr, textStatus, ThrownException) {
                alert(
                    "Error loading data. Exception: " +
                    ThrownException +
                    "\n" +
                    textStatus
                );
            },
        },
        columns: [{
            data: "kode",
            name: "kode",
            className: "text-center",
        },
        {
            data: "keterangan",
            name: "keterangan",
        },
        {
            data: "prosen",
            name: "prosen",
            className: "text-center",
        },
        {
            data: "effective_date",
            name: "effective_date",
            render: function (data, type, row) {
                if (data != null) {
                    return moment(data).format("DD/MM/YYYY");
                } else {
                    return '-'
                }
            },
            className: "text-center",
        },
        {
            data: "kode",
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

    window.getActions = function (data, tyoe, row) {
        var action_view =
            '<a href="' +
            url_default +
            "/vatEdit/" +
            data +
            '" title="Edit" class="btn btn-xs btn-warning" style="margin-right: 5px;color:white"><i class="fa fa-edit"></i></a>';

        return action_view;
    };
});
