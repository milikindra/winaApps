$(document).ready(function () {
    // window.onerror = function (message, url, lineNumber) {
    // return true; 
    // };
    // $(document).on("select2:open", () => {
    //     document
    //         .querySelector(".select2-container--open .select2-search__field")
    //         .focus();
    // });

    $(document).on("keydown", ".input-numerical", function (e) {
        if (
            (e.key >= "0" && e.key <= "9") || ["Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab"].includes(
                e.key
            )
        ) { } else {
            e.preventDefault();
        }
    });
    $(".numaja").keypress(function (e) {
        if ((e.charCode >= 48 && e.charCode <= 57) || e.charCode == 0)
            return true;
        else return false;
    });
    $(".numajaDesimal").keypress(function (e) {
        if (
            (e.charCode >= 48 && e.charCode <= 57) ||
            e.charCode == 0 ||
            e.charCode == 46
        )
            return true;
        else return false;
    });
    // $(function () {
    //     $(".datepicker").datepicker({
    //         dateFormat: "dd/mm/yy"
    //     }).val();
    // });
});

function dtModalInventory(voids, kategori, subkategori, um) {
    var table = $("#dtModalInventory").DataTable({
        scrollY: 400,
        scrollCollapse: true,
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
        drawCallback: function (settings, json) { },
        ajax: {
            url: get_inventory +
                "/" +
                voids +
                "/" +
                kategori +
                "/" +
                subkategori + "/" + um,
            type: "GET",
            dataType: "JSON",
        },
        columns: [{
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
            className: "dt-body-center",
        },
        {
            data: "kodeBJ",
            name: "kodeBJ",
            className: "dt-body-center",
            render: function (data, type, row) {
                if (data == 'I') {
                    return 'Item';
                } else {
                    return 'Group';
                }
            },
        },
        {
            data: "kodeBJ",
            name: "kodeBJ",
            className: "hidden",
        },
        {
            data: "VINTRASID",
            name: "VINTRASID",
            className: "hidden",
            render: function (data, type, row) {
                return data;
            },
        },
        {
            data: "TAHUN",
            name: "TAHUN",
            className: "hidden",
        },
        {
            data: "merk",
            name: "merk",
            className: "hidden",
        },
        ],
        order: [
            [0, "asc"]
        ],
    });
}
