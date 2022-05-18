$(".selects2").select2();

$(document).ready(function () {
    $("#reportType").prop("selectedIndex", 1).trigger("change");
    filterReport();
    $("#reportType").change(function () {
        filterReport();
    });

    function filterReport() {
        var reportType = $("#reportType").val();
        if (reportType == "appPosisiStok") {
            $("#appPosisiStok").css("display", "block");
            $("#type").val("appPosisiStok");
        } else {
            $("#appPosisiStok").css("display", "none");
        }
    }
});
