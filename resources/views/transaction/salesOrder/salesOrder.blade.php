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
                        <div class="row">
                            <div class="col-12"><a href="{{ route('salesOrderAdd')}}" class="btn btn-info btn-sm btn-block">
                                    New Sales Order
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="card-title">Filter Data</h5>
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
                                    <input type="checkbox" class="form-check-input" id="void">
                                    <label for="void" class="form-check-label">Show Detail</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr class="half-break" />
                                <label>Category</label>
                                <select class="form-control form-control-sm selects2" id="kategoriFilter" style="width: 100%;">
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
                                <h5 class="card-title">Filter SO</h5>
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
                                    <input type="checkbox" class="form-check-input" id="fdate">
                                    <label for="fdate" class="form-check-label">Filter By Date</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <hr class="half-break" />
                                <label>Start Date</label>
                                <input type="date" class="form-control form-control-sm" name="sdate" id="sdate" value="{{date('Y-m-01')}}" required>
                            </div>
                            <div class="col-12">
                                <hr class="half-break" />
                                <label>End Date</label>
                                <input type="date" class="form-control form-control-sm" name="edate" id="edate" value="{{date('Y-m-d')}}" required>
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
                                <h5 class="card-title">Data Sales Order</h5>
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
                        <table id="datatables" class="table table-bordered table-hover minpadding table-hover tbl-sm scroly" style="cursor:pointer" width="100%">
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
    var view_url = "{{URL::to('salesOrderEdit')}}";
    var url_default = "{{ URL('') }}";
</script>
<script src="{{ asset('js/transaction/salesOrder/salesOrder-table.js')}}"></script>
@endpush