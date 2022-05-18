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
                            <div class="col-12">
                                <h3 class="card-title">Filter Data</h3>
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
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="void"></input>
                                    <label>Show Detail</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <label>Kategori</label>
                                <select class="form-control selects2" id="kategoriFilter">
                                    <option value="outstanding" selected>Outstanding</option>
                                    <option value="lunas">Lunas</option>
                                    <option value="all">All</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="card-title">Filter Sales Order</h3>
                                <div class="card-tools float-right">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('salesOrder') }}">
                            @csrf
                            <div class="row">
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
                                    <button type="submit" class="btn btn-flat btn-info float-right">Prosess</button>
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
                                <h3 class="card-title">Data Sales Order</h3>
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
                        <table id="datatables" class="table table-bordered table-striped table-hover">
                            <thead id="dtheader">

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
                                <select class="form-control selects2" id="kategoriAdd" name="kategori">
                                    <option value="">Pilih Kategori</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Subkategori</label>
                            <div class="col-sm-4">
                                <select class="form-control selects2" id="subkategoriAdd" name="subkategori">
                                    <option value="">Pilih Subkategori</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Merk</label>
                            <div class="col-sm-4">
                                <select class="form-control selects2" id="merkAdd" name="merk">
                                    <option value="">Pilih Merk</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Harga Jual</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control numaja" name="harga_jual" placeholder="Masukkan Harga Jual">
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
                                <select class="form-control selects2" id="salesAcc" name="salesAcc">
                                    <option></option>

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
                                <select class="form-control selects2" id="purchaseAcc" name="purchaseAcc">
                                    <option></option>

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
                    <button type="button" class="btn btn-flat btn-default" style="text-align:left;" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-flat btn-info">Save</button>
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
                                <select class="form-control selects2" id="kategoriEdit" name="kategori">
                                    <option value="">Pilih Kategori</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Subkategori</label>
                            <div class="col-sm-4">
                                <select class="form-control selects2" id="subkategoriEdit" name="subkategori">
                                    <option value="">Pilih Subkategori</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Merk</label>
                            <div class="col-sm-4">
                                <select class="form-control selects2" id="merkEdit" name="merk">
                                    <option value="">Pilih Merk</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Harga Jual</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control numaja" id="harga_jual" name="harga_jual" placeholder="Masukkan Harga Jual">
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
                                <select class="form-control selects2" id="salesAccEdit" name="salesAcc">
                                    <option></option>

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
                                <select class="form-control selects2" id="purchaseAccEdit" name="purchaseAcc">
                                    <option></option>

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
                    <button type="button" class="btn btn-flat btn-default" style="text-align:left;" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-flat btn-info">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- end modal -->
@endsection
@push('other-script')
<script>
    var rute = "{{ URL::to('salesOrder/data/populate') }}";
    // var rute_delete = "{{ URL::to('inventory/data/delete') }}";
    // var rute_edit = "{{ URL::to('inventory/data/edit') }}";
    var base_url = "{{ route('salesOrder') }}";
    var url_default = "{{ URL('') }}";
</script>
<script src="{{ asset('js/transaction/salesOrder/salesOrder-table.js')}}"></script>
@endpush