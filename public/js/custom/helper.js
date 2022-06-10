$(document).ready(function () {
    $(document).on("select2:open", () => {
        document
            .querySelector(".select2-container--open .select2-search__field")
            .focus();
    });

    $(document).on("keydown", ".input-numerical", function (e) {
        if (
            (e.key >= "0" && e.key <= "9") || ["Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab"].includes(
                e.key
            )
        ) {} else {
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
    $(function () {
        $(".datepicker").datepicker({
            dateFormat: "dd/mm/yy"
        }).val();
    });
});
