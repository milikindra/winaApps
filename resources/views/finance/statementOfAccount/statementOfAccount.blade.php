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
<form action="{{ route('statementOfAccount/export') }}" method="POST" enctype="multipart/form-data" target="_blank">
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
                                        @if (hasAccess('FZ01.01'))
                                        <option value="appCustomerSOA">Customer SOA</option>
                                        @endif
                                        @if (hasAccess('FZ02.01'))
                                        <option value="appSupplierSOA">Supplier SOA</option>
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
                                <div class="col-12" id="filterEdate" style="display: none;margin-bottom:5px;">
                                    <label>End Date</label>
                                    <input type="date" class="form-control form-control-sm" id="edate" name="edate" value="{{date('Y-m-d')}}">
                                </div>
                                <div class="col-12" id="filterCustomer" style="display: none;margin-bottom:5px;">
                                    <label>Customers</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" name="customer" id="customer">
                                        <div class="input-group-append">
                                            <a href="javascript:void(0)" class="btn btn-info" id="customer_modal"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" id="filterSO" style="display: none;margin-bottom:5px;">
                                    <label>SO</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" name="so" id="so">
                                        <div class="input-group-append">
                                            <a href="javascript:void(0)" class="btn btn-info" id="so_modal"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" id="filterSales" style="display: none;margin-bottom:5px;">
                                    <label>Sales</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" name="sales" id="sales">
                                        <div class="input-group-append">
                                            <a href="javascript:void(0)" class="btn btn-info" id="sales_modal"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" id="filterOverdueCustomer" style="display: none;margin-bottom:5px;">
                                    <label>Overdue</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" name="overdueCustomer" id="overdueCustomer">
                                        <div class="input-group-append">
                                            <a href="javascript:void(0)" class="btn btn-info" id="overdueCustomer_modal"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" id="filterTotalCustomer" style="display: none;margin-bottom:5px;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="isTotalCustomer" value="Y" name="isTotal">
                                        <label class="form-check-label">Show Total Per Customer</label>
                                    </div>
                                </div>

                                <div class="col-12" id="filterSupplier" style="display: none;margin-bottom:5px;">
                                    <label>Supplier</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" name="supplier" id="supplier">
                                        <div class="input-group-append">
                                            <a href="javascript:void(0)" class="btn btn-info" id="supplier_modal"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" id="filterInventory" style="display: none;margin-bottom:5px;">
                                    <label>Inventory</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" name="inventory" id="inventory">
                                        <div class="input-group-append">
                                            <a href="javascript:void(0)" class="btn btn-info" id="inventory_modal"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" id="filterTag" style="display: none;margin-bottom:5px;">
                                    <label>Tag</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" name="tag" id="tag">
                                    </div>
                                </div>
                                <div class="col-12" id="filterOverdueSupplier" style="display: none;margin-bottom:5px;">
                                    <label>Overdue</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" name="overdueSupplier" id="overdueSupplier">
                                        <div class="input-group-append">
                                            <a href="javascript:void(0)" class="btn btn-info" id="overdueSupplier_modal"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" id="filterTotalSupplier" style="display: none;margin-bottom:5px;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="isTotalSupplier" value="Y" name="isTotal">
                                        <label>Show Total Per Supplier</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-info float-right" id="processFilter" onclick="dataReport()">Process</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-10" style="display: none;" id="appCustomerSOA">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="card-title">Customer Statement Of Account</h3>
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
                                <button type="submit" class="btn btn-sm btn-info" name="exportType" value="Print">Print</button>
                                <button type="submit" class="btn  btn-sm  btn-info" name="exportType" value="Excel">Excel</button>
                            </div>
                            <br />
                            <h4 style="font-family: helvetica,sans-serif;text-align: center;margin-top: 0px;margin-bottom: 5px;" id="titleCustomerSOA"></h4>
                            <div style="display: inline-none; clear: both; position: static; margin-bottom: 0px; width: 100%;">
                                <h5 style="font-family: helvetica,sans-serif;text-align: center;margin-top: 0px;margin-bottom: 5px;" id="subtitleCustomerSOA"></h5>
                            </div>
                            <div style="display: inline-none; clear: both; position: static; margin-bottom: 0px; width: 100%;">
                                <h6 style="font-family: helvetica,sans-serif;text-align: center;margin-top: 0px;margin-bottom: 5px;" id="filterCustomerSOA"></h6>
                            </div>
                            <br />
                            <table class="table tableCustomerSOA minpadding" id="tableCustomerSOA" style="width: 100%;cursor:pointer">
                                <thead>
                                    <tr style="text-align: center;">
                                        <th id="no-sort">Customer</th>
                                        <th>Invoice</th>
                                        <th>Invoice Date</th>
                                        <th>Due Date</th>
                                        <th>Est Date</th>
                                        <th>PO</th>
                                        <th>Total</th>
                                        <th>Sales</th>
                                        <th>Overdue > 100 days</th>
                                        <th>Overdue 1 - 30 days</th>
                                        <th>Overdue 31 - 60 days</th>
                                        <th>Overdue 61 - 100 days</th>
                                        <th>Not Due</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="100%" style="text-align:center">No data available in table </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer ">
                        </div>
                    </div>
                </div>

                <div class="col-lg-10" style="display: none;" id="appSupplierSOA">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="card-title">Supplier Statement Of Account</h3>
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
                                <button type="submit" class="btn btn-sm btn-info" name="exportType" value="Print">Print</button>
                                <button type="submit" class="btn  btn-sm  btn-info" name="exportType" value="Excel">Excel</button>
                            </div>
                            <br />
                            <h4 style="font-family: helvetica,sans-serif;text-align: center;margin-top: 0px;margin-bottom: 5px;" id="titleSupplierSOA"></h4>
                            <div style="display: inline-none; clear: both; position: static; margin-bottom: 0px; width: 100%;">
                                <h5 style="font-family: helvetica,sans-serif;text-align: center;margin-top: 0px;margin-bottom: 5px;" id="subtitleSupplierSOA"></h5>
                            </div>
                            <div style="display: inline-none; clear: both; position: static; margin-bottom: 0px; width: 100%;">
                                <h6 style="font-family: helvetica,sans-serif;text-align: center;margin-top: 0px;margin-bottom: 5px;" id="filterSupplierSOA"></h6>
                            </div>
                            <br />
                            <table class="table tableSupplierSOA minpadding" id="tableSupplierSOA" style="width: 100%;">
                                <thead>
                                    <tr style="text-align: center;">
                                        <th>Supplier</th>
                                        <th>PI</th>
                                        <th>PI Date</th>
                                        <th>Due Date</th>
                                        <th>Invoice</th>
                                        <th>Currency</th>
                                        <th>Total</th>
                                        <th>Payment Paid</th>
                                        <th>Age</th>
                                        <th>Overdue < 15 days</th>
                                        <th>Overdue 15 - 30 days</th>
                                        <th>Overdue 31 - 60 days</th>
                                        <th>Overdue > 60 days</th>
                                        <th>Due In 1 Week</th>
                                        <th>Due In 2 Weeks</th>
                                        <th>On Scheduled</th>
                                        <th>Total (IDR)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="100%" style="text-align:center">No data available in table </td>
                                    </tr>
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
<!-- customer -->
<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <table class="table tbl_customer" style="width: 100%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th style="width: 5%" style="text-align: center;"></th>
                                <th style="text-align: center;">Kode Customer</th>
                                <th style="width: 30%" style="text-align: center;">Customer</th>
                                <th style="width: 65%" style="text-align: center;">Address</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class=" modal-footer justify-content-between">
                <button type="button" class="btn btn-sm btn-default" style="text-align:left;" data-dismiss="modal">Close</button>
                <button type="submit" id="customer_save" class="btn btn-sm btn-info">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="soModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid table-responsive">
                    <table class="table tbl_so" style="width: 100%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th></th>
                                <th>Nomor</th>
                                <th>Tanggal</th>
                                <th>Kode Sales</th>
                                <th>Nama Sales</th>
                                <th>ID Customer</th>
                                <th>Customer</th>
                                <th>Tempo</th>
                                <th>Currency</th>
                                <th>Rate</th>
                                <th>PO Customer</th>
                                <th>Jenis</th>
                                <th>No Ref.</th>
                                <th>Bussiness Unit</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class=" modal-footer justify-content-between">
                <button type="button" class="btn btn-sm btn-default" style="text-align:left;" data-dismiss="modal">Close</button>
                <button type="submit" id="so_save" class="btn btn-sm btn-info">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="salesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Sales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid table-responsive">
                    <table class="table tbl_sales" style="width: 100%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th></th>
                                <th>Id Sales</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class=" modal-footer justify-content-between">
                <button type="button" class="btn btn-sm btn-default" style="text-align:left;" data-dismiss="modal">Close</button>
                <button type="submit" id="sales_save" class="btn btn-sm btn-info">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalOverdueCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Overdue</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <table class="table tbl_overdueCustomer" style="width: 100%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th style="width: 70%" style="text-align: center;" colspan="3">Overdue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center;"><input type="checkbox" value="Y"></td>
                                <td style="display: none;">overdue_100</td>
                                <td>Overdue > 100 days</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"><input type="checkbox" value="Y"></td>
                                <td style="display: none;">overdue_1_30</td>
                                <td>Overdue 1 - 30 days</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"><input type="checkbox" value="Y"></td>
                                <td style="display: none;">overdue_31_60</td>
                                <td>Overdue 31 - 60 days</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"><input type="checkbox" value="Y"></td>
                                <td style="display: none;">overdue_61_100</td>
                                <td>Overdue 61 - 100 days</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"><input type="checkbox" value="Y"></td>
                                <td style="display: none;">notdue</td>
                                <td>Not Due</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class=" modal-footer justify-content-between">
                <button type="button" class="btn btn-sm btn-default" style="text-align:left;" data-dismiss="modal">Close</button>
                <button type="submit" id="overdueCustomer_save" class="btn btn-sm btn-info">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="customerNotesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Internal Notes & Estimation Date</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-3">
                            <!-- checkbox -->
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Estimation Date</label>
                                        <input type="date" class="form-control form-control-sm" id="estDate" name="estDate">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-9">
                            <!-- checkbox -->
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Internal Notes</label>
                                        <textarea class="form-control form-control-sm r1" row="1" name="inNotes" id="inNotes"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" modal-footer justify-content-between">
                <button type="button" class="btn btn-sm btn-default" style="text-align:left;" data-dismiss="modal">Close</button>
                <button type="submit" id="overdueCustomer_save" class="btn btn-sm btn-info">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- supplier -->
<div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid table-responsive">
                    <table class="table tbl_supplier" style="width: 100%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th></th>
                                <th>Id Supplier</th>
                                <th>Supplier</th>
                                <th>Telp.</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class=" modal-footer justify-content-between">
                <button type="button" class="btn btn-sm btn-default" style="text-align:left;" data-dismiss="modal">Close</button>
                <button type="submit" id="supplier_save" class="btn btn-sm btn-info">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="inventoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid table-responsive">
                    <table class="table tbl_inventory" style="width: 100%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th></th>
                                <th>Id</th>
                                <th>Inventory</th>
                                <th>UOM</th>
                                <th>Qty</th>
                                <th>Booked</th>
                                <th>Order</th>
                                <th>Transit</th>
                                <th>Category</th>
                                <th>Subcategory</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class=" modal-footer justify-content-between">
                <button type="button" class="btn btn-sm btn-default" style="text-align:left;" data-dismiss="modal">Close</button>
                <button type="submit" id="inventory_save" class="btn btn-sm btn-info">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalOverdueSupplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Overdue</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <table class="table tbl_overdueSupplier" style="width: 100%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th style="width: 70%" style="text-align: center;" colspan="2">Overdue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center;"><input type="checkbox" value="Y"></td>
                                <td style="display: none;">overdue_1_14</td>
                                <td>Overdue < 15 days</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"><input type="checkbox" value="Y"></td>
                                <td style="display: none;">overdue_15_30</td>
                                <td>Overdue 15 - 30 days</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"><input type="checkbox" value="Y"></td>
                                <td style="display: none;">overdue_31_60</td>
                                <td>Overdue 31 - 60 days</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"><input type="checkbox" value="Y"></td>
                                <td style="display: none;">overdue_60</td>
                                <td>Overdue > 60 days</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"><input type="checkbox" value="Y"></td>
                                <td style="display: none;">in_1_weeks</td>
                                <td>Due In 1 Week</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"><input type="checkbox" value="Y"></td>
                                <td style="display: none;">in_2_weeks</td>
                                <td>Due In 1 Week</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"><input type="checkbox" value="Y"></td>
                                <td style="display: none;">on_schedule</td>
                                <td>On Scheduled</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class=" modal-footer justify-content-between">
                <button type="button" class="btn btn-sm btn-default" style="text-align:left;" data-dismiss="modal">Close</button>
                <button type="submit" id="overdueSupplier_save" class="btn btn-sm btn-info">Save</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('other-modal')
@include('modalBox.modalSalesOrder')
@endpush
@push('other-script')
<script>
    var rute_customer_soa = "{{ URL::to('statementOfAccount/data/populateCustomerSOA') }}";
    var rute_supplier_soa = "{{ URL::to('statementOfAccount/data/populateSupplierSOA') }}";
    var get_customer = "{{ URL::to('customer/data/populate') }}";
    var get_salesOrder = "{{ URL::to('salesOrder/data/populateHead') }}";
    var get_sales = "{{ URL::to('sales/data/populate') }}";
    var get_supplier = "{{ URL::to('supplier/data/populate') }}";
    var get_inventory = "{{ URL::to('inventory/data/populate') }}";
</script>
<script src="{{ asset('js/finance/statementOfAccount/statementOfAccount.js')}}"></script>
@endpush