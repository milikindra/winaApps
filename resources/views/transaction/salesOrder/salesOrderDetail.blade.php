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
<form action="{{ route('salesOrderUpdate') }}" method="POST" enctype="multipart/form-data" id="frmSo">
    @csrf
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="card-title">Detail Sales Order</h5>
                                    <div class="card-tools float-right">
                                        <a href="javascript:void(0)" onclick="window.location.reload()" class="btn btn-tool" title="Reset Page">
                                            <i class="fas fa-sync-alt"></i>
                                        </a>
                                        <a href="{{ route('salesOrder') }}" class="btn btn-tool" title="Back To The List">
                                            <i class="fas fa-reply"></i>
                                        </a>
                                        <a href="{{ route('salesOrderAdd') }}" class="btn btn-tool" title="Add New Sales Order">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-2">
                                    <!-- checkbox -->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>SO</label>
                                                <input type="text" class="form-control form-control-sm form-control-border" name="nomor" id="nomor" autofocus required value="{{$so->head[0]->NO_BUKTI}}">
                                                <input type="hidden" name="nomor_old" id="nomor_old" required value="{{$so->head[0]->NO_BUKTI}}" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <datalist id="customerList">
                                                </datalist>
                                                <label>Customer</label>
                                                <input type="hidden" name="customer_name" id="customer_name" autocomplete="off" value="{{$so->head[0]->NM_CUST}}" required>
                                                <input type="hidden" name="customer" id="customer" autocomplete="off" value="{{$so->head[0]->ID_CUST}}" required>
                                                <input class="form-control form-control-sm form-control-border" list="customerList" id="customerSearch" value="{{$so->head[0]->ID_CUST.' ('.$so->head[0]->NM_CUST.')'}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Attn</label>
                                                <input type="text" class="form-control form-control-sm form-control-border" name="attn" id="attn" value="{{$so->head[0]->attn}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Due</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control form-control-sm form-control-border" name="tempo" id="tempo" required value="{{$so->head[0]->TEMPO}}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Days</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Pay.Term</label>
                                                <input type="text" class="form-control form-control-sm form-control-border" name="payterm" id="payterm" value="CASH" required value="{{$so->head[0]->pay_Term}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Currency</label>
                                                <input type="text" class="form-control form-control-sm form-control-border" name="curr" id="curr" readonly value="{{$so->head[0]->curr}}">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Rate Rp.</label>
                                                <input type="text" class="form-control form-control-sm form-control-border" name="rate_cur" id="rate_cur" required value="{{$so->head[0]->rate}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Date</label>
                                                <input type="date" class="form-control form-control-sm form-control-border" name="date_order" id="date_order" required value="{{$so->head[0]->TGL_BUKTI}}" onchange="getTax()">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Due Date</label>
                                                <input type="date" class="form-control form-control-sm form-control-border" name="date_due" id="date_due" required value="{{$so->head[0]->tgl_due}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>PO Customer</label>
                                                <input type="text" class="form-control form-control-sm form-control-border" name="po_customer" id="po_customer" required value="{{$so->head[0]->PO_CUST}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Quotation Ref.</label>
                                                <input type="text" class="form-control form-control-sm form-control-border" name="quotation_ref" id="quotation_ref" required value="{{$so->head[0]->no_ref}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Type</label>
                                                <select class="form-control form-control-sm form-control-border selects2" id="jenis" name="jenis" style="width: 100%;" required>
                                                    @if($so->head[0]->jenis == 'CO')
                                                    <option value="CO" selected>Component</option>
                                                    <option value="PR">Project</option>
                                                    @else
                                                    <option value="CO">Component</option>
                                                    <option value="PR" selected>Project</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Customer Address</label>
                                                <textarea class="form-control form-control-sm" name="customer_address" id="customer_address" rows="4">{{$so->head[0]->ALAMAT1."\r\n".$so->head[0]->ALAMAT2."\r\n".$so->head[0]->KOTA."\r\n".$so->head[0]->PROPINSI}}
                                                </textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-check">
                                                    @if($so->head[0]->use_branch=='1')
                                                    <input type="checkbox" class="form-check-input" name="use_branch" id="use_branch" onchange="useBranch()" checked></input>
                                                    @else
                                                    <input type="checkbox" class="form-check-input" name="use_branch" id="use_branch" onchange="useBranch()"></input>
                                                    @endif
                                                    <label class="form-check-label">Use Branch</label>
                                                </div>
                                                <label>Ship To</label>
                                                <?php if ($so->head[0]->use_branch == '1') {
                                                    echo '<select class="form-control form-control-sm" id="cmbShipping" style="display: block;">';
                                                } else {
                                                    echo '<select class="form-control form-control-sm" id="cmbShipping" style="display: none;">';
                                                }
                                                foreach ($branch as $b) {
                                                    if ($b->address_alias == $so->head[0]->alamatkirim) {
                                                        echo "<option value='" . $b->other_address . "' selected>" . $b->address_alias . "</option>";
                                                    } else {
                                                        echo "<option value='" . $b->other_address . "'>" . $b->address_alias . "</option>";
                                                    }
                                                }
                                                ?>
                                                </select>
                                                <input type="hidden" name="cmbShipping" id="cmbShippingKey" required>
                                                <textarea class="form-control form-control-sm" name="ship_to" id="ship_to" rows="4" required>{{$so->head[0]->alamatkirim}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Sales</label>
                                                <input type="hidden" name="sales_name" id="sales_name" value="{{$so->head[0]->NM_SALES}}">
                                                <select class="form-control form-control-sm form-control-border selects2" id="sales" name="sales" style="width: 100%;" onchange="" required>
                                                    @foreach($sales as $s)
                                                    @if($s->ID_SALES == $so->head[0]->ID_SALES)
                                                    <option value="{{$s->ID_SALES}}" selected>{{$s->ID_SALES." (".$s->NM_SALES.")"}}</option>
                                                    @else
                                                    <option value="{{$s->ID_SALES}}">{{$s->ID_SALES." (".$s->NM_SALES.")"}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Bussiness Unit</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control form-control-sm form-control-border" name="bu" id="bu_val" required value="{{$so->head[0]->DIVISI}}">
                                                    <div class="input-group-append input-group-append-edit">
                                                        <button type="button" class="btn btn-info" id="bu_modal">
                                                            <i class="fa fa-search"></i> </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Dept.</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control form-control-sm form-control-border" name="dept" id="dept_val" required value="{{$so->head[0]->Dept}}">
                                                    <div class="input-group-append input-group-append-edit">
                                                        <a href="javascript:void(0)" class="btn btn-info" id="dept_modal"><i class="fa fa-search"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Tag</label>
                                                <input type="text" class="form-control form-control-sm form-control-border" name="tag" id="tag" value="{{$so->head[0]->tag}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <!-- <div class="row"> -->
                                            <div class="col-md-12">
                                                <label>Internal Notes</label>
                                                <textarea class="form-control form-control-sm" name="notes" id="notes" rows="4">{{$so->head[0]->KETERANGAN}}</textarea>
                                            </div>
                                            <!-- </div> -->
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row col-md-12">
                                                <div class="col-md-7">
                                                    <label>Attachment</label>
                                                </div>
                                                <div class="col-md-5">
                                                    <a href="javascript:void(0)" class="btn btn-xs btn-warning float-right" onclick="removeAttach(this)" title="remove row"><i class="fa fa-minus"></i></a>
                                                    <a href="javascript:void(0)" class="btn btn-xs btn-info float-right" onclick="addAttach(this)" title="add row"><i class="fa fa-plus"></i></a>
                                                </div>
                                            </div>
                                            <div class="row col-md-12 attachDownload" id="attachDownload">
                                                @foreach($so->attach as $attach)
                                                <a target="_blank" href="{{URL::to('getFile/'.base64_encode($attach->path)) }}"><i class="fa fa-download"></i> {{$attach->value}}</a>
                                                @endforeach
                                            </div>
                                            <div class="row col-md-12 attachUpload" id="attachUpload" style="display:none;">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="row">
                                            <br />
                                            <br />
                                            <div class="col-md-12" style="border: 0.5px #E9ECEF solid;">
                                                <table class="table down_payment table-modal" id="down_payment" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:35%">Down Payment</th>
                                                            <th style="width:35%">Value</th>
                                                            <th style="width:20%">Tax</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 0; ?>
                                                        @foreach($so->um as $um)
                                                        <tr>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm" name="dp[]" id="dp-{{$i}}" value="{{$um->keterangan}}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="dp_value[]" id="dp_value-{{$i}}" onchange="addDp({{$i}})" value="{{$um->nilai}}">
                                                            </td>
                                                            <td>
                                                                <select class="form-control form-control-sm tax" name="dp_tax[]" id="dp_tax-{{$i}}" onchange="addDp({{$i}})">
                                                                    @foreach($vat as $v)
                                                                    @if($v->kode == $um->tax)
                                                                    <option value="{{$v->kode}}" selected>{{$v->kode}}</option>
                                                                    @else
                                                                    <option value="{{$v->kode}}">{{$v->kode}}</option>
                                                                    @endif
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td id="dp_tax_value-{{$i}}" style="display:none"></td>
                                                        </tr>
                                                        <?php $i++; ?>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <table width="100%">
                                                    <tr>
                                                        <td style="width: 50%;">
                                                            <input type="hidden" value="0" id="totalDpTax" name="totalDpTax" readonly autocomplete="off">
                                                            <input type="text" class="form-control form-control-sm numajaDesimal" value="0" id="totalDp" name="totalDp" readonly>
                                                        </td>
                                                        <td style="width: 50%;">
                                                            <a href="javascript:void(0)" onclick="removeRowDp(this)" class="btn btn-xs btn-warning float-right" title="remove row"><i class="fa fa-minus"></i></a>
                                                            <a href="javascript:void(0)" onclick="addRowDp(this)" class="btn btn-xs btn-info float-right" title="add row"><i class="fa fa-plus"></i></a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12">
                                    <table class="table trx table-modal" id="trx" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Item</th>
                                                <th style="width: 10%">Name</th>
                                                <th style="width: 5%">Desc</th>
                                                <th style="width: 2%">Qty</th>
                                                <th style="width: 2%">UOM</th>
                                                <th style="width: 2%">Price</th>
                                                <th style="width: 2%">Disc % 1</th>
                                                <th style="width: 2%">Disc % 2</th>
                                                <th style="width: 2%">Disc</th>
                                                <th style="width: 2%">Total</th>
                                                <th style="width: 2%">Tax</th>
                                                <th style="width: 2%">State</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $j = 0; ?>
                                            @foreach($so->detail as $det)
                                            <?php
                                            $state = '';
                                            if ($det->state == 'F') {
                                                $state = 'Finish';
                                            } else if ($det->state == 'B') {
                                                $state = 'Cancel';
                                            } ?>
                                            @if($det->kode_group == '')
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" name="no_stock[]" id="no_stock-{{$j}}" onclick="addData({{$j}})" value="{{$det->NO_STOCK}}" readonly>
                                                </td>
                                                <td>
                                                    <textarea class="form-control form-control-sm r1" name="nm_stock[]" id="nm_stock-{{$j}}" rows="3">{{$det->NM_STOCK}} </textarea>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" name="ket[]" id="ket-{{$j}}" value="{{$det->KET}}">
                                                </td>
                                                <td>
                                                    <input type="hidden" name="base_qty[]" id="base_qty-{{$j}}" value="{{$det->QTY}}">
                                                    <input type="number" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="qty[]" onchange="itemTotal({{$j}});child({{$j}});" id="qty-{{$j}}" value="{{$det->QTY}}">
                                                </td>
                                                <td>
                                                    <input type=" text" class="form-control form-control-sm" name="sat[]" id="sat-{{$j}}" value="{{$det->SAT}}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="price[]" onload="itemTotal({{$j}})" onchange="itemTotal({{$j}})" id="price-{{$j}}" value="{{number_format($det->HARGA,2)}}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="disc[]" onchange="itemTotal({{$j}})" id="disc-{{$j}}" value="{{$det->DISC1}}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="disc2[]" onchange="itemTotal({{$j}})" id="disc2-{{$j}}" value="{{$det->DISC2}}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="disc_val[]" onchange="itemTotal({{$j}})" id="disc_val-{{$j}}" value="{{$det->DISCRP}}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="total[]" id="total-{{$j}}" value="{{$det->JUMLAH}}" readonly>
                                                </td>
                                                <td>
                                                    <select class="form-control form-control-sm tax" name="tax[]" id="tax-{{$j}}" onchange="itemTotal({{$j}})">
                                                        @foreach($vat as $v)
                                                        @if($v->kode == $det->tax)
                                                        <option value="{{$v->kode}}" selected>{{$v->kode}}</option>
                                                        @else
                                                        <option value="{{$v->kode}}">{{$v->kode}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" name="state[]" id="state-{{$j}}" value="{{$state}}" readonly>
                                                </td>
                                                <td style="display: none;" id="itemTotal-{{$j}}"></td>
                                                <td style="display: none;" id="itemTax-{{$j}}"></td>
                                                <td style="display: none;" id="itemDisc-{{$j}}"></td>
                                                <td style="display: none;" id="itemTotalDiscHead-{{$j}}"></td>
                                                <td style="display: none;" id="itemBruto-{{$j}}"></td>
                                                <td style="display: none;" id="itemTaxValue-{{$j}}"></td>
                                                <td style="display: none;"><input type="hidden" name="itemKodeGroup[]" id="itemKodeGroup-{{$j}}" value="{{$det->kode_group}}"> </td>
                                                <td style="display: none;"><input type="hidden" name="itemVintrasId[]" id="itemVintrasId-{{$j}}" value="{{$det->VINTRASID}}"> </td>
                                                <td style="display: none;"><input type="hidden" name="itemTahunVintras[]" id="itemTahunVintras-{{$j}}" value="{{$det->tahun}}"> </td>
                                                <td style="display: none;"><input type="hidden" name="merkItem[]" id="merkItem-{{$j}}" value="{{$det->merk}}"> </td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" name="no_stock[]" id="no_stock-{{$j}}" value="{{$det->NO_STOCK}}" readonly>
                                                </td>
                                                <td>
                                                    <textarea class="form-control form-control-sm r1" name="nm_stock[]" id="nm_stock-{{$j}}" rows="3">{{$det->NM_STOCK}} </textarea>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" name="ket[]" id="ket-{{$j}}" value="{{$det->KET}}">
                                                </td>
                                                <td>
                                                    <input type="hidden" name="base_qty[]" id="base_qty-{{$j}}" value="{{$det->QTY}}">
                                                    <input type="number" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="qty[]" onchange="itemTotal({{$j}})" id="qty-{{$j}}" value="{{$det->QTY}}" readonly>
                                                </td>
                                                <td>
                                                    <input type=" text" class="form-control form-control-sm" name="sat[]" id="sat-{{$j}}" value="{{$det->SAT}}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm numajaDesimal" style="display: none;" name="price[]" onchange="itemTotal({{$j}})" id="price-{{$j}}" value="{{number_format($det->HARGA,2)}}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm numajaDesimal" style="display: none;" name="disc[]" onchange="itemTotal({{$j}})" id="disc-{{$j}}" value="{{$det->DISC1}}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm numajaDesimal" style="display: none;" name="disc2[]" onchange="itemTotal({{$j}})" id="disc2-{{$j}}" value="{{$det->DISC2}}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm numajaDesimal" style="display: none;" name="disc_val[]" onchange="itemTotal({{$j}})" id="disc_val-{{$j}}" value="{{$det->DISCRP}}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm numajaDesimal" style="display: none;" name="total[]" id="total-{{$j}}" value="{{$det->JUMLAH}}">
                                                </td>
                                                <td>
                                                    <select class="form-control form-control-sm" name="tax[]" id="tax-{{$j}}" style="display: none;">
                                                        <option value="" selected></option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" name="state[]" id="state-{{$j}}" value="{{$state}}" readonly>
                                                </td>
                                                <td style="display: none;" id="itemTotal-{{$j}}"></td>
                                                <td style="display: none;" id="itemTax-{{$j}}"></td>
                                                <td style="display: none;" id="itemDisc-{{$j}}"></td>
                                                <td style="display: none;" id="itemTotalDiscHead-{{$j}}"></td>
                                                <td style="display: none;" id="itemBruto-{{$j}}"></td>
                                                <td style="display: none;" id="itemTaxValue-{{$j}}"></td>
                                                <td style="display: none;"><input type="hidden" name="itemKodeGroup[]" id="itemKodeGroup-{{$j}}" value="{{$det->kode_group}}"> </td>
                                                <td style="display: none;"><input type="hidden" name="itemVintrasId[]" id="itemVintrasId-{{$j}}" value="{{$det->VINTRASID}}"> </td>
                                                <td style="display: none;"><input type="hidden" name="itemTahunVintras[]" id="itemTahunVintras-{{$j}}" value="{{$det->tahun}}"> </td>
                                                <td style="display: none;"><input type="hidden" name="merkItem[]" id="merkItem-{{$j}}" value="{{$det->merk}}"> </td>

                                            </tr>
                                            @endif
                                            <?php $j++; ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <table width="100%">
                                        <tr>
                                            <td style="width: 100%;">
                                                <a href="javascript:void(0)" onclick="removeRow(this)" class="btn btn-xs btn-warning float-right" title="remove row"><i class="fa fa-minus"></i></a>
                                                <a href="javascript:void(0)" onclick="addRow(this)" class="btn btn-xs btn-info float-right" title="add row"><i class="fa fa-plus"></i></a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-3">
                                    <div class="form-group row">
                                        <label class="col-sm-4">Total DPP</label>
                                        <div class="col-sm-8">
                                            <input type="hidden" name="totalBruto" id="totalBruto">
                                            <input type="text" class="form-control form-control-sm form-control-border numajaDesimal" style="text-align: right;" name="totalDpp" id="totalDpp" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4">Total PPn</label>
                                        <div class="col-sm-8"><input type="text" class="form-control form-control-sm form-control-border numajaDesimal" style="text-align: right;" name="totalPpn" id="totalPpn" readonly></div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4">Total</label>
                                        <div class="col-sm-8"><input type="text" class="form-control form-control-sm form-control-border numajaDesimal" style="text-align: right;" name="grandTotal" id="grandTotal" readonly></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-md-12 row">
                                <div class="col-sm-6">
                                    Created By : {{($so->head[0]->CREATOR==''?"-":$so->head[0]->CREATOR). " | ". date_format(date_create($so->head[0]->create_date),'d-m-Y H:i:s')}}
                                    <br />
                                    Updated By : {{($so->head[0]->EDITOR==''?"-":$so->head[0]->EDITOR) . " | ". date_format(date_create($so->head[0]->edit_date),'d-m-Y H:i:s')}}
                                </div>
                                <div class="col-sm-6 float-right">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-info  float-right" id="edit" title="edit" onclick="btnEdit()"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="{{ url('salesOrderPrint/'.$so->head[0]->NO_BUKTI) }}" target="_blank" class="btn btn-sm btn-warning  float-right" id="printPage" title="print"><i class="fas fa-print"></i></a>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger  float-right" id="delete" title="delete" onclick="btnDelete()"><i class="fas fa-trash-alt"></i></a>

                                    <input type="hidden" name="process" value="save" id="process" required>
                                    <button type="button" class="btn btn-sm btn-warning float-right" id="printEdit" title="print" style="display: none;"><i class="fa fa-print"></i></button>
                                    <button type="button" class="btn btn-sm btn-info float-right" id="saveEdit" title="save" style="display: none;"><i class="fa fa-save"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
<!-- Modal -->
<div class="modal fade" id="modalBu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Bussiness Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <table class="table tbl_bu" style="width: 100%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th style="width: 15%" style="text-align: center;">Id</th>
                                <th style="width: 70%" style="text-align: center;">Description</th>
                                <th style="width: 10%" style="text-align: center;">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bu as $b)
                            <tr>
                                <td>
                                    {{$b->divisi}}
                                </td>
                                <td>
                                    {{$b->keterangan}}
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm ">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class=" modal-footer justify-content-between">
                <button type="submit" id="bu_save" class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" style="text-align:left;" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDept" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header bg-info">
                <h5 class="modal-title">Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <table class="table tbl_dept" style="width: 100%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th style="width: 15%" style="text-align: center;">Id</th>
                                <th style="width: 70%" style="text-align: center;">Description</th>
                                <th style="width: 10%" style="text-align: center;">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dept as $d)
                            <tr>
                                <td>
                                    {{$d->kode}}
                                </td>
                                <td>
                                    {{$d->keterangan}}
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm ">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class=" modal-footer justify-content-between">
                <button type="submit" id="dept_save" class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" style="text-align:left;" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalStateCancel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Inventory</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <table class="table" id="datatables" style="width: 100%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th style="width: 15%" style="text-align: center;">Id</th>
                                <th style="width: 70%" style="text-align: center;">Name</th>
                                <th style="width: 10%" style="text-align: center;">UoM</th>
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

@endsection
@push('other-modal')
@include('modalBox.modalInventory')
@endpush
@push('other-script')
<script>
    var rute = "{{ URL::to('salesOrder/data/populate') }}";
    var get_customer = "{{ URL::to('customerGetById') }}";
    var get_inventory = "{{ URL::to('inventory/data/populate') }}";
    var get_SoItemChild = "{{ URL::to('inventoryChildGetByHead') }}";
    var get_statusSo = "{{ URL::to('salesOrderStatus') }}";
    var get_customer = "{{ URL::to('customerGetById') }}";
    var get_vat = "{{ URL::to('vat/data/byDate') }}";
    var rute_addBranch = "{{ URL::to('customer/addBranch') }}";
    var rute_saveState = "{{ URL::to('salesOrder/state') }}";
    var rute_cekSo = "{{ URL::to('salesOrder/cekSo') }}";
    var void_url = "{{ URL::to('salesOrder/void') }}";
    var base_url = "{{ route('salesOrder') }}";
    var url_default = "{{ URL('') }}";
    var vat = <?= json_encode($vat); ?>;
    var sales = <?= json_encode($sales); ?>;
    var attach = <?= json_encode($so->attach); ?>;
</script>
<script src="{{ asset('js/transaction/salesOrder/salesOrder-add.js')}}"></script>
<script src="{{ asset('js/transaction/salesOrder/salesOrder-edit.js')}}"></script>

@endpush