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
                            <div class="col-12"><a href="{{ route('salesOrderAdd')}}" class="btn btn-info btn-sm btn-block">
                                    Tambah Sales Order
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
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
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input custom-control-input-info" id="void">
                                    <label for="void" class="custom-control-label">Show Detail</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <br />
                                <label>Kategori</label>
                                <select class="form-control selects2" id="kategoriFilter" width="100%">
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
                        <div class="row">
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input custom-control-input-info" type="checkbox" id="fdate" checked>
                                    <label for="fdate" class="custom-control-label">Filter Tanggal</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <br />
                                <label>Tanggal Awal</label>
                                <input type="date" class="form-control" name="sdate" id="sdate" value="{{date('Y-m-01')}}" required>
                            </div>
                            <div class="col-12">
                                <br />
                                <label>Tanggal Akhir</label>
                                <input type="date" class="form-control" name="edate" id="edate" value="{{date('Y-m-d')}}" required>
                            </div>
                        </div>
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
                        <table id="datatables" class="table table-bordered table-striped table-hover" style="cursor:pointer" width="100%">
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
@endsection
@push('other-script')
<script>
    var rute = "{{ URL::to('salesOrder/data/populate') }}";
    var base_url = "{{ route('salesOrder') }}";
    var view_url = "{{URL::to('salesOrderDetail')}}";
    var url_default = "{{ URL('') }}";
</script>
<script src="{{ asset('js/transaction/salesOrder/salesOrder-table.js')}}"></script>
@endpush