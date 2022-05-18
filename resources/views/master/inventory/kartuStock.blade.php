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
                                <h3 class="card-title">Filter Kartu Stock</h3>
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
                                    <label>Kode</label>
                                    <input type="text" class="form-control" name="kode" id="kode_kartu_stok" value="{{$kode}}" required>
                                </div>
                                <div class="col-12">
                                    <br />
                                    <label>Tanggal Awal</label>
                                    <input type="date" class="form-control" name="sdate" id="sdate" value="{{date('Y-m-d', strtotime($sdate))}}" required>
                                </div>
                                <div class="col-12">
                                    <br />
                                    <label>Tanggal Akhir</label>
                                    <input type="date" class="form-control" name="edate" id="edate" value="{{date('Y-m-d', strtotime($edate))}}" required>
                                </div>
                                <div class="col-12">
                                    <br />
                                    <label>Lokasi</label>
                                    <select class="form-control selects2" style="width: 100%;" name="lokasi" id="lokasi">
                                        <option value="all" selected>All</option>
                                        @foreach($lokasi as $lok)
                                        @if($lok->id_lokasi == $lokasi_input)
                                        <option value="{{$lok->id_lokasi}}" selected>{{$lok->id_lokasi}} - {{$lok->keterangan}}</option>
                                        @else
                                        <option value="{{$lok->id_lokasi}}">{{$lok->id_lokasi}} - {{$lok->keterangan}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <br />
                                        @if($item_transfer=='1')
                                        <input type="checkbox" name="item_transfer" id="item_transfer" value="1" class="form-check-input" checked></input>
                                        @else
                                        <input type="checkbox" name="item_transfer" id="item_transfer" value="1" class="form-check-input"></input>
                                        @endif
                                        <label>Include item transfer</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button onclick="kartuStok(this)" class="btn btn-flat btn-info float-right">Kartu Stok</button>
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
                                <h3 class="card-title">Kartu Stok</h3>
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
                                    <th>Trans</th>
                                    <th>Nomor</th>
                                    <th>Tanggal</th>
                                    <th>Gudang</th>
                                    <th>Debet</th>
                                    <th>Nilai Debet</th>
                                    <th>Kredit</th>
                                    <th>Nilai Kredit</th>
                                    <th>Saldo</th>
                                    <th>Nilai Saldo</th>
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
    var rute = "{{ URL::to('kartuStok/data/populate') }}";
    var base_url = "{{ route('inventory') }}";
    var url_default = "{{ URL('') }}";
</script>
<script src="{{ asset('js/master/inventory/inventoryKartuStok-table.js')}}"></script>
@endpush