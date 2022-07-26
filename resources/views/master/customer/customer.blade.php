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
                        <div class="row margbot-5">
                            <div class="col-12">
                                <a href="javascript:void(0)" class="btn btn-info  btn-sm btn-block" onclick="customerAdd()">
                                    Add Customer
                                </a>
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
                                <h3 class="card-title">Customer Data</h3>
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
                        <table id="datatables" style="width: 100%;" class="table table-bordered table-hover tbl-sm sroly">
                            <thead>
                                <tr style="text-align: center;">
                                    <th width="10%">Code</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Tax Code</th>
                                    <th>T.O.P</th>
                                    <th>Sales</th>
                                    <th>NPWP</th>
                                    <th>Nationality Id</th>
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
<!-- modal -->
<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form method="POST" id="formCustomer" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="kodeOld" name="kodeOld" required>
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="titleCustomer"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group row margbot-5">
                            <label class="col-sm-1">Code</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control form-control-sm" name="kode" id="kode" placeholder="Insert Code" required>
                            </div>
                            <label class="col-sm-1">Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-sm" name="full_name" id="full_name" placeholder="Insert Name" required>
                            </div>
                            <div class="col-sm-1">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="aktif" id="aktif" checked></input>
                                    <label class="form-check-label">ACTIVE</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row margbot-5">
                            <label class="col-sm-1">Address</label>
                            <div class="col-sm-9">
                                <textarea class="form-control form-control-sm" rows="1" name="address" id="address"></textarea>
                            </div>
                        </div>
                        <div class="form-group row margbot-5">
                            <label class="col-sm-1">Phone</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control form-control-sm numaja" name="telp" id="telp" placeholder="Insert Phone Number">
                            </div>
                            <label class="col-sm-1">Fax</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control form-control-sm numaja" name="fax" id="fax" placeholder="Insert Fax Number">
                            </div>
                        </div>
                        <div class="form-group row margbot-5">
                            <label class="col-sm-1">T.O.P</label>
                            <div class="col-sm-2">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control form-control-sm numajadesimal" name="tempo" id="tempo" placeholder="Insert Term of Payment" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Days</span>
                                    </div>
                                </div>
                            </div>
                            <label class="col-sm-1">Limit (Rp.)</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control form-control-sm numajadesimal" name="limit" id="limit" placeholder="Insert Limit Payment" value="0">
                            </div>
                            <label class="col-sm-1" style="vertical-align: bottom;"><small><i>Rp. 0 = unlimited</i></small></label>
                        </div>
                        <div class="form-group row margbot-5">
                            <label class="col-sm-1">Sales</label>
                            <div class="col-sm-2">
                                <select class="form-control form-control-sm form-control-border selects2" id="sales" name="sales" style="width: 100%;" onchange="" required>
                                    <option selected disabled></option>
                                    @foreach($sales as $s)
                                    <option value="{{$s->ID_SALES}}">{{$s->ID_SALES." (".$s->NM_SALES.")"}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-sm-1">Type</label>
                            <div class="col-sm-2">
                                <select class="form-control form-control-sm" name="type" id="type">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D" selected>D</option>
                                </select>
                            </div>
                            <label class="col-sm-1">Area</label>
                            <div class="col-sm-2">
                                <select class="form-control form-control-sm form-control-border selects2" id="area" name="area" style="width: 100%;" onchange="" required>
                                    @foreach($area as $s)
                                    <option value="{{$s->kode}}">{{$s->keterangan}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row margbot-5">
                            <label class="col-sm-1">Currency</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control form-control-sm" name="curr" id="curr" placeholder="Insert Currency">
                            </div>
                            <label class="col-sm-1">Tax Code</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control form-control-sm" name="tax_code" id="tax_code" placeholder="Insert Tax Code">
                            </div>
                            <div class="col-sm-1">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="wapu" id="wapu"></input>
                                    <label class="form-check-label">WAPU</label>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="berikat" id="berikat"></input>
                                    <label class="form-check-label">BERIKAT</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row margbot-5">
                            <label class="col-sm-1">Alias</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control form-control-sm numajadesimal" name="alias" id="alias" placeholder="Insert Alias">
                            </div>
                        </div>
                        <hr />
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#company" role="tab" aria-controls="company" aria-selected="true">Factory Data</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="personal-tab" data-toggle="pill" href="#personal" role="tab" aria-controls="personal" aria-selected="false">NPWP/NIK</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="branch-tab" data-toggle="pill" href="#branch" role="tab" aria-controls="branch" aria-selected="false">Branch</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="notes-tab" data-toggle="pill" href="#notes" role="tab" aria-controls="notes" aria-selected="false">Note</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="custom-content-below-tabContent">
                                <div class="tab-pane fade active show" id="company" role="tabpanel" aria-labelledby="company-tab">
                                    <br />
                                    <div class="form-group row margbot-5">
                                        <label class="col-sm-1"></label>
                                        <label class="col-sm-1">Address</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm" name="address_company" id="address_company">
                                        </div>
                                        <label class="col-sm-1">District</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm" name="district_company" id="district_company">
                                        </div>
                                    </div>
                                    <div class="form-group row margbot-5">
                                        <label class="col-sm-1"></label>
                                        <label class="col-sm-1">City</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm" name="city_company" id="city_company">
                                        </div>
                                        <label class="col-sm-1">Province</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm" name="province_company" id="province_company">
                                        </div>
                                    </div>
                                    <div class="form-group row margbot-5">
                                        <label class="col-sm-1"></label>
                                        <label class="col-sm-1">Phone</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm" name="phone_company" id="phone_company">
                                        </div>
                                        <label class="col-sm-1">Fax</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm" name="fax_company" id="fax_company">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                                    <br />
                                    <div class="form-group row margbot-5">
                                        <label class="col-sm-1"></label>
                                        <label class="col-sm-1">Tax Number (NPWP)</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm" name="tax_number" id="tax_number">
                                        </div>
                                    </div>
                                    <div class="form-group row margbot-5">
                                        <label class="col-sm-1"></label>
                                        <label class="col-sm-1">Name</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm" name="tax_name" id="tax_name">
                                        </div>
                                    </div>
                                    <div class="form-group row margbot-5">
                                        <label class="col-sm-1"></label>
                                        <label class="col-sm-1">Address</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm" name="tax_address" id="tax_address">
                                        </div>
                                    </div>

                                    <div class="form-group row margbot-5">
                                        <label class="col-sm-1"></label>
                                        <label class="col-sm-1">Nationality Id (NIK)</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm numaja" name="tax_nationalityId" id="tax_nationalityId">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="branch" role="tabpanel" aria-labelledby="branch-tab">
                                    <br />
                                    <div class="form-group row margbot-5">
                                        <table class="table trxBranch table-modal" id="trxBranch" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%">Branch Name</th>
                                                    <th style="width: 10%">Branch Address</th>
                                                    <th style="width: 2%">Branch Tax Number (NPWP)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 100%;">
                                                    <a href="javascript:void(0)" onclick="removeRowChild(this)" class="btn btn-xs btn-warning float-right" title="remove row"><i class="fa fa-minus"></i></a>
                                                    <a href="javascript:void(0)" onclick="addRowChild(this)" class="btn btn-xs btn-info float-right" title="add row"><i class="fa fa-plus"></i></a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
                                    <br />
                                    <div class="form-group row margbot-5">
                                        <label class="col-sm-1"></label>
                                        <label class="col-sm-1">Type of Bussiness</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm" name="type_of_bussiness" id="type_of_bussiness">
                                        </div>
                                    </div>
                                    <div class="form-group row margbot-5">
                                        <label class="col-sm-1"></label>
                                        <label class="col-sm-1">Description</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm" name="description_bussiness" id="description_bussiness">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" style="text-align:left;" data-dismiss="modal">Close</button>
                            <button type="submit" id="btnAddSave" class="btn btn-info">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal -->
@endsection
@push('other-modal')
@endpush
@push('other-script')
<script>
    var rute = "{{ URL::to('customer/data/populate') }}";
    var save_customer = "{{ route('customerAddSave') }}";
    var update_customer = "{{ route('customerUpdate') }}";
    var rute_edit = "{{ URL::to('customer/data/edit') }}";
    var base_url = "{{ route('customer') }}";
    var url_default = "{{ URL('') }}";
</script>
<script src="{{ asset('js/master/customer/customer-table.js?')}}"></script>
<script src="{{ asset('js/master/customer/customer-add.js?')}}"></script>
@endpush