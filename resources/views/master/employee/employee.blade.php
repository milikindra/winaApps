@extends('template.main-template')

@section('main-content')
<div class="container-xl">
    <!-- Page title -->
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    {{ $parent_page }}
                </div>
                <h2 class="page-title">
                    {{ $title }}
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="#" class="btn btn-outline-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-registration">
                        <i class="ti ti-plus"></i>
                        Tambah Karyawan
                    </a>
                    <a href="#" class="btn btn-outline-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-registration" aria-label="Tambah Karyawan">
                        <i class="ti ti-plus"></i>
                    </a>
                    <!-- <a href="#" class="btn btn-outline-seccondary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-filter">
                        <i class="ti ti-filter"></i>
                        Filter
                    </a>
                    <a href="#" class="btn btn-outline-seccondary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-filter" aria-label="Filter">
                        <i class="ti ti-filter"></i>
                    </a> -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{$title}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table class="table card-table table-vcenter text-nowrap datatable" id="datatables">
                                <thead>
                                    <tr>
                                        <th>Id Karyawan</th>
                                        <th>Nama Lengkap</th>
                                        <th>NIK</th>
                                        <th>Tempat & tanggal Lahir</th>
                                        <th>JK</th>
                                        <th>Gol. Darah</th>
                                        <th>Alamat</th>
                                        <th>Telp</th>
                                        <th>SIM</th>
                                        <th>Kode PTKP</th>
                                        <th>NPWP</th>
                                        <th></th>
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
    </div>
</div>

{{-- Modal --}}
<div class="modal modal-blur fade" id="modal-registration" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Formulir Registrasi Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="example-text-input" placeholder="Your report name">
                </div>
            </div>
            <div class="modal-body">
                <label class="form-label">Report type</label>
                <div class="form-selectgroup-boxes row mb-3">
                    <div class="col-lg-6">
                        <label class="form-selectgroup-item">
                            <input type="radio" name="report-type" value="1" class="form-selectgroup-input" checked>
                            <span class="form-selectgroup-label d-flex align-items-center p-3">
                                <span class="me-3">
                                    <span class="form-selectgroup-check"></span>
                                </span>
                                <span class="form-selectgroup-label-content">
                                    <span class="form-selectgroup-title strong mb-1">Simple</span>
                                    <span class="d-block text-muted">Provide only basic data needed for the
                                        report</span>
                                </span>
                            </span>
                        </label>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-selectgroup-item">
                            <input type="radio" name="report-type" value="1" class="form-selectgroup-input">
                            <span class="form-selectgroup-label d-flex align-items-center p-3">
                                <span class="me-3">
                                    <span class="form-selectgroup-check"></span>
                                </span>
                                <span class="form-selectgroup-label-content">
                                    <span class="form-selectgroup-title strong mb-1">Advanced</span>
                                    <span class="d-block text-muted">Insert charts and additional advanced analyses to
                                        be inserted in the report</span>
                                </span>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label class="form-label">Report url</label>
                            <div class="input-group input-group-flat">
                                <span class="input-group-text">
                                    https://tabler.io/reports/
                                </span>
                                <input type="text" class="form-control ps-0" value="report-01" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Visibility</label>
                            <select class="form-select">
                                <option value="1" selected>Private</option>
                                <option value="2">Public</option>
                                <option value="3">Hidden</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Client name</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Reporting period</label>
                            <input type="date" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div>
                            <label class="form-label">Additional information</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-outline-warning " data-bs-dismiss="modal">
                    Cancel
                </a>
                <a href="#" class="btn btn-outline-primary ms-auto" data-bs-dismiss="modal">
                    Process
                </a>
            </div>
        </div>
    </div>
</div>
<!-- 
<div class="modal modal-blur fade" id="modal-registration" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="example-text-input" placeholder="Your report name">
                </div>
                <label class="form-label">Report type</label>
                <div class="form-selectgroup-boxes row mb-3">
                    <div class="col-lg-6">
                        <label class="form-selectgroup-item">
                            <input type="radio" name="report-type" value="1" class="form-selectgroup-input" checked>
                            <span class="form-selectgroup-label d-flex align-items-center p-3">
                                <span class="me-3">
                                    <span class="form-selectgroup-check"></span>
                                </span>
                                <span class="form-selectgroup-label-content">
                                    <span class="form-selectgroup-title strong mb-1">Simple</span>
                                    <span class="d-block text-muted">Provide only basic data needed for the
                                        report</span>
                                </span>
                            </span>
                        </label>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-selectgroup-item">
                            <input type="radio" name="report-type" value="1" class="form-selectgroup-input">
                            <span class="form-selectgroup-label d-flex align-items-center p-3">
                                <span class="me-3">
                                    <span class="form-selectgroup-check"></span>
                                </span>
                                <span class="form-selectgroup-label-content">
                                    <span class="form-selectgroup-title strong mb-1">Advanced</span>
                                    <span class="d-block text-muted">Insert charts and additional advanced analyses to
                                        be inserted in the report</span>
                                </span>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label class="form-label">Report url</label>
                            <div class="input-group input-group-flat">
                                <span class="input-group-text">
                                    https://tabler.io/reports/
                                </span>
                                <input type="text" class="form-control ps-0" value="report-01" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Visibility</label>
                            <select class="form-select">
                                <option value="1" selected>Private</option>
                                <option value="2">Public</option>
                                <option value="3">Hidden</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Client name</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Reporting period</label>
                            <input type="date" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div>
                            <label class="form-label">Additional information</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-outline-warning " data-bs-dismiss="modal">
                    Cancel
                </a>
                <a href="#" class="btn btn-outline-primary ms-auto" data-bs-dismiss="modal">
                    <i class="ti ti-plus"></i>
                    Create new report
                </a>
            </div>
        </div>
    </div>
</div> -->
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