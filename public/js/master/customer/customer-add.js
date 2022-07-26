$(document).ready(function () {
    window.customerEdit = function (element) {
        resetCustomer();
        var kode = $(element).data("customer");
        $.ajax({
            url: rute_edit + "/" + kode,
            type: "GET",
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                $("#kodeOld").val(kode);
                $("#kode").val(kode);
                $("#full_name").val(response.data.NM_CUST);
                if (response.data.aktif == "Y") {
                    $("#aktif").prop("checked", true);
                } else {
                    $("#aktif").prop("checked", false);
                }
                $("#address").val(response.data.ALAMAT1);
                $("#telp").val(response.data.TELP);
                $("#fax").val(response.data.FAX);
                $("#tempo").val(response.data.TEMPO);
                $("#limit").val(response.data.PLAFON);
                $("#sales")
                    .select2()
                    .val(response.data.ID_SALES)
                    .trigger("change");
                $("#type")
                    .val(response.data.tipeCustomer)
                    .trigger("change");
                $("#area")
                    .select2()
                    .val(response.data.AREA)
                    .trigger("change");
                $("#curr").val(response.data.curr);
                $("#tax_code").val(response.data.KodePajak);
                if (response.data.isWapu == "Y") {
                    $("#wapu").prop("checked", true);
                } else {
                    $("#wapu").prop("checked", false);
                }
                if (response.data.isBerikat == "Y") {
                    $("#berikat").prop("checked", true);
                } else {
                    $("#berikat").prop("checked", false);
                }
                $("#address_company").val(response.data.al_fac);
                $("#district_company").val(response.data.kecamatan_fac);
                $("#city_company").val(response.data.kabupaten_fac);
                $("#province_company").val(response.data.propinsi_fac);
                $("#phone_company").val(response.data.telp_fac);
                $("#fax_company").val(response.data.fax_fac);
                $("#tax_number").val(response.data.NO_NPWP);
                $("#tax_name").val(response.data.nama_npwp);
                $("#tax_address").val(response.data.al_npwp);
                $("#tax_nationalityId").val(response.data.no_ktp);
                $("#type_of_bussiness").val(response.data.usaha);
                $("#description_bussiness").val(response.data.keterangan);

                jQuery.each(response.branch, function (i, val) {
                    addRowChild();
                    $('#branch_name-' + i).val(val.address_alias);
                    $('#branch_address-' + i).val(val.other_address);
                    $('#branch_tax_number-' + i).val(val.tax_number);
                });
            },
            error: function (xhr, textStatus, ThrownException) {
                console.log(
                    "Error loading data. Exception: " +
                    ThrownException +
                    "\n" +
                    textStatus
                );
            },
        });

        $('#formCustomer').prop('action', update_customer);
        $("#customerModal").modal("show");
    }


    $('#btnAddSave').on('click', function (e) {
        if ($('#kode').val() != '') {
            if ($('#kodeOld').val() != '') {
                e.preventDefault();
                var form = $(this).parents('form');
                Swal.fire({
                    title: "Are you sure?",
                    text: "This action maybe change customer data",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#17a2b8",
                    cancelButtonColor: "#FFC107",
                    confirmButtonText: "Yes, Process it!",
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#formCustomer').prop('action', update_customer);
                        form.submit();
                    }
                });
            } else {
                $('#formCustomer').prop('action', save_customer);
                form.submit();
            }
        }
    });
});
function addRowChild() {
    var rowCount = $(".trxBranch tr").length - 1;
    $(".trxBranch").append(
        '<tr> <td> <input type="text" class="form-control form-control-sm" name="branch_name[]" id="branch_name-' +
        rowCount +
        '"> </td><td> <textarea class="form-control form-control-sm" rows="1" name="branch_address[]" id="branch_address-' +
        rowCount +
        '" ></textarea> </td><td> <input type="text" class="form-control form-control-sm" name="branch_tax_number[]" autocomplete="off"  id="branch_tax_number-' +
        rowCount +
        '"> </td></tr > '
    );
}

function removeRowChild() {
    $(".trxBranch tr:last").remove();
}
function customerAdd() {
    resetCustomer();
    $('#titleInventory').html('Add Customer')
    $('#formCustomer').prop('action', save_customer);
    $("#customerModal").modal("show");
}


function resetCustomer() {
    $(".trxBranch tbody tr").remove();
    document.getElementById("formCustomer").reset();
    $("#sales")
        .select2()
        .val('')
        .trigger("change");
    $("#area").prop("selectedIndex", 0).trigger("change");
}
