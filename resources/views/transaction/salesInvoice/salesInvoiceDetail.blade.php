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
<form action="{{ route('salesInvoiceUpdate') }}" id="salesInvoiceUpdate" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="module" id="module" value="edit">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="card-title">Detail Sales Invoice | {{$si->head[0]->no_bukti2}}</h3>
                                    <div class="card-tools float-right">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
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
                                                <datalist id="customerList">
                                                </datalist>
                                                <label>Customer</label>
                                                <input type="hidden" name="si_id" id="si_id" value="{{$si->head[0]->NO_BUKTI}}" autocomplete="off" required>
                                                <input type="hidden" name="customer_name" id="customer_name" value="{{$si->head[0]->NM_CUST}}" autocomplete="off" required>
                                                <input type="hidden" name="customer" id="customer" value="{{$si->head[0]->ID_CUST}}" autocomplete="off" required>
                                                <input class="form-control form-control-sm form-control-border" list="customerList" id="customerSearch" value="{{$si->head[0]->ID_CUST.' ('. $si->head[0]->NM_CUST.')'}}" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>SO</label>
                                                <div class="input-group">
                                                    <input type="hidden" class="" id="cust_so" name="cust_so" value="{{$si->head[0]->ID_CUST}}">
                                                    <input type="text" class="form-control form-control-sm form-control-border" id="so_id" name="so_id" value="{{$si->head[0]->isUM != 'Y'?$si->head[0]->no_so:$si->head[0]->no_so_um}}" readonly>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-sm btn-info" id="btnSo" onclick="getSo()"><i class="fas fa-search"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Sales</label>
                                                <input type="hidden" id="sales_name" name="sales_name" value="{{$si->head[0]->NM_SALES}}">
                                                <select class="form-control form-control-sm  selects2" id="sales_id" name="sales_id" onchange="getSales()">
                                                    @foreach($sales as $s)
                                                    @if($s->ID_SALES == $si->head[0]->ID_SALES)
                                                    <option value="{{$s->ID_SALES}}" data-name="{{$s->NM_SALES}}" selected>{{$s->ID_SALES." (".$s->NM_SALES.")"}}</option>
                                                    @else
                                                    <option value="{{$s->ID_SALES}}" data-name="{{$s->NM_SALES}}">{{$s->ID_SALES." (".$s->NM_SALES.")"}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Due</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control form-control-sm form-control-border" name="tempo" id="tempo" value="{{$si->head[0]->TEMPO}}" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Days</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Pay.Term</label>
                                                <input type="text" class="form-control form-control-sm form-control-border" name="payterm" id="payterm" value="{{$si->head[0]->pay_term}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Currency</label>
                                                <input type="text" class="form-control form-control-sm form-control-border" name="curr" id="curr" value="{{$si->head[0]->curr}}" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Rate Rp.</label>
                                                <input type="text" class="form-control form-control-sm form-control-border" name="rate_cur" id="rate_cur" value="{{$si->head[0]->rate}}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Date</label>
                                                <input type="date" class="form-control form-control-sm form-control-border" name="date_order" id="date_order" value="{{$si->head[0]->TGL_BUKTI}}" required onchange="getTax()">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-check">
                                                    @if($si->head[0]->isUM=='Y')
                                                    <input type="checkbox" class="form-check-input" name="use_dp" id="use_dp" onclick="return false;" checked></input>
                                                    @else
                                                    <input type="checkbox" class="form-check-input" name="use_dp" id="use_dp" onclick="return false;"></input>
                                                    @endif
                                                    <label>Down Payment By SO</label>
                                                </div>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control form-control-sm form-control-border" name="do_soum" id="do_soum" value="{{$si->head[0]->isUM !='Y' ?  $si->detail[0]->no_sj : $si->detail[0]->NM_STOCK; }}" required readonly>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-info" id="modalByDp" disabled>
                                                            <i class="fa fa-search"></i> </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Account Receivable</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control form-control-sm form-control-border" name="acc_receivable" id="acc_receivable" value="{{$si->head[0]->no_rek}}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-check">
                                                    @if($si->head[0]->isWapu =="Y")
                                                    <input type="checkbox" class="form-check-input" name="cek_wapu" id="cek_wapu" onclick="return false;" checked></input>
                                                    <label>WAPU/KWB</label>
                                                    <h2 id="wapu" style="display: block; color: red; font-weight: bold;">
                                                        W.A.P.U
                                                    </h2>
                                                    @else
                                                    <input type="checkbox" class="form-check-input" name="cek_wapu" id="cek_wapu" onclick="return false;"></input>
                                                    <label>WAPU/KWB</label>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Tax Serial Number </label>
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="font-size: 11px;" id="tax_snFlabel">{{substr($si->head[0]->no_pajak,0,4)}}</span>
                                                        <input type="hidden" name="tax_snF" id="tax_snF" value="{{substr($si->head[0]->no_pajak,0,4)}}" required>
                                                    </div>
                                                    <datalist id="taxSnList">
                                                    </datalist>
                                                    <input class="form-control form-control-sm form-control-border" list="taxSnList" id="tax_snE" name="tax_snE" value="{{substr($si->head[0]->no_pajak,4)}}" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Invoice Address</label>
                                                <select class="form-control form-control-sm" id="cmbShipping" name="cmbShipping" style="display: block;">
                                                </select>
                                                <input type="hidden" name="cmbShipping" id="cmbShippingKey">
                                                <textarea class="form-control form-control-sm" name="ship_to" id="ship_to" rows="5" readonly>{{$si->head[0]->alamatkirim}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Received Id</label>
                                                    <input type="text" class="form-control form-control-sm form-control-border" name="received_id" id="received_id" value="{{$si->head[0]->no_tt}}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Received Date</label>
                                                    <input type="date" class="form-control form-control-sm form-control-border" name="received_date" id="received_date" value="{{$si->head[0]->tgl_tt}}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Received By</label>
                                                    <input type="text" class="form-control form-control-sm form-control-border" name="received_by" id="received_by" value="{{$si->head[0]->penerima_tt}}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Internal Notes</label>
                                                    <textarea class="form-control form-control-sm" name="notes" id="notes" rows="4">{{$si->head[0]->KETERANGAN}}</textarea>
                                                </div>
                                            </div>
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
                                                <div class="row col-md-12 attachDownload" id="attachDownload">
                                                    @foreach($si->attach as $attach)
                                                    <a target="_blank" href="{{URL::to('getFile/'.base64_encode($attach->path)) }}"><i class="fa fa-download"></i> {{$attach->value}}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="row col-md-12 attachUpload" id="attachUpload" style="display: none;">
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
                                        <table class="table table-modal scroly" id="trx" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%">Item</th>
                                                    <th style="width: 10%">Name</th>
                                                    <th style="width: 5%">Desc</th>
                                                    <th style="width: 2%">Qty</th>
                                                    <th style="width: 2%">UoM</th>
                                                    <th style="width: 2%">Price</th>
                                                    <th style="width: 2%">Disc % 1</th>
                                                    <th style="width: 2%">Disc % 2</th>
                                                    <th style="width: 2%">Disc</th>
                                                    <th style="width: 2%">Total</th>
                                                    <th style="width: 2%">Tax</th>
                                                    <th style="width: 2%">DO Number</th>
                                                    <th style="width: 2%">Warehouse</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $j = 0; ?>
                                                @foreach($si->detail as $det)
                                                <tr>
                                                    <td> <input type="text" class="form-control form-control-sm" name="no_stock[]" id="no_stock-{{$j}}" onclick="addData({{$j}})" value="{{$det->NO_STOCK}}" readonly> </td>
                                                    <td> <textarea class="form-control form-control-sm r1" name="nm_stock[]" id="nm_stock-{{$j}}" rows="3">{{$det->NM_STOCK}}</textarea> </td>
                                                    <td> <input type="text" class="form-control form-control-sm" name="ket[]" id="ket-{{$j}}" value="{{$det->KET}}"> </td>
                                                    <td><input type="hidden" name="base_qty[]" id="base_qty-{{$j}}" value="{{$det->QTY}}"> <input type="number" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="qty[]" value="{{number_format($det->QTY,2,'.',',')}}" autocomplete="off" id="qty-{{$j}}" onchange="itemTotal({{$j}})"> </td>
                                                    <td> <input type="text" class="form-control form-control-sm" name="sat[]" id="sat-{{$j}}" value="{{$det->SAT}}"> </td>
                                                    <td> <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="price[]" autocomplete="off" id="price-{{$j}}" onchange="itemTotal({{$j}})" value="{{number_format($det->HARGA,2)}}"> </td>
                                                    <td> <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="disc[]" autocomplete="off" id="disc-{{$j}}" onchange="itemTotal({{$j}})" value="{{number_format($det->DISC1,2)}}"> </td>
                                                    <td> <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="disc2[]" autocomplete="off" id="disc2-{{$j}}" onchange="itemTotal({{$j}})" value="{{number_format($det->DISC2,2)}}"> </td>
                                                    <td> <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="disc_val[]" autocomplete="off" id="disc_val-{{$j}}" onchange="itemTotal({{$j}})" value="{{number_format($det->DISCRP,2)}}"> </td>
                                                    <td> <input type="text" class="form-control form-control-sm numajaDesimal" style="text-align: right;" name="total[]" autocomplete="off" id="total-{{$j}}" value="{{number_format($det->JUMLAH,2)}}" readonly>
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
                                                    <td> <input type="text" class="form-control form-control-sm" name="sj[]" id="sj-{{$j}}" value="{{$det->no_sj}}" readonly> </td>
                                                    <td>
                                                        <select class="form form-control form-control-sm" name="warehouse[]" id="warehouse-{{$j}}">
                                                            @foreach($lokasi as $w)
                                                            @if($w->id_lokasi == $det->id_lokasi)
                                                            <option value="{{$w->id_lokasi}}" selected>{{$w->id_lokasi}}</option>
                                                            @else
                                                            <option value="{{$w->id_lokasi}}">{{$w->id_lokasi}}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td style="display:none" id="itemTotal-{{$j}}"></td>
                                                    <td style="display:none" id="itemTax-{{$j}}"> </td>
                                                    <td style="display:none" id="itemDisc-{{$j}}"> </td>
                                                    <td style="display:none" id="itemTotalDiscHead-{{$j}}"> </td>
                                                    <td style="display:none" id="itemBruto-{{$j}}"> </td>
                                                    <td style="display:none" id="itemTaxValue-{{$j}}"> </td>
                                                    <td style="display:none"> <input type="hidden" name="itemKodeGroup[]" id="itemKodeGroup-{{$j}}"> </td>
                                                    <td style="display:none"> <input type="hidden" name="itemVintrasId[]" id="itemVintrasId-{{$j}}"> </td>
                                                    <td style="display:none"> <input type="hidden" name="itemTahunVintras[]" id="itemTahunVintras-{{$j}}"> </td>
                                                    <td style="display:none"> <input type="hidden" name="merkItem[]" id="merkItem-{{$j}}"> </td>
                                                </tr>
                                                <?php $j++; ?>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 100%;">
                                                    <a href="javascript:void(0)" onclick="removeRow(this)" accesskey="r" class="btn btn-xs btn-warning float-right" title="remove row (alt+r)"><i class="fa fa-minus"></i></a>
                                                    <a href="javascript:void(0)" onclick="addRow(this)" accesskey="a" class="btn btn-xs btn-info float-right" title="add row (alt+a)"><i class="fa fa-plus"></i></a>
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
                                            <label class="col-sm-4">Total</label>
                                            <div class="col-sm-8">
                                                <input type="hidden" name="totalSo" id="totalSo" value="{{$si->so[0]->totdpp_rp}}" autocomplete="off">
                                                <input type="hidden" name="totalSoDp" id="totalSoDp" value="{{$si->so[0]->uangmuka}}" autocomplete="off">
                                                <input type="hidden" name="totalSiDp" id="totalSiDp" value="{{$si->um[0]->total}}" autocomplete=" off">
                                                <input type="hidden" name="totalPPnSiDp" id="totalPPnSiDp" value="{{$si->um[0]->ppn}}" autocomplete="off">
                                                <input type="hidden" name="totalBruto" id="totalBruto" autocomplete="off">
                                                <input type="text" class="form-control form-control-sm form-control-border numajaDesimal" style="text-align: right;" name="totalDpp" id="totalDpp" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4">Total DP</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm form-control-border numajaDesimal" style="text-align: right;" name="totalDp" id="totalDp" value="{{number_format($si->head[0]->uangmuka,2)}}" onchange="cekSiDp()">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4">Total PPn</label>
                                            <div class="col-sm-8"><input type="text" class="form-control form-control-sm form-control-border numajaDesimal" style="text-align: right;" name="totalPpn" id="totalPpn" readonly></div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="taxCustomer" id="taxCustomer">
                                            <input type="hidden" name="taxDp" id="taxDp">
                                            <input type="hidden" name="taxDetail" id="taxDetail">
                                            <input type="hidden" name="finalDp" id="finalDp">
                                            <label class="col-sm-4">Grand Total</label>
                                            <div class="col-sm-8"><input type="text" class="form-control form-control-sm form-control-border numajaDesimal" style="text-align: right;" name="grandTotal" id="grandTotal" readonly></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div id="det">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-info  float-right" id="edit" title="edit" onclick="btnEdit()"><i class="fas fa-pencil-alt"></i></a>
                                    <div class="btn-group float-right show" id="btnPrintDetail">
                                        <a href="javascript:void(0)" class="btn btn-sm btn-warning dropdown-toggle dropdown-icon" id="printDetail" title="print" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-print"></i>
                                        </a>
                                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-97px, 38px, 0px);">
                                            <a href="{{ URL::to('salesInvoicePrint/f1/'.base64_encode($si->head[0]->NO_BUKTI)) }}" target="_blank" class="dropdown-item" id="f1Detail" title="Format-1">Format-1</a>
                                            <a href="{{ URL::to('salesInvoicePrint/f2/'.base64_encode($si->head[0]->NO_BUKTI)) }}" target="_blank" class="dropdown-item" id="f2Detail" title="Format-2">Format-2</a>
                                            <a href="{{ URL::to('salesInvoicePrint/f3/'.base64_encode($si->head[0]->NO_BUKTI)) }}" target="_blank" class="dropdown-item" id="f3Detail" title="Format-3">Format-3</a>
                                        </div>
                                    </div>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger  float-right" id="delete" title="delete" onclick="btnDelete()"><i class="fas fa-trash-alt"></i></a>
                                </div>

                                <div id="edit">
                                    <input type="hidden" name="process" value="save" id="process" required>
                                    <div class="btn-group float-right show" style="display: none;" id="btnPrintDetail">
                                        <button type="button" class="btn btn-sm btn-warning dropdown-toggle dropdown-icon" id="printUpdate" title="print" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-print"></i>
                                        </button>
                                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-97px, 38px, 0px);">
                                            <button type="button" class="dropdown-item" id="f1Update" title="Format-1">Format-1</i>
                                            </button>
                                            <button type="button" class="dropdown-item" id="f2Update" title="Format-2">Format-2</i>
                                            </button>
                                            <button type="button" class="dropdown-item" id="f3Update" title="Format3">Format-3</i>
                                            </button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-info float-right" id="update" title="save" style="display: none;"><i class="fa fa-save"></i></button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</form>
<!-- Modal -->
<div class="modal fade" id="modalDo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Outstanding Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid table-responsive">
                    <table class="table tabelOutstandingOrder tbl-sm sroly " id="tabelOutstandingOrder" style="width: 100%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th>DO</th>
                                <th>Date</th>
                                <th>ID Customer</th>
                                <th>Customer</th>
                                <th>Ship To</th>
                                <th>Location</th>
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

<div class="modal fade" id="modalSoDp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Outstanding Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid table-responsive">
                    <table class="table tabelOutstandingOrderDp tbl-sm sroly " id="tabelOutstandingOrderDp" style="width: 100%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th>Description</th>
                                <th>Value</th>
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

<!-- end Modal -->
@endsection
@push('other-modal')
@include('modalBox.modalInventory')
@include('modalBox.modalSalesOrder')
@endpush
@push('other-script')
<script>
    var get_customer = "{{ URL::to('customerGetById') }}";
    var base_url = "{{ route('salesInvoice') }}";
    var url_default = "{{ URL('') }}";
    var rute_addBranch = "{{ URL::to('customer/addBranch') }}";
    var rute_do = "{{ URL::to('salesInvoice/data/do') }}";
    var get_do = "{{ URL::to('salesInvoice/get/do') }}";
    var rute_sodp = "{{ URL::to('salesInvoice/data/sodp') }}";
    var get_sodp = "{{ URL::to('salesInvoice/get/sodp') }}";
    var get_vat = "{{ URL::to('vat/data/byDate') }}";
    var get_efaktur = "{{ URL::to('efaktur/get/byDate')}}";
    var vat = <?= json_encode($vat); ?>;
    var sales = <?= json_encode($sales); ?>;
    var lokasi = <?= json_encode($lokasi); ?>;
    var attach = <?= json_encode($si->attach); ?>;
</script>
<script src="{{ asset('js/custom/salesOrder.js')}}"></script>
<script src="{{ asset('js/transaction/salesInvoice/salesInvoice-add.js?')}}"></script>
<script src="{{ asset('js/transaction/salesInvoice/salesInvoice-edit.js?')}}"></script>
@endpush