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
                                <select class="form-control selects2" style="width: 100%;" name="dataType" id="dataType">
                                    <option value="" selected disabled></option>
                                    @if (hasAccess('FX01.01'))
                                    <option value="appAccountHistory">Account History</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

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
                        <div class="row">
                            <div class="col-12">
                                <label>Tanggal Awal</label>
                                <input type="date" class="form-control" id="sdate" name="sdate" min="2000-01-01" value="{{date('Y-m-01')}}">
                            </div>
                            <div class="col-12">
                                <label>Tanggal Akhir</label>
                                <input type="date" class="form-control" id="edate" name="edate" value="{{date('Y-m-d')}}">
                                <br />
                            </div>
                            <div class="col-12 filterGlHead">
                            </div>
                            <div class="col-12">
                                <label>Nomor SO</label>
                                <input type="text" class="form-control" id="so_id" name="so_id" onclick="modalSo()">
                            </div>
                            <div class="col-12">
                                <label>Karyawan</label>
                                <select class="form-control selects2" id="id_employee" name="id_employee">
                                    <option selected disabled></option>
                                    @foreach($employee as $e)
                                    <option value="{{$e->username}}">{{$e->full_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label>Department</label>
                                <select class="form-control selects2" id="dept_id" name="dept_id">
                                    <option selected disabled></option>
                                    @foreach($dept as $e)
                                    <option value="{{$e->kode}}">{{$e->keterangan}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <br />
                                <a href="javascript:void(0)" class="btn btn-info float-right" id="processFilter" onclick="dataReport()">Process</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-10" style="display: none;" id="appAccountHistory">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="card-title">Account History</h3>
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
                        <table class="table tabelAccountHistory" id="tabelAccountHistory" style="width: 100%;">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>Flag Transaction</th>
                                    <th>No. Rekening</th>
                                    <th>Nama Rekening</th>
                                    <th>Nomor</th>
                                    <th>Tanggal</th>
                                    <th>No. SO</th>
                                    <th>Id Karyawan</th>
                                    <th>No. Pajak</th>
                                    <th>Tag</th>
                                    <th>Uraian</th>
                                    <th>Nilai Debet</th>
                                    <th>Debet Valas</th>
                                    <th>Nilai Kredit</th>
                                    <th>Kredit Valas</th>
                                    <th>Saldo</th>
                                    <th>Saldo Valas</th>
                                    <th>Dept</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer ">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('other-modal')
@include('modalBox.modalAccountGl')
@include('modalBox.modalSalesOrder')
@endpush
@push('other-script')
<script>
    var rute_accountHistory = "{{ URL::to('generalLedger/data/populateAccountHistory') }}";
</script>
<script src="{{ asset('js/custom/accountGl.js')}}"></script>
<script src="{{ asset('js/custom/salesOrder.js')}}"></script>
<script src="{{ asset('js/finance/generalLedger/generalLedger.js')}}"></script>
@endpush