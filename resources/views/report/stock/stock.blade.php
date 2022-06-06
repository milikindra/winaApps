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
                                <h3 class="card-title">Filter</h3>
                                <div class="card-tools float-right">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="javascript:void(0)">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <label>Report</label>
                                    <select class="form-control selects2" style="width: 100%;" name="reportType" id="reportType">
                                        <option value="" selected disabled></option>
                                        @if (hasAccess('RX01.01'))
                                        <option value="appPosisiStok">Posisi Stock</option>
                                        @endif
                                    </select>
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
                                <h3 class="card-title">Filter Report</h3>
                                <div class="card-tools float-right">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <form action="{{ route('reportPosisiStock') }}" method="POST" enctype="multipart/form-data" target="_blank" id="appPosisiStok" style="display: none;">
                        @csrf
                        <div class="card-body">
                            <div class="container-fluid">
                                <input type="hidden" name="type" id="type" required>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Tanggal</label>
                                    <div class="col-sm-4">
                                        <input type="date" name="edate" class="form-control" value="{{date('Y-m-d')}}" required>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Qty</label>
                                    <div class="col-sm-2">
                                        <select class="form-control selects2" style="width: 100%;" name="qty" id="qty">
                                            <option value="all" selected>All</option>
                                            <option value="1">Lebih dari 0</option>
                                            <option value="-1">Kurang dari 0</option>
                                            <option value="0">Sama dengan 0</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="isNilai" checked></input>
                                            <label>Tampilkan Nilai</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Lokasi</label>
                                    <div class="col-sm-4">
                                        <select class="form-control selects2" style="width: 100%;" name="lokasi" id="lokasi">
                                            <option value="all" selected>All</option>
                                            @foreach($lokasi as $lok)
                                            <option value="{{$lok->id_lokasi}}">{{$lok->id_lokasi}} - {{$lok->keterangan}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="offset-sm-2 col-sm-4">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="isGrouping" checked></input>
                                            <label>Grouping Per Lokasi</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Barang</label>
                                    <div class="col-sm-4">
                                        <select class="form-control selects2" style="width: 100%;" name="inventory" id="inventory">
                                            <option value="all" selected>All</option>
                                            @foreach($inventory as $inv)
                                            <option value="{{$inv->no_stock}}">{{$inv->no_stock}} - {{$inv->nm_stock}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Merk</label>
                                    <div class="col-sm-4">
                                        <select class="form-control selects2" style="width: 100%;" id="merkAdd" name="merk">
                                            <option value="all" selected>All</option>
                                            @foreach($merk as $merks)
                                            <option value="{{$merks->Kode}}">{{$merks->Kode}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Kategori</label>
                                    <div class="col-sm-4">
                                        <select class="form-control selects2" name="kategori" style="width: 100%;" id="kategori">
                                            <option value="all" selected>All</option>
                                            @foreach($kategori as $kat)
                                            <option value="{{$kat->kategori}}">{{$kat->kategori}} - {{$kat->keterangan}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Sub Kategori</label>
                                    <div class="col-sm-4">
                                        <select class="form-control selects2" name="subKategori" style="width: 100%;" id="subKategori">
                                            <option value="all" selected>All</option>
                                            @foreach($subKategori as $kat)
                                            <option value="{{$kat->kode}}">{{$kat->kode}} - {{$kat->keterangan}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <button type="submit" name="action" value="print" class="btn btn-warning float-right"><i class="fa fa-print"></i></button>
                            <button type="submit" name="action" value="excel" class="btn btn-info float-right"><i class="fas fa-file-excel"></i></button>
                        </div>
                    </form>

                    <table>
                        
                    </table>


                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('other-script')
<script>
    // var rute = " {{ URL::to('kartuStok/data/populate') }}"; var base_url="{{ route('reportStock') }}" ; var url_default="{{ URL('') }}" ; 
</script>
<script src="{{ asset('js/report/stock/stock.js')}}"></script>
@endpush