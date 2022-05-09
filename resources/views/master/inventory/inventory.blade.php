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
                                <select class="form-control" id="kategori">
                                    <option value="all" selected>All</option>
                                    @foreach($kategori as $kat)
                                    <option value="{{$kat->kategori}}">{{$kat->kategori}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <br />
                                <label>Sub Kategori</label>
                                <select class="form-control" id="subkategori">
                                    <option value="all" selected>All</option>
                                    @foreach($subKategori as $subkat)
                                    <option value="{{$subkat->kode}}">{{$subkat->kode}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <br />
                                    <input type="checkbox" class="form-check-input" id="void"></input>
                                    <label>Show Qty 0</label>
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
                        <form method="post">
                            <div class="row">
                                <div class="col-12">
                                    <label>Tanggal Awal</label>
                                    <input type="date" class="form-control" name="sdate" required>
                                </div>
                                <div class="col-12">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" class="form-control" name="edate" value="{{date('Y-m-d')}}" required>
                                </div>
                                <div class="col-12">
                                    <br />
                                    <label>Lokasi</label>
                                    <select class="form-control" id="lokasi">
                                        <option selected>All</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <br />
                                        <input type="checkbox" class="form-check-input"></input>
                                        <label>Include item transfer</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-flat btn-info float-right">Kartu Stok</button>
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
                        <a href="{{ route('inventoryAdd')}}" class="btn btn-info btn-flat btn-sm">Tambah Inventory</a>
                        <hr />
                        <table id="datatables" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>Kode</th>
                                    <th>Nama Inventory</th>
                                    <th>Satuan</th>
                                    <th>Saldo</th>
                                    <th>Booked</th>
                                    <th>Order</th>
                                    <th>Transit</th>
                                    <th>Kategori</th>
                                    <th>Subkategori</th>
                                    <th>Opsi</th>
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
@endsection
@push('other-script')
<script>
    var rute = "{{ URL::to('inventory/data/populate') }}";
    var base_url = "{{ route('inventory') }}";
    var url_default = "{{ URL('') }}";
    var fullDate = new Date();
    var twoDigitMonth = ("0" + (fullDate.getMonth() + 1)).slice(-2);
    var lastDay = new Date(fullDate.getFullYear(), fullDate.getMonth() + 1, 0);
    var sdate = "01" + "-" + twoDigitMonth + "-" + fullDate.getFullYear();
    var edate = lastDay.getDate() + "-" + twoDigitMonth + "-" + fullDate.getFullYear();
</script>
<script src="{{ asset('js/master/inventory/inventory-table.js')}}"></script>
@endpush