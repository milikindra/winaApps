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
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">
                <div class="card">
                    <div class="card-header">
                        <div class="row margbot-5">
                            <div class="col-12">
                                <a href="javascript:void(0)" class="btn btn-info  btn-sm btn-block" onclick="inventoryAdd('I')">
                                    Add Inventory
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="javascript:void(0)" class="btn btn-info  btn-sm btn-block" onclick="inventoryAdd('G')">
                                    Add Group Inventory
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="card-title">Filter Inventory</h3>
                                <div class="card-tools float-right">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 margbot-5">
                                <label>Category</label>
                                <select class="form-control form-control-sm selects2" style="width: 100%;" id="kategoriFilter">
                                    <option value="all" selected>All</option>
                                    @foreach($kategori as $kat)
                                    <option value="{{$kat->kategori}}">{{$kat->kategori}} - {{$kat->keterangan}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 margbot-5">
                                <label>Subcategory</label>
                                <select class="form-control form-control-sm selects2" style="width: 100%;" id="subkategoriFilter">
                                    <option value="all" selected>All</option>
                                    @foreach($subKategori as $kat)
                                    <option value="{{$kat->kode}}">{{$kat->kode}} - {{$kat->keterangan}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 margbot-5">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="void">
                                    <label class="form-check-label">Show Qty 0</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="card-title">Filter Stock Card</h3>
                                <div class="card-tools float-right">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('kartuStok') }}">
                            @csrf
                            <div class="row">
                                <div class="col-12 margbot-5">
                                    <label>Code</label>
                                    <input type="text" class="form-control form-control-sm" name="kode" id="kode_kartu_stok" required>
                                </div>
                                <div class="col-12 margbot-5">
                                    <label>Start Date</label>
                                    <input type="date" class="form-control form-control-sm" name="sdate" value="{{date('Y-m-d', strtotime('-1 year'))}}" required>
                                </div>
                                <div class="col-12 margbot-5">
                                    <label>End Date</label>
                                    <input type="date" class="form-control form-control-sm" name="edate" value="{{date('Y-m-d')}}" required>
                                </div>
                                <div class="col-12 margbot-5">
                                    <label>Location</label>
                                    <select class="form-control form-control-sm selects2" style="width: 100%;" name="lokasi" id="lokasi">
                                        <option value="all" selected>All</option>
                                        @foreach($lokasi as $lok)
                                        <option value="{{$lok->id_lokasi}}">{{$lok->id_lokasi}} - {{$lok->keterangan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 margbot-5">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" value="1" name="item_transfer" id="item_transfer">
                                        <label class="form-check-label">Include item transfer</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-sm btn-info float-right">Stock Card</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="card-title">Inventory Data</h3>
                                <div class="card-tools float-right">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="datatables" style="width: 100%;" class="table table-bordered table-hover tbl-sm sroly">
                            <thead>
                                <tr style="text-align: center;">
                                    <th width="10%">Code</th>
                                    <th>Item</th>
                                    <th>UoM</th>
                                    <th>Saldo</th>
                                    <th>Booked</th>
                                    <th>Order</th>
                                    <th>Transit</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th width="10%">Option</th>
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
</section>
<!-- Modal -->
<div class="modal fade" id="inventoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form method="POST" id="formInventory" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="kodeBJ" name="kodeBJ" required>
                <input type="hidden" id="kodeOld" name="kodeOld" required>
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="titleInventory"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group row margbot-5">
                            <label class="col-sm-2">Code</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" name="kode" id="kode" placeholder="Insert Code" required>
                            </div>
                            <div class="col-sm-3 isBj">
                                <a class="btn btn-info btn-sm btnVintras" href="javascript:void(0)">Import Data From VINTRAS</a>
                            </div>
                            <div class="col-sm-1 isBj">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="aktif" id="aktif" checked></input>
                                    <label class="form-check-label">ACTIVE</label>
                                </div>
                            </div>
                            <div class="col-sm-1 isBj">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="konsinyansi" id="konsinyansi" checked></input>
                                    <label class="form-check-label">CONSIGNMENT</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row margbot-5">
                            <label class="col-sm-2" id="inventoryName"></label>
                            <div class="col-sm-10">
                                <textarea class="form-control form-control-sm" name="nama_barang" id="nama_barang" rows="2" placeholder="Insert Name"></textarea>
                            </div>
                        </div>
                        <div class="form-group row margbot-5">
                            <label class="col-sm-2">UoM</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" name="satuan" id="satuan" maxlength="5" placeholder="Insert Unit Of Measurment">
                            </div>
                            <label class="col-sm-2 isBj">Minimum Stock</label>
                            <div class="col-sm-4 isBj">
                                <input type="number" class="form-control form-control-sm" name="stok_minimal" id="stok_minimal" placeholder="Insert Minimum Stock" value="0" min="0">
                            </div>
                        </div>
                        <div class="form-group row margbot-5">
                            <label class="col-sm-2">Category</label>
                            <div class="col-sm-4">
                                <select class="form-control form-control-sm selects2" style="width: 100%;" id="kategoriInventory" name="kategori">
                                    <option value="">Select Category</option>
                                    @foreach($kategori as $kat)
                                    <option value="{{$kat->kategori}}">{{$kat->kategori}} - {{$kat->keterangan}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-sm-2 isBj">Vintras Id</label>
                            <div class="col-sm-4 isBj">
                                <input type="text" class="form-control form-control-sm vintrasId" name="vintrasId" id="vintrasId" placeholder="Does Not Have Vintras Id" readonly>
                            </div>
                        </div>
                        <div class="form-group row margbot-5">
                            <label class="col-sm-2">Subcategory</label>
                            <div class="col-sm-4">
                                <select class="form-control form-control-sm selects2" style="width: 100%;" id="subKategoriInventory" name="subkategori">
                                    <option value="">Select Subcategory</option>
                                    @foreach($subKategori as $kat)
                                    <option value="{{$kat->kode}}">{{$kat->kode}} - {{$kat->keterangan}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row margbot-5">
                            <label class="col-sm-2">Brand</label>
                            <div class="col-sm-4">
                                <select class="form-control form-control-sm selects2" style="width: 100%;" id="merkInventory" name="merk">
                                    <option value="">Select Brand</option>
                                    @foreach($merk as $merks)
                                    <option value="{{ltrim($merks->Kode)}}">{{$merks->Kode}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row margbot-5">
                            <label class="col-sm-2 isBj">Selling Price</label>
                            <div class="col-sm-4 isBj">
                                <input type="text" class="form-control form-control-sm numajaDesimal" name="harga_jual" id="harga_jual" placeholder="Insert Selling Price">
                            </div>
                        </div>
                        <div class="form-group row margbot-5">
                            <label class="col-sm-2 isBj">Description</label>
                            <div class="col-sm-10 isBj">
                                <input type="text" class="form-control form-control-sm" name="keterangan" id="keterangan" placeholder="Description">
                            </div>
                        </div>
                        <hr class="isBj" />
                        <div class="form-group row margbot-5">
                            <div class="col-sm-3 isBj">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="isMinus" name="isMinus"></input>
                                    <label class="form-check-label">NON INVENTORY</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row margbot-5">
                            <label class="col-sm-2 isBj">Sales Account</label>
                            <div class="col-sm-4 isBj">
                                <select class="form-control form-control-sm selects2" style="width: 100%;" id="salesAcc" name="salesAcc">
                                    <option></option>
                                    @foreach($account as $acc)
                                    <option value="{{$acc->no_rek}}">{{$acc->no_rek." - ".$acc->nm_rek}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3 isBj">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="PPhPs23" id="PPhPs23"></input>
                                    <label class="form-check-label">PPh Ps 23</label>
                                </div>
                            </div>
                            <div class="col-sm-3 isBj">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="PPhPs21" id="PPhPs21"></input>
                                    <label class="form-check-label">PPh Ps 21</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row margbot-5">
                            <label class="col-sm-2 isBj">Purchase Account</label>
                            <div class="col-sm-4 isBj">
                                <select class="form-control form-control-sm selects2" style="width: 100%;" id="purchaseAcc" name="purchaseAcc">
                                    <option></option>
                                    @foreach($account as $acc)
                                    <option value="{{$acc->no_rek}}">{{$acc->no_rek." - ".$acc->nm_rek}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3 isBj">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="PPhPs4Ayat2" id="PPhPs4Ayat2"></input>
                                    <label class="form-check-label">PPh Ps 4 ayat 2</label>
                                </div>
                            </div>
                            <div class="col-sm-3 isBj">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="PPhPs21OP" id="PPhPs21OP"></input>
                                    <label class="form-check-label">PPh Ps 21 OP</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row margbot-5 nBj">
                            <table class="table trx table-modal" id="trx" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">Id</th>
                                        <th style="width: 10%">Name</th>
                                        <th style="width: 2%">Qty</th>
                                        <th style="width: 2%">UoM</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                <div class=" modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" style="text-align:left;" data-dismiss="modal">Close</button>
                    <button type="submit" id="btnAddSave" class="btn btn-info">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="vintrasPeriod" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Vintras Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group row margbot-5">
                        <label class="col-sm-1">Period</label>
                        <div class="col-sm-2">
                            <select class="form-control form-control-sm selects2" style="width: 100%;" id="vintrasYear" name="vintrasYear">
                                <option selected disabled>Select Period</option>
                                <?php
                                $start = 2018;
                                $end = date("Y");
                                for ($end; $end >= $start; $end--) {
                                    echo "<option>" . $end . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card-body table-responsive">
                            <table id="vintrasTable" style="width: 100%;" class="table table-bordered table-hover tbl-sm scroly">
                                <thead>
                                    <tr style="text-align: center;">
                                        <th style="width: 20%;">Ref. Code</th>
                                        <th style="width: 25%;">Specification</th>
                                        <th style="width: 10%;">Date</th>
                                        <th style="width: 20%;">Cutomers</th>
                                        <th>Brand</th>
                                        <th>Ref. Description</th>
                                        <th>Other Specification</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class=" modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" style="text-align:left;" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end modal -->
@endsection
@push('other-modal')
@include('modalBox.modalInventory')
@endpush
@push('other-script')
<script>
    var rute = "{{ URL::to('inventory/data/populate') }}";
    var rute_vintras = "{{ URL::to('vintras/data/populate') }}";
    var rute_delete = "{{ URL::to('inventory/data/delete') }}";
    var rute_edit = "{{ URL::to('inventory/data/edit') }}";
    var save_inventory = "{{ route('inventoryAddSave') }}";
    var update_inventory = "{{ route('inventoryUpdate') }}";
    var base_url = "{{ route('inventory') }}";
    var url_default = "{{ URL('') }}";
</script>
<script src="{{ asset('js/master/inventory/inventory-table.js?')}}"></script>
<script src="{{ asset('js/master/inventory/inventory-add.js?')}}"></script>
@endpush