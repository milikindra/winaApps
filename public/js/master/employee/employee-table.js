$(document).ready(function () {
    var table = $("#datatables").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [
            [1, 25, 50, 100, 250, 500, 1000],
            [1, 25, 50, 100, 250, 500, 1000],
        ],
        drawCallback: function (settings, json) {},
        ajax: {
            url: rute + "/" + 0,
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
        columns: [
            {
                data: "employee_id",
                name: "employee_id",
            },
            {
                data: "full_name",
                name: "full_name",
            },
            {
                data: "national_id",
                name: "national_id",
            },
            {
                data: "dob",
                name: "dob",
                render: function (data, type, row) {
                    return moment(data).format("DD MMM YYYY");
                },
            },
            {
                data: "blood_type",
                name: "blood_type",
            },
            {
                data: "religion",
                name: "religion",
            },
            {
                data: "address",
                name: "address",
            },
            {
                data: "phone",
                name: "phone",
            },

            {
                data: "user_id",
                render: function (data, type, row) {
                    return getActions(data, type, row);
                },
                orderable: false,
            },
        ],
        order: [[0, "asc"]],
    });

    window.getActions = function (data, tyoe, row) {
        var action_view =
            '<a href="' +
            url_default +
            "/employeeDetail/" +
            data +
            '" title="Lihat Detail" class="btn btn-sm btn-flat btn-info" style="margin-right: 5px;color:white"><i class="fa fa-search"></i></a>';
        action_view +=
            '<a href="' +
            url_default +
            "/employeeEdit/" +
            data +
            '" title="Edit" class="btn btn-sm btn-flat btn-warning" style="margin-right: 5px;color:white"><i class="fa fa-edit"></i></a>';

        return action_view;
    };
});
