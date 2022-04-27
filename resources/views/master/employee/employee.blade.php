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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="card-title">Data Karyawan</h3>
                            </div>
                            <div class="col-6 ">
                                <h3 class="card-title float-right"><a class="btn btn-white btn-sm btn-flat" style="margin-left: 5px; padding:0" href="{{ route('employeeAdd')}}" title="Tambah Karyawan"><i class="fa fa-plus"></i></a></h3>
                                <h3 class="card-title float-right"><a class="btn btn-white btn-sm btn-flat" style="margin-left: 5px; padding:0" title="filter"><i class="fa fa-filter"></i></a></h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="datatables" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>ID Karyawan</th>
                                    <th>Nama Lengkap</th>
                                    <th>NIK</th>
                                    <th>Tempat, Tanggal Lahir</th>
                                    <th>Golongan Darah</th>
                                    <th>Agama</th>
                                    <th>Alamat</th>
                                    <th>Telp.</th>
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