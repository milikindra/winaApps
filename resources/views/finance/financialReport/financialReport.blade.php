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
<form action="{{ route('financialReport/export') }}" method="POST" enctype="multipart/form-data" target="_blank">
    @csrf
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
                                        @if (hasAccess('FY01.01'))
                                        <option value="appIncomeStatement">Income Statement</option>
                                        @endif
                                        @if (hasAccess('FY02.01'))
                                        <option value="appBalanceSheet">Balance Sheet</option>
                                        @endif
                                        @if (hasAccess('FY03.01'))
                                        <option value="appProjectPnl">Project PNL</option>
                                        @endif
                                        @if (hasAccess('FY04.01'))
                                        <option value="appProjectPnlList">Project PNL (List)</option>
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
                                <div class="col-12" id="filterSdate" style="display: none;">
                                    <label>Start Date</label>
                                    <input type="date" class="form-control" id="sdate" name="sdate" min="2000-01-01" value="{{date('Y-m-01')}}">
                                </div>
                                <div class="col-12" id="filterEdate" style="display: none;">
                                    <label>End Date</label>
                                    <input type="date" class="form-control" id="edate" name="edate" value="{{date('Y-m-d')}}">
                                    <br />
                                </div>

                                <div class="col-12" id="filterTotal" style="display: none;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="isTotal" value="Y" name="isTotal">
                                        <label>Show Total Only</label>
                                    </div>
                                </div>
                                <div class="col-12" id="filterParent" style="display: none;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="isParent" value="Y" name="isParent" checked>
                                        <label>Show Parent</label>
                                    </div>
                                </div>
                                <div class="col-12" id="filterChild" style="display: none;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="isChild" value="Y" name="isChild" checked>
                                        <label>Show Child</label>
                                    </div>
                                </div>
                                <div class="col-12" id="filterZero" style="display: none;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="isZero" value="Y" name="isZero">
                                        <label>Include Zero Balance</label>
                                    </div>
                                </div>
                                <div class="col-12" id="filterTotalParrent" style="display: none;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="isTotalParent" value="Y" name="isTotalParent" checked>
                                        <label>Show Total On Parent</label>
                                    </div>
                                </div>
                                <div class="col-12" id="filterPercent" style="display: none;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="isPercent" value="Y" name="isPercent" checked>
                                        <label>Show Percent</label>
                                    </div>
                                </div>
                                <div class="col-12" id="filterValas" style="display: none;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="isValas" value="Y" name="isValas">
                                        <label>Show Valas Value</label>
                                    </div>
                                </div>
                                <div class="col-12" id="filterShowCoa" style="display: none;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="isShowCoa" value="Y" name="isShowCoa">
                                        <label>Show COA</label>
                                    </div>
                                </div>
                                <div class="col-12" id="filterSo" style="display: none;">
                                    <label>SO</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="so_id" name="so_id" onchange="getPnlProject()" readonly>
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-info" onclick="modalSo()"><i class="fas fa-search"></i></button>
                                        </span>
                                    </div>
                                    <br />
                                    <span id="so_descrription" class="border border-gray rounded" width="100%" style="display: none;"></span>
                                    <br />
                                </div>

                                <div class="col-12" id="filterShowCoa" style="display: none;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="isShowCoa" value="Y" name="isShowCoa">
                                        <label>Show COA</label>
                                    </div>
                                </div>

                                <div class="col-12" id="filterAssumptionCost" style="display: none;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="isAssumptionCost" value="Y" name="isAssumptionCost" checked>
                                        <label>Include Assumption Cost</label>
                                    </div>
                                </div>

                                <div class="col-12" id="filterOverhead" style="display: none;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="isOverhead" value="Y" name="isOverhead">
                                        <label>Include Overhead</label>
                                    </div>
                                </div>

                                <div class="col-12" id="filterCommision" style="display: none;">
                                    <table class="table filterCommision table-modal" id="filterCommision" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="width:50%">Description</th>
                                                <th style="width:30%">Value</th>
                                                <th style="width:20%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <table width="100%">
                                        <tfoot>
                                            <tr>
                                                <td style="width: 50%;">
                                                </td>
                                                <td style="width: 50%;">
                                                    <a href="javascript:void(0)" onclick="removeRowCommision(this)" class="btn btn-xs btn-warning float-right" title="remove row"><i class="fa fa-minus"></i></a>
                                                    <a href="javascript:void(0)" onclick="addRowCommision(this)" class="btn btn-xs btn-info float-right" title="add row"><i class="fa fa-plus"></i></a>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="col-12" id="filterPh" style="display: none;">
                                    <label>Note PH</label>
                                    <textarea class="form-control" id="notePh" name="notePh"></textarea>
                                </div>

                                <div class="col-12">
                                    <br />
                                    <a href="javascript:void(0)" class="btn btn-info float-right" id="processFilter" onclick="dataReport()">Process</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-10" style="display: none;" id="appIncomeStatement">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="card-title">Income Statement</h3>
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
                                <button type="submit" class="btn btn-info" name="exportType" value="Print">Print</button>
                                <button type="submit" class="btn btn-info" name="exportType" value="Excel">Excel</button>
                            </div>
                            <br />
                            <br />
                            <table class="table tableIncomeStatement minpadding" id="tableIncomeStatement" style="width: 100%;">
                                <thead>
                                    <tr style="text-align: center;">
                                        <th id="no-sort" colspan="2">Description</th>
                                        <th colsapan="2">Balance</th>
                                    </tr>
                                    <tr style="display:none">
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
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

                <div class="col-lg-10" style="display: none;" id="appBalanceSheet">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="card-title">Balance Sheet</h3>
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
                                <button type="submit" class="btn btn-info" name="exportType" value="Print">Print</button>
                                <button type="submit" class="btn btn-info" name="exportType" value="Excel">Excel</button>
                            </div>
                            <br />
                            <br />
                            <table class="table tableBalanceSheet minpadding" id="tableBalanceSheet" style="width: 100%;">
                                <thead>
                                    <tr style="text-align: center;">
                                        <th id="no-sort" colspan="2">Description</th>
                                        <th colsapan="2">Balance</th>
                                    </tr>
                                    <tr style="display:none">
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
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

                <div class="col-lg-10" style="display: none;" id="appProjectPnl">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="card-title">Project Profit And Loss</h3>
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
                                <button type="submit" class="btn btn-info" name="exportType" value="Print">Print</button>
                                <button type="submit" class="btn btn-info" name="exportType" value="Excel">Excel</button>
                            </div>
                            <br />
                            <br />
                            <table class="table tablePnlProject minpadding " id="tablePnlProject" style="width: 100%;">
                                <thead>
                                    <tr style="text-align: center;">
                                        <th id="no-sort">Description</th>
                                        <th colsapan="2">Balance</th>
                                    </tr>
                                    <tr style="display:none">
                                        <th></th>
                                        <th></th>
                                        <th></th>
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
</form>
@endsection
@push('other-modal')
@include('modalBox.modalSalesOrder')
@endpush
@push('other-script')
<script>
    var rute_incomeStatement = "{{ URL::to('financialReport/data/populateIncomeStatement') }}";
    var rute_balanceSheet = "{{ URL::to('financialReport/data/populateBalanceSheet') }}";
    var rute_pnlProjectTable = "{{ URL::to('financialReport/data/populatePnlProject') }}";
    var rute_pnlProjectSave = "{{ URL::to('pnlProjectSave') }}";
</script>
<script src="{{ asset('js/custom/salesOrder.js')}}"></script>
<script src="{{ asset('js/finance/financialReport/financialReport.js')}}"></script>
@endpush