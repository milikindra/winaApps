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
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12"><button type="button" class="btn btn-info  btn-sm btn-block" data-toggle="modal" data-target="#addInventory">
                                    Tambah Inventory
                                </button>
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
                            <div class="col-12">
                                <label>Kategori</label>
                                <select class="form-control selects2" style="width: 100%;" id="kategoriFilter">
                                    <option value="all" selected>All</option>
                                    @foreach($kategori as $kat)
                                    <option value="{{$kat->kategori}}">{{$kat->kategori}} - {{$kat->keterangan}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <br />
                                <label>Sub Kategori</label>
                                <select class="form-control selects2" style="width: 100%;" id="subkategoriFilter">
                                    <option value="all" selected>All</option>
                                    @foreach($subKategori as $kat)
                                    <option value="{{$kat->kode}}">{{$kat->kode}} - {{$kat->keterangan}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <br />
                                    <input type="checkbox" class="custom-control-input custom-control-input-info" id="void">
                                    <label for="void" class="custom-control-label">Show Qty 0</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="card-title">Filter Kartu Stok</h3>
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
                                <div class="col-12">
                                    <label>Kode</label>
                                    <input type="text" class="form-control" name="kode" id="kode_kartu_stok" required>
                                </div>
                                <div class="col-12">
                                    <br />
                                    <label>Tanggal Awal</label>
                                    <input type="date" class="form-control" name="sdate" value="{{date('Y-m-d', strtotime('-1 year'))}}" required>
                                </div>
                                <div class="col-12">
                                    <br />
                                    <label>Tanggal Akhir</label>
                                    <input type="date" class="form-control" name="edate" value="{{date('Y-m-d')}}" required>
                                </div>
                                <div class="col-12">
                                    <br />
                                    <label>Lokasi</label>
                                    <select class="form-control selects2" style="width: 100%;" name="lokasi" id="lokasi">
                                        <option value="all" selected>All</option>
                                        @foreach($lokasi as $lok)
                                        <option value="{{$lok->id_lokasi}}">{{$lok->id_lokasi}} - {{$lok->keterangan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="col-12">
                                        <div class="custom-control custom-checkbox">
                                            <br />
                                            <input type="checkbox" class="custom-control-input custom-control-input-info" value="1" name="item_transfer" id="item_transfer">
                                            <label for="item_transfer" class="custom-control-label">Include item transfer</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-info float-right">Kartu Stok</button>
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
                                <h3 class="card-title">Data Inventory</h3>
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
                        <table id="datatables" style="width: 100%;" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="text-align: center;">
                                    <th width="10%">Kode</th>
                                    <th>Nama Inventory</th>
                                    <th>Satuan</th>
                                    <th>Saldo</th>
                                    <th>Booked</th>
                                    <th>Order</th>
                                    <th>Transit</th>
                                    <th>Kategori</th>
                                    <th>Subkategori</th>
                                    <th width="10%">Opsi</th>
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
<div class="modal fade" id="addInventory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="{{ route('inventoryAddSave') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-info">
                    <h5 class="modal-title">Tambah Inventory</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Kode</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="kode" placeholder="Masukkan Kode" required>
                            </div>
                            <div class="col-sm-3 form-check">
                                <input type="checkbox" class="form-check-input" name="aktif" checked></input>
                                <label>AKTIF</label>
                            </div>
                            <div class="col-sm-3">
                                <input type="checkbox" class="form-check-input" name="konsinyansi"></input>
                                <label>KONSINYANSI</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Barang</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="nama_barang" rows="2" placeholder="Masukkan Nama Barang"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Satuan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="satuan" maxlength="5" placeholder="Masukkan satuan">
                            </div>
                            <label class="col-sm-2 col-form-label">Stok Minimal</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="stok_minimal" placeholder="Masukkan Stok Minimal" value="0" min="0">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Kategori</label>
                            <div class="col-sm-4">
                                <select class="form-control selects2" style="width: 100%;" id="kategoriAdd" name="kategori">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategori as $kat)
                                    <option value="{{$kat->kategori}}">{{$kat->kategori}} - {{$kat->keterangan}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Subkategori</label>
                            <div class="col-sm-4">
                                <select class="form-control selects2" style="width: 100%;" id="subkategoriAdd" name="subkategori">
                                    <option value="">Pilih Subkategori</option>
                                    @foreach($subKategori as $kat)
                                    <option value="{{$kat->kode}}">{{$kat->kode}} - {{$kat->keterangan}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Merk</label>
                            <div class="col-sm-4">
                                <select class="form-control selects2" style="width: 100%;" id="merkAdd" name="merk">
                                    <option value="">Pilih Merk</option>
                                    @foreach($merk as $merks)
                                    <option value="{{$merks->Kode}}">{{$merks->Kode}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Harga Jual</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control numajaDesimal" name="harga_jual" placeholder="Masukkan Harga Jual">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Keterangan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="keterangan" placeholder="keterangan">
                            </div>
                        </div>
                        <hr />
                        <div class="form-group row">
                            <div class="col-sm-3 form-check">
                                <input type="checkbox" class="form-check-input" id="isMinus" name="isMinus"></input>
                                <label>NON INVENTORY</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Sales Account</label>
                            <div class="col-sm-4">
                                <select class="form-control selects2" style="width: 100%;" id="salesAcc" name="salesAcc">
                                    <option></option>
                                    @foreach($account as $acc)
                                    <option value="{{$acc->no_rek}}">{{$acc->no_rek." - ".$acc->nm_rek}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3 form-check">
                                <input type="checkbox" class="form-check-input" name="PphPs23"></input>
                                <label>PPh Ps 23</label>
                            </div>
                            <div class="col-sm-3">
                                <input type="checkbox" class="form-check-input" name="PPhPs21"></input>
                                <label>PPh Ps 21</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Purchase Account</label>
                            <div class="col-sm-4">
                                <select class="form-control selects2" style="width: 100%;" id="purchaseAcc" name="purchaseAcc">
                                    <option></option>
                                    @foreach($account as $acc)
                                    <option value="{{$acc->no_rek}}">{{$acc->no_rek." - ".$acc->nm_rek}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3 form-check">
                                <input type="checkbox" class="form-check-input" name="PPhPs4Ayat2"></input>
                                <label>PPh Ps 4 ayat 2</label>
                            </div>
                            <div class="col-sm-3">
                                <input type="checkbox" class="form-check-input" name="PPhPs21OP"></input>
                                <label>PPh Ps 21 OP</label>
                            </div>
                        </div>

                    </div>
                </div>
                <div class=" modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" style="text-align:left;" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editInventory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="{{ route('inventoryUpdate') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-info">
                    <h5 class="modal-title">Edit Inventory</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Kode</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="kode" name="kode" placeholder="Masukkan Kode" required>
                            </div>
                            <div class="col-sm-3 form-check">
                                <input type="checkbox" class="form-check-input" id="aktifEdit" name="aktif" checked></input>
                                <label>AKTIF</label>
                            </div>
                            <div class="col-sm-3">
                                <input type="checkbox" class="form-check-input" id="konsinyansiEdit" name="konsinyansi"></input>
                                <label>KONSINYANSI</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Barang</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="nama_barang" name="nama_barang" rows="2" placeholder="Masukkan Nama Barang"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Satuan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="satuan" name="satuan" maxlength="5" placeholder="Masukkan satuan">
                            </div>
                            <label class="col-sm-2 col-form-label">Stok Minimal</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="stok_minimal" name="stok_minimal" placeholder="Masukkan Stok Minimal" value="0" min="0">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Kategori</label>
                            <div class="col-sm-4">
                                <select class="form-control selects2" style="width: 100%;" id="kategoriEdit" name="kategori">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategori as $kat)
                                    <option value="{{$kat->kategori}}">{{$kat->kategori}} - {{$kat->keterangan}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Subkategori</label>
                            <div class="col-sm-4">
                                <select class="form-control selects2" style="width: 100%;" id="subkategoriEdit" name="subkategori">
                                    <option value="">Pilih Subkategori</option>
                                    @foreach($subKategori as $kat)
                                    <option value="{{$kat->kode}}">{{$kat->kode}} - {{$kat->keterangan}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Merk</label>
                            <div class="col-sm-4">
                                <select class="form-control selects2" style="width: 100%;" id="merkEdit" name="merk">
                                    <option value="">Pilih Merk</option>
                                    @foreach($merk as $merks)
                                    <option value="{{$merks->Kode}}">{{$merks->Kode}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Harga Jual</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control numajaDesimal" id="harga_jual" name="harga_jual" placeholder="Masukkan Harga Jual">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Keterangan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="keterangan">
                            </div>
                        </div>
                        <hr />
                        <div class="form-group row">
                            <div class="col-sm-3 form-check">
                                <input type="checkbox" class="form-check-input" id="isMinusEdit" name="isMinus"></input>
                                <label>NON INVENTORY</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Sales Account</label>
                            <div class="col-sm-4">
                                <select class="form-control selects2" style="width: 100%;" id="salesAccEdit" name="salesAcc">
                                    <option></option>
                                    @foreach($account as $acc)
                                    <option value="{{$acc->no_rek}}">{{$acc->no_rek." - ".$acc->nm_rek}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3 form-check">
                                <input type="checkbox" class="form-check-input" id="PphPs23Edit" name="PphPs23"></input>
                                <label>PPh Ps 23</label>
                            </div>
                            <div class="col-sm-3">
                                <input type="checkbox" class="form-check-input" id="PPhPs21Edit" name="PPhPs21"></input>
                                <label>PPh Ps 21</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Purchase Account</label>
                            <div class="col-sm-4">
                                <select class="form-control selects2" style="width: 100%;" id="purchaseAccEdit" name="purchaseAcc">
                                    <option></option>
                                    @foreach($account as $acc)
                                    <option value="{{$acc->no_rek}}">{{$acc->no_rek." - ".$acc->nm_rek}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3 form-check">
                                <input type="checkbox" class="form-check-input" id="PPhPs4Ayat2Edit" name="PPhPs4Ayat2"></input>
                                <label>PPh Ps 4 ayat 2</label>
                            </div>
                            <div class="col-sm-3">
                                <input type="checkbox" class="form-check-input" id="PPhPs21OPEdit" name="PPhPs21OP"></input>
                                <label>PPh Ps 21 OP</label>
                            </div>
                        </div>

                    </div>
                </div>
                <div class=" modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" style="text-align:left;" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- end modal -->
@endsection
@push('other-script')
<script>
    var rute = "{{ URL::to('inventory/data/populate') }}";
    var rute_delete = "{{ URL::to('inventory/data/delete') }}";
    var rute_edit = "{{ URL::to('inventory/data/edit') }}";
    var base_url = "{{ route('inventory') }}";
    var url_default = "{{ URL('') }}";
</script>
<script src="{{ asset('js/master/inventory/inventory-table.js?')}}"></script>
@endpush