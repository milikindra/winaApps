@extends('template.main-template')

@section('main-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $title }}</h1>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<form action="{{ route('salesOrderAddSave') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="card-title">Tambah Sales Order</h3>
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
                                                <label>Nomor</label>
                                                <input type="text" class="form-control form-control-sm form-control-border" name="nomor" id="nomor" autofocus required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Customer</label>
                                                <input type="hidden" name="customer_name" id="customer_name" autocomplete="off" required>
                                                <select class="form-control form-control-sm selects2 form-control-border" id="customer" name="customer" style="width: 100%;" onchange="getCustomer()" required>
                                                    <option selected disabled></option>
                                                    @foreach($customer as $c)
                                                    <option value="{{$c->ID_CUST}}">{{$c->ID_CUST." (".$c->NM_CUST.")"}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Attn</label>
                                                <input type="text" class="form-control form-control-sm form-control-border" name="attn" id="attn">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Tempo</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control form-control-sm form-control-border" name="tempo" id="tempo" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Days</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Pay.Term</label>
                                                <input type="text" class="form-control form-control-sm form-control-border" name="payterm" id="payterm" value="CASH" required>
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
                                                <input type="date" class="form-control form-control-sm form-control-border" name="date_order" id="date_order" value="{{date('Y-m-d')}}" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Due Date</label>
                                                <input type="date" class="form-control form-control-sm form-control-border" name="date_due" id="date_due" value="{{date('Y-m-d')}}" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>PO Customer</label>
                                                <input type="text" class="form-control form-control-sm form-control-border" name="po_customer" id="po_customer" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Quotation Ref.</label>
                                                <input type="text" class="form-control form-control-sm form-control-border" name="quotation_ref" id="quotation_ref" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Jenis</label>
                                                <select class="form-control form-control-sm form-control-border selects2" id="jenis" name="jenis" style="width: 100%;" required>
                                                    <option selected disabled></option>
                                                    <option value="CO">Component</option>
                                                    <option value="PR">Project</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Customer Address</label>
                                                <textarea class="form-control form-control-sm" name="customer_address" id="customer_address" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Ship To</label>
                                                <textarea class="form-control form-control-sm" name="ship_to" id="ship_to" rows="4" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Sales</label>
                                                <input type="hidden" name="sales_name" id="sales_name" autocomplete="off">
                                                <select class="form-control form-control-sm form-control-border selects2" id="sales" name="sales" style="width: 100%;" onchange="" required>
                                                    <option selected disabled></option>
                                                    @foreach($sales as $s)
                                                    <option value="{{$s->ID_SALES}}">{{$s->ID_SALES." (".$s->NM_SALES.")"}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Bussiness Unit</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control form-control-sm form-control-border" name="bu" id="bu_val" required>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-info" id="bu_modal">
                                                            <i class="fa fa-search"></i> </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Dept.</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control form-control-sm form-control-border" name="dept" id="dept_val" required>
                                                    <div class="input-group-append">
                                                        <a href="javascript:void(0)" class="btn btn-info" id="dept_modal"><i class="fa fa-search"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Tag</label>
                                                <input type="text" class="form-control form-control-sm form-control-border" name="tag" id="tag">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Internal Notes</label>
                                                <textarea class="form-control form-control-sm" name="notes" id="notes" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" style="border: 1px #000;">
                                                <table class="table down_payment table-modal" id="down_payment" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:50%">Down Payment</th>
                                                            <th style="width:30%">Nilai</th>
                                                            <th style="width:20%">Tax</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm" name="dp[]" id="dp-0">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="dp_value[]" id="dp_value-0" autocomplete="off" onchange="addDp(0)">
                                                            </td>
                                                            <td>
                                                                <select class="form-control form-control-sm" name="dp_tax[]" id="dp_tax-0" onchange="addDp(0)">
                                                                    @foreach($vat as $v)
                                                                    <option value="{{$v->kode}}">{{$v->kode}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td id="dp_tax_value-0" style="display:none"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table width="100%">
                                                    <tr>
                                                        <td style="width: 50%;">
                                                            <input type="hidden" value="0" id="totalDpTax" name="totalDpTax" readonly autocomplete="off">
                                                            <input type="text" class="form-control form-control-sm numajaDesimal" value="0" id="totalDp" name="totalDp" readonly>
                                                        </td>
                                                        <td style="width: 50%;">
                                                            <a href="javascript:void(0)" onclick="removeRowDp(this)" class="btn btn-xs btn-warning float-right" title="remove row"><i class="fa fa-minus"></i></a>
                                                            <a href="javascript:void(0)" onclick="addRowDp(this)" class="btn btn-xs btn-info float-right" title="add row"><i class="fa fa-plus"></i></a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
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
                                    <table class="table trx table-modal" id="trx" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Kode</th>
                                                <th style="width: 10%">Nama</th>
                                                <th style="width: 5%">Ket</th>
                                                <th style="width: 2%">Qty</th>
                                                <th style="width: 2%">Sat</th>
                                                <th style="width: 2%">Harga</th>
                                                <th style="width: 2%">Disc % 1</th>
                                                <th style="width: 2%">Disc % 2</th>
                                                <th style="width: 2%">Disc</th>
                                                <th style="width: 2%">Jumlah</th>
                                                <th style="width: 2%">Tax</th>
                                                <th style="width: 2%">State</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" name="no_stock[]" id="no_stock-0" onclick="addData(0)" readonly>
                                                </td>
                                                <td>
                                                    <textarea class="form-control form-control-sm" name="nm_stock[]" id="nm_stock-0" rows="3"></textarea>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" name="ket[]" id="ket-0">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="qty[]" onchange="itemTotal(0)" autocomplete="off" id="qty-0">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" name="sat[]" id="sat-0">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="price[]" onchange="itemTotal(0)" autocomplete="off" id="price-0">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="disc[]" onchange="itemTotal(0)" autocomplete="off" id="disc-0">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="disc2[]" onchange="itemTotal(0)" autocomplete="off" id="disc2-0">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="disc_val[]" onchange="itemTotal(0)" autocomplete="off" id="disc_val-0">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="total[]" id="total-0" readonly>
                                                </td>
                                                <td>
                                                    <select class="form-control form-control-sm" name="tax[]" id="tax-0" onchange="itemTotal(0)">
                                                        @foreach($vat as $v)
                                                        <option value="{{$v->kode}}">{{$v->kode}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" name="state[]" id="state-0" onclick="" readonly>
                                                </td>
                                                <td style="display: none;" id="itemTotal-0"></td>
                                                <td style="display: none;" id="itemTax-0"></td>
                                                <td style="display: none;" id="itemDisc-0"></td>
                                                <td style="display: none;" id="itemTotalDiscHead-0"></td>
                                                <td style="display: none;" id="itemBruto-0"></td>
                                                <td style="display: none;" id="itemTaxValue-0"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table width="100%">
                                        <tr>
                                            <td style="width: 100%;">
                                                <a href="javascript:void(0)" onclick="removeRow(this)" class="btn btn-xs btn-warning float-right" title="remove row"><i class="fa fa-minus"></i></a>
                                                <a href="javascript:void(0)" onclick="addRow(this)" class="btn btn-xs btn-info float-right" title="add row"><i class="fa fa-plus"></i></a>
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
                                        <label class="col-sm-4">Total Dpp</label>
                                        <div class="col-sm-8">
                                            <input type="hidden" name="totalBruto" id="totalBruto" autocomplete="off">
                                            <input type="text" class="form-control form-control-sm form-control-border" style="text-align: right;" name="totalDpp" id="totalDpp" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4">Discount</label>
                                        <div class="col-sm-2"><input type="text" class="form-control form-control-sm form-control-border numajaDesimal" style="text-align: right;" name="discountProcentageHead" id="discountProcentageHead" onchange="discountHead('discountProcentageHead')" autocomplete="off" placeholder="%"></div>
                                        <div class="col-sm-6"><input type="text" class="form-control form-control-sm form-control-border numajaDesimal" style="text-align: right;" name="discountValueHead" id="discountValueHead" onchange="discountHead('discountValueHead')" autocomplete="off"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4">Total PPn</label>
                                        <div class="col-sm-8"><input type="text" class="form-control form-control-sm form-control-border" style="text-align: right;" name="totalPpn" id="totalPpn" readonly></div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4">Total</label>
                                        <div class="col-sm-8"><input type="text" class="form-control form-control-sm form-control-border" style="text-align: right;" name="grandTotal" id="grandTotal" readonly></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-warning float-right" value="print" id="print" name="process" title="print" formtarget="_blank" onclick="refreshWindow()"><i class="fa fa-print"></i></button>
                            <button type="submit" class="btn btn-info float-right" value="save" name="process" title="save"><i class="fa fa-save"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
<!-- Modal -->
<div class="modal fade" id="modalBu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Bussiness Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <table class="table tbl_bu" style="width: 100%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th style="width: 15%" style="text-align: center;">Kode</th>
                                <th style="width: 70%" style="text-align: center;">Keterangan</th>
                                <th style="width: 10%" style="text-align: center;">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bu as $b)
                            <tr>
                                <td>
                                    {{$b->divisi}}
                                </td>
                                <td>
                                    {{$b->keterangan}}
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm numajaDesimal">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class=" modal-footer justify-content-between">
                <button type="submit" id="bu_save" class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" style="text-align:left;" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDept" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header bg-info">
                <h5 class="modal-title">Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <table class="table tbl_dept" style="width: 100%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th style="width: 15%" style="text-align: center;">Kode</th>
                                <th style="width: 70%" style="text-align: center;">Keterangan</th>
                                <th style="width: 10%" style="text-align: center;">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dept as $d)
                            <tr>
                                <td>
                                    {{$d->kode}}
                                </td>
                                <td>
                                    {{$d->keterangan}}
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm numajaDesimal">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class=" modal-footer justify-content-between">
                <button type="submit" id="dept_save" class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" style="text-align:left;" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalBarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Inventory</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <table class="table" id="datatables" style="width: 100%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th style="width: 15%" style="text-align: center;">Kode</th>
                                <th style="width: 70%" style="text-align: center;">Nama</th>
                                <th style="width: 10%" style="text-align: center;">Sat</th>
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
@endsection
@push('other-script')
<script>
    var rute = "{{ URL::to('salesOrder/data/populate') }}";
    var get_customer = "{{ URL::to('customerGetById') }}";
    var get_inventory = "{{ URL::to('inventory/data/populate') }}";
    var base_url = "{{ route('salesOrder') }}";
    var url_default = "{{ URL('') }}";
    var vat = <?= json_encode($vat); ?>;
    var sales = <?= json_encode($sales); ?>;
    var customer = <?= json_encode($customer); ?>;
</script>
<script src="{{ asset('js/transaction/salesOrder/salesOrder-add.js')}}"></script>
<script>

</script>

@endpush