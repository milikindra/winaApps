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
            url: rute + "/" + 1,
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
            data: "employee_id",
            name: "employee_id",
            className: "text-center",
        },
        {
            data: "full_name",
            name: "full_name",
        },
        {
            data: "national_id",
            name: "national_id",
            className: "text-center",
        },
        {
            data: "dob",
            name: "dob",
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
            data: "blood_type",
            name: "blood_type",
            className: "text-center",
        },
        {
            data: "religion",
            name: "religion",
            className: "text-center",
        },
        {
            data: "address",
            name: "address",
            className: "text-center",
        },
        {
            data: "phone",
            name: "phone",
            className: "text-center",
        },
        {
            data: "department",
            name: "department",
            className: "text-center",
        },
        {
            data: "user_id",
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
        var action_view ='<a href="' +url_default +"/employeeDetail/" +data +'" title="View Detail" class="btn btn-xs btn-info" style="margin-right: 5px;color:white"><i class="fa fa-search"></i></a>';
        action_view +=
            '<a href="' +
            url_default +
            "/employeeEdit/" +
            data +
            '" title="Edit" class="btn btn-xs btn-warning" style="margin-right: 5px;color:white"><i class="fa fa-edit"></i></a>';

        return action_view;
    };
});
