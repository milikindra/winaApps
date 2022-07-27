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
                            <div class="col-12"><a href="" class="btn btn-info btn-sm btn-block">
                                    Add Vat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="card-title">Vat Data</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="datatables" class="table table-bordered table-striped tbl-sm" width="100%">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>Code</th>
                                    <th>Vat</th>
                                    <th>%</th>
                                    <th>Effective Date</th>
                                    <th>Option</th>
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
    var rute = "{{ URL::to('vat/data/populate') }}";
    var base_url = "{{ route('vat') }}";
    var url_default = "{{ URL('') }}";
</script>
<script src="{{ asset('js/master/vat/vat-table.js')}}"></script>
@endpush