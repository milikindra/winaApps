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
                            <div class="col-12"><a href="{{ route('employeeAdd')}}" class="btn btn-info btn-sm btn-block">
                                    Add Employee
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
                                <h3 class="card-title">Employee Data</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="datatables" class="table table-bordered table-striped tbl-sm" width="100%">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>Employee Id</th>
                                    <th>Full Name</th>
                                    <th>Nationalty Id</th>
                                    <th>Date Birth</th>
                                    <th>Blood Type</th>
                                    <th>Religion</th>
                                    <th>Address</th>
                                    <th>Telp.</th>
                                    <th>Department</th>
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
    var rute = "{{ URL::to('employee/data/populate') }}";
    var base_url = "{{ route('employee') }}";
    var url_default = "{{ URL('') }}";
    var fullDate = new Date();
    var twoDigitMonth = ("0" + (fullDate.getMonth() + 1)).slice(-2);
    var lastDay = new Date(fullDate.getFullYear(), fullDate.getMonth() + 1, 0);
    var sdate = "01" + "-" + twoDigitMonth + "-" + fullDate.getFullYear();
    var edate = lastDay.getDate() + "-" + twoDigitMonth + "-" + fullDate.getFullYear();
</script>
<script src="{{ asset('js/master/employee/employee-table.js')}}"></script>
@endpush