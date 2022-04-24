$(document).ready(function () {
    var table = $("#datatables").DataTable({
        processing: true,
        serverSide: true,
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
            "/memoInDetail/" +
            data +
            '" title="Lihat Detail" class="btn btn-outline-info" style="margin-right: 5px;"><i class="ti ti-search"></i></a>';
        action_view +=
            '<a href="' +
            url_default +
            "/memoInEdit/" +
            data +
            '" title="Edit" class="btn btn-outline-warning" style="margin-right: 5px;"><i class="ti ti-pencil"></i></a>';
        action_view +=
            '<button onclick="memoInActive(this)" data-memo_id="' +
            data +
            '" title="UnVoid" class="btn btn-outline-primary" style="margin-right: 5px;"><i class="ti ti-check"></i></button>';

        return action_view;
    };
});
