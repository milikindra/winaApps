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
                                    @if (hasAccess('FX02.01'))
                                    <option value="appCoaTransaction">COA Transaction</option>
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
                                <label>Start Date</label>
                                <input type="date" class="form-control" id="sdate" name="sdate" min="2000-01-01" value="{{date('Y-m-01')}}">
                            </div>
                            <div class="col-12">
                                <label>End Date</label>
                                <input type="date" class="form-control" id="edate" name="edate" value="{{date('Y-m-d')}}">
                                <br />
                            </div>
                            <div class="col-12 filterGlHead" id="filterAccount" style="display: none;">
                            </div>
                            <div class="col-12" id="filterSo" style="display: none;">
                                <label>SO</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="so_id" name="so_id">
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-info" onclick="modalSo()"><i class="fas fa-search"></i></button>
                                    </span>
                                </div>


                            </div>
                            <div class="col-12" id="filterEmployee" style="display:none;">
                                <label>Employee</label>
                                <select class="form-control selects2" id="id_employee" name="id_employee">
                                    <option selected disabled></option>
                                    @foreach($employee as $e)
                                    <option value="{{$e->username}}">{{$e->full_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12" id="filterDepartment" style="display: none;">
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
                        <div class="btn-group">
                            <a href="" class="btn btn-info">Print</a>
                            <a href="" class="btn btn-info">Excel</a>
                        </div>
                        <br />
                        <br />
                        <table class="table tableAccountHistory" id="tableAccountHistory" style="width: 100%;">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>No. Account</th>
                                    <th>Account Name</th>
                                    <th>Transaction Number</th>
                                    <th>Date</th>
                                    <th>SO</th>
                                    <th>Employee</th>
                                    <th>Description</th>
                                    <th>Debet (IDR)</th>
                                    <th>Credit (IDR)</th>
                                    <th>Saldo (IDR)</th>
                                    <th>Debet (Valas)</th>
                                    <th>Credit (Valas)</th>
                                    <th>Saldo (Valas)</th>
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

            <div class="col-lg-10" style="display: none;" id="appCoaTransaction">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="card-title">COA Transactian</h3>
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
                        <div class="btn-group">
                            <a href="" class="btn btn-info">Print</a>
                            <a href="" class="btn btn-info">Excel</a>
                        </div>
                        <br />
                        <br />
                        <table class="table tableCoaTransaction" id="tableCoaTransaction" style="width: 100%;">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>Transaction</th>
                                    <th>No. Account</th>
                                    <th>Account Name</th>
                                    <th>No. Account</th>
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Debet (IDR)</th>
                                    <th>Credit (IDR)</th>
                                    <th>Debet (Valas)</th>
                                    <th>Credit (Valas)</th>
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
    var rute_coaTransaction = "{{ URL::to('generalLedger/data/populateCoaTransaction') }}";
</script>
<script src="{{ asset('js/custom/accountGl.js')}}"></script>
<script src="{{ asset('js/custom/salesOrder.js')}}"></script>
<script src="{{ asset('js/finance/generalLedger/generalLedger.js')}}"></script>
@endpush