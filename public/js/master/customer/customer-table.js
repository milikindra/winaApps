$(document).ready(function () {
    $(".selects2").select2();
    var Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
    });

    function dt() {
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

                className: "btn-info",
            },
            {
                extend: "excel",
                className: "btn-info",
            },
            {
                extend: "pdf",
                className: "btn-info",
            }
            ],

            dom: "<'row'<'col-sm-12'B>>" +
                "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            drawCallback: function (settings, json) { },
            ajax: {
                url: rute + '/1',
                type: "GET",
                dataType: "JSON",
            },
            columns: [{
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
            {
                data: "KodePajak",
                name: "KodePajak",
                className: "dt-body-right",
            },
            {
                data: "TEMPO",
                name: "TEMPO",
                className: "dt-body-right",
            },
            {
                data: "ID_SALES",
                name: "ID_SALES",
            },
            {
                data: "NO_NPWP",
                name: "NO_NPWP",
            },
            {
                data: "no_ktp",
                name: "no_ktp",
            },
            {
                data: "ID_CUST",
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
    dt();
    window.getActions = function (data, tyoe, row) {
        var action_view =
            '<button onclick="customerEdit(this)" data-customer="' +
            data +
            '" title="Edit" class="btn btn-sm btn-icon btn-warning" style="margin-right: 5px;"><i class="fa fa-edit"></i></button>';
        return action_view;
    };
});
