@extends('template.main-template')

@section('main-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5 class="m-0">{{ $title }}</h5>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<form action="{{ route('salesInvoiceAddSave') }}" id="salesInvoiceAddSave" method="POST" enctype="multipart/form-data">
    @csrf
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="card-title">Add Sales Invoice</h3>
                                    <div class="card-tools float-right">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-2">
                                    <!-- checkbox -->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <datalist id="customerList">
                                                </datalist>
                                                <label>Customer</label>
                                                <input type="hidden" name="customer_name" id="customer_name" autocomplete="off" required>
                                                <input type="hidden" name="customer" id="customer" autocomplete="off" required>
                                                <input class="form-control form-control-sm form-control-border" list="customerList" id="customerSearch" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>SO</label>
                                                <div class="input-group">
                                                    <input type="hidden" class="" id="cust_so" name="cust_so">
                                                    <input type="text" class="form-control form-control-sm form-control-border" id="so_id" name="so_id" readonly>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-sm btn-info" onclick="getSo()"><i class="fas fa-search"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Due</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control form-control-sm form-control-border" name="tempo" id="tempo" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Days</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Pay.Term</label>
                                                <input type="text" class="form-control form-control-sm form-control-border" name="payterm" id="payterm">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Currency</label>
                                                <input type="text" class="form-control form-control-sm form-control-border" name="curr" id="curr" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Rate Rp.</label>
                                                <input type="text" class="form-control form-control-sm form-control-border" name="rate_cur" id="rate_cur" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Date</label>
                                                <input type="date" class="form-control form-control-sm form-control-border" name="date_order" id="date_order" value="{{date('Y-m-d')}}" required onchange="getTax()">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="use_dp" id="use_dp" onchange="useDpSo()"></input>
                                                    <label>Down Payment By SO</label>
                                                </div>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control form-control-sm form-control-border" name="do_soum" id="do_soum" required readonly>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-info" id="modalByDp" disabled>
                                                            <i class="fa fa-search"></i> </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Account Receivable</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control form-control-sm form-control-border" name="acc_receivable" id="acc_receivable" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="cek_wapu" id="cek_wapu" onclick="return false;"></input>
                                                    <label>WAPU/KWB</label>
                                                    <h2 id="wapu" style="display: none; color: red; font-weight: bold;">
                                                        W.A.P.U
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Tax Serial Number </label>
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="tax_snF">XXX.</span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm form-control-border" id="tax_snE" name="tax_snE" readonly>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-sm btn-info" onclick=""><i class="fas fa-search"></i></button>
                                                    </span>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Ship To | <a href="javascript:void(0)" id="addBranch">Add Branch</a></label>
                                                <select class="form-control form-control-sm" id="cmbShipping" style="display: block;">
                                                </select>
                                                <input type="hidden" name="cmbShipping" id="cmbShippingKey">
                                                <textarea class="form-control form-control-sm" name="ship_to" id="ship_to" rows="5" readonly></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Received By</label>
                                                    <input type="text" class="form-control form-control-sm form-control-border" name="received_by" id="received_by">
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Received Date</label>
                                                    <input type="date" class="form-control form-control-sm form-control-border" name="received_by" id="received_by">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Internal Notes</label>
                                                    <textarea class="form-control form-control-sm" name="notes" id="notes" rows="4"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row col-md-12">
                                                <div class="col-md-7">
                                                    <label>Attachment</label>
                                                </div>
                                                <div class="col-md-5">
                                                    <a href="javascript:void(0)" class="btn btn-xs btn-warning float-right" onclick="removeAttach(this)" title="remove row"><i class="fa fa-minus"></i></a>
                                                    <a href="javascript:void(0)" class="btn btn-xs btn-info float-right" onclick="addAttach(this)" title="add row"><i class="fa fa-plus"></i></a>
                                                </div>
                                            </div>
                                            <div class="row col-md-12 attachUpload" id="attachUpload">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-modal scroly" id="trx" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%">Item</th>
                                                    <th style="width: 10%">Name</th>
                                                    <th style="width: 5%">Desc</th>
                                                    <th style="width: 2%">Qty</th>
                                                    <th style="width: 2%">UoM</th>
                                                    <th style="width: 2%">Price</th>
                                                    <th style="width: 2%">Disc % 1</th>
                                                    <th style="width: 2%">Disc % 2</th>
                                                    <th style="width: 2%">Disc</th>
                                                    <th style="width: 2%">Total</th>
                                                    <th style="width: 2%">Tax</th>
                                                    <th style="width: 2%">DO Number</th>
                                                    <th style="width: 2%">Warehouse</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 100%;">
                                                    <a href="javascript:void(0)" onclick="removeRow(this)" accesskey="r" class="btn btn-xs btn-warning float-right" title="remove row (alt+r)"><i class="fa fa-minus"></i></a>
                                                    <a href="javascript:void(0)" onclick="addRow(this)" accesskey="a" class="btn btn-xs btn-info float-right" title="add row (alt+a)"><i class="fa fa-plus"></i></a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-end">
                                    <div class="col-3">
                                        <div class="form-group row">
                                            <label class="col-sm-4">Total DPP</label>
                                            <div class="col-sm-8">
                                                <input type="hidden" name="totalBruto" id="totalBruto" autocomplete="off">
                                                <input type="text" class="form-control form-control-sm form-control-border numajaDesimal" style="text-align: right;" name="totalDpp" id="totalDpp" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4">Discount</label>
                                            <div class="col-sm-2"><input type="text" class="form-control form-control-sm form-control-border numajaDesimal" style="text-align: right;" name="discountProcentageHead" id="discountProcentageHead" onchange="discountHead('discountProcentageHead')" autocomplete="off" placeholder="%"></div>
                                            <div class="col-sm-6"><input type="text" class="form-control form-control-sm form-control-border numajaDesimal" style="text-align: right;" name="discountValueHead" id="discountValueHead" onchange="discountHead('discountValueHead')" autocomplete="off"></div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4">Total PPn</label>
                                            <div class="col-sm-8"><input type="text" class="form-control form-control-sm form-control-border numajaDesimal" style="text-align: right;" name="totalPpn" id="totalPpn" readonly></div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4">Total</label>
                                            <div class="col-sm-8"><input type="text" class="form-control form-control-sm form-control-border numajaDesimal" style="text-align: right;" name="grandTotal" id="grandTotal" readonly></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" name="process" value="save" id="process" required>
                                <button type="button" class="btn btn-warning float-right" id="print" title="print"><i class="fa fa-print"></i></button>
                                <button type="button" class="btn btn-info float-right" id="save" title="save"><i class="fa fa-save"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</form>
<!-- Modal -->
<div class="modal fade" id="modalDo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Outstanding Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid table-responsive">
                    <table class="table tabelOutstandingOrder tbl-sm sroly " id="tabelOutstandingOrder" style="width: 100%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th>DO</th>
                                <th>Date</th>
                                <th>ID Customer</th>
                                <th>Customer</th>
                                <th>Ship To</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSoDp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Outstanding Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid table-responsive">
                    <table class="table tabelOutstandingOrderDp tbl-sm sroly " id="tabelOutstandingOrderDp" style="width: 100%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th>Description</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end Modal -->
@endsection
@push('other-modal')
@include('modalBox.modalInventory')
@include('modalBox.modalSalesOrder')
@endpush
@push('other-script')
<script>
    var get_customer = "{{ URL::to('customerGetById') }}";
    var base_url = "{{ route('salesInvoice') }}";
    var url_default = "{{ URL('') }}";
    var rute_addBranch = "{{ URL::to('customer/addBranch') }}";
    var rute_do = "{{ URL::to('salesInvoice/data/do') }}";
    var get_do = "{{ URL::to('salesInvoice/get/do') }}";
    var rute_sodp = "{{ URL::to('salesInvoice/data/sodp') }}";
    var get_sodp = "{{ URL::to('salesInvoice/get/sodp') }}";
    var get_vat = "{{ URL::to('vat/data/byDate') }}";
    var vat = <?= json_encode($vat); ?>;
    var sales = <?= json_encode($sales); ?>;
    var lokasi = <?= json_encode($lokasi); ?>;
</script>
<script src="{{ asset('js/custom/salesOrder.js')}}"></script>
<script src="{{ asset('js/transaction/salesInvoice/salesInvoice-add.js?')}}"></script>
@endpush