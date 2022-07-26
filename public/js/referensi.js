
// CONTEXT MENU ON TABEL
$(function () {
    $.contextMenu({
        selector: '.trx tbody tr',
        callback: function (key, options) {
            var m = "clicked: " + key;
            var indexs_row = $(this).closest("tr").children("td:first").children().attr('id').substring(9);
            //     console.log($(this).closest("tr").children("td:first").children().val());
            if (key == 'cancel') {
                console.log($(this).closest("tr").children("td:first").children().val());
            } else if (key == 'finish') {
                console.log($(this).closest("tr").html());
            }
            // console.log("Clicked on " + key + " on element " + e);
        },
        items: {
            "cancel": { name: "Cancel" },
            "finish": { name: "Finish" },
        }
    });
});