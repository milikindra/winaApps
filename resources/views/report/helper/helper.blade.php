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
                                <label>Report</label>
                                <select class="form-control selects2" style="width: 100%;" name="reportType" id="reportType">
                                    <option selected disabled></option>
                                    @if (hasAccess('RY01.01'))
                                    <option value="appTransmitalReceipt">Transmital Receipt</option>
                                    @endif
                                    @if (hasAccess('RY02.01'))
                                    <option value="appOfferingLetter">Offering Letter</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-10" style="display: none;" id="appTransmitalReceipt">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="card-title">Transmital Receipt</h3>
                                <div class="card-tools float-right">
                                    <a href="javascript:void(0)" onclick="window.location.reload()" class="btn btn-tool" title="Reset Page">
                                        <i class="fas fa-sync-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <form action="{{ route('reportTransmitalReceipt') }}" method="POST" enctype="multipart/form-data" target="_blank" id="frmTransmitalReceipt">
                        @csrf
                        <div class="card-body">
                            <div class="container-fluid">
                                <input type="hidden" name="type" id="type" required>
                                <div class="form-group row" style="margin:0px;">
                                    <label class="col-sm-2 col-form-label">Customer</label>
                                    <div class="col-sm-4">
                                        <input type="hidden" name="trNmCustomer" id="trNmCustomer" required>
                                        <select class="form-control form-control-sm selects2 form-control-border" style="width: 100%;" name="trCustomer" id="trCustomer" required>
                                            <option selected disabled></option>
                                            @foreach($customer as $c)
                                            <option value="{{$c->ID_CUST}}">{{$c->NM_CUST}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row" style="margin:0px;">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-4">
                                        <textarea class="form-control form-control-sm form-control-border" name="trAddress" id="trAddress"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row" style="margin:0px;">
                                    <label class="col-sm-2 col-form-label">To</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm form-control-border" name="trTo" id="trTo" value="Accounting/Finnance Dept" required>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div class="container-fluid">
                                <datalist id="si">
                                </datalist>
                                <table class="table table-bordered tr" id="tr" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th width="5%" style="text-align: center;">No.</th>
                                            <th width="40%" style="text-align: center;">Document</th>
                                            <th style="text-align: center;">Description</th>
                                            <th width="1%" style=" text-align: center;"></th>
                                        </tr>
                                    </thead>
                                </table>
                                <table width=" 100%">
                                    <tr>
                                        <td style="width: 100%; ">
                                            <a href="javascript:void(0)" onclick="removeRowTrTbody(this)" class="btn btn-xs btn-warning float-right" title="remove row"><i class="fa fa-minus"></i></a>
                                            <a href="javascript:void(0)" onclick="addRowTrTbody(this)" class="btn btn-xs btn-info float-right" title="add row"><i class="fa fa-plus"></i></a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="container-fluid">
                                <div class="form-group row justify-content-md-center">
                                    <div class="col-sm-8">
                                        <input class="custom-control-input custom-control-input-dark custom-control-input-outline" type="checkbox" id="trReturnCb">
                                        <label for="trReturnCb" class="custom-control-label">PLEASE RETURN DUPLICATE COPY THIS TRANSMITAL WITH SIGNATURE </label>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-md-center">
                                    <div class="col-sm-8 form-inline">
                                        <input class="custom-control-input custom-control-input-dark custom-control-input-outline" type="checkbox" id="trEmailCb">
                                        <label for="trEmailCb" class="custom-control-label">Email to : </label>
                                        <input type="email" class="form-control form-control-sm form-control-border" name="trEmailCb" style="width: 40%;" id="trEmailCb" value="finance-ar@viktori-automation.com">
                                    </div>
                                </div>
                                <div class="form-group row" style="margin:0px;">
                                    <label class="col-sm-2 col-form-label">Received By</label>
                                </div>
                                <div class="form-group row" style="margin:0px;">
                                    <label class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm form-control-border" name="trReceivedName" id="trReceivedName">
                                    </div>
                                    <label class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm form-control-border" name="trSenderdName" id="trSenderdName" value="{{session('user')->full_name}}" required>
                                    </div>
                                </div>
                                <div class="form-group row" style="margin:0px;">
                                    <label class="col-sm-2 col-form-label">Date</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm form-control-border" name="trReceiveDate" id="trReceiveDate">
                                    </div>
                                    <label class="col-sm-2 col-form-label">Date</label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control form-control-sm form-control-border" name="trSenderDate" id="trSenderDate" value="{{date('Y-m-d')}}" required>
                                    </div>
                                </div>
                                <div class="form-group row" style="margin:0px;">
                                    <label class="col-sm-2 col-form-label">Signature</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm form-control-border" name="trSignature" id="trSignature">
                                    </div>
                                    <label class="col-sm-2 col-form-label">Signature</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm form-control-border" name="trSignature" id="trSignature">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <button type="submit" name="action" id="printTransmitalReceipt" value="print" class="btn btn-warning float-right"><i class="fa fa-print"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-10" style="display: none;" id="appOfferingLetter">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="card-title">Offering Letter</h3>
                                <div class="card-tools float-right">
                                    <a href="javascript:void(0)" onclick="window.location.reload()" class="btn btn-tool" title="Reset Page">
                                        <i class="fas fa-sync-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <form action="{{ route('reportOfferingLetter') }}" method="POST" enctype="multipart/form-data" target="_blank">
                        @csrf
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="form-group row" style="text-align:right">
                                    <label class="col-sm-1 col-form-label">Year</label>
                                    <div class="col-sm-2">
                                        <select class="form-control form-control-sm selects2 form-control-border" style="width: 100%;" name="olYear" id="olYear" required>
                                            <option selected disabled></option>
                                            <?php
                                            for ($i = (int)date('Y'); $i >= 2018; $i--) {
                                                echo '<option>' . $i . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Quotation Ref.</label>
                                    <div class="col-sm-2">
                                        <select class="form-control form-control-sm selects2 form-control-border" style="width: 100%;" name="olQuotationRef" id="olQuotationRef" required>
                                            <option selected disabled></option>
                                        </select>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Sequence No.</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control form-control-sm" name="olSequence" id="olSequence" placeholder="Q.135" required>
                                    </div>
                                </div>
                                <hr />
                                <div class="form-group row" style="text-align:right;margin:0;">
                                    <label class="col-sm-1 col-form-label">Customer</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-sm form-control-border" name="olCustomer" id="olCustomer" required>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Quotation No.</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control form-control-sm form-control-border" name="olQuotationSequence" id="olQuotationSequence" readonly>
                                    </div>
                                </div>
                                <div class="form-group row" style="text-align:right;margin:0;">
                                    <label class="col-sm-1 col-form-label"></label>
                                    <div class="col-sm-6"></div>
                                    <label class="col-sm-2 col-form-label">Customer Code</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control form-control-sm form-control-border" name="olCustomerCode" id="olCustomerCode">
                                    </div>
                                </div>
                                <div class="form-group row" style="text-align:right;margin:0;">
                                    <label class="col-sm-1 col-form-label"></label>
                                    <div class="col-sm-6"></div>
                                    <label class="col-sm-2 col-form-label">Date</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control form-control-sm form-control-border" name="olDate" id="olDate">
                                    </div>
                                </div>
                                <div class="form-group row" style="text-align:right;margin:0;">
                                    <label class="col-sm-1 col-form-label">Telp</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control form-control-sm form-control-border" name="olTelp" id="olTelp">
                                    </div>
                                    <label class="col-sm-2 col-form-label">Fax</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control form-control-sm form-control-border" name="olFax" id="olFax">
                                    </div>
                                    <label class="col-sm-2 col-form-label">Currency</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control form-control-sm form-control-border" name="olCurrency" id="olCurrency">
                                    </div>
                                </div>
                                <div class="form-group row" style="text-align:right;margin:0;">
                                    <label class="col-sm-1 col-form-label">Attn.</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control form-control-sm form-control-border" name="olAttn" id="olAttn">
                                    </div>
                                    <label class="col-sm-2 col-form-label">CC</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control form-control-sm form-control-border" name="olCc" id="olCc">
                                    </div>
                                    <label class="col-sm-2 col-form-label">Validty</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control form-control-sm form-control-border" name="olValidty" id="olValidty">
                                    </div>
                                </div>
                                <div class="form-group row" style="text-align:right;margin:0;">
                                    <label class="col-sm-1 col-form-label">Creator</label>
                                    <div class="col-sm-6"><input type="text" class="form-control form-control-sm form-control-border" name="olCreator" id="olCreator"></div>
                                    <label class="col-sm-2 col-form-label">Your Ref</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control form-control-sm form-control-border" name="olRef" id="olRef">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <button type="submit" name="action" value="print" class="btn btn-warning float-right"><i class="fa fa-print"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('other-script')
<script>
    var get_customer = "{{ URL::to('customerGetForSi') }}";
    var get_efaktur = "{{ URL::to('siGetEfaktur') }}";
    var get_quotation = "{{ URL::to('vintras/getQuotationByPeriod') }}";

    var customer = <?= json_encode($customer); ?>;
</script>
<script src="{{ asset('js/report/helper/helper.js')}}"></script>

@endpush