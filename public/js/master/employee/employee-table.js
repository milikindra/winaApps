$(document).ready(function () {
    var table = $("#datatables").DataTable({
        processing: true,
        serverSide: true,
        // drawCallback: function (settings, json) {},
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
                data: "gender",
                name: "gender",
            },
            {
                data: "blood_type",
                name: "blood_type",
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
                data: "sim_type",
                name: "sim_type",
            },
            {
                data: "ptkp_type",
                name: "ptkp_type",
            },
            {
                data: "tax_id",
                name: "tax_id",
            },

            // {
            //     data: "qty",
            //     name: "qty",
            //     render: function (data, type, row) {
            //         return addPeriod(parseFloat(data).toFixed(2), ",");
            //     },
            // },
            // {
            //     data: "qty",
            //     name: "qty",
            //     render: function (data, type, row) {
            //         return addPeriod(parseFloat(data).toFixed(2), ",");
            //     },
            // },
            // {
            //     data: "qty",
            //     name: "qty",
            //     render: function (data, type, row) {
            //         return addPeriod(parseFloat(data).toFixed(2), ",");
            //     },
            // },
            // {
            //     data: "qty",
            //     name: "qty",
            //     render: function (data, type, row) {
            //         return addPeriod(parseFloat(data).toFixed(2), ",");
            //     },
            // },
            // {
            //     data: "qty",
            //     name: "qty",
            //     render: function (data, type, row) {
            //         return addPeriod(parseFloat(data).toFixed(2), ",");
            //     },
            // },
            // {
            //     data: "qty",
            //     name: "qty",
            //     render: function (data, type, row) {
            //         return addPeriod(parseFloat(data).toFixed(2), ",");
            //     },
            // },
            {
                data: "user_id",
                render: function (data, type, row) {
                    return getActions(data, type, row);
                },
                orderable: false,
            },
        ],
        // order: [[0, "desc"]],
    });

    window.getActions = function (data, tyoe, row) {
        var action_view =
            '<a href="' +
            url_default +
            "/memoInDetail/" +
            data +
            '" title="Lihat Detail" class="btn btn-icon btn-info" style="margin-right: 5px;"><i class="fas fa-search"></i></a>';
        action_view +=
            '<a href="' +
            url_default +
            "/memoInEdit/" +
            data +
            '" title="Edit" class="btn btn-icon btn-warning" style="margin-right: 5px;"><i class="fas fa-edit"></i></a>';
        if (row["void"] == 0) {
            action_view +=
                '<button onclick="memoInVoid(this)" data-memo_id="' +
                data +
                '" title="Void" class="btn btn-icon btn-danger" style="margin-right: 5px;"><i class="fas fa-times"></i></button>';
        } else {
            action_view +=
                '<button onclick="memoInActive(this)" data-memo_id="' +
                data +
                '" title="UnVoid" class="btn btn-icon btn-primary" style="margin-right: 5px;"><i class="fas fa-check"></i></button>';
        }

        return action_view;
    };
});
